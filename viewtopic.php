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

$topic_id = isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;
$post_id = !empty($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$forum_id = !empty($_GET['forum']) ? intval($_GET['forum']) : 0;
$move = isset($_GET['move'])? strtolower($_GET['move']) : '';
$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;
$type = (!empty($_GET['type']) && in_array($_GET['type'], array("active", "pending", "deleted")))? $_GET['type'] : "";
$mode = !empty($_GET['mode']) ? intval($_GET['mode']) : (!empty($type)?2:0);

if ( !$topic_id && !$post_id ) {
	$redirect = empty($forum_id)?"index.php":'viewforum.php?forum='.$forum_id;
    redirect_header($redirect, 2, _MD_ERRORTOPIC);
}

$topic_handler =& icms_getmodulehandler('topic', basename( dirname( __FILE__ ) ), 'iforum' );
if ( !empty($post_id) ) {
    $forumtopic =& $topic_handler->getByPost($post_id);
} elseif(!empty($move)) {
    $forumtopic =& $topic_handler->getByMove($topic_id, ($move == "prev")?-1:1, $forum_id);
    $topic_id = $forumtopic->getVar("topic_id");
} else {
    $forumtopic =& $topic_handler->get($topic_id);
}
if ( !is_object($forumtopic) || !$topic_id = $forumtopic->getVar('topic_id') ) {
    redirect_header('viewforum.php?forum='.$forum_id, 2, _MD_ERRORTOPIC);
}
$forum_id = $forumtopic->getVar('forum_id');
$forum_handler =& icms_getmodulehandler('forum', basename( dirname( __FILE__ ) ), 'iforum' );
$viewtopic_forum =& $forum_handler->get($forum_id);

$isadmin = iforum_isAdmin($viewtopic_forum);

if(!$isadmin && $forumtopic->getVar('approved')<0 ){
    redirect_header("viewforum.php?forum=".$forum_id,2,_MD_NORIGHTTOVIEW);
    exit();
}
if (!$forum_handler->getPermission($viewtopic_forum)){
    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
    exit();
}
/* Only admin has access to admin mode */
if(!$isadmin){
	$type = "";
	$mode = 0;
}
if($mode){
	$_GET['viewmode'] = "flat";
}

$perm =& icms_getmodulehandler('permission', basename( dirname( __FILE__ ) ), 'iforum' );
$permission_set = $perm->getPermissions('forum', $forum_id);

if (!$topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "view")){
    redirect_header("viewforum.php?forum=".$forum_id, 2, _MD_NORIGHTTOVIEW);
    exit();
}

$karma_handler =& icms_getmodulehandler('karma', basename( dirname( __FILE__ ) ), 'iforum' );
$user_karma = $karma_handler->getUserKarma();

$valid_modes = array("flat", "thread", "compact", "left", "right");
$viewmode_cookie = iforum_getcookie("V");
if(isset($_GET['viewmode']) && in_array($_GET['viewmode'], $valid_modes)) {
	iforum_setcookie("V", $_GET['viewmode'], $forumCookie['expire']);
}
$viewmode = isset($_GET['viewmode'])? $_GET['viewmode'] : 
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
$order = (isset($_GET['order']) && in_array(strtoupper($_GET['order']),array("DESC","ASC")))?$_GET['order']:"ASC";
			/*
			(
				(is_object($xoopsUser) && $xoopsUser->getVar('uorder')==1)?
				"DESC":"ASC"
			);
			*/

$total_posts = $topic_handler->getPostCount($forumtopic, $type);

