<?php
// $Id: archive.php,v 1.3 2005/10/19 17:20:28 phppp Exp $
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

/*
 * The file is not ready yet
 * phppp
 */

include_once("header.php");
include XOOPS_ROOT_PATH."/header.php";
$forum = isset($_GET['forum']) ? intval($_GET['forum']) : 0;
$topic_id = isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;

if($forum == 0)
{
	display_archive();
}

if ($forum > 0 && $topic_id == 0)
{
	/*$permissions = get_forum_auth($forum);
	if ($permissions['can_view'] == 0)
	{
		redirect_header('archive.php',2,_MD_NORIGHTTOACCESS);
		die();
	}*/

	display_forum_topics($forum);
}

if ($forum > 0 && $topic_id > 0)
{
	/*
	$permissions = get_forum_auth($forum);
	if ($permissions['can_view'] == 0)
	{
		redirect_header('archive.php',2,_MD_NORIGHTTOACCESS);
		die();
	}
	*/
	display_topic($forum, $topic_id, $content_only);
}


////////////////////////////////////////////////////////////////////
function display_archive()
{
	global $db, $forumTable, $forumImage;

	include_once(XOOPS_ROOT_PATH."/header.php");

	echo "<table border='0' width='100%' cellpadding='5'>";
	echo "<tr><td align='left'>".newbb_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='".$forumPath['url']."archive.php'>";
	echo _MD_FORUM_ARCHIVE."</a>";
	echo "</td></tr></table><br />";

	echo "<table border='0' width='90%' cellpadding='5' align=center>";
	echo "<tr><td>";
	$sql = "SELECT * FROM ".$forumTable['categories'];
	$result = $db->query($sql);
	while ($row = $db->fetch_object($result))
	{
		echo "<h3>".$row->cat_title."</h3>";
		display_archive_forums($row->cat_id);
	}
	echo "</td></tr></table>";

	include_once(XOOPS_ROOT_PATH."/footer.php");
}

