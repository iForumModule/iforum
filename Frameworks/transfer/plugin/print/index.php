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
class transfer_print extends Transfer
{
	function transfer_print()
	{
		$this->Transfer("print");
	}
	
	function do_transfer(&$data)
	{
		eval(parent::do_transfer());
	
		global $print_data;
		
		$print_data["subject"] = $data["title"];
		$print_data["author"] = $data["author"];
		$print_data["date"] = $data["date"];
		$print_data["text"] = $data["content"];
		$print_data["url"] = $data["url"];
	
		//$hiddens["print_data"] = base64_encode(serialize($post_data));
		
		//include XOOPS_ROOT_PATH."/header.php";
		//xoops_confirm($hiddens, XOOPS_URL."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/print.php", $this->config["title"]);
		include XOOPS_ROOT_PATH."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/print.php";
		//include XOOPS_ROOT_PATH."/footer.php";
		exit();
	}
}
?>