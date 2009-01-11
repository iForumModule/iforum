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

include 'admin_header.php';

if (isset($_POST['cat_orders'])) $cat_orders = $_POST['cat_orders'];
if (isset($_POST['orders'])) $orders = $_POST['orders'];
if (isset($_POST['cat'])) $cat = $_POST['cat'];
if (isset($_POST['forum'])) $forum = $_POST['forum'];

if (!empty($_POST['submit'])) {
    for ($i = 0; $i < count($cat_orders); $i++) {
        $sql = "update " . $xoopsDB->prefix("bb_categories") . " set cat_order = " . $cat_orders[$i] . " WHERE cat_id=$cat[$i]";
        if (!$result = $xoopsDB->query($sql)) {
    		redirect_header("admin_forum_reorder.php", 1, _AM_IFORUM_FORUM_ERROR);
        }
    }

    for ($i = 0; $i < count($orders); $i++) {
        $sql = "update " . $xoopsDB->prefix("bb_forums") . " set forum_order = " . $orders[$i] . " WHERE forum_id=".$forum[$i];
        if (!$result = $xoopsDB->query($sql)) {
    		redirect_header("admin_forum_reorder.php", 1, _AM_IFORUM_FORUM_ERROR);
        }
    }
    redirect_header("admin_forum_reorder.php", 1, _AM_IFORUM_BOARDREORDER);
} else {
	include_once ICMS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/class/xoopsformloader.php";
    $orders = array();
    $cat_orders = array();
    $forum = array();
    $cat = array();

    xoops_cp_header();
    loadModuleAdminMenu(6, _AM_IFORUM_SETFORUMORDER);
    echo "<fieldset style='border: #e8e8e8 1px solid;'>
		  <legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_SETFORUMORDER . "</legend>";
    echo"<br /><br /><table width='100%' border='0' cellspacing='1' class='outer'>"
     . "<tr><td class='odd'>";
    $tform = new XoopsThemeForm(_AM_IFORUM_SETFORUMORDER, "", "");
    $tform->display();
    echo "<form name='reorder' method='post'>";
    echo "<table border='0' width='100%' cellpadding='2' cellspacing='1' class='outer'>";
    echo "<tr>";
    echo "<td class='head' align='center' width='3%' height='16'><strong>" . _AM_IFORUM_REORDERID . "</strong>";
    echo "</td><td class='head' align='left' width='30%'><strong>" . _AM_IFORUM_REORDERTITLE . "</strong>";
    echo "</td><td class='head' align='center' width='5%'><strong>" . _AM_IFORUM_REORDERWEIGHT . "</strong>";
    echo "</td></tr>";
    $category_handler =& icms_getmodulehandler('category', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
    $categories = $category_handler->getAllCats();
	$forum_handler =& icms_getmodulehandler('forum', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
	$forums = $forum_handler->getForumsByCategory();

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

    foreach($categories as $key => $onecat) {
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