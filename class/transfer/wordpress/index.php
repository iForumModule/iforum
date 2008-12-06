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

function transfer_wordpress(&$data)
{
	global $xoopsModule, $xoopsConfig, $xoopsUser, $xoopsModuleConfig;
	global $xoopsLogger, $xoopsOption, $xoopsTpl, $xoopsblock;

	$_config = require(dirname(__FILE__)."/config.php");

		
	$hiddens["action"] = "post";
	$hiddens["post_status"] = "draft";
	$content = $data["content"] . "<p><a href=\"".$data["url"]."\">"._MORE."</a></p>";
	$hiddens["content"] = $content;
	$hiddens["post_title"] = $data["title"];
	$hiddens["post_author"] = empty($xoopsUser)?0:$xoopsUser->getVar("uid");
	//$hiddens["advanced"] = 1;
	$hiddens["save"] = 1;
	$hiddens["post_from_xoops"] = 1;
	
	include_once ICMS_ROOT_PATH."/header.php";
	xoops_confirm($hiddens, ICMS_URL."/modules/".$_config["module"]."/wp-admin/post.php", $_config["title"]);
	$GLOBALS["xoopsOption"]['output_type'] = "plain";
	include_once ICMS_ROOT_PATH."/footer.php";
	exit();
}
?>