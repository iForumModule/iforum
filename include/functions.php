<?php
// $Id: functions.php,v 1.1.8.5 2005/01/10 14:21:12 praedator Exp $
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
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

function newbb_getUnameFromId( $userid, $usereal = 0 )
{
	$userid = intval($userid);
	$usereal = intval($usereal);
	if ($userid > 0) {
        $member_handler =& xoops_gethandler('member');
        $user =& $member_handler->getUser($userid);
        if (is_object($user)) {
            $ts =& MyTextSanitizer::getInstance();
            if ( $usereal && $user->getVar('name') ) {
				return $ts->htmlSpecialChars($user->getVar('name'));
        	} else {
				return $ts->htmlSpecialChars($user->getVar('uname'));
			}
        }
    }
    return $GLOBALS['xoopsConfig']['anonymous'];
}

function newbb_attachmentImage($source)
{
	global $xoopsModuleConfig;

	$img_path = XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig['dir_attachments'];
	$img_url = XOOPS_URL.'/'.$xoopsModuleConfig['dir_attachments'];
	$thumb_path = $img_path.'/thumbs';
	$thumb_url = $img_url.'/thumbs';

	$thumb = $thumb_path.'/'.$source;
	$image = $img_path.'/'.$source;
	$thumb_url = $thumb_url.'/'.$source;
	$image_url = $img_url.'/'.$source;

	$imginfo = @getimagesize($image);
	$img_info = ( count($imginfo)>0 )?$imginfo[0]."X".$imginfo[1].' px':"";

	if($xoopsModuleConfig['max_img_width']>0){
		if($imginfo[0]>$xoopsModuleConfig['max_image_width'] || $imginfo[1]>$xoopsModuleConfig['max_image_height']){
			if($imginfo[0]>$xoopsModuleConfig['max_img_width']){
				$pseudo_width = $xoopsModuleConfig['max_img_width'];
				$pseudo_height = $xoopsModuleConfig['max_img_width']*($imginfo[1]/$imginfo[0]);
				$pseudo_size = "width='".$pseudo_width."px' height='".$pseudo_height."px'";
			}
			if($pseudo_height>$xoopsModuleConfig['max_image_height']){
				$pseudo_height = $xoopsModuleConfig['max_image_height'];
				$pseudo_width = $xoopsModuleConfig['max_image_height']*($imginfo[0]/$imginfo[1]);
				$pseudo_size = "width='".$pseudo_width."px' height='".$pseudo_height."px'";
			}
		}else
		if(!file_exists($thumb_path.'/'.$source) && $imginfo[0]>$xoopsModuleConfig['max_img_width']){
			newbb_createThumbnail($source, $xoopsModuleConfig['max_img_width']);
		}
	}


	if(file_exists($thumb)){
		$attachmentImage  = '<a href="'.$image_url.'" title="'.$source.' '.$img_info.'" target="newbb_image">';
		$attachmentImage .= '<img src="'.$thumb_url.'" alt="'.$source.' '.$img_info.'" />';
		$attachmentImage .= '</a>';
	}elseif(!empty($pseudo_size)){
		$attachmentImage  = '<a href="'.$image_url.'" title="'.$source.' '.$img_info.'" target="newbb_image">';
		$attachmentImage .= '<img src="'.$image_url.'" '.$pseudo_size.' alt="'.$source.' '.$img_info.'" />';
		$attachmentImage .= '</a>';
	}elseif(file_exists($image)){
		$attachmentImage = '<img src="'.$image_url.'" alt="'.$source.' '.$img_info.'" />';
	}else $attachmentImage = '';

	return $attachmentImage;
}


