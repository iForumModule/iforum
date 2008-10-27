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
* Article object stats handler class.  
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2000 The XOOPS Project
*
* {@link _XoopsPersistableObjectHandler} 
*
*/

class ArtObjectStatsHandler extends _XoopsPersistableObjectHandler
{
    function ArtObjectStatsHandler(&$db, $table, $className, $keyName, $identifierName = false) {
        $this->_XoopsPersistableObjectHandler( $db, $table, $className, $keyName, $identifierName );
    }
    
    /**
     * count objects matching a condition
     * 
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of objects
     */
    function getCount($criteria = null)
    {
        $field = "";
        $groupby = false;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            if ($criteria->groupby != "") {
                $groupby = true;
                $field = $criteria->groupby.", "; //Not entirely secure unless you KNOW that no criteria's groupby clause is going to be mis-used
            }
        }
        $sql = 'SELECT '.$field.'COUNT(*) FROM '.$this->table;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
            if ($criteria->groupby != "") {
                $sql .= $criteria->getGroupby();
            }
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        if ($groupby == false) {
            list($count) = $this->db->fetchRow($result);
            return $count;
        }
        else {
            $ret = array();
            while (list($id, $count) = $this->db->fetchRow($result)) {
                $ret[$id] = $count;
            }
            return $ret;
        }
    }
    
    /**
     * get counts matching a condition
     * 
     * @param object	$criteria {@link CriteriaElement} to match
     * @return array of conunts
     */
   	function getCounts($criteria = null)
    {
	    $ret = array();
	    
	    $sql_where = "";
	    $limit = null;
	    $start = null;
	    $groupby_key = $this->keyName;
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql_where = $criteria->renderWhere();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
            if($groupby = $criteria->groupby){
	            $groupby_key = $groupby;
            }
        }
        $sql = "SELECT ".$groupby_key.", COUNT(*) AS count".
        		" FROM " . $this->table.
        		" ".$sql_where.
        		" GROUP BY ".$groupby_key.
        		" ORDER BY count DESC";
        if(!$result = $this->db->query($sql, $limit, $start)) {
	        //xoops_error("get object counts error: ".$sql);
            return $ret;
        }
        $ret = array();
        while (list($id, $count) = $this->db->fetchRow($result)) {
            $ret[$id] = $count;
        }
        return $ret;
    }
}
?>