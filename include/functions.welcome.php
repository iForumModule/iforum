<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		http://xoopsforge.com The XOOPS FORGE Project
* @copyright		http://xoops.org.cn The XOOPS CHINESE Project
* @copyright		XOOPS_copyrights.txt
* @copyright		readme.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license			GNU General Public License (GPL)
*					a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		CBB - XOOPS Community Bulletin Board
* @since			3.08
* @author		phppp
* ----------------------------------------------------------------------------------------------------------
* 				iForum - a bulletin Board (Forum) for ImpressCMS
* @since			1.00
* @author		modified by stranger
* @version		$Id$
*/

if(!defined("NEWBB_FUNCTIONS_WELCOME")):
define("NEWBB_FUNCTIONS_WELCOME", true);

function iforum_welcome_create( &$user, $forum_id )
{
	global $xoopsModule, $xoopsModuleConfig, $myts;

	if(!is_object($user)){
		return false;
	}
	
	$post_handler =& icms_getmodulehandler('post', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
	$forumpost =& $post_handler->create();
    $forumpost->setVar('poster_ip', iforum_getIP());
    $forumpost->setVar('uid', $user->getVar("uid"));
	$forumpost->setVar('approved', 1);
    $forumpost->setVar('forum_id', $forum_id);

    $subject = sprintf(_MD_WELCOME_SUBJECT, $user->getVar('uname'));
    $forumpost->setVar('subject', $subject);
    $forumpost->setVar('dohtml', 1);
    $forumpost->setVar('dosmiley', 1);
    $forumpost->setVar('doxcode', 0);
    $forumpost->setVar('dobr', 1);
    $forumpost->setVar('icon', "");
    $forumpost->setVar('attachsig', 1);
    $forumpost->setVar('post_time', time());

	$categories = array();
	
	$module_handler =& xoops_gethandler('module');
	if($mod = @$module_handler->getByDirname('profile', true)):
	$gperm_handler = & xoops_gethandler( 'groupperm' );
	$groups = array(XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_USERS);
	
	if(!defined("_PROFILE_MA_ALLABOUT")) {
		$mod->loadLanguage();
	}
	$groupperm_handler =& icms_getmodulehandler('permission', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
	$show_ids = $groupperm_handler->getItemIds('profile_show', $groups, $mod->getVar('mid'));
	$visible_ids = $groupperm_handler->getItemIds('profile_visible', $groups, $mod->getVar('mid'));
	unset($mod);
	$fieldids = array_intersect($show_ids, $visible_ids);
	$profile_handler =& xoops_gethandler('profile');
	$fields = $profile_handler->loadFields();
	$cat_handler =& icms_getmodulehandler('category', 'profile');
	$categories = $cat_handler->getObjects(null, true, false);
	$fieldcat_handler =& icms_getmodulehandler('fieldcategory', 'profile');
	$fieldcats = $fieldcat_handler->getObjects(null, true, false);
	
	// Add core fields
	$categories[0]['cat_title'] = sprintf(_PROFILE_MA_ALLABOUT, $user->getVar('uname'));
	$avatar = trim($user->getVar('user_avatar'));
	if(!empty($avatar) && $avatar !="blank.gif"){
		$categories[0]['fields'][] = array('title' => _PROFILE_MA_AVATAR, 'value' => "<img src='".XOOPS_UPLOAD_URL."/".$user->getVar('user_avatar')."' alt='".$user->getVar('uname')."' />");
		$weights[0][] = 0;
	}
	if ($user->getVar('user_viewemail') == 1) {
	    $email = $user->getVar('email', 'E');
	    $categories[0]['fields'][] = array('title' => _PROFILE_MA_EMAIL, 'value' => $email);
	    $weights[0][] = 0;
	}
	
	// Add dynamic fields
	foreach (array_keys($fields) as $i) {
	    if (in_array($fields[$i]->getVar('fieldid'), $fieldids)) {
	        $catid = isset($fieldcats[$fields[$i]->getVar('fieldid')]) ? $fieldcats[$fields[$i]->getVar('fieldid')]['catid'] : 0;
	        $value = $fields[$i]->getOutputValue($user);
	        if (is_array($value)) {
	            $value = implode('<br />', array_values($value));
	        }
	        
	        if(empty($value)) continue;
	        $categories[$catid]['fields'][] = array('title' => $fields[$i]->getVar('field_title'), 'value' => $value);
	        $weights[$catid][] = isset($fieldcats[$fields[$i]->getVar('fieldid')]) ? intval($fieldcats[$fields[$i]->getVar('fieldid')]['field_weight']) : 1;
	    }
	}
	
	foreach (array_keys($categories) as $i) {
	    if (isset($categories[$i]['fields'])) {
	        array_multisort($weights[$i], SORT_ASC, array_keys($categories[$i]['fields']), SORT_ASC, $categories[$i]['fields']);
	    }
	}
	ksort($categories);
    endif;
    
	$message = sprintf(_MD_WELCOME_MESSAGE, $user->getVar('uname'))."\n\n";
	$message .= _PROFILE.": <a href='".ICMS_URL . "/userinfo.php?uid=" . $user->getVar('uid')."'><strong>".$user->getVar('uname')."</strong></a> ";
	$message .= " | <a href='".ICMS_URL . "/pmlite.php?send2=1&amp;to_userid=" . $user->getVar('uid')."'>"._MD_PM."</a>\n";
	foreach($categories as $category){
		if(isset($category["fields"])){
			$message .= "\n\n".$category["cat_title"].":\n\n";
			foreach($category["fields"] as $field){
				if(empty($field["value"])) continue;
				$message .=$field["title"].": ".$field["value"]."\n";
			}
		}
	}
    $forumpost->setVar('post_text', $message);
    $postid = $post_handler->insert($forumpost);

    if(!empty($xoopsModuleConfig['notification_enabled'])){
	    $tags = array();
	    $tags['THREAD_NAME'] = $subject;
	    $tags['THREAD_URL'] = ICMS_URL . '/modules/' . $xoopsModule->getVar("dirname") . '/viewtopic.php?post_id='.$postid.'&amp;topic_id=' . $forumpost->getVar('topic_id').'&amp;forum=' . $forum_id;
	    $tags['POST_URL'] = $tags['THREAD_URL'] . '#forumpost' . $postid;
	    include_once 'include/notification.inc.php';
	    $forum_info = iforum_notify_iteminfo ('forum', $forum_id);
	    $tags['FORUM_NAME'] = $forum_info['name'];
	    $tags['FORUM_URL'] = $forum_info['url'];
	    $notification_handler =& xoops_gethandler('notification');
        $notification_handler->triggerEvent('forum', $forum_id, 'new_thread', $tags);
        $notification_handler->triggerEvent('global', 0, 'new_post', $tags);
        $notification_handler->triggerEvent('forum', $forum_id, 'new_post', $tags);
        $tags['POST_CONTENT'] = $myts->stripSlashesGPC($message);
        $tags['POST_NAME'] = $myts->stripSlashesGPC($subject);
        $notification_handler->triggerEvent('global', 0, 'new_fullpost', $tags);
    }

    return $postid;
}

endif;
?>