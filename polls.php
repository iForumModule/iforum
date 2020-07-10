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
 
include_once("header.php");
 
include ICMS_ROOT_PATH."/modules/xoopspoll/include/constants.php";
include_once ICMS_ROOT_PATH."/class/xoopsblock.php";
include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspoll.php";
include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspolloption.php";
include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspolllog.php";
include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspollrenderer.php";
 
$op = "add";
if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];
if (isset($_GET['poll_id'])) $poll_id = (int)$_GET['poll_id'];
	if (isset($_POST['poll_id'])) $poll_id = (int)$_POST['poll_id'];
	if (isset($_GET['topic_id'])) $topic_id = (int)$_GET['topic_id'];
	if (isset($_POST['topic_id'])) $topic_id = (int)$_POST['topic_id'];
	 
if (!isset($module_handler)) $module_handler = icms::handler('icms_module');
$xoopspoll = $module_handler->getByDirname('xoopspoll');
if (!is_object($xoopspoll) || !$xoopspoll->getVar('isactive'))
{
	redirect_header("javascript:history.go(-1);", 2, _MD_POLLMODULE_ERROR);
	exit();
}
 
include ICMS_ROOT_PATH."/header.php";
 
$topic_handler = icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
$forumtopic = $topic_handler->get($topic_id);
$forum = $forumtopic->getVar('forum_id');
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
$viewtopic_forum = $forum_handler->get($forum);
if (!$forum_handler->getPermission($viewtopic_forum))
{
	redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
	exit();
}
if (!$topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "view"))
{
	redirect_header("viewforum.php?forum=".$viewtopic_forum->getVar('forum_id'), 2, _MD_NORIGHTTOVIEW);
	exit();
}
 
$isadmin = iforum_isAdmin($viewtopic_forum);
$perm = false;
if ($isadmin)
{
	$perm = true;
}
elseif ($topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "addpoll")
&& $viewtopic_forum->getVar('allow_polls') == 1 )
{
	if (($op == "add" || $op == "save") && !$forumtopic->getVar("topic_haspoll") && is_object(icms::$user) && icms::$user->getVar("uid") == $forumtopic->getVar("topic_poster")
	)
	{
		$perm = true;
	}
	elseif(!empty($poll_id))
	{
		$poll = new XoopsPoll($poll_id);
		if (is_object(icms::$user) && icms::$user->getVar("uid") == $poll->getVar("user_id")) $perm = true;
	}
}
if (!$perm)
{
	redirect_header("viewtopic.php?topic_id=".$topic_id, 2, _MD_NORIGHTTOACCESS);
}
 
