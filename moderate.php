<?php
// $Id: moderate.php,v 1.1.1.1 2005/10/19 16:23:25 phppp Exp $
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
include 'header.php';

$forum_id = isset($_POST['forum']) ? intval($_POST['forum']) : 0;
$forum_id = isset($_GET['forum']) ? intval($_GET['forum']) : $forum_id;

$isadmin = newbb_isAdmin($forum_id);
if(!$isadmin){
    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
    exit();
}
$is_administrator = newbb_isAdmin();

$moderate_handler =& icms_getmodulehandler('moderate', basename( dirname( __FILE__ ) ), 'iforum' );

if(!empty($_POST["submit"])&&!empty($_POST["expire"])){
	if( !empty($_POST["ip"]) && !preg_match("/^([0-9]{1,3}\.){0,3}[0-9]{1,3}$/", $_POST["ip"])) $_POST["ip"]="";
	if(
		(!empty($_POST["uid"]) && $moderate_handler->getLatest($_POST["uid"])>(time()+$_POST["expire"]*3600*24))
		||
		(!empty($_POST["ip"]) && $moderate_handler->getLatest($_POST["ip"], false)>(time()+$_POST["expire"]*3600*24))
		||
		(empty($_POST["uid"]) && empty($_POST["ip"]))
	){
	}else{
		$moderate_obj =& $moderate_handler->create();
		$moderate_obj->setVar("uid", @$_POST["uid"]);
		$moderate_obj->setVar("ip", @$_POST["ip"]);
		$moderate_obj->setVar("forum_id", $forum_id);
		$moderate_obj->setVar("mod_start", time());
		$moderate_obj->setVar("mod_end", time()+$_POST["expire"]*3600*24);
		$moderate_obj->setVar("mod_desc", @$_POST["desc"]);
		if($res = $moderate_handler->insert($moderate_obj) && !empty($forum_id) && !empty($_POST["uid"]) ){
			$uname = XoopsUser::getUnameFromID($_POST["uid"]);
			$post_handler =& icms_getmodulehandler("post", basename( dirname( __FILE__ ) ), 'iforum' );
			$forumpost =& $post_handler->create();
		    $forumpost->setVar("poster_ip", newbb_getIP());
		    $forumpost->setVar("uid", empty($GLOBALS["xoopsUser"])?0:$GLOBALS["xoopsUser"]->getVar("uid"));
		    $forumpost->setVar("forum_id", $forum_id);
			$forumpost->setVar("subject", sprintf(_MD_SUSPEND_SUBJECT, $uname, $_POST["expire"]));
			$forumpost->setVar("post_text", sprintf(_MD_SUSPEND_TEXT, '<a href="' . XOOPS_URL . '/userinfo.php?uid='.$_POST["uid"].'">'.$uname.'</a>', $_POST["expire"], @$_POST["desc"], formatTimestamp(time()+$_POST["expire"]*3600*24) ));
		    $forumpost->setVar("dohtml", 1);
		    $forumpost->setVar("dosmiley", 1);
		    $forumpost->setVar("doxcode", 1);
		    $forumpost->setVar("post_time", time());
			$post_handler->insert($forumpost);
			unset($forumpost);
		}
		if($_POST["uid"]>0){
			$online_handler =& xoops_gethandler('online');
			$onlines =& $online_handler->getAll(new Criteria("online_uid", $_POST["uid"]));
			if (false != $onlines) {
    			$online_ip = $onlines[0]["online_ip"];
				$sql = sprintf('DELETE FROM %s WHERE sess_ip = %s', $xoopsDB->prefix('session'), $xoopsDB->quoteString($online_ip));
		        if ( !$result = $xoopsDB->queryF($sql) ) {
		        }
			}
		}
		if(!empty($_POST["ip"])){
			$sql = 'DELETE FROM '.$xoopsDB->prefix('session').' WHERE sess_ip LIKE '.$xoopsDB->quoteString('%'.$_POST["ip"]);
	        if ( !$result = $xoopsDB->queryF($sql) ) {
	        }
		}
		redirect_header("moderate.php?forum=$forum_id", 2, _MD_DBUPDATED);
		exit();
	}
}elseif(!empty($_GET["del"])){
	$moderate_obj =& $moderate_handler->get($_GET["del"]);
	if($is_administrator || $moderate_obj->getVar("forum_id")==$forum_id){
		$moderate_handler->delete($moderate_obj, true);
		redirect_header("moderate.php?forum=$forum_id", 2, _MD_DBUPDATED);
		exit();
	}
}