function newbb_createThumbnail($source, $thumb_width)
{
	global $xoopsModuleConfig;

	$img_path = XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig['dir_attachments'];
	$thumb_path = $img_path.'/thumbs';
	$src_file = $img_path.'/'.$source;
	$new_file = $thumb_path.'/'.$source;
	$imageLibs = newbb_getImageLibs();

	if (!filesize($src_file) || !is_readable($src_file)) {
		return false;
	}

	if (!is_dir($thumb_path) || !is_writable($thumb_path)) {
		return false;
	}

	$imginfo = @getimagesize($src_file);
	if ( NULL == $imginfo ) {
		return false;
	}
	if($imginfo[0] < $thumb_width) {
		return false;
	}

	$newWidth = (int)(min($imginfo[0],$thumb_width));
	$newHeight = (int)($imginfo[1] * $newWidth / $imginfo[0]);

	if ($xoopsModuleConfig['image_lib'] == 1 or $xoopsModuleConfig['image_lib'] == 0 )
	{
		if (preg_match("#[A-Z]:|\\\\#Ai",__FILE__)){
			$cur_dir = dirname(__FILE__);
			$src_file_im = '"'.$cur_dir.'\\'.strtr($src_file, '/', '\\').'"';
			$new_file_im = '"'.$cur_dir.'\\'.strtr($new_file, '/', '\\').'"';
		} else {
			$src_file_im =   @escapeshellarg($src_file);
			$new_file_im =   @escapeshellarg($new_file);
		}
		$path = empty($xoopsModuleConfig['path_magick'])?"":$xoopsModuleConfig['path_magick']."/";
		$magick_command = $path . 'convert -quality 85 -antialias -sample ' . $newWidth . 'x' . $newHeight . ' ' . $src_file_im . ' +profile "*" ' . str_replace('\\', '/', $new_file_im) . '';

		@passthru($magick_command);
		if (file_exists($new_file)){
				return true;
		}
	}

	if ($xoopsModuleConfig['image_lib'] == 2 or $xoopsModuleConfig['image_lib'] == 0 )
	{
		$path = empty($xoopsModuleConfig['path_netpbm'])?"":$xoopsModuleConfig['path_netpbm']."/";
		if (eregi("\.png", $source)){
			$cmd = $path . "pngtopnm $src_file | ".$path . "pnmscale -xysize $newWidth $newHeight | ".$path . "pnmtopng > $new_file" ;
		}
		else if (eregi("\.(jpg|jpeg)", $source)){
			$cmd = $path . "jpegtopnm $src_file | ".$path . "pnmscale -xysize $newWidth $newHeight | ".$path . "ppmtojpeg -quality=90 > $new_file" ;
		}
		else if (eregi("\.gif", $source)){
			$cmd = $path . "giftopnm $src_file | ".$path . "pnmscale -xysize $newWidth $newHeight | ppmquant 256 | ".$path . "ppmtogif > $new_file" ;
		}

		@exec($cmd, $output, $retval);
		if (file_exists($new_file)){
				return true;
		}
	}

	$type = $imginfo[2];
	$supported_types = array();

	if (!extension_loaded('gd')) return false;
	if (function_exists('imagegif')) $supported_types[] = 1;
	if (function_exists('imagejpeg'))$supported_types[] = 2;
	if (function_exists('imagepng')) $supported_types[] = 3;

    $imageCreateFunction = (function_exists('imagecreatetruecolor'))? "imagecreatetruecolor" : "imagecreate";

	if (in_array($type, $supported_types) )
	{
		switch ($type)
		{
			case 1 :
				if (!function_exists('imagecreatefromgif')) return false;
				$im = imagecreatefromgif($src_file);
				$new_im = imagecreate($newWidth, $newHeight);
				imagecopyresized($new_im, $im, 0, 0, 0, 0, $newWidth, $newHeight, $imginfo[0], $imginfo[1]);
				imagegif($new_im, $new_file);
				imagedestroy($im);
				imagedestroy($new_im);
				break;
			case 2 :
				$im = imagecreatefromjpeg($src_file);
				$new_im = $imageCreateFunction($newWidth, $newHeight);
				imagecopyresized($new_im, $im, 0, 0, 0, 0, $newWidth, $newHeight, $imginfo[0], $imginfo[1]);
				imagejpeg($new_im, $new_file, 90);
				imagedestroy($im);
				imagedestroy($new_im);
				break;
			case 3 :
				$im = imagecreatefrompng($src_file);
				$new_im = $imageCreateFunction($newWidth, $newHeight);
				imagecopyresized($new_im, $im, 0, 0, 0, 0, $newWidth, $newHeight, $imginfo[0], $imginfo[1]);
				imagepng($new_im, $new_file);
				imagedestroy($im);
				imagedestroy($new_im);
				break;
		}
	}


	if (file_exists($new_file))	return true;
	else return false;
}

function newbb_is_dir($dir){
    $openBasedir = ini_get('open_basedir');
    if (empty($openBasedir)) {
	    return is_dir($dir);
    }

    return in_array($dir, explode(':', $openBasedir));
}

/*
 * Sorry, we have to use the stupid solution unless there is an option in MyTextSanitizer:: htmlspecialchars();
 */
function &newbb_htmlSpecialChars($text)
{
	return preg_replace(array("/&amp;/i", "/&nbsp;/i"), array('&', '&amp;nbsp;'), htmlspecialchars($text));
}

function &newbb_displayTarea(&$text, $html = 0, $smiley = 1, $xcode = 1, $image = 1, $br = 1)
{
	global $myts;

	if ($html != 1) {
		// html not allowed
		$text =& newbb_htmlSpecialChars($text);
	}
	$text =& $myts->codePreConv($text, $xcode); // Ryuji_edit(2003-11-18)
	$text =& $myts->makeClickable($text);
	if ($smiley != 0) {
		// process smiley
		$text =& $myts->smiley($text);
	}
	if ($xcode != 0) {
		// decode xcode
		if ($image != 0) {
			// image allowed
			$text =& $myts->xoopsCodeDecode($text);
        		} else {
            		// image not allowed
            		$text =& $myts->xoopsCodeDecode($text, 0);
		}
	}
	if ($br != 0) {
		$text =& $myts->nl2Br($text);
	}
	$text =& $myts->codeConv($text, $xcode, $image);	// Ryuji_edit(2003-11-18)
	return $text;
}

// The function is intended to filter out possible malicious text, on a very beginning stage tho
// kses project at SF could be a good solution to adapt in our next step
function &newbb_textFilter($text)
{
	global $xoopsConfig;
	$tags=empty($xoopsConfig['filter_tags'])?array():explode(",",$xoopsConfig['filter_tags']);
	$tags = array_map("trim", $tags);
	if(count($tags)==0)
	//return $text;
	$tags[] = "script";
	$tags[] = "vbscript";
	$tags[] = "javascript";
	//$tags[] = "iframe";
	foreach($tags as $tag){
		$search[] = "'<".$tag."[^>]*?>.*?</".$tag.">'si";
		$replace[] = " !FILTERED! ";
	}
	//$search[]= "'<iframe[^>]*?/>'si";
	//$replace[]=" !FILTERED! ";
	$text = preg_replace($search, $replace, $text);
	return $text;
}

function newbb_html2text($document)
{
	// PHP Manual:: function preg_replace
	// $document should contain an HTML document.
	// This will remove HTML tags, javascript sections
	// and white space. It will also convert some
	// common HTML entities to their text equivalent.

	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
	                 "'<[\/\!]*?[^<>]*?>'si",          // Strip out HTML tags
	                 "'([\r\n])[\s]+'",                // Strip out white space
	                 "'&(quot|#34);'i",                // Replace HTML entities
	                 "'&(amp|#38);'i",
	                 "'&(lt|#60);'i",
	                 "'&(gt|#62);'i",
	                 "'&(nbsp|#160);'i",
	                 "'&(iexcl|#161);'i",
	                 "'&(cent|#162);'i",
	                 "'&(pound|#163);'i",
	                 "'&(copy|#169);'i",
	                 "'&#(\d+);'e");                    // evaluate as php

	$replace = array ("",
	                 "",
	                 "\\1",
	                 "\"",
	                 "&",
	                 "<",
	                 ">",
	                 " ",
	                 chr(161),
	                 chr(162),
	                 chr(163),
	                 chr(169),
	                 "chr(\\1)");

	$text = preg_replace($search, $replace, $document);
	return $text;
}

