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
 
include 'header.php';
 
$topic_id = isset($_POST['topic_id']) ? (int)$_POST['topic_id'] :
 0;
$post_id = !empty($_GET['post_id']) ? (int)$_GET['post_id'] :
 0;
$post_id = !empty($_POST['post_id']) ? $_POST['post_id'] :
 $post_id;
$uid = !empty($_POST['uid']) ? $_POST['uid'] :
 0;
$op = !empty($_GET['op']) ? $_GET['op'] :
 (!empty($_POST['op']) ? $_POST['op']:"");
$op = in_array($op, array("approve", "delete", "restore", "split"))? $op :
 "";
$mode = !empty($_GET['mode']) ? (int)$_GET['mode'] :
 1;
 
if (empty($post_id) || empty($op))
{
	redirect_header("javascript:history.go(-1);", 2, _MD_NORIGHTTOACCESS);
	exit();
}
 
$post_handler = icms_getmodulehandler('post', basename(__DIR__), 'iforum' );
$topic_handler = icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
if (empty($topic_id))
{
	$viewtopic_forum = null;
}
else
{
	$forumtopic = $topic_handler->get($topic_id);
	$forum_id = $forumtopic->getVar('forum_id');
	$viewtopic_forum = $forum_handler->get($forum_id);
}
$isadmin = iforum_isAdmin($viewtopic_forum);
 
if (!$isadmin)
{
	redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
	exit();
}
 
