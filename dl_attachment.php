<?php
// $Id: dl_attachment.php,v 1.1.1.15 2004/11/09 19:47:13 praedator Exp $
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

ob_start();
include "header.php";
include XOOPS_ROOT_PATH.'/header.php';

$attach_id = isset($_GET['attachid']) ? strval($_GET['attachid']) : '';
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

if(!$post_id||!$attach_id) die(_MD_NO_SUCH_FILE.': post_id:'.$post_id.'; attachid'.$attachid);

$post_handler =& xoops_getmodulehandler('post', 'newbb');
$forumpost =& $post_handler->get($post_id);
$attachments = $forumpost->getAttachment();
$attach = $attachments[$attach_id];
if (!$attach) die(_MD_NO_SUCH_FILE);
$file_saved = XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig['dir_attachments'].'/'.$attach['name_saved'];
if(!file_exists($file_saved)) die(_MD_NO_SUCH_FILE);
if($down = $forumpost->incrementDownload($attach_id)) {
	$forumpost->saveAttachment();
}
unset($forumpost);
$msg = ob_get_contents();
ob_end_clean();

$file_display = $attach['name_display'];
$mimetype = $attach['mimetype'];
if (function_exists('mb_http_output')) {
	mb_http_output('pass');
}
header('Content-Type: '.$mimetype);
if (preg_match("/MSIE ([0-9]\.[0-9]{1,2})/", $HTTP_USER_AGENT)) {
	header('Content-Disposition: inline; filename="'.$file_display.'"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
} else {
	header('Content-Disposition: attachment; filename="'.$file_display.'"');
	header('Expires: 0');
	header('Pragma: no-cache');
}
readfile($file_saved);
?>