/*
 * Currently the newbb session/cookie handlers are limited to:
 * -- one dimension
 * -- "," and "|" are preserved
 *
 */

function newbb_setsession($name, $string = '')
{
	if(is_array($string)) {
		$value = array();
		foreach ($string as $key => $val){
			$value[]=$key."|".$val;
		}
		$string = implode(",", $value);
	}
	$_SESSION['newbb_'.$name] = $string;
}

function newbb_getsession($name, $isArray = false)
{
	$value = !empty($_SESSION['newbb_'.$name]) ? $_SESSION['newbb_'.$name] : false;
	if($isArray) {
		$_value = ($value)?explode(",", $value):array();
		$value = array();
		if(count($_value)>0) foreach($_value as $string){
			$key = substr($string, 0, strpos($string,"|"));
			$val = substr($string, (strpos($string,"|")+1));
			$value[$key] = $val;
		}
		unset($_value);
	}
	return $value;
}

function newbb_setcookie($name, $string = '', $expire = 0)
{
	global $forumCookie;
	if(is_array($string)) {
		$value = array();
		foreach ($string as $key => $val){
			$value[]=$key."|".$val;
		}
		$string = implode(",", $value);
	}
	setcookie($forumCookie['prefix'].$name, $string, intval($expire), $forumCookie['path'], $forumCookie['domain'], $forumCookie['secure']);
}

function newbb_getcookie($name, $isArray = false)
{
	global $forumCookie;
	$value = !empty($_COOKIE[$forumCookie['prefix'].$name]) ? $_COOKIE[$forumCookie['prefix'].$name] : false;
	if($isArray) {
		$_value = ($value)?explode(",", $value):array();
		$value = array();
		if(count($_value)>0) foreach($_value as $string){
			$key = substr($string, 0, strpos($string,"|"));
			$val = substr($string, (strpos($string,"|")+1));
			$value[$key] = $val;
		}
		unset($_value);
	}
	return $value;
}

function newbb_checkTimelimit($action_last, $action_tag, $inMinute = true)
{
	global $xoopsModuleConfig;
	if(!isset($xoopsModuleConfig[$action_tag]) or $xoopsModuleConfig[$action_tag]==0) return true;
	$timelimit = ($inMinute)?$xoopsModuleConfig[$action_tag]*60:$xoopsModuleConfig[$action_tag];
	return ($action_last > time()-$timelimit)?true:false;
}


function &getModuleAdministrators($mid=0)
{
	static $module_administrators=array();
	if(isset($module_administrators[$mid])) return $module_administrators[$mid];

    $moduleperm_handler =& xoops_gethandler('groupperm');
    $groupsIds = $moduleperm_handler->getGroupIds('module_admin', $mid);

    $administrators = array();
    $member_handler =& xoops_gethandler('member');
    foreach($groupsIds as $groupid){
    	$userIds = $member_handler->getUsersByGroup($groupid);
    	foreach($userIds as $userid){
        	$administrators[$userid] = 1;
    	}
    }
    $module_administrators[$mid] =array_keys($administrators);
    unset($administrators);
    return $module_administrators[$mid];
}

function newbb_isAdministrator($user=-1, $mid=0)
{
	global $xoopsUser;
	static $administrators, $xoopsModule, $newBB_mid;

	if($user == -1) $user = &$xoopsUser;
	if(!is_object($user) && intval($user)<1) return false;
	$uid = (is_object($user))?$user->getVar('uid'):intval($user);

	if(!$mid){
		if (!isset($newBB_mid)) {
		    if(is_object($xoopsModule)&& 'newbb' == $xoopsModule->dirname()){
		    	$newBB_mid = $xoopsModule->getVar('mid');
		    }else{
		        $modhandler = &xoops_gethandler('module');
		        $newBB = &$modhandler->getByDirname('newbb');
			    $newBB_mid = $newBB->getVar('mid');
			    unset($newBB);
		    }
		}
		$mid = $newBB_mid;
	}

	if(!isset($administrators)) {
		$administrators =& getModuleAdministrators($mid);
	}

	return in_array($uid,$administrators);
}

function newbb_isAdmin($forum = 0, $user=-1)
{
	global $xoopsUser;
	static $_cachedModerators;

	if($user == -1) $user = &$xoopsUser;
	if(!is_object($user) && intval($user)<1) return false;
	$uid = (is_object($user))?$user->getVar('uid'):intval($user);
	if(newbb_isAdministrator($uid)) return true;

	$cache_id = (is_object($forum))?$forum->getVar('forum_id'):intval($forum);
	if(!isset($_cachedModerators[$cache_id])){
		$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
		if(!is_object($forum)) $forum = $forum_handler->get(intval($forum));
		$_cachedModerators[$cache_id] = &$forum_handler->getModerators($forum);
	}
	return in_array($uid,$_cachedModerators[$cache_id]);
}

function newbb_isModerator($forum = 0, $user=-1)
{
	global $xoopsUser;
	static $_cachedModerators;

	if($user == -1) $user = &$xoopsUser;
	if(!is_object($user) && intval($user)<1) return false;
	$uid = (is_object($user))?$user->getVar('uid'):intval($user);

	$cache_id = (is_object($forum))?$forum->getVar('forum_id'):intval($forum);
	if(!isset($_cachedModerators[$cache_id])){
		$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
		if(!is_object($forum)) $forum = $forum_handler->get(intval($forum));
		$_cachedModerators[$cache_id] = &$forum_handler->getModerators($forum);
	}
	return in_array($uid,$_cachedModerators[$cache_id]);
}

