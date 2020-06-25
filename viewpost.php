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
// To enable image auto-resize by js
$icms_module_header .= '<script src="'.ICMS_URL.'/modules/'.$icmsModule->getVar('dirname').'/include/js/xoops.js" type="text/javascript"></script>';
 
$start = !empty($_GET['start']) ? (int)$_GET['start'] :
 0;
$forum_id = !empty($_GET['forum']) ? (int)$_GET['forum'] :
 0;
$order = isset($_GET['order'])?$_GET['order']:
"DESC";
 
$uid = !empty($_GET['uid']) ? (int)$_GET['uid'] :
 0;
$type = (!empty($_GET['type']) && in_array($_GET['type'], array("active", "pending", "deleted", "new")))? $_GET['type'] :
 "";
$mode = !empty($_GET['mode']) ? (int)$_GET['mode'] :
 0;
$mode = (!empty($type) && in_array($type, array("active", "pending", "deleted")) )?2:$mode;
 
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
$post_handler = icms_getmodulehandler('post', basename(__DIR__), 'iforum' );
 
$isadmin = iforum_isAdmin($forum_id);
/* Only admin has access to admin mode */
if (!$isadmin)
{
	$type = in_array($type, array("active", "pending", "deleted"))?"":
	$type;
	$mode = 0;
}
if ($mode)
{
	$_GET['viewmode'] = "flat";
}
 
if (empty($forum_id))
{
	$forums = $forum_handler->getForums(0, "view");
	$access_forums = array_keys($forums);
}
else
{
	$forum_obj = $forum_handler->get($forum_id);
	$forums[$forum_id] = & $forum_obj;
	$access_forums = array($forum_id);
}
 
$post_perpage = icms::$module->config['posts_per_page'];
 
$criteria_count = new icms_db_criteria_Compo(new icms_db_criteria_Item("forum_id", "(".implode(",", $access_forums).")", "IN"));
$criteria_post = new icms_db_criteria_Compo(new icms_db_criteria_Item("p.forum_id", "(".implode(",", $access_forums).")", "IN"));
$criteria_post->setSort("p.post_time");
$criteria_post->setOrder($order);
 
if (!empty($uid))
{
	$criteria_count->add(new icms_db_criteria_Item("uid", $uid));
	$criteria_post->add(new icms_db_criteria_Item("p.uid", $uid));
}
 
$join = null;
switch($type)
{
	case "pending":
	$criteria_type_count = new icms_db_criteria_Item("approved", 0);
	$criteria_type_post = new icms_db_criteria_Item("p.approved", 0);
	break;
	case "deleted":
	$criteria_type_count = new icms_db_criteria_Item("approved", -1);
	$criteria_type_post = new icms_db_criteria_Item("p.approved", -1);
	break;
	case "new":
	$criteria_type_count = new icms_db_criteria_Compo(new icms_db_criteria_Item("post_time", intval($last_visit), ">"));
	$criteria_type_post = new icms_db_criteria_Compo(new icms_db_criteria_Item("p.post_time", intval($last_visit), ">"));
	$criteria_type_count->add(new icms_db_criteria_Item("approved", 1));
	$criteria_type_post->add(new icms_db_criteria_Item("p.approved", 1));
	// following is for "unread" -- not finished
	/*
	if (empty(icms::$module->config["read_mode"])){
	}elseif(icms::$module->config["read_mode"] ==2){
	$join = ' LEFT JOIN ' . $this->db->prefix('bb_reads_topic') . ' r ON r.read_item = p.topic_id';
	$criteria_type_post = new icms_db_criteria_Compo(new icms_db_criteria_Item("p.post_id", "r.post_id", ">"));
	$criteria_type_post->add(new icms_db_criteria_Item("r.read_id", "NULL", "IS"), "OR");
	$criteria_type_post->add(new icms_db_criteria_Item("p.approved", 1));
	$criteria_type_count =& $criteria_type_post;
	}elseif(icms::$module->config["read_mode"] == 1){
	$criteria_type_count = new icms_db_criteria_Compo(new icms_db_criteria_Item("post_time", intval($last_visit), ">"));
	$criteria_type_post = new icms_db_criteria_Compo(new icms_db_criteria_Item("p.post_time", intval($last_visit), ">"));
	$criteria_type_count->add(new icms_db_criteria_Item("approved", 1));
	$criteria_type_post->add(new icms_db_criteria_Item("p.approved", 1));
	}
	*/
	break;
	default:
	$criteria_type_count = new icms_db_criteria_Item("approved", 1);
	$criteria_type_post = new icms_db_criteria_Item("p.approved", 1);
	break;
}
$criteria_count->add($criteria_type_count);
$criteria_post->add($criteria_type_post);
 
