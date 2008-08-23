<?php
// $Id: index.php,v 1.1.1.1 2005/10/19 16:23:36 phppp Exp $
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

function transfer_pm(&$data)
{
	global $xoopsModule, $xoopsConfig, $xoopsUser, $xoopsModuleConfig;
	global $xoopsLogger, $xoopsOption, $xoopsTpl, $xoopsblock;

	$_config = require(dirname(__FILE__)."/config.php");
	
	$hiddens["to_userid"] = $data["uid"];
	$hiddens["subject"] = $data["title"];
	$content  = str_replace("<br />", "\n\r", $data["content"]);
	$content  = str_replace("<br>", "\n\r", $content);
	$content  = "[quote]\n".newbb_html2text($content)."\n[/quote]";
	$content = $data["title"]."\n\r".$content."\n\r\n\r"._MORE."\n\r".$data["url"];
	$hiddens["message"] = $content;
	
	include XOOPS_ROOT_PATH."/header.php";
	if(!empty($_config["module"]) && is_dir(XOOPS_ROOT_PATH."/modules/".$_config["module"])){
		$action = XOOPS_URL."/modules/".$_config["module"]."/pmlite.php";
	}else{
		$action = XOOPS_URL."/pmlite.php?send2=1&amp;to_userid=".$data["uid"];
	}
	xoops_confirm($hiddens, $action, $_config["title"]);
	$GLOBALS["xoopsOption"]['output_type'] = "plain";
	include XOOPS_ROOT_PATH."/footer.php";
	exit();
}
?>