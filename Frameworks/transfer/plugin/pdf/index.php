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


class transfer_pdf extends Transfer
{
	function transfer_pdf()
	{
		$this->Transfer("pdf");
	}
	
	function do_transfer(&$data)
	{
		eval(parent::do_transfer());
	
		//$_GET["article"] = $data["id"];
		//$_GET["page"] = $data["page"];
		global $pdf_data;
		
		$pdf_data["title"] = $data["title"];
		$pdf_data["subtitle"] = $data["subtitle"];
		$pdf_data["author"] = $data["author"];
		$pdf_data["date"] = $data["date"];
		$pdf_data["content"] = $data["content"];
		$pdf_data["url"] = $data["url"];
		//$hiddens["pdf_data"] = base64_encode(serialize($pdf_data));
			
		//include XOOPS_ROOT_PATH."/header.php";
		//xoops_confirm($hiddens, XOOPS_URL."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/pdf.php", $this->config["title"]);
		include XOOPS_ROOT_PATH."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/pdf.php";
		//include XOOPS_ROOT_PATH."/footer.php";
		exit();
	}
}
?>