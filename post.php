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
include_once ICMS_ROOT_PATH . '/modules/' . $icmsModule->getVar("dirname") . '/class/uploader.php';
 
foreach (array(
'forum',
	'topic_id',
	'post_id',
	'order',
	'pid',
	'start',
	'isreply',
	'isedit' ) as $getint)
{
	$ {
		$getint }
	 = isset($_POST[$getint]) ? intval($_POST[$getint]) :
	 0 ;
}
$op = isset($_POST['op']) ? $_POST['op'] :
 '';
$viewmode = (isset($_POST['viewmode']) && $_POST['viewmode'] != 'flat') ? 'thread' :
 'flat';
if (empty($forum) )
{
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
}
 
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
$topic_handler = icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
$post_handler = icms_getmodulehandler('post', basename(__DIR__), 'iforum' );
 
if (!empty($isedit) && $post_id > 0 )
{
	$forumpost = $post_handler->get($post_id);
	$topic_id = $forumpost->getVar("topic_id");
}
else
{
	$forumpost = $post_handler->create();
}
$topic = $topic_handler->get($topic_id);
$forum_id = ($topic_id)?$topic->getVar("forum_id"):
$forum;
$forum_obj = $forum_handler->get($forum_id);
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
 
include ICMS_ROOT_PATH."/header.php";
 
if (!empty($_POST['contents_submit']) )
{
	$token_valid = false;
	if (class_exists("XoopsSecurity"))
	{
		$token_valid = $GLOBALS['xoopsSecurity']->check();
	}
	else
	{
		// backward compatible
		if (!empty($_SESSION['submit_token']) && !empty($_POST['post_valid']) && $_POST['post_valid'] == $_SESSION['submit_token'] ) $token_valid = true;
		$_SESSION['submit_token'] = null;
	}
	 
	$captcha_invalid = false;
	if (!is_object(icms::$user))
	{
		$uname = !isset($_POST['uname']) ? '' :
		 trim($_POST['uname']);
		$pass = !isset($_POST['pass']) ? '' :
		 trim($_POST['pass']);
		$member_handler = icms::handler('icms_member');
		$user = $member_handler->loginUser(addslashes(icms_core_DataFilter::stripSlashesGPC($uname)), addslashes(icms_core_DataFilter::stripSlashesGPC($pass)));
		if (is_object($user) && 0 < $user->getVar('level'))
		{
			if (!empty($_POST["login"]))
			{
				$user->setVar('last_login', time());
				if (!$member_handler->insertUser($user))
				{
				}
				$_SESSION = array();
				$_SESSION['xoopsUserId'] = $user->getVar('uid');
				$_SESSION['xoopsUserGroups'] = $user->getGroups();
				if ($icmsConfig['use_mysession'] && $icmsConfig['session_name'] != '')
				{
					setcookie($icmsConfig['session_name'], session_id(), time()+(60 * $icmsConfig['session_expire']), '/', '', 0);
				}
				$user_theme = $user->getVar('theme');
				if (in_array($user_theme, $icmsConfig['theme_set_allowed']))
				{
					$_SESSION['xoopsUserTheme'] = $user_theme;
				}
			}
			icms::$user = & $user;
		}
	}
	if (!empty(icms::$module->config['captcha_enabled']) && @include_once ICMS_ROOT_PATH."/class/captcha/captcha.php")
	{
		$icmsCaptcha = IcmsCaptcha::instance();
		if (! $icmsCaptcha->verify() )
		{
			$captcha_invalid = true;
			$error_message[] = $icmsCaptcha->getMessage();
		}
	}
	 
	 
	$isadmin = iforum_isAdmin($forum_obj);
	 
	$time_valid = true;
	if (!$isadmin && !empty(icms::$module->config['post_timelimit']) )
	{
		$last_post = iforum_getsession('LP'); // using session might be more secure ...
		if (time()-$last_post < icms::$module->config['post_timelimit'])
		{
			$time_valid = false;
		}
	}
	 
	if ($captcha_invalid || !$token_valid || !$time_valid)
	{
		$_POST['contents_preview'] = 1;
		$_POST['contents_submit'] = null;
		$_POST['contents_upload'] = null;
		if (!$token_valid) echo "<div class=\"errorMsg\">"._MD_INVALID_SUBMIT."</div>";
		if (!$time_valid) echo "<div class=\"errorMsg\">".sprintf(_MD_POSTING_LIMITED, icms::$module->config['post_timelimit'])."</div>";
		echo "<br clear=\"both\" />";
	}
}
 
