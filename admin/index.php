<?php
// $Id: index.php,v 1.3 2005/10/19 17:20:32 phppp Exp $
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                      //
// Copyright (c) 2000 XOOPS.org                           //
// <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
include('admin_header.php');

$op = '';
$ok = isset($_POST['ok']) ? intval($_POST['ok']) : 0;
foreach (array('approved', 'topic_id', 'post_id') as $getint) {
    ${$getint} = isset($_POST[$getint]) ? intval($_POST[$getint]) : 0;
}
foreach (array('approved', 'topic_id', 'post_id') as $getint) {
    ${$getint} = (${$getint})?${$getint}:(isset($_GET[$getint]) ? intval($_GET[$getint]) : 0);
}
if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op) {
    case "del":
        $post_handler = &xoops_getmodulehandler('post', 'newbb');
        if (!empty($ok)) {
            if (!empty($post_id)) {
                $post = &$post_handler->get($post_id);

                if ($ok == 2 && isset($post)) {
                    $post_handler->delete($post, true);
                }

                sync($post->getVar('forum_id'), "forum");
                sync($post->getVar('topic_id'), "topic");
            }
            if ($post->istopic()) {
                redirect_header("index.php", 2, _AM_NEWBB_POSTSDELETED);
                exit();
            } else {
                redirect_header("index.php", 2, _AM_NEWBB_POSTSDELETED);
                exit();
            }
        } else {
            xoops_cp_header();
            xoops_confirm(array('post_id' => $post_id, 'op' => 'del', 'ok' => 2), 'index.php', _AM_NEWBB_DEL_ONE);
            xoops_cp_footer();
        }
        exit();
        break;

    case "approve":

        if (!empty($post_id)) {
            $post_handler = &xoops_getmodulehandler('post', 'newbb');
            if ($post_handler->approve($post_id)) {
                redirect_header("index.php", 1, _AM_NEWBB_POSTAPPROVED);
            } else {
                redirect_header("index.php", 1, _AM_NEWBB_POSTNOTAPPROVED);
            }
        } elseif (!empty($topic_id)) {
            $topic_handler = &xoops_getmodulehandler('topic', 'newbb');
            if ($topic_handler->approve($topic_id)) {
                redirect_header("index.php", 1, _AM_NEWBB_TOPICAPPROVED);
            } else {
                redirect_header("index.php", 1, _AM_NEWBB_TOPICNOTAPPROVED);
            }
        }
        exit();
        break;

	/* removed */

    case "mod":

        if (empty($post_id)) {
            redirect_header("index.php", 2, _MD_ERRORPOST);
            exit();
        } else {
            xoops_cp_header();
        	loadModuleAdminMenu(0, "Index");
            echo "<br />";

            $post_handler = &xoops_getmodulehandler('post', 'newbb');
            $forumpost = &$post_handler->get($post_id);
		    $forum_handler =& xoops_getmodulehandler('forum', 'newbb');
		    $forum = $forum_handler->get($forumpost->getVar('forum_id'));

    		$pid = $forumpost->getVar('pid');
		    $dohtml = $forumpost->getVar('dohtml');
		    $dosmiley = $forumpost->getVar('dosmiley');
		    $doxcode = $forumpost->getVar('doxcode');
		    $icon = $forumpost->getVar('icon');
		    $attachsig = $forumpost->getVar('attachsig');
		    $topic_id=$forumpost->getVar('topic_id');
		    $istopic = ( $forumpost->istopic() )?1:0;
		    $isedit =1;
		    $subject_pre="";
		    $subject=$forumpost->getVar('subject', "E");
		    $message=$forumpost->getVar('post_text', "E");
		    $poster_name=$forumpost->getVar('poster_name', "E");
		    $attachments=$forumpost->getAttachment();
		    $post_karma=$forumpost->getVar('post_karma');
		    $require_reply=$forumpost->getVar('require_reply');
		    $hidden = "";

			$admin_form_action = "admin_post.php";
            include '../include/forumform.inc.php';
            xoops_cp_footer();
        }

        exit();
        break;
	/* */

    case "createdir":
		if (isset($_GET['path'])) $path = $_GET['path'];
        $res = newbb_admin_mkdir($path);
        $msg = ($res)?_AM_NEWBB_DIRCREATED:_AM_NEWBB_DIRNOTCREATED;
        redirect_header('index.php', 2, $msg . ': ' . $path);
        exit();
        break;

    case "setperm":
        $res = newbb_admin_chmod($path, 0777);
        $msg = ($res)?_AM_NEWBB_PERMSET:_AM_NEWBB_PERMNOTSET;
        redirect_header('index.php', 2, $msg . ': ' . $path);
        exit();
        break;

    case "senddigest":
        $digest_handler = &xoops_getmodulehandler('digest', 'newbb');
        $res = $digest_handler->process(true);
        $msg = ($res)?_AM_NEWBB_DIGEST_FAILED:_AM_NEWBB_DIGEST_SENT;
        redirect_header('index.php', 2, $msg);
        exit();
        break;

    case "default":
    default:

        xoops_cp_header();

        loadModuleAdminMenu(0, "Index");
		$imageLibs = newbb_getImageLibs();

        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_PREFERENCES . "</legend>";

        echo "<div style='padding: 12px;'>" . _AM_NEWBB_POLLMODULE . ": ";
        $module_handler = &xoops_gethandler('module');
        $xoopspoll = &$module_handler->getByDirname('xoopspoll');
        if (is_object($xoopspoll)) $isOK = $xoopspoll->getVar('isactive');
        else $isOK = false;
        echo ($isOK)?_AM_NEWBB_AVAILABLE:_AM_NEWBB_NOTAVAILABLE;
        echo "</div>";
        echo "<div style='padding: 8px;'>";
	    echo "<a href='http://www.imagemagick.org' target='_blank'>"._AM_NEWBB_IMAGEMAGICK."&nbsp;</a>";
	    if(array_key_exists('imagemagick',$imageLibs)) {
	    	echo "<strong><font color='green'>"._AM_NEWBB_AUTODETECTED.$imageLibs['imagemagick']."</font></strong>";
	    }
	    else { echo _AM_NEWBB_NOTAVAILABLE;
		}
	    echo "<br />";
		echo "<a href='http://sourceforge.net/projects/netpbm' target='_blank'>NetPBM:&nbsp;</a>";
		if(array_key_exists('netpbm',$imageLibs)) {
			echo "<strong><font color='green'>"._AM_NEWBB_AUTODETECTED.$imageLibs['netpbm']."</font></strong>";
		}
		else { echo _AM_NEWBB_NOTAVAILABLE;
		}
		echo "<br />";
		echo _AM_NEWBB_GDLIB1."&nbsp;";
		if(array_key_exists('gd1',$imageLibs)) {
			echo "<strong><font color='green'>"._AM_NEWBB_AUTODETECTED.$imageLibs['gd1']."</font></strong>";
		}
		else { echo _AM_NEWBB_NOTAVAILABLE;
		}
			
		echo "<br />";
		echo _AM_NEWBB_GDLIB2."&nbsp;";
		if(array_key_exists('gd2',$imageLibs)) {
			echo "<strong><font color='green'>"._AM_NEWBB_AUTODETECTED.$imageLibs['gd2']."</font></strong>";
		}
		else { echo _AM_NEWBB_NOTAVAILABLE;
		}
		echo "</div>";
      

        echo "<div style='padding: 8px;'>" . _AM_NEWBB_ATTACHPATH . ": ";
        $attach_path = XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['dir_attachments'] . '/';
        $path_status = newbb_admin_getPathStatus($attach_path);
        echo $attach_path . ' ( ' . $path_status . ' )';

        echo "<br />" . _AM_NEWBB_THUMBPATH . ": ";
        $thumb_path = $attach_path . 'thumbs/'; // be careful
        $path_status = newbb_admin_getPathStatus($thumb_path);
        echo $thumb_path . ' ( ' . $path_status . ' )';

        echo "</div>";

        echo "</fieldset><br />";

        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_BOARDSUMMARY . "</legend>";
        echo "<div style='padding: 12px;'>";
        echo _AM_NEWBB_TOTALTOPICS . " <strong>" . get_total_topics() . "</strong> | ";
        echo _AM_NEWBB_TOTALPOSTS . " <strong>" . get_total_posts(0, 'all') . "</strong> | ";
        echo _AM_NEWBB_TOTALVIEWS . " <strong>" . get_total_views() . "</strong></div>";
        echo "</fieldset><br />";

        $report_handler = &xoops_getmodulehandler('report', 'newbb');
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_REPORT . "</legend>";
        echo "<div style='padding: 12px;'><a href='admin_report.php'>" . _AM_NEWBB_REPORT_PENDING . "</a> <strong>" . $report_handler->getReportCount(0) . "</strong> | ";
        echo _AM_NEWBB_REPORT_PROCESSED . " <strong>" . $report_handler->getReportCount(1) . "</strong>";
        echo "</div>";
        echo "</fieldset><br />";

        if ($xoopsModuleConfig['email_digest'] > 0) {
            $digest_handler = &xoops_getmodulehandler('digest', 'newbb');
            echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_DIGEST . "</legend>";
            $due = ($digest_handler->checkStatus()) / 60; // minutes
            $prompt = ($due > 0)? sprintf(_AM_NEWBB_DIGEST_PAST, $due):sprintf(_AM_NEWBB_DIGEST_NEXT, abs($due));
            echo "<div style='padding: 12px;'><a href='index.php?op=senddigest'>" . $prompt . "</a> | ";
            echo "<a href='admin_digest.php'>" . _AM_NEWBB_DIGEST_ARCHIVE . "</a> <strong>" . $digest_handler->getDigestCount() . "</strong>";
            echo "</div>";
            echo "</fieldset><br />";
        }

        echo "<br /><br />";

        /* A trick to clear garbage for suspension management
         * Not good but works
         */
		if (!empty($xoopsModuleConfig['enable_usermoderate'])){
			$moderate_handler =& xoops_getmodulehandler('moderate', 'newbb');
			$moderate_handler->clearGarbage();
		}
         
        xoops_cp_footer();
        break;
}

?>