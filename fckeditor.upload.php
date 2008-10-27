<?php 
/**
 * FCKeditor adapter for XOOPS
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		4.00
 * @version		$Id$
 * @package		xoopseditor
 */
include "header.php";
define("NEWBB_DISABLE_UPLOAD", 0);

if(defined("NEWBB_DISABLE_UPLOAD") && constant("NEWBB_DISABLE_UPLOAD")){
	define("FCKUPLOAD_DISABLED", 1);
}
define("XOOPS_FCK_FOLDER", $xoopsModule->getVar("dirname"));
include XOOPS_ROOT_PATH."/class/xoopseditor/FCKeditor/editor/filemanager/upload/php/upload.php";
?>