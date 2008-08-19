<?php
// $Id: rss.php,v 1.1.2.11 2004/11/10 03:27:19 phppp Exp $
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

include_once("header.php");
include_once XOOPS_ROOT_PATH.'/class/template.php';
error_reporting(0);

$charset = empty($xoopsModuleConfig['rss_utf8'])?_CHARSET:'UTF-8';
header ('Content-Type:text/xml; charset='.$charset);

$tpl = new XoopsTpl();
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime($xoopsModuleConfig['rss_cachetime']*60);
if (!$tpl->is_cached('db:newbb_rss.html')) {
	$rss = &newbb_buildrss();
	$tpl->assign('rss', $rss);
}
$tpl->display('db:newbb_rss.html');
?>