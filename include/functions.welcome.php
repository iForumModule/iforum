<?php
// $Id: functions.php,v 1.3 2005/10/19 17:20:33 phppp Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
//  Author: phppp (D.J., infomax@gmail.com)                                  //
//  URL: http://xoopsforge.com, http://xoops.org.cn                          //
//  Project: Article Project                                                 //
//  ------------------------------------------------------------------------ //

if(!defined("NEWBB_FUNCTIONS_WELCOME")):
define("NEWBB_FUNCTIONS_WELCOME", true);

function newbb_welcome_create( &$user, $forum_id )
{
	global $xoopsModule, $xoopsModuleConfig, $myts;

	if(!is_object($user)){
		return false;
	}
	
	$post_handler =& xoops_getmodulehandler('post', basename(  dirname(  dirname( __FILE__ ) ) ));
	$forumpost =& $post_handler->create();
    $forumpost->setVar('poster_ip', newbb_getIP());
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
	$groupperm_handler =& xoops_getmodulehandler('permission', basename(  dirname(  dirname( __FILE__ ) ) ));
	$show_ids = $groupperm_handler->getItemIds('profile_show', $groups, $mod->getVar('mid'));
	$visible_ids = $groupperm_handler->getItemIds('profile_visible', $groups, $mod->getVar('mid'));
	unset($mod);
	$fieldids = array_intersect($show_ids, $visible_ids);
	$profile_handler =& xoops_gethandler('profile');
	$fields = $profile_handler->loadFields();
	$cat_handler =& xoops_getmodulehandler('category', 'profile');
	$categories = $cat_handler->getObjects(null, true, false);
	$fieldcat_handler =& xoops_getmodulehandler('fieldcategory', 'profile');
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
	$message .= _PROFILE.": <a href='".XOOPS_URL . "/userinfo.php?uid=" . $user->getVar('uid')."'><strong>".$user->getVar('uname')."</strong></a> ";
	$message .= " | <a href='".XOOPS_URL . "/pmlite.php?send2=1&amp;to_userid=" . $user->getVar('uid')."'>"._MD_PM."</a>\n";
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
	    $tags['THREAD_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar("dirname") . '/viewtopic.php?post_id='.$postid.'&amp;topic_id=' . $forumpost->getVar('topic_id').'&amp;forum=' . $forum_id;
	    $tags['POST_URL'] = $tags['THREAD_URL'] . '#forumpost' . $postid;
	    include_once 'include/notification.inc.php';
	    $forum_info = newbb_notify_iteminfo ('forum', $forum_id);
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