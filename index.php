<?php
// $Id: index.php,v 1.3 2005/10/19 17:20:28 phppp Exp $
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

/* deal with marks */
if (isset($_GET['mark_read'])){
    $result = $xoopsDB->query("SELECT forum_id FROM ".$xoopsDB->prefix("bb_forums"));
    $forum_lastview = newbb_getcookie('LF',true);
    if(1 == intval($_GET['mark_read'])){ // marked as read
	    $markvalue = time();
	    $markresult = _MD_MARK_READ;
    }else{ // marked as unread
	    $markvalue = false;
	    $markresult = _MD_MARK_UNREAD;
    }
    while ( list($forum_id)=$xoopsDB->fetchRow($result) )
    {
        $forum_lastview[$forum_id] = $markvalue;
    }

	newbb_setcookie("LF", $forum_lastview);

    $url=XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/index.php';
    redirect_header($url,2, _MD_ALL_FORUM_MARKED.' '.$markresult);
}

/* rss feed */
if(!empty($xoopsModuleConfig['rss_enable'])){
	$xoops_module_header .= '
	<link rel="alternate" type="application/rss+xml" title="'.$xoopsModule->getVar('name').'" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/rss.php" />
	';
}

$xoopsOption['template_main']= 'newbb_index.html';
$xoopsOption['xoops_module_header']= $xoops_module_header;
include XOOPS_ROOT_PATH."/header.php";

$xoopsTpl->assign('xoops_module_header', $xoops_module_header);
if ($xoopsModuleConfig['wol_enabled']){
	$online_handler =& xoops_getmodulehandler('online', 'newbb');
	$online_handler->init();
    $xoopsTpl->assign('online', $online_handler->show_online());
}

/* display forum stats */
$xoopsTpl->assign(array(
	"lang_welcomemsg" => sprintf(_MD_WELCOME, htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)), 
	"total_topics" => get_total_topics(), 
	"total_posts" => get_total_posts(0, 'all'), 
	"lang_lastvisit" => sprintf(_MD_LASTVISIT,formatTimestamp($last_visit)), 
	"lang_currenttime" => sprintf(_MD_TIMENOW,formatTimestamp(time(),"m"))));

$viewcat = (!empty($_GET['cat'])) ? intval($_GET['cat']) : 0;
$category_handler =& xoops_getmodulehandler('category', 'newbb');

