<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		http://xoopsforge.com The XOOPS FORGE Project
* @copyright		http://xoops.org.cn The XOOPS CHINESE Project
* @copyright		XOOPS_copyrights.txt
* @copyright		readme.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license			GNU General Public License (GPL)
*					a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		CBB - XOOPS Community Bulletin Board
* @since			3.08
* @author		phppp
* ----------------------------------------------------------------------------------------------------------
* 				iForum - a bulletin Board (Forum) for ImpressCMS
* @since			1.00
* @author		modified by stranger
* @version		$Id$
*/

include "header.php";

/* deal with marks */
if (isset($_GET['mark_read'])){
    if(1 == intval($_GET['mark_read'])){ // marked as read
	    $markvalue = 1;
	    $markresult = _MD_MARK_READ;
    }else{ // marked as unread
	    $markvalue = 0;
	    $markresult = _MD_MARK_UNREAD;
    }
	iforum_setRead_forum($markvalue);
    $url=ICMS_URL . '/modules/' . $xoopsModule->getVar("dirname") . '/index.php';
    redirect_header($url, 2, _MD_ALL_FORUM_MARKED.' '.$markresult);
}

$viewcat = @intval($_GET['cat']);
$category_handler =& icms_getmodulehandler('category', basename( dirname( __FILE__ ) ), 'iforum' );

$categories = array();
if (!$viewcat) {
	$categories = $category_handler->getAllCats('access', true);
    $forum_index_title = "";
	$xoops_pagetitle = $xoopsModule->getVar('name');
}else {
    $category_obj =& $category_handler->get($viewcat);
	if($category_handler->getPermission($category_obj)) {
		$categories[$viewcat] =& $category_obj;
	}
    $forum_index_title = sprintf(_MD_FORUMINDEX, htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES));
	$xoops_pagetitle = $category_obj->getVar('cat_title') . " [" .$xoopsModule->getVar('name')."]";
}
if(count($categories) == 0){
    redirect_header(ICMS_URL, 2, _MD_NORIGHTTOACCESS);
    exit();
}

/* rss feed */
if(!empty($xoopsModuleConfig['rss_enable'])){
	$xoops_module_header .= '
	<link rel="alternate" type="application/rss+xml" title="'.$xoopsModule->getVar('name').'" href="'.ICMS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/rss.php" />
	';
}

$xoopsOption['template_main']= 'iforum_index.html';
$xoopsOption['xoops_pagetitle']= $xoops_pagetitle;
$xoopsOption['xoops_module_header']= $xoops_module_header;
include ICMS_ROOT_PATH."/header.php";

$xoopsTpl->assign('xoops_pagetitle', $xoops_pagetitle);
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);
$xoopsTpl->assign('forum_index_title', $forum_index_title);
if ($xoopsModuleConfig['wol_enabled']){
	$online_handler =& icms_getmodulehandler('online', basename( dirname( __FILE__ ) ), 'iforum' );
	$online_handler->init();
    $xoopsTpl->assign('online', $online_handler->show_online());
}

/* display forum stats */
$xoopsTpl->assign(array(
	"lang_welcomemsg" => sprintf(_MD_WELCOME, htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)), 
	"total_topics" => get_total_topics(), 
	"total_posts" => get_total_posts(), 
	"lang_lastvisit" => sprintf(_MD_LASTVISIT,formatTimestamp($last_visit)), 
	"lang_currenttime" => sprintf(_MD_TIMENOW,formatTimestamp(time(),"m"))));

$forum_handler =& icms_getmodulehandler('forum', basename( dirname( __FILE__ ) ), 'iforum' );
$forums_obj = $forum_handler->getForumsByCategory(array_keys($categories), "access");
$forums_array = $forum_handler->display($forums_obj);
unset($forums_obj);

if(count($forums_array)>0){
    foreach ($forums_array[0] as $parent => $forum) {
        if (isset($forums_array[$forum['forum_id']])) {
            $forum['subforum'] =& $forums_array[$forum['forum_id']];
        }
        $forumsByCat[$forum['forum_cid']][] = $forum;
    }
}

$category_array = array();
$cat_order = array();
$toggles = iforum_getcookie('G', true);
foreach(array_keys($categories) as $id){
    $forums = array();

    $onecat =& $categories[$id];
    
    $catid="cat_".$onecat->getVar('cat_id');
	$catshow = (count($toggles)>0)?((in_array($catid, $toggles)) ? false : true):true;

	$display = ($catshow) ? 'block;' : 'none;';
	$display_icon  = ($catshow) ? 'images/minus.png' : 'images/plus.png';

    if (isset($forumsByCat[$onecat->getVar('cat_id')])) {
        $forums =& $forumsByCat[$onecat->getVar('cat_id')];
    }

	$cat_description = $onecat->getVar('cat_description');
	$cat_description = $myts->undoHtmlSpecialChars($cat_description);
	$cat_sponsor = array();
    @list($url, $title) = array_map("trim",preg_split("/ /", $onecat->getVar('cat_url'), 2));
    if(empty($title)) $title = $url;
    $title = $myts->htmlSpecialChars($title);
	if(!empty($url)) $cat_sponsor = array("title"=>$title, "link"=>formatURL($url));
	if($onecat->getVar('cat_image') &&	$onecat->getVar('cat_image') != "blank.gif"){
		$cat_image = ICMS_URL."/modules/" . $xoopsModule->getVar("dirname") . "/images/category/" . $onecat->getVar('cat_image');
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
unset($categories);

$xoopsTpl->assign_by_ref("categories", $category_array);
$xoopsTpl->assign("subforum_display", $xoopsModuleConfig['subforum_display']);
$xoopsTpl->assign('mark_read', "index.php?mark_read=1");
$xoopsTpl->assign('mark_unread', "index.php?mark_read=2");

$xoopsTpl->assign('all_link', "viewall.php");
$xoopsTpl->assign('post_link', "viewpost.php");
$xoopsTpl->assign('newpost_link', "viewpost.php?type=new");
$xoopsTpl->assign('digest_link', "viewall.php?type=digest");
$xoopsTpl->assign('unreplied_link', "viewall.php?type=unreplied");
$xoopsTpl->assign('unread_link', "viewall.php?type=unread");
$xoopsTpl->assign('down',iforum_displayImage($forumImage['doubledown']));
$xoopsTpl->assign('menumode',$menumode);
$xoopsTpl->assign('menumode_other',$menumode_other);

$isadmin = iforum_isAdmin();
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
    $xoopsTpl->assign("rss_button", iforum_displayImage($forumImage['rss'], 'RSS feed'));
}
$xoopsTpl->assign(array(
	"img_hotfolder" => iforum_displayImage($forumImage['newposts_forum']),
	"img_folder" => iforum_displayImage($forumImage['folder_forum']),
	"img_locked_nonewposts" => iforum_displayImage($forumImage['locked_forum']),
	"img_locked_newposts" => iforum_displayImage($forumImage['locked_forum_newposts']),
	'img_subforum' => iforum_displayImage($forumImage['subforum'])));
include_once ICMS_ROOT_PATH.'/footer.php';
?>