if ($op == "add" )
{
	$poll_form = new icms_form_Theme(_MD_POLL_CREATNEWPOLL, "poll_form", "polls.php");
	 
	$question_text = new icms_form_elements_Text(_MD_POLL_POLLQUESTION, "question", 50, 255);
	$poll_form->addElement($question_text, true);
	 
	$desc_tarea = new icms_form_elements_Textarea(_MD_POLL_POLLDESC, "description");
	$poll_form->addElement($desc_tarea);
	 
	$currenttime = formatTimestamp(time(), "Y-m-d H:i:s");
	$endtime = formatTimestamp(time()+604800, "Y-m-d H:i:s");
	$expire_text = new icms_form_elements_Text(_MD_POLL_EXPIRATION."<br /><small>"._MD_POLL_FORMAT."<br />".sprintf(_MD_POLL_CURRENTTIME, $currenttime)."</small>", "end_time", 30, 19, $endtime);
	$poll_form->addElement($expire_text);
	 
	$weight_text = new icms_form_elements_Text(_MD_POLL_DISPLAYORDER, "weight", 6, 5, 0);
	$poll_form->addElement($weight_text);
	 
	$multi_yn = new icms_form_elements_Radioyn(_MD_POLL_ALLOWMULTI, "multiple", 0);
	$poll_form->addElement($multi_yn);
	 
	$notify_yn = new icms_form_elements_Radioyn(_MD_POLL_NOTIFY, "notify", 1);
	$poll_form->addElement($notify_yn);
	 
	$option_tray = new icms_form_elements_Tray(_MD_POLL_POLLOPTIONS, "");
	$barcolor_array = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH."/modules/xoopspoll/images/colorbars/", "", array('gif', 'jpg', 'png'));
	for($i = 0; $i < 10; $i++)
	{
		$current_bar = (current($barcolor_array) != "blank.gif") ? current($barcolor_array) :
		 next($barcolor_array);
		$option_text = new icms_form_elements_Text("", "option_text[]", 50, 255);
		$option_tray->addElement($option_text);
		$color_select = new icms_form_elements_Select("", "option_color[".$i."]", $current_bar);
		$color_select->addOptionArray($barcolor_array);
		$color_select->setExtra("onchange='showImgSelected(\"option_color_image[".$i."]\", \"option_color[".$i."]\", \"modules/xoopspoll/images/colorbars\", \"\", \"".ICMS_URL."\")'");
		$color_label = new icms_form_elements_Label("", "<img src='".ICMS_URL."/modules/xoopspoll/images/colorbars/".$current_bar."' name='option_color_image[".$i."]' id='option_color_image[".$i."]' width='30' align='bottom' height='15' alt='' /><br />");
		$option_tray->addElement($color_select);
		$option_tray->addElement($color_label);
		if (!next($barcolor_array) )
		{
			reset($barcolor_array);
		}
		unset($color_select, $color_label);
	}
	$poll_form->addElement($option_tray);
	 
	$submit_button = new icms_form_elements_Button("", "poll_submit", _SUBMIT, "submit");
	$poll_form->addElement($submit_button);
	$op_hidden = new icms_form_elements_Hidden("op", "save");
	$poll_form->addElement($op_hidden);
	$poll_topic_id_hidden = new icms_form_elements_Hidden("topic_id", $topic_id);
	$poll_form->addElement($poll_topic_id_hidden);
	//include ICMS_ROOT_PATH."/header.php";
	echo "<h4>"._MD_POLL_POLLCONF."</h4>";
	$poll_form->display();
	//include ICMS_ROOT_PATH."/footer.php";
	//exit();
}
 
