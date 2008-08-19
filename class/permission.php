<?php 
// $Id: permission.php,v 1.1.1.18 2004/10/10 00:37:07 phppp Exp $
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
if (!defined('FORUM_PERM_ITEMS')) define('FORUM_PERM_ITEMS', 'post,view,reply,edit,delete,addpoll,vote,attach,noapprove');

class NewbbPermissionHandler extends XoopsObjectHandler {
    /**
     * Saves permissions for the selected category
     * 
     *   saveCategory_Permissions()
     * 
     * @param array $groups : group with granted permission
     * @param integer $categoryID : categoryID on which we are setting permissions for Categories and Forums
     * @param string $perm_name : name of the permission
     * @return boolean : TRUE if the no errors occured
     */

    function saveCategory_Permissions($groups, $categoryID, $perm_name)
    {
        global $xoopsModule;

        if (!is_object($xoopsModule)) {
            $module_handler = &xoops_gethandler('module');
            $xoopsModule = &$module_handler->getByDirname('newbb');
        } 

        $result = true;
        $module_id = $xoopsModule->getVar('mid') ;
        $gperm_handler = &xoops_gethandler('groupperm'); 
        // First, if the permissions are already there, delete them
        $gperm_handler->deleteByModule($module_id, $perm_name, $categoryID); 
        // Save the new permissions
        if (count($groups) > 0) {
            foreach ($groups as $group_id) {
                $gperm_handler->addRight($perm_name, $categoryID, $group_id, $module_id);
            } 
        } 
        return $result;
    } 

    /*
	* Returns permissions for a certain type
	*
	* @param string $type "global", "forum" or "topic" (should perhaps have "post" as well - but I don't know)
	* @param int $id id of the item (forum, topic or possibly post) to get permissions for
	*
	* @return array
	*/
    function getPermissions($type = "global", $id = null)
    {
        global $xoopsUser;
        static $permissions;

        $module_handler = &xoops_gethandler('module');
        $xoopsNewBB = &$module_handler->getByDirname('newbb');

        if (!isset($permissions[$type]) || ($id != null && !isset($permissions[$type][$id]))) {
            // Get group permissions handler
            $gperm_handler = &xoops_gethandler('groupperm'); 
            // Get user's groups
            $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS); 
            // Create string of groupid's separated by commas, inserted in a set of brackets
            if (count($groups) < 1) return false;
            $groupstring = "(" . implode(',', $groups) . ")"; 
            // Create criteria for getting only the permissions regarding this module and this user's groups
            $criteria = new CriteriaCompo(new Criteria('gperm_modid', $xoopsNewBB->getVar('mid')));
            $criteria->add(new Criteria('gperm_groupid', $groupstring, 'IN'));
            if ($id != null) {
                if (is_array($id)) {
                    $counter = 0;
                    $idstring = "(" . implode(',', $id) . ")";
                    $criteria->add(new Criteria('gperm_itemid', $idstring, 'IN'));
                } else {
                    $criteria->add(new Criteria('gperm_itemid', intval($id)));
                } 
            } 

            switch ($type) {
                case "topic":
                    $items = explode(',', FORUM_PERM_ITEMS);
                    $full_items = array();
                    foreach($items as $item) {
                        $full_items[] = "'forum_can_" . $item . "'";
                    } 
                    $gperm_names = implode(',', $full_items);
                    break;

                case "forum":
                    $gperm_names = "'global_forum_access'";
                    break;

                case "global":
                    $gperm_names = "'forum_cat_access'";
                    break;
            } 
            // Add criteria for gpermnames
            $criteria->add(new Criteria('gperm_name', "(" . $gperm_names . ")", 'IN')); 
            // Get all permission objects in this module and for this user's groups
            $userpermissions = &$gperm_handler->getObjects($criteria, true); 
            // Set the granted permissions to 1
            foreach ($userpermissions as $gperm_id => $gperm) {
                $permissions[$type][$gperm->getVar('gperm_itemid')][$gperm->getVar('gperm_name')] = 1;
            } 
        } 
        // Return the permission array
        return isset($permissions[$type]) ? $permissions[$type] : array();
    } 

    function permission_table($permission_set, $forum = 0, $topic_locked = false, $isadmin = false)
    {
        global $xoopsUser;

        if (is_object($forum)) $forumid = $forum->getVar('forum_id');
        else $forumid = $forum;

        $perm_items = explode(',', FORUM_PERM_ITEMS);
        $perm = "<table><tr><td align='left'><small>";
        foreach($perm_items as $item) {
            if ($isadmin ||
                (isset($permission_set[$forumid]['forum_can_' . $item]) && !$topic_locked)
                    ) {
                $perm .= "<img src='images/enable.gif' alt=''>&nbsp;".constant('_MD_CAN_' . strtoupper($item));
            } else {
                $perm .= "<img src='images/disable.gif' alt=''>&nbsp;".constant('_MD_CANNOT_' . strtoupper($item));
            } 
        } 
        $perm .= "</small></td></tr></table>";

        return $perm;
    } 
} 

?>
