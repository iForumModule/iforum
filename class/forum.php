<?php
// $Id: forum.php,v 1.1.4.4 2005/01/14 18:06:53 phppp Exp $
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
class Forum extends XoopsObject {
    var $db;
    var $table;
    var $groups_forum_access;
    var $groups_forum_can_post;
    var $groups_forum_can_view;
    var $groups_forum_can_reply;
    var $groups_forum_can_edit;
    var $groups_forum_can_delete;
    var $groups_forum_can_addpoll;
    var $groups_forum_can_attach;
    var $groups_forum_can_noapprove;

    function Forum()
    {
        $this->db = &Database::getInstance();
        $this->table = $this->db->prefix("bb_forums");
        $this->initVar('forum_id', XOBJ_DTYPE_INT);
        $this->initVar('forum_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('forum_desc', XOBJ_DTYPE_TXTAREA);
        $this->initVar('forum_moderator', XOBJ_DTYPE_TXTBOX);
        $this->initVar('forum_topics', XOBJ_DTYPE_INT);
        $this->initVar('forum_posts', XOBJ_DTYPE_INT);
        $this->initVar('forum_last_post_id', XOBJ_DTYPE_INT);
        $this->initVar('cat_id', XOBJ_DTYPE_INT);
        $this->initVar('forum_type', XOBJ_DTYPE_INT);
        $this->initVar('parent_forum', XOBJ_DTYPE_INT);
        $this->initVar('allow_html', XOBJ_DTYPE_INT);
        $this->initVar('allow_sig', XOBJ_DTYPE_INT);
        $this->initVar('allow_subject_prefix', XOBJ_DTYPE_INT);
        $this->initVar('hot_threshold', XOBJ_DTYPE_INT);
        $this->initVar('allow_polls', XOBJ_DTYPE_INT);
        $this->initVar('allow_attachments', XOBJ_DTYPE_INT);
        $this->initVar('attach_maxkb', XOBJ_DTYPE_INT);
        $this->initVar('attach_ext', XOBJ_DTYPE_TXTAREA);
        $this->initVar('forum_order', XOBJ_DTYPE_INT);
    }

    function updateModerators($modertators)
    {
        $sql = "UPDATE " . $this->db->prefix('bb_forums') . " SET forum_moderator=" . $this->db->quoteString($modertators) . " WHERE forum_id=" . $this->getVar('forum_id');
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

        $moderators = array();
        $forum_moderators = trim($this->getVar('forum_moderator'));
        $forum_moderators = explode(' ', $forum_moderators);
        foreach ($forum_moderators as $key => $moderatorid) {
            if ($moderatorid > 0) $moderators[$moderatorid] = 1;
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
	        $moderators_new = &$member_handler->getUserList(new Criteria('uid', $moderators_new, 'IN'), true);
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
        global $xoopsConfig, $xoopsModule, $xoopsTpl, $myts;

        $sql = 'SELECT f.*, u.uname, u.name, u.uid, p.topic_id, p.post_time, p.poster_name, p.subject, p.icon FROM ' . $this->db->prefix('bb_forums') . ' f LEFT JOIN ' . $this->db->prefix('bb_posts') . ' p ON p.post_id = f.forum_last_post_id LEFT JOIN ' . $this->db->prefix('users') . ' u ON u.uid = p.uid';

        $sql .= ' WHERE f.parent_forum = ' . $this->getVar('forum_id') . ' ORDER BY f.forum_order';
        //$xoopsTpl->assign('forum_index_title', sprintf(_MD_FORUMINDEX, $xoopsConfig['sitename']));

        if (!$result = $this->db->query($sql)) {
            //echo "<br />Forum::getSubForums error::" . $sql;
            return false;
        }

        $forums = array(); // RMV-FIX
        $ret = array();
        $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
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
                array('forum_moderators' => $this->disp_forumModerators(trim($forum_data['forum_moderator']))
                    ),
                array('forum_permission' => $forum_handler->getPermission($this)
                    )
                );
            $ret[] = $forums;
        }
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

        $disp_array['forum_lastpost_time'] = formatTimestamp($forum_data['post_time']);

        $last_post_icon = '<a href="' . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/viewtopic.php?post_id=' . $forum_data['forum_last_post_id'] . '&amp;topic_id=' . $forum_data['topic_id'] . '#forumpost' . $forum_data['forum_last_post_id'] . '">';
        if ($forum_data['icon']) {
            $last_post_icon .= '<img src="' . XOOPS_URL . '/images/subject/' . $forum_data['icon'] . '" alt="" />';
        } else {
            $last_post_icon .= '<img src="' . XOOPS_URL . '/images/subject/icon1.gif" alt="" />';
        }
        $last_post_icon .= '</a>';
        $disp_array['forum_lastpost_icon'] = $last_post_icon;

        if ($forum_data['uid'] != 0 && $forum_data['uname']) {
            if ($xoopsModuleConfig['show_realname'] && $forum_data['name']) {
                $forum_lastpost_user = '' . _MD_BY . '&nbsp;<a href="' . XOOPS_URL . '/userinfo.php?uid=' . $forum_data['uid'] . '">' . $myts->htmlSpecialChars(@$forum_data['name']) . '</a>';
            } else {
                $forum_lastpost_user = '' . _MD_BY . '&nbsp;<a href="' . XOOPS_URL . '/userinfo.php?uid=' . $forum_data['uid'] . '">' . $myts->htmlSpecialChars($forum_data['uname']) . '</a>';
            }
        } else {
            $forum_lastpost_user = !empty($forum_data['poster_name'])?$myts->htmlSpecialChars($forum_data['poster_name']):$xoopsConfig['anonymous'];
        }
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
            $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
            $valid_moderators = $this->getModerators(true);
        } elseif (empty($valid_moderators)) {
            return $ret;
        } elseif (!is_array($valid_moderators)) {
            $moderators = array();
            $criteira = "(" . implode(',', explode(' ', $valid_moderators)) . ")";
            $member_handler = &xoops_gethandler('member');
            $valid_moderators = &$member_handler->getUserList(new Criteria('uid', $criteira, 'IN'), true);
        }

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
    }
}

