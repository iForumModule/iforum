<?php
// $Id: reply.php,v 1.5.4.2 2005/01/07 05:27:34 phppp Exp $
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
foreach (array('forum', 'topic_id', 'post_id', 'order', 'pid', 'start') as $getint) {
    ${$getint} = isset($_GET[$getint]) ? intval($_GET[$getint]) : 0;
}
$viewmode = (isset($_GET['viewmode']) && $_GET['viewmode'] != 'flat') ? 'thread' : 'flat';
if ( empty($forum) ) {
    redirect_header("index.php", 2, _MD_ERRORFORUM);
    exit();
} elseif ( empty($topic_id) ) {
    redirect_header("viewforum.php?forum=$forum", 2, _MD_ERRORTOPIC);
    exit();
} elseif ( empty($post_id) ) {
    redirect_header("viewtopic.php?topic_id=$topic_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid", 2, _MD_ERRORPOST);
    exit();
} else {

    $forum_handler =& xoops_getmodulehandler('forum', 'newbb');
    $forum = $forum_handler->get($forum);
	if (!$forum_handler->getPermission($forum)){
	    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
	    exit();
	}

	$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
	$topic_status = $topic_handler->get($topic_id,'topic_status');
	if ( !$topic_handler->getPermission($forum, $topic_status, 'reply'))
	{
		redirect_header("viewtopic.php?topic_id=$topic_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid&amp;forum=".$forum->getVar('forum_id'), 2, _MD_NORIGHTTOREPLY);
	    exit();
	}

	if ($xoopsModuleConfig['wol_enabled']){
		$online_handler =& xoops_getmodulehandler('online', 'newbb');
		$online_handler->init($forum);
	}

    $myts =& MyTextSanitizer::getInstance();

    include XOOPS_ROOT_PATH.'/header.php';

	$isadmin = newbb_isAdmin($forum);

    $post_handler =& xoops_getmodulehandler('post', 'newbb');
    $forumpost =& $post_handler->get($post_id);
    $forumpostshow =& $post_handler->getByLimit($topic_id,5);

    if($forumpost->getVar('uid')) {
	    $r_name =newbb_getUnameFromId( $forumpost->getVar('uid'), $xoopsModuleConfig['show_realname'] );
    }else{
	    $poster_name = $forumpost->getVar('poster_name');
    	$r_name = (empty($poster_name))?$xoopsConfig['anonymous']:$myts->htmlSpecialChars($poster_name);
	}

    $r_subject=$forumpost->getVar('subject', "E");
    if( $isadmin && $xoopsModuleConfig['allow_moderator_html']){
	}else{
	    $r_subject = $myts->undoHtmlSpecialChars($r_subject);
    	$r_subject = newbb_html2text($r_subject);
	    $r_subject = $myts->htmlSpecialChars($r_subject);
	}

    if (!preg_match("/^Re:/i",$r_subject)) {
        $subject = 'Re: '.$r_subject;
    } else {
        $subject = $r_subject;
    }

    $q_message = $forumpost->getVar('post_text',"e");

    if((!$xoopsModuleConfig['enable_karma']||!$forumpost->getVar('post_karma'))
    && (!$xoopsModuleConfig['allow_require_reply'] ||!$forumpost->getVar('require_reply')))
    {
	    if (isset($_GET['quotedac']) && $_GET['quotedac'] == 1) {
	        $message = "[quote]\n";
	        $message .= sprintf(_MD_USERWROTE,$r_name);
	        $message .= "\n".$q_message."[/quote]";
        	$hidden = "";
	    } else {
	        $hidden = "[quote]\n";
	        $hidden .= sprintf(_MD_USERWROTE,$r_name);
	        $hidden .= "\n".$q_message."[/quote]";
	        $message = "";
	    }
    }else{
        $hidden = "";
        $message = "";
    }

    echo "<br />";
    $pid=$post_id;
    unset($post_id);
    $topic_id=$forumpost->getVar('topic_id');
    $isreply =1;
    $istopic = 0;
    $dohtml = 0;
    $dosmiley = 1;
    $doxcode = 1;
    $subject_pre="";
    $icon = '';
    $attachsig = (is_object($xoopsUser) && $xoopsUser->getVar('attachsig')) ? 1 : 0;
    $topic_id=$forumpost->getVar('topic_id');
    $post_karma = 0;
    $require_reply = 0;

    if ($xoopsModuleConfig['disc_show'] == 2 or $xoopsModuleConfig['disc_show'] == 3 ){
    echo "<table cellpadding='4' cellspacing='1' width='98%' class='outer'><tr><td class='head' align='center'>"._MD_BOARD_DISCLAIMER."</td></tr>";
	echo "<tr><td><br />".$xoopsModuleConfig['disclaimer']."<br /></td></tr></table>";
    }

    include 'include/forumform.inc.php';

	$karma_handler =& xoops_getmodulehandler('karma', 'newbb');
	$user_karma = $karma_handler->getUserKarma();

    foreach ($forumpostshow as $eachpost) {
    	// Sorry, in order to save queries, we have to hide the non-open post_text even if you have replied or have adequate karma, even an admin.
	    if( $xoopsModuleConfig['enable_karma'] && $eachpost->getVar('post_karma') > 0 ) {
	        $p_message = sprintf(_MD_KARMA_REQUIREMENT, "***", $eachpost->getVar('post_karma'))."</div>";
	    }elseif( $xoopsModuleConfig['allow_require_reply'] && $eachpost->getVar('require_reply') ) {
	        $p_message = _MD_REPLY_REQUIREMENT;
	    }else{
		    $p_message = $eachpost->getVar('post_text');
	    }

    	$isadmin = 0;
    	if($eachpost->getVar('uid')) {
	    	$p_name =newbb_getUnameFromId( $eachpost->getVar('uid'), $xoopsModuleConfig['show_realname'] );
			if (newbb_isAdmin($forum, $eachpost->getVar('uid'))) $isadmin = 1;
    	}else{
	    	$poster_name = $eachpost->getVar('poster_name');
    		$p_name = (empty($poster_name))?$xoopsConfig['anonymous']:$myts->htmlSpecialChars($poster_name);
		}
		$p_date = formatTimestamp($eachpost->getVar('post_time'));
	    if( $isadmin && $xoopsModuleConfig['allow_moderator_html']){
	    	$p_subject = $myts->undoHtmlSpecialChars($eachpost->getVar('subject'));
		}else{
	    	$p_subject = $eachpost->getVar('subject');
		}
    	$p_content = _MD_BY." <strong> ".$p_name." </strong> "._MD_ON." <strong> ".$p_date."</strong><br /><br />";
    	$p_content .= $p_message;

	    echo "<table cellpadding='4' cellspacing='1' width='98%' class='outer'><tr><td class='head'>".$p_subject."</td></tr>";
	    echo "<tr><td><br />".$p_content."<br /></td></tr></table>";
	}

    include XOOPS_ROOT_PATH.'/footer.php';
}
?>