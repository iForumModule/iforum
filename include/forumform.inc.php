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
 
if (!defined('ICMS_ROOT_PATH'))
{
	exit();
}
 
if (empty($forum_obj))
{
	$forum_handler = icms_getmodulehandler('forum', basename(dirname(__DIR__) ), 'iforum' );
	$forum = isset($_GET['forum']) ? (int)$_GET['forum'] :
	 (isset($forum) ? (int)$forum : 0);
	$forum_obj = $forum_handler->get($forum);
}
 
foreach (array(
'start',
	'topic_id',
	'post_id',
	'pid',
	'isreply',
	'isedit',
	'contents_preview' ) as $getint)
{
	$ {
		$getint }
	 = isset($_GET[$getint]) ? (int)$_GET[$getint] :
	((!empty($ {
		$getint }
	))?$ {
		$getint }
	:0 );
}
foreach (array(
'order',
	'viewmode',
	'hidden',
	'iforum_form',
	'icon',
	'op' ) as $getstr)
{
	$ {
		$getstr }
	 = isset($_GET[$getstr]) ? $_GET[$getstr] :
	((!empty($ {
		$getstr }
	))? $ {
		$getstr }
	: '' );
}
 
 
$topic_handler = icms_getmodulehandler('topic', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
$topic_status = $topic_handler->get(@$topic_id, 'topic_status');
 
$forum_form_action = (empty($admin_form_action))?"post.php":
$admin_form_action; // admin/index.php also uses this form
$forum_form = new icms_form_Theme('', 'forumform', $forum_form_action, 'post', true);
$forum_form->setExtra('enctype="multipart/form-data"');
 
if (iforum_checkSubjectPrefixPermission($forum))
{
	if ($forum_obj->getVar('allow_subject_prefix'))
	{
		$subject_add = new icms_form_elements_Tray(_MD_TOPIC_SUBJECTC, '');
		$subjectpres = explode(',', icms::$module->config['subject_prefix']);
		$subjectpres = array_map('trim', $subjectpres);
		if (count($subjectpres) > 1)
		{
			foreach($subjectpres as $subjectpre)
			{
				$subject_array[] = trim($subjectpre);
			}
			$subject_select = new icms_form_elements_Select('', 'subject_pre', $subject_pre);
			$subject_select->addOptionArray($subject_array);
			$subject_add->addElement(new icms_form_elements_Label($subject_select->render()));
		}
		$forum_form->addElement($subject_add);
	}
}
$subject_form = new icms_form_elements_Text(_MD_SUBJECTC, 'subject', 60, 100, $subject);
$subject_form->setExtra("tabindex='1'");
$forum_form->addElement($subject_form, true);
 
if (!is_object(icms::$user) && empty($admin_form_action))
{
	$required = !empty(icms::$module->config["require_name"]);
	$forum_form->addElement(new icms_form_elements_Text(_MD_NAMEMAIL, 'poster_name', 60, 255, (!empty($isedit) && !empty($poster_name))?$poster_name:''), $required);
}
 
$icons_radio = new icms_form_elements_Radio(_MD_MESSAGEICON, 'icon', $icon);
$subject_icons = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . "/images/subject/", '', array('gif', 'jpg', 'png'));
foreach ($subject_icons as $iconfile)
{
	$icons_radio->addOption($iconfile, '<img style="vertical-align:middle;" src="'.ICMS_URL.'/images/subject/'.$iconfile.'" alt="" />');
}
$forum_form->addElement($icons_radio);
 
$nohtml = ($forum_obj->getVar('allow_html'))?false:
true;
 
if (!empty($editor))
{
	iforum_setcookie("editor", $editor);
}
elseif(!$editor = iforum_getcookie("editor"))
{
	//$editor = iforum_getcookie("editor");
	if (is_object(icms::$user))
	{
		$editor = @ icms::$user->getVar("editor"); // Need set through user profile
	}
	if (empty($editor))
	{
		$editor = @ icms::$module->config["editor_default"];
	}
}
$icmsConfig = icms::$config->getConfigsByCat(ICMS_CONF);
$icms_allowed_editors = str_replace('default', $icmsConfig["editor_default"], $icmsConfig["editor_enabled_list"]);

