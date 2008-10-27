<?php
/**
 * Text sanitizing handlers
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		Frameworks::art
 */
if (!defined("FRAMEWORKS_ART_FUNCTIONS_SANITIZER")):
define("FRAMEWORKS_ART_FUNCTIONS_SANITIZER", true);

/* 
 * Filter out possible malicious text
 * kses project at SF could be a good solution to check
 *
 * @param string	$text 	text to filter
 * @param bool		$force 	flag indicating to force filtering
 * @return string 	filtered text
 */
function text_filter(&$text, $force = false)
{
	global $xoopsUser, $xoopsConfig, $xoopsUserIsAdmin;
	
	if (empty($force) && $xoopsUserIsAdmin) {
		return $text;
	}
	
	if (@include_once dirname(dirname(__FILE__))."/PEAR/HTML/Safe.php") {
		 $safehtml =& new HTML_Safe();
		 $text = $safehtml->parse($text);
		 return $text;
	}
	
	// For future applications
	$tags = empty($xoopsConfig["filter_tags"]) ? array() : explode(",", $xoopsConfig["filter_tags"]);
	$tags = array_map("trim", $tags);
	
	// Set embedded tags
	$tags[] = "SCRIPT";
	$tags[] = "VBSCRIPT";
	$tags[] = "JAVASCRIPT";
	foreach ($tags as $tag) {
		$search[] = "/<".$tag."[^>]*?>.*?<\/".$tag.">/si";
		$replace[] = " [!".strtoupper($tag)." FILTERED!] ";
	}
	// Set meta refresh tag
	$search[]= "/<META[^>\/]*HTTP-EQUIV=(['\"])?REFRESH(\\1)[^>\/]*?\/>/si";
	$replace[]="";
	
	// Sanitizing scripts in IMG tag
	//$search[]= "/(<IMG[\s]+[^>\/]*SOURCE=)(['\"])?(.*)(\\2)([^>\/]*?\/>)/si";
	//$replace[]="";
	
	// Set iframe tag
	$search[]= "/<IFRAME[^>\/]*SRC=(['\"])?([^>\/]*)(\\1)[^>\/]*?\/>/si";
	$replace[]=" [!IFRAME FILTERED! \\2] ";
	$search[]= "/<IFRAME[^>]*?>([^<]*)<\/IFRAME>/si";
	$replace[]=" [!IFRAME FILTERED! \\1] ";
	// action
	$text = preg_replace($search, $replace, $text);
	return $text;
}

endif;
?>