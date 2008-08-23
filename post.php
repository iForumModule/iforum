<?php
// $Id: post.php,v 1.3 2005/10/19 17:20:28 phppp Exp $
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
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

include 'header.php';
include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/class/uploader.php';

foreach (array(
			'forum',
			'topic_id',
			'post_id',
			'order',
			'pid',
			'start',
			'isreply',
			'isedit'
			) as $getint) {
    ${$getint} = isset($_POST[$getint]) ? intval($_POST[$getint]) : 0 ;
}
$op = isset($_POST['op']) ? $_POST['op'] : '';
$viewmode = (isset($_POST['viewmode']) && $_POST['viewmode'] != 'flat') ? 'thread' : 'flat';
if ( empty($forum) ) {
    redirect_header("index.php", 2, _MD_ERRORFORUM);
    exit();
}

$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
$post_handler =& xoops_getmodulehandler('post', 'newbb');

if ( !empty($isedit) && $post_id>0 ) {
    $forumpost =& $post_handler->get($post_id);
    $topic_id = $forumpost->getVar("topic_id");
}else{
	$forumpost =& $post_handler->create();
}
$topic =& $topic_handler->get($topic_id);
$forum_id = ($topic_id)?$topic->getVar("forum_id"):$forum;
$forum =& $forum_handler->get($forum_id);
if (!$forum_handler->getPermission($forum)){
    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
    exit();
}

if ($xoopsModuleConfig['wol_enabled']){
	$online_handler =& xoops_getmodulehandler('online', 'newbb');
	$online_handler->init($forum);
}

include XOOPS_ROOT_PATH."/header.php";

if ( !empty($_POST['contents_submit']) ) {
	$token_valid = false;
	if(class_exists("XoopsSecurity")){
		$token_valid = $GLOBALS['xoopsSecurity']->check();
	}else{ // backward compatible
		if( !empty($_SESSION['submit_token']) && !empty($_POST['post_valid']) && $_POST['post_valid']==$_SESSION['submit_token'] ) $token_valid = true;
		$_SESSION['submit_token'] = null;
	}

	if(!is_object($xoopsUser)){
		$uname = !isset($_POST['uname']) ? '' : trim($_POST['uname']);
		$pass = !isset($_POST['pass']) ? '' : trim($_POST['pass']);
		$member_handler =& xoops_gethandler('member');
		$user =& $member_handler->loginUser(addslashes($myts->stripSlashesGPC($uname)), addslashes($myts->stripSlashesGPC($pass)));
		if(is_object($user) && 0 < $user->getVar('level')){
			if(!empty($_POST["login"])){
				$user->setVar('last_login', time());
				if (!$member_handler->insertUser($user)) {
				}
				$_SESSION = array();
				$_SESSION['xoopsUserId'] = $user->getVar('uid');
				$_SESSION['xoopsUserGroups'] = $user->getGroups();
				if ($xoopsConfig['use_mysession'] && $xoopsConfig['session_name'] != '') {
					setcookie($xoopsConfig['session_name'], session_id(), time()+(60 * $xoopsConfig['session_expire']), '/',  '', 0);
				}
				$user_theme = $user->getVar('theme');
				if (in_array($user_theme, $xoopsConfig['theme_set_allowed'])) {
					$_SESSION['xoopsUserTheme'] = $user_theme;
				}
			}
			$xoopsUser =& $user;
		}
	}

	$isadmin = newbb_isAdmin($forum);

	$time_valid = true;
	if( !$isadmin && !empty($xoopsModuleConfig['post_timelimit']) ){
    	$last_post = newbb_getsession('LP'); // using session might be more secure ...
		if(time()-$last_post < $xoopsModuleConfig['post_timelimit']){
			$time_valid = false;
		}
	}

	if(!$token_valid || !$time_valid){
		$_POST['contents_preview'] = 1;
		$_POST['contents_submit'] = null;
		$_POST['contents_upload'] = null;
		if(!$token_valid) echo "<div class=\"errorMsg\">"._MD_INVALID_SUBMIT."</div>";
		if(!$time_valid) echo "<div class=\"errorMsg\">".sprintf(_MD_POSTING_LIMITED,$xoopsModuleConfig['post_timelimit'])."</div>";
		echo "<br clear=\"both\" />";
	}
}