// The user should not select an editor, the admin has to manage
// WYSIWYG editors will not display within this list
//if ($icms_allowed_editors != array ('')) {
//	include_once ICMS_ROOT_PATH . "/modules/" . basename(dirname(dirname(__FILE__))) . "/class/compat/class/xoopsform/formselecteditor.php";
//	$forum_form->addElement(new IforumFormSelectEditor($forum_form, "editor", $editor, $nohtml, $icms_allowed_editors));
//}
$editor_configs = array();
$editor_configs["name"] = "message";
$editor_configs["value"] = $message;
$editor_configs["rows"] = empty(icms::$module->config["editor_rows"])? 35 :
 icms::$module->config["editor_rows"];
$editor_configs["cols"] = empty(icms::$module->config["editor_cols"])? 60 :
 icms::$module->config["editor_cols"];
$editor_configs["width"] = empty(icms::$module->config["editor_width"])? "100%" :
 icms::$module->config["editor_width"];
$editor_configs["height"] = empty(icms::$module->config["editor_height"])? "400px" :
 icms::$module->config["editor_height"];
include_once ICMS_ROOT_PATH . "/modules/" . basename(dirname(dirname(__FILE__))) . "/class/compat/class/xoopsform/formeditor.php";
$forum_form->addElement(new IforumFormEditor(_MD_MESSAGEC, $editor, $editor_configs, $nohtml, $onfailure = null));
 
if (iforum_tag_module_included() && !empty(icms::$module->config['allow_tagging']) && (empty($topic_id) || $forumpost->isTopic()))
{
	$topic_tags = "";
	if (!empty($topic_id))
	{
		$topic_tags = $topic_handler->get($topic_id, 'topic_tags');
	}
	elseif (!empty($_POST["topic_tags"]))
	{
		$topic_tags = icms_core_DataFilter::htmlSpecialchars($myts->stripSlashesGPC($_POST["topic_tags"]));
	}
	if (@include_once ICMS_ROOT_PATH."/modules/tag/include/formtag.php")
	{
		$forum_form->addElement(new XoopsFormTag("topic_tags", 60, 255, $topic_tags));
	}
}
 
$options_tray = new icms_form_elements_Tray(_MD_OPTIONS, '<br />');
if (is_object(icms::$user) && icms::$module->config['allow_user_anonymous'] == 1)
{
	$noname = (!empty($isedit) && is_object($forumpost) && $forumpost->getVar('uid') == 0) ? 1 :
	 0;
	$noname_checkbox = new icms_form_elements_Checkbox('', 'noname', $noname);
	$noname_checkbox->addOption(1, _MD_POSTANONLY);
	$options_tray->addElement($noname_checkbox);
}
$groups = (is_object(icms::$user)) ? icms::$user->getGroups() : ICMS_GROUP_ANONYMOUS;
$gperm_handler = icms::handler('icms_member_groupperm');
if ($editor != 'dhtmltextarea' && $forum_obj->getVar('allow_html'))
{
	$html_checkbox = new icms_form_elements_Checkbox('', 'dohtml', 1);
	$html_checkbox->addOption(1, _MD_DOHTML);
	$options_tray->addElement($html_checkbox);
	$forum_form->addElement(new icms_form_elements_Hidden('dobr', 0));
}
else
{
	$forum_form->addElement(new icms_form_elements_Hidden('dohtml', 0));
	$br_checkbox = new icms_form_elements_Checkbox('', 'dobr', $dobr);
	$br_checkbox->addOption(1, _MD_DOBR);
	$options_tray->addElement($br_checkbox);
}
 
$smiley_checkbox = new icms_form_elements_Checkbox('', 'dosmiley', $dosmiley);
$smiley_checkbox->addOption(1, _MD_DOSMILEY);
$options_tray->addElement($smiley_checkbox);
 
$xcode_checkbox = new icms_form_elements_Checkbox('', 'doxcode', $doxcode);
$xcode_checkbox->addOption(1, _MD_DOXCODE);
$options_tray->addElement($xcode_checkbox);
 
 
if ($forum_obj->getVar('allow_sig') && is_object(icms::$user))
{
	$attachsig_checkbox = new icms_form_elements_Checkbox('', 'attachsig', $attachsig);
	$attachsig_checkbox->addOption(1, _MD_ATTACHSIG);
	$options_tray->addElement($attachsig_checkbox);
}
 
