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
 
define("MYTEXTSANITIZER_EXTENDED", 1);
include_once dirname(__FILE__)."/config.php";
include_once XOOPS_ROOT_PATH."/class/module.textsanitizer.php";

class MyTextSanitizerExtended extends MyTextSanitizer
{
	/**
	 * @var	holding reference to text
	 */
	var $text = "";
	
	var $patterns = array();
	var $replacements = array();
	
	function MyTextSanitizerExtended()
	{
		$this->MyTextSanitizer();
	}

	/**
	 * Access the only instance of this class
     *
     * @return	object
     *
     * @static
     * @staticvar   object
	 */
	function &getInstance()
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new MyTextSanitizerExtended();
		}
		return $instance;
	}
	
	function truncate($text)
	{
		if ( empty($text) || !defined('EXTCODE_URL_MAX_LENGTH') || EXTCODE_URL_MAX_LENGTH == 0 || strlen($text) < EXTCODE_URL_MAX_LENGTH ) return $text;
		$len = floor( EXTCODE_URL_MAX_LENGTH / 2 );
		$ret = substr($text, 0, $len) . " ... ". substr($text, 5 - $len);
		return $ret;
	}

	/**
	 * Make links in the text clickable
	 *
	 * @param   string  $text
	 * @return  string
	 **/
	function makeClickable(&$text)
	{
		$valid_chars = "a-z0-9\/\-_+=.~!%@?#&;:$\|";
		$patterns = array(
						"/(^|[^]_a-z0-9-=\"'\/])([a-z]+?):\/\/([{$valid_chars}]+)/ei", 
						"/(^|[^]_a-z0-9-=\"'\/])www\.([a-z0-9\-]+)\.([{$valid_chars}]+)/ei", 
						"/(^|[^]_a-z0-9-=\"'\/])ftp\.([a-z0-9\-]+)\.([{$valid_chars}]+)/ei", 
						"/(^|[^]_a-z0-9-=\"'\/:\.])([a-z0-9\-_\.]+?)@([{$valid_chars}]+)/ei");
		$replacements = array(
						"'\\1<a href=\"\\2://\\3\" title=\"\\2://\\3\" target=\"_blank\">\\2://'.MyTextSanitizerExtended::truncate( '\\3' ).'</a>'", 
						"'\\1<a href=\"http://www.\\2.\\3\" title=\"www.\\2.\\3\" target=\"_blank\">'.MyTextSanitizerExtended::truncate( 'www.\\2.\\3' ).'</a>'", 
						"'\\1<a href=\"ftp://ftp.\\2.\\3\" title=\"ftp.\\2.\\3\" target=\"_blank\">'.MyTextSanitizerExtended::truncate( 'ftp.\\2.\\3' ).'</a>'", 
						"'\\1<a href=\"mailto:\\2@\\3\" title=\"\\2@\\3\">'.MyTextSanitizerExtended::truncate( '\\2@\\3' ).'</a>'");
		return preg_replace($patterns, $replacements, $text);
	}

	/**
	 * Replace XoopsCodes with their equivalent HTML formatting
	 *
	 * @param   string  $text
	 * @param   bool    $allowimage Allow images in the text?
     *                              On FALSE, uses links to images.
	 * @return  string
	 **/
	function &xoopsCodeDecode(&$text, $allowimage = 1)
	{
		$patterns = array();
		$replacements = array();
		$patterns[] = "/\[siteurl=(['\"]?)([^\"'<>]*)\\1](.*)\[\/siteurl\]/sU";
		$replacements[] = '<a href="'.XOOPS_URL.'/\\2">\\3</a>';
		$patterns[] = "/\[url=(['\"]?)(http[s]?:\/\/[^\"'<>]*)\\1](.*)\[\/url\]/sU";
		$replacements[] = '<a href="\\2" target="_blank">\\3</a>';
		$patterns[] = "/\[url=(['\"]?)(ftp?:\/\/[^\"'<>]*)\\1](.*)\[\/url\]/sU";
		$replacements[] = '<a href="\\2" target="_blank">\\3</a>';
		$patterns[] = "/\[url=(['\"]?)([^\"'<>]*)\\1](.*)\[\/url\]/sU";
		$replacements[] = '<a href="http://\\2" target="_blank">\\3</a>';
		$patterns[] = "/\[color=(['\"]?)([a-zA-Z0-9]*)\\1](.*)\[\/color\]/sU";
		$replacements[] = '<span style="color: #\\2;">\\3</span>';
		$patterns[] = "/\[size=(['\"]?)([a-z0-9-]*)\\1](.*)\[\/size\]/sU";
		$replacements[] = '<span style="font-size: \\2;">\\3</span>';
		$patterns[] = "/\[font=(['\"]?)([^;<>\*\(\)\"']*)\\1](.*)\[\/font\]/sU";
		$replacements[] = '<span style="font-family: \\2;">\\3</span>';
		$patterns[] = "/\[email]([^;<>\*\(\)\"']*)\[\/email\]/sU";
		$replacements[] = '<a href="mailto:\\1">\\1</a>';
		$patterns[] = "/\[b](.*)\[\/b\]/sU";
		$replacements[] = '<strong>\\1</strong>';
		$patterns[] = "/\[i](.*)\[\/i\]/sU";
		$replacements[] = '<i>\\1</i>';
		$patterns[] = "/\[u](.*)\[\/u\]/sU";
		$replacements[] = '<u>\\1</u>';
		$patterns[] = "/\[d](.*)\[\/d\]/sU";
		$replacements[] = '<del>\\1</del>';
		$patterns[] = "/\[quote]/sU";
		$replacements[] = _QUOTEC.'<div class="xoopsQuote"><blockquote>';
		$patterns[] = "/\[\/quote]/sU";
		$replacements[] = '</blockquote></div>';
		$text = str_replace( "\x00", "", $text );
		$c = "[\x01-\x1f]*";
		$patterns[] = "/j{$c}a{$c}v{$c}a{$c}s{$c}c{$c}r{$c}i{$c}p{$c}t{$c}:/si";
		$replacements[] = "(script removed)";
		$patterns[] = "/a{$c}b{$c}o{$c}u{$c}t{$c}:/si";
		$replacements[] = "about :";
		
		$this->text = $text;
		$this->patterns = $patterns;
		$this->replacements = $replacements;
		
		$this->xoopsCodeDecode_extended($allowimage);

		$text = $this->text = preg_replace($this->patterns, $this->replacements, $this->text);
		return $text;
	}

	/**
	 * Replaces banned words in a string with their replacements
	 *
	 * @param   string $text
	 * @return  string
     *
     * @deprecated
	 **/
	function &censorString(&$text)
	{
		if (!isset($this->censorConf)) {
			$config_handler =& xoops_gethandler('config');
			$this->censorConf =& $config_handler->getConfigsByCat(XOOPS_CONF_CENSOR);
		}
		if ($this->censorConf['censor_enable'] == 1) {
			$replacement = $this->censorConf['censor_replace'];
			foreach ($this->censorConf['censor_words'] as $bad) {
				$bad = trim($bad);
				if (!empty($bad)){
					$patterns[] = "/([^0-9a-z_])".$bad."([^0-9a-z_])/siU";
					$replacements[] = "\\1".$replacement."\\2";
					$text = preg_replace($patterns, $replacements, $text);
				}
   			}
		}
   		return $text;
	}


	/**#@+
	 * Sanitizing of [code] tag
	 */
	function codePreConv($text, $xcode = 1) {
		if ($xcode != 0) {
			$patterns = "/\[code([^\]]*?)\](.*)\[\/code\]/esU";
			$replacements = "'[code\\1]'.base64_encode('\\2').'[/code]'";
			$text =  preg_replace($patterns, $replacements, $text);
		}
		return $text;
	}

	function codeConv($text, $xcode = 1, $image = 1) {
		if (empty($xcode)) return $text;
		$patterns = "/\[code([^\]]*?)\](.*)\[\/code\]/esU";
		$codeSanitizerParameter = "'$2'" . (empty($image) ? ", 0" : "");
		$replacements = "'<div class=\"xoopsCode\"><code>'.\$this->loadExtension('syntaxhighlight', \$this->codeSanitizer($codeSanitizerParameter), '$1').'</code></div>'";
		$text =  preg_replace($patterns, $replacements, $text);
		return $text;
	}

	function codeSanitizer($str, $image = 1) {
		$str =  $this->htmlSpecialChars(str_replace('\"', '"', base64_decode($str)));
		$str = $this->xoopsCodeDecode($str, $image);
		return $str;
	}

	function xoopsCodeDecode_extended($allowimage = 1)
	{
		$this->patterns[] = "/&quot;/i";
		$this->replacements[] = "\"";
		$this->patterns[] = "/&#039;/i";
		$this->replacements[] = "'";
		
		$this->loadExtension("iframe");
		$this->loadExtension("image", $allowimage);
		if (EXTCODE_ENABLE_FLASH) {
			$this->loadExtension("flash");
		}
		if (EXTCODE_ENABLE_YOUTUBE) {
			$this->loadExtension("youtube");
		}
		if (EXTCODE_ENABLE_WMP) {
			$this->loadExtension("wmp");
		}
		if (EXTCODE_ENABLE_MMS) {
			$this->loadExtension("mms");
		}
		if (EXTCODE_ENABLE_RTSP) {
			$this->loadExtension("rtsp");
		}
		if (EXTCODE_ENABLE_WIKI) {
			$this->loadExtension("wiki");
		}
	}
	
	function loadExtension($name)
	{
		if (! include_once(dirname(__FILE__)."/plugins/{$name}.php") ) {
			return;
		}
		$func = "textsanitizer_{$name}";
		if (! function_exists($func) ) {
			return;
		}
		$args = array_slice(func_get_args(), 1);
		return call_user_func_array($func, array_merge( array(&$this), $args));
	}
	
	function xoops_codeHighlight( $source, $language )
	{
		return $this->loadExtension("syntaxhighlight", $source, $language);
	}

}
?>