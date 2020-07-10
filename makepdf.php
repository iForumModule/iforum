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
 
error_reporting(0);
include 'header.php';
 
$forum = isset($_GET['forum']) ? (int)$_GET['forum'] :
 0;
$topic_id = isset($_GET['topic_id']) ? (int)$_GET['topic_id'] :
 0;
$post_id = !empty($_GET['post_id']) ? (int)$_GET['post_id'] :
 0;
 
if (empty($post_id))
{
	redirect_header(ICMS_URL.'/modules/'.basename(__DIR__).'/index.php', 2, _MD_ERRORTOPIC);
	exit();
}
 
// Not exists
$post_handler = icms_getmodulehandler('post', basename(__DIR__), 'iforum' );
$post = $post_handler->get($post_id);
if (empty($post) )
{
	redirect_header(ICMS_URL.'/modules/'.basename(__DIR__).'/index.php', 2, _MD_NORIGHTTOVIEW);
	exit();
}
// Not yet approved
$post_handler = icms_getmodulehandler('post', basename(__DIR__), 'iforum' );
$post = $post_handler->get($post_id);
if (!$approved = $post->getVar('approved') )
{
	redirect_header(ICMS_URL.'/modules/'.basename(__DIR__).'/index.php', 2, _MD_NORIGHTTOVIEW);
	exit();
}
 
$topic_handler = icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
$forumtopic = $topic_handler->getByPost($post_id);
$topic_id = $forumtopic->getVar('topic_id');
if (!$approved = $forumtopic->getVar('approved') )
{
	redirect_header(ICMS_URL.'/modules/'.basename(__DIR__).'/index.php', 2, _MD_NORIGHTTOVIEW);
	exit();
}
 
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
$forum = ($forum)?$forum:
$forumtopic->getVar('forum_id');
$viewtopic_forum = $forum_handler->get($forum);
if (!$forum_handler->getPermission($viewtopic_forum) )
{
	redirect_header(ICMS_URL.'/modules/'.basename(__DIR__).'/index.php', 2, _MD_NORIGHTTOACCESS);
	exit();
}
 
if (!$topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "view") )
{
	redirect_header(ICMS_URL.'/modules/'.basename(__DIR__).'/index.php', 2, _MD_NORIGHTTOVIEW);
	exit();
}
require_once ICMS_ROOT_PATH.'/include/pdf.php';
$post_data = $post_handler->getPostForPDF($post);
$pdf_data['title'] = $viewtopic_forum->getVar("forum_name");
$pdf_data['subtitle'] = $forumtopic->getVar('topic_title');
$pdf_data['subsubtitle'] = $post_data['subject'];
$pdf_data['date'] = $post_data['date'];
$pdf_data['content'] = $post_data['text'];
$pdf_data['author'] = $post_data['author'];
 
$content = '<b><i><u>'._PDF_SUBJECT.': '.$pdf_data['title'].'</u></i></b><br /><b>
	'._PDF_TOPIC.': '.$pdf_data['subsubtitle'].'</b><br />
	'._POSTEDBY.': '.$pdf_data['author'].'<br />
	'._PDF_DATE.': '.formatTimestamp($pdf_data['date'], 'm').'<br /><br /><br />'.$pdf_data['content'].'<br />';
$doc_title = $pdf_data['subtitle'];
$doc_keywords = 'ICMS';
$contents = Generate_PDF ($content, $doc_title, $doc_keywords);
