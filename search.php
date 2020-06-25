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
iforum_load_lang_file("search");
$icmsConfigSearch = icms::$config->getConfigsByCat(ICMS_CONF_SEARCH);
if ($icmsConfigSearch['enable_search'] != 1)
{
	header('Location: '.ICMS_URL.'/modules/'.basename(__DIR__).'/index.php');
	exit();
}
 
$icmsConfig['module_cache'][$icmsModule->getVar('mid')] = 0;
$xoopsOption['template_main'] = 'iforum_search.html';
include ICMS_ROOT_PATH.'/header.php';
 
include_once ICMS_ROOT_PATH.'/modules/'.basename(__DIR__).'/include/search.inc.php';
$limit = icms::$module->config['topics_per_page'];
 
$queries = array();
$andor = "";
$start = 0;
$uid = 0;
$forum = 0;
$sortby = 'p.post_time DESC';
$subquery = "";
$searchin = "both";
$sort = "";
$since = isset($_POST['since']) ? $_POST['since'] :
 (isset($_GET['since']) ? $_GET['since'] : null);
$next_search['since'] = $since;
$term = isset($_POST['term']) ? $_POST['term'] :
 (isset($_GET['term']) ? $_GET['term'] : null);
$uname = isset($_POST['uname']) ? $_POST['uname'] :
 (isset($_GET['uname']) ? $_GET['uname'] : null);
 
if (icms::$module->config['wol_enabled'])
	{
	$online_handler = icms_getmodulehandler('online', basename(__DIR__), 'iforum' );
	$online_handler->init(0);
}
 
$icmsTpl->assign("forumindex", sprintf(_MD_FORUMINDEX, htmlspecialchars($icmsConfig['sitename'], ENT_QUOTES)));
$icmsTpl->assign("img_folder", iforum_displayImage($forumImage['folder_topic']));
 
