<?php
/**
 * Extended object handlers
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		Frameworks::art
 */
 
if (!defined("ICMS_ROOT_PATH")) {
	exit();
}

/**
* Article object joint methods handler class.  
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2000 The XOOPS Project
*
* {@link _XoopsPersistableObjectHandler} 
*
*/

class ArtObjectJointHandler
{
    /**#@+
     *
     * @var object
     */
    var $_handler;
    
    function ArtObjectJointHandler(&$handler) {
	    $this->_handler =& $handler; 
    }
	
    /**
     * get a list of objects matching a condition with another related object
     * 
     * @param 	object	$criteria 	{@link CriteriaElement} to match
     * @param 	array	$tags 		variables to fetch
     * @param 	bool	$asObject 	flag indicating as object, otherwise as array
     * @return 	array of objects {@link ArtObject}
     */
   	function &getByLink($criteria = null, $tags = null, $asObject = true, $field_link = null, $field_object = null)
    {
	    if(is_array($tags) && count($tags)>0) {
		    if(!in_array("o.".$this->_handler->keyName, $tags)) {
			    $tags[] = "o.".$this->_handler->keyName;
		    }
		    $select = implode(",", $tags);
	    }
	    else $select = "o.*, l.*";
	    $limit = null;
	    $start = null;
	    $field_object = empty($field_object) ? $this->_handler->field_object : preg_replace("/[^a-z0-9\-_]/i", "", $field_object); // deprecated
	    $field_link = empty($field_link) ? $this->_handler->field_link : preg_replace("/[^a-z0-9\-_]/i", "", $field_link); // deprecated
	    
	    $field_object = empty($field_object) ? $field_link : $field_object;
        $sql = "SELECT $select".
        		" FROM " . $this->_handler->table." AS o ".
        		" LEFT JOIN ".$this->_handler->table_link." AS l ON o.".$field_object." = l.".$field_link;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
            if ($sort = $criteria->getSort()) {
                $sql .= " ORDER BY ".$sort." ".$criteria->getOrder();
                $orderSet = true;
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        if(empty($orderSet)) $sql .= " ORDER BY o.".$this->_handler->keyName." DESC";
        $result = $this->_handler->db->query($sql, $limit, $start);
        $ret = array();
		if($asObject) {        
	        while ($myrow = $this->_handler->db->fetchArray($result)) {
	            $object =& $this->_handler->create(false);
	            $object->assignVars($myrow);
	            $ret[$myrow[$this->_handler->keyName]] = $object;
	            unset($object);
	        }
        }else{
	    	$object =& $this->_handler->create(false);
	        while ($myrow = $this->_handler->db->fetchArray($result)) {
	            $object->assignVars($myrow);
		        $ret[$myrow[$this->keyName]] = $object->getValues(array_keys($myrow));
	        }
	    	unset($object);
        }
        
        return $ret;
    }

    /**
     * count objects matching a condition
     * 
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of articles
     */
   	function getCountByLink($criteria = null)
    {
        $sql = "SELECT COUNT(DISTINCT ".$this->_handler->keyName.") AS count".
        		" FROM " . $this->_handler->table." AS o ".
        		" LEFT JOIN ".$this->_handler->table_link." AS l ON o.".$this->_handler->field_object." = l.".$this->_handler->field_link;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        if (!$result = $this->_handler->db->query($sql)) {
            return false;
        }
        $myrow = $this->_handler->db->fetchArray($result);
        return intval($myrow["count"]);
    }
    
   	function getCountsByLink($criteria = null)
    {
        $sql = "SELECT l.".$this->_handler->keyName_link.", COUNT(*)".
        		" FROM " . $this->_handler->table." AS o ".
        		" LEFT JOIN ".$this->_handler->table_link." AS l ON o.".$this->_handler->field_object." = l.".$this->_handler->field_link;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        $sql .=" GROUP BY l.".$this->_handler->keyName_link."";
        if (!$result = $this->_handler->db->query($sql)) {
            return false;
        }
        $ret = array();
        while (list($id, $count) = $this->_handler->db->fetchRow($result)) {
            $ret[$id] = $count;
        }
        return $ret;
    }
    
   	function updateByLink($data, $criteria = null)
    {
	    $set = array();
	    foreach($data as $key=>$val){
		    $set[] = "o.".$key. "=".$this->_handler->db->quoteString($val);
	    }
        $sql = "UPDATE " . $this->_handler->table." AS o ".
        		" SET ".implode(", ", $set).
        		" LEFT JOIN ".$this->_handler->table_link." AS l ON o.".$this->_handler->field_object." = l.".$this->_handler->field_link;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        return $this->_handler->db->query($sql);
    }
    
   	function deleteByLink($criteria = null)
    {
        $sql = "DELETE".
        		" FROM " . $this->_handler->table." AS o ".
        		" LEFT JOIN ".$this->_handler->table_link." AS l ON o.".$this->_handler->field_object." = l.".$this->_handler->field_link;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        return $this->_handler->db->query($sql);
    }
}
?>