if ($viewmode == "thread") {
    $xoopsOption['template_main'] =  'iforum_viewtopic_thread.html';
    if(!empty($xoopsModuleConfig["posts_for_thread"]) && $total_posts > $xoopsModuleConfig["posts_for_thread"]) {
	    redirect_header("viewtopic.php?topic_id=$topic_id&amp;viewmode=flat", 2, _MD_EXCEEDTHREADVIEW);
	    exit();
    }
	$postsArray = $topic_handler->getAllPosts($forumtopic, $order, $total_posts, $start, 0, $type);
}elseif ($viewmode == "left") {
    $xoopsOption['template_main'] =  'iforum_viewtopic_left.html';
    $postsArray = $topic_handler->getAllPosts($forumtopic, $order, $xoopsModuleConfig['posts_per_page'], $start, $post_id, $type);
}elseif ($viewmode == "right") {
    $xoopsOption['template_main'] =  'iforum_viewtopic_right.html';
    $postsArray = $topic_handler->getAllPosts($forumtopic, $order, $xoopsModuleConfig['posts_per_page'], $start, $post_id, $type);
} else {
    $xoopsOption['template_main'] =  'iforum_viewtopic_flat.html';
    $postsArray = $topic_handler->getAllPosts($forumtopic, $order, $xoopsModuleConfig['posts_per_page'], $start, $post_id, $type);
}

// cookie should be handled before calling ICMS_ROOT_PATH."/header.php", otherwise it won't work for cache
//$topic_lastread = iforum_getcookie('LT',true);
//if ( empty($topic_lastread[$topic_id]) ) {
    $forumtopic->incrementCounter();
//}
/*
$topic_lastread[$topic_id] = time();
iforum_setcookie("LT", $topic_lastread);
*/
iforum_setRead("topic", $topic_id, $forumtopic->getVar("topic_last_post_id"));

if(!empty($xoopsModuleConfig['rss_enable'])){
	$xoops_module_header .= '<link rel="alternate" type="application/rss+xml" title="'.$xoopsModule->getVar('name').'-'.$viewtopic_forum->getVar('forum_name').'" href="'.ICMS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/rss.php?f='.$viewtopic_forum->getVar("forum_id").'" />';
}
$xoops_pagetitle = $forumtopic->getVar('topic_title') . ' [' . $xoopsModule->getVar('name') ." - ". $viewtopic_forum->getVar('forum_name') . "]";

$xoopsOption['xoops_pagetitle']= $xoops_pagetitle;
$xoopsOption['xoops_module_header']= $xoops_module_header;
include ICMS_ROOT_PATH."/header.php";
if($xoopsTpl->xoops_canUpdateFromFile() && is_dir(XOOPS_THEME_PATH."/".$xoopsConfig['theme_set']."/templates/".$xoopsModule->getVar("dirname"))){
	$xoopsTpl->assign('iforum_template_path', XOOPS_THEME_PATH."/".$xoopsConfig['theme_set']."/templates/".$xoopsModule->getVar("dirname"));
}else{
	$xoopsTpl->assign('iforum_template_path', ICMS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/templates");
}
$xoopsTpl->assign('xoops_pagetitle', $xoops_pagetitle);
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);

if ($xoopsModuleConfig['wol_enabled']){
	$online_handler =& icms_getmodulehandler('online', basename( dirname( __FILE__ ) ), 'iforum' );
	$online_handler->init($viewtopic_forum, $forumtopic);
    $xoopsTpl->assign('online', $online_handler->show_online());
}

if($viewtopic_forum->getVar('parent_forum') > 0){
    $q = "select forum_name from ".$xoopsDB->prefix('bb_forums')." WHERE forum_id=".$viewtopic_forum->getVar('parent_forum');
    $row = $xoopsDB->fetchArray($xoopsDB->query($q));
    $xoopsTpl->assign(array('parent_forum' => $viewtopic_forum->getVar('parent_forum'), 'parent_name' => $myts->htmlSpecialChars($row['forum_name'])));
}

$topic_prefix = "";
if($forumtopic->getVar('topic_subject')
 && !empty($xoopsModuleConfig['subject_prefix'])
 && $viewtopic_forum->getVar("allow_subject_prefix")
){
    $subjectpres = explode(',', $xoopsModuleConfig['subject_prefix']);
	$topic_prefix = $subjectpres[intval($forumtopic->getVar('topic_subject'))]." ";
}
$xoopsTpl->assign(array(
	'topic_title' 		=> '<a href="'.$forumUrl['root'].'/viewtopic.php?viewmode='.$viewmode.'&amp;type='.$type.'&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id.'">'. $topic_prefix.$forumtopic->getVar('topic_title').'</a>', 
	'forum_name' 		=> $viewtopic_forum->getVar('forum_name'), 
	'lang_nexttopic' 	=> _MD_NEXTTOPIC, 
	'lang_prevtopic' 	=> _MD_PREVTOPIC
	));

