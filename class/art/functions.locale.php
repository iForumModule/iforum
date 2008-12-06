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
if (!defined("FRAMEWORKS_ART_FUNCTIONS_LOCALE")):
define("FRAMEWORKS_ART_FUNCTIONS_LOCALE", true);

defined("FRAMEWORKS_ART_FUNCTIONS_INI") || require_once (dirname(__FILE__)."/functions.ini.php");

// backward compatible
if (!function_exists("xoops_local")):
// calling XoopsLocal::{$func}()
function xoops_local($func)
{
	// get parameters
	$func_args = func_get_args();
	$func = array_shift($func_args);
	// local method defined
	if (is_callable(array("XoopsLocal", $func))) {
		return call_user_func_array(array("XoopsLocal", $func), $func_args);
	}
	// php function defined
	if (function_exists($func)) {
		return call_user_func_array($func, $func_args);
	}
	// nothing
	return null;
}
endif;
if (!class_exists("XoopsLocal")) {
	$GLOBALS["xoopsConfig"]["language"] = preg_replace("/[^a-z0-9_\-]/i", "", $GLOBALS["xoopsConfig"]["language"]);
	if (!@include_once ICMS_ROOT_PATH."/modules/".basename( dirname(  dirname(  dirname( __FILE__ ) ) ) )."/language/".$GLOBALS["xoopsConfig"]["language"]."/local.php") {
		require_once ICMS_ROOT_PATH."/modules/".basename( dirname(  dirname(  dirname( __FILE__ ) ) ) )."/language/english/local.php";
	}
} else {
	$methods = get_class_methods("XoopsLocal");
	if (!in_array("getTimeFormatDesc", $methods) && !in_array("gettimeformatdesc", $methods)) {
		$msg = "<strong>The locale version is too old.</strong> Please copy <br />XOOPS/Frameworks/compat/language/english/<strong>local.php, local.class.php</strong> to XOOPS/language/english/";
		if ($GLOBALS["xoopsConfig"]["language"] != "english") {
			if (is_dir(ICMS_ROOT_PATH."/Frameworks/compat/language/".$GLOBALS["xoopsConfig"]["language"]."/")) {
				$msg .= "<br />XOOPS/Frameworks/compat/language/".$GLOBALS["xoopsConfig"]["language"]."/<strong>local.php</strong> to XOOPS/language/".$GLOBALS["xoopsConfig"]["language"]."/";
			} else {
				$msg .= "<br />And modify XOOPS/language/".$GLOBALS["xoopsConfig"]["language"]."/<strong>local.php</strong> according to XOOPS/language/english/local.php";
			}
		}
		xoops_error($msg);
		die();
	}
}

endif;
?>