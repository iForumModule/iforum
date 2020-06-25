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
// Disable cache
$icmsConfig["module_cache"][$icmsModule->getVar("mid")] = 0;
include ICMS_ROOT_PATH."/header.php";
foreach (array('forum', 'topic_id', 'post_id', 'order', 'pid') as $getint)
{
	$ {
		$getint }
	 = isset($_GET[$getint]) ? (int)$_GET[$getint] :
	 0;
}
$viewmode = (isset($_GET['viewmode']) && $_GET['viewmode'] != 'flat') ? 'thread' :
 'flat';
if (empty($forum) )
{
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
}
elseif (empty($post_id) )
{
	redirect_header("viewforum.php?forum=$forum", 2, _MD_ERRORPOST);
	exit();
}
else
{
	$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
	$topic_handler = icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
	$post_handler = icms_getmodulehandler('post', basename(__DIR__), 'iforum' );
	 
	 
	$forumpost = $post_handler->get($post_id);
	$forum_obj = $forum_handler->get($forumpost->getVar("forum_id"));
	if (!$forum_handler->getPermission($forum_obj))
		{
		redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
		exit();
	}
	 
	if (icms::$module->config['wol_enabled'])
		{
		$online_handler = icms_getmodulehandler('online', basename(__DIR__), 'iforum' );
		$online_handler->init($forum_obj);
	}
	$isadmin = iforum_isAdmin($forum_obj);
	$uid = is_object(icms::$user)? icms::$user->getVar('uid'):
	0;
	 
	$topic_status = $topic_handler->get($topic_id, 'topic_status');
	if ($topic_handler->getPermission($forum_obj, $topic_status, 'edit')
		&& ($isadmin || $forumpost->checkIdentity()) )
	{
	}
	else
	{
		redirect_header("viewtopic.php?forum=".$forum_obj->getVar('forum_id')."&amp;topic_id=$topic_id&amp;post_id=$post_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid", 2, _MD_NORIGHTTOEDIT);
		exit();
	}
	if (!$isadmin && !$forumpost->checkTimelimit('edit_timelimit'))
	{
		redirect_header("viewtopic.php?forum=".$forum_obj->getVar('forum_id')."&amp;topic_id=$topic_id&amp;post_id=$post_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid", 2, _MD_TIMEISUP);
		exit();
	}
	$post_id2 = $forumpost->getVar('pid');
	 
	$dohtml = $forumpost->getVar('dohtml');
	$dosmiley = $forumpost->getVar('dosmiley');
	$doxcode = $forumpost->getVar('doxcode');
	$dobr = $forumpost->getVar('dobr');
	$icon = $forumpost->getVar('icon');
	$attachsig = $forumpost->getVar('attachsig');
	$topic_id = $forumpost->getVar('topic_id');
	$istopic = ($forumpost->istopic() )?1:0;
	$isedit = 1;
	$subject_pre = "";
	$subject = $forumpost->getVar('subject', "E");
	$message = $forumpost->getVar('post_text', "E");
	$poster_name = $forumpost->getVar('poster_name', "E");
	$attachments = $forumpost->getAttachment();
	$post_karma = $forumpost->getVar('post_karma');
	$require_reply = $forumpost->getVar('require_reply');
	$hidden = "";
	 
	include 'include/forumform.inc.php';
	if (!$istopic)
	{
		$forumpost2 = $post_handler->get($post_id2);
		 
		$r_message = $forumpost2->getVar('post_text');
		 
		$isadmin = 0;
		if ($forumpost2->getVar('uid'))
		{
			$r_name = iforum_getUnameFromId($forumpost2->getVar('uid'), icms::$module->config['show_realname']);
			if (iforum_isAdmin($forum_obj, $forumpost2->getVar('uid'))) $isadmin = 1;
		}
		else
		{
			$poster_name = $forumpost2->getVar('poster_name');
			$r_name = (empty($poster_name))?$icmsConfig['anonymous']:
			$poster_name;
		}
		$r_date = formatTimestamp($forumpost2->getVar('post_time'));
		$r_subject = $forumpost2->getVar('subject');
		 
		$r_content = _MD_BY." ".$r_name." "._MD_ON." ".$r_date."<br /><br />";
		$r_content .= $r_message;
		$r_subject = $forumpost2->getVar('subject');
		echo "<table cellpadding='4' cellspacing='1' width='98%' class='outer'><tr><td class='head'>".$r_subject."</td></tr>";
		echo "<tr><td><br />".$r_content."<br /></td></tr></table>";
	}
	 
	include ICMS_ROOT_PATH.'/footer.php';
}