$category_handler =& icms_getmodulehandler("category", basename( dirname( __FILE__ ) ), 'iforum' );
$category_obj =& $category_handler->get($viewtopic_forum->getVar("cat_id"), array("cat_title"));
$xoopsTpl->assign('category', array("id" => $viewtopic_forum->getVar("cat_id"), "title" => $category_obj->getVar('cat_title')));

$xoopsTpl->assign('folder_topic', iforum_displayImage($forumImage['folder_topic']));

$xoopsTpl->assign('topic_id', $topic_id);
$xoopsTpl->assign('forum_id', $forum_id);

if ($order == 'DESC') {
	$order_current = 'DESC';
    $xoopsTpl->assign(array('order_current' => 'DESC'));
} else {
	$order_current = 'ASC';
    $xoopsTpl->assign(array('order_current' => 'ASC'));
}

$t_new = iforum_displayImage($forumImage['t_new'],_MD_POSTNEW);
$t_reply = iforum_displayImage($forumImage['t_reply'],_MD_REPLY);
$t_extras = iforum_displayImage($forumImage['t_extras'],_MD_EXTRAS);
$t_signup = iforum_displayImage($forumImage['t_signup'],_MD_EXTRAS);

if ($topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "post")){
    $xoopsTpl->assign('forum_post_or_register', "<a href=\"newtopic.php?forum=".$forum_id."\">".$t_new."</a>");
} elseif ( !empty($GLOBALS["xoopsModuleConfig"]["show_reg"]) ) {
    if($forumtopic->getVar('topic_status')){
    	$xoopsTpl->assign('forum_post_or_register', _MD_TOPICLOCKED);
    }elseif ( !is_object($xoopsUser)) {
    	$xoopsTpl->assign('forum_post_or_register', '<a href="'.ICMS_URL.'/user.php?xoops_redirect='.htmlspecialchars($xoopsRequestUri).'">'.$t_signup.'</a>');
	}
} else {
    $xoopsTpl->assign('forum_post_or_register', '');
}
if ($topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "reply")){
    $xoopsTpl->assign('forum_reply', "<a href=\"reply.php?forum=".$forum_id."&amp;topic_id=".$topic_id."\">".$t_reply."</a>");
}
    $xoopsTpl->assign('forum_extras', $t_extras);

$poster_array = array();
$require_reply = false;
foreach ($postsArray as $eachpost) {
	if($eachpost->getVar('uid')>0) $poster_array[$eachpost->getVar('uid')] = 1;
	if($eachpost->getVar('require_reply')>0) $require_reply = true;
}
$userid_array=array();
$online = array();
if(count($poster_array)>0){
	$member_handler =& xoops_gethandler('member');
	$userid_array = array_keys($poster_array);
	$user_criteria = "(".implode(",",$userid_array).")";
	$users = $member_handler->getUsers( new Criteria('uid', $user_criteria, 'IN'), true);
}else{
	$user_criteria = '';
	$users = null;
}

if ($xoopsModuleConfig['wol_enabled'] && $online_handler){
	$online = $online_handler->checkStatus(array_keys($poster_array));
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
	    if (!$viewtopic_forum->getVar('allow_sig')) {
	        $viewtopic_users[$userid]["signature"] = "";
	    }
	}
}
unset($users);
unset($groups_disp);

if($xoopsModuleConfig['allow_require_reply'] && $require_reply){
	if(!empty($xoopsModuleConfig['cache_enabled'])){
		$viewtopic_posters = iforum_getsession("t".$topic_id, true);
		if(!is_array($viewtopic_posters) || count($viewtopic_posters)==0){
			$viewtopic_posters =& $topic_handler->getAllPosters($forumtopic);
			iforum_setsession("t".$topic_id, $viewtopic_posters);
		}
	}else{
		$viewtopic_posters =& $topic_handler->getAllPosters($forumtopic);
	}
}else{
	$viewtopic_posters =array();
}

