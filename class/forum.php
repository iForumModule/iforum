<?php
// $Id: forum.php,v 1.3 2005/10/19 17:20:32 phppp Exp $
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
include_once XOOPS_ROOT_PATH.'/modules/newbb/include/functions.php';

newbb_load_object();

class Forum extends ArtObject {
    var $db;
    var $table;

    function Forum()
    {
        $this->db = &Database::getInstance();
        $this->table = $this->db->prefix("bb_forums");
        $this->initVar('forum_id', XOBJ_DTYPE_INT);
        $this->initVar('forum_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('forum_desc', XOBJ_DTYPE_TXTAREA);
        $this->initVar('forum_moderator', XOBJ_DTYPE_ARRAY, serialize(array()));
        $this->initVar('forum_topics', XOBJ_DTYPE_INT);
        $this->initVar('forum_posts', XOBJ_DTYPE_INT);
        $this->initVar('forum_last_post_id', XOBJ_DTYPE_INT);
        $this->initVar('cat_id', XOBJ_DTYPE_INT);
        $this->initVar('forum_type', XOBJ_DTYPE_INT);
        $this->initVar('parent_forum', XOBJ_DTYPE_INT);
        $this->initVar('allow_html', XOBJ_DTYPE_INT); // To be added in 3.01: 0 - disabled; 1 - enabled; 2 - checked by default
        $this->initVar('allow_sig', XOBJ_DTYPE_INT);
        $this->initVar('allow_subject_prefix', XOBJ_DTYPE_INT);
        $this->initVar('hot_threshold', XOBJ_DTYPE_INT);
        $this->initVar('allow_polls', XOBJ_DTYPE_INT);
        $this->initVar('allow_attachments', XOBJ_DTYPE_INT);
        $this->initVar('attach_maxkb', XOBJ_DTYPE_INT);
        $this->initVar('attach_ext', XOBJ_DTYPE_TXTAREA);
        $this->initVar('forum_order', XOBJ_DTYPE_INT);
        /*
         * For desc
         *
         */
        $this->initVar("dohtml", XOBJ_DTYPE_INT, 1);
        $this->initVar("dosmiley", XOBJ_DTYPE_INT, 1);
        $this->initVar("doxcode", XOBJ_DTYPE_INT, 1);
        $this->initVar("doimage", XOBJ_DTYPE_INT, 1);
        $this->initVar("dobr", XOBJ_DTYPE_INT, 1);
    }

    function updateModerators($modertators)
    {
        $sql = "UPDATE " . $this->db->prefix('bb_forums') . " SET forum_moderator=" . $this->db->quoteString(serialize($modertators)) . " WHERE forum_id=" . $this->getVar('forum_id');
        if (!$result = $this->db->query($sql)) {
            //echo "<br />Forum::updateModerators error::" . $sql;
            return false;
        }

        return true;
    }

    // Get moderators in uname or in uid
    function &getModerators($asUname = false)
    {
	    static $_cachedModerators = array();

        $_moderators = $this->getVar('forum_moderator');
        $moderators = array();
        
        foreach($_moderators as $moderator){
	        if(empty($moderator)) continue;
	        $moderators[$moderator] = 1;
        }
        $moderators = array_keys($moderators);
        if(!$asUname) return $moderators;

        $moderators_return = array();
        $moderators_new = array();
        foreach($moderators as $id){
	        if($id ==0) continue;
	        if(isset($_cachedModerators[$id])) $moderators_return[$id] = &$_cachedModerators[$id];
	        else $moderators_new[]=$id;
        }
        if(count($moderators_new)>0){
	        $moderators_new = "(" . implode(',', $moderators_new) . ")";
	        $member_handler = &xoops_gethandler('member');
	        $moderators_new = $member_handler->getUserList(new Criteria('u.uid', $moderators_new, 'IN'), true);
	        foreach($moderators_new as $id => $name){
				$_cachedModerators[$id] = $name;
				$moderators_return[$id] = $name;
			}
        }
        return $moderators_return;
    }

    function isSubForum()
    {
        return ($this->getVar('parent_forum') > 0);
    }

    function getSubForums()
    {
        global $xoopsConfig, $xoopsModuleConfig, $myts;

        $sql = 'SELECT f.*, u.uid, p.topic_id, p.post_time, p.poster_name, p.subject, p.icon FROM ' . $this->db->prefix('bb_forums') . ' f LEFT JOIN ' . $this->db->prefix('bb_posts') . ' p ON p.post_id = f.forum_last_post_id LEFT JOIN ' . $this->db->prefix('users') . ' u ON u.uid = p.uid';
        $sql .= ' WHERE f.parent_forum = ' . $this->getVar('forum_id') . ' ORDER BY f.forum_order';

        if (!$result = $this->db->query($sql)) {
            //newbb_message("Forum::getSubForums error::" . $sql);
            return false;
        }

        $forums = array();
        $data = array();
        $ret = array();
        $users = array();
        $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
        while ($forum_data = $this->db->fetchArray($result)) {
	        $forum_data["moderators"] = unserialize($forum_data['forum_moderator']);
            $data[$forum_data['forum_id']] = $forum_data;
            $users = array_merge($users, $forum_data["moderators"]);
            $users[] = $forum_data["uid"];
        }
		$users_linked = newbb_getUnameFromIds(array_unique($users), !empty($xoopsModuleConfig['show_realname']), true);
        foreach($data as $id=>$forum_data){
			$forum_moderators = array();
			$moderators = $forum_data["moderators"];
			foreach($moderators as $moderator){
				$forum_moderators[] = @$users_linked[$moderator];
			}
			$forum_data["lastpost_user"] = @$users_linked[$forum_data["uid"]];
			$lastpost_user = @$users_linked[$forum_data["uid"]];
			if(empty($forum_data["lastpost_user"]) && !empty($forum_data["poster_name"])){
				$forum_data["lastpost_user"] = $myts->htmlSpecialChars($forum_data["poster_name"]);
			}
			if(empty($forum_data["lastpost_user"])){
				$forum_data["lastpost_user"] = $myts->htmlSpecialChars($GLOBALS["xoopsConfig"]["anonymous"]);
			}
			
            $forums = array_merge(
                array('forum_id' => $forum_data['forum_id'],
                    'forum_name' => $myts->htmlSpecialChars($forum_data['forum_name']),
                    'forum_desc' => $myts->displayTarea($forum_data['forum_desc'], 1, 1, 1, 1, 1),
                    'forum_posts' => $forum_data['forum_posts'],
                    'forum_topics' => $forum_data['forum_topics'],
                    'forum_type' => $forum_data['forum_type']
                    ),
                $this->disp_forumIndex($forum_data),
                array('forum_moderators' => implode(", ", $forum_moderators)
                    ),
                array('forum_permission' => $forum_handler->getPermission($this)
                    )
                );
            $ret[] = $forums;
        }
        /*
        while ($forum_data = $this->db->fetchArray($result)) {
            $forums = array_merge(
                array('forum_id' => $forum_data['forum_id'],
                    'forum_name' => $myts->htmlSpecialChars($forum_data['forum_name']),
                    'forum_desc' => $myts->displayTarea($forum_data['forum_desc'], 1, 1, 1, 1, 1),
                    'forum_posts' => $forum_data['forum_posts'],
                    'forum_topics' => $forum_data['forum_topics'],
                    'forum_type' => $forum_data['forum_type'],
                    ),
                $this->disp_forumIndex($forum_data),
                array('forum_moderators' => $this->disp_forumModerators(unserialize($forum_data['forum_moderator']))
                    ),
                array('forum_permission' => $forum_handler->getPermission($this)
                    )
                );
            $ret[] = $forums;
        }
        */
        return $ret;
    }

    function disp_forumIndex(&$forum_data)
    {
        global $xoopsConfig, $forumImage, $xoopsModule, $xoopsModuleConfig, $myts;

        $disp_array = array();

        if (!$forum_data['post_time'])
            return array("forum_lastpost_time" => "",
                "forum_lastpost_icon" => "",
                "forum_lastpost_user" => "",
                "forum_folder" => ($this->getVar('forum_type') == 1) ? newbb_displayImage($forumImage['locked_forum']) : newbb_displayImage($forumImage['folder_forum'])
                );

        $forum_lastview = newbb_getcookie('LF', true);
        $forum_lastview = (isset($forum_lastview[$forum_data['forum_id']]))?$forum_lastview[$forum_data['forum_id']]:0;

        $disp_array['forum_lastpost_time'] = newbb_formatTimestamp($forum_data['post_time']);

        $last_post_icon = '<a href="' . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/viewtopic.php?post_id=' . $forum_data['forum_last_post_id'] . '&amp;topic_id=' . $forum_data['topic_id'] . '#forumpost' . $forum_data['forum_last_post_id'] . '">';
        //if ($forum_data['icon']) {
        //if (!empty($forum_data['icon']) && is_file(XOOPS_ROOT_PATH . '/images/subject/' . $forum_data['icon'])) {
        if (!empty($forum_data['icon']) ) {
            $last_post_icon .= '<img src="' . XOOPS_URL . '/images/subject/' . htmlspecialchars($forum_data['icon']) . '" alt="" />';
        } else {
            $last_post_icon .= '<img src="' . XOOPS_URL . '/images/subject/icon1.gif" alt="" />';
        }
        $last_post_icon .= '</a>';
        $disp_array['forum_lastpost_icon'] = $last_post_icon;

        $forum_lastpost_user = @$forum_data['lastpost_user'];
        /*
        if(empty($forum_lastpost_user)):
        if ($forum_data['uid'] != 0 && $forum_data['uname']) {
            if ($xoopsModuleConfig['show_realname'] && $forum_data['name']) {
                $forum_lastpost_user = '<a href="' . XOOPS_URL . '/userinfo.php?uid=' . $forum_data['uid'] . '">' . $myts->htmlSpecialChars(@$forum_data['name']) . '</a>';
            } else {
                $forum_lastpost_user = '<a href="' . XOOPS_URL . '/userinfo.php?uid=' . $forum_data['uid'] . '">' . $myts->htmlSpecialChars($forum_data['uname']) . '</a>';
            }
        } else {
            $forum_lastpost_user = !empty($forum_data['poster_name'])?$myts->htmlSpecialChars($forum_data['poster_name']):$xoopsConfig['anonymous'];
        }
        endif;
        */
        $disp_array['forum_lastpost_user'] = $forum_lastpost_user;

        if ($GLOBALS['last_visit'] < $forum_data['post_time'] && $forum_lastview < $forum_data['post_time']) {
            $forum_folder = ($this->getVar('forum_type') == 1) ? $forumImage['locked_forum_newposts'] : $forumImage['newposts_forum'];
        } else {
            $forum_folder = ($this->getVar('forum_type') == 1) ? $forumImage['locked_forum'] : $forumImage['folder_forum'];
        }

        $disp_array['forum_folder'] = newbb_displayImage($forum_folder);

        return $disp_array;
    }

    function disp_forumModerators($valid_moderators = 0)
    {
    	global $xoopsDB, $xoopsModuleConfig, $myts;

        $ret = "";
        if ($valid_moderators === 0) {
            $valid_moderators = $this->getModerators();
        }
        if (empty($valid_moderators) || !is_array($valid_moderators)) {
            return $ret;
        }
        $moderators = newbb_getUnameFromIds($valid_moderators, !empty($xoopsModuleConfig['show_realname']), true);
        //unset($moderators[0]);
		$ret = implode(", ", $moderators);
		return $ret;
        
		/*
        if ($xoopsModuleConfig['show_realname']){
        	if (!$valid_moderators || count($valid_moderators) < 1) return false;
        	foreach ($valid_moderators as $uid => $uname) {
	 			$sql = "SELECT uid, name FROM ".$xoopsDB->prefix("users")." WHERE uid=$uid ";
				if ( !$result = $xoopsDB->query($sql) ) {
					return array();
				}
				if ( !$myrow = $xoopsDB->fetchArray($result) ) {
					return array();
				}

				$name = (empty($myrow['name']))?$myts->htmlSpecialChars($uname):$myts->htmlSpecialChars($myrow['name']);
            	$ret .= "<a href='" . XOOPS_URL . "/userinfo.php?uid=" . $uid . "'>" . $name . "</a> ";
        	}
        }
        else {
             if (!$valid_moderators || count($valid_moderators) < 1) return false;
        	 foreach ($valid_moderators as $uid => $uname) {
            	$ret .= "<a href='" . XOOPS_URL . "/userinfo.php?uid=" . $uid . "'>" . $myts->htmlSpecialChars($uname) . "</a> ";
        	 }

        }

        return $ret;
        */
    }
}

class NewbbForumHandler extends ArtObjectHandler
{
    function NewbbForumHandler(&$db) {
        $this->ArtObjectHandler($db, 'bb_forums', 'Forum', 'forum_id', 'forum_name');
    }

