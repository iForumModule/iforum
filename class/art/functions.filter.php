<?php
/**
 * Filter handler
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		Frameworks::art
 */

if (!defined("FRAMEWORKS_ART_FUNCTIONS_FILTER")):
define("FRAMEWORKS_ART_FUNCTIONS_FILTER", true);

/**
 * load all local filters for an object
 * 
 * Filter distribution:
 * In each module folder there is a folder "filter" containing filter files with, 
 * filename: [name of target class][.][function/action name][.php];
 * function name: [name of target class][_][function/action name];
 * parameter: the target object
 *
 * @param   string     $object	class name or object
 * @param   string     $method	function or action name
 * @access public
 */
function mod_loadFilters(&$object, $method)
{
	load_functions("cache");
    if (!$modules_active = mod_loadCacheFile("modules_active", "system")) {
	    $module_handler = icms::handler('icms_module');
	    $modules_obj = $module_handler->getObjects(new icms_db_criteria_Item('isactive', 1));
	    $modules_active = array();
	    foreach (array_keys($modules_obj) as $key) {
		    $modules_active[] = $modules_obj[$key]->getVar("dirname");
	    }
	    unset($modules_obj);
	    mod_createCacheFile($modules_active, "modules_active", "system");
    }
    $class = is_object($object) ? get_class($object) : $object;
    foreach ($modules_active as $f) {
        if (!@include_once ICMS_ROOT_PATH."/modules/{$f}/filter/{$class}.{$method}.php") continue;
        if (function_exists("{$class}_{$method}")) call_user_func_array("{$class}_{$method}", array(&$object));
    }
}
    
endif;