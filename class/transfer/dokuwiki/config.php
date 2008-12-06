<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		http://xoopsforge.com The XOOPS FORGE Project
* @copyright		http://xoops.org.cn The XOOPS CHINESE Project
* @copyright		XOOPS_copyrights.txt
* @copyright		readme.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license			GNU General Public License (GPL)
*					a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		CBB - XOOPS Community Bulletin Board
* @since			3.08
* @author		phppp
* ----------------------------------------------------------------------------------------------------------
* 				iForum - a bulletin Board (Forum) for ImpressCMS
* @since			1.00
* @author		modified by stranger
* @version		$Id$
*/

/**
 * Transfer::iforum config
 *
 * @author	    phppp, http://xoops.org.cn
 * @copyright	copyright (c) 2005 XOOPSForge.com
 * @package		module::article
 *
 */
//global $xoopsConfig, $xoopsModule;

$current_path = __FILE__;
if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
$root_path = dirname($current_path);

$xoopsConfig['language'] = preg_replace("/[^a-z0-9_\-]/i", "", $xoopsConfig['language']);
if(!@include_once($root_path."/language/".$xoopsConfig['language'].".php")){
	include_once($root_path."/language/english.php");
}

return $config = array(
		"title"		=>	_MD_TRANSFER_DOKUWIKI,
		"module"	=>	"dokuwiki",
		"level"		=>	1,	/* 0 - hidden (For direct call only); 1 - display (available for selection) */
		"namespace"	=>	"transfer",
		"namespace_skip"	=>	array("discussion"),
		"prefix"	=>	$xoopsModule->getVar("dirname")
	);
?>