function newbb_checkSubjectPrefixPermission($forum = 0, $user=-1)
{
	global $xoopsUser, $xoopsModuleConfig;

	if($xoopsModuleConfig['subject_prefix_level']<1){
		return false;
	}
	if($xoopsModuleConfig['subject_prefix_level']==1){
		return true;
	}
	if($user == -1) $user = &$xoopsUser;
	if(!is_object($user) && intval($user)<1) return false;
	$uid = (is_object($user))?$user->getVar('uid'):intval($user);
	if($xoopsModuleConfig['subject_prefix_level']==2){
		return true;
	}
	if($xoopsModuleConfig['subject_prefix_level']==3){
		if(newbb_isAdmin($forum, $user)) return true;
		else return false;
	}
	if($xoopsModuleConfig['subject_prefix_level']==4){
		if(newbb_isAdministrator($user)) return true;
	}
	return false;
}
/*
* Gets the total number of topics in a form
*/
function get_total_topics($forum_id="")
{
    global $xoopsDB;
    if ( $forum_id ) {
        $sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("bb_topics")." WHERE forum_id = $forum_id";
    } else {
        $sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("bb_topics");
    }
    if ( !$result = $xoopsDB->query($sql) ) {
        return _MD_ERROR;
    }

    if ( !$myrow = $xoopsDB->fetchArray($result) ) {
        return _MD_ERROR;
    }

    return $myrow['total'];
}

/*
* Returns the total number of posts in the whole system, a forum, or a topic
* Also can return the number of users on the system.
*/
function get_total_posts($id, $type)
{
    global $xoopsDB;
    switch ( $type ) {
        case 'users':
        $sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("users")." WHERE (uid > 0) AND ( level >0 )";
        break;
        case 'all':
        $sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("bb_posts");
        break;
        case 'forum':
        $sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("bb_posts")." WHERE forum_id = $id";
        break;
        case 'topic':
        $sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("bb_posts")." WHERE topic_id = $id";
        break;
        // Old, we should never get this.
        case 'user':
        exit("Should be using the users.user_posts column for this.");
    }
    if ( !$result = $xoopsDB->query($sql) ) {
	    echo "<br />get_total_posts::error :$sql";
        return false;
    }
    if ( !$myrow = $xoopsDB->fetchArray($result) ) {
        return 0;
    }
    return $myrow['total'];
}

function get_total_views()
{
    global $xoopsDB;
    $total="";

    $sql = "SELECT sum(topic_views) FROM ".$xoopsDB->prefix("bb_topics")."";

    if ( !$result = $xoopsDB->query($sql) ) {
        return _MD_ERROR;
    }

    list ($total) = $xoopsDB->fetchRow($result);
    return $total;
}

function make_jumpbox()
{
	$box = '<form name="forum_jumpbox" method="get" action="viewforum.php" onsubmit="if(document.forum_jumpbox.forum.value <1){return false;}">';
	$box .= '<select class="select" name="forum" onchange="if(this.options[this.selectedIndex].value >0 ){ forms[\'forum_jumpbox\'].submit();}">';

    $box .='<option value="-1">-- '._MD_SELFORUM.' --</option>';


	$category_handler =& xoops_getmodulehandler('category', 'newbb');
	$forum_handler =& xoops_getmodulehandler('forum', 'newbb');

    $categories = $category_handler->getAllCats(0, 'access');
    $forums = $forum_handler->getForums(0, 'access');

	if(count($categories)>0 && count($forums)>0){
		$box_cats=array();
		$box_forums=array();
		foreach($forums as $forumid=>$forum){
			$box_forums[$forum->getVar('cat_id')][$forum->getVar('forum_id')]['title'] = $forum->getVar('forum_name');
		}
		foreach($categories as $category){
			if( !isset($box_forums[$category->getVar('cat_id')]) || count( $box_forums[$category->getVar('cat_id')] ) < 1 ) continue;
            $box .= "
                <option value='-1'>&nbsp;</option>
                <option value='-1'>".$category->getVar('cat_title')."</option>";
            foreach ($box_forums[$category->getVar('cat_id')] as $forumid=>$forum) {
                $box .= "<option value='".$forumid."'>-- ".$forum['title']."</option>";
            }
		}
    } else {
        $box .= "<option value='-1'>ERROR</option>";
    }

    $box .= "</select> <input type='submit' class='button' value='"._GO."' /></form>";
    return $box;
}

