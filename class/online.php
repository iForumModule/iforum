<?php
// $Id: online.php,v 1.1.2.14 2004/11/16 22:17:10 praedator Exp $
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                      //
// Copyright (c) 2000 XOOPS.org                           //
// <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
class NewbbOnlineHandler 
{
    var $db;
    var $forum;
    var $forum_object;
    var $forumtopic;

    function init($forum = 0, $forumtopic = 0)
    {
        $this->db = &Database::getInstance();
        if (is_object($forum)) {
            $this->forum = $forum->getVar('forum_id');
            $this->forum_object = &$forum;
        } else {
            $this->forum = $forum;
            $this->forum_object = $forum;
        }
        if (is_object($forumtopic)) {
            $this->forumtopic = $forumtopic->getVar('topic_id');
            if(empty($this->forum))  $this->forum = $forumtopic->getVar('forum_id');
        } else {
            $this->forumtopic = $forumtopic;
        }

        $this->update();
    }

    function update()
    {
        global $xoopsUser, $_SERVER;
        mt_srand((double)microtime() * 1000000);
        // set gc probabillity to 10% for now..
        if (mt_rand(1, 100) < 11) {
            $this->gc(300);
        }
        if (is_object($xoopsUser)) {
            $uid = $xoopsUser->getVar('uid');
            $uname = $xoopsUser->getVar('uname');
        } else {
            $uid = 0;
            $uname = '';
        }
        $this->write($uid, $uname, time(), $this->forum, $_SERVER['REMOTE_ADDR'], $this->forumtopic);
    }
    
    function &show_online()
    {
        global $xoopsModuleConfig, $forumImage;

        if ($this->forumtopic)
            $num_total = $this->getCount(new Criteria('online_topic', $this->forumtopic));
        elseif ($this->forum)
            $num_total = $this->getCount(new Criteria('online_forum', $this->forum));
        else
            $num_total = $this->getCount();

        if ($this->forumtopic) {
            $criteria = new CriteriaCompo(new Criteria('online_topic', $this->forumtopic));
            $criteria->add(new Criteria('online_uid', '0', '<>'));
        } elseif ($this->forum) {
            $criteria = new CriteriaCompo(new Criteria('online_forum', $this->forum));
            $criteria->add(new Criteria('online_uid', '0', '<>'));
        } else {
            $criteria = new Criteria('online_uid', '0', '<>');
        }
        $users = &$this->getAll($criteria);
        $num_user = count($users);
        $num_anonymous = $num_total - $num_user;

        $online = array();
        $online['image'] = newbb_displayImage($forumImage['whosonline']);
		$online['num_total'] = $num_total;
		$online['num_user'] = $num_user;
		$online['num_anonymous'] = $num_anonymous;

        for ($i = 0; $i < $num_user; $i++) {
            $online['users'][$i]['link']= XOOPS_URL . "/userinfo.php?uid=" . $users[$i]['online_uid'];
            $online['users'][$i]['uname']= $users[$i]['online_uname'];
            if(newbb_isAdministrator($users[$i]['online_uid'])){
                $online['users'][$i]['color']= $xoopsModuleConfig['wol_admin_col'];
            }
            elseif(newbb_isModerator($this->forum_object, $users[$i]['online_uid'])){
                $online['users'][$i]['color']= $xoopsModuleConfig['wol_mod_col'];
            }
            else{
                $online['users'][$i]['color']= "";
            }
        }

        return $online;
    }
    
    /**
     * Write online information to the database
     *
     * @param int $uid UID of the active user
     * @param string $uname Username
     * @param string $timestamp
     * @param string $forum Current forum
     * @param string $ip User's IP adress
     * @return bool TRUE on success
     */
    function write($uid, $uname, $time, $forum, $ip, $forumtopic)
    {
    	$uid = intval($uid);
        if ($uid > 0) {
            $sql = "SELECT COUNT(*) FROM " . $this->db->prefix('bb_online') . " WHERE online_uid=" . $uid;
        } else {
            $sql = "SELECT COUNT(*) FROM " . $this->db->prefix('bb_online') . " WHERE online_uid=" . $uid . " AND online_ip='" . $ip . "'";
        }
        list($count) = $this->db->fetchRow($this->db->queryF($sql));
        if ($count > 0) {
            $sql = "UPDATE " . $this->db->prefix('bb_online') . " SET online_updated= '" . $time . "', online_forum = '" . $forum . "', online_topic = '" . $forumtopic . "' WHERE online_uid = " . $uid;
            if ($uid == 0) {
                $sql .= " AND online_ip='" . $ip . "'";
            }
        } else {
            $sql = sprintf("INSERT INTO %s (online_uid, online_uname, online_updated, online_ip, online_forum, online_topic) VALUES (%u, %s, %u, %s, %u, %u)", $this->db->prefix('bb_online'), $uid, $this->db->quoteString($uname), $time, $this->db->quoteString($ip), $forum, $forumtopic);
        }
        if (!$this->db->queryF($sql)) {
            return false;
        }
        return true;
    }

    /**
     * Garbage Collection
     *
     * Delete all online information that has not been updated for a certain time
     *
     * @param int $expire Expiration time in seconds
     */
    function gc($expire)
    {
        $sql = sprintf("DELETE FROM %s WHERE online_updated < %u", $this->db->prefix('bb_online'), time() - intval($expire));
        $this->db->queryF($sql);
    }

    /**
     * Get an array of online information
     *
     * @param object $criteria {@link CriteriaElement}
     * @return array Array of associative arrays of online information
     */
    function &getAll($criteria = null)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM ' . $this->db->prefix('bb_online');
        if (is_object($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = &$this->db->query($sql, $limit, $start);
        if (!$result) {
            return false;
        } while ($myrow = $this->db->fetchArray($result)) {
            $ret[] = &$myrow;
            unset($myrow);
        }
        return $ret;
    }

    /**
     * Count the number of online users
     *
     * @param object $criteria {@link CriteriaElement}
     */
    function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('bb_online');
        if (is_object($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = &$this->db->query($sql)) {
            return false;
        }
        list($ret) = $this->db->fetchRow($result);
        return $ret;
    }
}

?>