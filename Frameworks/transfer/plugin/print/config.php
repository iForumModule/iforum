<?php
/**
 * Transfer config
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		3.00
 * @version		$Id$
 * @package		Frameworks:transfer
 */
/* 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}
global $xoopsConfig;

$xoopsConfig['language'] = preg_replace("/[^a-z0-9_\-]/i", "", $xoopsConfig['language']);
if(!@include_once(dirname(__FILE__)."/language/".$xoopsConfig['language'].".php")){
	include_once(dirname(__FILE__)."/language/english.php");
}
*/
$item_name = strtoupper(basename(dirname(__FILE__)));
return $config = array(
		"title"		=>	CONSTANT("_MD_TRANSFER_{$item_name}"),
		"desc"		=>	CONSTANT("_MD_TRANSFER_{$item_name}_DESC"),
		"level"		=>	5,	/* 0 - hidden (For direct call only); >0 - display (available for selection) */
	);
?>