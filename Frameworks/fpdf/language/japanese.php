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
require FPDF_PATH.'/japanese.php';
class FPDF_local extends PDF_Japanese{}

require_once dirname(__FILE__)."/language.php";

// Modify any configs not applicable to your language

// Valid PDF charset
$pdf_config['charset']	= 'SJIS';

$pdf_config['font']['slogan'] = array(
	'family'=>'SJIS-hw',
	'style'=>'bi',
	'size'=>8
	);

$pdf_config['font']['title'] = array(
	'family'=>'SJIS-hw',
	'style'=>'biu',
	'size'=>12
	);

$pdf_config['font']['subject'] = array(
	'family'=>'SJIS-hw',
	'style'=>'b',
	'size'=>11
	);

$pdf_config['font']['author'] = array(
	'family'=>'SJIS-hw',
	'style'=>'',
	'size'=>10
	);

$pdf_config['font']['subtitle'] = array(
	'family'=>'SJIS-hw',
	'style'=>'b',
	'size'=>11
	);

$pdf_config['font']['subsubtitle'] = array(
	'family'=>'SJIS-hw',
	'style'=>'b',
	'size'=>10
	);

$pdf_config['font']['content'] = array(
	'family'=>'SJIS-hw',
	'style'=>'',
	'size'=>10
	);

$pdf_config['font']['footer'] = array(
	'family'=>'SJIS-hw',
	'style'=>'',
	'size'=>8
	);
/*	
$pdf_config['action_on_error']	= 0; // 0 - continue; 1 - die
$pdf_config['creator'] 			= 'XOOPS PDF CREATOR BASED ON FPDF v1.53';
$pdf_config['name'] 			= $xoopsModule->getVar("name");
$pdf_config['url'] 				= XOOPS_URL;
$pdf_config['mail'] 			= 'mailto:'.$xoopsConfig['adminmail'];
$pdf_config['slogan']			= xoops_substr($myts->htmlspecialchars( $xoopsConfig['sitename'] ) , 0, 30);
$pdf_config['scale'] 			= '0.8';
$pdf_config['dateformat'] 		= _DATESTRING;
$pdf_config['footerpage'] 		= "Page %s";
*/
	
// Usually you do not need change the following class if you are not using: S/T Chinese, Korean, Japanese
// For more details, refer to: http://fpdf.org
class PDF_language extends _PDF_language
{
	function PDF_language($orientation='P', $unit='mm', $format='A4')
	{
	    $this->FPDF($orientation, $unit, $format);
		$this->AddSJIShwFont();
		$this->out_charset = $GLOBALS['pdf_config']['charset'];
	}

	// Modify any of the following function to suit your language
	// refer to schinese.php for example
	
	/*
	function Error($msg)
	{
		return parent::Error($msg);
	}

	function encoding(&$text, $in_charset, $out_charset = null)
	{
		parent::encoding($text, $in_charset, $out_charset);
	}

	function _encoding_array(&$text, $in_charset, $out_charset = null)
	{
		parent::_encoding_array($text, $in_charset, $out_charset);
	}
	*/

	function _encoding(&$text, $in_charset, $out_charset = null)
	{
		// some conversion goes here
		// refer to schinese.php for example
	}
}
?>