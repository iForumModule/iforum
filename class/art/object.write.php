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
* Object write handler class.  
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2000 The XOOPS Project
*
* {@link _XoopsPersistableObjectHandler} 
*
*/

class ArtObjectWriteHandler
{
    /**#@+
     *
     * @var object
     */
    var $_handler;
    
    function ArtObjectWriteHandler(&$handler) {
	    $this->_handler =& $handler; 
    }

    function &cleanVars(&$object)
    {
	    $object->cleanVars();
	    $changedVars = array();
        $ts =& MyTextSanitizer::getInstance();
        foreach ($object->vars as $k => $v) {
	        if(!$v["changed"]) continue;
            $cleanv = $object->cleanVars[$k];
            switch ($v["data_type"]) {
                case XOBJ_DTYPE_TXTAREA:
                    if ( !$v['not_gpc'] && !empty($object->vars['dohtml']['value']) ){
	                    load_functions("sanitizer");
                        $cleanv = text_filter($cleanv);
                    }
                case XOBJ_DTYPE_TXTBOX:
                case XOBJ_DTYPE_SOURCE:
                case XOBJ_DTYPE_URL:
                case XOBJ_DTYPE_EMAIL:
                case XOBJ_DTYPE_OTHER:
                    $cleanv = $this->_handler->db->quoteString($cleanv);
                    break;
                case XOBJ_DTYPE_INT:
                	break;
                case XOBJ_DTYPE_ARRAY:
                	$cleanv = $v['value'];
                    if ( !$v['not_gpc'] ){
	                    $cleanv = array_map(array(&$ts, "stripSlashesGPC"), $cleanv);
                    }
                    foreach (array_keys($cleanv) as $key) {
	                    $cleanv[$key] = str_replace('\\"', '"', addslashes($cleanv[$key]));
                    }
 	                $cleanv = "'".serialize($cleanv)."'";
                    break;
                case XOBJ_DTYPE_STIME:
                case XOBJ_DTYPE_MTIME:
                case XOBJ_DTYPE_LTIME:
                default:
                   break;
            }
        	$changedVars[$k] = $cleanv;
            unset($cleanv);
        }

        return $changedVars;
    }
    
    /**
     * insert an object into the database
     * 
     * @param	object	$object 	{@link ArtObject} reference to ArtObject
     * @param 	bool 	$force 		flag to force the query execution despite security settings
     * @return 	int 	object ID
     */
    function insert(&$object, $force = true)
    {
        if (!$object->isDirty()) {
	        $object->setErrors("not isDirty");
	        return $object->getVar($this->_handler->keyName);
        }
        if (!$changedVars = $this->cleanVars($object)) {
	        $object->setErrors("cleanVars failed");
	        return $object->getVar($this->_handler->keyName);
        }
        $queryFunc = empty($force) ? "query" : "queryF";
        
        if ($object->isNew()) {
	        $keys = array_keys($changedVars);
	        $vals = array_values($changedVars);
            $sql = "INSERT INTO " . $this->_handler->table . " (".implode(",", $keys).") VALUES (".implode(",", $vals).")";
            if (!$result = $this->_handler->db->{$queryFunc}($sql)) {
                $object->setErrors("Insert object error ($queryFunc):" . $sql);
                return false;
            }
            $object->unsetNew();
	        if(!$object->getVar($this->_handler->keyName) && $object_id = $this->_handler->db->getInsertId()){
	            $object->assignVar($this->_handler->keyName, $object_id);
        	}
        } else {
            $keys = array();
	        foreach ($changedVars as $k => $v) {
	            $keys[] = " {$k} = {$v}";
	        }
            $sql = "UPDATE " . $this->_handler->table . " SET ".implode(",",$keys)." WHERE ".$this->_handler->keyName." = " . $this->_handler->db->quoteString($object->getVar($this->_handler->keyName));
            if (!$result = $this->_handler->db->{$queryFunc}($sql)) {
                $object->setErrors("update object error:" . $sql);
                return false;
            }
        }
        unset($changedVars);
        return $object->getVar($this->_handler->keyName);
    }

    /**
     * delete an object from the database
     * 
     * @param object $obj reference to the object to delete
     * @param bool $force
     * @return bool FALSE if failed.
     */
    function delete(&$obj, $force = false)
    {
        if (is_array($this->_handler->keyName)) {
            $clause = array();
            for ($i = 0; $i < count($this->_handler->keyName); $i++) {
	            $clause[] = $this->_handler->keyName[$i]." = ".$this->_handler->db->quoteString($obj->getVar($this->_handler->keyName[$i]));
            }
            $whereclause = implode(" AND ", $clause);
        }
        else {
            $whereclause = $this->_handler->keyName." = ".$this->_handler->db->quoteString($obj->getVar($this->_handler->keyName));
        }
        $sql = "DELETE FROM ".$this->_handler->table." WHERE ".$whereclause;
        if (false != $force) {
            $result = $this->_handler->db->queryF($sql);
        } else {
            $result = $this->_handler->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * delete all objects meeting the conditions
     * 
     * @param object $criteria {@link CriteriaElement} with conditions to meet
     * @return bool
     */
    function deleteAll($criteria = null, $force = true, $asObject = false)
    {
        if ($asObject) {
	        $objects =& $this->_handler->getAll($criteria);
	        foreach (array_keys($objects) as $key) {
		        $this->delete($objects[$key], $force);
	        }
	        unset($objects);
	        return true;
        }
        $queryFunc = empty($force) ? "query" : "queryF";
        $sql = 'DELETE FROM '.$this->_handler->table;
        if (!empty($criteria)) {
	        if (is_subclass_of($criteria, 'criteriaelement')) {
	            $sql .= ' '.$criteria->renderWhere();
            } else {
	            return false; 
            }
        }
        if (!$this->_handler->db->{$queryFunc}($sql)) {
            return false;
        }
        $rows = $this->_handler->db->getAffectedRows();
        return $rows > 0 ? $rows : true;
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
    	$set_clause = $fieldname . ' = ';
    	if ( is_numeric( $fieldvalue ) ) {
    		$set_clause .=  $fieldvalue;
    	} elseif ( is_array( $fieldvalue ) ) {
    		$set_clause .= $this->_handler->db->quoteString( implode( ',', $fieldvalue ) );
    	} else {
    		$set_clause .= $this->_handler->db->quoteString( $fieldvalue );
    	}
        $sql = 'UPDATE '.$this->_handler->table.' SET '.$set_clause;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (false != $force) {
            $result = $this->_handler->db->queryF($sql);
        } else {
            $result = $this->_handler->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        return true;
    }
}
?>