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

	
function textsanitizer_image(&$ts, $allowimage = 1)
{
	$EXTCODE_IMAGE_MAX_WIDTH = ( defined('EXTCODE_IMAGE_MAX_WIDTH') && EXTCODE_IMAGE_MAX_WIDTH > 0 ) ? intval( EXTCODE_IMAGE_MAX_WIDTH ) : 0;
	$ts->patterns[] = "/\[img align=(['\"]?)(left|center|right)\\1 width=(['\"]?)([0-9]*)\\3]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
	$ts->patterns[] = "/\[img align=(['\"]?)(left|center|right)\\1]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
	$ts->patterns[] = "/\[img width=(['\"]?)([0-9]*)\\1]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
	$ts->patterns[] = "/\[img]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
	$ts->patterns[] = "/\[img align=(['\"]?)(left|center|right)\\1 id=(['\"]?)([0-9]*)\\3]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
	$ts->patterns[] = "/\[img id=(['\"]?)([0-9]*)\\1]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
	if (!$allowimage) {
		$ts->replacements[] = '<a href="\\5" target="_blank">\\5</a>';
		$ts->replacements[] = '<a href="\\3" target="_blank">\\3</a>';
		$ts->replacements[] = '<a href="\\3" target="_blank">\\3</a>';
		$ts->replacements[] = '<a href="\\1" target="_blank">\\1</a>';
		$ts->replacements[] = '<a href="'.XOOPS_URL.'/image.php?id=\\4" target="_blank">\\4</a>';
		$ts->replacements[] = '<a href="'.XOOPS_URL.'/image.php?id=\\2" target="_blank">\\3</a>';
	} else {
		if (EXTCODE_ENABLE_IMAGE_CLICKABLE && $EXTCODE_IMAGE_MAX_WIDTH){
			$ts->replacements[] = "<a href='javascript:CaricaFoto(\"\\5\");'><img src='\\5' align='\\2' alt='Open in new window' border='0' onload=\"JavaScript:if(this.width>\\4)this.width=\\4\" /></a><br />";
			$ts->replacements[] = "<a href='javascript:CaricaFoto(\"\\3\");'><img src='\\3' align='\\2' alt='Open in new window' border='0' ".
				( EXTCODE_ENABLE_IMAGE_RESIZE ? "onload=\"JavaScript:imageResize(this, ".$EXTCODE_IMAGE_MAX_WIDTH.")\"" : "" ).
				"/></a><br />";
			$ts->replacements[] = "<a href='javascript:CaricaFoto(\"\\3\");'><img src='\\3' alt='Open in new window' border='0' onload=\"JavaScript:if(this.width>\\2)this.width=\\2\" /></a><br />";
			$ts->replacements[] = "<a href='javascript:CaricaFoto(\"\\1\");'><img src='\\1' alt='Open in new window' border='0'".
				( EXTCODE_ENABLE_IMAGE_RESIZE ? " onload=\"JavaScript:imageResize(this, ".$EXTCODE_IMAGE_MAX_WIDTH.")\"" : "" ).
				"/></a><br />";
		}else{
			$ts->replacements[] = "<img src='\\5' border='0' alt='' onload=\"JavaScript:if(this.width>\\4)this.width=\\4\" align='\\2' /><br />";
			$ts->replacements[] = "<img src='\\3' border='0' alt='' ".
				( EXTCODE_ENABLE_IMAGE_RESIZE ? " onload=\"JavaScript:imageResize(this, ".$EXTCODE_IMAGE_MAX_WIDTH.")\"" : "" ).
				"/></a><br />";
			$ts->replacements[] = "<img src='\\3' border='0' alt='' onload=\"JavaScript:if(this.width>\\2)this.width=\\2\" /><br />";
			$ts->replacements[] = "<img src='\\1' border='0' alt='' ".
				( EXTCODE_ENABLE_IMAGE_RESIZE ? " onload=\"JavaScript:imageResize(this, ".$EXTCODE_IMAGE_MAX_WIDTH.")\"" : "" ).
				"/></a><br />";
		}
		$ts->replacements[] = '<img src="'.XOOPS_URL.'/image.php?id=\\4" align="\\2" alt="\\4" />';
		$ts->replacements[] = '<img src="'.XOOPS_URL.'/image.php?id=\\2" alt="\\3" />';
	}
}
?>