if (!empty($_POST['contents_submit']) )
{
	$message = $_POST['message'];
	if (empty($message))
	{
		redirect_header("javascript:history.go(-1);", 1);
		exit();
	}
	if (!empty($isedit) && $post_id > 0)
	{
		 
		$uid = is_object(icms::$user)? icms::$user->getVar('uid'):
		0;
		 
		$topic_status = $topic_handler->get($topic_id, 'topic_status');
		if ($topic_handler->getPermission($forum_obj, $topic_status, 'edit')
			&& ($isadmin || ($forumpost->checkTimelimit('edit_timelimit') && $forumpost->checkIdentity() ))
		)
		{
		}
		else
		{
			redirect_header("viewtopic.php?forum=$forum_id&amp;topic_id=$topic_id&amp;post_id=$post_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid", 2, _MD_NORIGHTTOEDIT);
			exit();
		}
		 
		$delete_attach = isset($_POST['delete_attach']) ? $_POST['delete_attach'] :
		 array();
		if (is_array($delete_attach) && count($delete_attach) > 0) $forumpost->deleteAttachment($delete_attach);
		}
	else
	{
		if ($topic_id)
		{
			$topic_status = $topic_handler->get($topic_id, 'topic_status');
			if (!$topic_handler->getPermission($forum_obj, $topic_status, 'reply'))
			{
				redirect_header("viewtopic.php?forum=$forum_id&amp;topic_id=$topic_id&amp;post_id=$post_id&amp;order=$order&amp;viewmode=$viewmode&amp;pid=$pid", 2, _MD_NORIGHTTOREPLY);
				exit();
			}
		}
		else
		{
			$topic_status = 0;
			if (!$topic_handler->getPermission($forum_obj, $topic_status, 'post'))
			{
				redirect_header("viewtopic.php?forum=$forum_id", 2, _MD_NORIGHTTOPOST);
				exit();
			}
		}
		 
		$isreply = 0;
		$isnew = 1;
		if (!is_object(icms::$user) || (!empty($_POST['noname']) && !empty(icms::$module->config['allow_user_anonymous']) ) )
		{
			$uid = 0;
		}
		else
		{
			$uid = icms::$user->getVar("uid");
		}
		if (isset($pid) && $pid != "")
		{
			$forumpost->setVar('pid', $pid);
		}
		if (!empty($topic_id))
		{
			$forumpost->setVar('topic_id', $topic_id);
			$isreply = 1;
		}
		$forumpost->setVar('poster_ip', iforum_getIP());
		$forumpost->setVar('uid', $uid);
		$forumpost->setVar('post_time', time());
	}
	 
	if ($topic_handler->getPermission($forum_obj, $topic_status, 'noapprove')) $approved = 1;
	else $approved = 0;
	$forumpost->setVar('approved', $approved);
	 
	$forumpost->setVar('forum_id', $forum_obj->getVar('forum_id'));
	 
	$subject = xoops_trim($_POST['subject']);
	$subject = ($subject == '') ? _NOTITLE :
	 $subject;
	$poster_name = !empty($_POST['poster_name'])?xoops_trim($_POST['poster_name']):
	'';
	$dohtml = !empty($_POST['dohtml']) ? 1 :
	 0;
	$dosmiley = !empty($_POST['dosmiley']) ? 1 :
	 0;
	$doxcode = !empty($_POST['doxcode']) ? 1 :
	 0;
	$dobr = !empty($_POST['dobr']) ? 1 :
	 0;
	$icon = (!empty($_POST['icon']) && is_file(ICMS_ROOT_PATH . "/images/subject/" . $_POST['icon']) ) ? $_POST['icon'] : '';
	$attachsig = !empty($_POST['attachsig']) ? 1 :
	 0;
	$view_require = !empty($_POST['view_require']) ? $_POST['view_require'] :
	 '';
	$post_karma = (($view_require == 'require_karma') && isset($_POST['post_karma']))?intval($_POST['post_karma']):
	0;
	$require_reply = ($view_require == 'require_reply')?1:
	0;
	$forumpost->setVar('subject', $subject);
	 
	// The text filter is far from complete
	// Let's look for some comprehensive handlers
	if ($dohtml && !iforum_isAdmin($forum_obj) )
	{
		//$message=iforum_textFilter($message);
	}
	$forumpost->setVar('post_text', $message);
	$forumpost->setVar('post_karma', $post_karma);
	$forumpost->setVar('require_reply', $require_reply);
	$forumpost->setVar('poster_name', $poster_name);
	$forumpost->setVar('dohtml', $dohtml);
	$forumpost->setVar('dosmiley', $dosmiley);
	$forumpost->setVar('doxcode', $doxcode);
	$forumpost->setVar('dobr', $dobr);
	$forumpost->setVar('icon', $icon);
	$forumpost->setVar('attachsig', $attachsig);
	$forumpost->setAttachment();
	if (!empty($post_id) ) $forumpost->setPostEdit($poster_name); // is reply
	 
	$attachments_tmp = array();
	if (!empty($_POST["attachments_tmp"]))
		{
		$attachments_tmp = unserialize(base64_decode($_POST["attachments_tmp"]));
		if (isset($_POST["delete_tmp"]) && count($_POST["delete_tmp"]))
			{
			foreach($_POST["delete_tmp"] as $key)
			{
				unlink(XOOPS_CACHE_PATH . "/" . $attachments_tmp[$key][0]);
				unset($attachments_tmp[$key]);
			}
		}
	}
	if (count($attachments_tmp))
		{
		foreach($attachments_tmp as $key => $attach)
		{
			if (rename(XOOPS_CACHE_PATH . "/" . $attachments_tmp[$key][0],
				ICMS_ROOT_PATH . "/".icms::$module->config['dir_attachments']."/".$attachments_tmp[$key][0] ))
			{
				$forumpost->setAttachment($attach[0], $attach[1], $attach[2]);
			}
		}
	}
	 
	$error_upload = '';
	 
	if (isset($_FILES['userfile']['name']) && $_FILES['userfile']['name'] != '' && $topic_handler->getPermission($forum_obj, $topic_status, 'attach')
	)
	{
		$maxfilesize = $forum_obj->getVar('attach_maxkb') * 1024;
		$uploaddir = ICMS_ROOT_PATH . "/". icms::$module->config['dir_attachments'];
		 
		$uploader = new iforum_uploader($uploaddir,	$forum_obj->getVar('attach_ext'), $maxfilesize);
		 
		if ($uploader->fetchMedia($_POST['xoops_upload_file'][0]) )
			{
			$prefix = is_object(icms::$user)?strval(icms::$user->uid()).'_':
			'iforum_';
			$uploader->setPrefix($prefix);
			if (!$uploader->upload() )
				$error_upload = $uploader->getErrors();
			else
				{
				if (is_file($uploader->getSavedDestination() ))
					{
					$forumpost->setAttachment($uploader->getSavedFileName(), $uploader->getMediaName(), $uploader->getMediaType());
				}
			}
		}
		else
		{
			$error_upload = $uploader->getErrors();
		}
	}
	 
	$postid = $post_handler->insert($forumpost);
	if (!$postid )
	{
		include_once(ICMS_ROOT_PATH.'/header.php');
		icms_core_Message::error('Could not insert forum post');
		icms_core_Message::error($forumpost->getErrors());
		include_once(ICMS_ROOT_PATH.'/footer.php');
		exit();
	}
	iforum_setsession("LP", time()); // Recording last post time
	 
	 
	if (iforum_checkSubjectPrefixPermission($forum_obj) && !empty($_POST['subject_pre']))
	{
		$subject_pre = intval($_POST['subject_pre']);
		$sbj_res = $post_handler->insertnewsubject($forumpost->getVar('topic_id'), $subject_pre);
	}
	 
	if (iforum_tag_module_included() && !empty(icms::$module->config['allow_tagging']) && $forumpost->isTopic() && @include_once ICMS_ROOT_PATH."/modules/tag/include/functions.php")
	{
		$topic->setVar("topic_tags", @$_POST["topic_tags"]);
		if ($tag_handler = tag_getTagHandler() )
		{
			$tag_handler->updateByItem(@$_POST["topic_tags"], $forumpost->getVar('topic_id'), $icmsModule->getVar("dirname"), 0);
		}
		$topic_handler->updateAll("topic_tags", @$_POST["topic_tags"], new icms_db_criteria_Item("topic_id", $forumpost->getVar('topic_id')));
		 
		if ($tag_handler = @xoops_getmodulehandler('tag', 'tag', true))
		{
			$tag_handler->updateByItem(@$_POST["topic_tags"], $forumpost->getVar('topic_id'));
		}
		 
	}
	 
	// RMV-NOTIFY
	// Define tags for notification message
	if ($approved && !empty(icms::$module->config['notification_enabled']) && !empty($isnew))
	{
		$tags = array();
		$tags['THREAD_NAME'] = $_POST['subject'];
		$tags['THREAD_URL'] = ICMS_URL . '/modules/' . $icmsModule->getVar("dirname") . '/viewtopic.php?post_id='.$postid.'&amp;topic_id=' . $forumpost->getVar('topic_id').'&amp;forum=' . $forumpost->getVar('forum_id');
		$tags['POST_URL'] = $tags['THREAD_URL'] . '#forumpost' . $postid;
		include_once 'include/notification.inc.php';
		$forum_info = iforum_notify_iteminfo ('forum', $forum_obj->getVar('forum_id'));
		$tags['FORUM_NAME'] = $forum_info['name'];
		$tags['FORUM_URL'] = $forum_info['url'];
		$notification_handler = icms::handler('icms_data_notification');
		if (empty($isreply))
		{
			// Notify of new thread
			$notification_handler->triggerEvent('forum', $forum_obj->getVar('forum_id'), 'new_thread', $tags);
		}
		else
		{
			// Notify of new post
			$notification_handler->triggerEvent('thread', $topic_id, 'new_post', $tags);
		}
		$notification_handler->triggerEvent('global', 0, 'new_post', $tags);
		$notification_handler->triggerEvent('forum', $forum_obj->getVar('forum_id'), 'new_post', $tags);
		$tags['POST_CONTENT'] = icms_core_DataFilter::stripSlashesGPC($_POST['message']);
		$tags['POST_NAME'] = icms_core_DataFilter::stripSlashesGPC($_POST['subject']);
		$notification_handler->triggerEvent('global', 0, 'new_fullpost', $tags);
		$notification_handler->triggerEvent('forum', $forum_obj->getVar('forum_id'), 'new_fullpost', $tags);
	}
	 
	// If user checked notification box, subscribe them to the
	// appropriate event; if unchecked, then unsubscribe
	if (!empty(icms::$user) && !empty(icms::$module->config['notification_enabled']))
	{
		$notification_handler = icms::handler('icms_data_notification');
		if (empty($_POST['notify']))
		{
			$notification_handler->unsubscribe('thread', $forumpost->getVar('topic_id'), 'new_post');
		}
		elseif ($_POST['notify'] > 0)
		{
			$notification_handler->subscribe('thread', $forumpost->getVar('topic_id'), 'new_post');
		}
		// elseif($_POST['notify']<0) keep it as it is
	}
	 
	if ($approved)
	{
		if (!empty(icms::$module->config['cache_enabled']))
		{
			iforum_setsession("t".$forumpost->getVar("topic_id"), null);
		}
		$redirect = "viewtopic.php?topic_id=".$forumpost->getVar('topic_id')."&amp;post_id=".$postid."#forumpost".$postid."";
		$message = _MD_THANKSSUBMIT."<br />".$error_upload;
	}
	else
	{
		$redirect = "viewforum.php?forum=".$forumpost->getVar('forum_id');
		$message = _MD_THANKSSUBMIT."<br />"._MD_WAITFORAPPROVAL."<br />".$error_upload;
	}
	if ($op == "add" )
	{
		redirect_header("polls.php?op=add&amp;forum=".$forumpost->getVar('forum_id')."&amp;topic_id=".$forumpost->getVar('topic_id')."", 1, _MD_ADDPOLL);
		exit();
	}
	else
	{
		redirect_header($redirect, 2, $message);
		exit();
	}
}
 
 
if (!empty($_POST['contents_upload']) )
{
	$attachments_tmp = array();
	if (!empty($_POST["attachments_tmp"]))
		{
		$attachments_tmp = unserialize(base64_decode($_POST["attachments_tmp"]));
		if (isset($_POST["delete_tmp"]) && count($_POST["delete_tmp"]))
			{
			foreach($_POST["delete_tmp"] as $key)
			{
				unlink(XOOPS_CACHE_PATH . $attachments_tmp[$key][0]);
				unset($attachments_tmp[$key]);
			}
		}
		 
	}
	 
	$error_upload = '';
	if (isset($_FILES['userfile']['name']) && $_FILES['userfile']['name'] != '' ) {
		$maxfilesize = $forum_obj->getVar('attach_maxkb') * 1024;
		$uploaddir = XOOPS_CACHE_PATH;
		$allowed_extensions = $forum_obj->getVar('attach_ext');
		$uploader = new iforum_uploader($uploaddir, $allowed_extensions, $maxfilesize);
		 
		if ($uploader->fetchMedia($_POST['xoops_upload_file'][0]) )
			{
			$prefix = is_object(icms::$user)?strval(icms::$user->getVar('uid')).'_':
			'iforum_';
			$uploader->setPrefix($prefix);
			if (!$uploader->upload() )
				$error_upload = $uploader->getErrors();
			else
				{
				if (is_file($uploader->getSavedDestination() ))
					{
					$attachments_tmp[strval(time())] = array(
					$uploader->getSavedFileName(),
						$uploader->getMediaName(),
						$uploader->getMediaType()
					);
				}
			}
		}
		else
		{
			$error_upload = $uploader->getErrors();
		}
	}
}
 
