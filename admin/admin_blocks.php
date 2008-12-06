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

// ------------------------------------------------------------------------- //
// myblocksadmin.php                              //
// - XOOPS block admin for each modules -                     //
// GIJOE <http://www.peak.ne.jp/>                   //
// ------------------------------------------------------------------------- //
include("admin_header.php");
header("Location: ".ICMS_URL."/modules/system/admin.php?fct=blocksadmin&selmod=".$xoopsModule->getVar("mid"));
?>