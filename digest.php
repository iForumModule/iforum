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
 
// Why the skip-DB-security check defined only for XMLRPC? We also need it!!! ~_*
if (!defined('XOOPS_XMLRPC')) define('XOOPS_XMLRPC', 1);
	ob_start();
include_once("header.php");
if (icms::$module->config['email_digest'] == 0)
{
	echo "<br />Not set";
	return false;
}
$digest_handler = icms_getmodulehandler('digest', basename(__DIR__), 'iforum' );
$msg = $digest_handler->process();
$msg .= ob_get_contents();
ob_end_clean();
echo "<br />".$msg;