    function &create($isNew = true)
    {
        $forum = new Forum();
        if ($isNew) {
            $forum->setNew();
        }
        return $forum;
    }

    function &get($id)
    {
        $forum = &$this->create(false);
        if ($id > 0) {
            $sql = "SELECT * FROM " . $this->db->prefix("bb_forums") . " WHERE forum_id = " . intval($id);
            if (!$result = $this->db->query($sql)) {
	            newbb_message("NewbbForumHandler::get error::" . $sql);
	            return false;
            } while ($row = $this->db->fetchArray($result)) {
                $forum->assignVars($row);
            }
        }
        return $forum;
    }

    function insert(&$forum)
    {
        if (!$forum->isDirty()) {
            return true;
        }
        if (!$forum->cleanVars()) {
            $forum->setErrors("NewbbForumHandler::cleanVars error");
            return false;
        }
        foreach ($forum->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        if ($forum->isNew()) {
            $forum->setVar('forum_id', $this->db->genId($forum->table . "_forum_id_seq"));
            $sql = "INSERT INTO " . $forum->table . " (forum_id, forum_name, forum_desc,parent_forum,
             forum_moderator, forum_topics,forum_posts,forum_last_post_id, cat_id, forum_type, allow_html, allow_sig, allow_subject_prefix,
             hot_threshold, forum_order, allow_attachments,attach_maxkb, attach_ext, allow_polls,subforum_count)
             VALUES
             (" . $forum->getVar('forum_id') . ", " . $this->db->quoteString($forum_name) . ", " . $this->db->quoteString($forum_desc) . ", " . intval($parent_forum) . ",
              " . $this->db->quoteString($forum_moderator) . ",0,0,0, " . $cat_id . ",
              " . $forum_type . ", " . $allow_html . ", " . $allow_sig . "," . $allow_subject_prefix . ",
              " . $hot_threshold . ", " . $forum_order . ", " . $allow_attachments . ", " . $attach_maxkb . ", " . $this->db->quoteString($attach_ext) . ", " . $allow_polls . ",0 )";
        } else {
            $sql = "UPDATE " . $forum->table . " SET forum_name=" . $this->db->quoteString($forum_name) . ", forum_desc=" . $this->db->quoteString($forum_desc) . ",
             forum_moderator=" . $this->db->quoteString($forum_moderator) . ",
             cat_id=" . $cat_id . ", forum_type=" . $forum_type . ", allow_html=" . $allow_html . ",
             allow_sig=" . $allow_sig . ",allow_subject_prefix=" . $allow_subject_prefix . ",
             hot_threshold=" . $hot_threshold . ", forum_order=" . $forum_order . ", allow_attachments=" . $allow_attachments . ",
             attach_maxkb=" . $attach_maxkb . ", attach_ext=" . $this->db->quoteString($attach_ext) . ", allow_polls=" . $allow_polls . "
             WHERE forum_id=" . $forum_id . " ";
        }
        if (!$this->db->query($sql)) {
            $forum->setErrors("NewbbForumHandler::insert error::" . $sql);
            return false;
        }

        if (!($forum->getVar('forum_id'))) {
	        $forum->setVar('forum_id', $this->db->getInsertId());
        }
        
        if ($forum->isNew()) {
        	$this->applyPermissionTemplate($forum);
    	}

        return $forum->getVar('forum_id');
    }

