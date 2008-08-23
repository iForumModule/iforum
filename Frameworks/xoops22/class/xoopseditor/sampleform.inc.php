<?php
// $Id: sampleform.inc.php,v 1.1.2.4 2005/07/14 16:13:31 phppp Exp $
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
 * XOOPS editor usage example
 *
 * @author	    phppp (D.J.)
 * @copyright	copyright (c) 2005 XOOPS.org
 *
 */


if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

/*
 * Edit form with selected editor
 */
$sample_form = new XoopsThemeForm('', 'sample_form', "action.php");
$sample_form->setExtra('enctype="multipart/form-data"');

// Not required but for user-friendly concern
$editor = !empty($_REQUEST['editor'])?$_REQUEST['editor']:"";
if(!empty($editor)){
	setcookie("editor",$editor); // save to cookie
}else
// Or use user pre-selected editor through profile
if(is_object($xoopsUser)){
	$editor =@ $xoopsUser->getVar("editor"); // Need set through user profile
}

// Add the editor selection box
// If dohtml is disabled, set $noHtml = true
$sample_form->addElement(new XoopsFormSelectEditor($sample_form,"editor",$editor, $noHtml=false));

// options for the editor
//required configs
$options['name'] ='required_element';
$options['value'] = empty($_REQUEST['message'])?"":$_REQUEST['message'];
//optional configs
$options['rows'] = 25; // default value = 5
$options['cols'] = 60; // default value = 50
$options['width'] = '100%'; // default value = 100%
$options['height'] = '400px'; // default value = 400px

// "textarea": if the selected editor with name of $editor can not be created, the editor "textarea" will be used
// if no $onFailure is set, then the first available editor will be used
// If dohtml is disabled, set $noHtml to true
$sample_form->addElement(new XoopsFormEditor(_MD_MESSAGEC, $editor, $editor_configs, $nohtml=false, $onfailure="textarea"), true);

$sample_form->addElement(new XoopsFormText("SOME REQUIRED ELEMENTS", "required_element2", 50, 255, $required_element2), true);

$sample_form->addElement(new XoopsFormButton('', 'save', _SUBMIT, "submit"));

$sample_form->display();
?>
