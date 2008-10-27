<?php
/**
 * CAPTCHA class For XOOPS
 *
 * Currently there are two types of CAPTCHA forms, text and image
 * The default mode is "text", it can be changed in the priority:
 * 1 If mode is set through XoopsFormCaptcha::setMode(), take it
 * 2 Elseif mode is set though captcha/config.php, take it
 * 3 Else, take "text"
 *
 * D.J.
 */

$config = array(
	"mode"				=> 'image', 
	"name"				=> 'xoopscaptcha', 
	"skipmember"		=> true,					// Skip CAPTCHA check for members
	"maxattempt"		=> 10,  					// Maximum attempts for each session
	
	"num_chars"			=> 4,  						// Maximum characters
	
													// For image mode, based on DuGris' SecurityImage
	"rootpath"			=> dirname(__FILE__),		// __Absolute__ Path to the root of fonts and backgrounds
	"imagepath"			=> "uploads/captcha",		// Path to temporary image files, __relative__ to XOOPS_ROOT_PATH
	"imageurl"			=> "Frameworks/captcha/scripts/img.php",		// Path to the script for creating image, __relative__ to XOOPS_ROOT_PATH
	"casesensitive"		=> false,					// Characters in image mode is case-sensitive
	"fontsize_min"		=> 12,  					// Minimum font-size
	"fontsize_max"		=> 12,  					// Maximum font-size 
	"background_type"	=> 0, 						// Background type in image mode: 0 - bar; 1 - circle; 2 - line; 3 - rectangle; 4 - ellipse; 5 - polygon; 100 - generated from files
	"background_num"	=> 50,						// Number of background images to generate
	"polygon_point"		=> 3,
	);
	
$language = preg_replace("/[^a-z0-9_\-]/i", "", $GLOBALS["xoopsConfig"]["language"]);

if(! @include_once dirname(__FILE__)."/language/{$language}.php") {
	require_once dirname(__FILE__)."/language/english.php";
}

return $config;
?>