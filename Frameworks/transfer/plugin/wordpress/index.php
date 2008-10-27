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

class transfer_wordpress extends Transfer
{
	function transfer_wordpress()
	{
		$this->Transfer("wordpress");
	}
	
	function do_transfer(&$data)
	{
		eval(parent::do_transfer());
	
		$hiddens["action"] = "post";
		$hiddens["post_status"] = "draft";
		$content = $data["content"] . "<p><a href=\"".$data["url"]."\">"._MORE."</a></p>";
		$hiddens["content"] = $content;
		$hiddens["post_title"] = $data["title"];
		$hiddens["post_author"] = empty($xoopsUser)? 0 : $xoopsUser->getVar("uid");
		//$hiddens["advanced"] = 1;
		$hiddens["save"] = 1;
		$hiddens["post_from_xoops"] = 1;
		
		include_once XOOPS_ROOT_PATH."/header.php";
		xoops_confirm($hiddens, XOOPS_URL."/modules/".$this->config["module"]."/wp-admin/post.php", $this->config["title"]." (".$this->config["desc"].")");
		include_once XOOPS_ROOT_PATH."/footer.php";
		exit();
	}
}
?>