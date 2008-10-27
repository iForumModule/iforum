<?php
// $Id: functions.php,v 1.3 2005/10/19 17:20:33 phppp Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: phppp (D.J., infomax@gmail.com)                                  //
// URL: http://xoopsforge.com, http://xoops.org.cn                          //
// Project: Article Project                                                 //
// ------------------------------------------------------------------------ //

if(!defined("FRAMEWORKS_ART_FUNCTIONS_INI")):
define("FRAMEWORKS_ART_FUNCTIONS_INI", true);


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


function load_object()
{
	if(class_exists("ArtObject")) return true;
	if(!defined("XOOPS_PATH") || !@include_once(XOOPS_PATH."/Frameworks/art/object.php")){
		include_once(XOOPS_ROOT_PATH."/Frameworks/art/object.php");
	}
	if(class_exists("ArtObject")) return true;
	else return false;
}

/**
 * Get localized string if it is defined 
 *
 * @param	string	$name	string to be localized
 */
if(!function_exists("mod_constant")) {
function mod_constant($name)
{
	if(!empty($GLOBALS["VAR_PREFIXU"]) && @defined($GLOBALS["VAR_PREFIXU"]."_".strtoupper($name))){
		return CONSTANT($GLOBALS["VAR_PREFIXU"]."_".strtoupper($name));
	}elseif(defined(strtoupper($name))){
		return CONSTANT(strtoupper($name));
	}else{
		return str_replace("_", " ", strtolower($name));
	}
}
}

/**
 * Display contents of a variable, an array or an object or an array of objects 
 *
 * @param	mixed	$message	variable/array/object
 */
if(!function_exists("xoops_message")):
function xoops_message( $message, $userlevel = 0)
{
	global $xoopsUser;
	$level = 1;
	if(!$xoopsUser) $level = 0;
	elseif($xoopsUser->isAdmin()) $level = 2;
	if($userlevel > $level) return;
	
	echo "<div style=\"clear:both\"> </div>";
	if(is_array($message) || is_object($message)){
		echo "<div><pre>";print_r($message);echo "</pre></div>";
	}else{
		echo "<div>$message</div>";
	}
	echo "<div style=\"clear:both\"> </div>";
}
endif;
function mod_message( $message )
{
	global $xoopsModuleConfig;
	if(!empty($xoopsModuleConfig["do_debug"])){
		if(is_array($message) || is_object($message)){
			echo "<div><pre>";print_r($message);echo "</pre></div>";
		}else{
			echo "<div>$message</div>";
		}
	}
	return true;
}

/**
 * Get dirname of a module according to current path
 *
 * @param	string	$current_path	path to where the function is called
 * @return	string	$dirname
 */
function mod_getDirname($current_path= null)
{
	if ( DIRECTORY_SEPARATOR != '/' ) $current_path = str_replace( strpos( $current_path, '\\\\', 2 ) ? '\\\\' : DIRECTORY_SEPARATOR, '/', $current_path);
	$url_arr = explode('/',strstr($current_path,'/modules/'));
	return $url_arr[2];
}

/**
 * Is a module being installed or updated
 * Used for setting module configuration default values or options
 *
 * The function should be in functions.admin.php, however it requires extra inclusion in xoops_version.php if so
 *
 * @param	string	$dirname	dirname of current module
 * @return	bool
 */
function mod_isModuleAction($dirname = "system")
{
	$ret = @(
		// action module "system"
		!empty($GLOBALS["xoopsModule"]) && "system" == $GLOBALS["xoopsModule"]->getVar("dirname")
		&&
		// current dirname
		($dirname == $_POST["dirname"] || $dirname == $_POST["module"])
		&&
		// current op 
		("update_ok" == $_POST["op"] || "install_ok" == $_POST["op"])
		&&
		// current action
		"modulesadmin" == $_POST["fct"]
		);
	return $ret;
}

endif;
?>