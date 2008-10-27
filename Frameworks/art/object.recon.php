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
* Article object reconciliation handler class.  
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2000 The XOOPS Project
*
* {@link _XoopsPersistableObjectHandler} 
*
*/

class ArtObjectReconHandler extends _XoopsPersistableObjectHandler
{
     
    /**#@+
     *
     * @var string
     */
    var $table_link;
    var $field_link;
    var $field_object;
    var $keyname_link;
    
    function ArtObjectReconHandler(&$db, $table, $className, $keyName, $identifierName = false) {
        $this->_XoopsPersistableObjectHandler( $db, $table, $className, $keyName, $identifierName );
    }
    
    
    /**
     * clean orphan objects
     * 
     * @return 	bool	true on success
     */
    function cleanOrphan($table_link = "", $field_link = "", $field_object = "")
    {
	    $table_link = empty($table_link) ? $this->table_link : preg_replace("/[^a-z0-9\-_]/i", "", $table_link);
	    if(empty($table_link)){
		    return false;
	    }
	    $field_link = empty($field_link) ? $this->field_link : preg_replace("/[^a-z0-9\-_]/i", "", $field_link);
	    if(empty($field_link)){
		    return false;
	    }
	    $field_object = empty($field_object) ? ( empty($this->field_object) ? $field_link : $this->field_object ) : preg_replace("/[^a-z0-9\-_]/i", "", $field_object);
	    
    	/* for MySQL 4.1+ */
    	if($this->mysql_major_version() >= 4):
        $sql = "DELETE FROM ".$this->table.
        		" WHERE (".$field_object." NOT IN ( SELECT DISTINCT ".$field_link." FROM ".$table_link.") )";
        else:
        // for 4.0+
        /* */
        $sql = 	"DELETE ".$this->table." FROM ".$this->table.
        		" LEFT JOIN ".$table_link." AS aa ON ".$this->table.".".$field_object." = aa.".$field_link." ".
        		" WHERE (aa.".$field_link." IS NULL)";
        /* */
        // for 4.1+
        /*
        $sql = 	"DELETE bb FROM ".$this->table." AS bb".
        		" LEFT JOIN ".$table_link." AS aa ON bb.".$field_object." = aa.".$field_link." ".
        		" WHERE (aa.".$field_link." IS NULL)";
        */
		endif;
        if (!$result = $this->db->queryF($sql)) {
	        //mod_message("cleanOrphan:". $sql);
            return false;
        }
        return true;
    }
    
    /**
     * Synchronizing objects
     * 
     * @return 	bool	true on success
     */
    function synchronization()
    {
	    $this->cleanOrphan();
        return true;
    }
}
?>