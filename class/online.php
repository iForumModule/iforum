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
 
class IforumOnlineHandler {
	var $forum;
	var $forum_object;
	var $forumtopic;
	var $user_ids = array();
	 
	function init($forum = null, $forumtopic = null)
	{
		if (is_object($forum))
		{
			$this->forum = $forum->getVar('forum_id');
			$this->forum_object = &$forum;
		}
		else
		{
			$this->forum = intval($forum);
			$this->forum_object = $forum;
		}
		if (is_object($forumtopic))
		{
			$this->forumtopic = $forumtopic->getVar('topic_id');
			if (empty($this->forum)) $this->forum = $forumtopic->getVar('forum_id');
		}
		else
		{
			$this->forumtopic = intval($forumtopic);
		}
		 
		$this->update();
	}
	 
	public function update()
	{
		global $icmsModule;
		 
		mt_srand((double)microtime() * 1000000);
		// set gc probabillity to 10% for now..
		if (mt_rand(1, 100) < 11)
		{
			$this->gc(300);
		}
		if (is_object(icms::$user))
		{
			$uid = icms::$user->getVar('uid');
			$uname = icms::$user->getVar('uname');
			$name = icms::$user->getVar('name');
		}
		else
		{
			$uid = 0;
			$uname = '';
			$name = '';
		}
		 
		$online_handler = icms::handler('icms_core_Online');
		if (!$online_handler->write($uid, $uname, time(), $icmsModule->getVar('mid'), $_SERVER['REMOTE_ADDR'])) {
			iforum_message("iforum online upate error");
		}
		 
		$uname = (empty(icms::$module->config['show_realname']) || empty($name))?$uname:
		$name;
		$this->write($uid, $uname, time(), $this->forum, $_SERVER['REMOTE_ADDR'], $this->forumtopic);
	}
	 
	public function show_online()
	{
		global $forumImage;
		 
		if ($this->forumtopic)
		{
			$criteria = new icms_db_criteria_Item('online_topic', $this->forumtopic);
		}
		elseif ($this->forum)
		{
			$criteria = new icms_db_criteria_Item('online_forum', $this->forum);
		}
		else
		{
			$criteria = null;
		}
		$users = $this->getAll($criteria);
		$num_total = count($users);
		 
		$num_user = 0;
		$users_id = array();
		$users_online = array();
		for ($i = 0; $i < $num_total; $i++)
		{
			if (empty($users[$i]['online_uid'])) continue;
			$users_id[] = $users[$i]['online_uid'];
			$users_online[$users[$i]['online_uid']] = array(
			"link" => ICMS_URL . "/userinfo.php?uid=" . $users[$i]['online_uid'],
				"uname" => $users[$i]['online_uname'],
				);
			$num_user ++;
		}
		$num_anonymous = $num_total - $num_user;
		$online = array();
		$online['image'] = iforum_displayImage($forumImage['whosonline']);
		$online['num_total'] = $num_total;
		$online['num_user'] = $num_user;
		$online['num_anonymous'] = $num_anonymous;
		$administrator_list = iforum_isModuleAdministrators($users_id, $GLOBALS["icmsModule"]->getVar("mid"));
		foreach ($users_online as $uid => $user)
		{
			if (!empty($administrator_list[$uid]))
			{
				$user['level'] = 2;
			}
			elseif(iforum_isModerator($this->forum_object, $uid))
			{
				$user['level'] = 1;
			}
			else
			{
				$user['level'] = 0;
			}
			$online["users"][] = $user;
		}
		 
		return $online;
	}
	 
