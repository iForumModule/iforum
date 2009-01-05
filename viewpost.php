<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		http://xoopsforge.com The XOOPS FORGE Project
* @copyright		http://xoops.org.cn The XOOPS CHINESE Project
* @copyright		XOOPS_copyrights.txt
* @copyright		readme.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license			GNU General Public License (GPL)
*					a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		CBB - XOOPS Community Bulletin Board
* @since			3.08
* @author		phppp
* ----------------------------------------------------------------------------------------------------------
* 				iForum - a bulletin Board (Forum) for ImpressCMS
* @since			1.00
* @author		modified by stranger
* @version		$Id$
*/

include 'header.php';
// To enable image auto-resize by js
$xoops_module_header .= '<script src="'.ICMS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/js/xoops.js" type="text/javascript"></script>';

$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;
$forum_id = !empty($_GET['forum']) ? intval($_GET['forum']) : 0;
$order = isset($_GET['order'])?$_GET['order']:"DESC";

$uid = !empty($_GET['uid']) ? intval($_GET['uid']) : 0;
$type = (!empty($_GET['type']) && in_array($_GET['type'], array("active", "pending", "deleted", "new")))? $_GET['type'] : "";
$mode = !empty($_GET['mode']) ? intval($_GET['mode']) : 0;
$mode = (!empty($type) && in_array($type, array("active", "pending", "deleted")) )?2:$mode;

$forum_handler =& icms_getmodulehandler('forum', basename( dirname( __FILE__ ) ), 'iforum' );
$post_handler =& icms_getmodulehandler('post', basename( dirname( __FILE__ ) ), 'iforum' );

$isadmin = iforum_isAdmin($forum_id);
/* Only admin has access to admin mode */
if(!$isadmin){
	$type = in_array($type, array("active", "pending", "deleted"))?"":$type;
	$mode = 0;
}
if($mode){
	$_GET['viewmode'] = "flat";
}

if(empty($forum_id)){
	$forums = $forum_handler->getForums(0, "view");
	$access_forums = array_keys($forums);
}else{
	$forum_obj =& $forum_handler->get($forum_id);
	$forums[$forum_id] =& $forum_obj;
	$access_forums = array($forum_id);
}

$post_perpage = $xoopsModuleConfig['posts_per_page'];

$criteria_count = new CriteriaCompo(new Criteria("forum_id", "(".implode(",",$access_forums).")", "IN"));
$criteria_post = new CriteriaCompo(new Criteria("p.forum_id", "(".implode(",",$access_forums).")", "IN"));
$criteria_post->setSort("p.post_time");
$criteria_post->setOrder($order);

if(!empty($uid)){
	$criteria_count->add(new Criteria("uid", $uid));
	$criteria_post->add(new Criteria("p.uid", $uid));
}

$join = null;
switch($type){
	case "pending":
		$criteria_type_count = new Criteria("approved", 0);
		$criteria_type_post = new Criteria("p.approved", 0);
		break;
	case "deleted":
		$criteria_type_count = new Criteria("approved", -1);
		$criteria_type_post = new Criteria("p.approved", -1);
		break;
	case "new":
		$criteria_type_count = new CriteriaCompo(new Criteria("post_time", intval($last_visit), ">"));
		$criteria_type_post = new CriteriaCompo(new Criteria("p.post_time", intval($last_visit), ">"));
		$criteria_type_count->add(new Criteria("approved", 1));
		$criteria_type_post->add(new Criteria("p.approved", 1));
		// following is for "unread" -- not finished
		/*
        if(empty($xoopsModuleConfig["read_mode"])){
        }elseif($xoopsModuleConfig["read_mode"] ==2){
    		$join = ' LEFT JOIN ' . $this->db->prefix('bb_reads_topic') . ' r ON r.read_item = p.topic_id';
			$criteria_type_post = new CriteriaCompo(new Criteria("p.post_id", "r.post_id", ">"));
			$criteria_type_post->add(new Criteria("r.read_id", "NULL", "IS"), "OR");
			$criteria_type_post->add(new Criteria("p.approved", 1));
			$criteria_type_count =& $criteria_type_post;
        }elseif($xoopsModuleConfig["read_mode"] == 1){
			$criteria_type_count = new CriteriaCompo(new Criteria("post_time", intval($last_visit), ">"));
			$criteria_type_post = new CriteriaCompo(new Criteria("p.post_time", intval($last_visit), ">"));
			$criteria_type_count->add(new Criteria("approved", 1));
			$criteria_type_post->add(new Criteria("p.approved", 1));
        }
        */
		break;
	default:
		$criteria_type_count = new Criteria("approved", 1);
		$criteria_type_post = new Criteria("p.approved", 1);
		break;
}
$criteria_count->add($criteria_type_count);
$criteria_post->add($criteria_type_post);

