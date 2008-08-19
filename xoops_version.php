<?php
// $Id: xoops_version.php,v 1.1.1.66 2004/11/15 22:09:16 praedator Exp $
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
$modversion['version'] = 2.00;
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
$modversion['status_version'] = "2.0";
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

$modversion['config'][1]['name'] = 'image_set';
$modversion['config'][1]['title'] = '_MI_IMG_SET';
$modversion['config'][1]['description'] = '_MI_IMG_SET_DESC';
$modversion['config'][1]['formtype'] = 'select';
$modversion['config'][1]['valuetype'] = 'text';
$modversion['config'][1]['options'] = $dirlist;
$modversion['config'][1]['default'] = "default";

$modversion['config'][55]['name'] = 'image_type';
$modversion['config'][55]['title'] = '_MI_IMG_TYPE';
$modversion['config'][55]['description'] = '_MI_IMG_TYPE_DESC';
$modversion['config'][55]['formtype'] = 'select';
$modversion['config'][55]['valuetype'] = 'text';
$modversion['config'][55]['options'] = array('png'=>'png', 'gif'=>'gif', 'auto'=>'auto');
$modversion['config'][55]['default'] = "png";

$modversion['config'][56]['name'] = 'pngforie_enabled';
$modversion['config'][56]['title'] = '_MI_PNGFORIE_ENABLE';
$modversion['config'][56]['description'] = '_MI_PNGFORIE_ENABLE_DESC';
$modversion['config'][56]['formtype'] = 'yesno';
$modversion['config'][56]['valuetype'] = 'int';
$modversion['config'][56]['default'] = 1;

$modversion['config'][57]['name'] = 'form_options';
$modversion['config'][57]['title'] = '_MI_FORM_OPTIONS';
$modversion['config'][57]['description'] = '_MI_FORM_OPTIONS_DESC';
$modversion['config'][57]['formtype'] = 'select_multi';
$modversion['config'][57]['valuetype'] = 'array';
$modversion['config'][57]['options'] = array(
											_MI_FORM_DHTML=>'dhtml',
											_MI_FORM_COMPACT=>'textarea',
											_MI_FORM_SPAW=>'spaw',
											_MI_FORM_HTMLAREA=>'htmlarea',
											_MI_FORM_KOIVI=>'koivi',
											_MI_FORM_FCK=>'fck'
											);
$modversion['config'][57]['default'] = array('dhtml', 'textarea');

$modversion['config'][50]['name'] = 'topics_per_page';
$modversion['config'][50]['title'] = '_MI_TOPICSPERPAGE';
$modversion['config'][50]['description'] = '_MI_TOPICSPERPAGE_DESC';
$modversion['config'][50]['formtype'] = 'textbox';
$modversion['config'][50]['valuetype'] = 'int';
$modversion['config'][50]['default'] = 20;

$modversion['config'][51]['name'] = 'posts_per_page';
$modversion['config'][51]['title'] = '_MI_POSTSPERPAGE';
$modversion['config'][51]['description'] = '_MI_POSTSPERPAGE_DESC';
$modversion['config'][51]['formtype'] = 'textbox';
$modversion['config'][51]['valuetype'] = 'int';
$modversion['config'][51]['default'] = 10;


$modversion['config'][40]['name'] = 'cache_enabled';
$modversion['config'][40]['title'] = '_MI_CACHE_ENABLE';
$modversion['config'][40]['description'] = '_MI_CACHE_ENABLE_DESC';
$modversion['config'][40]['formtype'] = 'yesno';
$modversion['config'][40]['valuetype'] = 'int';
$modversion['config'][40]['default'] = 0;

$modversion['config'][2]['name'] = 'dir_attachments';
$modversion['config'][2]['title'] = '_MI_DIR_ATTACHMENT';
$modversion['config'][2]['description'] = '_MI_DIR_ATTACHMENT_DESC';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = 'uploads/newbb';

