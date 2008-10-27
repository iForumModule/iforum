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

if(!defined("FRAMEWORKS_ART_FUNCTIONS")):
define("FRAMEWORKS_ART_FUNCTIONS", true);

include_once (dirname(__FILE__)."/functions.ini.php");
// Backward compatibility
@include_once (dirname(__FILE__)."/functions.admin.php");

/**
 * Get client IP
 * 
 * Adapted from PMA_getIp() [phpmyadmin project]
 *
 * @param	bool	$asString	requiring integer or dotted string
 * @return	mixed	string or integer value for the IP
 */
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

function &mod_getUnameFromIds( $uid, $usereal = 0, $linked = false )
{
	if(!is_array($uid))  $uid = array($uid);
	$userid = array_map("intval", array_filter($uid));

	$myts =& MyTextSanitizer::getInstance();
	$users = array();
	if(count($userid)>0){
        $sql = 'SELECT uid, uname, name FROM ' . $GLOBALS['xoopsDB']->prefix('users'). ' WHERE level>0 AND uid IN('.implode(",", array_unique($userid)).')';
        if (!$result = $GLOBALS['xoopsDB']->query($sql)) {
	        xoops_error("user query error: ".$sql);
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
	if(in_array(0, $users)) $users[0] = $myts->htmlSpecialChars($GLOBALS['xoopsConfig']['anonymous']);
    return $users;
}

function mod_getUnameFromId( $userid, $usereal = 0, $linked = false)
{
	$myts =& MyTextSanitizer::getInstance();
	$userid = intval($userid);
	if ($userid > 0) {
        $member_handler =& xoops_gethandler('member');
        $user =& $member_handler->getUser($userid);
        if (is_object($user)) {
		    $myts =& MyTextSanitizer::getInstance();
            if ( $usereal && $user->getVar('name') ) {
				$username = $user->getVar('name');
        	} else {
				$username = $user->getVar('uname');
			}
        }
        if(!empty($linked)){
			$username = '<a href="' . XOOPS_URL . '/userinfo.php?uid='.$userid.'">'.$username.'</a>';
        }
    }
    if(empty($username)){
		$username = $myts->htmlSpecialChars($GLOBALS['xoopsConfig']['anonymous']);
    }
    return $username;
}

function mod_createCacheFile($data, $name = null, $dirname = null)
{
    global $xoopsModule;

    $name = ($name)?$name:strval(time());
    $dirname = ($dirname)?$dirname:(is_object($xoopsModule)?$xoopsModule->getVar("dirname"):"system");

	$file_name = $dirname."_".$name.".php";
	$file = XOOPS_CACHE_PATH."/".$file_name;
	if ( $fp = fopen( $file , "wt" ) ) {
		fwrite( $fp, "<?php\nreturn " . var_export( $data, true ) . ";\n?>" );
		fclose( $fp );
	} else {
		xoops_error( "Cannot create cache file: ".$file_name );
	}
    return $file_name;
}

function &mod_loadCacheFile($name, $dirname = null)
{
    global $xoopsModule;

    $data = null;
    
    if(empty($name)) return $data;
    $dirname = ($dirname)?$dirname:(is_object($xoopsModule)?$xoopsModule->getVar("dirname"):"system");
	$file_name = $dirname."_".$name.".php";
	$file = XOOPS_CACHE_PATH."/".$file_name;
	
	$data = @include $file;
	return $data;
}

endif;
?>