$karma_handler =& icms_getmodulehandler('karma', basename( dirname( __FILE__ ) ), 'iforum' );
$user_karma = $karma_handler->getUserKarma();

$valid_modes = array("flat", "compact", "left", "right");
$viewmode_cookie = iforum_getcookie("V");
if(isset($_GET['viewmode'])&&$_GET['viewmode']=="compact") iforum_setcookie("V", "compact", $forumCookie['expire']);
$viewmode = isset($_GET['viewmode'])?
			$_GET['viewmode']:
			(
				!empty($viewmode_cookie)?
				$viewmode_cookie:
				(
				/*
					is_object($xoopsUser)?
					$xoopsUser->getVar('umode'):
				*/
					@$valid_modes[$xoopsModuleConfig['view_mode']-1]
				)
			);
$viewmode = in_array($viewmode, $valid_modes)?$viewmode:"flat";

$postCount = $post_handler->getPostCount($criteria_count);
$posts = $post_handler->getPostsByLimit($criteria_post, $post_perpage, $start/*, $join*/);

$poster_array = array();
if(count($posts)>0) foreach (array_keys($posts) as $id) {
	$poster_array[$posts[$id]->getVar('uid')] = 1;
}

$xoops_pagetitle = $xoopsModule->getVar('name'). ' - ' ._MD_VIEWALLPOSTS;
$xoopsOption['xoops_pagetitle']= $xoops_pagetitle;
$xoopsOption['xoops_module_header']= $xoops_module_header;
$xoopsOption['template_main'] = 'iforum_viewpost.html';
include ICMS_ROOT_PATH."/header.php";
if($xoopsTpl->xoops_canUpdateFromFile() && is_dir(XOOPS_THEME_PATH."/".$xoopsConfig['theme_set']."/templates/".$xoopsModule->getVar("dirname"))){
	$xoopsTpl->assign('iforum_template_path', XOOPS_THEME_PATH."/".$xoopsConfig['theme_set']."/templates/".$xoopsModule->getVar("dirname"));
}else{
	$xoopsTpl->assign('iforum_template_path', ICMS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/templates");
}

if(!empty($forum_id)){
	if (!$forum_handler->getPermission($forum_obj, "view")){
	    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
	    exit();
	}
	if($forum_obj->getVar('parent_forum')){
		$parent_forum_obj =& $forum_handler->get($forum_obj->getVar('parent_forum'), array("forum_name"));
		$parentforum = array("id"=>$forum_obj->getVar('parent_forum'), "name"=>$parent_forum_obj->getVar("forum_name"));
		unset($parent_forum_obj);
		$xoopsTpl->assign_by_ref("parentforum", $parentforum);
	}
	$xoopsTpl->assign('forum_name', $forum_obj->getVar('forum_name'));
	$xoopsTpl->assign('forum_moderators', $forum_obj->disp_forumModerators());

	$xoops_pagetitle = $forum_obj->getVar('forum_name'). ' - ' ._MD_VIEWALLPOSTS. ' [' . $xoopsModule->getVar('name'). ']';
	$xoopsTpl->assign("forum_id", $forum_obj->getVar('forum_id'));

	if(!empty($xoopsModuleConfig['rss_enable'])){
		$xoops_module_header .= '<link rel="alternate" type="application/xml+rss" title="'.$xoopsModule->getVar('name').'-'.$forum_obj->getVar('forum_name').'" href="'.ICMS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/rss.php?f='.$forum_id.'" />';
	}
}elseif(!empty($xoopsModuleConfig['rss_enable'])){
	$xoops_module_header .= '<link rel="alternate" type="application/xml+rss" title="'.$xoopsModule->getVar('name').'" href="'.ICMS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/rss.php" />';
}
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);
$xoopsTpl->assign('xoops_pagetitle', $xoops_pagetitle);

$userid_array=array();
if(count($poster_array)>0){
	$member_handler =& xoops_gethandler('member');
	$userid_array = array_keys($poster_array);
	$user_criteria = "(".implode(",",$userid_array).")";
	$users = $member_handler->getUsers( new Criteria('uid', $user_criteria, 'IN'), true);
}else{
	$user_criteria = '';
	$users = null;
}

