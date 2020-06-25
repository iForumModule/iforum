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
 
class IforumKarmaHandler {
	var $user;
	 
	function getUserKarma($user = false)
	{
		 
		if (!isset($user) || !$user)
		{
			if (is_object(icms::$user)) $this->user = &icms::$user;
			else $this->user = null;
		}
		elseif (is_object($user))
		{
			$this->user = &$user;
		}
		elseif (is_int ($user) && $user > 0)
		{
			$member_handler = icms::handler('icms_member');
			$this->user =$member_handler->get($user);
		}
		 else $this->user = null;
		 
		return $this->calUserkarma();
	}
	 
	function calUserkarma()
	{
		if (!$this->user) $user_karma = 0;
		else $user_karma = $this->user->getVar('posts') * 50;
		return $user_karma;
	}
	 
	function updateUserKarma()
	{
	}
	 
	function writeUserKarma()
	{
	}
	 
	function readUserKarma()
	{
	}
}