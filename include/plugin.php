<?php
// $Id: plugin.php,v 1.1.1.1 2005/10/19 16:23:50 phppp Exp $
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
if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/* some static xoopsModuleConfig */

// specification for custom time format
// default manner will be used if not specified
$customConfig["formatTimestamp_custom"] = ""; // Could be set as "Y-m-d H:i" 

// requiring "name" field for anonymous users in edit form
$customConfig["require_name"] = true; 

// display "register or login to post" for anonymous users
$customConfig["show_reg"] = true; 

// perform forum/topic synchronization on module update
$customConfig["syncOnUpdate"] = true;

// time for pending/deleted topics/posts, expired one will be removed automatically, in days; 0 or no cleanup
$customConfig["pending_expire"] = 7;

// redirect to its URI of an attachment when requested
// Set to true if your attachment would be corrupted after download with normal way
$customConfig["download_direct"] = false;

// Set allowed editors 
// Should set from module preferences?
$customConfig["editor_allowed"] = array(); 

// Set the default editor
$customConfig["editor_default"] = ""; 

// storage method for reading records: 0 - none; 1 - cookie; 2 - db
$customConfig["read_mode"] = 2;

// expire time for reading records, in days
$customConfig["read_expire"] = 30;

// maximum records per forum for one user
$customConfig["read_items"] = 100;

// default value for editor rows, coloumns 
$customConfig["editor_rows"] = 25;
$customConfig["editor_cols"] = 60;

// default value for editor width, height (string)
$customConfig["editor_width"] = "100%";
$customConfig["editor_height"] = "400px";

// MENU handler
/* You could remove anyone by commenting out in order to disable it */
$valid_menumodes = array(
	0 => _MD_MENU_SELECT,	// for selectbox
	1 => _MD_MENU_CLICK,	// for "click to expand"
	2 => _MD_MENU_HOVER		// for "mouse hover to expand"
	);
	
return $customConfig;	
?>