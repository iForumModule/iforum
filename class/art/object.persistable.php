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
class _XoopsPersistableObject extends icms_core_Object
{
    /**
     * @var string
     */
    var $table;
    
    function __construct($table = null) {
	    if (!empty($table)) {
	    	$this->table = $GLOBALS["xoopsDB"]->prefix($table);
    	}
    }
    
    /**
    * returns a specific variable for the object in a proper format
    * 
    * @access public
    * @param string $key key of the object's variable to be returned
    * @param string $format format to use for the output
    * @return mixed formatted value of the variable
    */
    function getVar($key, $format = 's')
    {
		//defined("MYTEXTSANITIZER_EXTENDED") || include_once ICMS_ROOT_PATH."/class/module.textsanitizer.php";
		$ts = icms_core_Textsanitizer::getInstance();
		$ret = null;
		if ( !isset($this->vars[$key]) ) return $ret ;
		$ret = $this->vars[$key]['value'];
		
        switch ($this->vars[$key]['data_type']) {

        case XOBJ_DTYPE_TXTBOX:
            switch (strtolower($format)) {
            case 's':
            case 'show':
            case 'e':
            case 'edit':
                return icms_core_DataFilter::htmlSpecialchars($ret);
                break 1;
            case 'p':
            case 'preview':
            case 'f':
            case 'formpreview':
                return icms_core_DataFilter::htmlSpecialchars(icms_core_DataFilter::stripSlashesGPC($ret));
                break 1;
            case 'n':
            case 'none':
            default:
                break 1;
            }
            break;
        case XOBJ_DTYPE_TXTAREA:
            switch (strtolower($format)) {
            case 's':
            case 'show':
                $html = !empty($this->vars['dohtml']['value']) ? 1 : 0;
                $xcode = (!isset($this->vars['doxcode']['value']) || $this->vars['doxcode']['value'] == 1) ? 1 : 0;
                $smiley = (!isset($this->vars['dosmiley']['value']) || $this->vars['dosmiley']['value'] == 1) ? 1 : 0;
                $image = (!isset($this->vars['doimage']['value']) || $this->vars['doimage']['value'] == 1) ? 1 : 0;
                $br = (!isset($this->vars['dobr']['value']) || $this->vars['dobr']['value'] == 1) ? 1 : 0;
                return $ts->displayTarea($ret, $html, $smiley, $xcode, $image, $br);
                break 1;
            case 'e':
            case 'edit':
                return htmlspecialchars($ret, ENT_QUOTES);
                break 1;
            case 'p':
            case 'preview':
                $html = !empty($this->vars['dohtml']['value']) ? 1 : 0;
                $xcode = (!isset($this->vars['doxcode']['value']) || $this->vars['doxcode']['value'] == 1) ? 1 : 0;
                $smiley = (!isset($this->vars['dosmiley']['value']) || $this->vars['dosmiley']['value'] == 1) ? 1 : 0;
                $image = (!isset($this->vars['doimage']['value']) || $this->vars['doimage']['value'] == 1) ? 1 : 0;
                $br = (!isset($this->vars['dobr']['value']) || $this->vars['dobr']['value'] == 1) ? 1 : 0;
                return $ts->previewTarea($ret, $html, $smiley, $xcode, $image, $br);
                break 1;
            case 'f':
            case 'formpreview':
                return htmlspecialchars($ts->stripSlashesGPC($ret), ENT_QUOTES);
                break 1;
            case 'n':
            case 'none':
            default:
                break 1;
            }
            break;
        case XOBJ_DTYPE_ARRAY:
	        $ret = $this->vars[$key]['value'];
            if (!is_array($ret)) {
                if ($ret != "") {
                    $ret = @unserialize($ret);
                }
            	$ret = is_array($ret) ? $ret : array();
            }
            break;
        case XOBJ_DTYPE_SOURCE:
            switch (strtolower($format)) {
            case 's':
            case 'show':
                break 1;
            case 'e':
            case 'edit':
                return htmlspecialchars($ret, ENT_QUOTES);
                break 1;
            case 'p':
            case 'preview':
                return $ts->stripSlashesGPC($ret);
                break 1;
            case 'f':
            case 'formpreview':
                return htmlspecialchars($ts->stripSlashesGPC($ret), ENT_QUOTES);
                break 1;
            case 'n':
            case 'none':
            default:
                break 1;
            }
            break;
        default:
            if ($this->vars[$key]['options'] != '' && $ret != '') {
                switch (strtolower($format)) {
                case 's':
                case 'show':
					$selected = explode('|', $ret);
                    $options = explode('|', $this->vars[$key]['options']);
                    $i = 1;
                    $ret = array();
                    foreach ($options as $op) {
                        if (in_array($i, $selected)) {
                            $ret[] = $op;
                        }
                        $i++;
                    }
                    return implode(', ', $ret);
                case 'e':
                case 'edit':
                    $ret = explode('|', $ret);
                    break 1;
                default:
                    break 1;
                }

            }
            break;
        }
        return $ret;
    }

    /**
    * assign a value to a variable
    * 
    * @access public
    * @param string $key name of the variable to assign
    * @param mixed $value value to assign
    */
    function assignVar($key, $value)
    {
        if (isset($key) && isset($this->vars[$key])) {
            $this->vars[$key]['value'] =& $value;
        }
    }
    