if ( !empty($_POST['contents_submit']) ) {
    $message =  $_POST['message'];
	if(empty($message)){
	    redirect_header("javascript:history.go(-1);", 1);
	    exit();
	}
    if ( !empty($isedit) && $post_id>0) {

		$uid = is_object($xoopsUser)? $xoopsUser->getVar('uid'):0;

		$topic_status = $topic_handler->get($topic_id,'topic_status');
		if ( $topic_handler->getPermission($forum, $topic_status, 'edit')
			&& ( $isadmin || ( $forumpost->checkTimelimit('edit_timelimit') && $forumpost->checkIdentity() ))
			) {}
		else{
		    redirect_header("viewtopic.php?forum=$forum&amp;topic_id=$topic_id&amp;post_id=$post_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid",2,_MD_NORIGHTTOEDIT);
		    exit();
		}

	    $delete_attach = isset($_POST['delete_attach']) ? $_POST['delete_attach'] : array();
	    if (is_array($delete_attach) && count($delete_attach)>0) $forumpost->deleteAttachment($delete_attach);
    }
    else {
		if($topic_id){
			$topic_status = $topic_handler->get($topic_id,'topic_status');
			if (!$topic_handler->getPermission($forum, $topic_status, 'reply')) {
			    redirect_header("viewtopic.php?forum=$forum&amp;topic_id=$topic_id&amp;post_id=$post_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid",2,_MD_NORIGHTTOREPLY);
			    exit();
			}
		}
		if(!$topic_id){
			$topic_status = 0;
			if (!$topic_handler->getPermission($forum, $topic_status, 'post')) {
			    redirect_header("viewtopic.php?forum=$forum",2,_MD_NORIGHTTOPOST);
			    exit();
			}
		}

        $isreply = 0;
        $isnew = 1;
        if ( !is_object($xoopsUser) || ( !empty($_POST['noname']) && !empty($xoopsModuleConfig['allow_user_anonymous']) ) ) {
            $uid = 0;
        }
        else {
            $uid = $xoopsUser->getVar("uid");
        }
        if (isset($pid) && $pid != "") {
            $forumpost->setVar('pid', $pid);
        }
        if (!empty($topic_id)) {
            $forumpost->setVar('topic_id', $topic_id);
            $isreply = 1;
        }
        $forumpost->setVar('poster_ip', newbb_getIP());
        $forumpost->setVar('uid', $uid);
    }

	if($topic_handler->getPermission($forum, $topic_status, 'noapprove')) $approved = 1;
	else $approved = 0;
	$forumpost->setVar('approved', $approved);

    $forumpost->setVar('forum_id', $forum->getVar('forum_id'));

    $subject = xoops_trim($_POST['subject']);
    $subject = ($subject == '') ? _NOTITLE : $subject;
    $poster_name = !empty($_POST['poster_name'])?xoops_trim($_POST['poster_name']):'';
    $dohtml = !empty($_POST['dohtml']) ? 1 : 0;
    $dosmiley = !empty($_POST['dosmiley']) ? 1 : 0;
    $doxcode = !empty($_POST['doxcode']) ? 1 : 0;
    $dobr = !empty($_POST['dobr']) ? 1 : 0;
    $icon = (!empty($_POST['icon']) && is_file(XOOPS_ROOT_PATH . "/images/subject/" . $_POST['icon']) ) ? $_POST['icon'] : '';
    $attachsig = !empty($_POST['attachsig']) ? 1 : 0;
    $view_require = !empty($_POST['view_require']) ? $_POST['view_require'] : '';
    $post_karma = (($view_require == 'require_karma')&&isset($_POST['post_karma']))?intval($_POST['post_karma']):0;
    $require_reply = ($view_require == 'require_reply')?1:0;
    $forumpost->setVar('subject', $subject);

    // The text filter is far from complete
    // Let's look for some comprehensive handlers
	if($dohtml && !newbb_isAdmin($forum) ) {
		$message=newbb_textFilter($message);
	}
    $forumpost->setVar('post_text', $message);
    $forumpost->setVar('post_karma', $post_karma);
    $forumpost->setVar('require_reply', $require_reply);
    $forumpost->setVar('poster_name', $poster_name);
    $forumpost->setVar('dohtml', $dohtml);
    $forumpost->setVar('dosmiley', $dosmiley);
    $forumpost->setVar('doxcode', $doxcode);
    $forumpost->setVar('dobr', $dobr);
    $forumpost->setVar('icon', $icon);
    $forumpost->setVar('attachsig', $attachsig);
	$forumpost->setAttachment();
	if ( !empty($post_id) ) $forumpost->setPostEdit($poster_name); // is reply

	$attachments_tmp = array();
	if (!empty($_POST["attachments_tmp"])){
		$attachments_tmp=unserialize(base64_decode($_POST["attachments_tmp"]));
		if (isset($_POST["delete_tmp"]) && count($_POST["delete_tmp"])){
			foreach($_POST["delete_tmp"] as $key){
				unlink(XOOPS_CACHE_PATH . "/" . $attachments_tmp[$key][0]);
				unset($attachments_tmp[$key]);
			}
		}
    }
	if (count($attachments_tmp)){
		foreach($attachments_tmp as $key=>$attach){
			rename(XOOPS_CACHE_PATH . "/" . $attachments_tmp[$key][0],
				XOOPS_ROOT_PATH . "/".$xoopsModuleConfig['dir_attachments']."/".$attachments_tmp[$key][0]
			);
            $forumpost->setAttachment($attach[0], $attach[1], $attach[2]);
        }
    }

    $error_upload = '';

    if (isset($_FILES['userfile']['name']) && $_FILES['userfile']['name']!=''
    	&& $topic_handler->getPermission($forum, $topic_status, 'attach')
    )
    {
        $maxfilesize = $forum->getVar('attach_maxkb')*1024;
        $uploaddir = XOOPS_ROOT_PATH . "/".$xoopsModuleConfig['dir_attachments'];

        $uploader = new newbb_uploader(
        	$uploaddir,
        	$forum->getVar('attach_ext'),
        	$maxfilesize
        );

        $uploader->setCheckMediaTypeByExt();

        if ( $uploader->fetchMedia( $_POST['xoops_upload_file'][0]) )
        {
	        $prefix = is_object($xoopsUser)?strval($xoopsUser->uid()).'_':'newbb_';
	        $uploader->setPrefix($prefix);
            if ( !$uploader->upload() )
                $error_upload = $uploader->getErrors();
            else{
                if ( is_file( $uploader->getSavedDestination() )){
                    $forumpost->setAttachment($uploader->getSavedFileName(), $uploader->getMediaName(), $uploader->getMediaType());
                }
            }
        }
        else
        {
            $error_upload = $uploader->getErrors();
        }
    }

    $postid = $post_handler->insert($forumpost);
    if (!$postid ) {
        include_once(XOOPS_ROOT_PATH.'/header.php');
        xoops_error('Could not insert forum post');
        include_once(XOOPS_ROOT_PATH.'/footer.php');
        exit();
    }
	newbb_setsession("LP", time()); // Recording last post time


    if(newbb_checkSubjectPrefixPermission($forum) && !empty($_POST['subject_pre'])){
		$subject_pre = intval($_POST['subject_pre']);
		$sbj_res = $post_handler->insertnewsubject($forumpost->getVar('topic_id'), $subject_pre);
    }

    // RMV-NOTIFY
    // Define tags for notification message
    if($approved && !empty($xoopsModuleConfig['notification_enabled']) && !empty($isnew)){
	    $tags = array();
	    $tags['THREAD_NAME'] = $_POST['subject'];
	    $tags['THREAD_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/viewtopic.php?post_id='.$postid.'&amp;topic_id=' . $forumpost->getVar('topic_id').'&amp;forum=' . $forumpost->getVar('forum_id');
	    $tags['POST_URL'] = $tags['THREAD_URL'] . '#forumpost' . $postid;
	    include_once 'include/notification.inc.php';
	    $forum_info = newbb_notify_iteminfo ('forum', $forum->getVar('forum_id'));
	    $tags['FORUM_NAME'] = $forum_info['name'];
	    $tags['FORUM_URL'] = $forum_info['url'];
	    $notification_handler =& xoops_gethandler('notification');
        if (empty($isreply)) {
            // Notify of new thread
            $notification_handler->triggerEvent('forum', $forum->getVar('forum_id'), 'new_thread', $tags);
        } else {
            // Notify of new post
            $notification_handler->triggerEvent('thread', $topic_id, 'new_post', $tags);
        }
        $notification_handler->triggerEvent('global', 0, 'new_post', $tags);
        $notification_handler->triggerEvent('forum', $forum->getVar('forum_id'), 'new_post', $tags);
        $myts =& MyTextSanitizer::getInstance();
        $tags['POST_CONTENT'] = $myts->stripSlashesGPC($_POST['message']);
        $tags['POST_NAME'] = $myts->stripSlashesGPC($_POST['subject']);
        $notification_handler->triggerEvent('global', 0, 'new_fullpost', $tags);
        $notification_handler->triggerEvent('forum', $forum->getVar('forum_id'), 'new_fullpost', $tags);
    }

    // If user checked notification box, subscribe them to the
    // appropriate event; if unchecked, then unsubscribe
    if (!empty($xoopsUser) && !empty($xoopsModuleConfig['notification_enabled'])) {
	    $notification_handler =& xoops_gethandler('notification');
        if (!empty($_POST['notify'])) {
            $notification_handler->subscribe('thread', $forumpost->getVar('topic_id'), 'new_post');
        } else {
            $notification_handler->unsubscribe('thread', $forumpost->getVar('topic_id'), 'new_post');
        }
    }

    if($approved){
		if(!empty($xoopsModuleConfig['cache_enabled'])){
			newbb_setsession("t".$forumpost->getVar("topic_id"), null);
		}
    	$redirect = "viewtopic.php?topic_id=".$forumpost->getVar('topic_id')."&amp;post_id=".$postid."#forumpost".$postid."";
	    $message = _MD_THANKSSUBMIT."<br />".$error_upload;
    }else{
	    $redirect = "viewforum.php?forum=".$forumpost->getVar('forum_id');
	    $message = _MD_THANKSSUBMIT."<br />"._MD_WAITFORAPPROVAL."<br />".$error_upload;
	}
	if ( $op == "add" ) {
		redirect_header("polls.php?op=add&amp;forum=".$forumpost->getVar('forum_id')."&amp;topic_id=".$forumpost->getVar('topic_id')."",1,_MD_ADDPOLL);
		exit();
    }else{
	    redirect_header($redirect,2,$message);
        exit();
    }
}


if ( !empty($_POST['contents_upload']) ) {
	$attachments_tmp=array();
	if (!empty($_POST["attachments_tmp"])){
		$attachments_tmp=unserialize(base64_decode($_POST["attachments_tmp"]));
		if (isset($_POST["delete_tmp"]) && count($_POST["delete_tmp"])){
			foreach($_POST["delete_tmp"] as $key){
				unlink(XOOPS_CACHE_PATH . $attachments_tmp[$key][0]);
				unset($attachments_tmp[$key]);
			}
		}

    }

    $error_upload = '';
    if (isset($_FILES['userfile']['name']) && $_FILES['userfile']['name']!=''
    )
    {
        $maxfilesize = $forum->getVar('attach_maxkb')*1024;
        $uploaddir = XOOPS_CACHE_PATH;

        $uploader = new newbb_uploader(
        	$uploaddir,
        	$forum->getVar('attach_ext'),
        	$maxfilesize
        );

        $uploader->setCheckMediaTypeByExt();

        if ( $uploader->fetchMedia( $_POST['xoops_upload_file'][0]) )
        {
	        $prefix = is_object($xoopsUser)?strval($xoopsUser->uid()).'_':'newbb_';
	        $uploader->setPrefix($prefix);
            if ( !$uploader->upload() )
                $error_upload = $uploader->getErrors();
            else{
                if ( is_file( $uploader->getSavedDestination() )){
					$attachments_tmp[strval(time())]=array(
                    	$uploader->getSavedFileName(),
                    	$uploader->getMediaName(),
                    	$uploader->getMediaType()
                    	);
                }
            }
        }
        else
        {
            $error_upload = $uploader->getErrors();
        }
    }
}

if ( !empty($_POST['contents_preview']) || !empty($_GET['contents_preview']) ) {
	if (!empty($_POST["attachments_tmp"])){
		$attachments_tmp=unserialize(base64_decode($_POST["attachments_tmp"]));
	}

    $myts =& MyTextSanitizer::getInstance();
    $p_subject = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['subject']));
    $dosmiley = empty($_POST['dosmiley']) ? 0 : 1;
    $dohtml = empty($_POST['dohtml']) ? 0 : 1;
    $doxcode = empty($_POST['doxcode']) ? 0 : 1;
    $dobr = empty($_POST['dobr']) ? 0 : 1;
    $p_message = $_POST['message'];
    $p_message = $myts->previewTarea($p_message, $dohtml, $dosmiley, $doxcode, 1, $dobr);
	if($dohtml && !newbb_isAdmin($forum) ) {
		$p_message = newbb_textFilter($p_message);
	}

    echo "<table cellpadding='4' cellspacing='1' width='98%' class='outer'>";
    echo "<tr><td class='head'>".$p_subject."</td></tr>";
    if(isset($_POST['poster_name'])){
		$p_poster_name = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['poster_name']));
		echo "<tr><td>".$p_poster_name."</td></tr>";
	}
    echo "<tr><td><br />".$p_message."<br /></td></tr></table>";
}

