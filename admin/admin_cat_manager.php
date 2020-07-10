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
icms_cp_header();
 
$op = !empty($_GET['op'])? $_GET['op'] :
 (!empty($_POST['op'])?$_POST['op']:"");
$cat_id = (int)(!empty($_GET['cat_id']) ? $_GET['cat_id'] : (!empty($_POST['cat_id']) ? $_POST['cat_id'] : 0));
 
$category_handler = icms_getmodulehandler('category', basename(dirname(__DIR__) ), 'iforum' );
 
/**
* newCategory()
*
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
	$category_handler =icms_getmodulehandler('category', basename(dirname(__DIR__) ), 'iforum' );
	if ($cat_id > 0)
	{
		$fc = $category_handler->get($cat_id);
	}
	else
	{
		$fc = $category_handler->create();
	}
	$groups_cat_access = null;
	global $icmsModule;
	 
	if ($cat_id)
	{
		$sform = new icms_form_Theme(_AM_IFORUM_EDITCATEGORY . " " . $fc->getVar('cat_title'), "op", xoops_getenv('PHP_SELF'));
	}
	else
	{
		$sform = new icms_form_Theme(_AM_IFORUM_CREATENEWCATEGORY, "op", xoops_getenv('PHP_SELF'));
		$fc->setVar('cat_title', '');
		$fc->setVar('cat_image', 'blank.gif');
		$fc->setVar('cat_description', '');
		$fc->setVar('cat_order', 0);
		$fc->setVar('cat_url', 'http://www.impresscms.org ImpressCMS');
	}
	 
	$sform->addElement(new icms_form_elements_Text(_AM_IFORUM_SETCATEGORYORDER, 'cat_order', 5, 10, $fc->getVar('cat_order')), false);
	$sform->addElement(new icms_form_elements_Text(_AM_IFORUM_CATEGORY, 'title', 50, 80, $fc->getVar('cat_title', 'E')), true);
	$sform->addElement(new icms_form_elements_Dhtmltextarea(_AM_IFORUM_CATEGORYDESC, 'catdescript', $fc->getVar('cat_description', 'E'), 10, 60), false);
	 
	$imgdir = "/modules/" . $icmsModule->getVar("dirname") . "/images/category";
	if (!$fc->getVar("cat_image")) $fc->setVar('cat_image', 'blank.gif');
		$graph_array = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . $imgdir."/", "", array('gif', 'jpg', 'png'));
	array_unshift($graph_array, _NONE);
	$indeximage_select = new icms_form_elements_Select('', 'indeximage', $fc->getVar('cat_image'));
	$indeximage_select->addOptionArray($graph_array);
	$indeximage_select->setExtra("onchange=\"showImgSelected('img', 'indeximage', '/".$imgdir."/', '', '" . ICMS_URL . "')\"");
	$indeximage_tray = new icms_form_elements_Tray(_AM_IFORUM_IMAGE, '&nbsp;');
	$indeximage_tray->addElement($indeximage_select);
	$indeximage_tray->addElement(new icms_form_elements_Label('', "<br /><img src='" . ICMS_URL . $imgdir . "/" . $fc->getVar('cat_image') . " 'name='img' id='img' alt='' />"));
	$sform->addElement($indeximage_tray);
	 
	$sform->addElement(new icms_form_elements_Text(_AM_IFORUM_SPONSORLINK, 'sponurl', 50, 80, $fc->getVar('cat_url', 'E')), false);
	$sform->addElement(new icms_form_elements_Hidden('cat_id', $cat_id));
	 
	$button_tray = new icms_form_elements_Tray('', '');
	$button_tray->addElement(new icms_form_elements_Hidden('op', 'save'));
	 
	$butt_save = new icms_form_elements_Button('', '', _SUBMIT, 'submit');
	$butt_save->setExtra('onclick="this.form.elements.op.value=\'save\'"');
	$button_tray->addElement($butt_save);
	if ($cat_id)
	{
		$butt_delete = new icms_form_elements_Button('', '', _CANCEL, 'submit');
		$butt_delete->setExtra('onclick="this.form.elements.op.value=\'default\'"');
		$button_tray->addElement($butt_delete);
	}
	$sform->addElement($button_tray);
	$sform->display();
}
 
switch ($op)
{
	case "manage":
	$categories = $category_handler->getAllCats();
	if (count($categories) == 0)
	{
		loadModuleAdminMenu(1, _AM_IFORUM_CREATENEWCATEGORY);
		echo " <fieldset style='border: #e8e8e8 1px solid;'>
			<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_CREATENEWCATEGORY . "</legend>";
		echo "<br />";
		newCategory();
		echo "</fieldset>";
		 
		break;
	}
	 
	loadModuleAdminMenu(1, _AM_IFORUM_CATADMIN);
	echo "<fieldset style='border: #e8e8e8 1px solid;'>
		<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_CATADMIN . "</legend>";
	echo"<br />";
	echo "<a style='border: 1px solid #5E5D63; color: #000000; font-family: verdana, tahoma, arial, helvetica, sans-serif; font-size: 1em; padding: 4px 8px; text-align:center;' href='admin_cat_manager.php'>" . _AM_IFORUM_CREATENEWCATEGORY . "</a><br /><br />";
	 
	echo "<table border='0' cellpadding='4' cellspacing='1' width='100%' class='outer'>";
	echo "<tr align='center'>";
	echo "<td class='bg3'>" . _AM_IFORUM_CATEGORY1 . "</td>";
	//echo "<td class='bg3' width='10%'>" . _AM_IFORUM_STATE . "</td>";
	echo "<td class='bg3' width='10%'>" . _AM_IFORUM_EDIT . "</td>";
	echo "<td class='bg3' width='10%'>" . _AM_IFORUM_DELETE . "</td>";
	echo "</tr>";
	 
	foreach($categories as $key => $onecat)
	{
		$cat_edit_link = "<a href=\"admin_cat_manager.php?op=mod&cat_id=" . $onecat->getVar('cat_id') . "\">".iforum_displayImage($forumImage['edit'], _EDIT)."</a>";
		$cat_del_link = "<a href=\"admin_cat_manager.php?op=del&cat_id=" . $onecat->getVar('cat_id') . "\">".iforum_displayImage($forumImage['delete'], _DELETE)."</a>";
		$cat_title_link = "<a href=\"".ICMS_URL."/modules/".$icmsModule->getVar("dirname")."/index.php?cat=" . $onecat->getVar('cat_id') . "\">".$onecat->getVar('cat_title')."</a>";
		 
		echo "<tr class='odd' align='left'>";
		echo "<td>" . $cat_title_link . "</td>";
		echo "<td align='center'>" . $cat_edit_link . "</td>";
		echo "<td align='center'>" . $cat_del_link . "</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "</fieldset>";
	break;
	 
	case "mod":
	$fc =$category_handler->get($cat_id);
	loadModuleAdminMenu(1, _AM_IFORUM_EDITCATEGORY . $fc->getVar('cat_title'));
	echo "<fieldset style='border: #e8e8e8 1px solid;'>
		<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_EDITCATEGORY . "</legend>";
	echo"<br />";
	 
	editCategory($cat_id);
	 
	echo "</fieldset>";
	break;
	 
	case "del":
	if (empty($_POST['confirm']))
	{
		xoops_confirm(array('op' => 'del', 'cat_id' => (int)$_GET['cat_id'], 'confirm' => 1), 'admin_cat_manager.php', _AM_IFORUM_WAYSYWTDTTAL);
		break;
	}
	else
	{
		$fc =$category_handler->create(false);
		$fc->setVar('cat_id', $_POST['cat_id']);
		$category_handler->delete($fc);
		 
		redirect_header("admin_cat_manager.php", 2, _AM_IFORUM_CATEGORYDELETED);
	}
	break;
	 
	case "save":
	 
	if ($cat_id)
	{
		$fc =$category_handler->get($cat_id);
		$message = _AM_IFORUM_CATEGORYUPDATED;
	}
	else
	{
		$fc =$category_handler->create();
		$message = _AM_IFORUM_CATEGORYCREATED;
	}
	 
	$fc->setVar('cat_title', @$_POST['title']);
	$fc->setVar('cat_image', $_POST['indeximage']);
	$fc->setVar('cat_order', $_POST['cat_order']);
	$fc->setVar('cat_description', @$_POST['catdescript']);
	//$fc->setVar('cat_state', $_POST['state']);
	$fc->setVar('cat_url', @$_POST['sponurl']);
	//$fc->setVar('cat_showdescript', @$_POST['show']);
	 
	if (!$category_handler->insert($fc))
	{
		$message = _AM_IFORUM_DATABASEERROR;
	}
	if ($cat_id = $fc->getVar("cat_id") && $fc->isNew())
	{
		$gperm_handler = icms::handler("icms_member_groupperm");
		$group_list = array(ICMS_GROUP_ADMIN, ICMS_GROUP_USERS, ICMS_GROUP_ANONYMOUS);
		foreach ($group_list as $group_id)
		{
			$gperm_handler->addRight("category_access", $cat_id, $group_id, $icmsModule->getVar("mid"));
		}
	}
	redirect_header("admin_cat_manager.php?op=manage", 2, $message);
	exit();
	 
	case "default":
	default:
	loadModuleAdminMenu(1, _AM_IFORUM_CREATENEWCATEGORY);
	echo "<fieldset style='border: #e8e8e8 1px solid;'>
		<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_CREATENEWCATEGORY . "</legend>";
	echo "<br />";
	newCategory();
	echo "</fieldset>";
}
 
icms_cp_footer();