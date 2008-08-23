<?php
// $Id: object.php,v 1.1.1.1 2005/11/10 19:51:08 phppp Exp $
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
//                                                                          //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
//                                                                          //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
//                                                                          //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: phppp (D.J., infomax@gmail.com)                                  //
// URL: http://xoopsforge.com, http://xoops.org.cn                          //
// Project: Article Project                                                 //
// ------------------------------------------------------------------------ //
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}


// XOOPS 2.2
if(!defined("XOOPS_PATH") && class_exists("XoopsPersistableObjectHandler")):
	class _XoopsObject extends XoopsObject
	{
	}
	
	class _XoopsPersistableObjectHandler extends XoopsPersistableObjectHandler 
	{
	    function _XoopsPersistableObjectHandler(&$db, $tablename, $classname, $keyname, $idenfierName = false) {
			$this->XoopsPersistableObjectHandler($db, $tablename, $classname, $keyname, $idenfierName);
	    }
	}

// XOOPS 2.0, 2.3
else:
	include_once dirname(dirname(__FILE__))."/xoops22/kernel/object.php";
endif;

if(!class_exists("ArtObject")):

/**
 * Article Object
 * 
 * @author D.J. (phppp)
 * @copyright copyright &copy; 2005 XoopsForge.com
 * @package module::article
 *
 * {@link XoopsObject} 
 **/

class ArtObject extends _XoopsObject
{
    /**
     * holds all variables of value changed
     * 
     * @var array
     */
	var $changedVars = array();
    /**
     * holds reference to xoopsDB
     * @var object
     */
    var $db;
    /**
     * @var string
     */
    var $table;

    function ArtObject($id = null)
    {
        $this->db =& Database::getInstance();
    }
    
    /**
    * unset variable(s) for the object
    * 
    * @access public
    * @param mixed $var
    */
    function destoryVars($var)
    {
	    if(empty($var)) return true;
	    if(!is_array($var)) $var = array($var);
	    foreach($var as $key){
		    @$this->vars[$key]["changed"] = false;
	    }
	    return true;
    }

    function cleanVars()
    {
	    parent::cleanVars();
        foreach ($this->vars as $k => $v) {
            $cleanv = $this->cleanVars[$k];
            switch ($v["data_type"]) {
                case XOBJ_DTYPE_TXTAREA:
                    if ($v["changed"] && !empty($this->vars['dohtml']['value'])) {
                        $cleanv = text_filter($cleanv);
                    }
                case XOBJ_DTYPE_TXTBOX:
                case XOBJ_DTYPE_SOURCE:
                case XOBJ_DTYPE_URL:
                case XOBJ_DTYPE_EMAIL:
                    if ($v["changed"]) {
                        $cleanv = $this->db->quoteString($cleanv);
                    }
                    break;
                case XOBJ_DTYPE_INT:
                	break;
                case XOBJ_DTYPE_ARRAY:
            		if($v["changed"]){
	                	$cleanv = $this->db->quoteString($cleanv);
                	}
                    break;
                case XOBJ_DTYPE_STIME:
                case XOBJ_DTYPE_MTIME:
                case XOBJ_DTYPE_LTIME:
                default:
                    break;
            }
            if($v["changed"]){
            	$this->changedVars[$k] = $cleanv;
        	}
            unset($cleanv);
        }

        return true;
    }
}

/**
* Article object handler class.  
* @package module::article
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2000 The XOOPS Project
*
* {@link XoopsPersistableObjectHandler} 
*
* @param CLASS_PREFIX variable prefix for the class name
*/

class ArtObjectHandler extends _XoopsPersistableObjectHandler
{
    /**#@+
    * Information about obj-category link
    *
    * @var string
    */
    var $table_link;
    var $field_link;
    var $keyname_link;
    
	/**
	 * Constructor
	 *
	 * @param object $db reference to the {@link XoopsDatabase} object	 
	 **/
    function ArtObjectHandler(&$db, $tablename, $classname, $keyname, $idenfierName = false) {
        $this->_XoopsPersistableObjectHandler($db, $tablename, $classname, $keyname, $idenfierName);
    }
    
