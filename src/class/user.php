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
* @version  $Id $
*/

if (!defined("ICMS_ROOT_PATH"))
{
	exit();
}

defined("IFORUM_FUNCTIONS_INI") || include ICMS_ROOT_PATH.'/modules/'.basename(dirname(dirname(__FILE__ ) ) ).'/include/functions.ini.php';
function iforum_getGroupsByUser($uid)
{
	$ret = array();
	if (empty($uid)) return $ret;
	$uid_criteria = is_array($uid)?"IN(".implode(", ", array_map("intval", $uid)).")":
	"=".$uid;
	$sql = 'SELECT groupid, uid FROM '.icms::$xoopsDB->prefix('groups_users_link').' WHERE uid '.$uid_criteria;
	$result = icms::$xoopsDB->query($sql);
	if (!$result)
	{
		return $ret;
	}
	while ($myrow = icms::$xoopsDB->fetchArray($result))
	{
		$ret[$myrow['uid']][] = $myrow['groupid'];
	}
	foreach($ret as $uid2 => $groups)
	{
		$ret[$uid2] = array_unique($groups);
	}

	return $ret;
}

function get_user_level(& $user)
{

	$RPG = $user->getVar('posts');
	$RPGDIFF = $user->getVar('user_regdate');

	$today = time();
	$diff = $today - $RPGDIFF;
	$exp = round($diff / 86400, 0);
	if ($exp <= 0)
	{
		$exp = 1;
	}
	$ppd = round($RPG / $exp, 0);
	$level = pow (log10 ($RPG), 3);
	$ep = floor (100 * ($level - floor ($level)));
	$showlevel = floor ($level + 1);
	$hpmulti = round ($ppd / 6, 1);
	if ($hpmulti > 1.5)
	{
		$hpmulti = 1.5;
	}
	if ($hpmulti < 1)
	{
		$hpmulti = 1;
	}
	$maxhp = $level * 25 * $hpmulti;
	$hp = $ppd / 5;
	if ($hp >= 1)
	{
		$hp = $maxhp;
	}
	else
	{
		$hp = floor ($hp * $maxhp);
	}
	$hp = floor ($hp);
	$maxhp = floor ($maxhp);
	if ($maxhp <= 0)
	{
		$zhp = 1;
	}
	else
	{
		$zhp = $maxhp;
	}
	$hpf = floor (100 * ($hp / $zhp)) - 1;
	$maxmp = ($exp * $level) / 5;
	$mp = $RPG / 3;
	if ($mp >= $maxmp)
	{
		$mp = $maxmp;
	}
	$maxmp = floor ($maxmp);
	$mp = floor ($mp);
	if ($maxmp <= 0)
	{
		$zmp = 1;
	}
	else
	{
		$zmp = $maxmp;
	}
	$mpf = floor (100 * ($mp / $zmp)) - 1;
	if ($hpf >= 98 )
	{
		$hpf = $hpf - 2;
	}
	if ($ep >= 98 )
	{
		$ep = $ep - 2;
	}
	if ($mpf >= 98 )
	{
		$mpf = $mpf - 2;
	}

	$level = array();
	$level['level'] = $showlevel ;
	$level['exp'] = $ep;
	$level['exp_width'] = $ep.'%';
	$level['hp'] = $hp;
	$level['hp_max'] = $maxhp;
	$level['hp_width'] = $hpf.'%';
	$level['mp'] = $mp;
	$level['mp_max'] = $maxmp;
	$level['mp_width'] = $mpf.'%';

	return $level;
}

class User extends icms_core_Object {

	public $user = null;

	function __construct(&$user)
	{
		$this->user = &$user;

		parent::__construct();
	}

