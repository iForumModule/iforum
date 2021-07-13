<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
* Tag blocks for iForum
*
* @copyright  http://www.impresscms.org/ The ImpressCMS Project
* @copyright  http://www.impresscms.ir/ The Persian ImpressCMS Project
* @copyright  readme.txt
* @license   GNU General Public License (GPL)
*     a copy of the GNU license is enclosed.
* @since   1.01
* @author      Sina Asghari (aka stranger) <pesian_stranger@users.sourceforge.net>
* @author   Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
* @version   $Id$
*/
 
if (!defined('ICMS_ROOT_PATH'))
{
	exit();
}
 
function iforum_tag_block_cloud_show($options)
{
	if (!@include_once ICMS_ROOT_PATH.'/modules/tag/blocks/block.php')
	{
		return null;
	}
	$block_content = tag_block_cloud_show($options, basename(dirname(dirname(__FILE__ ) ) ));
	return $block_content;
}
 
function iforum_tag_block_cloud_edit($options)
{
	if (!@include_once ICMS_ROOT_PATH.'/modules/tag/blocks/block.php')
	{
		return null;
	}
	$form = tag_block_cloud_edit($options);
	return $form;
}
 
function iforum_tag_block_top_show($options)
{
	if (!@include_once ICMS_ROOT_PATH.'/modules/tag/blocks/block.php')
	{
		return null;
	}
	$block_content = tag_block_top_show($options, basename(dirname(dirname(__FILE__ ) ) ));
	return $block_content;
}
 
function iforum_tag_block_top_edit($options)
{
	if (!@include_once ICMS_ROOT_PATH.'/modules/tag/blocks/block.php')
	{
		return null;
	}
	$form = tag_block_top_edit($options);
	return $form;
}
?>