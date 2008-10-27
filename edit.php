<?php
// $Id: edit.php,v 1.3 2005/10/19 17:20:28 phppp Exp $
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
include 'header.php';
// Disable cache
$xoopsConfig["module_cache"][$xoopsModule->getVar("mid")] = 0;
include XOOPS_ROOT_PATH."/header.php";
foreach (array('forum', 'topic_id', 'post_id', 'order', 'pid') as $getint) {
    ${$getint} = isset($_GET[$getint]) ? intval($_GET[$getint]) : 0;
}
$viewmode = (isset($_GET['viewmode']) && $_GET['viewmode'] != 'flat') ? 'thread' : 'flat';
if ( empty($forum) ) {
    redirect_header("index.php", 2, _MD_ERRORFORUM);
    exit();
} elseif ( empty($post_id) ) {
    redirect_header("viewforum.php?forum=$forum", 2, _MD_ERRORPOST);
    exit();
} else {
    $forum_handler =& xoops_getmodulehandler('forum', 'newbb');
	$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
    $post_handler =& xoops_getmodulehandler('post', 'newbb');
    

    $forumpost =& $post_handler->get($post_id);
    $forum_obj =& $forum_handler->get($forumpost->getVar("forum_id"));
	if (!$forum_handler->getPermission($forum_obj)){
	    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
	    exit();
	}

	if ($xoopsModuleConfig['wol_enabled']){
		$online_handler =& xoops_getmodulehandler('online', 'newbb');
		$online_handler->init($forum_obj);
	}
	$isadmin = newbb_isAdmin($forum_obj);
	$uid = is_object($xoopsUser)? $xoopsUser->getVar('uid'):0;

	$topic_status = $topic_handler->get($topic_id,'topic_status');
	if ( $topic_handler->getPermission($forum_obj, $topic_status, 'edit')
		&& ( $isadmin || $forumpost->checkIdentity()) ) {}
	else{
	    redirect_header("viewtopic.php?forum=".$forum_obj->getVar('forum_id')."&amp;topic_id=$topic_id&amp;post_id=$post_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid",2,_MD_NORIGHTTOEDIT);
	    exit();
	}
    if(!$isadmin && !$forumpost->checkTimelimit('edit_timelimit')){
		redirect_header("viewtopic.php?forum=".$forum_obj->getVar('forum_id')."&amp;topic_id=$topic_id&amp;post_id=$post_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid",2,_MD_TIMEISUP);
    	exit();
	}
    $post_id2 = $forumpost->getVar('pid');

    $dohtml = $forumpost->getVar('dohtml');
    $dosmiley = $forumpost->getVar('dosmiley');
    $doxcode = $forumpost->getVar('doxcode');
    $dobr = $forumpost->getVar('dobr');
    $icon = $forumpost->getVar('icon');
    $attachsig = $forumpost->getVar('attachsig');
    $topic_id=$forumpost->getVar('topic_id');
    $istopic = ( $forumpost->istopic() )?1:0;
    $isedit =1;
    $subject_pre="";
    $subject=$forumpost->getVar('subject', "E");
    $message=$forumpost->getVar('post_text', "E");
    $poster_name=$forumpost->getVar('poster_name', "E");
    $attachments=$forumpost->getAttachment();
    $post_karma=$forumpost->getVar('post_karma');
    $require_reply=$forumpost->getVar('require_reply');
    $hidden = "";

    include 'include/forumform.inc.php';
    if (!$istopic) {
        $forumpost2 =& $post_handler->get($post_id2);

	    $r_message = $forumpost2->getVar('post_text');

    	$isadmin = 0;
    	if($forumpost2->getVar('uid')) {
	    	$r_name = newbb_getUnameFromId( $forumpost2->getVar('uid'), $xoopsModuleConfig['show_realname']);
			if (newbb_isAdmin($forum_obj, $forumpost2->getVar('uid'))) $isadmin = 1;
    	}else{
	    	$poster_name = $forumpost2->getVar('poster_name');
    		$r_name = (empty($poster_name))?$xoopsConfig['anonymous']:$poster_name;
		}
		$r_date = formatTimestamp($forumpost2->getVar('post_time'));
	    $r_subject = $forumpost2->getVar('subject');

        $r_content = _MD_BY." ".$r_name." "._MD_ON." ".$r_date."<br /><br />";
        $r_content .= $r_message;
        $r_subject=$forumpost2->getVar('subject');
        echo "<table cellpadding='4' cellspacing='1' width='98%' class='outer'><tr><td class='head'>".$r_subject."</td></tr>";
        echo "<tr><td><br />".$r_content."<br /></td></tr></table>";
    }

    include XOOPS_ROOT_PATH.'/footer.php';
}
?>