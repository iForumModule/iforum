<?php
/**
 * TextSanitizer extension
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		4.00
 * @version		$Id$
 * @package		Frameworks::textsanitizer
 */
	
function textsanitizer_mms(&$ts)
{
	$ts->patterns[] = "/\[mms=(['\"]?)([^\"']*),([^\"']*)\\1]([^\"]*)\[\/mms\]/sU";
	$rp = "<OBJECT id=videowindow1 height='\\3' width='\\2' classid='CLSID:6BF52A52-394A-11D3-B153-00C04F79FAA6'>";
	$rp .= "<PARAM NAME=\"URL\" VALUE=\"\\4\">";
	$rp .= "<PARAM NAME=\"rate\" VALUE=\"1\">";
	$rp .= "<PARAM NAME=\"balance\" VALUE=\"0\">";
	$rp .= "<PARAM NAME=\"currentPosition\" VALUE=\"0\">";
	$rp .= "<PARAM NAME=\"defaultFrame\" VALUE=\"\">";
	$rp .= "<PARAM NAME=\"playCount\" VALUE=\"1\">";
	$rp .= "<PARAM NAME=\"autoStart\" VALUE=\"0\">";
	$rp .= "<PARAM NAME=\"currentMarker\" VALUE=\"0\">";
	$rp .= "<PARAM NAME=\"invokeURLs\" VALUE=\"-1\">";
	$rp .= "<PARAM NAME=\"baseURL\" VALUE=\"\">";
	$rp .= "<PARAM NAME=\"volume\" VALUE=\"50\">";
	$rp .= "<PARAM NAME=\"mute\" VALUE=\"0\">";
	$rp .= "<PARAM NAME=\"uiMode\" VALUE=\"full\">";
	$rp .= "<PARAM NAME=\"stretchToFit\" VALUE=\"0\">";
	$rp .= "<PARAM NAME=\"windowlessVideo\" VALUE=\"0\">";
	$rp .= "<PARAM NAME=\"enabled\" VALUE=\"-1\">";
	$rp .= "<PARAM NAME=\"enableContextMenu\" VALUE=\"-1\">";
	$rp .= "<PARAM NAME=\"fullScreen\" VALUE=\"0\">";
	$rp .= "<PARAM NAME=\"SAMIStyle\" VALUE=\"\">";
	$rp .= "<PARAM NAME=\"SAMILang\" VALUE=\"\">";
	$rp .= "<PARAM NAME=\"SAMIFilename\" VALUE=\"\">";
	$rp .= "<PARAM NAME=\"captioningID\" VALUE=\"\">";
	$rp .= "<PARAM NAME=\"enableErrorDialogs\" VALUE=\"0\">";
	$rp .= "<PARAM NAME=\"_cx\" VALUE=\"12700\">";
	$rp .= "<PARAM NAME=\"_cy\" VALUE=\"8731\">";
	$rp .= "</OBJECT>";
	$ts->replacements[] = $rp;
}
?>