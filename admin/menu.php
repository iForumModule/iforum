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
$i=0;
$adminmenu[$i]['title'] = _MI_NEWBB_ADMENU_INDEX;
$adminmenu[$i++]['link'] = "admin/index.php";
$adminmenu[$i]['title'] = _MI_NEWBB_ADMENU_CATEGORY;
$adminmenu[$i++]['link'] = "admin/admin_cat_manager.php?op=manage";
$adminmenu[$i]['title'] = _MI_NEWBB_ADMENU_FORUM;
$adminmenu[$i++]['link'] = "admin/admin_forum_manager.php?op=manage";
$adminmenu[$i]['title'] = _MI_NEWBB_ADMENU_PERMISSION;
$adminmenu[$i++]['link'] = "admin/admin_permissions.php";
$adminmenu[$i]['title'] = _MI_NEWBB_ADMENU_BLOCK;
$adminmenu[$i++]['link'] = "admin/admin_blocks.php";
$adminmenu[$i]['title'] = _MI_NEWBB_ADMENU_SYNC;
$adminmenu[$i++]['link'] = "admin/admin_forum_manager.php?op=sync";
$adminmenu[$i]['title'] = _MI_NEWBB_ADMENU_ORDER;
$adminmenu[$i++]['link'] = "admin/admin_forum_reorder.php";
$adminmenu[$i]['title'] = _MI_NEWBB_ADMENU_PRUNE;
$adminmenu[$i++]['link'] = "admin/admin_forum_prune.php";
$adminmenu[$i]['title'] = _MI_NEWBB_ADMENU_REPORT;
$adminmenu[$i++]['link'] = "admin/admin_report.php";
$adminmenu[$i]['title'] = _MI_NEWBB_ADMENU_DIGEST;
$adminmenu[$i++]['link'] = "admin/admin_digest.php";
$adminmenu[$i]['title'] = _MI_NEWBB_ADMENU_VOTE;
$adminmenu[$i++]['link'] = "admin/admin_votedata.php";

?>