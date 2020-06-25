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
 
include "header.php";
 
if (isset($_POST['submit']) )
{
	foreach (array('forum', 'topic_id', 'newforum', 'newtopic') as $getint)
	{
		$ {
			$getint }
		 = isset($_POST[$getint]) ? intval($_POST[$getint]) :
		 0;
	}
}
else
{
	foreach (array('forum', 'topic_id') as $getint)
	{
		$ {
			$getint }
		 = isset($_GET[$getint]) ? (int)$_GET[$getint] :
		 0;
	}
}
 
if (!$topic_id )
{
	$redirect = empty($forum_id)?"index.php":
	'viewforum.php?forum='.$forum;
	redirect_header($redirect, 2, _MD_ERRORTOPIC);
}
 
$topic_handler = icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
$forum = $topic_handler->get($topic_id, "forum_id");
$forum_new = !empty($newtopic)?$topic_handler->get($newtopic, "forum_id"):
0;
 
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
if (!$forum_handler->getPermission($forum, 'moderate')
	|| (!empty($forum_new) && !$forum_handler->getPermission($forum_new, 'reply')) // The forum for the topic to be merged to
|| (!empty($newforum) && !$forum_handler->getPermission($newforum, 'post')) // The forum to be moved to
)
{
	redirect_header("viewtopic.php?forum=$forum&amp;topic_id=$topic_id", 2, _NOPERM);
	exit();
}
 
if (icms::$module->config['wol_enabled'])
	{
	$online_handler = icms_getmodulehandler('online', basename(__DIR__), 'iforum' );
	$online_handler->init($forum);
}
 
$action_array = array('merge', 'delete', 'move', 'lock', 'unlock', 'sticky', 'unsticky', 'digest', 'undigest');
foreach($action_array as $_action)
{
	$action[$_action] = array(
	"name" => $_action,
		"desc" => constant(strtoupper('_MD_DESC_'.$_action)),
		"submit" => constant(strtoupper("_MD_".$_action)),
		'sql' => 'topic_'.$_action.'=1',
		'msg' => constant(strtoupper("_MD_TOPIC".$_action))
	);
}
$action['lock']['sql'] = 'topic_status = 1';
$action['unlock']['sql'] = 'topic_status = 0';
$action['unsticky']['sql'] = 'topic_sticky = 0';
$action['undigest']['sql'] = 'topic_digest = 0';
$action['digest']['sql'] = 'topic_digest = 1, digest_time = '.time();
 
// Disable cache
$icmsConfig["module_cache"][$icmsModule->getVar("mid")] = 0;
include ICMS_ROOT_PATH.'/header.php';
 