if (!empty($_POST['contents_preview']) || !empty($_GET['contents_preview']) )
{
	if (!empty($_POST["attachments_tmp"]))
		{
		$attachments_tmp = unserialize(base64_decode($_POST["attachments_tmp"]));
	}
	 
	$p_subject = icms_core_DataFilter::htmlSpecialchars(icms_core_DataFilter::stripSlashesGPC($_POST['subject']));
	$dosmiley = empty($_POST['dosmiley']) ? 0 : 1;
	$dohtml = empty($_POST['dohtml']) ? 0 : 1;
	$doxcode = empty($_POST['doxcode']) ? 0 : 1;
	$dobr = empty($_POST['dobr']) ? 0 : 1;
	$p_message = $_POST['message'];
	$p_message = $myts->previewTarea($p_message, $dohtml, $dosmiley, $doxcode, 1, $dobr);
	if ($dohtml && !iforum_isAdmin($forum_obj) )
	{
		//$p_message = iforum_textFilter($p_message);
	}
	 
	echo "<table cellpadding='4' cellspacing='1' width='98%' class='outer'>";
	echo "<tr><td class='head'>".$p_subject."</td></tr>";
	if (isset($_POST['poster_name']))
	{
		$p_poster_name = icms_core_DataFilter::htmlSpecialchars(icms_core_DataFilter::stripSlashesGPC($_POST['poster_name']));
		echo "<tr><td>".$p_poster_name."</td></tr>";
	}
	echo "<tr><td><br />".$p_message."<br /></td></tr></table>";
}
 