if ($op == "save" )
{
	/*
	* The option check should be done before submitting
	*/
	$option_empty = true;
	if (empty($_POST['option_text']))
	{
		redirect_header("javascript:history.go(-1);", 2, _MD_ERROROCCURED.': '._MD_POLL_POLLOPTIONS.' !');
	}
	$option_text = $_POST['option_text'];
	foreach ($option_text as $optxt )
	{
		if (trim($optxt) != "" )
		{
			$option_empty = false;
			break;
		}
	}
	if ($option_empty) redirect_header("javascript:history.go(-1);", 2, _MD_ERROROCCURED.': '._MD_POLL_POLLOPTIONS.' !');
	 
	$poll = new XoopsPoll();
	//$question = (empty($_POST['question']))?"":$_POST['question'];
	$poll->setVar("question", @$_POST['question']);
	//$description = (empty($_POST['description']))?"":$_POST['description'];
	$poll->setVar("description", @$_POST['description']);
	if (!empty($_POST['end_time']) )
	{
		$timezone = is_object(icms::$user)? icms::$user->timezone() :
		 null;
		$poll->setVar("end_time", userTimeToServerTime(strtotime($_POST['end_time']), $timezone));
	}
	else
	{
		// if expiration date is not set, set it to 10 days from now
		$poll->setVar("end_time", time() + (86400 * 10));
	}
	$poll->setVar("display", 0);
	//$weight = (empty($_POST['weight']))?"":$_POST['weight'];
	$poll->setVar("weight", intval(@$_POST['weight']));
	//$weight = (empty($_POST['multiple']))?"":$_POST['multiple'];
	$poll->setVar("multiple", intval(@$_POST['multiple']));
	if (!empty($_POST["notify"]) )
	{
		// if notify, set mail status to "not mailed"
		$poll->setVar("mail_status", POLL_NOTMAILED);
	}
	else
	{
		// if not notify, set mail status to already "mailed"
		$poll->setVar("mail_status", POLL_MAILED);
	}
	$uid = is_object(icms::$user)?icms::$user->getVar("uid"):
	0;
	$poll->setVar("user_id", $uid);
	$new_poll_id = $poll->store();
	$option_color = (empty($_POST['option_color']))?NULL:
	$_POST['option_color'];
	if (!empty($new_poll_id) )
	{
		$i = 0;
		foreach ($option_text as $optxt )
		{
			$optxt = trim($optxt);
			if ($optxt != "" )
			{
				$option = new XoopsPollOption();
				$option->setVar("option_text", $optxt);
				$option->setVar("option_color", $option_color[$i]);
				$option->setVar("poll_id", $new_poll_id);
				$option->store();
			}
			$i++;
		}
		$sql = "UPDATE ".icms::$xoopsDB->prefix("bb_topics")." SET topic_haspoll = 1, poll_id = $new_poll_id WHERE topic_id = $topic_id";
		if (!$result = icms::$xoopsDB->query($sql) )
		{
			iforum_message("poll adding to topic error: ".$sql);
		}
		include_once ICMS_ROOT_PATH.'/class/template.php';
		xoops_template_clear_module_cache($icmsModule->getVar('mid'));
	}
	else
	{
		iforum_message($poll->getHtmlErrors());
		//exit();
	}
	redirect_header("viewtopic.php?topic_id=$topic_id", 1, _MD_POLL_DBUPDATED);
	//exit();
}
 
