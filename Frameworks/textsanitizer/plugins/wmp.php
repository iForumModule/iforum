<?php
/**
 * TextSanitizer extension
 *
 * Not finished
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		4.00
 * @version		$Id$
 * @package		Frameworks::textsanitizer
 */
	
function textsanitizer_wmp(&$ts)
{
	$ts->patterns[] = "/\[wmp=(['\"]?)([^\"']*),([^\"']*)\\1]([^\"]*)\[\/wmp\]/sU";
    $rp  = "<object classid=\"clsid:6BF52A52-394A-11D3-B153-00C04F79FAA6\" id=\"WindowsMediaPlayer\" width=\"\\2\" height=\"\\3\">\n";
    $rp .= "<param name=\"URL\" value=\"\\4\">\n";
    $rp .= "<param name=\"AutoStart\" value=\"0\">\n";
	$rp .= "<embed autostart=\"0\" src=\"\\4\" type=\"video/x-ms-wmv\" width=\"\\2\" height=\"\\3\" controls=\"ImageWindow\" console=\"cons\"> </embed>";
    $rp .= "</object>\n";
	$ts->replacements[] = $rp;
}
?>