function display_archive_forums($cat_id, $parent_forum = 0, $level=0)
{
	global $db, $myts, $xoopsUser, $xoopsModule, $forumTable;

	$sql = "SELECT forum_id, forum_name FROM ".$forumTable['forums']." WHERE cat_id ='$cat_id' AND parent_forum=$parent_forum ORDER BY forum_id";
	if ($res = $db->query($sql))
	{
		while (list($forum_id, $forum_name) = $db->fetch_row($res))
		{
			$permissions = get_forum_auth($forum_id);
			if ($permissions['can_view'] == 0)
			{
				continue;
			}
			$name = $myts->htmlSpecialChars($forum_name);
			for ($i = 0; $i<($level*4+4); $i++)
				echo "&nbsp;";
			echo "<a href='archive.php?forum=$forum_id'><b>$name</b></a><br />";
			$newlevel = $level+1;
			display_archive_forums($cat_id, $forum_id, $newlevel);
		}
	}

}
////////////////////////////////////////////////////////////////////
function display_forum_topics($forum)
{
	global $db, $myts, $xoopsUser, $xoopsModule, $forumTable, $forumImage;

	include_once(XOOPS_ROOT_PATH."/header.php");

	$q = "select * from ".$forumTable['forums']." WHERE forum_id=".$forum;
	$result = $db->query($q);
	if(!$result)
		echo $db->error();

	$forumdata = $db->fetch_array($result);
	echo "<table border='0' width='100%' cellpadding='5'>";
	echo "<tr><td align='left'>".newbb_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='".$forumPath['url']."archive.php'>";
	echo _MD_FORUM_ARCHIVE."</a>";
	if($forumdata['parent_forum'] == 0)
	{
		echo "<br />&nbsp;&nbsp;&nbsp;".newbb_displayImage($forumImage['f_close'])."&nbsp;&nbsp;<strong>".$myts->htmlSpecialChars($forumdata['forum_name'])."</strong><br />";
	}
	else
	{
		$q = "select forum_name from ".$forumTable['forums']." WHERE forum_id=".$forumdata['parent_forum'];
		$row = $db->fetch_array($db->query($q));
		echo "<br />&nbsp;&nbsp;&nbsp;".newbb_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='".$forumPath['url']."archive.php?forum=".$forumdata['parent_forum']."'>".$myts->htmlSpecialChars($row['forum_name'])."</a>";
		echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".newbb_displayImage($forumImage['f_close'])."&nbsp;&nbsp;<strong>".$myts->htmlSpecialChars($forumdata['forum_name'])."</strong><br />";
	}
	echo "</td></tr></table><br />";

	echo "<table border='0' width='90%' cellpadding='5' align='center'>";
	echo "<tr><td>";
	$sql = "select * from ".$forumTable['topics']." where forum_id=$forum order by topic_last_post_id DESC";
	$result = $db->query($sql);
	$counter = 1;
	while ($row = $db->fetch_object($result))
	{
		echo "$counter.&nbsp;";
		echo "<a href='archive.php?forum=$forum&amp;topic_id=".$row->topic_id."'>".$row->topic_title."</a>";
		echo "&nbsp;&nbsp;&nbsp;<a href='archive.php?forum=$forum&amp;topic_id=".$row->topic_id."&amp;content_only=1' target='_blank'>"._MD_ARCHIVE_POPUP."</a>";
		echo "<br />";

		$counter++;
	}
	echo "</td></tr></table>";

	include_once(XOOPS_ROOT_PATH."/footer.php");
}
////////////////////////////////////////////////////////////////////
function display_topic($forum, $topic_id, $content_only = 1)
{
	global $db, $myts, $xoopsUser, $xoopsModule, $forumTable, $forumImage, $meta;

	if($content_only==0)
	{
		include_once(XOOPS_ROOT_PATH."/header.php");
	}

	$q = "select * from ".$forumTable['forums']." WHERE forum_id=".$forum;
	$result = $db->query($q);
	$forumdata = $db->fetch_array($result);

	$q = "select * from ".$forumTable['topics']." WHERE topic_id=".$topic_id;
	$result = $db->query($q);
	$topicdata = $db->fetch_array($result);

	echo "<table border='0' width='100%' cellpadding='5'>";
	echo "<tr><td align='left'>".newbb_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='".$forumPath['url']."archive.php'>";
	echo _MD_FORUM_ARCHIVE."</a>";
	if($forumdata['parent_forum'] == 0)
	{
		echo "<br />&nbsp;&nbsp;&nbsp;".newbb_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='archive.php?forum=$forum'>".$myts->htmlSpecialChars($forumdata['forum_name'])."</a>";
		echo "<br />".newbb_displayImage($forumImage['f_content'])."&nbsp;&nbsp;<strong>".$myts->htmlSpecialChars($topicdata['topic_title'])."</strong><br />";
	}
	else
	{
		$q = "select forum_name from ".$forumTable['forums']." WHERE forum_id=".$forumdata['parent_forum'];
		$row = $db->fetch_array($db->query($q));
		echo "<br />&nbsp;&nbsp;&nbsp;".newbb_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='".$forumPath['url']."archive.php?forum=".$forumdata['parent_forum']."'>".$myts->htmlSpecialChars($row['forum_name'])."</a>";
		echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".newbb_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='archive.php?forum=$forum'>".$myts->htmlSpecialChars($forumdata['forum_name'])."</a>";
		echo "<br />&nbsp;&nbsp;&nbsp;".newbb_displayImage($forumImage['f_content'])."&nbsp;&nbsp;<strong>".$myts->htmlSpecialChars($topicdata['topic_title'])."</strong><br />";
	}

	echo "</td></tr></table><br />";

// =============== LINK HEADER ===============
echo "<table border='0' width='640' cellpadding='5' cellspacing='0' bgcolor='#FFFFFF' align=center><tr><td>";
echo "<h3>"._MD_FORUM." : ".$forumdata['forum_name']."</h3>";
echo "<h3>"._MD_SUBJECT." : ".$topicdata['topic_title']."</h3>";
echo "<i><strong>".$meta['copyright']."<br /><a href=".XOOPS_URL.">".XOOPS_URL."</a>
<br /><br />"._MD_PRINT_TOPIC_LINK."<br />
<a href='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/viewtopic.php?topic_id=$topic_id&amp;forum=$forum'>".XOOPS_URL."/modules/".$xoopsModule->dirname()."/viewtopic.php?topic_id=$topic_id&amp;forum=$forum</a>
</strong></i><br /><br />";
// ============= END LINK HEADER =============

	$forumpost = new ForumPosts();
	$forumpost->setOrder("post_time ASC");
	$forumpost->setTopicId($topic_id);
	$forumpost->setParent(0);

	$postsArray = $forumpost->getAllPosts();
	$count = 0;
	echo "<table border='0' width='100%' cellpadding='5' cellspacing='0' bgcolor='#FFFFFF'><tr><td>";
	foreach ($postsArray as $obj)
	{
		if ( !($count % 2) )
		{
			$row_color = 1;
		}
		else
		{
			$row_color = 2;
		}
		echo "<tr><td>";
		$forumpost->setType($obj->type);
		$obj->showPostForPrint($order);
		$count++;
		echo "</td></tr>";
	}
	echo "</table>";
	echo "</td></tr></table>";

	if($content_only==0)
	{
		include_once(XOOPS_ROOT_PATH."/footer.php");
	}
}

?>