<?php
// $Id: local.php,v 1.1.2.5 2005/09/16 01:16:50 phppp Exp $

$original_locale = setlocale(LC_ALL, 0);
if (!setlocale(LC_ALL, 'zh')) {
	setlocale(LC_ALL, $original_locale );
}

// Local handler for string and encoding
class XoopsLocal
{	
	// localized substr
	/* For GB2312;
	 * UTF-8 needs extra treatment
	 */
/*	 
	function &substr($str, $start, $length, $trimmarker = '...')
	{
		$DEP_CHAR=chr(127);
		$pos_st=0;
		$action = false;
		$strlen_str = strlen($str);
		$strlen_trimmarker = strlen($trimmarker);
	    for($pos_i=0;$pos_i<$strlen_str;$pos_i++) {
	        if( substr($str,$pos_i,1) > $DEP_CHAR ) {
		        $pos_i++;
	        }
	        if($pos_i<=$start) {
		        $pos_st=$pos_i;
	        }
	        if($pos_i>=$pos_st+$length+$strlen_trimmarker) {
		        $action = true;
		        break;
	        }
	    }
	    if($action){
    		$ret = substr($str, $pos_st, $pos_i-$pos_st-$strlen_trimmarker);
    		$ret .= $trimmarker;
	    }else{
    		$ret = substr($str, $pos_st);
	    }
    	return $ret;
	}
*/
	function substr($str, $start, $length, $trimmarker = '...') {
	    $charset = empty($GLOBALS["xlanguage"]['charset_base'])?_CHARSET:$GLOBALS["xlanguage"]['charset_base'];
	    
	    switch(strtoupper($charset)){
	    case "UTF-8":	    
	    // Count one Chinese character as 2 English alphabets
	    // To be developed
	    
	    default:
	    
			$ch = chr(127);
			$p = array("/[\x81-\xfe]([\x81-\xfe]|[\x40-\xfe])/","/[\x01-\x77]/");
			$r = array("","");
			
			if($start > 0) {
				$s = substr($str,0,$start);
				if($s{strlen($s)-1} > $ch) {
					$s = preg_replace($p,$r,$s);
					$start += strlen($s);
				}
			}
			$s = substr($str,$start,$start+$length);
			$end = strlen($s);
			if($s{$end-1} > $ch) {
				$s = preg_replace($p,$r,$s);
				$end += strlen($s);
			}
			$ret = substr($str,$start,$end);
			if($start + $length < strlen($str)){
				$ret .= $trimmarker;
			}
			
			break;
		
		}
		
		return $ret;
	}
	
	function utf8_encode($text)
	{
		$text = XoopsLocal::convert_encoding($text, 'utf-8');
		return $text;
	}
	
	function convert_encoding($text, $to='utf-8', $from='')
	{
		if(empty($text)) {		
			return $text;
		}
	    if(empty($from)) $from = empty($GLOBALS["xlanguage"]['charset_base'])?_CHARSET:$GLOBALS["xlanguage"]['charset_base'];
	    if (empty($to) || !strcasecmp($to, $from)) return $text;
	    
		if(function_exists('mb_convert_encoding')) {
			$converted_text = @mb_convert_encoding($text, $to, $from);
		}elseif(function_exists('iconv')) {
			$converted_text = @iconv($from, $to . "//TRANSLIT", $text);
		}	
		if(empty($converted_text)){
			static $xconv_handler;
			$xconv_handler = isset($xconv_handler)?$xconv_handler:@xoops_getmodulehandler('xconv', 'xconv', true);
			if(is_object($xconv_handler)){
				$converted_text = @$xconv_handler->convert_encoding($text, $to, $from);
				if(!empty($converted_text)) {
					return $converted_text;
				}
			}
		}
		
		$text = empty($converted_text)?$text:$converted_text;
	
	    return $text;
	}

	function trim($text)
	{
	    $ret = trim($text);
	    return $ret;
	}
	
	/*
	* Function to display formatted times in user timezone
	*/
	function formatTimestamp($time, $format="l", $timeoffset="")
	{
	    global $xoopsConfig, $xoopsUser;
	    if(strtolower($format) == "rss" ||strtolower($format) == "r"){
        	$TIME_ZONE = "";
        	if(!empty($GLOBALS['xoopsConfig']['server_TZ'])){
				$server_TZ = abs(intval($GLOBALS['xoopsConfig']['server_TZ']*3600.0));
				$prefix = ($GLOBALS['xoopsConfig']['server_TZ']<0)?" -":" +";
				$TIME_ZONE = $prefix.date("Hi",$server_TZ);
			}
			$date = gmdate("D, d M Y H:i:s", intval($time)).$TIME_ZONE;
			return $date;
    	}
    	
	    $usertimestamp = xoops_getUserTimestamp($time, $timeoffset);
	    switch (strtolower($format)) {
        case 's':
	        $datestring = _SHORTDATESTRING;
	        break;
        case 'm':
	        $datestring = _MEDIUMDATESTRING;
	        break;
        case 'mysql':
	        $datestring = "Y-m-d H:i:s";
	        break;
        case 'rss':
	    	$datestring = "r";
	        break;
        case 'l':
	        $datestring = _DATESTRING;
	        break;
        case 'c':
        case 'custom':
	        $current_timestamp = xoops_getUserTimestamp(time(), $timeoffset);
	        if(date("Ymd", $usertimestamp) == date("Ymd", $current_timestamp)){
				$datestring = _TODAY;
			}elseif(date("Ymd", $usertimestamp+24*60*60) == date("Ymd", $current_timestamp)){
				$datestring = _YESTERDAY;
			}elseif(date("Y", $usertimestamp) == date("Y", $current_timestamp)){
				$datestring = _MONTHDAY;
			}else{
				$datestring = _YEARMONTHDAY;
			}
	        break;
        default:
	        if ($format != '') {
	            $datestring = $format;
	        } else {
	            $datestring = _DATESTRING;
	        }
	        break;
	    }

	    return date($datestring, $usertimestamp);
	}
	
	
	// adding your new functions
	// calling the function:
	// Method 1: echo xoops_local("hello", "Some greeting words");
	// Method 2: echo XoopsLocal::hello("Some greeting words");
	function hello($text)
	{
		$ret = "<div>Hello, ".$text."</div>";
		return $ret;
	}
}
?>