    function delete(&$forum)
    {
        global $xoopsModule;
        /*
        $sql = "SELECT post_id FROM " . $this->db->prefix("bb_posts") . " WHERE forum_id = " . $forum->getVar('forum_id');
        if (!$r = $this->db->query($sql)) {
            newbb_message("NewbbForumHandler::delete error::" . $sql);
            return false;
        }
        if ($this->db->getRowsNum($r) > 0) {
            $sql = "DELETE FROM " . $this->db->prefix("bb_posts_text") . " WHERE ";
            $looped = false;
            while ($ids = $this->db->fetchArray($r)) {
                if ($looped == true) {
                    $sql .= " OR ";
                }
                $sql .= "post_id = " . $ids["post_id"] . " ";
                $looped = true;
            }
            if (!$r = $this->db->query($sql)) {
	            newbb_message("NewbbForumHandler::delete error::" . $sql);
	            return false;
	        }
            $sql = sprintf("DELETE FROM %s WHERE forum_id = %u", $this->db->prefix("bb_posts"), $forum->getVar('forum_id'));
            if (!$r = $this->db->query($sql)) {
	            newbb_message("NewbbForumHandler::delete error::" . $sql);
	            return false;
	        }
        }
        */
        // RMV-NOTIFY
        xoops_notification_deletebyitem ($xoopsModule->getVar('mid'), 'forum', $forum->getVar('forum_id'));
        // Get list of all topics in forum, to delete them too
		$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
        $sql = sprintf("SELECT topic_id FROM %s WHERE forum_id = %u", $this->db->prefix("bb_topics"), $forum->getVar('forum_id'));
        if ($r = $this->db->query($sql)) {
	        // There is potential scalability problem
            while ($row = $this->db->fetchArray($r)) {
				$topic_handler->delete($row['topic_id'], true);
                //xoops_notification_deletebyitem ($xoopsModule->getVar('mid'), 'thread', $row['topic_id']);
            }
        }
        /*
        $sql = sprintf("DELETE FROM %s WHERE forum_id = %u", $this->db->prefix("bb_topics"), $forum->getVar('forum_id'));
        if (!$r = $this->db->query($sql)) {
            return false;
        }
        */
        $sql = "DELETE FROM " . $forum->table . " WHERE forum_id=" . $forum->getVar('forum_id') . "";
        if (!$this->db->query($sql)) {
            newbb_message("NewbbForumHandler::delete error::" . $sql);
            return false;
        }
        $sql = "UPDATE " . $this->db->prefix('bb_forums') . " SET parent_forum = 0 WHERE parent_forum=".$forum->getVar('forum_id');
        if (!$this->db->query($sql)) {
            newbb_message("NewbbForumHandler::delete error::" . $sql);
            return false;
        }

        return $this->deletePermission($forum);
    }