if ($op == "edit" )
{
	$poll = new XoopsPoll($_GET['poll_id']);
	$poll_form = new icms_form_Theme(_MD_POLL_EDITPOLL, "poll_form", "polls.php");
	$author_label = new icms_form_elements_Label(_MD_POLL_AUTHOR, "<a href='".ICMS_URL."/userinfo.php?uid=".$poll->getVar("user_id")."'>".iforum_getUnameFromId($poll->getVar("user_id"), icms::$module->config['show_realname'])."</a>");
	$poll_form->addElement($author_label);
	$question_text = new icms_form_elements_Text(_MD_POLL_POLLQUESTION, "question", 50, 255, $poll->getVar("question", "E"));
	$poll_form->addElement($question_text);
	$desc_tarea = new icms_form_elements_Textarea(_MD_POLL_POLLDESC, "description", $poll->getVar("description", "E"));
	$poll_form->addElement($desc_tarea);
	$date = formatTimestamp($poll->getVar("end_time"), "Y-m-d H:i:s");
	if (!$poll->hasExpired() )
	{
		$expire_text = new icms_form_elements_Text(_MD_POLL_EXPIRATION."<br /><small>"._MD_POLL_FORMAT."<br />".sprintf(_MD_POLL_CURRENTTIME, formatTimestamp(time(), "Y-m-d H:i:s"))."</small>", "end_time", 20, 19, $date);
		$poll_form->addElement($expire_text);
	}
	else
	{
		$restart_label = new icms_form_elements_Label(_MD_POLL_EXPIRATION, sprintf(_MD_POLL_EXPIREDAT, $date)."<br /><a href='polls.php?op=restart&amp;poll_id=".$poll->getVar("poll_id")."'>"._MD_POLL_RESTART."</a>");
		$poll_form->addElement($restart_label);
	}
	$weight_text = new icms_form_elements_Text(_MD_POLL_DISPLAYORDER, "weight", 6, 5, $poll->getVar("weight"));
	$poll_form->addElement($weight_text);
	$multi_yn = new icms_form_elements_Radioyn(_MD_POLL_ALLOWMULTI, "multiple", $poll->getVar("multiple"));
	$poll_form->addElement($multi_yn);
	$options_arr = XoopsPollOption::getAllByPollId($poll->getVar("poll_id"));
	$notify_value = 1;
	if ($poll->getVar("mail_status") != 0 )
	{
		$notify_value = 0;
	}
	$notify_yn = new icms_form_elements_Radioyn(_MD_POLL_NOTIFY, "notify", $notify_value);
	$poll_form->addElement($notify_yn);
	$option_tray = new icms_form_elements_Tray(_MD_POLL_POLLOPTIONS, "");
	$barcolor_array = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH."/modules/xoopspoll/images/colorbars/", "", array('gif', 'jpg', 'png'));
	$i = 0;
	foreach($options_arr as $option)
	{
		$option_text = new icms_form_elements_Text("", "option_text[]", 50, 255, $option->getVar("option_text"));
		$option_tray->addElement($option_text);
		$option_id_hidden = new icms_form_elements_Hidden("option_id[]", $option->getVar("option_id"));
		$option_tray->addElement($option_id_hidden);
		$color_select = new icms_form_elements_Select("", "option_color[".$i."]", $option->getVar("option_color"));
		$color_select->addOptionArray($barcolor_array);
		$color_select->setExtra("onchange='showImgSelected(\"option_color_image[".$i."]\", \"option_color[".$i."]\", \"modules/xoopspoll/images/colorbars\", \"\", \"".ICMS_URL."\")'");
		$color_label = new icms_form_elements_Label("", "<img src='".ICMS_URL."/modules/xoopspoll/images/colorbars/".$option->getVar("option_color", "E")."' name='option_color_image[".$i."]' id='option_color_image[".$i."]' width='30' align='bottom' height='15' alt='' /><br />");
		$option_tray->addElement($color_select);
		$option_tray->addElement($color_label);
		unset($color_select, $color_label, $option_id_hidden, $option_text);
		$i++;
	}
	$more_label = new icms_form_elements_Label("", "<br /><a href='polls.php?op=addmore&amp;poll_id=".$poll->getVar("poll_id")."&amp;topic_id=".$topic_id."'>"._MD_POLL_ADDMORE."</a>");
	$option_tray->addElement($more_label);
	$poll_form->addElement($option_tray);
	$op_hidden = new icms_form_elements_Hidden("op", "update");
	$poll_form->addElement($op_hidden);
	$poll_topic_id_hidden = new icms_form_elements_Hidden("topic_id", $topic_id);
	$poll_form->addElement($poll_topic_id_hidden);
	$poll_id_hidden = new icms_form_elements_Hidden("poll_id", $poll->getVar("poll_id"));
	$poll_form->addElement($poll_id_hidden);
	$submit_button = new icms_form_elements_Button("", "poll_submit", _SUBMIT, "submit");
	$poll_form->addElement($submit_button);
	//include ICMS_ROOT_PATH."/header.php";
	echo "<h4>"._MD_POLL_POLLCONF."</h4>";
	$poll_form->display();
	//include ICMS_ROOT_PATH."/footer.php";
	//exit();
}
 
