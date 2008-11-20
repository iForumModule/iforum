<?php 
// $Id: menu.php,v 1.3 2005/10/19 17:20:32 phppp Exp $
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

$adminmenu[0]['title']  = _MI_NEWBB_ADMENU_INDEX;
$adminmenu[0]['link']   = "admin/index.php";
$adminmenu[0]['icon']   = 'images/home.png';
$adminmenu[1]['title']  = _MI_NEWBB_ADMENU_CATEGORY;
$adminmenu[1]['link']   = "admin/admin_cat_manager.php?op=manage";
$adminmenu[1]['icon']   = 'images/folder.png';
$adminmenu[2]['title']  = _MI_NEWBB_ADMENU_FORUM;
$adminmenu[2]['link']   = "admin/admin_forum_manager.php?op=manage";
$adminmenu[2]['icon']   = 'images/imforum_iconbig.png';
$adminmenu[3]['title']  = _MI_NEWBB_ADMENU_PERMISSION;
$adminmenu[3]['link']   = "admin/admin_permissions.php";
$adminmenu[3]['icon']   = 'images/permission.png';
$adminmenu[4]['title']  = _MI_NEWBB_ADMENU_BLOCK;
$adminmenu[4]['link']   = "admin/admin_blocks.php";
$adminmenu[4]['icon']   = 'images/blocks.png';
$adminmenu[5]['title']  = _MI_NEWBB_ADMENU_SYNC;
$adminmenu[5]['link']   = "admin/admin_forum_manager.php?op=sync";
$adminmenu[5]['icon']   = 'images/sync.png';
$adminmenu[6]['title']  = _MI_NEWBB_ADMENU_ORDER;
$adminmenu[6]['link']   = "admin/admin_forum_reorder.php";
$adminmenu[6]['icon']   = 'images/order.png';
$adminmenu[7]['title']  = _MI_NEWBB_ADMENU_PRUNE;
$adminmenu[7]['link']   = "admin/admin_forum_prune.php";
$adminmenu[7]['icon']   = 'images/prune.png';
$adminmenu[8]['title']  = _MI_NEWBB_ADMENU_REPORT;
$adminmenu[8]['link']   = "admin/admin_report.php";
$adminmenu[8]['icon']   = 'images/reports.png';
$adminmenu[9]['title']  = _MI_NEWBB_ADMENU_DIGEST;
$adminmenu[9]['link']   = "admin/admin_digest.php";
$adminmenu[9]['icon']   = 'images/digest.png';
$adminmenu[10]['title'] = _MI_NEWBB_ADMENU_VOTE;
$adminmenu[10]['link']  = "admin/admin_votedata.php";
$adminmenu[10]['icon']  = 'images/votes.png';

?>