if (empty($admin_form_action) && is_object(icms::$user) && icms::$module->config['notification_enabled'])
{
	if (!empty($notify))
	{
		// If 'notify' set, use that value (e.g. preview or upload)
		//$notify = 1;
	}
	else
	{
		// Otherwise, check previous subscribed status...
		$notification_handler = icms::handler('icms_data_notification');
		if (!empty($topic_id) && $notification_handler->isSubscribed('thread', $topic_id, 'new_post', $icmsModule->getVar('mid'), icms::$user->getVar('uid')))
		{
			$notify = 1;
		}
		else
		{
			$notify = 0;
		}
	}
	 
	$notify_checkbox = new icms_form_elements_Checkbox('', 'notify', $notify);
	$notify_checkbox->addOption(1, _MD_NEWPOSTNOTIFY);
	$options_tray->addElement($notify_checkbox);
}
$forum_form->addElement($options_tray);
 
if ($topic_handler->getPermission($forum_obj, $topic_status, 'attach'))
{
	$upload_tray = new icms_form_elements_Tray(_MD_ATTACHMENT);
	$upload_tray->addElement(new icms_form_elements_File('', 'userfile', ''));
	$upload_tray->addElement(new icms_form_elements_Button('', 'contents_upload', _MD_UPLOAD, "submit"));
	$upload_tray->addElement(new icms_form_elements_Label("<BR /><BR />"._MD_MAX_FILESIZE.":", $forum_obj->getVar('attach_maxkb')."K; "));
	$extensions = trim(str_replace('|', ' ', $forum_obj->getVar('attach_ext')));
	$extensions = (empty($extensions) || $extensions == "*")?_ALL:
	$extensions;
	$upload_tray->addElement(new icms_form_elements_Label(_MD_ALLOWED_EXTENSIONS.":", $extensions));
	$forum_form->addElement($upload_tray);
}
 
if (!empty($attachments) && is_array($attachments) && count($attachments))
	{
	$delete_attach_checkbox = new icms_form_elements_Checkbox(_MD_THIS_FILE_WAS_ATTACHED_TO_THIS_POST, 'delete_attach[]');
	foreach($attachments as $key => $attachment)
	{
		$attach = _DELETE.' <a href='.ICMS_URL.'/'.icms::$module->config['dir_attachments'].'/'.$attachment['name_saved'].' targe="_blank" >'.$attachment['name_display'].'</a>';
		$delete_attach_checkbox->addOption($key, $attach);
	}
	$forum_form->addElement($delete_attach_checkbox);
	unset($delete_attach_checkbox);
}
 
if (!empty($attachments_tmp) && is_array($attachments_tmp) && count($attachments_tmp))
	{
	$delete_attach_checkbox = new icms_form_elements_Checkbox(_MD_REMOVE, 'delete_tmp[]');
	$url_prefix = str_replace(ICMS_ROOT_PATH, ICMS_URL, XOOPS_CACHE_PATH);
	foreach($attachments_tmp as $key => $attachment)
	{
		$attach = ' <a href="'.$url_prefix.'/'.$attachment[0].'" target="_blank" >'.$attachment[1].'</a>';
		$delete_attach_checkbox->addOption($key, $attach);
	}
	$forum_form->addElement($delete_attach_checkbox);
	unset($delete_attach_checkbox);
	$attachments_tmp = base64_encode(serialize($attachments_tmp));
	$forum_form->addElement(new icms_form_elements_Hidden('attachments_tmp', $attachments_tmp));
}
 
