<?php
// $Id: admin_cat_manager.php,v 1.1.1.17 2004/11/13 23:49:08 phppp Exp $
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
include('admin_header.php');

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];
if (isset($_POST['default'])) $op = 'default';
if (isset($_GET['cat_id'])) $cat_id = $_GET['cat_id'];
if (isset($_POST['cat_id'])) $cat_id = $_POST['cat_id'];
$category_handler = &xoops_getmodulehandler('category', 'newbb');
/**
 * newCategory()
 *
 * @param integer $catid
 * @return
 */
function newCategory()
{
    editCategory();
}

/**
 * editCategory()
 *
 * @param integer $catid
 * @return
 */
function editCategory($cat_id = 0)
{
    $category_handler = &xoops_getmodulehandler('category', 'newbb');
    if ($cat_id > 0) {
        $fc = &$category_handler->get($cat_id);
    } else {
        $fc = &$category_handler->create();
    }
    $groups_cat_access = null;
    global $xoopsModule;

    if ($cat_id) {
        $sform = new XoopsThemeForm(_AM_NEWBB_EDITCATEGORY . " " . $fc->getVar('cat_title'), "op", xoops_getenv('PHP_SELF'));
    } else {
        $sform = new XoopsThemeForm(_AM_NEWBB_CREATENEWCATEGORY, "op", xoops_getenv('PHP_SELF'));
        $fc->setVar('cat_title', '');
        $fc->setVar('cat_image', 'blank.gif');
        $fc->setVar('cat_description', '');
        $fc->setVar('cat_order', 0);
        $fc->setVar('cat_state', 0);
        $fc->setVar('cat_showdescript', 1);
        $fc->setVar('cat_url', 'http://www.xoops.org');
    }
    // READ PERMISSIONS
    $member_handler = &xoops_gethandler('member');
    $group_list = &$member_handler->getGroupList();

    $gperm_handler = &xoops_gethandler('groupperm');
    $groups_cat_access = ($cat_id)?$gperm_handler->getGroupIds('forum_cat_access', $cat_id, $xoopsModule->getVar('mid')):array_keys($group_list);

    $groups_cat_access_checkbox = new XoopsFormCheckBox(_AM_NEWBB_ACCESSLEVEL, 'groups_cat_access[]', $groups_cat_access);
    foreach ($group_list as $group_id => $group_name) {
        $groups_cat_access_checkbox->addOption($group_id, $group_name);
    }
    $sform->addElement($groups_cat_access_checkbox);

    $sform->addElement(new XoopsFormText(_AM_NEWBB_SETCATEGORYORDER, 'cat_order', 5, 10, $fc->getVar('cat_order')), false);
    $sform->addElement(new XoopsFormText(_AM_NEWBB_CATEGORY, 'title', 50, 80, $fc->getVar('cat_title', 'E')), true);
    $sform->addElement(new XoopsFormDhtmlTextArea(_AM_NEWBB_CATEGORYDESC, 'catdescript', $fc->getVar('cat_description', 'E'), 10, 60), false);

    $displaydescription_radio = new XoopsFormRadioYN(_AM_NEWBB_SHOWDESC, 'show', $fc->getVar('cat_showdescript'), '' . _YES . '', ' ' . _NO . '');
    $sform->addElement($displaydescription_radio);

    $status_select = new XoopsFormSelect(_AM_NEWBB_STATE, "state", $fc->getVar('cat_state'));
    $status_select->addOptionArray(array('0' => _AM_NEWBB_ACTIVE, '1' => _AM_NEWBB_INACTIVE));
    $sform->addElement($status_select);

    $imgdir = "/modules/" . $xoopsModule->dirname() . "/images/category";
    if (!isset($fc->cat_image)) $fc->cat_image = 'blank.gif';
    $graph_array = &XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . $imgdir);
    $indeximage_select = new XoopsFormSelect('', 'indeximage', $fc->getVar('cat_image'));
    $indeximage_select->addOptionArray($graph_array);
    $indeximage_select->setExtra("onchange='showImgSelected(\"image\",\"indeximage\", \"" . $imgdir . "\", \"\", \"" . XOOPS_URL . "\")'");
    $indeximage_tray = new XoopsFormElementTray(_AM_NEWBB_SPONSORIMAGE, '&nbsp;');
    $indeximage_tray->addElement($indeximage_select);
    $indeximage_tray->addElement(new XoopsFormLabel('', "<br /><img src='" . XOOPS_URL . $imgdir . "/" . $fc->getVar('cat_image') . " 'name='image' id='image' alt='' />"));
    $sform->addElement($indeximage_tray);

    $sform->addElement(new XoopsFormText(_AM_NEWBB_SPONSORLINK, 'sponurl', 50, 80, $fc->getVar('cat_url', 'E')), false);
    $sform->addElement(new XoopsFormHidden('cat_id', $cat_id));

    $button_tray = new XoopsFormElementTray('', '');
    $button_tray->addElement(new XoopsFormHidden('op', 'save'));

    $butt_save = new XoopsFormButton('', '', _SUBMIT, 'submit');
    $butt_save->setExtra('onclick="this.form.elements.op.value=\'save\'"');
    $button_tray->addElement($butt_save);
    if ($cat_id) {
        $butt_delete = new XoopsFormButton('', '', _CANCEL, 'submit');
        $butt_delete->setExtra('onclick="this.form.elements.op.value=\'default\'"');
        $button_tray->addElement($butt_delete);
    }
    $sform->addElement($button_tray);
    $sform->display();
}
xoops_cp_header();
switch ($op) {
    case "manage":

        $categorys = $category_handler->getAllCats();
        if (empty($categorys)) {
            newbb_adminmenu(1, _AM_NEWBB_CREATENEWCATEGORY);
            echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_CREATENEWCATEGORY . "</legend>";
            echo "<br />";

            newCategory();

            echo "</fieldset>";

            break;
        }

        newbb_adminmenu(1, _AM_NEWBB_CATADMIN);
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_CATADMIN . "</legend>";
        echo"<br />";
        echo "<a style='border: 1px solid #5E5D63; color: #000000; font-family: verdana, tahoma, arial, helvetica, sans-serif; font-size: 1em; padding: 4px 8px; text-align:center;' href='admin_cat_manager.php'>" . _AM_NEWBB_CREATENEWCATEGORY . "</a><br /><br />";

        echo "<table border='0' cellpadding='4' cellspacing='1' width='100%' class='outer'>";
        echo "<tr align='center'>";
        echo "<td class='bg3'>" . _AM_NEWBB_CATEGORY1 . "</td>";
        echo "<td class='bg3'>" . _AM_NEWBB_STATE . "</td>";
        echo "<td class='bg3'>" . _AM_NEWBB_EDIT . "</td>";
        echo "<td class='bg3'>" . _AM_NEWBB_DELETE . "</td>";
        echo "</tr>";

        foreach($categorys as $onecat) {
            if (!$onecat->getVar('cat_state')) {
                $status = _AM_NEWBB_ACTIVE;
            } else {
                $status = _AM_NEWBB_INACTIVE;
            }
            $cat_edit_link = "<a href=\"admin_cat_manager.php?op=mod&cat_id=" . $onecat->getVar('cat_id') . "\">".newbb_displayImage($forumImage['edit'], _EDIT)."</a>";
            $cat_del_link = "<a href=\"admin_cat_manager.php?op=del&cat_id=" . $onecat->getVar('cat_id') . "\">".newbb_displayImage($forumImage['delete'], _DELETE)."</a>";

            echo "<tr class='odd' align='left'>";
            echo "<td width='60%'>" . $onecat->textLink() . "</td>";
            echo "<td width='10%' align='center'>" . $status . "</td>";
            echo "<td width='10%' align='center'>" . $cat_edit_link . "</td>";
            echo "<td width='10%' align='center'>" . $cat_del_link . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</fieldset>";
        break;

    case "mod":
        $fc = &$category_handler->get($cat_id);
        newbb_adminmenu(1, _AM_NEWBB_EDITCATEGORY . $fc->getVar('cat_title'));
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_EDITCATEGORY . "</legend>";
        echo"<br />";

        editCategory($cat_id);

        echo "</fieldset>";
        break;

    case "del":
        if (isset($_POST['confirm']) != 1) {
            xoops_confirm(array('op' => 'del', 'cat_id' => intval($_GET['cat_id']), 'confirm' => 1), 'admin_cat_manager.php', _AM_NEWBB_WAYSYWTDTTAL);
            break;
        } else {
            $fc = &$category_handler->create(false);
            $fc->setVar('cat_id', $_POST['cat_id']);
            $category_handler->delete($fc);

            redirect_header("admin_cat_manager.php", 2, _AM_NEWBB_CATEGORYDELETED);
            exit();
        }
        exit();

    case "save":

        if ($cat_id) {
            $fc = &$category_handler->get($cat_id);
            $message = _AM_NEWBB_CATEGORYUPDATED;
        } else {
            $fc = &$category_handler->create();
            $message = _AM_NEWBB_CATEGORYCREATED;
        }

        $fc->setVar('cat_title', @$_POST['title']);
        $fc->setVar('cat_image', $_POST['indeximage']);
        $fc->setVar('cat_order', $_POST['cat_order']);
        $fc->setVar('cat_description', @$_POST['catdescript']);
        $fc->setVar('cat_state', $_POST['state']);
        $fc->setVar('cat_url', @$_POST['sponurl']);
        $fc->setVar('cat_showdescript', @$_POST['show']);
        $fc->groups_cat_access = @$_POST['groups_cat_access'];

        if (!$category_handler->insert($fc)) {
            $message = _AM_NEWBB_DATABASEERROR;
        }
        redirect_header("admin_cat_manager.php", 2, $message);
        exit();

    case "default":
    default:
        newbb_adminmenu(1, _AM_NEWBB_CREATENEWCATEGORY);
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_CREATENEWCATEGORY . "</legend>";
        echo "<br />";

        newCategory();

        echo "</fieldset>";
}
xoops_cp_footer();

?>