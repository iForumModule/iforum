<?php
/**
* iForum - a forum module for ImpressCMS
*
* Based upon NewBB/CBB
*
* File: menu.php
*
* @copyright  http://www.xoops.org/ The XOOPS Project
* @copyright  XOOPS_copyrights.txt
* @copyright  http://www.impresscms.org/ The ImpressCMS Project
* @license  GNU General Public License (GPL)
*    a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package  iForum
* @since   1.0
* @author  McDonald
* @version  $Id$
*/
 
$admin_dirname = basename(dirname(dirname(__FILE__ ) ) );
 
global $icmsModule, $icmsConfig;
 
$adminmenu[0]['title'] = _MI_IFORUM_ADMENU_INDEX;
$adminmenu[0]['link'] = 'admin/index.php';
$adminmenu[0]['icon'] = 'images/home.png';
$adminmenu[1]['title'] = _MI_IFORUM_ADMENU_CATEGORY;
$adminmenu[1]['link'] = 'admin/admin_cat_manager.php?op=manage';
$adminmenu[1]['icon'] = 'images/folder.png';
$adminmenu[2]['title'] = _MI_IFORUM_ADMENU_FORUM;
$adminmenu[2]['link'] = 'admin/admin_forum_manager.php?op=manage';
$adminmenu[2]['icon'] = 'images/imforum_iconbig.png';
$adminmenu[3]['title'] = _MI_IFORUM_ADMENU_PERMISSION;
$adminmenu[3]['link'] = 'admin/admin_permissions.php';
$adminmenu[3]['icon'] = 'images/permission.png';
$adminmenu[4]['title'] = _MI_IFORUM_ADMENU_BLOCK;
$adminmenu[4]['link'] = 'admin/admin_blocks.php';
$adminmenu[4]['icon'] = 'images/blocks.png';
$adminmenu[5]['title'] = _MI_IFORUM_ADMENU_SYNC;
$adminmenu[5]['link'] = 'admin/admin_forum_manager.php?op=sync';
$adminmenu[5]['icon'] = 'images/sync.png';
$adminmenu[6]['title'] = _MI_IFORUM_ADMENU_ORDER;
$adminmenu[6]['link'] = 'admin/admin_forum_reorder.php';
$adminmenu[6]['icon'] = 'images/order.png';
$adminmenu[7]['title'] = _MI_IFORUM_ADMENU_PRUNE;
$adminmenu[7]['link'] = 'admin/admin_forum_prune.php';
$adminmenu[7]['icon'] = 'images/prune.png';
$adminmenu[8]['title'] = _MI_IFORUM_ADMENU_REPORT;
$adminmenu[8]['link'] = 'admin/admin_report.php';
$adminmenu[8]['icon'] = 'images/reports.png';
$adminmenu[9]['title'] = _MI_IFORUM_ADMENU_DIGEST;
$adminmenu[9]['link'] = 'admin/admin_digest.php';
$adminmenu[9]['icon'] = 'images/digest.png';
$adminmenu[10]['title'] = _MI_IFORUM_ADMENU_VOTE;
$adminmenu[10]['link'] = 'admin/admin_votedata.php';
$adminmenu[10]['icon'] = 'images/votes.png';
 
if (isset($icmsModule ) )
{
	 
	if (file_exists(ICMS_ROOT_PATH . '/modules/' . $admin_dirname . '/language/' . $icmsConfig['language'] . '/admin.php' ) )
	{
		include_once ICMS_ROOT_PATH . '/modules/' . $admin_dirname . '/language/' . $icmsConfig['language'] . '/admin.php';
	}
	else
	{
		include_once ICMS_ROOT_PATH . '/modules/' . $admin_dirname . '/language/english/admin.php';
	}
	 
	$i = -1;
	 
	$i++;
	$headermenu[$i]['title'] = $icmsModule->getVar('name' );
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $admin_dirname .'/index.php';
	 
	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $icmsModule->getVar('mid' );
	 
	$i++;
	$headermenu[$i]['title'] = _AM_IFORUM_ABOUT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $admin_dirname . '/admin/about.php';
	 
}
 
?>