$karma_handler = icms_getmodulehandler('karma', basename(__DIR__), 'iforum' );
$user_karma = $karma_handler->getUserKarma();
 
$valid_modes = array("flat", "compact", "left", "right");
$viewmode_cookie = iforum_getcookie("V");
if (isset($_GET['viewmode']) && $_GET['viewmode'] == "compact") iforum_setcookie("V", "compact", $forumCookie['expire']);
$viewmode = isset($_GET['viewmode'])? $_GET['viewmode']:
(
!empty($viewmode_cookie)? $viewmode_cookie:
(
/*
is_object(icms::$user)?
icms::$user->getVar('umode'):
*/
@$valid_modes[icms::$module->config['view_mode']-1] )
);
$viewmode = in_array($viewmode, $valid_modes)?$viewmode:
"flat";
 
$postCount = $post_handler->getPostCount($criteria_count);
$posts = $post_handler->getPostsByLimit($criteria_post, $post_perpage, $start/*, $join*/);
 
$poster_array = array();
if (count($posts) > 0) foreach (array_keys($posts) as $id)
{
	$poster_array[$posts[$id]->getVar('uid')] = 1;
}
 
$icms_pagetitle = $icmsModule->getVar('name'). ' - ' ._MD_VIEWALLPOSTS;
$xoopsOption['xoops_pagetitle'] = $icms_pagetitle;
$xoopsOption['xoops_module_header'] = $icms_module_header;
$xoopsOption['template_main'] = 'iforum_viewpost.html';
include ICMS_ROOT_PATH."/header.php";
if ($icmsTpl->compile_check && is_dir(XOOPS_THEME_PATH."/".$icmsConfig['theme_set']."/templates/".$icmsModule->getVar("dirname")))
{
	$icmsTpl->assign('iforum_template_path', XOOPS_THEME_PATH."/".$icmsConfig['theme_set']."/templates/".$icmsModule->getVar("dirname"));
}
else
{
	$icmsTpl->assign('iforum_template_path', ICMS_ROOT_PATH."/modules/".$icmsModule->getVar("dirname")."/templates");
}
 
if (!empty($forum_id))
{
	if (!$forum_handler->getPermission($forum_obj, "view"))
		{
		redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
		exit();
	}
	if ($forum_obj->getVar('parent_forum'))
	{
		$parent_forum_obj = $forum_handler->get($forum_obj->getVar('parent_forum'), array("forum_name"));
		$parentforum = array("id" => $forum_obj->getVar('parent_forum'), "name" => $parent_forum_obj->getVar("forum_name"));
		unset($parent_forum_obj);
		$icmsTpl->assign_by_ref("parentforum", $parentforum);
	}
	$icmsTpl->assign('forum_name', $forum_obj->getVar('forum_name'));
	$icmsTpl->assign('forum_moderators', $forum_obj->disp_forumModerators());
	 
	$icms_pagetitle = $forum_obj->getVar('forum_name'). ' - ' ._MD_VIEWALLPOSTS. ' [' . $icmsModule->getVar('name'). ']';
	$icmsTpl->assign("forum_id", $forum_obj->getVar('forum_id'));
	 
	if (!empty(icms::$module->config['rss_enable']))
	{
		$icms_module_header .= '<link rel="alternate" type="application/xml+rss" title="'.$icmsModule->getVar('name').'-'.$forum_obj->getVar('forum_name').'" href="'.ICMS_URL.'/modules/'.$icmsModule->getVar('dirname').'/rss.php?f='.$forum_id.'" />';
	}
}
elseif(!empty(icms::$module->config['rss_enable']))
{
	$icms_module_header .= '<link rel="alternate" type="application/xml+rss" title="'.$icmsModule->getVar('name').'" href="'.ICMS_URL.'/modules/'.$icmsModule->getVar('dirname').'/rss.php" />';
}
$icmsTpl->assign('xoops_module_header', $icms_module_header);
$icmsTpl->assign('xoops_pagetitle', $icms_pagetitle);
 
