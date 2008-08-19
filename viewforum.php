<?php
// $Id: viewforum.php,v 1.1.1.48 2004/11/14 14:57:31 praedator Exp $
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

include "header.php";

if ( !isset($_GET['forum']) ) {
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
}

$forum = isset($_GET['forum'])?intval($_GET['forum']):0; // ?
$topics = isset($_GET['topics'])?strval($_GET['topics']):'';
$type = isset($_GET['type'])?strtolower($_GET['type']):'';

if (isset($_GET['mark_read'])){
	$topic_lastread = newbb_getcookie('LT',true);
	$topics = newbb_getcookie("ST",true);
    if(1 == intval($_GET['mark_read'])){ 						// mark topics on this page as read
	    foreach($topics as $topic){
			$topic_lastread[$topic] = time();
		}
		newbb_setcookie("LT", $topic_lastread);
	    $marktarget = _MD_ALL_FORUM_MARKED;
	    $markresult = _MD_MARK_READ;
    }else{ 					// mark topics as unread
	    foreach($topics as $topic){
			$topic_lastread[$topic] = false;
		}
		newbb_setcookie("LT", $topic_lastread);
	    $marktarget = _MD_ALL_TOPIC_MARKED;
	    $markresult = _MD_MARK_UNREAD;
    }

	$url = "viewforum.php?start=".$_GET['start']."&amp;forum=$forum&amp;sortname=".$_GET['sortname']."&amp;sortorder=".$_GET['sortorder']."&amp;sortsince=".$_GET['sortsince']."&amp;type=$type";
    redirect_header($url,2, $marktarget.' '.$markresult);
}

$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
$forumid = $forum;
$forum =& $forum_handler->get($forum);
if (!$forum_handler->getPermission($forum)){
    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
    exit();
}

// cookie should be handled before calling XOOPS_ROOT_PATH."/header.php", otherwise it won't work for cache
$forum_lastview = newbb_getcookie('LF',true);
$forum_lastview[$forum->getVar('forum_id')] = time();
newbb_setcookie("LF", $forum_lastview);

$forum_name = newbb_html2text($myts->undoHtmlSpecialChars($forum->getVar('forum_name')));
$xoops_pagetitle = $xoopsModule->getVar('name'). ' - ' .$forum_name;

$xoopsOption['template_main'] = 'newbb_viewforum.html';
include XOOPS_ROOT_PATH."/header.php";

$xoopsTpl->assign('xoops_module_header', $newbb_module_header);
$xoopsTpl->assign('xoops_pagetitle', $xoops_pagetitle);
$xoopsTpl->assign("forum_id", $forum->getVar('forum_id'));

if ($xoopsModuleConfig['wol_enabled']){
	$online_handler =& xoops_getmodulehandler('online', 'newbb');
	$online_handler->init($forum);
    $xoopsTpl->assign('online', $online_handler->show_online());
    $xoopsTpl->assign('color_admin', $xoopsModuleConfig['wol_admin_col']);
    $xoopsTpl->assign('color_mod', $xoopsModuleConfig['wol_mod_col']);
}

$getpermission =& xoops_getmodulehandler('permission', 'newbb');
$permission_set = $getpermission->getPermissions("topic");

$show_reg = 0;
$t_new = newbb_displayImage($forumImage['t_new'],_MD_POSTNEW);

if ($forum_handler->getPermission($forum, "post")){
	$xoopsTpl->assign('viewer_can_post', true);
	$xoopsTpl->assign('forum_post_or_register', "<a href=\"newtopic.php?forum=".$forum->getVar('forum_id')."\">".$t_new."</a>");
	if ($forum_handler->getPermission($forum, "addpoll")){
		$t_poll = newbb_displayImage($forumImage['t_poll'],_MD_ADDPOLL);
		$xoopsTpl->assign('forum_addpoll', "<a href=\"newtopic.php?op=add&amp;forum=".$forum->getVar('forum_id')."\">".$t_poll."</a>&nbsp;");
 	}
} else {
	$xoopsTpl->assign('viewer_can_post', false);
	if ( $show_reg == 1 ) {
		$xoopsTpl->assign('forum_post_or_register', '<a href="'.XOOPS_URL.'/user.php?xoops_redirect='.htmlspecialchars($xoopsRequestUri).'">'._MD_REGTOPOST.'</a>');
		$xoopsTpl->assign('forum_addpoll', "");
	} else {
		$xoopsTpl->assign('forum_post_or_register', "");
		$xoopsTpl->assign('forum_addpoll', "");
	}
}


