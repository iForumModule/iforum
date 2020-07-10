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
 
include("header.php");
 
include_once ICMS_ROOT_PATH."/modules/xoopspoll/include/constants.php";
include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspoll.php";
include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspolloption.php";
include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspolllog.php";
include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspollrenderer.php";
 
if (!empty($_POST['poll_id']) )
{
	$poll_id = (int)$_POST['poll_id'];
}
elseif (!empty($_GET['poll_id']))
{
	$poll_id = (int)$_GET['poll_id'];
}
if (!empty($_POST['topic_id']) )
{
	$topic_id = (int)$_POST['topic_id'];
}
elseif (!empty($_GET['topic_id']))
{
	$topic_id = (int)$_GET['topic_id'];
}
if (!empty($_POST['forum']) )
{
	$forum = (int)$_POST['forum'];
}
elseif (!empty($_GET['forum']))
{
	$forum = (int)$_GET['forum'];
}
 
$topic_handler = icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
$topic_obj = $topic_handler->get($topic_id);
if (!$topic_handler->getPermission($topic_obj->getVar("forum_id"), $topic_obj->getVar('topic_status'), "vote"))
	{
	redirect_header("javascript:history.go(-1);", 2, _NOPERM);
}
 
if (!empty($_POST['option_id']) )
{
	$mail_author = false;
	$poll = new XoopsPoll($poll_id);
	 
	if (is_object(icms::$user) )
	{
		if (XoopsPollLog::hasVoted($poll_id, $_SERVER['REMOTE_ADDR'], icms::$user->getVar("uid")) )
		{
			$msg = _PL_ALREADYVOTED;
			setcookie("bb_polls[$poll_id]", 1);
		}
		else
		{
			$poll->vote($_POST['option_id'], '', icms::$user->getVar("uid"));
			$poll->updateCount();
			$msg = _PL_THANKSFORVOTE;
			setcookie("bb_polls[$poll_id]", 1);
		}
	}
	else
	{
		if (XoopsPollLog::hasVoted($poll_id, $_SERVER['REMOTE_ADDR']) )
		{
			$msg = _PL_ALREADYVOTED;
			setcookie("bb_polls[$poll_id]", 1);
		}
		else
		{
			$poll->vote($_POST['option_id'], $_SERVER['REMOTE_ADDR']);
			$poll->updateCount();
			$msg = _PL_THANKSFORVOTE;
			setcookie("bb_polls[$poll_id]", 1);
		}
	}
	 
	redirect_header("viewtopic.php?topic_id=$topic_id&amp;forum=$forum&amp;poll_id=$poll_id&amp;pollresult=1", 1, $msg);
	exit();
}
redirect_header("viewtopic.php?topic_id=$topic_id&amp;forum=$forum", 1, "You must choose an option !!");