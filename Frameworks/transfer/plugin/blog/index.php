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

class transfer_blog extends Transfer
{
	function transfer_blog()
	{
		$this->Transfer("blog");
	}
	
	function do_transfer(&$data)
	{
		eval(parent::do_transfer());
		
		$hiddens["art_author"] = $data["author"];
		$hiddens["art_title"] = $data["title"];
		$hiddens["art_source"] = $data["url"];
		$hiddens["text"] = $data["content"];
		
		include XOOPS_ROOT_PATH."/header.php";
		xoops_confirm($hiddens, XOOPS_URL."/modules/".$this->config["module"]."/action.article.php", $this->config["title"]." (".$this->config["desc"].")");
		include XOOPS_ROOT_PATH."/footer.php";
		exit();
	}
}

?>