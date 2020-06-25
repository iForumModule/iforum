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
 
/*
* Print contents of a post or a topic
* currently only available for post print
*
* TODO: topic print; print with page splitting
*
*/
 
error_reporting(0);
include 'header.php';
error_reporting(0);
 
if (empty($_POST["post_data"]))
{
	 
	$forum = isset($_GET['forum']) ? (int)$_GET['forum'] :
	 0;
	$topic_id = isset($_GET['topic_id']) ? (int)$_GET['topic_id'] :
	 0;
	$post_id = !empty($_GET['post_id']) ? (int)$_GET['post_id'] :
	 0;
	 
	if (empty($post_id) && empty($topic_id) )
		{
		die(_MD_ERRORTOPIC);
	}
	 
	if (!empty($post_id))
	{
		$post_handler = icms_getmodulehandler('post', basename(__DIR__), 'iforum' );
		$post = $post_handler->get($post_id);
		if (!$approved = $post->getVar('approved'))
		{
			die(_MD_NORIGHTTOVIEW);
		}
		$topic_id = $post->getVar("topic_id");
		$post_data = $post_handler->getPostForPrint($post);
		$isPost = 1;
		$post_data["url"] = ICMS_URL."/".basename(__DIR__)."/viewtopic.php?topic_id=".$post->getVar("topic_id")."&amp;post_id=".$post_id;
	}
	 
	$topic_handler = icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
	$forumtopic = $topic_handler->get($topic_id);
	$topic_id = $forumtopic->getVar('topic_id');
	$forum = $forumtopic->getVar('forum_id');
	if (!$approved = $forumtopic->getVar('approved'))
	{
		die(_MD_NORIGHTTOVIEW);
	}
	 
	$isadmin = iforum_isAdmin($viewtopic_forum);
	if (!$isadmin && $forumtopic->getVar('approved') < 0 )
	{
		die(_MD_NORIGHTTOVIEW);
	}
	 
	$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
	$forum = $forumtopic->getVar('forum_id');
	$viewtopic_forum = $forum_handler->get($forum);
	if (!$forum_handler->getPermission($viewtopic_forum))
		{
		die(_MD_NORIGHTTOVIEW);
	}
	 
	if (!$topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "view"))
		{
		die(_MD_NORIGHTTOVIEW);
	}
	 
}
else
{
	$post_data = unserialize(base64_decode($_POST["post_data"]));
	$isPost = 1;
}
 
header('Content-Type: text/html; charset='._CHARSET);
 
if (empty($isPost))
{
	 
	echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n";
	echo "<html>\n<head>\n";
	echo "<title>" . htmlspecialchars($icmsConfig['sitename']) . "</title>\n";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n";
	echo "<meta name='AUTHOR' content='" . htmlspecialchars($icmsConfig['sitename'], ENT_QUOTES) . "' />\n";
	echo "<meta name='COPYRIGHT' content='Copyright (c) ".date('Y')." by " . htmlspecialchars($icmsConfig['sitename'], ENT_QUOTES) . "' />\n";
	echo "<meta name='DESCRIPTION' content='" . htmlspecialchars($icmsConfig['slogan'], ENT_QUOTES) . "' />\n";
	echo "<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n\n\n";
	echo "<body bgcolor='#ffffff' text='#000000' onload='window.print()'>
		<div style='width: 750px; border: 1px solid #000; padding: 20px;'>
		<div style='text-align: center; display: block; margin: 0 0 6px 0;'>
		<img src='" . ICMS_URL . "/modules/".basename(__DIR__)."/images/xoopsbb_slogo.png' border='0' alt='' />
		<br />
		<br />
		";
	 
	$postsArray = $topic_handler->getAllPosts($forumtopic);
	foreach ($postsArray as $post)
	{
		if (!$post->getVar('approved')) continue;
		$post_data = $post_handler->getPostForPrint($post);
		echo "<h2 style='margin: 0;'>".$post_data['subject']."</h2>
			<div align='center'>" ._POSTEDBY. "&nbsp;".$post_data['author']."&nbsp;"._ON."&nbsp;".$post_data['date']."</div>
			<div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'></div>
			<div style='text-align: left'>".$post_data['text']."</div>
			<div style='padding-top: 12px; border-top: 2px solid #ccc;'></div><br />";
	}
	echo "<p>"._MD_COMEFROM . "&nbsp;".ICMS_URL."/".basename(__DIR__)."/viewtopic.php?forum=".$forum_id."&amp;topic_id=".$topic_id."</p>";
	echo "</div></div>";
	echo "</body></html>";
	 
}
else
{
	 
	echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n";
	echo "<html>\n<head>\n";
	echo "<title>" . htmlspecialchars($icmsConfig['sitename']) . "</title>\n";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n";
	echo "<meta name='AUTHOR' content='" . htmlspecialchars($icmsConfig['sitename'], ENT_QUOTES) . "' />\n";
	echo "<meta name='COPYRIGHT' content='Copyright (c) ".date('Y')." by " . htmlspecialchars($icmsConfig['sitename'], ENT_QUOTES) . "' />\n";
	echo "<meta name='DESCRIPTION' content='" . htmlspecialchars($icmsConfig['slogan'], ENT_QUOTES) . "' />\n";
	echo "<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n\n\n";
	echo "</head>\n\n\n";
	echo "<body bgcolor='#ffffff' text='#000000' onload='window.print()'>
		<div style='width: 750px; border: 1px solid #000; padding: 20px;'>
		<div style='text-align: center; display: block; margin: 0 0 6px 0;'>
		<img src='" . ICMS_URL . "/modules/".basename(__DIR__)."/images/xoopsbb_slogo.png' border='0' alt='' />
		<h2 style='margin: 0;'>".$post_data['subject']."</h2></div>
		<div align='center'>" ._POSTEDBY. "&nbsp;".$post_data['author']."&nbsp;"._ON."&nbsp;".$post_data['date']."</div>
		<div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'></div>
		<div style='text-align: left'>".$post_data['text']."</div>
		<div style='padding-top: 12px; border-top: 2px solid #ccc;'></div>
		<p>"._MD_COMEFROM . "&nbsp;".$post_data["url"]."</p>
		</div>
		<br />";
	echo "<br /></body></html>";
}