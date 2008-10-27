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

if (!@include_once dirname(__FILE__)."/modules/".$xoopsModule->getVar("dirname").".php") {
	if (!@include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/plugin.transfer.php") {
		die("No plugin available");
	}
}
$transfer_handler = new ModuleTransferHandler();
$op_options	= $transfer_handler->getList();

include XOOPS_ROOT_PATH."/header.php";
@include XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";
echo "<div class=\"confirmMsg\" style=\"width: 80%; padding:20px;margin:10px auto; text-align:left !important;\"><h2>"._MD_TRANSFER_DESC."</h2><br />";
echo "<form name=\"opform\" id=\"opform\" action=\"".xoops_getenv("PHP_SELF")."\" method=\"post\"><ul>\n";
foreach($op_options as $value => $option){
	echo "<li><a href=\"###\" onclick=\"document.forms.opform.op.value='".$value."'; document.forms.opform.submit();\" title=\"{$option["desc"]}\">".$option["title"]."</a></li>\n";
}
echo $module_variables;
echo "<input type=\"hidden\" name=\"op\" id=\"op\" value=\"\">";
echo "</url></form></div>";

$xoopsOption['output_type'] = "plain";
include XOOPS_ROOT_PATH."/footer.php";
exit();
?>