<?php
// $Id: viewall.php,v 1.1.4.3 2005/01/10 01:49:41 phppp Exp $
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

$type = isset($_GET['type'])?strtolower($_GET['type']):'all';

$xoopsOption['template_main'] = 'newbb_viewall.html';
include XOOPS_ROOT_PATH."/header.php";

$forum_handler =& xoops_getmodulehandler('forum', 'newbb');

$xoopsTpl->assign('xoops_module_header', $newbb_module_header);

$viewall_forums = $forum_handler->getForums(0,'access'); // get all accessible forums

if ($xoopsModuleConfig['wol_enabled']){
	$online_handler =& xoops_getmodulehandler('online', 'newbb');
	$online_handler->init();
    $xoopsTpl->assign('online', $online_handler->show_online());
    $xoopsTpl->assign('color_admin', $xoopsModuleConfig['wol_admin_col']);
    $xoopsTpl->assign('color_mod', $xoopsModuleConfig['wol_mod_col']);
}
$xoopsTpl->assign('forum_index_title', sprintf(_MD_FORUMINDEX,htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
$xoopsTpl->assign('folder_topic', newbb_displayImage($forumImage['folder_topic']));

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

$since = !empty($_GET['since']) ? intval($_GET['since']) : $xoopsModuleConfig["since_default"];
$forum_selection_since = &newbb_sinceSelectBox($since);
/*
$sel_since_array = array(1, 2, 5, 10, 20, 30, 40, 60, 75, 100);
$forum_selection_since = '<select name="since">';
foreach ($sel_since_array as $sort_since_v) {
	$forum_selection_since .= '<option value="'.$sort_since_v.'"'.(($since == $sort_since_v) ? ' selected="selected"' : '').'>'.sprintf(_MD_FROMLASTDAYS,$sort_since_v).'</option>';
}
$forum_selection_since .= '<option value="365"'.(($since == 365) ? ' selected="selected"' : '').'>'.sprintf(_MD_THELASTYEAR,365).'</option>';
$forum_selection_since .= '<option value="1000"'.(($since == 1000) ? ' selected="selected"' : '').'>'.sprintf(_MD_BEGINNING,1000).'</option>';
$forum_selection_since .= '</select>';
*/

// assign to template
$xoopsTpl->assign('forum_selection_since', $forum_selection_since);
$xoopsTpl->assign('h_topic_link', "viewall.php?sortname=t.topic_title&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_title" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_reply_link', "viewall.php?sortname=t.topic_replies&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_replies" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_poster_link', "viewall.php?sortname=u.uname&amp;since=$since&amp;sortorder=". (($sortname == "u.uname" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_views_link', "viewall.php?sortname=t.topic_views&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_views" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_forum_link', "viewall.php?sortname=t.forum_id&amp;since=$since&amp;sortorder=". (($sortname == "t.forum_id" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_ratings_link', "viewall.php?sortname=t.topic_ratings&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_ratings" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_date_link', "viewall.php?sortname=p.post_time&amp;since=$since&amp;sortorder=". (($sortname == "p.post_time" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('forum_since', $since); // For $since in search.php

$startdate = time() - newbb_getSinceTime($since);
$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;

$all_link = "viewall.php?start=$start&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since";
$digest_link = "viewall.php?start=$start&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=digest";
$unreplied_link = "viewall.php?start=$start&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=unreplied";
$unread_link = "viewall.php?start=$start&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=unread";
switch($type){
	case 'digest':
		$current_type = _MD_DIGEST;
		$current_link = $digest_link;
		break;
	case 'unreplied':
		$current_type = _MD_UNREPLIED;
		$current_link = $unreplied_link;
		break;
	case 'unread':
		$current_type = _MD_UNREAD;
		$current_link = $unread_link;
		break;
	default:
		$type = 'all';
		$current_type = _MD_ALL;
		$current_link = $all_link;
		break;
	}

list($allTopics, $sticky) = $forum_handler->getAllTopics(0,$startdate,$start,$sortname,$sortorder,$type);
$xoopsTpl->assign('topics', $allTopics);
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
$xoopsTpl->assign('all_link', $all_link);
$xoopsTpl->assign('digest_link', $digest_link);
$xoopsTpl->assign('unreplied_link', $unreplied_link);
$xoopsTpl->assign('unread_link', $unread_link);
$xoopsTpl->assign('current_type', $current_type);
$xoopsTpl->assign('current_link', $current_link);

$all_topics = $forum_handler->getTopicCount(0,$startdate,$type);
if ( $all_topics > $xoopsModuleConfig['topics_per_page']) {
	include XOOPS_ROOT_PATH.'/class/pagenav.php';
	$nav = new XoopsPageNav($all_topics, $xoopsModuleConfig['topics_per_page'], $start, "start", 'sortname='.$sortname.'&amp;sortorder='.$sortorder.'&amp;since='.$since."&amp;type=$type");
	$xoopsTpl->assign('forum_pagenav', $nav->renderImageNav(4));
} else {
	$xoopsTpl->assign('forum_pagenav', '');
}
$xoopsTpl->assign('show_jumpbox', $xoopsModuleConfig['show_jump']);
$xoopsTpl->assign('forum_jumpbox', make_jumpbox(0));
$xoopsTpl->assign('down',newbb_displayImage($forumImage['doubledown']));

$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name'). ' - ' .$current_type);

include XOOPS_ROOT_PATH."/footer.php";
?>