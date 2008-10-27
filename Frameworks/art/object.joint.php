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
 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

load_objectHandler("persistable");
//class_exists("_XoopsPersistableObjectHandler") || require_once dirname(__FILE__)."/object.persistable.php";

/**
* Article object joint methods handler class.  
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2000 The XOOPS Project
*
* {@link _XoopsPersistableObjectHandler} 
*
*/

class ArtObjectJointHandler extends _XoopsPersistableObjectHandler
{
     
    /**#@+
     *
     * @var string
     */
    var $table_link;
    var $field_link;
    var $field_object;
    var $keyname_link;
    
    function ArtObjectJointHandler(&$db, $tablename, $classname, $keyname, $identifierName = false) {
        $this->_XoopsPersistableObjectHandler($db, $tablename, $classname, $keyname, $identifierName);
    }
	
    /**
     * get a list of objects matching a condition with another related object
     * 
     * @param 	object	$criteria 	{@link CriteriaElement} to match
     * @param 	array	$tags 		variables to fetch
     * @param 	bool	$asObject 	flag indicating as object, otherwise as array
     * @return 	array of articles {@link Barticle}
     */
   	function &getByLink($criteria = null, $tags = null, $asObject = true, $field_link = null, $field_object = null)
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
	    $field_object = empty($field_object) ? $this->field_object : preg_replace("/[^a-z0-9\-_]/i", "", $field_object); // deprecated
	    $field_link = empty($field_link) ? $this->field_link : preg_replace("/[^a-z0-9\-_]/i", "", $field_link); // deprecated
	    
	    $field_object = empty($field_object) ? $field_link : $field_object;
        $sql = "SELECT $select".
        		" FROM " . $this->table." AS o ".
        		" LEFT JOIN ".$this->table_link." AS l ON o.".$field_object." = l.".$field_link;
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
     * count objects matching a condition of a category (categories)
     * 
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of articles
     */
   	function getCountByLink($criteria = null)
    {
        $sql = "SELECT COUNT(DISTINCT ".$this->keyName.") AS count".
        		" FROM " . $this->table." AS o ".
        		" LEFT JOIN ".$this->table_link." AS l ON o.".$this->field_object." = l.".$this->field_link;
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
        $sql = "SELECT l.".$this->keyName_link.", COUNT(*)".
        		" FROM " . $this->table." AS o ".
        		" LEFT JOIN ".$this->table_link." AS l ON o.".$this->field_object." = l.".$this->field_link;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        $sql .=" GROUP BY l.".$this->keyName_link."";
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
        		" LEFT JOIN ".$this->table_link." AS l ON o.".$this->field_object." = l.".$this->field_link;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        return $this->db->query($sql);
    }
    
   	function deleteByLink($criteria = null)
    {
        $sql = "DELETE".
        		" FROM " . $this->table." AS o ".
        		" LEFT JOIN ".$this->table_link." AS l ON o.".$this->field_object." = l.".$this->field_link;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        return $this->db->query($sql);
    }
}
?>