$userid_array = array();
if (count($poster_array) > 0)
{
	$member_handler = icms::handler('icms_member');
	$userid_array = array_keys($poster_array);
	$user_criteria = "(".implode(",", $userid_array).")";
	$users = $member_handler->getUsers(new icms_db_criteria_Item('uid', $user_criteria, 'IN'), true);
}
else
{
	$user_criteria = '';
	$users = null;
}
 
if (icms::$module->config['wol_enabled'])
	{
	$online = array();
	if (!empty($user_criteria))
	{
		$online_handler = icms_getmodulehandler('online', basename(__DIR__), 'iforum');
		$online_handler->init($forum_id);
		$online_full = $online_handler->getAll(new icms_db_criteria_Item('online_uid', $user_criteria, 'IN'));
		if (is_array($online_full) && count($online_full) > 0)
		{
			foreach ($online_full as $thisonline)
			{
				if ($thisonline['online_uid'] > 0) $online[$thisonline['online_uid']] = 1;
			}
		}
	}
}
 
if (icms::$module->config['groupbar_enabled'])
{
	$groups_disp = array();
	$groups = $member_handler->getGroups();
	$count = count($groups);
	for ($i = 0; $i < $count; $i++)
	{
		$groups_disp[$groups[$i]->getVar('groupid')] = $groups[$i]->getVar('name');
	}
	unset($groups);
}
 
$viewtopic_users = array();
 
if (count($userid_array) > 0)
{
	$user_handler = icms_getmodulehandler('user', basename(__DIR__), 'iforum' );
	$user_handler->setUsers($users);
	$user_handler->setGroups($groups_disp);
	$user_handler->setStatus($online);
	foreach($userid_array as $userid)
	{
		$viewtopic_users[$userid] = $user_handler->get($userid);
	}
}
unset($users);
unset($groups_disp);
 
