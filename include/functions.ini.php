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
//  Author: phppp (D.J., infomax@gmail.com)                                  //
//  URL: http://xoopsforge.com, http://xoops.org.cn                          //
//  Project: Article Project                                                 //
//  ------------------------------------------------------------------------ //
if (!defined('XOOPS_ROOT_PATH')){ exit(); }

if(defined("NEWBB_FUNCTIONS_INI")) return; define("NEWBB_FUNCTIONS_INI",1);

include_once(XOOPS_ROOT_PATH."/modules/".basename(  dirname(  dirname( __FILE__ ) ) )."/class/art/functions.php");

function newbb_load_object()
{
	return load_object();
}

function newbb_message( $message )
{
	global $xoopsModuleConfig;
	if(!empty($xoopsModuleConfig["do_debug"])){
		if(is_array($message) || is_object($message)){
			echo "<div><pre>";print_r($message);echo "</pre></div>";
		}else{
			echo "<div>$message</div>";
		}
	}
	return;
}

function &newbb_load_config()
{
	static $moduleConfig;
	if(isset($moduleConfig)){
		return $moduleConfig;
	}
	
    if(isset($GLOBALS["xoopsModule"]) && is_object($GLOBALS["xoopsModule"]) && $GLOBALS["xoopsModule"]->getVar("dirname", "n") == "newbb"){
	    if(!empty($GLOBALS["xoopsModuleConfig"])) {
		    $moduleConfig =& $GLOBALS["xoopsModuleConfig"];
	    }else{
		    return null;
	    }
    }else{
		$module_handler = &xoops_gethandler('module');
		$module = $module_handler->getByDirname("newbb");
	
	    $config_handler = &xoops_gethandler('config');
	    $criteria = new CriteriaCompo(new Criteria('conf_modid', $module->getVar('mid')));
	    $configs =& $config_handler->getConfigs($criteria);
	    foreach(array_keys($configs) as $i){
		    $moduleConfig[$configs[$i]->getVar('conf_name')] = $configs[$i]->getConfValueForOutput();
	    }
	    unset($configs);
    }
	if($customConfig = @include(XOOPS_ROOT_PATH."/modules/newbb/include/plugin.php")){
		$moduleConfig = array_merge($moduleConfig, $customConfig);
	}
    return $moduleConfig;
}

function getConfigForBlock()
{
	return newbb_load_config();
	
	static $newbbConfig;
	if(isset($newbbConfig)){
		return $newbbConfig;
	}
	
    if(is_object($GLOBALS["xoopsModule"]) && $GLOBALS["xoopsModule"]->getVar("dirname") == "newbb"){
	    $newbbConfig =& $GLOBALS["xoopsModuleConfig"];
    }else{
		$module_handler =& xoops_gethandler('module');
		$newbb = $module_handler->getByDirname('newbb');
	
	    $config_handler =& xoops_gethandler('config');
	    $criteria = new CriteriaCompo(new Criteria('conf_modid', $newbb->getVar('mid')));
	    $criteria->add(new Criteria('conf_name', "('show_realname', 'subject_prefix', 'allow_require_reply')", "IN"));
	    $configs =& $config_handler->getConfigs($criteria);
	    foreach(array_keys($configs) as $i){
		    $newbbConfig[$configs[$i]->getVar('conf_name')] = $configs[$i]->getConfValueForOutput();
	    }
	    unset($newbb, $configs);
    }
    return $newbbConfig;
}


// Backword compatible
function newbb_load_lang_file( $filename, $module = '', $default = 'english' )
{
	if(function_exists("xoops_load_lang_file")){
		return xoops_load_lang_file($filename, $module, $default);
	}
	
	$lang = $GLOBALS['xoopsConfig']['language'];
	$path = XOOPS_ROOT_PATH . ( empty($module) ? '/' : "/modules/$module/" ) . 'language';
	if ( !( $ret = @include_once( "$path/$lang/$filename.php" ) ) ) {
		$ret = @include_once( "$path/$default/$filename.php" );
	}
	return $ret;
}

// Adapted from PMA_getIp() [phpmyadmin project]
function newbb_getIP($asString = false)
{
	return mod_getIP($asString);
}

function newbb_formatTimestamp($time, $format = "c", $timeoffset = "")
{
	if(strtolower($format) == "reg" || strtolower($format) == "") {
		$format = "c";
	}
	if( (strtolower($format) == "custom" || strtolower($format) == "c") && !empty($GLOBALS["xoopsModuleConfig"]["formatTimestamp_custom"]) ) {
		$format = $GLOBALS["xoopsModuleConfig"]["formatTimestamp_custom"];
	}
	
	load_functions("locale");
	return XoopsLocal::formatTimestamp($time, $format, $timeoffset);
	
	if(class_exists("XoopsLocal") && is_callable(array("XoopsLocal", "formatTimestamp")) && defined("_TODAY")){
		return XoopsLocal::formatTimestamp($time, $format, $timeoffset);
	}
	
    global $xoopsConfig, $xoopsUser;
    if(strtolower($format) == "rss" || strtolower($format) == "r"){
    	$TIME_ZONE = "";
    	if(!empty($GLOBALS['xoopsConfig']['server_TZ'])){
			$server_TZ = abs(intval($GLOBALS['xoopsConfig']['server_TZ']*3600.0));
			$prefix = ($GLOBALS['xoopsConfig']['server_TZ']<0)?" -":" +";
			$TIME_ZONE = $prefix.date("Hi",$server_TZ);
		}
		$date = gmdate("D, d M Y H:i:s", intval($time)).$TIME_ZONE;
		return $date;
	}
	
    $usertimestamp = xoops_getUserTimestamp($time, $timeoffset);
    switch (strtolower($format)) {
    case 's':
        $datestring = _SHORTDATESTRING;
        break;
    case 'm':
        $datestring = _MEDIUMDATESTRING;
        break;
    case 'mysql':
        $datestring = "Y-m-d H:i:s";
        break;
    case 'rss':
    	$datestring = "r";
        break;
    case 'l':
        $datestring = _DATESTRING;
        break;
    case 'c':
    case 'custom':
    default:
    	newbb_load_lang_file("main", "newbb");
        $current_timestamp = xoops_getUserTimestamp(time(), $timeoffset);
        if(date("Ymd", $usertimestamp) == date("Ymd", $current_timestamp)){
			$datestring = _MD_TODAY;
		}elseif(date("Ymd", $usertimestamp+24*60*60) == date("Ymd", $current_timestamp)){
			$datestring = _MD_YESTERDAY;
		}elseif(date("Y", $usertimestamp) == date("Y", $current_timestamp)){
			$datestring = _MD_MONTHDAY;
		}else{
			$datestring = _MD_YEARMONTHDAY;
		}
        break;
    }

    return date($datestring, $usertimestamp);
}
?>