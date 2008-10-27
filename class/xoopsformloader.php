<?php
// $Id: xoopsformloader.php,v 1.8.22.1.2.4 2005/07/14 16:13:30 phppp Exp $
if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

if(!@include_once XOOPS_ROOT_PATH."/Frameworks/xoops22/class/xoopsformloader.php"){
	include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
}
?>