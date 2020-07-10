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
 
include('admin_header.php');
include_once ICMS_ROOT_PATH."/class/pagenav.php";
 
$op = !empty($_GET['op'])? $_GET['op'] :
 (!empty($_POST['op'])?$_POST['op']:"default");
$item = !empty($_GET['op'])? $_GET['item'] :
 (!empty($_POST['item'])?$_POST['item']:"process");
 
$start = (isset($_GET['start']))?$_GET['start']:
0;
//$report_handler = icms_getmodulehandler('report', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
 
icms_cp_header();
switch($op)
{
	case "delete":
	$digest_ids = $_POST['digest_id'];
	$digest_handler = icms_getmodulehandler('digest', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
	foreach($digest_ids as $did => $value)
	{
		$digest_handler->delete($did);
	}
	redirect_header("admin_digest.php", 1);
	break;
	 
	default:
	 
	$limit = 5;
	loadModuleAdminMenu(9, _AM_IFORUM_DIGESTADMIN);
	echo "<fieldset style='border: #e8e8e8 1px solid;'>
		<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_DIGESTADMIN . "</legend>";
	echo"<br />";
	echo '<form action="'.xoops_getenv('PHP_SELF').'" method="post">';
	echo "<table border='0' cellpadding='4' cellspacing='1' width='100%' class='outer'>";
	echo "<tr align='center'>";
	echo "<td class='bg3'>"._AM_IFORUM_DIGESTCONTENT."</td>";
	echo "<td class='bg3' width='2%'>"._DELETE."</td>";
	echo "</tr>";
	 
	$digest_handler = icms_getmodulehandler('digest', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
	$digests = $digest_handler->getAllDigests($start, $limit);
	foreach($digests as $digest)
	{
		echo "<tr class='odd' align='left'>";
		echo "<td><strong>#".$digest['digest_id'].' @ '. formatTimestamp($digest['digest_time']) . '</strong><br />' . str_replace("\n", "<br />", $digest['digest_content']) . "</td>";
		echo "<td align='center' ><input type='checkbox' name='digest_id[".$digest['digest_id']."]' value='1' /></td>";
		echo "</tr>";
		echo "<tr colspan='2'><td height='2'></td></tr>";
	}
	$submit = new icms_form_elements_Button('', 'submit', _SUBMIT, 'submit');
	echo "<tr colspan='2'><td align='center'>".$submit->render()."</td></tr>";
	$hidden = new icms_form_elements_Hidden('op', 'delete');
	echo $hidden->render();
	$hidden = new icms_form_elements_Hidden('item', $item);
	echo $hidden->render()."</form>";
	 
	echo "</table>";
	 
	$nav = new icms_view_PageNav($digest_handler->getDigestCount(), $limit, $start, "start");
	echo $nav->renderNav(4);
	 
	echo "</fieldset>";
	 
	break;
}
icms_cp_footer();
