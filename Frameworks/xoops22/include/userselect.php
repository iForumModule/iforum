<?php
// $Id: userselect.php,v 1.1.2.11 2005/09/11 15:37:11 phppp Exp $
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                      //
// Copyright (c) 2000 XOOPS.org                           //
// <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

// Where to locate the file? Member search should be restricted
// Limitation: Only work with javascript enabled 

include("../../../mainfile.php");
$moduleperm_handler = & xoops_gethandler( 'groupperm' );
if ( !is_object($xoopsUser) 
	|| ( empty($_REQUEST["mid"]) && $xoopsUser->isAdmin() ) 
	|| !$moduleperm_handler->checkRight( 'module_admin', $_REQUEST["mid"], $xoopsUser->getGroups() )
) {
    redirect_header( XOOPS_URL . "/user.php", 1, _NOPERM );
    exit();
}


include_once XOOPS_ROOT_PATH . "/include/cp_functions.php";
include_once dirname(dirname(__FILE__))."/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH . "/class/pagenav.php";
if(!@include_once dirname(dirname(__FILE__))."/language/".$xoopsConfig["language"]."/user.php"){
	include_once dirname(dirname(__FILE__))."/language/english/user.php";
}
xoops_cp_header();

$start = (isset($_GET['start']))?$_GET['start']:0;
$_REQUEST['group'] = empty($_REQUEST['group'])?0:$_REQUEST['group'];
$_REQUEST['level'] = empty($_REQUEST['level'])?-999:$_REQUEST['level'];
$_REQUEST['rank'] = empty($_REQUEST['rank'])?0:$_REQUEST['rank'];
$_REQUEST['searchText'] = isset($_REQUEST['searchText'])?trim($_REQUEST['searchText']):"";
$limit = 200;
$size = isset($_REQUEST['multiple']) && $_REQUEST['multiple'] ? 20 : 1;
$valid_subjects = array("uname"=>_MA_SEARCH_NAME, "email"=>_MA_SEARCH_EMAIL, "uid"=> _MA_SEARCH_UID);

$name_parent = $_REQUEST["target"];
$name_current = 'users';
echo $js_adduser='
	<script type="text/javascript">
	var multiple='.intval($_REQUEST['multiple']).';
	function addusers(){
        var sel_current = xoopsGetElementById("'.$name_current.($_REQUEST['multiple']?'[]':'').'");
        var sel_str="";
        var num = 0;
		for (var i = 0; i < sel_current.options.length; i++) {
			if (sel_current.options[i].selected) {
				var len=sel_current.options[i].text.length+sel_current.options[i].value.length;
				sel_str +=len+":"+sel_current.options[i].value+":"+sel_current.options[i].text;
				num ++;
			}
		}
		if(num==0) {
			if(multiple==0){ 
				window.close();
			}
			return false;
		}
		sel_str = num+":"+sel_str;
        window.opener.addusers(sel_str);
		if(multiple==0){ 
			window.close();
			window.opener.focus();
		}
        return true;
	}
	</script>
';

$member_handler = &xoops_gethandler('member');
if(!empty($_REQUEST["action"])){
	if(!class_exists("XoopsRankHandler")):
	require_once(dirname(dirname(dirname(__FILE__)))."/art/object.php"); 
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
	$rank_handler =& new XoopsRankHandler($xoopsDB);
	else:
	$rank_handler = xoops_gethandler('rank');
	endif;
	$ranks =& $rank_handler->getList();
	$groups =& $member_handler->getGroupList();
	$ranks[0] = _NONE;
	$groups[0] = _NONE;
}

if(empty($_REQUEST["action"])){
	$form_sel = new XoopsThemeForm(_MA_LOOKUP_USER, "searchusers", xoops_getenv('PHP_SELF'));
	
	$sel_box = new XoopsFormSelect(_MA_SEARCHBY, 'subject', empty($_REQUEST['subject'])?NULL:$_REQUEST['subject']);
	$sel_box->addOptionArray($valid_subjects);
	$form_sel->addElement($sel_box);
	
	$searchtext = new XoopsFormText(_MA_SEARCH_TEXT, 'searchText', 60, 255, empty($_REQUEST['searchText'])?NULL:$_REQUEST['searchText']);
	$searchtext->setDescription(_MA_SEARCH_TEXT_DESC);
	$form_sel->addElement($searchtext);
	
	$close_button = new XoopsFormButton('', '', _CLOSE, 'button');
	$close_button->setExtra('onclick="window.close()"') ;
	
	$button_tray = new XoopsFormElementTray("");
	$button_tray->addElement(new XoopsFormButton('', 'search', _SEARCH, 'submit'));
	$button_tray->addElement($close_button);
	
	$form_sel->addElement(new XoopsFormHidden('action', $_REQUEST["action"]));
	$form_sel->addElement(new XoopsFormHidden('target', $_REQUEST["target"]));
	$form_sel->addElement(new XoopsFormHidden('multiple', $_REQUEST["multiple"]));
	$form_sel->addElement(new XoopsFormHidden('mid', $_REQUEST["mid"]));
	$form_sel->addElement($button_tray);
	$form_sel->display();   
	     
}

