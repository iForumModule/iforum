<?php
// $Id: delete.php,v 1.5 2005/05/15 12:24:47 phppp Exp $
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

$ok = isset($_POST['ok']) ? intval($_POST['ok']) : 0;
foreach (array('forum', 'topic_id', 'post_id', 'order', 'pid', 'act') as $getint) {
    ${$getint} = isset($_POST[$getint]) ? intval($_POST[$getint]) : 0;

}
foreach (array('forum', 'topic_id', 'post_id', 'order', 'pid', 'act') as $getint) {
    ${$getint} = (${$getint})?${$getint}:(isset($_GET[$getint]) ? intval($_GET[$getint]) : 0);

}
$viewmode = (isset($_GET['viewmode']) && $_GET['viewmode'] != 'flat') ? 'thread' : 'flat';
$viewmode = ($viewmode)?$viewmode: (isset($_POST['viewmode'])?$_POST['viewmode'] : 'flat');

if ( empty($forum) ) {
    redirect_header("index.php", 2, _MD_ERRORFORUM);
    exit();
}

$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
$_forum =& $forum_handler->get($forum);
if (!$forum_handler->getPermission($_forum)){
    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
    exit();
}

$isadmin = newbb_isAdmin($_forum);

$uid = is_object($xoopsUser)? $xoopsUser->getVar('uid'):0;

$post_handler =& xoops_getmodulehandler('post', 'newbb');
$forumpost =& $post_handler->get($post_id);

$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
$topic = $topic_handler->get($topic_id);
$topic_status = $topic->getVar('topic_status');
if ( $topic_handler->getPermission($forum, $topic_status, 'delete')
	&& ( $isadmin || $forumpost->checkIdentity() )){}
else{
	redirect_header("viewtopic.php?topic_id=$topic_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid&amp;forum=$forum", 2, _MD_DELNOTALLOWED);
    exit();
}

$post_handler =& xoops_getmodulehandler('post', 'newbb');
$forumpost =& $post_handler->get($post_id);

if (!$isadmin && !$forumpost->checkTimelimit('delete_timelimit'))
{
	redirect_header("viewtopic.php?forum=$forum&amp;topic_id=$topic_id&amp;post_id=$post_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid",2,_MD_TIMEISUPDEL);
	exit();
}

if ($xoopsModuleConfig['wol_enabled']){
	$online_handler =& xoops_getmodulehandler('online', 'newbb');
	$online_handler->init($_forum);
}

if ( $ok ) {
    $isDeleteOne = (NEWBB_DELETEONE == $ok)? true : false;
    if($forumpost->isTopic() && $topic->getVar("topic_replies")==0) $isDeleteOne=false;
    if($isDeleteOne && $forumpost->isTopic() && $topic->getVar("topic_replies")>0){
    	$post_handler->emptyTopic($forumpost);
    }else{
	    $post_handler->delete($forumpost, $isDeleteOne);
	    sync($forum, "forum");
	    sync($topic_id, "topic");
    }

    if ( $isDeleteOne )
        redirect_header("viewtopic.php?topic_id=$topic_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid&amp;forum=$forum", 2, _MD_POSTDELETED);
    else
        redirect_header("viewforum.php?forum=$forum", 2, _MD_POSTSDELETED);
	exit();

} else {
    include XOOPS_ROOT_PATH."/header.php";
    if ( $act == 1 )
    {
    	xoops_confirm(array('post_id' => $post_id, 'viewmode' => $viewmode, 'order' => $order, 'forum' => $forum, 'topic_id' => $topic_id, 'ok' => NEWBB_DELETEONE), 'delete.php', _MD_DEL_ONE);
	}
   	if ( $act == 99 )
   	{
    	xoops_confirm(array('post_id' => $post_id, 'viewmode' => $viewmode, 'order' => $order, 'forum' => $forum, 'topic_id' => $topic_id, 'ok' => NEWBB_DELETEONE), 'delete.php', _MD_DEL_ONE);
    	xoops_confirm(array('post_id' => $post_id, 'viewmode' => $viewmode, 'order' => $order, 'forum' => $forum, 'topic_id' => $topic_id, 'ok' => NEWBB_DELETEALL), 'delete.php', _MD_DEL_RELATED);
    }
}

include XOOPS_ROOT_PATH.'/footer.php';
?>