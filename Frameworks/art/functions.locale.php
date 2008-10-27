<?php
/**
 * user/member handlers
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		Frameworks::art
 */
if(!defined("FRAMEWORKS_ART_FUNCTIONS_LOCALE")):
define("FRAMEWORKS_ART_FUNCTIONS_LOCALE", true);

defined("FRAMEWORKS_ART_FUNCTIONS_INI") || include_once (dirname(__FILE__)."/functions.ini.php");

// backward compatible
if(!function_exists("xoops_local")):
// calling XoopsLocal::{$func}()
function xoops_local($func)
{
	// get parameters
	$func_args = func_get_args();
	$func = array_shift($func_args);
	// local method defined
	if(is_callable(array("XoopsLocal", $func))) {
		return call_user_func_array(array("XoopsLocal", $func), $func_args);
	}
	// php function defined
	if(function_exists($func)){
		return call_user_func_array($func, $func_args);
	}
	// nothing
	return null;
}
endif;
if(!class_exists("XoopsLocal")){
	$GLOBALS["xoopsConfig"]["language"] = preg_replace("/[^a-z0-9_\-]/i", "", $GLOBALS["xoopsConfig"]["language"]);
	if(!@include_once (dirname(dirname(__FILE__))."/xoops22/language/".$GLOBALS["xoopsConfig"]["language"]."/local.php")){
		include_once (dirname(dirname(__FILE__))."/xoops22/language/english/local.php");
	}
}

endif;
?>