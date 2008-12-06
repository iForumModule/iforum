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

function transfer_bookmark(&$data)
{
	global $xoopsModule, $xoopsConfig, $xoopsUser, $xoopsModuleConfig;
	global $xoopsLogger, $xoopsOption, $xoopsTpl, $xoopsblock;

	$_config = require(dirname(__FILE__)."/config.php");
	
	include ICMS_ROOT_PATH."/header.php";
	/* bookmark tools:
	 * del.icio.us
	 * viv.sina.com.cn
	 * 365key
	 */
	echo "<div class=\"centered\" style=\"padding:20px;\"><span class=\"head\">".$_config["title"]."</span><br clear=\"all\"><br clear=\"all\"><div>";
	printf(_MD_TRANSFER_BOOKMARK_ITEMS, $data["title"], $data["url"]);
	echo "</div></div>";
	$GLOBALS["xoopsOption"]['output_type'] = "plain";
	include ICMS_ROOT_PATH."/footer.php";
	exit();
}
?>