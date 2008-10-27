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

if (!defined('XOOPS_ROOT_PATH')) { exit(); }
if (!defined('FPDF_PATH')) { exit(); }

class xoopsPDF
{
	var $language;
	var $charset;
	var $data;
	var $config;
	var $pdf_handler;
	var $cache;
	var $cache_id;
	var $content;
	var $delimiter = "[XoopsPDF]";
	
	function xoopsPDF($language, $charset = _CHARSET)
	{
		$this->charset = preg_replace("/[^a-z0-9_\-]/i", "", $charset);
		$this->language = preg_replace("/[^a-z0-9_\-]/i", "", $language);
		define("FPDF_CHARSET_XOOPS", $this->charset);
		$this->_load_locale();
		$this->cache = $GLOBALS["xoopsOption"]["pdf_cache"];
	}
	
	function initialize($orientation='P', $unit='mm', $format='A4')
	{
		require_once dirname(__FILE__)."/pdf.php";
	    $this->pdf_handler =& new PDF($orientation, $unit, $format);
	}
	
	function _encoding()
	{
		$this->pdf_handler->encoding($this->data, $this->charset);
		$this->pdf_handler->encoding($this->config, $this->charset);
	}
	
	function loadCache($filename)
	{
    	$filename = XOOPS_CACHE_PATH."/{$filename}.html";
        if ( file_exists($filename) && ($fd = @fopen($filename, 'rb')) ) {
            $contents = '';
            while (!feof($fd)) {
                $contents .= fread($fd, 8192);
            }
            fclose($fd);
            if ( !$pos = strpos($contents, $this->delimiter) ) return null;
            $data["key"] = substr($contents, 0, $pos);
            $data["content"] = substr($contents, $pos + strlen($this->delimiter));
            return $data;
        }
        return null;
	}
	
	function createCache($data, $filename)
	{
    	$filename = XOOPS_CACHE_PATH."/{$filename}.html";
        if ($fd = @fopen($filename, 'wb')) {
            fputs($fd, $data["key"].$this->delimiter.$data["content"]);
            fclose($fd);
            return true;
        }
        return false;
	}
	
    /**
     * PDF maker cache policy
     * 
     * Possible cache values:
     * 0 - no cache
     * -1 - update cache upon content change verified by md5
     * positive integer - seconds
     */
	function is_cached()
	{
    	//load_functions("cache");
    	if (!$data = $this->loadCache($this->cache_id)) {
        	return false;
    	}
    	if ($this->cache > 0) {
        	if (time() - $data["key"] > $this->cache) {
            	return false;
        	}
        	$this->content = $data["content"];
        	return true;
    	}
    	if (md5(serialize($this->data)) == $data["key"]) {
        	$this->content = $data["content"];
        	return true;
    	}
    	
    	return false;
	}
	
	function generateCacheId($cache_id) {
		
		// Generate language section
		$extra_string = $this->language."|".$this->charset;
		
		// XOOPS_DB_PASS and XOOPS_DB_NAME (before we find better variables) are used to protect sensitive contents
		$extra_string .= '|' . substr( md5(XOOPS_DB_PASS.XOOPS_DB_NAME), 0, strlen(XOOPS_DB_USER) * 2 );
		$cache_id .= '|' . $extra_string;
		$this->cache_id = urlencode($cache_id);
		return $this->cache_id;
	}
	
	function checkCache() {
		global $xoopsModule;

		if ( $this->cache ) {
			$uri = str_replace( XOOPS_URL, '', $_SERVER['REQUEST_URI'] );
			// Clean uri by removing session id
			if (defined('SID') && SID && strpos($uri, SID)) {
				$uri = preg_replace("/([\?&])(".SID."$|".SID."&)/", "\\1", $uri);
			}
			$dirname = is_object($xoopsModule) ? $xoopsModule->getVar( 'dirname', 'n' ) : "system";
			$cacheId = $this->generateCacheId($dirname . '|' . $uri);

			if ( $this->is_cached( ) ) {
				$this->render( );
				return true;
            }
		}
		return false;
	}
	
	function render()
	{
    	if (!$this->content) {
            $this->content = $this->pdf_handler->Output("", "S");
            if ($this->cache) {
                $data = array();
                $data["content"] = $this->content;
            	if ($this->cache > 0) {
                	$data["key"] = time();
            	} else {
                	$data["key"] = md5(serialize($this->data));
            	}
        	    $this->createCache($data, $this->cache_id);
        	}
    	}
    	
    	$name = "doc.pdf";
		//Send to standard output
		if(ob_get_contents())
			$this->pdf_handler->Error('Some data has already been output, can\'t send PDF file');
		if(php_sapi_name()!='cli')
		{
			//We send to a browser
			header('Content-Type: application/pdf');
			if(headers_sent())
				$this->pdf_handler->Error('Some data has already been output to browser, can\'t send PDF file');
			header('Content-Length: '.strlen($this->content));
			header('Content-disposition: inline; filename="'.$name.'"');
		}
		echo $this->content;
	}
	 
