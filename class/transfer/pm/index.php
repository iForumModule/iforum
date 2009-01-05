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

function transfer_pm(&$data)
{
	global $xoopsModule, $xoopsConfig, $xoopsUser, $xoopsModuleConfig;
	global $xoopsLogger, $xoopsOption, $xoopsTpl, $xoopsblock;

	$_config = require(dirname(__FILE__)."/config.php");
	
	$hiddens["to_userid"] = $data["uid"];
	$hiddens["subject"] = $data["title"];
	$content  = str_replace("<br />", "\n\r", $data["content"]);
	$content  = str_replace("<br>", "\n\r", $content);
	$content  = "[quote]\n".iforum_html2text($content)."\n[/quote]";
	$content = $data["title"]."\n\r".$content."\n\r\n\r"._MORE."\n\r".$data["url"];
	$hiddens["message"] = $content;
	
	include ICMS_ROOT_PATH."/header.php";
	if(!empty($_config["module"]) && is_dir(ICMS_ROOT_PATH."/modules/".$_config["module"])){
		$action = ICMS_URL."/modules/".$_config["module"]."/pmlite.php";
	}else{
		$action = ICMS_URL."/pmlite.php?send2=1&amp;to_userid=".$data["uid"];
	}
	xoops_confirm($hiddens, $action, $_config["title"]);
	$GLOBALS["xoopsOption"]['output_type'] = "plain";
	include ICMS_ROOT_PATH."/footer.php";
	exit();
}
?>