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

	
function textsanitizer_iframe(&$ts)
{
	$ts->patterns[] = "/\[iframe=(['\"]?)([^\"']*)\\1]([^\"]*)\[\/iframe\]/sU";
	if (@EXTCODE_ENABLE_IFRAME) {
		$ts->replacements[] = "<iframe src='\\3' width='100%' height='\\2' scrolling='auto' frameborder='yes' marginwidth='0' marginheight='0' noresize></iframe>";
	} else {
		$ts->replacements[] = '[IFRAME FILTERED: \\3]';
	}
}
?>