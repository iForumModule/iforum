<?php 
// $Id: myblocksadmin.php,v 1.1.1.11 2004/10/09 23:34:02 praedator Exp $
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
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
// ------------------------------------------------------------------------- //
// myblocksadmin.php                              //
// - XOOPS block admin for each modules -                     //
// GIJOE <http://www.peak.ne.jp/>                   //
// ------------------------------------------------------------------------- //
include("admin_header.php");
include_once('mygrouppermform.php') ;
include_once(XOOPS_ROOT_PATH . '/class/xoopsblock.php') ;

$xoops_system_url = XOOPS_URL . '/modules/system' ;
$xoops_system_path = XOOPS_ROOT_PATH . '/modules/system' ;
// language files
$language = $xoopsConfig['language'] ;
if (! file_exists("$xoops_system_path/language/$language/admin/blocksadmin.php")) $language = 'english' ;

include_once("$xoops_system_path/language/$language/admin.php") ;
include_once("$xoops_system_path/language/$language/admin/blocksadmin.php") ;
$group_defs = file("$xoops_system_path/language/$language/admin/groups.php") ;
foreach($group_defs as $def) {
    if (strstr($def , '_AM_ACCESSRIGHTS') || strstr($def , '_AM_ACTIVERIGHTS')) eval($def) ;
} 
// check $xoopsModule
if (! is_object($xoopsModule)) redirect_header(XOOPS_URL . '/user.php' , 1 , _NOPERM) ;
// get blocks owned by the module
$block_arr = &XoopsBlock::getByModule($xoopsModule->mid()) ;

function list_blocks()
{
    global $xoopsUser , $xoopsConfig , $xoopsDB ;
    global $block_arr , $xoops_system_url ;

    $side_descs = array(0 => _AM_SBLEFT, 1 => _AM_SBRIGHT, 3 => _AM_CBLEFT, 4 => _AM_CBRIGHT, 5 => _AM_CBCENTER) ; 
    // displaying TH
    echo "
	<table width='100%' class='outer' cellpadding='4' cellspacing='1'>
	<tr valign='middle'><th width='20%'>" . _AM_BLKDESC . "</th><th>" . _AM_TITLE . "</th><th align='center' nowrap='nowrap'>" . _AM_SIDE . "</th><th align='center'>" . _AM_WEIGHT . "</th><th align='center'>" . _AM_VISIBLE . "</th><th align='right'>" . _AM_ACTION . "</th></tr>
	"; 
    // blocks displaying loop
    $class = 'even' ;
    foreach(array_keys($block_arr) as $i) {
        $visible = ($block_arr[$i]->getVar("visible") == 1) ? _YES : _NO ;
        $weight = $block_arr[$i]->getVar("weight") ;
        $side_desc = $side_descs[ $block_arr[$i]->getVar("side") ] ;
        $title = $block_arr[$i]->getVar("title") ;
        if ($title == '') $title = "&nbsp;" ;
        $name = $block_arr[$i]->getVar("name") ;
        $bid = $block_arr[$i]->getVar("bid") ;

        echo "<tr valign='top'><td class='$class'>$name</td><td class='$class'>$title</td><td class='$class' align='center'>$side_desc</td><td class='$class' align='center'>$weight</td><td class='$class' align='center' nowrap='nowrap'>$visible</td><td class='$class' align='right'><a href='$xoops_system_url/admin.php?fct=blocksadmin&amp;op=edit&amp;bid=$bid' target='_blank'>" . _EDIT . "</a></td></tr>\n" ;
        $class = ($class == 'even') ? 'odd' : 'even' ;
    } 
    echo "<tr><td class='foot' align='center' colspan='7'>
	</td></tr></table>\n" ;
} 

function list_groups()
{
    global $xoopsUser , $xoopsConfig , $xoopsDB ;
    global $xoopsModule , $block_arr , $xoops_system_url ;

    foreach(array_keys($block_arr) as $i) {
        $item_list[ $block_arr[$i]->getVar("bid") ] = $block_arr[$i]->getVar("title") ;
    } 

    $form = new MyXoopsGroupPermForm('' , 1 , 'block_read' , _MD_AM_ADGS) ;
    $form->addAppendix('module_admin', $xoopsModule->mid(), $xoopsModule->name() . ' ' . _AM_ACTIVERIGHTS);
    $form->addAppendix('module_read', $xoopsModule->mid(), $xoopsModule->name() . ' ' . _AM_ACCESSRIGHTS);
    foreach($item_list as $item_id => $item_name) {
        $form->addItem($item_id , $item_name) ;
    } 
    echo $form->render() ;
} 

if (! empty($_POST['submit'])) {
    include("mygroupperm.php") ;
    redirect_header(XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/myblocksadmin.php" , 1 , _MD_AM_DBUPDATED);
} 

xoops_cp_header() ;

newbb_adminMenu(7, _AM_NEWBB_BLOCKS);

echo "<h3 style=\"color: #2F5376; margin-top: 6px; \">" . _AM_BADMIN . "</h3>\n" ;
list_blocks() ;
list_groups() ;
xoops_cp_footer() ;

?>