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
	if (empty($dirname) && empty($GLOBALS["icmsModule"])) {
		return null;
	}
	$dirname = !empty($dirname) ? $dirname : $GLOBALS["icmsModule"]->getVar("dirname");
	
    if (isset($GLOBALS["icmsModule"]) && is_object($GLOBALS["icmsModule"]) && $GLOBALS["icmsModule"]->getVar("dirname", "n") == $dirname){
	    if (isset($GLOBALS["icmsModuleConfig"])) {
		    $moduleConfig =& $GLOBALS["icmsModuleConfig"];
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
	
	$module_handler = icms::handler('icms_module');
	$module = $module_handler->getByDirname($dirname);

    $criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item('conf_modid', $module->getVar('mid')));
    $configs = icms::$config->getConfigs($criteria);
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