<?php
// $Id: viewtopic.php,v 1.1.1.114 2004/11/16 22:17:11 praedator Exp $
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

include 'header.php';
include_once XOOPS_ROOT_PATH."/include/xoopscodes.php";

if (file_exists(XOOPS_ROOT_PATH."/modules/xoopspoll"))
{
	include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspoll.php";
	include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspolloption.php";
	include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspolllog.php";
	include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspollrenderer.php";
}
$forum = isset($_GET['forum']) ? intval($_GET['forum']) : 0;
$topic_id = isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;
$topic_time = (isset($_GET['topic_time'])) ? intval($_GET['topic_time']) : 0;
$post_id = !empty($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$move = isset($_GET['move'])? strtolower($_GET['move']) : '';

if ( !$topic_id && !$post_id ) {
    redirect_header('viewforum.php?forum='.$forum,2,_MD_ERRORTOPIC);
}

$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
if ( isset($post_id) && $post_id != "" ) {
    $forumtopic =& $topic_handler->getByPost($post_id);
} else {
    $forumtopic =& $topic_handler->get($topic_id);
}
if(!$approved = $forumtopic->getVar('approved')){
    redirect_header("viewforum.php?forum=".$forumtopic->getVar('forum_id'),2,_MD_NORIGHTTOVIEW);
    exit();
}
$forum = ($forum)?$forum:$forumtopic->getVar('forum_id'); // ?

$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
$viewtopic_forum =& $forum_handler->get($forum);
if (!$forum_handler->getPermission($viewtopic_forum)){
    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
    exit();
}

$perm =& xoops_getmodulehandler('permission', 'newbb');
$permission_set = $perm->getPermissions('topic', $forumtopic->getVar('forum_id'));

if (!$topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "view")){
    redirect_header("viewforum.php?forum=".$viewtopic_forum->getVar('forum_id'),2,_MD_NORIGHTTOVIEW);
    exit();
}

$karma_handler =& xoops_getmodulehandler('karma', 'newbb');
$user_karma = $karma_handler->getUserKarma();

if ( !$forumdata =  $topic_handler->getViewData($topic_id, $forum, $move) ) {
	redirect_header('viewforum.php?forum='.$viewtopic_forum->getVar('forum_id'), 2, _MD_FORUMNOEXIST);
	exit();
} else {
	$topic_id = $forumdata['topic_id'];
	$forumtopic = @$topic_handler->get($topic_id);
}
if ($topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "post")){
	$display_stat= 1;

	$qrshow = true;
	if (isset($HTTP_COOKIE_VARS['newbb2_toggle']))
		{
			$cookiearr = split(',',$_COOKIE['newbb2_toggle']);
			$qrshow = (in_array('quick_reply', $cookiearr)) ? false : true;
		}

	$display = ($qrshow) ? 'none;' : 'block;';
	$display_icon  = newbb_displayImage($forumImage['t_qr']);

}
else {
	$display_stat= 0;
	$display='';
	$display_icon = '';
}


//------------------------------------------------------
// rating_img
$rating = number_format($forumdata['rating']/2, 0);
if ( $rating < 1 ) {
	$rating_img = newbb_displayImage($forumImage['blank']);
}
else
{
	$rating_img  = newbb_displayImage($forumImage['rate'.$rating]);
}

$isadmin = newbb_isAdmin($viewtopic_forum);

$total_posts = get_total_posts($topic_id, "topic");

//use users preferences
if (is_object($xoopsUser)) {
    $viewmode = $xoopsUser->getVar('umode');
    $order = ($xoopsUser->getVar('uorder') == 1) ? 'DESC' : 'ASC';
} else {
    $viewmode = 'flat';
    $order = 'ASC';
}
if ($xoopsModuleConfig['view_mode'] == 1)    $viewmode = 'flat';
if ($xoopsModuleConfig['view_mode'] == 2)    $viewmode = 'thread';

