<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright  http://www.xoops.org/ The XOOPS Project
* @copyright  http://xoopsforge.com The XOOPS FORGE Project
* @copyright  http://xoops.org.cn The XOOPS CHINESE Project
* @copyright  XOOPS_copyrights.txt
* @copyright  readme.txt
* @copyright  http://www.impresscms.org/ The ImpressCMS Project
* @license   GNU General Public License (GPL)
*     a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package  CBB - XOOPS Community Bulletin Board
* @since   3.08
* @author  phppp
* ----------------------------------------------------------------------------------------------------------
*     iForum - a bulletin Board (Forum) for ImpressCMS
* @since   1.00
* @author  modified by stranger
* @version  $Id$
*/
 
include_once __DIR__ .'/read.php';
 
/**
* A handler for read/unread handling
*
* @package     iforum/cbb
*
* @author     D.J. (phppp, http://xoopsforge.com)
* @copyright copyright (c) 2005 XOOPS.org
*/
 
class Readtopic extends Read {
	function __construct()
	{
        parent::__construct("topic");
		//$this->initVar('forum_id', XOBJ_DTYPE_INT);
	}
}
 
class IforumReadtopicHandler extends IforumReadHandler {
	/**
	* maximum records per forum for one user.
	* assigned from icms::$module->config["read_items"]
	*
	* @var integer
	*/
	var $items_per_forum;
	 
	function __construct(&$db)
	{
        parent::__construct($db, "topic");
		$iforumConfig = iforum_load_config();
		$this->items_per_forum = isset($iforumConfig["read_items"])?intval($iforumConfig["read_items"]):
		100;
	}
	 
	/**
	* clean orphan items from database
	*
	* @return  bool true on success
	*/
	function cleanOrphan()
	{
		parent::cleanOrphan($this->db->prefix("bb_posts"), "post_id");
		return parent::cleanOrphan($this->db->prefix("bb_topics"), "topic_id", "read_item");
	}
	 
	/**
	* Clear garbage
	*
	* Delete all expired and duplicated records
	*/
	function clearGarbage()
	{
		parent::clearGarbage();
		 
		// TODO: clearItemsExceedMaximumItemsPerForum
		return true;
	}
	 
	function setRead_items($status = 0, $forum_id = 0, $uid = null)
	{
		if (empty($this->mode)) return true;
		 
		if ($this->mode == 1) return $this->setRead_items_cookie($status, $forum_id);
		else return $this->setRead_items_db($status, $forum_id, $uid);
	}
	 
	function setRead_items_cookie($status, $forum_id)
	{
		$cookie_name = "LT";
		$cookie_vars = iforum_getcookie($cookie_name, true);
		 
		$item_handler = icms_getmodulehandler('topic', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("forum_id", $forum_id));
		$criteria->setSort("topic_last_post_id");
		$criteria->setOrder("DESC");
		$criteria->setLimit($this->items_per_forum);
		$items = $item_handler->getIds($criteria);
		 
		foreach($items as $var)
		{
			if (empty($status))
			{
				if (isset($cookie_vars[$var])) unset($cookie_vars[$var]);
			}
			else
			{
				$cookie_vars[$var] = time() /*$items[$var]*/;
			}
		}
		iforum_setcookie($cookie_name, $cookie_vars);
		return true;
	}
	 
	function setRead_items_db($status, $forum_id, $uid)
	{
		if (empty($uid))
		{
			if (is_object($GLOBALS["xoopsUser"]))
			{
				$uid = $GLOBALS["xoopsUser"]->getVar("uid");
			}
			else
			{
				return false;
			}
		}
		 
		$item_handler = icms_getmodulehandler('topic', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
		$criteria_topic = new icms_db_criteria_Compo(new icms_db_criteria_Item("forum_id", $forum_id));
		$criteria_topic->setSort("topic_last_post_id");
		$criteria_topic->setOrder("DESC");
		$criteria_topic->setLimit($this->items_per_forum);
		$criteria_sticky = new icms_db_criteria_Compo(new icms_db_criteria_Item("forum_id", $forum_id));
		$criteria_sticky->add(new icms_db_criteria_Item("topic_sticky", 1));
		 
		if (empty($status))
		{
			$items_id = $item_handler->getIds($criteria_topic);
			$sticky_id = $item_handler->getIds($criteria_sticky);
			$items = $items_id+$sticky_id;
			$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("uid", $uid));
			$criteria->add(new icms_db_criteria_Item("read_item", "(".implode(", ", $items).")", "IN"));
			$this->deleteAll($criteria, true);
			return true;
		}
		 
		$items_obj = $item_handler->getAll($criteria_topic, array("topic_last_post_id"));
		$sticky_obj = $item_handler->getAll($criteria_sticky, array("topic_last_post_id"));
		$items_obj = $items_obj + $sticky_obj;
		$items = array();
		foreach(array_keys($items_obj) as $key)
		{
			$items[$key] = $items_obj[$key]->getVar("topic_last_post_id");
		}
		unset($items_obj, $sticky_obj);
		foreach(array_keys($items) as $key)
		{
			$this->setRead_db($key, $items[$key], $uid);
		}
		return true;
	}
}