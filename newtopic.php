<?php
// $Id: newtopic.php,v 1.1.1.24 2004/11/14 14:57:31 praedator Exp $
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
foreach (array('forum', 'order') as $getint) {
    ${$getint} = isset($_GET[$getint]) ? intval($_GET[$getint]) : 0;
}
if (isset($_GET['op'])) $op = $_GET['op'];
$viewmode = (isset($_GET['viewmode']) && $_GET['viewmode'] != 'flat') ? 'thread' : 'flat';
if ( empty($forum) ) {
    redirect_header("index.php", 2, _MD_ERRORFORUM);
    exit();
}
    $forum_handler =& xoops_getmodulehandler('forum', 'newbb');
    $forum = $forum_handler->get($forum);
	if (!$forum_handler->getPermission($forum)){
	    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
	    exit();
	}

	$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
	if (!$topic_handler->getPermission($forum, 0, 'post')) {
        redirect_header("viewforum.php?order=$order&amp;viewmode=$viewmode&amp;forum=".$forum->getVar('forum_id'),2,_MD_NORIGHTTOPOST);
	    exit();
	}

	if ($xoopsModuleConfig['wol_enabled']){
		$online_handler =& xoops_getmodulehandler('online', 'newbb');
		$online_handler->init($forum);
	}

    $istopic = 1;
    $pid=0;
    $subject = "";
    $message = "";
    $myts =& MyTextSanitizer::getInstance();
    $hidden = "";
    $subject_pre="";
    $dohtml = 0;
    $dosmiley = 1;
    $doxcode = 1;
    $icon = '';
    $post_karma = 0;
    $require_reply = 0;
    $attachsig = (is_object($xoopsUser) && $xoopsUser->getVar('user_sig')) ? 1 : 0;
    unset($post_id);
    unset($topic_id);


    include XOOPS_ROOT_PATH.'/header.php';
    if ($xoopsModuleConfig['disc_show'] == 1 or $xoopsModuleConfig['disc_show'] == 3 ){
	    echo "<table cellpadding='4' cellspacing='1' width='100%' class='outer'><tr><td class='head' align='center'>"._MD_BOARD_DISCLAIMER."</td></tr>";
		echo "<tr><td><br />".$xoopsModuleConfig['disclaimer']."<br /></td></tr></table>";
    }

    include 'include/forumform.inc.php';
    include XOOPS_ROOT_PATH.'/footer.php';
?>