    function _setVar($var, $val)
    {
        $this->{$var} = $val;
    }
    
    function _getVar($var)
    {
	    static $vars = array();
	    
	    if(isset($vars[$var])) return $vars[$var];
	    if(!isset($this->{$var})) $vars[$var] = null;
        else $vars[$var] = preg_replace("/[^a-z0-9\-_]/i", "", $this->{$var});
        
        return $vars[$var];
    }
    
    /**
     * Load a {@link Xcategory} object from the database
     * 
     * @param   int     $id     ID
     * @param   array	$tags	variables to fetch
     * @return  object  {@link Xcategory}, a new {@link Xcategory} on fail
     **/
    function &get($id = 0, $tags=null)
    {
	    $id = intval($id);
	    if(empty($id)) return $this->create();
    	$object =& $this->create(false);
	    if(is_array($tags) && count($tags)>0) {
		    $select = implode(",", $tags);
		    if(!in_array($this->keyName, $tags)){
			    $select .= ", ".$this->keyName;
		    }
	    }
	    else $select = "*";
        $sql = "SELECT $select FROM " . $this->table . " WHERE ".$this->keyName." = " . $id;
        if (!$result = $this->db->query($sql)) {
	        $ret = null;
            return $ret;
        } 
        while ($row = $this->db->fetchArray($result)) {
            $object->assignVars($row);
        }

        return $object;
    }
    
    /**
     * insert a new object into the database
     * 
     * @param	object	$object 	{@link ArtObject} reference to ArtObject
     * @param 	bool 	$force 		flag to force the query execution despite security settings
     * @return 	int 	object ID
     */
    function insert(&$object, $force = true)
    {
        if (!$object->isDirty()) {
	        $object->setErrors("not isDirty");
	        return $object->getVar($this->keyName);
        }
        if (!$object->cleanVars()) {
	        $object->setErrors("cleanVars failed");
	        return false;
        }
        if (empty($object->changedVars)) {
	        return $object->getVar($this->keyName);
        }
        $queryFunc = empty($force)?"query":"queryF";
        
        if ($object->isNew()) {
	        unset($object->changedVars[$this->keyName]);
	        $keys = array_keys($object->changedVars);
	        $vals = array_values($object->changedVars);
            $sql = "INSERT INTO " . $this->table . " (".implode(",", $keys).") VALUES (".implode(",", $vals).")";
            if (!$result = $this->db->{$queryFunc}($sql)) {
                $object->setErrors("Insert object error ($queryFunc):" . $sql);
                return false;
            }
            $object_id = $this->db->getInsertId();
            $object->unsetNew();
            $object->setVar($this->keyName, $object_id);
            
        } else {
            $keys = array();
	        foreach ($object->changedVars as $k => $v) {
	            $keys[] = " $k = $v";
	        }
            $sql = "UPDATE " . $this->table . " SET ".implode(",",$keys)." WHERE ".$this->keyName." = " . $object->getVar($this->keyName);
            if (!$result = $this->db->{$queryFunc}($sql)) {
                $object->setErrors("update object error:" . $sql);
                return false;
            }
        }
        unset($object->changedVars);
        return $object->getVar($this->keyName);
    }
    
    /**
    * Retrieve a list of objects as arrays - Try to repair a misuse of setSort in parent::object
    *
    * @param object $criteria {@link CriteriaElement} conditions to be met
    * @param int   $limit      Max number of objects to fetch
    * @param int   $start      Which record to start at
    *
    * @return array
    */
    
    function getList($criteria = null, $limit = 0, $start = 0) 
    {
        if ($criteria == null) {
            $criteria = new CriteriaCompo();
        }
        
        if ($criteria->getSort() == '') {
            //$criteria->setSort($this->keyName);
        }
        
        return parent::getList($criteria, $limit, $start);
    }
    
