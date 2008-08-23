<?php
// $Id: dhtmltextarea.php,v 1.1.2.4 2005/08/12 18:07:28 mithyt2 Exp $
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
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
/**
 * Pseudo class
 *
 * @author	    phppp (D.J.)
 * @copyright	copyright (c) 2005 XOOPS.org
 */

class FormDhtmlTextArea extends XoopsFormDhtmlTextArea
{
	/**
	 * Constructor
	 *
     * @param	array   $configs  Editor Options
     * @param	binary 	$checkCompatible  true - return false on failure
	 */
	function FormDhtmlTextArea($configs, $checkCompatible = false)
	{
		if(!empty($configs)) foreach($configs as $key => $val){
			${$key} = $val;
			$this->$key = $val;
		}
		$this->XoopsFormDhtmlTextArea("", $name, empty($value)?"":$value, empty($rows)?5:$rows, empty($cols)?50:$cols, empty($hiddentext)?"xoopsHiddenText":$hiddentext);
	}

	function setConfig($configs)
	{
	    foreach($configs as $key=>$val){
		    $this->$key = $val;
	    }
	}
}
?>