if ( !empty($_POST['contents_upload']) || !empty($_POST['contents_preview']) || !empty($_GET['contents_preview']) || !empty($_POST['editor'])) 
{

    echo "<br />";

    $editor = empty($_POST['editor']) ? "" : $_POST['editor'];
    $dosmiley = empty($_POST['dosmiley']) ? 0 : 1;
    $dohtml = empty($_POST['dohtml']) ? 0 : 1;
    $doxcode = empty($_POST['doxcode']) ? 0 : 1;
    $dobr = empty($_POST['dobr']) ? 0 : 1;
    $subject_pre = (isset($_POST['subject_pre']))?$_POST['subject_pre']:'';
    $subject = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['subject']));
	$message = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['message']));
    $poster_name = isset($_POST['poster_name'])?$myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['poster_name'])):'';
    $hidden = isset($_POST['hidden'])?$myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['hidden'])):'';
    $notify = !empty($_POST['notify']) ? 1 : 0;
    $attachsig = !empty($_POST['attachsig']) ? 1 : 0;
    $isreply = !empty($_POST['isreply']) ? 1 : 0;
    $isedit = !empty($_POST['isedit']) ? 1 : 0;
    $icon = (!empty($_POST['icon']) && is_file(XOOPS_ROOT_PATH . "/images/subject/" . $_POST['icon']) ) ? $_POST['icon'] : '';
    $view_require = isset($_POST['view_require']) ? $_POST['view_require'] : '';
    $post_karma = (($view_require == 'require_karma')&&isset($_POST['post_karma']))?intval($_POST['post_karma']):0;
    $require_reply = ($view_require == 'require_reply')?1:0;

    if(empty($_POST['contents_upload'])) $contents_preview = 1;
    $attachments=$forumpost->getAttachment();
    include 'include/forumform.inc.php';
}

include XOOPS_ROOT_PATH.'/footer.php';
?>