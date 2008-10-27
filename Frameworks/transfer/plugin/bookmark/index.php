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

class transfer_bookmark extends Transfer
{
	function transfer_bookmark()
	{
		$this->Transfer("bookmark");
	}
	
	function do_transfer(&$data)
	{
		eval(parent::do_transfer());
		
		include XOOPS_ROOT_PATH."/header.php";
		/* bookmark tools:
		 * del.icio.us
		 * viv.sina.com.cn
		 * 365key
		 */
		echo "<div class=\"centered\" style=\"padding:20px;\"><span class=\"head\">".$this->config["title"]."(".$this->config["desc"].")</span><br style=\"clear: both;\" /><br style=\"clear: both;\" /><div>";
		printf(_MD_TRANSFER_BOOKMARK_ITEMS, $data["title"], $data["url"]);
		echo "</div></div>";
		include XOOPS_ROOT_PATH."/footer.php";
		exit();
	}
}

?>