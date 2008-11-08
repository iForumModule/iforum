<?php
// $Id: newbb_block.php,v 1.1.1.2 2005/10/19 16:23:31 phppp Exp $
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
if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
require_once(XOOPS_ROOT_PATH.'/modules/'.basename( dirname( dirname( __FILE__ ) ) ).'/include/functions.php');
if(defined('NEWBB_BLOCK_DEFINED')) return;
define('NEWBB_BLOCK_DEFINED',true);

function b_newbb_array_filter($var){
	return $var > 0;
}

// options[0] - Citeria valid: time(by default)
// options[1] - NumberToDisplay: any positive integer
// options[2] - TimeDuration: negative for hours, positive for days, for instance, -5 for 5 hours and 5 for 5 days
// options[3] - DisplayMode: 0-full view;1-compact view;2-lite view
// options[4] - Display Navigator: 1 (by default), 0 (No)
// options[5] - Title Length : 0 - no limit
// options[6] - SelectedForumIDs: null for all

function b_newbb_show($options)
{
    global $xoopsConfig;
    global $access_forums;
	$modulename = basename( dirname( dirname( __FILE__ ) ) );
    $db =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();
    $block = array();
    $i = 0;
    $order = "";
    $extra_criteria = "";
	if(!empty($options[2])) {
		$time_criteria = time() - newbb_getSinceTime($options[2]);
		$extra_criteria = " AND p.post_time>".$time_criteria;
	}
    $time_criteria = null;
    switch ($options[0]) {
        case 'time':
        default:
            $order = 'p.post_time';
    		$extra_criteria .= " AND p.approved=1";
            break;
    }
    $newbbConfig = getConfigForBlock();
    			
    if(!isset($access_forums)){
	    $forum_handler =& xoops_getmodulehandler('forum', 'newbb');
    	if(!$access_obj =& $forum_handler->getForums(0, 'access', array('forum_id', 'cat_id', 'forum_type')) ){
	    	return null;
    	}
    	$access_forums = array_keys( $access_obj ); // get all accessible forums
    	unset($access_obj );
	}
    if (!empty($options[6])) {
        $allowedforums = array_filter(array_slice($options, 6), "b_newbb_array_filter"); // get allowed forums
        $allowed_forums = array_intersect($allowedforums, $access_forums);
    }else{
        $allowed_forums = $access_forums;
    }

    $forum_criteria = ' AND t.forum_id IN (' . implode(',', $allowed_forums) . ')';
    $approve_criteria = ' AND t.approved = 1';

    $query = 'SELECT'.
    		'	DISTINCT t.topic_id, t.topic_replies, t.forum_id, t.topic_title, t.topic_views, t.topic_subject,'.
    		'	f.forum_name, f.allow_subject_prefix,'.
    		'	p.post_id, p.post_time, p.icon, p.uid, p.poster_name'.
    		'	FROM ' . $db->prefix('bb_posts') . ' AS p '.
    		'	LEFT JOIN ' . $db->prefix('bb_topics') . ' AS t ON t.topic_last_post_id=p.post_id'.
    		'	LEFT JOIN ' . $db->prefix('bb_forums') . ' AS f ON f.forum_id=t.forum_id'.
    		'	WHERE 1=1 ' .
    			$forum_criteria .
    			$approve_criteria .
    			$extra_criteria .
    			' ORDER BY ' . $order . ' DESC';

    $result = $db->query($query, $options[1], 0);
    if (!$result) {
	    newbb_message("newbb block query error: ".$query);
        return false;
    }
    $block['disp_mode'] = $options[3]; // 0 - full view; 1 - compact view; 2 - lite view;
    $rows = array();
    $author = array();
    while ($row = $db->fetchArray($result)) {
        $rows[] = $row;
        $author[$row["uid"]] = 1;
    }
    if (count($rows) < 1) return false;
	$author_name = newbb_getUnameFromIds(array_keys($author), $newbbConfig['show_realname'], true);

    foreach ($rows as $arr) {
        $topic_page_jump = '';
        if ($arr['allow_subject_prefix']) {
            $subjectpres = explode(',', $newbbConfig['subject_prefix']);
            if (count($subjectpres) > 1) {
                foreach($subjectpres as $subjectpre) {
                    $subject_array[] = $subjectpre;
                }
               	$subject_array[0] = null;
            }
            $topic['topic_subject'] = $subject_array[$arr['topic_subject']];
        } else {
            $topic['topic_subject'] = "";
        }
        $topic['post_id'] = $arr['post_id'];
        $topic['forum_id'] = $arr['forum_id'];
        $topic['forum_name'] = $myts->htmlSpecialChars($arr['forum_name']);
        $topic['id'] = $arr['topic_id'];

        $title = $myts->htmlSpecialChars($arr['topic_title']);
        if(!empty($options[5])){
        	$title = xoops_substr($title, 0, $options[5]);
    	}
        $topic['title'] = $title;
        $topic['replies'] = $arr['topic_replies'];
        $topic['views'] = $arr['topic_views'];
        $topic['time'] = newbb_formatTimestamp($arr['post_time']);
        if (!empty($author_name[$arr['uid']])) {
        	$topic_poster = $author_name[$arr['uid']];
        } else {
            $topic_poster = $myts->htmlSpecialChars( ($arr['poster_name'])?$arr['poster_name']:$GLOBALS["xoopsConfig"]["anonymous"] );
        }
        $topic['topic_poster'] = $topic_poster;
        $topic['topic_page_jump'] = $topic_page_jump;
        $block['topics'][] = $topic;
        unset($topic);
    }
    $block['indexNav'] = intval($options[4]);
    $block['modulename'] = $modulename;

    return $block;
}