// override mode/order if any requested
if (isset($_GET['viewmode']) && ($_GET['viewmode'] == 'flat' || $_GET['viewmode'] == 'thread')) {
    $viewmode = $_GET['viewmode'];
}
if (isset($_GET['order']) && ($_GET['order'] == 'ASC' || $_GET['order'] == 'DESC')) {
    $order = $_GET['order'];
}
$qorder = ($order == 1)? "post_time DESC": "post_time ASC";

$forumtopic->setOrder($qorder);

// initialize the start number of select query
$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;

if ($viewmode == "thread") {
    $xoopsOption['template_main'] =  'newbb_viewtopic_thread.html';
    $postCount = $topic_handler->getPostCount($forumtopic);
    if(defined('MAX_POSTCOUNT_THREADVIEW')&&($postCount > MAX_POSTCOUNT_THREADVIEW)) {
	    redirect_header("viewtopic.php?topic_id=$topic_id&amp;viewmode=flat", 2, _MD_EXCEEDTHREADVIEW);
	    exit();
    }
	$postsArray = $topic_handler->getAllPosts($forumtopic, $order, $postCount, $start);

} else {
    $viewmode = "flat";
    $xoopsOption['template_main'] =  'newbb_viewtopic_flat.html';
    $postsArray = $topic_handler->getAllPosts($forumtopic, $order, $xoopsModuleConfig['posts_per_page'], $start, $post_id);
}

// cookie should be handled before calling XOOPS_ROOT_PATH."/header.php", otherwise it won't work for cache
$topic_lastread = newbb_getcookie('LT',true);
if ( empty($topic_lastread[$topic_id]) ) {
    $forumtopic->incrementCounter();
}
$topic_lastread[$topic_id] = time();
newbb_setcookie("LT", $topic_lastread);

if(newbb_isAdmin($forumdata['forum_id'], $forumdata['topic_poster']) && $xoopsModuleConfig['allow_moderator_html'] ) $topic_title = newbb_html2text($myts->undoHtmlSpecialChars($forumdata['topic_title']));
else $topic_title = $myts->htmlSpecialChars($forumdata['topic_title']);
$forum_name = newbb_html2text($myts->undoHtmlSpecialChars($forumdata['forum_name']));
$module_name = $xoopsModule->getVar('name');
$xoops_pagetitle = $module_name. ' - ' .$forum_name. ' - ' .$topic_title;
$xoops_pagetitle = $module_name. ' - ' .$myts->displayTarea($forum_name). ' - ' .$topic_title;


include XOOPS_ROOT_PATH."/header.php";
$xoopsTpl->assign('xoops_module_header', $newbb_module_header);
$xoopsTpl->assign('xoops_pagetitle', $xoops_pagetitle);

if ($xoopsModuleConfig['wol_enabled']){
	$online_handler =& xoops_getmodulehandler('online', 'newbb');
	$online_handler->init($viewtopic_forum, $forumtopic);
    $xoopsTpl->assign('online', $online_handler->show_online());
    $xoopsTpl->assign('color_admin', $xoopsModuleConfig['wol_admin_col']);
    $xoopsTpl->assign('color_mod', $xoopsModuleConfig['wol_mod_col']);
}

if($forumdata['parent_forum'] > 0){
    $q = "select forum_name from ".$xoopsDB->prefix('bb_forums')." WHERE forum_id=".$forumdata['parent_forum'];
    $row = $xoopsDB->fetchArray($xoopsDB->query($q));
    $xoopsTpl->assign(array('parent_forum' => $forumdata['parent_forum'], 'parent_name' => $myts->displayTarea($row['forum_name'])));
}

/*
 * This is for moderator html
 * The $myts->displayTarea() treatment is only necessary for multilanguage conversion hack inside the function
 */
if(newbb_isAdmin($viewtopic_forum, $forumdata['topic_poster']) && $xoopsModuleConfig['allow_moderator_html']) $dohtml = true;
else $dohtml = false;
$forumdata['topic_title'] = $myts->displayTarea($forumdata['topic_title'], $dohtml, 0, 1, 0, 0);
$forumdata['forum_name'] = $myts->displayTarea($forumdata['forum_name'], 0, 0, 1, 0, 0);
$xoopsTpl->assign(array('topic_title' => '<a href="'.$forumUrl['root'].'/viewtopic.php?viewmode='.$viewmode.'&amp;topic_id='.$topic_id.'&amp;forum='.$forumdata['forum_id'].'">'. $forumdata['topic_title'].'</a>', 'forum_name' => $forumdata['forum_name'], 'topic_time' => $forumdata['topic_time'], 'lang_nexttopic' => _MD_NEXTTOPIC, 'lang_prevtopic' => _MD_PREVTOPIC));

