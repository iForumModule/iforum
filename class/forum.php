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
 
if (!defined("ICMS_ROOT_PATH"))
{
	exit();
}
 
defined("IFORUM_FUNCTIONS_INI") || include ICMS_ROOT_PATH.'/modules/'.basename(dirname(__DIR__) ).'/include/functions.ini.php';
iforum_load_object();
 
class Forum extends icms_ipf_Object {

    public function __construct(&$handler) {
        global $icmsConfig, $icmsConfigMultilang;
        parent::__construct($handler);

		//$this->ArtObject("bb_forums");
		$this->quickInitVar('forum_id', XOBJ_DTYPE_INT);
		$this->quickInitVar('forum_name', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('forum_desc', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('forum_moderator', XOBJ_DTYPE_ARRAY, serialize(array()));
		$this->quickInitVar('forum_topics', XOBJ_DTYPE_INT);
		$this->quickInitVar('forum_posts', XOBJ_DTYPE_INT);
		$this->quickInitVar('forum_last_post_id', XOBJ_DTYPE_INT);
		$this->quickInitVar('cat_id', XOBJ_DTYPE_INT);
		$this->quickInitVar('forum_type', XOBJ_DTYPE_INT, 0); // 0 - active; 1 - inactive
		$this->quickInitVar('parent_forum', XOBJ_DTYPE_INT);
		$this->quickInitVar('allow_html', XOBJ_DTYPE_INT, 0); // To be added in 3.01: 0 - disabled; 1 - enabled; 2 - checked by default
		$this->quickInitVar('allow_sig', XOBJ_DTYPE_INT, 1);
		$this->quickInitVar('allow_subject_prefix', XOBJ_DTYPE_INT, 1);
		$this->quickInitVar('hot_threshold', XOBJ_DTYPE_INT, 20);
		$this->quickInitVar('allow_polls', XOBJ_DTYPE_INT, 0);
		//$this->quickInitVar('allow_attachments', XOBJ_DTYPE_INT);
		$this->quickInitVar('attach_maxkb', XOBJ_DTYPE_INT, 100);
		$this->quickInitVar('attach_ext', XOBJ_DTYPE_TXTAREA, "zip|jpg|gif");
		$this->quickInitVar('forum_order', XOBJ_DTYPE_INT, 99);
		/*
		* For desc
		*
		*/
		$this->quickInitVar("dohtml", XOBJ_DTYPE_INT, 1);
		$this->quickInitVar("dosmiley", XOBJ_DTYPE_INT, 1);
		$this->quickInitVar("doxcode", XOBJ_DTYPE_INT, 1);
		$this->quickInitVar("doimage", XOBJ_DTYPE_INT, 1);
		$this->quickInitVar("dobr", XOBJ_DTYPE_INT, 1);
	}
	 
	// Get moderators in uname or in uid
	function &getModerators($asUname = false)
	{
		static $_cachedModerators = array();
		 
		$moderators = array_filter($this->getVar('forum_moderator'));
		if (!$asUname) return $moderators;
		 
		$moderators_return = array();
		$moderators_new = array();
		foreach($moderators as $id)
		{
			if ($id == 0) continue;
			if (isset($_cachedModerators[$id])) $moderators_return[$id] = &$_cachedModerators[$id];
			else $moderators_new[] = $id;
		}
		if (count($moderators_new) > 0)
		{
			include_once ICMS_ROOT_PATH.'/modules/'.basename(dirname(dirname(__FILE__ ) ) ).'/include/functions.php';
			$moderators_new = iforum_getUnameFromIds($moderators_new);
			foreach($moderators_new as $id => $name)
			{
				$_cachedModerators[$id] = $name;
				$moderators_return[$id] = $name;
			}
		}
		return $moderators_return;
	}
	 
	// deprecated
	function isSubForum()
	{
		return ($this->getVar('parent_forum') > 0);
	}
	 
	function disp_forumModerators($valid_moderators = 0)
	{
		global $myts;
		 
		$ret = "";
		if ($valid_moderators === 0)
		{
			$valid_moderators = $this->getModerators();
		}
		if (empty($valid_moderators) || !is_array($valid_moderators))
		{
			return $ret;
		}
		include_once ICMS_ROOT_PATH.'/modules/'.basename(dirname(dirname(__FILE__ ) ) ).'/include/functions.php';
		$moderators = iforum_getUnameFromIds($valid_moderators, !empty(icms::$module->config['show_realname']), true);
		$ret = implode(", ", $moderators);
		return $ret;
	}
}
