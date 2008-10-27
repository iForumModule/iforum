<?php
// $Id: viewall.php,v 1.3 2005/10/19 17:20:28 phppp Exp $
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
//  Author: phppp (D.J., infomax@gmail.com)                                  //
//  URL: http://xoopsforge.com, http://xoops.org.cn                          //
//  Project: Article Project                                                 //
//  ------------------------------------------------------------------------ //

include "header.php";

$type = (!empty($_GET['type']) && in_array($_GET['type'], array("active", "pending", "deleted", "digest", "unreplied", "unread")))? $_GET['type'] : "";
$mode = !empty($_GET['mode']) ? intval($_GET['mode']) : 0;
$mode = (!empty($type) && in_array($type, array("active", "pending", "deleted")))?2:$mode;

$isadmin = newbb_isAdmin();
/* Only admin has access to admin mode */
if(!$isadmin){
	$type = (!empty($type) && in_array($type, array("active", "pending", "deleted")))?"":$type;
	$mode = 0;
}

if(!empty($xoopsModuleConfig['rss_enable'])){
	$xoops_module_header .= '<link rel="alternate" type="application/xml+rss" title="'.$xoopsModule->getVar('name').'" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/rss.php" />';
}
$xoopsOption['xoops_module_header']= $xoops_module_header;
$xoopsOption['template_main'] = 'newbb_viewall.html';
include XOOPS_ROOT_PATH."/header.php";
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);

$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
$viewall_forums = $forum_handler->getForums(0,'access', array("forum_id", "cat_id", "forum_name")); // get all accessible forums

if ($xoopsModuleConfig['wol_enabled']){
	$online_handler =& xoops_getmodulehandler('online', 'newbb');
	$online_handler->init();
    $xoopsTpl->assign('online', $online_handler->show_online());
}
$xoopsTpl->assign('forum_index_title', sprintf(_MD_FORUMINDEX,htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
$xoopsTpl->assign('folder_topic', newbb_displayImage($forumImage['folder_topic']));

$sel_sort_array = array("t.topic_title"=>_MD_TOPICTITLE, "u.uname"=>_MD_TOPICPOSTER, "t.topic_time"=>_MD_TOPICTIME, "t.topic_replies"=>_MD_NUMBERREPLIES, "t.topic_views"=>_MD_VIEWS, "p.post_time"=>_MD_LASTPOSTTIME);
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
$xoopsTpl->assign_by_ref('forum_selection_sort', $forum_selection_sort);

$sortorder = (!isset($_GET['sortorder']) || $_GET['sortorder'] != "ASC") ? "DESC" : "ASC";
$forum_selection_order = '<select name="sortorder">';
$forum_selection_order .= '<option value="ASC"'.(($sortorder == "ASC") ? ' selected="selected"' : '').'>'._MD_ASCENDING.'</option>';
$forum_selection_order .= '<option value="DESC"'.(($sortorder == "DESC") ? ' selected="selected"' : '').'>'._MD_DESCENDING.'</option>';
$forum_selection_order .= '</select>';

// assign to template
$xoopsTpl->assign_by_ref('forum_selection_order', $forum_selection_order);

$since = isset($_GET['since']) ? intval($_GET['since']) : $xoopsModuleConfig["since_default"];
$forum_selection_since = newbb_sinceSelectBox($since);

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

$startdate = empty($since)?0:(time() - newbb_getSinceTime($since));
$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;

$all_link = "viewall.php?start=$start&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since";
$post_link = "viewpost.php?since=$since";
$newpost_link = "viewpost.php?new=1&amp;since=$since";
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
	case 'active':
		$current_type = _MD_ALL. ' ['._MD_TYPE_ADMIN.']';
		$current_link = $all_link.'&amp;type='.$type;
		break;
	case 'pending':
		$current_type = _MD_ALL. ' ['._MD_TYPE_PENDING.']';
		$current_link = $all_link.'&amp;type='.$type;
		break;
	case 'deleted':
		$current_type = _MD_ALL. ' ['._MD_TYPE_DELETED.']';
		$current_link = $all_link.'&amp;type='.$type;
		break;
	default:
		$type = 'all';
		$current_type = _MD_ALL;
		$current_link = $all_link;
		break;
	}

list($allTopics, $sticky) = $forum_handler->getAllTopics($viewall_forums, $startdate, $start, $sortname, $sortorder, $type);
$xoopsTpl->assign_by_ref('topics', $allTopics);
unset($allTopics);
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
$xoopsTpl->assign('post_link', $post_link);
$xoopsTpl->assign('newpost_link', $newpost_link);
$xoopsTpl->assign('digest_link', $digest_link);
$xoopsTpl->assign('unreplied_link', $unreplied_link);
$xoopsTpl->assign('unread_link', $unread_link);
$xoopsTpl->assign('current_type', $current_type);
$xoopsTpl->assign('current_link', $current_link);

$all_topics = $forum_handler->getTopicCount($viewall_forums, $startdate, $type);
unset($viewall_forums);
if ( $all_topics > $xoopsModuleConfig['topics_per_page']) {
	include XOOPS_ROOT_PATH.'/class/pagenav.php';
	$nav = new XoopsPageNav($all_topics, $xoopsModuleConfig['topics_per_page'], $start, "start", 'sortname='.$sortname.'&amp;sortorder='.$sortorder.'&amp;since='.$since."&amp;type=$type&amp;mode=".$mode);
	$xoopsTpl->assign('forum_pagenav', $nav->renderNav(4));
} else {
	$xoopsTpl->assign('forum_pagenav', '');
}
if(!empty($xoopsModuleConfig['show_jump'])){
	$xoopsTpl->assign('forum_jumpbox', newbb_make_jumpbox());
}
$xoopsTpl->assign('down',newbb_displayImage($forumImage['doubledown']));
$xoopsTpl->assign('menumode',$menumode);
$xoopsTpl->assign('menumode_other',$menumode_other);

$xoopsTpl->assign('mode', $mode);
$xoopsTpl->assign('type', $type);
$xoopsTpl->assign('viewer_level', ($isadmin)?2:(is_object($xoopsUser)?1:0) );

$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name'). ' - ' .$current_type);

include XOOPS_ROOT_PATH."/footer.php";
?>