$xoopsTpl->assign('folder_topic', newbb_displayImage($forumImage['folder_topic']));

$xoopsTpl->assign('topic_id', $forumdata['topic_id']);
$topic_id = $forumdata['topic_id'];
$xoopsTpl->assign('forum_id', $forumdata['forum_id']);

if ($order == 'DESC') {
    $xoopsTpl->assign(array('order_current' => 'DESC', 'order_other' => 'ASC', 'lang_order_other' => _OLDESTFIRST));
} else {
    $xoopsTpl->assign(array('order_current' => 'ASC', 'order_other' => 'DESC', 'lang_order_other' => _NEWESTFIRST));
}


$xoopsTpl->assign(array('lang_threaded' => _THREADED, 'lang_flat' => _FLAT));
$t_new = newbb_displayImage($forumImage['t_new'],_MD_POSTNEW);

$show_reg = 0;

if ($topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "post")){
    $xoopsTpl->assign(array('viewer_can_post' => true, 'forum_post_or_register' => "<a href=\"newtopic.php?forum=".$forumdata['forum_id']."\">
    ".$t_new."</a>"));
} else {
    $xoopsTpl->assign('viewer_can_post', false);
    if ( $show_reg == 1 ) {
        $xoopsTpl->assign('forum_post_or_register', '<a href="'.XOOPS_URL.'/user.php?xoops_redirect='.htmlspecialchars($xoopsRequestUri).'">'._MD_REGTOPOST.'</a>');
    } else {
        $xoopsTpl->assign('forum_post_or_register', '');
    }
}
$poster_array = array();
foreach ($postsArray as $eachpost) {
	if($eachpost->getVar('uid')>0) $poster_array[$eachpost->getVar('uid')] = 1;
}
$userid_array=array();
if(count($poster_array)>0){
	$member_handler =& xoops_gethandler('member');
	$userid_array = array_keys($poster_array);
	$user_criteria = "(".implode(",",$userid_array).")";
	$users = $member_handler->getUsers( new Criteria('uid', $user_criteria, 'IN'), true);
}else{
	$user_criteria = '';
	$users = null;
}

if($xoopsModuleConfig['groupbar_enabled']){
	$groups_disp = array();
	$groups =& $member_handler->getGroups();
	$count = count($groups);
	for ($i = 0; $i < $count; $i++) {
		$groups_disp[$groups[$i]->getVar('groupid')] = $groups[$i]->getVar('name');
	}
	unset($groups);
}

$viewtopic_users = array();
if(count($userid_array)>0)
foreach($userid_array as $userid){
	if ( !isset($users[$userid]) || !(is_object($users[$userid])) || !($users[$userid]->isActive()) )	 continue;
	if($xoopsModuleConfig['groupbar_enabled']){
		$groupids = $users[$userid] -> getGroups();
		foreach($groupids as $id){
			if(isset($groups_disp[$id])) $viewtopic_users[$userid]['groups'][] = $groups_disp[$id];
		}
		unset($groupids);
	}
	$viewtopic_users[$userid]['level'] = ($xoopsModuleConfig['levels_enabled'])?get_user_level($users[$userid]):null;
	$viewtopic_users[$userid]['user'] = $users[$userid];
	$viewtopic_users[$userid]['rank'] = $users[$userid]->rank();
	if(newbb_isAdmin($viewtopic_forum, $userid)) $viewtopic_users[$userid]['is_forumadmin'] = 1;
}
unset($users);
unset($groups_disp);

if ($xoopsModuleConfig['wol_enabled'] && $online_handler){
	$online = array();
	if(!empty($user_criteria)){
		$online_full = $online_handler->getAll(new Criteria('online_uid', $user_criteria, 'IN'));
		if(is_array($online_full)&&count($online_full)>0){
			foreach ($online_full as $thisonline) {
			    if ($thisonline['online_uid'] > 0) $online[$thisonline['online_uid']] = 1;
			}
		}
	}
}

if ($viewmode == "thread") {
	if(isset($post_id)&&$post_id){
		$post_handler =& xoops_getmodulehandler('post', 'newbb');
		$currentPost = $post_handler -> get($post_id);

		$topPost = $topic_handler->getTopPost($forumtopic->getVar('topic_id'));
	    $top_pid = $topPost->getVar('post_id');
	    unset($topPost);
	}else{
		$currentPost = $topic_handler->getTopPost($forumtopic->getVar('topic_id'));
	    $top_pid = $currentPost->getVar('post_id');
	}

	$currentPost->showPost($isadmin, $forumdata);
    $postArray = $topic_handler->getPostTree($postsArray,$top_pid);
    if ( count($postArray) > 0 ) {
        foreach ($postArray as $treeItem) {
            $topic_handler->showTreeItem($forumtopic, $treeItem);
            if($treeItem['post_id'] == $post_id) $treeItem['subject'] = '<strong>'.$treeItem['subject'].'</strong>';
            $xoopsTpl->append("topic_trees", array("post_id" => $treeItem['post_id'], "post_time" => $treeItem['post_time'], "post_image" => $treeItem['icon'], "post_title" => $treeItem['subject'], "post_prefix" => $treeItem['prefix'], "poster" => $treeItem['poster']));
        }
    }
}
if ($viewmode == "flat") {
    $xoopsTpl->assign(array('topic_viewmode' => 'flat', 'lang_top' => _MD_TOP, 'lang_bottom' => _MD_BOTTOM));

    foreach ($postsArray as $eachpost) {
        $eachpost->showPost($isadmin, $forumdata);
    }

    if ( $total_posts > $xoopsModuleConfig['posts_per_page'] ) {
        include XOOPS_ROOT_PATH.'/class/pagenav.php';
        $nav = new XoopsPageNav($total_posts, $xoopsModuleConfig['posts_per_page'], $start, "start", 'topic_id='.$topic_id.'&amp;viewmode='.$viewmode.'&amp;order='.$order);
        $xoopsTpl->assign('forum_page_nav', $nav->renderImageNav(4));
    } else {
        $xoopsTpl->assign('forum_page_nav', '');
    }
}

if ( $xoopsModuleConfig['quickreply_enabled'] == 1 && $forumdata['topic_status'] != 1 ) {
    $post_id = $topic_handler->getTopPostId($topic_id);
	$post_valid = 1;
	$_SESSION['submit_token'] = $post_valid;

	include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

	$forum_form = new XoopsThemeForm(_MD_POSTREPLY, 'quick_reply', "post.php");
	$forum_form->setExtra('onsubmit="if(document.quick_reply.message.value == \'RE\' || document.quick_reply.message.value == \'\'){ alert(\''._MD_QUICKREPLY_EMPTY.'\'); return false;}else{ return true;}"');

	$message_form = &newbb_getTextareaForm(newbb_getcookie('newbb_form'), _MD_MESSAGEC, 'message', '', 10, 60);
	$forum_form->addElement($message_form, '');

	$forum_form->addElement(new XoopsFormHidden('dohtml', 0));
	$forum_form->addElement(new XoopsFormHidden('dosmiley', 1));
	$forum_form->addElement(new XoopsFormHidden('doxcode', 1));
	$forum_form->addElement(new XoopsFormHidden('attachsig', 1));

	$forum_form->addElement(new XoopsFormHidden('isreply', 1));
	$forum_form->addElement(new XoopsFormHidden('subject', 'Re: '.newbb_html2text($forumdata['topic_title'])));
	$forum_form->addElement(new XoopsFormHidden('pid', $post_id));
	$forum_form->addElement(new XoopsFormHidden('topic_id', $topic_id));
	$forum_form->addElement(new XoopsFormHidden('forum', $forum));
	$forum_form->addElement(new XoopsFormHidden('viewmode', $viewmode));
	$forum_form->addElement(new XoopsFormHidden('order', $order));
	$forum_form->addElement(new XoopsFormHidden('start', $start));
	$forum_form->addElement(new XoopsFormHidden('post_valid', $post_valid));

	$submit_button = new XoopsFormButton('', 'contents_submit', _SUBMIT, "submit");
	$button_tray = new XoopsFormElementTray('');
	$button_tray->addElement($submit_button);
	$forum_form->addElement($button_tray);

    $xoopsTpl->assign('quickreply', array( 'show' => 1, 'form' => $forum_form->render()));

}else{
	$xoopsTpl->assign('quickreply', array( 'show' => 0));
}

$xoopsTpl->assign('topic_print_link', "print.php?form=1&amp;topic_id=$topic_id&amp;forum=".$forumdata['forum_id']."&amp;order=$order&amp;start=$start");

$admin_actions = array();

$ad_move = newbb_displayImage($forumImage['move_topic'],_MD_MOVETOPIC);
$ad_delete = newbb_displayImage($forumImage['del_topic'],_MD_DELETETOPIC);
$ad_lock = newbb_displayImage($forumImage['lock_topic'],_MD_LOCKTOPIC);
$ad_unlock = newbb_displayImage($forumImage['unlock_topic'],_MD_UNLOCKTOPIC);
$ad_sticky = newbb_displayImage($forumImage['sticky'],_MD_STICKYTOPIC);
$ad_unsticky = newbb_displayImage($forumImage['unsticky'],_MD_UNSTICKYTOPIC);
$ad_digest = newbb_displayImage($forumImage['digest'],_MD_DIGESTTOPIC);
$ad_undigest = newbb_displayImage($forumImage['undigest'],_MD_UNDIGESTTOPIC);

$admin_actions['move'] = '<tr><td class="head"><small><a class="newbb_link" href="'.$forumUrl['root'].'/topicmanager.php?mode=move&amp;topic_id='.$topic_id.'&amp;forum='.$forum.'">'.$ad_move.'&nbsp;'._MD_MOVETOPIC.'</a></small></td></tr>';
$admin_actions['delete'] = '<tr><td class="head" ><small><a class="newbb_link" href="'.$forumUrl['root'].'/topicmanager.php?mode=delete&amp;topic_id='.$topic_id.'&amp;forum='.$forum.'">'.$ad_delete.'&nbsp;'._MD_DELETETOPIC.'</a></small></td></tr>';
if ( !$forumdata['topic_status'] )
    $admin_actions['lock'] = '<tr><td class="head"><small><a class="newbb_link" href="'.$forumUrl['root'].'/topicmanager.php?mode=lock&amp;topic_id='.$topic_id.'&amp;forum='.$forum.'">'.$ad_lock.'&nbsp;'._MD_LOCKTOPIC.'</a></small></td></tr>';
else
    $admin_actions['unlock'] = '<tr><td class="head"><small><a class="newbb_link" href="'.$forumUrl['root'].'/topicmanager.php?mode=unlock&amp;topic_id='.$topic_id.'&amp;forum='.$forum.'">'.$ad_unlock.'&nbsp;'._MD_UNLOCKTOPIC.'</a></small></td></tr>';
if ( !$forumdata['topic_sticky'] )
    $admin_actions['sticky'] = '<tr><td class="head"><small><a class="newbb_link" href="'.$forumUrl['root'].'/topicmanager.php?mode=sticky&amp;topic_id='.$topic_id.'&amp;forum='.$forum.'">'.$ad_sticky.'&nbsp;'._MD_STICKYTOPIC.'</a></small></td></tr>';
else
    $admin_actions['unsticky'] = '<tr><td class="head"><small><a class="newbb_link" href="'.$forumUrl['root'].'/topicmanager.php?mode=unsticky&amp;topic_id='.$topic_id.'&amp;forum='.$forum.'">'.$ad_unsticky.'&nbsp;'._MD_UNSTICKYTOPIC.'</a></small></td></tr>';
if ( !$forumdata['topic_digest'] )
    $admin_actions['digest'] = '<tr><td class="head"><small><a class="newbb_link" href="'.$forumUrl['root'].'/topicmanager.php?mode=digest&amp;topic_id='.$topic_id.'&amp;forum='.$forum.'">'.$ad_digest.'&nbsp;'._MD_DIGESTTOPIC.'</a></small></td></tr>';
else
    $admin_actions['undigest'] = '<tr><td class="head"><small><a class="newbb_link" href="'.$forumUrl['root'].'/topicmanager.php?mode=undigest&amp;topic_id='.$topic_id.'&amp;forum='.$forum.'">'.$ad_undigest.'&nbsp;'._MD_UNDIGESTTOPIC.'</a></small></td></tr>';
$xoopsTpl->assign('admin_actions', $admin_actions);

$xoopsTpl->assign('viewer_is_admin', $isadmin );

$permission_table = ($xoopsModuleConfig['show_permissiontable'])?$perm->permission_table($permission_set,$viewtopic_forum, $forumtopic->getVar('topic_status')):'';
$xoopsTpl->assign('permission_table', $permission_table);
$xoopsTpl->assign('votes',$forumdata['votes']);
$xoopsTpl->assign('rating_img',$rating_img);
$xoopsTpl->assign('display',$display);
$xoopsTpl->assign('display_icon',$display_icon);
$xoopsTpl->assign('display_stat',$display_stat);

///////////////////////////////
// show Poll
if ($topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "vote")){
if ($forumdata['topic_haspoll'] == 1)
{
	$poll_edit = newbb_displayImage($forumImage['edit'],_MD_EDITPOLL);
    $poll_delete = newbb_displayImage($forumImage['delete'],_MD_DELETEPOLL);
    $poll_restart = newbb_displayImage($forumImage['restart'],_MD_RESTARTPOLL);

	$adminpoll_actions = array();
    $adminpoll_actions['editpoll'] = '<tr><td class="head"><small><a class="newbb_link" href="'.$forumUrl['root'].'/polls.php?op=edit&amp;poll_id='.$forumdata['poll_id'].'&amp;topic_id='.$topic_id.'&amp;forum='.$forum.'">'.$poll_edit.'&nbsp;'._MD_EDITPOLL.'</a></small></td></tr>';
    $adminpoll_actions['deletepoll'] = '<tr><td class="head"><small><a class="newbb_link" href="'.$forumUrl['root'].'/polls.php?op=delete&amp;poll_id='.$forumdata['poll_id'].'&amp;topic_id='.$topic_id.'&amp;forum='.$forum.'">'.$poll_delete.'&nbsp;'._MD_DELETEPOLL.'</a></small></td></tr>';
    $adminpoll_actions['restartpoll'] = '<tr><td class="head"><small><a class="newbb_link" href="'.$forumUrl['root'].'/polls.php?op=restart&amp;poll_id='.$forumdata['poll_id'].'&amp;topic_id='.$topic_id.'&amp;forum='.$forum.'">'.$poll_restart.'&nbsp;'._MD_RESTARTPOLL.'</a></small></td></tr>';

    $xoopsTpl->assign('adminpoll_actions', $adminpoll_actions);
	$xoopsTpl->assign('topic_poll', 1);
	$poll = new XoopsPoll($forumdata['poll_id']);
	if ( is_object($xoopsUser) ) {
			if ( XoopsPollLog::hasVoted($forumdata['poll_id'], $_SERVER['REMOTE_ADDR'], $xoopsUser->getVar("uid")) ) {
				pollresults($forumdata['poll_id']);
				$xoopsTpl->assign('topic_pollresult', 1);
				setcookie("bb_polls[$forumdata[poll_id]]", 1);
			} else {
				pollview($forumdata['poll_id']);
				setcookie("bb_polls[$forumdata[poll_id]]", 1);
			}
		} else {
			if ( XoopsPollLog::hasVoted($forumdata['poll_id'], $_SERVER['REMOTE_ADDR']) ) {
				pollresults($forumdata['poll_id']);
				$xoopsTpl->assign('topic_pollresult', 1);
				setcookie("bb_polls[$forumdata[poll_id]]", 1);
			} else {
				pollview($forumdata['poll_id']);
				setcookie("bb_polls[$forumdata[poll_id]]", 1);
			}
		}
	}
}

else {
	if ($forumdata['topic_haspoll'] == 1)
	{
		$xoopsTpl->assign('topic_poll', 0);
		$xoopsTpl->assign('topic_pollresult', 0);
	}
}
if ($topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "addpoll")){

	if ($forumdata['topic_haspoll'] == 1)
	{
		$xoopsTpl->assign('forum_addpoll', "");
	}
	else {
	$t_poll = newbb_displayImage($forumImage['t_poll'],_MD_ADDPOLL);

	$xoopsTpl->assign('forum_addpoll', "<a href=\"polls.php?op=add&amp;forum=".$forumdata['forum_id']."&amp;topic_id=".$topic_id."\">".$t_poll."</a>&nbsp;");
	}
}
else {
	$xoopsTpl->assign('forum_addpoll', "");
}
$xoopsTpl->assign('p_up',newbb_displayImage($forumImage['p_up'],_MD_TOP));
$xoopsTpl->assign('rating_enable', $xoopsModuleConfig['rating_enabled']);
$xoopsTpl->assign('groupbar_enable', $xoopsModuleConfig['groupbar_enabled']);
$xoopsTpl->assign('anonymous_prefix', $xoopsModuleConfig['anonymous_prefix']);