function &newbb_buildrss()
{
    global $moduleperm_handler, $xoopsDB, $xoopsModuleConfig, $xoopsModule, $xoopsUser, $xoopsConfig, $myts;

	$moduleperm_handler =& xoops_gethandler('groupperm');
    if (!$xoopsModuleConfig['rss_enable'] or
    	!$moduleperm_handler->checkRight('module_read', $xoopsModule->getVar('mid'), XOOPS_GROUP_ANONYMOUS)
    ) return false;

	$allow_moderator_html =$xoopsModuleConfig['allow_moderator_html'];

	$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
	$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
	$thisUser = $xoopsUser;
	$xoopsUser = null;
	$access_forums = $forum_handler->getForums(0,'access'); // get all accessible forums
	$xoopsUser = $thisUser;

	$available_forums = array();
	foreach($access_forums as $forum){
		if($topic_handler->getPermission($forum)) {
			$available_forums[$forum->getVar('forum_id')] = $forum;
		}
	}
    unset($access_forums);

    $forum_criteria = ' AND t.forum_id IN ('.implode(',',array_keys($available_forums)).')';
    unset($available_forums);
	$approve_criteria = ' AND t.approved = 1 AND p.approved = 1';

    $query='SELECT t.topic_id, t.forum_id, t.topic_title, p.post_id, p.post_time, p.uid, p.poster_name, p.post_karma, p.require_reply, p.dohtml, p.dosmiley, p.doxcode, pt.post_text FROM '.$xoopsDB->prefix('bb_topics').' t, '.$xoopsDB->prefix('bb_posts_text').' pt, '.$xoopsDB->prefix('bb_posts').' p WHERE t.topic_last_post_id=p.post_id '.$forum_criteria. $approve_criteria.' AND pt.post_id=p.post_id ORDER BY p.post_id DESC';
    $limit = intval($xoopsModuleConfig['rss_maxitems'] * 1.5);

    if (!$result = $xoopsDB->query($query,$limit)) {
	    //echo "<br />No result:<br />$query <br />limit:$limit";
        return false;
    }
    $rows = array();
    while ($row = $xoopsDB->fetchArray($result)) {
        $users[$row['uid']] = 1;
        $rows[] = $row;
    }
	if(count($rows)<1) {
		return false;
	}
    $uids = array_keys($users);
    if(count($uids)>0){
	    $member_handler =& xoops_gethandler('member');
	    $user_criteria = new Criteria('uid', "(".implode(',', $uids).")", 'IN');
		$users = $member_handler->getUsers( new Criteria('uid', "(".implode(',', $uids).")", 'IN'), true);
	}else{
		$users = array();
	}

	$xmlrss_handler =& xoops_getmodulehandler('xmlrss', 'newbb');
	$rss = $xmlrss_handler->create();

	$rss->setVarRss('channel_title', $xoopsConfig['sitename'].' :: '._MD_FORUM);
	$rss->channel_link = XOOPS_URL.'/';
	$rss->setVarRss('channel_desc', $xoopsConfig['slogan'].' :: '.$xoopsModule->getInfo('description'));
	$rss->channel_lastbuild = formatTimestamp(time(), 'rss');
	$rss->channel_webmaster = $xoopsConfig['adminmail'];
	$rss->channel_editor = $xoopsConfig['adminmail'];
	$rss->setVarRss('channel_category', $xoopsModule->getVar('name'));
	$rss->channel_generator = $xoopsModule->getInfo('version');
	$rss->channel_language = _LANGCODE;
    $rss->xml_encoding = empty($xoopsModuleConfig['rss_utf8'])?_CHARSET:'UTF-8';
	$rss->image_url = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/'.$xoopsModule->getInfo('image');

	$dimention = getimagesize(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar('dirname').'/'.$xoopsModule->getInfo('image'));
	if (empty($dimention[0])) {
		$width = 88;
	} else {
		$width = ($dimention[0] > 144) ? 144 : $dimention[0];
	}
	if (empty($dimention[1])) {
		$height = 31;
	} else {
		$height = ($dimention[1] > 400) ? 400 : $dimention[1];
	}
	$rss->image_width = $width;
	$rss->image_height = $height;

	$rss->max_items            = $xoopsModuleConfig['rss_maxitems'];
	$rss->max_item_description = $xoopsModuleConfig['rss_maxdescription'];

	foreach($rows as $topic){
        if( $xoopsModuleConfig['enable_karma'] && $topic['post_karma'] > 0 ) continue;
		if( $xoopsModuleConfig['allow_require_reply'] && $topic['require_reply']) continue;
		if($topic['uid'] >0){
			if ( isset($users[$topic['uid']]) && (is_object($users[$topic['uid']])) && ($users[$topic['uid']]->isActive()) ){
				$topic['uname'] = $users[$topic['uid']]->getVar('uname');
		        if(newbb_isAdmin(0,$topic['uid']) && $allow_moderator_html){
		        	$topic['topic_title'] = $myts->undoHtmlSpecialChars($topic['topic_title']);
		        	$topic['topic_title'] = newbb_html2text($topic['topic_title']);
		    	}
			}else{
				$topic['uname'] = $xoopsConfig['anonymous'];
			}
		}else{
            $topic['uname'] = $topic['poster_name']?$topic['poster_name']:$xoopsConfig['anonymous'];
		}
		$description  = &$myts->displayTarea($topic['post_text'], $topic['dohtml'], $topic['dosmiley'], $topic['doxcode']);
		$label = _MD_BY." ".$topic['uname'];
		$time = formatTimestamp($topic['post_time'], "rss");
        $link = XOOPS_URL . "/modules/" . $xoopsModule->dirname() . '/viewtopic.php?topic_id=' . $topic['topic_id'] . '&amp;forum=' . $topic['forum_id'];
		$title = $topic['topic_title'];
     	if(!$rss->addItem($title, $link, $description, $label, $time)) break;
	}
	$rss_feed = &$xmlrss_handler->get($rss);

	return $rss_feed;
}

