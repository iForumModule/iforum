<?php
// $Id: online.php,v 1.3 2005/10/19 17:20:32 phppp Exp $
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
	var $user_ids = array();
	
    function init($forum = null, $forumtopic = null)
    {
        $this->db = &Database::getInstance();
        if (is_object($forum)) {
            $this->forum = $forum->getVar('forum_id');
            $this->forum_object = &$forum;
        } else {
            $this->forum = intval($forum);
            $this->forum_object = $forum;
        }
        if (is_object($forumtopic)) {
            $this->forumtopic = $forumtopic->getVar('topic_id');
            if(empty($this->forum))  $this->forum = $forumtopic->getVar('forum_id');
        } else {
            $this->forumtopic = intval($forumtopic);
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
		$xoopsupdate = $xoops_online_handler->write($uid, $uname, time(), $xoopsModule->getVar('mid'), $_SERVER['REMOTE_ADDR']);
		if(!$xoopsupdate){
			newbb_message("newbb online upate error");
		}

		$uname = (empty($xoopsModuleConfig['show_realname'])||empty($name))?$uname:$name;
        $this->write($uid, $uname, time(), $this->forum, $_SERVER['REMOTE_ADDR'], $this->forumtopic);
    }

    function &show_online()
    {
        global $xoopsModuleConfig, $forumImage;

        if ($this->forumtopic) {
            //$criteria = new CriteriaCompo(new Criteria('online_topic', $this->forumtopic));
            //$criteria->add(new Criteria('online_uid', '0', '<>'));
	        $criteria = new Criteria('online_topic', $this->forumtopic);
        } elseif ($this->forum) {
            //$criteria = new CriteriaCompo(new Criteria('online_forum', $this->forum));
            //$criteria->add(new Criteria('online_uid', '0', '<>'));
	        $criteria = new Criteria('online_forum', $this->forum);
        } else {
            //$criteria = new Criteria('online_uid', '0', '<>');
	        $criteria = null;
        }
        //$num_total = $this->getCount($criteria_count);
        $users =& $this->getAll($criteria);
        $num_total = count($users);
        //$num_anonymous = $num_total - $num_user;

		$num_user = 0;
		$users_id = array();
		$users_online = array();
        for ($i = 0; $i < $num_total; $i++) {
	        if(empty($users[$i]['online_uid'])) continue;
	        $users_id[] = $users[$i]['online_uid'];
	        $users_online[$users[$i]['online_uid']] = array(
	        	"link" => XOOPS_URL . "/userinfo.php?uid=" . $users[$i]['online_uid'],
	        	"uname" => $users[$i]['online_uname'],
	        );
	        $num_user ++;
        }
        $num_anonymous = $num_total - $num_user;
        $online = array();
        $online['image'] = newbb_displayImage($forumImage['whosonline']);
		$online['num_total'] = $num_total;
		$online['num_user'] = $num_user;
		$online['num_anonymous'] = $num_anonymous;
        $administrator_list = newbb_isModuleAdministrators($users_id, $GLOBALS["xoopsModule"]->getVar("mid"));
        foreach ($users_online as $uid=>$user) {
            //$online['users'][$i]['link']= XOOPS_URL . "/userinfo.php?uid=" . $users[$i]['online_uid'];
            //$online['users'][$i]['uname']= $users[$i]['online_uname'];
            //if(newbb_isAdministrator($users[$i]['online_uid'])){
            if(!empty($administrator_list[$uid])){
                $user['level']= 2;
            }
            elseif(newbb_isModerator($this->forum_object, $uid)){
                $user['level']= 1;
            }
            else{
                $user['level']= 0;
            }
            $online["users"][] = $user;
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
	        newbb_message("can not update online info: ".$sql);
            return false;
        }
        
    	$mysql_version = substr(trim(mysql_get_server_info()), 0, 3);
    	/* for MySQL 4.1+ */
    	if($mysql_version >= "4.1"):

		$sql = 	"DELETE FROM ".$this->db->prefix('bb_online').
				" WHERE".
				" ( online_uid > 0 AND online_uid NOT IN ( SELECT online_uid FROM ".$this->db->prefix('online')." WHERE online_module =".$xoopsModule->getVar('mid')." ) )".
				" OR ( online_uid = 0 AND online_ip NOT IN ( SELECT online_ip FROM ".$this->db->prefix('online')." WHERE online_module =".$xoopsModule->getVar('mid')." AND online_uid = 0 ) )";
        
		if($result = $this->db->queryF($sql)){
	        return true;
        }else{
	        newbb_message("clean xoops online error: ".$sql);
	        return false;
        }

        
        else: 
        $sql = 	"DELETE ".$this->db->prefix('bb_online')." FROM ".$this->db->prefix('bb_online')." AS bb".
        		" LEFT JOIN ".$this->db->prefix('online')." AS aa ".
        		" ON bb.online_uid = aa.online_uid WHERE bb.online_uid > 1 AND aa.online_uid IS NULL";
        $result = $this->db->queryF($sql);
        $sql = 	"DELETE ".$this->db->prefix('bb_online')." FROM ".$this->db->prefix('bb_online')." AS bb".
        		" LEFT JOIN ".$this->db->prefix('online')." AS aa ".
        		" ON bb.online_ip = aa.online_ip WHERE bb.online_uid = 0 AND aa.online_ip IS NULL";
        $result = $this->db->queryF($sql);
        return true;
        /*
        $uids = array();
        $ips = array();
        $sql = 'SELECT online_uid, online_ip FROM '.$this->db->prefix('online')." WHERE online_module = ".$xoopsModule->getVar('mid');
        $result = $this->db->query($sql);
        if (!$result) {
	        //newbb_message("uid not exists in xoops online: ".$sql);
        	$sql = "TRUNCATE ".$this->db->prefix('bb_online');
        	$this->db->queryF($sql);
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

        if (!$this->db->queryF($sql)) {
            return false;
        }
        return true;
        */
        endif;
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
        $sql = "DELETE FROM ".$this->db->prefix('bb_online')." WHERE online_updated < ".(time() - intval($expire));
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
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return false;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $ret[] = &$myrow;
            if($myrow["online_uid"]>0){
            	$this->user_ids[] = $myrow["online_uid"];
        	}
            unset($myrow);
        }
        $this->user_ids = array_unique($this->user_ids);
        return $ret;
    }

    function checkStatus($uids)
    {
	    $online_users = array();
        $ret = array();
        if(!empty($this->user_ids)) {
	        $online_users =& $this->user_ids;
        }
        else{
        	$sql = 'SELECT online_uid FROM ' . $this->db->prefix('bb_online');
        	if(!empty($uids)) {
        		$sql .= ' WHERE online_uid IN ('.implode(", ",array_map("intval", $uids)).')';
    		}
        			
	        $result = $this->db->query($sql);
	        if (!$result) {
	            return false;
	        }
	        while (list($uid) = $this->db->fetchRow($result)) {
		        $online_users[] = $uid;
	        }
        }
        foreach($uids as $uid){
	        if(in_array($uid, $online_users)){
		        $ret[$uid] = 1;
	        }
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
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        list($ret) = $this->db->fetchRow($result);
        return $ret;
    }
}

?>