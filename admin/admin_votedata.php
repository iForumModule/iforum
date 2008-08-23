<?php
// $Id: admin_votedata.php,v 1.2 2005/04/18 01:22:27 phppp Exp $
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                      //
// Copyright (c) 2000 XOOPS.org                           //
// <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
include 'admin_header.php';

$op = "";
if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op)
{
    case "delvotes":
        global $xoopsDB, $_GET;
        $rid = $_GET['rid'];
        $topic_id = $_GET['topic_id'];
        $sql = $xoopsDB->queryF("DELETE FROM " . $xoopsDB->prefix('bb_votedata') . " WHERE ratingid = $rid");
        $xoopsDB->query($sql);
        newbb_updaterating($topic_id);
        redirect_header("admin_votedata.php", 1, _AM_NEWBB_VOTEDELETED);
        break;

    case 'main':
    default:

        global $xoopsDB;

		$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
        $useravgrating = '0';
        $uservotes = '0';

		$sql = "SELECT * FROM " . $xoopsDB->prefix('bb_votedata') . " ORDER BY ratingtimestamp DESC";
        $results = $xoopsDB->query($sql, 20, $start);
		$votes = $xoopsDB->getRowsNum($results);

        $sql = "SELECT rating FROM " . $xoopsDB->prefix('bb_votedata') . "";
        $result2 = $xoopsDB->query($sql, 20, $start);
		$uservotes = $xoopsDB->getRowsNum($result2);
        $useravgrating = 0;

        while (list($rating2) = $xoopsDB->fetchRow($result2))
        {
            $useravgrating = $useravgrating + $rating2;
        }
        if ($useravgrating > 0)
        {
            $useravgrating = $useravgrating / $uservotes;
            $useravgrating = number_format($useravgrating, 2);
        }

        xoops_cp_header();
        newbb_adminmenu(9, _AM_NEWBB_VOTE_RATINGINFOMATION);


	echo "
		<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_VOTE_DISPLAYVOTES . "</legend>\n
		<div style='padding: 8px;'>\n
		<div><strong>" . _AM_NEWBB_VOTE_USERAVG . ": </strong>$useravgrating</div>\n
		<div><strong>" . _AM_NEWBB_VOTE_TOTALRATE . ": </strong>$uservotes</div>\n
		<div style='padding: 8px;'>\n
		<ul><li>".newbb_displayImage($forumImage['delete'], _DELETE)." " . _AM_NEWBB_VOTE_DELETEDSC . "</li></ul>
		<div>\n
		</fieldset>\n
		<br />\n

		<table width='100%' cellspacing='1' cellpadding='2' class='outer'>\n
		<tr>\n
		<th align='center'>" . _AM_NEWBB_VOTE_ID . "</th>\n
		<th align='center'>" . _AM_NEWBB_VOTE_USER . "</th>\n
		<th align='center'>" . _AM_NEWBB_VOTE_IP . "</th>\n
		<th align='center'>" . _AM_NEWBB_VOTE_FILETITLE . "</th>\n
		<th align='center'>" . _AM_NEWBB_VOTE_RATING . "</th>\n
		<th align='center'>" . _AM_NEWBB_VOTE_DATE . "</th>\n
		<th align='center'>" . _AM_NEWBB_ACTION . "</th></tr>\n";

        if ($votes == 0)
        {
            echo "<tr><td align='center' colspan='7' class='head'>" . _AM_NEWBB_VOTE_NOVOTES . "</td></tr>";
        }
        while (list($ratingid, $topic_id, $ratinguser, $rating, $ratinghostname, $ratingtimestamp) = $xoopsDB->fetchRow($results))
        {
            $sql = "SELECT topic_title FROM " . $xoopsDB->prefix('bb_topics') . " WHERE topic_id=" . $topic_id . "";
            $down_array = $xoopsDB->fetchArray($xoopsDB->query($sql));

            $formatted_date = formatTimestamp($ratingtimestamp, _DATESTRING);
            $ratinguname = newbb_getUnameFromId($ratinguser, $xoopsModuleConfig['show_realname']);
	echo "
		<tr>\n
		<td class='head' align='center'>$ratingid</td>\n
		<td class='even' align='center'>$ratinguname</td>\n
		<td class='even' align='center' >$ratinghostname</td>\n
		<td class='even' align='center'>".$myts->htmlSpecialChars($down_array['topic_title'])."</td>\n
		<td class='even' align='center'>$rating</td>\n
		<td class='even' align='center'>$formatted_date</td>\n
		<td class='even' align='center'><strong><a href='admin_votedata.php?op=delvotes&amp;topic_id=$topic_id&amp;rid=$ratingid'>".newbb_displayImage($forumImage['delete'], _DELETE)."</a></strong></td>\n
		</tr>\n";
        }
        echo "</table>";
		//Include page navigation
		include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $page = ($votes > 20) ? _AM_NEWBB_MINDEX_PAGE : '';
        $pagenav = new XoopsPageNav($page, 20, $start, 'start');
        echo '<div align="right" style="padding: 8px;">' . $page . '' . $pagenav->renderImageNav(4) . '</div>';
        break;
}
xoops_cp_footer();
?>