$modversion['config'][16]['name'] = 'media_allowed';
$modversion['config'][16]['title'] = '_MI_MEDIA_ENABLE';
$modversion['config'][16]['description'] = '_MI_MEDIA_ENABLE_DESC';
$modversion['config'][16]['formtype'] = 'yesno';
$modversion['config'][16]['valuetype'] = 'int';
$modversion['config'][16]['default'] = 1;

$modversion['config'][3]['name'] = 'path_magick';
$modversion['config'][3]['title'] = '_MI_PATH_MAGICK';
$modversion['config'][3]['description'] = '_MI_PATH_MAGICK_DESC';
$modversion['config'][3]['formtype'] = 'textbox';
$modversion['config'][3]['valuetype'] = 'text';
$modversion['config'][3]['default'] = (newbb_is_dir('/usr/bin/X11'))?'/usr/bin/X11':'';

$modversion['config'][58]['name'] = 'path_netpbm';
$modversion['config'][58]['title'] = '_MI_PATH_NETPBM';
$modversion['config'][58]['description'] = '_MI_PATH_NETPBM_DESC';
$modversion['config'][58]['formtype'] = 'textbox';
$modversion['config'][58]['valuetype'] = 'text';
$modversion['config'][58]['default'] = (newbb_is_dir('/usr/bin'))?'/usr/bin':'';

$modversion['config'][59]['name'] = 'image_lib';
$modversion['config'][59]['title'] = '_MI_IMAGELIB';
$modversion['config'][59]['description'] = '_MI_IMAGELIB_DESC';
$modversion['config'][59]['formtype'] = 'select';
$modversion['config'][59]['valuetype'] = 'int';
$modversion['config'][59]['default'] = 4;
$modversion['config'][59]['options'] = array( _MI_AUTO => 0,_MI_MAGICK => 1, _MI_NETPBM => 2, _MI_GD1 => 3, _MI_GD2 => 4 );

$modversion['config'][4]['name'] = 'max_img_width';
$modversion['config'][4]['title'] = '_MI_MAX_IMG_WIDTH';
$modversion['config'][4]['description'] = '_MI_MAX_IMG_WIDTH_DESC';
$modversion['config'][4]['formtype'] = 'textbox';
$modversion['config'][4]['valuetype'] = 'int';
$modversion['config'][4]['default'] = 500;

$modversion['config'][5]['name'] = 'wol_enabled';
$modversion['config'][5]['title'] = '_MI_WOL_ENABLE';
$modversion['config'][5]['description'] = '_MI_WOL_ENABLE_DESC';
$modversion['config'][5]['formtype'] = 'yesno';
$modversion['config'][5]['valuetype'] = 'int';
$modversion['config'][5]['default'] = 1;

$modversion['config'][6]['name'] = 'wol_admin_col';
$modversion['config'][6]['title'] = '_MI_WOL_ADMIN_COL';
$modversion['config'][6]['description'] = '_MI_WOL_ADMIN_COL_DESC';
$modversion['config'][6]['formtype'] = 'textbox';
$modversion['config'][6]['valuetype'] = 'text';
$modversion['config'][6]['default'] = '#FFA34F';

$modversion['config'][7]['name'] = 'wol_mod_col';
$modversion['config'][7]['title'] = '_MI_WOL_MOD_COL';
$modversion['config'][7]['description'] = '_MI_WOL_MOD_COL_DESC';
$modversion['config'][7]['formtype'] = 'textbox';
$modversion['config'][7]['valuetype'] = 'text';
$modversion['config'][7]['default'] = '#006600';

$modversion['config'][8]['name'] = 'levels_enabled';
$modversion['config'][8]['title'] = '_MI_LEVELS_ENABLE';
$modversion['config'][8]['description'] = '_MI_LEVELS_ENABLE_DESC';
$modversion['config'][8]['formtype'] = 'yesno';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = 1;

$modversion['config'][9]['name'] = 'userbar_enabled';
$modversion['config'][9]['title'] = '_MI_USERBAR_ENABLE';
$modversion['config'][9]['description'] = '_MI_USERBAR_ENABLE_DESC';
$modversion['config'][9]['formtype'] = 'yesno';
$modversion['config'][9]['valuetype'] = 'int';
$modversion['config'][9]['default'] = 1;

