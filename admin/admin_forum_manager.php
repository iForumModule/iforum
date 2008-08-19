<?php
// $Id: admin_forum_manager.php,v 1.1.1.34 2004/11/13 23:49:08 phppp Exp $
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
include XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/class/pagenav.php";
include_once XOOPS_ROOT_PATH . "/modules/newbb/class/formselectuser.php";

$op = '';
$confirm = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];
if (isset($_POST['default'])) $op = 'default';
if (isset($_GET['forum'])) $forum = $_GET['forum'];
if (isset($_POST['forum'])) $forum = $_POST['forum'];

$start = (isset($_GET['start']))?$_GET['start']:0;

$forum_handler = &xoops_getmodulehandler('forum', 'newbb');
/**
 * newForum()
 *
 * @param integer $catid
 * @return
 */
function newForum($parent_forum = null)
{
    editForum(null, $parent_forum);
}

/**
 * editForum()
 *
 * @param integer $catid
 * @return
 */
function editForum($ff = null, $parent_forum = 0)
{
    global $start, $myts;

    $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
    if ($ff == null) {
        $ff = &$forum_handler->create();
        $new = true;
        $forum = 0;
    } else {
        $forum = $ff->getVar('forum_id');
        $new = false;
    }
    if ($parent_forum > 0) {
        $pf = &$forum_handler->get($parent_forum);
    }

    $groups_forum_access = null;
    $groups_forum_can_post = null;
    $groups_forum_can_view = null;
    $groups_forum_can_reply = null;
    $groups_forum_can_edit = null;
    $groups_forum_can_delete = null;
    $groups_forum_can_addpoll = null;
    $groups_forum_can_attach = null;
    $groups_forum_can_noapprove = null;

    Global $xoopsDB, $xoopsModule;

    $mytree = new XoopsTree($xoopsDB->prefix("bb_categories"), "cat_id", "0");

    if ($forum) {
        $moderators = $ff->getModerators(true);

        $limit = 200;
        $moderatorform = new XoopsThemeForm(_AM_NEWBB_MODERATOR . " " . $ff->getVar('forum_name'), "op", xoops_getenv('PHP_SELF'));

        $rem_moderator_checkbox = new XoopsFormCheckBox(_AM_NEWBB_MODERATOR_REMOVE, 'rem_moderator[]');
        if (count($moderators) > 0) {
            foreach($moderators as $moderator => $name) {
                $rem_moderator_checkbox->addOption($moderator, $name);
            }
            $moderatorform->addElement($rem_moderator_checkbox);
        }

        $user_select = new NewbbFormSelectUser('', 'forum_moderator', $start, $limit, array_keys($moderators));
        $user_select_tray = new XoopsFormElementTray(_AM_NEWBB_MODERATOR_ADD, "<br />");
        $user_select_tray->addElement($user_select);
        $member_handler = &xoops_gethandler('member');
        $usercount = $member_handler->getUserCount();
        $nav = new XoopsPageNav($usercount, $limit, $start, "start", "op=mod&amp;forum=$forum");
        $user_select_nav = new XoopsFormLabel('', $nav->renderNav(4));
        $user_select_tray->addElement($user_select_nav);
        $submit_button = new XoopsFormButton('', '', _AM_NEWBB_EDIT, 'submit');

        $moderatorform->addElement($user_select_tray);
        $moderatorform->addElement(new XoopsFormHidden('forum', $forum));
        $moderatorform->addElement(new XoopsFormHidden('op', 'moderators'));
        $moderatorform->addElement($submit_button);
        $moderatorform->display();
        echo "<br />\n";
        $sform = new XoopsThemeForm(_AM_NEWBB_EDITTHISFORUM . " " . $ff->getVar('forum_name'), "op", xoops_getenv('PHP_SELF'));
    } else {
        $sform = new XoopsThemeForm(_AM_NEWBB_CREATENEWFORUM, "op", xoops_getenv('PHP_SELF'));

        $ff->setVar('forum_order', 0);
        $ff->setVar('forum_name', '');
        $ff->setVar('forum_desc', '');
        $ff->setVar('forum_moderator', 1);

        $ff->setVar('forum_type', 0);
        $ff->setVar('allow_html', 1);
        $ff->setVar('allow_sig', 1);
        $ff->setVar('allow_polls', 1);
        $ff->setVar('allow_subject_prefix', 0);
        $ff->setVar('hot_threshold', 10);
        $ff->setVar('allow_attachments', 1);
        $ff->setVar('attach_maxkb', 1000);
        $ff->setVar('attach_ext', 'zip|gif|jpg');
    }
    // READ PERMISSIONS
    $member_handler = &xoops_gethandler('member');
    $group_list = &$member_handler->getGroupList();
    //$group_ids = array();
    $gperm_handler = &xoops_gethandler('groupperm');
    $groups_forum_access =($forum)?$gperm_handler->getGroupIds('global_forum_access', $forum, $xoopsModule->getVar('mid')):array_keys($group_list);

    $groups_access_checkbox = new XoopsFormCheckBox(_AM_NEWBB_ACCESSLEVEL, 'groups_forum_access[]', $groups_forum_access);
    foreach ($group_list as $group_id => $group_name) {
        $groups_access_checkbox->addOption($group_id, $group_name);
    }
    $sform->addElement($groups_access_checkbox);

    $sform->addElement(new XoopsFormText(_AM_NEWBB_SET_FORUMORDER, 'forum_order', 5, 10, $ff->getVar('forum_order')), false);
    $sform->addElement(new XoopsFormText(_AM_NEWBB_FORUMNAME, 'forum_name', 50, 80, $ff->getVar('forum_name', 'E')), true);
    $sform->addElement(new XoopsFormDhtmlTextArea(_AM_NEWBB_FORUMDESCRIPTION, 'forum_desc', $ff->getVar('forum_desc', 'E'), 10, 60), false);

    $sform->addElement(new XoopsFormHidden('parent_forum', $parent_forum));
    if ($parent_forum == 0) {
        ob_start();
        if ($new) {
        	$mytree->makeMySelBox("cat_title", "cat_id", $_GET['cat_id']);
        } else {
        	$mytree->makeMySelBox("cat_title", "cat_id", $ff->getVar('cat_id'));
        }
        $sform->addElement(new XoopsFormLabel(_AM_NEWBB_CATEGORY, ob_get_contents()));
        ob_end_clean();
    } else {
        $sform->addElement(new XoopsFormHidden('cat_id', $pf->getVar('cat_id')));
    }

    $status_select = new XoopsFormSelect(_AM_NEWBB_STATE, "forum_type", $ff->getVar('forum_type'));
    $status_select->addOptionArray(array('0' => _AM_NEWBB_ACTIVE, '1' => _AM_NEWBB_INACTIVE));
    $sform->addElement($status_select);

    $allowhtml_radio = new XoopsFormRadioYN(_AM_NEWBB_ALLOWHTML, 'allow_html', $ff->getVar('allow_html'), '' . _YES . '', ' ' . _NO . '');
    $sform->addElement($allowhtml_radio);

    $allowsig_radio = new XoopsFormRadioYN(_AM_NEWBB_ALLOWSIGNATURES, 'allow_sig', $ff->getVar('allow_sig'), '' . _YES . '', ' ' . _NO . '');
    $sform->addElement($allowsig_radio);

    $allowpolls_radio = new XoopsFormRadioYN(_AM_NEWBB_ALLOWPOLLS, 'allow_polls', $ff->getVar('allow_polls'), '' . _YES . '', ' ' . _NO . '');
    $sform->addElement($allowpolls_radio);

    $allowprefix_radio = new XoopsFormRadioYN(_AM_NEWBB_ALLOW_SUBJECT_PREFIX, 'allow_subject_prefix', $ff->getVar('allow_subject_prefix'), '' . _YES . '', ' ' . _NO . '');
    $sform->addElement($allowprefix_radio);

    $sform->addElement(new XoopsFormText(_AM_NEWBB_HOTTOPICTHRESHOLD, 'hot_threshold', 5, 10, $ff->getVar('hot_threshold')), true);

    $allowattach_radio = new XoopsFormRadioYN(_AM_NEWBB_ALLOW_ATTACHMENTS, 'allow_attachments', $ff->getVar('allow_attachments'), '' . _YES . '', ' ' . _NO . '');
    $sform->addElement($allowattach_radio);
    $sform->addElement(new XoopsFormText(_AM_NEWBB_ATTACHMENT_SIZE, 'attach_maxkb', 5, 10, $ff->getVar('attach_maxkb')), true);
    $sform->addElement(new XoopsFormText(_AM_NEWBB_ALLOWED_EXTENSIONS, 'attach_ext', 50, 512, $ff->getVar('attach_ext')), true);

    $sform->addElement(new XoopsFormLabel('', '<strong>' . _AM_NEWBB_PERMISSIONS_TO_THIS_FORUM . '</strong>'));
    $member_handler = &xoops_gethandler('member');
    $group_list = &$member_handler->getGroupList();

    $gperm_handler = &xoops_gethandler('groupperm');
    if ($forum > 0) {
        $groups_forum_can_view = $gperm_handler->getGroupIds('forum_can_view', $forum, $xoopsModule->getVar('mid'));
        $groups_forum_can_post = $gperm_handler->getGroupIds('forum_can_post', $forum, $xoopsModule->getVar('mid'));
        $groups_forum_can_reply = $gperm_handler->getGroupIds('forum_can_reply', $forum, $xoopsModule->getVar('mid'));
        $groups_forum_can_edit = $gperm_handler->getGroupIds('forum_can_edit', $forum, $xoopsModule->getVar('mid'));
        $groups_forum_can_delete = $gperm_handler->getGroupIds('forum_can_delete', $forum, $xoopsModule->getVar('mid'));
        $groups_forum_can_addpoll = $gperm_handler->getGroupIds('forum_can_addpoll', $forum, $xoopsModule->getVar('mid'));
        $groups_forum_can_vote = $gperm_handler->getGroupIds('forum_can_vote', $forum, $xoopsModule->getVar('mid'));
        $groups_forum_can_attach = $gperm_handler->getGroupIds('forum_can_attach', $forum, $xoopsModule->getVar('mid'));
        $groups_forum_can_noapprove = $gperm_handler->getGroupIds('forum_can_noapprove', $forum, $xoopsModule->getVar('mid'));
    } else {
	    $full_list = array_keys($group_list);
	    $member_list = array();
	    foreach($full_list as $id){
			if($id != 3) $member_list[]=$id; // Make sure the anonymous group id is equal to 3 !!
	    }
	    $admin_list = $gperm_handler->getGroupIds('module_admin', $xoopsModule->getVar('mid'));

        $groups_forum_can_view = &$full_list;
        $groups_forum_can_post = &$member_list;
        $groups_forum_can_reply = &$member_list;
        $groups_forum_can_edit = &$member_list;
        $groups_forum_can_delete = &$admin_list;
        $groups_forum_can_addpoll = &$member_list;
        $groups_forum_can_vote = &$member_list;
        $groups_forum_can_attach = &$member_list;
        $groups_forum_can_noapprove = &$member_list;
    }
    $groups_forum_can_view_checkbox = new XoopsFormCheckBox(_AM_NEWBB_CAN_VIEW, 'groups_forum_can_view[]', $groups_forum_can_view);
    foreach ($group_list as $group_id => $group_name) {
        $groups_forum_can_view_checkbox->addOption($group_id, $group_name);
    }
    $sform->addElement($groups_forum_can_view_checkbox);

    $groups_forum_can_post_checkbox = new XoopsFormCheckBox(_AM_NEWBB_CAN_POST, 'groups_forum_can_post[]', $groups_forum_can_post);
    foreach ($group_list as $group_id => $group_name) {
        $groups_forum_can_post_checkbox->addOption($group_id, $group_name);
    }
    $sform->addElement($groups_forum_can_post_checkbox);

    $groups_forum_can_reply_checkbox = new XoopsFormCheckBox(_AM_NEWBB_CAN_REPLY, 'groups_forum_can_reply[]', $groups_forum_can_reply);
    foreach ($group_list as $group_id => $group_name) {
        $groups_forum_can_reply_checkbox->addOption($group_id, $group_name);
    }
    $sform->addElement($groups_forum_can_reply_checkbox);

    $groups_forum_can_edit_checkbox = new XoopsFormCheckBox(_AM_NEWBB_CAN_EDIT, 'groups_forum_can_edit[]', $groups_forum_can_edit);
    foreach ($group_list as $group_id => $group_name) {
        $groups_forum_can_edit_checkbox->addOption($group_id, $group_name);
    }
    $sform->addElement($groups_forum_can_edit_checkbox);

    $groups_forum_can_delete_checkbox = new XoopsFormCheckBox(_AM_NEWBB_CAN_DELETE, 'groups_forum_can_delete[]', $groups_forum_can_delete);
    foreach ($group_list as $group_id => $group_name) {
        $groups_forum_can_delete_checkbox->addOption($group_id, $group_name);
    }
    $sform->addElement($groups_forum_can_delete_checkbox);

    $groups_forum_can_addpoll_checkbox = new XoopsFormCheckBox(_AM_NEWBB_CAN_ADDPOLL, 'groups_forum_can_addpoll[]', $groups_forum_can_addpoll);
    foreach ($group_list as $group_id => $group_name) {
        $groups_forum_can_addpoll_checkbox->addOption($group_id, $group_name);
    }
    $sform->addElement($groups_forum_can_addpoll_checkbox);

    $groups_forum_can_vote_checkbox = new XoopsFormCheckBox(_AM_NEWBB_CAN_VOTE, 'groups_forum_can_vote[]', $groups_forum_can_vote);
    foreach ($group_list as $group_id => $group_name) {
        $groups_forum_can_vote_checkbox->addOption($group_id, $group_name);
    }
    $sform->addElement($groups_forum_can_vote_checkbox);

    $groups_forum_can_attach_checkbox = new XoopsFormCheckBox(_AM_NEWBB_CAN_ATTACH, 'groups_forum_can_attach[]', $groups_forum_can_attach);
    foreach ($group_list as $group_id => $group_name) {
        $groups_forum_can_attach_checkbox->addOption($group_id, $group_name);
    }
    $sform->addElement($groups_forum_can_attach_checkbox);

    $groups_forum_can_noapprove_checkbox = new XoopsFormCheckBox(_AM_NEWBB_CAN_NOAPPROVE, 'groups_forum_can_noapprove[]', $groups_forum_can_noapprove);
    foreach ($group_list as $group_id => $group_name) {
        $groups_forum_can_noapprove_checkbox->addOption($group_id, $group_name);
    }
    $sform->addElement($groups_forum_can_noapprove_checkbox);
    $sform->addElement(new XoopsFormHidden('forum', $forum));

    $jstray = new XoopsFormElementTray('', '');
    foreach ($group_list as $group_id => $group_name) {
        $jstray->addElement(new XoopsFormHidden('group_ids[]', strval($group_id)));
    }

    $jsuncheckbutton = new XoopsFormButton('', '', _NONE, 'submit');
    $jsuncheckbutton->setExtra('onclick="this.form.elements.op.value=\'savenone\'"') ;

    $jscheckbutton = new XoopsFormButton('', '', _ALL, 'submit');
    $jscheckbutton->setExtra('onclick="this.form.elements.op.value=\'saveall\'"') ;

    $jstray->addElement($jsuncheckbutton) ;
    $jstray->addElement($jscheckbutton) ;

    $sform->addElement($jstray);

    $button_tray = new XoopsFormElementTray('', '');
    $button_tray->addElement(new XoopsFormHidden('op', 'save'));
    // No ID for forum -- then it's new forum, button says 'Create'
    if (!$forum) {
        $butt_create = new XoopsFormButton('', '', _AM_NEWBB_CREATEFORUM, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'save\'"');
        $button_tray->addElement($butt_create);

        $butt_clear = new XoopsFormButton('', '', _AM_NEWBB_CLEAR, 'reset');
        $button_tray->addElement($butt_clear);

        $butt_cancel = new XoopsFormButton('', '', _CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    } else { // button says 'Update'
            $butt_create = new XoopsFormButton('', '', _AM_NEWBB_EDIT, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'save\'"');
        $button_tray->addElement($butt_create);

        $butt_cancel = new XoopsFormButton('', '', _CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    }

    $sform->addElement($button_tray);
    $sform->display();
}
xoops_cp_header();
switch ($op) {
    case 'moveforum':

        if (isset($_POST['save']) && $_POST['save'] != "") {
            if (isset($_GET['forum'])) $forum = intval($_GET['forum']);
            if (isset($_POST['forum'])) $forum = intval($_POST['forum']);

            $bMoved = 0;
            $errString = '';
            // Look for subforums
            $sql = "SELECT * from " . $xoopsDB->prefix('bb_forums') . " WHERE parent_forum=$forum";
            if ($result = $xoopsDB->query($sql)) {
                if ($xoopsDB->getRowsNum($result) == 0) {
                    $sql_move = "UPDATE " . $xoopsDB->prefix('bb_forums') . " SET cat_id=" . $_POST['cat_id'] . ", parent_forum=" . $_POST['parent_forum'] . " WHERE forum_id=$forum";
                    if ($xoopsDB->query($sql_move))
                        $bMoved = 1;
                } else {
                    // Are we trying to move this
                    if ($_POST['parent_forum'] != 0) {
                        $errString = "This forum cannot be made as a subforum.<br />Multi-level subforums are not allowed.";
                    } else {
                        $sql_move = "UPDATE " . $xoopsDB->prefix('bb_forums') . " SET cat_id=" . $_POST['cat_id'] . ", parent_forum=" . $_POST['parent_forum'] . " WHERE forum_id=$forum";
                        if ($xoopsDB->query($sql_move)) {
                            $bMoved = 1;
                            while ($row = $xoopsDB->fetchArray($result)) {
                                $sql_move_sub = "UPDATE " . $xoopsDB->prefix('bb_forums') . " SET cat_id=" . $_POST['cat_id'] . " WHERE forum_id=" . $row['forum_id'];
                                $xoopsDB->query($sql_move_sub);
                            }
                        }
                    }
                }
            }

            $sql = "UPDATE " . $xoopsDB->prefix('bb_forums') . " SET cat_id=" . $_POST['cat_id'] . ", parent_forum=" . $_POST['parent_forum'] . " WHERE forum_id=$forum";
            if ($result = $xoopsDB->query($sql)) {
                $bMoved = 1;
            }

            if (!$bMoved) {
                redirect_header('./admin_forum_manager.php?op=manage', 2, _AM_NEWBB_MSG_ERR_FORUM_MOVED . '<br />' . $errString);
            } else {
                redirect_header('./admin_forum_manager.php?op=manage', 2, _AM_NEWBB_MSG_FORUM_MOVED);
            }
            die();
        } else {
            newbb_adminmenu(2, "");

            if (isset($_GET['forum'])) $forum = intval($_GET['forum']);
            if (isset($_POST['forum'])) $forum = intval($_POST['forum']);
            $forum = &$forum_handler->get($forum);
            $name = $myts->htmlSpecialChars($forum->getVar('forum_name'));
            $desc = $myts->htmlSpecialChars($forum->getVar('forum_desc'));

            $cat_list = "<select name=\"cat_id\" onchange='document.forummove.submit();'>";
            $cat_list .= '<option value="0">' . _AM_NEWBB_SELECT . '</option>';

            $category_handler = &xoops_getmodulehandler('category', 'newbb');
            $categories = $category_handler->getAllCats();

            foreach ($categories as $key => $category) {
                $selected = '';
                if (isset($_POST['cat_id']) && $_POST['cat_id'] == $category->getVar('cat_id')) $selected = 'selected';
                $cat_list .= "<option value='" . $category->getVar('cat_id') . "' $selected>" . $category->getVar('cat_title') . "</option>";
            }
            $cat_list .= '</select>';

            $sf_list = '<select name="parent_forum">';
            $sf_list .= '<option value="0" selected>' . _AM_NEWBB_SELECT . '</option>';
            $sf_list .= '<option value="0">' . _NONE . '</option>';
            if (isset($_POST['cat_id'])) {
                $sql = "SELECT * FROM " . $xoopsDB->prefix('bb_forums') . " WHERE cat_id=" . $_POST['cat_id'] . " AND forum_id!=$forum->getVar('forum_id')";
                if ($result = $xoopsDB->query($sql))
                    while ($row = $xoopsDB->fetchArray($result)) {
                    $sf_list .= "<option value='" . $row['forum_id'] . "'>" . $row['forum_name'] . "</option>";
                }
            }
            $sf_list .= '</select>';

            echo '<form action="./admin_forum_manager.php" method="post" name="forummove" id="forummove">';
            echo '<input type="hidden" name="op" value="moveforum" />';
            echo '<input type="hidden" name="forum" value=' . $forum->getVar('forum_id') . ' />';
            echo '<table border="0" cellpadding="1" cellspacing="0" align="center" valign="top" width="95%"><tr>';
            echo '<td class="bg2">';
            echo '<table border="0" cellpadding="1" cellspacing="1" width="100%"><tr class="bg3">';
            echo '<td align="center" colspan="2"><strong>' . _AM_NEWBB_MOVETHISFORUM . '</strong></td>';
            echo '</tr>';
            echo '<tr><td class="bg1">' . _AM_NEWBB_MOVE2CAT . '</td><td class="bg1">' . $cat_list . '</td></tr>';
            echo '<tr><td class="bg1">' . _AM_NEWBB_MAKE_SUBFORUM_OF . '</td><td class="bg1">' . $sf_list . '</td></tr>';
            echo '<tr><td colspan="2" align="center"><input type="submit" name="save" value=' . _GO . ' class="button" /></td></tr>';
            echo '</form></table></td></tr></table>';
        }
        break;

    case 'sync':
        if (isset($_POST['submit'])) {
            flush();
            sync(null, "all forums");
            flush();
            sync(null, "all topics");
            redirect_header("./index.php", 1, _AM_NEWBB_SYNCHING);
            exit();
        } else {
            newbb_adminmenu(3, _AM_NEWBB_SYNCFORUM);
            echo '<fieldset><legend style="font-weight: bold; color: #900;">' . _AM_NEWBB_SYNCFORUM . '</legend>';
            echo '<br /><br /><table width="100%" border="0" cellspacing="1" class="outer"><tr><td class="odd">';
            echo '<table border="0" cellpadding="1" cellspacing="1" width="100%">';
            echo '<tr class="bg3" align="left">';
            echo '<td>' . _AM_NEWBB_CLICKBELOWSYNC . '</td>';
            echo '</tr>';
            echo '<tr class="bg1" align="center">';
            echo '<td><form action="admin_forum_manager.php" method="post">';
            echo '<input type="hidden" name="op" value="sync"><input type="submit" name="submit" value=' . _AM_NEWBB_SYNCFORUM . ' /></form></td>';
            echo '</td>';
            echo '</tr>';
            echo '</table></td></tr></table>';
        }

        echo "</fieldset>";
        break;

    case "moderators":
        if ($forum) {
            $ff = &$forum_handler->get($forum);
        } else {
            redirect_header("admin_forum_manager.php?op=mod&amp;forum=$forum", 2, _AM_NEWBB_FORUM_ERROR);
            exit();
        }
        $cur_moderators = explode(' ', $ff->getVar('forum_moderator'));
        $new_moderators = array();
        $upd_moderators = array();
        foreach($cur_moderators as $moderator) {
            $new_moderators[$moderator] = 1;
        }
        if (isset($_POST['forum_moderator'])) {
            $add_moderators = $_POST['forum_moderator'];
            foreach($add_moderators as $moderator) {
                $new_moderators[$moderator] = 1;
            }
        }
        if (isset($_POST['rem_moderator'])) {
            $rem_moderators = $_POST['rem_moderator'];
            foreach($rem_moderators as $moderator) {
                $new_moderators[$moderator] = 0;
            }
        }
        foreach($new_moderators as $moderator => $val) {
            if ($val > 0) $upd_moderators[$moderator] = 1;
        }
        $forum_moderators = implode(' ', array_keys($upd_moderators));
        if ($ff->updateModerators($forum_moderators)) {
            redirect_header("admin_forum_manager.php?op=mod&amp;forum=$forum", 2, _AM_NEWBB_FORUMUPDATE);
            exit();
        } else {
            redirect_header("admin_forum_manager.php?op=mod&amp;forum=$forum", 2, _AM_NEWBB_FORUM_ERROR);
            exit();
        }

        break;

    case "saveall":

        if ($forum) {
            $ff = &$forum_handler->get($forum);
            $message = _AM_NEWBB_FORUMUPDATE;
        } else {
            $ff = &$forum_handler->create();
            $message = _AM_NEWBB_FORUMCREATED;
        }

        $ff->setVar('forum_name', $_POST['forum_name']);
        $ff->setVar('forum_desc', $_POST['forum_desc']);
        $ff->setVar('forum_order', $_POST['forum_order']);
        $ff->groups_forum_access = $_POST['groups_forum_access'];
        $ff->groups_forum_can_post = $_POST['group_ids'];
        $ff->groups_forum_can_view = $_POST['group_ids'];
        $ff->groups_forum_can_reply = $_POST['group_ids'];
        $ff->groups_forum_can_edit = $_POST['group_ids'];
        $ff->groups_forum_can_delete = $_POST['group_ids'];
        $ff->groups_forum_can_addpoll = $_POST['group_ids'];
        $ff->groups_forum_can_vote = $_POST['group_ids'];
        $ff->groups_forum_can_attach = $_POST['group_ids'];
        $ff->groups_forum_can_noapprove = $_POST['group_ids'];
        $ff->setVar('forum_moderator', $ff->getVar('forum_moderator'));
        $ff->setVar('parent_forum', $_POST['parent_forum']);
        $ff->setVar('cat_id', $_POST['cat_id']);
        $ff->setVar('forum_type', $_POST['forum_type']);
        $ff->setVar('allow_html', $_POST['allow_html']);
        $ff->setVar('allow_sig', $_POST['allow_sig']);
        $ff->setVar('allow_polls', $_POST['allow_polls']);
        $ff->setVar('allow_subject_prefix', $_POST['allow_subject_prefix']);
        $ff->setVar('allow_attachments', $_POST['allow_attachments']);
        $ff->setVar('attach_maxkb', $_POST['attach_maxkb']);
        $ff->setVar('attach_ext', $_POST['attach_ext']);
        $ff->setVar('hot_threshold', $_POST['hot_threshold']);
        if ($forum_handler->insert($ff)) {
            redirect_header("admin_forum_manager.php?op=mod&amp;forum=" . $ff->getVar('forum_id') . "", 2, $message);
            exit();
        } else {
            redirect_header("admin_forum_manager.php?op=mod&amp;forum=" . $ff->getVar('forum_id') . "", 2, _AM_NEWBB_FORUM_ERROR);
            exit();
        }

    case "savenone":

        if ($forum) {
            $ff = &$forum_handler->get($forum);
            $message = _AM_NEWBB_FORUMUPDATE;
        } else {
            $ff = &$forum_handler->create();
            $message = _AM_NEWBB_FORUMCREATED;
        }

        $ff->setVar('forum_name', $_POST['forum_name']);
        $ff->setVar('forum_desc', $_POST['forum_desc']);
        $ff->setVar('forum_order', $_POST['forum_order']);
        $ff->groups_forum_access = $_POST['groups_forum_access'];
        $ff->groups_forum_can_post = null;
        $ff->groups_forum_can_view = null;
        $ff->groups_forum_can_reply = null;
        $ff->groups_forum_can_edit = null;
        $ff->groups_forum_can_delete = null;
        $ff->groups_forum_can_addpoll = null;
        $ff->groups_forum_can_vote = null;
        $ff->groups_forum_can_attach = null;
        $ff->groups_forum_can_noapprove = null;
        $ff->setVar('forum_moderator', $ff->getVar('forum_moderator'));
        $ff->setVar('parent_forum', $_POST['parent_forum']);
        $ff->setVar('cat_id', $_POST['cat_id']);
        $ff->setVar('forum_type', $_POST['forum_type']);
        $ff->setVar('allow_html', $_POST['allow_html']);
        $ff->setVar('allow_sig', $_POST['allow_sig']);
        $ff->setVar('allow_polls', $_POST['allow_polls']);
        $ff->setVar('allow_subject_prefix', $_POST['allow_subject_prefix']);
        $ff->setVar('allow_attachments', $_POST['allow_attachments']);
        $ff->setVar('attach_maxkb', $_POST['attach_maxkb']);
        $ff->setVar('attach_ext', $_POST['attach_ext']);
        $ff->setVar('hot_threshold', $_POST['hot_threshold']);
        if ($forum_handler->insert($ff)) {
            redirect_header("admin_forum_manager.php?op=mod&amp;forum=" . $ff->getVar('forum_id') . "", 2, $message);
            exit();
        } else {
            redirect_header("admin_forum_manager.php?op=mod&amp;forum=" . $ff->getVar('forum_id') . "", 2, _AM_NEWBB_FORUM_ERROR);
            exit();
        }

    case "save":

        if ($forum) {
            $ff = &$forum_handler->get($forum);
            $message = _AM_NEWBB_FORUMUPDATE;
        } else {
            $ff = &$forum_handler->create();
            $message = _AM_NEWBB_FORUMCREATED;
        }

        $ff->setVar('forum_name', $_POST['forum_name']);
        $ff->setVar('forum_desc', $_POST['forum_desc']);
        $ff->setVar('forum_order', $_POST['forum_order']);
        $ff->groups_forum_access = @$_POST['groups_forum_access'];
        $ff->groups_forum_can_post = @$_POST['groups_forum_can_post'];
        $ff->groups_forum_can_view = @$_POST['groups_forum_can_view'];
        $ff->groups_forum_can_reply = @$_POST['groups_forum_can_reply'];
        $ff->groups_forum_can_edit = @$_POST['groups_forum_can_edit'];
        $ff->groups_forum_can_delete = @$_POST['groups_forum_can_delete'];
        $ff->groups_forum_can_addpoll = @$_POST['groups_forum_can_addpoll'];
        $ff->groups_forum_can_vote = @$_POST['groups_forum_can_vote'];
        $ff->groups_forum_can_attach = @$_POST['groups_forum_can_attach'];
        $ff->groups_forum_can_noapprove = @$_POST['groups_forum_can_noapprove'];
        $ff->setVar('forum_moderator', $ff->getVar('forum_moderator'));
        $ff->setVar('parent_forum', $_POST['parent_forum']);
        $ff->setVar('cat_id', $_POST['cat_id']);
        $ff->setVar('forum_type', @$_POST['forum_type']);
        $ff->setVar('allow_html', @$_POST['allow_html']);
        $ff->setVar('allow_sig', @$_POST['allow_sig']);
        $ff->setVar('allow_polls', $_POST['allow_polls']);
        $ff->setVar('allow_subject_prefix', @$_POST['allow_subject_prefix']);
        $ff->setVar('allow_attachments', $_POST['allow_attachments']);
        $ff->setVar('attach_maxkb', $_POST['attach_maxkb']);
        $ff->setVar('attach_ext', $_POST['attach_ext']);
        $ff->setVar('hot_threshold', $_POST['hot_threshold']);
        if ($forum_handler->insert($ff)) {
            redirect_header("admin_forum_manager.php?op=mod&amp;forum=" . $ff->getVar('forum_id') . "", 2, $message);
            exit();
        } else {
            redirect_header("admin_forum_manager.php?op=mod&amp;forum=" . $ff->getVar('forum_id') . "", 2, _AM_NEWBB_FORUM_ERROR);
            exit();
        }

    case "mod":
        $ff = &$forum_handler->get($forum);
        newbb_adminmenu(2, _AM_NEWBB_EDITTHISFORUM . $ff->getVar('forum_name'));
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_EDITTHISFORUM . "</legend>";
        echo"<br /><br /><table width='100%' border='0' cellspacing='1' class='outer'><tr><td class='odd'>";

        editForum($ff);

        echo"</td></tr></table>";
        echo "</fieldset>";
        break;

    case "del":

        if (isset($_POST['confirm']) != 1) {
            xoops_confirm(array('op' => 'del', 'forum' => intval($_GET['forum']), 'confirm' => 1), 'admin_forum_manager.php', _AM_NEWBB_TWDAFAP);
            break;
        } else {
            $ff = &$forum_handler->get($_POST['forum']);
            $forum_handler->delete($ff);
            redirect_header("admin_forum_manager.php", 1, _AM_NEWBB_FORUMREMOVED);
            exit();
        }
        break;

    case 'manage':
        newbb_adminmenu(2, _AM_NEWBB_FORUM_MANAGER);

        $category_handler = &xoops_getmodulehandler('category', 'newbb');
        $categories = $category_handler->getAllCats();
		$forums = $category_handler->getForums();

		$forums_array = array();
		foreach ($forums as $forumid => $forum) {
		    $forums_array[$forum->getVar('parent_forum')][] = array(
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

        // Output
        $echo = "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_FORUM_MANAGER . "</legend>";
        $echo .= "<br />";

        $echo .= "<table border='0' cellpadding='4' cellspacing='1' width='100%' class='outer'>";
        $echo .= "<tr align='center'>";
        $echo .= "<td class='bg3' colspan='2'>" . _AM_NEWBB_NAME . "</td>";
        $echo .= "<td class='bg3'>" . _AM_NEWBB_EDIT . "</td>";
        $echo .= "<td class='bg3'>" . _AM_NEWBB_DELETE . "</td>";
        $echo .= "<td class='bg3'>" . _AM_NEWBB_ADD . "</td>";
        $echo .= "<td class='bg3'>" . _AM_NEWBB_MOVE . "</td>";
        $echo .= "</tr>";

        foreach ($categories as $key => $category) {
            // Display the Category
            $cat_link = "<a href=\"" . $forumUrl['root'] . "/index.php?viewcat=" . $category->getVar('cat_id') . "\">" . $category->getVar('cat_title') . "</a>";
            $cat_edit_link = "<a href=\"admin_cat_manager.php?op=mod&amp;cat_id=" . $category->getVar('cat_id') . "\">".newbb_displayImage($forumImage['edit'], _EDIT)."</a>";
            $cat_del_link = "<a href=\"admin_cat_manager.php?op=del&amp;cat_id=" . $category->getVar('cat_id') . "\">".newbb_displayImage($forumImage['delete'], _DELETE)."</a>";
            $forum_add_link = "<a href=\"admin_forum_manager.php?op=addforum&amp;cat_id=" . $category->getVar('cat_id') . "\">".newbb_displayImage($forumImage['new_forum'])."</a>";

            $echo .= "<tr class='even' align='left'>";
            $echo .= "<td width='100%' colspan='2'><strong>" . $cat_link . "</strong></td>";
            $echo .= "<td align='center'>" . $cat_edit_link . "</td>";
            $echo .= "<td align='center'>" . $cat_del_link . "</td>";
            $echo .= "<td align='center'>" . $forum_add_link . "</td>";
            $echo .= "<td></td>";
            $echo .= "</tr>";

		    $forums = (!empty($forumsByCat[$category->getVar('cat_id')]))?$forumsByCat[$category->getVar('cat_id')]:array();
            if (count($forums)>0) {
		    	ksort($forums);
                foreach ($forums as $key => $forum) {
                    $f_link = "&nbsp;<a href=\"" . $forumUrl['root'] . "/viewforum.php?forum=" . $forum['forum_id'] . "\">" . $forum['forum_name'] . "</a>";
                    $f_edit_link = "<a href=\"admin_forum_manager.php?op=mod&amp;forum=" . $forum['forum_id'] . "\">".newbb_displayImage($forumImage['edit'])."</a>";
                    $f_del_link = "<a href=\"admin_forum_manager.php?op=del&amp;forum=" . $forum['forum_id'] . "\">".newbb_displayImage($forumImage['delete'])."</a>";
                    $sf_add_link = "<a href=\"admin_forum_manager.php?op=addsubforum&amp;cat_id=" . $forum['forum_cid'] . "&parent_forum=" . $forum['forum_id'] . "\">".newbb_displayImage($forumImage['new_subforum'])."</a>";
                    $f_move_link = "<a href=\"admin_forum_manager.php?op=moveforum&amp;forum=" . $forum['forum_id'] . "\">".newbb_displayImage($forumImage['move_topic'])."</a>";

                    $echo .= "<tr class='odd' align='left'><td></td>";
                    $echo .= "<td><strong>" . $f_link . "</strong></td>";
                    $echo .= "<td align='center'>" . $f_edit_link . "</td>";
                    $echo .= "<td align='center'>" . $f_del_link . "</td>";
                    $echo .= "<td align='center'>" . $sf_add_link . "</td>";
                    $echo .= "<td align='center'>" . $f_move_link . "</td>";
                    $echo .= "</tr>";

                    if(isset($forum['subforum'])){
                		foreach ($forum['subforum'] as $key => $subforum) {
	                        $f_link = "&nbsp;<a href=\"" . $forumUrl['root'] . "/viewforum.php?forum=" . $subforum['forum_id'] . "\">-->" . $subforum['forum_name'] . "</a>";
	                        $f_edit_link = "<a href=\"admin_forum_manager.php?op=mod&amp;forum=" . $subforum['forum_id'] . "\">".newbb_displayImage($forumImage['edit'])."</a>";
	                        $f_del_link = "<a href=\"admin_forum_manager.php?op=del&amp;forum=" . $subforum['forum_id'] . "\">".newbb_displayImage($forumImage['delete'])."</a>";
	                        $sf_add_link = "";
	                        $f_move_link = "<a href=\"admin_forum_manager.php?op=moveforum&amp;forum=" . $subforum['forum_id'] . "\">".newbb_displayImage($forumImage['move_topic'])."</a>";
		                    $echo .= "<tr class='odd' align='left'><td></td>";
		                    $echo .= "<td><strong>" . $f_link . "</strong></td>";
		                    $echo .= "<td align='center'>" . $f_edit_link . "</td>";
		                    $echo .= "<td align='center'>" . $f_del_link . "</td>";
		                    $echo .= "<td align='center'>" . $sf_add_link . "</td>";
		                    $echo .= "<td align='center'>" . $f_move_link . "</td>";
		                    $echo .= "</tr>";
	                	}
                    }
                }
            }
        }
        echo $echo;
        echo "</table>";
        echo "</fieldset>";
        break;

    case "default":
    default:
        newbb_adminmenu(2, _AM_NEWBB_CREATENEWFORUM);
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_CREATENEWFORUM . "</legend>";
        echo "<br />";

        newForum();

        echo "</fieldset>";
        break;

    case "addsubforum":
        newbb_adminmenu(2, _AM_NEWBB_CREATENEWFORUM);
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_CREATENEWFORUM . "</legend>";
        echo "<br />";
        $parent_forum = isset($_GET['parent_forum']) ? intval($_GET['parent_forum']) : null;

        newForum($parent_forum);

        echo "</fieldset>";

        break;
}
xoops_cp_footer();

?>