<?php
// $Id: forumform.inc.php,v 1.1.1.51 2004/11/15 18:19:20 phppp Exp $
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

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
include XOOPS_ROOT_PATH."/class/xoopsformloader.php";

if(!is_object($forum)){
    $forum_handler =& xoops_getmodulehandler('forum', 'newbb');
    $forum = isset($_GET['forum']) ? intval($_GET['forum']) : (isset($forum) ? intval($forum) : 0);
    $forum = $forum_handler->get($forum);
}

foreach (array(
		'start',
		'topic_id',
		'post_id',
		'pid',
		'isreply',
		'isedit',
		'contents_preview'
		) as $getint) {
    ${$getint} = isset($_GET[$getint]) ? intval($_GET[$getint]) : ( (!empty(${$getint}))?${$getint}:0 );
}
foreach (array(
		'order',
		'viewmode',
		'hidden',
		'newbb_form',
		'icon',
		'op'
		) as $getstr) {
    ${$getstr} = isset($_GET[$getstr]) ? $_GET[$getstr] : ( (!empty(${$getstr}))? ${$getstr} : '' );
}


$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
$topic_status = $topic_handler->get(@$topic_id,'topic_status');

if(!empty($newbb_form)){
	newbb_setcookie('newbb_form',$newbb_form);
}else{
	$newbb_form = newbb_getcookie('newbb_form');
}
if(count($xoopsModuleConfig['form_options'])>1 && !$contents_preview){
	$select_form = new XoopsThemeForm('', 'newbb_formtype', xoops_getenv('PHP_SELF'), 'get');

	$options = array();
	$newbb_forms = array( 'textarea' => _MD_FORM_COMPACT, 'dhtml' => _MD_FORM_DHTML, 'spaw' => _MD_FORM_SPAW, 'htmlarea' => _MD_FORM_HTMLAREA, 'koivi' =>  _MD_FORM_KOIVI, 'fck' => _MD_FORM_FCK );
	foreach($xoopsModuleConfig['form_options'] as $option){
		$options[$option]=$newbb_forms[$option];
	}
	$option_select = new XoopsFormSelect('', 'newbb_form', $newbb_form);
	$option_select->setExtra('onchange="if(this.options[this.selectedIndex].value.length > 0 ){ forms[\'newbb_formtype\'].submit() }"');
	$option_select->addOptionArray($options);

	$button_tray = new XoopsFormElementTray(_MD_SELECT_FORMTYPE);
	$button_tray->addElement(new XoopsFormLabel($option_select->render()));
	$submit_button = new XoopsFormButton('', '', _SUBMIT, "submit");
	$button_tray->addElement($submit_button);

	$select_form->addElement($button_tray);

	$select_form->addElement(new XoopsFormHidden('pid', $pid));
	$select_form->addElement(new XoopsFormHidden('post_id', $post_id));
	$select_form->addElement(new XoopsFormHidden('topic_id', $topic_id));
	$select_form->addElement(new XoopsFormHidden('forum', $forum->getVar('forum_id')));
	$select_form->addElement(new XoopsFormHidden('viewmode', $viewmode));
	$select_form->addElement(new XoopsFormHidden('order', $order));
	$select_form->addElement(new XoopsFormHidden('start', $start));
    $select_form->addElement(new XoopsFormHidden('hidden', $hidden));
    $select_form->addElement(new XoopsFormHidden('isreply', $isreply));
	$select_form->addElement(new XoopsFormHidden('isedit', $isedit));
	$select_form->addElement(new XoopsFormHidden('icon', $icon));
	$select_form->addElement(new XoopsFormHidden('contents_preview', $contents_preview));

	$select_form->display();
}

$forum_form_action = (empty($admin_form_action))?"post.php":$admin_form_action; // admin/index.php also uses this form
$forum_form = new XoopsThemeForm('', 'forumform', $forum_form_action);
$forum_form->setExtra('enctype="multipart/form-data"');

if (newbb_isAdmin($forum)) {
	if ($forum->getVar('allow_subject_prefix')) {
		$subject_add = new XoopsFormElementTray(_MD_TOPIC_SUBJECTC,'');
		$subjectpres = explode(',',$xoopsModuleConfig['subject_prefix']);
		if(count($subjectpres)>1) {
			foreach($subjectpres as $subjectpre){
				$subject_array[]=trim($subjectpre);
			}
			$subject_select = new XoopsFormSelect('', 'subject_pre', $subject_pre);
			$subject_select->addOptionArray($subject_array);
			$subject_add->addElement(new XoopsFormLabel($subject_select->render()));
		}
		$forum_form->addElement($subject_add);
	}
}
$subject_form = new XoopsFormText(_MD_SUBJECTC, 'subject', 60, 100, $subject);
$subject_form->setExtra("tabindex='1'");
$forum_form->addElement($subject_form,true);

