<?php
// $Id: category.php,v 1.6 2005/05/25 01:01:42 phppp Exp $
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
class Category extends XoopsObject {
    var $db;
    var $table;
    var $groups_cat_access;

    function Category()
    {
        $this->db = &Database::getInstance();
        $this->table = $this->db->prefix("bb_categories");
        $this->initVar('cat_id', XOBJ_DTYPE_INT);
        $this->initVar('pid', XOBJ_DTYPE_INT, 0);
        $this->initVar('cat_title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('cat_image', XOBJ_DTYPE_TXTBOX);
        $this->initVar('cat_description', XOBJ_DTYPE_TXTAREA);
        $this->initVar('cat_order', XOBJ_DTYPE_INT);
        $this->initVar('cat_state', XOBJ_DTYPE_INT);
        $this->initVar('cat_url', XOBJ_DTYPE_URL);
        $this->initVar('cat_showdescript', XOBJ_DTYPE_INT);
    }

    function imgLink()
    {
        global $xoopsModule;

        $ret = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/index.php?cat=" . $this->getVar('cat_id') . "'>" . "<img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/topics/" . $this->getVar('cat_image') . "' alt='" . $this->getVar('cat_title') . "' /></a>";
        return $ret;
    }

    function textLink()
    {
        global $xoopsModule;

        $ret = "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/index.php?cat=" . $this->getVar('cat_id') . "'>" . $this->getVar('cat_title') . "</a>";
        return $ret;
    }
}

class NewbbCategoryHandler extends XoopsObjectHandler
{
	function &create($isNew = true)
    {
        $category = new Category();
        if ($isNew) {
            $category->setNew();
        }
        return $category;
    }

    function &get($id = 0)
    {
        $category = &$this->create(false);
        if ($id > 0) {
            $sql = "SELECT * FROM " . $this->db->prefix("bb_categories") . " WHERE cat_id = " . intval($id);
            if (!$result = $this->db->query($sql)) {
                return false;
            } while ($row = $this->db->fetchArray($result)) {
                $category->assignVars($row);
            }
        }
        return $category;
    }

    function &getAllCats($permission = false)
    {
	    static $_cachedCats=array();
	    $perm_string = (empty($permission))?'all':'access';
	    if(isset($_cachedCats[$perm_string])) return $_cachedCats[$perm_string];
        $sql = "SELECT * FROM " . $this->db->prefix("bb_categories");
        $sql .= " ORDER BY cat_order";
        if (!$result = $this->db->query($sql)) {
	        newbb_message("query error: ".$sql);
            return false;
        } 
        $_cachedCats[$perm_string]=array();
        while ($row = $this->db->fetchArray($result)) {
            $category = &$this->create(false);
            $category->assignVars($row);
            if ($permission && !$this->getPermission($category)) continue;
            $_cachedCats[$perm_string][] = $category;
            unset($category);
        }
        return $_cachedCats[$perm_string];
    }

