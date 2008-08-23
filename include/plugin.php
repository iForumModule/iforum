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
/* some static xoopsModuleConfig */

// requiring "name" field for anonymous users in edit form
$GLOBALS["xoopsModuleConfig"]["require_name"] = true; 

// display "register or login to post" for anonymous users
$GLOBALS["xoopsModuleConfig"]["show_reg"] = true; 

// perform forum/topic synchronization on module update
$GLOBALS["xoopsModuleConfig"]["syncOnUpdate"] = false;

// redirect to its URI of an attachment when requested
// Set to true if your attachment would be corrupted after download with normal way
$GLOBALS["xoopsModuleConfig"]["download_direct"] = false;

// Set allowed editors 
// Should set from module preferences?
$GLOBALS["xoopsModuleConfig"]["editor_allowed"] = array(); 

// Set the default editor
$GLOBALS["xoopsModuleConfig"]["editor_default"] = ""; 

// MENU handler
/* You could remove anyone by commenting out in order to disable it */
$valid_menumodes = array(
	0 => _MD_MENU_SELECT,	// for selectbox
	1 => _MD_MENU_CLICK,	// for "click to expand"
	2 => _MD_MENU_HOVER		// for "mouse hover to expand"
	);
?>