	function &getUserbar()
	{
		global $isadmin, $forumImage;

		$user = & $this->user;
		$userbar = array();
		$userbar[] = array("link" => ICMS_URL . "/userinfo.php?uid=" . $user->getVar("uid"), "name" => _PROFILE, "image" => iforum_displayImage($forumImage['personal'], _PROFILE));
		if (is_object(icms::$user))
		{
			$userbar[] = array(
				"link" => ICMS_URL."/pmlite.php?send2=1&to_userid=".$user->getVar("uid"),
				"name" => _MD_PM,
				"image" => iforum_displayImage($forumImage['home'], _MD_PM),
				"pm" => TRUE
			);
		}
		if ($user->getVar('user_viewemail') || (is_object(icms::$user) && icms::$user->isAdmin()) )
		$userbar[] = array("link" => "javascript:void window.open('mailto:" . $user->getVar('email') . "', 'new');", "name" => _MD_EMAIL, "image" => iforum_displayImage($forumImage['email'], _MD_EMAIL));
		if ($user->getVar('url'))
		$userbar[] = array(
			"link" => "javascript:void window.open('" . $user->getVar('url') . "', 'new');",
			"name" => _MD_WWW,
			"image" => iforum_displayImage($forumImage['homepage'], _MD_WWW)
		);
		if ($user->getVar('user_icq'))
		$userbar[] = array("link" => "javascript:void window.open('http://www.icq.com/people/?searched=1&tos=friend&f=TypeOfSearch&donline_only=on&uin=" . $user->getVar('user_icq')."', 'new');", "name" => _MD_ICQ, "image" => iforum_displayImage($forumImage['icq'], _MD_ICQ));
		if ($user->getVar('user_aim'))
		$userbar[] = array("link" => "javascript:void window.open('aim:goim?screenname=" . $user->getVar('user_aim') . "&amp;message=Hi+" . $user->getVar('user_aim') . "+Are+you+there?" . "', 'new');", "name" => _MD_AIM, "image" => iforum_displayImage($forumImage['aim'], _MD_AIM));
		if ($user->getVar('user_yim'))
		$userbar[] = array("link" => "javascript:void window.open('http://edit.yahoo.com/config/send_webmesg?.target=" . $user->getVar('user_yim') . "&amp;.src=pg" . "', 'new');", "name" => _MD_YIM, "image" => iforum_displayImage($forumImage['yahoo'], _MD_YIM));
		if ($user->getVar('user_msnm'))
		$userbar[] = array("link" => "javascript:void window.open('http://members.msn.com?mem=" . $user->getVar('user_msnm') . "', 'new');", "name" => _MD_MSNM, "image" => iforum_displayImage($forumImage['msnm'], _MD_MSNM));
		return $userbar;
	}

	function getLevel()
	{
		global $forumUrl;
		$user = & $this->user;
		$level = get_user_level($user);
		if (icms::$module->config['user_level'] == 2)
		{
			$table = "<table class='userlevel'><tr><td class='end'><img src='" . $forumUrl['images_set'] . "/rpg/img_"._GLOBAL_LEFT.".gif' alt='' /></td><td class='center' background='" . $forumUrl['images_set'] . "/rpg/img_backing.gif'><img src='" . $forumUrl['images_set'] . "/rpg/%s.gif' width='%d' alt='' /></td><td><img src='" . $forumUrl['images_set'] . "/rpg/img_"._GLOBAL_RIGHT.".gif' alt='' /></td></tr></table>";

			$info = _MD_LEVEL . " " . $level['level'] . "<br />" . _MD_HP . " " . $level['hp'] . " / " . $level['hp_max'] . "<br />". sprintf($table, "orange", $level['hp_width']);
			$info .= _MD_MP . " " . $level['mp'] . " / " . $level['mp_max'] . "<br />". sprintf($table, "green", $level['mp_width']);
			$info .= _MD_EXP . " " . $level['exp'] . "<br />". sprintf($table, "blue", $level['exp_width']);
		}
		else
		{
			$info = "<div class='comUserLevel'>";
			$info .= "<span><a href='#' title=' ". _MD_LEVEL_MOD_LEVEL ." '>" . _MD_LEVEL . "</a> " . $level['level'] . "</span>";
			$info .= "<span><a href='#' title=' ". _MD_LEVEL_MOD_EXP ." '>" . _MD_EXP . "</a> " . $level['exp'] . "</span>";
			$info .= "<span><a href='#' title=' ". _MD_LEVEL_MOD_HP ." '>" . _MD_HP . "</a> " . $level['hp'] . " / " . $level['hp_max'] . "</span>";
			$info .= "<span><a href='#' title=' ". _MD_LEVEL_MOD_MP ." '>" . _MD_MP . "</a> " . $level['mp'] . " / " . $level['mp_max'] . "</span>";
			$info .= "</div>";
		}
		return $info;
	}

