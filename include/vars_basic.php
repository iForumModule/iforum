<?php
// $Id: xoops_version.php,v 1.6.2.5 2005/01/09 00:52:33 phppp Exp $
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
if(empty($xoopsModuleConfig['basicmode'])) return;

$xoopsModuleConfig['image_type'] = 'auto';
$xoopsModuleConfig['pngforie_enabled'] = 0;
$xoopsModuleConfig['subforum_display'] = 'hidden';
$xoopsModuleConfig['post_excerpt'] = 0;
$xoopsModuleConfig['cache_enabled'] = 1;
$xoopsModuleConfig['media_allowed'] = 0;
$xoopsModuleConfig['path_magick'] = '';
$xoopsModuleConfig['path_netpbm'] = '';
$xoopsModuleConfig['image_lib'] = 0;
$xoopsModuleConfig['wol_enabled'] = 0;
$xoopsModuleConfig['levels_enabled'] = 0;
$xoopsModuleConfig['userbar_enabled'] = 0;
$xoopsModuleConfig['show_realname'] = 0;
$xoopsModuleConfig['groupbar_enabled'] = 0;
$xoopsModuleConfig['rating_enabled'] = 0;
$xoopsModuleConfig['reportmod_enabled'] = 0;
$xoopsModuleConfig['quickreply_enabled'] = 0;
//$xoopsModuleConfig['rss_enable'] = 1;
$xoopsModuleConfig['rss_maxitems'] = 10;
$xoopsModuleConfig['rss_maxdescription'] = 200;
//$xoopsModuleConfig['rss_cachetime'] = 30;
$xoopsModuleConfig['rss_utf8'] = 1;
$xoopsModuleConfig['view_mode'] = 0;
$xoopsModuleConfig['show_jump'] = 0;
$xoopsModuleConfig['show_permissiontable'] = 0;
$xoopsModuleConfig['email_digest'] = 0;
$xoopsModuleConfig['show_ip'] = 0;
$xoopsModuleConfig['enable_karma'] = 0;
$xoopsModuleConfig['since_options'] = "-1, -2, -6, -12, 1, 2, 5, 10, 20, 30, 60, 100";
$xoopsModuleConfig['since_default'] = 100;
$xoopsModuleConfig['allow_user_anonymous'] = 0;
$xoopsModuleConfig['anonymous_prefix'] = '';
$xoopsModuleConfig['allow_require_reply'] = 0;
$xoopsModuleConfig['edit_timelimit'] = 0;
$xoopsModuleConfig['delete_timelimit'] = 60;
$xoopsModuleConfig['post_timelimit'] = 30;
$xoopsModuleConfig['subject_prefix_level'] =  0;
$xoopsModuleConfig['disc_show'] = 0;
?>