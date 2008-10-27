<?php
/**
 * Cache handler
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		Frameworks::art
 */

if(!defined("FRAMEWORKS_ART_FUNCTIONS_CACHE")):
define("FRAMEWORKS_ART_FUNCTIONS_CACHE", true);

function mod_createCacheFile($data, $name = null, $dirname = null)
{
    global $xoopsModule;

    $name = ($name)? $name : strval(time());
    $dirname = ($dirname)? $dirname : (is_object($xoopsModule) ? $xoopsModule->getVar("dirname") : "system");

	$file_name = $dirname."_".$name.".php";
	$file = XOOPS_CACHE_PATH."/".$file_name;
	if ( $fp = fopen( $file , "wt" ) ) {
		fwrite( $fp, "<?php\nreturn " . var_export( $data, true ) . ";\n?>" );
		fclose( $fp );
	} else {
		xoops_error( "Cannot create cache file: ".$file_name );
	}
    return $file_name;
}

function &mod_loadCacheFile($name, $dirname = null)
{
    global $xoopsModule;

    $data = null;
    
    if(empty($name)) return $data;
    $dirname = ($dirname) ? $dirname : (is_object($xoopsModule) ? $xoopsModule->getVar("dirname") : "system");
	$file_name = $dirname."_".$name.".php";
	$file = XOOPS_CACHE_PATH."/".$file_name;
	
	$data = @include $file;
	return $data;
}

function mod_clearCacheFile($name = "", $dirname = null)
{
    global $xoopsModule;
    
    $pattern = ($dirname) ? "{$dirname}_{$name}.*\.php" : "[^_]+_{$name}.*\.php";
	if ($handle = opendir(XOOPS_CACHE_PATH)) {
		while (false !== ($file = readdir($handle))) {
			if (is_file(XOOPS_CACHE_PATH.'/'.$file) && preg_match("/^{$pattern}$/", $file)) {
				@unlink(XOOPS_CACHE_PATH.'/'.$file);
			}
		}
		closedir($handle);
	}
	return true;
}

endif;
?>