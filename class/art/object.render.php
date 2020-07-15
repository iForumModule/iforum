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
* Object render handler class.  
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2000 The XOOPS Project
*
* {@link _XoopsPersistableObjectHandler} 
*
*/

class ArtObjectRenderHandler
{
    /**#@+
     *
     * @var object
     */
    var $_handler;
    
    function __construct(&$handler) {
	    $this->_handler =& $handler; 
    }

    /**
     * retrieve objects from the database
     *
     * For performance consideration, getAll() is recommended
     * 
     * @param object $criteria {@link icms_db_criteria_Element} conditions to be met
     * @param bool $id_as_key use the ID as key for the array?
     * @param bool $as_object return an array of objects?
     *
     * @return array
     */
    function &getObjects($criteria = null, $id_as_key = false, $as_object = true)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->_handler->table;
        if (isset($criteria) && is_subclass_of($criteria, 'icms_db_criteria_Element')) {
            $sql .= ' '.$criteria->renderWhere();
            if ($criteria->getSort() != '') {
                $sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = icms::$xoopsDB->query($sql, $limit, $start);
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
        while ($myrow = icms::$xoopsDB->fetchArray($result)) {
            $obj = $this->_handler->create(false);
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
                    $ret[$myrow[$this->_handler->keyName]] =& $obj;
                }
                else {
                    $row = array();
                    $vars = $obj->getVars();
                    foreach (array_keys($vars) as $i) {
                        $row[$i] = $obj->getVar($i);
                    }
                    $ret[$myrow[$this->_handler->keyName]] = $row;
                }
            }
            unset($obj);
        }

        return $ret;
    }
    
    /**
    * Retrieve a list of objects as arrays - Try to repair a misuse of setSort in parent::object
    *
    * @param object $criteria {@link icms_db_criteria_Element} conditions to be met
    * @param int   $limit      Max number of objects to fetch
    * @param int   $start      Which record to start at
    *
    * @return array
    */
    
    function getList($criteria = null, $limit = 0, $start = 0) 
    {
        $ret = array();
        if ($criteria == null) {
            $criteria = new icms_db_criteria_Compo();
        }
            
        $sql = 'SELECT '.$this->_handler->keyName;
        if(!empty($this->_handler->identifierName)){
	        $sql .= ', '.$this->_handler->identifierName;
        }
        $sql .= ' FROM '.$this->_handler->table;
        if (isset($criteria) && is_subclass_of($criteria, 'icms_db_criteria_Element')) {
            $sql .= ' '.$criteria->renderWhere();
            if ($criteria->getSort() != '') {
                $sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = icms::$xoopsDB->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }

        $myts = icms_core_Textsanitizer::getInstance();
        while ($myrow = icms::$xoopsDB->fetchArray($result)) {
            //identifiers should be textboxes, so sanitize them like that
            $ret[$myrow[$this->_handler->keyName]] = empty($this->_handler->identifierName) ? 1 : icms_core_DataFilter::htmlSpecialchars($myrow[$this->_handler->identifierName]);
        }
        return $ret;
    }

    /**
     * get IDs of objects matching a condition
     * 
     * @param 	object	$criteria {@link icms_db_criteria_Element} to match
     * @return 	array of object IDs
     */
    function &getIds($criteria = null)
    {
        $ret = array();
        $sql = "SELECT ".$this->_handler->keyName." FROM " . $this->_handler->table;
        $limit = $start = null;
        if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
            $sql .= " ".$criteria->renderWhere();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        if(!$result = icms::$xoopsDB->query($sql, $limit, $start)){
	        //icms_core_Message::error(icms::$xoopsDB->error());
	        return $ret;
        }
        while ($myrow = icms::$xoopsDB->fetchArray($result)) {
	        $ret[] = $myrow[$this->_handler->keyName];
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
     * @param object	$criteria 	{@link icms_db_criteria_Element} to match
     * @param array		$tags 		variables to fetch
     * @param bool		$asObject 	flag indicating as object, otherwise as array
     * @return array of objects 	{@link ArtObject}
     */
   	function &getByLimit($limit=0, $start = 0, $criteria = null, $tags = null, $asObject=true)
   	{
        if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
	        $criteria->setLimit($limit);
	        $criteria->setStart($start);
        } elseif(!empty($limit)) {
			$criteria = new icms_db_criteria_Compo();
	        $criteria->setLimit($limit);
	        $criteria->setStart($start);
        }
        $ret = $this->_handler->getAll($criteria, $tags, $asObject);
        return $ret;
   	}	
}