    function &getForums($cat = null, $permission = "")
    {
	    $_cachedForums=array();
	    $perm_string = (empty($permission))?'all':$permission;
        $sql = "SELECT * FROM " . $this->db->prefix('bb_forums');
        if (is_numeric($cat) && $cat> 0) {
            $sql .= " WHERE cat_id=" . intval($cat);
        }elseif(is_array($cat) && count($cat) >0){
            $sql .= " WHERE cat_id IN (" . implode(", ", array_map("intval", $cat)).")";
        }
        $sql .= " ORDER BY forum_order";
        if (!$result = $this->db->query($sql)){
            newbb_message("NewbbForumHandler::getForums error::" . $sql);
            return $_cachedForums;
        }
        $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
        $_cachedForums[$perm_string]=array();
        while ($row = $this->db->fetchArray($result)) {
            $thisforum = $this->create(false);
            $thisforum->assignVars($row);
            if ($permission && !$this->getPermission($thisforum, $permission, empty($cat))) continue;
            $_cachedForums[$perm_string][$row['forum_id']] = $thisforum;
            unset($thisforum);
        }

        // TODO: Retrieve subforums
        return $_cachedForums[$perm_string];
    }
    
    function &getForumsByCategory($categoryid = null, $permission = "", $asObject = true)
    {
        $forums =& $this->getForums($categoryid, $permission);
        if($asObject) return $forums;
        
		$forums_array = array();
		$array_cat=array();
		$array_forum=array();
		if(!is_array($forums)) return array();
		foreach (array_keys($forums) as $forumid) {
			$forum =& $forums[$forumid];
		    $forums_array[$forum->getVar('parent_forum')][$forumid] = array(
			    'cid' => $forum->getVar('cat_id'),
			    'title' => $forum->getVar('forum_name')
			);
		}
		if(!isset($forums_array[0])) {
			$ret = array();
			return $ret;
		}
		foreach ($forums_array[0] as $key => $forum) {
		    if (isset($forums_array[$key])) {
		        $forum['sub'] = $forums_array[$key];
		    }
		    $array_forum[$forum['cid']][$key] = $forum;
		}
		ksort($array_forum);
		unset($forums);
		unset($forums_array);
        return $array_forum;
    }

    function &getForumsByCat($cat = 0)
    {
        $sql = "SELECT * FROM " . $this->db->prefix('bb_forums');
        if ($cat != 0) {
            $sql .= " WHERE cat_id=" . intval($cat);
        }
        $sql .= " ORDER BY forum_order, forum_id=parent_forum";
        if (!$result = $this->db->query($sql)) {
            newbb_message("NewbbForumHandler::getForumsByCat error::" . $sql);
            return false;
        }
        $ret = array();
        while ($row = $this->db->fetchArray($result)) {
            $thisforum = $this->create(false);
            $thisforum->assignVars($row);
            $ret[$row['cat_id']][$row['forum_id']] = $thisforum;
            unset($thisforum);
        }
        return $ret;
    }

    // Get moderators of multi-forums
    function &getModerators(&$forums, $asUname = false)
    {
        if (empty($forums)) $forums = $this->getForums();
        $moderators = array();
        if (is_array($forums)) {
            foreach ($forums as $forumid => $forum) {
                $moderators = array_merge($moderators, $forum->getModerators($asUname));
            }
        } elseif (is_object($forums)) {
            $moderators =& $forums->getModerators($asUname);
        }
        return $moderators;
    }

