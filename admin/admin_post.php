<?php
// $Id: admin_post.php,v 1.4 2005/04/18 01:22:27 phppp Exp $
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                      //
// Copyright (c) 2000 XOOPS.org                           //
// <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //



include('admin_header.php');
//include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/class/mimetype.php';
include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/class/uploader.php';
foreach (array('forum', 'topic_id', 'post_id', 'pid') as $getint) {
    ${$getint} = isset($_POST[$getint]) ? intval($_POST[$getint]) : 0;
}

if ( empty($forum) ) {
    redirect_header("index.php", 2, _MD_ERRORFORUM);
    exit();
}

$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
$forum =& $forum_handler->get($forum);

$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
$topic =& $topic_handler->get($topic_id);
$post_handler =& xoops_getmodulehandler('post', 'newbb');

if ( !empty($_POST['contents_preview']) ) {
	xoops_cp_header();
	newbb_adminmenu(0, "");
    echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td>";
    $myts =& MyTextSanitizer::getInstance();
    $p_subject = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['subject']));
    $dosmiley = isset($_POST['dosmiley']) ? 1 : 0;
    $dohtml = isset($_POST['dohtml']) ? 1 : 0;
    $doxcode = isset($_POST['doxcode']) ? 1 : 0;
    $p_message = $myts->previewTarea($_POST['message'],$dohtml,$dosmiley,$doxcode);

    echo "<table cellpadding='4' cellspacing='1' width='98%' class='outer'>";
    echo "<tr><td class='head'>".$p_subject."</td></tr>";
    if(isset($_POST['poster_name'])){
		$p_poster_name = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['poster_name']));
		echo "<tr><td>".$p_poster_name."</td></tr>";
	}
    echo "<tr><td><br />".$p_message."<br /></td></tr></table>";

    echo "<br />";

    $subject_pre = (isset($_POST['subject_pre']))?$_POST['subject_pre']:'';
    $subject = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['subject']));
	$message = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['message']));
    $poster_name = isset($_POST['poster_name'])?$myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['poster_name'])):'';
    $hidden = isset($_POST['hidden'])?$myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['hidden'])):'';
    $notify = !empty($_POST['notify']) ? 1 : 0;
    $attachsig = !empty($_POST['attachsig']) ? 1 : 0;

    $icon = isset($_POST['icon']) ? $_POST['icon'] : 0;
    $view_require = isset($_POST['view_require']) ? $_POST['view_require'] : '';
    $post_karma = (($view_require == 'require_karma')&&isset($_POST['post_karma']))?intval($_POST['post_karma']):0;
    $require_reply = ($view_require == 'require_reply')?1:0;
    include 'include/forumform.inc.php';
    echo"</td></tr></table>";
	xoops_cp_footer();
}
else {

    $message =  $_POST['message'];

	$uid = is_object($xoopsUser)? $xoopsUser->getVar('uid'):0;
    $post_handler =& xoops_getmodulehandler('post', 'newbb');
    $forumpost =& $post_handler->get($post_id);
	$topic_status = $topic_handler->get($topic_id,'topic_status');
    $delete_attach = isset($_POST['delete_attach']) ? $_POST['delete_attach'] : '';
    if (count($delete_attach)) $forumpost->deleteAttachment($delete_attach);

	$forumpost->setVar('approved', 0);
    $forumpost->setVar('forum_id', $forum->getVar('forum_id'));

    $subject = xoops_trim($_POST['subject']);
    $subject = ($subject == '') ? _NOTITLE : $subject;
    $poster_name = isset($_POST['poster_name'])?xoops_trim($_POST['poster_name']):'';
    $dohtml = isset($_POST['dohtml']) ? intval($_POST['dohtml']) : 0;
    $dosmiley = isset($_POST['dosmiley']) ? intval($_POST['dosmiley']) : 0;
    $doxcode = isset($_POST['doxcode']) ? intval($_POST['doxcode']) : 0;
    $icon = isset($_POST['icon']) ? intval($_POST['icon']) : 0;
    $attachsig = isset($_POST['attachsig']) ? 1 : 0;
    $view_require = isset($_POST['view_require']) ? $_POST['view_require'] : '';
    $post_karma = (($view_require == 'require_karma')&&isset($_POST['post_karma']))?intval($_POST['post_karma']):0;
    $require_reply = ($view_require == 'require_reply')?1:0;
    $forumpost->setVar('subject', $subject);
    $forumpost->setVar('post_text', $message);
    $forumpost->setVar('post_karma', $post_karma);
    $forumpost->setVar('require_reply', $require_reply);
    $forumpost->setVar('poster_name', $poster_name);
    $forumpost->setVar('dohtml', $dohtml);
    $forumpost->setVar('dosmiley', $dosmiley);
    $forumpost->setVar('doxcode', $doxcode);
    $forumpost->setVar('icon', $icon);
    $forumpost->setVar('attachsig', $attachsig);
	$forumpost->setAttachment();

    $error_upload = '';

    if (isset($_FILES['userfile']['name']) && $_FILES['userfile']['name']!='')
    {
        $maxfilesize = $forum->getVar('attach_maxkb')*1024;
        $uploaddir = XOOPS_ROOT_PATH . "/".$xoopsModuleConfig['dir_attachments'];
        $url = XOOPS_URL . "/".$xoopsModuleConfig['dir_attachments']."/" . $_FILES['userfile']['name'];

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
    	redirect_header('index.php', 2, _AM_NEWBB_POSTNOTSAVED);
        exit();
    }
	$message = _AM_NEWBB_POSTSAVED;

    if(isset($_POST['subject_pre'])){
		$subject_pre = intval($_POST['subject_pre']);
		$sbj_res = $post_handler->insertnewsubject($topic_id, $subject_pre);
    }

    $approved = isset($_POST['approved']) ? intval($_POST['approved']) : '';
    if($approved){
        if (!$post_handler->approve($postid)) {
            redirect_header("index.php", 1, _AM_NEWBB_POSTNOTAPPROVED);
            exit();
        }

	    if(!empty($xoopsModuleConfig['notification_enabled'])){
		    $tags = array();
		    $tags['THREAD_NAME'] = $_POST['subject'];
		    $tags['THREAD_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/viewtopic.php?post_id='.$postid.'&topic_id=' . $forumpost->getVar('topic_id').'&forum=' . $forumpost->getVar('forum_id');
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
	    }
        $message = _AM_NEWBB_POSTAPPROVED;
    }

    redirect_header('index.php', 2, $message);
    exit();
}
?>