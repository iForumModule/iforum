<?php
// $Id: category.php,v 1.3 2005/10/19 17:20:32 phppp Exp $
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
//  Author: phppp (D.J., infomax@gmail.com)                                  //
//  URL: http://xoopsforge.com, http://xoops.org.cn                          //
//  Project: Article Project                                                 //
//  ------------------------------------------------------------------------ //
 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

defined("NEWBB_FUNCTIONS_INI") || include XOOPS_ROOT_PATH.'/modules/'.basename( dirname( dirname( __FILE__ ) ) ).'/include/functions.ini.php';
newbb_load_object();

class Category extends ArtObject {

    function Category()
    {
	    $this->ArtObject("bb_categories");
        $this->initVar('cat_id', XOBJ_DTYPE_INT);
        $this->initVar('pid', XOBJ_DTYPE_INT, 0);
        $this->initVar('cat_title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('cat_image', XOBJ_DTYPE_TXTBOX);
        $this->initVar('cat_description', XOBJ_DTYPE_TXTAREA);
        $this->initVar('cat_order', XOBJ_DTYPE_INT);
        //$this->initVar('cat_state', XOBJ_DTYPE_INT);
        $this->initVar('cat_url', XOBJ_DTYPE_URL);
        //$this->initVar('cat_showdescript', XOBJ_DTYPE_INT);
    }
}

class NewbbCategoryHandler extends ArtObjectHandler
{
    function NewbbCategoryHandler(&$db) {
        $this->ArtObjectHandler($db, 'bb_categories', 'Category', 'cat_id', 'cat_title');
    }

    function &getAllCats($permission = false, $idAsKey = true, $tags = null)
    {
	    $perm_string = (empty($permission))?'all':'access';
        $_cachedCats[$perm_string]=array();
        $criteria = new Criteria("1", 1);
        $criteria->setSort("cat_order");
        $categories =& $this->getAll($criteria, $tags, $idAsKey);
        foreach(array_keys($categories) as $key){
            if ($permission && !$this->getPermission($categories[$key])) continue;
            if($idAsKey){
            	$_cachedCats[$perm_string][$key] = $categories[$key];
            }else{
            	$_cachedCats[$perm_string][] = $categories[$key];
        	}
        }
        return $_cachedCats[$perm_string];
    }

    function insert(&$category)
    {
        parent::insert($category, true);
        if ($category->isNew()) {
	        $this->applyPermissionTemplate($category);
        }

        return $category->getVar('cat_id');
    }

    function delete(&$category)
    {
        global $xoopsModule;
		$forum_handler = &xoops_getmodulehandler('forum', basename(  dirname(  dirname( __FILE__ ) ) ));
		$forum_handler->deleteAll(new Criteria("cat_id", $category->getVar('cat_id')), true, true);
        if ($result = parent::delete($category)) {
            // Delete group permissions
            return $this->deletePermission($category);
        } else {
	        $category->setErrors("delete category error: ".$sql);
            return false;
        }
    }

    /*
     * Check permission for a category
     *
     * TODO: get a list of categories per permission type
     *
     * @param	mixed (object or integer)	category object or ID
     * return	bool
     */
    function getPermission($category)
    {
        global $xoopsUser, $xoopsModule;
        static $_cachedCategoryPerms;

        if (newbb_isAdministrator()) return true;

        if(!isset($_cachedCategoryPerms)){
	        $getpermission = &xoops_getmodulehandler('permission', basename(  dirname(  dirname( __FILE__ ) ) ));
	        $_cachedCategoryPerms = $getpermission->getPermissions("category");
        }

        $cat_id = is_object($category)? $category->getVar('cat_id'):intval($category);
        $permission = (isset($_cachedCategoryPerms[$cat_id]['category_access'])) ? 1 : 0;

        return $permission;
    }
        
    function deletePermission(&$category)
    {
		$perm_handler =& xoops_getmodulehandler('permission', basename(  dirname(  dirname( __FILE__ ) ) ));
		return $perm_handler->deleteByCategory($category->getVar("cat_id"));
	}
    
    function applyPermissionTemplate(&$category)
    {
		$perm_handler =& xoops_getmodulehandler('permission', basename(  dirname(  dirname( __FILE__ ) ) ));
		return $perm_handler->setCategoryPermission($category->getVar("cat_id"));
	}
}

?>