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

if (!defined('XOOPS_ROOT_PATH')) { exit(); }
$xoopsLogger->activated = false;

defined("FRAMEWORKS_ART_FUNCTIONS_INI") || include_once dirname(__FILE__)."/../art/functions.ini.php";

define('FPDF_PATH', dirname(__FILE__));
define('FPDF_FONTPATH', FPDF_PATH.'/font/');

/**
 * Set PDF maker cache policy
 * 
 * Cache value $xoopsOption["pdf_cache"] can be set in module/dirname/pdf.php; if not, set below
 *
 * Possible cache values:
 * 0 - no cache
 * -1 - update cache upon content change verified by md5
 * positive integer - seconds
 */
if (!isset($GLOBALS["xoopsOption"]["pdf_cache"])) {
    $GLOBALS["xoopsOption"]["pdf_cache"] = -1;
}

require_once FPDF_PATH.'/xoopspdf.php';
?>