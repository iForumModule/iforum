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
require FPDF_PATH.'/chinese.php';
class FPDF_local extends PDF_Chinese{}

require_once dirname(__FILE__)."/language.php";

// Valid PDF charset
$pdf_config['charset']	= 'GB2312';

// Language definitios
$pdf_config['constant']	= array(
	'title'			=>	'标题',
	'subtitle'		=>	'子标题',
	'subsubtitle'	=>	'二级子标题',
	'author'		=>	'作者',
	'date'			=>	'日期',
	'url'			=>	'网址',
	);

$pdf_config['font']['slogan'] = array(
	'family'		=> 'simhei',
	'style'			=> '',
	'size'			=> 20
	);

$pdf_config['font']['title'] = array(
	'family'		=> 'simhei',
	'style'			=> 'bu',
	'size'			=> 12
	);

$pdf_config['font']['subject'] = array(
	'family'		=> 'simhei',
	'style'			=> 'b',
	'size'			=> 11
	);

$pdf_config['font']['author'] = array(
	'family'		=> 'simsun',
	'style'			=> '',
	'size'			=> 10
	);

$pdf_config['font']['subtitle'] = array(
	'family'		=> 'simhei',
	'style'			=> 'b',
	'size'			=> 11
	);

$pdf_config['font']['subsubtitle'] = array(
	'family'		=> 'simhei',
	'style'			=> 'b',
	'size'			=> 10
	);

$pdf_config['font']['content'] = array(
	'family'		=> 'simsun',
	'style'			=> '',
	'size'			=> 10
	);

$pdf_config['font']['footer'] = array(
	'family'		=> 'simsun',
	'style'			=> '',
	'size'			=> 8
	);
	
$pdf_config['footerpage'] 		= "第 %s 页";

// For more details, refer to: http://fpdf.org
class PDF_language extends _PDF_language
{
	function PDF_language($orientation='P', $unit='mm', $format='A4')
	{
	    //Call parent constructor
	    $this->FPDF($orientation, $unit, $format);
	    //Initialization
		$this->AddGBhwFont('simsun','宋体');
		$this->AddGBhwFont('simhei','黑体');
		$this->AddGBhwFont('simkai','楷体_GB2312');
		$this->AddGBhwFont('sinfang','仿宋_GB2312');
	}

	function Error($msg)
	{
		global $pdf_config;
		if($pdf_config['action_on_error']){
			//Fatal error
			die('<B>FPDF 错误: </B>'.$msg);
		}
	}

	function _encoding(&$text, $in_charset, $out_charset = null)
	{
		if($out_charset === null) $out_charset = $this->$out_charset;
		
		if(function_exists("xoopschina_convert_encoding")) {
			$text = xoopschina_convert_encoding($text, $in_charset, $out_charset);
			return;
		}

		$xconv_handler = @xoops_getmodulehandler('xconv', 'xconv', true);
		if($xconv_handler &&
			$converted_text = @$xconv_handler->convert_encoding($text, $out_charset, $in_charset)
		){
			$text = $converted_text;
			return;
		}
		if(XOOPS_USE_MULTIBYTES && function_exists('mb_convert_encoding')) $converted_text = @mb_convert_encoding($text, $out_charset, $in_charset);
		else
		if(function_exists('iconv')) $converted_text = @iconv($in_charset, $out_charset . "//TRANSLIT", $text);
		$text = empty($converted_text)?$text:$converted_text;
	}
}
?>