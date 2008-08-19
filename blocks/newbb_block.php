<?php
// $Id: newbb_block.php,v 1.1.2.8 2004/11/20 18:24:21 phppp Exp $
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
include_once XOOPS_ROOT_PATH . '/modules/newbb/include/functions.php';
if(defined('NEWBB_BLOCK_DEFINED')) return;
define('NEWBB_BLOCK_DEFINED',true);

function b_newbb_show($options)
{
    global $xoopsConfig;
    static $newbbConfig, $access_forums;

    $db = &Database::getInstance();
    $myts = &MyTextSanitizer::getInstance();
    $block = array();
    $i = 0;
    switch ($options[2]) {
        case 'views':
            $order = 't.topic_views';
            break;
        case 'replies':
            $order = 't.topic_replies';
            break;
        case 'time':
        default:
            $order = 't.topic_time';
            break;
    }
    $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
	$module_handler = &xoops_gethandler('module');
	$newbb = $module_handler->getByDirname('newbb');

    if(!isset($newbbConfig)){
	    $config_handler = &xoops_gethandler('config');
	    $newbbConfig = &$config_handler->getConfigsByCat(0, $newbb->getVar('mid'));
    }

    $allow_moderator_html = $newbbConfig['allow_moderator_html'];

    if(!isset($access_forums)){
    	$access_forums = $forum_handler->getForums(0, 'access'); // get all accessible forums
	}

    if (!empty($options[3])) {
        $allowedforums = explode(",", $options[3]); // get allowed forums
        $allowed_forums = array();
        $notallowed_forums = array();
        foreach($allowedforums as $fid) {
            if (intval($fid) > 0) $allowed_forums[intval($fid)] = 1;
        }
        $allowed_forums = array_keys($allowed_forums);
    }
    $valid_forums = array_keys($access_forums);
    if (!empty($allowed_forums) && count($allowed_forums) > 0) $valid_forums = array_intersect($allowed_forums, $valid_forums);

    $forum_criteria = ' AND t.forum_id IN (' . implode(',', $valid_forums) . ')';
    unset($access_forums);
    $approve_criteria = ' AND t.approved = 1 AND p.approved = 1';

    $query = 'SELECT t.*, f.forum_name, f.allow_subject_prefix, p.post_id, p.icon, p.uid, p.poster_name, u.uname, u.name FROM ' . $db->prefix('bb_topics') . ' t, ' . $db->prefix('bb_forums') . ' f, ' . $db->prefix('bb_posts') . ' p LEFT JOIN ' . $db->prefix("users") . ' u ON u.uid = p.uid WHERE f.forum_id=t.forum_id ' . $forum_criteria . $approve_criteria . ' AND t.topic_last_post_id=p.post_id ORDER BY ' . $order . ' DESC';
    $result = $db->query($query, $options[0], 0);
    if (!$result) {
        return false;
    }
    $block['disp_mode'] = $options[1]; // 0 - full view; 1 - compact view; 2 - lite view;
    $block['lang_forum'] = _MB_NEWBB_FORUM;
    $block['lang_topic'] = _MB_NEWBB_TOPIC;
    $block['lang_replies'] = _MB_NEWBB_RPLS;
    $block['lang_views'] = _MB_NEWBB_VIEWS;
    $block['lang_lastpost'] = _MB_NEWBB_LPOST;
    $block['lang_visitforums'] = _MB_NEWBB_VSTFRMS;
    $rows = array();
    while ($row = $db->fetchArray($result)) {
        $rows[] = $row;
    }
    if (count($rows) < 1) return false;

    foreach ($rows as $arr) {
        if ($arr['icon']) {
            $last_post_icon = '<img src="' . XOOPS_URL . '/images/subject/' . $arr['icon'] . '" alt="" />';
        } else {
            $last_post_icon = '<img src="' . XOOPS_URL . '/images/subject/icon1.gif" alt="" />';
        }
        // ------------------------------------------------------
        // topic_page_jump
        $topic_page_jump = '';
        $totalpages = ceil(($arr['topic_replies'] + 1) / $newbbConfig['posts_per_page']);
        if ($totalpages > 1) {
            $topic_page_jump .= '&nbsp;&nbsp;&nbsp;<img src="' . XOOPS_URL . '/images/icons/posticon.gif" alt="" /> ';
            $append = false;
            for ($i = 1; $i <= $totalpages; $i++) {
                if ($i > 3 && $i < $totalpages) {
                	if(!$append){
                        	$topic_page_jump .= "...";
                        	$append = true;
                    	}
                } else {
                    $topic_page_jump .= '[<a href="' . XOOPS_URL . '/modules/newbb/viewtopic.php?topic_id=' . $arr['topic_id'] . '&amp;start=' . (($i - 1) * $newbbConfig['posts_per_page']) . '">' . $i . '</a>]';
                    $topic['jump_post'] = "<a href='" . XOOPS_URL . "/modules/newbb/viewtopic.php?topic_id=" . $arr['topic_id'] . "&amp;post_id=" . $arr['post_id'] . "#forumpost" . $arr['post_id'] . "'>" . $last_post_icon . "</a>";
                }
            }
        } else {
            $topic['jump_post'] = "<a href='" . XOOPS_URL . "/modules/newbb/viewtopic.php?topic_id=" . $arr['topic_id'] . "&amp;post_id=" . $arr['post_id'] ."#forumpost" . $arr['post_id'] . "'>" . $last_post_icon . "</a>";
        }
        if ($arr['allow_subject_prefix']) {
            $subjectpres = explode(',', $newbbConfig['subject_prefix']);
            if (count($subjectpres) > 1) {
                foreach($subjectpres as $subjectpre) {
                    $subject_array[] = $subjectpre;
                }
            }
            $topic['topic_subject'] = $subject_array[$arr['topic_subject']];
        } else {
            $topic['topic_subject'] = "";
        }
        $topic['forum_id'] = $arr['forum_id'];
        $topic['forum_name'] = $myts->htmlSpecialChars($arr['forum_name']);
        $topic['id'] = $arr['topic_id'];

        //if (newbb_isAdmin($arr['forum_id'],$arr['topic_poster']) && $allow_moderator_html) {
	    /* To avoid query cost, we have to use the not so accurate code
	     * If you are not concerned by query, comment out the following line and use the above one
	     */
        if (newbb_isAdmin(0,$arr['topic_poster']) && $allow_moderator_html) {
            $topic['title'] = $arr['topic_title'];
        } else {
            $topic['title'] = $myts->htmlSpecialChars($arr['topic_title']);
        }
        $topic['replies'] = $arr['topic_replies'];
        $topic['views'] = $arr['topic_views'];
        $topic['post_id'] = $arr['post_id'];
        $time = formatTimestamp($arr['topic_time'], 'm');
        if ($arr['uid'] != 0) {
            if ($newbbConfig['show_realname'] && $arr['name']) {
                $topic_poster = "<a href='" . XOOPS_URL . "/userinfo.php?uid=" . $arr['uid'] . "'>" . $arr['name'] . "</a>";
            } else {
                $topic_poster = "<a href='" . XOOPS_URL . "/userinfo.php?uid=" . $arr['uid'] . "'>" . $arr['uname'] . "</a>";
            }
        } else {
            $topic_poster = $arr['poster_name']?$arr['poster_name']:$xoopsConfig['anonymous'];
        }
        $topic['time'] = $time . '<br />' . $topic['jump_post'];

        $topic['time'] .= "<br />" . $topic_poster;
        $topic['topic_page_jump'] = $topic_page_jump;
        $block['topics'][] = &$topic;
        unset($topic);
    }
    return $block;
}

