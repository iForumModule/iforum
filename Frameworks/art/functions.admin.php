<?php
// $Id: functions.php,v 1.3 2005/10/19 17:20:33 phppp Exp $
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
// Author: phppp (D.J., infomax@gmail.com)                                  //
// URL: http://xoopsforge.com, http://xoops.org.cn                          //
// Project: Article Project                                                 //
// ------------------------------------------------------------------------ //

if(!defined("FRAMEWORKS_ART_FUNCTIONS_ADMIN")):
define("FRAMEWORKS_ART_FUNCTIONS_ADMIN", true);

include_once (dirname(__FILE__)."/functions.ini.php");

function loadModuleAdminMenu ($currentoption = -1, $breadcrumb="")
{
	// For XOOPS 2.2*
	if(isset($GLOBALS["xTheme"]) && method_exists($GLOBALS["xTheme"], "loadModuleAdminMenu")){
		$GLOBALS["xTheme"]->loadModuleAdminMenu($currentoption, $breadcrumb);
	// For XOOPS 2.0*, 2.3*
	}else{
		echo _loadModuleAdminMenu($currentoption, $breadcrumb);
	}
	return true;
}

function _loadModuleAdminMenu($currentoption, $breadcrumb="")
{
	$adminmenu = array();
	
	if(!@include XOOPS_ROOT_PATH."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/".$GLOBALS["xoopsModule"]->getInfo("adminmenu")){
		return null;
	}
	$module_link = XOOPS_URL."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/";
	$image_link = XOOPS_URL."/Frameworks/xoops22/include";
	
	$adminmenu_text ='
	<style type="text/css">
	<!--
	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0;}
	#buttonbar { float:left; width:100%; background: #e7e7e7 url("'.$image_link.'/modadminbg.gif") repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px;}
	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
	#buttonbar li { display:inline; margin:0; padding:0; }
	#buttonbar a { float:left; background:url("'.$image_link.'/left_both.gif") no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
	#buttonbar a span { float:left; display:block; background:url("'.$image_link.'/right_both.gif") no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
	/* Commented Backslash Hack hides rule from IE5-Mac \*/
	#buttonbar a span {float:none;}
	/* End IE5-Mac hack */
	#buttonbar a:hover span { color:#333; }
	#buttonbar .current a { background-position:0 -150px; border-width:0; }
	#buttonbar .current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
	#buttonbar a:hover { background-position:0% -150px; }
	#buttonbar a:hover span { background-position:100% -150px; }	
	//-->
	</style>
	<div id="buttontop">
	 <table style="width: 100%; padding: 0; " cellspacing="0">
	     <tr>
	         <td style="width: 70%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;">
	             <a href="../index.php">'.$GLOBALS["xoopsModule"]->getVar("name").'</a>
	         </td>
	         <td style="width: 30%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;">
	             <b>'.$GLOBALS["xoopsModule"]->getVar("name").'</b>&nbsp;'.$breadcrumb.'
	         </td>
	     </tr>
	 </table>
	</div>
	<div id="buttonbar">
	 <ul>
	';
	foreach(array_keys($adminmenu) as $key){
		$adminmenu_text .= (($currentoption == $key)? '<li class="current">':'<li>').'<a href="'.$module_link.$adminmenu[$key]["link"].'"><span>'.$adminmenu[$key]["title"].'</span></a></li>';
	}
	$adminmenu_text .='
	 </ul>
	</div>
	<br style="clear:both;" />';
	
	return $adminmenu_text;
}
endif;
?>