	/**
	* Write online information to the database
	*
	* @param int $uid UID of the active user
	* @param string $uname Username
	* @param string $timestamp
	* @param string $forum Current forum
	* @param string $ip User's IP adress
	* @return bool TRUE on success
	*/
	function write($uid, $uname, $time, $forum, $ip, $forumtopic)
	{
		global $icmsModule;
		 
		$uid = intval($uid);
		if ($uid > 0)
		{
			$sql = "SELECT COUNT(*) FROM " . $GLOBALS["xoopsDB"]->prefix('bb_online') . " WHERE online_uid=" . $uid;
		}
		else
		{
			$sql = "SELECT COUNT(*) FROM " . $GLOBALS["xoopsDB"]->prefix('bb_online') . " WHERE online_uid=" . $uid . " AND online_ip='" . $ip . "'";
		}
		list($count) = $GLOBALS["xoopsDB"]->fetchRow($GLOBALS["xoopsDB"]->queryF($sql));
		if ($count > 0)
		{
			$sql = "UPDATE " . $GLOBALS["xoopsDB"]->prefix('bb_online') . " SET online_updated= '" . $time . "', online_forum = '" . $forum . "', online_topic = '" . $forumtopic . "' WHERE online_uid = " . $uid;
			if ($uid == 0)
			{
				$sql .= " AND online_ip='" . $ip . "'";
			}
		}
		else
		{
			$sql = sprintf("INSERT INTO %s (online_uid, online_uname, online_updated, online_ip, online_forum, online_topic) VALUES (%u, %s, %u, %s, %u, %u)", $GLOBALS["xoopsDB"]->prefix('bb_online'), $uid, $GLOBALS["xoopsDB"]->quoteString($uname), $time, $GLOBALS["xoopsDB"]->quoteString($ip), $forum, $forumtopic);
		}
		if (!$GLOBALS["xoopsDB"]->queryF($sql))
		{
			iforum_message("can not update online info: ".$sql);
			return false;
		}
		 
		$mysql_version = "6.0.0";

		/* for MySQL 4.1+ */
		if ($mysql_version >= "4.1"):
		 
		$sql = "DELETE FROM ".$GLOBALS["xoopsDB"]->prefix('bb_online'). " WHERE". " ( online_uid > 0 AND online_uid NOT IN ( SELECT online_uid FROM ".$GLOBALS["xoopsDB"]->prefix('online')." WHERE online_module =".$icmsModule->getVar('mid')." ) )". " OR ( online_uid = 0 AND online_ip NOT IN ( SELECT online_ip FROM ".$GLOBALS["xoopsDB"]->prefix('online')." WHERE online_module =".$icmsModule->getVar('mid')." AND online_uid = 0 ) )";
		 
		if ($result = $GLOBALS["xoopsDB"]->queryF($sql))
		{
			return true;
		}
		else
		{
			iforum_message("clean xoops online error: ".$sql);
			return false;
		}
		 
		 
		else:
			$sql = "DELETE ".$GLOBALS["xoopsDB"]->prefix('bb_online')." FROM ".$GLOBALS["xoopsDB"]->prefix('bb_online'). " LEFT JOIN ".$GLOBALS["xoopsDB"]->prefix('online')." AS aa ". " ON ".$GLOBALS["xoopsDB"]->prefix('bb_online').".online_uid = aa.online_uid WHERE ".$GLOBALS["xoopsDB"]->prefix('bb_online').".online_uid > 0 AND aa.online_uid IS NULL";
		$result = $GLOBALS["xoopsDB"]->queryF($sql);
		$sql = "DELETE ".$GLOBALS["xoopsDB"]->prefix('bb_online')." FROM ".$GLOBALS["xoopsDB"]->prefix('bb_online'). " LEFT JOIN ".$GLOBALS["xoopsDB"]->prefix('online')." AS aa ". " ON ".$GLOBALS["xoopsDB"]->prefix('bb_online').".online_ip = aa.online_ip WHERE ".$GLOBALS["xoopsDB"]->prefix('bb_online').".online_uid = 0 AND aa.online_ip IS NULL";
		$result = $GLOBALS["xoopsDB"]->queryF($sql);
		return true;
		endif;
	}
	 
	/**
	* Garbage Collection
	*
	* Delete all online information that has not been updated for a certain time
	*
	* @param int $expire Expiration time in seconds
	*/
	function gc($expire)
	{
		global $icmsModule;
		$sql = "DELETE FROM ".$GLOBALS["xoopsDB"]->prefix('bb_online')." WHERE online_updated < ".(time() - intval($expire));
		$GLOBALS["xoopsDB"]->queryF($sql);
		 
		$online_handler = icms::handler('icms_core_Online');
		$online_handler->gc($expire);
	}
	 
	/**
	* Get an array of online information
	*
	* @param object $criteria {@link icms_db_criteria_Element}
	* @return array Array of associative arrays of online information
	*/
	function &getAll($criteria = null)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM ' . $GLOBALS["xoopsDB"]->prefix('bb_online');
		if (is_object($criteria) && is_subclass_of($criteria, 'icms_db_criteria_Element'))
		{
			$sql .= ' ' . $criteria->renderWhere();
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		$result = $GLOBALS["xoopsDB"]->query($sql, $limit, $start);
		if (!$result)
		{
			return false;
		}
		while ($myrow = $GLOBALS["xoopsDB"]->fetchArray($result))
		{
			$ret[] = $myrow;
			if ($myrow["online_uid"] > 0 )
			{
				$this->user_ids[] = $myrow["online_uid"];
			}
			unset($myrow);
		}
		$this->user_ids = array_unique($this->user_ids);
		return $ret;
	}
	 
	function checkStatus($uids)
	{
		$online_users = array();
		$ret = array();
		if (!empty($this->user_ids))
		{
			$online_users = & $this->user_ids;
		}
		else
		{
			$sql = 'SELECT online_uid FROM ' . $GLOBALS["xoopsDB"]->prefix('bb_online');
			if (!empty($uids))
			{
				$sql .= ' WHERE online_uid IN ('.implode(", ", array_map("intval", $uids)).')';
			}
			 
			$result = $GLOBALS["xoopsDB"]->query($sql);
			if (!$result)
			{
				return false;
			}
			while (list($uid) = $GLOBALS["xoopsDB"]->fetchRow($result))
			{
				$online_users[] = $uid;
			}
		}
		foreach($uids as $uid)
		{
			if (in_array($uid, $online_users))
			{
				$ret[$uid] = 1;
			}
		}
		return $ret;
	}
	 
	/**
	* Count the number of online users
	*
	* @param object $criteria {@link icms_db_criteria_Element}
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $GLOBALS["xoopsDB"]->prefix('bb_online');
		if (is_object($criteria) && is_subclass_of($criteria, 'icms_db_criteria_Element'))
		{
			$sql .= ' ' . $criteria->renderWhere();
		}
		if (!$result = $GLOBALS["xoopsDB"]->query($sql))
		{
			return false;
		}
		list($ret) = $GLOBALS["xoopsDB"]->fetchRow($result);
		return $ret;
	}
}