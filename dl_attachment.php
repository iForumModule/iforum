<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright  http://www.xoops.org/ The XOOPS Project
* @copyright  http://xoopsforge.com The XOOPS FORGE Project
* @copyright  http://xoops.org.cn The XOOPS CHINESE Project
* @copyright  XOOPS_copyrights.txt
* @copyright  readme.txt
* @copyright  http://www.impresscms.org/ The ImpressCMS Project
* @license   GNU General Public License (GPL)
*     a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package  CBB - XOOPS Community Bulletin Board
* @since   3.08
* @author  phppp
* ----------------------------------------------------------------------------------------------------------
*     iForum - a bulletin Board (Forum) for ImpressCMS
* @since   1.00
* @author  modified by stranger
* @version  $Id$
*/
 
ob_start();
include "header.php";
include ICMS_ROOT_PATH.'/header.php';
 
$attach_id = isset($_GET['attachid']) ? strval($_GET['attachid']) :
 '';
$post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] :
 0;
 
if (!$post_id || !$attach_id) die(_MD_NO_SUCH_FILE.': post_id:'.$post_id.'; attachid'.$attachid);
 
$post_handler = icms_getmodulehandler('post', basename(__DIR__), 'iforum' );
$forumpost = $post_handler->get($post_id);
if (!$approved = $forumpost->getVar('approved')) die(_MD_NORIGHTTOVIEW);
$topic_handler = icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
$forumtopic = $topic_handler->getByPost($post_id);
$topic_id = $forumtopic->getVar('topic_id');
if (!$approved = $forumtopic->getVar('approved')) die(_MD_NORIGHTTOVIEW);
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
$viewtopic_forum = $forum_handler->get($forumtopic->getVar('forum_id'));
if (!$forum_handler->getPermission($viewtopic_forum)) die(_MD_NORIGHTTOACCESS);
	if (!$topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "view")) die(_MD_NORIGHTTOVIEW);
	 
$attachments = $forumpost->getAttachment();
$attach = $attachments[$attach_id];
if (!$attach) die(_MD_NO_SUCH_FILE);
	$file_saved = ICMS_ROOT_PATH.'/'.icms::$module->config['dir_attachments'].'/'.$attach['name_saved'];
if (!file_exists($file_saved)) die(_MD_NO_SUCH_FILE);
if ($down = $forumpost->incrementDownload($attach_id))
{
	$forumpost->saveAttachment();
}
unset($forumpost);
$msg = ob_get_contents();
ob_end_clean();
 
if (!empty($GLOBALS["icmsModuleConfig"]["download_direct"])):
 
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("location: ".ICMS_URL.'/'.icms::$module->config['dir_attachments'].'/'.$attach['name_saved']);
 
else:
	$file_display = $attach['name_display'];
$mimetype = $attach['mimetype'];
if (function_exists('mb_http_output'))
{
	mb_http_output('pass');
}
header('Expires: 0');
header('Content-Type: '.$mimetype);
if (preg_match("/MSIE ([0-9]\.[0-9]{1,2})/", $HTTP_USER_AGENT))
{
	header('Content-Disposition: inline; filename="'.$file_display.'"');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
}
else
{
	header('Content-Disposition: attachment; filename="'.$file_display.'"');
	header('Pragma: no-cache');
}
header("Content-Type: application/force-download");
header("Content-Transfer-Encoding: binary");
 
$handle = fopen($file_saved, "rb");
while (!feof($handle))
{
	$buffer = fread($handle, 4096);
	echo $buffer;
}
fclose($handle);
 
endif;