if (!is_object($xoopsUser) && empty($admin_form_action)) {
	$forum_form->addElement(new XoopsFormText(_MD_NAMEMAIL, 'poster_name', 60, 255, ( !empty($isedit) && !empty($poster_name))?$poster_name:''));
}

$icons_radio = new XoopsFormRadio(_MD_MESSAGEICON, 'icon', $icon);
$subject_icons = XoopsLists::getSubjectsList();
foreach ($subject_icons as $iconfile) {
	$icons_radio->addOption($iconfile, '<img src="'.XOOPS_URL.'/images/subject/'.$iconfile.'" alt="" />');
}
$forum_form->addElement($icons_radio);

$caption = _MD_MESSAGEC;
$name ='message';
$value = $message;
$rows = 25;
$cols = 60;
$width = '100%';
$height = '400px';
$isWysiwyg = false;

if($forum->getVar('allow_html') && ($editor = &newbb_getWysiwygForm($newbb_form, $caption, $name, $value, $width, $height)) ){
	if(method_exists($editor, 'setFilePath')){
		$editor->setFilePath('/'.$xoopsModuleConfig['dir_attachments']);
	}
	if ($forum->getVar('allow_attachments')
		&& $topic_handler->getPermission($forum, $topic_status, 'attach')
		&& method_exists($editor, 'enableUpload')
		) {
		$editor->enableUpload(explode('|', $forum->getVar('attach_ext')));
	}
	$isWysiwyg = true;
	$dohtml = 1;
}else{
	$editor = &newbb_getTextareaForm($newbb_form, $caption, $name, $value, $rows, $cols);
}

$editor->setExtra("tabindex='2'");
$forum_form->addElement($editor, true);

$options_tray = new XoopsFormElementTray(_MD_OPTIONS, '<br />');
if (is_object($xoopsUser) && $xoopsModuleConfig['allow_user_anonymous'] == 1) {
    $noname = (!empty($isedit) && is_object($forumpost) && $forumpost->getVar('uid') == 0) ? 1 : 0;
    $noname_checkbox = new XoopsFormCheckBox('', 'noname', $noname);
    $noname_checkbox->addOption(1, _MD_POSTANONLY);
    $options_tray->addElement($noname_checkbox);
}

if ($forum->getVar('allow_html')) {
    $html_checkbox = new XoopsFormCheckBox('', 'dohtml', $dohtml);
    $html_checkbox->addOption(1, _MD_DOHTML);
    $options_tray->addElement($html_checkbox);
}else {
    $forum_form->addElement(new XoopsFormHidden('dohtml', 0));
}

$smiley_checkbox = new XoopsFormCheckBox('', 'dosmiley', $dosmiley);
$smiley_checkbox->addOption(1, _MD_DOSMILEY);
$options_tray->addElement($smiley_checkbox);

$xcode_checkbox = new XoopsFormCheckBox('', 'doxcode', $doxcode);
$xcode_checkbox->addOption(1, _MD_DOXCODE);
$options_tray->addElement($xcode_checkbox);

if ($forum->getVar('allow_sig') && is_object($xoopsUser)) {
    $attachsig_checkbox = new XoopsFormCheckBox('', 'attachsig', $attachsig);
    $attachsig_checkbox->addOption(1, _MD_ATTACHSIG);
    $options_tray->addElement($attachsig_checkbox);
}

if ( empty($admin_form_action) && is_object($xoopsUser) && $xoopsModuleConfig['notification_enabled']) {
    if (!empty($notify)) {
		// If 'notify' set, use that value (e.g. preview)
		$notify = 1;
	}
	else {
		// Otherwise, check previous subscribed status...
		$notification_handler =& xoops_gethandler('notification');
		if (!empty($topic_id) && $notification_handler->isSubscribed('thread', $topic_id, 'new_post', $xoopsModule->getVar('mid'), $xoopsUser->getVar('uid'))) {
			$notify = 1;
		}
		else {
		    $notify = 0;
		}
	}
    $forum_form->addElement(new XoopsFormHidden('istopic', $istopic));

    $notify_checkbox = new XoopsFormCheckBox('', 'notify', $notify);
    $notify_checkbox->addOption(1, _MD_NEWPOSTNOTIFY);
    $options_tray->addElement($notify_checkbox);
}

$forum_form->addElement($options_tray);

if ($forum->getVar('allow_attachments') && $topic_handler->getPermission($forum, $topic_status, 'attach')) {
    $forum_form->addElement(new XoopsFormFile(_MD_ATTACHMENT, 'userfile',''));
    $forum_form->addElement(new XoopsFormLabel(_MD_ALLOWED_EXTENSIONS, "<i>".str_replace('|',' ',$forum->getVar('attach_ext'))."</i>"));
}

