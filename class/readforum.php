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
 
include_once dirname(__FILE__).'/read.php';
 
/**
* A handler for read/unread handling
*
* @package     iforum/cbb
*
* @author     D.J. (phppp, http://xoopsforge.com)
* @copyright copyright (c) 2005 XOOPS.org
*/
 
class Readforum extends Read {
	function __construct()
	{
        parent::__construct("forum");
	}
}
 
class IforumReadforumHandler extends IforumReadHandler {
	function __construct(&$db)
	{
        parent::__construct($db, "forum");
	}
	 
	/**
	* clean orphan items from database
	*
	* @return  bool true on success
	*/
	function cleanOrphan()
	{
		parent::cleanOrphan($this->db->prefix("bb_posts"), "post_id");
		return parent::cleanOrphan($this->db->prefix("bb_forums"), "forum_id", "read_item");
	}
	 
	function setRead_items($status = 0, $uid = null)
	{
		if (empty($this->mode)) return true;
		 
		if ($this->mode == 1) return $this->setRead_items_cookie($status);
		else return $this->setRead_items_db($status, $uid);
	}
	 
	function setRead_items_cookie($status, $items)
	{
		$cookie_name = "LF";
		$items = array();
		if (!empty($status)):
		$item_handler = icms_getmodulehandler('forum', basename(dirname(__DIR__) ), 'iforum' );
		$items_id = $item_handler->getIds();
		foreach($items_id as $key)
		{
			$items[$key] = time();
		}
		endif;
		iforum_setcookie($cookie_name, $items);
		return true;
	}
	 
	function setRead_items_db($status, $uid)
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
		if (empty($status))
		{
			$this->deleteAll(new icms_db_criteria_Item("uid", $uid));
			return true;
		}
		 
		$item_handler = icms_getmodulehandler('forum', basename(dirname(__DIR__) ), 'iforum' );
		$items_obj = $item_handler->getAll(null, array("forum_last_post_id"));
		foreach(array_keys($items_obj) as $key)
		{
			$this->setRead_db($key, $items_obj[$key]->getVar("forum_last_post_id"), $uid);
		}
		unset($items_obj);
		 
		return true;
	}
}