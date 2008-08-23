<?php
// $Id: viewpost.php,v 1.1.1.2 2005/10/19 16:23:28 phppp Exp $
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

$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;
$forum_id = !empty($_GET['forum']) ? intval($_GET['forum']) : 0;
$order = isset($_GET['order'])?$_GET['order']:"DESC";

$uid = !empty($_GET['uid']) ? intval($_GET['uid']) : 0;
$type = (!empty($_GET['type']) && in_array($_GET['type'], array("active", "pending", "deleted", "new")))? $_GET['type'] : "";
$mode = !empty($_GET['mode']) ? intval($_GET['mode']) : 0;
$mode = (!empty($type) && in_array($type, array("active", "pending", "deleted")) )?2:$mode;

$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
$post_handler =& xoops_getmodulehandler('post', 'newbb');

$isadmin = newbb_isAdmin($forum_id);
/* Only admin has access to admin mode */
if(!$isadmin){
	$type = in_array($type, array("active", "pending", "deleted"))?"":$type;
	$mode = 0;
}
if($mode){
	$_GET['viewmode'] = "flat";
}

if(empty($forum_id)){
	$forums = $forum_handler->getForums(0, "view");
	$access_forums = array_keys($forums);
}
else{
	$forum =& $forum_handler->get($forum_id);
	$forums[$forum_id] =& $forum;
	$access_forums = array($forum_id);
}

$post_perpage = $xoopsModuleConfig['posts_per_page'];

$criteria_count = new CriteriaCompo(new Criteria("forum_id", "(".implode(",",$access_forums).")", "IN"));
$criteria_post = new CriteriaCompo(new Criteria("p.forum_id", "(".implode(",",$access_forums).")", "IN"));
$criteria_post->setSort("p.post_time");
$criteria_post->setOrder($order);

if(!empty($uid)){
	$criteria_count->add(new Criteria("uid", $uid));
	$criteria_post->add(new Criteria("p.uid", $uid));
}

switch($type){
	case "pending":
		$criteria_type_count = new Criteria("approved", 0);
		$criteria_type_post = new Criteria("p.approved", 0);
		break;
	case "deleted":
		$criteria_type_count = new Criteria("approved", -1);
		$criteria_type_post = new Criteria("p.approved", -1);
		break;
	case "new":
		$criteria_type_count = new CriteriaCompo(new Criteria("post_time", intval($last_visit), ">"));
		$criteria_type_post = new CriteriaCompo(new Criteria("p.post_time", intval($last_visit), ">"));
		$criteria_type_count->add(new Criteria("approved", 1));
		$criteria_type_post->add(new Criteria("p.approved", 1));
		break;
	default:
		$criteria_type_count = new Criteria("approved", 1);
		$criteria_type_post = new Criteria("p.approved", 1);
		break;
}
$criteria_count->add($criteria_type_count);
$criteria_post->add($criteria_type_post);

$karma_handler =& xoops_getmodulehandler('karma', 'newbb');
$user_karma = $karma_handler->getUserKarma();

$valid_modes = array("flat", "compact");
$viewmode_cookie = newbb_getcookie("V");
if(isset($_GET['viewmode'])&&$_GET['viewmode']=="compact") newbb_setcookie("V", "compact", $forumCookie['expire']);
$viewmode = isset($_GET['viewmode'])?
			$_GET['viewmode']:
			(
				!empty($viewmode_cookie)?
				$viewmode_cookie:
				(
					is_object($xoopsUser)?
					$xoopsUser->getVar('umode'):
					$valid_modes[$xoopsModuleConfig['view_mode']-1]
				)
			);
$viewmode = in_array($viewmode, $valid_modes)?$viewmode:"flat";

$postCount = $post_handler->getPostCount($criteria_count);
$posts = $post_handler->getPostsByLimit($post_perpage, $start, $criteria_post);

$poster_array = array();
$topic_lastread = newbb_getcookie('LT',true);
if(count($posts)>0) foreach (array_keys($posts) as $id) {
	$poster_array[$posts[$id]->getVar('uid')] = 1;
	$topic_lastread[$posts[$id]->getVar('topic_id')] = time();
}
newbb_setcookie("LT", $topic_lastread);

$xoops_pagetitle = $xoopsModule->getVar('name'). ' - ' ._MD_VIEWALLPOSTS;
$xoopsOption['xoops_pagetitle']= $xoops_pagetitle;
$xoopsOption['xoops_module_header']= $xoops_module_header;
$xoopsOption['template_main'] = 'newbb_viewpost.html';
include XOOPS_ROOT_PATH."/header.php";