if($forum->isSubforum())
{
	$q = "select forum_name from ".$xoopsDB->prefix('bb_forums')." WHERE forum_id=".$forum->getVar('parent_forum');
	$row = $xoopsDB->fetchArray($xoopsDB->query($q));
	$xoopsTpl->assign(array('parent_forum' => $forum->getVar('parent_forum'), 'parent_name' => $row['forum_name']));
}
$xoopsTpl->assign('forum_index_title', sprintf(_MD_FORUMINDEX,$xoopsConfig['sitename']));
$xoopsTpl->assign('folder_topic', newbb_displayImage($forumImage['folder_topic']));
$xoopsTpl->assign('forum_name', $forum->getVar('forum_name'));
$xoopsTpl->assign('forum_moderators', $forum->disp_forumModerators());

$sel_sort_array = array("t.topic_title"=>_MD_TOPICTITLE, "t.topic_replies"=>_MD_NUMBERREPLIES, "u.uname"=>_MD_TOPICPOSTER, "t.topic_views"=>_MD_VIEWS, "p.post_time"=>_MD_LASTPOSTTIME);
if ( !isset($_GET['sortname']) || !in_array($_GET['sortname'], array_keys($sel_sort_array)) ) {
	$sortname = "p.post_time";
} else {
	$sortname = $_GET['sortname'];
}

$forum_selection_sort = '<select name="sortname">';
foreach ( $sel_sort_array as $sort_k => $sort_v ) {
	$forum_selection_sort .= '<option value="'.$sort_k.'"'.(($sortname == $sort_k) ? ' selected="selected"' : '').'>'.$sort_v.'</option>';
}
$forum_selection_sort .= '</select>';

// assign to template
$xoopsTpl->assign('forum_selection_sort', $forum_selection_sort);

$sortorder = (!isset($_GET['sortorder']) || $_GET['sortorder'] != "ASC") ? "DESC" : "ASC";
$forum_selection_order = '<select name="sortorder">';
$forum_selection_order .= '<option value="ASC"'.(($sortorder == "ASC") ? ' selected="selected"' : '').'>'._MD_ASCENDING.'</option>';
$forum_selection_order .= '<option value="DESC"'.(($sortorder == "DESC") ? ' selected="selected"' : '').'>'._MD_DESCENDING.'</option>';
$forum_selection_order .= '</select>';

// assign to template
$xoopsTpl->assign('forum_selection_order', $forum_selection_order);

$sortsince = !empty($_GET['sortsince']) ? intval($_GET['sortsince']) : 100;
$sel_since_array = array(1, 2, 5, 10, 20, 30, 40, 60, 75, 100);
$forum_selection_since = '<select name="sortsince">';
foreach ($sel_since_array as $sort_since_v) {
	$forum_selection_since .= '<option value="'.$sort_since_v.'"'.(($sortsince == $sort_since_v) ? ' selected="selected"' : '').'>'.sprintf(_MD_FROMLASTDAYS,$sort_since_v).'</option>';
}
$forum_selection_since .= '<option value="365"'.(($sortsince == 365) ? ' selected="selected"' : '').'>'.sprintf(_MD_THELASTYEAR,365).'</option>';
$forum_selection_since .= '<option value="1000"'.(($sortsince == 1000) ? ' selected="selected"' : '').'>'.sprintf(_MD_BEGINNING,1000).'</option>';
$forum_selection_since .= '</select>';

