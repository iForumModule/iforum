<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		http://xoopsforge.com The XOOPS FORGE Project
* @copyright		http://xoops.org.cn The XOOPS CHINESE Project
* @copyright		XOOPS_copyrights.txt
* @copyright		readme.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license			GNU General Public License (GPL)
*					a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		CBB - XOOPS Community Bulletin Board
* @since			3.08
* @author		phppp
* ----------------------------------------------------------------------------------------------------------
* 				iForum - a bulletin Board (Forum) for ImpressCMS
* @since			1.00
* @author		modified by stranger
* @version		$Id$
*/
die('Sorry, this feature is not ready yet!<br />');

function transfer_email(&$data)
{
	global $xoopsModule, $xoopsConfig, $xoopsUser, $xoopsModuleConfig;
	global $xoopsLogger, $xoopsOption, $xoopsTpl, $xoopsblock;

	$_config = require(dirname(__FILE__)."/config.php");
	
	include ICMS_ROOT_PATH."/header.php";
	require_once(ICMS_ROOT_PATH . "/class/xoopsformloader.php");
	$content  = str_replace("<br />", "\n", $data["content"]);
	$content  = str_replace("<br>", "\n", $content);
	$content  = iforum_html2text($content);
	$content = $data["title"]."\n".$content."\n\n"._MORE."\n".$data["url"];
	$form_email = new XoopsThemeForm(_MD_TRANSFER_EMAIL, "formemail", ICMS_URL."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/class/transfer/email/action.email.php");
	$form_email->addElement(new XoopsFormText(_MD_TRANSFER_EMAIL_ADDRESS, "email", 50, 100), true);
	$form_email->addElement(new XoopsFormText(_MD_TRANSFER_EMAIL_TITLE, "title", 50, 255, $data["title"]), true);
	$form_email->addElement(new XoopsFormTextArea(_MD_TRANSFER_EMAIL_CONTENT, "content", $content, 10, 60), true);
	$form_email->addElement(new XoopsFormButton("", "email_submit", _SUBMIT, "submit"));
	$form_email->display();
	$GLOBALS["xoopsOption"]['output_type'] = "plain";
	include ICMS_ROOT_PATH."/footer.php";
	exit();
}
?>