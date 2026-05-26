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

if (!defined('ICMS_ROOT_PATH')) {
	exit();
}

class Digest extends icms_ipf_Object {
	public $items;
	public $isHtml = false;
	public $isSummary = true;

	function __construct($handler = null)
	{
		$this->handler = $handler;
		$this->initVar('digest_id', XOBJ_DTYPE_INT);
		$this->initVar('digest_time', XOBJ_DTYPE_INT);
		$this->initVar('digest_content', XOBJ_DTYPE_TXTAREA);
		$this->items = array();
	}

	function setHtml()
	{
		$this->isHtml = true;
	}

	function setSummary()
	{
		$this->isSummary = true;
	}

	function addItem($title, $link, $author, $summary = "")
	{
		$title = $this->cleanup($title);
		$author = $this->cleanup($author);
		if (!empty($summary))
		{
			$summary = $this->cleanup($summary);
		}
		$this->items[] = array('title' => $title, 'link' => $link, 'author' => $author, 'summary' => $summary);
	}

	function cleanup($text)
	{
		global $myts;

		$clean = stripslashes($text);
		$clean = $myts->displayTarea($clean, 1, 0, 1);
		$clean = strip_tags($clean);
		$clean = htmlspecialchars($clean, ENT_QUOTES);

		return $clean;
	}

	function buildContent($isSummary = true, $isHtml = false)
	{
		$digest_count = count($this->items);
		$content = "";
		if ($digest_count > 0)
		{
			$linebreak = ($isHtml)?"<br />":
			"\n";
			for($i = 0; $i < $digest_count; $i++)
			{
				if ($isHtml)
				{
					$content .= ($i + 1) . ". <a href=" . $this->items[$i]['link'] . ">" . $this->items[$i]['title'] . "</a>";
				}
				else
				{
					$content .= ($i + 1) . ". " . $this->items[$i]['title'] . $linebreak . $this->items[$i]['link'];
				}

				$content .= $linebreak . $this->items[$i]['author'];
				if ($isSummary) $content .= $linebreak . $this->items[$i]['summary'];
				$content .= $linebreak . $linebreak;
			}
		}
		$this->setVar('digest_content', $content);
		return true;
	}
}

class IforumDigestHandler extends icms_ipf_Handler {
	public $last_digest;
	public $last_digest_id = 0;

	function __construct(&$db)
	{
		parent::__construct($db, 'digest', 'digest_id', '', '', basename(dirname(__FILE__, 2)));
		$this->table = $db->prefix('bb_digest');
		$this->className = 'Digest';
	}

	function get($id, $as_object = true, $debug = false, $criteria = false)
	{
		$id = (int)$id;
		if ($id < 1)
		{
			return null;
		}

		return parent::get($id, $as_object, $debug, $criteria);
	}

	function process($isForced = false)
	{
		$this->getLastDigest();
		if (!$isForced)
		{
			$status = $this->checkStatus();
			if ($status < 1) return 1;
		}
		$digest =$this->create();
		$status = $this->buildDigest($digest);
		if (!$status) return 2;
		$status = $this->insert($digest);
		if (!$status) return 3;
		$status = $this->notify($digest);
		if (!$status) return 4;
		return 0;
	}

	function notify(&$digest)
	{
		$notification_handler = icms::handler('icms_data_notification');
		$tags['DIGEST_ID'] = $digest->getVar('digest_id');
		$tags['DIGEST_CONTENT'] = $digest->getVar('digest_content', 'E');
		$notification_handler->triggerEvent('global', 0, 'digest', $tags);
		return true;
	}

	function &getAllDigests(&$start, $perpage = 5)
	{
		if (empty($start))
		{
			$start = 0;
		}

		$criteria = new icms_db_criteria_Compo();
		$criteria->setSort('digest_id');
		$criteria->setOrder('DESC');
		$criteria->setLimit((int)$perpage);
		$criteria->setStart((int)$start);

		$digests = $this->getObjects($criteria);
		$ret = array();
		foreach ($digests as $digest)
		{
			$ret[] = array(
				'digest_id' => $digest->getVar('digest_id'),
				'digest_time' => $digest->getVar('digest_time'),
				'digest_content' => $digest->getVar('digest_content'),
			);
		}

		return $ret;
	}

	function getDigestCount()
	{
		return $this->getCount();
	}

	function getLastDigest()
	{
		$sql = 'SELECT digest_id, digest_time FROM ' . $this->table . ' ORDER BY digest_time DESC, digest_id DESC';
		$result = $this->db->query($sql, 1, 0);
		if (!$result)
		{
			$this->last_digest = 0;
			$this->last_digest_id = 0;
		}
		else
		{
			$array = $this->db->fetchArray($result);
			$this->last_digest = (isset($array['digest_time'])) ? (int)$array['digest_time'] : 0;
			$this->last_digest_id = (isset($array['digest_id'])) ? (int)$array['digest_id'] : 0;
		}
	}