if ($xoopsModuleConfig['wol_enabled']){
	$online = array();
	if(!empty($user_criteria)){
		$online_handler =& icms_getmodulehandler('online', basename( dirname( __FILE__ ) ), 'iforum' );
		$online_handler->init($forum_id);
		$online_full = $online_handler->getAll(new Criteria('online_uid', $user_criteria, 'IN'));
		if(is_array($online_full)&&count($online_full)>0){
			foreach ($online_full as $thisonline) {
			    if ($thisonline['online_uid'] > 0) $online[$thisonline['online_uid']] = 1;
			}
		}
	}
}

if($xoopsModuleConfig['groupbar_enabled']){
	$groups_disp = array();
	$groups = $member_handler->getGroups();
	$count = count($groups);
	for ($i = 0; $i < $count; $i++) {
		$groups_disp[$groups[$i]->getVar('groupid')] = $groups[$i]->getVar('name');
	}
	unset($groups);
}

$viewtopic_users = array();

if(count($userid_array)>0){
	$user_handler =& icms_getmodulehandler('user', basename( dirname( __FILE__ ) ), 'iforum' );
	$user_handler->setUsers($users);
	$user_handler->setGroups($groups_disp);
	$user_handler->setStatus($online);
	foreach($userid_array as $userid){
		$viewtopic_users[$userid] =& $user_handler->get($userid);
	}
}
unset($users);
unset($groups_disp);

