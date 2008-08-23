<?php
// $Id: xoops_version.php,v 1.6.2.6 2005/01/10 01:49:41 phppp Exp $
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

$modversion['name'] = "NewBB 2.0";
$modversion['version'] = 2.02;
$modversion['description'] = _MI_NEWBB_DESC;
$modversion['credits'] = "The XOOPS Project, samuels, phppp, Dave_L, herve, Mithrandir,  The Xoops China, The French Xoops Support";
$modversion['author'] = "The XOOPS Project Module Dev Team - NewBB Teamleader Predator";
$modversion['help'] = "";
$modversion['license'] = "GNU General Public License (GPL) see LICENSE";
$modversion['official'] = 1;
$modversion['image'] = "images/xoopsbb_slogo.png";
$modversion['dirname'] = "newbb";

// Added by marcan for the About page in admin section
$modversion['author_realname'] = "Marko Schmuck";
$modversion['author_website_url'] = "http://dev.xoops.org";
$modversion['author_website_name'] = "dev.xoops.org";
$modversion['author_email'] = "predator@xoops.org";
$modversion['status_version'] = "2.02";
$modversion['status'] = "Final";

$modversion['warning'] = "This module comes as it is, without any guarantees what so ever.
Although this module is not beta, it is still under active development. This release can be used
in a live website or a production environment, but its <strong>use</strong> is under your own responsibility,
which means the author is not responsible.";

$modversion['demo_site_url'] = "http://www.xoops2.org";
$modversion['demo_site_name'] = "NewBB Demo";
$modversion['support_site_url'] = "http://dev.xoops.org/modules/xfmod/project/?newbb";
$modversion['support_site_name'] = "Newbb on the Developers Forge";
$modversion['submit_bug'] = "http://dev.xoops.org/modules/xfmod/tracker/?func=add&group_id=1001&atid=104";
$modversion['submit_feature'] = "http://dev.xoops.org/modules/xfmod/tracker/?func=add&group_id=1001&atid=107";

$modversion['author_word'] = "
<strong>NewBB</strong> is the result of multiple ideas from multiple people.
<br /><br />
For some external code very big thanks to:
<br /><br />
About page ( this here ) by marcan http://www.smartfactory.ca<br />
Blockadmin by GIJOE<br />
Adminmenu by Horacio http://www.mesadepruebas.com
<br /><br />
Special thanks also to Mithrandir (Jan Pedersen) for all the help by the grouppermission , a very big thanks to phppp  from Xoops China for his excellent teamwork and The Xoops China Community which put a lot of work into the newbb.
<br /><br />
For the Buttons thanks to simeon and alitanara.
<br /><br />
For the dutch translation: jan304 http://xoops.jan304.org <br />
For the french translation: outch and the French Xoops Support http://www.frxoops.org<br />
For the persian translation: irmtfan http://www.jadoogaran.com<br />
For the german translation: the http://www.xoops-city.de team.<br />
For the portuguese brazil translation: Valcilon, victorcpd from http://www.xoopstotal.com.br .<br />
For the spanish translation: Marco Sánchez (Dr. Clone) http://www.drclone.net .<br />
For the italian translation: Blueangel http://www.xoopsit.net .<br />
For the russian translation: Alexxus http://www.xoops.ru .<br />
For the swedish translation: perhol http://fino.net .<br />
For the schinese and tchinese translation: phppp, chia and the Xoops China http://www.xoops.org.cn .<br />
<br /><br />
Finally, thanks to all the people who made that module possible, samuels, phppp, David_L, herve, bbchen and so many others !
<br /><br />
So, enjoy newBB !
";


// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
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


// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;

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


// Blocks
//$modversion['blocks'][$i]['options'] = "NumberToDisplay|DisplayMode(0-fullview;1-compactview;2-liteview)|OrderBy|SelectedForumIDs";

$modversion['blocks'][1]['file'] = "newbb_block.php";
$modversion['blocks'][1]['name'] = _MI_NEWBB_BNAME1;
$modversion['blocks'][1]['description'] = "Shows recent topics in the forums";
$modversion['blocks'][1]['show_func'] = "b_newbb_show";
$modversion['blocks'][1]['options'] = "10|0|time|0";
$modversion['blocks'][1]['edit_func'] = "b_newbb_edit";
$modversion['blocks'][1]['template'] = 'newbb_block.html';

$modversion['blocks'][2]['file'] = "newbb_block.php";
$modversion['blocks'][2]['name'] = _MI_NEWBB_BNAME2;
$modversion['blocks'][2]['description'] = "Shows most viewed topics in the forums";
$modversion['blocks'][2]['show_func'] = "b_newbb_show";
$modversion['blocks'][2]['options'] = "10|0|views|0";
$modversion['blocks'][2]['edit_func'] = "b_newbb_edit";
$modversion['blocks'][2]['template'] = 'newbb_block.html';

$modversion['blocks'][3]['file'] = "newbb_block.php";
$modversion['blocks'][3]['name'] = _MI_NEWBB_BNAME3;
$modversion['blocks'][3]['description'] = "Shows most active topics in the forums";
$modversion['blocks'][3]['show_func'] = "b_newbb_show";
$modversion['blocks'][3]['options'] = "10|0|replies|0";
$modversion['blocks'][3]['edit_func'] = "b_newbb_edit";
$modversion['blocks'][3]['template'] = 'newbb_block.html';


// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "newbb_search";

// Smarty
$modversion['use_smarty'] = 1;

include_once(XOOPS_ROOT_PATH.'/modules/newbb/include/functions.php');

$handle = opendir(XOOPS_ROOT_PATH.'/modules/newbb/images/imagesets/');
while (false !== ($file = readdir($handle))) {
  if (is_dir(XOOPS_ROOT_PATH.'/modules/newbb/images/imagesets/'.$file) && !preg_match("/^[.]{1,2}$/",$file) && strtolower($file) != 'cvs') {
    $dirlist[$file]=$file;
  }
}
closedir($handle);

$modversion['config'][] = array(
	'name' 			=> 'image_set',
	'title' 		=> '_MI_IMG_SET',
	'description' 	=> '_MI_IMG_SET_DESC',
	'formtype' 		=> 'select',
	'valuetype' 	=> 'text',
	'options' 		=> $dirlist,
	'default' 		=> "default");

$modversion['config'][] = array(
	'name' 			=> 'image_type',
	'title' 		=> '_MI_IMG_TYPE',
	'description' 	=> '_MI_IMG_TYPE_DESC',
	'formtype' 		=> 'select',
	'valuetype' 	=> 'text',
	'options' 		=> array('png'=>'png', 'gif'=>'gif', 'auto'=>'auto'),
	'default' 		=> "png");

$modversion['config'][] = array(
	'name' 			=> 'pngforie_enabled',
	'title' 		=> '_MI_PNGFORIE_ENABLE',
	'description' 	=> '_MI_PNGFORIE_ENABLE_DESC',
	'formtype' 		=> 'yesno',
	'valuetype' 	=> 'int',
	'default' 		=> 1);

$modversion['config'][] = array(
	'name' => 'form_options',
	'title' => '_MI_FORM_OPTIONS',
	'description' => '_MI_FORM_OPTIONS_DESC',
	'formtype' => 'select_multi',
	'valuetype' => 'array',
	'options' => array(
					_MI_FORM_DHTML=>'dhtml',
					_MI_FORM_COMPACT=>'textarea',
					_MI_FORM_SPAW=>'spaw',
					_MI_FORM_HTMLAREA=>'htmlarea',
					_MI_FORM_KOIVI=>'koivi',
					_MI_FORM_TINYMCE=>'tinymce',
					_MI_FORM_FCK=>'fck'),
	'default' => array('dhtml', 'textarea'));

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
	'default' => (newbb_is_dir('/usr/bin/X11'))?'/usr/bin/X11':'');

$modversion['config'][] = array(
	'name' => 'path_netpbm',
	'title' => '_MI_PATH_NETPBM',
	'description' => '_MI_PATH_NETPBM_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'text',
	'default' => (newbb_is_dir('/usr/bin'))?'/usr/bin':'');

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
	'name' => 'wol_admin_col',
	'title' => '_MI_WOL_ADMIN_COL',
	'description' => '_MI_WOL_ADMIN_COL_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'text',
	'default' => '#FFA34F');

$modversion['config'][] = array(
	'name' => 'wol_mod_col',
	'title' => '_MI_WOL_MOD_COL',
	'description' => '_MI_WOL_MOD_COL_DESC',
	'formtype' => 'textbox',
	'valuetype' => 'text',
	'default' => '#006600');

$modversion['config'][] = array(
	'name' => 'levels_enabled',
	'title' => '_MI_LEVELS_ENABLE',
	'description' => '_MI_LEVELS_ENABLE_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

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
	'default' => 1);

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
	'default' => 200);

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
	'default' => 1);

$modversion['config'][] = array(
	'name' => 'view_mode',
	'title' => '_MI_VIEWMODE',
	'description' => '_MI_VIEWMODE_DESC',
	'formtype' => 'select',
	'valuetype' => 'int',
	'default' => 1,
	'options' => array( _NONE => 0, _FLAT => 1, _THREADED => 2));

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
	'name' => 'allow_moderator_html',
	'title' => '_MI_MODERATOR_HTML',
	'description' => '_MI_MODERATOR_HTML_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1);

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
	'default' => '<center>The forum contains a lot of posts with a lot of usefull information. <br /><br />In order to keep the number of double-posts to a minimum, we would like to ask you to use the forum search before posting your questions here.</center>');

// Notification

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
$modversion['notification']['category'][2]['subscribe_from'] = array('viewtopic.php', 'viewforum.php');
$modversion['notification']['category'][2]['item_name'] = 'forum';
$modversion['notification']['category'][2]['allow_bookmark'] = 1;

$modversion['notification']['category'][3]['name'] = 'global';
$modversion['notification']['category'][3]['title'] = _MI_NEWBB_GLOBAL_NOTIFY;
$modversion['notification']['category'][3]['description'] = _MI_NEWBB_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = array('index.php', 'viewtopic.php', 'viewforum.php');

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

?>