if(!empty($forum_id)){
	if (!$forum_handler->getPermission($forum, "view")){
	    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
	    exit();
	}
	if($forum->isSubforum())
	{
		$q = "select forum_name from ".$xoopsDB->prefix('bb_forums')." WHERE forum_id=".$forum->getVar('parent_forum');
		$row = $xoopsDB->fetchArray($xoopsDB->query($q));
		$xoopsTpl->assign(array('parent_forum' => $forum->getVar('parent_forum'), 'parent_name' => $myts->htmlSpecialChars($row['forum_name'])));
	}
	$xoopsTpl->assign('forum_name', $forum->getVar('forum_name'));
	$xoopsTpl->assign('forum_moderators', $forum->disp_forumModerators());

	$forum_lastview = newbb_getcookie('LF',true);
	$forum_lastview[$forum_id] = time();
	newbb_setcookie("LF", $forum_lastview);
	$xoops_pagetitle = $xoopsModule->getVar('name'). ' - ' .$forum->getVar('forum_name'). ' - ' ._MD_VIEWALLPOSTS;
	$xoopsTpl->assign("forum_id", $forum->getVar('forum_id'));

	if(!empty($xoopsModuleConfig['rss_enable'])){
		$xoops_module_header .= '<link rel="alternate" type="application/xml+rss" title="'.$xoopsModule->getVar('name').'-'.$forum->getVar('forum_name').'" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/rss.php?f='.$forum_id.'" />';
	}
}elseif(!empty($xoopsModuleConfig['rss_enable'])){
	$xoops_module_header .= '<link rel="alternate" type="application/xml+rss" title="'.$xoopsModule->getVar('name').'" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/rss.php" />';
}
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);
$xoopsTpl->assign('xoops_pagetitle', $xoops_pagetitle);

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

if ($xoopsModuleConfig['wol_enabled']){
	$online = array();
	if(!empty($user_criteria)){
		$online_handler =& xoops_getmodulehandler('online', 'newbb');
		$online_handler->init($forum_id);
		$online_full = $online_handler->getAll(new Criteria('online_uid', $user_criteria, 'IN'));
		if(is_array($online_full)&&count($online_full)>0){
			foreach ($online_full as $thisonline) {
			    if ($thisonline['online_uid'] > 0) $online[$thisonline['online_uid']] = 1;
			}
		}
	}
}

if($xoopsModuleConfig['groupbar_enabled']){
	$groups_disp = array();
	$groups = $member_handler->getGroups();
	$count = count($groups);
	for ($i = 0; $i < $count; $i++) {
		$groups_disp[$groups[$i]->getVar('groupid')] = $groups[$i]->getVar('name');
	}
	unset($groups);
}

$viewtopic_users = array();

if(count($userid_array)>0){
	$user_handler =& xoops_getmodulehandler('user', 'newbb');
	$user_handler->setUsers($users);
	$user_handler->setGroups($groups_disp);
	$user_handler->setStatus($online);
	foreach($userid_array as $userid){
		$viewtopic_users[$userid] =& $user_handler->get($userid);
	}
}
unset($users);
unset($groups_disp);

