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
include '../../../../../mainfile.php';
require_once("config.php");

$myts =& MyTextSanitizer::getInstance();

$email_to = $myts->stripSlashesGPC($_POST["email"]);
if(!checkEmail($email_to)) {
	include ICMS_ROOT_PATH."/header.php";
	echo "<div class=\"resultMsg\">"."Invalid email";
	echo "<br clear=\"all\" /><br /><input type=\"button\" value=\""._CLOSE."\" onclick=\"window.close()\"></div>";
	
	include ICMS_ROOT_PATH."/footer.php";
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
	$xoopsMailer->setFromName(iforum_getIP(true));				
}
$xoopsMailer->setSubject($title);
$xoopsMailer->setBody($content);
$xoopsMailer->send();

include ICMS_ROOT_PATH."/header.php";
echo "<div class=\"resultMsg\">".$config["title"];
echo "<br clear=\"all\" /><br /><input type=\"button\" value=\""._CLOSE."\" onclick=\"window.close()\"></div>";

include ICMS_ROOT_PATH."/footer.php";
?>