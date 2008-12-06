<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		http://xoopsforge.com The XOOPS FORGE Project
* @copyright		http://xoops.org.cn The XOOPS CHINESE Project
* @copyright		XOOPS_copyrights.txt
* @copyright		readme.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license			GNU General Public License (GPL)
*					a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		CBB - XOOPS Community Bulletin Board
* @since			3.08
* @author		phppp
* ----------------------------------------------------------------------------------------------------------
* 				iForum - a bulletin Board (Forum) for ImpressCMS
* @since			1.00
* @author		modified by stranger
* @version		$Id$
*/

include_once '../../mainfile.php';
include_once ICMS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";
include_once ICMS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/functions.php";
include_once ICMS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/class/art/functions.php";

$myts =& MyTextSanitizer::getInstance();

// menumode cookie
if(isset($_REQUEST['menumode'])){
	$menumode = intval($_REQUEST['menumode']);
	iforum_setcookie("M", $menumode, $forumCookie['expire']);
}else{
	$cookie_M = intval(iforum_getcookie("M"));
	$menumode = ($cookie_M === null || !isset($valid_menumodes[$cookie_M]))?$xoopsModuleConfig['menu_mode']:$cookie_M;
}

$menumode_other = array();
$menu_url = htmlSpecialChars(preg_replace("/&menumode=[^&]/", "", $_SERVER[ 'REQUEST_URI' ]));
$menu_url .= (false === strpos($menu_url, "?"))?"?menumode=":"&amp;menumode=";
foreach($valid_menumodes as $key=>$val){
	if($key != $menumode) $menumode_other[]=array("title"=>$val, "link"=>$menu_url.$key);
}

$iforum_module_header = '';
$iforum_module_header .= '<link rel="alternate" type="application/rss+xml" title="'.$xoopsModule->getVar('name').'" href="'.ICMS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/rss.php" />';
if(!empty($xoopsModuleConfig['pngforie_enabled'])){
	$iforum_module_header .= '<style type="text/css">img {behavior:url("include/pngbehavior.htc");}</style>';
}
$iforum_module_header .= '
	<link rel="stylesheet" type="text/css" href="templates/iforum'.(( defined("_ADM_USE_RTL") && _ADM_USE_RTL )?'_rtl':'').'.css" />
	<script type="text/javascript">var toggle_cookie="'.$forumCookie['prefix'].'G'.'";</script>
	<script src="include/js/iforum_toggle.js" type="text/javascript"></script>
	';
if($menumode==2){
	$iforum_module_header .= '
	<link rel="stylesheet" type="text/css" href="templates/iforum_menu_hover.css" />
	<style type="text/css">body {behavior:url("include/iforum.htc");}</style>
	';
}
if($menumode==1){
	$iforum_module_header .= '
	<link rel="stylesheet" type="text/css" href="templates/iforum_menu_click.css" />
	<script src="include/js/iforum_menu_click.js" type="text/javascript"></script>
	';
}
$xoops_module_header = $iforum_module_header; // for cache hack
//$xoopsOption['xoops_module_header'] = $xoops_module_header;
/*
if(!empty($xoopsModuleConfig['pngforie_enabled'])){
	$xTheme->addCSS(null,null,'img {behavior:url("include/pngbehavior.htc");}');
}
$xTheme->addJS(ICMS_URL."/modules/".$xoopsModule->getVar("dirname")."/include/js/iforum_toggle.js");
$xTheme->addJS(null, null, 'var toggle_cookie="'.$forumCookie['prefix'].'G'.'";');
if($menumode==2){
	$xTheme->addCSS(ICMS_URL."/modules/".$xoopsModule->getVar("dirname")."/templates/iforum_menu_hover.css");
	$xTheme->addCSS(null,null,'body {behavior:url("include/iforum.htc");}');
}
if($menumode==1){
	$xTheme->addCSS(ICMS_URL."/modules/".$xoopsModule->getVar("dirname")."/templates/iforum_menu_click.css");
	$xTheme->addJS(ICMS_URL."/modules/".$xoopsModule->getVar("dirname")."/include/js/iforum_menu_click.js");
}
$xoops_module_header = '<link rel="stylesheet" type="text/css" media="screen" href="'.ICMS_URL."/modules/".$xoopsModule->getVar("dirname").'/templates/iforum.css" />';
*/

iforum_welcome();
?>