function sync($id, $type)
{
    global $xoopsDB;
    switch ( $type ) {
        case 'forum':
        $sql = "SELECT MAX(post_id) AS last_post FROM ".$xoopsDB->prefix("bb_posts")." WHERE forum_id = $id";
        if ( !$result = $xoopsDB->query($sql) ) {
            exit("Could not get post ID");
        }
        if ( $row = $xoopsDB->fetchArray($result) ) {
            $last_post = $row['last_post'];
        }

        $sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("bb_posts")." WHERE forum_id = $id";
        if ( !$result = $xoopsDB->query($sql) ) {
            exit("Could not get post count");
        }
        if ( $row = $xoopsDB->fetchArray($result) ) {
            $total_posts = $row['total'];
        }

        $sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("bb_topics")." WHERE forum_id = $id";
        if ( !$result = $xoopsDB->query($sql) ) {
            exit("Could not get topic count");
        }
        if ( $row = $xoopsDB->fetchArray($result) ) {
            $total_topics = $row['total'];
        }

        $sql = sprintf("UPDATE %s SET forum_last_post_id = %u, forum_posts = %u, forum_topics = %u WHERE forum_id = %u", $xoopsDB->prefix("bb_forums"), $last_post, $total_posts, $total_topics, $id);
        if ( !$result = $xoopsDB->queryF($sql) ) {
            exit("Could not update forum $id");
        }
        break;
        case 'topic':
        $sql = "SELECT max(post_id) AS last_post FROM ".$xoopsDB->prefix("bb_posts")." WHERE topic_id = $id";
        if ( !$result = $xoopsDB->query($sql) ) {
            exit("Could not get post ID");
        }
        if ( $row = $xoopsDB->fetchArray($result) ) {
            $last_post = $row['last_post'];
        }
        if ( $last_post > 0 ) {
            $sql = "SELECT COUNT(*) AS total FROM ".$xoopsDB->prefix("bb_posts")." WHERE topic_id = $id";
            if ( !$result = $xoopsDB->query($sql) ) {
                exit("Could not get post count");
            }
            if ( $row = $xoopsDB->fetchArray($result) ) {
                $total_posts = $row['total'];
            }
            $total_posts -= 1;
            $sql = sprintf("UPDATE %s SET topic_replies = %u, topic_last_post_id = %u WHERE topic_id = %u", $xoopsDB->prefix("bb_topics"), $total_posts, $last_post, $id);
            if ( !$result = $xoopsDB->queryF($sql) ) {
                exit("Could not update topic $id");
            }
        }
        break;
        case 'all forums':
        $sql = "SELECT forum_id FROM ".$xoopsDB->prefix("bb_forums");
        if ( !$result = $xoopsDB->query($sql) ) {
            exit("Could not get forum IDs");
        }
        while ( $row = $xoopsDB->fetchArray($result) ) {
            $id = $row['forum_id'];
            sync($id, "forum");
        }
        break;
        case 'all topics':
        $sql = "SELECT topic_id FROM ".$xoopsDB->prefix("bb_topics");
        if ( !$result = $xoopsDB->query($sql) ) {
            exit("Could not get topic ID's");
        }
        while ( $row = $xoopsDB->fetchArray($result) ) {
            $id = $row['topic_id'];
            sync($id, "topic");
        }
        break;
    }
    return true;
}

function getLinkUsernameFromUid($userid = 0, $name= 0)
{
    if (!is_numeric($userid)) {
        return $userid;
    }

    $userid = intval($userid);
    if ($userid > 0) {
        $member_handler =& xoops_gethandler('member');
        $user =& $member_handler->getUser($userid);

        if (is_object($user)) {
            $ts =& MyTextSanitizer::getInstance();
            $username = $user->getVar('uname');
            $usernameu = $user->getVar('name');

            if ( ($name) && !empty($usernameu))  {
                $username = $user->getVar('name');
            }
            if ( !empty($usernameu)) {
                $linkeduser = "<a href='".XOOPS_URL."/userinfo.php?uid=".$userid."'>". $ts->htmlSpecialChars($username) ."</a>";
            }
            else {
                $linkeduser = "<a href='".XOOPS_URL."/userinfo.php?uid=".$userid."'>". ucwords($ts->htmlSpecialChars($username)) ."</a>";
            }
            return $linkeduser;
        }
    }
    return $GLOBALS['xoopsConfig']['anonymous'];
}

function get_user_level($user)
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
    $level['LEVEL']  = $showlevel ;
    $level['EXP'] = $ep;
    $level['HP']  = $hp;
    $level['HP_MAX']  = $maxhp;
    $level['HP_WIDTH'] = $hpf;
    $level['MP']  = $mp;
    $level['MP_MAX']  = $maxmp;
    $level['MP_WIDTH'] = $mpf;

    return $level;
}

function newbb_adminmenu ($currentoption = 0, $breadcrumb = '')
{

	/* Nice buttons styles */
	echo "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:12px; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/newbb/images/bg.png') repeat-x left bottom; font-size:12px; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/newbb/images/left_both.png') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/newbb/images/right_both.png') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar #current a { background-position:0 -150px; border-width:0; }
		#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }
		</style>
    ";

	global $xoopsModule, $xoopsConfig;

	$tblColors = Array();
	$tblColors[0] = $tblColors[1] = $tblColors[2] = $tblColors[3] = $tblColors[4] = $tblColors[5] = $tblColors[6] = $tblColors[7] = $tblColors[8] = $tblColors[9] = '';
	$tblColors[$currentoption] = 'current';

	if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once XOOPS_ROOT_PATH . '/modules/newbb/language/english/modinfo.php';
	}

	echo "<div id='buttontop'>";
	echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
	echo "<td style=\"width: 60%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule -> getVar( 'mid' )."\">" . _AM_NEWBB_GENERALSET . "</a> | <a href=\"../index.php\">" . _AM_NEWBB_GOTOMOD . "</a> | <a href=\"#\">" . _AM_NEWBB_HELP . "</a> | <a href=\"about.php\">" . _AM_NEWBB_ABOUT . "</a></td>";
	echo "<td style=\"width: 40%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\"><strong>" . $xoopsModule->name() . " " . _AM_NEWBB_MODULEADMIN . "</strong> " . $breadcrumb . "</td>";
	echo "</tr></table>";
	echo "</div>";

	echo "<div id='buttonbar'>";
	echo "<ul>";
	echo "<li id='" . $tblColors[0] . "'><a href=\"index.php\"><span>"._MI_NEWBB_ADMENU1 ."</span></a></li>";
	echo "<li id='" . $tblColors[1] . "'><a href=\"admin_cat_manager.php?op=manage\"><span>" . _MI_NEWBB_ADMENU2 . "</span></a></li>";
	echo "<li id='" . $tblColors[2] . "'><a href=\"admin_forum_manager.php?op=manage\"><span>" . _MI_NEWBB_ADMENU3 . "</span></a></li>";
	echo "<li id='" . $tblColors[3] . "'><a href=\"admin_forum_manager.php?op=sync\"><span>" . _MI_NEWBB_ADMENU4 . "</span></a></li>";
	echo "<li id='" . $tblColors[4] . "'><a href=\"admin_forum_reorder.php\"><span>" . _MI_NEWBB_ADMENU5 . "</span></a></li>";
	echo "<li id='" . $tblColors[5] . "'><a href=\"admin_forum_prune.php\"><span>" . _MI_NEWBB_ADMENU6 . "</span></a></li>";
	echo "<li id='" . $tblColors[6] . "'><a href=\"admin_report.php\"><span>" . _MI_NEWBB_ADMENU7 . "</span></a></li>";
	echo "<li id='" . $tblColors[7] . "'><a href=\"myblocksadmin.php\"><span>" . _MI_NEWBB_ADMENU8 . "</span></a></li>";
	echo "<li id='" . $tblColors[8] . "'><a href=\"admin_digest.php\"><span>" . _MI_NEWBB_ADMENU9 . "</span></a></li>";
        echo "<li id='" . $tblColors[9] . "'><a href=\"admin_votedata.php\"><span>" . _MI_NEWBB_ADMENU10 . "</span></a></li>";

	echo "</ul></div>";
	echo "<br /><br /><pre>&nbsp;</pre><pre>&nbsp;</pre><pre>&nbsp;</pre><pre>&nbsp;</pre><pre>&nbsp;</pre>";
}

