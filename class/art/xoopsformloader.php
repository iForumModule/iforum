<?php
/**
 * Article management
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		module::article
 */
if (!defined('ICMS_ROOT_PATH')) {
	exit();
}

if(!@include_once ICMS_ROOT_PATH."/modules/".basename( dirname(  dirname(  dirname( __FILE__ ) ) ) )."/class/compat/class/xoopsformloader.php"){
	require_once ICMS_ROOT_PATH."/class/xoopsformloader.php";
}
?>