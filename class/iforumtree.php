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
 
class IForumTree extends icms_view_Tree {
	var $prefix = '&nbsp;&nbsp;';
	var $increment = '&nbsp;&nbsp;';
	var $postArray = '';
	 
	function __construct($table_name, $id_name = "post_id", $pid_name = "pid")
	{
		parent::__construct($table_name, $id_name, $pid_name);
	}
	 
	function setPrefix($val = '')
	{
		$this->prefix = $val;
		$this->increment = $val;
	}
	 
	function getAllPostArray($sel_id, $order = '')
	{
		$this->postArray = $this->getAllChild($sel_id, $order);
	}
	 
	function setPostArray($postArray)
	{
		$this->postArray = &$postArray;
	}
	// returns an array of first child objects for a given id($sel_id)
	function getPostTree(&$postTree_array, $pid = 0, $prefix = '&nbsp;&nbsp;')
	{
		if (!is_array($postTree_array)) $postTree_array = array();
			 
		$newPostArray = array();
		$prefix .= $this->increment;
		foreach($this->postArray as $post)
		{
			if ($post->getVar('pid') == $pid)
			{
				$postTree_array[] = array('prefix' => $prefix,
					'icon' => $post->getVar('icon'),
					'post_time' => $post->getVar('post_time'),
					'post_id' => $post->getVar('post_id'),
					'forum_id' => $post->getVar('forum_id'),
					'subject' => $post->getVar('subject'),
					'poster_name' => $post->getVar('poster_name'),
					'uid' => $post->getVar('uid')
				);
				$this->getPostTree($postTree_array, $post->getVar('post_id'), $prefix);
			}
			else
			{
				$newPostArray[] = $post;
			}
		}
		$this->postArray = $newPostArray;
		unset($newPostArray);
		 
		return true;
	}
}