if (icms::$module->config['enable_karma'] || icms::$module->config['allow_require_reply'])
{
	$view_require = ($require_reply)?'require_reply':
	(($post_karma)?'require_karma':'require_null');
	$radiobox = new icms_form_elements_Radio(_MD_VIEW_REQUIRE, 'view_require', $view_require );
	if (icms::$module->config['allow_require_reply'])
	{
		$radiobox->addOption('require_reply', _MD_REQUIRE_REPLY);
	}
	if (icms::$module->config['enable_karma'])
	{
		$karmas = array_map("trim", explode(',', icms::$module->config['karma_options']));
		if (count($karmas) > 1)
		{
			foreach($karmas as $karma)
			{
				$karma_array[strval($karma)] = intval($karma);
			}
			$karma_select = new icms_form_elements_Select('', "post_karma", $post_karma);
			$karma_select->addOptionArray($karma_array);
			$radiobox->addOption('require_karma', _MD_REQUIRE_KARMA. ($karma_select->render()) );
		}
	}
	$radiobox->addOption('require_null', _MD_REQUIRE_NULL);
}
$forum_form->addElement($radiobox );
 
if (!empty(icms::$module->config['captcha_enabled']) )
{
	$forum_form->addElement(new icms_form_elements_Captcha() );
}
 
if (!empty($admin_form_action))
{
	$approved_radio = new icms_form_elements_Radioyn(_AM_IFORUM_APPROVE, 'approved', 1, '' . _YES . '', ' ' . _NO . '');
	$forum_form->addElement($approved_radio);
}
 
// backward compatible
if (!class_exists("XoopsSecurity"))
{
	$post_valid = 1;
	$_SESSION['submit_token'] = $post_valid;
	$forum_form->addElement(new icms_form_elements_Hidden('post_valid', $post_valid));
}
 
$forum_form->addElement(new icms_form_elements_Hidden('pid', $pid));
$forum_form->addElement(new icms_form_elements_Hidden('post_id', $post_id));
$forum_form->addElement(new icms_form_elements_Hidden('topic_id', $topic_id));
$forum_form->addElement(new icms_form_elements_Hidden('forum', $forum_obj->getVar('forum_id')));
$forum_form->addElement(new icms_form_elements_Hidden('viewmode', $viewmode));
$forum_form->addElement(new icms_form_elements_Hidden('order', $order));
$forum_form->addElement(new icms_form_elements_Hidden('start', $start));
$forum_form->addElement(new icms_form_elements_Hidden('isreply', $isreply));
$forum_form->addElement(new icms_form_elements_Hidden('isedit', $isedit));
$forum_form->addElement(new icms_form_elements_Hidden('op', $op));
 
$button_tray = new icms_form_elements_Tray('');
 
$submit_button = new icms_form_elements_Button('', 'contents_submit', _SUBMIT, "submit");
$submit_button->setExtra("tabindex='3'");
 
$cancel_button = new icms_form_elements_Button('', 'cancel', _CANCEL, 'button');
if (isset($topic_id) && $topic_id != "" )
	$extra = "viewtopic.php?topic_id=".intval($topic_id);
else
	$extra = "viewforum.php?forum=".$forum_obj->getVar('forum_id');
$cancel_button->setExtra("onclick='location=\"".$extra."\"'");
$cancel_button->setExtra("tabindex='6'");
 
if (!empty($isreply) && !empty($hidden) )
{
	$forum_form->addElement(new icms_form_elements_Hidden('hidden', $hidden));
	 
	$quote_button = new icms_form_elements_Button('', 'quote', _MD_QUOTE, 'button');
	$quote_button->setExtra("onclick='xoopsGetElementById(\"message_tarea\").value=xoopsGetElementById(\"message_tarea\").value+ xoopsGetElementById(\"hidden\").value;xoopsGetElementById(\"hidden\").value=\"\";'");
	$quote_button->setExtra("tabindex='4'");
	$button_tray->addElement($quote_button);
}
 
$preview_button = new icms_form_elements_Button('', 'btn_preview', _PREVIEW, "button");
$preview_button->setExtra("tabindex='5'");
$preview_button->setExtra('onclick="window.document.forms.forumform.contents_preview.value=1;
	window.document.forms.forumform.submit();"');
$forum_form->addElement(new icms_form_elements_Hidden('contents_preview', 0));
 
$button_tray->addElement($preview_button);
$button_tray->addElement($submit_button);
$button_tray->addElement($cancel_button);
$forum_form->addElement($button_tray);
 
$forum_form->display();