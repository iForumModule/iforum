<?php
// $Id: posttonews.php,v 1.1.2.3 2004/11/20 15:18:18 phppp Exp $
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
include 'header.php';
include_once XOOPS_ROOT_PATH.'/header.php';
include_once XOOPS_ROOT_PATH.'/modules/news/class/class.newsstory.php';

//test if news module is installed and active
$module_handler = &xoops_gethandler('module');
$xoopsnews = &$module_handler->getByDirname('news');
if (is_object($xoopsnews)) $isOK = $xoopsnews->getVar('isactive');
else $isOK = false;
if(!$isOK)redirect_header('index.php', 3, _MD_ERROR);


//Take the post_id by GET
//If the post_id is defined show the form
//The new story must be sent by POST otherwise it doesn't execute the INSERT query
//If no post_id show a error

$op = 'form';
if ( isset($_GET['post_id']) ) {
	$post_id = intval($_GET['post_id']);
}elseif ( isset($_POST['post'])||isset($_POST['post_id'])){
	$op = 'post';
	$post_id = intval($_POST['post_id']);
}else{
	redirect_header('index.php', 3, _MD_ERRORPOST);
}

switch ($op)
{
	case 'post':
	//get the post
	$post_handler =& xoops_getmodulehandler('post', 'newbb');
	$post=$post_handler->get($post_id);

	$story = new NewsStory();
	$story->setTitle($post->getVar('subject','e'));/**/
	$story->setHometext($post->getVar('post_text','e'));/**/
	$story->setUid($post->getVar('uid'));/**/
	$story->setTopicId(0);/**/
	$story->setHostname(xoops_getenv('REMOTE_ADDR'));/**/
	$dohtml = $post->getVar('dohtml');
	$nohtml = empty($dohtml)?1:0;
	$story->setNohtml($nohtml);/**/
	$story->setNosmiley(0);/**/
	$story->setNotifyPub(0);/**/
	$story->setType('admin');
	$story->setExpired(0);/**/
	$story->setTopicdisplay(0);/**/
	$story->setTopicalign('R');/**/
   	$story->setIhome(0);/**/
	$story->setBodytext(' ');/**/
	$story->setExpired(0);/**/
	$story->setPublished(0);/**/
	$story->setApproved(0);/**/

	//save the story
	$result = $story->store();

	//notify
	if ($result)
	{
		$notification_handler =& xoops_gethandler('notification');
		$tags['WAITINGSTORIES_URL'] = XOOPS_URL . '/modules/news/admin/index.php?op=newarticle';
		$notification_handler->triggerEvent('global', 0, 'story_submit', $tags);
		$tags = array();
		$tags['STORY_NAME'] = $title;
		$tags['STORY_URL'] = XOOPS_URL . '/modules/news/ticle.php?storyid=' . $story->storyid();
		$tags['WAITINGSTORIES_URL'] = XOOPS_URL . '/modules/news/admin/index.php?op=newarticle';
		$notification_handler->triggerEvent('global', 0, 'story_submit', $tags);
	}
	redirect_header(XOOPS_URL.'/modules/news/submit.php?op=edit&amp;storyid=' . $story->storyid(), 3, _MD_THANKSSUBMIT);
	break;

	case 'form':
	default:

    echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>";
    echo "<table border='0' cellpadding='1' cellspacing='0' align='center' width='95%'>";
    echo "<tr>";
    echo "<td align='center'><p style='margin:5px;'><h2>"._MD_POSTTONEWS."</h2></p>";
    echo "<input type='hidden' name='post_id' value='".$post_id."' />";
    echo "<input type='submit' name='post' value='". _MD_SUBMIT."' />";
    echo "</td></tr></table></form>";

	break;
}

include XOOPS_ROOT_PATH.'/footer.php';
?>