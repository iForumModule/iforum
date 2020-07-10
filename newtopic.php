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
 
include 'header.php';
foreach (array('forum', 'order') as $getint)
{
	$ {
		$getint }
	 = isset($_GET[$getint]) ? (int)$_GET[$getint] :
	 0;
}
if (isset($_GET['op'])) $op = $_GET['op'];
$viewmode = (isset($_GET['viewmode']) && $_GET['viewmode'] != 'flat') ? 'thread' :
 'flat';
if (empty($forum) )
{
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
}
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
$forum_obj = $forum_handler->get($forum);
if (!$forum_handler->getPermission($forum_obj))
	{
	redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
	exit();
}
 
$topic_handler = icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
if (!$topic_handler->getPermission($forum_obj, 0, 'post'))
{
	redirect_header("viewforum.php?order=$order&amp;viewmode=$viewmode&amp;forum=".$forum_obj->getVar('forum_id'), 2, _MD_NORIGHTTOPOST);
	exit();
}
 
if (icms::$module->config['wol_enabled'])
	{
	$online_handler = icms_getmodulehandler('online', basename(__DIR__), 'iforum' );
	$online_handler->init($forum_obj);
}
 
$istopic = 1;
$pid = 0;
$subject = "";
$message = "";
$myts = MyTextSanitizer::getInstance();
$hidden = "";
$subject_pre = "";
$dohtml = 1;
$dosmiley = 1;
$doxcode = 1;
$dobr = 1;
$icon = '';
$post_karma = 0;
$require_reply = 0;
$attachsig = (is_object(icms::$user) && icms::$user->getVar('attachsig')) ? 1 :
 0;
unset($post_id);
unset($topic_id);
 
 
// Disable cache
$icmsConfig["module_cache"][$icmsModule->getVar("mid")] = 0;
include ICMS_ROOT_PATH.'/header.php';
if (icms::$module->config['disc_show'] == 1 or icms::$module->config['disc_show'] == 3 )
	{
	echo "<div class=\"confirmMsg\">".icms::$module->config['disclaimer']."</div><br clear=\"both\">";
}
 
include 'include/forumform.inc.php';
include ICMS_ROOT_PATH.'/footer.php';