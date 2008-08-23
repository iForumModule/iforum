<?php
// $Id: transfer.php,v 1.1.1.1 2005/10/19 16:23:34 phppp Exp $
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
/**
 * @package module::article
 * @copyright copyright &copy; 2005 XoopsForge.com
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class NewbbTransferHandler
{
	var $root_path;
	
    function NewbbTransferHandler()
    {
		$current_path = __FILE__;
		if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
		$this->root_path = dirname($current_path)."/transfer";
    }
    
    function &getList()
    {
		global $xoopsConfig, $xoopsModule;
    	$module_handler =& xoops_gethandler("module");
		$criteria = new CriteriaCompo(new Criteria("isactive", 1));
		$module_list =array_keys( $module_handler->getList($criteria, true) );
		$_list = XoopsLists::getDirListAsArray($this->root_path."/");
		foreach($_list as $item){
			if(is_readable($this->root_path."/".$item."/config.php")){
				require($this->root_path."/".$item."/config.php");
				if(empty($config["level"])) continue;
				if(!empty($config["module"]) && !in_array($config["module"], $module_list)) continue;
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
     *@param	string	$item	name of the script for the transfer
     *@param	array	$data	associative array of title, uid, body, source (url of the article) and extra tags
     *return	mixed
     */
    function do_transfer($item, $data)
    {
		global $xoopsConfig, $xoopsModule;
	    $item = preg_replace("/[^a-z0-9_\-]/i", "", $item);
		if(!is_readable($this->root_path."/".$item."/index.php")) return false;
		require_once $this->root_path."/".$item."/index.php";
		$func = "transfer_".$item;
		if(!function_exists($func)) return false;
		$ret = $func($data);
	    return $ret;
    }
}
?>