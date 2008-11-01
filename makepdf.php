<?php
// $Id: makepdf.php,v 1.1.1.1 2005/10/19 15:58:07 phppp Exp $
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
//  Author: phppp (D.J., infomax@gmail.com)                                  //
//  URL: http://xoopsforge.com, http://xoops.org.cn                          //
//  Project: Article Project                                                 //
//  ------------------------------------------------------------------------ //

error_reporting(0);
include 'header.php';
require_once XOOPS_ROOT_PATH.'/include/pdf.php';

$forum = isset($_GET['forum']) ? intval($_GET['forum']) : 0;
$topic_id = isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;
$post_id = !empty($_GET['post_id']) ? intval($_GET['post_id']) : 0;

if (empty($post_id))  {
    redirect_header(XOOPS_URL.'/modules/newbb/index.php',2,_MD_ERRORTOPIC);
    exit();
}

// Not yet approved
$post_handler =& xoops_getmodulehandler('post', basename( dirname( __FILE__ ) ));
$post = & $post_handler->get($post_id);
if ( !$approved = $post->getVar('approved') ) {
    redirect_header(XOOPS_URL.'/modules/newbb/index.php', 2, _MD_NORIGHTTOVIEW);
    exit();
}

$topic_handler =& xoops_getmodulehandler('topic', basename( dirname( __FILE__ ) ));
$forumtopic =& $topic_handler->getByPost($post_id);
$topic_id = $forumtopic->getVar('topic_id');
if ( !$approved = $forumtopic->getVar('approved') ) {
    redirect_header(XOOPS_URL.'/modules/newbb/index.php', 2, _MD_NORIGHTTOVIEW);
    exit();
}

$forum_handler =& xoops_getmodulehandler('forum', basename( dirname( __FILE__ ) ));
$forum = ($forum)?$forum:$forumtopic->getVar('forum_id');
$viewtopic_forum =& $forum_handler->get($forum);
if ( !$forum_handler->getPermission($viewtopic_forum) ) {
    redirect_header(XOOPS_URL.'/modules/newbb/index.php', 2, _MD_NORIGHTTOACCESS);
    exit();
}

if ( !$topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "view") ) {
    redirect_header(XOOPS_URL.'/modules/newbb/index.php', 2, _MD_NORIGHTTOVIEW);
    exit();
}
$post_data = $post_handler->getPostForPDF($post);
$pdf_data['title'] = $viewtopic_forum->getVar("forum_name");
$pdf_data['subtitle'] = $forumtopic->getVar('topic_title');
$pdf_data['subsubtitle'] = $post_data['subject'];
$pdf_data['date'] = $post_data['date'];
$pdf_data['content'] = $post_data['text'];
$pdf_data['author'] = $post_data['author'];

$content = '<b><i><u>'.NEWBB_PDF_SUBJECT.': '.$pdf_data['title'].'</u></i></b><br /><b>
'.NEWBB_PDF_TOPIC.': '.$pdf_data['subject'].'</b><br />
'._POSTEDBY.' : '.$pdf_data['author'].'<br />
'.NEWBB_PDF_DATE.':  '.formatTimestamp($pdf_data['date'],$dateformat).'<br /><br /><br />'.$pdf_data['content'].'<br />';
$doc_title = $pdf_data['subtitle'];
$doc_keywords = 'ICMS';
$contents = Generate_PDF ($content, $doc_title, $doc_keywords);

?>