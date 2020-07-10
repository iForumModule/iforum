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
 
if (!defined("ICMS_ROOT_PATH"))
{
	exit();
}
 
defined("IFORUM_FUNCTIONS_INI") || include ICMS_ROOT_PATH.'/modules/'.basename(dirname(__DIR__) ).'/include/functions.ini.php';
iforum_load_object();
 
class Category extends ArtObject {
	 
	function __construct()
	{
		parent::__construct("bb_categories");
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
 
class IforumCategoryHandler extends ArtObjectHandler {
	function __construct(&$db)
	{
		parent::__construct($db, 'bb_categories', 'Category', 'cat_id', 'cat_title');
	}
	 
	function &getAllCats($permission = false, $idAsKey = true, $tags = null)
	{
		$perm_string = (empty($permission))?'all':
		'access';
		$_cachedCats[$perm_string] = array();
		$criteria = new icms_db_criteria_Item("1", 1);
		$criteria->setSort("cat_order");
		$categories = $this->getAll($criteria, $tags, $idAsKey);
		foreach(array_keys($categories) as $key)
		{
			if ($permission && !$this->getPermission($categories[$key])) continue;
			if ($idAsKey)
			{
				$_cachedCats[$perm_string][$key] = $categories[$key];
			}
			else
			{
				$_cachedCats[$perm_string][] = $categories[$key];
			}
		}
		return $_cachedCats[$perm_string];
	}
	 
	function insert(&$category, $force = true)
	{
		parent::insert($category, true);
		if ($category->isNew())
		{
			$this->applyPermissionTemplate($category);
		}
		 
		return $category->getVar('cat_id');
	}
	 
	function delete(&$category, $force = true)
	{
		global $icmsModule;
		$forum_handler =icms_getmodulehandler('forum', basename(dirname(__DIR__) ), 'iforum' );
		$forum_handler->deleteAll(new icms_db_criteria_Item("cat_id", $category->getVar('cat_id')), true, true);
		if ($result = parent::delete($category))
		{
			// Delete group permissions
			return $this->deletePermission($category);
		}
		else
		{
			$category->setErrors("delete category error: ".$sql);
			return false;
		}
	}
	 
	/*
	* Check permission for a category
	*
	* TODO: get a list of categories per permission type
	*
	* @param mixed (object or integer) category object or ID
	* return bool
	*/
	function getPermission($category)
	{
		global $icmsModule;
		static $_cachedCategoryPerms;
		 
		if (iforum_isAdministrator()) return true;
		 
		if (!isset($_cachedCategoryPerms))
		{
			$getpermission =icms_getmodulehandler('permission', basename(dirname(__DIR__) ), 'iforum' );
			$_cachedCategoryPerms = $getpermission->getPermissions("category");
		}
		 
		$cat_id = is_object($category)? $category->getVar('cat_id'):
            (int)$category;
		$permission = (isset($_cachedCategoryPerms[$cat_id]['category_access'])) ? 1 :
		 0;
		 
		return $permission;
	}
	 
	function deletePermission(&$category)
	{
		$perm_handler = icms_getmodulehandler('permission', basename(dirname(__DIR__) ), 'iforum' );
		return $perm_handler->deleteByCategory($category->getVar("cat_id"));
	}
	 
	function applyPermissionTemplate(&$category)
	{
		$perm_handler = icms_getmodulehandler('permission', basename(dirname(__DIR__) ), 'iforum' );
		return $perm_handler->setCategoryPermission($category->getVar("cat_id"));
	}
}