if ($viewmode == "thread") {
	if(!empty($post_id)){
		$post_handler =& icms_getmodulehandler('post', basename( dirname( __FILE__ ) ), 'iforum' );
		$currentPost = $post_handler -> get($post_id);
		
		if(!$isadmin && $currentPost->getVar('approved')<0 ){
		    redirect_header("viewtopic.php?topic_id=".$topic_id, 2, _MD_NORIGHTTOVIEW);
		    exit();
		}

		$topPost = $topic_handler->getTopPost($topic_id);
	    $top_pid = $topPost->getVar('post_id');
	    unset($topPost);
	}else{
		$currentPost =& $topic_handler->getTopPost($topic_id);
	    $top_pid = $currentPost->getVar('post_id');
	}

    $xoopsTpl->append('topic_posts', $currentPost->showPost($isadmin));
	
    $postArray =& $topic_handler->getPostTree($postsArray);
    if ( count($postArray) > 0 ) {
        foreach ($postArray as $treeItem) {
            $topic_handler->showTreeItem($forumtopic, $treeItem);
            if($treeItem['post_id'] == $post_id) $treeItem['subject'] = '<strong>'.$treeItem['subject'].'</strong>';
            $xoopsTpl->append("topic_trees", array("post_id" => $treeItem['post_id'], "post_time" => $treeItem['post_time'], "post_image" => $treeItem['icon'], "post_title" => $treeItem['subject'], "post_prefix" => $treeItem['prefix'], "poster" => $treeItem['poster']));
        }
        unset($postArray);
    }
}
else {
    foreach ($postsArray as $eachpost) {
    	$xoopsTpl->append('topic_posts', $eachpost->showPost($isadmin));
    }

    if ( $total_posts > $xoopsModuleConfig['posts_per_page'] ) {
        include ICMS_ROOT_PATH.'/class/pagenav.php';
        $nav = new XoopsPageNav($total_posts, $xoopsModuleConfig['posts_per_page'], $start, "start", 'topic_id='.$topic_id.'&amp;viewmode='.$viewmode.'&amp;order='.$order.'&amp;type='.$type."&amp;mode=".$mode);
        $xoopsTpl->assign('forum_page_nav', $nav->renderNav(4));
    } else {
        $xoopsTpl->assign('forum_page_nav', '');
    }
}
unset($postsArray);

$xoopsTpl->assign('topic_print_link', "print.php?form=1&amp;topic_id=$topic_id&amp;forum=".$forum_id."&amp;order=$order&amp;start=$start");

$admin_actions = array();

$ad_merge = "";
$ad_move = "";
$ad_delete = "";
$ad_lock = "";
$ad_unlock = "";
$ad_sticky = "";
$ad_unsticky = "";
$ad_digest = "";
$ad_undigest = "";

$admin_actions['merge'] = array(
	"link" => $forumUrl['root'].'/topicmanager.php?mode=merge&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
	"name" => _MD_MERGETOPIC,
	"image" => $ad_merge);
$admin_actions['move'] = array(
	"link" => $forumUrl['root'].'/topicmanager.php?mode=move&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
	"name" => _MD_MOVETOPIC,
	"image" => $ad_move);
$admin_actions['delete'] = array(
	"link" => $forumUrl['root'].'/topicmanager.php?mode=delete&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
	"name" => _MD_DELETETOPIC,
	"image" => $ad_delete);
