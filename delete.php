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
 
$ok = isset($_POST['ok']) ? intval($_POST['ok']) :
 0;
foreach (array('forum', 'topic_id', 'post_id', 'order', 'pid', 'act') as $getint)
{
	$ {
		$getint }
	 = isset($_POST[$getint]) ? intval($_POST[$getint]) :
	 0;
	 
}
foreach (array('forum', 'topic_id', 'post_id', 'order', 'pid', 'act') as $getint)
{
	$ {
		$getint }
	= ($ {
		$getint }
	)?$ {
		$getint }
	:
	(isset($_GET[$getint]) ? (int)$_GET[$getint] : 0);
}
$viewmode = (isset($_GET['viewmode']) && $_GET['viewmode'] != 'flat') ? 'thread' :
 'flat';
$viewmode = ($viewmode)?$viewmode:
 (isset($_POST['viewmode'])?$_POST['viewmode'] : 'flat');
 
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
$topic_handler = icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
$post_handler = icms_getmodulehandler('post', basename(__DIR__), 'iforum' );
 
if (!empty($post_id) )
{
	$topic = $topic_handler->getByPost($post_id);
}
else
{
	$topic = $topic_handler->get($topic_id);
}
$topic_id = $topic->getVar('topic_id');
if (!$topic_id )
{
	$redirect = empty($forum)?"index.php":
	'viewforum.php?forum='.$forum;
	redirect_header($redirect, 2, _MD_ERRORTOPIC);
	exit();
}
 
$forum = $topic->getVar('forum_id');
$forum_obj = $forum_handler->get($forum);
if (!$forum_handler->getPermission($forum_obj))
	{
	redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
	exit();
}
 
$isadmin = iforum_isAdmin($forum_obj);
$uid = is_object(icms::$user)? icms::$user->getVar('uid'):
0;
 
$forumpost = $post_handler->get($post_id);
$topic_status = $topic->getVar('topic_status');
if ($topic_handler->getPermission($topic->getVar("forum_id"), $topic_status, 'delete')
	&& ($isadmin || $forumpost->checkIdentity() ))
{
}
else
{
	redirect_header("viewtopic.php?topic_id=$topic_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid&amp;forum=$forum", 2, _MD_DELNOTALLOWED);
	exit();
}
 
if (!$isadmin && !$forumpost->checkTimelimit('delete_timelimit'))
	{
	redirect_header("viewtopic.php?forum=$forum&amp;topic_id=$topic_id&amp;post_id=$post_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid", 2, _MD_TIMEISUPDEL);
	exit();
}
 
if (icms::$module->config['wol_enabled'])
	{
	$online_handler = icms_getmodulehandler('online', basename(__DIR__), 'iforum' );
	$online_handler->init($forum_obj);
}
 
if ($ok )
{
	$isDeleteOne = (IFORUM_DELETEONE == $ok)? true :
	 false;
	/*
	if ($forumpost->isTopic() && $topic->getVar("topic_replies")==0) $isDeleteOne=false;
	if ($isDeleteOne && $forumpost->isTopic() && $topic->getVar("topic_replies")>0){
	$post_handler->emptyTopic($forumpost);
	}else{
	*/
	$post_handler->delete($forumpost, $isDeleteOne);
	$forum_handler->synchronization($forum);
	$topic_handler->synchronization($topic_id);
	//}
	 
	if ($isDeleteOne )
		{
		redirect_header("viewtopic.php?topic_id=$topic_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid&amp;forum=$forum", 2, _MD_POSTDELETED);
	}
	else
	{
		redirect_header("viewforum.php?forum=$forum", 2, _MD_POSTSDELETED);
	}
	exit();
	 
}
else
{
	include ICMS_ROOT_PATH."/header.php";
	icms_core_Message::confirm(array('post_id' => $post_id, 'viewmode' => $viewmode, 'order' => $order, 'forum' => $forum, 'topic_id' => $topic_id, 'ok' => IFORUM_DELETEONE), 'delete.php', _MD_DEL_ONE);
	if ($isadmin) {
		icms_core_Message::confirm(array('post_id' => $post_id, 'viewmode' => $viewmode, 'order' => $order, 'forum' => $forum, 'topic_id' => $topic_id, 'ok' => IFORUM_DELETEALL), 'delete.php', _MD_DEL_RELATED);
	}
	include ICMS_ROOT_PATH.'/footer.php';
}