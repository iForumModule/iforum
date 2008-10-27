<?php
// $Id: fpdf.inc.php,v 1.1.1.1 2005/11/10 19:51:12 phppp Exp $
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

if (!defined('XOOPS_ROOT_PATH')){ exit(); }

define('FPDF_PATH', dirname(__FILE__));
define('FPDF_FONTPATH', FPDF_PATH.'/font/');

require_once FPDF_PATH.'/xoopspdf.php';
/*
$language = preg_replace("/[^a-z0-9_\-]/i", "", $xoopsConfig['language']);
if(include_once(FPDF_PATH.'/language/'.$language.'_'.str_replace('-', '_', _CHARSET).'.php')){
}elseif(include_once(FPDF_PATH.'/language/'.$language.'.php')){
}elseif(!include_once(FPDF_PATH.'/language/english.php')){
	die('No Language File!');
}
*/
//include FPDF_PATH.'/xoopsfpdf.php';
?>