$pn =0;
$topic_handler = &xoops_getmodulehandler('topic', 'newbb');
static $suspension = array();
foreach(array_keys($posts) as $id){
	$pn++;

	$post =& $posts[$id];
    $post_title = $post->getVar('subject');

    $posticon = $post->getVar('icon');
    //if (!empty($posticon) && is_file(XOOPS_ROOT_PATH . '/images/subject/'.$posticon) ){
    if (!empty($posticon) ){
        $post_image = '<a name="' . $post->getVar('post_id') . '"><img src="' . XOOPS_URL . '/images/subject/' . htmlspecialchars($posticon) . '" alt="" /></a>';
    }else{
        $post_image = '<a name="' . $post->getVar('post_id') . '"><img src="' . XOOPS_URL . '/images/icons/no_posticon.gif" alt="" /></a>';
    }
    if($post->getVar('uid')>0 && isset($viewtopic_users[$post->getVar('uid')])) {
	    $poster = $viewtopic_users[$post->getVar('uid')];
    }
    else $poster= array(
    	'uid' => 0,
        'name' => $post->getVar('poster_name')?$post->getVar('poster_name'):$myts->HtmlSpecialChars($xoopsConfig['anonymous']),
        'link' => $post->getVar('poster_name')?$post->getVar('poster_name'):$myts->HtmlSpecialChars($xoopsConfig['anonymous'])
  	);
    if ($isadmin or $post->checkIdentity()) {
        $post_text = $post->getVar('post_text');
        $post_attachment = $post->displayAttachment();
    } elseif ($xoopsModuleConfig['enable_karma'] && $post->getVar('post_karma') > $user_karma) {
        $post_text = "<div class='karma'>" . sprintf(_MD_KARMA_REQUIREMENT, $user_karma, $post->getVar('post_karma')) . "</div>";
        $post_attachment = '';
    } elseif (
        	$xoopsModuleConfig['allow_require_reply']
        	&& $post->getVar('require_reply')
    	) {
        $post_text = "<div class='karma'>" . _MD_REPLY_REQUIREMENT . "</div>";
        $post_attachment = '';
    } else {
        $post_text = $post->getVar('post_text');
        $post_attachment = $post->displayAttachment();
    }

    $thread_buttons = array();
    
	if($GLOBALS["xoopsModuleConfig"]['enable_permcheck']){
	
		if(!isset($suspension[$post->getVar('forum_id')])){
			$moderate_handler =& xoops_getmodulehandler('moderate', 'newbb');
			$suspension[$post->getVar('forum_id')] = $moderate_handler->verifyUser(-1,"",$post->getVar('forum_id'));
		}
		
	    $edit_ok = false;
	    if ($isadmin) {
	        $edit_ok = true;
	    } elseif (!$suspension[$post->getVar('forum_id')] && $post->checkIdentity() && $post->checkTimelimit('edit_timelimit')) {
	        $edit_ok = true;
	    }
	    if ($edit_ok) {
	        $thread_buttons['edit']['image'] = newbb_displayImage($forumImage['p_edit'], _EDIT);
	        $thread_buttons['edit']['link'] = "edit.php?forum=" .$post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
	        $thread_buttons['edit']['name'] = _EDIT;
	    }
	
	    if ( (!$suspension[$post->getVar('forum_id')] && $post->checkIdentity() && $post->checkTimelimit('delete_timelimit')) 
	    	|| $isadmin )
	    {
	        $thread_buttons['delete']['image'] = newbb_displayImage($forumImage['p_delete'], _DELETE);
	        $thread_buttons['delete']['link'] = "delete.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
	        $thread_buttons['delete']['name'] = _DELETE;
	    }
	    if (!$suspension[$post->getVar('forum_id')] && is_object($xoopsUser)) {
	        $thread_buttons['reply']['image'] = newbb_displayImage($forumImage['p_reply'], _MD_REPLY);
	        $thread_buttons['reply']['link'] = "reply.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
	        $thread_buttons['reply']['name'] = _MD_REPLY;
	        /*
	        $thread_buttons['quote']['image'] = newbb_displayImage($forumImage['p_quote'], _MD_QUOTE);
	        $thread_buttons['quote']['link'] = "reply.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id') . "&amp;quotedac=1";
	        $thread_buttons['quote']['name'] = _MD_QUOTE;
	        */
	    }
    
	}else{
        $thread_buttons['edit']['image'] = newbb_displayImage($forumImage['p_edit'], _EDIT);
        $thread_buttons['edit']['link'] = "edit.php?forum=" .$post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
        $thread_buttons['edit']['name'] = _EDIT;
        $thread_buttons['delete']['image'] = newbb_displayImage($forumImage['p_delete'], _DELETE);
        $thread_buttons['delete']['link'] = "delete.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
        $thread_buttons['delete']['name'] = _DELETE;
        $thread_buttons['reply']['image'] = newbb_displayImage($forumImage['p_reply'], _MD_REPLY);
        $thread_buttons['reply']['link'] = "reply.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
        $thread_buttons['reply']['name'] = _MD_REPLY;
	}

    if (!$isadmin && $xoopsModuleConfig['reportmod_enabled']) {
        $thread_buttons['report']['image'] = newbb_displayImage($forumImage['p_report'], _MD_REPORT);
        $thread_buttons['report']['link'] = "report.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
        $thread_buttons['report']['name'] = _MD_REPORT;
    }
    $thread_action = array();

    $xoopsTpl->append('posts',
    		array(
    			'post_id' => $post->getVar('post_id'),
    			'topic_id' => $post->getVar('topic_id'),
    			'forum_id' => $post->getVar('forum_id'),
                'post_date' => newbb_formatTimestamp($post->getVar('post_time')),
                'post_image' => $post_image,
                'post_title' => $post_title,
                'post_text' => $post_text,
                'post_attachment' => $post_attachment,
                'post_edit' => $post->displayPostEdit(),
                'post_no' => $start+$pn,
                'post_signature' => ($post->getVar('attachsig'))?@$poster["signature"]:"",
	            'poster_ip' => ($isadmin && $xoopsModuleConfig['show_ip'])?long2ip($post->getVar('poster_ip')):"",
		    	'thread_action' => $thread_action,
                'thread_buttons' => $thread_buttons,
                'poster' => $poster
       		)
  	);

    unset($thread_buttons);
	unset($poster);
}
unset($viewtopic_users);
unset($forums);

if(!empty($xoopsModuleConfig['show_jump'])){
	$xoopsTpl->assign('forum_jumpbox', newbb_make_jumpbox($forum_id));
}