function &newbb_admin_getPathStatus($path)
{
	if(empty($path)) return false;
	if(@is_writable($path)){
		$path_status = _AM_NEWBB_AVAILABLE;
	}elseif(!@is_dir($path)){
		$path_status = _AM_NEWBB_NOTAVAILABLE." <a href=index.php?op=createdir&amp;path=$path>"._AM_NEWBB_CREATETHEDIR.'</a>';
	}else{
		$path_status = _AM_NEWBB_NOTWRITABLE." <a href=index.php?op=setperm&amp;path=$path>"._AM_NEWBB_SETMPERM.'</a>';
	}
	return $path_status;
}

function newbb_admin_mkdir($target)
{
	// http://www.php.net/manual/en/function.mkdir.php
	// saint at corenova.com
	// bart at cdasites dot com
	if (is_dir($target)||empty($target)) return true; // best case check first
	if (file_exists($target) && !is_dir($target)) return false;
	if (newbb_admin_mkdir(substr($target,0,strrpos($target,'/'))))
	  if (!file_exists($target)) return mkdir($target); // crawl back up & create dir tree
	return true;
}

function newbb_admin_chmod($target, $mode = 0777)
{
	return @chmod($target, $mode);
}

function pollview($poll_id)
{
    global $xoopsTpl;

	$poll = new XoopsPoll($poll_id);
	$renderer = new XoopsPollRenderer($poll);
    $renderer->assignForm($xoopsTpl);
    $xoopsTpl->assign('lang_vote' , _PL_VOTE);
    $xoopsTpl->assign('lang_results' , _PL_RESULTS);
}

function pollresults($poll_id)
{
	global $xoopsTpl;

	$poll = new XoopsPoll($poll_id);
	$renderer = new XoopsPollRenderer($poll);
	$renderer->assignResults($xoopsTpl);
}

function newbb_isIE5()
{
	static $user_agent_is_IE5;

	if(isset($user_agent_is_IE5)) return $user_agent_is_IE5;;
    $msie='/msie\s(5\.[5-9]|[6-9]\.[0-9]*).*(win)/i';
    if( !isset($_SERVER['HTTP_USER_AGENT']) ||
        !preg_match($msie,$_SERVER['HTTP_USER_AGENT']) ||
        preg_match('/opera/i',$_SERVER['HTTP_USER_AGENT'])){
	    $user_agent_is_IE5 = false;
    }else{
	    $user_agent_is_IE5 = true;
    }
    return $user_agent_is_IE5;
}

function newbb_displayImage($image, $alt = "", $width = 0, $height =0, $style ="margin: 0px;", $sizeMeth='scale')
{
	global $xoopsModuleConfig, $forumImage;
	static $image_type;

	$user_agent_is_IE5 = newbb_isIE5();
	if(!isset($image_type)) $image_type = ($xoopsModuleConfig['image_type'] == 'auto')?(($user_agent_is_IE5)?'gif':'png'):$xoopsModuleConfig['image_type'];
	$image .= '.'.$image_type;
	$imageuri=str_replace(XOOPS_URL,XOOPS_ROOT_PATH,$image);
	if(file_exists($imageuri)){
	    $size=@getimagesize($imageuri);
	    if(is_array($size)){
		    $width=$size[0];
		    $height=$size[1];
	    }
    }else{
		$image=$forumImage['blank'].'.gif';
    }
    $width .='px';
    $height .='px';

    $img_style = "width: $width; height:$height; $style";
    $image_url = "<img src=\"".$image."\" style=\"".$img_style."\" alt=\"".$alt."\" align=\"middle\" />";

    return $image_url;
}

/**
 * newbb_updaterating()
 *
 * @param $sel_id
 * @return updates rating data in itemtable for a given item
 **/
function newbb_updaterating($sel_id)
{
    global $xoopsDB;
    $query = "select rating FROM " . $xoopsDB -> prefix('bb_votedata') . " WHERE topic_id = " . $sel_id . "";
    $voteresult = $xoopsDB -> query($query);
    $votesDB = $xoopsDB -> getRowsNum($voteresult);
    $totalrating = 0;
    while (list($rating) = $xoopsDB -> fetchRow($voteresult))
    {
        $totalrating += $rating;
    }
    $finalrating = $totalrating / $votesDB;
    $finalrating = number_format($finalrating, 4);
    $sql = sprintf("UPDATE %s SET rating = %u, votes = %u WHERE topic_id = %u", $xoopsDB -> prefix('bb_topics'), $finalrating, $votesDB, $sel_id);
    $xoopsDB -> query($sql);
}