// options[0] - Citeria valid: time(by default), views, replies, digest, sticky
// options[1] - NumberToDisplay: any positive integer
// options[2] - TimeDuration: negative for hours, positive for days, for instance, -5 for 5 hours and 5 for 5 days
// options[3] - DisplayMode: 0-full view;1-compact view;2-lite view
// options[4] - Display Navigator: 1 (by default), 0 (No)
// options[5] - Title Length : 0 - no limit
// options[6] - SelectedForumIDs: null for all

function b_newbb_topic_show($options)
{
    global $xoopsConfig;
    global $access_forums;
	$modulename = basename( dirname( dirname( __FILE__ ) ) );
    $db = &Database::getInstance();
    $myts = &MyTextSanitizer::getInstance();
    $block = array();
    $i = 0;
    $order = "";
    $extra_criteria = "";
    $time_criteria = null;
	if(!empty($options[2])) {
		$time_criteria = time() - newbb_getSinceTime($options[2]);
		$extra_criteria = " AND t.topic_time>".$time_criteria;
	}
    switch ($options[0]) {
        case 'views':
            $order = 't.topic_views';
            break;
        case 'replies':
            $order = 't.topic_replies';
            break;
        case 'digest':
            $order = 't.digest_time';
    		$extra_criteria = " AND t.topic_digest=1";
    		if($time_criteria)
    		$extra_criteria .= " AND t.digest_time>".$time_criteria;
            break;
        case 'sticky':
            $order = 't.topic_time';
    		$extra_criteria .= " AND t.topic_sticky=1";
            break;
        case 'time':
        default:
            $order = 't.topic_time';
            break;
    }
	$newbbConfig = getConfigForBlock();

    if(!isset($access_forums)){
	    $forum_handler =& xoops_getmodulehandler('forum', 'newbb');
    	if(!$access_obj =& $forum_handler->getForums(0, 'access', array('forum_id', 'cat_id', 'forum_type')) ){
	    	return null;
    	}
    	$access_forums = array_keys( $access_obj ); // get all accessible forums
    	unset($access_obj );
	}

    if (!empty($options[6])) {
        $allowedforums = array_filter(array_slice($options, 6), "b_newbb_array_filter"); // get allowed forums
        $allowed_forums = array_intersect($allowedforums, $access_forums);
    }else{
        $allowed_forums = $access_forums;
    }

    $forum_criteria = ' AND t.forum_id IN (' . implode(',', $allowed_forums) . ')';
    $approve_criteria = ' AND t.approved = 1';

    $query = 'SELECT'.
    		'	t.topic_id, t.topic_replies, t.forum_id, t.topic_title, t.topic_views, t.topic_subject, t.topic_time, t.topic_poster, t.poster_name,'.
    		'	f.forum_name, f.allow_subject_prefix'.
    		'	FROM ' . $db->prefix('bb_topics') . ' AS t '.
    		'	LEFT JOIN ' . $db->prefix('bb_forums') . ' AS f ON f.forum_id=t.forum_id'.
    		'	WHERE 1=1 ' .
    			$forum_criteria .
    			$approve_criteria .
    			$extra_criteria .
    			' ORDER BY ' . $order . ' DESC';

    $result = $db->query($query, $options[1], 0);
    if (!$result) {
	    newbb_message("newbb block query error: ".$query);
        return false;
    }
    $block['disp_mode'] = $options[3]; // 0 - full view; 1 - compact view; 2 - lite view;
    $rows = array();
    $author = array();
    while ($row = $db->fetchArray($result)) {
        $rows[] = $row;
        $author[$row["topic_poster"]] = 1;
    }
    if (count($rows) < 1) return false;
	$author_name = newbb_getUnameFromIds(array_keys($author), $newbbConfig['show_realname'], true);

    foreach ($rows as $arr) {
        $topic_page_jump = '';
        if ($arr['allow_subject_prefix']) {
            $subjectpres = explode(',', $newbbConfig['subject_prefix']);
            if (count($subjectpres) > 1) {
                foreach($subjectpres as $subjectpre) {
                    $subject_array[] = $subjectpre;
                }
               	$subject_array[0] = null;
            }
            $topic['topic_subject'] = $subject_array[$arr['topic_subject']];
        } else {
            $topic['topic_subject'] = "";
        }
        $topic['forum_id'] = $arr['forum_id'];
        $topic['forum_name'] = $myts->htmlSpecialChars($arr['forum_name']);
        $topic['id'] = $arr['topic_id'];

        $title = $myts->htmlSpecialChars($arr['topic_title']);
        if(!empty($options[5])){
        	$title = xoops_substr($title, 0, $options[5]);
    	}
        $topic['title'] = $title;
        $topic['replies'] = $arr['topic_replies'];
        $topic['views'] = $arr['topic_views'];
        $topic['time'] = newbb_formatTimestamp($arr['topic_time']);
        if (!empty($author_name[$arr['topic_poster']])) {
        	$topic_poster = $author_name[$arr['topic_poster']];
        } else {
            $topic_poster = $myts->htmlSpecialChars( ($arr['poster_name'])?$arr['poster_name']:$GLOBALS["xoopsConfig"]["anonymous"] );
        }
        $topic['topic_poster'] = $topic_poster;
        $topic['topic_page_jump'] = $topic_page_jump;
        $block['topics'][] = $topic;
        unset($topic);
    }
    $block['indexNav'] = intval($options[4]);
    $block['modulename'] = $modulename;

    return $block;
}

