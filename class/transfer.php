<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright  http://www.xoops.org/ The XOOPS Project
* @copyright  http://xoopsforge.com The XOOPS FORGE Project
* @copyright  http://xoops.org.cn The XOOPS CHINESE Project
* @copyright  XOOPS_copyrights.txt
* @copyright  readme.txt
* @copyright  http://www.impresscms.org/ The ImpressCMS Project
* @license   GNU General Public License (GPL)
*     a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package  CBB - XOOPS Community Bulletin Board
* @since   3.08
* @author  phppp
* ----------------------------------------------------------------------------------------------------------
*     iForum - a bulletin Board (Forum) for ImpressCMS
* @since   1.00
* @author  modified by stranger
* @version  $Id$
*/
 
/**
* @package module::article
* @copyright copyright &copy; 2005 XoopsForge.com
*/
 
if (!defined("ICMS_ROOT_PATH"))
{
	exit();
}
 
class IforumTransferHandler {
	var $root_path;
	 
	function __construct()
	{
		$current_path = __FILE__;
		if (DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace(strpos($current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
		$this->root_path = dirname($current_path)."/transfer";
	}
	 
	function &getList()
	{
		global $icmsConfig, $icmsModule;
		$module_handler = icms::handler("icms_module");
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("isactive", 1));
		$module_list = array_keys($module_handler->getList($criteria, true) );
		$_list = XoopsLists::getDirListAsArray($this->root_path."/");
		foreach($_list as $item)
		{
			if (is_readable($this->root_path."/".$item."/config.php"))
			{
				require($this->root_path."/".$item."/config.php");
				if (empty($config["level"])) continue;
				if (!empty($config["module"]) && !in_array($config["module"], $module_list)) continue;
				$list[$item] = $config["title"];
				unset($config);
			}
		}
		unset($_list);
		return $list;
	}
	 
	/**
	* Transfer article content to another module or site
	*
	*@param string $item name of the script for the transfer
	*@param array $data associative array of title, uid, body, source (url of the article) and extra tags
	*return mixed
	*/
	function do_transfer($item, $data)
	{
		global $icmsConfig, $icmsModule;
		$item = preg_replace("/[^a-z0-9_\-]/i", "", $item);
		if (!is_readable($this->root_path."/".$item."/index.php")) return false;
		require_once $this->root_path."/".$item."/index.php";
		$func = "transfer_".$item;
		if (!function_exists($func)) return false;
		$ret = $func($data);
		return $ret;
	}
}