    function insert(&$category)
    {
        if (!$category->isDirty()) {
            return true;
        }
        if (!$category->cleanVars()) {
            return false;
        }
        foreach ($category->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        global $myts, $xoopsModule;

        if ($category->isNew()) {
            $category->setVar('cat_id', $this->db->genId($category->table . "_cat_id_seq"));
            /*
            $sql = "INSERT INTO " . $category->table . " (cat_id, cat_image, cat_title, cat_description, cat_order, cat_state, cat_url, cat_showdescript)
			         VALUES (" . $category->getVar('cat_id') . ", " . $this->db->quoteString($cat_image) . ", " . $this->db->quoteString($cat_title) . ", " . $this->db->quoteString($cat_description) . ", " . $cat_order . ", " . $cat_state . ", " . $this->db->quoteString($cat_url) . ", " . $cat_showdescript . " )";
			*/
            $sql = "INSERT INTO " . $category->table . " (cat_id, cat_image, cat_title, cat_description, cat_order, cat_url, cat_showdescript)
			         VALUES (" . $category->getVar('cat_id') . ", " . $this->db->quoteString($cat_image) . ", " . $this->db->quoteString($cat_title) . ", " . $this->db->quoteString($cat_description) . ", " . $cat_order . ", " . $this->db->quoteString($cat_url) . ", " . $cat_showdescript . " )";
        } else {
            //$sql = "UPDATE " . $category->table . " SET cat_image=" . $this->db->quoteString($cat_image) . ", cat_title=" . $this->db->quoteString($cat_title) . ", cat_description=" . $this->db->quoteString($cat_description) . ", cat_order=" . $cat_order . ",  cat_state=" . $cat_state . ", cat_url=" . $this->db->quoteString($cat_url) . ",  cat_showdescript=" . $cat_showdescript . " WHERE cat_id=" . $cat_id;
            $sql = "UPDATE " . $category->table . " SET cat_image=" . $this->db->quoteString($cat_image) . ", cat_title=" . $this->db->quoteString($cat_title) . ", cat_description=" . $this->db->quoteString($cat_description) . ", cat_order=" . $cat_order . ", cat_url=" . $this->db->quoteString($cat_url) . ",  cat_showdescript=" . $cat_showdescript . " WHERE cat_id=" . $cat_id;
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        if (!($category->getVar('cat_id'))) $category->setVar('cat_id', $this->db->getInsertId());
        $perm = &xoops_getmodulehandler('permission', 'newbb');
        $perm->saveCategory_Permissions($category->groups_cat_access, $category->getVar('cat_id'), 'forum_cat_access');

        return true;
    }

    function delete(&$category)
    {
        global $xoopsModule;
		$forum_handler = &xoops_getmodulehandler('forum', 'newbb');
        $forums =& $forum_handler->getForumsByCat($category->getVar('cat_id'));
        if(count($forums[$category->getVar('cat_id')])>0) foreach($forums[$category->getVar('cat_id')] as $fid=>$forum){
	        $forum_handler->delete($forum);
        }
        $sql = "DELETE FROM " . $category->table . " WHERE cat_id=" . $category->getVar('cat_id') . "";
        if ($result = $this->db->query($sql)) {
            // Delete group permissions
            $gperm_handler = &xoops_gethandler('groupperm');
            $criteria = new CriteriaCompo(new Criteria('gperm_modid', intval($xoopsModule->getVar('mid'))));
            $criteria->add(new Criteria('gperm_name', 'forum_cat_access'));
            $criteria->add(new Criteria('gperm_itemid', $category->getVar('cat_id')));
            return $gperm_handler->deleteAll($criteria);
        } else {
	        newbb_message("delete category error: ".$sql);
            return false;
        }
    }

    function getLatestPosts($viewcat = 0)
    {
        $sql = 'SELECT f.*, u.uname, u.name, u.uid, p.topic_id, p.post_time, p.subject, p.poster_name, p.icon FROM ' . $this->db->prefix('bb_forums') . ' f LEFT JOIN ' . $this->db->prefix('bb_posts') . ' p ON p.post_id = f.forum_last_post_id LEFT JOIN ' . $this->db->prefix('users') . ' u ON u.uid = p.uid';
        if ($viewcat != 0) {
            $sql .= ' WHERE f.cat_id = ' . intval($viewcat);
        } else {
            $sql .= ' ORDER BY f.cat_id, f.forum_order';
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $ret = array();
        while ($row = $this->db->fetchArray($result)) {
            $ret[$row['forum_id']] = $row;
        }
        return $ret;
    }

    function getForums($categoryid = 0, $permission = "")
    {
        $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
        return $forum_handler->getForums($categoryid, $permission);
    }

    function getPermission($category)
    {
        global $xoopsUser, $xoopsModule;
        static $_cachedCategoryPerms;

        if (newbb_isAdministrator()) return true;

        if(!isset($_cachedCategoryPerms)){
	        $getpermission = &xoops_getmodulehandler('permission', 'newbb');
	        $_cachedCategoryPerms = $getpermission->getPermissions("global");
        }

        $cat_id = is_object($category)? $category->getVar('cat_id'):intval($category);
        $permission = (isset($_cachedCategoryPerms[$cat_id]['forum_cat_access'])) ? 1 : 0;
        /*
        if(!empty($permission)){
	        if(!is_object($category)) $category =& $this->get($cat_id);
        	if ($category->getVar('cat_state')) $permission = 0; // if category inactive, all has no access except admin
    	}
    	*/

        return $permission;
    }
}

?>