// assign to template
$xoopsTpl->assign('forum_selection_since', $forum_selection_since);
$xoopsTpl->assign('h_topic_link', "viewforum.php?forum=$forumid&amp;sortname=t.topic_title&amp;sortsince=$sortsince&amp;sortorder=". (($sortname == "t.topic_title" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_reply_link', "viewforum.php?forum=$forumid&amp;sortname=t.topic_replies&amp;sortsince=$sortsince&amp;sortorder=". (($sortname == "t.topic_replies" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_poster_link', "viewforum.php?forum=$forumid&amp;sortname=u.uname&amp;sortsince=$sortsince&amp;sortorder=". (($sortname == "u.uname" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_views_link', "viewforum.php?forum=$forumid&amp;sortname=t.topic_views&amp;sortsince=$sortsince&amp;sortorder=". (($sortname == "t.topic_views" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_ratings_link', "viewforum.php?forum=$forumid&amp;sortname=t.topic_ratings&amp;sortsince=$sortsince&amp;sortorder=". (($sortname == "t.topic_ratings" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_date_link', "viewforum.php?forum=$forumid&amp;sortname=p.post_time&amp;sortsince=$sortsince&amp;sortorder=". (($sortname == "p.post_time" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('forum_since', $sortsince); // For $since in search.php

$startdate = time() - (86400* $sortsince);
$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;

list($allTopics, $sticky) = $forum_handler->getAllTopics($forum,$startdate,$start,$sortname,$sortorder,$type);

$xoopsTpl->assign('topics', $allTopics);
$xoopsTpl->assign("subforum", $forum->getSubforums());
$xoopsTpl->assign('sticky', $sticky);
$xoopsTpl->assign('rating_enable', $xoopsModuleConfig['rating_enabled']);
$xoopsTpl->assign('img_newposts', newbb_displayImage($forumImage['newposts_topic']));
$xoopsTpl->assign('img_hotnewposts', newbb_displayImage($forumImage['hot_newposts_topic']));
$xoopsTpl->assign('img_folder', newbb_displayImage($forumImage['folder_topic']));
$xoopsTpl->assign('img_hotfolder', newbb_displayImage($forumImage['hot_folder_topic']));
$xoopsTpl->assign('img_locked', newbb_displayImage($forumImage['locked_topic']));

$xoopsTpl->assign('img_sticky', newbb_displayImage($forumImage['folder_sticky'],_MD_TOPICSTICKY));
$xoopsTpl->assign('img_digest', newbb_displayImage($forumImage['folder_digest'],_MD_TOPICDIGEST));
$xoopsTpl->assign('img_poll', newbb_displayImage($forumImage['poll'],_MD_TOPICHASPOLL));

$mark_read_link = "viewforum.php?mark_read=1&amp;start=$start&amp;forum=".$forum->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;sortsince=$sortsince&amp;type=$type";
$mark_unread_link = "viewforum.php?mark_read=2&amp;start=$start&amp;forum=".$forum->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;sortsince=$sortsince&amp;type=$type";
$xoopsTpl->assign('mark_read', $mark_read_link);
$xoopsTpl->assign('mark_unread', $mark_unread_link);

$xoopsTpl->assign('digest_link', "viewforum.php?start=$start&amp;forum=".$forum->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;sortsince=$sortsince&amp;type=digest");
$xoopsTpl->assign('unreplied_link', "viewforum.php?start=$start&amp;forum=".$forum->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;sortsince=$sortsince&amp;type=unreplied");
$xoopsTpl->assign('unread_link', "viewforum.php?start=$start&amp;forum=".$forum->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;sortsince=$sortsince&amp;type=unread");
switch($type){
	case 'digest':
		$current_type = '['._MD_DIGEST.']';
		break;
	case 'unreplied':
		$current_type = '['._MD_UNREPLIED.']';
		break;
	case 'unread':
		$current_type = '['._MD_UNREAD.']';
		break;
	default:
		$current_type = '';
		break;
	}
$xoopsTpl->assign('forum_topictype', $current_type);

$all_topics = $forum_handler->getTopicCount($forum,$startdate,$type);
if ( $all_topics > $xoopsModuleConfig['topics_per_page']) {
	include XOOPS_ROOT_PATH.'/class/pagenav.php';
	$nav = new XoopsPageNav($all_topics, $xoopsModuleConfig['topics_per_page'], $start, "start", 'forum='.$forum->getVar('forum_id').'&amp;sortname='.$sortname.'&amp;sortorder='.$sortorder.'&amp;sortsince='.$sortsince."&amp;type=$type");
	$xoopsTpl->assign('forum_pagenav', $nav->renderImageNav(4));
} else {
	$xoopsTpl->assign('forum_pagenav', '');
}

$xoopsTpl->assign('show_jumpbox', $xoopsModuleConfig['show_jump']);
$xoopsTpl->assign('forum_jumpbox', make_jumpbox($forum));
$xoopsTpl->assign('down',newbb_displayImage($forumImage['doubledown']));

$isadmin = newbb_isAdmin($forum);
$permission_table = ($xoopsModuleConfig['show_permissiontable'])?$getpermission->permission_table($permission_set,$forum->getVar('forum_id'), false, $isadmin):'';
$xoopsTpl->assign('permission_table', $permission_table);

// the cookie should be set before calling xoops/header.php, however, ...
newbb_setcookie("ST", array_keys($allTopics));

include XOOPS_ROOT_PATH."/footer.php";
?>