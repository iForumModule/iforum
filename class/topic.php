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
 
defined("IFORUM_FUNCTIONS_INI") || include ICMS_ROOT_PATH.'/modules/'.basename(dirname(__DIR__) ).'/include/functions.ini.php';
iforum_load_object();
 
class Topic extends ArtObject {
	function __construct()
	{
		parent::__construct("bb_topics");
		$this->initVar('topic_id', XOBJ_DTYPE_INT);
		$this->initVar('topic_title', XOBJ_DTYPE_TXTBOX);
		$this->initVar('topic_poster', XOBJ_DTYPE_INT);
		$this->initVar('topic_time', XOBJ_DTYPE_INT);
		$this->initVar('topic_views', XOBJ_DTYPE_INT);
		$this->initVar('topic_replies', XOBJ_DTYPE_INT);
		$this->initVar('topic_last_post_id', XOBJ_DTYPE_INT);
		$this->initVar('forum_id', XOBJ_DTYPE_INT);
		$this->initVar('topic_status', XOBJ_DTYPE_INT);
		$this->initVar('topic_subject', XOBJ_DTYPE_INT);
		$this->initVar('topic_sticky', XOBJ_DTYPE_INT);
		$this->initVar('topic_digest', XOBJ_DTYPE_INT);
		$this->initVar('digest_time', XOBJ_DTYPE_INT);
		$this->initVar('approved', XOBJ_DTYPE_INT);
		$this->initVar('poster_name', XOBJ_DTYPE_TXTBOX);
		$this->initVar('rating', XOBJ_DTYPE_OTHER);
		$this->initVar('votes', XOBJ_DTYPE_INT);
		$this->initVar('topic_haspoll', XOBJ_DTYPE_INT);
		$this->initVar('poll_id', XOBJ_DTYPE_INT);
		$this->initVar('topic_tags', XOBJ_DTYPE_SOURCE);
	}
	 
	function incrementCounter()
	{
		$sql = 'UPDATE ' . $GLOBALS["xoopsDB"]->prefix('bb_topics') . ' SET topic_views = topic_views + 1 WHERE topic_id =' . $this->getVar('topic_id');
		$GLOBALS["xoopsDB"]->queryF($sql);
	}
}
 
class IforumTopicHandler extends ArtObjectHandler {
	function __construct(&$db)
	{
		parent::__construct($db, 'bb_topics', 'Topic', 'topic_id', 'topic_title');
	}
	 
	function &get($id, $var = null)
	{
		$ret = null;
		if (!empty($var) && is_string($var))
		{
			$tags = array($var);
		}
		else
		{
			$tags = $var;
		}
		if (!$topic_obj = parent::get($id, $tags))
		{
			return $ret;
		}
		if (!empty($var) && is_string($var))
		{
			$ret = @$topic_obj->getVar($var);
		}
		else
		{
			$ret = & $topic_obj;
		}
		return $ret;
	}
	 
