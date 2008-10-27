<?php
/**
 * Transfer config
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		3.00
 * @version		$Id$
 * @package		Frameworks:transfer
 */

$item_name = strtoupper(basename(dirname(__FILE__)));
return $config = array(
		"title"		=>	CONSTANT("_MD_TRANSFER_{$item_name}"),
		"desc"		=>	CONSTANT("_MD_TRANSFER_{$item_name}_DESC"),
		"level"		=>	1,	/* 0 - hidden (For direct call only); >0 - display (available for selection) */
		"module"	=>	"article"
	);
?>