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
 
if (empty($_GET['forum']) )
{
	redirect_header("index.php", 2, _MD_ERRORFORUM);
	exit();
}
 
if (isset($_GET['mark_read']))
	{
	if (1 == (int)$_GET['mark_read'])
	{
		// marked as read
		$markvalue = 1;
		$markresult = _MD_MARK_READ;
	}
	else
	{
		// marked as unread
		$markvalue = 0;
		$markresult = _MD_MARK_UNREAD;
	}
	iforum_setRead_topic($markvalue, $_GET['forum']);
	$url = "viewforum.php?start=".$_GET['start']."&amp;forum=".$_GET['forum']."&amp;sortname=".$_GET['sortname']."&amp;sortorder=".$_GET['sortorder']."&amp;since=".$_GET['since'];
	redirect_header($url, 2, $markresult);
}
 
$forum_id = (int)$_GET['forum'];
$type = (!empty($_GET['type']) && in_array($_GET['type'], array("active", "pending", "deleted", "digest", "unreplied", "unread")))? $_GET['type'] :
 "";
$mode = !empty($_GET['mode']) ? (int)$_GET['mode'] :
 0;
$mode = (!empty($type) && in_array($type, array("active", "pending", "deleted")))?2:
$mode;
 
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
$forum_obj = $forum_handler->get($forum_id);
if (!$forum_handler->getPermission($forum_obj))
	{
	redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
	exit();
}
iforum_setRead("forum", $forum_id, $forum_obj->getVar("forum_last_post_id"));
 
 
$icms_pagetitle = $forum_obj->getVar('forum_name') . " [" .$icmsModule->getVar('name')."]";
if (!empty(icms::$module->config['rss_enable']))
{
	$icms_module_header .= '<link rel="alternate" type="application/xml+rss" title="'.$icmsModule->getVar('name').'-'.$forum_obj->getVar('forum_name').'" href="'.ICMS_URL.'/modules/'.$icmsModule->getVar('dirname').'/rss.php?f='.$forum_id.'" />';
}
 
$xoopsOption['template_main'] = 'iforum_viewforum.html';
$xoopsOption['xoops_pagetitle'] = $icms_pagetitle;
$xoopsOption['xoops_module_header'] = $icms_module_header;
include ICMS_ROOT_PATH."/header.php";
$icmsTpl->assign('xoops_module_header', $icms_module_header);
$icmsTpl->assign('xoops_pagetitle', $icms_pagetitle);
$icmsTpl->assign("forum_id", $forum_obj->getVar('forum_id'));
 
$isadmin = iforum_isAdmin($forum_obj);
$icmsTpl->assign('viewer_level', ($isadmin)?2:(is_object(icms::$user)?1:0) );
/* Only admin has access to admin mode */
if (!$isadmin)
{
	$type = (!empty($type) && in_array($type, array("active", "pending", "deleted")))?"":
	$type;
	$mode = 0;
}
$icmsTpl->assign('mode', $mode);
$icmsTpl->assign('type', $type);
 
if (icms::$module->config['wol_enabled'])
	{
	$online_handler = icms_getmodulehandler('online', basename(__DIR__), 'iforum' );
	$online_handler->init($forum_obj);
	$icmsTpl->assign('online', $online_handler->show_online());
}
 
$getpermission = icms_getmodulehandler('permission', basename(__DIR__), 'iforum' );
$permission_set = $getpermission->getPermissions("forum", $forum_obj->getVar('forum_id'));
 
$t_new = iforum_displayImage($forumImage['t_new'], _MD_POSTNEW);
$t_extras = iforum_displayImage($forumImage['t_extras'], _MD_EXTRAS);
$t_signup = iforum_displayImage($forumImage['t_signup'], _MD_EXTRAS);
 