switch($op)
{
	case "restore":
	$post_id = array_values($post_id);
	sort($post_id);
	$topics = array();
	$forums = array();
	foreach($post_id as $post)
	{
		$post_obj = $post_handler->get($post);
		if (!empty($topic_id) && $topic_id != $post_obj->getVar("topic_id")) continue;
		$post_handler->approve($post_obj);
		$topics[$post_obj->getVar("topic_id")] = 1;
		$forums[$post_obj->getVar("forum_id")] = 1;
		unset($post_obj);
	}
	foreach(array_keys($topics) as $topic)
	{
		$topic_handler->synchronization($topic);
	}
	foreach(array_keys($forums) as $forum)
	{
		$forum_handler->synchronization($forum);
	}
	break;
	case "approve":
	$post_id = array_values($post_id);
	sort($post_id);
	$topics = array();
	$forums = array();
	$criteria = new icms_db_criteria_Item("post_id", "(".implode(",", $post_id).")", "IN");
	$posts_obj = $post_handler->getObjects($criteria, true);
	foreach($post_id as $post)
	{
		$post_obj = & $posts_obj[$post];
		if (!empty($topic_id) && $topic_id != $post_obj->getVar("topic_id")) continue;
		$post_handler->approve($post_obj);
		$topics[$post_obj->getVar("topic_id")] = $post;
		$forums[$post_obj->getVar("forum_id")] = 1;
	}
	foreach(array_keys($topics) as $topic)
	{
		$topic_handler->synchronization($topic);
	}
	foreach(array_keys($forums) as $forum)
	{
		$forum_handler->synchronization($forum);
	}
	 
	if (empty(icms::$module->config['notification_enabled'])) break;
	 
	$criteria_topic = new icms_db_criteria_Item("topic_id", "(".implode(",", array_keys($topics)).")", "IN");
	$topic_list = $topic_handler->getList($criteria_topic, true);
	 
	$criteria_forum = new icms_db_criteria_Item("forum_id", "(".implode(",", array_keys($forums)).")", "IN");
	$forum_list = $forum_handler->getList($criteria_forum);
	 
	include_once 'include/notification.inc.php';
	$notification_handler = icms::handler('icms_data_notification');
	foreach($post_id as $post)
	{
		$tags = array();
		$tags['THREAD_NAME'] = $topic_list[$posts_obj[$post]->getVar("topic_id")];
		$tags['THREAD_URL'] = ICMS_URL . '/modules/' . $icmsModule->getVar('dirname') . '/viewtopic.php?topic_id=' . $posts_obj[$post]->getVar("topic_id").'&amp;forum=' . $posts_obj[$post]->getVar('forum_id');
		$tags['FORUM_NAME'] = $forum_list[$posts_obj[$post]->getVar('forum_id')];
		$tags['FORUM_URL'] = ICMS_URL . '/modules/' . $icmsModule->getVar('dirname') . '/viewforum.php?forum=' . $posts_obj[$post]->getVar('forum_id');
		$tags['POST_URL'] = $tags['THREAD_URL'].'#forumpost' . $post;
		$notification_handler->triggerEvent('thread', $posts_obj[$post]->getVar("topic_id"), 'new_post', $tags);
		$notification_handler->triggerEvent('forum', $posts_obj[$post]->getVar('forum_id'), 'new_post', $tags);
		$notification_handler->triggerEvent('global', 0, 'new_post', $tags);
		$tags['POST_CONTENT'] = $posts_obj[$post]->getVar("post_text");
		$tags['POST_NAME'] = $posts_obj[$post]->getVar("subject");
		$notification_handler->triggerEvent('global', 0, 'new_fullpost', $tags);
		$notification_handler->triggerEvent('forum', $posts_obj[$post]->getVar('forum_id'), 'new_fullpost', $tags);
	}
	break;
	case "delete":
	$post_id = array_values($post_id);
	rsort($post_id);
	$topics = array();
	$forums = array();
	foreach($post_id as $post)
	{
		$post_obj = $post_handler->get($post);
		if (!empty($topic_id) && $topic_id != $post_obj->getVar("topic_id")) continue;
		$topics[$post_obj->getVar("topic_id")] = 1;
		$forums[$post_obj->getVar("forum_id")] = 1;
		$post_handler->delete($post_obj);
		unset($post_obj);
	}
	foreach(array_keys($topics) as $topic)
	{
		$topic_handler->synchronization($topic);
	}
	foreach(array_keys($forums) as $forum)
	{
		$forum_handler->synchronization($forum);
	}
	break;
	case "split":
	$post_obj = $post_handler->get($post_id);
	if (empty($post_id) || $post_obj->isTopic())
	{
		break;
	}
	$topic_id = $post_obj->getVar("topic_id");
	 
	$newtopic = $topic_handler->create();
	$newtopic->setVar("topic_title", $post_obj->getVar("subject"), true);
	$newtopic->setVar("topic_poster", $post_obj->getVar("uid"), true);
	$newtopic->setVar("forum_id", $post_obj->getVar("forum_id"), true);
	$newtopic->setVar("topic_time", $post_obj->getVar("post_time"), true);
	$newtopic->setVar("poster_name", $post_obj->getVar("poster_name"), true);
	$newtopic->setVar("approved", 1, true);
	$topic_handler->insert($newtopic, true);
	$new_topic_id = $newtopic->getVar('topic_id');
	 
	$pid = $post_obj->getVar("pid");
	 
	$post_obj->setVar("topic_id", $new_topic_id, true);
	$post_obj->setVar("pid", 0, true);
	$post_handler->insert($post_obj);
	 
	/* split a single post */
	if ($mode == 1)
	{
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("topic_id", $topic_id));
		$criteria->add(new icms_db_criteria_Item('pid', $post_id));
		$post_handler->updateAll("pid", $pid, $criteria, true);
		/* split a post and its children posts */
	}
	elseif($mode == 2)
	{
		include_once(ICMS_ROOT_PATH . "/class/xoopstree.php");
		$mytree = new XoopsTree(icms::$xoopsDB->prefix("bb_posts"), "post_id", "pid");
		$posts = $mytree->getAllChildId($post_id);
		if (count($posts) > 0)
		{
			$criteria = new icms_db_criteria_Item('post_id', "(".implode(",", $posts).")", "IN");
			$post_handler->updateAll("topic_id", $new_topic_id, $criteria, true);
		}
		/* split a post and all posts coming after */
	}
	elseif($mode == 3)
	{
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("topic_id", $topic_id));
		$criteria->add(new icms_db_criteria_Item('post_id', $post_id, ">"));
		$post_handler->updateAll("topic_id", $new_topic_id, $criteria, true);
		 
		unset($criteria);
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("topic_id", $new_topic_id));
		$criteria->add(new icms_db_criteria_Item('post_id', $post_id, ">"));
		$post_handler->identifierName = "pid";
		$posts = $post_handler->getList($criteria);
		 
		unset($criteria);
		$post_update = array();
		foreach($posts as $postid => $pid)
		{
			if (!in_array($pid, array_keys($posts)))
			{
				$post_update[] = $pid;
			}
		}
		if (count($post_update))
		{
			$criteria = new icms_db_criteria_Item('post_id', "(".implode(",", $post_update).")", "IN");
			$post_handler->updateAll("pid", $post_id, $criteria, true);
		}
	}
	 
	$forum_id = $post_obj->getVar("forum_id");
	$topic_handler->synchronization($topic_id);
	$topic_handler->synchronization($new_topic_id);
	$sql = sprintf("UPDATE %s SET forum_topics = forum_topics+1 WHERE forum_id = %u", icms::$xoopsDB->prefix("bb_forums"), $forum_id);
	$result = icms::$xoopsDB->queryF($sql);
	 
	break;
}
if (!empty($topic_id))
{
	redirect_header("viewtopic.php?topic_id=$topic_id", 2, _MD_DBUPDATED);
}
elseif(!empty($forum_id))
{
	redirect_header("viewforum.php?forum=$forum_id", 2, _MD_DBUPDATED);
}
else
{
	redirect_header("viewpost.php?uid=$uid", 2, _MD_DBUPDATED);
}
 
include ICMS_ROOT_PATH.'/footer.php';