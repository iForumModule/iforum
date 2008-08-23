<?php
// $Id: online.php,v 1.4 2005/04/18 01:22:28 phppp Exp $
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
        global $xoopsUser, $xoopsModuleConfig, $xoopsModule;

        mt_srand((double)microtime() * 1000000);
        // set gc probabillity to 10% for now..
        if (mt_rand(1, 100) < 11) {
            $this->gc(300);
        }
        if (is_object($xoopsUser)) {
            $uid = $xoopsUser->getVar('uid');
            $uname = $xoopsUser->getVar('uname');
            $name = $xoopsUser->getVar('name');
        } else {
            $uid = 0;
            $uname = '';
            $name = '';
        }

        $xoops_online_handler =& xoops_gethandler('online');
		$xoopsupdate=$xoops_online_handler->write($uid, $uname, time(), $xoopsModule->getVar('mid'), $_SERVER['REMOTE_ADDR']);
		if(!$xoopsupdate){
			//echo "<br />xoops upate error";
		}

		$uname = (empty($xoopsModuleConfig['show_realname'])||empty($name))?$uname:$name;
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
	    global $xoopsModule;

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
	        //echo "<br />can not update:".$sql;
            return false;
        }

		//$sql = "DELETE FROM ".$this->db->prefix('bb_online')." WHERE NOT EXISTS ( SELECT * FROM ".$this->db->prefix('online')." AS aa WHERE online_uid = aa.online_uid AND aa.online_module =".$xoopsModule->getVar('mid').")";

        //$sql = "DELETE FROM ".$this->db->prefix('bb_online')." AS bb LEFT JOIN ".$this->db->prefix('online')." AS aa ON bb.online_uid = aa.online_uid	WHERE aa.online_uid IS NULL";
        //$sql = "DELETE FROM ".$this->db->prefix('bb_online')." AS bb WHERE NOT EXISTS ( SELECT * FROM ".$this->db->prefix('online')." AS aa WHERE bb.online_uid = aa.online_uid AND aa.online_module =".$xoopsModule->getVar('mid').")";
        //$sql = "DELETE FROM ".$this->db->prefix('bb_online')." WHERE online_uid NOT IN ( SELECT DISTINCT online_uid FROM ".$this->db->prefix('online')." WHERE online_module =".$xoopsModule->getVar('mid').")";
        /* */
        $uids = array();
        $ips = array();
        $sql = 'SELECT online_uid, online_ip FROM '.$this->db->prefix('online')." WHERE online_module = ".$xoopsModule->getVar('mid');
        $result = &$this->db->query($sql);
        if (!$result) {
	        //echo "<br />uid not exists in xoops online:".$sql;
        	$sql = "DELETE FROM ".$this->db->prefix('bb_online');
        	return true;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $uids[$myrow['online_uid']] = 1;
            if($myrow['online_uid'] == 0) $ips[] = $this->db->quoteString($myrow['online_ip']);
            unset($myrow);
        }
        $uid_string = implode(",",array_keys($uids));
        if(count($ips)>0){
        	$sql = "DELETE FROM ".$this->db->prefix('bb_online')." WHERE ( online_uid NOT IN (".$uid_string.") ) OR ( online_uid = 0 AND online_ip NOT IN (".implode(",", $ips).") )";
    	}
        else{
        	$sql = "DELETE FROM ".$this->db->prefix('bb_online')." WHERE ( online_uid NOT IN (".$uid_string.") )";
        }
		/* */

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
	    global $xoopsModule;
        $sql = sprintf("DELETE FROM ".$this->db->prefix('bb_online')." WHERE online_updated < ".time() - intval($expire));
        $this->db->queryF($sql);

        $xoops_online_handler =& xoops_gethandler('online');
		$xoops_online_handler->gc($expire);
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
        }
        while ($myrow = $this->db->fetchArray($result)) {
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