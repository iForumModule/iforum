<?php
// $Id: user.php,v 1.1.1.2 2005/10/19 16:23:34 phppp Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
//  Author: phppp (D.J., infomax@gmail.com)                                  //
//  URL: http://xoopsforge.com, http://xoops.org.cn                          //
//  Project: Article Project                                                 //
//  ------------------------------------------------------------------------ //
 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

defined("NEWBB_FUNCTIONS_INI") || include XOOPS_ROOT_PATH.'/modules/'.basename( dirname( dirname( __FILE__ ) ) ).'/include/functions.ini.php';
function newbb_getGroupsByUser($uid)
{
	global $xoopsDB;	
    $ret = array();
	if(empty($uid)) return $ret;
    $uid_criteria = is_array($uid)?"IN(".implode(", ", array_map("intval", $uid)).")":"=".$uid;
    $sql = 'SELECT groupid, uid FROM '.$xoopsDB->prefix('groups_users_link').' WHERE uid '.$uid_criteria;
    $result = $xoopsDB->query($sql);
    if (!$result) {
        return $ret;
    }
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $ret[$myrow['uid']][] = $myrow['groupid'];
    }
    foreach($ret as $uid=>$groups){
	    $ret[$uid] = array_unique($groups);
    }
    
    return $ret;
}

function newbb_getrank($rank_id =0, $posts = 0)
{
	static $ranks;
    $myts =& MyTextSanitizer::getInstance();
    
	if(empty($ranks)){
		if(!class_exists("XoopsRankHandler")):
		class XoopsRank extends ArtObject
		{
		    function XoopsRank()
		    {
		        $this->ArtObject();
		        $this->initVar('rank_id', XOBJ_DTYPE_INT, null, false);
		        $this->initVar('rank_title', XOBJ_DTYPE_TXTBOX, null, false);
		        $this->initVar('rank_min', XOBJ_DTYPE_INT, 0);
		        $this->initVar('rank_max', XOBJ_DTYPE_INT, 0);
		        $this->initVar('rank_special', XOBJ_DTYPE_INT, 0);
		        $this->initVar('rank_image', XOBJ_DTYPE_TXTBOX, "");
		    }
		}
		class XoopsRankHandler extends ArtObjectHandler
		{
		    function XoopsRankHandler(&$db) {
		        $this->ArtObjectHandler($db, 'ranks', 'XoopsRank', 'rank_id', 'rank_title');
		    }
		}
		$rank_handler =& new XoopsRankHandler($GLOBALS["xoopsDB"]);
		else:
		$rank_handler =& xoops_gethandler('rank');
		endif;
		$ranks = $rank_handler->getObjects(null, true, false);
	}
	
	$ret = array();
	if($rank_id>0){
		$ret["title"] = $myts->htmlspecialchars($ranks[$rank_id]["rank_title"]);		
		$ret["image"] = $ranks[$rank_id]["rank_image"];		
	}else{
		foreach($ranks as $id=>$rank){
			if($rank["rank_min"]<=$posts && $rank["rank_max"]>=$posts && empty($rank["rank_special"])){
				$ret["title"] = $myts->htmlspecialchars($rank["rank_title"]);		
				$ret["image"] = $rank["rank_image"];		
				break;
			}
		}
	}
	return $ret;
}

