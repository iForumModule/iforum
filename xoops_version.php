<?php
// $Id: xoops_version.php,v 1.3 2005/10/19 17:20:28 phppp Exp $
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

$modversion['name'] = _MI_NEWBB_NAME;
$modversion['version'] = 3.07;
$modversion['description'] = _MI_NEWBB_DESC;
$modversion['credits'] = "NewBB 2 developed by Marko Schmuck (predator) and D.J. (phppp)";
$modversion['author'] = "D.J. (phppp)";
$modversion['license'] = "GNU General Public License (GPL) see LICENSE";
$modversion['image'] = "images/xoopsbb_slogo.png";
$modversion['dirname'] = "newbb";

$modversion['author_realname'] = "CBB Dev Team";
$modversion['author_website_url'] = "http://xoopsforge.com";
$modversion['author_website_name'] = "XForge";
$modversion['author_email'] = "php_pp@hotmail.com";
$modversion['status_version'] = "3.07";
$modversion['status'] = "Stable";

$modversion['warning'] = "For XOOPS 2.0*, 2.2*, 2.3";

$modversion['demo_site_url'] = "http://xoopsforge.com/modules/newbb/";
$modversion['demo_site_name'] = "XForge";
$modversion['support_site_url'] = "http://xoopsforge.com/modules/newbb/";
$modversion['support_site_name'] = "Team CBB";
$modversion['submit_feature'] = "http://xoopsforge.com/modules/newbb/";
$modversion['submit_bug'] = "http://xoopsforge.com/modules/newbb/";

include_once(XOOPS_ROOT_PATH."/Frameworks/art/functions.ini.php");
// Is performing module install/update?
$isModuleAction = mod_isModuleAction($modversion['dirname']);

// Sql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = "bb_archive";
$modversion['tables'][1] = "bb_categories";
$modversion['tables'][2] = "bb_votedata";
$modversion['tables'][3] = "bb_forums";
$modversion['tables'][4] = "bb_posts";
$modversion['tables'][5] = "bb_posts_text";
$modversion['tables'][6] = "bb_topics";
$modversion['tables'][7] = "bb_online";
$modversion['tables'][8] = "bb_digest";
$modversion['tables'][9] = "bb_report";
$modversion['tables'][10] = "bb_attachments"; // reserved table for next version
$modversion['tables'][11] = "bb_moderates"; // For suspension
$modversion['tables'][12] = "bb_reads_forum";
$modversion['tables'][13] = "bb_reads_topic";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;

//install
$modversion['onInstall'] = 'include/module.php';

//update things
$modversion['onUpdate'] = 'include/module.php';

//module css
//$modversion['css'] = 'templates/newbb.css';

// Templates
$modversion['templates'][0]['file'] = 'newbb_poll_results.html';
$modversion['templates'][0]['description'] = '';
$modversion['templates'][1]['file'] = 'newbb_index.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'newbb_searchresults.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'newbb_search.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'newbb_thread.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'newbb_viewforum.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file'] = 'newbb_viewtopic_flat.html';
$modversion['templates'][6]['description'] = '';
$modversion['templates'][7]['file'] = 'newbb_viewtopic_thread.html';
$modversion['templates'][7]['description'] = '';
$modversion['templates'][8]['file'] = 'newbb_rss.html';
$modversion['templates'][8]['description'] = '';
$modversion['templates'][9]['file'] = 'newbb_viewall.html';
$modversion['templates'][9]['description'] = '';
$modversion['templates'][10]['file'] = 'newbb_poll_view.html';
$modversion['templates'][10]['description'] = '';
$modversion['templates'][11]['file'] = 'newbb_online.html';
$modversion['templates'][11]['description'] = '';
$modversion['templates'][12]['file'] = 'newbb_viewpost.html';
$modversion['templates'][12]['description'] = '';
$modversion['templates'][13]['file'] = 'newbb_item.html';
$modversion['templates'][13]['description'] = '';
//$modversion['templates'][14]['file'] = 'newbb_viewpost_list.html';
//$modversion['templates'][14]['description'] = '';


// Blocks

