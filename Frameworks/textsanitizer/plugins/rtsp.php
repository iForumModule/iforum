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

function textsanitizer_rtsp(&$ts)
{
	$ts->patterns[] = "/\[rtsp=(['\"]?)([^\"']*),([^\"']*)\\1]([^\"]*)\[\/rtsp\]/sU";
	$rp = "<object classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" HEIGHT='\\3' ID=Player WIDTH='\\2' VIEWASTEXT>";
	$rp .= "<param NAME=\"_ExtentX\" VALUE=\"12726\">";
	$rp .= "<param NAME=\"_ExtentY\" VALUE=\"8520\">";
	$rp .= "<param NAME=\"AUTOSTART\" VALUE=\"0\">";
	$rp .= "<param NAME=\"SHUFFLE\" VALUE=\"0\">";
	$rp .= "<param NAME=\"PREFETCH\" VALUE=\"0\">";
	$rp .= "<param NAME=\"NOLABELS\" VALUE=\"0\">";
	$rp .= "<param NAME=\"CONTROLS\" VALUE=\"ImageWindow\">";
	$rp .= "<param NAME=\"CONSOLE\" VALUE=\"_master\">";
	$rp .= "<param NAME=\"LOOP\" VALUE=\"0\">";
	$rp .= "<param NAME=\"NUMLOOP\" VALUE=\"0\">";
	$rp .= "<param NAME=\"CENTER\" VALUE=\"0\">";
	$rp .= "<param NAME=\"MAINTAINASPECT\" VALUE=\"1\">";
	$rp .= "<param NAME=\"BACKGROUNDCOLOR\" VALUE=\"#000000\">";
	$rp .= "<param NAME=\"SRC\" VALUE=\"\\4\">";
	$rp .= "<embed autostart=\"0\" src=\"\\4\" type=\"audio/x-pn-realaudio-plugin\" HEIGHT='\\3' WIDTH='\\2' controls=\"ImageWindow\" console=\"cons\"> </embed>";
	$rp .= "</object>";
	$rp .= "<br /><object CLASSID=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA HEIGHT=32 ID=Player WIDTH='\\2' VIEWASTEXT>";
	$rp .= "<param NAME=\"_ExtentX\" VALUE=\"18256\">";
	$rp .= "<param NAME=\"_ExtentY\" VALUE=\"794\">";
	$rp .= "<param NAME=\"AUTOSTART\" VALUE=\"0\">";
	$rp .= "<param NAME=\"SHUFFLE\" VALUE=\"0\">";
	$rp .= "<param NAME=\"PREFETCH\" VALUE=\"0\">";
	$rp .= "<param NAME=\"NOLABELS\" VALUE=\"0\">";
	$rp .= "<param NAME=\"CONTROLS\" VALUE=\"controlpanel\">";
	$rp .= "<param NAME=\"CONSOLE\" VALUE=\"_master\">";
	$rp .= "<param NAME=\"LOOP\" VALUE=\"0\">";
	$rp .= "<param NAME=\"NUMLOOP\" VALUE=\"0\">";
	$rp .= "<param NAME=\"CENTER\" VALUE=\"0\">";
	$rp .= "<param NAME=\"MAINTAINASPECT\" VALUE=\"0\">";
	$rp .= "<param NAME=\"BACKGROUNDCOLOR\" VALUE=\"#000000\">";
	$rp .= "<param NAME=\"SRC\" VALUE=\"\\4\">";
	$rp .= "<embed autostart=\"0\" src=\"\\4\" type=\"audio/x-pn-realaudio-plugin\" HEIGHT='30' WIDTH='\\2' controls=\"ControlPanel\" console=\"cons\"> </embed>";
	$rp .= "</object>";

	$ts->replacements[] = $rp;
}
?>