function get_user_level(& $user)
{

    $RPG = $user->getVar('posts');
    $RPGDIFF = $user->getVar('user_regdate');

    $today = time();
    $diff = $today - $RPGDIFF;
    $exp = round($diff / 86400,0);
    if ($exp<=0) { $exp = 1; }
    $ppd= round($RPG / $exp, 0);
    $level = pow (log10 ($RPG), 3);
    $ep = floor (100 * ($level - floor ($level)));
    $showlevel = floor ($level + 1);
    $hpmulti =round ($ppd / 6, 1);
    if ($hpmulti > 1.5) { $hpmulti = 1.5; }
    if ($hpmulti < 1) { $hpmulti = 1; }
    $maxhp = $level * 25 * $hpmulti;
    $hp= $ppd / 5;
    if ($hp >= 1) {
        $hp= $maxhp;
    } else {
        $hp= floor ($hp * $maxhp);
    }
    $hp= floor ($hp);
    $maxhp= floor ($maxhp);
    if ($maxhp <= 0) {
        $zhp = 1;
    } else {
        $zhp = $maxhp;
    }
    $hpf= floor (100 * ($hp / $zhp)) - 1;
    $maxmp= ($exp * $level) / 5;
    $mp= $RPG / 3;
    if ($mp >= $maxmp) { $mp = $maxmp; }
    $maxmp = floor ($maxmp);
    $mp = floor ($mp);
    if ($maxmp <= 0) {
        $zmp = 1;
    } else {
        $zmp = $maxmp;
    }
    $mpf= floor (100 * ($mp / $zmp)) - 1;
    if ( $hpf >= 98 ) { $hpf = $hpf - 2; }
    if ( $ep >= 98 ) { $ep = $ep - 2; }
    if ( $mpf >= 98 ) { $mpf = $mpf - 2; }

    $level = array();
    $level['level']  = $showlevel ;
    $level['exp'] = $ep;
    $level['exp_width'] = $ep.'%';
    $level['hp']  = $hp;
    $level['hp_max']  = $maxhp;
    $level['hp_width'] = $hpf.'%';
    $level['mp']  = $mp;
    $level['mp_max']  = $maxmp;
    $level['mp_width'] = $mpf.'%';

    return $level;
}

class User extends XoopsObject
{
	var $user = null;
    function User(&$user)
    {
	    if(!is_object($user)) return null;
	    $this->user=&$user;
    }

    function &getUserbar()
    {
	    global $xoopsUser, $isadmin;
	    
    	$user =& $this->user;
    	$userbar = array();
        $userbar[] = array("link"=>XOOPS_URL . "/userinfo.php?uid=" . $user->getVar("uid"), "name" =>_PROFILE);
		if (is_object($xoopsUser)){
        	$userbar[]= array("link"=>"javascript:void openWithSelfMain('" . XOOPS_URL . "/pmlite.php?send2=1&amp;to_userid=" . $user->getVar("uid") . "', 'pmlite', 450, 380);", "name"=>_MD_PM);
    	}
        if($user->getVar('user_viewemail') || (is_object($xoopsUser) && $xoopsUser->isAdmin()) )
        $userbar[]= array("link"=>"javascript:void window.open('mailto:" . $user->getVar('email') . "', 'new');", "name"=>_MD_EMAIL);
        if($user->getVar('url'))
        $userbar[]= array("link"=>"javascript:void window.open('" . $user->getVar('url') . "', 'new');", "name"=>_MD_WWW);
        if($user->getVar('user_icq'))
        $userbar[]= array("link"=>"javascript:void window.open('http://wwp.icq.com/scripts/search.dll?to=" . $user->getVar('user_icq')."', 'new');", "name" => _MD_ICQ);
        if($user->getVar('user_aim'))
        $userbar[]= array("link"=>"javascript:void window.open('aim:goim?screenname=" . $user->getVar('user_aim') . "&amp;message=Hi+" . $user->getVar('user_aim') . "+Are+you+there?" . "', 'new');", "name"=>_MD_AIM);
        if($user->getVar('user_yim'))
        $userbar[]= array("link"=>"javascript:void window.open('http://edit.yahoo.com/config/send_webmesg?.target=" . $user->getVar('user_yim') . "&.src=pg" . "', 'new');", "name"=> _MD_YIM);
        if($user->getVar('user_msnm'))
        $userbar[]= array("link"=>"javascript:void window.open('http://members.msn.com?mem=" . $user->getVar('user_msnm') . "', 'new');", "name" => _MD_MSNM);
		return $userbar;
    }