if(!empty($_REQUEST["action"])||!empty($_REQUEST["search"])){
    $form_user = new XoopsThemeForm(_MA_SEARCH_SELECTUSER, "selectusers", xoops_getenv('PHP_SELF'));

    $myts =& MyTextSanitizer::getInstance();
    $criteria = new CriteriaCompo();
   
	if(!empty($_REQUEST['search'])){
	    $text = empty($_REQUEST['searchText'])?"%":$myts->addSlashes(trim($_REQUEST['searchText']));
	    $subject = in_array($_REQUEST['subject'], array_keys($valid_subjects))?trim($_REQUEST['subject']):"uname";
	    $crit = new Criteria($subject, $text, 'LIKE');
		$criteria->add($crit);
	    $sort = $subject;
	    $nav_extra =
	    	"action=".$_REQUEST["action"]."&amp;target=".$_REQUEST["target"]."&amp;multiple=".$_REQUEST["multiple"].
	    	"&amp;searchText=".$_REQUEST['searchText']."&amp;search=1&amp;subject=".$_REQUEST['subject']."&amp;mid=".$_REQUEST["mid"];
    }else{
	    $crit = null;
	    $sort = "uname";
	    $nav_extra =
    		"action=".$_REQUEST["action"]."&amp;target=".$_REQUEST["target"]."&amp;multiple=".$_REQUEST["multiple"].
	    	"&amp;group=".$_REQUEST['group']."&amp;level=".$_REQUEST['level']."&amp;rank=".$_REQUEST['rank']."&amp;mid=".$_REQUEST["mid"];
		if(!empty($_REQUEST["group"])){
			$uids = $member_handler->getUsersByGroup(intval($_REQUEST["group"]), false, $limit, $start);
		    $id_in = "(".implode(",", $uids).")";
	    	$crit_group = new Criteria("uid", $id_in, "IN");
			$criteria->add($crit_group);
    		$usercount = $member_handler->getUserCountByGroup(intval($_REQUEST["group"]));
		}else{
			if(!empty($_REQUEST["rank"])){
		    	$crit_rank = new Criteria("rank", intval($_REQUEST["rank"]));
				$criteria->add($crit_rank);
			}
			if(!empty($_REQUEST["level"])){
				$level_value = array(1=>1, 2=>0, 3=>-1);
				$level = isset($level_value[intval($_REQUEST["level"])])? $level_value[intval($_REQUEST["level"])] : 1;
		    	$crit_level = new Criteria("level", $level);
				$criteria->add($crit_level);
			}
		}
    }
    
    $criteria->setSort($sort);
    $criteria->setLimit($limit);
    $criteria->setStart($start);
    $select_form = new XoopsFormSelect("", "users", array(), $size, $_REQUEST["multiple"]);
    $select_form->addOptionArray($member_handler->getUserList($criteria));
    
    $user_select_tray = new XoopsFormElementTray(_MA_SEARCH_USERLIST, "<br />");
    $user_select_tray->addElement($select_form);
    $usercount = isset($usercount)? $usercount : $member_handler->getUserCount($criteria);
    $nav = new XoopsPageNav($usercount, $limit, $start, "start", $nav_extra);
    $user_select_nav = new XoopsFormLabel(sprintf(_MA_SEARCH_COUNT, $usercount), $nav->renderNav(4));
    $user_select_tray->addElement($user_select_nav);
    
    $add_button = new XoopsFormButton('', '', _ADD, 'button');
	$add_button->setExtra('onclick="addusers();"') ;

    $close_button = new XoopsFormButton('', '', _CLOSE, 'button');
	$close_button->setExtra('onclick="window.close()"') ;

    $button_tray = new XoopsFormElementTray("");
    $button_tray->addElement($add_button);
    $button_tray->addElement(new XoopsFormButton('', '', _CANCEL, 'reset'));
    $button_tray->addElement($close_button);

    $form_user->addElement($user_select_tray);
    
    if(!empty($_REQUEST["action"])){    
	    $group_select = new XoopsFormSelect(_MA_SEARCH_GROUP, 'group', $_REQUEST['group']);
		$group_select->addOptionArray($groups);
		$group_select->setDescription(_MA_SEARCH_GROUP_DESC);
	    $level_select = new XoopsFormSelect(_MA_SEARCH_LEVEL, 'level', $_REQUEST['level']);
	    $levels = array(0=>_NONE, 1=>_MA_SEARCH_LEVEL_ACTIVE, 2=>_MA_SEARCH_LEVEL_INACTIVE, 3=>_MA_SEARCH_LEVEL_DISABLED);
		$level_select->addOptionArray($levels);
	    $rank_select = new XoopsFormSelect(_MA_SEARCH_RANK, 'rank', $_REQUEST['rank']);
		$rank_select->addOptionArray($ranks);
	    $form_user->addElement($group_select);
	    $form_user->addElement($level_select);	    
	    $form_user->addElement($rank_select);	    

	    $refresh_button = new XoopsFormButton('', '', _MA_SEARCH_REFRESH, 'submit');
    	$button_tray->addElement($refresh_button);
    }
    
    $form_user->addElement(new XoopsFormHidden('action', $_REQUEST["action"]));
    $form_user->addElement(new XoopsFormHidden('target', $_REQUEST["target"]));
    $form_user->addElement(new XoopsFormHidden('multiple', $_REQUEST["multiple"]));
    $form_user->addElement(new XoopsFormHidden('mid', $_REQUEST["mid"]));
    $form_user->addElement($button_tray);
    $form_user->display();        
}

$xoopsOption['output_type'] = "plain";
xoops_cp_footer();
?>