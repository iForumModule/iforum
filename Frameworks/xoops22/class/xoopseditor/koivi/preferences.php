<?php
// $Id: preferences.php,v 1.1.2.1 2005/06/04 02:11:51 phppp Exp $
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
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

//FULL TOOLBAR OPTIONS
define("_XK_P_FULLTOOLBAR","floating,fontname,fontsize,formatblock,insertsymbols,newline,undo,redo,cut,copy,paste,pastespecial,separator,spellcheck,print, separator,bold,italic,underline,strikethrough,removeformat,separator,justifyleft,justifycenter,justifyright,justifyfull,newparagraph,separator,ltr,rtl,separator,insertorderedlist,insertunorderedlist,indent,outdent,newline,forecolor,hilitecolor,superscript,subscript,separator,quote,code,inserthorizontalrule,insertanchor,insertdate,separator,createlink,unlink,separator,insertimage,imagemanager,imageproperties,separator,createtable,cellalign,cellborders,cellcolor,toggleborders,themecss,togglemode,separator");

//SMALL TOOLBAR OPTIONS
define("_XK_P_SMALLTOOLBAR","fontsize,forecolor,hilitecolor,separator,bold,italic,underline,strikethrough,separator,quote,code,separator,createlink,insertimage,imagemanager");

//TEXT DIRECTION(ltr / rtl)
define("_XK_P_TDIRECTION","ltr");

//SKIN (default / xp)
define("_XK_P_SKIN","default");

//PATH
$current_path = __FILE__;
if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
define("_XK_P_PATH", substr(dirname($current_path), strlen(XOOPS_ROOT_PATH)));

//WIDTH
define("_XK_P_WIDTH","100%");

//HEIGHT
define("_XK_P_HEIGHT","400px");
?>