	function checkStatus()
	{
		if (!isset($this->last_digest)) $this->getLastDigest();
			$deadline = (icms::$module->config['email_digest'] == 1)? 60 * 60 * 24:
		60 * 60 * 24 * 7;
		$time_diff = time() - $this->last_digest;
		return $time_diff - $deadline;
	}

	function insert(&$digest, $force = false, $checkObject = true, $debug = false)
	{
		$digest->setVar('digest_time', time());

		return parent::insert($digest, true);
	}

	function delete(&$digest, $force = false)
	{
		if (is_object($digest))
		{
			$digest_obj = $digest;
			$digest_id = (int)$digest->getVar('digest_id');
		}
		else
		{
			$digest_id = (int)$digest;
			$digest_obj = $this->get($digest_id);
		}
		if (!$digest_obj || $digest_obj->isNew())
		{
			return false;
		}
		if (!isset($this->last_digest)) $this->getLastDigest();
		if ($this->last_digest_id === $digest_id)
		{
			return false; // It is not allowed to delete the last digest
		}

		return parent::delete($digest_obj, true);
	}

	function buildDigest(&$digest)
	{
		global $icmsConfig;

		if (!defined('SUMMARY_LENGTH')) define('SUMMARY_LENGTH', 100);

		$forum_handler =icms_getmodulehandler('forum', basename(dirname(__FILE__, 2)), 'iforum' );
		$thisUser = icms::$user;
		icms::$user = null; // To get posts accessible by anonymous
		$access_forums = $forum_handler->getForums(0, 'access'); // get all accessible forums
		icms::$user = $thisUser;

		if (count($access_forums) < 1)
		{
			return false;
		}

		$forum_criteria = ' AND t.forum_id IN (' . implode(',', array_keys($access_forums)) . ')';
		unset($access_forums);
		$approve_criteria = ' AND t.approved = 1 AND p.approved = 1';
		$time_criteria = ' AND t.digest_time > ' . $this->last_digest;

		$karma_criteria = (icms::$module->config['enable_karma'])? " AND p.post_karma=0":
		"";
		$reply_criteria = (icms::$module->config['allow_require_reply'])? " AND p.require_reply=0":
		"";

		$query = 'SELECT t.topic_id, t.forum_id, t.topic_title, t.topic_time, t.digest_time, p.uid, p.poster_name, pt.post_text FROM ' . $this->db->prefix('bb_topics') . ' t, ' . $this->db->prefix('bb_posts_text') . ' pt, ' . $this->db->prefix('bb_posts') . ' p WHERE t.topic_digest = 1 AND p.topic_id=t.topic_id AND p.pid=0 ' . $forum_criteria . $approve_criteria . $time_criteria . $karma_criteria . $reply_criteria . ' AND pt.post_id=p.post_id ORDER BY t.digest_time DESC';
		if (!$result = $this->db->query($query))
		{
			return false;
		}
		$rows = array();
		$users = array();
		while ($row = $this->db->fetchArray($result))
		{
			$users[$row['uid']] = 1;
			$rows[] = $row;
		}
		if (count($rows) < 1)
		{
			return false;
		}
		$uids = array_keys($users);
		if (count($uids) > 0)
		{
			$member_handler = icms::handler('icms_member');
			$users = $member_handler->getUsers(new icms_db_criteria_Item('uid', "(" . implode(',', $uids) . ")", 'IN'), true);
		}
		else
		{
			$users = array();
		}

		foreach($rows as $topic)
		{
			if ($topic['uid'] > 0)
			{
				if (isset($users[$topic['uid']]) && (is_object($users[$topic['uid']])) && ($users[$topic['uid']]->isActive())) {
					$topic['uname'] = $users[$topic['uid']]->getVar('uname');
				} else {
					$topic['uname'] = $icmsConfig['anonymous'];
				}
			} else {
				$topic['uname'] = $topic['poster_name']?$topic['poster_name']: $icmsConfig['anonymous'];
			}
			$summary = icms_core_DataFilter::icms_substr(iforum_html2text($topic['post_text']), 0, SUMMARY_LENGTH);
			$author = $topic['uname'] . " (" . formatTimestamp($topic['topic_time']) . ")";
			$link = ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . '/viewtopic.php?topic_id=' . $topic['topic_id'] . '&amp;forum=' . $topic['forum_id'];
			$title = $topic['topic_title'];
			$digest->addItem($title, $link, $author, $summary);
		}
		$digest->buildContent();
		return true;
	}
}