if ($op == "update" )
{
	$option_empty = true;
	if (empty($_POST['option_text']))
	{
		redirect_header("javascript:history.go(-1);", 2, _MD_ERROROCCURED.': '._MD_POLL_POLLOPTIONS.' !');
	}
	$option_text = $_POST['option_text'];
	foreach ($option_text as $optxt )
	{
		if (trim($optxt) != "" )
		{
			$option_empty = false;
			break;
		}
	}
	if ($option_empty) redirect_header("javascript:history.go(-1);", 2, _MD_ERROROCCURED.': '._MD_POLL_POLLOPTIONS.' !');
	 
	$poll = new XoopsPoll($poll_id);
	//$question = (empty($_POST['question']))?"":$_POST['question'];
	$poll->setVar("question", @$_POST['question']);
	//$description = (empty($_POST['description']))?"":$_POST['description'];
	$poll->setVar("description", @$_POST['description']);
	$end_time = (empty($_POST['end_time']))?"":
	$_POST['end_time'];
	if (!empty($end_time) )
	{
		$timezone = is_object(icms::$user)? icms::$user->timezone() :
		 null;
		$poll->setVar("end_time", userTimeToServerTime(strtotime($end_time), $timezone));
	}
	$poll->setVar("display", 0);
	//$weight = (empty($_POST['weight']))?"":$_POST['weight'];
	$poll->setVar("weight", intval(@$_POST['weight']));
	//$multiple = (empty($_POST['multiple']))?"":$_POST['multiple'];
	$poll->setVar("multiple", intval(@$_POST['multiple']));
	if (!empty($_POST["notify"]) && $end_time > time() )
	{
		// if notify, set mail status to "not mailed"
		$poll->setVar("mail_status", POLL_NOTMAILED);
	}
	else
	{
		// if not notify, set mail status to already "mailed"
		$poll->setVar("mail_status", POLL_MAILED);
	}
	if (!$poll->store() )
	{
		iforum_message($poll->getHtmlErrors());
		exit();
	}
	$i = 0;
	$option_id = (empty($_POST['option_id']))?NULL:
	$_POST['option_id'];
	$option_color = (empty($_POST['option_color']))?NULL:
	$_POST['option_color'];
	foreach ($option_id as $opid )
	{
		$option = new XoopsPollOption($opid);
		$option_text[$i] = trim ($option_text[$i]);
		if ($option_text[$i] != "" )
		{
			$option->setVar("option_text", $option_text[$i]);
			$option->setVar("option_color", $option_color[$i]);
			$option->store();
		}
		else
		{
			if ($option->delete() != false )
			{
				XoopsPollLog::deleteByOptionId($option->getVar("option_id"));
			}
		}
		$i++;
	}
	$poll->updateCount();
	include_once ICMS_ROOT_PATH.'/class/template.php';
	xoops_template_clear_module_cache($icmsModule->getVar('mid'));
	redirect_header("viewtopic.php?topic_id=$topic_id", 1, _MD_POLL_DBUPDATED);
	//exit();
}
 
if ($op == "addmore" )
{
	$poll = new XoopsPoll($_GET['poll_id']);
	$poll_form = new icms_form_Theme(_MD_POLL_ADDMORE, "poll_form", "polls.php");
	$question_label = new icms_form_elements_Label(_MD_POLL_POLLQUESTION, $poll->getVar("question"));
	$poll_form->addElement($question_label);
	$option_tray = new icms_form_elements_Tray(_MD_POLL_POLLOPTIONS, "");
	$barcolor_array = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH."/modules/xoopspoll/images/colorbars/", "", array('gif', 'jpg', 'png'));
	for($i = 0; $i < 10; $i++)
	{
		$current_bar = (current($barcolor_array) != "blank.gif") ? current($barcolor_array) :
		 next($barcolor_array);
		$option_text = new icms_form_elements_Text("", "option_text[]", 50, 255);
		$option_tray->addElement($option_text);
		$color_select = new icms_form_elements_Select("", "option_color[".$i."]", $current_bar);
		$color_select->addOptionArray($barcolor_array);
		$color_select->setExtra("onchange='showImgSelected(\"option_color_image[".$i."]\", \"option_color[".$i."]\", \"modules/xoopspoll/images/colorbars\", \"\", \"".ICMS_URL."\")'");
		$color_label = new icms_form_elements_Label("", "<img src='".ICMS_URL."/modules/xoopspoll/images/colorbars/".$current_bar."' name='option_color_image[".$i."]' id='option_color_image[".$i."]' width='30' align='bottom' height='15' alt='' /><br />");
		$option_tray->addElement($color_select);
		$option_tray->addElement($color_label);
		unset($color_select, $color_label, $option_text);
		if (!next($barcolor_array) )
		{
			reset($barcolor_array);
		}
	}
	$poll_form->addElement($option_tray);
	$submit_button = new icms_form_elements_Button("", "poll_submit", _SUBMIT, "submit");
	$poll_form->addElement($submit_button);
	$op_hidden = new icms_form_elements_Hidden("op", "savemore");
	$poll_form->addElement($op_hidden);
	$poll_topic_id_hidden = new icms_form_elements_Hidden("topic_id", $topic_id);
	$poll_form->addElement($poll_topic_id_hidden);
	$poll_id_hidden = new icms_form_elements_Hidden("poll_id", $poll->getVar("poll_id"));
	$poll_form->addElement($poll_id_hidden);
	//include ICMS_ROOT_PATH."/header.php";
	echo "<h4>"._MD_POLL_POLLCONF."</h4>";
	$poll_form->display();
	//include ICMS_ROOT_PATH."/footer.php";
	//exit();
}
 
