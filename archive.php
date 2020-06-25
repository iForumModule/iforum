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
* The file is not ready yet
* phppp
*/
 
die('Sorry, this feature is not ready yet!<br />');
 
include_once("header.php");
include ICMS_ROOT_PATH."/header.php";
$forum = isset($_GET['forum']) ? (int)$_GET['forum'] :
 0;
$topic_id = isset($_GET['topic_id']) ? (int)$_GET['topic_id'] :
 0;
 
if ($forum == 0)
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
	 
	include_once(ICMS_ROOT_PATH."/header.php");
	 
	echo "<table border='0' width='100%' cellpadding='5'>";
	echo "<tr><td align='left'>".iforum_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='".$forumPath['url']."archive.php'>";
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
	 
	include_once(ICMS_ROOT_PATH."/footer.php");
}
 
function display_archive_forums($cat_id, $parent_forum = 0, $level = 0)
{
	global $db, $myts, $icmsModule, $forumTable;
	 
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
			$name = icms_core_DataFilter::htmlSpecialchars($forum_name);
			for ($i = 0; $i < ($level * 4+4); $i++)
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
	global $db, $myts, $icmsModule, $forumTable, $forumImage;
	 
	include_once(ICMS_ROOT_PATH."/header.php");
	 
	$q = "SELECT * FROM ".$forumTable['forums']." WHERE forum_id=".$forum;
	$result = $db->query($q);
	if (!$result)
	echo $db->error();
	 
	$forumdata = $db->fetch_array($result);
	echo "<table border='0' width='100%' cellpadding='5'>";
	echo "<tr><td align='left'>".iforum_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='".$forumPath['url']."archive.php'>";
	echo _MD_FORUM_ARCHIVE."</a>";
	if ($forumdata['parent_forum'] == 0)
	{
		echo "<br />&nbsp;&nbsp;&nbsp;".iforum_displayImage($forumImage['f_close'])."&nbsp;&nbsp;<strong>".icms_core_DataFilter::htmlSpecialchars($forumdata['forum_name'])."</strong><br />";
	}
	else
	{
		$q = "SELECT forum_name FROM ".$forumTable['forums']." WHERE forum_id=".$forumdata['parent_forum'];
		$row = $db->fetch_array($db->query($q));
		echo "<br />&nbsp;&nbsp;&nbsp;".iforum_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='".$forumPath['url']."archive.php?forum=".$forumdata['parent_forum']."'>".icms_core_DataFilter::htmlSpecialchars($row['forum_name'])."</a>";
		echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".iforum_displayImage($forumImage['f_close'])."&nbsp;&nbsp;<strong>".icms_core_DataFilter::htmlSpecialchars($forumdata['forum_name'])."</strong><br />";
	}
	echo "</td></tr></table><br />";
	 
	echo "<table border='0' width='90%' cellpadding='5' align='center'>";
	echo "<tr><td>";
	$sql = "SELECT * FROM ".$forumTable['topics']." where forum_id=$forum order by topic_last_post_id DESC";
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
	 
	include_once(ICMS_ROOT_PATH."/footer.php");
}
////////////////////////////////////////////////////////////////////
function display_topic($forum, $topic_id, $content_only = 1)
{
	global $db, $myts, $icmsModule, $forumTable, $forumImage, $meta;
	 
	if ($content_only == 0)
	{
		include_once(ICMS_ROOT_PATH."/header.php");
	}
	 
	$q = "SELECT * FROM ".$forumTable['forums']." WHERE forum_id=".$forum;
	$result = $db->query($q);
	$forumdata = $db->fetch_array($result);
	 
	$q = "SELECT * FROM ".$forumTable['topics']." WHERE topic_id=".$topic_id;
	$result = $db->query($q);
	$topicdata = $db->fetch_array($result);
	 
	echo "<table border='0' width='100%' cellpadding='5'>";
	echo "<tr><td align='left'>".iforum_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='".$forumPath['url']."archive.php'>";
	echo _MD_FORUM_ARCHIVE."</a>";
	if ($forumdata['parent_forum'] == 0)
	{
		echo "<br />&nbsp;&nbsp;&nbsp;".iforum_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='archive.php?forum=$forum'>".icms_core_DataFilter::htmlSpecialchars($forumdata['forum_name'])."</a>";
		echo "<br />".iforum_displayImage($forumImage['f_content'])."&nbsp;&nbsp;<strong>".icms_core_DataFilter::htmlSpecialchars($topicdata['topic_title'])."</strong><br />";
	}
	else
	{
		$q = "SELECT forum_name FROM ".$forumTable['forums']." WHERE forum_id=".$forumdata['parent_forum'];
		$row = $db->fetch_array($db->query($q));
		echo "<br />&nbsp;&nbsp;&nbsp;".iforum_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='".$forumPath['url']."archive.php?forum=".$forumdata['parent_forum']."'>".icms_core_DataFilter::htmlSpecialchars($row['forum_name'])."</a>";
		echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".iforum_displayImage($forumImage['f_open'])."&nbsp;&nbsp;<a href='archive.php?forum=$forum'>".icms_core_DataFilter::htmlSpecialchars($forumdata['forum_name'])."</a>";
		echo "<br />&nbsp;&nbsp;&nbsp;".iforum_displayImage($forumImage['f_content'])."&nbsp;&nbsp;<strong>".icms_core_DataFilter::htmlSpecialchars($topicdata['topic_title'])."</strong><br />";
	}
	 
	echo "</td></tr></table><br />";
	 
	// =============== LINK HEADER ===============
	echo "<table border='0' width='640' cellpadding='5' cellspacing='0' bgcolor='#FFFFFF' align=center><tr><td>";
	echo "<h3>"._MD_FORUM." : ".$forumdata['forum_name']."</h3>";
	echo "<h3>"._MD_SUBJECT." : ".$topicdata['topic_title']."</h3>";
	echo "<i><strong>".$meta['copyright']."<br /><a href=".ICMS_URL.">".ICMS_URL."</a>
		<br /><br />"._MD_PRINT_TOPIC_LINK."<br />
		<a href='".ICMS_URL."/modules/".$icmsModule->getVar("dirname")."/viewtopic.php?topic_id=$topic_id&amp;forum=$forum'>".ICMS_URL."/modules/".$icmsModule->getVar("dirname")."/viewtopic.php?topic_id=$topic_id&amp;forum=$forum</a>
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
		if (!($count % 2) )
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
	 
	if ($content_only == 0)
	{
		include_once(ICMS_ROOT_PATH."/footer.php");
	}
}
 
?>