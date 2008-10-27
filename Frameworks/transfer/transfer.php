<?php
/**
 * Transfer handler for XOOPS
 *
 * This is intended to handle content intercommunication between modules as well as components
 * There might need to be a more explicit name for the handle since it is always confusing
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		3.00
 * @version		$Id$
 * @package		Frameworks::transfer
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}
define("TRANSFER_ROOT_PATH", dirname(__FILE__));
defined("FRAMEWORKS_ART_FUNCTIONS_INI") || require_once(XOOPS_ROOT_PATH."/Frameworks/art/functions.ini.php");

function transfer_load_language($path, $language, $charset)
{
	if ( DIRECTORY_SEPARATOR != "/" ) $path = str_replace( strpos( $path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $path);
	if (@include_once($path.'/'.$language.'.php')) {
		return true;
	}
	$file = $path.'/'.strtolower($language.'_'.str_replace('-', '', $charset)).'.php';
	if (@include_once($file)) {
		return true;
	}
	if (@include_once($path.'/'.$language.'.php')) {
		return true;
	}
	if (@include_once($path.'/english.php')) {
		return true;
	}
	xoops_error("No Language File: {$path} - {$language} - {$charset}");
	return false;
}

if (!class_exists("Transfer")):
class Transfer
{
	var $name;
	var $config;
	
    function Transfer($item, $language = null)
    {
	    $this->name = strtolower( empty($item) ? get_class($this) : $item );
		$this->load_language($this->name, $language);
		$this->config = require TRANSFER_ROOT_PATH."/plugin/".$this->name."/config.php";
    }
    
    /**
     * Load language
     * 
     * <ul>Priority or language file name:
     *		<li>language with charset</li>
     *		<li>language</li>
     *		<li>english</li>
     * </ul>
     *
     * @param	string	$language
     * @param	string	$charset
     * @param	string	$path
     * return
     */
    function load_language($item = null, $language = "", $path = "", $charset = _CHARSET)
    {
	    $item = strtolower( empty($item) ? get_class($this) : $item );
	    
		$path = empty($path) ? TRANSFER_ROOT_PATH."/plugin/{$item}/language" : $path;
		
		$language = empty($language) ? $GLOBALS["xoopsConfig"]["language"] : $language;
		$language = preg_replace("/[^a-z0-9_\-]/i", "", $language);
		
		transfer_load_language($path, $language, $charset);
    }

    /**
     * Transfer content of an item in a module to another module or external application
     *
     * return	mixed
     */
    function do_transfer()
    {
	    return $global_string = '
			global $xoopsModule, $xoopsConfig, $xoopsUser, $xoopsModuleConfig;
			global $xoopsLogger, $xoopsOption, $xoopsTpl, $xoopsblock;
			';
    }
}
endif;

if (!class_exists("TransferHandler")):
class TransferHandler
{
	var $root_path;
	var $item;
	
    function TransferHandler($language = null)
    {
		$current_path = TRANSFER_ROOT_PATH;
		if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
		$this->root_path = $current_path."/plugin";
		$this->load_language($language);
    }
    
    /**
     * Load language
     * 
     * <ul>Priority or language file name:
     *		<li>language with charset</li>
     *		<li>language</li>
     *		<li>english</li>
     * </ul>
     *
     * @param	string	$language
     * @param	string	$charset
     * @param	string	$path
     * return
     */
    function load_language($language = "", $charset = _CHARSET, $path = "")
    {
		$path = empty($path) ? TRANSFER_ROOT_PATH."/language" : $path;
		
		$language = empty($language) ? $GLOBALS["xoopsConfig"]["language"] : $language;
		$language = preg_replace("/[^a-z0-9_\-]/i", "", $language);
		
		transfer_load_language($path, $language, $charset);
    }
    
    /**
     * Get valid addon list
     * 
     * @param	array	$skip	Addons to skip
     * @param	boolean	$sort	To sort the list upon 'level'
     * return	array	$list
     */
    function &getList($skip = array(), $sort = true)
    {
	    if (!empty($GLOBALS["addons_skip_module"]) && is_array($GLOBALS["addons_skip_module"])) {
		    $skip = array_merge($skip, $GLOBALS["addons_skip_module"]);
	    }
		$mod_dirname = is_object($GLOBALS["xoopsModule"]) ? $GLOBALS["xoopsModule"]->getVar("dirname") : "system";
		
		// Load the cache
		if (function_exists("mod_loadCacheFile") && $list = mod_loadCacheFile("{$mod_dirname}_".intval($sort), "transfer")) {
			return $list;
		}
	    
	    // All addon list
	    require_once XOOPS_ROOT_PATH."/class/xoopslists.php";
		$list_addon = XoopsLists::getDirListAsArray($this->root_path."/");
		// List for addons belonging to a module
		$list_module = array();

		$list_sort = array();
		// All active addons
		foreach ($list_addon as $item) {
			Transfer::load_language($item);
			if (@include_once($this->root_path."/".$item."/config.php")) {
				if (empty($config["level"])) continue;
				if (!empty($skip) && in_array($item, $skip)) continue;
				if (!empty($config["module"])) {
					if ($config["module"] == $mod_dirname) continue;
					$list_module[] = htmlspecialchars($config["module"]);
				}
				$list[$item] = array(
									"title"	=> $config["title"], 
									"desc"	=> $config["desc"], 
									"level"	=> $config["level"]
									);
				$list_sort[$item] = $config["level"];
				unset($config);
			}
		}
		
		// Escape invalid addons belonging to a module 
		if (!empty($list_module)) {
	    	$module_handler =& xoops_gethandler("module");
			$module_invalid = array_diff( $list_module, array_keys( $module_handler->getList(new Criteria("isactive", 1), true) ) );
			
			foreach ($module_invalid as $key) {
				unset($list[$key]);
				unset($list_sort[$key]);
			}
		}
		
		// Sort the list if requried
		if (!empty($sort)) {
			$list_sort = array_values($list_sort);
			array_multisort($list, SORT_STRING,
			               $list_sort, SORT_NUMERIC, SORT_DESC);
		}
		unset($list_addon, $list_sort, $list_module);
		
		// Generate the cache
		if (function_exists("mod_createCacheFile")) {
			mod_createCacheFile($list, "{$mod_dirname}_".intval($sort), "transfer");
		}
		
		return $list;
    }
    
    function load_item($item)
    {
	    $item = preg_replace("/[^a-z0-9_\-]/i", "", $item);
		if (!include_once($this->root_path."/".$item."/index.php")) return false;
		$class = "transfer_".$item;
		$this->item =& new $class();
		if (!is_object($this->item)) {
			xoops_error("item not available: $item");
			exit();
		}
		return true;
    }

    /**
     * Transfer content of an item in a module to another module or external application
     *
     * @param	string	$item	name of the script for the transfer
     * @param	array	$data	associative array of title, uid, body, source (url of the article) and extra tags
     * return	mixed
     */
    function do_transfer($item, &$data)
    {
	    if (!$this->load_item($item)) return false;
		return $this->item->do_transfer($data);
    }
}
endif;
?>