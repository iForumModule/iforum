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
//  Author: phppp (D.J., infomax@gmail.com)                                  //
//  URL: http://xoopsforge.com, http://xoops.org.cn                          //
//  Project: Article Project                                                 //
//  ------------------------------------------------------------------------ //
 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

include_once XOOPS_ROOT_PATH.'/modules/newbb/include/functions.ini.php';
newbb_load_object();

/**
 * A handler for read/unread handling
 * 
 * @package     newbb/cbb
 * 
 * @author	    D.J. (phppp, http://xoopsforge.com)
 * @copyright	copyright (c) 2005 XOOPS.org
 */

class Read extends ArtObject 
{
    var $table;

    function Read($type)
    {
        $this->ArtObject();
        $this->table = $GLOBALS["xoopsDB"]->prefix("bb_reads_".$type);
        $this->initVar('read_id', XOBJ_DTYPE_INT);
        $this->initVar('uid', XOBJ_DTYPE_INT);
        $this->initVar('read_item', XOBJ_DTYPE_INT);
        $this->initVar('post_id', XOBJ_DTYPE_INT);
        $this->initVar('read_time', XOBJ_DTYPE_INT);
    }
}

class NewbbReadHandler extends ArtObjectHandler
{
    /**
     * Object type.
     * <ul>
     *  <li>forum</li>
     *  <li>topic</li>
     * </ul>
     *
     * @var string
     */
	var $type;
	
    /**
     * seconds records will persist.
     * assigned from $xoopsModuleConfig["read_expire"]
     * <ul>
     *  <li>0 = never records</li>
     *  <li>-1 = never expires</li>
     * </ul>
     *
     * @var integer
     */
	var $lifetime;
	
    /**
     * storage mode for records.
     * assigned from $xoopsModuleConfig["read_mode"]
     * <ul>
     *  <li>0 = never records</li>
     *  <li>1 = uses cookie</li>
     *  <li>2 = stores in database</li>
     * </ul>
     *
     * @var integer
     */
	var $mode;
	
    function NewbbReadHandler(&$db, $type) {
	    $type = ("forum" == $type)?"forum":"topic";
        $this->ArtObjectHandler($db, 'bb_reads_'.$type, 'Read'.$type, 'read_id', 'post_id');
        $this->type = $type;
	    $newbbConfig = newbb_load_config();
        $this->lifetime = isset($newbbConfig["read_expire"])?$newbbConfig["read_expire"] *24*3600 : 30*24*3600;
        $this->mode = isset($newbbConfig["read_mode"])?$newbbConfig["read_mode"]:2;
    }

    /**
     * Clear garbage
     * 
     * Delete all expired and duplicated records
     */
    function clearGarbage(){
	    $expire = time() - intval($this->lifetime);
		$sql = "DELETE FROM ".$this->table." WHERE read_time < ". $expire;
        $this->db->queryF($sql);
	    
    	/* for MySQL 4.1+ */
    	if($this->mysql_client_version() >= 4):
        $sql = 	"DELETE bb FROM ".$this->table." AS bb".
        		" LEFT JOIN ".$this->table." AS aa ON bb.read_item = aa.read_item ".
        		" WHERE aa.post_id > bb.post_id";
        else:
        // for 4.0+
        $sql = 	"DELETE ".$this->table." FROM ".$this->table.
        		" LEFT JOIN ".$this->table." AS aa ON ".$this->table.".read_item = aa.read_item ".
        		" WHERE aa.post_id > ".$this->table.".post_id";
		endif;
        if (!$result = $this->db->queryF($sql)) {
	        newbb_message("cleanOrphan:". $sql);
            return false;
        }
        return true;
    }

    function getRead($read_item, $uid = null)
    {
	    if(empty($this->mode)) return null;
	    if($this->mode == 1) return $this->getRead_cookie($read_item);
	    else return $this->getRead_db($read_item, $uid);
    }
        