// options[0] - Citeria valid: title(by default), text
// options[1] - NumberToDisplay: any positive integer
// options[2] - TimeDuration: negative for hours, positive for days, for instance, -5 for 5 hours and 5 for 5 days
// options[3] - DisplayMode: 0-full view;1-compact view;2-lite view; Only valid for "time"
// options[4] - Display Navigator: 1 (by default), 0 (No)
// options[5] - Title/Text Length : 0 - no limit
// options[6] - SelectedForumIDs: null for all

function b_newbb_post_show($options)
{
    global $xoopsConfig;
    global $access_forums;
	$modulename = basename( dirname( dirname( __FILE__ ) ) );
    $db = &Database::getInstance();
    $myts = &MyTextSanitizer::getInstance();
    $block = array();
    $i = 0;
    $order = "";
    $extra_criteria = "";
    $time_criteria = null;
	if(!empty($options[2])) {
		$time_criteria = time() - newbb_getSinceTime($options[2]);
		$extra_criteria = " AND p.post_time>".$time_criteria;
	}
    
    switch ($options[0]) {
	    case "text":
		    if(!empty($newbbConfig['enable_karma']))
				$extra_criteria .= " AND p.post_karma = 0";
		    if(!empty($newbbConfig['allow_require_reply']))
				$extra_criteria .= " AND p.require_reply = 0";	    
        default:
            $order = 'p.post_time';
            break;
    }
    $newbbConfig = getConfigForBlock();

    if(!isset($access_forums)){
	    $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
    	if(!$access_obj =& $forum_handler->getForums(0, 'access', array('forum_id', 'cat_id', 'forum_type')) ){
	    	return null;
    	}
    	$access_forums = array_keys( $access_obj ); // get all accessible forums
    	unset($access_obj );
	}

    if (!empty($options[6])) {
        $allowedforums = array_filter(array_slice($options, 6), "b_newbb_array_filter"); // get allowed forums
        $allowed_forums = array_intersect($allowedforums, $access_forums);
    }else{
        $allowed_forums = $access_forums;
    }

    $forum_criteria = ' AND p.forum_id IN (' . implode(',', $allowed_forums) . ')';
    $approve_criteria = ' AND p.approved = 1';

    $query = 'SELECT';
    $query .= '	p.post_id, p.subject, p.post_time, p.icon, p.uid, p.poster_name,';
    if($options[0]=="text"){
    	$query .= '	p.dohtml, p.dosmiley, p.doxcode, p.dobr, pt.post_text,';    
	}
    $query .= '	f.forum_id, f.forum_name, f.allow_subject_prefix'.
    		'	FROM ' . $db->prefix('bb_posts') . ' AS p '.
    		'	LEFT JOIN ' . $db->prefix('bb_forums') . ' AS f ON f.forum_id=p.forum_id';
    if($options[0]=="text"){
    	$query .= '	LEFT JOIN ' . $db->prefix('bb_posts_text') . ' AS pt ON pt.post_id=p.post_id';
	}
    $query .= '	WHERE 1=1 ' .
    			$forum_criteria .
    			$approve_criteria .
    			$extra_criteria .
    			' ORDER BY ' . $order . ' DESC';

    $result = $db->query($query, $options[1], 0);
    if (!$result) {
	    newbb_message("newbb block query error: ".$query);
        return false;
    }
    $block['disp_mode'] = ($options[0]=="text")?3:$options[3]; // 0 - full view; 1 - compact view; 2 - lite view;
    $rows = array();
    $author = array();
    while ($row = $db->fetchArray($result)) {
        $rows[] = $row;
        $author[$row["uid"]] = 1;
    }
    if (count($rows) < 1) return false;
	$author_name = newbb_getUnameFromIds(array_keys($author), $newbbConfig['show_realname'], true);

    foreach ($rows as $arr) {
		//if ($arr['icon'] && is_file(XOOPS_ROOT_PATH . "/images/subject/" . $arr['icon'])) {
		if (!empty($arr['icon'])) {
            $last_post_icon = '<img src="' . XOOPS_URL . '/images/subject/' . htmlspecialchars($arr['icon']) . '" alt="" />';
        } else {
            $last_post_icon = '<img src="' . XOOPS_URL . '/images/subject/icon1.gif" alt="" />';
        }
        //$topic['jump_post'] = "<a href='" . XOOPS_URL . "/modules/newbb/viewtopic.php?post_id=" . $arr['post_id'] ."#forumpost" . $arr['post_id'] . "'>" . $last_post_icon . "</a>";
        $topic['forum_id'] = $arr['forum_id'];
        $topic['forum_name'] = $myts->htmlSpecialChars($arr['forum_name']);
        //$topic['id'] = $arr['topic_id'];

        $title = $myts->htmlSpecialChars($arr['subject']);
        if($options[0]!="text" && !empty($options[5])) {
	        $title = xoops_substr($title, 0, $options[5]);
        }
        $topic['title'] = $title;
        $topic['post_id'] = $arr['post_id'];
        $topic['time'] = newbb_formatTimestamp($arr['post_time']);
        if (!empty($author_name[$arr['uid']])) {
        	$topic_poster = $author_name[$arr['uid']];
        } else {
            $topic_poster = $myts->htmlSpecialChars( ($arr['poster_name'])?$arr['poster_name']:$GLOBALS["xoopsConfig"]["anonymous"] );
        }
        $topic['topic_poster'] = $topic_poster;
    	
        if($options[0]=="text"){
	        $post_text = $myts->displayTarea($arr['post_text'],$arr['dohtml'],$arr['dosmiley'],$arr['doxcode'],1,$arr['dobr']);
        	if(!empty($options[5])){
	    		$post_text = xoops_substr(newbb_html2text($post_text), 0, $options[5]);
    		}
        	$topic['post_text'] = $post_text;
        }        
        
        $block['topics'][] = $topic;
        unset($topic);
    }
    $block['indexNav'] = intval($options[4]);
    $block['modulename'] = $modulename;
    return $block;
}