function b_newbb_edit($options)
{
    $form = _MB_NEWBB_DISPLAY."<input type='text' name='options[0]' value='" . $options[0] . "' />";
    $form .= "<br />" . _MB_NEWBB_DISPLAYMODE. "<input type='radio' name='options[1]' value='0'";
    if ($options[1] == 0) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_FULL . "<input type='radio' name='options[1]' value='1'";
    if ($options[1] == 1) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_COMPACT . "<input type='radio' name='options[1]' value='2'";
    if ($options[1] == 2) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;" . _MB_NEWBB_DISPLAYMODE_LITE;

    $form .= '<input type="hidden" name="options[2]" value="' . $options[2] . '" />';

    $form .= "<br /><br />" . _MB_NEWBB_FORUMLIST;
    $form .= '<input type="hidden" name="options[3]" value="' . $options[3] . '" />';

    /*
     * The cookie method for multiple selection is from links.infophp.com and has been test with ie 5+, firefox 1.0
     * phppp
     */
    $form .= '<script type="text/javascript">function creatOpt(form){var v = "";for(var i=0;i<form.extra.options.length;i++){var e = form.extra.options[i];if(e.selected==true){if(v.length>0)	{v = v + "," + e.value;}else{v = e.value;}}}form.elements[11].value = v;}</script>';
    $form .= "<br />&nbsp;&nbsp;<select id='extra' name='extra' multiple onchange=\"creatOpt(this.form);\">";
    //$form .= "<br />&nbsp;&nbsp;" . _MB_NEWBB_FORUMLIST_DESC;
    $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
    $forums = $forum_handler->getForums();
    ksort($forums);
	$selected = empty($options[3])?' selected':'';
    $form .= "<option value=0$selected>"._ALL."</option>";
    $fids = explode(',', $options[3]);

    $myts = &MyTextSanitizer::getInstance();
    foreach ($forums as $fid => $forum) {
	    if(in_array($fid, $fids)) $selected = " selected";
	    else $selected ='';
        $form .= "<option value='".$fid."' $selected>".$myts->htmlSpecialChars($forum->getVar('forum_name'))."</option>";
    }
    $form .= "</select><br />";

    return $form;
}

function b_newbb_custom($options)
{
	global $xoopsConfig;
	// If no newbb module block set, we have to include the language file
	if(is_readable(XOOPS_ROOT_PATH.'/modules/newbb/language/'.$xoopsConfig['language'].'/blocks.php'))
		include_once(XOOPS_ROOT_PATH.'/modules/newbb/language/'.$xoopsConfig['language'].'/blocks.php');
	else
		include_once(XOOPS_ROOT_PATH.'/modules/newbb/language/english/blocks.php');

	$options = explode('|',$options);
	$block = &b_newbb_show($options);
	if(count($block["topics"])<1) return false;

	$tpl = new XoopsTpl();
	$tpl->assign('block', $block);
	$tpl->display('db:newbb_block.html');
}
?>