if (isset($_POST['submit']) )
{
	$mode = $_POST['mode'];
	if ('delete' == $mode)
	{
		//$topic_handler = icms_getmodulehandler('topic', basename( dirname( __FILE__ ) ), 'iforum' );
		$topic_handler->delete($topic_id);
		$forum_handler->synchronization($forum);
		//sync($topic_id, "topic");
		//xoops_notification_deletebyitem ($icmsModule->getVar('mid'), 'thread', $topic_id);
		echo $action[$mode]['msg']."<p><a href='viewforum.php?forum=$forum'>"._MD_RETURNTOTHEFORUM."</a></p><p><a href='index.php'>"._MD_RETURNFORUMINDEX."</a></p>";
	}
	elseif('merge' == $mode)
	{
		//$topic_handler = icms_getmodulehandler('topic', basename( dirname( __FILE__ ) ), 'iforum' );
		$post_handler = icms_getmodulehandler('post', basename(__DIR__), 'iforum' );
		 
		$newtopic_obj = $topic_handler->get($newtopic);
		/* return false if destination topic is newer or not existing */
		if ($newtopic > $topic_id || !is_object($newtopic_obj))
		{
			redirect_header("javascript:history.go(-1)", 2, _MD_ERROR);
			exit();
		}
		 
		$criteria_topic = new icms_db_criteria_Item("topic_id", $topic_id);
		$criteria = new icms_db_criteria_Compo($criteria_topic);
		$criteria->add(new icms_db_criteria_Item('pid', 0));
		$post_handler->updateAll("pid", $topic_handler->getTopPostId($newtopic), $criteria, true);
		$post_handler->updateAll("topic_id", $newtopic, $criteria_topic, true);
		 
		$topic_views = $topic_handler->get($topic_id, "topic_views")+$newtopic_obj->getVar("topic_views");
		$criteria_newtopic = new icms_db_criteria_Item("topic_id", $newtopic);
		$topic_handler->updateAll("topic_views", $topic_views, $criteria_newtopic, true);
		 
		$topic_handler->synchronization($newtopic);
		 
		$poll_id = $topic_handler->get($topic_id, "poll_id");
		if ($poll_id > 0)
		{
			if (iforum_poll_module_active())
				{
				include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspoll.php";
				include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspolloption.php";
				include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspolllog.php";
				include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspollrenderer.php";
				 
				$poll = new XoopsPoll($poll_id);
				if ($poll->delete() != false )
				{
					XoopsPollOption::deleteByPollId($poll->getVar("poll_id"));
					XoopsPollLog::deleteByPollId($poll->getVar("poll_id"));
					xoops_comment_delete($icmsModule->getVar('mid'), $poll->getVar('poll_id'));
				}
			}
		}
		 
		$sql = sprintf("DELETE FROM %s WHERE topic_id = %u", icms::$xoopsDB->prefix("bb_topics"), $topic_id);
		$result = icms::$xoopsDB->queryF($sql);
		 
		$sql = sprintf("DELETE FROM %s WHERE topic_id = %u", icms::$xoopsDB->prefix("bb_votedata"), $topic_id);
		$result = icms::$xoopsDB->queryF($sql);
		 
		$sql = sprintf("UPDATE %s SET forum_topics = forum_topics-1 WHERE forum_id = %u", icms::$xoopsDB->prefix("bb_forums"), $forum);
		$result = icms::$xoopsDB->queryF($sql);
		 
		echo $action[$mode]['msg']. "<p><a href='viewtopic.php?topic_id=$newtopic'>"._MD_VIEWTHETOPIC."</a></p>". "<p><a href='viewforum.php?forum=$forum'>"._MD_RETURNTOTHEFORUM."</a></p>". "<p><a href='index.php'>"._MD_RETURNFORUMINDEX."</a></p>";
	}
	elseif('move' == $mode)
	{
		if ($newforum > 0)
		{
			$sql = sprintf("UPDATE %s SET forum_id = %u WHERE topic_id = %u", icms::$xoopsDB->prefix("bb_topics"), $newforum, $topic_id);
			if (!$r = icms::$xoopsDB->query($sql) )
			{
				return false;
			}
			$sql = sprintf("UPDATE %s SET forum_id = %u WHERE topic_id = %u", icms::$xoopsDB->prefix("bb_posts"), $newforum, $topic_id);
			if (!$r = icms::$xoopsDB->query($sql) )
			{
				return false;
			}
			$forum_handler->synchronization($newforum);
			$forum_handler->synchronization($forum);
			echo $action[$mode]['msg']."<p><a href='viewtopic.php?topic_id=$topic_id&amp;forum=$newforum'>"._MD_GOTONEWFORUM."</a></p><p><a href='index.php'>"._MD_RETURNFORUMINDEX."</a></p>";
		}
		else
		{
			redirect_header("javascript:history.go(-1)", 2, _MD_ERRORFORUM);
		}
	}
	else
	{
		$sql = sprintf("UPDATE %s SET ".$action[$mode]['sql']." WHERE topic_id = %u", icms::$xoopsDB->prefix("bb_topics"), $topic_id);
		if (!$r = icms::$xoopsDB->query($sql) )
		{
			redirect_header("viewtopic.php?forum=$forum&amp;topic_id=$topic_id&amp;order=$order&amp;viewmode=$viewmode", 2, _MD_ERROR_BACK.'<br />sql:'.$sql);
			exit();
		}
		echo $action[$mode]['msg']."<p><a href='viewtopic.php?topic_id=$topic_id&amp;forum=$forum'>"._MD_VIEWTHETOPIC."</a></p><p><a href='viewforum.php?forum=".$forum."'>"._MD_RETURNFORUMINDEX."</a></p>";
	}
}
else
{
	// No submit
	$mode = $_GET['mode'];
	echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";
	echo "<table border='0' cellpadding='1' cellspacing='0' align='center' width='95%'>";
	echo "<tr><td class='bg2'>";
	echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'>";
	echo "<tr class='bg3' align='left'>";
	echo "<td colspan='2' align='center'>".$action[$mode]['desc']."</td></tr>";
	 
	if ($mode == 'move' )
	{
		echo '<tr><td class="bg3">'._MD_MOVETOPICTO.'</td><td class="bg1">';
		$box = '<select name="newforum" size="1">';
		 
		$category_handler = icms_getmodulehandler('category', basename(__DIR__), 'iforum' );
		$categories = $category_handler->getAllCats('access', true);
		$forums = $forum_handler->getForumsByCategory(array_keys($categories), 'post', false);
		 
		if (count($categories) > 0 && count($forums) > 0)
		{
			foreach(array_keys($forums) as $key)
			{
				$box .= "<option value='-1'>[".$categories[$key]->getVar('cat_title')."]</option>";
				foreach ($forums[$key] as $forumid => $_forum)
				{
					$box .= "<option value='".$forumid."'>-- ".$_forum['title']."</option>";
					if (!isset($_forum["sub"])) continue;
					foreach (array_keys($_forum["sub"]) as $fid)
					{
						$box .= "<option value='".$fid."'>---- ".$_forum["sub"][$fid]['title']."</option>";
					}
				}
			}
		}
		else
		{
			$box .= "<option value='-1'>"._MD_NOFORUMINDB."</option>";
		}
		unset($forums, $categories);
		 
		echo $box;
		echo '</select></td></tr>';
	}
	if ($mode == 'merge' )
	{
		echo '<tr><td class="bg3">'._MD_MERGETOPICTO.'</td><td class="bg1">';
		echo _MD_TOPIC."ID-$topic_id: <input name='newtopic' value='' />";
		echo '</td></tr>';
	}
	echo '<tr class="bg3"><td colspan="2" align="center">';
	echo "<input type='hidden' name='mode' value='".$action[$mode]['name']."' />";
	echo "<input type='hidden' name='topic_id' value='".$topic_id."' />";
	echo "<input type='hidden' name='forum' value='".$forum."' />";
	echo "<input type='submit' name='submit' value='". $action[$mode]['submit']."' />";
	echo "</td></tr></form></table></td></tr></table>";
}
include ICMS_ROOT_PATH.'/footer.php';