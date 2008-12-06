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
defined("FRAMEWORKS_ART_FUNCTIONS_INI") || include_once (dirname(__FILE__)."/functions.ini.php");
load_objectHandler("persistable");

if (!class_exists("ArtObject")):

/**
 * Art Object
 * 
 * @author D.J. (phppp)
 * @copyright copyright &copy; 2005 XoopsForge.com
 * @package module::article
 *
 * {@link _XoopsPersistableObject} 
 **/

class ArtObject extends _XoopsPersistableObject
{
    
    /**
     * @var string
     */
    var $plugin_path;
    
    function ArtObject($table = "")
    {
	    $this->_XoopsPersistableObject($table);
    }

    /**
     * dynamically register additional filter for the object
     * 
     * This is from the original code along with /kernel/object.php,
     * It is not necessary but keep as it is, to change when necessary
     *
     * @param string $filtername name of the filter
     * @access public
     */
    function registerFilter($filtername)
    {
        parent::registerFilter($filtername);
    }

    /**
     * load all additional filters that have been registered to the object
     * 
     * This is from the original code along with /kernel/object.php,
     * I don't understand its design purpose in terms of plugin distribution but just leave as it is
     *
     * @access private
     */
    function _loadFilters()
    {
	    static $loaded;
	    if (!isset($loaded)) return;
	    $loaded = 1;
	    
	    $path = empty($this->plugin_path) ? dirname(__FILE__).'/filters' : $this->plugin_path;
        @include_once $path.'/filter.php';
        foreach ($this->_filters as $f) {
            @include_once $path.'/'.strtolower($f).'php';
        }
    }
    
    /**
     * load all local filters for the object
     * 
     * Filter distribution:
     * In each module folder there is a folder "filter" containing filter files with, 
     * filename: [name of target class][.][function/action name][.php];
     * function name: [name of target class][_][function/action name];
     * parameter: the target object
     *
     * @param   string     $class	class name
     * @param   string     $method	function or action name
     * @access public
     */
    function loadFilters($method)
    {
        $this->_loadFilters();
        
        load_functions("filter");
        mod_loadFilters($this, $method);
    }

}

/**
* object handler class.  
* @package module::article
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2000 The XOOPS Project
*
* {@link _XoopsPersistableObjectHandler} 
*
*/

class ArtObjectHandler extends _XoopsPersistableObjectHandler
{
    /**#@+
     * holds reference to object handler(DAO) classes: render, reconciliation, stats, write, joint
     * @access private
     */
    var $_handler;
     
    /**#@+
     * for _jHandler
     *
     * @var string
     */
    var $table_link;
    var $field_link;
    var $field_object;
    var $keyname_link;
    
	/**
	 * Constructor
	 *
	 * @param object $db reference to the {@link XoopsDatabase} object	 
	 **/
    function ArtObjectHandler(&$db, $table = "", $className = "", $keyName = "", $identifierName = false) {
	    $table = $db->prefix($table);
        $this->_XoopsPersistableObjectHandler( $db, $table, $className, $keyName, $identifierName );
    }
    
    function _loadHandler($name, $params = array()) {
	    if ( !isset($this->_handler[$name]) ) {
		    load_objectHandler($name);
		    $className = "ArtObject".ucfirst($name)."Handler";
	        $this->_handler[$name] =& new $className($this);
        }
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
	    $this->_loadHandler("write");
	    return $this->_handler["write"]->insert($object, $force);
    }