if ( !$forumtopic->getVar('topic_status') ){
    $admin_actions['lock'] = array(
    	"link"=>$forumUrl['root'].'/topicmanager.php?mode=lock&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
    	"image"=>$ad_lock,
    	"name"=>_MD_LOCKTOPIC);
}else{
    $admin_actions['unlock'] = array(
    	"link"=>$forumUrl['root'].'/topicmanager.php?mode=unlock&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
    	"image"=>$ad_unlock,
    	"name"=>_MD_UNLOCKTOPIC);
}
if ( !$forumtopic->getVar('topic_sticky') ){
    $admin_actions['sticky'] = array(
    	"link"=>$forumUrl['root'].'/topicmanager.php?mode=sticky&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
    	"image"=>$ad_sticky,
    	"name"=>_MD_STICKYTOPIC);
}else{
    $admin_actions['unsticky'] = array(
    	"link"=>$forumUrl['root'].'/topicmanager.php?mode=unsticky&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
    	"image"=>$ad_unsticky,
    	"name"=>_MD_UNSTICKYTOPIC);
}
if ( !$forumtopic->getVar('topic_digest') ){
    $admin_actions['digest'] = array(
    	"link"=>$forumUrl['root'].'/topicmanager.php?mode=digest&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
    	"image"=>$ad_digest,
    	"name"=>_MD_DIGESTTOPIC);
}else{
    $admin_actions['undigest'] = array(
    	"link"=>$forumUrl['root'].'/topicmanager.php?mode=undigest&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
    	"image"=>$ad_undigest,
    	"name"=>_MD_UNDIGESTTOPIC);
}
$xoopsTpl->assign_by_ref('admin_actions', $admin_actions);

$xoopsTpl->assign('viewer_level', ($isadmin)?2:(is_object($xoopsUser)?1:0) );

if($xoopsModuleConfig['show_permissiontable']){
	$permission_table = $perm->permission_table($permission_set,$viewtopic_forum, $forumtopic->getVar('topic_status'), $isadmin);
	$xoopsTpl->assign_by_ref('permission_table', $permission_table);
	unset($permission_table);
}

///////////////////////////////
// show Poll
if ( $viewtopic_forum->getVar('allow_polls') ):
if(
	(
		$forumtopic->getVar('topic_haspoll')
		&& $topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "vote")
	)
	|| $topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "addpoll")
){
	@include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspoll.php";
	@include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspolloption.php";
	@include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspolllog.php";
	@include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspollrenderer.php";
}

if ( $forumtopic->getVar('topic_haspoll') 
	&& $topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "vote")
){

	$xoopsTpl->assign('topic_poll', 1);
	$poll = new XoopsPoll($forumtopic->getVar('poll_id'));
	$renderer = new XoopsPollRenderer($poll);
	$uid = is_object($xoopsUser)?$xoopsUser->getVar("uid"):0;
	if ( XoopsPollLog::hasVoted($forumtopic->getVar('poll_id'), $_SERVER['REMOTE_ADDR'], $uid) ) {
		$renderer->assignResults($xoopsTpl);
		//pollresults($forumtopic->getVar('poll_id'));
		$xoopsTpl->assign('topic_pollresult', 1);
		setcookie("bb_polls[".$forumtopic->getVar("poll_id")."]", 1);
	} else {
	    $renderer->assignForm($xoopsTpl);
	    $xoopsTpl->assign('lang_vote' , _PL_VOTE);
	    $xoopsTpl->assign('lang_results' , _PL_RESULTS);
		//pollview($forumtopic->getVar('poll_id'));
		setcookie("bb_polls[".$forumtopic->getVar("poll_id")."]", 1);
	}
}
if ($topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "addpoll")
){
	if(!$forumtopic->getVar('topic_haspoll')){	
		if( is_object($xoopsUser) && $xoopsUser->getVar("uid")==$forumtopic->getVar("topic_poster") ){
			$t_poll = iforum_displayImage($forumImage['t_poll'],_MD_ADDPOLL);
			$xoopsTpl->assign('forum_addpoll', "<a href=\"polls.php?op=add&amp;forum=".$forum_id."&amp;topic_id=".$topic_id."\">".$t_poll."</a>&nbsp;");
		}
	}elseif($isadmin
		|| (is_object($poll) && is_object($xoopsUser) && $xoopsUser->getVar("uid")==$poll->getVar("user_id") )
	){
		$poll_edit = "";
	    $poll_delete = "";
	    $poll_restart = "";

		$adminpoll_actions = array();
	    $adminpoll_actions['editpoll'] = array(
	    	"link" => $forumUrl['root'].'/polls.php?op=edit&amp;poll_id='.$forumtopic->getVar('poll_id').'&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
	    	"image" => $poll_edit,
	    	"name" => _MD_EDITPOLL);
	    $adminpoll_actions['deletepoll'] = array(
	    	"link" => $forumUrl['root'].'/polls.php?op=delete&amp;poll_id='.$forumtopic->getVar('poll_id').'&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
	    	"image" => $poll_delete,
	    	"name" => _MD_DELETEPOLL);
	    $adminpoll_actions['restartpoll'] = array(
	    	"link" => $forumUrl['root'].'/polls.php?op=restart&amp;poll_id='.$forumtopic->getVar('poll_id').'&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
	    	"image" => $poll_restart,
	    	"name" => _MD_RESTARTPOLL);

	    $xoopsTpl->assign_by_ref('adminpoll_actions', $adminpoll_actions);	
	    unset($adminpoll_actions);
	}
}
if(isset($poll)) unset($poll);
endif;