// options[0] - Citeria valid: time(by default)
// options[1] - NumberToDisplay: any positive integer
// options[2] - TimeDuration: negative for hours, positive for days, for instance, -5 for 5 hours and 5 for 5 days
// options[3] - DisplayMode: 0-full view;1-compact view;2-lite view
// options[4] - Display Navigator: 1 (by default), 0 (No)
// options[5] - SelectedForumIDs: null for all

$modversion['blocks'][1] = array(
	'file' => "newbb_block.php",
	'name' => _MI_NEWBB_BLOCK_TOPIC_POST,
	'description' => "Shows recent replied topics",
	'show_func' => "b_newbb_show",
	'options' => "time|5|360|0|1|0",
	'edit_func' => "b_newbb_edit",
	'template' => 'newbb_block.html');

// options[0] - Citeria valid: time(by default), views, replies, digest, sticky
// options[1] - NumberToDisplay: any positive integer
// options[2] - TimeDuration: negative for hours, positive for days, for instance, -5 for 5 hours and 5 for 5 days
// options[3] - DisplayMode: 0-full view;1-compact view;2-lite view
// options[4] - Display Navigator: 1 (by default), 0 (No)
// options[5] - Title Length : 0 - no limit
// options[6] - SelectedForumIDs: null for all

$modversion['blocks'][] = array(
	'file' => "newbb_block.php",
	'name' => _MI_NEWBB_BLOCK_TOPIC,
	'description' => "Shows recent topics in the forums",
	'show_func' => "b_newbb_topic_show",
	'options' => "time|5|360|0|1|0|0",
	'edit_func' => "b_newbb_topic_edit",
	'template' => 'newbb_block_topic.html');


// options[0] - Citeria valid: title(by default), text
// options[1] - NumberToDisplay: any positive integer
// options[2] - TimeDuration: negative for hours, positive for days, for instance, -5 for 5 hours and 5 for 5 days
// options[3] - DisplayMode: 0-full view;1-compact view;2-lite view; Only valid for "time"
// options[4] - Display Navigator: 1 (by default), 0 (No)
// options[5] - Title/Text Length : 0 - no limit
// options[6] - SelectedForumIDs: null for all

$modversion['blocks'][] = array(
	'file' => "newbb_block.php",
	'name' => _MI_NEWBB_BLOCK_POST,
	'description' => "Shows recent posts in the forums",
	'show_func' => "b_newbb_post_show",
	'options' => "title|10|360|0|1|0|0",
	'edit_func' => "b_newbb_post_edit",
	'template' => 'newbb_block_post.html');

// options[0] - Citeria valid: post(by default), topic, digest, sticky
// options[1] - NumberToDisplay: any positive integer
// options[2] - TimeDuration: negative for hours, positive for days, for instance, -5 for 5 hours and 5 for 5 days
// options[3] - DisplayMode: 0-full view;1-compact view;
// options[4] - Display Navigator: 1 (by default), 0 (No)
// options[5] - SelectedForumIDs: null for all

$modversion['blocks'][] = array(
	'file' => "newbb_block.php",
	'name' => _MI_NEWBB_BLOCK_AUTHOR,
	'description' => "Shows authors stats",
	'show_func' => "b_newbb_author_show",
	'options' => "topic|5|360|0|1|0",
	'edit_func' => "b_newbb_author_edit",
	'template' => 'newbb_block_author.html');	

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "newbb_search";

// Smarty
$modversion['use_smarty'] = 1;

$modversion['config'][] = array(
	'name' 			=> 'do_debug',
	'title' 		=> '_MI_DO_DEBUG',
	'description' 	=> '_MI_DO_DEBUG_DESC',
	'formtype' 		=> 'yesno',
	'valuetype' 	=> 'int',
	'default' 		=> 0);

$imagesets = array("default"=>"Default", "hsyong"=>"hsyong");
if($isModuleAction){
	require_once(XOOPS_ROOT_PATH.'/class/xoopslists.php');
	$imagesets =& XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH.'/modules/newbb/images/imagesets/');
}
$modversion['config'][] = array(
	'name' 			=> 'image_set',
	'title' 		=> '_MI_IMG_SET',
	'description' 	=> '_MI_IMG_SET_DESC',
	'formtype' 		=> 'select',
	'valuetype' 	=> 'text',
	'options' 		=> $imagesets,
	'default' 		=> "default");