if (!empty($_POST['submit']) || !empty($_GET['submit']) || !empty($uname) || !empty($term))
{
	$start = isset($_GET['start']) ? $_GET['start'] :
	 0;
	$forum = isset($_POST['forum']) ? $_POST['forum'] :
	 (isset($_GET['forum']) ? $_GET['forum'] : null);
	if (empty($forum) or $forum == 'all' or (is_array($forum) and in_array('all', $forum)))
	{
		$forum = array();
	}
	elseif(!is_array($forum))
	{
		$forum = array_map("intval", explode(",", $forum));
	}
	$next_search['forum'] = implode(",", $forum);
	 
	$addterms = isset($_POST['andor']) ? $_POST['andor'] :
	 (isset($_GET['andor']) ? $_GET['andor'] : "");
	$next_search['andor'] = $addterms;
	 
	if (!in_array(strtolower($addterms), array("or", "and", "exact")))
		{
		$andor = "AND";
	}
	else
	{
		$andor = strtoupper($addterms);
	}
	 
	$uname_required = false;
	$search_username = $uname;
	$search_username = trim($search_username);
	$next_search['uname'] = $search_username;
	if (!empty($search_username) )
	{
		$uname_required = true;
		$search_username = $myts->addSlashes($search_username);
		if (!$result = icms::$xoopsDB->query("SELECT uid FROM ".icms::$xoopsDB->prefix("users")." WHERE uname LIKE '%$search_username%'") )
		{
			redirect_header('search.php', 1, _MD_ERROROCCURED);
			exit();
		}
		$uid = array();
		while ($row = icms::$xoopsDB->fetchArray($result))
		{
			$uid[] = $row['uid'];
		}
	}
	else
	{
		$uid = 0;
	}
	 
	$next_search['term'] = $term;
	$query = trim($term);
	 
	if ($andor != "EXACT" )
	{
		$ignored_queries = array(); // holds kewords that are shorter than allowed minmum length
		$temp_queries = preg_split('/[\s,]+/', $query);
		foreach ($temp_queries as $q)
		{
			$q = trim($q);
			if (strlen($q) >= $icmsConfigSearch['keyword_min'])
			{
				$queries[] = $myts->addSlashes($q);
			}
			else
			{
				$ignored_queries[] = $myts->addSlashes($q);
			}
		}
		if (!$uname_required && count($queries) == 0)
		{
			redirect_header('search.php', 2, sprintf(_SR_KEYTOOSHORT, $icmsConfigSearch['keyword_min']));
			exit();
		}
	}
	else
	{
		//$query = trim($query);
		if (!$uname_required && (strlen($query) < $icmsConfigSearch['keyword_min']))
		{
			redirect_header('search.php', 2, sprintf(_SR_KEYTOOSHORT, $icmsConfigSearch['keyword_min']));
			exit();
		}
		$queries = array($myts->addSlashes($query));
	}
	 
	// entries must be lowercase
	$allowed = array('p.post_time desc', 't.topic_title', 't.topic_views', 't.topic_replies', 'f.forum_name', 'u.uname');
	 
	$sortby = isset($_POST['sortby']) ? $_POST['sortby'] :
	 (isset($_GET['sortby']) ? $_GET['sortby'] : null);
	$next_search['sortby'] = $sortby;
	$sortby = (in_array(strtolower($sortby), $allowed)) ? $sortby :
	 'p.post_time DESC';
	$searchin = isset($_POST['searchin']) ? $_POST['searchin'] :
	 (isset($_GET['searchin']) ? $_GET['searchin'] : 'both');
	$next_search['searchin'] = $searchin;
	if (!empty($since))
	{
		$subquery = ' AND p.post_time >= ' . (time() - iforum_getSinceTime($since));
	}
	 
	if ($uname_required && (!$uid || count($uid) < 1)) $result = false;
	else $results = iforum_search($queries, $andor, $limit, $start, $uid, $forum, $sortby, $searchin, $subquery);
	 
	if (count($results) < 1 )
	{
		$icmsTpl->assign("lang_nomatch", _SR_NOMATCH);
	}
	else
	{
		foreach ($results as $row)
		{
			$icmsTpl->append('results', array('forum_name' => icms_core_DataFilter::htmlSpecialchars($row['forum_name']), 'forum_link' => $row['forum_link'], 'link' => $row['link'], 'title' => $row['title'], 'poster' => $row['poster'], 'post_time' => formatTimestamp($row['time'], "m")));
		}
		unset($results);
		 
		if (count($next_search) > 0)
		{
			$items = array();
			foreach($next_search as $para => $val)
			{
				if (!empty($val)) $items[] = "$para=$val";
			}
			if (count($items) > 0) $paras = implode("&", $items);
			unset($next_search);
			unset($items);
		}
		$search_url = ICMS_URL.'/modules/'.$icmsModule->getVar('dirname')."/search.php?".$paras;
		 
		$next_results = iforum_search($queries, $andor, 1, $start + $limit, $uid, $forum, $sortby, $searchin, $subquery);
		$next_count = count($next_results);
		$has_next = false;
		if (is_array($next_results) && $next_count > 0)
		{
			$has_next = true;
		}
		if (false != $has_next)
		{
			$next = $start + $limit;
			$queries = implode(',', $queries);
			$search_url_next = $search_url."&start=$next";
			$search_next = '<a href="'.htmlspecialchars($search_url_next).'">'._SR_NEXT.'</a>';
			$icmsTpl->assign("search_next", $search_next);
		}
		if ($start > 0 )
		{
			$prev = $start - $limit;
			$search_url_prev = $search_url."&start=$prev";
			$search_prev = '<a href="'.htmlspecialchars($search_url_prev).'">'._SR_PREVIOUS.'</a>';
			$icmsTpl->assign("search_prev", $search_prev);
		}
	}
	 
	$search_info = _SR_KEYWORDS.": ".icms_core_DataFilter::htmlSpecialchars($term);
	if ($uname_required)
	{
		if ($search_info) $search_info .= "<br />";
		$search_info .= _MD_USERNAME.": ".icms_core_DataFilter::htmlSpecialchars($search_username);
	}
	$icmsTpl->assign("search_info", $search_info);
}
 
$forumperms = icms_getmodulehandler('permission', basename(__DIR__), 'iforum' );
$allowed_forums = $forumperms->getPermissions('forum');
 
$forum_handler = icms_getmodulehandler('forum', basename(__DIR__), 'iforum' );
$forum_array = $forum_handler->getForums();
 
$select_forum = '<select name="forum[]" size="5" multiple="multiple">';
$select_forum .= '<option value="all">'._MD_SEARCHALLFORUMS.'</option>';
foreach ($forum_array as $key => $forum)
{
	if (in_array($forum->getVar('forum_id'), array_keys($allowed_forums)))
	{
		$select_forum .= '<option value="'.$forum->getVar('forum_id').'">'.$forum->getVar('forum_name').'</option>';
	}
}
$select_forum .= '</select>';
$icmsTpl->assign_by_ref("forum_selection_box", $select_forum);
$select_since = iforum_sinceSelectBox(icms::$module->config['since_default']);
$icmsTpl->assign_by_ref("since_selection_box", $select_since);
 
if ($icmsConfigSearch['keyword_min'] > 0)
{
	$icmsTpl->assign("search_rule", sprintf(_SR_KEYIGNORE, $icmsConfigSearch['keyword_min']));
}
 
include ICMS_ROOT_PATH.'/footer.php';