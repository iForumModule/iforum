<?php
// $Id: search.php,v 1.1.1.23 2004/10/19 22:35:56 phppp Exp $
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

$xoopsConfig['module_cache'][$xoopsModule->getVar('mid')] = 0;
$xoopsOption['template_main']= 'newbb_search.html';
include XOOPS_ROOT_PATH.'/header.php';
include_once XOOPS_ROOT_PATH.'/modules/newbb/include/search.inc.php';

$forumperms =& xoops_getmodulehandler('permission', 'newbb');
$allowed_forums = $forumperms->getPermissions('forum');

$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
$forum_array = $forum_handler->getForums();

$select = '<select name="forum[]" size="5" multiple="multiple">';
$select .= '<option value="all">'._MD_SEARCHALLFORUMS.'</option>';
foreach ($forum_array as $key => $forum) {
    if (in_array($forum->getVar('forum_id'), array_keys($allowed_forums))) {
        $select .= '<option value="'.$forum->getVar('forum_id').'">'.$forum->getVar('forum_name').'</option>';
    }
}
$select .= '</select>';
$xoopsTpl->assign("forum_selection_box", $select);

$limit = $xoopsModuleConfig['topics_per_page'];

$queries = array();
$andor = "";
$start = 0;
$uid = 0;
$forum = 0;
$sortby = 'p.post_time DESC';
$subquery = "";
$searchin = "both";
$sort = "";
$since = isset($_POST['since']) ? $_POST['since'] : (isset($_GET['since']) ? $_GET['since'] : null);
$next_search['since'] = $since;
$since = intval($since); // This since

if ($xoopsModuleConfig['wol_enabled']){
	$online_handler =& xoops_getmodulehandler('online', 'newbb');
	$online_handler->init($forum);
}

if ( isset($_POST['submit']) || isset($_GET['term']) ) {
    $start = isset($_GET['start']) ? $_GET['start'] : 0;
    $forum = isset($_POST['forum']) ? $_POST['forum'] : (isset($_GET['forum']) ? $_GET['forum'] : null);
    $next_search['forum'] = $forum;
    if (!isset($forum) or $forum == 'all' or (is_array($forum) and in_array('all', $forum))) {
       $forum = array();
    } elseif (is_array($forum)) {
       $forum = $forum;
    } else {
       $forum = intval($forum);
    }

    $addterms = isset($_POST['andor']) ? $_POST['andor'] : (isset($_GET['andor']) ? $_GET['andor'] : null);
    $next_search['andor'] = $addterms;
    if ( isset($addterms) && $addterms == "any" ) { // AND/OR relates to the ANY or ALL on Search Page
        $andor = 'OR';
    } 
    else {
        $andor = 'AND';
    }
    
    $term = isset($_POST['term']) ? $_POST['term'] : (isset($_GET['term']) ? $_GET['term'] : "");
    $next_search['term'] = $term;
    $query = trim($term);
    $temp_queries = preg_split('/[\s,]+/', $query);
    foreach ($temp_queries as $q) {
        $q = trim($q);
        if($q) $queries[] = $myts->addSlashes($q);
    }
    
    $uname_required = false;
    $search_username = isset($_POST['uname']) ? $_POST['uname'] : (isset($_GET['uname']) ? $_GET['uname'] : null);
    $next_search['uname'] = $search_username;
    if ( isset($search_username) && trim($search_username) != "" ) {
	    $uname_required = true;
        $search_username = $myts->oopsAddSlashes(trim($search_username));
        if ( !$result = $xoopsDB->query("SELECT uid FROM ".$xoopsDB->prefix("users")." WHERE uname LIKE '%$search_username%'") ) {
            redirect_header('search.php',1,_MD_ERROROCCURED);
            exit();
        }
        $uid = array();
        while ($row = $xoopsDB->fetchArray($result)) {
            $uid[] = $row['uid'];
        }
    }
    else {
        $uid = 0;
    }
    // entries must be lowercase
    $allowed = array('p.post_time desc', 't.topic_title', 't.topic_views', 't.topic_replies', 'f.forum_name', 'u.uname');
    
    $sortby = isset($_POST['sortby']) ? $_POST['sortby'] : (isset($_GET['sortby']) ? $_GET['sortby'] : null);
    $next_search['sortby'] = $sortby;
    $sortby = (in_array(strtolower($sortby), $allowed)) ? $sortby :  'p.post_time DESC';
    $searchin = isset($_POST['searchin']) ? $_POST['searchin'] : (isset($_GET['searchin']) ? $_GET['searchin'] : 'both');
    if (isset($_POST['searchboth'])||isset($_GET['searchboth']))  $searchin='both'; // The "searchboth" is used in some templates
    $next_search['searchin'] = $searchin;
	if ($since > 0) {
		$subquery = ' AND p.post_time >= ' . (time() - 3600 * $since);
	}
    
	if($uname_required&&(!$uid||count($uid)<1)) $result = false;
    else $results =& newbb_search($queries, $andor, $limit, $start, $uid, $forum, $sortby, $searchin, $subquery);
    
    if ( count($results) < 1 ) {
        $xoopsTpl->assign("lang_nomatch", _MD_NOMATCH);
    }
    else {
        foreach ($results as $row) {
            $xoopsTpl->append('results', array('forum_name' => $myts->displayTarea($myts->htmlSpecialChars($row['forum_name'])), 'forum_link' => $row['forum_link'], 'link' => $row['link'], 'title' => $row['title'], 'poster' => $row['poster'], 'post_time' => formatTimestamp($row['time'], "m")));
                      
        }
        
        if(count($next_search)>0){
	        $items = array();
	        foreach($next_search as $para => $val){
		        if(!empty($val)) $items[] = "$para=$val";
	        }
	        if(count($items)>0) $paras = implode("&",$items);
	        unset($next_search);
	        unset($items);
        }
      	$search_url = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname')."/search.php?".$paras;
        
       	$next_results =& newbb_search($queries, $andor, 1, $start + $limit, $uid, $forum, $sortby, $searchin, $subquery);
        $next_count = count($next_results);
        $has_next = false;
        if (is_array($next_results) && $next_count >0) {
            $has_next = true;
        }
        if (false != $has_next) {
            $next = $start + $limit;
            $queries = implode(',',$queries);
            $search_url_next = $search_url."&amp;start=$next";
            $search_next = '<a href="'.htmlspecialchars($search_url_next).'">'._MD_SEARCHNEXT.'</a>';
			$xoopsTpl->assign("search_next", $search_next);
        }
        if ( $start > 0 ) {
            $prev = $start - $limit;
            $search_url_prev = $search_url."&amp;start=$prev";
            $search_prev = '<a href="'.htmlspecialchars($search_url_prev).'">'._MD_SEARCHPREV.'</a>';
			$xoopsTpl->assign("search_prev", $search_prev);
        }
    }
    
	$search_info = (empty($term))? "":(_MD_KEYWORDS." ".$term);
    if($uname_required){
	    if($search_info) $search_info .= "<br />";
	    $search_info .= _MD_USERNAME.": ".$search_username;
	}
	$xoopsTpl->assign("search_info", $search_info);
}

$xoopsTpl->assign("forumindex", sprintf(_MD_FORUMINDEX,$xoopsConfig['sitename']));
$xoopsTpl->assign("img_folder", newbb_displayImage($forumImage['folder_topic']));
include XOOPS_ROOT_PATH.'/footer.php';
?>