    /**
    * unset variable(s) for the object
    * 
    * @access public
    * @param mixed $var
    */
    function destoryVars($var)
    {
	    if (empty($var)) return true;
	    if (!is_array($var)) $var = array($var);
	    foreach($var as $key){
		    if (!isset($this->vars[$key])) continue;
		    $this->vars[$key]["changed"] = null;
	    }
	    return true;
    }
    
	/**
	* Returns the values of the specified variables
	*
	* @param mixed $keys An array containing the names of the keys to retrieve, or null to get all of them
	* @param string $format Format to use (see getVar)
	* @param int $maxDepth Maximum level of recursion to use if some vars are objects themselves
	* @return array associative array of key->value pairs
	*/
	function getValues($keys = null, $format = 's', $maxDepth = 1)
    {
    	if ( !isset( $keys ) ) {
    		$keys = array_keys( $this->vars );
    	}
    	$vars = array();
    	$class = get_class($this);
    	foreach ( $keys as $key ) {
    		if ( isset( $this->vars[$key] ) ) {
    			if ( is_object( $this->vars[$key] ) && is_a( $this->vars[$key], $class ) ) {
					if ( $maxDepth ) {
    					$vars[$key] = $this->vars[$key]->getValues( null, $format, $maxDepth - 1 );
					}
    			} else {
    				$vars[$key] = $this->getVar( $key, $format );
    			}
    		}
    	}
    	return $vars;
    }
}

/**
* Persistable Object Handler class.  
*
* @author	Taiwen Jiang, derived from Jan Keller Pedersen's class for XOOPS 2.2
*/

class _XoopsPersistableObjectHandler extends icms_core_ObjectHandler {

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
    function __construct(&$db, $table = "", $className = "", $keyName = "", $identifierName = false) {
        parent::__construct($db);
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
        $obj = new $this->className();
        if ($isNew === true) {
            $obj->setNew();
        }
        return $obj;
    }
    
    /**
     * Load a {@link _XoopsPersistableObject} object from the database
     * 
     * @param   mixed	$id     ID
     * @param   array	$tags	variables to fetch
     * @return  object  {@link _XoopsPersistableObject}, a new {@link _XoopsPersistableObject} on fail
     **/
    function &get($id) {
		$tags = null;
		$args = func_get_args();
		if (isset($args[1])) $tags = $args[1];
		
	    if (empty($id)) {
	    	$object = $this->create();
		    return $object;
	    }
	    
	    $ret = null;
	    if (is_array($tags) && count($tags) > 0) {
		    $select = implode(",", $tags);
		    if (!in_array($this->keyName, $tags)){
			    $select .= ", ".$this->keyName;
		    }
	    } else {
		    $select = "*";
	    }
        $sql = "SELECT {$select} FROM {$this->table} WHERE {$this->keyName} = " . $this->db->quoteString($id);
        if (!$result = $this->db->query($sql)) {
            return $ret;
        }
        
        if (!$this->db->getRowsNum($result)) {
	        return $ret;
        }
        
    	$object = $this->create(false);
		$object->assignVars($this->db->fetchArray($result));
        
        return $object;
    }    
    
    /**
     * get objects matching a condition
     * 
     * @param object	$criteria {@link icms_db_criteria_Element} to match
     * @param array		$tags 	variables to fetch
     * @param bool		$asObject 	flag indicating as object, otherwise as array
     * @return array of objects/array {@link _XoopsPersistableObject}
     */
    function &getAll($criteria = null, $tags = null, $asObject = true)
    {
	    if (is_array($tags) && count($tags) > 0) {
		    if (!in_array($this->keyName, $tags)) $tags[] = $this->keyName;
		    $select = implode(",", $tags);
	    }
	    else $select = "*";
	    $limit = null;
	    $start = null;
        $sql = "SELECT $select FROM " . $this->table;
        if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element")) {
            $sql .= " ".$criteria->renderWhere();
            if ($sort = $criteria->getSort()) {
                $sql .= " ORDER BY ".$sort." ".$criteria->getOrder();
                $orderSet = true;
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        if (empty($orderSet)) $sql .= " ORDER BY ".$this->keyName." DESC";
        $result = $this->db->query($sql, $limit, $start);
        $ret = array();
		if ($asObject) {        
	        while ($myrow = $this->db->fetchArray($result)) {
	            $object = $this->create(false);
	            $object->assignVars($myrow);
	            $ret[$myrow[$this->keyName]] = $object;
	            unset($object);
	        }
        } else {
	    	$object = $this->create(false);
	        while ($myrow = $this->db->fetchArray($result)) {
	            $object->assignVars($myrow);
		        $ret[$myrow[$this->keyName]] = $object->getValues(array_keys($myrow));
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
	    /*
	    if (!is_null($conn)) {
		    return mysql_get_server_info($conn);
	    } else {
		    return mysql_get_server_info();
	    }
	    */
	    return "6.0.0";
    }
    
    /**
     * get MySQL major version
     * 
     * @return 	integer	: 3 - 4.1-; 4 - 4.1+; 5 - 5.0+
     */
    function mysql_major_version()
    {
	    $version = $this->mysql_server_version();
	    if (version_compare( $version, "5.0.0", "ge" ) ) $mysql_version = 5;
	    elseif (version_compare( $version, "4.1.0", "ge" ) ) $mysql_version = 4;
	    else $mysql_version = 3;
	    return $mysql_version;
    }
	
	function insert(&$object) {}
	function delete(&$object) {}
}