if (!empty($_POST['contents_upload']) || !empty($_POST['contents_preview']) || !empty($_GET['contents_preview']) || !empty($_POST['editor']))
	{
	 
	echo "<br />";
	 
	$editor = empty($_POST['editor']) ? "" :
	 $_POST['editor'];
	$dosmiley = empty($_POST['dosmiley']) ? 0 :
	 1;
	$dohtml = empty($_POST['dohtml']) ? 0 :
	 1;
	$doxcode = empty($_POST['doxcode']) ? 0 :
	 1;
	$dobr = empty($_POST['dobr']) ? 0 :
	 1;
	$subject_pre = (isset($_POST['subject_pre']))?$_POST['subject_pre']:
	'';
	$subject = icms_core_DataFilter::htmlSpecialchars(icms_core_DataFilter::stripSlashesGPC($_POST['subject']));
	$message = icms_core_DataFilter::htmlSpecialchars(icms_core_DataFilter::stripSlashesGPC($_POST['message']));
	$poster_name = isset($_POST['poster_name'])?icms_core_DataFilter::htmlSpecialchars(icms_core_DataFilter::stripSlashesGPC($_POST['poster_name'])):
	'';
	$hidden = isset($_POST['hidden'])? icms_core_DataFilter::htmlSpecialchars(icms_core_DataFilter::stripSlashesGPC($_POST['hidden'])):
	'';
	$notify = @intval($_POST['notify']);
	$attachsig = !empty($_POST['attachsig']) ? 1 :
	 0;
	$isreply = !empty($_POST['isreply']) ? 1 :
	 0;
	$isedit = !empty($_POST['isedit']) ? 1 :
	 0;
	$icon = (!empty($_POST['icon']) && is_file(ICMS_ROOT_PATH . "/images/subject/" . $_POST['icon']) ) ? $_POST['icon'] : '';
	$view_require = isset($_POST['view_require']) ? $_POST['view_require'] :
	 '';
	$post_karma = (($view_require == 'require_karma') && isset($_POST['post_karma']) )? intval($_POST['post_karma']) : 0 ;
	$require_reply = ($view_require == 'require_reply')?1:
	0;
	 
	if (empty($_POST['contents_upload'])) $contents_preview = 1;
	$attachments = $forumpost->getAttachment();
	include 'include/forumform.inc.php';
}
 
include ICMS_ROOT_PATH.'/footer.php';