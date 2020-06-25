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
 
include "header.php";
 
$type = (!empty($_GET['type']) && in_array($_GET['type'], array("active", "pending", "deleted", "digest", "unreplied", "unread")))? $_GET['type'] :
 "";
$mode = !empty($_GET['mode']) ? (int)$_GET['mode'] :
 0;
$mode = (!empty($type) && in_array($type, array("active", "pending", "deleted")))?2:
$mode;
 
$isadmin = iforum_isAdmin();
/* Only admin has access to admin mode */
if (!$isadmin)
{
	$type = (!empty($type) && in_array($type, array("active", "pending", "deleted")))?"":
	$type;
	$mode = 0;
}
 
if (!empty(icms::$module->config['rss_enable']))
{
	$icms_module_header .= '<link rel="alternate" type="application/rss+xml" title="'.$icmsModule->getVar('name').'" href="'.ICMS_URL.'/modules/'.$icmsModule->getVar('dirname').'/rss.php" />';
}
$xoopsOption['xoops_module_header'] = $icms_module_header;
$xoopsOption['template_main'] = 'iforum_viewall.html';
include ICMS_ROOT_PATH."/header.php";
$icmsTpl->assign('xoops_module_header', $icms_module_header);
 
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
$viewall_forums = $forum_handler->getForums(0, 'access', array("forum_id", "cat_id", "forum_name")); // get all accessible forums
 
if (icms::$module->config['wol_enabled'])
	{
	$online_handler = icms_getmodulehandler('online', basename(__DIR__), 'iforum' );
	$online_handler->init();
	$icmsTpl->assign('online', $online_handler->show_online());
}
$icmsTpl->assign('forum_index_title', sprintf(_MD_FORUMINDEX, htmlspecialchars($icmsConfig['sitename'], ENT_QUOTES)));
$icmsTpl->assign('folder_topic', iforum_displayImage($forumImage['folder_topic']));
 
$sel_sort_array = array("t.topic_title" => _MD_TOPICTITLE, "u.uname" => _MD_TOPICPOSTER, "t.topic_time" => _MD_TOPICTIME, "t.topic_replies" => _MD_NUMBERREPLIES, "t.topic_views" => _MD_VIEWS, "p.post_time" => _MD_LASTPOSTTIME);
if (!isset($_GET['sortname']) || !in_array($_GET['sortname'], array_keys($sel_sort_array)) )
{
	$sortname = "p.post_time";
}
else
{
	$sortname = $_GET['sortname'];
}
 
$forum_selection_sort = '<select name="sortname">';
foreach ($sel_sort_array as $sort_k => $sort_v )
{
	$forum_selection_sort .= '<option value="'.$sort_k.'"'.(($sortname == $sort_k) ? ' selected="selected"' : '').'>'.$sort_v.'</option>';
}
$forum_selection_sort .= '</select>';
$icmsTpl->assign_by_ref('forum_selection_sort', $forum_selection_sort);
 
$sortorder = (!isset($_GET['sortorder']) || $_GET['sortorder'] != "ASC") ? "DESC" :
 "ASC";
$forum_selection_order = '<select name="sortorder">';
$forum_selection_order .= '<option value="ASC"'.(($sortorder == "ASC") ? ' selected="selected"' : '').'>'._MD_ASCENDING.'</option>';
$forum_selection_order .= '<option value="DESC"'.(($sortorder == "DESC") ? ' selected="selected"' : '').'>'._MD_DESCENDING.'</option>';
$forum_selection_order .= '</select>';
 
// assign to template
$icmsTpl->assign_by_ref('forum_selection_order', $forum_selection_order);
 
$since = isset($_GET['since']) ? (int)$_GET['since'] :
 icms::$module->config["since_default"];
$forum_selection_since = iforum_sinceSelectBox($since);
 