class NewbbForumHandler extends XoopsObjectHandler
{

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
	            //echo "<br />NewbbForumHandler::get error::" . $sql;
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
            //echo "<br />NewbbForumHandler::cleanVars error";
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
            //echo "<br />NewbbForumHandler::insert error::" . $sql;
            return false;
        }

        if (!($forum->getVar('forum_id'))) $forum->setVar('forum_id', $this->db->getInsertId());
        $perm = &xoops_getmodulehandler('permission', 'newbb');
        $perm->saveCategory_Permissions($forum->groups_forum_access, $forum->getVar('forum_id'), 'global_forum_access');
        $perm->saveCategory_Permissions($forum->groups_forum_can_post, $forum->getVar('forum_id'), 'forum_can_post');
        $perm->saveCategory_Permissions($forum->groups_forum_can_view, $forum->getVar('forum_id'), 'forum_can_view');
        $perm->saveCategory_Permissions($forum->groups_forum_can_reply, $forum->getVar('forum_id'), 'forum_can_reply');
        $perm->saveCategory_Permissions($forum->groups_forum_can_edit, $forum->getVar('forum_id'), 'forum_can_edit');
        $perm->saveCategory_Permissions($forum->groups_forum_can_delete, $forum->getVar('forum_id'), 'forum_can_delete');
        $perm->saveCategory_Permissions($forum->groups_forum_can_addpoll, $forum->getVar('forum_id'), 'forum_can_addpoll');
        $perm->saveCategory_Permissions($forum->groups_forum_can_vote, $forum->getVar('forum_id'), 'forum_can_vote');
        $perm->saveCategory_Permissions($forum->groups_forum_can_attach, $forum->getVar('forum_id'), 'forum_can_attach');
        $perm->saveCategory_Permissions($forum->groups_forum_can_noapprove, $forum->getVar('forum_id'), 'forum_can_noapprove');

        return true;
    }

    function delete(&$forum)
    {
        global $xoopsModule;
        $sql = "SELECT post_id FROM " . $this->db->prefix("bb_posts") . " WHERE forum_id = " . $forum->getVar('forum_id');
        if (!$r = $this->db->query($sql)) {
            //echo "<br />NewbbForumHandler::delete error::" . $sql;
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
	            //echo "<br />NewbbForumHandler::delete error::" . $sql;
	            return false;
	        }
            $sql = sprintf("DELETE FROM %s WHERE forum_id = %u", $this->db->prefix("bb_posts"), $_POST['forum_id']);
            if (!$r = $this->db->query($sql)) {
	            //echo "<br />NewbbForumHandler::delete error::" . $sql;
	            return false;
	        }
        }
        // RMV-NOTIFY
        xoops_notification_deletebyitem ($xoopsModule->getVar('mid'), 'forum', $_POST['forum_id']);
        // Get list of all topics in forum, to delete them too
        $sql = sprintf("SELECT topic_id FROM %s WHERE forum_id = %u", $this->db->prefix("bb_topics"), $_POST['forum_id']);
        if ($r = $this->db->query($sql)) {
            while ($row = $this->db->fetchArray($r)) {
                xoops_notification_deletebyitem ($xoopsModule->getVar('mid'), 'thread', $row['topic_id']);
            }
        }
        $sql = sprintf("DELETE FROM %s WHERE forum_id = %u", $this->db->prefix("bb_topics"), $_POST['forum_id']);
        if (!$r = $this->db->query($sql)) {
            return false;
        }
        $sql = "DELETE FROM " . $forum->table . " WHERE forum_id=" . $forum->getVar('forum_id') . "";
        if (!$this->db->query($sql)) {
            //echo "<br />NewbbForumHandler::delete error::" . $sql;
            return false;
        }
        // Delete group permissions
        $gperm_handler = &xoops_gethandler('groupperm');
        $gperm_names = "('forum_can_post', 'forum_can_view', 'forum_can_reply', 'forum_can_edit', 'forum_can_delete', 'forum_can_addpoll', 'forum_can_vote', 'forum_can_attach', 'global_forum_access')";

        $criteria = new CriteriaCompo(new Criteria('gperm_modid', intval($xoopsModule->getVar('mid'))));
        $criteria->add(new Criteria('gperm_name', $gperm_names, 'IN'));
        $criteria->add(new Criteria('gperm_itemid', intval($_POST['forum_id'])));
        return $gperm_handler->deleteAll($criteria);
    }

    function getForums($cat = 0, $permission = false)
    {
	    static $_cachedForums=array();
	    $perm_string = (empty($permission))?'all':$permission;
	    if(isset($_cachedForums[$cat][$perm_string])) return $_cachedForums[$cat][$perm_string];
        $sql = "SELECT * FROM " . $this->db->prefix('bb_forums');
        if ($cat != 0) {
            $sql .= " WHERE cat_id=" . intval($cat);
        }
        $sql .= " ORDER BY forum_order";
        if (!$result = $this->db->query($sql)){
            //echo "<br />NewbbForumHandler::getForums error::" . $sql;
            return false;
        }
        //$ret = array();
        $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
        while ($row = $this->db->fetchArray($result)) {
            $thisforum = $this->create(false);
            $thisforum->assignVars($row);
            if ($permission && !$this->getPermission($thisforum, $permission)) continue;
            $_cachedForums[$cat][$perm_string][$row['forum_id']] = $thisforum;
            unset($thisforum);
        }
        // TODO: Retrieve subforums
        return @$_cachedForums[$cat][$perm_string];
    }

    function getForumsByCat($cat = 0)
    {
        $sql = "SELECT * FROM " . $this->db->prefix('bb_forums');
        if ($cat != 0) {
            $sql .= " WHERE cat_id=" . intval($cat);
        }
        $sql .= " ORDER BY forum_order, forum_id=parent_forum";
        if (!$result = $this->db->query($sql)) {
            //echo "<br />NewbbForumHandler::getForumsByCat error::" . $sql;
            return false;
        }
        $ret = array();
        while ($row = $this->db->fetchArray($result)) {
            $thisforum = $this->create(false);
            $thisforum->assignVars($row);
            $ret[$row['cat_id']][$row['forum_id']] = $thisforum;
            unset($thisforum);
        }
        // TODO: Retrieve subforums
        return $ret;
    }

    // Get moderators of multi-forums
    function &getModerators($forums = 0, $asUname = false)
    {
        if ($forums == 0) $forums = $this->getForums();
        $moderators = array();
        if (is_array($forums)) {
            foreach ($forums as $forumid => $forum) {
                $moderators = array_merge($moderators, $forum->getModerators($asUname));
            }
        } elseif (is_object($forums)) {
            $moderators = &$forums->getModerators($asUname);
        }
        if (count($moderators) < 1) return array();
        return $moderators;
    }

    function getAllTopics($forum, $startdate, $start, $sortname, $sortorder, $type = '', $excerpt = 0)
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
            if (is_array($viewall_forums) && count($viewall_forums) > 0)
                $forum_criteria = ' AND t.forum_id IN (' . implode(',', array_keys($viewall_forums)) . ')';
            else
                $forum_criteria = '';
        }

        $sort_sticky = '';
        switch ($type) {
            case 'digest':
                $post_time = ' p.post_time > ' . $startdate;
                $extra_criteria = ' AND topic_digest = 1';
                break;
            case 'unreplied':
                $post_time = ' p.post_time > ' . $startdate;
                $extra_criteria = ' AND topic_replies < 1';
                break;
            case 'unread':
                $post_time = ' p.post_time > ' . $GLOBALS['last_visit'];
                $extra_criteria = '';
                break;
            case 'all': // For viewall.php; do not display sticky topics at first
                $post_time = ' p.post_time > ' . $startdate;
                $extra_criteria = '';
                break;
            default:
                $post_time = ' (p.post_time > ' . $startdate . ' OR t.topic_sticky=1)';
                $sort_sticky = ' t.topic_sticky DESC';
                $extra_criteria = '';
                break;
        }
        $sort = $sort_sticky;
        $sort_in = trim($sortname.' '.$sortorder);
        if($sort) {
	        if($sort_in) $sort .= ', '.$sort_in;
        }elseif($sort_in){
	        $sort = $sort_in;
        }

        if(!empty($sort)) $sort = ' ORDER BY '. $sort;
        $approve_criteria = ' AND t.approved = 1 AND p.approved = 1';
        if($excerpt==0){
        	$sql = 'SELECT t.*, u.name, u.uname,u2.name as last_post_name, u2.uname as last_poster, p.post_time as last_post_time, p.poster_name as last_poster_name, p.icon, p.post_id FROM ' . $this->db->prefix("bb_topics") . ' t LEFT JOIN ' . $this->db->prefix("users") . ' u ON u.uid = t.topic_poster LEFT JOIN ' . $this->db->prefix('bb_posts') . ' p ON p.post_id = t.topic_last_post_id LEFT JOIN ' . $this->db->prefix("users") . ' u2 ON  u2.uid = p.uid WHERE ';
    	}else{
        	$sql = 'SELECT t.*, u.name, u.uname,u2.name as last_post_name, u2.uname as last_poster, p.post_time as last_post_time, p.poster_name as last_poster_name, p.icon, p.post_id, p.post_karma, p.require_reply, pt.post_text FROM ' . $this->db->prefix("bb_topics") . ' t LEFT JOIN ' . $this->db->prefix("users") . ' u ON u.uid = t.topic_poster LEFT JOIN ' . $this->db->prefix('bb_posts') . ' p ON p.post_id = t.topic_last_post_id LEFT JOIN ' . $this->db->prefix('bb_posts_text') . ' pt ON pt.post_id = t.topic_last_post_id LEFT JOIN ' . $this->db->prefix("users") . ' u2 ON  u2.uid = p.uid WHERE ';
    	}
        $sql .= $post_time . $forum_criteria . $extra_criteria . $approve_criteria . $sort;

        if (!$result = $this->db->query($sql, $xoopsModuleConfig['topics_per_page'], $start)) {
            redirect_header('index.php', 2, _MD_ERROROCCURED . '<br />' . $sql);
            exit();
        }

        $sticky = 0;
        $topics = array();
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
            if ($myrow['icon'] && is_file(XOOPS_ROOT_PATH . '/images/subject/' . $myrow['icon'])) {
                $topic_icon = '<img src="' . XOOPS_URL . '/images/subject/' . $myrow['icon'] . '" alt="" />';
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
                $topic_icon = newbb_displayImage($forumImage['poll'], _MD_TOPICHASPOLL);
            }
            if ($myrow['topic_haspoll'] && $myrow['topic_sticky']) {
                $topic_icon = newbb_displayImage($forumImage['folder_sticky'], _MD_TOPICSTICKY) . '<br />' . newbb_displayImage($forumImage['poll'], _MD_TOPICHASPOLL);
                $stick = 0;
                $sticky++;
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
            if ($myrow['icon']) {
            	$last_post_icon = '<img src="' . XOOPS_URL . '/images/subject/' . $myrow['icon'] . '" alt="" />';
        	} else {
            	$last_post_icon = '<img src="' . XOOPS_URL . '/images/subject/icon1.gif" alt="" />';
        	}
            $topic_page_jump = '';
            $topic_page_jump_icon = '';
            $totalpages = ceil(($myrow['topic_replies'] + 1) / $xoopsModuleConfig['posts_per_page']);
            if ($totalpages > 1) {
                $topic_page_jump .= '&nbsp;&nbsp;&nbsp;<img src="' . XOOPS_URL . '/images/icons/posticon.gif" alt="" /> ';
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
            // ------------------------------------------------------
            // => topic array
            if (is_object($viewall_forums[$myrow['forum_id']]))
                $forum_link = '<a href="' . XOOPS_URL . '/modules/newbb/viewforum.php?forum=' . $myrow['forum_id'] . '">' . $myts->htmlSpecialChars($viewall_forums[$myrow['forum_id']]->getVar('forum_name')) . '</a>';
            else $forum_link = '';

            if (newbb_isAdmin($forum,$myrow['topic_poster']) && $xoopsModuleConfig['allow_moderator_html'])
                $topic_title = $myrow['topic_title'];
            else
                $topic_title = $myts->htmlSpecialChars($myrow['topic_title']);
            if ($myrow['topic_digest']) $topic_title = "<span class='digest'>" . $topic_title . "</span>";

            $subjectpres = explode(',', $xoopsModuleConfig['subject_prefix']);
            if (count($subjectpres) > 1) {
                foreach($subjectpres as $subjectpre) {
                    $subject_array[] = $subjectpre;
                }
            }

            if( $excerpt == 0 ){
	            $topic_excerpt = "";
            }elseif( ($myrow['post_karma']>0 || $myrow['require_reply']>0) && !newbb_isAdmin($forum) ){
	            $topic_excerpt = "";
            }else{
	            $topic_excerpt = xoops_substr(newbb_html2text($myrow['post_text']), 0, $excerpt);
            }

            $topics[$myrow['topic_id']] = array('topic_icon' => $topic_icon,
                'topic_folder' => newbb_displayImage($topic_folder),
                'topic_title' => $topic_title,
                'allow_prefix' => $allow_subject_prefix,
                'topic_subject' => $subject_array[$myrow['topic_subject']],
                'topic_link' => 'viewtopic.php?topic_id=' . $myrow['topic_id'] . '&amp;forum=' . $myrow['forum_id'],
                'rating_img' => $rating_img,
                'topic_page_jump' => $topic_page_jump,
                'topic_page_jump_icon' => $topic_page_jump_icon,
                'topic_replies' => $myrow['topic_replies'],
                'topic_poster' => $topic_poster,
                'topic_views' => $myrow['topic_views'],
                'topic_last_posttime' => formatTimestamp($myrow['last_post_time']),
                'topic_last_poster' => $topic_last_poster,
                'topic_forum_link' => $forum_link,
                'topic_excerpt' => $topic_excerpt,
                'stick' => $stick
                );
            }

            if (is_array($topics) && count($topics) > 0) {
                $result2 = $this->db->query("SELECT attachment,topic_id FROM " . $this->db->prefix("bb_posts") . " WHERE topic_id IN (" . implode(',', array_keys($topics)) . ")");
                if ($result2) {
                    while ($arr2 = $this->db->fetchArray($result2)) {
                        if ($arr2['attachment']) $topics[$arr2['topic_id']]['attachment'] = '&nbsp;' . newbb_displayImage($forumImage['clip'], _MD_TOPICSHASATT);
                        unset($arr2);
                    }
                }
            }
            return array($topics, $sticky);
        }

        function getTopicCount($forum, $startdate, $type)
        {
            global $viewall_forums;

            switch ($type) {
                case 'digest':
                    $post_time = ' p.post_time > ' . $startdate;
                    $extra_criteria = ' AND topic_digest = 1';
                    break;
                case 'unreplied':
                    $post_time = ' p.post_time > ' . $startdate;
                    $extra_criteria = ' AND topic_replies < 1';
                    break;
	            case 'all':
	                $post_time = ' p.post_time > ' . $startdate;
	                $extra_criteria = '';
	                break;
                default:
                    $post_time = ' (p.post_time > ' . $startdate . ' OR t.topic_sticky=1)';
                    $extra_criteria = '';
                    break;
            }
            if (is_object($forum)) $forum_criteria = ' AND t.forum_id = ' . $forum->getVar('forum_id');
            else {
                if (is_array($viewall_forums) && count($viewall_forums) > 0)
                    $forum_criteria = ' AND t.forum_id IN (' . implode(',', array_keys($viewall_forums)) . ')';
                else
                    $forum_criteria = '';
            }

            $approve_criteria = ' AND t.approved = 1'; // any others?

            $sql = 'SELECT COUNT(*) as count FROM ' . $this->db->prefix("bb_topics") . ' t LEFT JOIN ' . $this->db->prefix('bb_posts') . ' p ON p.post_id = t.topic_last_post_id WHERE ';
            $sql .= $post_time . $forum_criteria . $extra_criteria . $approve_criteria;
            if (!$result = $this->db->query($sql)) {
                redirect_header('index.php', 2, "<br />NewbbForumHandler::getTopicCount "._MD_ERROROCCURED."<br />".$sql);
                exit();
            }
            $myrow = $this->db->fetchArray($result);
            return $myrow['count'];
        }

	    // get permission
	    // parameter: $type: 'moderate', 'access', 'post', 'addpoll'
	    // $gperm_names = "'global_forum_access', 'forum_can_post', 'forum_can_addpoll'";
        function getPermission($forum, $type = "access")
        {
            global $xoopsUser, $xoopsModule;
            static $_cachedPerms;

            if (newbb_isAdministrator()) return true;
            if (is_int($forum)) $forum = $this->get($forum);
            if ($forum->getVar('forum_type')) return false;// if forum inactive, all has no access except admin


            $category_handler = &xoops_getmodulehandler('category', 'newbb');
            $categoryPerm = &$category_handler->getPermission($forum->getVar('cat_id'));
        	if (!$categoryPerm) return false;

            $type = strtolower($type);
            if ("moderate" == $type) {
                $permission = (newbb_isModerator($forum))?1:0;
            } else {
                 if(in_array($type, array('post', 'addpoll'))) {
	               	$perm_type = 'topic';
	                $perm_item = 'forum_can_' . $type;
                }
                else {
	               	$perm_type = 'forum';
	                $perm_item = 'global_forum_access';
                }
	    			if (!isset($_cachedPerms[$perm_type])) {
						$getpermission = &xoops_getmodulehandler('permission', 'newbb');
						$_cachedPerms[$perm_type] = $getpermission->getPermissions($perm_type);
	    			}
                	$permission = (isset($_cachedPerms[$perm_type][$forum->getVar('forum_id')][$perm_item])) ? 1 : 0;
            }
            return $permission;
        }
    }

?>