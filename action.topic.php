<?php
// $Id: action.topic.php,v 1.1.1.1 2005/10/19 16:23:24 phppp Exp $
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

$forum_id = isset($_POST['forum_id']) ? intval($_POST['forum_id']) : 0;
$topic_id = !empty($_POST['topic_id']) ? $_POST['topic_id'] : null;
$op = !empty($_POST['op']) ? $_POST['op']:"";
$op = in_array($op, array("approve", "delete", "restore", "move"))? $op : "";


if ( empty($topic_id) || empty($op)) {
	redirect_header("javascript:history.go(-1);", 2, _MD_NORIGHTTOACCESS);
    exit();
}

$topic_id = array_values($topic_id);
$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
/*
$topicid = is_array($topic_id)?$topic_id[0]:$topic_id;
$forumtopic =& $topic_handler->get($topicid);
$forum_id = $forumtopic->getVar('forum_id');
$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
$viewtopic_forum =& $forum_handler->get($forum_id);
*/

$isadmin = newbb_isAdmin($forum_id);

if(!$isadmin){
    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
    exit();
}

switch($op){
	case "restore":
		$forums = array();
		foreach($topic_id as $topic){
			$topic_handler->approve($topic);
			sync($topic, "topic");
			$forums[$topic_handler->get($topic, "forum_id")] = 1;
		}
		foreach(array_keys($forums) as $forum){
			sync($forum, "forum");
		}
		break;
	case "approve":
		$forums = array();
		$criteria = new Criteria("topic_id", "(".implode(",", $topic_id).")", "IN");
		$topics_obj =& $topic_handler->getObjects($criteria, true);
		foreach($topic_id as $topic){
			$topic_handler->approve($topic);
			sync($topic, "topic");
			$forums[$topics_obj[$topic]->getVar("forum_id")] = 1;
		}
		foreach(array_keys($forums) as $forum){
			sync($forum, "forum");
		}
		
		if(empty($xoopsModuleConfig['notification_enabled'])) break;
		
		$criteria_forum = new Criteria("forum_id", "(".implode(",", array_keys($forums)).")", "IN");
		$forum_list =& $forum_handler->getList($criteria_forum);
			
		include_once 'include/notification.inc.php';
		$notification_handler =& xoops_gethandler('notification');
		foreach($topic_id as $topic){
		    $tags = array();
		    $tags['THREAD_NAME'] = $topics_obj[$topic]->getVar("topic_title");
		    $tags['THREAD_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/viewtopic.php?topic_id=' . $topic.'&amp;forum=' . $topics_obj[$topic]->getVar('forum_id');
		    $tags['FORUM_NAME'] = $forum_list[$topics_obj[$topic]->getVar("forum_id")];
		    $tags['FORUM_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/viewforum.php?forum=' . $topics_obj[$topic]->getVar('forum_id');
	        $notification_handler->triggerEvent('global', 0, 'new_thread', $tags);
	        $notification_handler->triggerEvent('forum', $topics_obj[$topic]->getVar('forum_id'), 'new_thread', $tags);
	        $post_obj =& $topic_handler->getTopPost($topic);
		    $tags['POST_URL'] = $tags['THREAD_URL'].'#forumpost' . $post_obj->getVar("post_id");
	        $notification_handler->triggerEvent('thread', $topic, 'new_post', $tags);
	        $notification_handler->triggerEvent('forum', $topics_obj[$topic]->getVar('forum_id'), 'new_post', $tags);
	        $notification_handler->triggerEvent('global', 0, 'new_post', $tags);
	        $tags['POST_CONTENT'] = $post_obj->getVar("post_text");
	        $tags['POST_NAME'] = $post_obj->getVar("subject");
	        $notification_handler->triggerEvent('global', 0, 'new_fullpost', $tags);
	        $notification_handler->triggerEvent('forum', $topics_obj[$topic]->getVar('forum_id'), 'new_fullpost', $tags);
	        unset($post_obj);
		}
		break;
	case "delete":
		$forums = array();
		foreach($topic_id as $topic){
			$forums[$topic_handler->get($topic, "forum_id")] = 1;
			$topic_handler->delete($topic);
		}
		foreach(array_keys($forums) as $forum){
			sync($forum, "forum");
		}
		break;
	case "move":
		if(!empty($_POST["newforum"]) && $_POST["newforum"]!=$forum_id){
        	$criteria = new Criteria('topic_id', "(".implode(",", $topic_id).")", "IN");
			$post_handler =& xoops_getmodulehandler('post', 'newbb');
            $post_handler->updateAll("forum_id", intval($_POST["newforum"]), $criteria, true);
            $topic_handler->updateAll("forum_id", intval($_POST["newforum"]), $criteria, true);
            
            sync($_POST["newforum"], 'forum');
            sync($forum_id, 'forum');
		}else{
			$category_handler =& xoops_getmodulehandler('category', 'newbb');
		    $categories = $category_handler->getAllCats('access', true);
		    $forums = $category_handler->getForums(0, 'access', false);
		
	        $box = '<select name="newforum" size="1">';
			if(count($categories)>0 && count($forums)>0){
				foreach(array_keys($forums) as $key){
		            $box .= "<option value='-1'>[".$categories[$key]->getVar('cat_title')."]</option>";
		            foreach ($forums[$key] as $forumid=>$_forum) {
		                $box .= "<option value='".$forumid."'>-- ".$_forum['title']."</option>";
						if( !isset($_forum["sub"])) continue; 
			            foreach (array_keys($_forum["sub"]) as $fid) {
			                $box .= "<option value='".$fid."'>---- ".$_forum["sub"][$fid]['title']."</option>";
		                }
		            }
				}
		    } else {
		        $box .= "<option value='-1'>"._MD_NOFORUMINDB."</option>";
		    }
		    $box .="</select>";
	    	unset($forums, $categories);
	          
		    echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";
		    echo "<table border='0' cellpadding='1' cellspacing='0' align='center' width='95%'>";
		    echo "<tr><td class='bg2'>";
		    echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'>";
	        echo '<tr><td class="bg3">'._MD_MOVETOPICTO.'</td><td class="bg1">';
	    	echo $box;      
	        echo '</td></tr>';
		    echo '<tr class="bg3"><td colspan="2" align="center">';
		    echo "<input type='hidden' name='op' value='move' />";
		    foreach($topic_id as $id){
		    	echo "<input type='hidden' name='topic_id[]' value='".$id."' />";
	    	}
		    echo "<input type='submit' name='submit' value='". _SUBMIT."' />";
		    echo "</td></tr></table></td></tr></table>";
		    echo "</form>";
			include XOOPS_ROOT_PATH.'/footer.php';
			exit();
	    }
	    break;
}
if(empty($forum_id)){
	redirect_header("viewall.php", 2, _MD_DBUPDATED);
}else{
	redirect_header("viewforum.php?forum=$forum_id", 2, _MD_DBUPDATED);
}

include XOOPS_ROOT_PATH.'/footer.php';
?>