$xoopsTpl->assign('p_up',iforum_displayImage($forumImage['p_up'],_MD_TOP));
$xoopsTpl->assign('rating_enable', $xoopsModuleConfig['rating_enabled']);
$xoopsTpl->assign('groupbar_enable', $xoopsModuleConfig['groupbar_enabled']);
$xoopsTpl->assign('anonymous_prefix', $xoopsModuleConfig['anonymous_prefix']);

$xoopsTpl->assign('threaded',iforum_displayImage($forumImage['threaded']));
$xoopsTpl->assign('flat',iforum_displayImage($forumImage['flat']));
$xoopsTpl->assign('left',iforum_displayImage($forumImage['left']));
$xoopsTpl->assign('right',iforum_displayImage($forumImage['right']));
$xoopsTpl->assign('down',iforum_displayImage($forumImage['doubledown']));
$xoopsTpl->assign('down2',iforum_displayImage($forumImage['down']));
$xoopsTpl->assign('up',iforum_displayImage($forumImage['up']));
$xoopsTpl->assign('printer',iforum_displayImage($forumImage['printer']));
$xoopsTpl->assign('personal',iforum_displayImage($forumImage['personal']));
$xoopsTpl->assign('post_content',iforum_displayImage($forumImage['post_content']));

if(!empty($xoopsModuleConfig['rating_enabled'])){
	$xoopsTpl->assign('votes',$forumtopic->getVar('votes'));
	$rating = number_format($forumtopic->getVar('rating')/2, 0);
	if ( $rating < 1 ) {
		$rating_img = iforum_displayImage($forumImage['blank']);
	}else{
		$rating_img  = iforum_displayImage($forumImage['rate'.$rating]);
	}
	$xoopsTpl->assign('rating_img',$rating_img);
	$xoopsTpl->assign('rate1',iforum_displayImage($forumImage['rate1'],_MD_RATE1));
	$xoopsTpl->assign('rate2',iforum_displayImage($forumImage['rate2'],_MD_RATE2));
	$xoopsTpl->assign('rate3',iforum_displayImage($forumImage['rate3'],_MD_RATE3));
	$xoopsTpl->assign('rate4',iforum_displayImage($forumImage['rate4'],_MD_RATE4));
	$xoopsTpl->assign('rate5',iforum_displayImage($forumImage['rate5'],_MD_RATE5));
}

// create jump box
if(!empty($xoopsModuleConfig['show_jump'])){
	$xoopsTpl->assign('forum_jumpbox', iforum_make_jumpbox($forum_id));
}
$xoopsTpl->assign(array('lang_forum_index' => sprintf(_MD_FORUMINDEX,htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)), 'lang_from' => _MD_FROM, 'lang_joined' => _MD_JOINED, 'lang_posts' => _MD_POSTS, 'lang_poster' => _MD_POSTER, 'lang_thread' => _MD_THREAD, 'lang_edit' => _EDIT, 'lang_delete' => _DELETE, 'lang_reply' => _REPLY, 'lang_postedon' => _MD_POSTEDON,'lang_groups' => _MD_GROUPS));