if ($forum_handler->getPermission($forum_obj, "post")) {
	$icmsTpl->assign('forum_post_or_register', "<a href=\"newtopic.php?forum=".$forum_obj->getVar('forum_id')."\">".$t_new."</a>");
	if ($forum_handler->getPermission($forum_obj, "addpoll") && $forum_obj->getVar('allow_polls') == 1) {
		$t_poll = iforum_displayImage($forumImage['t_poll'], _MD_ADDPOLL);
		if (iforum_poll_module_active()) {
			$icmsTpl->assign('forum_addpoll', "<a href=\"newtopic.php?op=add&amp;forum=".$forum_obj->getVar('forum_id')."\">".$t_poll."</a>&nbsp;");
		}
	}
} else {
	if (!empty($GLOBALS["icmsModuleConfig"]["show_reg"]) && !is_object(icms::$user)) {
		$redirect = preg_replace("|(.*)\/modules\/".basename(__DIR__)."\/(.*)|", "\\1/modules/".basename(__DIR__)."/newtopic.php?forum=".$forum_obj->getVar('forum_id'), htmlspecialchars($xoopsRequestUri));
		$icmsTpl->assign('forum_post_or_register', '<a href="'.ICMS_URL.'/user.php?xoops_redirect='.$redirect.'">'.$t_signup.'</a>');
		$icmsTpl->assign('forum_addpoll', "");
	} else {
		$icmsTpl->assign('forum_post_or_register', "");
		$icmsTpl->assign('forum_addpoll', "");
	}
}
$icmsTpl->assign('forum_extras', $t_extras);
 
if ($forum_obj->getVar('parent_forum')) {
	$parent_forum_obj = $forum_handler->get($forum_obj->getVar('parent_forum'), array("forum_name"));
	$parentforum = array("id" => $forum_obj->getVar('parent_forum'), "name" => $parent_forum_obj->getVar("forum_name"));
	unset($parent_forum_obj);
	$icmsTpl->assign_by_ref("parentforum", $parentforum);
} else {
	$criteria = new icms_db_criteria_Item("parent_forum", $forum_id);
	$criteria->setSort("forum_order");
	if ($forums_obj = $forum_handler->getAll($criteria)) {
		$subforum_array = $forum_handler->display($forums_obj);
		if (isset($subforum_array[$forum_id])) {
			$subforum = array_values($subforum_array[$forum_id]);
			unset($forums_obj, $subforum_array);
			$icmsTpl->assign_by_ref("subforum", $subforum);
		}
	}
}
 
$category_handler = icms_getmodulehandler("category", basename(__DIR__), 'iforum' );
$category_obj = $category_handler->get($forum_obj->getVar("cat_id"), array("cat_title"));
$icmsTpl->assign('category', array("id" => $forum_obj->getVar("cat_id"), "title" => $category_obj->getVar('cat_title')));
 
$icmsTpl->assign('forum_index_title', sprintf(_MD_FORUMINDEX, htmlspecialchars($icmsConfig['sitename'], ENT_QUOTES)));
$icmsTpl->assign('folder_topic', iforum_displayImage($forumImage['folder_topic']));
$icmsTpl->assign('forum_name', $forum_obj->getVar('forum_name'));
$icmsTpl->assign('forum_moderators', $forum_obj->disp_forumModerators());
 
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
 
$icmsTpl->assign_by_ref('forum_selection_order', $forum_selection_order);
 
$since = isset($_GET['since']) ? (int)$_GET['since'] :
 icms::$module->config["since_default"];
$forum_selection_since = iforum_sinceSelectBox($since);
 
