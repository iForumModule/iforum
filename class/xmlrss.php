<?php
// $Id: xmlrss.php,v 1.3 2005/10/19 17:20:32 phppp Exp $
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                      //
// Copyright (c) 2000 XOOPS.org                           //
// <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: phppp (D.J., infomax@gmail.com)                                  //
// URL: http://xoopsforge.com, http://xoops.org.cn                          //
// Project: Article Project                                                 //
// ------------------------------------------------------------------------ //
// ---------------------------------------------------------------------------------------//
/**
 * Description
 *
 * @param type $var description
 * @return type description
 * @link
 */
class Xmlrss {

    var $xml_version;
    var $rss_version;
    var $xml_encoding;

    var $channel_title;
    var $channel_link;
    var $channel_desc;
	var $channel_lastbuild;
	var $channel_webmaster;
	var $channel_editor;
	var $channel_category;
	var $channel_generator;
	var $channel_language;

    var $image_title;
    var $image_url;
    var $image_link;
    var $image_description;
    var $image_height;
    var $image_width;

    var $max_items;
    var $max_item_description;
    var $items = array();

    function Xmlrss()
    {
	    global $xoopsModuleConfig;

        $this->xml_version = '1.0';
        $this->xml_encoding = empty($xoopsModuleConfig['rss_utf8'])?_CHARSET:'UTF-8';
        $this->rss_version = '2.0';
        $this->image_height = 31;
        $this->image_width = 88;
        $this->max_items = 10;
        $this->max_item_description = 0;
        $this->items = array();
    }

    function setVarRss($var, $val)
    {
        $this->$var = $this->cleanup($val);
    }

    function addItem($title, $link, $description = '', $label = '', $pubdate = 0)
    {
        if (count($this->items) < $this->max_items) {
            if (!empty($label)) {
                $label = '[' . $this->cleanup($label) . ']';
            }
            if (!empty($description)) {
                $description = $this->cleanup($description, $this->max_item_description);
                //$description .= ' ' . $label;
            } else {
                //$description = $label;
            }

            $title = $this->cleanup($title).' ' . $label;
            $pubdate = $this->cleanup($pubdate);
            $this->items[] = array('title' => $title, 'link' => $link, 'guid' => $link, 'description' => $description, 'pubdate'=>$pubdate);
        } else return false;
        return true;
    }

    function cleanup($text, $trim = 0)
    {
        if(strtolower($this->xml_encoding) == "utf-8" && strncasecmp(_CHARSET,$this->xml_encoding, 5)){
        	$text =& XoopsLocal::convert_encoding($text, "utf-8");
    	}
        if(!empty($trim))
        $text = xoops_substr($text, 0, intval($trim));
        $text = htmlspecialchars($text, ENT_QUOTES);

        return $text;
    }
}

class NewbbXmlrssHandler
{
    function &create()
    {
        $xmlrss = new Xmlrss();
        return $xmlrss;
    }

    function &get(&$rss)
    {
	    $rss_array = array();
		$rss_array['xml_version'] = $rss->xml_version;
		$rss_array['xml_encoding'] = $rss->xml_encoding;
		$rss_array['rss_version'] = $rss->rss_version;
		$rss_array['channel_title'] = $rss->channel_title;
		$rss_array['channel_link'] = $rss->channel_link;
		$rss_array['channel_desc'] = $rss->channel_desc;
		$rss_array['channel_lastbuild'] = $rss->channel_lastbuild;
		$rss_array['channel_webmaster'] = $rss->channel_webmaster;
		$rss_array['channel_editor'] = $rss->channel_editor;
		$rss_array['channel_category'] = $rss->channel_category;
		$rss_array['channel_generator'] = $rss->channel_generator;
		$rss_array['channel_language'] = $rss->channel_language;
		$rss_array['image_title'] = $rss->channel_title;
		$rss_array['image_url'] = $rss->image_url;
		$rss_array['image_link'] = $rss->channel_link;
		$rss_array['image_width'] = $rss->image_width;
		$rss_array['image_height'] = $rss->image_height;
		$rss_array['items'] = $rss->items;

		return $rss_array;
    }

}

?>