<?php
// $Id: topic.php,v 1.6 2005/05/15 12:25:54 phppp Exp $
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
include_once XOOPS_ROOT_PATH . "/modules/newbb/class/newbbtree.php";

class Topic extends XoopsObject {
    var $order;

    function Topic()
    {
        $this->db = &Database::getInstance();
        $this->table = $this->db->prefix("bb_topics");
        $this->initVar('topic_id', XOBJ_DTYPE_INT);
        $this->initVar('topic_title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('topic_poster', XOBJ_DTYPE_INT);
        $this->initVar('topic_time', XOBJ_DTYPE_INT);
        $this->initVar('topic_views', XOBJ_DTYPE_INT);
        $this->initVar('topic_replies', XOBJ_DTYPE_INT);
        $this->initVar('topic_last_post_id', XOBJ_DTYPE_INT);
        $this->initVar('forum_id', XOBJ_DTYPE_INT);
        $this->initVar('topic_status', XOBJ_DTYPE_INT);
        $this->initVar('topic_subject', XOBJ_DTYPE_INT);
        $this->initVar('approved', XOBJ_DTYPE_INT);
        $this->initVar('poster_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('rating', XOBJ_DTYPE_OTHER);
        $this->initVar('votes', XOBJ_DTYPE_INT);
        $this->initVar('topic_haspoll', XOBJ_DTYPE_INT);
        $this->initVar('poll_id', XOBJ_DTYPE_INT);
    }

    function setOrder($order)
    {
        $this->order = $order;
    }

    function incrementCounter()
    {
        $sql = 'UPDATE ' . $this->db->prefix('bb_topics') . ' SET topic_views = topic_views + 1 WHERE topic_id =' . $this->getVar('topic_id');
        $this->db->queryF($sql);
    }
}

class NewbbTopicHandler extends XoopsObjectHandler
{
    function &get($id, $var = '')
    {
        if (!$id) return false;
        $sel = $var?strval($var):'*';
        $sql = 'SELECT ' . $sel . ' FROM ' . $this->db->prefix('bb_topics') . ' WHERE topic_id=' . $id;
        $result = $this->db->query($sql);
        if (!$result) {
            //echo "<br />NewbbTopicHandler::get error:" . $sql;
            return false;
        }
        $array = $this->db->fetchArray($result);
        if ($var) return $array[$var];
        $topic = &$this->create(false);
        $topic->assignVars($array);
        return $topic;
    }

    function &create($isNew = true)
    {
        $topic = new Topic();
        if ($isNew) {
            $topic->setNew();
        }
        return $topic;
    }

    function approve($topic_id)
    {
        $sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET approved = 1 WHERE topic_id = $topic_id";
        if (!$result = $this->db->queryF($sql)) {
            //echo "<br />NewbbTopicHandler::approve error:" . $sql;
            return false;
        }
        return true;
    }

    function &getByPost($post_id)
    {
        $sql = "SELECT t.* FROM " . $this->db->prefix('bb_topics') . " t, " . $this->db->prefix('bb_posts') . " p
                WHERE t.topic_id = p.topic_id AND p.post_id = " . intval($post_id);
        $result = $this->db->query($sql);
        if (!$result) {
            //echo "<br />NewbbTopicHandler::getByPost error:" . $sql;
            return false;
        }
        $row = $this->db->fetchArray($result);
        $topic = &$this->create(false);
        $topic->assignVars($row);
        return $topic;
    }

    function getPostCount(&$topic)
    {
        $approve_criteria = ' AND approved = 1';
        $sql = "SELECT COUNT(*) FROM " . $this->db->prefix('bb_posts') . " WHERE topic_id=" . intval($topic->getVar('topic_id')) . $approve_criteria;
        $result = $this->db->query($sql);
        if (!$result) {
            //echo "<br />NewbbTopicHandler::getPostCount error:" . $sql;
            return false;
        }
        list($count) = $this->db->fetchRow($result);
        return $count;
    }

    function getTopPost($topic_id)
    {
        $sql = "SELECT p.*, t.* FROM " . $this->db->prefix('bb_posts') . " p,
	        " . $this->db->prefix('bb_posts_text') . " t
	        WHERE
	        p.topic_id = " . $topic_id . " AND p.pid = 0
	        AND t.post_id = p.post_id";

        $result = $this->db->query($sql);
        if (!$result) {
            //echo "<br />NewbbTopicHandler::getTopPost error:" . $sql;
            return false;
        }
        $post_handler = &xoops_getmodulehandler('post', 'newbb');
        $myrow = $this->db->fetchArray($result);
        $post = &$post_handler->create(false);
        $post->assignVars($myrow);
        return $post;
    }

    function getTopPostId($topic_id)
    {
        $sql = "SELECT post_id FROM " . $this->db->prefix('bb_posts') . " WHERE topic_id = " . $topic_id . " AND pid = 0";
        $result = $this->db->query($sql);
        if (!$result) {
            //echo "<br />NewbbTopicHandler::getTopPostId error:" . $sql;
            return false;
        }
        list($post_id) = $this->db->fetchRow($result);
        return $post_id;
    }

    function &getAllPosts(&$topic, $order = "ASC", $perpage = 10, &$start, $post_id = 0)
    {
	    global $xoopsModuleConfig;

        $perpage = (intval($perpage)>0)?intval($perpage):(empty($xoopsModuleConfig['posts_per_page'])?10:$xoopsModuleConfig['posts_per_page']);
        $start = (intval($start)>0)?intval($start):0;
        $approve_criteria = ' AND p.approved = 1'; // any others?

        if ($post_id) {
	        if ($order == "DESC") {
	            $operator_for_position = '>' ;
	        } else {
	            $order = "ASC" ;
	            $operator_for_position = '<' ;
	        }
        	$approve_criteria = ' AND approved = 1'; // any others?
            $sql = "SELECT COUNT(*) FROM " . $this->db->prefix('bb_posts') . " WHERE topic_id=" . intval($topic->getVar('topic_id')) . $approve_criteria . " AND post_id $operator_for_position $post_id";
            $result = $this->db->query($sql);
	        if (!$result) {
	            //echo "<br />NewbbTopicHandler::getAllPosts:post-count error:" . $sql;
	            return false;
	        }
            list($position) = $this->db->fetchRow($result);
            $start = intval($position / $perpage) * $perpage;
        }

        $sql = 'SELECT p.*, t.* FROM ' . $this->db->prefix('bb_posts') . ' p, ' . $this->db->prefix('bb_posts_text') . " t WHERE p.topic_id=" . intval($topic->getVar('topic_id')) . " AND p.post_id = t.post_id" . $approve_criteria . " ORDER BY p.post_id $order";
        $result = $this->db->query($sql, $perpage, $start);
        if (!$result) {
            //echo "<br />NewbbTopicHandler::getAllPosts error:" . $sql;
            return false;
        }
        $ret = array();
        $post_handler = &xoops_getmodulehandler('post', 'newbb');
        while ($myrow = $this->db->fetchArray($result)) {
            $post = &$post_handler->create(false);
            $post->assignVars($myrow);
            $ret[$myrow['post_id']] = $post;
            unset($post);
        }
        return $ret;
    }

    function &getPostTree(&$postArray, $pid=0)
    {
        $NewBBTree = new NewBBTree('bb_posts');
        $NewBBTree->setPrefix('&nbsp;&nbsp;');
        $NewBBTree->setPostArray($postArray);
        $NewBBTree->getPostTree($postsArray, $pid);
        return $postsArray;
    }

    function showTreeItem(&$topic, &$postArray)
    {
        global $xoopsConfig, $xoopsModuleConfig, $viewtopic_users, $myts;

        $postArray['post_time'] = newbb_formatTimestamp($postArray['post_time']);

        if (is_file(XOOPS_ROOT_PATH . "/images/subject/" . $postArray['icon']))
            $postArray['icon'] = "<img src='" . XOOPS_URL . "/images/subject/" . $postArray['icon'] . "' alt='' />";
        else
            $postArray['icon'] = '<a name="' . $postArray['post_id'] . '"><img src="' . XOOPS_URL . '/images/icons/no_posticon.gif" alt="" /></a>';

        if (isset($viewtopic_users[$postArray['uid']]['is_forumadmin']))
            $postArray['subject'] = $myts->undoHtmlSpecialChars($postArray['subject']);
        $postArray['subject'] = '<a href="viewtopic.php?viewmode=thread&amp;topic_id=' . $topic->getVar('topic_id') . '&amp;forum=' . $postArray['forum_id'] . '&amp;post_id=' . $postArray['post_id'] . '">' . $postArray['subject'] . '</a>';

        $isActiveUser = false;
        if (isset($viewtopic_users[$postArray['uid']])) {
	        $postArray['poster'] = $viewtopic_users[$postArray['uid']]['name'];
	        if($postArray['uid']>0)
	        $postArray['poster'] = "<a href=\"".XOOPS_URL . "/userinfo.php?uid=" . $postArray['uid'] ."\">".$viewtopic_users[$postArray['uid']]['name']."</a>";
        }else{
            $postArray['poster'] = (empty($postArray['poster_name']))?$myts->HtmlSpecialChars($xoopsConfig['anonymous']):$postArray['poster_name'];
        }

        return $postArray;
    }


    function getViewData($topic_id, $forum, $move = '')
    {
        $sql = "SELECT
				t.topic_id,
		        t.topic_title,
		        t.topic_poster,
		        t.topic_status,
		        t.topic_subject,
		        t.topic_sticky,
		        t.topic_digest,
		        t.digest_time,
		        t.topic_time,
		        t.topic_last_post_id,
		        t.approved,
		        t.poster_name,
		        t.rating,
		        t.votes,
		        t.topic_haspoll,
		        t.poll_id,
		        f.forum_id,
		        f.forum_name,
		        f.allow_html,
		        f.allow_sig,
		        f.hot_threshold,
				f.forum_type,
		        f.allow_attachments,
		        f.attach_maxkb,
		        f.attach_ext,
		        f.allow_polls,
		        f.parent_forum
		        FROM
		        " . $this->db->prefix('bb_topics') . " t
		        LEFT JOIN " . $this->db->prefix('bb_forums') . " f ON f.forum_id = t.forum_id
		        WHERE ";
        if ('next' == $move)
            $sql .= "
				t.topic_id > $topic_id AND t.forum_id = $forum
				ORDER BY t.topic_id ASC LIMIT 1";
        elseif ('prev' == $move)
            $sql .= "
				t.topic_id < $topic_id AND t.forum_id = $forum
				ORDER BY t.topic_id DESC LIMIT 1";
        else
            $sql .= "
		        t.topic_id = $topic_id";

        $result = $this->db->query($sql);
        if (!$result) {
            //echo "<br />NewbbTopicHandler::getViewData error:" . $sql;
            return false;
        }

        if (!$forumdata = $this->db->fetchArray($result)) {
            return false;
        }

        return $forumdata;
    }

    function &getAllPosters(&$topic, $isApproved = true)
    {
        $sql = 'SELECT DISTINCT uid FROM ' . $this->db->prefix('bb_posts') . "  WHERE topic_id=" . $topic->getVar('topic_id')." AND uid>0";
        if($isApproved) $sql .= ' AND approved = 1';
        $result = $this->db->query($sql);
        if (!$result) {
            //echo "<br />NewbbTopicHandler::getAllPosters error:" . $sql;
            return array();
        }
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $ret[] = $myrow['uid'];
        }
        return $ret;
    }

    // get permission
    // parameter: $type: 'post', 'view',  'reply', 'edit', 'delete', 'addpoll', 'vote', 'attach'(, 'noapprove' -- to be added)
    // $gperm_names = "'forum_can_post', 'forum_can_view', 'forum_can_reply', 'forum_can_edit', 'forum_can_delete', 'forum_can_addpoll', 'forum_can_vote', 'forum_can_attach', 'forum_can_noapprove'";
    function getPermission($forum, $topic_locked = 0, $type = "view")
    {
        global $xoopsUser, $xoopsModule;
        static $_cachedTopicPerms;

        if(newbb_isAdmin($forum)) return 1;


        if (!is_object($forum)) {
	        if(intval($forum)<1) return false;
            $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
            $forum = &$forum_handler->get(intval($forum));
        }

        if (!isset($_cachedTopicPerms)){
            $getpermission = &xoops_getmodulehandler('permission', 'newbb');
            $_cachedTopicPerms = &$getpermission->getPermissions("topic");
        }

        $type = strtolower($type);
        $perm_item = 'forum_can_' . $type;
        $permission = (isset($_cachedTopicPerms[$forum->getVar('forum_id')][$perm_item])) ? 1 : 0;

        if ($topic_locked && 'view' != $type) $permission = 0;

        return $permission;
    }
}

?>