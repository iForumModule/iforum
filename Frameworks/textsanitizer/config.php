<?php
/**
 * Extended TextSanitizer
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		4.00
 * @version		$Id$
 * @package		Frameworks::textsanitizer
 */

// Set to enable extended xoops code; set to 0 if you need disable it
if( !defined("XOOPS_ENABLE_EXTENDEDCODE") ){
	define("XOOPS_ENABLE_EXTENDEDCODE", 1 );
}

// Set prefences, applicable only if XOOPS_ENABLE_EXTENDEDCODE is set to true/1

define('EXTCODE_ENABLE_IFRAME',	 0); // enable iframe, this could be malicious, be careful

define('EXTCODE_ENABLE_FLASH',	1); // Flash
define('EXTCODE_ENABLE_YOUTUBE',	1); // Youtube
define('EXTCODE_ENABLE_WMP',	0); // Windows Media Player
define('EXTCODE_ENABLE_MMS',	0); // mms
define('EXTCODE_ENABLE_RTSP',	0); // RTSP

/*
 * Auto-detection of media(flash or image) dimension from the url: width, height
 * Be careful, enable it only in case you are sure about it as it is not always working
 * If it is not enabled, media submitter will be asked to provide dimensions for the media,
 * otherwise, media dimensions will be detected automatically when it is displayed, which requires CPU consumption and slows down page content generation
 */
define('EXTCODE_ENABLE_DIMENSION_DETECT',	1);

define('EXTCODE_ENABLE_WIKI',			1); // Add internal link to wiki module
define('EXTCODE_ENABLE_WIKI_LINK',		XOOPS_URL."/modules/mediawiki/?title=%s"); // The link to wiki module
define('EXTCODE_ENABLE_WIKI_CHARSET',	"UTF-8"); // Charset of wiki module

define('EXTCODE_ENABLE_CODE_HIGHLIGHT',				1);			// Source code highlight: 0 - disable; 1 - php highlight; 2 - geshi highlight
define('EXTCODE_CODEHIGHLIGHT_LANGUAGE_DEFAULT',	"PHP");		// Default language for code highlight, applicable only if geshi is enabled

define('EXTCODE_ENABLE_IMAGE_CLICKABLE',	1);		// Enable image clickable, open in a new window
define('EXTCODE_ENABLE_IMAGE_RESIZE',		1);		// Enable image resize, applicable only for xcode [img]
define('EXTCODE_IMAGE_MAX_WIDTH',			300);	// Maximum width for image resize functionality; 0 for no resize

define('EXTCODE_URL_MAX_LENGTH',			60); // Maximum length for a converted URL; 0 for no conversion

?>