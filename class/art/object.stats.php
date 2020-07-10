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
* Object stats handler class.  
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2000 The XOOPS Project
*
* {@link _XoopsPersistableObjectHandler} 
*
*/

class ArtObjectStatsHandler
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
     * count objects matching a condition
     * 
     * @param object $criteria {@link icms_db_criteria_Element} to match
     * @return int count of objects
     */
    function getCount($criteria = null)
    {
        $field = "";
        $groupby = false;
        if (isset($criteria) && is_subclass_of($criteria, 'icms_db_criteria_Element')) {
            if ($criteria->groupby != "") {
                $groupby = true;
                $field = $criteria->groupby.", "; //Not entirely secure unless you KNOW that no criteria's groupby clause is going to be mis-used
            }
        }
        $sql = 'SELECT '.$field.'COUNT(*) FROM '.$this->_handler->table;
        if (isset($criteria) && is_subclass_of($criteria, 'icms_db_criteria_Element')) {
            $sql .= ' '.$criteria->renderWhere();
            if ($criteria->groupby != "") {
                $sql .= $criteria->getGroupby();
            }
        }
        $result = icms::$xoopsDB->query($sql);
        if (!$result) {
            return 0;
        }
        if ($groupby == false) {
            list($count) = icms::$xoopsDB->fetchRow($result);
            return $count;
        }
        else {
            $ret = array();
            while (list($id, $count) = icms::$xoopsDB->fetchRow($result)) {
                $ret[$id] = $count;
            }
            return $ret;
        }
    }
    
    /**
     * get counts matching a condition
     * 
     * @param object	$criteria {@link icms_db_criteria_Element} to match
     * @return array of conunts
     */
   	function getCounts($criteria = null)
    {
	    $ret = array();
	    
	    $sql_where = "";
	    $limit = null;
	    $start = null;
	    $groupby_key = $this->_handler->keyName;
        if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
            $sql_where = $criteria->renderWhere();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
            if($groupby = $criteria->groupby) {
	            $groupby_key = $groupby;
            }
        }
        $sql = "SELECT ".$groupby_key.", COUNT(*) AS count".
        		" FROM " . $this->_handler->table.
        		" ".$sql_where.
        		" GROUP BY ".$groupby_key
        		//." ORDER BY count DESC"
        		;
        if(!$result = icms::$xoopsDB->query($sql, $limit, $start)) {
	        //icms_core_Message::error("get object counts error: ".$sql);
            return $ret;
        }
        $ret = array();
        while (list($id, $count) = icms::$xoopsDB->fetchRow($result)) {
            $ret[$id] = $count;
        }
        return $ret;
    }
}