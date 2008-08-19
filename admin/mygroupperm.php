<?php 
// $Id: mygroupperm.php,v 1.1.1.8 2004/10/09 23:34:02 praedator Exp $
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
if (! defined('XOOPS_ROOT_PATH')) exit ;

function myDeleteByModule($DB, $gperm_modid, $gperm_name = null, $gperm_itemid = null)
{
    $criteria = new CriteriaCompo(new Criteria('gperm_modid', intval($gperm_modid)));
    if (isset($gperm_name)) {
        $criteria->add(new Criteria('gperm_name', $gperm_name));
        if (isset($gperm_itemid)) {
            $criteria->add(new Criteria('gperm_itemid', intval($gperm_itemid)));
        } 
    } 
    $sql = "DELETE FROM " . $DB->prefix('group_permission') . ' ' . $criteria->renderWhere();
    if (!$result = $DB->query($sql)) {
        return false;
    } 
    return true;
} 

$modid = isset($_POST['modid']) ? intval($_POST['modid']) : 1;
// we dont want system module permissions to be changed here ( 1 -> 0 GIJ)
if ($modid <= 0 || !is_object($xoopsUser) || !$xoopsUser->isAdmin($modid)) {
    redirect_header(XOOPS_URL . '/index.php', 1, _NOPERM);
    exit();
} 
$module_handler = &xoops_gethandler('module');
$module = &$module_handler->get($modid);
if (!is_object($module) || !$module->getVar('isactive')) {
    redirect_header(XOOPS_URL . '/admin.php', 1, _MODULENOEXIST);
    exit();
} 
$member_handler = &xoops_gethandler('member');
$group_list = &$member_handler->getGroupList();
if (is_array($_POST['perms']) && !empty($_POST['perms'])) {
    $gperm_handler = xoops_gethandler('groupperm');
    foreach ($_POST['perms'] as $perm_name => $perm_data) {
        foreach($perm_data['itemname' ] as $item_id => $item_name) {

            if (false != myDeleteByModule($gperm_handler->db, $modid, $perm_name, $item_id)) {
                if (empty($perm_data['groups'])) continue ;
                foreach ($perm_data['groups'] as $group_id => $item_ids) {

                    $selected = isset($item_ids[ $item_id ]) ? $item_ids[ $item_id ] : 0 ;
                    if ($selected == 1) {
                        // make sure that all parent ids are selected as well
                        if ($perm_data['parents'][$item_id] != '') {
                            $parent_ids = explode(':', $perm_data['parents'][$item_id]);
                            foreach ($parent_ids as $pid) {
                                if ($pid != 0 && !in_array($pid, array_keys($item_ids))) {
                                    // one of the parent items were not selected, so skip this item
                                    $msg[] = sprintf(_MD_AM_PERMADDNG, '<strong>' . $perm_name . '</strong>', '<strong>' . $perm_data['itemname'][$item_id] . '</strong>', '<strong>' . $group_list[$group_id] . '</strong>') . ' (' . _MD_AM_PERMADDNGP . ')';
                                    continue 2;
                                } 
                            } 
                        } 
                        $gperm = &$gperm_handler->create();
                        $gperm->setVar('gperm_groupid', $group_id);
                        $gperm->setVar('gperm_name', $perm_name);
                        $gperm->setVar('gperm_modid', $modid);
                        $gperm->setVar('gperm_itemid', $item_id);
                        if (!$gperm_handler->insert($gperm)) {
                            $msg[] = sprintf(_MD_AM_PERMADDNG, '<strong>' . $perm_name . '</strong>', '<strong>' . $perm_data['itemname'][$item_id] . '</strong>', '<strong>' . $group_list[$group_id] . '</strong>');
                        } else {
                            $msg[] = sprintf(_MD_AM_PERMADDOK, '<strong>' . $perm_name . '</strong>', '<strong>' . $perm_data['itemname'][$item_id] . '</strong>', '<strong>' . $group_list[$group_id] . '</strong>');
                        } 
                        unset($gperm);
                    } 
                } 
            } else {
                $msg[] = sprintf(_MD_AM_PERMRESETNG, $module->getVar('name'));
            } 
        } 
    } 
} 

?>