$modversion['config'][34]['name'] = 'show_realname';
$modversion['config'][34]['title'] = '_MI_SHOW_REALNAME';
$modversion['config'][34]['description'] = '_MI_SHOW_REALNAME_DESC';
$modversion['config'][34]['formtype'] = 'yesno';
$modversion['config'][34]['valuetype'] = 'int';
$modversion['config'][34]['default'] = 0;

$modversion['config'][32]['name'] = 'groupbar_enabled';
$modversion['config'][32]['title'] = '_MI_GROUPBAR_ENABLE';
$modversion['config'][32]['description'] = '_MI_GROUPBAR_ENABLE_DESC';
$modversion['config'][32]['formtype'] = 'yesno';
$modversion['config'][32]['valuetype'] = 'int';
$modversion['config'][32]['default'] = 1;

$modversion['config'][10]['name'] = 'rating_enabled';
$modversion['config'][10]['title'] = '_MI_RATING_ENABLE';
$modversion['config'][10]['description'] = '_MI_RATING_ENABLE_DESC';
$modversion['config'][10]['formtype'] = 'yesno';
$modversion['config'][10]['valuetype'] = 'int';
$modversion['config'][10]['default'] = 1;

$modversion['config'][11]['name'] = 'reportmod_enabled';
$modversion['config'][11]['title'] = '_MI_REPORTMOD_ENABLE';
$modversion['config'][11]['description'] = '_MI_REPORTMOD_ENABLE_DESC';
$modversion['config'][11]['formtype'] = 'yesno';
$modversion['config'][11]['valuetype'] = 'int';
$modversion['config'][11]['default'] = 0;

$modversion['config'][52]['name'] = 'quickreply_enabled';
$modversion['config'][52]['title'] = '_MI_QUICKREPLY_ENABLE';
$modversion['config'][52]['description'] = '_MI_QUICKREPLY_ENABLE_DESC';
$modversion['config'][52]['formtype'] = 'yesno';
$modversion['config'][52]['valuetype'] = 'int';
$modversion['config'][52]['default'] = 1;

$modversion['config'][12]['name'] = 'rss_enable';
$modversion['config'][12]['title'] = '_MI_RSS_ENABLE';
$modversion['config'][12]['description'] = '_MI_RSS_ENABLE_DESC';
$modversion['config'][12]['formtype'] = 'yesno';
$modversion['config'][12]['valuetype'] = 'int';
$modversion['config'][12]['default'] = 1;

$modversion['config'][13]['name'] = 'rss_maxitems';
$modversion['config'][13]['title'] = '_MI_RSS_MAX_ITEMS';
$modversion['config'][13]['description'] = '';
$modversion['config'][13]['formtype'] = 'textbox';
$modversion['config'][13]['valuetype'] = 'int';
$modversion['config'][13]['default'] = 10;

$modversion['config'][14]['name'] = 'rss_maxdescription';
$modversion['config'][14]['title'] = '_MI_RSS_MAX_DESCRIPTION';
$modversion['config'][14]['description'] = '';
$modversion['config'][14]['formtype'] = 'textbox';
$modversion['config'][14]['valuetype'] = 'int';
$modversion['config'][14]['default'] = 200;

$modversion['config'][15]['name'] = 'rss_cachetime';
$modversion['config'][15]['title'] = '_MI_RSS_CACHETIME';
$modversion['config'][15]['description'] = '_MI_RSS_CACHETIME_DESCRIPTION';
$modversion['config'][15]['formtype'] = 'textbox';
$modversion['config'][15]['valuetype'] = 'int';
$modversion['config'][15]['default'] = 30;

$modversion['config'][18]['name'] = 'rss_utf8';
$modversion['config'][18]['title'] = '_MI_RSS_UTF8';
$modversion['config'][18]['description'] = '_MI_RSS_UTF8_DESCRIPTION';
$modversion['config'][18]['formtype'] = 'yesno';
$modversion['config'][18]['valuetype'] = 'int';
$modversion['config'][18]['default'] = 1;