$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$sortname = isset($_GET['sort']) ? $_GET['sort'] : "";

switch($sortname){
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

$criteria = new Criteria("forum_id", "(0, ".$forum_id.")", "IN");
$criteria->setLimit($xoopsModuleConfig['topics_per_page']);
$criteria->setStart($start);
$criteria->setSort($sort);
$criteria->setOrder($order);
$moderate_objs =& $moderate_handler->getObjects($criteria);
$moderate_count = $moderate_handler->getCount($criteria);

include XOOPS_ROOT_PATH.'/header.php';
if($forum_id){
	$url = 'viewforum.php?forum='.$forum_id;
}else{
	$url = 'index.php';
}
echo '<div style="padding: 10px; margin-left:auto; margin-right:auto; text-align:center;"><a href="'.$url.'"><h2>'._MD_SUSPEND_MANAGEMENT.'</h2></a></div>';

if(!empty($moderate_count)){
	$_users = array();
	foreach(array_keys($moderate_objs) as $id){
		$_users[$moderate_objs[$id]->getVar("uid")] = 1;
	}
	$users =& newbb_getUnameFromIds(array_keys($_users), $xoopsModuleConfig['show_realname'], true);
	
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
	
	foreach(array_keys($moderate_objs) as $id){
		echo '	
			<tr>
				<td width="5%" align="center" nowrap="nowrap">
					'.(
						$moderate_objs[$id]->getVar("uid")?
							(isset($users[$moderate_objs[$id]->getVar("uid")])?$users[$moderate_objs[$id]->getVar("uid")]:$moderate_objs[$id]->getVar("uid"))
							:$moderate_objs[$id]->getVar("ip")
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
					'.
					( ($is_administrator || $moderate_objs[$id]->getVar("forum_id")==$forum_id)?'<a href="moderate.php?forum='.$forum_id.'&amp;del='.$moderate_objs[$id]->getVar("mod_id").'">'._DELETE.'</a>':' ').'
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
	if ( $moderate_count > $xoopsModuleConfig['topics_per_page']) {
		include XOOPS_ROOT_PATH.'/class/pagenav.php';
		$nav = new XoopsPageNav($all_topics, $xoopsModuleConfig['topics_per_page'], $start, "start", 'forum='.$forum_id.'&amp;sort='.$sortname);
		echo '<tr><td colspan="6">'.$nav->renderNav(4).'</td></tr>';
	}
	
	echo '</table><br /><br />';			
}

include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
$forum_form = new XoopsThemeForm(_ADD, 'suspend', "moderate.php", 'post');
$forum_form->addElement(new XoopsFormText(_MD_SUSPEND_UID, 'uid', 20, 25));
$forum_form->addElement(new XoopsFormText(_MD_SUSPEND_IP, 'ip', 20, 25));
$forum_form->addElement(new XoopsFormText(_MD_SUSPEND_DURATION, 'expire', 20, 25, ''), true);
$forum_form->addElement(new XoopsFormText(_MD_SUSPEND_DESC, 'desc', 50, 255));
$forum_form->addElement(new XoopsFormHidden('forum', $forum_id));
$forum_form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, "submit"));
$forum_form->display();
include XOOPS_ROOT_PATH.'/footer.php';
?>