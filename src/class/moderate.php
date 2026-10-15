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

if (!defined("ICMS_ROOT_PATH"))
{
	exit();
}

defined("IFORUM_FUNCTIONS_INI") || include ICMS_ROOT_PATH.'/modules/'.basename(dirname(__FILE__, 2)).'/include/functions.ini.php';
/**
* A handler for User moderation management
*
* @package     iforum/cbb
*
* @author     D.J. (phppp, http://xoopsforge.com)
* @copyright copyright (c) 2005 XOOPS.org
*/

class mod_iforum_Moderate extends icms_ipf_Object {

	public function __construct(&$handler)
	{
		parent::__construct($handler);
		$this->initVar('mod_id', XOBJ_DTYPE_INT);
		$this->initVar('mod_start', XOBJ_DTYPE_INT);
		$this->initVar('mod_end', XOBJ_DTYPE_INT);
		$this->initVar('mod_desc', XOBJ_DTYPE_TXTBOX);
		$this->initVar('uid', XOBJ_DTYPE_INT);
		$this->initVar('ip', XOBJ_DTYPE_TXTBOX);
		$this->initVar('forum_id', XOBJ_DTYPE_INT);
	}
}

class mod_iforum_ModerateHandler extends icms_ipf_Handler {
	use mod_iforum_HandlerTrait;

	public function __construct(&$db)
	{
		parent::__construct($db, 'moderate', 'mod_id', 'uid', '', 'iforum');
		// the legacy schema is kept: the table is bb_moderates
		$this->table = $db->prefix('bb_moderates');
	}

	/**
	* Clear garbage
	*
	* Delete all moderation information that has expired
	*
	* @param int $expire Expiration time in UNIX, 0 for time()
	*/
	function clearGarbage($expire = 0)
	{
		$expire = time() - (int)$expire;
		$sql = sprintf("DELETE FROM %s WHERE mod_end < %u", $this->db->prefix('bb_moderates'), $expire);
		$this->db->queryF($sql);
	}

	/**
	* Check if a user is moderated, according to his uid and ip
	*
	*
	* @param int $uid user id
	* @param string $ip user ip
	*/
	function verifyUser(int $uid = -1, string $ip = "", $forum = 0)
	{
		if (!empty(icms::$module->config['cache_enabled']))
		{
			$forums = $this->forumList($uid, $ip);
			return in_array($forum, $forums);
		}
		$uid = ($uid < 0)?(is_object(icms::$user)?icms::$user->getVar("uid"):0):
		$uid;
		$uid_criteria = empty($uid)?"1=1":
		"uid=". (int)$uid;
		$ip = empty($ip)?iforum_getIP(true):
		$ip;
		if (!empty($ip))
		{
			$ip_segs = explode(".", $ip);
			for($i = 1; $i <= 4; $i++)
			{
				$ips[] = $this->db->quoteString(implode(".", array_slice($ip_segs, 0, $i)));
			}
			$ip_criteria = "ip IN(".implode(",", $ips).")";
		}
		else
		{
			$ip_criteria = "1=1";
		}
		$forum_criteria = empty($forum)?"forum_id=0":
		"forum_id=0 OR forum_id=". (int)$forum;
		$expire_criteria = "mod_end > ".time();
		$sql = sprintf("SELECT COUNT(*) AS count FROM %s WHERE (%s OR %s) AND (%s) AND (%s)", $this->db->prefix('bb_moderates'), $uid_criteria, $ip_criteria, $forum_criteria, $expire_criteria);
		if (!$result = $this->db->query($sql))
		{
			return false;
		}
		$row = $this->db->fetchArray($result);
		return $row["count"];
	}

	/**
	* Get a forum list that a user is suspended, according to his uid and ip
	* Store the list into session if module cache is enabled
	*
	*
	* @param int  $uid user id
	* @param string  $ip user ip
	*/
	public function forumList($uid = -1, $ip = "")
	{
		static $forums = array();
		$uid = ($uid < 0)?(is_object(icms::$user)?icms::$user->getVar("uid"):0):
		$uid;
		$ip = empty($ip)?iforum_getIP(true):
		$ip;
		if (isset($forums[$uid][$ip]))
		{
			return $forums[$uid][$ip];
		}
		if (!empty(icms::$module->config['cache_enabled']))
		{
			$forums[$uid][$ip] = iforum_getsession("sf".$uid."_".ip2long($ip), true);
			if (is_array($forums[$uid][$ip]) && count($forums[$uid][$ip]))
			{
				return $forums[$uid][$ip];
			}
		}
		$uid_criteria = empty($uid)?"1=1":
		"uid=". (int)$uid;
		if (!empty($ip))
		{
			$ip_segs = explode(".", $ip);
			for($i = 1; $i <= 4; $i++)
			{
				$ips[] = $this->db->quoteString(implode(".", array_slice($ip_segs, 0, $i)));
			}
			$ip_criteria = "ip IN(".implode(",", $ips).")";
		}
		else
		{
			$ip_criteria = "1=1";
		}
		$expire_criteria = "mod_end > ".time();
		$sql = sprintf("SELECT forum_id, COUNT(*) AS count FROM %s WHERE (%s OR %s) AND (%s) GROUP BY forum_id", $this->db->prefix('bb_moderates'), $uid_criteria, $ip_criteria, $expire_criteria);
		if (!$result = $this->db->query($sql))
		{
			return $forums[$uid][$ip] = array();
		}
		$_forums = array();
		while ($row = $this->db->fetchArray($result))
		{
			if ($row["count"] > 0)
			{
				$_forums[$row["forum_id"]] = 1;
			}
		}
		$forums[$uid][$ip] = count($_forums)?array_keys($_forums):
		array(-1);
		if (!empty(icms::$module->config['cache_enabled']))
		{
			iforum_setsession("sf".$uid."_".ip2long($ip), $forums[$uid][$ip]);
		}

		return $forums[$uid][$ip];
	}

	/**
	* Get latest expiration for a user moderation
	*
	*
	* @param mix  $item user id or ip
	*/
	function getLatest($item, $isUid = true)
	{
		if ($isUid)
		{
			$criteria = "uid =".intval($item);
		}
		else
		{
			$ip_segs = explode(".", $item);
			$segs = min(count($ip_segs), 4);
			for($i = 1; $i <= $segs; $i++)
			{
				$ips[] = $this->db->quoteString(implode(".", array_slice($ip_segs, 0, $i)));
			}
			$criteria = "ip IN(".implode(",", $ips).")";
		}
		$sql = "SELECT MAX(mod_end) AS expire FROM ".$this->db->prefix('bb_moderates')." WHERE ".$criteria;
		if (!$result = $this->db->query($sql))
		{
			return -1;
		}
		$row = $this->db->fetchArray($result);
		return $row["expire"];
	}

	/**
	* clean orphan items from database
	*
	* @return  bool true on success
	*/
	function cleanOrphan($table_link = "", $field_link = "", $field_object = "")
	{
		$sql = "DELETE FROM ".$this->table. " WHERE (forum_id >0 AND forum_id NOT IN ( SELECT DISTINCT forum_id FROM ".$this->db->prefix("bb_forums").") )";
		if (!$result = $this->db->queryF($sql))
		{
			iforum_message("cleanOrphan:". $sql);
			return false;
		}
		return true;
	}
}