    /**
     * get objects matching a condition
     * 
     * @param object	$criteria {@link CriteriaElement} to match
     * @param array		$tags 	variables to fetch
     * @param bool		$asObject 	flag indicating as object, otherwise as array
     * @return array of articles {@link Article}
     */
    function &getAll($criteria = null, $tags = null, $asObject=true)
    {
	    if(is_array($tags) && count($tags)>0) {
		    if(!in_array($this->keyName, $tags)) $tags[] = $this->keyName;
		    $select = implode(",", $tags);
	    }
	    else $select = "*";
	    $limit = null;
	    $start = null;
        $sql = "SELECT $select FROM " . $this->table;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
            if ($sort = $criteria->getSort()) {
                $sql .= " ORDER BY ".$sort." ".$criteria->getOrder();
                $orderSet = true;
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        if(empty($orderSet)) $sql .= " ORDER BY ".$this->keyName." DESC";
        $result = $this->db->query($sql, $limit, $start);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $object =& $this->create(false);
            $object->assignVars($myrow);
            if($asObject){
            	$ret[$myrow[$this->keyName]] = $object;
        	}else{
	        	foreach($myrow as $key=>$val){
            		$ret[$myrow[$this->keyName]][$key] = ($object->vars[$key]["changed"])?$object->getVar($key):$val;
        		}
        	}
            unset($object);
        }
        return $ret;
    }
    
    /**
     * delete all objects meeting the conditions
     * 
     * @param object $criteria {@link CriteriaElement} with conditions to meet
     * @return bool
     */

    function deleteAll($criteria = null, $force = true)
    {
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
        	$queryFunc = empty($force)?"query":"queryF";
            $sql = 'DELETE FROM '.$this->table;
            $sql .= ' '.$criteria->renderWhere();
            if (!$this->db->{$queryFunc}($sql)) {
                return false;
            }
            $rows = $this->db->getAffectedRows();
            return $rows > 0 ? $rows : true;
        }
        return false;
    }

    /**
     * get a limited list of objects matching a condition
     * 
	 * {@link CriteriaCompo} 
	 *
	 * @param int   	$limit      Max number of objects to fetch
	 * @param int   	$start      Which record to start at
     * @param object	$criteria 	{@link CriteriaElement} to match
     * @param array		$tags 		variables to fetch
     * @param bool		$asObject 	flag indicating as object, otherwise as array
     * @return array of objects 	{@link Object}
     */
   	function &getByLimit($limit=0, $start = 0, $criteria = null, $tags = null, $asObject=true)
   	{
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
	        $criteria->setLimit($limit);
	        $criteria->setStart($start);
        }elseif(!empty($limit)){
			$criteria = new CriteriaCompo();
	        $criteria->setLimit($limit);
	        $criteria->setStart($start);
        }
        $ret =& $this->getAll($criteria, $tags, $asObject);
        return $ret;
   	}
    
    /**
     * get a list of objects matching a condition with another related object
     * 
     * @param 	object	$criteria 	{@link CriteriaElement} to match
     * @param 	array	$tags 		variables to fetch
     * @param 	bool	$asObject 	flag indicating as object, otherwise as array
     * @return 	array of articles {@link Barticle}
     */
   	function &getByLink($criteria = null, $tags = null, $asObject=true, $linkfield = null)
    {
	    if(is_array($tags) && count($tags)>0) {
		    if(!in_array("o.".$this->keyName, $tags)) {
			    $tags[] = "o.".$this->keyName;
		    }
		    $select = implode(",", $tags);
	    }
	    else $select = "o.*, l.*";
	    $limit = null;
	    $start = null;
	    $linkfield = empty($linkfield)?$this->_getVar("field_link"):preg_replace("/[^a-z0-9\-_]/i", "", $linkfield); // deprecated
        $sql = "SELECT $select".
        		" FROM " . $this->table." AS o ".
        		" LEFT JOIN ".$this->_getVar("table_link")." AS l ON o.".$linkfield." = l.".$linkfield;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
            if ($sort = $criteria->getSort()) {
                $sql .= " ORDER BY ".$sort." ".$criteria->getOrder();
                $orderSet = true;
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        if(empty($orderSet)) $sql .= " ORDER BY o.".$this->keyName." DESC";
        $result = $this->db->query($sql, $limit, $start);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $object =& $this->create(false);
            $object->assignVars($myrow);
            if($asObject){
            	$ret[$myrow[$this->keyName]] = $object;
        	}else{
	        	foreach($myrow as $key=>$val){
            		$ret[$myrow[$this->keyName]][$key] = ($object->vars[$key]["changed"])?$object->getVar($key):$val;
        		}
        	}
            unset($object);
        }
        return $ret;
    }

    /**
     * count articles matching a condition of a category (categories)
     * 
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of articles
     */
   	function getCountByLink($criteria = null)
    {
        $sql = "SELECT COUNT(DISTINCT ".$this->keyName.") AS count".
        		" FROM " . $this->table." AS o ".
        		" LEFT JOIN ".$this->_getVar("table_link")." AS l ON o.".$this->_getVar("field_link")." = l.".$this->_getVar("field_link");
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $myrow = $this->db->fetchArray($result);
        return intval($myrow["count"]);
    }
    
   	function getCountsByLink($criteria = null)
    {
        $sql = "SELECT l.".$this->_getVar("keyName_link").", COUNT(*)".
        		" FROM " . $this->table." AS o ".
        		" LEFT JOIN ".$this->_getVar("table_link")." AS l ON o.".$this->_getVar("field_link")." = l.".$this->_getVar("field_link");
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        $sql .=" GROUP BY l.".$this->_getVar("keyName_link")."";
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $ret = array();
        while (list($id, $count) = $this->db->fetchRow($result)) {
            $ret[$id] = $count;
        }
        return $ret;
    }
    
   	function updateByLink($data, $criteria = null)
    {
	    $set = array();
	    foreach($data as $key=>$val){
		    $set[] = "o.".$key. "=".$this->db->quoteString($val);
	    }
        $sql = "UPDATE " . $this->table." AS o ".
        		" SET ".implode(", ", $set).
        		" LEFT JOIN ".$this->_getVar("table_link")." AS l ON o.".$this->_getVar("field_link")." = l.".$this->_getVar("field_link");
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        return $this->db->query($sql);
    }
    
   	function deleteByLink($criteria = null)
    {
        $sql = "DELETE".
        		" FROM " . $this->table." AS o ".
        		" LEFT JOIN ".$this->_getVar("table_link")." AS l ON o.".$this->_getVar("field_link")." = l.".$this->_getVar("field_link");
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        return $this->db->query($sql);
    }
}
endif;

