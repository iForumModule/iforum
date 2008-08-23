<?php
// $Id: moderate.php,v 1.1.1.1 2005/10/19 16:23:33 phppp Exp $
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
include_once XOOPS_ROOT_PATH.'/modules/newbb/include/functions.ini.php';
newbb_load_object();

/**
 * A handler for User moderation management
 * 
 * @package     newbb/cbb
 * 
 * @author	    D.J. (phppp, http://xoopsforge.com)
 * @copyright	copyright (c) 2005 XOOPS.org
 */

class Moderate extends ArtObject {
    var $db;
    var $table;

    function Moderate()
    {
        $this->db = &Database::getInstance();
        $this->table = $this->db->prefix("bb_moderates");
        $this->initVar('mod_id', XOBJ_DTYPE_INT);
        $this->initVar('mod_start', XOBJ_DTYPE_INT);
        $this->initVar('mod_end', XOBJ_DTYPE_INT);
        $this->initVar('mod_desc', XOBJ_DTYPE_TXTBOX);
        $this->initVar('uid', XOBJ_DTYPE_INT);
        $this->initVar('ip', XOBJ_DTYPE_TXTBOX);
        $this->initVar('forum_id', XOBJ_DTYPE_INT);
    }
}

class NewbbModerateHandler extends ArtObjectHandler
{
    function NewbbModerateHandler(&$db) {
        $this->ArtObjectHandler($db, 'bb_moderates', 'Moderate', 'mod_id', 'uid');
    }

    /**
     * Clear garbage
     * 
     * Delete all moderation information that has expired
     * 
     * @param	int $expire Expiration time in UNIX, 0 for time()
     */
    function clearGarbage($expire=0){
	    $expire = empty($expire)?time():intval($expire);
		$sql = sprintf("DELETE FROM %s WHERE mod_end < %u", $this->db->prefix('bb_moderates'), $expire);
        $this->db->queryF($sql);
    }
    
    /**
     * Check if a user is moderated, according to his uid and ip
     * 
     * 
     * @param	int 	$uid user id
     * @param	string 	$ip user ip
     */
    function verifyUser($uid=-1, $ip="", $forum = 0){	    
		if(!empty($GLOBALS["xoopsModuleConfig"]['cache_enabled'])){
			$forums = $this->forumList($uid, $ip);
			return in_array($forum, $forums);
		}
	    $uid = ($uid<0)?(is_object($GLOBALS["xoopsUser"])?$GLOBALS["xoopsUser"]->getVar("uid"):0):$uid;
	    $uid_criteria = empty($uid)?"1=1":"uid=".intval($uid);
	    $ip = empty($ip)?newbb_getIP(true):$ip;
	    if(!empty($ip)){
		    $ip_segs = explode(".", $ip);
		    for($i=1; $i<=4; $i++){
			    $ips[] = $this->db->quoteString(implode(".", array_slice($ip_segs, 0, $i)));
		    }
	    	$ip_criteria = "ip IN(".implode(",", $ips).")";
	    }else{
	    	$ip_criteria = "1=1";
    	}
	    $forum_criteria = empty($forum)?"forum_id=0":"forum_id=0 OR forum_id=".intval($forum);
	    $expire_criteria = "mod_end > ".time();
		$sql = sprintf("SELECT COUNT(*) AS count FROM %s WHERE (%s OR %s) AND (%s) AND (%s)", $this->db->prefix('bb_moderates'), $uid_criteria, $ip_criteria, $forum_criteria, $expire_criteria);
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $row = $this->db->fetchArray($result);
		return $row["count"];
    }
    
    /**
     * Get a forum list that a user is suspended, according to his uid and ip
     * Store the list into session if module cache is enabled
     * 
     * 
     * @param	int 	$uid user id
     * @param	string 	$ip user ip
     */
    function forumList($uid=-1, $ip=""){
	    static $forums = array();
	    $uid = ($uid<0)?(is_object($GLOBALS["xoopsUser"])?$GLOBALS["xoopsUser"]->getVar("uid"):0):$uid;
	    $ip = empty($ip)?newbb_getIP(true):$ip;
	    if(isset($forums[$uid][$ip])){
		    return $forums[$uid][$ip];
	    }
		if(!empty($GLOBALS["xoopsModuleConfig"]['cache_enabled'])){
			$forums[$uid][$ip] = newbb_getsession("sf".$uid."_".ip2long($ip), true);
			if(is_array($forums[$uid][$ip]) && count($forums[$uid][$ip])){
		    	return $forums[$uid][$ip];
			}
		}
	    $uid_criteria = empty($uid)?"1=1":"uid=".intval($uid);
	    if(!empty($ip)){
		    $ip_segs = explode(".", $ip);
		    for($i=1; $i<=4; $i++){
			    $ips[] = $this->db->quoteString(implode(".", array_slice($ip_segs, 0, $i)));
		    }
	    	$ip_criteria = "ip IN(".implode(",", $ips).")";
	    }else{
	    	$ip_criteria = "1=1";
    	}
	    $expire_criteria = "mod_end > ".time();
		$sql = sprintf("SELECT forum_id, COUNT(*) AS count FROM %s WHERE (%s OR %s) AND (%s) GROUP BY forum_id", $this->db->prefix('bb_moderates'), $uid_criteria, $ip_criteria, $expire_criteria);
        if (!$result = $this->db->query($sql)) {
            return $forums[$uid][$ip] = array();
        }
        $_forums = array();
        while($row = $this->db->fetchArray($result)){
	        if($row["count"]>0){
	        	$_forums[$row["forum_id"]] = 1; 
        	}
        }
        $forums[$uid][$ip] = count($_forums)?array_keys($_forums):array(-1);
		if(!empty($GLOBALS["xoopsModuleConfig"]['cache_enabled'])){
			newbb_setsession("sf".$uid."_".ip2long($ip), $forums[$uid][$ip]);
		}
        
		return $forums[$uid][$ip];
    }
    
    /**
     * Get latest expiration for a user moderation
     * 
     * 
     * @param	mix 	$item	user id or ip
     */
    function getLatest($item, $isUid = true){
	    if($isUid){
	    	$criteria = "uid =".intval($item);
	    }else{
		    $ip_segs = explode(".",$item);
		    $segs = min(count($ip_segs), 4);
		    for($i=1; $i<=$segs; $i++){
			    $ips[] = $this->db->quoteString(implode(".", array_slice($ip_segs, 0, $i)));
		    }
	    	$criteria = "ip IN(".implode(",", $ips).")";
	    }
		$sql = "SELECT MAX(mod_end) AS expire FROM ".$this->db->prefix('bb_moderates')." WHERE ".$criteria;
        if (!$result = $this->db->query($sql)) {
            return -1;
        }
        $row = $this->db->fetchArray($result);
        return $row["expire"];
    }
}
?>