<?php
// $Id: admin_permissions.php,v 1.1.1.1 2005/10/19 15:58:12 phppp Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: XOOPS Foundation                                                  //
// URL: http://www.xoops.org/                                                //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
include 'admin_header.php';
xoops_cp_header();

loadModuleAdminMenu(3);

$action = isset($_REQUEST['action']) ? strtolower($_REQUEST['action']) : "";
$module_id = $xoopsModule->getVar('mid');
$perms = array_map("trim",explode(',', FORUM_PERM_ITEMS));

switch($action){
	case "template":
		
		$opform = new XoopsSimpleForm(_AM_NEWBB_PERM_ACTION, 'actionform', 'admin_permissions.php', "get");
		$op_select = new XoopsFormSelect("", 'action');
		$op_select->setExtra('onchange="document.forms.actionform.submit()"');
		$op_select->addOptionArray(array(
			"no"=>_SELECT, 
			"template"=>_AM_NEWBB_PERM_TEMPLATE, 
			"apply"=>_AM_NEWBB_PERM_TEMPLATEAPP,
			"default"=>_AM_NEWBB_PERM_SETBYGROUP
			));
		$opform->addElement($op_select);
		$opform->display();
		
        $member_handler =& xoops_gethandler('member');
        $glist =& $member_handler->getGroupList();
        $elements = array();
        $newbbperm_handler = &xoops_getmodulehandler('permission', 'newbb');
        $perm_template = $newbbperm_handler->getTemplate($groupid = 0);
        foreach (array_keys($glist) as $i) {
            $selected = !empty($perm_template[$i])?array_keys($perm_template[$i]):array();
            $ret_ele  = '<tr align="left" valign="top"><td class="head">'.$glist[$i].'</td>';
			$ret_ele .= '<td class="even">';
			$ret_ele .= '<table class="outer"><tr><td class="odd"><table><tr>';
			$ii = 0;
			foreach ($perms as $perm) {
				$ii++;
				if($ii%5==0){
					$ret_ele .= '</tr><tr>';
				}
				$checked = in_array("forum_".$perm, $selected)?" checked='checked'":"";
				$ret_ele .='<td><input name="perms['.$i.']['."forum_".$perm.']" id="perms['.$i.']" onclick="" value="1" type="checkbox"'.$checked.'>'.CONSTANT("_AM_NEWBB_CAN_".strtoupper($perm)).'<br></td>';
			}
			$ret_ele .= '</tr></table></td><td class="even">';
			$ret_ele .= _ALL.' <input id="checkall['.$i.']" type="checkbox" value="" onclick="xoopsCheckGroup(\'template\', \'checkall['.$i.']\', \'perms['.$i.']\')" />';
			$ret_ele .= '</td></tr></table>';
			$ret_ele .= '</td></tr>';
            $elements[] = $ret_ele;
        } 
        $tray = new XoopsFormElementTray('');
        $tray->addElement(new XoopsFormHidden('action', 'template_save'));
        $tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $tray->addElement(new XoopsFormButton('', 'reset', _CANCEL, 'reset'));
     	$ret = '<h4>' . _AM_NEWBB_PERM_TEMPLATE . '</h4>' . _AM_NEWBB_PERM_TEMPLATE_DESC . '<br /><br /><br />';
        $ret .= "<form name='template' id='template' method='post'>\n<table width='100%' class='outer' cellspacing='1'>\n";
        $ret .= implode("\n",$elements);
		$ret .= '<tr align="left" valign="top"><td class="head"></td><td class="even">';
        $ret .= $tray->render();
		$ret .= '</td></tr>';
        $ret .= '</table></form>';
        echo $ret;
        break;	
	case "template_save":
        $newbbperm_handler = &xoops_getmodulehandler('permission', 'newbb');
        $res = $newbbperm_handler->setTemplate($_POST['perms'], $groupid = 0);
        if($res){
	    	redirect_header("admin_permissions.php?action=template", 2, _AM_NEWBB_PERM_TEMPLATE_CREATED);
        }else{
	    	redirect_header("admin_permissions.php?action=template", 2, _AM_NEWBB_PERM_TEMPLATE_ERROR);
        }
		break;
	case "apply":
        $newbbperm_handler = &xoops_getmodulehandler('permission', 'newbb');
	    $perm_template = $newbbperm_handler->getTemplate();
		if($perm_template===null){
	    	redirect_header("admin_permissions.php?action=template", 2, _AM_NEWBB_PERM_TEMPLATE);
		}
		
		$opform = new XoopsSimpleForm(_AM_NEWBB_PERM_ACTION, 'actionform', 'admin_permissions.php', "get");
		$op_select = new XoopsFormSelect("", 'action');
		$op_select->setExtra('onchange="document.forms.actionform.submit()"');
		$op_select->addOptionArray(array("no"=>_SELECT, "template"=>_AM_NEWBB_PERM_TEMPLATE, "apply"=>_AM_NEWBB_PERM_TEMPLATEAPP));
		$opform->addElement($op_select);
		$opform->display();
		
		$category_handler = &xoops_getmodulehandler('category', 'newbb');
		$forums = $category_handler->getForums(0, '', false);
		$fm_options = array();
		foreach (array_keys($forums) as $c) {
			foreach(array_keys($forums[$c]) as $f){
				$fm_options[$f] = $forums[$c][$f]["title"];
		        if(!isset($forums[$c][$f]["sub"])) continue;
				foreach(array_keys($forums[$c][$f]["sub"]) as $s){
					$fm_options[$s] = "-- ".$forums[$c][$f]["sub"][$s]["title"];
				}
			}
		}
		unset($forums);		
		$fmform = new XoopsThemeForm(_AM_NEWBB_PERM_TEMPLATEAPP, 'fmform', 'admin_permissions.php', "post");
		$fm_select = new XoopsFormSelect(_AM_NEWBB_PERM_FORUMS, 'forums', null, 5, true);
		$fm_select->addOptionArray($fm_options);
		$fmform->addElement($fm_select);
        $tray = new XoopsFormElementTray('');
        $tray->addElement(new XoopsFormHidden('action', 'apply_save'));
        $tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $tray->addElement(new XoopsFormButton('', 'reset', _CANCEL, 'reset'));
		$fmform->addElement($tray);
		$fmform->display();
		break;
		
	case "apply_save":
		if(empty($_POST["forums"])) break;
	    $newbbperm_handler = &xoops_getmodulehandler('permission', 'newbb');
		foreach($_POST["forums"] as $forum){
			$newbbperm_handler->applyTemplate($forum, $module_id);
		}
	    redirect_header("admin_permissions.php", 2, _AM_NEWBB_PERM_TEMPLATE_APPLIED);
		break;
		/*
	    $perm_template = $newbbperm_handler->getTemplate();
		$groupperm_handler =& xoops_gethandler('groupperm');
	    $member_handler =& xoops_gethandler('member');
	    $glist =& $member_handler->getGroupList();
		foreach(array_keys($glist) as $group){
		    foreach($perms as $perm){
			    $perm = "forum_".$perm;
				$ids = $groupperm_handler->getItemIds($perm, $group, $module_id);
				$ids_dif = array_diff($_POST["forums"], $ids);
				foreach($ids_dif as $id){
					if(empty($perm_template[$group][$perm])){
						// deleteRight is not defined other versions than XOOPS 2.2*
						//$groupperm_handler->deleteRight($perm, $id, $group, $module_id);
				        $criteria = new CriteriaCompo(new Criteria('gperm_name', $perm));
				        $criteria->add(new Criteria('gperm_groupid', $group));
				        $criteria->add(new Criteria('gperm_itemid', $id));
				        $criteria->add(new Criteria('gperm_modid', $module_id));
				        $perms_obj = $groupperm_handler->getObjects($criteria);
				        if (!empty($perms_obj)) {
					        foreach($perms_obj as $perm_obj){
				            	$groupperm_handler->delete($perm_obj);
					        }
				        }
				        unset($criteria, $perms_obj);
					}else{
						$groupperm_handler->addRight($perm, $id, $group, $module_id);
					}
				}
		    }
		}
	    redirect_header("admin_permissions.php", 2, _AM_NEWBB_PERM_TEMPLATE_APPLIED);
		break;
		*/
		
	default:
		
		$opform = new XoopsSimpleForm(_AM_NEWBB_PERM_ACTION, 'actionform', 'admin_permissions.php', "get");
		$op_select = new XoopsFormSelect("", 'action');
		$op_select->setExtra('onchange="document.forms.actionform.submit()"');
		$op_select->addOptionArray(array(
			"no"=>_SELECT, 
			"template"=>_AM_NEWBB_PERM_TEMPLATE, 
			"apply"=>_AM_NEWBB_PERM_TEMPLATEAPP,
			"default"=>_AM_NEWBB_PERM_SETBYGROUP
			));
		$opform->addElement($op_select);
		$opform->display();
		
		$category_handler = &xoops_getmodulehandler('category', 'newbb');
		$forums = $category_handler->getForums(0, '', false);
		$op_options = array("category"=>_AM_NEWBB_CAT_ACCESS);
		$fm_options = array("category"=>array("title"=>_AM_NEWBB_CAT_ACCESS, "item"=>"category_access", "desc"=>"", "anonymous"=>true));
		foreach($perms as $perm){
			$op_options[$perm] = CONSTANT("_AM_NEWBB_CAN_".strtoupper($perm));
			$fm_options[$perm] = array("title"=>CONSTANT("_AM_NEWBB_CAN_".strtoupper($perm)), "item"=>"forum_".$perm, "desc"=>"", "anonymous"=>true);
		}
		
		$op_keys = array_keys($op_options);
		$op = isset($_GET['op']) ? strtolower($_GET['op']) : (isset($_COOKIE['op']) ? strtolower($_COOKIE['op']):"");
		if(empty($op)){
			$op = $op_keys[0];
			setCookie("op", isset($op_keys[1])?$op_keys[1]:"");
		}else{
			for($i=0;$i<count($op_keys);$i++){
				if($op_keys[$i]==$op) break;
			}
			setCookie("op", isset($op_keys[$i+1])?$op_keys[$i+1]:"");
		}
		
		$opform = new XoopsSimpleForm('', 'opform', 'admin_permissions.php', "get");
		$op_select = new XoopsFormSelect("", 'op', $op);
		$op_select->setExtra('onchange="document.forms.opform.submit()"');
		$op_select->addOptionArray($op_options);
		$opform->addElement($op_select);
		$opform->display();
		
		$perm_desc = "";
		include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
		$form = new XoopsGroupPermForm($fm_options[$op]["title"], $module_id, $fm_options[$op]["item"], $fm_options[$op]["desc"], 'admin/admin_permissions.php', $fm_options[$op]["anonymous"]);
		
		if($op=="category"){
			$categories = $category_handler->getAllCats("", true);
			foreach (array_keys($categories) as $key) {
				$form->addItem($key, $categories[$key]->getVar('cat_title'));
			}
			unset($categories);
		}else{
			foreach (array_keys($forums) as $c) {
				foreach(array_keys($forums[$c]) as $f){
			        $form->addItem($f, $forums[$c][$f]["title"]);
			        if(!isset($forums[$c][$f]["sub"])) continue;
					foreach(array_keys($forums[$c][$f]["sub"]) as $s){
			        	$form->addItem($s, "&rarr;".$forums[$c][$f]["sub"][$s]["title"]);
					}
				}
			}
		}
		$form->display();
		
		break;
}

/*
	$op_options = array();
	foreach (array_keys($forums) as $c) {
		foreach(array_keys($forums[$c]) as $f){
			$op_options[$f] = $forums[$c][$f]["title"];
	        if(!isset($forums[$c][$f]["sub"])) continue;
			foreach(array_keys($forums[$c][$f]["sub"]) as $s){
				$op_options[$s] = "-- ".$forums[$c][$f]["sub"][$s]["title"];
			}
		}
	}
	unset($forums);
	$fm_options = array();
*/

xoops_cp_footer();
?>