$pn = 0;
$topic_handler =icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
static $suspension = array();
foreach(array_keys($posts) as $id)
{
	$pn++;
	 
	$post = & $posts[$id];
	$post_title = $post->getVar('subject');
	 
	if ($posticon = $post->getVar('icon') )
		{
		$post_image = '<img style="vertical-align:middle;" src="' . ICMS_URL . '/images/subject/' . htmlspecialchars($posticon) . '" alt="" />';
	}
	else
	{
		$post_image = '<img style="vertical-align:middle;" src="' . ICMS_URL . '/images/icons/no_posticon.gif" alt="" />';
	}
	if ($post->getVar('uid') > 0 && isset($viewtopic_users[$post->getVar('uid')]))
	{
		$poster = $viewtopic_users[$post->getVar('uid')];
	}
	else $poster = array(
	'uid' => 0,
		'name' => $post->getVar('poster_name')?$post->getVar('poster_name'):
	icms_core_DataFilter::htmlSpecialchars($icmsConfig['anonymous']),
		'link' => $post->getVar('poster_name')?$post->getVar('poster_name'):
	icms_core_DataFilter::htmlSpecialchars($icmsConfig['anonymous'])
	);
	if ($isadmin || $post->checkIdentity())
	{
		$post_text = $post->getVar('post_text');
		$post_attachment = $post->displayAttachment();
	}
	elseif (icms::$module->config['enable_karma'] && $post->getVar('post_karma') > $user_karma)
	{
		$post_text = "<div class='karma'>" . sprintf(_MD_KARMA_REQUIREMENT, $user_karma, $post->getVar('post_karma')) . "</div>";
		$post_attachment = '';
	}
	elseif (
	icms::$module->config['allow_require_reply'] && $post->getVar('require_reply')
	)
	{
		$post_text = "<div class='karma'>" . _MD_REPLY_REQUIREMENT . "</div>";
		$post_attachment = '';
	}
	else
	{
		$post_text = $post->getVar('post_text');
		$post_attachment = $post->displayAttachment();
	}
	 
	$thread_buttons = array();
	 
	if ($GLOBALS["icmsModuleConfig"]['enable_permcheck'])
	{
		 
		if (!isset($suspension[$post->getVar('forum_id')]))
		{
			$moderate_handler = icms_getmodulehandler('moderate', basename(__DIR__), 'iforum' );
			$suspension[$post->getVar('forum_id')] = $moderate_handler->verifyUser(-1, "", $post->getVar('forum_id'));
		}
		 
		if (!$suspension[$post->getVar('forum_id')] && $post->checkIdentity() && $post->checkTimelimit('edit_timelimit')
			|| $isadmin)
		{
			$thread_buttons['edit']['image'] = iforum_displayImage($forumImage['p_edit'], _EDIT);
			$thread_buttons['edit']['link'] = "edit.php?forum=" .$post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
			$thread_buttons['edit']['name'] = _EDIT;
		}
		 
		if ((!$suspension[$post->getVar('forum_id')] && $post->checkIdentity() && $post->checkTimelimit('delete_timelimit'))
			|| $isadmin )
		{
			$thread_buttons['delete']['image'] = iforum_displayImage($forumImage['p_delete'], _DELETE);
			$thread_buttons['delete']['link'] = "delete.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
			$thread_buttons['delete']['name'] = _DELETE;
		}
		if (!$suspension[$post->getVar('forum_id')] && is_object(icms::$user))
		{
			$thread_buttons['reply']['image'] = iforum_displayImage($forumImage['p_reply'], _MD_REPLY);
			$thread_buttons['reply']['link'] = "reply.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
			$thread_buttons['reply']['name'] = _MD_REPLY;
			 
			$thread_buttons['quote']['image'] = iforum_displayImage($forumImage['p_quote'], _MD_QUOTE);
			$thread_buttons['quote']['link'] = "reply.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id') . "&amp;quotedac=1";
			$thread_buttons['quote']['name'] = _MD_QUOTE;
		}
		 
	}
	else
	{
		$thread_buttons['edit']['image'] = iforum_displayImage($forumImage['p_edit'], _EDIT);
		$thread_buttons['edit']['link'] = "edit.php?forum=" .$post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
		$thread_buttons['edit']['name'] = _EDIT;
		$thread_buttons['delete']['image'] = iforum_displayImage($forumImage['p_delete'], _DELETE);
		$thread_buttons['delete']['link'] = "delete.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
		$thread_buttons['delete']['name'] = _DELETE;
		$thread_buttons['reply']['image'] = iforum_displayImage($forumImage['p_reply'], _MD_REPLY);
		$thread_buttons['reply']['link'] = "reply.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
		$thread_buttons['reply']['name'] = _MD_REPLY;
	}
	 
	if (!$isadmin && icms::$module->config['reportmod_enabled'])
	{
		$thread_buttons['report']['image'] = iforum_displayImage($forumImage['p_report'], _MD_REPORT);
		$thread_buttons['report']['link'] = "report.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
		$thread_buttons['report']['name'] = _MD_REPORT;
	}
	$thread_action = array();
	 
	$icmsTpl->append('posts',
		array(
	'post_id' => $post->getVar('post_id'),
		'topic_id' => $post->getVar('topic_id'),
		'forum_id' => $post->getVar('forum_id'),
		'post_date' => formatTimestamp($post->getVar('post_time')),
		'post_image' => $post_image,
		'post_title' => $post_title,
		'post_text' => $post_text,
		'post_attachment' => $post_attachment,
		'post_edit' => $post->displayPostEdit(),
		'post_no' => $start+$pn,
		'post_signature' => ($post->getVar('attachsig'))?@$poster["signature"]:
	"",
		'poster_ip' => ($isadmin && icms::$module->config['show_ip'])?long2ip($post->getVar('poster_ip')):
	"",
		'thread_action' => $thread_action,
		'thread_buttons' => $thread_buttons,
		'poster' => $poster )
	);
	 
	unset($thread_buttons);
	unset($poster);
}
unset($viewtopic_users);
unset($forums);
 
