<?php
// $Id: rss.php,v 1.3 2005/10/19 17:20:28 phppp Exp $
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
// Author: phppp (D.J., infomax@gmail.com)                                  //
// URL: http://xoopsforge.com, http://xoops.org.cn                          //
// Project: Article Project                                                 //
// ------------------------------------------------------------------------ //

include_once("header.php");
include_once XOOPS_ROOT_PATH.'/class/template.php';
error_reporting(0);

	$forums = null;
	$category = empty($_GET["c"])?null:intval($_GET["c"]);
	if(isset($_GET["f"])){
		$forums = array_map("intval", array_map("trim", explode("|",$_GET["f"])));
	}
		$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
		$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
		$access_forums = $forum_handler->getForums(0,'access'); // get all accessible forums

		$available_forums = array();
		foreach($access_forums as $forum){
			if($topic_handler->getPermission($forum)) {
				$available_forums[$forum->getVar('forum_id')] = $forum;
			}
		}
	    unset($access_forums);
	    if(is_array($forums) && count($forums)>0){
		    foreach($forums as $forum){
			    if(in_array($forum, array_keys($available_forums)))
			    $valid_forums[] = $forum;
		    }
	    }elseif($category>0){
			//$category_handler =& xoops_getmodulehandler('category', 'newbb');
			$_forums = $forum_handler->getForumsByCategory($category);
			$forums = array_keys($_forums);
			unset($_forums);
		    foreach($forums as $forum){
			    if(in_array($forum, array_keys($available_forums)))
			    $valid_forums[] = $forum;
		    }

	    }else{
			$valid_forums = array_keys($available_forums);
	    }
		unset($available_forums);
		if(count($valid_forums)==0){
			exit();
		}

$charset = empty($xoopsModuleConfig['rss_utf8'])?_CHARSET:'UTF-8';
header ('Content-Type:text/xml; charset='.$charset);

$tpl = new XoopsTpl();
$tpl->xoops_setCaching(1);
$tpl->xoops_setCacheTime($xoopsModuleConfig['rss_cachetime']*60);

