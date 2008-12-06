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

if (!defined('ICMS_ROOT_PATH')) {
	exit();
}

include_once ICMS_ROOT_PATH."/class/xoopsform/formelement.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/form.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formlabel.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formselect.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formpassword.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formbutton.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formcheckbox.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formhidden.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formfile.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formradio.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formradioyn.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formselectcountry.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formselecttimezone.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formselectlang.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formselectgroup.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formselectuser.php";

include_once ICMS_ROOT_PATH."/class/xoopsform/formselecttheme.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formselectmatchoption.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formtext.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formtextarea.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formdhtmltextarea.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formelementtray.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/themeform.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/simpleform.php";
@include_once ICMS_ROOT_PATH."/class/xoopsform/formcalendar.php"; // for XOOPS 22
include_once ICMS_ROOT_PATH."/class/xoopsform/formtextdateselect.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formdatetime.php";
include_once ICMS_ROOT_PATH."/class/xoopsform/formhiddentoken.php";

//if(!@include_once ICMS_ROOT_PATH."/class/xoopsform/formeditor.php") {
	require_once dirname(__FILE__)."/xoopsform/formeditor.php";
//}

//if( !@include_once ICMS_ROOT_PATH."/class/xoopsform/formselecteditor.php" ) {
	require_once dirname(__FILE__)."/xoopsform/formselecteditor.php";
//}
?>