    /**
     * delete an object from the database
     * 
     * @param object $obj reference to the object to delete
     * @param bool $force
     * @return bool FALSE if failed.
     */
    function delete(&$object, $force = false)
    {
	    $this->_loadHandler("write");
	    return $this->_handler["write"]->delete($object, $force);
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
	    $this->_loadHandler("render");
	    $ret = $this->_handler["render"]->getObjects($criteria, $id_as_key, $as_object);
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
	    $this->_loadHandler("render");
	    $ret = $this->_handler["render"]->getList($criteria, $limit, $start);
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
	    $this->_loadHandler("render");
	    $ret = $this->_handler["render"]->getIds($criteria);
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
     * @return array of objects 	{@link ArtObject}
     */
   	function &getByLimit($limit=0, $start = 0, $criteria = null, $tags = null, $asObject=true)
   	{
	    $this->_loadHandler("render");
	    $ret = $this->_handler["render"]->getByLimit($limit, $start, $criteria, $tags, $asObject);
	    return $ret;
   	}
    
    /**
     * count objects matching a condition
     * 
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of objects
     */
    function getCount($criteria = null)
    {
	    $this->_loadHandler("stats");
	    $ret = $this->_handler["stats"]->getCount($criteria);
	    return $ret;
    }
    
    /**
     * get counts matching a condition
     * 
     * @param object	$criteria {@link CriteriaElement} to match
     * @return array of conunts
     */
   	function getCounts($criteria = null)
    {
	    $this->_loadHandler("stats");
	    $ret = $this->_handler["stats"]->getCounts($criteria);
	    return $ret;
    }
    
    /**
     * delete all objects meeting the conditions
     * 
     * @param	object	$criteria {@link CriteriaElement} with conditions to meet
     * @param 	bool	$force	force to delete
     * @param 	bool	$asObject	delete in object way	
     * @return bool
     */

    function deleteAll($criteria = null, $force = true, $asObject = false)
    {
	    $this->_loadHandler("write");
	    return $this->_handler["write"]->deleteAll($criteria, $force, $asObject);
    }
    
    /**
     * Change a value for objects with a certain criteria
     * 
     * @param   string  $fieldname  Name of the field
     * @param   string  $fieldvalue Value to write
     * @param   object  $criteria   {@link CriteriaElement} 
     * 
     * @return  bool
     **/
    function updateAll($fieldname, $fieldvalue, $criteria = null, $force = false)
    {
	    $this->_loadHandler("write");
	    return $this->_handler["write"]->updateAll($fieldname, $fieldvalue, $criteria, $force);
    }
    
    /**
     * get a list of objects matching a condition with another related object
     * 
     * @param 	object	$criteria 	{@link CriteriaElement} to match
     * @param 	array	$tags 		variables to fetch
     * @param 	bool	$asObject 	flag indicating as object, otherwise as array
     * @return 	array of articles {@link ArtObject}
     */
   	function &getByLink($criteria = null, $tags = null, $asObject = true, $field_link = null, $field_object = null)
    {
	    $this->_loadHandler("joint", array("table_link", "field_link", "field_object", "keyname_link"));
	    $ret = $this->_handler["joint"]->getByLink($criteria, $tags, $asObject, $field_link, $field_object);
	    return $ret;
    }

    /**
     * count objects matching a condition of a category (categories)
     * 
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of objects
     */
   	function getCountByLink($criteria = null)
    {
	    $this->_loadHandler("joint", array("table_link", "field_link", "field_object", "keyname_link"));
	    $ret = $this->_handler["joint"]->getCountByLink($criteria);
	    return $ret;
    }
    
   	function getCountsByLink($criteria = null)
    {
	    $this->_loadHandler("joint", array("table_link", "field_link", "field_object", "keyname_link"));
	    $ret = $this->_handler["joint"]->getCountsByLink($criteria);
	    return $ret;
    }
    
   	function updateByLink($data, $criteria = null)
    {
	    $this->_loadHandler("joint", array("table_link", "field_link", "field_object", "keyname_link"));
	    $ret = $this->_handler["joint"]->updateByLink($data, $criteria);
	    return $ret;
    }
    
   	function deleteByLink($criteria = null)
    {
	    $this->_loadHandler("joint", array("table_link", "field_link", "field_object", "keyname_link"));
	    $ret = $this->_handler["joint"]->deleteByLink($criteria);
	    return $ret;
    }
    
    /**
     * clean orphan objects
     * 
     * @return 	bool	true on success
     */
    function cleanOrphan($table_link = "", $field_link = "", $field_object = "")
    {
	    $this->_loadHandler("recon", array("table_link", "field_link", "field_object", "keyname_link"));
	    $ret = $this->_handler["recon"]->cleanOrphan($table_link, $field_link, $field_object);
	    return $ret;
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
endif;
?>