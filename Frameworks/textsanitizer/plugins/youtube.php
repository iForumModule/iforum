<?php
/**
 * TextSanitizer extension -  youtube
 *
 *
 * @copyright	The XOOPS Project http://xoops.sf.net
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <phppp@users.sourceforge.net>
 * @since		1.00
 * @version		$Id$
 * @package		Frameworks::textsanitizer
 */
 
function _textsanitizer_displayYoutube($url, $width, $height)
{
    if (!preg_match("/^http:\/\/(www\.)?youtube\.com\/watch\?v=(.*)/i", $url, $matches)) {
        trigger_error("Not matched: $url $width $height", E_USER_WARNING);
        return "";
    }
    $src = "http://www.youtube.com/v/".$matches[2];
	if (empty($width) || empty($height)) {
		if ( !$dimension = @getimagesize($src) ) {
			return "";
		}
		if (!empty($width)) {
			$height = $dimension[1] * $width /  $dimension[0];
		} elseif (!empty($height)) {
			$width = $dimension[0] * $height /  $dimension[1];
		} else {
			list($width, $height) = array($dimension[0], $dimension[1]);
		}
	}
	$code = "<object width='{$width}' height='{$height}'><param name='movie' value='{$src}'></param>".
	        "<param name='wmode' value='transparent'></param>".
	        "<embed src='{$src}' type='application/x-shockwave-flash' wmode='transparent' width='425' height='350'></embed>".
	        "</object>";
	return $code;
}

function textsanitizer_youtube(&$ts)
{
	$ts->patterns[] = "/\[youtube=(['\"]?)([^\"']*),([^\"']*)\\1]([^\"]*)\[\/youtube\]/esU";
	$ts->replacements[] = "_textsanitizer_displayYoutube( '\\4', '\\2', '\\3' )"; 
}
?>