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
* Article object render handler class.  
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2000 The XOOPS Project
*
* {@link _XoopsPersistableObjectHandler} 
*
*/

class ArtObjectRenderHandler extends _XoopsPersistableObjectHandler
{
    function ArtObjectRenderHandler(&$db, $table, $className, $keyName, $identifierName = false) {
        $this->_XoopsPersistableObjectHandler( $db, $table, $className, $keyName, $identifierName );
    }

    /**
     * retrieve objects from the database
     * 
     * @param object $criteria {@link CriteriaElement} conditions to be met
     * @param bool $id_as_key use the ID as key for the array?
     * @param bool $as_object return an array of objects?
     *
     * @return array
     */
    function &getObjects($criteria = null, $id_as_key = false, $as_object = true)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->table;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
            if ($criteria->getSort() != '') {
                $sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }

        $ret = $this->convertResultSet($result, $id_as_key, $as_object);
        return $ret;
    }

    /**
     * Convert a database resultset to a returnable array
     *
     * @param object $result database resultset
     * @param bool $id_as_key - should NOT be used with joint keys
     * @param bool $as_object
     *
     * @return array
     */
    function convertResultSet($result, $id_as_key = false, $as_object = true) {
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $obj =& $this->create(false);
            $obj->assignVars($myrow);
            if (!$id_as_key) {
                if ($as_object) {
                    $ret[] =& $obj;
                }
                else {
                    $row = array();
                    $vars = $obj->getVars();
                    foreach (array_keys($vars) as $i) {
                        $row[$i] = $obj->getVar($i);
                    }
                    $ret[] = $row;
                }
            } else {
                if ($as_object) {
                    $ret[$myrow[$this->keyName]] =& $obj;
                }
                else {
                    $row = array();
                    $vars = $obj->getVars();
                    foreach (array_keys($vars) as $i) {
                        $row[$i] = $obj->getVar($i);
                    }
                    $ret[$myrow[$this->keyName]] = $row;
                }
            }
            unset($obj);
        }

        return $ret;
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
        $ret = array();
        if ($criteria == null) {
            $criteria = new CriteriaCompo();
        }
            
        $sql = 'SELECT '.$this->keyName;
        if(!empty($this->identifierName)){
	        $sql .= ', '.$this->identifierName;
        }
        $sql .= ' FROM '.$this->table;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
            if ($criteria->getSort() != '') {
                $sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }

        $myts =& MyTextSanitizer::getInstance();
        while ($myrow = $this->db->fetchArray($result)) {
            //identifiers should be textboxes, so sanitize them like that
            $ret[$myrow[$this->keyName]] = empty($this->identifierName) ? 1 : $myts->htmlSpecialChars($myrow[$this->identifierName]);
        }
        return $ret;
    }

    /**
     * get IDs of objects matching a condition
     * 
     * @param 	object	$criteria {@link CriteriaElement} to match
     * @return 	array of object IDs
     */
    function &getIds($criteria = null)
    {
        $ret = array();
        $sql = "SELECT ".$this->keyName." FROM " . $this->table;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        if(!$result = $this->db->query($sql)){
	        xoops_error($this->db->error());
	        return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
	        $ret[] = $myrow[$this->keyName];
        }
        return $ret;
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
}
?>