function &newbb_getWysiwygForm($newbb_form, $caption, $name, $value = "", $width = '100%', $height = '400px')
{

	$editor = false;
	switch(strtolower($newbb_form)){
	case "spaw":
		if (is_readable(XOOPS_ROOT_PATH . "/class/spaw/formspaw.php"))	{
			include_once(XOOPS_ROOT_PATH . "/class/spaw/formspaw.php");
			$editor = new XoopsFormSpaw($caption, $name, $value, $width, $height);
		}
		break;
	case "fck":
		if ( is_readable(XOOPS_ROOT_PATH . "/class/fckeditor/formfckeditor.php"))	{
			include_once(XOOPS_ROOT_PATH . "/class/fckeditor/formfckeditor.php");
			$editor = new XoopsFormFckeditor($caption, $name, $value, $width, $height);
		}
		break;
	case "htmlarea":
		if ( is_readable(XOOPS_ROOT_PATH . "/class/htmlarea/formhtmlarea.php"))	{
			include_once(XOOPS_ROOT_PATH . "/class/htmlarea/formhtmlarea.php");
			$editor = new XoopsFormHtmlarea($caption, $name, $value, $width, $height);
		}
		break;
	case "koivi":
		if ( is_readable(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php"))	{
			include_once(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php");
			$editor = new XoopsFormWysiwygTextArea($caption, $name, $value, $width, $height, '');
		}
		break;
	case "tinymce":
		if ( is_readable(XOOPS_ROOT_PATH . "/class/tinymce/formtinymce.php"))	{
			include_once(XOOPS_ROOT_PATH . "/class/tinymce/formtinymce.php");
			$editor = new XoopsFormTinymce($caption, $name, $value, $width, $height);
		}
		break;
	}

	return $editor;
}

function &newbb_getTextareaForm($newbb_form, $caption, $name, $value = "", $rows = 25, $cols = 60)
{
	switch(strtolower($newbb_form)){
		case "textarea":
			$form = new XoopsFormTextArea($caption, $name, $value, $rows, $cols);
			break;
		case "dhtml":
		default:
			$form = new XoopsFormDhtmlTextArea($caption, $name, $value, $rows, $cols);
			break;
	}

	return $form;
}

function newbb_getImageLibs()
{
/*
 * exec	could be disabled
 */
	global $xoopsModuleConfig;

	$imageLibs= array();
	unset($output, $status);
	if ( $xoopsModuleConfig['image_lib'] == 1 or $xoopsModuleConfig['image_lib'] == 0 ){
		$path = empty($xoopsModuleConfig['path_magick'])?"":$xoopsModuleConfig['path_magick']."/";
		@exec($path.'convert -version', $output, $status);
		if(empty($status)&&!empty($output)){
			if(preg_match("/imagemagick[ \t]+([0-9\.]+)/i",$output[0],$matches))
			   $imageLibs['imagemagick'] = $matches[0];
		}
		unset($output, $status);
	}
	 if ( $xoopsModuleConfig['image_lib'] == 2 or $xoopsModuleConfig['image_lib'] == 0 ){
		$path = empty($xoopsModuleConfig['path_netpbm'])?"":$xoopsModuleConfig['path_netpbm']."/";
		@exec($path.'jpegtopnm -version 2>&1',  $output, $status);
		if(empty($status)&&!empty($output)){
			if(preg_match("/netpbm[ \t]+([0-9\.]+)/i",$output[0],$matches))
			   $imageLibs['netpbm'] = $matches[0];
		}
		unset($output, $status);
	}

	$GDfuncList = get_extension_funcs('gd');
	ob_start();
	@phpinfo(INFO_MODULES);
	$output=ob_get_contents();
	ob_end_clean();
	$matches[1]='';
	if(preg_match("/GD Version[ \t]*(<[^>]+>[ \t]*)+([^<>]+)/s",$output,$matches)){
		$gdversion = $matches[2];
	}
	if( $GDfuncList ){
	 if( in_array('imagegd2',$GDfuncList) )
		$imageLibs['gd2'] = $gdversion;
	 else
		$imageLibs['gd1'] = $gdversion;
	}
	return $imageLibs;
}

function newbb_sinceSelectBox($selected = 100)
{
	global $xoopsModuleConfig;

	$select_array = explode(',',$xoopsModuleConfig['since_options']);
	$select_array = array_map('trim',$select_array);

	$forum_selection_since = '<select name="since">';
	foreach ($select_array as $since) {
		$forum_selection_since .= '<option value="'.$since.'"'.(($selected == $since) ? ' selected="selected"' : '').'>';
		if($since>0){
			$forum_selection_since .= sprintf(_MD_FROMLASTDAYS, $since);
		}else{
			$forum_selection_since .= sprintf(_MD_FROMLASTHOURS, abs($since));
		}
		$forum_selection_since .= '</option>';
	}
	$forum_selection_since .= '<option value="365"'.(($selected == 365) ? ' selected="selected"' : '').'>'._MD_THELASTYEAR.'</option>';
	$forum_selection_since .= '<option value="1000"'.(($selected == 1000) ? ' selected="selected"' : '').'>'._MD_BEGINNING.'</option>';
	$forum_selection_since .= '</select>';

	//echo htmlspecialchars($forum_selection_since);
	return $forum_selection_since;
}

function newbb_getSinceTime($since = 100)
{
	if($since>0) return intval($since) * 24 * 3600;
	else return intval(abs($since)) * 3600;
}
?>