// options[0] - Citeria valid: post(by default), topic, digest, sticky
// options[1] - NumberToDisplay: any positive integer
// options[2] - TimeDuration: negative for hours, positive for days, for instance, -5 for 5 hours and 5 for 5 days
// options[3] - DisplayMode: 0-full view;1-compact view;
// options[4] - Display Navigator: 1 (by default), 0 (No)
// options[5] - Title Length : 0 - no limit
// options[6] - SelectedForumIDs: null for all

function b_newbb_author_show($options)
{
    global $xoopsConfig;
    global $access_forums;
	$modulename = basename( dirname( dirname( __FILE__ ) ) );
    $db = &Database::getInstance();
    $myts = &MyTextSanitizer::getInstance();
    $block = array();
    $i = 0;
    $type = "topic";
    $order = "count";
    $extra_criteria = "";
    $time_criteria = null;
	if(!empty($options[2])) {
		$time_criteria = time() - newbb_getSinceTime($options[2]);
		$extra_criteria = " AND topic_time>".$time_criteria;
	}
    switch ($options[0]) {
        case 'topic':
            break;
        case 'digest':
    		$extra_criteria = " AND topic_digest=1";
    		if($time_criteria)
    		$extra_criteria .= " AND digest_time>".$time_criteria;
            break;
        case 'sticky':
    		$extra_criteria .= " AND topic_sticky=1";
            break;
        case 'post':
        default:
        	$type = "post";
    		if($time_criteria)
			$extra_criteria = " AND post_time>".$time_criteria;
            break;
    }
    $newbbConfig = getConfigForBlock();

    if(!isset($access_forums)){
	    $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
    	if(!$access_obj =& $forum_handler->getForums(0, 'access', array('forum_id', 'cat_id', 'forum_type')) ){
	    	return null;
    	}
    	$access_forums = array_keys( $access_obj ); // get all accessible forums
    	unset($access_obj );
	}

    if (!empty($options[5])) {
        $allowedforums = array_filter(array_slice($options, 5), "b_newbb_array_filter"); // get allowed forums
        $allowed_forums = array_intersect($allowedforums, $access_forums);
    }else{
        $allowed_forums = $access_forums;
    }

    if($type=="topic"){
	    $forum_criteria = ' AND forum_id IN (' . implode(',', $allowed_forums) . ')';
	    $approve_criteria = ' AND approved = 1';
	    $query = 'SELECT DISTINCT topic_poster AS author, COUNT(*) AS count
	    			FROM ' . $db->prefix('bb_topics') . '
	    			WHERE topic_poster>0 ' .
	    			$forum_criteria .
	    			$approve_criteria .
	    			$extra_criteria .
	    			' GROUP BY topic_poster ORDER BY ' . $order . ' DESC';
	}else{
	    $forum_criteria = ' AND forum_id IN (' . implode(',', $allowed_forums) . ')';
	    $approve_criteria = ' AND approved = 1';
	    $query = 'SELECT DISTINCT uid AS author, COUNT(*) AS count
	    			FROM ' . $db->prefix('bb_posts') . '
	    			WHERE uid>0 ' .
	    			$forum_criteria .
	    			$approve_criteria .
	    			$extra_criteria .
	    			' GROUP BY uid ORDER BY ' . $order . ' DESC';
	}

    $result = $db->query($query, $options[1], 0);
    if (!$result) {
	    newbb_message("newbb block query error: ".$query);
        return false;
    }
    $author = array();
    while ($row = $db->fetchArray($result)) {
	    $author[$row["author"]]["count"] = $row["count"];
    }
    if (count($author) < 1) return false;
	$author_name = newbb_getUnameFromIds(array_keys($author), $newbbConfig['show_realname']);
	foreach(array_keys($author) as $uid){
		$author[$uid]["name"] = $myts->htmlSpecialChars($author_name[$uid]);
	}
    $block['authors'] =& $author;
    $block['disp_mode'] = $options[3]; // 0 - full view; 1 - lite view;
    $block['indexNav'] = intval($options[4]);
    $block['modulename'] = $modulename;
    return $block;
}

