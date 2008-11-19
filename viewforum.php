<?php
// $Id: viewforum.php,v 1.3 2005/10/19 17:20:28 phppp Exp $
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

if ( empty($_GET['forum']) ) {
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
}

if (isset($_GET['mark_read'])){
    if(1 == intval($_GET['mark_read'])){ // marked as read
	    $markvalue = 1;
	    $markresult = _MD_MARK_READ;
    }else{ // marked as unread
	    $markvalue = 0;
	    $markresult = _MD_MARK_UNREAD;
    }
	newbb_setRead_topic($markvalue, $_GET['forum']);
	$url = "viewforum.php?start=".$_GET['start']."&amp;forum=".$_GET['forum']."&amp;sortname=".$_GET['sortname']."&amp;sortorder=".$_GET['sortorder']."&amp;since=".$_GET['since'];
    redirect_header($url,2, $markresult);
}

$forum_id = intval($_GET['forum']);
$type = (!empty($_GET['type']) && in_array($_GET['type'], array("active", "pending", "deleted", "digest", "unreplied", "unread")))? $_GET['type'] : "";
$mode = !empty($_GET['mode']) ? intval($_GET['mode']) : 0;
$mode = (!empty($type) && in_array($type, array("active", "pending", "deleted")))?2:$mode;

$forum_handler =& icms_getmodulehandler('forum', basename( dirname( __FILE__ ) ), 'iforum' );
$forum_obj =& $forum_handler->get($forum_id);
if (!$forum_handler->getPermission($forum_obj)){
    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
    exit();
}
newbb_setRead("forum", $forum_id, $forum_obj->getVar("forum_last_post_id"));


$xoops_pagetitle = $forum_obj->getVar('forum_name') . " [" .$xoopsModule->getVar('name')."]";
if(!empty($xoopsModuleConfig['rss_enable'])){
	$xoops_module_header .= '<link rel="alternate" type="application/xml+rss" title="'.$xoopsModule->getVar('name').'-'.$forum_obj->getVar('forum_name').'" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/rss.php?f='.$forum_id.'" />';
}

$xoopsOption['template_main'] = 'newbb_viewforum.html';
$xoopsOption['xoops_pagetitle']= $xoops_pagetitle;
$xoopsOption['xoops_module_header']= $xoops_module_header;
include XOOPS_ROOT_PATH."/header.php";
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);
$xoopsTpl->assign('xoops_pagetitle', $xoops_pagetitle);
$xoopsTpl->assign("forum_id", $forum_obj->getVar('forum_id'));

$isadmin = newbb_isAdmin($forum_obj);
$xoopsTpl->assign('viewer_level', ($isadmin)?2:(is_object($xoopsUser)?1:0) );
/* Only admin has access to admin mode */
if(!$isadmin){
	$type = (!empty($type) && in_array($type, array("active", "pending", "deleted")))?"":$type;
	$mode = 0;
}
$xoopsTpl->assign('mode', $mode);
$xoopsTpl->assign('type', $type);

if ($xoopsModuleConfig['wol_enabled']){
	$online_handler =& icms_getmodulehandler('online', basename( dirname( __FILE__ ) ), 'iforum' );
	$online_handler->init($forum_obj);
    $xoopsTpl->assign('online', $online_handler->show_online());
}

$getpermission =& icms_getmodulehandler('permission', basename( dirname( __FILE__ ) ), 'iforum' );
$permission_set = $getpermission->getPermissions("forum", $forum_obj->getVar('forum_id'));