$modversion['config'][] = array(
	'name' 			=> 'image_type',
	'title' 		=> '_MI_IMG_TYPE',
	'description' 	=> '_MI_IMG_TYPE_DESC',
	'formtype' 		=> 'select',
	'valuetype' 	=> 'text',
	'options' 		=> array('png'=>'png', 'gif'=>'gif', 'auto'=>'auto'),
	'default' 		=> "auto");


$theme_set = array(_NONE=>"0");
if($isModuleAction){
    foreach ($GLOBALS["xoopsConfig"]["theme_set_allowed"] as $theme) {
		$theme_set[$theme] = $theme;
    }
}
$modversion["config"][] = array(
	"name" => "theme_set",
	"title" => "_MI_THEMESET",
	"description" => "_MI_THEMESET_DESC",
	"formtype"=> "select",
	"valuetype" => "text",
	"options"=> $theme_set,
	"default" => "");

$modversion['config'][] = array(
	'name' 			=> 'pngforie_enabled',
	'title' 		=> '_MI_PNGFORIE_ENABLE',
	'description' 	=> '_MI_PNGFORIE_ENABLE_DESC',
	'formtype' 		=> 'yesno',
	'valuetype' 	=> 'int',
	'default' 		=> 0);

$modversion['config'][] = array(
	'name' => 'subforum_display',
	'title' => '_MI_SUBFORUM_DISPLAY',
	'description' => '_MI_SUBFORUM_DISPLAY_DESC',
	'formtype' => 'select',
	'valuetype' => 'text',
	'options' => array(
					_MI_SUBFORUM_EXPAND=>'expand',
					_MI_SUBFORUM_COLLAPSE=>'collapse',
					_MI_SUBFORUM_HIDDEN=>'hidden'),
	'default' => "collapse");