	function output($pdf_data)
	{
		$this->data = $pdf_data;
		if ($this->checkCache()) {
    		return true;
		}
		
		$this->_encoding();
		
		$pdf_data = $this->data;
		$pdf_config =& $this->config;
		
		$pdf =& $this->pdf_handler;
		
		$puff = "<br />";
		$puffer = "<br />";
		
		$pdf_data['title'] = $pdf_config["constant"]["title"].": ".$pdf_data['title'];
		if (!empty($pdf_data['subtitle'])){
			$pdf_data['subtitle'] = $pdf_config["constant"]["subtitle"].": ".$pdf_data['subtitle'];
		}
		if (!empty($pdf_data['subsubtitle'])){
			$pdf_data['subsubtitle'] = $pdf_config["constant"]["subsubtitle"].": ".$pdf_data['subsubtitle'];
		}
		$pdf_data['author'] = $pdf_config["constant"]["author"].': '.$pdf_data['author'];
		$pdf_data['date'] = $pdf_config["constant"]["date"]. ': '.$pdf_data['date'];
		$pdf_data['url'] = $pdf_config["constant"]["url"]. ': '.$pdf_data['url'];
		
		$pdf->SetCreator($pdf_config["creator"]);
		$pdf->SetTitle($pdf_data["title"]);
		$pdf->SetAuthor($pdf_config["slogan"]);
		$pdf->SetSubject($pdf_data["author"]);
		$keywords = array_filter(array($pdf_config["name"], $pdf_data["url"], $pdf_data["author"], $pdf_data["title"], $pdf_data["subtitle"], $pdf_data["subsubtitle"]));
		$pdf->SetKeywords(implode(", ", $keywords));
		$pdf->SetAutoPageBreak(true,25);
		$pdf->SetMargins($pdf_config["margin"]["left"],$pdf_config["margin"]["top"],$pdf_config["margin"]["right"]);
		
		$pdf->Open();
		
		//First page
		$pdf->AddPage();
		$pdf->SetXY(24,25);
		$pdf->SetTextColor(10,60,160);
		$pdf->SetFont($pdf_config["font"]["slogan"]["family"], $pdf_config["font"]["slogan"]["style"], $pdf_config["font"]["slogan"]["size"]);
		$pdf->WriteHTML($pdf_config["slogan"], $pdf_config["scale"]);
		$pdf->Image($pdf_config["logo"]["path"],$pdf_config["logo"]["left"],$pdf_config["logo"]["top"],$pdf_config["logo"]["width"],$pdf_config["logo"]["height"],"",$pdf_config["url"]);
		$pdf->Line(25,30,190,30);
		$pdf->SetXY(25,35);
		$pdf->SetFont($pdf_config["font"]["title"]["family"],$pdf_config["font"]["title"]["style"],$pdf_config["font"]["title"]["size"]);
		$pdf->WriteHTML($pdf_data["title"],$pdf_config["scale"]);
		
		if (!empty($pdf_data['subtitle'])){
			$pdf->WriteHTML($puff,$pdf_config["scale"]);
			$pdf->SetFont($pdf_config["font"]["subtitle"]["family"],$pdf_config["font"]["subtitle"]["style"],$pdf_config["font"]["subtitle"]["size"]);
			$pdf->WriteHTML($pdf_data["subtitle"],$pdf_config["scale"]);
		}
		if (!empty($pdf_data["subsubtitle"])) {
			$pdf->WriteHTML($puff,$pdf_config["scale"]);
			$pdf->SetFont($pdf_config["font"]["subsubtitle"]["family"],$pdf_config["font"]["subsubtitle"]["style"],$pdf_config["font"]["subsubtitle"]["size"]);
			$pdf->WriteHTML($pdf_data["subsubtitle"],$pdf_config["scale"]);
		}
		
		$pdf->WriteHTML($puff,$pdf_config["scale"]);
		$pdf->SetFont($pdf_config["font"]["author"]["family"],$pdf_config["font"]["author"]["style"],$pdf_config["font"]["author"]["size"]);
		$pdf->WriteHTML($pdf_data["author"],$pdf_config["scale"]);
		$pdf->WriteHTML($puff,$pdf_config["scale"]);
		$pdf->WriteHTML($pdf_data["date"],$pdf_config["scale"]);
		$pdf->WriteHTML($puff,$pdf_config["scale"]);
		$pdf->WriteHTML($pdf_data['url'],$pdf_config["scale"]);
		$pdf->WriteHTML($puff,$pdf_config["scale"]);
		
		$pdf->SetTextColor(0,0,0);
		$pdf->WriteHTML($puffer,$pdf_config["scale"]);
		
		$pdf->SetFont($pdf_config["font"]["content"]["family"],$pdf_config["font"]["content"]["style"],$pdf_config["font"]["content"]["size"]);
		$pdf->WriteHTML($pdf_data["content"],$pdf_config["scale"]);
		
		$this->render();
	}

	function _load_locale()
	{
		if ( @include_once(FPDF_PATH.'/language/'.strtolower($this->language.'_'.str_replace('-', '', $this->charset)).'.php') ) {
		} elseif ( @include_once(FPDF_PATH.'/language/'.$this->language.'.php') ) {
		} elseif ( !@include_once(FPDF_PATH.'/language/english.php') ) {
			die('No Language File!');
		}
		$this->config =& $GLOBALS["pdf_config"];
	}
}
?>