// assign to template
$icmsTpl->assign('forum_selection_since', $forum_selection_since);
$icmsTpl->assign('h_topic_link', "viewall.php?sortname=t.topic_title&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_title" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('h_reply_link', "viewall.php?sortname=t.topic_replies&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_replies" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('h_poster_link', "viewall.php?sortname=u.uname&amp;since=$since&amp;sortorder=". (($sortname == "u.uname" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('h_views_link', "viewall.php?sortname=t.topic_views&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_views" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('h_forum_link', "viewall.php?sortname=t.forum_id&amp;since=$since&amp;sortorder=". (($sortname == "t.forum_id" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('h_ratings_link', "viewall.php?sortname=t.topic_ratings&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_ratings" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('h_date_link', "viewall.php?sortname=p.post_time&amp;since=$since&amp;sortorder=". (($sortname == "p.post_time" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('forum_since', $since); // For $since in search.php
 
$startdate = empty($since)?0:
(time() - iforum_getSinceTime($since));
$start = !empty($_GET['start']) ? (int)$_GET['start'] :
 0;
 
$all_link = "viewall.php?start=$start&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since";
$post_link = "viewpost.php?since=$since";
$newpost_link = "viewpost.php?new=1&amp;since=$since";
$digest_link = "viewall.php?start=$start&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=digest";
$unreplied_link = "viewall.php?start=$start&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=unreplied";
$unread_link = "viewall.php?start=$start&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=unread";
switch($type)
{
	case 'digest':
	$current_type = _MD_DIGEST;
	$current_link = $digest_link;
	break;
	case 'unreplied':
	$current_type = _MD_UNREPLIED;
	$current_link = $unreplied_link;
	break;
	case 'unread':
	$current_type = _MD_UNREAD;
	$current_link = $unread_link;
	break;
	case 'active':
	$current_type = _MD_ALL. ' ['._MD_TYPE_ADMIN.']';
	$current_link = $all_link.'&amp;type='.$type;
	break;
	case 'pending':
	$current_type = _MD_ALL. ' ['._MD_TYPE_PENDING.']';
	$current_link = $all_link.'&amp;type='.$type;
	break;
	case 'deleted':
	$current_type = _MD_ALL. ' ['._MD_TYPE_DELETED.']';
	$current_link = $all_link.'&amp;type='.$type;
	break;
	default:
	$type = 'all';
	$current_type = _MD_ALL;
	$current_link = $all_link;
	break;
}
 
list($allTopics, $sticky) = $forum_handler->getAllTopics($viewall_forums, $startdate, $start, $sortname, $sortorder, $type);
$icmsTpl->assign_by_ref('topics', $allTopics);
unset($allTopics);
$icmsTpl->assign('sticky', $sticky);
$icmsTpl->assign('rating_enable', icms::$module->config['rating_enabled']);
$icmsTpl->assign('img_newposts', iforum_displayImage($forumImage['newposts_topic']));
$icmsTpl->assign('img_hotnewposts', iforum_displayImage($forumImage['hot_newposts_topic']));
$icmsTpl->assign('img_folder', iforum_displayImage($forumImage['folder_topic']));
$icmsTpl->assign('img_hotfolder', iforum_displayImage($forumImage['hot_folder_topic']));
$icmsTpl->assign('img_locked', iforum_displayImage($forumImage['locked_topic']));
 
$icmsTpl->assign('img_sticky', iforum_displayImage($forumImage['folder_sticky'], _MD_TOPICSTICKY));
$icmsTpl->assign('img_digest', iforum_displayImage($forumImage['folder_digest'], _MD_TOPICDIGEST));
$icmsTpl->assign('img_poll', iforum_displayImage($forumImage['poll'], _MD_TOPICHASPOLL));
$icmsTpl->assign('all_link', $all_link);
$icmsTpl->assign('post_link', $post_link);
$icmsTpl->assign('newpost_link', $newpost_link);
$icmsTpl->assign('digest_link', $digest_link);
$icmsTpl->assign('unreplied_link', $unreplied_link);
$icmsTpl->assign('unread_link', $unread_link);
$icmsTpl->assign('current_type', $current_type);
$icmsTpl->assign('current_link', $current_link);
 
$all_topics = $forum_handler->getTopicCount($viewall_forums, $startdate, $type);
unset($viewall_forums);
if ($all_topics > icms::$module->config['topics_per_page'])
{
	include ICMS_ROOT_PATH.'/class/pagenav.php';
	$nav = new XoopsPageNav($all_topics, icms::$module->config['topics_per_page'], $start, "start", 'sortname='.$sortname.'&amp;sortorder='.$sortorder.'&amp;since='.$since."&amp;type=$type&amp;mode=".$mode);
	$icmsTpl->assign('forum_pagenav', $nav->renderNav(4));
}
else
{
	$icmsTpl->assign('forum_pagenav', '');
}
if (!empty(icms::$module->config['show_jump']))
{
	$icmsTpl->assign('forum_jumpbox', iforum_make_jumpbox());
}
$icmsTpl->assign('down', iforum_displayImage($forumImage['doubledown']));
 
$icmsTpl->assign('mode', $mode);
$icmsTpl->assign('type', $type);
$icmsTpl->assign('viewer_level', ($isadmin)?2:(is_object(icms::$user)?1:0) );
 
$icmsTpl->assign('xoops_pagetitle', $icmsModule->getVar('name'). ' - ' .$current_type);
 
include ICMS_ROOT_PATH."/footer.php";