if (isset($attachments) && is_array($attachments) && count($attachments)){
	$delete_attach_checkbox = new XoopsFormCheckBox(_MD_THIS_FILE_WAS_ATTACHED_TO_THIS_POST, 'delete_attach[]');
	foreach($attachments as $key => $attachment){
		$attach = _DELETE.' <a href='.XOOPS_URL.'/'.$xoopsModuleConfig['dir_attachments'].'/'.$attachment['name_saved'].' targe="_blank" >'.$attachment['name_display'].'</a>';
		$delete_attach_checkbox->addOption($key, $attach);
	}
	$forum_form->addElement($delete_attach_checkbox);
}


if($xoopsModuleConfig['enable_karma'] || $xoopsModuleConfig['allow_require_reply']){
	$view_require = ($require_reply)?'require_reply':(($post_karma)?'require_karma':'require_null');
	$radiobox = new XoopsFormRadio( _MD_VIEW_REQUIRE, 'view_require', $view_require );
	if($xoopsModuleConfig['allow_require_reply']){
		$radiobox->addOption( 'require_reply', _MD_REQUIRE_REPLY);
	}
	if($xoopsModuleConfig['enable_karma']){
		$karmas = explode(',',$xoopsModuleConfig['karma_options']);
		if(count($karmas)>1) {
			foreach($karmas as $karma){
				$karma_array[strval($karma)] = intval($karma);
			}
			$karma_select = new XoopsFormSelect('', "post_karma", $post_karma);
			$karma_select->addOptionArray($karma_array);
			$radiobox->addOption( 'require_karma', _MD_REQUIRE_KARMA.$karma_select->render());
		}
	}
	$radiobox->addOption( 'require_null', _MD_REQUIRE_NULL);
}
$forum_form->addElement( $radiobox );

if(!empty($admin_form_action)){
    $approved_radio = new XoopsFormRadioYN(_AM_NEWBB_APPROVE, 'approved', 1, '' . _YES . '', ' ' . _NO . '');
	$forum_form->addElement($approved_radio);
}

$post_valid = 1;
$_SESSION['submit_token'] = $post_valid;
$forum_form->addElement(new XoopsFormHidden('post_valid', $post_valid));

$forum_form->addElement(new XoopsFormHidden('pid', $pid));
$forum_form->addElement(new XoopsFormHidden('post_id', $post_id));
$forum_form->addElement(new XoopsFormHidden('topic_id', $topic_id));
$forum_form->addElement(new XoopsFormHidden('forum', $forum->getVar('forum_id')));
$forum_form->addElement(new XoopsFormHidden('viewmode', $viewmode));
$forum_form->addElement(new XoopsFormHidden('order', $order));
$forum_form->addElement(new XoopsFormHidden('start', $start));
$forum_form->addElement(new XoopsFormHidden('isreply', $isreply));
$forum_form->addElement(new XoopsFormHidden('isedit', $isedit));
$forum_form->addElement(new XoopsFormHidden('op', $op));

$forum_form->addElement(new XoopsFormHidden('isWysiwyg', $isWysiwyg));

$button_tray = new XoopsFormElementTray('');

$submit_button = new XoopsFormButton('', 'contents_submit', _SUBMIT, "submit");
$submit_button->setExtra("tabindex='3'");

$cancel_button = new XoopsFormButton('', 'cancel', _MD_CANCELPOST, 'button');
if ( isset($topic_id) && $topic_id != "" )
    $extra = "viewtopic.php?topic_id=".intval($topic_id);
else
    $extra = "viewforum.php?forum=".$forum->getVar('forum_id');
$cancel_button->setExtra("onclick='location=\"".$extra."\"'");
$cancel_button->setExtra("tabindex='6'");

if(empty($isWysiwyg)){
	if ( !empty($isreply) && !empty($hidden) ) {
	    $forum_form->addElement(new XoopsFormHidden('hidden', $hidden));

	    $quote_button = new XoopsFormButton('', 'quote', _MD_QUOTE, 'button');
	    $quote_button->setExtra("onclick='xoopsGetElementById(\"message\").value=xoopsGetElementById(\"message\").value+ xoopsGetElementById(\"hidden\").value;xoopsGetElementById(\"hidden\").value=\"\";'");
	    $quote_button->setExtra("tabindex='4'");
		$button_tray->addElement($quote_button);
	}
	$preview_button = new XoopsFormButton('', 'contents_preview', _PREVIEW, "submit");
	$preview_button->setExtra("tabindex='5'");
	$button_tray->addElement($preview_button);
}
$button_tray->addElement($submit_button);
$button_tray->addElement($cancel_button);
$forum_form->addElement($button_tray);

$forum_form->display();
?>
