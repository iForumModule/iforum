<?php
/**
 * FPDF creator framework for XOOPS
 *
 * Supporting multi-byte languages as well as utf-8 charset
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		frameworks
 */
if (!defined('FPDF_PATH')){ exit(); }

global $pdf_config;

// Valid PDF charset
$pdf_config['charset']	= 'ISO-8859-1';

// Language definitios
$pdf_config['constant']	= array(
	'title'			=>	'Title',
	'subtitle'		=>	'Subtitle',
	'subsubtitle'	=>	'Second Subtitle',
	'author'		=>	'Author',
	'date'			=>	'Date',
	'url'			=>	'URL',
	);
	
$pdf_config['margin']	= array(
	'left'		=> 25,
	'top'		=> 25,
	'right'		=> 25
	);

$pdf_config['logo']   = array(
	'path'		=> XOOPS_ROOT_PATH.'/images/logo.gif',
	'left'		=> 150,
	'top'		=> 5,
	'width'		=> 0,
	'height'	=> 0
	);

$pdf_config['font']['slogan']	= array(
	'family'	=> 'Arial',
	'style'		=> 'bi',
	'size'		=> 8
	);

$pdf_config['font']['title'] 	= array(
	'family'	=> 'Arial',
	'style'		=> 'biu',
	'size'		=> 12
	);

$pdf_config['font']['subject'] 	= array(
	'family'	=> 'Arial',
	'style'		=> 'b',
	'size'		=> 11
	);

$pdf_config['font']['author']	= array(
	'family'	=> 'Arial',
	'style'		=> '',
	'size'		=> 10
	);

$pdf_config['font']['subtitle']	= array(
	'family'	=> 'Arial',
	'style'		=> 'b',
	'size'		=> 11
	);

$pdf_config['font']['subsubtitle']	= array(
	'family'	=> 'Arial',
	'style'		=> 'b',
	'size'		=> 10
	);

$pdf_config['font']['content']		= array(
	'family'	=> 'Arial',
	'style'		=> '',
	'size'		=> 10
	);

$pdf_config['font']['footer'] 		= array(
	'family'	=> 'Arial',
	'style'		=> '',
	'size'		=> 8
	);

$pdf_config['action_on_error']	= 0; // 0 - continue; 1 - die
$pdf_config['creator'] 			= 'XOOPS PDF CREATOR BASED ON FPDF v1.53';
$pdf_config['name'] 			= $GLOBALS["xoopsModule"]->getVar("name");
$pdf_config['url'] 				= XOOPS_URL;
$pdf_config['mail'] 			= 'mailto:'.$GLOBALS["xoopsConfig"]['adminmail'];
$pdf_config['slogan']			= xoops_substr(htmlspecialchars( $GLOBALS["xoopsConfig"]['sitename'] ) , 0, 30);
$pdf_config['scale'] 			= '0.8';
$pdf_config['dateformat'] 		= _DATESTRING;
$pdf_config['footerpage'] 		= "Page %s";

if(class_exists("FPDF_local")){
	class FPDF_XOOPS extends FPDF_local{}
}else{
	class FPDF_XOOPS extends FPDF{}
}

// Usually you do not need change the following class if you are not using: S/T Chinese, Korean, Japanese
// For more details, refer to: http://fpdf.org
class _PDF_language extends FPDF_XOOPS
{
	var $out_charset;
	
	function _PDF_language()
	{
		$this->out_charset = $GLOBALS['pdf_config']['charset'];
	}

	function Error($msg)
	{
		global $pdf_config;
		if($pdf_config['action_on_error']){
			//Fatal error
			die('<B>FPDF error: </B>'.$msg);
		}
	}

	function encoding(&$text, $in_charset, $out_charset = null)
	{
		if($out_charset === null) $out_charset = $this->out_charset;
	    if (empty($text) || empty($in_charset) || empty($out_charset) || !strcasecmp($out_charset, $in_charset)) return;

	    if(is_array($text)){
			$this->_encoding_array($text, $in_charset, $out_charset);
    	}else{
		    $this->_encoding($text, $in_charset, $out_charset);
	    }
	}

	function _encoding_array(&$text, $in_charset, $out_charset = null)
	{
		if($out_charset === null) $out_charset = $this->out_charset;

	    if(is_array($text)){
		    foreach($text as $key=>$val){
		    	$this->_encoding_array($text[$key], $in_charset, $out_charset);
	    	}
    	}else{
		    $this->_encoding($text, $in_charset, $out_charset);
	    }
	}

	function _encoding(&$text, $in_charset, $out_charset = null)
	{
		if($out_charset === null) $out_charset = $this->$out_charset;
		
		if(XOOPS_USE_MULTIBYTES && function_exists('mb_convert_encoding')) $converted_text = @mb_convert_encoding($text, $out_charset, $in_charset);
		else
		if(function_exists('iconv')) $converted_text = @iconv($in_charset, $out_charset . "//TRANSLIT", $text);
		$text = empty($converted_text)?$text:$converted_text;
		
		// some conversion goes here
		// refer to schinese.php for example
	}
}
?>