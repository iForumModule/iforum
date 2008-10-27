<?php
/**
 * TextSanitizer extension -  flash
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		4.00
 * @version		$Id$
 * @package		Frameworks::textsanitizer
 */
 
function _textsanitizer_displayFlash($url, $width, $height)
{
	if(empty($width) || empty($height)) {
		if( !$dimension = @getimagesize($url) ) {
			return "<a href='{$url}' target='_blank'>{$url}</a>";
		}
		if(!empty($width)) {
			$height = $dimension[1] * $width /  $dimension[0];
		}elseif(!empty($height)) {
			$width = $dimension[0] * $height /  $dimension[1];
		}else{
			list($width, $height) = array($dimension[0], $dimension[1]);
		}
	}
	
	$rp  = "<object width='{$width}' height='{$height}' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0'>";
	$rp .= "<param name='movie' value='{$url}'>";
	$rp .= "<param name='QUALITY' value='high'>";
	$rp .= "<PARAM NAME='bgcolor' VALUE='#FFFFFF'>";
	$rp .= "<param name='wmode' value='transparent'>";
	$rp .= "<embed src='{$url}' width='{$width}' height='{$height}' quality='high' bgcolor='#FFFFFF' wmode='transparent'  pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'></embed>";
	$rp .= "</object>";
	return $rp;
}

function textsanitizer_flash(&$ts)
{
	$ts->patterns[] = "/\[(swf|flash)=(['\"]?)([^\"']*),([^\"']*)\\2]([^\"]*)\[\/\\1\]/esU";
	$ts->replacements[] = "_textsanitizer_displayFlash( '\\5', '\\3', '\\4' )"; 
}
?>