	function approve($topic_id)
	{
		$sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET approved = 1 WHERE topic_id = $topic_id";
		if (!$result = $this->db->queryF($sql))
		{
			iforum_message("IforumTopicHandler::approve error:" . $sql);
			return false;
		}
		$post_handler = icms_getmodulehandler('post', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
		$posts_obj = $post_handler->getAll(new icms_db_criteria_Item('topic_id', $topic_id));
		foreach(array_keys($posts_obj) as $post_id)
		{
			$post_handler->approve($posts_obj[$post_id]);
		}
		unset($posts_obj);
		return true;
	}
	 
	/**
	* get previous/next topic
	*
	* @param integer $topic_id current topic ID
	* @param integer $action
	* <ul>
	*  <li> -1: previous </li>
	*  <li> 0: current </li>
	*  <li> 1: next </li>
	* </ul>
	* @param integer $forum_id the scope for moving
	* <ul>
	*  <li> >0 : inside the forum </li>
	*  <li> <= 0: global </li>
	* </ul>
	* @access public
	*/
	function &getByMove($topic_id, $action, $forum_id = 0)
	{
		$topic = null;
		if (!empty($action)):
		$sql = "SELECT * FROM " . $this->table. " WHERE 1=1". (($forum_id > 0)?" AND forum_id=". (int)$forum_id :""). " AND topic_id ".(($action > 0)?">":"<").intval($topic_id). " ORDER BY topic_id ".(($action > 0)?"ASC":"DESC")." LIMIT 1";
		if ($result = $this->db->query($sql))
		{
			if ($row = $this->db->fetchArray($result)):
			$topic = $this->create(false);
			$topic->assignVars($row);
			return $topic;
			endif;
		}
		endif;
		$topic = $this->get($topic_id);
		return $topic;
	}
	 
	function &getByPost($post_id)
	{
		$topic = null;
		$sql = "SELECT t.* FROM " . $this->db->prefix('bb_topics') . " t, " . $this->db->prefix('bb_posts') . " p
			WHERE t.topic_id = p.topic_id AND p.post_id = " . (int)$post_id;
		$result = $this->db->query($sql);
		if (!$result)
		{
			iforum_message("IforumTopicHandler::getByPost error:" . $sql);
			return $topic;
		}
		$row = $this->db->fetchArray($result);
		$topic = $this->create(false);
		$topic->assignVars($row);
		return $topic;
	}
	 
	function getPostCount(&$topic, $type = "")
	{
		switch($type)
		{
			case "pending":
			$approved = 0;
			break;
			case "deleted":
			$approved = -1;
			break;
			default:
			$approved = 1;
			break;
		}
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("topic_id", $topic->getVar('topic_id')));
		$criteria->add(new icms_db_criteria_Item("approved", $approved));
		$post_handler = icms_getmodulehandler("post", basename(dirname(__DIR__) ), 'iforum' );
		$count = $post_handler->getCount($criteria);
		return $count;
	}
	 
	function &getTopPost($topic_id)
	{
		$post = null;
		$sql = "SELECT p.*, t.* FROM " . $this->db->prefix('bb_posts') . " p,
			" . $this->db->prefix('bb_posts_text') . " t
			WHERE
			p.topic_id = " . $topic_id . " AND p.pid = 0
			AND t.post_id = p.post_id";
		 
		$result = $this->db->query($sql);
		if (!$result)
		{
			iforum_message("IforumTopicHandler::getTopPost error:" . $sql);
			return $post;
		}
		$post_handler = icms_getmodulehandler('post', basename(dirname(__DIR__) ), 'iforum' );
		$myrow = $this->db->fetchArray($result);
		$post = $post_handler->create(false);
		$post->assignVars($myrow);
		return $post;
	}
	 
	function getTopPostId($topic_id)
	{
		$sql = "SELECT MIN(post_id) AS post_id FROM " . $this->db->prefix('bb_posts') . " WHERE topic_id = " . $topic_id . " AND pid = 0";
		$result = $this->db->query($sql);
		if (!$result)
		{
			iforum_message("IforumTopicHandler::getTopPostId error:" . $sql);
			return false;
		}
		list($post_id) = $this->db->fetchRow($result);
		return $post_id;
	}
	 
