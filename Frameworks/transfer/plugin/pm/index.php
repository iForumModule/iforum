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

class transfer_pm extends Transfer
{
	function transfer_pm()
	{
		$this->Transfer("pm");
	}
	
	function do_transfer(&$data)
	{
		eval(parent::do_transfer());
	
		$hiddens["to_userid"] = $data["uid"];
		$hiddens["subject"] = $data["title"];
		$content  = str_replace("<br />", "\n\r", $data["content"]);
		$content  = str_replace("<br>", "\n\r", $content);
		$content  = "[quote]\n".strip_tags($content)."\n[/quote]";
		$content = $data["title"]."\n\r".$content."\n\r\n\r"._MORE."\n\r".$data["url"];
		$hiddens["message"] = $content;
		
		include XOOPS_ROOT_PATH."/header.php";
		if(!empty($this->config["module"]) && is_dir(XOOPS_ROOT_PATH."/modules/".$this->config["module"])){
			$action = XOOPS_URL."/modules/".$this->config["module"]."/pmlite.php";
		}else{
			$action = XOOPS_URL."/pmlite.php?send2=1&amp;to_userid=".$data["uid"];
		}
		xoops_confirm($hiddens, $action, $this->config["title"]." (".$this->config["desc"].")");
		include XOOPS_ROOT_PATH."/footer.php";
		exit();
	}
}
?>