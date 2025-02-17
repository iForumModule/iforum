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
 
if (!defined("IFORUM_FUNCTIONS_WELCOME")):
define("IFORUM_FUNCTIONS_WELCOME", true);
 
function iforum_welcome_create(&$user, $forum_id ) {
	if (!is_object($user)) return false;
	 
	$subject = sprintf(_MD_WELCOME_SUBJECT, $user->getVar('uname'));
	$post_handler = icms_getmodulehandler('post', basename(dirname(__FILE__, 2)), 'iforum' );
	$forumpost = $post_handler->create();
	$forumpost->setVar('poster_ip', iforum_getIP());
	$forumpost->setVar('uid', $user->getVar("uid"));
	$forumpost->setVar('approved', 1);
	$forumpost->setVar('forum_id', $forum_id);
	$forumpost->setVar('subject', $subject);
	$forumpost->setVar('dohtml', 1);
	$forumpost->setVar('dosmiley', 1);
	$forumpost->setVar('doxcode', 0);
	$forumpost->setVar('dobr', 1);
	$forumpost->setVar('icon', "");
	$forumpost->setVar('attachsig', 1);
	$forumpost->setVar('post_time', time());

	// no profile integration for security reasons. It would display email address and double information
	/* $profile_module = icms::handler('icms_module')->getByDirname('profile', TRUE);
	if (is_object($profile_module)) {
		$field_handler = icms_getModuleHandler('field', $profile_module->getVar("dirname"), 'profile');
		$fields = $field_handler->getProfileFields($user);
	} */
	 
	$message = sprintf(_MD_WELCOME_MESSAGE, $user->getVar('uname'))."\n";
	foreach ($fields as $category) {
		if (isset($category["fields"])) {
			$message .= "\n".$category["title"].":\n";
			foreach ($category["fields"] as $field) {
				if (empty($field["value"])) continue;
				$message .= $field["title"].": ".$field["value"]."\n";
			}
		}
	}
	$forumpost->setVar('post_text', $message);
	$postid = $post_handler->insert($forumpost);
	 
	if (!empty(icms::$module->config['notification_enabled'])) {
		$tags = array();
		$tags['THREAD_NAME'] = $subject;
		$tags['THREAD_URL'] = ICMS_URL . '/modules/' . icms::$module->getVar("dirname") . '/viewtopic.php?post_id='.$postid.'&amp;topic_id=' . $forumpost->getVar('topic_id').'&amp;forum=' . $forum_id;
		$tags['POST_URL'] = $tags['THREAD_URL'] . '#forumpost' . $postid;
		include_once 'include/notification.inc.php';
		$forum_info = iforum_notify_iteminfo ('forum', $forum_id);
		$tags['FORUM_NAME'] = $forum_info['name'];
		$tags['FORUM_URL'] = $forum_info['url'];
		$notification_handler = icms::handler('icms_data_notification');
		$notification_handler->triggerEvent('forum', $forum_id, 'new_thread', $tags);
		$notification_handler->triggerEvent('global', 0, 'new_post', $tags);
		$notification_handler->triggerEvent('forum', $forum_id, 'new_post', $tags);
		$tags['POST_CONTENT'] = icms_core_DataFilter::stripSlashesGPC($message);
		$tags['POST_NAME'] = icms_core_DataFilter::stripSlashesGPC($subject);
		$notification_handler->triggerEvent('global', 0, 'new_fullpost', $tags);
	}
	 
	return $postid;
}
endif;
