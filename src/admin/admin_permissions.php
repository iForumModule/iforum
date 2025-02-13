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

/**
* Add category navigation to forum casscade structure
* <ol>Special points:
* <li> Use negative values for category IDs to avoid conflict between category and forum
* <li> Disabled checkbox for categories to avoid unnecessary permission items for categories in forum permission table
* </ol>
*
* Note: this is a __patchy__ solution. We should have a more extensible and flexible group permission management: not only for data architecture but also for management interface
*/

icms_cp_header();

loadModuleAdminMenu(3, _AM_IFORUM_PERM_PERMISSIONS );

$action = isset($_REQUEST['action']) ? strtolower($_REQUEST['action']) : "";
$module_id = icms::$module->getVar('mid');
$perms = array_map("trim", explode(',', FORUM_PERM_ITEMS));

switch($action)
{
	case "template":
	$opform = new icms_form_Simple(_AM_IFORUM_PERM_ACTION, 'actionform', 'admin_permissions.php', "get");
	$op_select = new icms_form_elements_Select("", 'action');
	$op_select->setExtra('onchange="document.forms.actionform.submit()"');
	$op_select->addOptionArray(array(
	"no" => _SELECT,
		"template" => _AM_IFORUM_PERM_TEMPLATE,
		"apply" => _AM_IFORUM_PERM_TEMPLATEAPP,
		"default" => _AM_IFORUM_PERM_SETBYGROUP ));
	$opform->addElement($op_select);
	$opform->display();

	$member_handler = icms::handler('icms_member');
	$glist = $member_handler->getGroupList();
	$elements = array();
	$iforumperm_handler =icms_getmodulehandler('permission', basename(dirname(__FILE__, 2)), 'iforum' );
	$perm_template = $iforumperm_handler->getTemplate($groupid = 0);
	foreach (array_keys($glist) as $i)
	{
		$selected = !empty($perm_template[$i]) ? array_keys($perm_template[$i]) :
		 array();
		$ret_ele = '<tr align="left" valign="top"><td class="head">'.$glist[$i].'</td>';
		$ret_ele .= '<td class="even">';
		$ret_ele .= '<table class="outer"><tr><td class="odd"><table><tr>';
		$ii = 0;
		$option_ids = array();
		foreach ($perms as $perm)
		{
			$ii++;
			if ($ii % 5 == 0 )
			{
				$ret_ele .= '</tr><tr>';
			}
			$checked = in_array("forum_".$perm, $selected)?" checked='checked'":
			"";
			$option_id = $perm.'_'.$i;
			$option_ids[] = $option_id;
			$ret_ele .= '<td><input name="perms['.$i.']['."forum_".$perm.']" id="'.$option_id.'" onclick="" value="1" type="checkbox"'.$checked.'>'.CONSTANT("_AM_IFORUM_CAN_".strtoupper($perm)).'<br></td>';
		}
		$ret_ele .= '</tr></table></td><td class="even">';
		$ret_ele .= _ALL.' <input id="checkall['.$i.']" type="checkbox" value="" onclick="var optionids = new Array('.implode(", ", $option_ids).'); xoopsCheckAllElements(optionids, \'checkall['.$i.']\')" />';
		$ret_ele .= '</td></tr></table>';
		$ret_ele .= '</td></tr>';
		$elements[] = $ret_ele;
	}
	$tray = new icms_form_elements_Tray('');
	$tray->addElement(new icms_form_elements_Hidden('action', 'template_save'));
	$tray->addElement(new icms_form_elements_Button('', 'submit', _SUBMIT, 'submit'));
	$tray->addElement(new icms_form_elements_Button('', 'reset', _CANCEL, 'reset'));
	$ret = '<h4>' . _AM_IFORUM_PERM_TEMPLATE . '</h4>' . _AM_IFORUM_PERM_TEMPLATE_DESC . '<br /><br /><br />';
	$ret .= "<form name='template' id='template' method='post'>\n<table width='100%' class='outer' cellspacing='1'>\n";
	$ret .= implode("\n", $elements);
	$ret .= '<tr align="left" valign="top"><td class="head"></td><td class="even">';
	$ret .= $tray->render();
	$ret .= '</td></tr>';
	$ret .= '</table></form>';
	echo $ret;
	break;

	case "template_save":
	$iforumperm_handler =icms_getmodulehandler('permission', basename(dirname(__FILE__, 2)), 'iforum' );
	$res = $iforumperm_handler->setTemplate($_POST['perms'], $groupid = 0);
	if ($res)
	{
		redirect_header("admin_permissions.php?action=template", 2, _AM_IFORUM_PERM_TEMPLATE_CREATED);
	}
	else
	{
		redirect_header("admin_permissions.php?action=template", 2, _AM_IFORUM_PERM_TEMPLATE_ERROR);
	}
	break;

	case "apply":
	$iforumperm_handler =icms_getmodulehandler('permission', basename(dirname(__FILE__, 2)), 'iforum' );
	$perm_template = $iforumperm_handler->getTemplate();
	if ($perm_template === null)
	{
		redirect_header("admin_permissions.php?action=template", 2, _AM_IFORUM_PERM_TEMPLATE);
	}

	$opform = new icms_form_Simple(_AM_IFORUM_PERM_ACTION, 'actionform', 'admin_permissions.php', "get");
	$op_select = new icms_form_elements_Select("", 'action');
	$op_select->setExtra('onchange="document.forms.actionform.submit()"');
	$op_select->addOptionArray(array("no" => _SELECT, "template" => _AM_IFORUM_PERM_TEMPLATE, "apply" => _AM_IFORUM_PERM_TEMPLATEAPP));
	$opform->addElement($op_select);
	$opform->display();

	$category_handler = icms_getmodulehandler('category', basename(dirname(__FILE__, 2)), 'iforum' );
	$categories = $category_handler->getAllCats("", true);

	$forum_handler =icms_getmodulehandler('forum', basename(dirname(__FILE__, 2)), 'iforum' );
	$forums = $forum_handler->getForumsByCategory(0, '', false);
	$fm_options = array();
	foreach (array_keys($categories) as $c)
	{
		$fm_options[-1 * $c] = "[".$categories[$c]->getVar('cat_title')."]";
		foreach(array_keys($forums[$c]) as $f)
		{
			$fm_options[$f] = $forums[$c][$f]["title"];
			if (!isset($forums[$c][$f]["sub"])) continue;
			foreach(array_keys($forums[$c][$f]["sub"]) as $s)
			{
				$fm_options[$s] = "-- ".$forums[$c][$f]["sub"][$s]["title"];
			}
		}
	}
	unset($forums, $categories);
	$fmform = new icms_form_Theme(_AM_IFORUM_PERM_TEMPLATEAPP, 'fmform', 'admin_permissions.php', "post");
	$fm_select = new icms_form_elements_Select(_AM_IFORUM_PERM_FORUMS, 'forums', null, 10, true);
	$fm_select->addOptionArray($fm_options);
	$fmform->addElement($fm_select);
	$tray = new icms_form_elements_Tray('');
	$tray->addElement(new icms_form_elements_Hidden('action', 'apply_save'));
	$tray->addElement(new icms_form_elements_Button('', 'submit', _SUBMIT, 'submit'));
	$tray->addElement(new icms_form_elements_Button('', 'reset', _CANCEL, 'reset'));
	$fmform->addElement($tray);
	$fmform->display();
	break;

	case "apply_save":
	if (empty($_POST["forums"])) break;
	$iforumperm_handler = icms_getmodulehandler('permission', basename(dirname(__FILE__, 2)), 'iforum' );
	foreach($_POST["forums"] as $forum)
	{
		if ($forum < 1) continue;
		$iforumperm_handler->applyTemplate($forum, $module_id);
	}
	redirect_header("admin_permissions.php", 2, _AM_IFORUM_PERM_TEMPLATE_APPLIED);
	break;

	default:

	$opform = new icms_form_Simple(_AM_IFORUM_PERM_ACTION, 'actionform', 'admin_permissions.php', "get");
	$op_select = new icms_form_elements_Select("", 'action');
	$op_select->setExtra('onchange="document.forms.actionform.submit()"');
	$op_select->addOptionArray(array(
	"no" => _SELECT,
		"template" => _AM_IFORUM_PERM_TEMPLATE,
		"apply" => _AM_IFORUM_PERM_TEMPLATEAPP,
		"default" => _AM_IFORUM_PERM_SETBYGROUP ));
	$opform->addElement($op_select);
	$opform->display();

	$forum_handler = icms_getmodulehandler('forum', basename(dirname(__FILE__, 2)), 'iforum' );
	$forums = $forum_handler->getForumsByCategory(0, '', false);
	$op_options = array("category" => _AM_IFORUM_CAT_ACCESS);
	$fm_options = array("category" => array("title" => _AM_IFORUM_CAT_ACCESS, "item" => "category_access", "desc" => "", "anonymous" => true));
	foreach($perms as $perm)
	{
		$op_options[$perm] = CONSTANT("_AM_IFORUM_CAN_".strtoupper($perm));
		$fm_options[$perm] = array("title" => CONSTANT("_AM_IFORUM_CAN_".strtoupper($perm)), "item" => "forum_".$perm, "desc" => "", "anonymous" => true);
	}

	$op_keys = array_keys($op_options);
	$op = isset($_GET['op']) ? strtolower($_GET['op']) :
	 (isset($_COOKIE['op']) ? strtolower($_COOKIE['op']):"");
	if (empty($op))
	{
		$op = $op_keys[0];
		setCookie("op", isset($op_keys[1])?$op_keys[1]:"");
	}
	else
	{
		for($i = 0; $i < count($op_keys); $i++)
		{
			if ($op_keys[$i] == $op) break;
		}
		setCookie("op", isset($op_keys[$i+1])?$op_keys[$i+1]:"");
	}

	$opform = new icms_form_Simple('', 'opform', 'admin_permissions.php', "get");
	$op_select = new icms_form_elements_Select("", 'op', $op);
	$op_select->setExtra('onchange="document.forms.opform.submit()"');
	$op_select->addOptionArray($op_options);
	$opform->addElement($op_select);
	$opform->display();

	$perm_desc = "";

	$form = new icms_form_Groupperm($fm_options[$op]["title"], $module_id, $fm_options[$op]["item"], $fm_options[$op]["desc"], 'admin/admin_permissions.php', $fm_options[$op]["anonymous"]);

	$category_handler = icms_getmodulehandler('category', basename(dirname(__FILE__, 2)), 'iforum' );
	$categories = $category_handler->getAllCats("", true);
	if ($op == "category")
	{
		foreach (array_keys($categories) as $c)
		{
			$form->addItem($c, $categories[$c]->getVar('cat_title'));
		}
		unset($categories);
	}
	else
	{
		foreach (array_keys($categories) as $c)
		{
			$key_c = -1 * $c;
			$form->addItem($key_c, "<strong>[".$categories[$c]->getVar('cat_title')."]</strong>");
			if($forums[$c]) {
                foreach(array_keys($forums[$c]) as $f)
                {
                    $form->addItem($f, $forums[$c][$f]["title"], $key_c);
                    if (!isset($forums[$c][$f]["sub"])) continue;
                    foreach(array_keys($forums[$c][$f]["sub"]) as $s)
                    {
                        $form->addItem($s, "&rarr;".$forums[$c][$f]["sub"][$s]["title"], $f);
                    }
                }
            }
		}
		unset($forums, $categories);
	}
	$form->display();

	break;
}

icms_cp_footer();
?>