    function getAllTopics(&$forum, $startdate, $start, $sortname, $sortorder, $type = '', $excerpt = 0)
    {
        global $xoopsModule, $xoopsConfig, $xoopsModuleConfig, $forumImage, $forumUrl, $myts, $xoopsUser, $viewall_forums;
        $UserUid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : null;

        $topic_lastread = newbb_getcookie('LT', true);

        if (is_object($forum)) {
            $forum_criteria = ' AND t.forum_id = ' . $forum->getVar('forum_id');
            $hot_threshold = $forum->getVar('hot_threshold');
            $allow_subject_prefix = $forum->getVar('allow_subject_prefix');
        } else {
            $hot_threshold = 10;
            $allow_subject_prefix = 0;
            if (is_array($forum) && count($forum) > 0){
                $forum_criteria = ' AND t.forum_id IN (' . implode(',', array_keys($forum)) . ')';
            }elseif(!empty($forum)){
                $forum_criteria = ' AND t.forum_id ='.intval($forum);
            }else{
                $forum_criteria = '';
            }
        }

        $sort = array();
        $extra_criteria = '';
        $approve_criteria = ' AND t.approved = 1 AND p.approved = 1';
        $post_time = ' p.post_time > ' . $startdate;
        $post_on = ' p.post_id = t.topic_last_post_id';
        $post_criteria = '';
        switch ($type) {
            case 'digest':
                //$post_time = ' p.post_time > ' . $startdate;
                $extra_criteria = ' AND t.topic_digest = 1';
                break;
            case 'unreplied':
                //$post_time = ' p.post_time > ' . $startdate;
                $extra_criteria = ' AND t.topic_replies < 1';
                break;
            case 'unread':
                $post_time = ' p.post_time > ' . max($GLOBALS['last_visit'], $startdate);
                break;
            case 'pending':
		        $post_on = ' p.topic_id = t.topic_id';
        		$post_criteria = ' AND p.pid=0';
        		$approve_criteria = ' AND t.approved = 0';
                break;
            case 'deleted':
        		$approve_criteria = ' AND t.approved = -1';
                break;
            case 'all': // For viewall.php; do not display sticky topics at first
            case 'active': // same as "all"
                //$post_time = ' p.post_time > ' . $startdate;
                break;
            default:
                $post_time = ' (p.post_time > ' . $startdate . ' OR t.topic_sticky=1)';
                $sort[] = 't.topic_sticky DESC';
                break;
        }
        
        $select = 	't.*, '.
        			//'t.topic_id, t.topic_title, t.topic_poster, t.topic_time, t.topic_views, t.topic_replies, t.topic_last_post_id, t.topic_subject, t.poster_name,'.
        			//' t.topic_sticky, t.topic_haspoll, t.topic_status, t.rating, t.forum_id, t.topic_digest,'.
        			' p.post_time as last_post_time, p.poster_name as last_poster_name, p.icon, p.post_id, p.uid';
        $from = $this->db->prefix("bb_topics") . ' t LEFT JOIN ' . $this->db->prefix('bb_posts') . ' p ON '.$post_on;
        $where = $post_time . $post_criteria. $forum_criteria . $extra_criteria . $approve_criteria;

        if($excerpt==0){
        	//$sql = 'SELECT t.*, u.name, u.uname, u2.uid, u2.name as last_post_name, u2.uname as last_poster, p.post_time as last_post_time, p.poster_name as last_poster_name, p.icon, p.post_id FROM ' . $this->db->prefix("bb_topics") . ' t LEFT JOIN ' . $this->db->prefix("users") . ' u ON u.uid = t.topic_poster LEFT JOIN ' . $this->db->prefix('bb_posts') . ' p ON p.post_id = t.topic_last_post_id LEFT JOIN ' . $this->db->prefix("users") . ' u2 ON  u2.uid = p.uid WHERE ';
        	//$sql = 'SELECT t.*, p.post_time as last_post_time, p.poster_name as last_poster_name, p.icon, p.post_id, p.uid FROM ' . $this->db->prefix("bb_topics") . ' t LEFT JOIN ' . $this->db->prefix('bb_posts') . ' p ON p.post_id = t.topic_last_post_id WHERE ';
    	}else{
        	//$sql = 'SELECT t.*, u.name, u.uname, u2.uid, u2.name as last_post_name, u2.uname as last_poster, p.post_time as last_post_time, p.poster_name as last_poster_name, p.icon, p.post_id, p.post_karma, p.require_reply, pt.post_text FROM ' . $this->db->prefix("bb_topics") . ' t LEFT JOIN ' . $this->db->prefix("users") . ' u ON u.uid = t.topic_poster LEFT JOIN ' . $this->db->prefix('bb_posts') . ' p ON p.post_id = t.topic_last_post_id LEFT JOIN ' . $this->db->prefix('bb_posts_text') . ' pt ON pt.post_id = t.topic_last_post_id LEFT JOIN ' . $this->db->prefix("users") . ' u2 ON  u2.uid = p.uid WHERE ';
        	//$sql = 'SELECT t.*, p.post_time as last_post_time, p.poster_name as last_poster_name, p.icon, p.post_id, p.uid, p.post_karma, p.require_reply, pt.post_text FROM ' . $this->db->prefix("bb_topics") . ' t LEFT JOIN ' . $this->db->prefix('bb_posts') . ' p ON p.post_id = t.topic_last_post_id LEFT JOIN ' . $this->db->prefix('bb_posts_text') . ' pt ON pt.post_id = t.topic_last_post_id WHERE ';
        	$select .=', p.post_karma, p.require_reply, pt.post_text';
        	$from .= ' LEFT JOIN ' . $this->db->prefix('bb_posts_text') . ' pt ON pt.post_id = t.topic_last_post_id';
    	}
    	if($sortname == "u.uname"){
	    	/*
        	$select .=', u.uname';
        	$from .= 'LEFT JOIN ' . $this->db->prefix("users") . ' u ON u.uid = t.topic_poster';
        	*/
        	$sortname = "t.topic_poster";
    	}
    	
        $sort[] = trim($sortname.' '.$sortorder);
        $sort = implode(", ", $sort);
        if(empty($sort)) $sort = 'p.post_time DESC';
    	
        //$sql .= $post_time . $forum_criteria . $extra_criteria . $approve_criteria . $sort;
        
    	$sql = 	'SELECT '.$select.
    			' FROM '.$from.
    			' WHERE '.$where.
    			' ORDER BY '.$sort;
    			
        if (!$result = $this->db->query($sql, $xoopsModuleConfig['topics_per_page'], $start)) {
            redirect_header('index.php', 2, _MD_ERROROCCURED . '<br />' . $sql);
            exit();
        }

        $subject_array = array();
        if(!empty($allow_subject_prefix) && !empty($xoopsModuleConfig['subject_prefix'])):
        $subjectpres = explode(',', $xoopsModuleConfig['subject_prefix']);
        if (count($subjectpres) > 1) {
            foreach($subjectpres as $subjectpre) {
                $subject_array[] = $subjectpre." ";
            }
        }
        endif;
        $subject_array[0] = null;


        $sticky = 0;
        $topics = array();
        $posters = array();
        while ($myrow = $this->db->fetchArray($result)) {
            // ------------------------------------------------------
            /* Necessary and sufficient conditions for an unread topic:
            	1. the last_post_time must be later than the last_vist;
            	2. the last_post_time must be later than the topic_lastread;
            */
            $is_unread = false;
            $lastread = empty($topic_lastread[$myrow['topic_id']])? 0 : $topic_lastread[$myrow['topic_id']];
            if(max($GLOBALS['last_visit'], $lastread) < $myrow['last_post_time']) $is_unread = true;
            // ------------------------------------------------------

            // ------------------------------------------------------
            // topic_icon: priority: sticky -> digest -> regular

            // ------------------------------------------------------
            // type: if 'unread' topics
            if ('unread' == $type) {
	            if(!$is_unread) continue;
            }

            // ------------------------------------------------------
            // topic_icon: priority: sticky -> digest -> regular
            //if (!empty($myrow['icon']) && is_file(XOOPS_ROOT_PATH . '/images/subject/' . $myrow['icon'])) {
            if (!empty($myrow['icon'])) {
                $topic_icon = '<img src="' . XOOPS_URL . '/images/subject/' . htmlspecialchars($myrow['icon']) . '" alt="" />';
                $stick = 1;
            } else {
                $topic_icon = '<img src="' . XOOPS_URL . '/images/icons/no_posticon.gif" alt="" />';
                $stick = 1;
            }
            if ($myrow['topic_sticky']) {
                $topic_icon = newbb_displayImage($forumImage['folder_sticky'], _MD_TOPICSTICKY);
                $stick = 0;
                $sticky++;
            }
            if ($myrow['topic_haspoll']) {
	            if ($myrow['topic_sticky']) {
	                $topic_icon = newbb_displayImage($forumImage['folder_sticky'], _MD_TOPICSTICKY) . '<br />' . newbb_displayImage($forumImage['poll'], _MD_TOPICHASPOLL);
	                $stick = 0;
	                //$sticky++;
	            }else{
                	$topic_icon = newbb_displayImage($forumImage['poll'], _MD_TOPICHASPOLL);
	            }
            }
            // ------------------------------------------------------
            // topic_folder: priority: newhot -> hot/new -> regular
            if ($myrow['topic_status'] == 1) {
                $topic_folder = $forumImage['locked_topic'];
            } else {
                if ($myrow['topic_digest']) $topic_folder = $forumImage['folder_digest'];
                elseif ($myrow['topic_replies'] >= $hot_threshold) {
	                if($is_unread){
                        $topic_folder = $forumImage['hot_newposts_topic'];
                    } else {
                        $topic_folder = $forumImage['hot_folder_topic'];
                    }
                } else {
	                if($is_unread){
                        $topic_folder = $forumImage['newposts_topic'];
                    } else {
                        $topic_folder = $forumImage['folder_topic'];
                    }
                }
            }
            // ------------------------------------------------------
            // rating_img
            $rating = number_format($myrow['rating'] / 2, 0);
            if ($rating < 1) {
                $rating_img = newbb_displayImage($forumImage['blank']);
            } else {
                $rating_img = newbb_displayImage($forumImage['rate' . $rating]);
            }
            // ------------------------------------------------------
            // topic_page_jump
            /*
            //if ($myrow['icon']) {
            if (!empty($myrow['picon']) && is_file(XOOPS_ROOT_PATH . '/images/subject/' . $myrow['picon'])) {
            	$last_post_icon = '<img src="' . XOOPS_URL . '/images/subject/' . $myrow['picon'] . '" alt="" />';
        	} else {
            	$last_post_icon = newbb_displayImage($forumImage['docicon']);
        	}
        	*/
            $topic_page_jump = '';
            $topic_page_jump_icon = '';
            $totalpages = ceil(($myrow['topic_replies'] + 1) / $xoopsModuleConfig['posts_per_page']);
            if ($totalpages > 1) {
                //$topic_page_jump .= '&nbsp;&nbsp;&nbsp;<img src="' . XOOPS_URL . '/images/icons/posticon.gif" alt="" /> ';
                $topic_page_jump .= '&nbsp;&nbsp;';
                $append = false;
                for ($i = 1; $i <= $totalpages; $i++) {
                    if ($i > 3 && $i < $totalpages) {
	                    if(!$append){
                        	$topic_page_jump .= "...";
                        	$append = true;
                    	}
                    } else {
                        $topic_page_jump .= '[<a href="viewtopic.php?topic_id=' . $myrow['topic_id'] . '&amp;start=' . (($i - 1) * $xoopsModuleConfig['posts_per_page']) . '">' . $i . '</a>]';
                        $topic_page_jump_icon = "<a href='" . XOOPS_URL . "/modules/newbb/viewtopic.php?topic_id=" . $myrow['topic_id'] . "&amp;start=" . (($i - 1) * $xoopsModuleConfig['posts_per_page']) . "#forumpost" . $myrow['post_id'] . "'>" . newbb_displayImage($forumImage['docicon']) . "</a>";
                    }
                }
            }
            else {
            	$topic_page_jump_icon = "<a href='" . XOOPS_URL . "/modules/newbb/viewtopic.php?topic_id=" . $myrow['topic_id'] . "#forumpost" . $myrow['post_id'] . "'>" . newbb_displayImage($forumImage['docicon']) . "</a>";
        	}
            /*
        	// ------------------------------------------------------
            // topic_poster
            if ($myrow['topic_poster'] != 0 && $myrow['uname']) {
                if ($xoopsModuleConfig['show_realname'] && $myrow['name']) {
                    $topic_poster = '<a href="' . XOOPS_URL . '/userinfo.php?uid=' . $myrow['topic_poster'] . '">' . $myts->htmlSpecialChars($myrow['name']) . '</a>';
                } else {
                    $topic_poster = '<a href="' . XOOPS_URL . '/userinfo.php?uid=' . $myrow['topic_poster'] . '">' . $myts->htmlSpecialChars($myrow['uname']) . '</a>';
                }
            } else {
                $topic_poster = $myrow['poster_name']?$myts->htmlSpecialChars($myrow['poster_name']):$xoopsConfig['anonymous'];
            }
            // ------------------------------------------------------
            // topic_last_poster
            if ($xoopsModuleConfig['show_realname'] && $myrow['last_post_name']) {
                $topic_last_poster = $myts->htmlSpecialChars($myrow['last_post_name']);
            } elseif($myrow['last_poster']) {
                $topic_last_poster = $myts->htmlSpecialChars($myrow['last_poster']);
            } elseif ($myrow['last_poster_name']){
                $topic_last_poster = $myts->htmlSpecialChars($myrow['last_poster_name']);
        	}else{
                $topic_last_poster = $xoopsConfig['anonymous'];
            }

            if($myrow['uid']>0){
	            $topic_last_poster = '<a href="' . XOOPS_URL . '/userinfo.php?uid=' . $myrow['uid'] . '">' . $topic_last_poster . '</a>';
            }
            */
            // ------------------------------------------------------
            // => topic array
            if (is_object($viewall_forums[$myrow['forum_id']])){
                $forum_link = '<a href="' . XOOPS_URL . '/modules/newbb/viewforum.php?forum=' . $myrow['forum_id'] . '">' . $myts->htmlSpecialChars($viewall_forums[$myrow['forum_id']]->getVar('forum_name')) . '</a>';
            }else {
	            $forum_link = '';
            }

           	$topic_title = $myts->htmlSpecialChars($myrow['topic_title']);
            if ($myrow['topic_digest']) $topic_title = "<span class='digest'>" . $topic_title . "</span>";

            /*
            $subjectpres = explode(',', $xoopsModuleConfig['subject_prefix']);
            if (count($subjectpres) > 1) {
                foreach($subjectpres as $subjectpre) {
                    $subject_array[] = $subjectpre." ";
                }
            }
            $subject_array[0] = null;
            */

            if( $excerpt == 0 ){
	            $topic_excerpt = "";
            }elseif( ($myrow['post_karma']>0 || $myrow['require_reply']>0) && !newbb_isAdmin($forum) ){
	            $topic_excerpt = "";
            }else{
	            $topic_excerpt = xoops_substr(newbb_html2text($myrow['post_text']), 0, $excerpt);
	            $topic_excerpt = $myts->htmlSpecialChars($topic_excerpt);
            }

            $topic_subject = ($allow_subject_prefix)?$subject_array[$myrow['topic_subject']]:"";
            $topics[$myrow['topic_id']] = array(
            	'topic_id' => $myrow['topic_id'],
            	'topic_icon' => $topic_icon,
                'topic_folder' => newbb_displayImage($topic_folder),
                'topic_title' => $topic_subject.$topic_title,
                //'allow_prefix' => $allow_subject_prefix,
                //'topic_subject' => $subject_array[$myrow['topic_subject']],
                'topic_link' => 'viewtopic.php?topic_id=' . $myrow['topic_id'] . '&amp;forum=' . $myrow['forum_id'],
                'rating_img' => $rating_img,
                'topic_page_jump' => $topic_page_jump,
                'topic_page_jump_icon' => $topic_page_jump_icon,
                'topic_replies' => $myrow['topic_replies'],
                'topic_poster_uid' => $myrow['topic_poster'],
                'topic_poster_name' => $myts->htmlSpecialChars( ($myrow['poster_name'])?$myrow['poster_name']:$xoopsConfig['anonymous']),
                'topic_views' => $myrow['topic_views'],
                'topic_time' => newbb_formatTimestamp($myrow['topic_time']),
                'topic_last_posttime' => newbb_formatTimestamp($myrow['last_post_time']),
                'topic_last_poster_uid' => $myrow['uid'],
                'topic_last_poster_name' => $myts->htmlSpecialChars( ($myrow['last_poster_name'])?$myrow['last_poster_name']:$xoopsConfig['anonymous']),
                'topic_forum_link' => $forum_link,
                'topic_excerpt' => $topic_excerpt,
                'stick' => $stick
                );
                
                /* users */
                $posters[$myrow['topic_poster']] = 1;
                $posters[$myrow['uid']] = 1;
            }
			$posters_name =& newbb_getUnameFromIds(array_keys($posters), $xoopsModuleConfig['show_realname'], true);
            
            foreach(array_keys($topics) as $id){
	            $topics[$id]["topic_poster"] = !empty($posters_name[$topics[$id]["topic_poster_uid"]])?
	                                			$posters_name[$topics[$id]["topic_poster_uid"]]
	            								:$topics[$id]["topic_poster_name"];
	            $topics[$id]["topic_last_poster"] = !empty($posters_name[$topics[$id]["topic_last_poster_uid"]])?
	                                			$posters_name[$topics[$id]["topic_last_poster_uid"]]
	            								:$topics[$id]["topic_last_poster_name"];
	            unset($topics[$id]["topic_poster_name"], $topics[$id]["topic_last_poster_name"]);
            }

            if ( count($topics) > 0) {
		    	$sql = " SELECT DISTINCT topic_id FROM " . $this->db->prefix("bb_posts").
		    	 		" WHERE attachment != ''".
		    	 		" AND topic_id IN (" . implode(',', array_keys($topics)) . ")";
                if($result = $this->db->query($sql)) {
                    while (list($topic_id) = $this->db->fetchRow($result)) {
                        $topics[$topic_id]['attachment'] = '&nbsp;' . newbb_displayImage($forumImage['clip'], _MD_TOPICSHASATT);
                    }
                }
            }
            return array($topics, $sticky);
        }

