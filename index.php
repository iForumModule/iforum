<?php
// $Id: index.php,v 1.1.1.54 2004/11/02 15:47:36 phppp Exp $
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

$xoopsOption['template_main']= 'newbb_index.html';
include XOOPS_ROOT_PATH."/header.php";
$xoopsTpl->assign('xoops_module_header', $newbb_module_header);
if ($xoopsModuleConfig['wol_enabled']){
	$online_handler =& xoops_getmodulehandler('online', 'newbb');
	$online_handler->init();
    $xoopsTpl->assign('online', $online_handler->show_online());
    $xoopsTpl->assign('color_admin', $xoopsModuleConfig['wol_admin_col']);
    $xoopsTpl->assign('color_mod', $xoopsModuleConfig['wol_mod_col']);
}

$xoopsTpl->assign(array("lang_welcomemsg" => sprintf(_MD_WELCOME,$xoopsConfig['sitename']), "total_topics" => get_total_topics(), "total_posts" => get_total_posts(0, 'all'), "lang_lastvisit" => sprintf(_MD_LASTVISIT,formatTimestamp($last_visit)), "lang_currenttime" => sprintf(_MD_TIMENOW,formatTimestamp(time(),"m"))));

$viewcat = (!empty($_GET['cat'])) ? intval($_GET['cat']) : 0;
$category_handler =& xoops_getmodulehandler('category', 'newbb');

if (!$viewcat) {
    $categories = $category_handler->getAllCats();
    $xoopsTpl->assign('forum_index_title', '');
}
else {
    $categories = array($category_handler->get($viewcat));
    $xoopsTpl->assign('forum_index_title', sprintf(_MD_FORUMINDEX,$xoopsConfig['sitename']));
}

/* TODO for ADMIN_CP
$report_handler =& xoops_getmodulehandler('report', 'newbb');
$xoopsTpl->assign('report_pending', $report_handler->getReportCount(0));
*/

$last_posts = $category_handler->getLatestPosts($viewcat);
$forums = $category_handler->getForums($viewcat);
$forum_handler =& xoops_getmodulehandler('forum', 'newbb');

$forums_array = array();
foreach ($forums as $forumid => $forum) {
    $forum_data = $last_posts[$forumid];
    $forums_array[$forum->getVar('parent_forum')][] = array_merge(
	    array(
	    	'forum_order' => $forum->getVar('forum_order'),
		    'forum_id' => $forumid,
		    'forum_cid' => $forum->getVar('cat_id'),
		    'forum_name' => $forum->getVar('forum_name'),
		    'forum_desc' => $myts->undoHtmlSpecialChars($forum->getVar('forum_desc')),
		    'forum_posts' => $forum->getVar("forum_posts"),
		    'forum_topics' => $forum->getVar("forum_topics"),
		    'forum_type' => $forum->getVar('forum_type')
		),
		$forum->disp_forumIndex($forum_data),
		array(
		    'forum_moderators' => $forum->disp_forumModerators()
		),
		array(
		    'forum_permission' => $forum_handler->getPermission($forum)
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
$cat_order = array();
$cats="cat_";
foreach($categories as $onecat){
    $forums = array();

    $catid=$cats.$onecat->getVar('cat_id');
	$catshow = true;
	if (isset($_COOKIE['newbb2_toggle']))
	{
		$cookiearr = split(',',$_COOKIE['newbb2_toggle']);
		$catshow = (in_array($catid, $cookiearr)) ? false : true;
	}

	$display = ($catshow) ? 'block;' : 'none;';
	$display_icon  = ($catshow) ? 'images/minus.png' : 'images/plus.png';


    if (isset($forumsByCat[$onecat->getVar('cat_id')])) {
        $forums = $forumsByCat[$onecat->getVar('cat_id')];
    }

	$cat_description = ($onecat->getVar('cat_showdescript'))?$myts->undoHtmlSpecialChars($onecat->getVar('cat_description')):'';

    $category_array[] = array(
    	'cat_order' => $onecat->getVar('cat_order'),
    	'cat_id' => $onecat->getVar('cat_id'),
	    'cat_title' => $onecat->getVar('cat_title'),
	    'cat_image' => $onecat->getVar('cat_image'),
	    'cat_url' => $onecat->getVar('cat_url'),
	    'cat_description' => $cat_description,
	    'permission' => $category_handler->getPermission($onecat),
        'cat_display' => $display,
	    'cat_display_icon' => $display_icon,
	    'forums' => $forums
    	);
    $cat_order[] = $onecat->getVar('cat_order');
}

array_multisort($category_array, $cat_order);

$xoopsTpl->assign("categories", $category_array);
$xoopsTpl->assign("cat_display", $display);

$xoopsTpl->assign('mark_read', "index.php?mark_read=1");
$xoopsTpl->assign('mark_unread', "index.php?mark_read=2");

$xoopsTpl->assign('all_link', "viewall.php");
$xoopsTpl->assign('digest_link', "viewall.php?type=digest");
$xoopsTpl->assign('unreplied_link', "viewall.php?type=unreplied");
$xoopsTpl->assign('unread_link', "viewall.php?type=unread");
$xoopsTpl->assign('down',newbb_displayImage($forumImage['doubledown']));

if ( is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid()) ) {
    $xoopsTpl->assign('forum_index_cpanel',"<strong> <a href='admin/index.php' target='_blank'>"._MD_ADMINCP."</a></strong>  ");
}
if ($xoopsModuleConfig['rss_enable'] == 1) {
    $xoopsTpl->assign("rss_enable","<div align='right'><a href='".XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/rss.php' target='_blank'>".newbb_displayImage($forumImage['rss'])."</a></div>");
}
$xoopsTpl->assign(array(
	"img_hotfolder" => newbb_displayImage($forumImage['newposts_forum']),
	"img_folder" => newbb_displayImage($forumImage['folder_forum']),
	"img_locked_nonewposts" => newbb_displayImage($forumImage['locked_forum']),
	"img_locked_newposts" => newbb_displayImage($forumImage['locked_forum_newposts']),
	'img_subforum' => newbb_displayImage($forumImage['subforum'])));
include_once XOOPS_ROOT_PATH.'/footer.php';

?>