$pn =0;
$topic_handler = &icms_getmodulehandler('topic', basename( dirname( __FILE__ ) ), 'iforum' );
static $suspension = array();
foreach(array_keys($posts) as $id){
	$pn++;

	$post =& $posts[$id];
    $post_title = $post->getVar('subject');

    if ( $posticon = $post->getVar('icon') ){
        $post_image = '<img src="' . ICMS_URL . '/images/subject/' . htmlspecialchars($posticon) . '" alt="" />';
    }else{
        $post_image = '<img src="' . ICMS_URL . '/images/icons/no_posticon.gif" alt="" />';
    }
    if($post->getVar('uid')>0 && isset($viewtopic_users[$post->getVar('uid')])) {
	    $poster = $viewtopic_users[$post->getVar('uid')];
    }
    else $poster= array(
    	'uid' => 0,
        'name' => $post->getVar('poster_name')?$post->getVar('poster_name'):$myts->HtmlSpecialChars($xoopsConfig['anonymous']),
        'link' => $post->getVar('poster_name')?$post->getVar('poster_name'):$myts->HtmlSpecialChars($xoopsConfig['anonymous'])
  	);
    if ($isadmin || $post->checkIdentity()) {
        $post_text = $post->getVar('post_text');
        $post_attachment = $post->displayAttachment();
    } elseif ($xoopsModuleConfig['enable_karma'] && $post->getVar('post_karma') > $user_karma) {
        $post_text = "<div class='karma'>" . sprintf(_MD_KARMA_REQUIREMENT, $user_karma, $post->getVar('post_karma')) . "</div>";
        $post_attachment = '';
    } elseif (
        	$xoopsModuleConfig['allow_require_reply']
        	&& $post->getVar('require_reply')
    	) {
        $post_text = "<div class='karma'>" . _MD_REPLY_REQUIREMENT . "</div>";
        $post_attachment = '';
    } else {
        $post_text = $post->getVar('post_text');
        $post_attachment = $post->displayAttachment();
    }

    $thread_buttons = array();
    
	if($GLOBALS["xoopsModuleConfig"]['enable_permcheck']){
	
		if(!isset($suspension[$post->getVar('forum_id')])){
			$moderate_handler =& icms_getmodulehandler('moderate', basename( dirname( __FILE__ ) ), 'iforum' );
			$suspension[$post->getVar('forum_id')] = $moderate_handler->verifyUser(-1,"",$post->getVar('forum_id'));
		}
		
	    if (!$suspension[$post->getVar('forum_id')] && $post->checkIdentity() && $post->checkTimelimit('edit_timelimit')
	    	|| $isadmin) 
	    {
	        $thread_buttons['edit']['image'] = iforum_displayImage($forumImage['p_edit'], _EDIT);
	        $thread_buttons['edit']['link'] = "edit.php?forum=" .$post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
	        $thread_buttons['edit']['name'] = _EDIT;
	    }
	
	    if ( (!$suspension[$post->getVar('forum_id')] && $post->checkIdentity() && $post->checkTimelimit('delete_timelimit')) 
	    	|| $isadmin )
	    {
	        $thread_buttons['delete']['image'] = iforum_displayImage($forumImage['p_delete'], _DELETE);
	        $thread_buttons['delete']['link'] = "delete.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
	        $thread_buttons['delete']['name'] = _DELETE;
	    }
	    if (!$suspension[$post->getVar('forum_id')] && is_object($xoopsUser)) {
	        $thread_buttons['reply']['image'] = iforum_displayImage($forumImage['p_reply'], _MD_REPLY);
	        $thread_buttons['reply']['link'] = "reply.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
	        $thread_buttons['reply']['name'] = _MD_REPLY;

	        $thread_buttons['quote']['image'] = iforum_displayImage($forumImage['p_quote'], _MD_QUOTE);
	        $thread_buttons['quote']['link'] = "reply.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id') . "&amp;quotedac=1";
	        $thread_buttons['quote']['name'] = _MD_QUOTE;
	    }
    
	}else{
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

    if (!$isadmin && $xoopsModuleConfig['reportmod_enabled']) {
        $thread_buttons['report']['image'] = iforum_displayImage($forumImage['p_report'], _MD_REPORT);
        $thread_buttons['report']['link'] = "report.php?forum=" . $post->getVar('forum_id') . "&amp;topic_id=" . $post->getVar('topic_id');
        $thread_buttons['report']['name'] = _MD_REPORT;
    }
    $thread_action = array();

    $xoopsTpl->append('posts',
    		array(
    			'post_id' 		=> $post->getVar('post_id'),
    			'topic_id' 		=> $post->getVar('topic_id'),
    			'forum_id' 		=> $post->getVar('forum_id'),
                'post_date' 	=> formatTimestamp($post->getVar('post_time')),
                'post_image' 	=> $post_image,
                'post_title' 	=> $post_title,
                'post_text' 	=> $post_text,
                'post_attachment'	=> $post_attachment,
                'post_edit'			=> $post->displayPostEdit(),
                'post_no' 			=> $start+$pn,
                'post_signature'	=> ($post->getVar('attachsig'))?@$poster["signature"]:"",
	            'poster_ip' 		=> ($isadmin && $xoopsModuleConfig['show_ip'])?long2ip($post->getVar('poster_ip')):"",
		    	'thread_action' 	=> $thread_action,
                'thread_buttons' 	=> $thread_buttons,
                'poster' 			=> $poster
       		)
  	);

    unset($thread_buttons);
	unset($poster);
}
unset($viewtopic_users);
unset($forums);

if(!empty($xoopsModuleConfig['show_jump'])){
	$xoopsTpl->assign('forum_jumpbox', iforum_make_jumpbox($forum_id));
}

if ( $postCount > $post_perpage ) {
    include ICMS_ROOT_PATH.'/class/pagenav.php';
    $nav = new XoopsPageNav($postCount, $post_perpage, $start, "start", 'forum='.$forum_id.'&amp;viewmode='.$viewmode.'&amp;type='.$type.'&amp;uid='.$uid.'&amp;order='.$order."&amp;mode=".$mode);
    $xoopsTpl->assign('pagenav', $nav->renderNav(4));
} else {
    $xoopsTpl->assign('pagenav', '');
}

$xoopsTpl->assign('lang_forum_index', sprintf(_MD_FORUMINDEX,htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
$xoopsTpl->assign('folder_topic', iforum_displayImage($forumImage['folder_topic']));

switch($type){
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
if($uid>0){
	$lang_title .= ' ('.XoopsUser::getUnameFromId($uid).')';
}	
$xoopsTpl->assign('lang_title',$lang_title);
$xoopsTpl->assign('p_up',iforum_displayImage($forumImage['p_up'],_MD_TOP));
$xoopsTpl->assign('groupbar_enable', $xoopsModuleConfig['groupbar_enabled']);
$xoopsTpl->assign('anonymous_prefix', $xoopsModuleConfig['anonymous_prefix']);
$xoopsTpl->assign('down',iforum_displayImage($forumImage['doubledown']));
$xoopsTpl->assign('down2',iforum_displayImage($forumImage['down']));
$xoopsTpl->assign('up',iforum_displayImage($forumImage['up']));
$xoopsTpl->assign('printer',iforum_displayImage($forumImage['printer']));
$xoopsTpl->assign('personal',iforum_displayImage($forumImage['personal']));
$xoopsTpl->assign('post_content',iforum_displayImage($forumImage['post_content']));

$all_link = "viewall.php?forum=".$forum_id."&amp;start=$start";
$post_link = "viewpost.php?forum=".$forum_id;
$newpost_link = "viewpost.php?forum=".$forum_id."&amp;new=1";
$digest_link = "viewall.php?forum=".$forum_id."&amp;start=$start&amp;type=digest";
$unreplied_link = "viewall.php?forum=".$forum_id."&amp;start=$start&amp;type=unreplied";
$unread_link = "viewall.php?forum=".$forum_id."&amp;start=$start&amp;type=unread";

$xoopsTpl->assign('all_link', $all_link);
$xoopsTpl->assign('post_link', $post_link);
$xoopsTpl->assign('newpost_link', $newpost_link);
$xoopsTpl->assign('digest_link', $digest_link);
$xoopsTpl->assign('unreplied_link', $unreplied_link);
$xoopsTpl->assign('unread_link', $unread_link);

$viewmode_options = array();
if($viewmode=="compact"){
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=flat&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_FLAT);
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=left&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_MD_LEFT);
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=right&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_MD_RIGHT);
	if ($order == 'DESC') {
		$viewmode_options[]= array("link"=>"viewpost.php?viewmode=compact&amp;order=ASC&amp;forum=".$forum_id,"title"=>_OLDESTFIRST);
	} else {
		$viewmode_options[]= array("link"=>"viewpost.php?viewmode=compact&amp;order=DESC&amp;forum=".$forum_id,"title"=>_NEWESTFIRST);
	}
}elseif($viewmode=="left"){
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=flat&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_FLAT);
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=compact&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_MD_COMPACT);
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=right&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_MD_RIGHT);
	if ($order == 'DESC') {
		$viewmode_options[]= array("link"=>"viewpost.php?viewmode=left&amp;order=ASC&amp;forum=".$forum_id,"title"=>_OLDESTFIRST);
	} else {
		$viewmode_options[]= array("link"=>"viewpost.php?viewmode=left&amp;order=DESC&amp;forum=".$forum_id,"title"=>_NEWESTFIRST);
	}
}elseif($viewmode=="right"){
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=flat&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_FLAT);
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=compact&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_MD_COMPACT);
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=left&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_MD_LEFT);
	if ($order == 'DESC') {
		$viewmode_options[]= array("link"=>"viewpost.php?viewmode=right&amp;order=ASC&amp;forum=".$forum_id,"title"=>_OLDESTFIRST);
	} else {
		$viewmode_options[]= array("link"=>"viewpost.php?viewmode=rightt&amp;order=DESC&amp;forum=".$forum_id,"title"=>_NEWESTFIRST);
	}
}else{
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=compact&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_MD_COMPACT);
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=left&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_MD_LEFT);
	$viewmode_options[]= array("link"=>"viewpost.php?viewmode=right&amp;order=".$order."&amp;forum=".$forum_id,	"title"=>_MD_RIGHT);
	if ($order == 'DESC') {
		$viewmode_options[]= array("link"=>"viewpost.php?viewmode=flat&amp;order=ASC&amp;forum=".$forum_id,"title"=>_OLDESTFIRST);
	} else {
		$viewmode_options[]= array("link"=>"viewpost.php?viewmode=flat&amp;order=DESC&amp;forum=".$forum_id,"title"=>_NEWESTFIRST);
	}
}

$xoopsTpl->assign('viewmode_compact', ($viewmode=="compact")?1:0);
$xoopsTpl->assign('viewmode_left', ($viewmode=="left")?1:0);
$xoopsTpl->assign('viewmode_right', ($viewmode=="right")?1:0);
$xoopsTpl->assign_by_ref('viewmode_options', $viewmode_options);
$xoopsTpl->assign('menumode',$menumode);
$xoopsTpl->assign('menumode_other',$menumode_other);

$xoopsTpl->assign('viewer_level', ($isadmin)?2:(is_object($xoopsUser)?1:0) );
$xoopsTpl->assign('uid', $uid);
$xoopsTpl->assign('mode', $mode);
$xoopsTpl->assign('type', $type);

include ICMS_ROOT_PATH.'/footer.php';
?>