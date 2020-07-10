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
load_objectHandler("persistable");

/**
* Article object reconciliation handler class.  
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2000 The XOOPS Project
*
* {@link _XoopsPersistableObjectHandler} 
*
*/

class ArtObjectReconHandler
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
     * clean orphan objects
     * 
     * @return 	bool	true on success
     */
    function cleanOrphan($table_link = "", $field_link = "", $field_object = "")
    {
	    $table_link = empty($table_link) ? $this->_handler->table_link : preg_replace("/[^a-z0-9\-_]/i", "", $table_link);
	    if(empty($table_link)){
		    return false;
	    }
	    $field_link = empty($field_link) ? $this->_handler->field_link : preg_replace("/[^a-z0-9\-_]/i", "", $field_link);
	    if(empty($field_link)){
		    return false;
	    }
	    $field_object = empty($field_object) ? ( empty($this->_handler->field_object) ? $field_link : $this->_handler->field_object ) : preg_replace("/[^a-z0-9\-_]/i", "", $field_object);
	    
    	/* for MySQL 4.1+ */
    	if($this->_handler->mysql_major_version() >= 4):
        $sql = "DELETE FROM ".$this->_handler->table.
        		" WHERE (".$field_object." NOT IN ( SELECT DISTINCT ".$field_link." FROM ".$table_link.") )";
        else:
        // for 4.0+
        /* */
        $sql = 	"DELETE ".$this->_handler->table." FROM ".$this->_handler->table.
        		" LEFT JOIN ".$table_link." AS aa ON ".$this->_handler->table.".".$field_object." = aa.".$field_link." ".
        		" WHERE (aa.".$field_link." IS NULL)";
        /* */
        // for 4.1+
        /*
        $sql = 	"DELETE bb FROM ".$this->_handler->table." AS bb".
        		" LEFT JOIN ".$table_link." AS aa ON bb.".$field_object." = aa.".$field_link." ".
        		" WHERE (aa.".$field_link." IS NULL)";
        */
		endif;
        if (!$result = icms::$xoopsDB->queryF($sql)) {
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