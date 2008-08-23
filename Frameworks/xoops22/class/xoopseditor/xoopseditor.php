<?php
// $Id: xoopseditor.php,v 1.1.2.4 2005/07/15 22:55:57 phppp Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
/**
 * XOOPS editor handler
 *
 * @author	    phppp (D.J.)
 * @copyright	copyright (c) 2005 XOOPS.org
 *
 */
class XoopsEditorHandler
{
	var $root_path="";
	var $nohtml=false;

    function XoopsEditorHandler()
    {
		$current_path = __FILE__;
		if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
		$this->root_path = dirname($current_path);
    }
    
	/**
     * @param	string	$name  Editor name
     * @param	array 	$options  editor options: $key=>$val
     * @param	string	$OnFailure  a pre-validated editor that will be used if the required editor is failed to create
     * @param	bool	$noHtml  dohtml disabled
	 */
    function &get($name = "", $options = null, $noHtml=false, $OnFailure = "")
    {
	    $editor = null;
		$list =array_keys($this->getList($noHtml));
	    if(!empty($name) && in_array($name, $list)){
	    	$editor = & $this->_loadEditor($name, $options);
    	}
	    if(!is_object($editor)){
		    if(empty($OnFailure) || !in_array($OnFailure, $list)){
			    $OnFailure = $list[0];
    		}
	    	$editor = & $this->_loadEditor($OnFailure, $options);
    	}
	    return $editor;
    }

    function &getList($noHtml=false)
    {
	    static $editors;
	    if(!isset($editors)) {
			$order = array();
			$list = XoopsLists::getDirListAsArray($this->root_path.'/');
			foreach($list as $item){
				if(@include($this->root_path.'/'.$item.'/editor_registry.php')){
					//include($this->root_path.'/'.$item.'/editor_registry.php');
					if(empty($config['order'])) continue;
					$editors[$config['name']] = $config;
					$order[] = $config['order'];
				}
			}
			array_multisort($order, $editors);
		}
		$_list = array();
		foreach($editors as $name=>$item){
			if(!empty($noHtml)&&empty($item['nohtml'])) continue;
			$_list[$name] = $item['title'];
		}
		return $_list;
    }

    function render(&$editor)
    {
	    return $editor->render();
    }

    function setConfig(&$editor, $options)
    {
	    if(method_exists($editor, 'setConfig')) {
		    $editor->setConfig($options);
	    }else{
		    foreach($options as $key=>$val){
			    $editor->$key = $val;
		    }
	    }
    }

    function &_loadEditor($name="", $options=null)
    {
	    $editor_path = $this->root_path."/".$name;
		if(!@include($editor_path."/editor_registry.php")) return false;
		//include($editor_path."/editor_registry.php");
		if(empty($config['order'])) return null;
		include_once($config['file']);
		$editor =& new $config['class']($options);
		return $editor;
    }
}
?>