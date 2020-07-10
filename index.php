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
 
include "header.php";
 
/* deal with marks */
if (isset($_GET['mark_read']))
	{
	if (1 == (int)$_GET['mark_read'])
	{
		// marked as read
		$markvalue = 1;
		$markresult = _MD_MARK_READ;
	}
	else
	{
		// marked as unread
		$markvalue = 0;
		$markresult = _MD_MARK_UNREAD;
	}
	iforum_setRead_forum($markvalue);
	$url = ICMS_URL . '/modules/' . $icmsModule->getVar("dirname") . '/index.php';
	redirect_header($url, 2, _MD_ALL_FORUM_MARKED.' '.$markresult);
}
 
$viewcat = @(int)$_GET['cat'];
$category_handler = icms_getmodulehandler('category', basename(__DIR__), 'iforum' );
 
$categories = array();
if (!$viewcat)
{
	$categories = $category_handler->getAllCats('access', true);
	$forum_index_title = "";
	$icms_pagetitle = $icmsModule->getVar('name');
}
else
{
	$category_obj = $category_handler->get($viewcat);
	if ($category_handler->getPermission($category_obj))
	{
		$categories[$viewcat] = & $category_obj;
	}
	$forum_index_title = sprintf(_MD_FORUMINDEX, htmlspecialchars($icmsConfig['sitename'], ENT_QUOTES));
	$icms_pagetitle = $category_obj->getVar('cat_title') . " [" .$icmsModule->getVar('name')."]";
}
if (count($categories) == 0)
{
	redirect_header(ICMS_URL, 2, _MD_NORIGHTTOACCESS);
	exit();
}
 
/* rss feed */
if (!empty(icms::$module->config['rss_enable']))
{
	$icms_module_header .= '
		<link rel="alternate" type="application/rss+xml" title="'.$icmsModule->getVar('name').'" href="'.ICMS_URL.'/modules/'.$icmsModule->getVar('dirname').'/rss.php" />
		';
}
 
$xoopsOption['template_main'] = 'iforum_index.html';
$xoopsOption['xoops_pagetitle'] = $icms_pagetitle;
$xoopsOption['xoops_module_header'] = $icms_module_header;
include ICMS_ROOT_PATH."/header.php";
 
$icmsTpl->assign('xoops_pagetitle', $icms_pagetitle);
$icmsTpl->assign('xoops_module_header', $icms_module_header);
$icmsTpl->assign('forum_index_title', $forum_index_title);
if (icms::$module->config['wol_enabled'])
	{
	$online_handler = icms_getmodulehandler('online', basename(__DIR__), 'iforum' );
	$online_handler->init();
	$icmsTpl->assign('online', $online_handler->show_online());
}
 
/* display forum stats */
$icmsTpl->assign(array(
"lang_welcomemsg" => sprintf(_MD_WELCOME, htmlspecialchars($icmsConfig['sitename'], ENT_QUOTES)),
	"total_topics" => get_total_topics(),
	"total_posts" => get_total_posts(),
	"lang_lastvisit" => sprintf(_MD_LASTVISIT, formatTimestamp($last_visit)),
	"lang_currenttime" => sprintf(_MD_TIMENOW, formatTimestamp(time(), "m"))));
 
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
$forums_obj = $forum_handler->getForumsByCategory(array_keys($categories), "access");
$forums_array = $forum_handler->display($forums_obj);
unset($forums_obj);
 
if (count($forums_array) > 0)
{
	foreach ($forums_array[0] as $parent => $forum)
	{
		if (isset($forums_array[$forum['forum_id']]))
		{
			$forum['subforum'] = & $forums_array[$forum['forum_id']];
		}
		$forumsByCat[$forum['forum_cid']][] = $forum;
	}
}
 
$category_array = array();
$cat_order = array();
$toggles = iforum_getcookie('G', true);
foreach(array_keys($categories) as $id)
{
	$forums = array();
	 
	$onecat = & $categories[$id];
	 
	$catid = "cat_".$onecat->getVar('cat_id');
	$catshow = (count($toggles) > 0)?((in_array($catid, $toggles)) ? false : true):
	true;
	 
	$display = ($catshow) ? 'block;' :
	 'none;';
	$display_icon = ($catshow) ? 'images/minus.png' :
	 'images/plus.png';
	 
	if (isset($forumsByCat[$onecat->getVar('cat_id')]))
	{
		$forums = & $forumsByCat[$onecat->getVar('cat_id')];
	}
	 
	$cat_description = $onecat->getVar('cat_description');
	$cat_description = icms_core_DataFilter::undoHtmlSpecialChars($cat_description);
	$cat_sponsor = array();
	@list($url, $title) = array_map("trim", preg_split("/ /", $onecat->getVar('cat_url'), 2));
	if (empty($title)) $title = $url;
	$title = icms_core_DataFilter::htmlSpecialchars($title);
	if (!empty($url)) $cat_sponsor = array("title" => $title, "link" => formatURL($url));
	if ($onecat->getVar('cat_image') && $onecat->getVar('cat_image') != "blank.gif")
	{
		$cat_image = ICMS_URL."/modules/" . $icmsModule->getVar("dirname") . "/images/category/" . $onecat->getVar('cat_image');
	}
	else
	{
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
		'forums' => $forums );
	$cat_order[] = $onecat->getVar('cat_order');
}
unset($categories);
 
$icmsTpl->assign_by_ref("categories", $category_array);
$icmsTpl->assign("subforum_display", icms::$module->config['subforum_display']);
$icmsTpl->assign('mark_read', "index.php?mark_read=1");
$icmsTpl->assign('mark_unread', "index.php?mark_read=2");
 
$icmsTpl->assign('all_link', "viewall.php");
$icmsTpl->assign('post_link', "viewpost.php");
$icmsTpl->assign('newpost_link', "viewpost.php?type=new");
$icmsTpl->assign('digest_link', "viewall.php?type=digest");
$icmsTpl->assign('unreplied_link', "viewall.php?type=unreplied");
$icmsTpl->assign('unread_link', "viewall.php?type=unread");
$icmsTpl->assign('down', iforum_displayImage($forumImage['doubledown']));
 
$isadmin = iforum_isAdmin();
$icmsTpl->assign('viewer_level', ($isadmin)?2:(is_object(icms::$user)?1:0) );
$mode = (!empty($_GET['mode'])) ? (int)$_GET['mode'] :
 0;
$icmsTpl->assign('mode', $mode );
 
$icmsTpl->assign('viewcat', $viewcat);
$icmsTpl->assign('version', $icmsModule->getVar("version"));
 
/* To be removed */
if ($isadmin )
{
	$icmsTpl->assign('forum_index_cpanel', array("link" => "admin/index.php", "name" => _MD_ADMINCP));
}
 
if (icms::$module->config['rss_enable'] == 1)
{
	$icmsTpl->assign("rss_enable", 1);
	$icmsTpl->assign("rss_button", iforum_displayImage($forumImage['rss'], 'RSS feed'));
}
$icmsTpl->assign(array(
"img_hotfolder" => iforum_displayImage($forumImage['newposts_forum']),
	"img_folder" => iforum_displayImage($forumImage['folder_forum']),
	"img_locked_nonewposts" => iforum_displayImage($forumImage['locked_forum']),
	"img_locked_newposts" => iforum_displayImage($forumImage['locked_forum_newposts']),
	'img_subforum' => iforum_displayImage($forumImage['subforum'])));
include_once ICMS_ROOT_PATH.'/footer.php';