$modversion['config'][17]['name'] = 'view_mode';
$modversion['config'][17]['title'] = '_MI_VIEWMODE';
$modversion['config'][17]['description'] = '_MI_VIEWMODE_DESC';
$modversion['config'][17]['formtype'] = 'select';
$modversion['config'][17]['valuetype'] = 'int';
$modversion['config'][17]['default'] = 1;
$modversion['config'][17]['options'] = array( _NONE => 0, _FLAT => 1, _THREADED => 2);

$modversion['config'][19]['name'] = 'show_jump';
$modversion['config'][19]['title'] = '_MI_SHOW_JUMPBOX';
$modversion['config'][19]['description'] = '_MI_JUMPBOXDESC';
$modversion['config'][19]['formtype'] = 'yesno';
$modversion['config'][19]['valuetype'] = 'int';
$modversion['config'][19]['default'] = 1;

$modversion['config'][42]['name'] = 'show_permissiontable';
$modversion['config'][42]['title'] = '_MI_SHOW_PERMISSIONTABLE';
$modversion['config'][42]['description'] = '_MI_SHOW_PERMISSIONTABLE_DESC';
$modversion['config'][42]['formtype'] = 'yesno';
$modversion['config'][42]['valuetype'] = 'int';
$modversion['config'][42]['default'] = 1;

$modversion['config'][20]['name'] = 'email_digest';
$modversion['config'][20]['title'] = '_MI_EMAIL_DIGEST';
$modversion['config'][20]['description'] = '_MI_EMAIL_DIGEST_DESC';
$modversion['config'][20]['formtype'] = 'select';
$modversion['config'][20]['valuetype'] = 'int';
$modversion['config'][20]['default'] = 0;
$modversion['config'][20]['options'] = array( _MI_NEWBB_EMAIL_NONE => 0, _MI_NEWBB_EMAIL_DAILY => 1, _MI_NEWBB_EMAIL_WEEKLY => 2);

$modversion['config'][21]['name'] = 'show_ip';
$modversion['config'][21]['title'] = '_MI_SHOW_IP';
$modversion['config'][21]['description'] = '_MI_SHOW_IP_DESC';
$modversion['config'][21]['formtype'] = 'yesno';
$modversion['config'][21]['valuetype'] = 'int';
$modversion['config'][21]['default'] = 1;

$modversion['config'][22]['name'] = 'enable_karma';
$modversion['config'][22]['title'] = '_MI_ENABLE_KARMA';
$modversion['config'][22]['description'] = '_MI_ENABLE_KARMA_DESC';
$modversion['config'][22]['formtype'] = 'yesno';
$modversion['config'][22]['valuetype'] = 'int';
$modversion['config'][22]['default'] = 1;

$modversion['config'][23]['name'] = 'karma_options';
$modversion['config'][23]['title'] = '_MI_KARMA_OPTIONS';
$modversion['config'][23]['description'] = '_MI_KARMA_OPTIONS_DESC';
$modversion['config'][23]['formtype'] = 'textbox';
$modversion['config'][23]['valuetype'] = 'text';
$modversion['config'][23]['default'] = '0,10,50,100,500,1000,5000,10000';

$modversion['config'][24]['name'] = 'allow_moderator_html';
$modversion['config'][24]['title'] = '_MI_MODERATOR_HTML';
$modversion['config'][24]['description'] = '_MI_MODERATOR_HTML_DESC';
$modversion['config'][24]['formtype'] = 'yesno';
$modversion['config'][24]['valuetype'] = 'int';
$modversion['config'][24]['default'] = 1;

$modversion['config'][25]['name'] = 'allow_user_anonymous';
$modversion['config'][25]['title'] = '_MI_USER_ANONYMOUS';
$modversion['config'][25]['description'] = '_MI_USER_ANONYMOUS_DESC';
$modversion['config'][25]['formtype'] = 'yesno';
$modversion['config'][25]['valuetype'] = 'int';
$modversion['config'][25]['default'] = 1;

