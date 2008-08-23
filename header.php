<?php
// $Id: header.php,v 1.3 2005/10/19 17:20:28 phppp Exp $
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


include_once '../../mainfile.php';
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/functions.php";
include_once XOOPS_ROOT_PATH."/Frameworks/art/functions.php";

$myts =& MyTextSanitizer::getInstance();

// menumode cookie
if(isset($_REQUEST['menumode'])){
	$menumode = intval($_REQUEST['menumode']);
	newbb_setcookie("M", $menumode, $forumCookie['expire']);
}else{
	$cookie_M = intval(newbb_getcookie("M"));
	$menumode = ($cookie_M === null || !isset($valid_menumodes[$cookie_M]))?$xoopsModuleConfig['menu_mode']:$cookie_M;
}

$menumode_other = array();
$menu_url = htmlSpecialChars(preg_replace("/&menumode=[^&]/", "", $_SERVER[ 'REQUEST_URI' ]));
$menu_url .= (false === strpos($menu_url, "?"))?"?menumode=":"&amp;menumode=";
foreach($valid_menumodes as $key=>$val){
	if($key != $menumode) $menumode_other[]=array("title"=>$val, "link"=>$menu_url.$key);
}

$newbb_module_header = '';
$newbb_module_header .= '<link rel="alternate" type="application/xml+rss" title="'.$xoopsModule->getVar('name').'" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/rss.php" />';
if(!empty($xoopsModuleConfig['pngforie_enabled'])){
	$newbb_module_header .= '<style type="text/css">img {behavior:url("include/pngbehavior.htc");}</style>';
}
$newbb_module_header .= '
	<link rel="stylesheet" type="text/css" href="templates/newbb.css" />
	<script type="text/javascript">var toggle_cookie="'.$forumCookie['prefix'].'G'.'";</script>
	<script src="include/js/newbb_toggle.js" type="text/javascript"></script>
	';
if($menumode==2){
	$newbb_module_header .= '
	<link rel="stylesheet" type="text/css" href="templates/newbb_menu_hover.css" />
	<style type="text/css">body {behavior:url("include/newbb.htc");}</style>
	';
}
if($menumode==1){
	$newbb_module_header .= '
	<link rel="stylesheet" type="text/css" href="templates/newbb_menu_click.css" />
	<script src="include/js/newbb_menu_click.js" type="text/javascript"></script>
	';
}
$xoops_module_header = $newbb_module_header; // for cache hack
//$xoopsOption['xoops_module_header'] = $xoops_module_header;
/*
if(!empty($xoopsModuleConfig['pngforie_enabled'])){
	$xTheme->addCSS(null,null,'img {behavior:url("include/pngbehavior.htc");}');
}
$xTheme->addJS(XOOPS_URL."/modules/".$xoopsModule->getVar("dirname")."/include/js/newbb_toggle.js");
$xTheme->addJS(null, null, 'var toggle_cookie="'.$forumCookie['prefix'].'G'.'";');
if($menumode==2){
	$xTheme->addCSS(XOOPS_URL."/modules/".$xoopsModule->getVar("dirname")."/templates/newbb_menu_hover.css");
	$xTheme->addCSS(null,null,'body {behavior:url("include/newbb.htc");}');
}
if($menumode==1){
	$xTheme->addCSS(XOOPS_URL."/modules/".$xoopsModule->getVar("dirname")."/templates/newbb_menu_click.css");
	$xTheme->addJS(XOOPS_URL."/modules/".$xoopsModule->getVar("dirname")."/include/js/newbb_menu_click.js");
}
$xoops_module_header = '<link rel="stylesheet" type="text/css" media="screen" href="'.XOOPS_URL."/modules/".$xoopsModule->getVar("dirname").'/templates/newbb.css" />';
*/

newbb_welcome();
?>