$modversion['config'][] = array(
	'name' => 'post_excerpt',
	'title' => '_MI_POST_EXCERPT',
	'description' => '_MI_POST_EXCERPT_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 100);

$modversion['config'][] = array(
	'name' => 'topics_per_page',
	'title' => '_MI_TOPICSPERPAGE',
	'description' => '_MI_TOPICSPERPAGE_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 20);

$modversion['config'][] = array(
	'name' => 'posts_per_page',
	'title' => '_MI_POSTSPERPAGE',
	'description' => '_MI_POSTSPERPAGE_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 10);

$modversion['config'][] = array(
	'name' => 'posts_for_thread',
	'title' => '_MI_POSTSFORTHREAD',
	'description' => '_MI_POSTSFORTHREAD_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 200);


$modversion['config'][] = array(
	'name' => 'cache_enabled',
	'title' => '_MI_CACHE_ENABLE',
	'description' => '_MI_CACHE_ENABLE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 0);

$modversion['config'][] = array(
	'name' => 'dir_attachments',
	'title' => '_MI_DIR_ATTACHMENT',
	'description' => '_MI_DIR_ATTACHMENT_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'text',
	'default' => 'uploads/newbb');

$modversion['config'][] = array(
	'name' => 'media_allowed',
	'title' => '_MI_MEDIA_ENABLE',
	'description' => '_MI_MEDIA_ENABLE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'path_magick',
	'title' => '_MI_PATH_MAGICK',
	'description' => '_MI_PATH_MAGICK_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'text',
	'default' => '/usr/bin/X11');

$modversion['config'][] = array(
	'name' => 'path_netpbm',
	'title' => '_MI_PATH_NETPBM',
	'description' => '_MI_PATH_NETPBM_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'text',
	'default' => '/usr/bin');

$modversion['config'][] = array(
	'name' => 'image_lib',
	'title' => '_MI_IMAGELIB',
	'description' => '_MI_IMAGELIB_DESC',
	'formtype' => 'select',
	'valuetype' => 'int',
	'default' => 4,
	'options' => array( _MI_AUTO => 0,_MI_MAGICK => 1, _MI_NETPBM => 2, _MI_GD1 => 3, _MI_GD2 => 4 ));

$modversion['config'][] = array(
	'name' => 'max_img_width',
	'title' => '_MI_MAX_IMG_WIDTH',
	'description' => '_MI_MAX_IMG_WIDTH_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 500);

$modversion['config'][] = array(
	'name' => 'max_image_width',
	'title' => '_MI_MAX_IMAGE_WIDTH',
	'description' => '_MI_MAX_IMAGE_WIDTH_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 800);

$modversion['config'][] = array(
	'name' => 'max_image_height',
	'title' => '_MI_MAX_IMAGE_HEIGHT',
	'description' => '_MI_MAX_IMAGE_HEIGHT_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 640);

$modversion['config'][] = array(
	'name' => 'wol_enabled',
	'title' => '_MI_WOL_ENABLE',
	'description' => '_MI_WOL_ENABLE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'user_level',
	'title' => '_MI_USERLEVEL',
	'description' => '_MI_USERLEVEL_DESC',
	'formtype' => 'select',
	'valuetype' => 'int',
	'default' => 1,
	'options' => array( _MI_NULL => 0,_MI_TEXT => 1, _MI_GRAPHIC => 2));

$modversion['config'][] = array(
	'name' => 'userbar_enabled',
	'title' => '_MI_USERBAR_ENABLE',
	'description' => '_MI_USERBAR_ENABLE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'show_realname',
	'title' => '_MI_SHOW_REALNAME',
	'description' => '_MI_SHOW_REALNAME_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 0);

$modversion['config'][] = array(
	'name' => 'groupbar_enabled',
	'title' => '_MI_GROUPBAR_ENABLE',
	'description' => '_MI_GROUPBAR_ENABLE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'rating_enabled',
	'title' => '_MI_RATING_ENABLE',
	'description' => '_MI_RATING_ENABLE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 0);

$modversion['config'][] = array(
	'name' => 'reportmod_enabled',
	'title' => '_MI_REPORTMOD_ENABLE',
	'description' => '_MI_REPORTMOD_ENABLE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 0);

$modversion['config'][] = array(
	'name' => 'quickreply_enabled',
	'title' => '_MI_QUICKREPLY_ENABLE',
	'description' => '_MI_QUICKREPLY_ENABLE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'rss_enable',
	'title' => '_MI_RSS_ENABLE',
	'description' => '_MI_RSS_ENABLE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'rss_maxitems',
	'title' => '_MI_RSS_MAX_ITEMS',
	'description' => '',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 10);

$modversion['config'][] = array(
	'name' => 'rss_maxdescription',
	'title' => '_MI_RSS_MAX_DESCRIPTION',
	'description' => '',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 0);

$modversion['config'][] = array(
	'name' => 'rss_cachetime',
	'title' => '_MI_RSS_CACHETIME',
	'description' => '_MI_RSS_CACHETIME_DESCRIPTION',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 30);

$modversion['config'][] = array(
	'name' => 'rss_utf8',
	'title' => '_MI_RSS_UTF8',
	'description' => '_MI_RSS_UTF8_DESCRIPTION',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 0);

$modversion['config'][] = array(
	'name' => 'view_mode',
	'title' => '_MI_VIEWMODE',
	'description' => '_MI_VIEWMODE_DESC',
	'formtype' => 'select',
	'valuetype' => 'int',
	'default' => 1,
	'options' => array( _NONE => 0, _FLAT => 1, _THREADED => 2, _MI_COMPACT => 3));

$modversion['config'][] = array(
	'name' => 'menu_mode',
	'title' => '_MI_MENUMODE',
	'description' => '_MI_MENUMODE_DESC',
	'formtype' => 'select',
	'valuetype' => 'int',
	'default' => 0,
	'options' => array( "SELECT" => 0, "CLICK"=>1, "HOVER" => 2));

$modversion['config'][] = array(
	'name' => 'show_jump',
	'title' => '_MI_SHOW_JUMPBOX',
	'description' => '_MI_JUMPBOXDESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'show_permissiontable',
	'title' => '_MI_SHOW_PERMISSIONTABLE',
	'description' => '_MI_SHOW_PERMISSIONTABLE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'email_digest',
	'title' => '_MI_EMAIL_DIGEST',
	'description' => '_MI_EMAIL_DIGEST_DESC',
	'formtype' => 'select',
	'valuetype' => 'int',
	'default' => 0,
	'options' => array( _MI_NEWBB_EMAIL_NONE => 0, _MI_NEWBB_EMAIL_DAILY => 1, _MI_NEWBB_EMAIL_WEEKLY => 2));

$modversion['config'][] = array(
	'name' => 'show_ip',
	'title' => '_MI_SHOW_IP',
	'description' => '_MI_SHOW_IP_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'enable_karma',
	'title' => '_MI_ENABLE_KARMA',
	'description' => '_MI_ENABLE_KARMA_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'karma_options',
	'title' => '_MI_KARMA_OPTIONS',
	'description' => '_MI_KARMA_OPTIONS_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'text',
	'default' => '0, 10, 50, 100, 500, 1000, 5000, 10000');

$modversion['config'][] = array(
	'name' => 'since_options',
	'title' => '_MI_SINCE_OPTIONS',
	'description' => '_MI_SINCE_OPTIONS_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'text',
	'default' => "-1, -2, -6, -12, 1, 2, 5, 10, 20, 30, 60, 100");

$modversion['config'][] = array(
	'name' => 'since_default',
	'title' => '_MI_SINCE_DEFAULT',
	'description' => '_MI_SINCE_DEFAULT_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 100);

$modversion['config'][] = array(
	'name' => 'allow_user_anonymous',
	'title' => '_MI_USER_ANONYMOUS',
	'description' => '_MI_USER_ANONYMOUS_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'anonymous_prefix',
	'title' => '_MI_ANONYMOUS_PRE',
	'description' => '_MI_ANONYMOUS_PRE_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'text',
	'default' => 'Guest_');

$modversion['config'][] = array(
	'name' => 'allow_require_reply',
	'title' => '_MI_REQUIRE_REPLY',
	'description' => '_MI_REQUIRE_REPLY_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'edit_timelimit',
	'title' => '_MI_EDIT_TIMELIMIT',
	'description' => '_MI_EDIT_TIMELIMIT_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 60);

$modversion['config'][] = array(
	'name' => 'recordedit_timelimit',
	'title' => '_MI_RECORDEDIT_TIMELIMIT',
	'description' => '_MI_RECORDEDIT_TIMELIMIT_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 15);

$modversion['config'][] = array(
	'name' => 'delete_timelimit',
	'title' => '_MI_DELETE_TIMELIMIT',
	'description' => '_MI_DELETE_TIMELIMIT_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 60);

$modversion['config'][] = array(
	'name' => 'post_timelimit',
	'title' => '_MI_POST_TIMELIMIT',
	'description' => '_MI_POST_TIMELIMIT_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 30);

$modversion['config'][] = array(
	'name' => 'enable_permcheck',
	'title' => '_MI_PERMCHECK_ONDISPLAY',
	'description' => '_MI_PERMCHECK_ONDISPLAY_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'enable_usermoderate',
	'title' => '_MI_USERMODERATE',
	'description' => '_MI_USERMODERATE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 0);

$modversion['config'][] = array(
	'name' => 'subject_prefix_level',
	'title' => '_MI_SUBJECT_PREFIX_LEVEL',
	'description' => '_MI_SUBJECT_PREFIX_LEVEL_DESC',
	'formtype' => 'select',
	'valuetype' => 'int',
	'default' => 3,
	'options' => array( _MI_SPL_DISABLE =>0, _MI_SPL_ANYONE =>1, _MI_SPL_MEMBER =>2, _MI_SPL_MODERATOR =>3, _MI_SPL_ADMIN=>4));

$modversion['config'][] = array(
	'name' => 'subject_prefix',
	'title' => '_MI_SUBJECT_PREFIX',
	'description' => '_MI_SUBJECT_PREFIX_DESC',
	'formtype' => 'textarea',
	'valuetype' => 'text',
	'default' => 'NONE,'._MI_SUBJECT_PREFIX_DEFAULT);

$modversion['config'][] = array(
	'name' => 'disc_show',
	'title' => '_MI_SHOW_DIS',
	'description' => '_MI_SHOW_DIS_DESC',
	'formtype' => 'select',
	'valuetype' => 'int',
	'default' => 0,
	'options' => array( _NONE => 0, _MI_POST => 1, _MI_REPLY => 2, _MI_OP_BOTH=> 3));

$modversion['config'][] = array(
	'name' => 'disclaimer',
	'title' => '_MI_DISCLAIMER',
	'description' => '_MI_DISCLAIMER_DESC',
	'formtype' => 'textarea',
	'valuetype' => 'text',
	'default' => _MI_DISCLAIMER_TEXT);

$forum_options = array(_NONE => 0);
if($isModuleAction){
	$forum_handler =& xoops_getmodulehandler('forum', 'newbb', true);
	$forums = $forum_handler->getForumsByCategory(0, '', false, array("parent_forum", "cat_id", "forum_name"));
	if($forums):
	foreach (array_keys($forums) as $c) {
		foreach(array_keys($forums[$c]) as $f){
			$forum_options[$forums[$c][$f]["title"]]=$f;
	        if(!isset($forums[$c][$f]["sub"])) continue;
			foreach(array_keys($forums[$c][$f]["sub"]) as $s){
				$forum_options["-- ".$forums[$c][$f]["sub"][$s]["title"]]=$s;
			}
		}
	}
	unset($forums);
	endif;
}
$modversion['config'][] = array(
	'name' => 'welcome_forum',
	'title' => '_MI_WELCOMEFORUM',
	'description' => '_MI_WELCOMEFORUM_DESC',
	'formtype' => 'select',
	'valuetype' => 'int',
	'default' => 0,
	'options' => $forum_options);

// Notification
$modversion["notification"] = array();
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'newbb_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'thread';
$modversion['notification']['category'][1]['title'] = _MI_NEWBB_THREAD_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_NEWBB_THREAD_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = 'viewtopic.php';
$modversion['notification']['category'][1]['item_name'] = 'topic_id';
$modversion['notification']['category'][1]['allow_bookmark'] = 1;

$modversion['notification']['category'][2]['name'] = 'forum';
$modversion['notification']['category'][2]['title'] = _MI_NEWBB_FORUM_NOTIFY;
$modversion['notification']['category'][2]['description'] = _MI_NEWBB_FORUM_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = 'viewforum.php';
$modversion['notification']['category'][2]['item_name'] = 'forum';
$modversion['notification']['category'][2]['allow_bookmark'] = 1;

$modversion['notification']['category'][3]['name'] = 'global';
$modversion['notification']['category'][3]['title'] = _MI_NEWBB_GLOBAL_NOTIFY;
$modversion['notification']['category'][3]['description'] = _MI_NEWBB_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = 'index.php';

$modversion['notification']['event'][1]['name'] = 'new_post';
$modversion['notification']['event'][1]['category'] = 'thread';
$modversion['notification']['event'][1]['title'] = _MI_NEWBB_THREAD_NEWPOST_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_NEWBB_THREAD_NEWPOST_NOTIFYCAP;
$modversion['notification']['event'][1]['description'] = _MI_NEWBB_THREAD_NEWPOST_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'thread_newpost_notify';
$modversion['notification']['event'][1]['mail_subject'] = _MI_NEWBB_THREAD_NEWPOST_NOTIFYSBJ;

$modversion['notification']['event'][2]['name'] = 'new_thread';
$modversion['notification']['event'][2]['category'] = 'forum';
$modversion['notification']['event'][2]['title'] = _MI_NEWBB_FORUM_NEWTHREAD_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_NEWBB_FORUM_NEWTHREAD_NOTIFYCAP;
$modversion['notification']['event'][2]['description'] = _MI_NEWBB_FORUM_NEWTHREAD_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'forum_newthread_notify';
$modversion['notification']['event'][2]['mail_subject'] = _MI_NEWBB_FORUM_NEWTHREAD_NOTIFYSBJ;

$modversion['notification']['event'][3]['name'] = 'new_forum';
$modversion['notification']['event'][3]['category'] = 'global';
$modversion['notification']['event'][3]['title'] = _MI_NEWBB_GLOBAL_NEWFORUM_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _MI_NEWBB_GLOBAL_NEWFORUM_NOTIFYCAP;
$modversion['notification']['event'][3]['description'] = _MI_NEWBB_GLOBAL_NEWFORUM_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template'] = 'global_newforum_notify';
$modversion['notification']['event'][3]['mail_subject'] = _MI_NEWBB_GLOBAL_NEWFORUM_NOTIFYSBJ;

$modversion['notification']['event'][4]['name'] = 'new_post';
$modversion['notification']['event'][4]['category'] = 'global';
$modversion['notification']['event'][4]['title'] = _MI_NEWBB_GLOBAL_NEWPOST_NOTIFY;
$modversion['notification']['event'][4]['caption'] = _MI_NEWBB_GLOBAL_NEWPOST_NOTIFYCAP;
$modversion['notification']['event'][4]['description'] = _MI_NEWBB_GLOBAL_NEWPOST_NOTIFYDSC;
$modversion['notification']['event'][4]['mail_template'] = 'global_newpost_notify';
$modversion['notification']['event'][4]['mail_subject'] = _MI_NEWBB_GLOBAL_NEWPOST_NOTIFYSBJ;

$modversion['notification']['event'][5]['name'] = 'new_post';
$modversion['notification']['event'][5]['category'] = 'forum';
$modversion['notification']['event'][5]['title'] = _MI_NEWBB_FORUM_NEWPOST_NOTIFY;
$modversion['notification']['event'][5]['caption'] = _MI_NEWBB_FORUM_NEWPOST_NOTIFYCAP;
$modversion['notification']['event'][5]['description'] = _MI_NEWBB_FORUM_NEWPOST_NOTIFYDSC;
$modversion['notification']['event'][5]['mail_template'] = 'forum_newpost_notify';
$modversion['notification']['event'][5]['mail_subject'] = _MI_NEWBB_FORUM_NEWPOST_NOTIFYSBJ;

$modversion['notification']['event'][6]['name'] = 'new_fullpost';
$modversion['notification']['event'][6]['category'] = 'global';
$modversion['notification']['event'][6]['admin_only'] = 1;
$modversion['notification']['event'][6]['title'] = _MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFY;
$modversion['notification']['event'][6]['caption'] = _MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFYCAP;
$modversion['notification']['event'][6]['description'] = _MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFYDSC;
$modversion['notification']['event'][6]['mail_template'] = 'global_newfullpost_notify';
$modversion['notification']['event'][6]['mail_subject'] = _MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFYSBJ;

$modversion['notification']['event'][7]['name'] = 'digest';
$modversion['notification']['event'][7]['category'] = 'global';
$modversion['notification']['event'][7]['title'] = _MI_NEWBB_GLOBAL_DIGEST_NOTIFY;
$modversion['notification']['event'][7]['caption'] = _MI_NEWBB_GLOBAL_DIGEST_NOTIFYCAP;
$modversion['notification']['event'][7]['description'] = _MI_NEWBB_GLOBAL_DIGEST_NOTIFYDSC;
$modversion['notification']['event'][7]['mail_template'] = 'global_digest_notify';
$modversion['notification']['event'][7]['mail_subject'] = _MI_NEWBB_GLOBAL_DIGEST_NOTIFYSBJ;

$modversion['notification']['event'][8]['name'] = 'new_fullpost';
$modversion['notification']['event'][8]['category'] = 'forum';
$modversion['notification']['event'][8]['admin_only'] = 1;
$modversion['notification']['event'][8]['title'] = _MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFY;
$modversion['notification']['event'][8]['caption'] = _MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFYCAP;
$modversion['notification']['event'][8]['description'] = _MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFYDSC;
$modversion['notification']['event'][8]['mail_template'] = 'global_newfullpost_notify';
$modversion['notification']['event'][8]['mail_subject'] = _MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFYSBJ;
?>