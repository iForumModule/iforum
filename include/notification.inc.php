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
 
if (!defined('ICMS_ROOT_PATH'))
{
	exit();
}
require_once(ICMS_ROOT_PATH.'/modules/'.basename(dirname(dirname(__FILE__ ) ) ).'/include/functions.php');
if (!defined('IFORUM_NOTIFY_ITEMINFO') )
{
	define('IFORUM_NOTIFY_ITEMINFO', 1);
	 
	function iforum_notify_iteminfo($category, $item_id)
	{
		$module_handler = icms::handler('icms_module');
		$module = $module_handler->getByDirname(basename(dirname(dirname(__FILE__ ) ) ));
		 
		if ($category == 'global')
		{
			$item['name'] = '';
			$item['url'] = '';
			return $item;
		}
		$item_id = intval($item_id);
		 
		if ($category == 'forum')
		{
			// Assume we have a valid forum id
			$sql = 'SELECT forum_name FROM ' . icms::$xoopsDB->prefix('bb_forums') . ' WHERE forum_id = '.$item_id;
			if (!$result = icms::$xoopsDB->query($sql))
				{
				redirect_header("index.php", 2, _MD_ERRORFORUM);
				exit();
			}
			$result_array = icms::$xoopsDB->fetchArray($result);
			$item['name'] = $result_array['forum_name'];
			$item['url'] = ICMS_URL . '/modules/' . $module->getVar('dirname') . '/viewforum.php?forum=' . $item_id;
			return $item;
		}
		 
		if ($category == 'thread')
		{
			// Assume we have a valid topid id
			$sql = 'SELECT t.topic_title,f.forum_id,f.forum_name FROM '.icms::$xoopsDB->prefix('bb_topics') . ' t, ' . icms::$xoopsDB->prefix('bb_forums') . ' f WHERE t.forum_id = f.forum_id AND t.topic_id = '. $item_id . ' limit 1';
			if (!$result = icms::$xoopsDB->query($sql))
				{
				redirect_header("index.php", 2, _MD_ERROROCCURED);
				exit();
			}
			$result_array = icms::$xoopsDB->fetchArray($result);
			$item['name'] = $result_array['topic_title'];
			$item['url'] = ICMS_URL . '/modules/' . $module->getVar('dirname') . '/viewtopic.php?forum=' . $result_array['forum_id'] . '&topic_id=' . $item_id;
			return $item;
		}
		 
		if ($category == 'post')
		{
			// Assume we have a valid post id
			$sql = 'SELECT subject,topic_id,forum_id FROM ' . icms::$xoopsDB->prefix('bb_posts') . ' WHERE post_id = ' . $item_id . ' LIMIT 1';
			if (!$result = icms::$xoopsDB->query($sql))
				{
				redirect_header("index.php", 2, _MD_ERROROCCURED);
				exit();
			}
			$result_array = icms::$xoopsDB->fetchArray($result);
			$item['name'] = $result_array['subject'];
			$item['url'] = ICMS_URL . '/modules/' . $module->getVar('dirname') . '/viewtopic.php?forum= ' . $result_array['forum_id'] . '&amp;topic_id=' . $result_array['topic_id'] . '#forumpost' . $item_id;
			return $item;
		}
	}
}