if ( $postCount > $post_perpage ) {
    include XOOPS_ROOT_PATH.'/class/pagenav.php';
    $nav = new XoopsPageNav($postCount, $post_perpage, $start, "start", 'forum='.$forum_id.'&amp;viewmode='.$viewmode.'&amp;type='.$type.'&amp;uid='.$uid.'&amp;order='.$order."&amp;mode=".$mode);
    $xoopsTpl->assign('pagenav', $nav->renderNav(4));
} else {
    $xoopsTpl->assign('pagenav', '');
}

$xoopsTpl->assign('lang_forum_index', sprintf(_MD_FORUMINDEX,htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
$xoopsTpl->assign('folder_topic', newbb_displayImage($forumImage['folder_topic']));

switch($type){
	case 'active':
		$lang_title = _MD_VIEWALLPOSTS. ' ['._MD_TYPE_ADMIN.']';
		break;
	case 'pending':
		$lang_title = _MD_VIEWALLPOSTS. ' ['._MD_TYPE_PENDING.']';
		break;
	case 'deleted':
		$lang_title = _MD_VIEWALLPOSTS. ' ['._MD_TYPE_DELETED.']';
		break;
	case 'new':
		$lang_title = _MD_NEWPOSTS;
		break;
	default:
		$lang_title = _MD_VIEWALLPOSTS;
		break;
	}
if($uid>0){
	$lang_title .= ' ('.XoopsUser::getUnameFromId($uid).')';
}	
$xoopsTpl->assign('lang_title',$lang_title);
$xoopsTpl->assign('p_up',newbb_displayImage($forumImage['p_up'],_MD_TOP));
$xoopsTpl->assign('groupbar_enable', $xoopsModuleConfig['groupbar_enabled']);
$xoopsTpl->assign('anonymous_prefix', $xoopsModuleConfig['anonymous_prefix']);
$xoopsTpl->assign('down',newbb_displayImage($forumImage['doubledown']));
$xoopsTpl->assign('down2',newbb_displayImage($forumImage['down']));
$xoopsTpl->assign('up',newbb_displayImage($forumImage['up']));
$xoopsTpl->assign('printer',newbb_displayImage($forumImage['printer']));
$xoopsTpl->assign('personal',newbb_displayImage($forumImage['personal']));
$xoopsTpl->assign('post_content',newbb_displayImage($forumImage['post_content']));

$all_link = "viewall.php?forum=".$forum_id."&amp;start=$start";
$post_link = "viewpost.php?forum=".$forum_id;
$newpost_link = "viewpost.php?forum=".$forum_id."&amp;new=1";
$digest_link = "viewall.php?forum=".$forum_id."&amp;start=$start&amp;type=digest";
$unreplied_link = "viewall.php?forum=".$forum_id."&amp;start=$start&amp;type=unreplied";
$unread_link = "viewall.php?forum=".$forum_id."&amp;start=$start&amp;type=unread";

$xoopsTpl->assign('all_link', $all_link);
$xoopsTpl->assign('post_link', $post_link);
$xoopsTpl->assign('newpost_link', $newpost_link);
$xoopsTpl->assign('digest_link', $digest_link);
$xoopsTpl->assign('unreplied_link', $unreplied_link);
$xoopsTpl->assign('unread_link', $unread_link);

$viewmode_options = array();
if($viewmode=="compact"){
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=flat&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_FLAT);
	if ($order == 'DESC') {
		$viewmode_options[]= array("link"=>"viewpost.php?viewmode=compact&amp;order=ASC&amp;forum=".$forum_id,"title"=>_OLDESTFIRST);
	} else {
		$viewmode_options[]= array("link"=>"viewpost.php?viewmode=compact&amp;order=DESC&amp;forum=".$forum_id,"title"=>_NEWESTFIRST);
	}
}else{
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=compact&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_MD_COMPACT);
	if ($order == 'DESC') {
		$viewmode_options[]= array("link"=>"viewpost.php?viewmode=flat&amp;order=ASC&amp;forum=".$forum_id,"title"=>_OLDESTFIRST);
	} else {
		$viewmode_options[]= array("link"=>"viewpost.php?viewmode=flat&amp;order=DESC&amp;forum=".$forum_id,"title"=>_NEWESTFIRST);
	}
}

$xoopsTpl->assign('viewmode_compact', ($viewmode=="compact")?1:0);
$xoopsTpl->assign('viewmode_options', $viewmode_options);
$xoopsTpl->assign('menumode',$menumode);
$xoopsTpl->assign('menumode_other',$menumode_other);

$xoopsTpl->assign('viewer_level', ($isadmin)?2:(is_object($xoopsUser)?1:0) );
$xoopsTpl->assign('uid', $uid);
$xoopsTpl->assign('mode', $mode);
$xoopsTpl->assign('type', $type);

include XOOPS_ROOT_PATH.'/footer.php';
?>