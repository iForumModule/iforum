<?php
/**
 * Email action for Transfer handler for XOOPS
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

/* 
 * FIXME: the file should be moved out of the folder of Frameworks 
 * but where to locate it?
 */
 
include '../../../../mainfile.php';
require_once "../../../transfer.php";
Transfer::load_language("email");
$config = require_once("config.php");

$myts =& MyTextSanitizer::getInstance();

$email_to = $myts->stripSlashesGPC($_POST["email"]);
if(!checkEmail($email_to)) {
	include XOOPS_ROOT_PATH."/header.php";
	echo "<div class=\"resultMsg\">"."Invalid email";
	echo "<br clear=\"all\" /><br /><input type=\"button\" value=\""._CLOSE."\" onclick=\"window.close()\"></div>";
	
	include XOOPS_ROOT_PATH."/footer.php";
    exit();
}
$title = $myts->stripSlashesGPC($_POST["title"]);
$content = $myts->stripSlashesGPC($_POST["content"]);
$xoopsMailer =& getMailer();
$xoopsMailer->useMail();
$xoopsMailer->setToEmails($email_to);
if(is_object($xoopsUser)){
	$xoopsMailer->setFromEmail($xoopsUser->getVar("email", "E"));
	$xoopsMailer->setFromName($xoopsUser->getVar("uname", "E"));
}else{
	require_once XOOPS_ROOT_PATH."/Frameworks/art/functions.php";
	$xoopsMailer->setFromName(mod_getIP(true));				
}
$xoopsMailer->setSubject($title);
$xoopsMailer->setBody($content);
$xoopsMailer->send();

include XOOPS_ROOT_PATH."/header.php";
echo "<div class=\"resultMsg\">".$config["title"];
echo "<br clear=\"all\" /><br /><input type=\"button\" value=\""._CLOSE."\" onclick=\"window.close()\"></div>";

include XOOPS_ROOT_PATH."/footer.php";
?>