$t_new = newbb_displayImage($forumImage['t_new'],_MD_POSTNEW);
if ($forum_handler->getPermission($forum_obj, "post")){
	$xoopsTpl->assign('forum_post_or_register', "<a href=\"newtopic.php?forum=".$forum_obj->getVar('forum_id')."\">".$t_new."</a>");
	if ($forum_handler->getPermission($forum_obj, "addpoll") && $forum_obj->getVar('allow_polls') == 1){
		$t_poll = newbb_displayImage($forumImage['t_poll'],_MD_ADDPOLL);
		$xoopsTpl->assign('forum_addpoll', "<a href=\"newtopic.php?op=add&amp;forum=".$forum_obj->getVar('forum_id')."\">".$t_poll."</a>&nbsp;");
 	}
} else {
    if ( !empty($GLOBALS["xoopsModuleConfig"]["show_reg"]) && !is_object($xoopsUser)) {
	    $redirect = preg_replace("|(.*)\/modules\/".basename( dirname( __FILE__ ) )."\/(.*)|", "\\1/modules/".basename( dirname( __FILE__ ) )."/newtopic.php?forum=".$forum_obj->getVar('forum_id'), htmlspecialchars($xoopsRequestUri));
		$xoopsTpl->assign('forum_post_or_register', '<a href="'.XOOPS_URL.'/user.php?xoops_redirect='.$redirect.'">'._MD_REGTOPOST.'</a>');
		$xoopsTpl->assign('forum_addpoll', "");
	} else {
		$xoopsTpl->assign('forum_post_or_register', "");
		$xoopsTpl->assign('forum_addpoll', "");
	}
}

if($forum_obj->getVar('parent_forum')){
	$parent_forum_obj =& $forum_handler->get($forum_obj->getVar('parent_forum'), array("forum_name"));
	$parentforum = array("id"=>$forum_obj->getVar('parent_forum'), "name"=>$parent_forum_obj->getVar("forum_name"));
	unset($parent_forum_obj);
	$xoopsTpl->assign_by_ref("parentforum", $parentforum);
}else{
	$criteria =& new Criteria("parent_forum", $forum_id);
	$criteria->setSort("forum_order");
	if($forums_obj =& $forum_handler->getAll($criteria)){
		$subforum_array = $forum_handler->display($forums_obj);
		$subforum = array_values($subforum_array[$forum_id]);
		unset($forums_obj, $subforum_array);
		$xoopsTpl->assign_by_ref("subforum", $subforum);
	}
}

$category_handler =& icms_getmodulehandler("category", basename( dirname( __FILE__ ) ), 'iforum' );
$category_obj =& $category_handler->get($forum_obj->getVar("cat_id"), array("cat_title"));
$xoopsTpl->assign('category', array("id" => $forum_obj->getVar("cat_id"), "title" => $category_obj->getVar('cat_title')));