if (!empty(icms::$module->config['show_jump']))
{
	$icmsTpl->assign('forum_jumpbox', iforum_make_jumpbox($forum_id));
}
 
if ($postCount > $post_perpage )
{
	include ICMS_ROOT_PATH.'/class/pagenav.php';
	$nav = new XoopsPageNav($postCount, $post_perpage, $start, "start", 'forum='.$forum_id.'&amp;viewmode='.$viewmode.'&amp;type='.$type.'&amp;uid='.$uid.'&amp;order='.$order."&amp;mode=".$mode);
	$icmsTpl->assign('pagenav', $nav->renderNav(4));
}
else
{
	$icmsTpl->assign('pagenav', '');
}
 
$icmsTpl->assign('lang_forum_index', sprintf(_MD_FORUMINDEX, htmlspecialchars($icmsConfig['sitename'], ENT_QUOTES)));
$icmsTpl->assign('folder_topic', iforum_displayImage($forumImage['folder_topic']));
 
switch($type)
{
	case 'active':
	$lang_title = _MD_VIEWALLPOSTS. ' ['._MD_TYPE_ADMIN.']';
	break;
	case 'pending':
	$lang_title = _MD_VIEWALLPOSTS. ' ['._MD_TYPE_PENDING.']';
	break;
	case 'deleted':
	$lang_title = _MD_VIEWALLPOSTS. ' ['._MD_TYPE_DELETED.']';
	break;
	case 'new':
	$lang_title = _MD_NEWPOSTS;
	break;
	default:
	$lang_title = _MD_VIEWALLPOSTS;
	break;
}
if ($uid > 0)
{
	$lang_title .= ' ('.XoopsUser::getUnameFromId($uid).')';
}
$icmsTpl->assign('lang_title', $lang_title);
$icmsTpl->assign('p_up', iforum_displayImage($forumImage['p_up'], _MD_TOP));
$icmsTpl->assign('groupbar_enable', icms::$module->config['groupbar_enabled']);
$icmsTpl->assign('anonymous_prefix', icms::$module->config['anonymous_prefix']);
$icmsTpl->assign('down', iforum_displayImage($forumImage['doubledown']));
$icmsTpl->assign('down2', iforum_displayImage($forumImage['down']));
$icmsTpl->assign('up', iforum_displayImage($forumImage['up']));
$icmsTpl->assign('printer', iforum_displayImage($forumImage['printer']));
$icmsTpl->assign('personal', iforum_displayImage($forumImage['personal']));
$icmsTpl->assign('post_content', iforum_displayImage($forumImage['post_content']));
 
$all_link = "viewall.php?forum=".$forum_id."&amp;start=$start";
$post_link = "viewpost.php?forum=".$forum_id;
$newpost_link = "viewpost.php?forum=".$forum_id."&amp;new=1";
$digest_link = "viewall.php?forum=".$forum_id."&amp;start=$start&amp;type=digest";
$unreplied_link = "viewall.php?forum=".$forum_id."&amp;start=$start&amp;type=unreplied";
$unread_link = "viewall.php?forum=".$forum_id."&amp;start=$start&amp;type=unread";
 
$icmsTpl->assign('all_link', $all_link);
$icmsTpl->assign('post_link', $post_link);
$icmsTpl->assign('newpost_link', $newpost_link);
$icmsTpl->assign('digest_link', $digest_link);
$icmsTpl->assign('unreplied_link', $unreplied_link);
$icmsTpl->assign('unread_link', $unread_link);
 
