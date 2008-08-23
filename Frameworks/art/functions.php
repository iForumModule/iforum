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
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

if(!defined("FRAMEWORKS_ART_FUNCTIONS")){
	define("FRAMEWORKS_ART_FUNCTIONS", true);
}

if(!class_exists("XoopsLocal")){
	$GLOBALS["xoopsConfig"]["language"] = preg_replace("/[^a-z0-9_\-]/i", "", $GLOBALS["xoopsConfig"]["language"]);
	if(!@include_once (dirname(dirname(__FILE__))."/xoops22/language/".$GLOBALS["xoopsConfig"]["language"]."/local.php")){
		@include_once (dirname(dirname(__FILE__))."/xoops22/language/english/local.php");
	}
}

function loadModuleAdminMenu ($currentoption = -1, $breadcrumb="")
{
	// For XOOPS 2.2*
	if(isset($GLOBALS["xTheme"]) && method_exists($GLOBALS["xTheme"], "loadModuleAdminMenu")){
		$GLOBALS["xTheme"]->loadModuleAdminMenu($currentoption, $breadcrumb);
	// For XOOPS 2.0*, 2.3*
	}else{
		echo _loadModuleAdminMenu($currentoption, $breadcrumb);
	}
	return true;
}

function _loadModuleAdminMenu($currentoption, $breadcrumb="")
{
	$adminmenu = array();
	
	if(!@include XOOPS_ROOT_PATH."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/".$GLOBALS["xoopsModule"]->getInfo("adminmenu")){
		return null;
	}
	$module_link = XOOPS_URL."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/";
	$image_link = XOOPS_URL."/Frameworks/xoops22/include";
	
	$adminmenu_text ='
	<style type="text/css">
	<!--
	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0;}
	#buttonbar { float:left; width:100%; background: #e7e7e7 url("'.$image_link.'/modadminbg.gif") repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px;}
	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
	#buttonbar li { display:inline; margin:0; padding:0; }
	#buttonbar a { float:left; background:url("'.$image_link.'/left_both.gif") no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
	#buttonbar a span { float:left; display:block; background:url("'.$image_link.'/right_both.gif") no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
	/* Commented Backslash Hack hides rule from IE5-Mac \*/
	#buttonbar a span {float:none;}
	/* End IE5-Mac hack */
	#buttonbar a:hover span { color:#333; }
	#buttonbar .current a { background-position:0 -150px; border-width:0; }
	#buttonbar .current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
	#buttonbar a:hover { background-position:0% -150px; }
	#buttonbar a:hover span { background-position:100% -150px; }	
	//-->
	</style>
	<div id="buttontop">
	 <table style="width: 100%; padding: 0; " cellspacing="0">
	     <tr>
	         <td style="width: 70%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;">
	             <a href="../index.php">'.$GLOBALS["xoopsModule"]->getVar("name").'</a>
	         </td>
	         <td style="width: 30%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;">
	             <b>'.$GLOBALS["xoopsModule"]->getVar("name").'</b>&nbsp;'.$breadcrumb.'
	         </td>
	     </tr>
	 </table>
	</div>
	<div id="buttonbar">
	 <ul>
	';
	foreach(array_keys($adminmenu) as $key){
		$adminmenu_text .= (($currentoption == $key)? '<li class="current">':'<li>').'<a href="'.$module_link.$adminmenu[$key]["link"].'"><span>'.$adminmenu[$key]["title"].'</span></a></li>';
	}
	$adminmenu_text .='
	 </ul>
	</div>
	<br style="clear:both;" />';
	
	return $adminmenu_text;
}

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
	return;
}

// Adapted from PMA_getIp() [phpmyadmin project]
function mod_getIP($asString = false)
{
    // Gets the proxy ip sent by the user
    $proxy_ip     = '';
    if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $proxy_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else if (!empty($_SERVER["HTTP_X_FORWARDED"])) {
        $proxy_ip = $_SERVER["HTTP_X_FORWARDED"];
    } else if (!empty($_SERVER["HTTP_FORWARDED_FOR"])) {
        $proxy_ip = $_SERVER["HTTP_FORWARDED_FOR"];
    } else if (!empty($_SERVER["HTTP_FORWARDED"])) {
        $proxy_ip = $_SERVER["HTTP_FORWARDED"];
    } else if (!empty($_SERVER["HTTP_VIA"])) {
        $proxy_ip = $_SERVER["HTTP_VIA"];
    } else if (!empty($_SERVER["HTTP_X_COMING_FROM"])) {
        $proxy_ip = $_SERVER["HTTP_X_COMING_FROM"];
    } else if (!empty($_SERVER["HTTP_COMING_FROM"])) {
        $proxy_ip = $_SERVER["HTTP_COMING_FROM"];
    }

    if (!empty($proxy_ip) &&
        $is_ip = ereg('^([0-9]{1,3}\.){3,3}[0-9]{1,3}', $proxy_ip, $regs) &&
        count($regs) > 0
  	) {
      	$the_IP = $regs[0];
  	}else{
      	$the_IP = $_SERVER['REMOTE_ADDR'];	      	
  	}
    
  	$the_IP = ($asString)?$the_IP:ip2long($the_IP);
  	
  	return $the_IP;
}

function &mod_getUnameFromIds( $userid, $usereal = 0, $linked = false )
{
    $myts = &MyTextSanitizer::getInstance();
	if(!is_array($userid))  $userid = array($userid);
	$userid = array_map("intval", $userid);

	$users = array();
	if(count($userid)>0){
        $sql = 'SELECT uid, uname, name FROM ' . $GLOBALS['xoopsDB']->prefix('users'). ' WHERE level>0 AND uid IN('.implode(",", array_unique($userid)).')';
        if (!$result = $GLOBALS['xoopsDB']->query($sql)) {
            return $users;
        }
        while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
	        $uid = $row["uid"];
            if ( $usereal && $row["name"] ) {
				$users[$uid] = $myts->htmlSpecialChars($row["name"]);
        	} else {
				$users[$uid] = $myts->htmlSpecialChars($row["uname"]);
			}
			if($linked){
				$users[$uid] = '<a href="' . XOOPS_URL . '/userinfo.php?uid='.$uid.'">'.$users[$uid].'</a>';
			}
        }
	}
    return $users;
}

function mod_getUnameFromId( $userid, $usereal = 0 )
{
	$userid = intval($userid);
	$usereal = intval($usereal);
	if ($userid > 0) {
        $member_handler =& xoops_gethandler('member');
        $user =& $member_handler->getUser($userid);
        if (is_object($user)) {
            $ts =& MyTextSanitizer::getInstance();
            if ( $usereal && $user->getVar('name') ) {
				return $ts->htmlSpecialChars($user->getVar('name'));
        	} else {
				return $ts->htmlSpecialChars($user->getVar('uname'));
			}
        }
    }
    return $GLOBALS['xoopsConfig']['anonymous'];
}
?>