<?php
/**
 * Transfer handler for XOOPS
 *
 * This is intended to handle content intercommunication between modules as well as components
 * There might need to be a more explicit name for the handle since it is always confusing
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		3.00
 * @version		$Id$
 * @package		Frameworks::transfer
 */
 
if (!defined("XOOPS_ROOT_PATH") || !is_object($GLOBALS["xoopsModule"])) {
	return null;
}

if(!@include_once dirname(__FILE__)."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname").".php"){
	if(!@include_once XOOPS_ROOT_PATH."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/include/transfer.inc.php"){
		return null;
	}
}

$transfer_handler = new ModuleTransferHandler();
$op_options	= $transfer_handler->getList();

$limit = empty($GLOBALS["addons_limit_module"]) ? 3 : $GLOBALS["addons_limit_module"];

return $transferbar = array( 
					"title"	=> _MD_TRANSFER,
					"desc"	=> _MD_TRANSFER_DESC,
					"list"	=> array_slice($op_options, 0, $limit),
					"more"	=> (count($op_options) > $limit) ? _MD_TRANSFER_MORE : "",
					);
?>