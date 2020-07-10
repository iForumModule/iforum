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
 
include_once '../../mainfile.php';
include_once ICMS_ROOT_PATH."/modules/".$icmsModule->getVar("dirname")."/include/vars.php";
include_once ICMS_ROOT_PATH."/modules/".$icmsModule->getVar("dirname")."/include/functions.php";
include_once ICMS_ROOT_PATH."/modules/".$icmsModule->getVar("dirname")."/class/art/functions.php";
 
$myts = MyTextSanitizer::getInstance();
 
$iforum_module_header = '';
$iforum_module_header .= '<link rel="alternate" type="application/rss+xml" title="'.$icmsModule->getVar('name').'" href="'.ICMS_URL.'/modules/'.$icmsModule->getVar('dirname').'/rss.php" />';
if (!empty(icms::$module->config['pngforie_enabled']))
{
	$iforum_module_header .= '<style type="text/css">img {behavior:url("include/pngbehavior.htc");}</style>';
}
$iforum_module_header .= '
	<link rel="stylesheet" type="text/css" href="templates/iforum'.((defined("_ADM_USE_RTL") && _ADM_USE_RTL )?'_rtl':
'').'.css" />
	<script type="text/javascript">var toggle_cookie="'.$forumCookie['prefix'].'G'.'";</script>
	<script src="include/js/iforum_toggle.js" type="text/javascript"></script>
	';
$icms_module_header = $iforum_module_header; // for cache hack
 
iforum_welcome();