function b_newbb_edit($options)
{
	$modulename = basename( dirname( dirname( __FILE__ ) ) );
    $form  = _MB_NEWBB_CRITERIA."<select name='options[0]'>";
    $form .= "<option value='time'";
    if($options[0]=="time") $form .= " selected='selected' ";
    $form .= ">"._MB_NEWBB_CRITERIA_TIME."</option>";
    $form .= "</select>";
    $form .= "<br />" . _MB_NEWBB_DISPLAY."<input type='text' name='options[1]' value='" . $options[1] . "' />";
    $form .= "<br />" . _MB_NEWBB_TIME."<input type='text' name='options[2]' value='" . $options[2] . "' />";
    $form .= "<br />&nbsp;&nbsp;&nbsp;&nbsp;<small>" . _MB_NEWBB_TIME_DESC. "</small>";
    $form .= "<br />" . _MB_NEWBB_DISPLAYMODE. "<input type='radio' name='options[3]' value='0'";
    if ($options[3] == 0) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_FULL . "<input type='radio' name='options[3]' value='1'";
    if ($options[3] == 1) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_COMPACT . "<input type='radio' name='options[3]' value='2'";
    if ($options[3] == 2) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_LITE;

    $form .= "<br />" . _MB_NEWBB_INDEXNAV."<input type=\"radio\" name=\"options[4]\" value=\"1\"";
    if ($options[4] == 1) $form .= " checked=\"checked\"";
    $form .= " />"._YES."<input type=\"radio\" name=\"options[4]\" value=\"0\"";
    if ($options[4] == 0) $form .= " checked=\"checked\"";
    $form .= " />"._NO;

    $form .= "<br />" . _MB_NEWBB_TITLE_LENGTH."<input type='text' name='options[5]' value='" . $options[5] . "' />";

    $form .= "<br /><br />" . _MB_NEWBB_FORUMLIST;

    $options_forum = array_filter(array_slice($options, 6), "b_newbb_array_filter"); // get allowed forums
    $isAll = (count($options_forum)==0||empty($options_forum[0]))?true:false;
    $form .= "<br />&nbsp;&nbsp;<select name=\"options[]\" multiple=\"multiple\">";
    $form .= "<option value=\"0\" ";
    if ($isAll) $form .= " selected=\"selected\"";
    $form .= ">"._ALL."</option>";
    $form .= newbb_forumSelectBox($options_forum);
    /*
	$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
	$forums = $forum_handler->getForumsByCategory(0, '', false);
	foreach (array_keys($forums) as $c) {
		foreach(array_keys($forums[$c]) as $f){
        	$sel = ($isAll || in_array($f, $options_forum))?" selected=\"selected\"":"";
        	$form .= "<option value=\"$f\" $sel>".$forums[$c][$f]["title"]."</option>";
	        if(!isset($forums[$c][$f]["sub"])) continue;
			foreach(array_keys($forums[$c][$f]["sub"]) as $s){
        		$sel = ($isAll || in_array($s, $options_forum))?" selected=\"selected\"":"";
        		$form .= "<option value=\"$s\" $sel>-- ".$forums[$c][$f]["sub"][$s]["title"]."</option>";
			}
		}
	}
    unset($forums);
    */
    $form .= "</select><br />";

    return $form;
}

