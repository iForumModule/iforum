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
include ICMS_ROOT_PATH . "/class/xoopstree.php";
//include_once ICMS_ROOT_PATH . "/class/pagenav.php";
 
$op = '';
$confirm = '';
 
if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];
if (isset($_POST['default'])) $op = 'default';
if (isset($_GET['forum'])) $forum = $_GET['forum'];
if (isset($_POST['forum'])) $forum = $_POST['forum'];
 
$forum_handler = icms_getmodulehandler('forum', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
/**
* newForum()
*
* @param integer $catid
* @return
*/
function newForum($parent_forum = 0)
{
	editForum(null, $parent_forum);
}
 
/**
* editForum()
*
* @param integer $catid
* @return
*/
function editForum($ff, $parent_forum = 0) {
	global $myts, $icmsModule, $forum_handler;
	 
	if (!is_object($ff)) {
		$ff = $forum_handler->create();
		$new = true;
		$forum = 0;
	} else {
		$forum = $ff->getVar('forum_id');
		$new = false;
	}
	if ($parent_forum > 0) {
		$pf = $forum_handler->get($parent_forum);
	}
	 
	$mytree = new XoopsTree(icms::$xoopsDB->prefix("bb_categories"), "cat_id", "0");
	 
	if ($forum) {
		$sform = new icms_form_Theme(_AM_IFORUM_EDITTHISFORUM . " " . $ff->getVar('forum_name'), "op", xoops_getenv('PHP_SELF'));
	} else {
		$sform = new icms_form_Theme(_AM_IFORUM_CREATENEWFORUM, "op", xoops_getenv('PHP_SELF'));
		 
		$ff->setVar('parent_forum', $parent_forum);
		$ff->setVar('forum_order', 0);
		$ff->setVar('forum_name', '');
		$ff->setVar('forum_desc', '');
		$ff->setVar('forum_moderator', array(1));
		 
		$ff->setVar('forum_type', 0);
		$ff->setVar('allow_html', 1);
		$ff->setVar('allow_sig', 1);
		$ff->setVar('allow_polls', 0);
		$ff->setVar('allow_subject_prefix', 0);
		$ff->setVar('hot_threshold', 10);
		$ff->setVar('attach_maxkb', 1000);
		$ff->setVar('attach_ext', 'zip|gif|jpg');
	}
	 
	$sform->addElement(new icms_form_elements_Text(_AM_IFORUM_FORUMNAME, 'forum_name', 50, 80, $ff->getVar('forum_name', 'E')), true);
	$sform->addElement(new icms_form_elements_Dhtmltextarea(_AM_IFORUM_FORUMDESCRIPTION, 'forum_desc', $ff->getVar('forum_desc', 'E'), 10, 60), false);
	 
	$sform->addElement(new icms_form_elements_Hidden('parent_forum', $ff->getVar('parent_forum')));
	if ($parent_forum == 0)
	{
		ob_start();
		if ($new)
		{
			$mytree->makeMySelBox("cat_title", "cat_id", @$_GET['cat_id']);
		}
		else
		{
			$mytree->makeMySelBox("cat_title", "cat_id", $ff->getVar('cat_id'));
		}
		$sform->addElement(new icms_form_elements_Label(_AM_IFORUM_CATEGORY, ob_get_contents()));
		ob_end_clean();
	}
	else
	{
		$sform->addElement(new icms_form_elements_Hidden('cat_id', $pf->getVar('cat_id')));
	}
	 
	$sform->addElement(new icms_form_elements_Text(_AM_IFORUM_SET_FORUMORDER, 'forum_order', 5, 10, $ff->getVar('forum_order')), false);
	$status_select = new icms_form_elements_Select(_AM_IFORUM_STATE, "forum_type", $ff->getVar('forum_type'));
	$status_select->addOptionArray(array('0' => _AM_IFORUM_ACTIVE, '1' => _AM_IFORUM_INACTIVE));
	$sform->addElement($status_select);
	 
	$allowhtml_radio = new icms_form_elements_Radioyn(_AM_IFORUM_ALLOWHTML, 'allow_html', $ff->getVar('allow_html'), '' . _YES . '', ' ' . _NO . '');
	$sform->addElement($allowhtml_radio);
	 
	$allowsig_radio = new icms_form_elements_Radioyn(_AM_IFORUM_ALLOWSIGNATURES, 'allow_sig', $ff->getVar('allow_sig'), '' . _YES . '', ' ' . _NO . '');
	$sform->addElement($allowsig_radio);
	 
	$allowpolls_radio = new icms_form_elements_Radioyn(_AM_IFORUM_ALLOWPOLLS, 'allow_polls', $ff->getVar('allow_polls'), '' . _YES . '', ' ' . _NO . '');
	$sform->addElement($allowpolls_radio);
	 
	$allowprefix_radio = new icms_form_elements_Radioyn(_AM_IFORUM_ALLOW_SUBJECT_PREFIX, 'allow_subject_prefix', $ff->getVar('allow_subject_prefix'), '' . _YES . '', ' ' . _NO . '');
	$sform->addElement($allowprefix_radio);
	 
	$sform->addElement(new icms_form_elements_Text(_AM_IFORUM_HOTTOPICTHRESHOLD, 'hot_threshold', 5, 10, $ff->getVar('hot_threshold')), true);
	 
	/*
	$allowattach_radio = new icms_form_elements_Radioyn(_AM_IFORUM_ALLOW_ATTACHMENTS, 'allow_attachments', $ff->getVar('allow_attachments'), '' . _YES . '', ' ' . _NO . '');
	$sform->addElement($allowattach_radio);
	*/
	$sform->addElement(new icms_form_elements_Text(_AM_IFORUM_ATTACHMENT_SIZE, 'attach_maxkb', 5, 10, $ff->getVar('attach_maxkb')), true);
	//$sform->addElement(new icms_form_elements_Text(_AM_IFORUM_ALLOWED_EXTENSIONS, 'attach_ext', 50, 255, $ff->getVar('attach_ext')), true);
	$ext = $ff->getVar('attach_ext');
	$sform->addElement(new icms_form_elements_Text(_AM_IFORUM_ALLOWED_EXTENSIONS, 'attach_ext', 50, 255, $ext), true);
	$sform->addElement(new icms_form_elements_select_User(_AM_IFORUM_MODERATOR, 'forum_moderator', false, $ff->getVar("forum_moderator"), 5, true));
	 
	$perm_tray = new icms_form_elements_Tray(_AM_IFORUM_PERMISSIONS_TO_THIS_FORUM, '');
	$perm_checkbox = new icms_form_elements_Checkbox('', 'perm_template', $ff->isNew());
	$perm_checkbox->addOption(1, _AM_IFORUM_PERM_TEMPLATEAPP);
	$perm_tray->addElement($perm_checkbox);
	$perm_tray->addElement(new icms_form_elements_Label('', '<a href="admin_permissions.php?action=template" target="_blank">'._AM_IFORUM_PERM_TEMPLATE.'</a>'));
	$sform->addElement($perm_tray);
	 
	$sform->addElement(new icms_form_elements_Hidden('forum', $forum));
	$sform->addElement(new icms_form_elements_Hidden('op', "save"));
	 
	$button_tray = new icms_form_elements_Tray('', '');
	$button_tray->addElement(new icms_form_elements_Button('', '', _SUBMIT, 'submit'));
	 
	$button_tray->addElement(new icms_form_elements_Button('', '', _AM_IFORUM_CLEAR, 'reset'));
	 
	$butt_cancel = new icms_form_elements_Button('', '', _CANCEL, 'button');
	$butt_cancel->setExtra('onclick="history.go(-1)"');
	$button_tray->addElement($butt_cancel);
	 
	$sform->addElement($button_tray);
	$sform->display();
}
icms_cp_header();
switch ($op)
{
	case 'moveforum':
	loadModuleAdminMenu(2, "");
	 
	if (!empty($_POST['dest']))
	{
		if (!empty($_GET['forum'])) $forum_id = (int)$_GET['forum'];
			if (!empty($_POST['forum'])) $forum_id = intval($_POST['forum']);
			 
		$dest = $_POST['dest'];
		if ($dest {
			0 }
		== "f")
		{
			$pid = substr($dest, 1);
			$forum =$forum_handler->get(intval($pid));
			$cid = $forum->getVar("cat_id");
			unset($forum);
		}
		else
		{
			$cid = intval($dest);
			$pid = 0;
		}
		$bMoved = 0;
		$errString = '';
		$value = "cat_id=" . $cid.", parent_forum=" . $pid;
		$sql_move = "UPDATE " . icms::$xoopsDB->prefix('bb_forums') . " SET " . $value . " WHERE forum_id=$forum_id";
		if ($result = icms::$xoopsDB->queryF($sql_move))
			{
			$bMoved = 1;
			$sql = "UPDATE " . icms::$xoopsDB->prefix('bb_forums') . " SET parent_forum = 0 WHERE parent_forum=$forum_id";
			$result = icms::$xoopsDB->queryF($sql);
		}
		 
		if (!$bMoved)
		{
			redirect_header('./admin_forum_manager.php?op=manage', 2, _AM_IFORUM_MSG_ERR_FORUM_MOVED);
		}
		else
		{
			redirect_header('./admin_forum_manager.php?op=manage', 2, _AM_IFORUM_MSG_FORUM_MOVED);
		}
		exit();
	}
	else
	{
		//loadModuleAdminMenu(2, "");
		 
		if (!empty($_POST['forum'])) $forum_id = (int)$_POST['forum'];
			if (!empty($_GET['forum'])) $forum_id = (int)$_GET['forum'];
			//$forum =$forum_handler->get($forum_id);
		 
		$box = '<select name="dest">';
		$box .= '<option value=0 selected>' . _AM_IFORUM_SELECT . '</option>';
		 
		$category_handler = icms_getmodulehandler('category', basename(dirname(__DIR__) ), 'iforum' );
		$categories = $category_handler->getAllCats('', true);
		$forums = $forum_handler->getForumsByCategory(array_keys($categories), '', false);
		 
		if (count($categories) > 0 && count($forums) > 0)
		{
			foreach(array_keys($forums) as $key)
			{
				$box .= "<option value=".$key."'>".$categories[$key]->getVar('cat_title')."</option>";
				foreach ($forums[$key] as $forumid => $_forum)
				{
					$box .= "<option value='f".$forumid."'>-- ".$_forum['title']."</option>";
				}
			}
		}
		unset($forums, $categories);
		$box .= '</select>';
		 
		echo '<form action="./admin_forum_manager.php" method="post" name="forummove" id="forummove">';
		echo '<input type="hidden" name="op" value="moveforum" />';
		echo '<input type="hidden" name="forum" value=' . $forum_id . ' />';
		echo '<table border="0" cellpadding="1" cellspacing="0" align="center" valign="top" width="95%"><tr>';
		echo '<td class="bg2" align="center"><strong>' . _AM_IFORUM_MOVETHISFORUM . '</strong></td>';
		echo '</tr>';
		echo '<tr><td class="bg1" align="center">' . $box . '</td></tr>';
		echo '<tr><td align="center"><input type="submit" name="save" value=' . _GO . ' class="button" /></td></tr>';
		echo '</table></form>';
	}
	break;
	 
	case 'mergeforum':
	loadModuleAdminMenu(2, "");
	 
	if (!empty($_POST['dest_forum']))
	{
		if (isset($_GET['forum'])) $forum_id = (int)$_GET['forum'];
			if (isset($_POST['forum'])) $forum_id = (int)$_POST['forum'];
			 
		$sql = "UPDATE " . icms::$xoopsDB->prefix('bb_posts') . " SET forum_id=" . $_POST['dest_forum'] . " WHERE forum_id=$forum";
		$result = icms::$xoopsDB->queryF($sql);
		$sql = "UPDATE " . icms::$xoopsDB->prefix('bb_topics') . " SET forum_id=" . $_POST['dest_forum'] . " WHERE forum_id=$forum";
		$result = icms::$xoopsDB->queryF($sql);
		$sql = "UPDATE " . icms::$xoopsDB->prefix('bb_forums') . " SET parent_forum = 0 WHERE parent_forum=$forum_id";
		$result = icms::$xoopsDB->queryF($sql);
		 
		$sql = "SELECT COUNT(*) AS count FROM " . icms::$xoopsDB->prefix('bb_posts') . " WHERE WHERE forum_id=$forum_id";
		$result = icms::$xoopsDB->query($sql);
		list($post_count) = icms::$xoopsDB->fetchArray($result);
		$sql = "SELECT COUNT(*) AS count FROM " . icms::$xoopsDB->prefix('bb_topics') . " WHERE WHERE forum_id=$forum_id";
		$result = icms::$xoopsDB->query($sql);
		list($topic_count) = icms::$xoopsDB->fetchArray($result);
		 
		$forum =$forum_handler->get($forum_id);
		$forum_handler->delete($forum);
		 
		if ($post_count || $topic_count)
		{
			redirect_header('./admin_forum_manager.php?op=manage', 2, _AM_IFORUM_MSG_ERR_FORUM_MERGED);
		}
		else
		{
			redirect_header('./admin_forum_manager.php?op=manage', 2, _AM_IFORUM_MSG_FORUM_MERGED);
		}
		exit();
	}
	else
	{
		//loadModuleAdminMenu(2, "");
		 
		if (isset($_GET['forum'])) $forum_id = (int)$_GET['forum'];
			if (isset($_POST['forum'])) $forum_id = (int)$_POST['forum'];
			//$forum =$forum_handler->get($forum_id);
		 
		$box = '<select name="dest_forum">';
		$box .= '<option value=0 selected>' . _AM_IFORUM_SELECT . '</option>';
		 
		//$category_handler = icms_getmodulehandler('category', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
		$forums = $forum_handler->getForumsByCategory(0, '', false);
		 
		if (count($forums) > 0)
		{
			foreach(array_keys($forums) as $key)
			{
				foreach ($forums[$key] as $f => $_forum)
				{
					$box .= "<option value='".$f."'>-- ".$_forum['title']."</option>";
					if (!isset($_forum["sub"]) || count($_forum["sub"]) == 0) continue;
					foreach (array_keys($_forum["sub"]) as $s)
					{
						$box .= "<option value='".$s."'>---- ".$_forum["sub"][$s]['title']."</option>";
					}
				}
			}
		}
		unset($forums);
		 
		echo '<form action="./admin_forum_manager.php" method="post" name="forummove" id="forummove">';
		echo '<input type="hidden" name="op" value="mergeforum" />';
		echo '<input type="hidden" name="forum" value=' . $forum_id . ' />';
		echo '<table border="0" cellpadding="1" cellspacing="0" align="center" valign="top" width="95%"><tr>';
		echo '<td class="bg2" align="center"><strong>' . _AM_IFORUM_MERGETHISFORUM . '</strong></td>';
		echo '</tr>';
		echo '<tr><td class="bg1" align="center">' . _AM_IFORUM_MERGETO_FORUM . '</td></tr>';
		echo '<tr><td class="bg1" align="center">' . $box . '</td></tr>';
		echo '<tr><td align="center"><input type="submit" name="save" value=' . _GO . ' class="button" /></td></tr>';
		echo '</form></table>';
	}
	break;
	 
	case 'sync':
	loadModuleAdminMenu(5, _AM_IFORUM_SYNCFORUM);
	if (isset($_POST['submit']))
	{
		iforum_synchronization();
		/*
		$topic_handler = icms_getmodulehandler('topic', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
		$topic_handler->synchronization();
		*/
		redirect_header("./index.php", 1, _AM_IFORUM_SYNCHING);
		exit();
	}
	else
	{
		//loadModuleAdminMenu(3, _AM_IFORUM_SYNCFORUM);
		echo '<fieldset style="border: #e8e8e8 1px solid;">
			<legend style="display: inline; font-weight: bold; color: #900;">' . _AM_IFORUM_SYNCFORUM . '</legend>';
		echo '<br /><br /><table width="100%" border="0" cellspacing="1" class="outer"><tr><td class="odd">';
		echo '<table border="0" cellpadding="1" cellspacing="1" width="100%">';
		echo '<tr class="bg3" align="left">';
		echo '<td>' . _AM_IFORUM_CLICKBELOWSYNC . '</td>';
		echo '</tr>';
		echo '<tr class="bg1" align="center">';
		echo '<td><form action="admin_forum_manager.php" method="post">';
		echo '<input type="hidden" name="op" value="sync"><input type="submit" name="submit" value=' . _AM_IFORUM_SYNCFORUM . ' /></form></td>';
		echo '</td>';
		echo '</tr>';
		echo '</table></td></tr></table>';
	}
	 
	echo "</fieldset>";
	break;
	 
	case "save":
	 
	if ($forum)
	{
		$ff =$forum_handler->get($forum);
		$message = _AM_IFORUM_FORUMUPDATE;
	}
	else
	{
		$ff =$forum_handler->create();
		$message = _AM_IFORUM_FORUMCREATED;
	}
	 
	$ff->setVar('forum_name', $_POST['forum_name']);
	$ff->setVar('forum_desc', $_POST['forum_desc']);
	$ff->setVar('forum_order', $_POST['forum_order']);
	$ff->setVar('forum_moderator', isset($_POST['forum_moderator'])?$_POST['forum_moderator']:array());
	$ff->setVar('parent_forum', @$_POST['parent_forum']);
	$ff->setVar('cat_id', $_POST['cat_id']);
	$ff->setVar('forum_type', @$_POST['forum_type']);
	$ff->setVar('allow_html', @$_POST['allow_html']);
	$ff->setVar('allow_sig', @$_POST['allow_sig']);
	$ff->setVar('allow_polls', $_POST['allow_polls']);
	$ff->setVar('allow_subject_prefix', @$_POST['allow_subject_prefix']);
	//$ff->setVar('allow_attachments', $_POST['allow_attachments']);
	$ff->setVar('attach_maxkb', $_POST['attach_maxkb']);
	$ff->setVar('attach_ext', $_POST['attach_ext']);
	$ff->setVar('hot_threshold', $_POST['hot_threshold']);
	if ($forum_handler->insert($ff))
	{
		if (!empty($_POST["perm_template"]))
		{
			$groupperm_handler =icms_getmodulehandler('permission', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
			$perm_template = $groupperm_handler->getTemplate();
			$member_handler = icms::handler('icms_member');
			$glist = $member_handler->getGroupList();
			$perms = array_map("trim", explode(',', FORUM_PERM_ITEMS));
			foreach(array_keys($glist) as $group)
			{
				foreach($perms as $perm)
				{
					$perm = "forum_".$perm;
					$ids = $groupperm_handler->getItemIds($perm, $group, $icmsModule->getVar("mid"));
					if (!in_array($ff->getVar("forum_id"), $ids))
					{
						if (empty($perm_template[$group][$perm]))
						{
							$groupperm_handler->deleteRight($perm, $ff->getVar("forum_id"), $group, $icmsModule->getVar("mid"));
						}
						else
							{
							$groupperm_handler->addRight($perm, $ff->getVar("forum_id"), $group, $icmsModule->getVar("mid"));
						}
					}
				}
			}
		}
		redirect_header("admin_forum_manager.php?op=manage", 2, $message);
		exit();
	}
	else
	{
		redirect_header("admin_forum_manager.php?op=mod&amp;forum=" . $ff->getVar('forum_id') . "", 2, _AM_IFORUM_FORUM_ERROR);
		exit();
	}
	 
	case "mod":
	$ff = $forum_handler->get($forum);
	loadModuleAdminMenu(2, _AM_IFORUM_EDITTHISFORUM . $ff->getVar('forum_name'));
	echo "<fieldset style='border: #e8e8e8 1px solid;'>
		<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_EDITTHISFORUM . "</legend>";
	echo"<br /><br /><table width='100%' border='0' cellspacing='1' class='outer'><tr><td class='odd'>";
	 
	editForum($ff);
	 
	echo"</td></tr></table>";
	echo "</fieldset>";
	break;
	 
	case "del":
	 
	if (isset($_POST['confirm']) != 1)
	{
		xoops_confirm(array('op' => 'del', 'forum' => (int)$_GET['forum'], 'confirm' => 1), 'admin_forum_manager.php', _AM_IFORUM_TWDAFAP);
		break;
	}
	else
	{
		$ff =$forum_handler->get($_POST['forum']);
		$forum_handler->delete($ff);
		redirect_header("admin_forum_manager.php?op=manage", 1, _AM_IFORUM_FORUMREMOVED);
		exit();
	}
	break;
	 
	case 'manage':
	loadModuleAdminMenu(2, _AM_IFORUM_FORUM_MANAGER);
	 
	$echo = "<fieldset style='border: #e8e8e8 1px solid;'>
		<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_FORUM_MANAGER . "</legend>";
	$echo .= "<br />";
	 
	$echo .= "<table border='0' cellpadding='4' cellspacing='1' width='100%' class='outer'>";
	$echo .= "<tr align='center'>";
	$echo .= "<td class='bg3' colspan='2'>" . _AM_IFORUM_NAME . "</td>";
	$echo .= "<td class='bg3'>" . _AM_IFORUM_EDIT . "</td>";
	$echo .= "<td class='bg3'>" . _AM_IFORUM_DELETE . "</td>";
	$echo .= "<td class='bg3'>" . _AM_IFORUM_ADD . "</td>";
	$echo .= "<td class='bg3'>" . _AM_IFORUM_MOVE . "</td>";
	$echo .= "<td class='bg3'>" . _AM_IFORUM_MERGE . "</td>";
	$echo .= "</tr>";
	 
	$category_handler =icms_getmodulehandler('category', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
	$categories = $category_handler->getAllCats('', true);
	$forums = $forum_handler->getForumsByCategory(array_keys($categories), '', false);
	foreach (array_keys($categories) as $c)
	{
		$category = $categories[$c];
		$cat_link = "<a href=\"" . $forumUrl['root'] . "/index.php?viewcat=" . $category->getVar('cat_id') . "\">" . $category->getVar('cat_title') . "</a>";
		$cat_edit_link = "<a href=\"admin_cat_manager.php?op=mod&amp;cat_id=" . $category->getVar('cat_id') . "\">".iforum_displayImage($forumImage['edit'], _EDIT)."</a>";
		$cat_del_link = "<a href=\"admin_cat_manager.php?op=del&amp;cat_id=" . $category->getVar('cat_id') . "\">".iforum_displayImage($forumImage['delete'], _DELETE)."</a>";
		$forum_add_link = "<a href=\"admin_forum_manager.php?op=addforum&amp;cat_id=" . $category->getVar('cat_id') . "\">".iforum_displayImage($forumImage['new_forum'])."</a>";
		 
		$echo .= "<tr class='even' align='left'>";
		$echo .= "<td width='100%' colspan='2'><strong>" . $cat_link . "</strong></td>";
		$echo .= "<td align='center'>" . $cat_edit_link . "</td>";
		$echo .= "<td align='center'>" . $cat_del_link . "</td>";
		$echo .= "<td align='center'>" . $forum_add_link . "</td>";
		$echo .= "<td></td>";
		$echo .= "<td></td>";
		$echo .= "</tr>";
		if (!isset($forums[$c])) continue;
		foreach(array_keys($forums[$c]) as $f)
		{
			$f_link = "&nbsp;<a href=\"" . $forumUrl['root'] . "/viewforum.php?forum=" . $f . "\">" . $forums[$c][$f]["title"] . "</a>";
			$f_edit_link = "<a href=\"admin_forum_manager.php?op=mod&amp;forum=" . $f . "\">".iforum_displayImage($forumImage['edit'])."</a>";
			$f_del_link = "<a href=\"admin_forum_manager.php?op=del&amp;forum=" . $f . "\">".iforum_displayImage($forumImage['delete'])."</a>";
			$sf_add_link = "<a href=\"admin_forum_manager.php?op=addsubforum&amp;cat_id=" . $c . "&parent_forum=" . $f . "\">".iforum_displayImage($forumImage['new_subforum'])."</a>";
			$f_move_link = "<a href=\"admin_forum_manager.php?op=moveforum&amp;forum=" . $f . "\">".iforum_displayImage($forumImage['move_topic'])."</a>";
			$f_merge_link = "<a href=\"admin_forum_manager.php?op=mergeforum&amp;forum=" . $f . "\">".iforum_displayImage($forumImage['move_topic'])."</a>";
			 
			$echo .= "<tr class='odd' align='left'><td></td>";
			$echo .= "<td><strong>" . $f_link . "</strong></td>";
			$echo .= "<td align='center'>" . $f_edit_link . "</td>";
			$echo .= "<td align='center'>" . $f_del_link . "</td>";
			$echo .= "<td align='center'>" . $sf_add_link . "</td>";
			$echo .= "<td align='center'>" . $f_move_link . "</td>";
			$echo .= "<td align='center'>" . $f_merge_link . "</td>";
			$echo .= "</tr>";
			if (!isset($forums[$c][$f]["sub"])) continue;
			foreach(array_keys($forums[$c][$f]["sub"]) as $s)
			{
				$f_link = "&nbsp;<a href=\"" . $forumUrl['root'] . "/viewforum.php?forum=" . $s . "\">-->" . $forums[$c][$f]["sub"][$s]["title"] . "</a>";
				$f_edit_link = "<a href=\"admin_forum_manager.php?op=mod&amp;forum=" . $s . "\">".iforum_displayImage($forumImage['edit'])."</a>";
				$f_del_link = "<a href=\"admin_forum_manager.php?op=del&amp;forum=" . $s . "\">".iforum_displayImage($forumImage['delete'])."</a>";
				$sf_add_link = "";
				$f_move_link = "<a href=\"admin_forum_manager.php?op=moveforum&amp;forum=" . $s . "\">".iforum_displayImage($forumImage['move_topic'])."</a>";
				$f_merge_link = "<a href=\"admin_forum_manager.php?op=mergeforum&amp;forum=" . $s . "\">".iforum_displayImage($forumImage['move_topic'])."</a>";
				$echo .= "<tr class='odd' align='left'><td></td>";
				$echo .= "<td><strong>" . $f_link . "</strong></td>";
				$echo .= "<td align='center'>" . $f_edit_link . "</td>";
				$echo .= "<td align='center'>" . $f_del_link . "</td>";
				$echo .= "<td align='center'>" . $sf_add_link . "</td>";
				$echo .= "<td align='center'>" . $f_move_link . "</td>";
				$echo .= "<td align='center'>" . $f_merge_link . "</td>";
				$echo .= "</tr>";
			}
		}
	}
	unset($forums, $categories);
	 
	echo $echo;
	echo "</table>";
	echo "</fieldset>";
	break;
	 
	case "addsubforum":
	/*
	loadModuleAdminMenu(2, _AM_IFORUM_CREATENEWFORUM);
	echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_IFORUM_CREATENEWFORUM . "</legend>";
	echo "<br />";
	$parent_forum = isset($_GET['parent_forum']) ? (int)$_GET['parent_forum'] : null;
	 
	newForum($parent_forum);
	 
	echo "</fieldset>";
	 
	break;
	*/
	 
	case "default":
	default:
	loadModuleAdminMenu(2, _AM_IFORUM_CREATENEWFORUM);
	echo "<fieldset style='border: #e8e8e8 1px solid;'>
		<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_CREATENEWFORUM . "</legend>";
	echo "<br />";
	 
	//$parent_forum = isset($_GET['parent_forum']) ? (int)$_GET['parent_forum'] : null;
	newForum(@(int)$_GET['parent_forum']);
	 
	echo "</fieldset>";
	break;
}
icms_cp_footer();
 
?>