$xoopsTpl->assign('forum_index_title', sprintf(_MD_FORUMINDEX,htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
$xoopsTpl->assign('folder_topic', newbb_displayImage($forumImage['folder_topic']));
$xoopsTpl->assign('forum_name', $forum_obj->getVar('forum_name'));
$xoopsTpl->assign('forum_moderators', $forum_obj->disp_forumModerators());

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

$xoopsTpl->assign_by_ref('forum_selection_order', $forum_selection_order);

$since = isset($_GET['since']) ? intval($_GET['since']) : $xoopsModuleConfig["since_default"];
$forum_selection_since = newbb_sinceSelectBox($since);

$xoopsTpl->assign_by_ref('forum_selection_since', $forum_selection_since);
$xoopsTpl->assign('h_topic_link', "viewforum.php?forum=$forum_id&amp;sortname=t.topic_title&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_title" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_reply_link', "viewforum.php?forum=$forum_id&amp;sortname=t.topic_replies&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_replies" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_poster_link', "viewforum.php?forum=$forum_id&amp;sortname=u.uname&amp;since=$since&amp;sortorder=". (($sortname == "u.uname" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_views_link', "viewforum.php?forum=$forum_id&amp;sortname=t.topic_views&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_views" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_rating_link', "viewforum.php?forum=$forum_id&amp;sortname=t.topic_ratings&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_ratings" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_date_link', "viewforum.php?forum=$forum_id&amp;sortname=p.post_time&amp;since=$since&amp;sortorder=". (($sortname == "p.post_time" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('h_publish_link', "viewforum.php?forum=$forum_id&amp;sortname=t.topic_time&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_time" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$xoopsTpl->assign('forum_since', $since); // For $since in search.php

$startdate = empty($since)?0:(time() - newbb_getSinceTime($since));
$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;

list($allTopics, $sticky) = $forum_handler->getAllTopics($forum_obj,$startdate,$start,$sortname,$sortorder,$type,$xoopsModuleConfig['post_excerpt']);
$xoopsTpl->assign_by_ref('topics', $allTopics);
//unset($allTopics);
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

$mark_read_link = "viewforum.php?mark_read=1&amp;start=$start&amp;forum=".$forum_obj->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=$type";
$mark_unread_link = "viewforum.php?mark_read=2&amp;start=$start&amp;forum=".$forum_obj->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=$type";
$xoopsTpl->assign('mark_read', $mark_read_link);
$xoopsTpl->assign('mark_unread', $mark_unread_link);

$xoopsTpl->assign('post_link', "viewpost.php?forum=".$forum_obj->getVar('forum_id'));
$xoopsTpl->assign('newpost_link', "viewpost.php?type=new&amp;forum=".$forum_obj->getVar('forum_id'));
$xoopsTpl->assign('all_link', "viewforum.php?start=$start&amp;forum=".$forum_obj->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since");
$xoopsTpl->assign('digest_link', "viewforum.php?start=$start&amp;forum=".$forum_obj->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=digest");
$xoopsTpl->assign('unreplied_link', "viewforum.php?start=$start&amp;forum=".$forum_obj->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=unreplied");
$xoopsTpl->assign('unread_link', "viewforum.php?start=$start&amp;forum=".$forum_obj->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=unread");
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
	case 'active':
		$current_type = '['._MD_TYPE_ADMIN.']';
		break;
	case 'pending':
		$current_type = '['._MD_TYPE_PENDING.']';
		break;
	case 'deleted':
		$current_type = '['._MD_TYPE_DELETED.']';
		break;
	default:
		$current_type = '';
		break;
	}
$xoopsTpl->assign('forum_topictype', $current_type);

$all_topics = $forum_handler->getTopicCount($forum_obj,$startdate,$type);
if ( $all_topics > $xoopsModuleConfig['topics_per_page']) {
	include XOOPS_ROOT_PATH.'/class/pagenav.php';
	$nav = new XoopsPageNav($all_topics, $xoopsModuleConfig['topics_per_page'], $start, "start", 'forum='.$forum_obj->getVar('forum_id').'&amp;sortname='.$sortname.'&amp;sortorder='.$sortorder.'&amp;since='.$since."&amp;type=$type&amp;mode=".$mode);
	$xoopsTpl->assign('forum_pagenav', $nav->renderNav(4));
} else {
	$xoopsTpl->assign('forum_pagenav', '');
}

if(!empty($xoopsModuleConfig['show_jump'])){
	$xoopsTpl->assign('forum_jumpbox', newbb_make_jumpbox($forum_obj->getVar('forum_id')));
}
$xoopsTpl->assign('down',newbb_displayImage($forumImage['doubledown']));
$xoopsTpl->assign('menumode',$menumode);
$xoopsTpl->assign('menumode_other',$menumode_other);

if($xoopsModuleConfig['show_permissiontable']){
	$permission_table = & $getpermission->permission_table($permission_set,$forum_obj->getVar('forum_id'), false, $isadmin);
	$xoopsTpl->assign_by_ref('permission_table', $permission_table);
	unset($permission_table);
}

if ($xoopsModuleConfig['rss_enable'] == 1) {
	$xoopsTpl->assign("rss_button","<div align='right'><a href='".XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/rss.php?f=".$forum_obj->getVar('forum_id')."' title='RSS feed' target='_blank'>".newbb_displayImage($forumImage['rss'], 'RSS feed')."</a></div>");
}

include XOOPS_ROOT_PATH."/footer.php";
?>