	function getInfo()
	{
		global $myts;
		$icmsConfigUser = icms::$config->getConfigsByCat(ICMS_CONF_USER);
		$userinfo = array();
		$user = & $this->user;
		if (!(is_object($user)) || !($user->isActive()) ) return array("name" => icms_core_DataFilter::htmlSpecialchars(icms::$config->getConfig('anonymous')), "link" => icms_core_DataFilter::htmlSpecialchars(icms::$config->getConfig('anonymous']));
		$userinfo["uid"] = $user->getVar("uid");
		$name = $user->getVar('name');
		$name = (empty(icms::$module->config['show_realname']) || empty($name))?$user->getVar('uname'):
		$name;
		$userinfo["name"] = $name;
		$userinfo["link"] = "<a href=\"".ICMS_URL . "/userinfo.php?uid=" . $user->getVar("uid") ."\">".$name."</a>";
		$userinfo_avatar = ICMS_URL.'/modules/'.basename(dirname(dirname(__FILE__ ) ) ).'/images/anonymous.gif';
		if ($icmsConfigUser['avatar_allow_gravatar'])
		{
			$userinfo_avatar = $user->gravatar('G', $icmsConfigUser['avatar_width']);
		}
        else
        {
            $userinfo_avatar = ICMS_UPLOAD_URL . '/' . $user->getVar('user_avatar');
        }
		$userinfo["avatar"] = $userinfo_avatar;
		$userinfo["from"] = $user->getVar('user_from');
		$userinfo["regdate"] = formatTimestamp($user->getVar('user_regdate'), 'c');
		$userinfo["posts"] = $user->getVar('posts');
		$userinfo["groups_id"] = $user->getGroups();
		if (!empty(icms::$module->config['user_level']))
		{
			$userinfo["level"] = $this->getLevel();
		}
		if (!empty(icms::$module->config['userbar_enabled']))
		{
			$userinfo["userbar"] = $this->getUserbar();
		}

		$rank = $user->rank();
		$userinfo['rank']["title"] = $rank['title'];
		if (!empty($rank['image'])) {
			$userinfo['rank']['image'] = '<img src="' . $rank['image'] . '" />';
		}
		$var = $user->getVar('user_sig', 'N');
		$userinfo["signature"] = $myts->displayTarea($var, 1, 1, 1, 1, 1);
		return $userinfo;
	}
}

class IforumUserHandler extends icms_core_ObjectHandler {
	public $users = array();
	public $groups = array();
	public $status = array();

	function &get($uid)
	{
		global $forumImage;
		$userinfo = array();

		if (!isset($this->users[$uid])) return $userinfo;
		if (class_exists("User_language"))
		{
			$user = new User_language($this->users[$uid]);
		}
		else
		{
			$user = new User($this->users[$uid]);
		}
		$userinfo = $user->getInfo();
		if (icms::$module->config['groupbar_enabled'] && !empty($userinfo["groups_id"]))
		{
			foreach($userinfo["groups_id"] as $id)
			{
				if (isset($this->groups[$id])) $userinfo['groups'][] = $this->groups[$id];
			}
		}
		if (icms::$module->config['wol_enabled'])
		{
			$userinfo["status"] = isset($this->status[$uid]) ? _MD_ONLINE :
			_MD_OFFLINE;
		}
		return $userinfo;
	}

	function setUsers(&$users)
	{
		$groups = iforum_getGroupsByUser(array_keys($users));
		foreach(array_keys($users) as $uid)
		{
			$users[$uid]->setGroups(@$groups[$uid]);
		}
		$this->users = &$users;
	}

	function setGroups(&$groups)
	{
		$this->groups = &$groups;
	}

	function setStatus(&$status)
	{
		$this->status = &$status;
	}

	function &create() {}
	function insert(&$object) {}
	function delete(&$object) {}
}