    function getLevel()
    {
	    global $xoopsModuleConfig, $forumUrl;
	    $user =& $this->user;
		$level = get_user_level($user);
		if($xoopsModuleConfig['user_level']==2){
			$table = "<table class='userlevel'><tr><td class='end'><img src='" . $forumUrl['images_set'] . "/rpg/img_left.gif' alt='' /></td><td class='center' background='" . $forumUrl['images_set'] . "/rpg/img_backing.gif'><img src='" . $forumUrl['images_set'] . "/rpg/%s.gif' width='%d' alt='' /></td><td><img src='" . $forumUrl['images_set'] . "/rpg/img_right.gif' alt='' /></td></tr></table>";

			$info = _MD_LEVEL . " " . $level['level'] . "<br />" . _MD_HP . " " . $level['hp'] . " / " . $level['hp_max'] . "<br />".
				sprintf($table, "orange", $level['hp_width']);
            $info .= _MD_MP . " " . $level['mp'] . " / " . $level['mp_max'] . "<br />".
				sprintf($table, "green", $level['mp_width']);
            $info .= _MD_EXP . " " . $level['exp'] . "<br />".
				sprintf($table, "blue", $level['exp_width']);
		}else{
			$info = _MD_LEVEL . " " . $level['level'] . "; ". _MD_EXP . " " . $level['exp'] . "<br />";
			$info .= _MD_HP . " " . $level['hp'] . " / " . $level['hp_max'] . "<br />";
            $info .= _MD_MP . " " . $level['mp'] . " / " . $level['mp_max'];
		}
		return $info;
    }

    function getInfo()
    {
	    global $xoopsModuleConfig, $myts;
	    $userinfo=array();
	    $user =& $this->user;
		if ( !(is_object($user)) || !($user->isActive()) )	 return array("name"=>$myts->HtmlSpecialChars($GLOBALS["xoopsConfig"]['anonymous']), "link"=>$myts->HtmlSpecialChars($GLOBALS["xoopsConfig"]['anonymous']));
		$userinfo["uid"] = $user->getVar("uid");
	    $name = $user->getVar('name');
	    $name = (empty($xoopsModuleConfig['show_realname'])||empty($name))?$user->getVar('uname'):$name;
		$userinfo["name"] = $name;
		$userinfo["link"] = "<a href=\"".XOOPS_URL . "/userinfo.php?uid=" . $user->getVar("uid") ."\">".$name."</a>";
		$userinfo["avatar"] = $user->getVar('user_avatar');
		$userinfo["from"] = $user->getVar('user_from');
		$userinfo["regdate"] = newbb_formatTimestamp($user->getVar('user_regdate'), 'reg');
		$userinfo["posts"] = $user->getVar('posts');
		$userinfo["groups_id"] = $user -> getGroups();
		if(!empty($xoopsModuleConfig['user_level'])){
			$userinfo["level"] = $this->getLevel();
		}
		if(!empty($xoopsModuleConfig['userbar_enabled'])){
			$userinfo["userbar"] = $this->getUserbar();
		}

		$rank = newbb_getrank($user->getVar("rank"), $user->getVar("posts"));
		$userinfo['rank']["title"] = $rank['title'];
	    if (!empty($rank['image'])) {
	        $userinfo['rank']['image'] = "<img src='" . XOOPS_UPLOAD_URL . "/" . htmlspecialchars($rank['image'], ENT_QUOTES) . "' alt='' />";
	    }
		$var = $user->getVar('user_sig', 'N');
        $userinfo["signature"] = $myts->displayTarea($var, 1, 1, 1, 1, 1);
	    return $userinfo;
    }
}

class NewbbUserHandler extends XoopsObjectHandler
{
	var $users = array();
	var $groups = array();
	var $status = array();

    function &get($uid)
    {
	    global $xoopsModuleConfig, $forumImage;
	    $userinfo = array();
	    
        if(!isset($this->users[$uid])) return $userinfo;
        if(class_exists("User_language")){
        	$user = new User_language($this->users[$uid]);
    	}else{
        	$user = new User($this->users[$uid]);
    	}
        $userinfo = $user->getInfo();
		if($xoopsModuleConfig['groupbar_enabled'] && !empty($userinfo["groups_id"])){
			foreach($userinfo["groups_id"] as $id){
				if(isset($this->groups[$id])) $userinfo['groups'][] = $this->groups[$id];
			}
		}
	    if ($xoopsModuleConfig['wol_enabled']) {
	        $userinfo["status"] = isset($this->status[$uid]) ?
	        	newbb_displayImage($forumImage['online'], _MD_ONLINE) :
	        	newbb_displayImage($forumImage['offline'],_MD_OFFLINE);
	    }
		return $userinfo;
    }

    function setUsers(&$users)
    {
	    $groups = newbb_getGroupsByUser(array_keys($users));
	    foreach(array_keys($users) as $uid){
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
}

?>