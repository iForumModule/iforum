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

class transfer_email extends Transfer
{
	function transfer_email()
	{
		$this->Transfer("email");
	}
	
	function do_transfer(&$data)
	{
		eval(parent::do_transfer());
	
		include XOOPS_ROOT_PATH."/header.php";
		require_once(XOOPS_ROOT_PATH . "/class/xoopsformloader.php");
		$content  = str_replace("<br />", "\n", $data["content"]);
		$content  = str_replace("<br>", "\n", $content);
		$content  = strip_tags($content);
		$content = $data["title"]."\n".$content."\n\n"._MORE."\n".$data["url"];
		$form_email = new XoopsThemeForm(_MD_TRANSFER_EMAIL_DESC, "formemail", $this->config["url"]);
		$form_email->addElement(new XoopsFormText(_MD_TRANSFER_EMAIL_ADDRESS, "email", 50, 100), true);
		$form_email->addElement(new XoopsFormText(_MD_TRANSFER_EMAIL_TITLE, "title", 50, 255, $data["title"]), true);
		$form_email->addElement(new XoopsFormTextArea(_MD_TRANSFER_EMAIL_CONTENT, "content", $content, 10, 60), true);
		$form_email->addElement(new XoopsFormButton("", "email_submit", _SUBMIT, "submit"));
		$form_email->display();
		include XOOPS_ROOT_PATH."/footer.php";
		exit();
	}
}
?>