if(!function_exists("text_filter")):
/* 
 * Filter out possible malicious text
 * kses project at SF could be a good solution to check
 *
 * @param string	$text 	text to filter
 * @param bool		$force 	flag indicating to force filtering
 * @return string 	filtered text
 */
function text_filter(&$text, $force = false)
{
	global $xoopsUser, $xoopsConfig;
	
	if(empty($force) && is_object($xoopsUser) && $xoopsUser->isAdmin()){
		return $text;
	}
	// For future applications
	$tags=empty($xoopsConfig["filter_tags"])?array():explode(",", $xoopsConfig["filter_tags"]);
	$tags = array_map("trim", $tags);
	
	// Set embedded tags
	$tags[] = "SCRIPT";
	$tags[] = "VBSCRIPT";
	$tags[] = "JAVASCRIPT";
	foreach($tags as $tag){
		$search[] = "/<".$tag."[^>]*?>.*?<\/".$tag.">/si";
		$replace[] = " [!".strtoupper($tag)." FILTERED!] ";
	}
	// Set iframe tag
	$search[]= "/<IFRAME[^>\/]*SRC=(['\"])?([^>\/]*)(\\1)[^>\/]*?\/>/si";
	$replace[]=" [!IFRAME FILTERED!] \\2 ";
	$search[]= "/<IFRAME[^>]*?>([^<]*)<\/IFRAME>/si";
	$replace[]=" [!IFRAME FILTERED!] \\1 ";
	// action
	$text = preg_replace($search, $replace, $text);
	return $text;
}
endif;
?>