if ($op == "savemore" )
{
	$option_empty = true;
	if (empty($_POST['option_text']))
	{
		redirect_header("javascript:history.go(-1);", 2, _MD_ERROROCCURED.': '._MD_POLL_POLLOPTIONS.' !');
	}
	$option_text = $_POST['option_text'];
	foreach ($option_text as $optxt )
	{
		if (trim($optxt) != "" )
		{
			$option_empty = false;
			break;
		}
	}
	if ($option_empty) redirect_header("javascript:history.go(-1);", 2, _MD_ERROROCCURED.': '._MD_POLL_POLLOPTIONS.' !');
	 
	$poll = new XoopsPoll($poll_id);
	$i = 0;
	$option_color = (empty($_POST['option_color']))?NULL:
	$_POST['option_color'];
	foreach ($option_text as $optxt )
	{
		$optxt = trim($optxt);
		if ($optxt != "" )
		{
			$option = new XoopsPollOption();
			$option->setVar("option_text", $optxt);
			$option->setVar("poll_id", $poll->getVar("poll_id"));
			$option->setVar("option_color", $option_color[$i]);
			$option->store();
		}
		$i++;
	}
	include_once ICMS_ROOT_PATH.'/class/template.php';
	xoops_template_clear_module_cache($icmsModule->getVar('mid'));
	redirect_header("polls.php?op=edit&amp;poll_id=".$poll->getVar("poll_id")."&amp;topic_id=".$topic_id, 1, _MD_POLL_DBUPDATED);
	//exit();
}
 
if ($op == "delete" )
{
	//include ICMS_ROOT_PATH."/header.php";
	echo "<h4>"._MD_POLL_POLLCONF."</h4>";
	$poll = new XoopsPoll($_GET['poll_id']);
	xoops_confirm(array('op' => 'delete_ok', 'topic_id' => $topic_id, 'poll_id' => $poll->getVar('poll_id')), 'polls.php', sprintf(_MD_POLL_RUSUREDEL, $poll->getVar("question")));
	//include ICMS_ROOT_PATH."/footer.php";
	//exit();
}
 
if ($op == "delete_ok" )
{
	$poll = new XoopsPoll($poll_id);
	if ($poll->delete() != false )
	{
		XoopsPollOption::deleteByPollId($poll->getVar("poll_id"));
		XoopsPollLog::deleteByPollId($poll->getVar("poll_id"));
		include_once ICMS_ROOT_PATH.'/class/template.php';
		xoops_template_clear_module_cache($icmsModule->getVar('mid'));
		// delete comments for this poll
		xoops_comment_delete($icmsModule->getVar('mid'), $poll->getVar('poll_id'));
		$sql = "UPDATE ".icms::$xoopsDB->prefix("bb_topics")." SET votes = 0, topic_haspoll = 0, poll_id = 0 WHERE topic_id = $topic_id";
		if (!$result = icms::$xoopsDB->query($sql) )
		{
			iforum_message("poll removal from topic error: ".$sql);
		}
	}
	redirect_header("viewtopic.php?topic_id=$topic_id", 1, _MD_POLL_DBUPDATED);
	//exit();
}
 
