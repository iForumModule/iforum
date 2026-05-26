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

include 'admin_header.php';

$op = !empty($_GET['op'])? $_GET['op'] :
 (!empty($_POST['op'])?$_POST['op']:"");
$rate_handler = icms_getmodulehandler('rate', basename(dirname(__FILE__, 2)), 'iforum' );

switch ($op) {
	case "delvotes":
	$rid = (int)$_GET['rid'];
	$rate_handler->deleteRating($rid);
	redirect_header("admin_votedata.php", 1, _AM_IFORUM_VOTEDELETED);
	break;

	case 'main':
	default:
	$start = isset($_GET['start']) ? (int)$_GET['start'] :
	 0;
	$ratingSummary = $rate_handler->getAverageRating();
	$useravgrating = $ratingSummary['average_rating'];
	$uservotes = $ratingSummary['vote_count'];
	$votes = $rate_handler->getCount();
	$ratings = $rate_handler->getAllRates($start, 20);

	icms_cp_header();
	loadModuleAdminMenu(10, _AM_IFORUM_VOTE_RATINGINFOMATION);


	echo "
		<fieldset style='border: #e8e8e8 1px solid;'>
		<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_VOTE_DISPLAYVOTES . "</legend>\n
		<div style='padding: 8px;'>\n
		<div><strong>" . _AM_IFORUM_VOTE_USERAVG . ": </strong>$useravgrating</div>\n
		<div><strong>" . _AM_IFORUM_VOTE_TOTALRATE . ": </strong>$uservotes</div>\n
		<div style='padding: 8px;'>\n
		<ul><li>".iforum_displayImage($forumImage['delete'], _DELETE)." " . _AM_IFORUM_VOTE_DELETEDSC . "</li></ul>
		<div>\n
		</fieldset>\n
		<br />\n
		 
		<table width='100%' cellspacing='1' cellpadding='2' class='outer'>\n
		<tr>\n
		<th align='center'>" . _AM_IFORUM_VOTE_ID . "</th>\n
		<th align='center'>" . _AM_IFORUM_VOTE_USER . "</th>\n
		<th align='center'>" . _AM_IFORUM_VOTE_IP . "</th>\n
		<th align='center'>" . _AM_IFORUM_VOTE_FILETITLE . "</th>\n
		<th align='center'>" . _AM_IFORUM_VOTE_RATING . "</th>\n
		<th align='center'>" . _AM_IFORUM_VOTE_DATE . "</th>\n
		<th align='center'>" . _AM_IFORUM_ACTION . "</th></tr>\n";

	if ($votes == 0)
		{
		echo "<tr><td align='center' colspan='7' class='head'>" . _AM_IFORUM_VOTE_NOVOTES . "</td></tr>";
	}
	foreach ($ratings as $ratingRow)
	{
		$ratingid = (int)$ratingRow['ratingid'];
		$topic_id = (int)$ratingRow['topic_id'];
		$ratinguser = (int)$ratingRow['ratinguser'];
		$formatted_date = formatTimestamp($ratingRow['ratingtimestamp'], _DATESTRING);
		$ratinguname = iforum_getUnameFromId($ratinguser, icms::$module->config['show_realname']);
		$topicTitle = isset($ratingRow['topic_title']) ? $ratingRow['topic_title'] : '';
		$ratingHost = isset($ratingRow['ratinghostname']) ? $ratingRow['ratinghostname'] : '';
		echo "
			<tr>\n
			<td class='head' align='center'>$ratingid</td>\n
			<td class='even' align='center'>$ratinguname</td>\n
			<td class='even' align='center' >".icms_core_DataFilter::htmlSpecialchars($ratingHost)."</td>\n
			<td class='even' align='left'><a href='".ICMS_URL."/modules/".basename(dirname(__FILE__, 2))."/viewtopic.php?topic_id=".$topic_id."' target='topic'>".icms_core_DataFilter::htmlSpecialchars($topicTitle)."</a></td>\n
			<td class='even' align='center'>".$ratingRow['rating']."</td>\n
			<td class='even' align='center'>$formatted_date</td>\n
			<td class='even' align='center'><strong><a href='admin_votedata.php?op=delvotes&amp;rid=".(int)$ratingid."'>".iforum_displayImage($forumImage['delete'], _DELETE)."</a></strong></td>\n
			</tr>\n";
	}
	echo "</table>";
	//Include page navigation
	if ($votes > 20)
	{
		$pagenav = new icms_view_PageNav($votes, 20, $start, 'start');
		echo '<div align="right" style="padding: 8px;">' . _AM_IFORUM_MINDEX_PAGE . $pagenav->renderImageNav(4) . '</div>';
	}
	break;
}
icms_cp_footer();
?>