    function getRead_cookie($item_id)
    {
	    $cookie_name = ($this->type == "forum")?"LF":"LT";
	    $cookie_var = $item_id;
		$lastview = newbb_getcookie($cookie_name);
		return @$lastview[$cookie_var];
    }
    
    function getRead_db($read_item, $uid)
    {
	    if(empty($uid)){
		    if(is_object($GLOBALS["xoopsUser"])){
			    $uid = $GLOBALS["xoopsUser"]->getVar("uid");
		    }else{
			    return false;
		    }
	    }
	    $sql = "SELECT post_id ".
	    		" FROM ".$this->table.
	    		" WHERE read_item = ".intval($read_item).
	    		" 	AND uid = ".intval($uid);
	    if(!$result = $this->db->queryF($sql, 1)){
		    return null;
	    }
	    list($post_id) = $this->db->fetchRow($result);
	    return $post_id;
    }
    
    function setRead($read_item, $post_id, $uid = null)
    {
	    if(empty($this->mode)) return true;
	    if($this->mode == 1) return $this->setRead_cookie($read_item, $post_id);
	    else return $this->setRead_db($read_item, $post_id, $uid);
    }
        
    function setRead_cookie($read_item, $post_id)
    {
	    $cookie_name = ($this->type == "forum")?"LF":"LT";
		$lastview = newbb_getcookie($cookie_name,true);
		$lastview[$read_item] = time();
		newbb_setcookie($cookie_name, $lastview);
    }
    
    function setRead_db($read_item, $post_id, $uid)
    {
	    if(empty($uid)){
		    if(is_object($GLOBALS["xoopsUser"])){
			    $uid = $GLOBALS["xoopsUser"]->getVar("uid");
		    }else{
			    return false;
		    }
	    }
	    
	    $sql = "UPDATE ".$this->table.
	    		" SET post_id = ".intval($post_id).",".
	    		" 	read_time =".time().
	    		" WHERE read_item = ".intval($read_item).
	    		" 	AND uid = ".intval($uid);
	    if($this->db->queryF($sql) && $this->db->getAffectedRows()){
		    return true;
	    }
	    $object =& $this->create();
	    $object->setVar("read_item", $read_item, true);
	    $object->setVar("post_id", $post_id, true);
	    $object->setVar("uid", $uid, true);
	    $object->setVar("read_time", time(), true);
	    return parent::insert($object);
    }
    
    function isRead_items(&$items, $uid = null)
    {
	    $ret = null;
	    if(empty($this->mode)) return $ret;
	    
	    if($this->mode == 1) $ret = $this->isRead_items_cookie($items);
	    else $ret = $this->isRead_items_db($items, $uid);
	    return $ret;
    }
        
    function isRead_items_cookie(&$items)
    {
	    $cookie_name = ($this->type == "forum")?"LF":"LT";
	    $cookie_vars = newbb_getcookie($cookie_name, true);
	    
	    $ret = array();
	    foreach($items as $key => $last_update){
            $ret[$key] = (max(@$GLOBALS['last_visit'], @$cookie_vars[$key]) >= $last_update);
	    }
	    return $ret;
    }
    
    function isRead_items_db(&$items, $uid)
    {
	    $ret = array();
	    if(empty($uid)){
		    if(is_object($GLOBALS["xoopsUser"])){
			    $uid = $GLOBALS["xoopsUser"]->getVar("uid");
		    }else{
			    return $ret;
		    }
	    }
	    
		$criteria = new CriteriaCompo(new Criteria("uid", $uid));
		$criteria->add(new Criteria("read_item", "(".implode(", ", array_map("intval", array_keys($items))).")", "IN"));
		$items_obj =& $this->getAll($criteria, array("read_item", "post_id"));
	    
		$items_list = array();
	    foreach(array_keys($items_obj) as $key){
            $items_list[$items_obj[$key]->getVar("read_item")] = $items_obj[$key]->getVar("post_id");
	    }
		unset($items_obj);
	    
	    foreach($items as $key => $last_update){
            $ret[$key] = (@$items_list[$key] >= $last_update);
	    }
		return $ret;
    }
    
}
?>