        function getTopicCount(&$forum, $startdate, $type)
        {
            //global $viewall_forums;

	        $extra_criteria = '';
            $approve_criteria = ' AND t.approved = 1'; // any others?
            $post_time = ' p.post_time > ' . $startdate;
            switch ($type) {
                case 'digest':
                    //$post_time = ' p.post_time > ' . $startdate;
                    $extra_criteria = ' AND topic_digest = 1';
                    break;
                case 'unreplied':
                    //$post_time = ' p.post_time > ' . $startdate;
                    $extra_criteria = ' AND topic_replies < 1';
                    break;
	            case 'unread':
					$time_criterion = max($GLOBALS['last_visit'], $startdate);
	                $post_time = ' p.post_time > ' . $time_criterion;
	                $extra_criteria = '';
	        		$topics = array();
        			$topic_lastread = newbb_getcookie('LT', true);
	        		if(count($topic_lastread)>0) foreach($topic_lastread as $id=>$time){
		        		if($time > $time_criterion) $topics[] = $id;
			        }
			        if(count($topics)>0)
	                $extra_criteria = ' AND t.topic_id NOT IN ('.implode(",", $topics).')';
	                break;
	            case 'pending':
	        		$approve_criteria = ' AND t.approved = 0';
	                break;
	            case 'deleted':
	        		$approve_criteria = ' AND t.approved = -1';
	                break;
	            case 'all':
	                //$post_time = ' p.post_time > ' . $startdate;
	                //$extra_criteria = '';
	                break;
                default:
                    $post_time = ' (p.post_time > ' . $startdate . ' OR t.topic_sticky=1)';
                    $extra_criteria = '';
                    break;
            }
            if (is_object($forum)) $forum_criteria = ' AND t.forum_id = ' . $forum->getVar('forum_id');
            else {
	            if (is_array($forum) && count($forum) > 0){
	                $forum_criteria = ' AND t.forum_id IN (' . implode(',', array_keys($forum)) . ')';
	            }elseif(!empty($forum)){
	                $forum_criteria = ' AND t.forum_id ='.intval($forum);
	            }else{
	                $forum_criteria = '';
	            }
            }

            $sql = 'SELECT COUNT(*) as count FROM ' . $this->db->prefix("bb_topics") . ' t LEFT JOIN ' . $this->db->prefix('bb_posts') . ' p ON p.post_id = t.topic_last_post_id WHERE ';
            $sql .= $post_time . $forum_criteria . $extra_criteria . $approve_criteria;
            if (!$result = $this->db->query($sql)) {
                redirect_header('index.php', 2, "<br />NewbbForumHandler::getTopicCount "._MD_ERROROCCURED."<br />".$sql);
                exit();
            }
            $myrow = $this->db->fetchArray($result);
            $count = $myrow['count'];

            return $count;
        }