if (!$viewcat) {
	$categories = $category_handler->getAllCats('access', true);
    //$categories =& $category_handler->getAllCats("access");
    $xoopsTpl->assign('forum_index_title', '');
}
else {
    $cat =& $category_handler->get($viewcat);
	if($category_handler->getPermission($cat)) {
		$categories[$viewcat] =& $cat;
	}
	else $categories = array();
    $xoopsTpl->assign('forum_index_title', sprintf(_MD_FORUMINDEX,htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
}
if(count($categories) == 0){
    redirect_header(XOOPS_URL, 2, _MD_NORIGHTTOACCESS);
    exit();
}

$last_posts = $category_handler->getLatestPosts($viewcat);
$forums = $category_handler->getForums(array_keys($categories), "access");
$forum_handler =& xoops_getmodulehandler('forum', 'newbb');

$forums_array = array();
$users = array();
foreach (array_keys($last_posts) as $id) {
	$users[] = $last_posts[$id]["uid"];
}
foreach (array_keys($forums) as $id) {
	$users = array_merge($users, $forums[$id]->getModerators());
}
$users_linked = newbb_getUnameFromIds(array_unique($users), !empty($xoopsModuleConfig['show_realname']), true);

foreach (array_keys($forums) as $id) {
	$forum =& $forums[$id];
	$last_posts[$id]["lastpost_user"] = @$users_linked[$last_posts[$id]["uid"]];
	if(empty($last_posts[$id]["lastpost_user"]) && !empty($last_posts[$id]["poster_name"])){
		$last_posts[$id]["lastpost_user"] = $myts->htmlSpecialChars($last_posts[$id]["poster_name"]);
	}
	if(empty($last_posts[$id]["lastpost_user"])){
		$last_posts[$id]["lastpost_user"] = $myts->htmlSpecialChars($GLOBALS["xoopsConfig"]["anonymous"]);
	}

    $forum_data = $last_posts[$id];
	$forum_desc = $forum->getVar('forum_desc');
	$forum_desc = $myts->undoHtmlSpecialChars($forum_desc);
	$forum_moderators = array();
	$moderators = $forum->getModerators();
	foreach($moderators as $moderator){
		$forum_moderators[] = @$users_linked[$moderator];
	}
    $forums_array[$forum->getVar('parent_forum')][] = array_merge(
	    array(
	    	'forum_order' => $forum->getVar('forum_order'),
		    'forum_id' => $id,
		    'forum_cid' => $forum->getVar('cat_id'),
		    'forum_name' => $forum->getVar('forum_name'),
		    'forum_desc' => $forum->getVar('forum_desc'),
		    'forum_posts' => $forum->getVar("forum_posts"),
		    'forum_topics' => $forum->getVar("forum_topics"),
		    'forum_type' => $forum->getVar('forum_type')
		),
		$forum->disp_forumIndex($forum_data),
		array(
		    //'forum_moderators' => $forum->disp_forumModerators()
		    'forum_moderators' => implode(", ", $forum_moderators)
		)
	);
}
unset($forums);

if(count($forums_array)>0){
    foreach ($forums_array[0] as $parent => $forum) {
        if (isset($forums_array[$forum['forum_id']])) {
            $forum['subforum'] = $forums_array[$forum['forum_id']];
        }
        $forumsByCat[$forum['forum_cid']][] = $forum;
    }
}

$category_array = array();
$cat_order = array();
$toggles = newbb_getcookie('G', true);
foreach(array_keys($categories) as $id){
    $forums = array();

    $onecat =& $categories[$id];
    
    $catid="cat_".$onecat->getVar('cat_id');
	$catshow = (count($toggles)>0)?((in_array($catid, $toggles)) ? false : true):true;

	$display = ($catshow) ? 'block;' : 'none;';
	$display_icon  = ($catshow) ? 'images/minus.png' : 'images/plus.png';

    if (isset($forumsByCat[$onecat->getVar('cat_id')])) {
        $forums = $forumsByCat[$onecat->getVar('cat_id')];
    }

    $cat_description = "";
	if($onecat->getVar('cat_showdescript')){
		$cat_description = $onecat->getVar('cat_description');
		$cat_description = $myts->undoHtmlSpecialChars($cat_description);
	}
	$cat_sponsor = array();
    @list($url, $title) = array_map("trim",preg_split("/ /", $onecat->getVar('cat_url'), 2));
    if(empty($title)) $title = $url;
    $title = $myts->htmlSpecialChars($title);
	if(!empty($url)) $cat_sponsor = array("title"=>$title, "link"=>$url);
	if($onecat->getVar('cat_image') &&
		$onecat->getVar('cat_image') !="blank.gif" &&
		is_readable(XOOPS_ROOT_PATH."/modules/" . $xoopsModule->dirname() . "/images/category/".$onecat->getVar('cat_image'))
		){
			$cat_image = XOOPS_URL."/modules/" . $xoopsModule->dirname() . "/images/category/".$onecat->getVar('cat_image');
	}else{
		$cat_image = "";
	}
    $category_array[] = array(
    	'cat_order' => $onecat->getVar('cat_order'),
    	'cat_id' => $onecat->getVar('cat_id'),
	    'cat_title' => $onecat->getVar('cat_title'),
	    'cat_image' => $cat_image,
	    'cat_sponsor' => $cat_sponsor,
	    'cat_description' => $myts->displayTarea($cat_description, 1),
        'cat_display' => $display,
	    'cat_display_icon' => $display_icon,
	    'forums' => $forums
    	);
    $cat_order[] = $onecat->getVar('cat_order');
}
array_multisort($category_array, $cat_order);

$xoopsTpl->assign("categories", $category_array);
unset($category_array);

$xoopsTpl->assign("subforum_display", $xoopsModuleConfig['subforum_display']);

$xoopsTpl->assign('mark_read', "index.php?mark_read=1");
$xoopsTpl->assign('mark_unread', "index.php?mark_read=2");

$xoopsTpl->assign('all_link', "viewall.php");
$xoopsTpl->assign('post_link', "viewpost.php");
$xoopsTpl->assign('newpost_link', "viewpost.php?new=1");
$xoopsTpl->assign('digest_link', "viewall.php?type=digest");
$xoopsTpl->assign('unreplied_link', "viewall.php?type=unreplied");
$xoopsTpl->assign('unread_link', "viewall.php?type=unread");
$xoopsTpl->assign('down',newbb_displayImage($forumImage['doubledown']));
$xoopsTpl->assign('menumode',$menumode);
$xoopsTpl->assign('menumode_other',$menumode_other);

$isadmin = newbb_isAdmin();
$xoopsTpl->assign('viewer_level', ($isadmin)?2:(is_object($xoopsUser)?1:0) );
$mode = (!empty($_GET['mode'])) ? intval($_GET['mode']) : 0;
$xoopsTpl->assign('mode', $mode );

$xoopsTpl->assign('viewcat', $viewcat);
$xoopsTpl->assign('version', $xoopsModule->getVar("version"));

/* To be removed */
if ( $isadmin ) {
    $xoopsTpl->assign('forum_index_cpanel',array("link"=>"admin/index.php", "name"=>_MD_ADMINCP));
}

if ($xoopsModuleConfig['rss_enable'] == 1) {
    $xoopsTpl->assign("rss_enable",1);
    //$xoopsTpl->assign("rss_button","<a href='".XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/rss.php?c=".$viewcat."' title='RSS feed' target='_blank'>".newbb_displayImage($forumImage['rss'])."</a>");
    $xoopsTpl->assign("rss_button", newbb_displayImage($forumImage['rss'], 'RSS feed'));
}
$xoopsTpl->assign(array(
	"img_hotfolder" => newbb_displayImage($forumImage['newposts_forum']),
	"img_folder" => newbb_displayImage($forumImage['folder_forum']),
	"img_locked_nonewposts" => newbb_displayImage($forumImage['locked_forum']),
	"img_locked_newposts" => newbb_displayImage($forumImage['locked_forum_newposts']),
	'img_subforum' => newbb_displayImage($forumImage['subforum'])));
include_once XOOPS_ROOT_PATH.'/footer.php';
?>