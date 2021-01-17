<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright  http://www.xoops.org/ The XOOPS Project
* @copyright  http://xoopsforge.com The XOOPS FORGE Project
* @copyright  http://xoops.org.cn The XOOPS CHINESE Project
* @copyright  XOOPS_copyrights.txt
* @copyright  readme.txt
* @copyright  http://www.impresscms.org/ The ImpressCMS Project
* @license   GNU General Public License (GPL)
*     a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package  CBB - XOOPS Community Bulletin Board
* @since   3.08
* @author  phppp
* ----------------------------------------------------------------------------------------------------------
*     iForum - a bulletin Board (Forum) for ImpressCMS
* @since   1.00
* @author  modified by stranger
* @version  $Id$
*/
 
include "../../../include/cp_header.php";
include_once ICMS_ROOT_PATH."/modules/".$icmsModule->getVar("dirname")."/include/vars.php";
include_once ICMS_ROOT_PATH."/modules/".$icmsModule->getVar("dirname")."/class/art/functions.php";
include_once ICMS_ROOT_PATH."/modules/".$icmsModule->getVar("dirname")."/class/art/functions.admin.php";
 
 
// include the default language file for the admin interface
if (!@include_once(ICMS_ROOT_PATH."/modules/".$icmsModule->getVar("dirname")."/language/" . $icmsConfig['language'] . "/main.php"))
	{
	include_once(ICMS_ROOT_PATH."/modules/".$icmsModule->getVar("dirname")."/language/english/main.php");
}
 
 
$myts =MyTextSanitizer::getInstance();
 
?>