function b_newbb_topic_edit($options)
{
	$modulename = basename( dirname( dirname( __FILE__ ) ) );
    $form  = _MB_NEWBB_CRITERIA."<select name='options[0]'>";
    $form .= "<option value='time'";
	    if($options[0]=="time") $form .= " selected='selected' ";
	    $form .= ">"._MB_NEWBB_CRITERIA_TIME."</option>";
    $form .= "<option value='views'";
	    if($options[0]=="views") $form .= " selected='selected' ";
	    $form .= ">"._MB_NEWBB_CRITERIA_VIEWS."</option>";
    $form .= "<option value='replies'";
	    if($options[0]=="replies") $form .= " selected='selected' ";
	    $form .= ">"._MB_NEWBB_CRITERIA_REPLIES."</option>";
    $form .= "<option value='digest'";
	    if($options[0]=="digest") $form .= " selected='selected' ";
	    $form .= ">"._MB_NEWBB_CRITERIA_DIGEST."</option>";
    $form .= "<option value='sticky'";
	    if($options[0]=="sticky") $form .= " selected='selected' ";
	    $form .= ">"._MB_NEWBB_CRITERIA_STICKY."</option>";
    $form .= "</select>";
    $form .= "<br />" . _MB_NEWBB_DISPLAY."<input type='text' name='options[1]' value='" . $options[1] . "' />";
    $form .= "<br />" . _MB_NEWBB_TIME."<input type='text' name='options[2]' value='" . $options[2] . "' />";
    $form .= "<br />&nbsp;&nbsp;&nbsp;&nbsp;<small>" . _MB_NEWBB_TIME_DESC. "</small>";
    $form .= "<br />" . _MB_NEWBB_DISPLAYMODE. "<input type='radio' name='options[3]' value='0'";
    if ($options[3] == 0) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_FULL . "<input type='radio' name='options[3]' value='1'";
    if ($options[3] == 1) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_COMPACT . "<input type='radio' name='options[3]' value='2'";
    if ($options[3] == 2) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_LITE;

    $form .= "<br />" . _MB_NEWBB_INDEXNAV."<input type=\"radio\" name=\"options[4]\" value=\"1\"";
    if ($options[4] == 1) $form .= " checked=\"checked\"";
    $form .= " />"._YES."<input type=\"radio\" name=\"options[4]\" value=\"0\"";
    if ($options[4] == 0) $form .= " checked=\"checked\"";
    $form .= " />"._NO;

    $form .= "<br />" . _MB_NEWBB_TITLE_LENGTH."<input type='text' name='options[5]' value='" . $options[5] . "' />";

    $form .= "<br /><br />" . _MB_NEWBB_FORUMLIST;

    $options_forum = array_filter(array_slice($options, 6), "b_newbb_array_filter"); // get allowed forums
    $isAll = (count($options_forum)==0||empty($options_forum[0]))?true:false;
    $form .= "<br />&nbsp;&nbsp;<select name=\"options[]\" multiple=\"multiple\">";
    $form .= "<option value=\"0\" ";
    if ($isAll) $form .= " selected=\"selected\"";
    $form .= ">"._ALL."</option>";
    $form .= newbb_forumSelectBox($options_forum);
	/*    
	$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
	$forums = $forum_handler->getForumsByCategory(0, '', false);
	foreach (array_keys($forums) as $c) {
		foreach(array_keys($forums[$c]) as $f){
        	$sel = ($isAll || in_array($f, $options_forum))?" selected=\"selected\"":"";
        	$form .= "<option value=\"$f\" $sel>".$forums[$c][$f]["title"]."</option>";
	        if(!isset($forums[$c][$f]["sub"])) continue;
			foreach(array_keys($forums[$c][$f]["sub"]) as $s){
        		$sel = ($isAll || in_array($s, $options_forum))?" selected=\"selected\"":"";
        		$form .= "<option value=\"$s\" $sel>-- ".$forums[$c][$f]["sub"][$s]["title"]."</option>";
			}
		}
	}
    unset($forums);
    */
    $form .= "</select><br />";

    return $form;
}