$xoopsTpl->assign('threaded',newbb_displayImage($forumImage['threaded']));
$xoopsTpl->assign('flat',newbb_displayImage($forumImage['flat']));
$xoopsTpl->assign('left',newbb_displayImage($forumImage['left']));
$xoopsTpl->assign('right',newbb_displayImage($forumImage['right']));
$xoopsTpl->assign('down',newbb_displayImage($forumImage['doubledown']));
$xoopsTpl->assign('down2',newbb_displayImage($forumImage['down']));
$xoopsTpl->assign('up',newbb_displayImage($forumImage['up']));
$xoopsTpl->assign('printer',newbb_displayImage($forumImage['printer']));
$xoopsTpl->assign('personal',newbb_displayImage($forumImage['personal']));
$xoopsTpl->assign('post_content',newbb_displayImage($forumImage['post_content']));

$xoopsTpl->assign('rate1',newbb_displayImage($forumImage['rate1'],_MD_RATE1));
$xoopsTpl->assign('rate2',newbb_displayImage($forumImage['rate2'],_MD_RATE2));
$xoopsTpl->assign('rate3',newbb_displayImage($forumImage['rate3'],_MD_RATE3));
$xoopsTpl->assign('rate4',newbb_displayImage($forumImage['rate4'],_MD_RATE4));
$xoopsTpl->assign('rate5',newbb_displayImage($forumImage['rate5'],_MD_RATE5));

// create jump box
if($xoopsModuleConfig['show_jump']) $forum_jumpbox = make_jumpbox($forum);
else $forum_jumpbox = '';
$xoopsTpl->assign(array('forum_jumpbox' => $forum_jumpbox, 'lang_forum_index' => sprintf(_MD_FORUMINDEX,$xoopsConfig['sitename']), 'lang_from' => _MD_FROM, 'lang_joined' => _MD_JOINED, 'lang_posts' => _MD_POSTS, 'lang_poster' => _MD_POSTER, 'lang_thread' => _MD_THREAD, 'lang_edit' => _EDIT, 'lang_delete' => _DELETE, 'lang_reply' => _REPLY, 'lang_postedon' => _MD_POSTEDON,'lang_groups' => _MD_GROUPS));
$xoopsTpl->assign('show_jumpbox', $xoopsModuleConfig['show_jump']);
if ($xoopsModuleConfig['rss_enable'] == 1) {
    $xoopsTpl->assign("rss_enable","<div align='right'><a href='".XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/rss.php' target='_blank'>".newbb_displayImage($forumImage['rss'])."</a></div>");
}
include XOOPS_ROOT_PATH.'/footer.php';
?>