$compile_id = implode(",",$valid_forums);
$xoopsCachedTemplateId = 'mod_'.$xoopsModule->getVar('dirname').'|'.md5(str_replace(XOOPS_URL, '', $GLOBALS['xoopsRequestUri']));
if (!$tpl->is_cached('db:newbb_rss.html', $xoopsCachedTemplateId, $compile_id)) {

	$xmlrss_handler =& xoops_getmodulehandler('xmlrss', 'newbb');
	$rss = $xmlrss_handler->create();

	$rss->setVarRss('channel_title', $xoopsConfig['sitename'].' :: '._MD_FORUM);
	$rss->channel_link = XOOPS_URL.'/';
	$rss->setVarRss('channel_desc', $xoopsConfig['slogan'].' :: '.$xoopsModule->getInfo('description'));
	// There is a "bug" with xoops function formatTimestamp(time(), 'rss')
	// We have to make a customized function
	//$rss->channel_lastbuild = formatTimestamp(time(), 'rss');
	$rss->setVarRss('channel_lastbuild', newbb_formatTimestamp(time(), 'rss'));
	$rss->channel_webmaster = $xoopsConfig['adminmail'];
	$rss->channel_editor = $xoopsConfig['adminmail'];
	$rss->setVarRss('channel_category', $xoopsModule->getVar('name'));
	$rss->channel_generator = "CBB ".$xoopsModule->getInfo('version');
	$rss->channel_language = _LANGCODE;
    $rss->xml_encoding = empty($xoopsModuleConfig['rss_utf8'])?_CHARSET:'UTF-8';
	$rss->image_url = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/'.$xoopsModule->getInfo('image');

	$dimention = getimagesize(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar('dirname').'/'.$xoopsModule->getInfo('image'));
	if (empty($dimention[0])) {
		$width = 88;
	} else {
		$width = ($dimention[0] > 144) ? 144 : $dimention[0];
	}
	if (empty($dimention[1])) {
		$height = 31;
	} else {
		$height = ($dimention[1] > 400) ? 400 : $dimention[1];
	}
	$rss->image_width = $width;
	$rss->image_height = $height;

	$rss->max_items            = $xoopsModuleConfig['rss_maxitems'];
	$rss->max_item_description = $xoopsModuleConfig['rss_maxdescription'];


	    $forum_criteria = ' AND t.forum_id IN ('.implode(',',$valid_forums).')';
	    unset($valid_forums);
		$approve_criteria = ' AND t.approved = 1 AND p.approved = 1';

	    $query = 'SELECT'.
	    		'	f.forum_id, f.forum_name, f.allow_subject_prefix,'.
	    		'	t.topic_id, t.topic_title, t.topic_subject,'.
	    		'	p.post_id, p.post_time, p.subject, p.uid, p.poster_name, p.post_karma, p.require_reply, p.dohtml, p.dosmiley, p.doxcode,'.
	    		'	pt.post_text'.
	    		'	FROM ' . $xoopsDB->prefix('bb_posts') . ' AS p'.
	    		'	LEFT JOIN ' . $xoopsDB->prefix('bb_topics') . ' AS t ON t.topic_last_post_id=p.post_id'.
	    		'	LEFT JOIN ' . $xoopsDB->prefix('bb_posts_text') . ' AS pt ON pt.post_id=p.post_id'.
	    		'	LEFT JOIN ' . $xoopsDB->prefix('bb_forums') . ' AS f ON f.forum_id=p.forum_id'.
	    		'	WHERE 1=1 ' .
	    			$forum_criteria .
	    			$approve_criteria .
	    			' ORDER BY p.post_time DESC';

	    $limit = intval($xoopsModuleConfig['rss_maxitems'] * 1.5);

	    if (!$result = $xoopsDB->query($query,$limit)) {
		    newbb_message("query for rss builder error: ".$query);
			return $xmlrss_handler->get($rss);
	    }
	    $rows = array();
	    while ($row = $xoopsDB->fetchArray($result)) {
	        $users[$row['uid']] = 1;
	        $rows[] = $row;
	    }
		if(count($rows)<1) {
			return $xmlrss_handler->get($rss);
		}
		$users =& newbb_getUnameFromIds(array_keys($users), $xoopsModuleConfig['show_realname']);

		foreach($rows as $topic){
	        if( $xoopsModuleConfig['enable_karma'] && $topic['post_karma'] > 0 ) continue;
			if( $xoopsModuleConfig['allow_require_reply'] && $topic['require_reply']) continue;
			if(!empty($users[$topic['uid']])){
				$topic['uname'] = $users[$topic['uid']];
			}else{
            	$topic['uname'] = ($topic['poster_name'])?$myts->htmlSpecialChars($topic['poster_name']):$myts->htmlSpecialChars($GLOBALS["xoopsConfig"]["anonymous"]);
			}
			$description  = $topic["forum_name"]."::";
	        if ($topic['allow_subject_prefix']) {
	            $subjectpres = explode(',', $xoopsModuleConfig['subject_prefix']);
	            if (count($subjectpres) > 1) {
	                foreach($subjectpres as $subjectpre) {
	                    $subject_array[] = $subjectpre;
	                }
	               	$subject_array[0] = null;
	            }
	            $topic['topic_subject'] = $subject_array[$topic['topic_subject']];
	        } else {
	            $topic['topic_subject'] = "";
	        }
			$description  .= $topic['topic_subject']." ".$topic['topic_title']."<br />\n";
			$description  .= $myts->displayTarea($topic['post_text'], $topic['dohtml'], $topic['dosmiley'], $topic['doxcode']);
			$label = _MD_BY." ".$topic['uname'];
			$time = newbb_formatTimestamp($topic['post_time'], "rss");
	        $link = XOOPS_URL . "/modules/" . $xoopsModule->dirname() . '/viewtopic.php?topic_id=' . $topic['topic_id'] . '&amp;forum=' . $topic['forum_id'];
			$title = $topic['subject'];
	     	if(!$rss->addItem($title, $link, $description, $label, $time)) break;
		}
	$rss_feed = &$xmlrss_handler->get($rss);

	$tpl->assign('rss', $rss_feed);
	unset($rss);
}
$tpl->display('db:newbb_rss.html', $xoopsCachedTemplateId, $compile_id);
?>