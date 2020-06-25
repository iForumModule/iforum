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
 
switch ($op) {
	case "delvotes":
	global $_GET;
	$rid = (int)$_GET['rid'];
	$topic_id = (int)$_GET['topic_id'];
	$sql = icms::$xoopsDB->queryF("DELETE FROM " . icms::$xoopsDB->prefix('bb_votedata') . " WHERE ratingid = $rid");
	icms::$xoopsDB->query($sql);
	iforum_updaterating($topic_id);
	redirect_header("admin_votedata.php", 1, _AM_IFORUM_VOTEDELETED);
	break;
	 
	case 'main':
	default:
	$start = isset($_GET['start']) ? (int)$_GET['start'] :
	 0;
	$useravgrating = '0';
	$uservotes = '0';
	 
	$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('bb_votedata') . " ORDER BY ratingtimestamp DESC";
	$results = icms::$xoopsDB->query($sql, 20, $start);
	$votes = icms::$xoopsDB->getRowsNum($results);
	 
	$sql = "SELECT rating FROM " . icms::$xoopsDB->prefix('bb_votedata') . "";
	$result2 = icms::$xoopsDB->query($sql, 20, $start);
	$uservotes = icms::$xoopsDB->getRowsNum($result2);
	$useravgrating = 0;
	 
	while (list($rating2) = icms::$xoopsDB->fetchRow($result2))
	{
		$useravgrating = $useravgrating + $rating2;
	}
	if ($useravgrating > 0)
		{
		$useravgrating = $useravgrating / $uservotes;
		$useravgrating = number_format($useravgrating, 2);
	}
	 
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
	while (list($ratingid, $topic_id, $ratinguser, $rating, $ratinghostname, $ratingtimestamp) = icms::$xoopsDB->fetchRow($results))
	{
		$sql = "SELECT topic_title FROM " . icms::$xoopsDB->prefix('bb_topics') . " WHERE topic_id=" . $topic_id . "";
		$down_array = icms::$xoopsDB->fetchArray(icms::$xoopsDB->query($sql));
		 
		$formatted_date = formatTimestamp($ratingtimestamp, _DATESTRING);
		$ratinguname = iforum_getUnameFromId($ratinguser, icms::$module->config['show_realname']);
		echo "
			<tr>\n
			<td class='head' align='center'>$ratingid</td>\n
			<td class='even' align='center'>$ratinguname</td>\n
			<td class='even' align='center' >$ratinghostname</td>\n
			<td class='even' align='left'><a href='".ICMS_URL."/modules/".basename(dirname(dirname(__FILE__ ) ) )."/viewtopic.php?topic_id=".$topic_id."' target='topic'>".icms_core_DataFilter::htmlSpecialchars($down_array['topic_title'])."</a></td>\n
			<td class='even' align='center'>$rating</td>\n
			<td class='even' align='center'>$formatted_date</td>\n
			<td class='even' align='center'><strong><a href='admin_votedata.php?op=delvotes&amp;topic_id=$topic_id&amp;rid=$ratingid'>".iforum_displayImage($forumImage['delete'], _DELETE)."</a></strong></td>\n
			</tr>\n";
	}
	echo "</table>";
	//Include page navigation
	include_once ICMS_ROOT_PATH . '/class/pagenav.php';
	$page = ($votes > 20) ? _AM_IFORUM_MINDEX_PAGE :
	 '';
	$pagenav = new icms_view_PageNav($page, 20, $start, 'start');
	echo '<div align="right" style="padding: 8px;">' . $page . '' . $pagenav->renderImageNav(4) . '</div>';
	break;
}
icms_cp_footer();
?>