$viewmode_options = array();
if ($viewmode == "compact")
{
	$viewmode_options[] = array("link" => "viewpost.php?viewmode=flat&amp;order=".$order."&amp;forum=".$forum_id, "title" => _FLAT);
	$viewmode_options[] = array("link" => "viewpost.php?viewmode=left&amp;order=".$order."&amp;forum=".$forum_id, "title" => _MD_LEFT);
	$viewmode_options[] = array("link" => "viewpost.php?viewmode=right&amp;order=".$order."&amp;forum=".$forum_id, "title" => _MD_RIGHT);
	if ($order == 'DESC')
	{
		$viewmode_options[] = array("link" => "viewpost.php?viewmode=compact&amp;order=ASC&amp;forum=".$forum_id, "title" => _OLDESTFIRST);
	}
	else
	{
		$viewmode_options[] = array("link" => "viewpost.php?viewmode=compact&amp;order=DESC&amp;forum=".$forum_id, "title" => _NEWESTFIRST);
	}
}
elseif($viewmode == "left")
{
	$viewmode_options[] = array("link" => "viewpost.php?viewmode=flat&amp;order=".$order."&amp;forum=".$forum_id, "title" => _FLAT);
	$viewmode_options[] = array("link" => "viewpost.php?viewmode=compact&amp;order=".$order."&amp;forum=".$forum_id, "title" => _MD_COMPACT);
	$viewmode_options[] = array("link" => "viewpost.php?viewmode=right&amp;order=".$order."&amp;forum=".$forum_id, "title" => _MD_RIGHT);
	if ($order == 'DESC')
	{
		$viewmode_options[] = array("link" => "viewpost.php?viewmode=left&amp;order=ASC&amp;forum=".$forum_id, "title" => _OLDESTFIRST);
	}
	else
	{
		$viewmode_options[] = array("link" => "viewpost.php?viewmode=left&amp;order=DESC&amp;forum=".$forum_id, "title" => _NEWESTFIRST);
	}
}
elseif($viewmode == "right")
{
	$viewmode_options[] = array("link" => "viewpost.php?viewmode=flat&amp;order=".$order."&amp;forum=".$forum_id, "title" => _FLAT);
	$viewmode_options[] = array("link" => "viewpost.php?viewmode=compact&amp;order=".$order."&amp;forum=".$forum_id, "title" => _MD_COMPACT);
	$viewmode_options[] = array("link" => "viewpost.php?viewmode=left&amp;order=".$order."&amp;forum=".$forum_id, "title" => _MD_LEFT);
	if ($order == 'DESC')
	{
		$viewmode_options[] = array("link" => "viewpost.php?viewmode=right&amp;order=ASC&amp;forum=".$forum_id, "title" => _OLDESTFIRST);
	}
	else
	{
		$viewmode_options[] = array("link" => "viewpost.php?viewmode=rightt&amp;order=DESC&amp;forum=".$forum_id, "title" => _NEWESTFIRST);
	}
}
else
{
	$viewmode_options[] = array("link" => "viewpost.php?viewmode=compact&amp;order=".$order."&amp;forum=".$forum_id, "title" => _MD_COMPACT);
	$viewmode_options[] = array("link" => "viewpost.php?viewmode=left&amp;order=".$order."&amp;forum=".$forum_id, "title" => _MD_LEFT);
	$viewmode_options[] = array("link" => "viewpost.php?viewmode=right&amp;order=".$order."&amp;forum=".$forum_id, "title" => _MD_RIGHT);
	if ($order == 'DESC')
	{
		$viewmode_options[] = array("link" => "viewpost.php?viewmode=flat&amp;order=ASC&amp;forum=".$forum_id, "title" => _OLDESTFIRST);
	}
	else
	{
		$viewmode_options[] = array("link" => "viewpost.php?viewmode=flat&amp;order=DESC&amp;forum=".$forum_id, "title" => _NEWESTFIRST);
	}
}
 
$icmsTpl->assign('viewmode_compact', ($viewmode == "compact")?1:0);
$icmsTpl->assign('viewmode_left', ($viewmode == "left")?1:0);
$icmsTpl->assign('viewmode_right', ($viewmode == "right")?1:0);
$icmsTpl->assign_by_ref('viewmode_options', $viewmode_options);
 
$icmsTpl->assign('viewer_level', ($isadmin)?2:(is_object(icms::$user)?1:0) );
$icmsTpl->assign('uid', $uid);
$icmsTpl->assign('mode', $mode);
$icmsTpl->assign('type', $type);
 
include ICMS_ROOT_PATH.'/footer.php';