	function &getAllPosts(&$topic, $order = "ASC", $perpage = 10, &$start, $post_id = 0, $type = "")
	{
		$ret = array();
		$perpage = (intval($perpage) > 0) ? intval($perpage) :
		 (empty(icms::$module->config['posts_per_page']) ? 10 : icms::$module->config['posts_per_page']);
		$start = intval($start);
		switch($type)
		{
			case "pending":
			$approve_criteria = ' AND p.approved = 0';
			break;
			case "deleted":
			$approve_criteria = ' AND p.approved = -1';
			break;
			default:
			$approve_criteria = ' AND p.approved = 1';
			break;
		}
		 
		if ($post_id)
		{
			if ($order == "DESC")
			{
				$operator_for_position = '>' ;
			}
			else
			{
				$order = "ASC" ;
				$operator_for_position = '<' ;
			}
			//$approve_criteria = ' AND approved = 1'; // any others?
			$sql = "SELECT COUNT(*) FROM " . $this->db->prefix('bb_posts') . " AS p WHERE p.topic_id=" . intval($topic->getVar('topic_id')) . $approve_criteria . " AND p.post_id $operator_for_position $post_id";
			$result = $this->db->query($sql);
			if (!$result)
			{
				iforum_message("IforumTopicHandler::getAllPosts:post-count error:" . $sql);
				return $ret;
			}
			list($position) = $this->db->fetchRow($result);
			$start = intval($position / $perpage) * $perpage;
		}
		 
		$sql = 'SELECT p.*, t.* FROM ' . $this->db->prefix('bb_posts') . ' p, ' . $this->db->prefix('bb_posts_text') . " t WHERE p.topic_id=" . $topic->getVar('topic_id') . " AND p.post_id = t.post_id" . $approve_criteria . " ORDER BY p.post_id $order";
		$result = $this->db->query($sql, $perpage, $start);
		if (!$result)
		{
			iforum_message("IforumTopicHandler::getAllPosts error:" . $sql);
			return $ret;
		}
		$post_handler =icms_getmodulehandler('post', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
		while ($myrow = $this->db->fetchArray($result))
		{
			$post =$post_handler->create(false);
			$post->assignVars($myrow);
			$ret[$myrow['post_id']] = $post;
			unset($post);
		}
		return $ret;
	}
	 
	function &getPostTree(&$postArray, $pid = 0)
	{
		include_once ICMS_ROOT_PATH . "/modules/".basename(dirname(dirname(__FILE__ ) ) )."/class/iforumtree.php";
		$IForumTree = new IForumTree('bb_posts');
		$IForumTree->setPrefix('&nbsp;&nbsp;');
		$IForumTree->setPostArray($postArray);
		$IForumTree->getPostTree($postsArray, $pid);
		return $postsArray;
	}
	 
	function showTreeItem(&$topic, &$postArray)
	{
		global $icmsConfig, $viewtopic_users, $myts;
		 
		$postArray['post_time'] = formatTimestamp($postArray['post_time']);
		 
		if (!empty($postArray['icon']))
			{
			$postArray['icon'] = '<img style="vertical-align:middle;" src="' . ICMS_URL . "/images/subject/" . htmlspecialchars($postArray['icon']) . '" alt="" />';
		}
		else
		{
			$postArray['icon'] = '<a><img style="vertical-align:middle;" src="' . ICMS_URL . '/images/icons/no_posticon.gif" alt="" /></a>';
		}
		 
		if (isset($viewtopic_users[$postArray['uid']]['is_forumadmin']))
			{
			$postArray['subject'] = $myts->undoHtmlSpecialChars($postArray['subject']);
		}
		$postArray['subject'] = '<a href="viewtopic.php?viewmode=thread&amp;topic_id=' . $topic->getVar('topic_id') . '&amp;forum=' . $postArray['forum_id'] . '&amp;post_id=' . $postArray['post_id'] . '">' . $postArray['subject'] . '</a>';
		 
		$isActiveUser = false;
		if (isset($viewtopic_users[$postArray['uid']]['name']))
		{
			$postArray['poster'] = $viewtopic_users[$postArray['uid']]['name'];
			if ($postArray['uid'] > 0)
			$postArray['poster'] = "<a href=\"".ICMS_URL . "/userinfo.php?uid=" . $postArray['uid'] ."\">".$viewtopic_users[$postArray['uid']]['name']."</a>";
		}
		else
		{
			$postArray['poster'] = (empty($postArray['poster_name']))?icms_core_DataFilter::htmlSpecialchars($icmsConfig['anonymous']):
			$postArray['poster_name'];
		}
		 
		return $postArray;
	}
	 
	function &getAllPosters(&$topic, $isApproved = true)
	{
		$sql = 'SELECT DISTINCT uid FROM ' . $this->db->prefix('bb_posts') . "  WHERE topic_id=" . $topic->getVar('topic_id')." AND uid>0";
		if ($isApproved) $sql .= ' AND approved = 1';
		$result = $this->db->query($sql);
		if (!$result)
		{
			iforum_message("IforumTopicHandler::getAllPosters error:" . $sql);
			return array();
		}
		$ret = array();
		while ($myrow = $this->db->fetchArray($result))
		{
			$ret[] = $myrow['uid'];
		}
		return $ret;
	}
	 
	function delete(&$topic, $force = true)
	{
		$topic_id = is_object($topic)?$topic->getVar("topic_id"):
		intval($topic);
		if (empty($topic_id))
		{
			return false;
		}
		$post_obj = $this->getTopPost($topic_id);
		$post_handler = icms_getmodulehandler('post', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
		$post_handler->delete($post_obj, false, $force);
		return true;
	}
	 
	// get permission
	// parameter: $type: 'post', 'view',  'reply', 'edit', 'delete', 'addpoll', 'vote', 'attach'
	// $gperm_names = "'forum_can_post', 'forum_can_view', 'forum_can_reply', 'forum_can_edit', 'forum_can_delete', 'forum_can_addpoll', 'forum_can_vote', 'forum_can_attach', 'forum_can_noapprove'";
	function getPermission($forum, $topic_locked = 0, $type = "view")
	{
		global $icmsModule;
		static $_cachedTopicPerms;
		 
		if (iforum_isAdmin($forum)) return 1;
		 
		$forum = is_object($forum)?$forum->getVar('forum_id'):
		intval($forum);
		if ($forum < 1) return false;
		 
		if (!isset($_cachedTopicPerms))
			{
			$getpermission =icms_getmodulehandler('permission', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
			$_cachedTopicPerms = $getpermission->getPermissions("forum", $forum);
		}
		 
		$type = strtolower($type);
		$perm_item = 'forum_' . $type;
		$permission = (isset($_cachedTopicPerms[$forum][$perm_item])) ? 1 :
		 0;
		 
		if ($topic_locked && 'view' != $type) $permission = 0;
		 
		return $permission;
	}
	 
	/**
	* clean orphan items from database
	*
	* @return  bool true on success
	*/
	function cleanOrphan()
	{
		parent::cleanOrphan($this->db->prefix("bb_forums"), "forum_id");
		parent::cleanOrphan($this->db->prefix("bb_posts"), "topic_id");
		 
		return true;
	}
	 
	/**
	* clean expired objects from database
	*
	* @param  int  $expire  time limit for expiration
	* @return  bool true on success
	*/
	function cleanExpires($expire = 0)
	{
		$crit_expire = new icms_db_criteria_Compo(new icms_db_criteria_Item("approved", 0, "<="));
		//if(!empty($expire)){
		$crit_expire->add(new icms_db_criteria_Item("topic_time", time()-intval($expire), "<"));
		//}
		return $this->deleteAll($crit_expire, true/*, true*/);
	}
	 
	function synchronization($object = null, $force = true)
	{
		if (empty($object))
		{
			/* for MySQL 4.1+ */
			if ($this->mysql_major_version() >= 4):
			// Set topic_last_post_id
			$sql = "UPDATE ".$this->table. " SET ".$this->table.".topic_last_post_id = @last_post =(". " SELECT MAX(post_id) AS last_post ". "  FROM " . $this->db->prefix("bb_posts") . "  WHERE approved=1 AND topic_id = ".$this->table.".topic_id". " )". " WHERE ".$this->table.".topic_last_post_id <> @last_post";
			$this->db->queryF($sql);
			// Set topic_replies
			$sql = "UPDATE ".$this->table. " SET ".$this->table.".topic_replies = @replies =(". " SELECT count(*) AS total ". "  FROM " . $this->db->prefix("bb_posts") . "  WHERE approved=1 AND topic_id = ".$this->table.".topic_id". " )". " WHERE ".$this->table.".topic_replies <> @replies";
			$this->db->queryF($sql);
			else:
				// for 4.0+
			$topics = $this->getIds();
			foreach($topics as $id)
			{
				if (!$obj = $this->get($id)) continue;
				$this->synchronization($obj);
				unset($obj);
			}
			unset($topics);
			endif;
			 
			/*
			// MYSQL syntax error
			// Set post pid for top post
			$sql = "UPDATE ".$this->db->prefix("bb_posts").
			" SET ".$this->db->prefix("bb_posts").".pid = 0".
			" LEFT JOIN ".$this->db->prefix("bb_posts")." AS aa ON aa.topic_id = ".$this->db->prefix("bb_posts").".topic_id".
			" WHERE ".$this->db->prefix("bb_posts").".pid <> 0 ".
			"  AND ".$this->db->prefix("bb_posts").".post_id = MIN(aa.post_id)";
			$this->db->queryF($sql);
			// Set post pid for non-top post
			$sql = "UPDATE ".$this->db->prefix("bb_posts").
			" SET ".$this->db->prefix("bb_posts").".pid = MIN(aa.post_id)".
			" LEFT JOIN ".$this->db->prefix("bb_posts")." AS aa ON aa.topic_id = ".$this->db->prefix("bb_posts").".topic_id".
			" WHERE ".$this->db->prefix("bb_posts").".pid <> 0 ".
			"  AND ".$this->db->prefix("bb_posts").".post_id <> @top_post";
			$this->db->queryF($sql);
			*/
			return;
		}
		if (!is_object($object))
		{
			$object = $this->get(intval($object));
		}
		if (!$object->getVar("topic_id")) return false;
		 
		if ($force):
		$sql = "SELECT MAX(post_id) AS last_post, COUNT(*) AS total ". " FROM " . icms::$xoopsDB->prefix("bb_posts") . " WHERE approved=1 AND topic_id = ".$object->getVar("topic_id");
		if ($result = icms::$xoopsDB->query($sql) )
			if ($row = icms::$xoopsDB->fetchArray($result) )
		{
			if ($object->getVar("topic_last_post_id") != $row['last_post'])
			{
				$object->setVar("topic_last_post_id", $row['last_post']);
			}
			if ($object->getVar("topic_replies") != $row['total'] -1 )
			{
				$object->setVar("topic_replies", $row['total'] -1);
			}
		}
		$this->insert($object, true);
		endif;
		 
		$time_synchronization = 30 * 24 * 3600; // in days; this should be counted since last synchronization
		if ($force || $object->getVar("topic_time") > (time() - $time_synchronization)):
		$sql = "SELECT MIN(post_id) AS top_post FROM ".icms::$xoopsDB->prefix("bb_posts")." WHERE approved = 1 AND topic_id = ".$object->getVar("topic_id");
		if ($result = icms::$xoopsDB->query($sql) )
		{
			list($top_post) = icms::$xoopsDB->fetchRow($result);
			if (empty($top_post)) return false;
			$sql = "UPDATE ".icms::$xoopsDB->prefix("bb_posts"). " SET pid = 0 ". " WHERE post_id = ".$top_post. " AND pid <> 0";
			if (!$result = icms::$xoopsDB->queryF($sql) )
			{
				//iforum_message("Could not set top post $top_post for topic: ".$sql);
				//return false;
			}
			$sql = "UPDATE ".icms::$xoopsDB->prefix("bb_posts"). " SET pid = ".$top_post. " WHERE". "  topic_id = ".$object->getVar("topic_id"). "  AND post_id <> ".$top_post. "  AND pid = 0";
			if (!$result = icms::$xoopsDB->queryF($sql) )
			{
				//iforum_message("Could not set post parent ID for topic: ".$sql);
				//return false;
			}
			 
			/*
			// MYSQL syntax error
			$sql =  "UPDATE ".icms::$xoopsDB->prefix("bb_posts").
			" SET ".icms::$xoopsDB->prefix("bb_posts"). ".pid = ".$top_post.
			" LEFT JOIN ".icms::$xoopsDB->prefix("bb_posts"). " AS bb".
			"  ON bb.post_id = ".icms::$xoopsDB->prefix("bb_posts"). ".pid".
			" WHERE".
			"  ".icms::$xoopsDB->prefix("bb_posts"). ".topic_id = ".$object->getVar("topic_id").
			"  AND ".icms::$xoopsDB->prefix("bb_posts"). ".post_id <> ".$top_post.
			"  AND bb.topic_id <>".$object->getVar("topic_id");
			if ( !$result = icms::$xoopsDB->queryF($sql) ) {
			//iforum_message("Could not concile posts for topic: ".$sql);
			//return false;
			}
			*/
		}
		endif;
		return true;
	}
}