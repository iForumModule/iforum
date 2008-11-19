<?php
// $Id: action.post.php,v 1.1.1.1 2005/10/19 16:23:23 phppp Exp $
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
include 'header.php';

$topic_id = isset($_POST['topic_id']) ? intval($_POST['topic_id']) : 0;
$post_id = !empty($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$post_id = !empty($_POST['post_id']) ? $_POST['post_id'] : $post_id;
$uid = !empty($_POST['uid']) ? $_POST['uid'] : 0;
$op = !empty($_GET['op']) ? $_GET['op'] : (!empty($_POST['op']) ? $_POST['op']:"");
$op = in_array($op, array("approve", "delete", "restore", "split"))? $op : "";
$mode = !empty($_GET['mode']) ? intval($_GET['mode']) : 1;

if ( empty($post_id) || empty($op)) {
	redirect_header("javascript:history.go(-1);", 2, _MD_NORIGHTTOACCESS);
    exit();
}

$post_handler =& icms_getmodulehandler('post', basename( dirname( __FILE__ ) ), 'iforum' );
$topic_handler =& icms_getmodulehandler('topic', basename( dirname( __FILE__ ) ), 'iforum' );
$forum_handler =& icms_getmodulehandler('forum', basename( dirname( __FILE__ ) ), 'iforum' );
if(empty($topic_id)){
	$viewtopic_forum = null;
}else{
	$forumtopic =& $topic_handler->get($topic_id);
	$forum_id = $forumtopic->getVar('forum_id');
	$viewtopic_forum =& $forum_handler->get($forum_id);
}
$isadmin = newbb_isAdmin($viewtopic_forum);

if(!$isadmin){
    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
    exit();
}

switch($op){
	case "restore":
		$post_id = array_values($post_id);
		sort($post_id);
		$topics=array();
		$forums=array();
		foreach($post_id as $post){
        	$post_obj =& $post_handler->get($post);
        	if(!empty($topic_id) && $topic_id!=$post_obj->getVar("topic_id")) continue;
			$post_handler->approve($post_obj);
			$topics[$post_obj->getVar("topic_id")] =1;
			$forums[$post_obj->getVar("forum_id")] =1;
			unset($post_obj);
		}
		foreach(array_keys($topics) as $topic){
			$topic_handler->synchronization($topic);
		}
		foreach(array_keys($forums) as $forum){
			$forum_handler->synchronization($forum);
		}
		break;
	case "approve":
		$post_id = array_values($post_id);
		sort($post_id);
		$topics=array();
		$forums=array();
		$criteria = new Criteria("post_id", "(".implode(",", $post_id).")", "IN");
		$posts_obj =& $post_handler->getObjects($criteria, true);
		foreach($post_id as $post){
        	$post_obj =& $posts_obj[$post];
        	if(!empty($topic_id) && $topic_id!=$post_obj->getVar("topic_id")) continue;
			$post_handler->approve($post_obj);
			$topics[$post_obj->getVar("topic_id")] = $post;
			$forums[$post_obj->getVar("forum_id")] = 1;
		}
		foreach(array_keys($topics) as $topic){
			$topic_handler->synchronization($topic);
		}
		foreach(array_keys($forums) as $forum){
			$forum_handler->synchronization($forum);
		}
		
		if(empty($xoopsModuleConfig['notification_enabled'])) break;
		
		$criteria_topic = new Criteria("topic_id", "(".implode(",", array_keys($topics)).")", "IN");
		$topic_list =& $topic_handler->getList($criteria_topic, true);
		
		$criteria_forum = new Criteria("forum_id", "(".implode(",", array_keys($forums)).")", "IN");
		$forum_list =& $forum_handler->getList($criteria_forum);
			
		include_once 'include/notification.inc.php';
		$notification_handler =& xoops_gethandler('notification');
		foreach($post_id as $post){
		    $tags = array();
		    $tags['THREAD_NAME'] = $topic_list[$posts_obj[$post]->getVar("topic_id")];
		    $tags['THREAD_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/viewtopic.php?topic_id=' . $posts_obj[$post]->getVar("topic_id").'&amp;forum=' . $posts_obj[$post]->getVar('forum_id');
		    $tags['FORUM_NAME'] = $forum_list[$posts_obj[$post]->getVar('forum_id')];
		    $tags['FORUM_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/viewforum.php?forum=' . $posts_obj[$post]->getVar('forum_id');
		    $tags['POST_URL'] = $tags['THREAD_URL'].'#forumpost' . $post;
	        $notification_handler->triggerEvent('thread', $posts_obj[$post]->getVar("topic_id"), 'new_post', $tags);
	        $notification_handler->triggerEvent('forum', $posts_obj[$post]->getVar('forum_id'), 'new_post', $tags);
	        $notification_handler->triggerEvent('global', 0, 'new_post', $tags);
	        $tags['POST_CONTENT'] = $posts_obj[$post]->getVar("post_text");
	        $tags['POST_NAME'] = $posts_obj[$post]->getVar("subject");
	        $notification_handler->triggerEvent('global', 0, 'new_fullpost', $tags);
	        $notification_handler->triggerEvent('forum', $posts_obj[$post]->getVar('forum_id'), 'new_fullpost', $tags);
		}
		break;
	case "delete":
		$post_id = array_values($post_id);
		rsort($post_id);
		$topics=array();
		$forums=array();
		foreach($post_id as $post){
			$post_obj =& $post_handler->get($post);
        	if(!empty($topic_id) && $topic_id!=$post_obj->getVar("topic_id")) continue;
			$topics[$post_obj->getVar("topic_id")] =1;
			$forums[$post_obj->getVar("forum_id")] =1;
			$post_handler->delete($post_obj);
			unset($post_obj);
		}
		foreach(array_keys($topics) as $topic){
			$topic_handler->synchronization($topic);
		}
		foreach(array_keys($forums) as $forum){
			$forum_handler->synchronization($forum);
		}
		break;
	case "split":
		$post_obj =& $post_handler->get($post_id);
		if(empty($post_id) || $post_obj->isTopic()) {
			break;
		}
		$topic_id = $post_obj->getVar("topic_id");
		
		$newtopic =& $topic_handler->create();
		$newtopic->setVar("topic_title", $post_obj->getVar("subject"), true);
		$newtopic->setVar("topic_poster", $post_obj->getVar("uid"), true);
		$newtopic->setVar("forum_id", $post_obj->getVar("forum_id"), true);
		$newtopic->setVar("topic_time", $post_obj->getVar("post_time"), true);
		$newtopic->setVar("poster_name", $post_obj->getVar("poster_name"), true);
		$newtopic->setVar("approved", 1, true);
		$topic_handler->insert($newtopic, true);		
		$new_topic_id = $newtopic->getVar('topic_id');
		
		$pid = $post_obj->getVar("pid");
		
		$post_obj->setVar("topic_id", $new_topic_id, true);
		$post_obj->setVar("pid", 0, true);
		$post_handler->insert($post_obj);
		
		/* split a single post */
		if($mode==1){
	        $criteria = new CriteriaCompo(new Criteria("topic_id", $topic_id));
	        $criteria->add(new Criteria('pid',$post_id));
	        $post_handler->updateAll("pid", $pid, $criteria, true);
		/* split a post and its children posts */
		}elseif($mode==2){
	        include_once(XOOPS_ROOT_PATH . "/class/xoopstree.php");
	        $mytree = new XoopsTree($xoopsDB->prefix("bb_posts"), "post_id", "pid");
            $posts = $mytree->getAllChildId($post_id);
            if(count($posts)>0){
	        	$criteria = new Criteria('post_id', "(".implode(",", $posts).")", "IN");
	            $post_handler->updateAll("topic_id", $new_topic_id, $criteria, true);
            }
		/* split a post and all posts coming after */
		}elseif($mode==3){
	        $criteria = new CriteriaCompo(new Criteria("topic_id", $topic_id));
	        $criteria->add(new Criteria('post_id',$post_id, ">"));
	        $post_handler->updateAll("topic_id", $new_topic_id, $criteria, true);
	        
	        unset($criteria);
	        $criteria = new CriteriaCompo(new Criteria("topic_id", $new_topic_id));
	        $criteria->add(new Criteria('post_id',$post_id, ">"));
	        $post_handler->identifierName = "pid";
	        $posts = $post_handler->getList($criteria);
	        
	        unset($criteria);
	        $post_update = array();
	        foreach($posts as $postid=>$pid){
		        if(!in_array($pid, array_keys($posts))){
			        $post_update[] = $pid; 
		        }
	        }
	        if(count($post_update)){
	        	$criteria = new Criteria('post_id', "(".implode(",", $post_update).")", "IN");
	            $post_handler->updateAll("pid", $post_id, $criteria, true);
        	}
		}
		
        $forum_id = $post_obj->getVar("forum_id");
		$topic_handler->synchronization($topic_id);
		$topic_handler->synchronization($new_topic_id);
        $sql = sprintf("UPDATE %s SET forum_topics = forum_topics+1 WHERE forum_id = %u", $xoopsDB->prefix("bb_forums"), $forum_id);
        $result = $xoopsDB->queryF($sql);
        
		break;
}
if(!empty($topic_id)){
	redirect_header("viewtopic.php?topic_id=$topic_id", 2, _MD_DBUPDATED);
}elseif(!empty($forum_id)){
	redirect_header("viewforum.php?forum=$forum_id", 2, _MD_DBUPDATED);
}else{
	redirect_header("viewpost.php?uid=$uid", 2, _MD_DBUPDATED);
}

include XOOPS_ROOT_PATH.'/footer.php';
?>