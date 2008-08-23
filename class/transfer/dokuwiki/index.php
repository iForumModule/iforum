<?php
// $Id: index.php,v 1.1.1.1 2005/10/19 16:23:35 phppp Exp $
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

function transfer_dokuwiki(&$data)
{
	global $xoopsModule, $xoopsConfig, $xoopsUser, $xoopsModuleConfig;
	global $xoopsLogger, $xoopsOption, $xoopsTpl, $xoopsblock;

	$_config = require(dirname(__FILE__)."/config.php");
	
	$hiddens["id"] = $_config["namespace"].":".$_config["prefix"].$data["id"];
	$content = MyTextSanitizer::nl2Br($data["content"]);
	
	// Comment open: we need a lite html2wiki convertor
	$content = str_replace("<br />", "\\\\ ", $content);
	$content = str_replace("<br>", "\\\\ ", $content);
	$content = preg_replace_callback("/<a[\s]+href=(['\"]?)([^\"'<>]*)\\1[^>]*>([^<]*)<\/a>/imu", "transfer_parse_html_to_wiki", $content);
	$content = preg_replace_callback("/<img[\s]+src=(['\"]?)([^\"'<>]*)\\1[\s]+(alt=(['\"]?)([^\"'<>]*)\\3)?[^>]*>/imu", "transfer_parse_img_to_wiki", $content);
	$content  = newbb_html2text($content);
	// Comment close;
	
	$hiddens["wikitext"] = "=====".$data["title"]."===== \n".
							$content . "\\\\ \\\\ [[".$data["url"]."|".$data["title"].": "._MORE."]]";
	$hiddens["summary"] = $data["title"];
	$hiddens["do"] = "preview";
	
	include XOOPS_ROOT_PATH."/header.php";
	
	require_once(XOOPS_ROOT_PATH . "/class/xoopsformloader.php");
	$form_dokuwiki = new XoopsThemeForm(_MD_TRANSFER_DOKUWIKI, "formdokuwiki", XOOPS_URL."/modules/".$_config["module"]."/doku.php");
	foreach(array_keys($hiddens) as $key){
		$form_dokuwiki->addElement(new XoopsFormHidden($key, str_replace("'", "&#039;",$hiddens[$key])));
	}
	
	$namespace_option_tray = new XoopsFormElementTray(_MD_TRANSFER_DOKUWIKI_NAMESPACE, "<br />");
	require XOOPS_ROOT_PATH."/modules/".$_config["module"]."/inc/init.php";
	$dir_array =& transfer_getDirListAsArray($conf["datadir"], $_config["namespace_skip"]);
	
	$dir_array = array_merge(array(0=>_NONE), $dir_array);
	
	$namespace_select = new XoopsFormSelect(_SELECT, "namespace_sel", "transfer");
	$namespace_select->addOptionArray($dir_array);
	$namespace_option_tray->addElement($namespace_select);
	$namespace_option_tray->addElement(new XoopsFormText(_ADD, "namespace_new", 50, 100));
	
	$form_dokuwiki->addElement($namespace_option_tray);
	$form_dokuwiki->addElement(new XoopsFormText(_MD_TRANSFER_DOKUWIKI_NAME, "name", 50, 255, $_config["prefix"].$data["id"]));
	
	$submit_button = new XoopsFormButton("", "ok", _SUBMIT, "button");
	$submit_button->setExtra('onclick="
		var namespace = escape(\''.$_config["namespace"].'\');
		var name = escape(\''.$_config["prefix"].$data["id"].'\');
		var changed = 0;
		if(window.document.formdokuwiki.name.value.length>0){
			name = window.document.formdokuwiki.name.value;
			changed = 1;
		}
		if(window.document.formdokuwiki.namespace_new.value.length>0){
			namespace = window.document.formdokuwiki.namespace_new.value;
			changed = 1;
		}else{
			var namespace_sel = window.document.formdokuwiki.namespace_sel.options[window.document.formdokuwiki.namespace_sel.selectedIndex].value;
			if(namespace_sel != namespace){
				namespace = namespace_sel;
				changed = 1;
			}
		}
		if(changed ==1){
			window.document.formdokuwiki.id.value = null;
			if(namespace !=0) window.document.formdokuwiki.id.value = namespace+\':\';
			window.document.formdokuwiki.id.value += name;
		}
		window.document.formdokuwiki.submit();
		"');
	
	$cancel_button = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
	
	$button_tray = new XoopsFormElementTray("");
	$button_tray->addElement($submit_button);
	$button_tray->addElement($cancel_button);
	$form_dokuwiki->addElement($button_tray);
	
	$form_dokuwiki->display();
	
	$GLOBALS["xoopsOption"]['output_type'] = "plain";
	include XOOPS_ROOT_PATH."/footer.php";
	exit();
}

function transfer_parse_html_to_wiki($matches) {
	return "[[".$matches[2]."|".$matches[3]."]]";
}

function transfer_parse_img_to_wiki($matches) {
	if(empty($matches[4])){
		return "{{".$matches[2]."}}";
	}else{
		return "{{".$matches[2]."|".$matches[4]."}}";
	}
}

function &transfer_getDirListAsArray($dir, $dir_skip) {
	$dirlist = array();
	$stack[] = $dir;
	$dir_base = $dir;
	
	while ($stack) {
		$current_dir = array_pop($stack);
		$current_base = array_filter(explode("/", str_replace($dir_base, "", $current_dir)));
		$current_base = implode(":", array_map("trim", $current_base));
		if (is_dir($current_dir) && $dh = opendir($current_dir)) {
			while (($file = readdir($dh)) !== false) {
				if ($file !== '.' AND $file !== '..') {
					if(in_array($file, $dir_skip)) continue;
					$current_file = "{$current_dir}/{$file}";                   	
					if (strtolower($file) != 'cvs' && is_dir($current_file) ) {
						$dir = (empty($current_base)?"":$current_base.":").$file;
						$dirlist[$dir] = $dir;
						$stack[] = $current_file;
					}
				}
			}
		}
	}
	return $dirlist;
}
?>