<?php
/**
 * Functions handling module configs
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		Frameworks::art
 */

if(!defined("FRAMEWORKS_ART_FUNCTIONS_CONFIG")):
define("FRAMEWORKS_ART_FUNCTIONS_CONFIG", true);

/**
 * Load configs of a module
 *
 *
 * @param	string	$dirname	module dirname
 * @return	array
 */
function mod_loadConfig($dirname = "")
{
	if (empty($dirname) && empty($GLOBALS["xoopsModule"])) {
		return null;
	}
	$dirname = !empty($dirname) ? $dirname : $GLOBALS["xoopsModule"]->getVar("dirname");
	
    if (isset($GLOBALS["xoopsModule"]) && is_object($GLOBALS["xoopsModule"]) && $GLOBALS["xoopsModule"]->getVar("dirname", "n") == $dirname){
	    if (isset($GLOBALS["xoopsModuleConfig"])) {
		    $moduleConfig =& $GLOBALS["xoopsModuleConfig"];
	    } else {
		    return null;
	    }
    } else {
	    load_functions("cache");
	    if (!$moduleConfig = mod_loadCacheFile("config", $dirname)) {
		    $moduleConfig = mod_fetchConfig($dirname);
		    mod_createCacheFile($moduleConfig, "config", $dirname);
	    }
    }
	if ($customConfig = @include(ICMS_ROOT_PATH."/modules/{$dirname}/include/plugin.php")){
		$moduleConfig = array_merge($moduleConfig, $customConfig);
	}
    return $moduleConfig;
}

function mod_loadConfg($dirname = "") 
{
	return mod_loadConfig($dirname);
}

/**
 * Fetch configs of a module from database
 *
 *
 * @param	string	$dirname	module dirname
 * @return	array
 */
function mod_fetchConfig($dirname = "")
{
	if(empty($dirname)) {
		return null;
	}
	
	$module_handler =& xoops_gethandler('module');
	$module = $module_handler->getByDirname($dirname);

    $config_handler =& xoops_gethandler('config');
    $criteria = new CriteriaCompo(new Criteria('conf_modid', $module->getVar('mid')));
    $configs = $config_handler->getConfigs($criteria);
    foreach(array_keys($configs) as $i){
	    $moduleConfig[$configs[$i]->getVar('conf_name')] = $configs[$i]->getConfValueForOutput();
    }
    unset($module, $configs);
    
    return $moduleConfig;
}

function mod_fetchConfg($dirname = "")
{
	return mod_fetchConfig($dirname);
}

/**
 * clear config cache of a module
 *
 *
 * @param	string	$dirname	module dirname
 * @return	bool
 */
function mod_clearConfig($dirname = "")
{
	if(empty($dirname)) {
		return false;
	}
	
	load_functions("cache");
	return mod_clearCacheFile("config", $dirname); 
}

function mod_clearConfg($dirname = "")
{
	return mod_clearConfig($dirname);
}

endif;
?>