if ($op == "restart" )
{
	$poll = new XoopsPoll($_GET['poll_id']);
	$poll_form = new icms_form_Theme(_MD_POLL_RESTARTPOLL, "poll_form", "polls.php");
	$expire_text = new icms_form_elements_Text(_MD_POLL_EXPIRATION."<br /><small>"._MD_POLL_FORMAT."<br />".sprintf(_MD_POLL_CURRENTTIME, formatTimestamp(time(), "Y-m-d H:i:s"))."</small>", "end_time", 20, 19, formatTimestamp(time()+604800, "Y-m-d H:i:s"));
	$poll_form->addElement($expire_text);
	$notify_yn = new icms_form_elements_Radioyn(_MD_POLL_NOTIFY, "notify", 1);
	$poll_form->addElement($notify_yn);
	$reset_yn = new icms_form_elements_Radioyn(_MD_POLL_RESET, "reset", 0);
	$poll_form->addElement($reset_yn);
	$op_hidden = new icms_form_elements_Hidden("op", "restart_ok");
	$poll_form->addElement($op_hidden);
	$poll_topic_id_hidden = new icms_form_elements_Hidden("topic_id", $topic_id);
	$poll_form->addElement($poll_topic_id_hidden);
	$poll_id_hidden = new icms_form_elements_Hidden("poll_id", $poll->getVar("poll_id"));
	$poll_form->addElement($poll_id_hidden);
	$submit_button = new icms_form_elements_Button("", "poll_submit", _MD_POLL_RESTART, "submit");
	$poll_form->addElement($submit_button);
	//include ICMS_ROOT_PATH."/header.php";
	echo "<h4>"._MD_POLL_POLLCONF."</h4>";
	$poll_form->display();
	//include ICMS_ROOT_PATH."/footer.php";
	//exit();
}
 
if ($op == "restart_ok" )
{
	$poll = new XoopsPoll($poll_id);
	$end_time = (empty($_POST['end_time']))?"":
	$_POST['end_time'];
	if (!empty($end_time) )
	{
		$timezone = is_object(icms::$user)? icms::$user->timezone() :
		 null;
		$poll->setVar("end_time", userTimeToServerTime(strtotime($end_time), $timezone));
	}
	else
	{
		$poll->setVar("end_time", time() + (86400 * 10));
	}
	if (!empty($_POST["notify"]) && $end_time > time() )
	{
		// if notify, set mail status to "not mailed"
		$poll->setVar("mail_status", POLL_NOTMAILED);
	}
	else
	{
		// if not notify, set mail status to already "mailed"
		$poll->setVar("mail_status", POLL_MAILED);
	}
	if (!empty($_POST["reset"]) )
	{
		// reset all logs
		XoopsPollLog::deleteByPollId($poll->getVar("poll_id"));
		XoopsPollOption::resetCountByPollId($poll->getVar("poll_id"));
	}
	if (!$poll->store())
	{
		iforum_message($poll->getHtmlErrors());
		exit();
	}
	$poll->updateCount();
	include_once ICMS_ROOT_PATH.'/class/template.php';
	xoops_template_clear_module_cache($icmsModule->getVar('mid'));
	redirect_header("viewtopic.php?topic_id=$topic_id", 1, _MD_POLL_DBUPDATED);
	//exit();
}
 
if ($op == "log" )
{
	//include ICMS_ROOT_PATH."/header.php";
	echo "<h4>"._MD_POLL_POLLCONF."</h4>";
	echo "<br />View Log<br /> Sorry, not yet. ;-)";
	//include ICMS_ROOT_PATH."/footer.php";
	//exit();
}
 
include ICMS_ROOT_PATH."/footer.php";