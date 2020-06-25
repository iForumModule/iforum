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
 
$forum_id = isset($_POST['forum']) ? (int)$_POST['forum'] :
 0;
$forum_id = isset($_GET['forum']) ? (int)$_GET['forum'] :
 $forum_id;
 
$isadmin = iforum_isAdmin($forum_id);
if (!$isadmin)
{
	redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
	exit();
}
$is_administrator = iforum_isAdmin();
 
$moderate_handler = icms_getmodulehandler('moderate', basename(__DIR__), 'iforum' );
 
if (!empty($_POST["submit"]) && !empty($_POST["expire"]))
{
	if (!empty($_POST["ip"]) && !preg_match("/^([0-9]{1,3}\.){0,3}[0-9]{1,3}$/", $_POST["ip"])) $_POST["ip"] = "";
	if (
	(!empty($_POST["uid"]) && $moderate_handler->getLatest($_POST["uid"]) > (time()+$_POST["expire"] * 3600 * 24))
	|| (!empty($_POST["ip"]) && $moderate_handler->getLatest($_POST["ip"], false) > (time()+$_POST["expire"] * 3600 * 24))
	|| (empty($_POST["uid"]) && empty($_POST["ip"]))
	)
	{
	}
	else
	{
		$moderate_obj = $moderate_handler->create();
		$moderate_obj->setVar("uid", @$_POST["uid"]);
		$moderate_obj->setVar("ip", @$_POST["ip"]);
		$moderate_obj->setVar("forum_id", $forum_id);
		$moderate_obj->setVar("mod_start", time());
		$moderate_obj->setVar("mod_end", time()+$_POST["expire"] * 3600 * 24);
		$moderate_obj->setVar("mod_desc", @$_POST["desc"]);
		if ($res = $moderate_handler->insert($moderate_obj) && !empty($forum_id) && !empty($_POST["uid"]) )
		{
			$uname = XoopsUser::getUnameFromID($_POST["uid"]);
			$post_handler = icms_getmodulehandler("post", basename(__DIR__), 'iforum' );
			$forumpost = $post_handler->create();
			$forumpost->setVar("poster_ip", iforum_getIP());
			$forumpost->setVar("uid", empty($GLOBALS["xoopsUser"])?0:$GLOBALS["xoopsUser"]->getVar("uid"));
			$forumpost->setVar("forum_id", $forum_id);
			$forumpost->setVar("subject", sprintf(_MD_SUSPEND_SUBJECT, $uname, $_POST["expire"]));
			$forumpost->setVar("post_text", sprintf(_MD_SUSPEND_TEXT, '<a href="' . ICMS_URL . '/userinfo.php?uid='.$_POST["uid"].'">'.$uname.'</a>', $_POST["expire"], @$_POST["desc"], formatTimestamp(time()+$_POST["expire"] * 3600 * 24) ));
			$forumpost->setVar("dohtml", 1);
			$forumpost->setVar("dosmiley", 1);
			$forumpost->setVar("doxcode", 1);
			$forumpost->setVar("post_time", time());
			$post_handler->insert($forumpost);
			unset($forumpost);
		}
		if ($_POST["uid"] > 0)
		{
			$online_handler = icms::handler('icms_core_Online');
			$onlines = $online_handler->getAll(new icms_db_criteria_Item("online_uid", $_POST["uid"]));
			if (false != $onlines)
			{
				$online_ip = $onlines[0]["online_ip"];
				$sql = sprintf('DELETE FROM %s WHERE sess_ip = %s', icms::$xoopsDB->prefix('session'), icms::$xoopsDB->quoteString($online_ip));
				if (!$result = icms::$xoopsDB->queryF($sql) )
				{
				}
			}
		}
		if (!empty($_POST["ip"]))
		{
			$sql = 'DELETE FROM '.icms::$xoopsDB->prefix('session').' WHERE sess_ip LIKE '.icms::$xoopsDB->quoteString('%'.$_POST["ip"]);
			if (!$result = icms::$xoopsDB->queryF($sql) )
			{
			}
		}
		redirect_header("moderate.php?forum=$forum_id", 2, _MD_DBUPDATED);
		exit();
	}
}
elseif(!empty($_GET["del"]))
{
	$moderate_obj = $moderate_handler->get($_GET["del"]);
	if ($is_administrator || $moderate_obj->getVar("forum_id") == $forum_id)
	{
		$moderate_handler->delete($moderate_obj, true);
		redirect_header("moderate.php?forum=$forum_id", 2, _MD_DBUPDATED);
		exit();
	}
}
 