$icmsTpl->assign_by_ref('forum_selection_since', $forum_selection_since);
$icmsTpl->assign('h_topic_link', "viewforum.php?forum=$forum_id&amp;sortname=t.topic_title&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_title" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('h_reply_link', "viewforum.php?forum=$forum_id&amp;sortname=t.topic_replies&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_replies" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('h_poster_link', "viewforum.php?forum=$forum_id&amp;sortname=u.uname&amp;since=$since&amp;sortorder=". (($sortname == "u.uname" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('h_views_link', "viewforum.php?forum=$forum_id&amp;sortname=t.topic_views&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_views" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('h_rating_link', "viewforum.php?forum=$forum_id&amp;sortname=t.topic_ratings&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_ratings" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('h_date_link', "viewforum.php?forum=$forum_id&amp;sortname=p.post_time&amp;since=$since&amp;sortorder=". (($sortname == "p.post_time" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('h_publish_link', "viewforum.php?forum=$forum_id&amp;sortname=t.topic_time&amp;since=$since&amp;sortorder=". (($sortname == "t.topic_time" && $sortorder == "DESC") ? "ASC" : "DESC"))."&amp;type=$type";
$icmsTpl->assign('forum_since', $since); // For $since in search.php
 
$startdate = empty($since)?0:
(time() - iforum_getSinceTime($since));
$start = !empty($_GET['start']) ? (int)$_GET['start'] :
 0;
 
list($allTopics, $sticky) = $forum_handler->getAllTopics($forum_obj, $startdate, $start, $sortname, $sortorder, $type, icms::$module->config['post_excerpt']);
$icmsTpl->assign_by_ref('topics', $allTopics);
//unset($allTopics);
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
 
$mark_read_link = "viewforum.php?mark_read=1&amp;start=$start&amp;forum=".$forum_obj->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=$type";
$mark_unread_link = "viewforum.php?mark_read=2&amp;start=$start&amp;forum=".$forum_obj->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=$type";
$icmsTpl->assign('mark_read', $mark_read_link);
$icmsTpl->assign('mark_unread', $mark_unread_link);
 
$icmsTpl->assign('post_link', "viewpost.php?forum=".$forum_obj->getVar('forum_id'));
$icmsTpl->assign('newpost_link', "viewpost.php?type=new&amp;forum=".$forum_obj->getVar('forum_id'));
$icmsTpl->assign('all_link', "viewforum.php?start=$start&amp;forum=".$forum_obj->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since");
$icmsTpl->assign('digest_link', "viewforum.php?start=$start&amp;forum=".$forum_obj->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=digest");
$icmsTpl->assign('unreplied_link', "viewforum.php?start=$start&amp;forum=".$forum_obj->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=unreplied");
$icmsTpl->assign('unread_link', "viewforum.php?start=$start&amp;forum=".$forum_obj->getVar('forum_id')."&amp;sortname=$sortname&amp;sortorder=$sortorder&amp;since=$since&amp;type=unread");
switch($type)
{
	case 'digest':
	$current_type = '['._MD_DIGEST.']';
	break;
	case 'unreplied':
	$current_type = '['._MD_UNREPLIED.']';
	break;
	case 'unread':
	$current_type = '['._MD_UNREAD.']';
	break;
	case 'active':
	$current_type = '['._MD_TYPE_ADMIN.']';
	break;
	case 'pending':
	$current_type = '['._MD_TYPE_PENDING.']';
	break;
	case 'deleted':
	$current_type = '['._MD_TYPE_DELETED.']';
	break;
	default:
	$current_type = '';
	break;
}
$icmsTpl->assign('forum_topictype', $current_type);
 
$all_topics = $forum_handler->getTopicCount($forum_obj, $startdate, $type);
if ($all_topics > icms::$module->config['topics_per_page'])
{
	include ICMS_ROOT_PATH.'/class/pagenav.php';
	$nav = new XoopsPageNav($all_topics, icms::$module->config['topics_per_page'], $start, "start", 'forum='.$forum_obj->getVar('forum_id').'&amp;sortname='.$sortname.'&amp;sortorder='.$sortorder.'&amp;since='.$since."&amp;type=$type&amp;mode=".$mode);
	$icmsTpl->assign('forum_pagenav', $nav->renderNav(4));
}
else
{
	$icmsTpl->assign('forum_pagenav', '');
}
 
if (!empty(icms::$module->config['show_jump']))
{
	$icmsTpl->assign('forum_jumpbox', iforum_make_jumpbox($forum_obj->getVar('forum_id')));
}
$icmsTpl->assign('down', iforum_displayImage($forumImage['doubledown']));
 
if (icms::$module->config['show_permissiontable'])
{
	$permission_table = $getpermission->permission_table($permission_set, $forum_obj->getVar('forum_id'), false, $isadmin);
	$icmsTpl->assign_by_ref('permission_table', $permission_table);
	unset($permission_table);
}
 
if (icms::$module->config['rss_enable'] == 1)
{
	$icmsTpl->assign("rss_button", "<div><a href='".ICMS_URL . "/modules/" . $icmsModule->getVar("dirname") . "/rss.php?f=".$forum_obj->getVar('forum_id')."' title='RSS feed' target='_blank'>".iforum_displayImage($forumImage['rss'], 'RSS feed')."</a></div>");
}
 
include ICMS_ROOT_PATH."/footer.php";