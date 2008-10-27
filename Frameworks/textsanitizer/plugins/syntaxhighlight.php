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

	
function textsanitizer_syntaxhighlight(&$ts, &$source, $language )
{
	if (!EXTCODE_ENABLE_CODE_HIGHLIGHT){
		return "<pre>{$source}</pre>";
	}
	$source = MyTextSanitizer::undoHtmlSpecialChars($source);
	$source = stripslashes($source);
	if ( EXTCODE_ENABLE_CODE_HIGHLIGHT == 2 ) {
		$language = str_replace('=', '', $language);
		$language = ($language) ? $language: EXTCODE_CODEHIGHLIGHT_LANGUAGE_DEFAULT;
	    $language = strtolower($language);
		if ( $source = _textsanitizer_geshi_highlight( $source, $language ) ) return $source;
	}
	$source = _textsanitizer_php_highlight($source);
	return $source;
}

function _textsanitizer_php_highlight($text)
{
	$text = trim($text);
	$addedtag_open = 0;
	if ( !strpos($text, "<?php") and (substr($text, 0, 5) != "<?php") ) {
		$text = "<?php\n" . $text;
		$addedtag_open = 1;
	}
	$addedtag_close = 0;
	if ( !strpos($text, "?>") ) {
		$text .= "?>";
		$addedtag_close = 1;
	}
	$oldlevel = error_reporting(0);
	$buffer = highlight_string($text, true); // Require PHP 4.20+
	error_reporting($oldlevel);
	$pos_open = $pos_close = 0;
	if ($addedtag_open) {
		$pos_open = strpos($buffer, '&lt;?php');
	}
	if ($addedtag_close) {
		$pos_close = strrpos($buffer, '?&gt;');
	}
	
	$str_open = ($addedtag_open) ? substr($buffer, 0, $pos_open) : "";
	$str_close = ($pos_close) ? substr($buffer, $pos_close + 5) : "";
	
	$length_open = ($addedtag_open) ? $pos_open + 8 : 0;
	$length_text = ($pos_close) ? $pos_close - $length_open : 0;
	$str_internal = ($length_text) ? substr($buffer, $length_open, $length_text) : substr($buffer, $length_open);
	
	$buffer = $str_open.$str_internal.$str_close;
	return $buffer;
}

function _textsanitizer_geshi_highlight( $source, $language )
{
	if ( !@include_once dirname(__FILE__) . '/geshi.php' ) return false;

    // Create the new GeSHi object, passing relevant stuff
    $geshi = new GeSHi($source, $language);
    // Enclose the code in a <div>
    $geshi->set_header_type(GESHI_HEADER_NONE);

	// Sets the proper encoding charset other than "ISO-8859-1"
    $geshi->set_encoding(_CHARSET);

	$geshi->set_link_target ( "_blank" );

    // Parse the code
    $code = $geshi->parse_code();

    return $code;
}
?>