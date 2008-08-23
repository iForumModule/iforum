<?php
// $Id: admin_forum_reorder.php,v 1.3 2005/10/19 17:20:32 phppp Exp $
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

if (isset($_POST['cat_orders'])) $cat_orders = $_POST['cat_orders'];
if (isset($_POST['orders'])) $orders = $_POST['orders'];
if (isset($_POST['cat'])) $cat = $_POST['cat'];
if (isset($_POST['forum'])) $forum = $_POST['forum'];

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    for ($i = 0; $i < count($cat_orders); $i++) {
        $sql = "update " . $xoopsDB->prefix("bb_categories") . " set cat_order = " . $cat_orders[$i] . " WHERE cat_id=$cat[$i]";
        if (!$result = $xoopsDB->query($sql)) {
    		redirect_header("admin_forum_reorder.php", 1, _AM_NEWBB_FORUM_ERROR);
        }
    }

    for ($i = 0; $i < count($orders); $i++) {
        $sql = "update " . $xoopsDB->prefix("bb_forums") . " set forum_order = " . $orders[$i] . " WHERE forum_id=".$forum[$i];
        if (!$result = $xoopsDB->query($sql)) {
    		redirect_header("admin_forum_reorder.php", 1, _AM_NEWBB_FORUM_ERROR);
        }
    }
    redirect_header("admin_forum_reorder.php", 1, _AM_NEWBB_BOARDREORDER);
} else {
	include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/class/xoopsformloader.php";
    $orders = array();
    $cat_orders = array();
    $forum = array();
    $cat = array();

    xoops_cp_header();
    loadModuleAdminMenu(6, _AM_NEWBB_SETFORUMORDER);
    echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_SETFORUMORDER . "</legend>";
    echo"<br /><br /><table width='100%' border='0' cellspacing='1' class='outer'>"
     . "<tr><td class='odd'>";
    $tform = new XoopsThemeForm(_AM_NEWBB_SETFORUMORDER, "", "");
    $tform->display();
    echo "<form name='reorder' method='post'>";
    echo "<table border='0' width='100%' cellpadding='2' cellspacing='1' class='outer'>";
    echo "<tr>";
    echo "<td class='head' align='center' width='3%' height='16'><strong>" . _AM_NEWBB_REORDERID . "</strong>";
    echo "</td><td class='head' align='left' width='30%'><strong>" . _AM_NEWBB_REORDERTITLE . "</strong>";
    echo "</td><td class='head' align='center' width='5%'><strong>" . _AM_NEWBB_REORDERWEIGHT . "</strong>";
    echo "</td></tr>";
    $category_handler = &xoops_getmodulehandler('category', 'newbb');
    $categorys = $category_handler->getAllCats();
	$forums = $category_handler->getForums();

	$forums_array = array();
	foreach ($forums as $forumid => $forum) {
	    $forums_array[$forum->getVar('parent_forum')][] = array(
	    	'forum_order' => intval($forum->getVar('forum_order')),
		    'forum_id' => $forumid,
		    'forum_cid' => $forum->getVar('cat_id'),
		    'forum_name' => $forum->getVar('forum_name')
		);
	}
	unset($forums);
	if(count($forums_array)>0){
        foreach ($forums_array[0] as $key => $forum) {
            if (isset($forums_array[$forum['forum_id']])) {
                $forum['subforum'] = $forums_array[$forum['forum_id']];
            }
            $forumsByCat[$forum['forum_cid']][] = $forum;
        }
	}

    foreach($categorys as $onecat) {
        echo "<tr>";
        echo "<td align='left' class='head'>" . $onecat->getVar('cat_id') . "</td>";
        echo "<input type='hidden' name='cat[]' value='" . $onecat->getVar('cat_id') . "' />";
        echo "<td align='left' nowrap='nowrap' class='head' >" . $onecat->getVar('cat_title') . "</td>";
        echo "<td align='right' class='head'>";
        echo "<input type='text' name='cat_orders[]' value='" . $onecat->getVar('cat_order') . "' size='5' maxlength='5' />";
        echo "</td>";
        echo "</tr>";

	    $forums = (!empty($forumsByCat[$onecat->getVar('cat_id')]))?$forumsByCat[$onecat->getVar('cat_id')]:array();
        if (count($forums)>0) {
            foreach ($forums as $key => $forum) {
                echo "<tr>";
                echo "<td align='right' class='even'>" . $forum['forum_id'] . "</td>";
                echo "<input type='hidden' name='forum[]' value='" . $forum['forum_id'] . "' />";
                echo "<td align='left' nowrap='nowrap' class='odd'>" . $forum['forum_name'] . "</td>";
                echo "<td align='left' class='even'>";
                echo "<input type='text' name='orders[]' value='" . $forum['forum_order'] . "' size='5' maxlength='5' />";
                echo "</td>";
                echo "</tr>";

                if(isset($forum['subforum'])){
            		foreach ($forum['subforum'] as $key => $subforum) {
	                    echo "<tr>";
	                    echo "<td align='right' class='even'></td>";
	                    echo "<input type='hidden' name='forum[]' value='" . $subforum['forum_id'] . "' />";
	                    echo "<td align='left' nowrap='nowrap' class='odd'>";
	                    echo "<table width='100%'><tr>";
	                    echo "<td width='3%' align='right' nowrap='nowrap' class='even'>" . $subforum['forum_id'] . "</td>";
	                    echo "<td width='80%' align='left' nowrap='nowrap' class='odd'>-->&nbsp;" . $subforum['forum_name'] . "</td>";
	                    echo "<td width= '5%' align='right' nowrap='nowrap' class='odd'>";
	                    echo "<input type='text' name='orders[]' value='" . $subforum['forum_order'] . "' size='5' maxlength='5' /></td>";
	                    echo "</td></tr></table>";
	                    echo "<td align='left' class='even'>";
	                    echo "</td>";
	                    echo "</tr>";
                	}
                }
            }
        }
    }
    echo "<tr><td class='even' align='center' colspan='6'>";

    echo "<input type='submit' name='submit' value='" . _SUBMIT . "' />";

    echo "</td></tr>";
    echo "</table>";
    echo "</form>";
}

echo"</td></tr></table>";
echo "</fieldset>";
xoops_cp_footer();

?>