<?php
// $Id: print.php,v 1.1.1.14 2004/11/16 04:35:25 phppp Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
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

include 'header.php';
$form = isset($_GET['form']) ? intval($_GET['form']) : 0;
$forum = isset($_GET['forum']) ? intval($_GET['forum']) : 0;
$topic_id = isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;
$post_id = !empty($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;
if (isset($_GET['order']) && ($_GET['order'] == 'ASC' || $_GET['order'] == 'DESC')) {
    $order = $_GET['order'];
}

if ( !$topic_id && !$post_id ) die(_MD_ERRORTOPIC);

$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
if ( isset($post_id) && $post_id != "" ) {
    $forumtopic =& $topic_handler->getByPost($post_id);
} else {
    $forumtopic =& $topic_handler->get($topic_id);
}
if(!$forumtopic->getVar('approved'))   die(_MD_NORIGHTTOVIEW);

$forum = ($forum)?$forum:$forumtopic->getVar('forum_id');

$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
$viewtopic_forum =& $forum_handler->get($forum);
if (!$forum_handler->getPermission($viewtopic_forum)) die(_MD_NORIGHTTOACCESS);
if (!$topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "view"))  die(_MD_NORIGHTTOVIEW);
if ( empty($forum) ) die(_MD_ERRORFORUM);
if ( empty($topic_id) ) die(_MD_ERRORTOPIC);
if (!$topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "view"))   die(_MD_NORIGHTTOACCESS);

function PrintPage($topic_id, $forum_id, $start=0, $order = '')
{
	global $xoopsConfig, $xoopsModuleConfig, $forumtopic;

	echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n";
    echo "<html>\n<head>\n";
    echo "<title>" . $xoopsConfig['sitename'] . "</title>\n";
    echo "<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n";
    echo "<meta name='AUTHOR' content='" . $xoopsConfig['sitename'] . "' />\n";
    echo "<meta name='COPYRIGHT' content='Copyright (c) ".date('Y')." by " . $xoopsConfig['sitename'] . "' />\n";
    echo "<meta name='DESCRIPTION' content='" . $xoopsConfig['slogan'] . "' />\n";
    echo "<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n\n\n";
    echo "<body bgcolor='#ffffff' text='#000000' onload='window.print()'>
	 	  <div style='width: 750px; border: 1px solid #000; padding: 20px;'>
	 	  <div style='text-align: center; display: block; margin: 0 0 6px 0;'>
		  <img src='" . XOOPS_URL . "/modules/newbb/images/xoopsbb_slogo.png' border='0' alt='' />
		  <br />
		  <br />
		  ";

	$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
    $postsArray = $topic_handler->getAllPosts($forumtopic, $order, $xoopsModuleConfig['posts_per_page'], $start);
	$post_handler =& xoops_getmodulehandler('post', 'newbb');
    foreach ($postsArray as $post) {
		if(!$post->getVar('approved'))    continue;
		$post_data = $post_handler->getPostForPrint($post);
		echo "<h2 style='margin: 0;'>".$post_data['subject']."</h2>
 	          <div align='center'>" ._POSTEDBY. "&nbsp;".$post_data['author']."&nbsp;"._ON."&nbsp;".$post_data['date']."</div>
		      <div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'></div>
		      <div style='text-align: left'>".$post_data['text']."</div>
		      <div style='padding-top: 12px; border-top: 2px solid #ccc;'></div><br />";
    }
	echo "<p>"._MD_COMEFROM . "&nbsp;".XOOPS_URL."/newbb/viewtopic.php?forum=".$forum_id."&amp;topic_id=".$topic_id."</p>";
	echo "</div></div>";
	echo "</body></html>";
}

function PrintPost($post_id, $topic_id, $forum_id)
{
	global $xoopsConfig;

	$post_handler =& xoops_getmodulehandler('post', 'newbb');
	$post = & $post_handler->get($post_id);
	if(!$approved = $post->getVar('approved'))    die(_MD_NORIGHTTOVIEW);
	$post_data = $post_handler->getPostForPrint($post);

	echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n";
    echo "<html>\n<head>\n";
    echo "<title>" . $xoopsConfig['sitename'] . "</title>\n";
    echo "<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n";
    echo "<meta name='AUTHOR' content='" . $xoopsConfig['sitename'] . "' />\n";
    echo "<meta name='COPYRIGHT' content='Copyright (c) ".date('Y')." by " . $xoopsConfig['sitename'] . "' />\n";
    echo "<meta name='DESCRIPTION' content='" . $xoopsConfig['slogan'] . "' />\n";
    echo "<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n\n\n";
    echo "<body bgcolor='#ffffff' text='#000000' onload='window.print()'>
 		  <div style='width: 750px; border: 1px solid #000; padding: 20px;'>
 		  <div style='text-align: center; display: block; margin: 0 0 6px 0;'>
	      <img src='" . XOOPS_URL . "/modules/newbb/images/xoopsbb_slogo.png' border='0' alt='' />
	      <h2 style='margin: 0;'>".$post_data['subject']."</h2></div>
 	      <div align='center'>" ._POSTEDBY. "&nbsp;".$post_data['author']."&nbsp;"._ON."&nbsp;".$post_data['date']."</div>
		  <div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'></div>
		   	<div style='text-align: left'>".$post_data['text']."</div>
			<div style='padding-top: 12px; border-top: 2px solid #ccc;'></div>
			<p>"._MD_COMEFROM . "&nbsp;".XOOPS_URL."/newbb/viewtopic.php?forum=".$forum_id."&amp;topic_id=".$topic_id."&amp;post_id=".$post_id."</p>
		    </div>
            <br />";
	echo "<br /></body></html>";
}

if ($form == 1){
	PrintPage($topic_id, $forum, $start, $order);
}
if ($form == 2){
	PrintPost($post_id, $topic_id, $forum);
}
?>