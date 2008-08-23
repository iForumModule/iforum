<?php
// $Id: action.email.php,v 1.1.1.1 2005/10/19 16:23:35 phppp Exp $
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
//                                                                          //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
//                                                                          //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
//                                                                          //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: phppp (D.J., infomax@gmail.com)                                  //
// URL: http://xoopsforge.com, http://xoops.org.cn                          //
// Project: Article Project                                                 //
// ------------------------------------------------------------------------ //

include '../../../../../mainfile.php';
require_once("config.php");

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
	$xoopsMailer->setFromName(newbb_getIP(true));				
}
$xoopsMailer->setSubject($title);
$xoopsMailer->setBody($content);
$xoopsMailer->send();

include XOOPS_ROOT_PATH."/header.php";
echo "<div class=\"resultMsg\">".$config["title"];
echo "<br clear=\"all\" /><br /><input type=\"button\" value=\""._CLOSE."\" onclick=\"window.close()\"></div>";

include XOOPS_ROOT_PATH."/footer.php";
?>