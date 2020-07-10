<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright  http://www.xoops.org/ The XOOPS Project
* @copyright  http://xoopsforge.com The XOOPS FORGE Project
* @copyright  http://xoops.org.cn The XOOPS CHINESE Project
* @copyright  XOOPS_copyrights.txt
* @copyright  readme.txt
* @copyright  http://www.impresscms.org/ The ImpressCMS Project
* @license   GNU General Public License (GPL)
*     a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package  CBB - XOOPS Community Bulletin Board
* @since   3.08
* @author  phppp
* ----------------------------------------------------------------------------------------------------------
*     iForum - a bulletin Board (Forum) for ImpressCMS
* @since   1.00
* @author  modified by stranger
* @version  $Id$
*/
 
if (!defined("IFORUM_FUNCTIONS_IMAGE")):
define("IFORUM_FUNCTIONS_IMAGE", true);
 
function iforum_attachmentImage($source)
{
	$img_path = ICMS_ROOT_PATH.'/'.icms::$module->config['dir_attachments'];
	$img_url = ICMS_URL.'/'.icms::$module->config['dir_attachments'];
	$thumb_path = $img_path.'/thumbs';
	$thumb_url = $img_url.'/thumbs';
	 
	$thumb = $thumb_path.'/'.$source;
	$image = $img_path.'/'.$source;
	$thumb_url = $thumb_url.'/'.$source;
	$image_url = $img_url.'/'.$source;
	 
	$imginfo = @getimagesize($image);
	$img_info = (count($imginfo) > 0 )?$imginfo[0]."X".$imginfo[1].' px':"";
	 
	if (icms::$module->config['max_img_width'] > 0)
	{
		if (
		(icms::$module->config['max_image_width'] > 0 && $imginfo[0] > icms::$module->config['max_image_width'] )
		|| (icms::$module->config['max_image_height'] > 0 && $imginfo[1] > icms::$module->config['max_image_height'])
		)
		{
			if ($imginfo[0] > icms::$module->config['max_img_width'])
			{
				$pseudo_width = icms::$module->config['max_img_width'];
				$pseudo_height = icms::$module->config['max_img_width'] * ($imginfo[1]/$imginfo[0]);
				$pseudo_size = "width='".$pseudo_width."px' height='".$pseudo_height."px'";
			}
			if (icms::$module->config['max_image_height'] > 0 && $pseudo_height > icms::$module->config['max_image_height'])
			{
				$pseudo_height = icms::$module->config['max_image_height'];
				$pseudo_width = icms::$module->config['max_image_height'] * ($imginfo[0]/$imginfo[1]);
				$pseudo_size = "width='".$pseudo_width."px' height='".$pseudo_height."px'";
			}
		}
		else
			if (!file_exists($thumb_path.'/'.$source) && $imginfo[0] > icms::$module->config['max_img_width'])
		{
			iforum_createThumbnail($source, icms::$module->config['max_img_width']);
		}
	}
	 
	 
	if (file_exists($thumb))
	{
		$attachmentImage = '<a rel="lightbox" href="'.$image_url.'" title="'.$source.' '.$img_info.'" target="iforum_image">';
		$attachmentImage .= '<img src="'.$thumb_url.'" alt="'.$source.' '.$img_info.'" />';
		$attachmentImage .= '</a>';
	}
	elseif(!empty($pseudo_size))
	{
		$attachmentImage = '<a rel="lightbox" href="'.$image_url.'" title="'.$source.' '.$img_info.'" target="iforum_image">';
		$attachmentImage .= '<img src="'.$image_url.'" '.$pseudo_size.' alt="'.$source.' '.$img_info.'" />';
		$attachmentImage .= '</a>';
	}
	elseif(file_exists($image))
	{
		$attachmentImage = '<img src="'.$image_url.'" alt="'.$source.' '.$img_info.'" />';
	}
	else $attachmentImage = '';
	 
	return $attachmentImage;
}
 
 
function iforum_createThumbnail($source, $thumb_width)
{
	$img_path = ICMS_ROOT_PATH.'/'.icms::$module->config['dir_attachments'];
	$thumb_path = $img_path.'/thumbs';
	$src_file = $img_path.'/'.$source;
	$new_file = $thumb_path.'/'.$source;
	//$imageLibs = iforum_getImageLibs();
	 
	if (!filesize($src_file) || !is_readable($src_file))
	{
		return false;
	}
	 
	if (!is_dir($thumb_path) || !is_writable($thumb_path))
	{
		return false;
	}
	 
	$imginfo = @getimagesize($src_file);
	if (NULL == $imginfo )
	{
		return false;
	}
	if ($imginfo[0] < $thumb_width)
	{
		return false;
	}
	 
	$newWidth = (int)(min($imginfo[0], $thumb_width));
	$newHeight = (int)($imginfo[1] * $newWidth / $imginfo[0]);
	 
	if (icms::$module->config['image_lib'] == 1 or icms::$module->config['image_lib'] == 0 )
	{
		if (preg_match("#[A-Z]:|\\\\#Ai", __FILE__))
		{
			$cur_dir = dirname(__FILE__);
			$src_file_im = '"'.$cur_dir.'\\'.strtr($src_file, '/', '\\').'"';
			$new_file_im = '"'.$cur_dir.'\\'.strtr($new_file, '/', '\\').'"';
		}
		else
		{
			$src_file_im = @escapeshellarg($src_file);
			$new_file_im = @escapeshellarg($new_file);
		}
		$path = empty(icms::$module->config['path_magick'])?"":
		icms::$module->config['path_magick']."/";
		$magick_command = $path . 'convert -quality 85 -antialias -sample ' . $newWidth . 'x' . $newHeight . ' ' . $src_file_im . ' +profile "*" ' . str_replace('\\', '/', $new_file_im) . '';
			 
			@passthru($magick_command);
			if (file_exists($new_file)){
			return true;
			}
	}
	 
	if (icms::$module->config['image_lib'] == 2 or icms::$module->config['image_lib'] == 0 )
	{
		$path = empty(icms::$module->config['path_netpbm'])?"":icms::$module->config['path_netpbm']."/";
		if (eregi("\.png", $source)){
			$cmd = $path . "pngtopnm $src_file | ".$path . "pnmscale -xysize $newWidth $newHeight | ".$path . "pnmtopng > $new_file" ;
		}
		else if (eregi("\.(jpg|jpeg)", $source)){
			$cmd = $path . "jpegtopnm $src_file | ".$path . "pnmscale -xysize $newWidth $newHeight | ".$path . "ppmtojpeg -quality=90 > $new_file" ;
		}
		else if (eregi("\.gif", $source)){
			$cmd = $path . "giftopnm $src_file | ".$path . "pnmscale -xysize $newWidth $newHeight | ppmquant 256 | ".$path . "ppmtogif > $new_file" ;
		}
	
		@exec($cmd, $output, $retval);
		if (file_exists($new_file)){
			return true;
		}
	}
	 
	$type = $imginfo[2];
	$supported_types = array();
	 
	if (!extension_loaded('gd')) return false;
	if (function_exists('imagegif')) $supported_types[] = 1;
	if (function_exists('imagejpeg'))$supported_types[] = 2;
	if (function_exists('imagepng')) $supported_types[] = 3;
	 
	$imageCreateFunction = (function_exists('imagecreatetruecolor'))? "imagecreatetruecolor" : "imagecreate";
	 
	if (in_array($type, $supported_types) )
	{
		switch ($type)
		{
			case 1 :
				if (!function_exists('imagecreatefromgif')) return false;
				$im = imagecreatefromgif($src_file);
				$new_im = imagecreate($newWidth, $newHeight);
				imagecopyresized($new_im, $im, 0, 0, 0, 0, $newWidth, $newHeight, $imginfo[0], $imginfo[1]);
				imagegif($new_im, $new_file);
				imagedestroy($im);
				imagedestroy($new_im);
			break;
			case 2 :
				$im = imagecreatefromjpeg($src_file);
				$new_im = $imageCreateFunction($newWidth, $newHeight);
				imagecopyresized($new_im, $im, 0, 0, 0, 0, $newWidth, $newHeight, $imginfo[0], $imginfo[1]);
				imagejpeg($new_im, $new_file, 90);
				imagedestroy($im);
				imagedestroy($new_im);
			break;
			case 3 :
				$im = imagecreatefrompng($src_file);
				$new_im = $imageCreateFunction($newWidth, $newHeight);
				imagecopyresized($new_im, $im, 0, 0, 0, 0, $newWidth, $newHeight, $imginfo[0], $imginfo[1]);
				imagepng($new_im, $new_file);
				imagedestroy($im);
				imagedestroy($new_im);
			break;
			}
		}
		 
		 
		if (file_exists($new_file)) return true;
		else return false;
	}
	 
	endif;