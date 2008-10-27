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
	
// Parse links to internal wiki module
// We suppose only the internal link syntax is enabled, so no need to implement a wiki parser
function textsanitizer_wiki(&$ts)
{
	if (!EXTCODE_ENABLE_WIKI) {
		return;
	}
	$ts->patterns[] = "/\[\[([^\]]*)\]\]/esU";
	$ts->replacements[] = "_textsanitizer_wikiLink( '\\1' )"; 
}

function _textsanitizer_wikiLink($text)
{
	if ( empty($text) || !defined('EXTCODE_ENABLE_WIKI_LINK') || EXTCODE_ENABLE_WIKI_LINK == '' ) return $text;
	$charset = ( defined('EXTCODE_ENABLE_WIKI_CHARSET') && EXTCODE_ENABLE_WIKI_CHARSET != '' ) ? EXTCODE_ENABLE_WIKI_CHARSET : "UTF-8";
	
	load_functions("locale");
	$ret = "<a href='".sprintf( EXTCODE_ENABLE_WIKI_LINK, urlencode( XoopsLocal::convert_encoding($text, $charset) ) )."' target='_blank' title=''>".$text."</a>";
	return $ret;
}
?>