$start = isset($_GET['start']) ? (int)$_GET['start'] :
 0;
$sortname = isset($_GET['sort']) ? $_GET['sort'] :
 "";
 
switch($sortname)
{
	case "uid":
	$sort = "uid ASC, ip";
	$order = "ASC";
	break;
	case "start":
	$sort = "mod_start";
	$order = "ASC";
	break;
	case "expire":
	$sort = "mod_end";
	$order = "DESC";
	break;
	//case "expire":
	default:
	$sort = "forum_id ASC, uid ASC, ip";
	$order = "ASC";
	break;
}
 
$criteria = new icms_db_criteria_Item("forum_id", "(0, ".$forum_id.")", "IN");
$criteria->setLimit(icms::$module->config['topics_per_page']);
$criteria->setStart($start);
$criteria->setSort($sort);
$criteria->setOrder($order);
$moderate_objs = $moderate_handler->getObjects($criteria);
$moderate_count = $moderate_handler->getCount($criteria);
 
include ICMS_ROOT_PATH.'/header.php';
if ($forum_id)
{
	$url = 'viewforum.php?forum='.$forum_id;
}
else
{
	$url = 'index.php';
}
echo '<div style="padding: 10px; margin-left:auto; margin-right:auto; text-align:center;"><a href="'.$url.'"><h2>'._MD_SUSPEND_MANAGEMENT.'</h2></a></div>';
 
