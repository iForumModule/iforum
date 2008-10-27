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
 
if (!defined("XOOPS_ROOT_PATH") || !is_object($xoopsModule)) {
	exit();
}

if (!@include_once dirname(__FILE__)."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname").".php") {
	if (!@include_once XOOPS_ROOT_PATH."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/include/plugin.transfer.php") {
		return null;
	}
}

$transfer_handler = new ModuleTransferHandler();
$ret = $transfer_handler->do_transfer($op, $data);

include XOOPS_ROOT_PATH."/header.php";
$redirect = empty($ret["url"]) ? "javascript: window.close();" : $ret["url"];
xoops_confirm(array(), "javascript: window.close();", _MD_TRANSFER_DONE, _CLOSE, $redirect);
include XOOPS_ROOT_PATH."/footer.php";
exit();
?>