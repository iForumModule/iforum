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

/**
 * Base class for all objects in the Xoops kernel (and beyond) 
 * 
 * @author		Taiwen Jiang
 **/
class _XoopsPersistableObject extends XoopsObject
{
    /**
     * @var string
     */
    var $table;
    
    
    /* Adding the variable is totally wrong !!! Just for backward compatibility*/
    var $db;
    
    function _XoopsPersistableObject(){
	    if(!empty($table)) {
	    	$this->table = $GLOBALS["xoopsDB"]->prefix($table);
    	}
    	
    	/* Adding the variable is totally wrong !!! Just for backward compatibility*/
    	$this->db =& $GLOBALS["xoopsDB"];
    }

    /**
    * Skip treatment for empty var
    * 
    */
    function getVar($key, $format = 's')
    {
        switch ($this->vars[$key]['data_type']) {
            case XOBJ_DTYPE_ARRAY:
		        $ret = $this->vars[$key]['value'];
	            if (!is_array($ret)) {
	                if ($ret != "") {
	                    $ret = unserialize($ret);
	                }
	            	$ret = is_array($ret) ? $ret : array();
	            }
	            break;
            default:
            	$ret = parent::getVar($key, $format);
	            break;
        }
        
        return $ret;
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
		    @$this->vars[$key]["changed"] = null;
	    }
	    return true;
    }
}

/**
* Persistable Object Handler class.  
*
* @author	Taiwen Jiang, derived from Jan Keller Pedersen's class for XOOPS 2.2
*/

class _XoopsPersistableObjectHandler extends XoopsObjectHandler {

    /**#@+
    * Information about the class, the handler is managing
    *
    * @var string
    */
    var $table;
    var $keyName;
    var $className;
    var $identifierName;
    /**#@-*/

    /**
    * Constructor - called from child classes
    * @param object     $db         {@link XoopsDatabase} object
    * @param string     $tablename  Name of database table
    * @param string     $classname  Name of Class, this handler is managing
    * @param string     $keyname    Name of the property, holding the key
    *
    * @return void
    */
    function _XoopsPersistableObjectHandler(&$db, $table, $className, $keyName, $identifierName = false) {
        $this->XoopsObjectHandler($db);
        $this->table = $table;
        $this->keyName = $keyName;
        $this->className = $className;
        if ($identifierName != false) {
            $this->identifierName = $identifierName;
        }
    }
    
    /**
     * create a new object
     * 
     * @param bool $isNew Flag the new objects as "new"?
     *
     * @return object
     */
    function &create($isNew = true) {
        $obj =& new $this->className();
        if ($isNew === true) {
            $obj->setNew();
        }
        return $obj;
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
	    if(empty($id)) {
	    	$object =& $this->create();
		    return $object;
	    }
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
	        	foreach($myrow as $key => $val){
            		$ret[$myrow[$this->keyName]][$key] = ($object->vars[$key]["changed"]) ? $object->getVar($key) : $val;
        		}
        	}
            unset($object);
        }
        return $ret;
    }
        
    /**
     * get MySQL server version
     * 
     * @return 	string
     */
    function mysql_server_version($conn = null)
    {
	    if(!is_null($conn)){
		    return mysql_get_server_info($conn);
	    }else{
		    return mysql_get_server_info();
	    }
    }
    
    /**
     * get MySQL major version
     * 
     * @return 	integer	: 3 - 4.1-; 4 - 4.1+; 5 - 5.0+
     */
    function mysql_major_version()
    {
	    $version = $this->mysql_server_version();
	    if(version_compare( $version, "5.0.0", "ge" ) ) $mysql_version = 5;
	    elseif(version_compare( $version, "4.1.0", "ge" ) ) $mysql_version = 4;
	    else $mysql_version = 3;
	    return $mysql_version;
    }
    
    // deprecated
    function mysql_client_version()
    {
	    return $this->mysql_major_version();
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
        elseif(is_string($this->{$var})) $vars[$var] = preg_replace("/[^a-z0-9\-_]/i", "", $this->{$var});
        
        return $vars[$var];
    }
    
}
?>