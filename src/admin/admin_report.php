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

$start = (isset($_GET['start']))?$_GET['start']: 0;
$report_handler = icms_getmodulehandler('report', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );

icms_cp_header();
switch($op)
{
	case "save":
	$report_ids = $_POST['report_id'];
	$report_memos = isset($_POST['report_memo'])?$_POST['report_memo']:
	array();
	foreach($report_ids as $rid => $value)
	{
		if ($value)
		{
			$report_obj = $report_handler->get($rid);
			if ($item == 'processed')
			{
				$report_handler->delete($report_obj);
			}
			if ($item == 'process')
			{
				$report_obj->setVar("report_result", 1);
				$report_obj->setVar("report_memo", $report_memos[$rid]);
				$report_handler->insert($report_obj);
			}
		}
	}
	redirect_header("admin_report.php?item=$item", 1);

	break;

	case "process":
	default:

	if ($item == 'process')
	{
		$process_result = 0;
		$item_other = 'processed';
		$title_other = _AM_IFORUM_PROCESSEDREPORT;
		$extra = _AM_IFORUM_REPORTEXTRA;
	}
	else
	{
		$process_result = 1;
		$item_other = 'process';
		$title_other = _AM_IFORUM_PROCESSREPORT;
		$extra = _DELETE;
	}

	$limit = 10;
	loadModuleAdminMenu(8, _AM_IFORUM_REPORTADMIN);
	echo "<fieldset style='border: #e8e8e8 1px solid;'>
		<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_REPORTADMIN . "</legend>";
	echo"<br />";
	echo "<a style='border: 1px solid #5E5D63; color: #000000; font-family: verdana, tahoma, arial, helvetica, sans-serif; font-size: 1em; padding: 4px 8px; text-align:center;' href=\"admin_report.php?item=$item_other\">".$title_other."</a><br /><br />";

	echo '<form action="'.xoops_getenv('PHP_SELF').'" method="post">';
	echo "<table border='0' cellpadding='4' cellspacing='1' width='100%' class='outer'>";
	echo "<tr align='center'>";
	echo "<td class='bg3' width='80%'>"._AM_IFORUM_REPORTTITLE."</td>";
	echo "<td class='bg3' width='10%'>".$extra."</td>";
	echo "</tr>";

	$reports = $report_handler->getAllReports(0, "ASC", $limit, $start, $process_result);
	foreach($reports as $report)
	{
		$post_link = "<a href=\"".ICMS_URL."/modules/".icms::$module->getVar('dirname')."/viewtopic.php?post_id=". $report['post_id'] ."&amp;topic_id=". $report['topic_id'] ."&amp;forum=". $report['forum_id'] ."&amp;viewmode=thread\" target=\"checkreport\">".icms_core_DataFilter::htmlSpecialchars($report['subject'])."</a>";
		$checkbox = '<input type="checkbox" name="report_id['.$report['report_id'].']" value="1" checked="checked" />';
		if ($item == 'process')
		{
			$memo = '<input type="text" name="report_memo['.$report['report_id'].']" maxlength="255" size="80" />';
		}
		else
		{
			$memo = icms_core_DataFilter::htmlSpecialchars($report['report_memo']);
		}

		echo "<tr class='odd' align='left'>";
		echo "<td>"._AM_IFORUM_REPORTPOST.': '. $post_link . "</td>";
		echo "<td align='center'>" . $report['report_id'] . "</td>";
		echo "</tr>";
		echo "<tr class='odd' align='left'>";
		echo "<td>"._AM_IFORUM_REPORTTEXT.': '. icms_core_DataFilter::htmlSpecialchars($report['report_text']) . "</td>";
		$uid = intval($report['reporter_uid']);
		$reporter_name = iforum_getUnameFromId($uid, icms::$module->config['show_realname']);
		$reporter = (!empty($uid))? "<a href='" . ICMS_URL . "/userinfo.php?uid=".$uid."'>".$reporter_name."</a><br />":
		"";

		echo "<td align='center'>" . $reporter.long2ip($report['reporter_ip']) . "</td>";
		echo "</tr>";
		echo "<tr class='odd' align='left'>";
		echo "<td>"._AM_IFORUM_REPORTMEMO.': '. $memo . "</td>";
		echo "<td align='center' >" . $checkbox . "</td>";
		echo "</tr>";
		echo "<tr colspan='2'><td height='2'></td></tr>";
	}
	$submit = new icms_form_elements_Button('', 'submit', _SUBMIT, 'submit');
	echo "<tr colspan='2'><td align='center'>".$submit->render()."</td></tr>";
	$hidden = new icms_form_elements_Hidden('op', 'save');
	echo $hidden->render();
	$hidden = new icms_form_elements_Hidden('item', $item);
	echo $hidden->render()."</form>";

	echo "</table>";

	$nav = new icms_view_PageNav($report_handler->getCount(new icms_db_criteria_Item("report_result", $process_result)), $limit, $start, "start", "item=".$item);
	echo $nav->renderNav(4);

	echo "</fieldset>";

	break;
}
icms_cp_footer();

?>