$viewmode_options = array();
if($viewmode=="thread"){
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=flat&amp;topic_id=".$topic_id."&amp;forum=".$forum_id, "title"=>_FLAT);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=compact&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,	"title"=>_MD_COMPACT);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=left&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,	"title"=>_MD_LEFT);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=right&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,	"title"=>_MD_RIGHT);
}elseif($viewmode=="compact"){
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=thread&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,"title"=>_THREADED);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=flat&amp;order=".$order_current."&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,	"title"=>_FLAT);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=left&amp;order=".$order_current."&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,	"title"=>_MD_LEFT);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=right&amp;order=".$order_current."&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,	"title"=>_MD_RIGHT);
		if ($order == 'DESC') {
		$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=compact&amp;order=ASC&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,"title"=>_OLDESTFIRST);
	} else {
		$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=compact&amp;order=DESC&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,"title"=>_NEWESTFIRST);
	}
}elseif($viewmode=="left"){
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=thread&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,"title"=>_THREADED);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=compact&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,	"title"=>_MD_COMPACT);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=flat&amp;order=".$order_current."&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,	"title"=>_FLAT);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=right&amp;order=".$order_current."&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,	"title"=>_MD_RIGHT);
		if ($order == 'DESC') {
		$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=left&amp;order=ASC&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,"title"=>_OLDESTFIRST);
	} else {
		$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=left&amp;order=DESC&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,"title"=>_NEWESTFIRST);
	}
}elseif($viewmode=="right"){
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=thread&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,"title"=>_THREADED);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=compact&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,	"title"=>_MD_COMPACT);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=flat&amp;order=".$order_current."&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,	"title"=>_FLAT);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=left&amp;order=".$order_current."&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,	"title"=>_MD_LEFT);
		if ($order == 'DESC') {
		$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=right&amp;order=ASC&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,"title"=>_OLDESTFIRST);
	} else {
		$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=right&amp;order=DESC&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,"title"=>_NEWESTFIRST);
	}
}else{
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=thread&amp;topic_id=".$topic_id."&amp;forum=".$forum_id,"title"=>_THREADED);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=compact&amp;order=".$order_current."&amp;topic_id=".$topic_id."&amp;forum=".$forum_id, "title"=>_MD_COMPACT);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=left&amp;order=".$order_current."&amp;topic_id=".$topic_id."&amp;forum=".$forum_id, "title"=>_MD_LEFT);
	$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=right&amp;order=".$order_current."&amp;topic_id=".$topic_id."&amp;forum=".$forum_id, "title"=>_MD_RIGHT);
	if ($order == 'DESC') {
		$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=flat&amp;order=ASC&amp;type=$type&amp;topic_id=".$topic_id."&amp;forum=".$forum_id, "title"=>_OLDESTFIRST);
	} else {
		$viewmode_options[]= array("link"=>$forumUrl['root']."/viewtopic.php?viewmode=flat&amp;order=DESC&amp;type=$type&amp;topic_id=".$topic_id."&amp;forum=".$forum_id, "title"=>_NEWESTFIRST);
	}
}
switch($type){
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
$xoopsTpl->assign('topictype', $current_type);

$xoopsTpl->assign('mode', $mode);
$xoopsTpl->assign('type', $type);
$xoopsTpl->assign('viewmode_compact', ($viewmode=="compact")?1:0);
$xoopsTpl->assign('viewmode_left', ($viewmode=="left")?1:0);
$xoopsTpl->assign('viewmode_right', ($viewmode=="right")?1:0);
$xoopsTpl->assign_by_ref('viewmode_options', $viewmode_options);
unset($viewmode_options);
$xoopsTpl->assign('menumode',$menumode);
$xoopsTpl->assign('menumode_other',$menumode_other);

if( !empty($xoopsModuleConfig['quickreply_enabled'])
	&& $topic_handler->getPermission($viewtopic_forum, $forumtopic->getVar('topic_status'), "reply")
){
	include_once ICMS_ROOT_PATH."/class/xoopsformloader.php";

	$forum_form = new XoopsThemeForm(_MD_POSTREPLY, 'quick_reply', "post.php", 'post', true);

	if(!is_object($xoopsUser)){
		$config_handler =& xoops_gethandler('config');
		$user_tray = new XoopsFormElementTray(_MD_ACCOUNT);
		$user_tray->addElement(new XoopsFormText(_MD_NAME, "uname", 26, 255));
		$user_tray->addElement(new XoopsFormPassword(_MD_PASSWORD, "pass", 10, 32));
		$login_checkbox = new XoopsFormCheckBox('', 'login', 1);
		$login_checkbox->addOption(1, _MD_LOGIN);
		$user_tray->addElement($login_checkbox);
		$forum_form->addElement($user_tray, '');
	}

	$quickform = "dhtmltextarea";
	$editor_configs = array();
	$editor_configs["caption"] = _MD_MESSAGEC;
	$editor_configs["name"] ="message";
	$editor_configs["rows"] = 10;
	$editor_configs["cols"] = 60;
	if(!$editor_handler =& xoops_gethandler("editor", true)){
		if(!@include_once ICMS_ROOT_PATH."/class/xoopseditor.php") {
			require_once ICMS_ROOT_PATH."/modules/".basename( dirname( __FILE__ ) )."/class/compat/xoopseditor/xoopseditor.php";
		}
		$editor_handler =& new XoopsEditorHandler();
	}
	$editor_object = & $editor_handler->get($quickform, $editor_configs,"",1);
	$forum_form->addElement($editor_object, true);

	$forum_form->addElement(new XoopsFormHidden('dohtml', 0));
	$forum_form->addElement(new XoopsFormHidden('dosmiley', 1));
	$forum_form->addElement(new XoopsFormHidden('doxcode', 1));
	$forum_form->addElement(new XoopsFormHidden('dobr', 1));
	$forum_form->addElement(new XoopsFormHidden('attachsig', 1));

	$forum_form->addElement(new XoopsFormHidden('isreply', 1));
	
	$forum_form->addElement(new XoopsFormHidden('subject', _MD_RE.': '.$forumtopic->getVar('topic_title', 'e')));
	$forum_form->addElement(new XoopsFormHidden('pid', empty($post_id)?$topic_handler->getTopPostId($topic_id):$post_id));
	$forum_form->addElement(new XoopsFormHidden('topic_id', $topic_id));
	$forum_form->addElement(new XoopsFormHidden('forum', $forum_id));
	$forum_form->addElement(new XoopsFormHidden('viewmode', $viewmode));
	$forum_form->addElement(new XoopsFormHidden('order', $order));
	$forum_form->addElement(new XoopsFormHidden('start', $start));
	
		if( !empty($xoopsModuleConfig['captcha_enabled']) ){
		$forum_form->addElement( new IcmsFormCaptcha("", "topic_{$topic_id}_{$start}") );
		}
	// backward compatible
	if(!class_exists("XoopsSecurity")){
		$post_valid = 1;
		$_SESSION['submit_token'] = $post_valid;
		$forum_form->addElement(new XoopsFormHidden('post_valid', $post_valid));
	}

	$forum_form->addElement(new XoopsFormHidden('notify', -1));
	$forum_form->addElement(new XoopsFormHidden('contents_submit', 1));
	$submit_button = new XoopsFormButton('', 'quick_submit', _SUBMIT, "submit");
	$submit_button->setExtra('onclick="if(document.forms.quick_reply.message.value == \'RE\' || document.forms.quick_reply.message.value == \'\'){ alert(\''._MD_QUICKREPLY_EMPTY.'\'); return false;}else{ return true;}"');
	$button_tray = new XoopsFormElementTray('');
	$button_tray->addElement($submit_button);
	$forum_form->addElement($button_tray);

	$toggles = iforum_getcookie('G', true);
	$display = (in_array('qr', $toggles)) ? 'none;' : 'block;';
    $xoopsTpl->assign('quickreply', array( 'show' => 1, 'display'=>$display, 'icon'=>iforum_displayImage($forumImage['t_qr']), 'form' => $forum_form->render()));
	unset($forum_form);
}else{
	$xoopsTpl->assign('quickreply', array( 'show' => 0));
}

include ICMS_ROOT_PATH.'/footer.php';
?>