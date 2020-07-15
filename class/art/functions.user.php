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
if (!defined("FRAMEWORKS_ART_FUNCTIONS_USER")):
define("FRAMEWORKS_ART_FUNCTIONS_USER", true);

defined("FRAMEWORKS_ART_FUNCTIONS_INI") || include_once (dirname(__FILE__)."/functions.ini.php");


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
    
  	$the_IP = ($asString) ? $the_IP : ip2long($the_IP);
  	
  	//return $the_IP;
	return ip2long('1.1.1.1');
}

function &mod_getUnameFromIds( $uid, $usereal = false, $linked = false )
{
	if (!is_array($uid))  $uid = array($uid);
	$userid = array_map("intval", array_filter($uid));

	$myts = icms_core_Textsanitizer::getInstance();
	$users = array();
	if (count($userid) > 0) {
        $sql = 'SELECT uid, uname, name FROM ' . $GLOBALS['xoopsDB']->prefix('users'). ' WHERE level>0 AND uid IN('.implode(",", array_unique($userid)).')';
        if (!$result = $GLOBALS['xoopsDB']->query($sql)) {
	        //icms_core_Message::error("user query error: ".$sql);
            return $users;
        }
        while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
	        $uid = $row["uid"];
            if ( $usereal && $row["name"] ) {
				$users[$uid] = icms_core_DataFilter::htmlSpecialchars($row["name"]);
        	} else {
				$users[$uid] = icms_core_DataFilter::htmlSpecialchars($row["uname"]);
			}
			if ($linked){
				$users[$uid] = '<a href="' . ICMS_URL . '/userinfo.php?uid='.$uid.'" title="'.$users[$uid].'">'.$users[$uid].'</a>';
			}
        }
	}
	if (in_array(0, $users, true)) {
		$users[0] = icms_core_DataFilter::htmlSpecialchars($GLOBALS['icmsConfig']['anonymous']);
	}
    return $users;
}

function mod_getUnameFromId( $userid, $usereal = 0, $linked = false)
{
	$myts = icms_core_Textsanitizer::getInstance();
	$userid = intval($userid);
	if ($userid > 0) {
        $member_handler = icms::handler('icms_member');
        $user = $member_handler->getUser($userid);
        if (is_object($user)) {
            if ( $usereal && $user->getVar('name') ) {
				$username = $user->getVar('name');
        	} else {
				$username = $user->getVar('uname');
			}
	        if (!empty($linked)){
				$username = '<a href="' . ICMS_URL . '/userinfo.php?uid='.$userid.'" title="'.$username.'">'.$username.'</a>';
	        }
        }
    }
    if (empty($username)){
		$username = icms_core_DataFilter::htmlSpecialchars($GLOBALS['icmsConfig']['anonymous']);
    }
    return $username;
}

endif;
?>