function b_newbb_post_edit($options)
{
	$modulename = basename( dirname( dirname( __FILE__ ) ) );
    $form  = _MB_NEWBB_CRITERIA."<select name='options[0]'>";
    $form .= "<option value='title'";
	    if($options[0]=="title") $form .= " selected='selected' ";
	    $form .= ">"._MB_NEWBB_CRITERIA_TITLE."</option>";
    $form .= "<option value='text'";
	    if($options[0]=="text") $form .= " selected='selected' ";
	    $form .= ">"._MB_NEWBB_CRITERIA_TEXT."</option>";
    $form  .= "</select>";
    $form .= "<br />" . _MB_NEWBB_DISPLAY."<input type='text' name='options[1]' value='" . $options[1] . "' />";
    $form .= "<br />" . _MB_NEWBB_TIME."<input type='text' name='options[2]' value='" . $options[2] . "' />";
    $form .= "<br />&nbsp;&nbsp;&nbsp;&nbsp;<small>" . _MB_NEWBB_TIME_DESC. "</small>";
    $form .= "<br />" . _MB_NEWBB_DISPLAYMODE. "<input type='radio' name='options[3]' value='0'";
    if ($options[3] == 0) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_FULL . "<input type='radio' name='options[3]' value='1'";
    if ($options[3] == 1) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_COMPACT . "<input type='radio' name='options[3]' value='2'";
    if ($options[3] == 2) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_LITE;

    $form .= "<br />" . _MB_NEWBB_INDEXNAV."<input type=\"radio\" name=\"options[4]\" value=\"1\"";
    if ($options[4] == 1) $form .= " checked=\"checked\"";
    $form .= " />"._YES."<input type=\"radio\" name=\"options[4]\" value=\"0\"";
    if ($options[4] == 0) $form .= " checked=\"checked\"";
    $form .= " />"._NO;

    $form .= "<br />" . _MB_NEWBB_TITLE_LENGTH."<input type='text' name='options[5]' value='" . $options[5] . "' />";

    $form .= "<br /><br />" . _MB_NEWBB_FORUMLIST;

    $options_forum = array_filter(array_slice($options, 6), "b_newbb_array_filter"); // get allowed forums
    $isAll = (count($options_forum)==0||empty($options_forum[0]))?true:false;
    $form .= "<br />&nbsp;&nbsp;<select name=\"options[]\" multiple=\"multiple\">";
    $form .= "<option value=\"0\" ";
    if ($isAll) $form .= " selected=\"selected\"";
    $form .= ">"._ALL."</option>";
    $form .= newbb_forumSelectBox($options_forum);
    /*
	$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
	$forums = $forum_handler->getForumsByCategory(0, '', false);
	foreach (array_keys($forums) as $c) {
		foreach(array_keys($forums[$c]) as $f){
        	$sel = ($isAll || in_array($f, $options_forum))?" selected=\"selected\"":"";
        	$form .= "<option value=\"$f\" $sel>".$forums[$c][$f]["title"]."</option>";
	        if(!isset($forums[$c][$f]["sub"])) continue;
			foreach(array_keys($forums[$c][$f]["sub"]) as $s){
        		$sel = ($isAll || in_array($s, $options_forum))?" selected=\"selected\"":"";
        		$form .= "<option value=\"$s\" $sel>-- ".$forums[$c][$f]["sub"][$s]["title"]."</option>";
			}
		}
	}
    unset($forums);
    */
    $form .= "</select><br />";

    return $form;
}