if (!empty($moderate_count))
{
	$_users = array();
	foreach(array_keys($moderate_objs) as $id)
	{
		$_users[$moderate_objs[$id]->getVar("uid")] = 1;
	}
	$users = iforum_getUnameFromIds(array_keys($_users), icms::$module->config['show_realname'], true);
	 
	echo '
		<table class="outer" cellpadding="6" cellspacing="1" border="0" width="100%" align="center">
		<tr class="head" align="left">
		<td width="5%" align="center" nowrap="nowrap">
		<strong><a href="moderate.php?forum='.$forum_id.'&amp;start='.$start.'&amp;sort=uid" title="Sort by uid">'._MD_SUSPEND_UID.'</a></strong>
		</td>
		<td width="10%" align="center" nowrap="nowrap">
		<strong><a href="moderate.php?forum='.$forum_id.'&amp;start='.$start.'&amp;sort=start" title="Sort by start">'._MD_SUSPEND_START.'</a></strong>
		</td>
		<td width="10%" align="center" nowrap="nowrap">
		<strong><a href="moderate.php?forum='.$forum_id.'&amp;start='.$start.'&amp;sort=expire" title="Sort by expire">'._MD_SUSPEND_EXPIRE.'</a></strong>
		</td>
		<td width="10%" align="center" nowrap="nowrap">
		<strong><a href="moderate.php?forum='.$forum_id.'&amp;start='.$start.'&amp;sort=forum" title="Sort by expire">'._MD_SUSPEND_SCOPE.'</a></strong>
		</td>
		<td align="left">
		<strong>'._MD_SUSPEND_DESC.'</strong>
		</td>
		<td width="5%" align="center" nowrap="nowrap">
		<strong>'._DELETE.'</strong>
		</td>
		</tr>
		';
	 
	foreach(array_keys($moderate_objs) as $id)
	{
		echo '
			<tr>
			<td width="5%" align="center" nowrap="nowrap">
			'.(
		$moderate_objs[$id]->getVar("uid")? (isset($users[$moderate_objs[$id]->getVar("uid")])?$users[$moderate_objs[$id]->getVar("uid")]:$moderate_objs[$id]->getVar("uid"))
		:
		$moderate_objs[$id]->getVar("ip")
		).'
			</td>
			<td width="10%" align="center">
			'.(formatTimestamp($moderate_objs[$id]->getVar("mod_start"))).'
			</td>
			<td width="10%" align="center">
			'.(formatTimestamp($moderate_objs[$id]->getVar("mod_end"))).'
			</td>
			<td width="10%" align="center">
			'.($moderate_objs[$id]->getVar("forum_id")?_MD_FORUM:_ALL).'
			</td>
			<td align="left">
			'.($moderate_objs[$id]->getVar("mod_desc")?$moderate_objs[$id]->getVar("mod_desc"):_NONE).'
			</td>
			<td width="5%" align="center" nowrap="nowrap">
			'. (($is_administrator || $moderate_objs[$id]->getVar("forum_id") == $forum_id)?'<a href="moderate.php?forum='.$forum_id.'&amp;del='.$moderate_objs[$id]->getVar("mod_id").'">'._DELETE.'</a>':' ').'
			</td>
			</tr>
			';
	}
	echo '
		<tr class="head" align="left">
		<td width="5%" align="center" nowrap="nowrap">
		<strong><a href="moderate.php?forum='.$forum_id.'&amp;start='.$start.'&amp;sort=uid" title="Sort by uid">'._MD_SUSPEND_UID.'</a></strong>
		</td>
		<td width="10%" align="center" nowrap="nowrap">
		<strong><a href="moderate.php?forum='.$forum_id.'&amp;start='.$start.'&amp;sort=start" title="Sort by start">'._MD_SUSPEND_START.'</a></strong>
		</td>
		<td width="10%" align="center" nowrap="nowrap">
		<strong><a href="moderate.php?forum='.$forum_id.'&amp;start='.$start.'&amp;sort=expire" title="Sort by expire">'._MD_SUSPEND_EXPIRE.'</a></strong>
		</td>
		<td width="10%" align="center" nowrap="nowrap">
		<strong><a href="moderate.php?forum='.$forum_id.'&amp;start='.$start.'&amp;sort=forum" title="Sort by expire">'._MD_SUSPEND_SCOPE.'</a></strong>
		</td>
		<td align="left">
		<strong>'._MD_SUSPEND_DESC.'</strong>
		</td>
		<td width="5%" align="center" nowrap="nowrap">
		<strong>'._DELETE.'</strong>
		</td>
		</tr>
		';
	if ($moderate_count > icms::$module->config['topics_per_page'])
	{
		include ICMS_ROOT_PATH.'/class/pagenav.php';
		$nav = new XoopsPageNav($all_topics, icms::$module->config['topics_per_page'], $start, "start", 'forum='.$forum_id.'&amp;sort='.$sortname);
		echo '<tr><td colspan="6">'.$nav->renderNav(4).'</td></tr>';
	}
	 
	echo '</table><br /><br />';
}
 
$forum_form = new icms_form_Theme(_ADD, 'suspend', "moderate.php", 'post');
$forum_form->addElement(new icms_form_elements_Text(_MD_SUSPEND_UID, 'uid', 20, 25));
$forum_form->addElement(new icms_form_elements_Text(_MD_SUSPEND_IP, 'ip', 20, 25));
$forum_form->addElement(new icms_form_elements_Text(_MD_SUSPEND_DURATION, 'expire', 20, 25, ''), true);
$forum_form->addElement(new icms_form_elements_Text(_MD_SUSPEND_DESC, 'desc', 50, 255));
$forum_form->addElement(new icms_form_elements_Hidden('forum', $forum_id));
$forum_form->addElement(new icms_form_elements_Button('', 'submit', _SUBMIT, "submit"));
$forum_form->display();
include ICMS_ROOT_PATH.'/footer.php';