	    // get permission
        function getPermission($forum, $type = "access", $checkCategory = true)
        {
            global $xoopsUser, $xoopsModule;
            static $_cachedPerms;

            if($type == "all") return true;
            if (newbb_isAdministrator()) return true;
            if (is_int($forum)) $forum = $this->get($forum);
            if ($forum->getVar('forum_type')) return false;// if forum inactive, all has no access except admin

			if(!empty($checkCategory)){
	            $category_handler =& xoops_getmodulehandler('category', 'newbb');
	            $categoryPerm = $category_handler->getPermission($forum->getVar('cat_id'));
	        	if (!$categoryPerm) return false;
	    	}

            $type = strtolower($type);
            if ("moderate" == $type) {
                $permission = (newbb_isModerator($forum))?1:0;
            } else {
				$perms = array_map("trim",explode(',', FORUM_PERM_ITEMS));
               	$perm_type = 'forum';
                $perm_item = (in_array($type, $perms))?'forum_' . $type:"forum_access";
    			if (!isset($_cachedPerms[$perm_type])) {
					$getpermission = &xoops_getmodulehandler('permission', 'newbb');
					$_cachedPerms[$perm_type] = $getpermission->getPermissions($perm_type);
    			}
            	$permission = (isset($_cachedPerms[$perm_type][$forum->getVar('forum_id')][$perm_item])) ? 1 : 0;
            }
            return $permission;
        }
        
        function deletePermission(&$forum)
        {
			$perm_handler =& xoops_getmodulehandler('permission', 'newbb');
			return $perm_handler->deleteByForum($forum->getVar("forum_id"));
		}
        
        function applyPermissionTemplate(&$forum)
        {
			$perm_handler =& xoops_getmodulehandler('permission', 'newbb');
			return $perm_handler->applyTemplate($forum->getVar("forum_id"));
		}        
    }

?>