function b_newbb_author_edit($options)
{
	$modulename = basename( dirname( dirname( __FILE__ ) ) );
    $form  = _MB_NEWBB_CRITERIA."<select name='options[0]'>";
    $form .= "<option value='post'";
	    if($options[0]=="post") $form .= " selected='selected' ";
	    $form .= ">"._MB_NEWBB_CRITERIA_POST."</option>";
    $form .= "<option value='topic'";
	    if($options[0]=="topic") $form .= " selected='selected' ";
	    $form .= ">"._MB_NEWBB_CRITERIA_TOPIC."</option>";
    $form .= "<option value='digest'";
	    if($options[0]=="digest") $form .= " selected='selected' ";
	    $form .= ">"._MB_NEWBB_CRITERIA_DIGESTS."</option>";
    $form .= "<option value='sticky'";
	    if($options[0]=="sticky") $form .= " selected='selected' ";
	    $form .= ">"._MB_NEWBB_CRITERIA_STICKYS."</option>";
    $form .= "</select>";
    $form .= "<br />" . _MB_NEWBB_DISPLAY."<input type='text' name='options[1]' value='" . $options[1] . "' />";
    $form .= "<br />" . _MB_NEWBB_TIME."<input type='text' name='options[2]' value='" . $options[2] . "' />";
    $form .= "<br />&nbsp;&nbsp;&nbsp;&nbsp;<small>" . _MB_NEWBB_TIME_DESC. "</small>";
    $form .= "<br />" . _MB_NEWBB_DISPLAYMODE. "<input type='radio' name='options[3]' value='0'";
    if ($options[3] == 0) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_COMPACT . "<input type='radio' name='options[3]' value='1'";
    if ($options[3] == 1) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_LITE;

    $form .= "<br />" . _MB_NEWBB_INDEXNAV."<input type=\"radio\" name=\"options[4]\" value=\"1\"";
    if ($options[4] == 1) $form .= " checked=\"checked\"";
    $form .= " />"._YES."<input type=\"radio\" name=\"options[4]\" value=\"0\"";
    if ($options[4] == 0) $form .= " checked=\"checked\"";
    $form .= " />"._NO;

    $form .= "<br /><br />" . _MB_NEWBB_FORUMLIST;

    $options_forum = array_filter(array_slice($options, 5), "b_newbb_array_filter"); // get allowed forums
    $isAll = (count($options_forum)==0||empty($options_forum[0]))?true:false;
    $form .= "<br />&nbsp;&nbsp;<select name=\"options[]\" multiple=\"multiple\">";
    $form .= "<option value=\"0\" ";
    if ($isAll) $form .= " selected=\"selected\"";
    $form .= ">"._ALL."</option>";
    $form .= newbb_forumSelectBox($options_forum);
    /*
	$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
	$forums = $forum_handler->getForumsByCategory(0, '', false);
	foreach (array_keys($forums) as $c) {
		foreach(array_keys($forums[$c]) as $f){
        	$sel = ($isAll || in_array($f, $options_forum))?" selected=\"selected\"":"";
        	$form .= "<option value=\"$f\" $sel>".$forums[$c][$f]["title"]."</option>";
	        if(!isset($forums[$c][$f]["sub"])) continue;
			foreach(array_keys($forums[$c][$f]["sub"]) as $s){
        		$sel = ($isAll || in_array($s, $options_forum))?" selected=\"selected\"":"";
        		$form .= "<option value=\"$s\" $sel>-- ".$forums[$c][$f]["sub"][$s]["title"]."</option>";
			}
		}
	}
    unset($forums);
    */
    $form .= "</select><br />";

    return $form;
}
?>