$modversion['config'][31]['name'] = 'anonymous_prefix';
$modversion['config'][31]['title'] = '_MI_ANONYMOUS_PRE';
$modversion['config'][31]['description'] = '_MI_ANONYMOUS_PRE_DESC';
$modversion['config'][31]['formtype'] = 'textbox';
$modversion['config'][31]['valuetype'] = 'text';
$modversion['config'][31]['default'] = 'Guest_';

$modversion['config'][26]['name'] = 'allow_require_reply';
$modversion['config'][26]['title'] = '_MI_REQUIRE_REPLY';
$modversion['config'][26]['description'] = '_MI_REQUIRE_REPLY_DESC';
$modversion['config'][26]['formtype'] = 'yesno';
$modversion['config'][26]['valuetype'] = 'int';
$modversion['config'][26]['default'] = 1;

$modversion['config'][27]['name'] = 'edit_timelimit';
$modversion['config'][27]['title'] = '_MI_EDIT_TIMELIMIT';
$modversion['config'][27]['description'] = '_MI_EDIT_TIMELIMIT_DESC';
$modversion['config'][27]['formtype'] = 'textbox';
$modversion['config'][27]['valuetype'] = 'int';
$modversion['config'][27]['default'] = 60;

$modversion['config'][41]['name'] = 'recordedit_timelimit';
$modversion['config'][41]['title'] = '_MI_RECORDEDIT_TIMELIMIT';
$modversion['config'][41]['description'] = '_MI_RECORDEDIT_TIMELIMIT_DESC';
$modversion['config'][41]['formtype'] = 'textbox';
$modversion['config'][41]['valuetype'] = 'int';
$modversion['config'][41]['default'] = 15;

$modversion['config'][30]['name'] = 'delete_timelimit';
$modversion['config'][30]['title'] = '_MI_DELETE_TIMELIMIT';
$modversion['config'][30]['description'] = '_MI_DELETE_TIMELIMIT_DESC';
$modversion['config'][30]['formtype'] = 'textbox';
$modversion['config'][30]['valuetype'] = 'int';
$modversion['config'][30]['default'] = 60;

$modversion['config'][35]['name'] = 'post_timelimit';
$modversion['config'][35]['title'] = '_MI_POST_TIMELIMIT';
$modversion['config'][35]['description'] = '_MI_POST_TIMELIMIT_DESC';
$modversion['config'][35]['formtype'] = 'textbox';
$modversion['config'][35]['valuetype'] = 'int';
$modversion['config'][35]['default'] = 30;

$modversion['config'][33]['name'] = 'subject_prefix';
$modversion['config'][33]['title'] = '_MI_SUBJECT_PREFIX';
$modversion['config'][33]['description'] = '_MI_SUBJECT_PREFIX_DESC';
$modversion['config'][33]['formtype'] = 'textarea';
$modversion['config'][33]['valuetype'] = 'text';
$modversion['config'][33]['default'] = 'NONE,<font color="#00CC00">[solved]</font>,<font color="#00CC00">[fixed]</font>,<font color="#FF0000">[request]</font>,<font color="#FF0000">[bug report]</font>,<font color="#FF0000">[unsolved]</font>';

$modversion['config'][28]['name'] = 'disc_show';
$modversion['config'][28]['title'] = '_MI_SHOW_DIS';
$modversion['config'][28]['description'] = '_MI_SHOW_DIS_DESC';
$modversion['config'][28]['formtype'] = 'select';
$modversion['config'][28]['valuetype'] = 'int';
$modversion['config'][28]['default'] = 0;
$modversion['config'][28]['options'] = array( _NONE => 0, _MI_POST => 1, _MI_REPLY => 2, _MI_OP_BOTH=> 3);

$modversion['config'][29]['name'] = 'disclaimer';
$modversion['config'][29]['title'] = '_MI_DISCLAIMER';
$modversion['config'][29]['description'] = '_MI_DISCLAIMER_DESC';
$modversion['config'][29]['formtype'] = 'textarea';
$modversion['config'][29]['valuetype'] = 'text';
$modversion['config'][29]['default'] = '<center>The forum contains a lot of posts with a lot of usefull information. <br /><br />In order to keep the number of double-posts to a minimum, we would like to ask you to use the forum search before posting your questions here.</center>';

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