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
 
defined("IFORUM_FUNCTIONS_INI") || include ICMS_ROOT_PATH.'/modules/'.basename(dirname(dirname(__FILE__ ) ) ).'/include/functions.ini.php';
iforum_load_object();
 
class Post extends ArtObject {
	var $attachment_array = array();
	 
	function __construct()
	{
		$this->initVar('post_id', XOBJ_DTYPE_INT);
		$this->initVar('topic_id', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('forum_id', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('post_time', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('poster_ip', XOBJ_DTYPE_INT, 0);
		$this->initVar('poster_name', XOBJ_DTYPE_TXTBOX, "");
		$this->initVar('subject', XOBJ_DTYPE_TXTBOX, "", true);
		$this->initVar('pid', XOBJ_DTYPE_INT, 0);
		$this->initVar('dohtml', XOBJ_DTYPE_INT, 0);
		$this->initVar('dosmiley', XOBJ_DTYPE_INT, 1);
		$this->initVar('doxcode', XOBJ_DTYPE_INT, 1);
		$this->initVar('doimage', XOBJ_DTYPE_INT, 1);
		$this->initVar('dobr', XOBJ_DTYPE_INT, 1);
		$this->initVar('uid', XOBJ_DTYPE_INT, 1);
		$this->initVar('icon', XOBJ_DTYPE_TXTBOX, "");
		$this->initVar('attachsig', XOBJ_DTYPE_INT, 0);
		$this->initVar('approved', XOBJ_DTYPE_INT, 1);
		$this->initVar('post_karma', XOBJ_DTYPE_INT, 0);
		$this->initVar('require_reply', XOBJ_DTYPE_INT, 0);
		$this->initVar('attachment', XOBJ_DTYPE_TXTAREA, "");
		$this->initVar('post_text', XOBJ_DTYPE_TXTAREA, "");
		$this->initVar('post_edit', XOBJ_DTYPE_TXTAREA, "");
	}
	 
	// ////////////////////////////////////////////////////////////////////////////////////
	// attachment functions    TODO: there should be a file/attachment management class
	function getAttachment()
	{
		if (count($this->attachment_array)) return $this->attachment_array;
		$attachment = $this->getVar('attachment');
		if (empty($attachment)) $this->attachment_array = null;
		else $this->attachment_array = @unserialize(base64_decode($attachment));
		return $this->attachment_array;
	}
	 
	function incrementDownload($attach_key)
	{
		if (!$attach_key) return false;
		$this->attachment_array[strval($attach_key)]['num_download'] ++;
		return $this->attachment_array[strval($attach_key)]['num_download'];
	}
	 
	function saveAttachment()
	{
		if (is_array($this->attachment_array) && count($this->attachment_array) > 0)
			$attachment_save = base64_encode(serialize($this->attachment_array));
		else $attachment_save = '';
		$this->setVar('attachment', $attachment_save);
		$sql = "UPDATE " . $GLOBALS["xoopsDB"]->prefix("bb_posts") . " SET attachment=" . $GLOBALS["xoopsDB"]->quoteString($attachment_save) . " WHERE post_id = " . $this->getVar('post_id');
		if (!$result = $GLOBALS["xoopsDB"]->queryF($sql))
		{
			iforum_message("save attachment error: ". $sql);
			return false;
		}
		return true;
	}
	 
	function deleteAttachment($attach_array = null)
	{
		$attach_old = $this->getAttachment();
		if (!is_array($attach_old) || count($attach_old) < 1) return true;
		$this->attachment_array = array();
		 
		if ($attach_array === null) $attach_array = array_keys($attach_old); // to delete all!
		if (!is_array($attach_array)) $attach_array = array($attach_array);
			 
		foreach($attach_old as $key => $attach)
		{
			if (in_array($key, $attach_array))
			{
				@unlink(ICMS_ROOT_PATH . '/' . icms::$module->config['dir_attachments'] . '/' . $attach['name_saved']);
				@unlink(ICMS_ROOT_PATH . '/' . icms::$module->config['dir_attachments'] . '/thumbs/' . $attach['name_saved']); // delete thumbnails
				continue;
			}
			$this->attachment_array[$key] = $attach;
		}
		if (is_array($this->attachment_array) && count($this->attachment_array) > 0)
			$attachment_save = base64_encode(serialize($this->attachment_array));
		else $attachment_save = '';
		$this->setVar('attachment', $attachment_save);
		return true;
	}
	 
	function setAttachment($name_saved = '', $name_display = '', $mimetype = '', $num_download = 0)
	{
		static $counter = 0;
		$this->attachment_array = $this->getAttachment();
		if ($name_saved)
		{
			$key = strval(time()+$counter++);
			$this->attachment_array[$key] = array('name_saved' => $name_saved,
				'name_display' => isset($name_display)?$name_display:
			$name_saved,
				'mimetype' => $mimetype,
				'num_download' => isset($num_download)?intval($num_download):
			0 );
		}
		if (is_array($this->attachment_array))
			{
			$attachment_save = base64_encode(serialize($this->attachment_array));
		}
		else
		{
			$attachment_save = null;
		}
		$this->setVar('attachment', $attachment_save);
		return true;
	}
	 
	function displayAttachment($asSource = false)
	{
		global $icmsModule;
		 
		$post_attachment = '';
		$attachments = $this->getAttachment();
		if (is_array($attachments) && count($attachments) > 0)
		{
			include_once ICMS_ROOT_PATH . '/modules/' . $icmsModule->getVar("dirname") . '/include/functions.image.php';
			$image_extensions = array("jpg", "jpeg", "gif", "png", "bmp"); // need improve !!!
			$post_attachment .= '<br /><strong>' . _MD_ATTACHMENT . '</strong>:';
			$post_attachment .= '<br /><hr size="1" noshade="noshade" /><br />';
			foreach($attachments as $key => $att)
			{
				$file_extension = ltrim(strrchr($att['name_saved'], '.'), '.');
				$filetype = $file_extension;
				if (file_exists(ICMS_ROOT_PATH . '/modules/' . $icmsModule->getVar("dirname") . '/images/filetypes/' . $filetype . '.gif'))
					{
					$icon_filetype = ICMS_URL . '/modules/' . $icmsModule->getVar("dirname") . '/images/filetypes/' . $filetype . '.gif';
				}
				else
				{
					$icon_filetype = ICMS_URL . '/modules/' . $icmsModule->getVar("dirname") . '/images/filetypes/unknown.gif';
				}
				$file_size = @filesize(ICMS_ROOT_PATH . '/' . icms::$module->config['dir_attachments'] . '/' . $att['name_saved']);
				$file_size = number_format ($file_size / 1024, 2)." KB";
				if (in_array(strtolower($file_extension), $image_extensions) && icms::$module->config['media_allowed'])
				{
					$post_attachment .= '<br /><img style="vertical-align:middle;" src="' . $icon_filetype . '" alt="' . $filetype . '" /><strong>&nbsp; ' . $att['name_display'] . '</strong> <small>('.$file_size.')</small>';
					$post_attachment .= '<br />' . iforum_attachmentImage($att['name_saved'], $asSource);
					$isDisplayed = true;
				}
				else
				{
					$post_attachment .= '<a href="' . ICMS_URL . '/modules/' . $icmsModule->getVar("dirname") . '/dl_attachment.php?attachid=' . $key . '&amp;post_id=' . $this->getVar('post_id') . '"> <img style="vertical-align:middle;" src="' . $icon_filetype . '" alt="' . $filetype . '" /> ' . $att['name_display'] . '</a> ' . _MD_FILESIZE . ': '. $file_size . '; '._MD_HITS.': ' . $att['num_download'];
				}
				$post_attachment .= '<br />';
			}
		}
		return $post_attachment;
	}
	// attachment functions
	// ////////////////////////////////////////////////////////////////////////////////////
	 
	function setPostEdit($poster_name = '')
	{
		global $icmsConfig;
		 
		if (empty(icms::$module->config['recordedit_timelimit'])
		|| (time()-$this->getVar('post_time')) < icms::$module->config['recordedit_timelimit'] * 60 || $this->getVar('approved') < 1 )
		{
			return true;
		}
		if (is_object(icms::$user) && icms::$user->isActive())
		{
			if (icms::$module->config['show_realname'] && icms::$user->getVar('name'))
			{
				$edit_user = icms::$user->getVar('name');
			}
			else
			{
				$edit_user = icms::$user->getVar('uname');
			}
		}
		$post_edit = array();
		$post_edit['edit_user'] = $edit_user; // The proper way is to store uid instead of name. However, to save queries when displaying, the current way is ok.
		$post_edit['edit_time'] = time();
		 
		$post_edits = $this->getVar('post_edit');
		if (!empty($post_edits)) $post_edits = unserialize(base64_decode($post_edits));
			if (!is_array($post_edits)) $post_edits = array();
			$post_edits[] = $post_edit;
		$post_edit = base64_encode(serialize($post_edits));
		unset($post_edits);
		$this->setVar('post_edit', $post_edit);
		return true;
	}
	 
	function displayPostEdit()
	{
		global $myts;
		 
		if (empty(icms::$module->config['recordedit_timelimit']) ) return false;
		 
		$post_edit = '';
		$post_edits = $this->getVar('post_edit');
		if (!empty($post_edits)) $post_edits = unserialize(base64_decode($post_edits));
			if (!isset($post_edits) || !is_array($post_edits)) $post_edits = array();
			if (is_array($post_edits) && count($post_edits) > 0)
		{
			foreach($post_edits as $postedit)
			{
				$edit_time = intval($postedit['edit_time']);
				$edit_user = $myts->stripSlashesGPC($postedit['edit_user']);
				$post_edit .= _MD_EDITEDBY . " " . $edit_user . " " . _MD_ON . " " . formatTimestamp(intval($edit_time)) . "<br/>";
			}
		}
		return $post_edit;
	}
	 
	 
	function &getPostBody($imageAsSource = false)
	{
		global $icmsConfig, $myts;
		 
		$uid = is_object(icms::$user)? icms::$user->getVar('uid'):
		0;
		$karma_handler = icms_getmodulehandler('karma', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
		$user_karma = $karma_handler->getUserKarma();
		 
		$post = array();
		$post['attachment'] = false;
		$post_text = iforum_displayTarea($this->vars['post_text']['value'], $this->getVar('dohtml'), $this->getVar('dosmiley'), $this->getVar('doxcode'), $this->getVar('doimage'), $this->getVar('dobr'));
		if (iforum_isAdmin($this->getVar('forum_id')) or $this->checkIdentity())
		{
			$post['text'] = $post_text. '<br />' .$this->displayAttachment($imageAsSource);
		}
		elseif (icms::$module->config['enable_karma'] && $this->getVar('post_karma') > $user_karma)
		{
			$post['text'] = sprintf(_MD_KARMA_REQUIREMENT, $user_karma, $this->getVar('post_karma'));
		}
		elseif (icms::$module->config['allow_require_reply'] && $this->getVar('require_reply') && (!$uid || !isset($viewtopic_users[$uid])))
		{
			$post['text'] = _MD_REPLY_REQUIREMENT;
		}
		else
		{
			$post['text'] = $post_text. '<br />' .$this->displayAttachment($imageAsSource);
		}
		$member_handler = icms::handler('icms_member');
		$eachposter =$member_handler->getUser($this->getVar('uid'));
		if (is_object($eachposter) && $eachposter->isActive())
		{
			if (icms::$module->config['show_realname'] && $eachposter->getVar('name'))
			{
				$post['author'] = $eachposter->getVar('name');
			}
			else
			{
				$post['author'] = $eachposter->getVar('uname');
			}
			unset($eachposter);
		}
		else
		{
			$post['author'] = $this->getVar('poster_name')?$this->getVar('poster_name'):
			$icmsConfig['anonymous'];
		}
		 
		$post['subject'] = iforum_htmlSpecialChars($this->vars['subject']['value']);
		 
		$post['date'] = $this->getVar('post_time');
		 
		return $post;
	}
	 
	function isTopic()
	{
		return !$this->getVar('pid');
	}
	 
	function checkTimelimit($action_tag = 'edit_timelimit')
	{
		return iforum_checkTimelimit($this->getVar('post_time'), $action_tag);
	}
	 
	function checkIdentity($uid = -1)
	{
		$uid = ($uid > -1)?$uid:
		(is_object(icms::$user)? icms::$user->getVar('uid'):0);
		if ($this->getVar('uid') > 0)
		{
			$user_ok = ($uid == $this->getVar('uid'))?true:
			false;
		}
		else
		{
			static $user_ip;
			if (!isset($user_ip))
			{
				$user_ip = iforum_getIP();
			}
			$user_ok = ($user_ip == $this->getVar('poster_ip'))?true:
			false;
		}
		return $user_ok;
	}
	 
	// TODO: cleaning up and merge with post hanldings in viewpost.php
	function showPost($isadmin)
	{
		global $icmsConfig, $icmsModule, $myts, $icmsTpl;
		global $forumUrl, $forumImage;
		global $viewtopic_users, $viewtopic_posters, $viewtopic_forum, $forumtopic, $online, $user_karma, $viewmode, $order, $start, $total_posts, $topic_status;
		static $post_NO = 0;
		static $user_ip;
		 
		$post_id = $this->getVar('post_id');
		$topic_id = $this->getVar('topic_id');
		$forum_id = $this->getVar('forum_id');
		 
		$topic_status = $forumtopic->getVar('topic_status');
		 
		$uid = is_object(icms::$user)? icms::$user->getVar('uid'):
		0;
		 
		$post_NO ++;
		if (strtolower($order) == "desc") $post_no = $total_posts - ($start + $post_NO) + 1;
		else $post_no = $start + $post_NO;
		 
		if ($isadmin or $this->checkIdentity())
		{
			$post_text = $this->getVar('post_text');
			$post_attachment = $this->displayAttachment();
		}
		elseif (icms::$module->config['enable_karma'] && $this->getVar('post_karma') > $user_karma)
		{
			$post_text = "<div class='karma'>" . sprintf(_MD_KARMA_REQUIREMENT, $user_karma, $this->getVar('post_karma')) . "</div>";
			$post_attachment = '';
		}
		elseif (
		icms::$module->config['allow_require_reply'] && $this->getVar('require_reply')
		&& (
		!$uid || !in_array($uid, $viewtopic_posters)
		)
		)
		{
			$post_text = "<div class='karma'>" . _MD_REPLY_REQUIREMENT . "</div>";
			$post_attachment = '';
		}
		else
		{
			$post_text = $this->getVar('post_text');
			$post_attachment = $this->displayAttachment();
		}
		$poster = (($this->getVar('uid') > 0) && isset($viewtopic_users[$this->getVar('uid')]))? $viewtopic_users[$this->getVar('uid')]:
		array(
		'poster_uid' => 0,
			'name' => $this->getVar('poster_name')?$this->getVar('poster_name'):
		icms_core_DataFilter::htmlSpecialchars($icmsConfig['anonymous']),
			'link' => $this->getVar('poster_name')?$this->getVar('poster_name'):
		icms_core_DataFilter::htmlSpecialchars($icmsConfig['anonymous'])
		);
		 
		$posticon = $this->getVar('icon');
		if (!empty($posticon))
			{
			$post_image = '<img style="vertical-align:middle;" src="' . ICMS_URL . '/images/subject/' . $posticon . '" alt="" />';
		}
		else
		{
			$post_image = '<img style="vertical-align:middle;" src="' . ICMS_URL . '/images/icons/posticon.gif" alt="" />';
		}
		 
		$post_title = $this->getVar('subject');
		 
		$thread_buttons = array();
		 
		if ($GLOBALS["icmsModuleConfig"]['enable_permcheck'])
		{
			$topic_handler =icms_getmodulehandler('topic', basename(dirname(__DIR__) ), 'iforum' );
			if ($topic_handler->getPermission($forum_id, $topic_status, "edit"))
			{
				$edit_ok = false;
				if ($isadmin)
				{
					$edit_ok = true;
				}
				elseif ($this->checkIdentity() && $this->checkTimelimit('edit_timelimit'))
				{
					$edit_ok = true;
				}
				if ($edit_ok)
				{
					$thread_buttons['edit']['image'] = iforum_displayImage($forumImage['p_edit'], _EDIT);
					$thread_buttons['edit']['link'] = "edit.php?forum=" . $forum_id . "&amp;topic_id=" . $topic_id . "&amp;viewmode=$viewmode&amp;order=$order";
					$thread_buttons['edit']['name'] = _EDIT;
				}
			}
			 
			if ($topic_handler->getPermission($forum_id, $topic_status, "delete"))
			{
				$delete_ok = false;
				if ($isadmin)
				{
					$delete_ok = true;
				}
				elseif ($this->checkIdentity() && $this->checkTimelimit('delete_timelimit'))
				{
					$delete_ok = true;
				}
				 
				if ($delete_ok)
				{
					$thread_buttons['delete']['image'] = iforum_displayImage($forumImage['p_delete'], _DELETE);
					$thread_buttons['delete']['link'] = "delete.php?forum=" . $forum_id . "&amp;topic_id=" . $topic_id . "&amp;viewmode=$viewmode&amp;order=$order";
					$thread_buttons['delete']['name'] = _DELETE;
				}
			}
			if ($topic_handler->getPermission($forum_id, $topic_status, "reply"))
			{
				$thread_buttons['reply']['image'] = iforum_displayImage($forumImage['p_reply'], _MD_REPLY);
				$thread_buttons['reply']['link'] = "reply.php?forum=" . $forum_id . "&amp;topic_id=" . $topic_id . "&amp;viewmode=$viewmode&amp;order=$order&amp;start=$start";
				$thread_buttons['reply']['name'] = _MD_REPLY;
				 
				$thread_buttons['quote']['image'] = iforum_displayImage($forumImage['p_quote'], _MD_QUOTE);
				$thread_buttons['quote']['link'] = "reply.php?forum=" . $forum_id . "&amp;topic_id=" . $topic_id . "&amp;viewmode=$viewmode&amp;order=$order&amp;start=$start&amp;quotedac=1";
				$thread_buttons['quote']['name'] = _MD_QUOTE;
				 
			}
			 
		}
		else
		{
			 
			$thread_buttons['edit']['image'] = iforum_displayImage($forumImage['p_edit'], _EDIT);
			$thread_buttons['edit']['link'] = "edit.php?forum=" . $forum_id . "&amp;topic_id=" . $topic_id . "&amp;viewmode=$viewmode&amp;order=$order";
			$thread_buttons['edit']['name'] = _EDIT;
			 
			$thread_buttons['delete']['image'] = iforum_displayImage($forumImage['p_delete'], _DELETE);
			$thread_buttons['delete']['link'] = "delete.php?forum=" . $forum_id . "&amp;topic_id=" . $topic_id . "&amp;viewmode=$viewmode&amp;order=$order";
			$thread_buttons['delete']['name'] = _DELETE;
			 
			$thread_buttons['reply']['image'] = iforum_displayImage($forumImage['p_reply'], _MD_REPLY);
			$thread_buttons['reply']['link'] = "reply.php?forum=" . $forum_id . "&amp;topic_id=" . $topic_id . "&amp;viewmode=$viewmode&amp;order=$order&amp;start=$start";
			$thread_buttons['reply']['name'] = _MD_REPLY;
			 
		}
		 
		if (!$isadmin && icms::$module->config['reportmod_enabled'])
		{
			$thread_buttons['report']['image'] = iforum_displayImage($forumImage['p_report'], _MD_REPORT);
			$thread_buttons['report']['link'] = "report.php?forum=" . $forum_id . "&amp;topic_id=" . $topic_id . "&amp;viewmode=$viewmode&amp;order=$order";
			$thread_buttons['report']['name'] = _MD_REPORT;
		}
		 
		$thread_action = array();
		 
		$thread_action['pdf']['image'] = iforum_displayImage($forumImage['pdf'], _MD_PDF);
		$thread_action['pdf']['link'] = "makepdf.php?post_id=".$post_id;
		$thread_action['pdf']['name'] = _MD_PDF;
		 
		$thread_action['print']['image'] = iforum_displayImage($forumImage['printer'], _MD_PRINT);
		$thread_action['print']['link'] = "print.php?form=2&amp;forum=". $forum_id."&amp;topic_id=" . $topic_id . "&amp;post_id=".$post_id;
		$thread_action['print']['name'] = _MD_PRINT;
		 
		$post = array(
			'post_id' => $post_id,
			'post_parent_id' => $this->getVar('pid'),
			'post_date' => formatTimestamp($this->getVar('post_time')),
			'post_image' => $post_image,
			'post_title' => $post_title,
			'post_text' => $post_text,
			'post_attachment' => $post_attachment,
			'post_edit' => $this->displayPostEdit(),
			'post_no' => $post_no,
			'post_signature' => ($this->getVar('attachsig'))?@$poster["signature"]: "",
			'poster_ip' => ($isadmin && icms::$module->config['show_ip'])?long2ip($this->getVar('poster_ip')): "",
			'thread_action' => $thread_action,
			'thread_buttons' => $thread_buttons,
			'poster' => $poster );
		 
		unset($thread_action);
		unset($thread_buttons);
		unset($eachposter);
		 
		return $post;
	}
	 
}
 
class IforumPostHandler extends ArtObjectHandler {
	function __construct(&$db)
	{
		parent::__construct($db, 'bb_posts', 'Post', 'post_id', 'subject');
	}
	 
	function &get($id)
	{
		$id = (int)$id;
		$post = null;
		$sql = 'SELECT p.*, t.* FROM ' . $this->db->prefix('bb_posts') . ' p LEFT JOIN ' . $this->db->prefix('bb_posts_text') . ' t ON p.post_id=t.post_id WHERE p.post_id=' . $id;
		if ($array = $this->db->fetchArray($this->db->query($sql)))
		{
			$post = $this->create(false);
			$post->assignVars($array);
		}
		 
		return $post;
	}
	 
	function &getByLimit($topic_id, $limit, $approved = 1)
	{
		$sql = 'SELECT p.*, t.*, tp.topic_status FROM ' . $this->db->prefix('bb_posts') . ' p LEFT JOIN ' . $this->db->prefix('bb_posts_text') . ' t ON p.post_id=t.post_id LEFT JOIN ' . $this->db->prefix('bb_topics') . ' tp ON tp.topic_id=p.topic_id WHERE p.topic_id=' . $topic_id . ' AND p.approved ='. $approved .' ORDER BY p.post_time DESC';
		$result = $this->db->query($sql, $limit, 0);
		$ret = array();
		while ($myrow = $this->db->fetchArray($result))
		{
			$post = $this->create(false);
			$post->assignVars($myrow);
			 
			$ret[$myrow['post_id']] = $post;
			unset($post);
		}
		return $ret;
	}
	 
	function getPostForPDF(&$post)
	{
		return $post->getPostBody(true);
	}
	 
	function getPostForPrint(&$post)
	{
		return $post->getPostBody();
	}
	 
	function approve(&$post, $force = false)
	{
		if (empty($post))
		{
			return false;
		}
		if (is_numeric($post))
		{
			$post = $this->get($post);
		}
		$post_id = $post->getVar("post_id");
		if (empty($force) && $post->getVar("approved") > 0)
		{
			return true;
		}
		$post->setVar("approved", 1);
		$this->insert($post, true);
		$topic_handler = icms_getmodulehandler("topic", basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
		$topic_obj = $topic_handler->get($post->getVar("topic_id"));
		if ($topic_obj->getVar("topic_last_post_id") < $post->getVar("post_id"))
		{
			$topic_obj->setVar("topic_last_post_id", $post->getVar("post_id"));
		}
		if ($post->isTopic())
		{
			$topic_obj->setVar("approved", 1);
		}
		else
		{
			$topic_obj->setVar("topic_replies", $topic_obj->getVar("topic_replies")+1);
		}
		$topic_handler->insert($topic_obj, true);
		$forum_handler = icms_getmodulehandler("forum", basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
		$forum_obj = $forum_handler->get($post->getVar("forum_id"));
		if ($forum_obj->getVar("forum_last_post_id") < $post->getVar("post_id"))
		{
			$forum_obj->setVar("forum_last_post_id", $post->getVar("post_id"));
		}
		$forum_obj->setVar("forum_posts", $forum_obj->getVar("forum_posts")+1);
		if ($post->isTopic())
		{
			$forum_obj->setVar("forum_topics", $forum_obj->getVar("forum_topics")+1);
		}
		$forum_handler->insert($forum_obj, true);
		 
		// Update user stats
		if ($post->getVar('uid') > 0)
		{
			$member_handler = icms::handler('icms_member');
			$poster = $member_handler->getUser($post->getVar('uid'));
			if (is_object($poster) && $post->getVar('uid') == $poster->getVar("uid"))
			{
				$poster->setVar('posts', $poster->getVar('posts') + 1);
				$res = $member_handler->insertUser($poster, true);
				unset($poster);
			}
		}
		 
		return true;
	}
	 
	function insertnewsubject($topic_id, $subject)
	{
		$sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET topic_subject = " . intval($subject) . " WHERE topic_id = $topic_id";
		$result = $this->db->queryF($sql);
		if (!$result)
		{
			iforum_message("update topic subject error:" . $sql);
			return false;
		}
		return true;
	}
	 
	function insert(&$post, $force = true)
	{
		global $icmsConfig;
		 
		$topic_handler = icms_getmodulehandler("topic", basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
		// Verify the topic ID
		if ($topic_id = $post->getVar("topic_id"))
		{
			$topic_obj = $topic_handler->get($topic_id);
			// Invalid topic OR the topic is no approved and the post is not top post
			if (!$topic_obj // || (!$post->isTopic() && $topic_obj->getVar("approved") < 1)
			)
			{
				return false;
			}
		}
		if (empty($topic_id))
		{
			$post->setVar("topic_id", 0);
			$post->setVar("pid", 0);
			$post->setNew();
			$topic_obj = $topic_handler->create();
		}
		$text_handler = icms_getmodulehandler("text", basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
		$post_text_vars = array("post_text", "post_edit");
		if ($post->isNew())
		{
			if (!$topic_id = $post->getVar("topic_id"))
			{
				$topic_obj->setVar("topic_title", $post->getVar("subject", "n"));
				$topic_obj->setVar("topic_poster", $post->getVar("uid"));
				$topic_obj->setVar("forum_id", $post->getVar("forum_id"));
				$topic_obj->setVar("topic_time", $post->getVar("post_time"));
				$topic_obj->setVar("poster_name", $post->getVar("poster_name"), true);
				$topic_obj->setVar("approved", $post->getVar("approved"), true);
				if (!$topic_id = $topic_handler->insert($topic_obj, $force))
				{
					$post->deleteAttachment();
					$post->setErrors("insert topic error");
					icms_core_Message::error($topic_obj->getErrors());
					return false;
				}
				$post->setVar('topic_id', $topic_id);
				 
				$pid = 0;
				$post->setVar("pid", 0);
			}
			elseif(!$post->getVar("pid"))
			{
				$pid = $topic_handler->getTopPostId($topic_id);
				$post->setVar("pid", $pid);
			}
			 
			$text_obj = $text_handler->create();
			foreach($post_text_vars as $key)
			{
				$text_obj->vars[$key] = $post->vars[$key];
			}
			$post->destoryVars($post_text_vars);
			if (!$post_id = parent::insert($post, $force))
			{
				return false;
			}
			$text_obj->setVar("post_id", $post_id);
			if (!$text_handler->insert($text_obj, $force))
			{
				$this->delete($post);
				$post->setErrors("post text insert error");
				icms_core_Message::error($text_obj->getErrors());
				return false;
			}
			if ($post->getVar("approved") > 0)
			{
				$this->approve($post, true);
			}
			$post->setVar('post_id', $post_id);
		}
		else
		{
			if ($post->isTopic())
			{
				if ($post->getVar("subject") != $topic_obj->getVar("topic_title"))
				{
					$topic_obj->setVar("topic_title", $post->getVar("subject", "n"));
				}
				if ($post->getVar("approved") != $topic_obj->getVar("approved"))
				{
					$topic_obj->setVar("approved", $post->getVar("approved"));
				}
				if (!$result = $topic_handler->insert($topic_obj, $force))
				{
					$post->setErrors("update topic error");
					icms_core_Message::error($topic_obj->getErrors());
					return false;
				}
			}
			$text_obj = $text_handler->get($post->getVar("post_id"));
			$text_obj->setDirty();
			foreach($post_text_vars as $key)
			{
				$text_obj->vars[$key] = $post->vars[$key];
			}
			$post->destoryVars($post_text_vars);
			if (!$post_id = parent::insert($post, $force))
			{
				icms_core_Message::error($post->getErrors());
				return false;
			}
			if (!$text_handler->insert($text_obj, $force))
			{
				$post->setErrors("update post text error");
				icms_core_Message::error($text_obj->getErrors());
				return false;
			}
		}
		return $post->getVar('post_id');
	}
	 
	function delete(&$post, $isDeleteOne = true, $force = false)
	{
		if (!is_object($post) || $post->getVar('post_id') == 0) return false;
		if ($isDeleteOne)
		{
			if ($post->isTopic())
			{
				$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("topic_id", $post->getVar('topic_id')));
				$criteria->add(new icms_db_criteria_Item('approved', 1));
				$criteria->add(new icms_db_criteria_Item('pid', 0, ">"));
				if ($this->getPostCount($criteria) > 0)
				{
					return false;
				}
			}
			return $this->_delete($post, $force);
		}
		else
		{
			include_once(ICMS_ROOT_PATH . "/class/xoopstree.php");
			$mytree = new XoopsTree($this->db->prefix("bb_posts"), "post_id", "pid");
			$arr = $mytree->getAllChild($post->getVar('post_id'));
			for ($i = 0; $i < count($arr); $i++)
			{
				$childpost = $this->create(false);
				$childpost->assignVars($arr[$i]);
				$this->_delete($childpost, $force);
				unset($childpost);
			}
			$this->_delete($post, $force);
		}
		 
		return true;
	}
	 
	function _delete(&$post, $force = false)
	{
		global $icmsModule, $icmsConfig;
		static $forum_lastpost = array();
		 
		if (!is_object($post) || $post->getVar('post_id') == 0) return false;
		 
		$postcount_toupdate = ($post->getVar("approved") > 0);
		 
		/* Set active post as deleted */
		if ($post->getVar("approved") > 0 && empty($force))
		{
			$sql = "UPDATE " . $this->db->prefix("bb_posts") . " SET approved = -1 WHERE post_id = ".$post->getVar("post_id");
			if (!$result = $this->db->queryF($sql))
			{
			}
			/* delete pending post directly */
		}
		else
		{
			$sql = sprintf("DELETE FROM %s WHERE post_id = %u", $this->db->prefix("bb_posts"), $post->getVar('post_id'));
			if (!$result = $this->db->queryF($sql))
			{
				$post->setErrors("delte post error: ".$sql);
				return false;
			}
			$post->deleteAttachment();
			 
			$sql = sprintf("DELETE FROM %s WHERE post_id = %u", $this->db->prefix("bb_posts_text"), $post->getVar('post_id'));
			if (!$result = $this->db->queryF($sql))
			{
				$post->setErrors("Could not remove post text: " . $sql);
				return false;
			}
		}
		 
		if ($post->isTopic())
		{
			$topic_handler = icms_getmodulehandler('topic', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
			$topic_obj = $topic_handler->get($post->getVar('topic_id'));
			if (is_object($topic_obj) && $topic_obj->getVar("approved") > 0 && empty($force))
			{
				$topiccount_toupdate = 1;
				$topic_obj->setVar("approved", -1);
				$topic_handler->insert($topic_obj);
				xoops_notification_deletebyitem ($icmsModule->getVar('mid'), 'thread', $post->getVar('topic_id'));
			}
			else
			{
				if (is_object($topic_obj)):
				if ($topic_obj->getVar("approved") > 0)
				{
					xoops_notification_deletebyitem ($icmsModule->getVar('mid'), 'thread', $post->getVar('topic_id'));
				}
				 
				$poll_id = $topic_obj->getVar("poll_id");
				if ($poll_id > 0)
				{
					if (iforum_poll_module_active())
						{
						include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspoll.php";
						include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspolloption.php";
						include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspolllog.php";
						include_once ICMS_ROOT_PATH."/modules/xoopspoll/class/xoopspollrenderer.php";
						 
						$poll = new XoopsPoll($poll_id);
						if ($poll->delete() != false )
						{
							XoopsPollOption::deleteByPollId($poll->getVar("poll_id"));
							XoopsPollLog::deleteByPollId($poll->getVar("poll_id"));
							xoops_comment_delete($icmsModule->getVar('mid'), $poll->getVar('poll_id'));
						}
					}
				}
				endif;
				 
				$sql = sprintf("DELETE FROM %s WHERE topic_id = %u", $this->db->prefix("bb_topics"), $post->getVar('topic_id'));
				if (!$result = $this->db->queryF($sql))
				{
					iforum_message("Could not delete topic: ". $sql);
				}
				$sql = sprintf("DELETE FROM %s WHERE topic_id = %u", $this->db->prefix("bb_votedata"), $post->getVar('topic_id'));
				if (!$result = $this->db->queryF($sql))
				{
					iforum_message("Could not delete votedata: " .$sql);
				}
			}
		}
		else
		{
			$sql = "UPDATE ".$this->db->prefix("bb_topics")." t
				LEFT JOIN ".$this->db->prefix("bb_posts")." p ON p.topic_id = t.topic_id
				SET t.topic_last_post_id = p.post_id
				WHERE t.topic_last_post_id = ".$post->getVar('post_id')."
				AND p.post_id = (SELECT MAX(post_id) FROM ".$this->db->prefix("bb_posts")." WHERE topic_id=t.topic_id)";
			if (!$result = $this->db->queryF($sql))
			{
			}
		}
		 
		if ($postcount_toupdate > 0 )
		{
			 
			// Update user stats
			if ($post->getVar('uid') > 0)
			{
				$member_handler = icms::handler('icms_member');
				$poster = $member_handler->getUser($post->getVar('uid'));
				if (is_object($poster) && $post->getVar('uid') == $poster->getVar("uid"))
				{
					$poster->setVar('posts', $poster->getVar('posts') - 1);
					$res = $member_handler->insertUser($poster, true);
					unset($poster);
				}
			}
			 
			$sql = "UPDATE " . $this->db->prefix("bb_posts") . " SET pid = " . $post->getVar('pid') . " WHERE pid=" . $post->getVar('post_id');
			if (!$result = $this->db->queryF($sql))
			{
				//icms_core_Message::error($this->db->error());
			}
		}
		 
		return true;
	}
	 
	function getPostCount($criteria = null)
	{
		return parent::getCount($criteria);
	}
	 
	/*
	* TODO: combining viewtopic.php
	*/
	function &getPostsByLimit($criteria = null, $limit = 1, $start = 0, $join = null)
	{
		$ret = array();
		$sql = 'SELECT p.*, t.* '. ' FROM ' . $this->db->prefix('bb_posts') . ' AS p'. ' LEFT JOIN ' . $this->db->prefix('bb_posts_text') . " AS t ON t.post_id = p.post_id";
		if (!empty($join))
		{
			$sql .= $join;
		}
		if (isset($criteria) && is_subclass_of($criteria, "icms_db_criteria_Element"))
		{
			$sql .= " ".$criteria->renderWhere();
			if ($criteria->getSort() != "")
			{
				$sql .= " ORDER BY ".$criteria->getSort()." ".$criteria->getOrder();
			}
		}
		$result = $this->db->query($sql, intval($limit), intval($start));
		if (!$result)
		{
			iforum_message("IforumPostHandler::getPostsByLimit error:" . $sql);
			return $ret;
		}
		while ($myrow = $this->db->fetchArray($result))
		{
			$post = $this->create(false);
			$post->assignVars($myrow);
			$ret[$myrow['post_id']] = $post;
			unset($post);
		}
		return $ret;
	}
	 
	/**
	* clean orphan items from database
	*
	* @return  bool true on success
	*/
	function cleanOrphan()
	{
		parent::cleanOrphan($this->db->prefix("bb_topics"), "topic_id");
		parent::cleanOrphan($this->db->prefix("bb_posts_text"), "post_id");
		 
		/* for MySQL 4.1+ */
		if ($this->mysql_major_version() >= 4):
		$sql = "DELETE FROM ".$this->db->prefix("bb_posts_text"). " WHERE (post_id NOT IN ( SELECT DISTINCT post_id FROM ".$this->table.") )";
		else:
			// for 4.0+
		/* */
		$sql = "DELETE ".$this->db->prefix("bb_posts_text")." FROM ".$this->db->prefix("bb_posts_text"). " LEFT JOIN ".$this->table." AS aa ON ".$this->db->prefix("bb_posts_text").".post_id = aa.post_id ". " WHERE (aa.post_id IS NULL)";
		/* */
		// Alternative for 4.1+
		/*
		$sql =  "DELETE bb FROM ".$this->db->prefix("bb_posts_text")." AS bb".
		" LEFT JOIN ".$this->table." AS aa ON bb.post_id = aa.post_id ".
		" WHERE (aa.post_id IS NULL)";
		*/
		endif;
		if (!$result = $this->db->queryF($sql))
		{
			iforum_message("cleanOrphan:". $sql);
			return false;
		}
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
		if (!empty($expire))
		{
			$crit_expire->add(new icms_db_criteria_Item("post_time", time()-intval($expire), "<"));
		}
		return $this->deleteAll($crit_expire, true/*, true*/);
	}
}
