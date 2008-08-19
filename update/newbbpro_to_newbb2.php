<?php
// ------------------------------------------------------------------------- //
//                XOOPS - PHP Content Management System                      //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //
include_once "../../../mainfile.php";

$myts =& MyTextSanitizer::getInstance();

if ( isset($HTTP_POST_VARS) ) {
    foreach ($HTTP_POST_VARS as $k=>$v) {
        $$k = $myts->stripSlashesGPC($v);
    }
}
$language = $xoopsConfig['language'];

if ( file_exists("language/".$language."/updater.php") ) {
    include_once "language/".$language."/updater.php";
} elseif ( file_exists("language/english/updater.php") ) {
    include_once "language/english/updater.php";
    $language = 'english';
} else {
    echo 'no language file.';
    exit();
}


function install_header(){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title>Newbb 2.0 Updater</title>
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo _NEWBB_UPDATE_CHARSET ?>" />
  <style type="text/css" media="all"><!-- @import url(../../../xoops.css); --></style>
  <link rel="stylesheet" type="text/css" media="all" href="style.css" />
</head>
<body style="margin: 0; padding: 0;">
<form action='newbbpro_to_newbb2.php' method='post'>
<table width="778" align="center" cellpadding="0" cellspacing="0" background="img/bg_table.gif">
  <tr>
    <td width="150"><img src="img/hbar_left.gif" width="100%" height="23" alt="" /></td>
    <td width="478" background="img/hbar_middle.gif">&nbsp;</td>
    <td width="150"><img src="img/hbar_right.gif" width="100%" height="23" alt="" /></td>
  </tr>
  <tr>
    <td width="150"><a href="index.php"><img src="img/logo.gif" width="150" height="80" alt="" /></a></td>
    <td width="478" background="img/bg_darkblue.gif">&nbsp;</td>
    <td width="150"><img src="img/xoops2.gif" width="100%" height="80"></td>
  </tr>
  <tr>
    <td width="150"><img src="img/hbar_left.gif" width="100%" height="23" alt="" /></td>
    <td width="478" background="img/hbar_middle.gif">&nbsp;</td>
    <td width="150"><img src="img/hbar_right.gif" width="100%" height="23" alt="" /></td>
  </tr>
</table>

<table width="778" align="center" cellspacing="0" cellpadding="0" background="img/bg_table.gif"
  <tr>
    <td width='5%'>&nbsp;</td>
    <td align="center"><h4 style="margin-top: 10px; margin-bottom: 5px; padding: 10px;"><?php echo _NEWBB_UPDATE_L01;?></h4><div style="padding: 10px; text-align:left;">
<?php



}

function install_footer(){
?>

    <td width='5%'>&nbsp;</td>
  </tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><strong>Newbb 2.0 Updater by <a href='http://dev.xoops.org'>dev.xoops.org</a><br /><br /><a href='http://www.xoops.org/' target='_blank'><img src='../../../images/s_poweredby.gif' alt='XOOPS' border='0' /></a>&nbsp;
 <a href='http://www.spreadfirefox.com/?q=affiliates&amp;id=0&amp;t=70'><img border='0' alt='Get Firefox!' title='Get Firefox!' src='img/get.gif'/></a>   
    </strong></div><br />
	</td>
  </tr>
</table>

<table width="778" cellspacing="0" cellpadding="0" align="center" background="img/bg_table.gif">
  <tr>
    <td width="150"><img src="img/hbar_left.gif" width="100%" height="23" alt="" /></td>
    <td width="478" background="img/hbar_middle.gif">&nbsp;</td>
    <td width="150"><img src="img/hbar_installer_right.gif" width="100%" height="23" alt="" /></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}

if ( !isset($action) || $action == "" ) {
	$action = "message";
}

if ( $action == "message" ) {
	install_header();
	echo "
	<table width='100%' border='0'><tr><td colspan='2'>". _NEWBB_UPDATE_L40."</td></tr>
	<tr><td>-</td><td>"._NEWBB_UPDATE_L03."</td></tr>
	<tr><td>-</td><td><span style='color:#ff0000;font-weight:bold;'>"._NEWBB_UPDATE_L04."</span></td></tr>
	<tr>
    <td colspan='2' align='center'><br /><br /><input type='hidden' name='action' value='update1' /><input type='submit' name='submit' value='"._NEWBB_UPDATE_L99."' /></td>
    </tr>
  	</table>
	";
	install_footer();
	exit();
}


if ( $action == "update1" ) {

install_header();
echo "<table width='100%' border='0'><tr><td colspan='2' align='center'><b>". _NEWBB_UPDATE_L05."</b></td></tr>";

$result = $xoopsDB->queryF("CREATE TABLE ".$xoopsDB->prefix("bb_archive")."(
	`topic_id` tinyint(8) NOT NULL default '0',
	`post_id` tinyint(8) NOT NULL default '0',
  	`post_text` text NOT NULL
	) TYPE=MyISAM");

if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not create ".$xoopsDB->prefix("bb_archive")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Create ".$xoopsDB->prefix."_bb_archive</td></tr>";
}

$result = $xoopsDB->queryF("CREATE TABLE ".$xoopsDB->prefix("bb_attachments")."(
	`attach_id` int(8) unsigned NOT NULL auto_increment,
  `post_id` int(10) default NULL,
  `name_saved` varchar(255) default NULL,
  `name_disp` varchar(255) default NULL,
  `mimetype` varchar(255) default NULL,
  `online` int(1) NOT NULL default '1',
  `attach_time` int(10) NOT NULL default '0',
  `download` int(10) NOT NULL default '0',
  PRIMARY KEY  (`attach_id`),
  KEY `post_id` (`post_id`)
) TYPE=MyISAM");


if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not create ".$xoopsDB->prefix("bb_attachments")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Create ".$xoopsDB->prefix."_bb_attachments</td></tr>";
}
$result = $xoopsDB->queryF("CREATE TABLE ".$xoopsDB->prefix("bb_digest")."(
 `digest_id` int(8) unsigned NOT NULL auto_increment,
 `digest_time` int(10) NOT NULL default '0',
 `digest_content` text,
  PRIMARY KEY  (`digest_id`),
  KEY `digest_time` (`digest_time`)

) TYPE=MyISAM");


if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not create ".$xoopsDB->prefix("bb_digest")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Create ".$xoopsDB->prefix."_bb_digest</td></tr>";
}
$result = $xoopsDB->queryF("CREATE TABLE ".$xoopsDB->prefix("bb_online")."(
  `online_forum` int(10) NOT NULL default '0',
  `online_topic` int(10) NOT NULL default '0',
  `online_uid` int(10) default NULL,
  `online_uname` varchar(255) default NULL,
  `online_ip` varchar(32) default NULL,
  `online_updated` int(14) default NULL
) TYPE=MyISAM");


if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not create ".$xoopsDB->prefix("bb_online")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Create ".$xoopsDB->prefix."_bb_online</td></tr>";
}

$result = $xoopsDB->queryF("CREATE TABLE ".$xoopsDB->prefix("bb_report")."(
 `report_id` int(8) unsigned NOT NULL auto_increment,
  `post_id` int(10) default NULL,
  `reporter_uid` int(10) default NULL,
  `reporter_ip` int(11) NOT NULL default '0',
  `report_time` int(10) NOT NULL default '0',
  `report_text` varchar(255) default NULL,
  `report_result` tinyint(1) NOT NULL default '0',
  `report_memo` varchar(255) default NULL,
  PRIMARY KEY  (`report_id`),
  KEY `post_id` (`post_id`)
) TYPE=MyISAM");


if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not create ".$xoopsDB->prefix("bb_report")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Create ".$xoopsDB->prefix."_bb_report</td></tr>";
}

$result = $xoopsDB->queryF("CREATE TABLE ".$xoopsDB->prefix("bb_votedata")."(
 `ratingid` int(11) unsigned NOT NULL auto_increment,
  `topic_id` int(11) unsigned NOT NULL default '0',
  `ratinguser` int(11) NOT NULL default '0',
  `rating` tinyint(3) unsigned NOT NULL default '0',
  `ratinghostname` varchar(60) NOT NULL default '',
  `ratingtimestamp` int(10) NOT NULL default '0',
  PRIMARY KEY  (ratingid),
  KEY ratinguser (ratinguser),
  KEY ratinghostname (ratinghostname),
  KEY topic_id (topic_id)
) TYPE=MyISAM");


if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not create ".$xoopsDB->prefix("bb_votedata")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Create ".$xoopsDB->prefix."_bb_votedata</td></tr>";
}

echo "<tr>";
echo "<td colspan='2' align='center'><br /><br /><input type='hidden' name='action' value='update2' /><input type='submit' name='submit' value='"._NEWBB_UPDATE_L90."' /></td>
    </tr>";

echo "</table>";
install_footer();
}



if ( $action == "update2" ) {

install_header();
echo "<table width='100%' border='0'><tr><td colspan='2' align='center'><b>". _NEWBB_UPDATE_L06."</b></td></tr>";

//categories
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_categories")." ADD `cat_image` VARCHAR(50) DEFAULT NULL AFTER `cat_id`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_categories")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_categories</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_categories")." ADD `cat_description` TEXT NOT NULL AFTER `cat_title`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_categories")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_categories</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_categories")." CHANGE `cat_order` `cat_order` SMALLINT(3) UNSIGNED NOT NULL DEFAULT '0'");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not change field in ".$xoopsDB->prefix("bb_categories")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Change field in ".$xoopsDB->prefix."_bb_categories</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_categories")." ADD `cat_state` INT(1) NOT NULL DEFAULT '0' AFTER `cat_order`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_categories")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_categories</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_categories")." ADD `cat_url` VARCHAR(50) DEFAULT NULL AFTER `cat_state`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_categories")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_categories</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_categories")." ADD `cat_showdescript` SMALLINT(3) NOT NULL DEFAULT '0' AFTER `cat_url`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_categories")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_categories</td></tr>";
}

//forums

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." DROP `forum_access`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not drop field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Drop field in ".$xoopsDB->prefix."_bb_forums</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." DROP `posts_per_page`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not drop field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Drop field in ".$xoopsDB->prefix."_bb_forums</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." DROP `topics_per_page`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not drop field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Drop field in ".$xoopsDB->prefix."_bb_forums</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." ADD `parent_forum` INT(10) NOT NULL DEFAULT '0' AFTER `forum_desc`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_forums</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." CHANGE `forum_moderator` `forum_moderator` TEXT NOT NULL");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not change field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Change field in ".$xoopsDB->prefix."_bb_forums</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." CHANGE `forum_type` `forum_type` INT(1) NOT NULL DEFAULT '0'");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not change field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Change field in ".$xoopsDB->prefix."_bb_forums</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." CHANGE `allow_html` `allow_html` INT(1) NOT NULL DEFAULT '1'");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not change field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Change field in ".$xoopsDB->prefix."_bb_forums</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." CHANGE `allow_sig` `allow_sig` INT(1) NOT NULL DEFAULT '1'");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not change field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Change field in ".$xoopsDB->prefix."_bb_forums</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." ADD `allow_subject_prefix` INT(1) NOT NULL DEFAULT '0' AFTER `allow_sig`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_forums</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." CHANGE `allow_attachments` `allow_attachments` INT(1) NOT NULL DEFAULT '1'");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not change field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Change field in ".$xoopsDB->prefix."_bb_forums</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." ADD `forum_order` INT(8) NOT NULL DEFAULT '0' AFTER `hot_threshold`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_forums</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." ADD `allow_polls` INT(1) NOT NULL DEFAULT '0' AFTER `attach_ext`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_forums</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_forums")." ADD `subforum_count` INT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `allow_polls`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_forums")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_forums</td></tr>";
}

//posts
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_posts")." ADD `poster_name` varchar(255) DEFAULT NULL AFTER `uid`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_posts")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_posts</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_posts")." CHANGE `poster_ip` `poster_ip` INT(11) NOT NULL DEFAULT '0'");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not change field in ".$xoopsDB->prefix("bb_posts")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Change field in ".$xoopsDB->prefix."_bb_posts</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_posts")." DROP `nosmiley`");

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_posts")." CHANGE `nohtml` `dohtml` TINYINT(1) NOT NULL DEFAULT '0'");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not change field in ".$xoopsDB->prefix("bb_posts")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Change field in ".$xoopsDB->prefix."_bb_posts</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_posts")." ADD `dosmiley` TINYINT(1) NOT NULL DEFAULT '1' AFTER `dohtml`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_posts")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Change field in ".$xoopsDB->prefix."_bb_posts</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_posts")." ADD `doxcode` TINYINT(1) NOT NULL DEFAULT '0' AFTER `dosmiley`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_posts")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_posts</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_posts")." ADD `dobr` TINYINT(1) NOT NULL DEFAULT '1' AFTER `doxcode`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>OK exist just to be sure ".$xoopsDB->prefix("bb_posts")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_posts</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_posts")." ADD `doimage` TINYINT(1) NOT NULL DEFAULT '1' AFTER `dobr`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>OK exist just to be sure ".$xoopsDB->prefix("bb_posts")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_posts</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_posts")." ADD `approved` int(1) NOT NULL default '1' AFTER `attachsig`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_posts")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_posts</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_posts")." ADD  `post_karma` int(10) NOT NULL default '0' AFTER `approved`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_posts")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_posts</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_posts")." ADD `require_reply` int(1) NOT NULL default '0' AFTER `attachment`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_posts")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_posts</td></tr>";
}

//posts_text
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_posts_text")." ADD `post_edit` TEXT NOT NULL AFTER `post_text`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_posts_text")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_posts_text</td></tr>";
}


//topics
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_topics")." ADD `topic_subject` INT(3) NOT NULL default '0' AFTER `topic_status`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_topics")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_topics</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_topics")." ADD `topic_digest` TINYINT(1) NOT NULL default '0' AFTER `topic_sticky`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_topics")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_topics</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_topics")." ADD  `digest_time` int(10) NOT NULL default '0' AFTER `topic_digest`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_topics")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_topics</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_topics")." ADD `approved` int(1) NOT NULL default '1' AFTER  `digest_time`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_topics")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_topics</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_topics")." ADD `poster_name` varchar(255) DEFAULT NULL AFTER `approved`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_topics")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_topics</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_topics")." ADD `rating` double(6,4) NOT NULL default '0.0000' AFTER `poster_name`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_topics")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_topics</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_topics")." ADD  `votes` int(11) unsigned NOT NULL default '0' AFTER `rating`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_topics")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_topics</td></tr>";
}

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_topics")." ADD `topic_haspoll` tinyint(1) NOT NULL default '0' AFTER `votes`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_topics")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_topics</td></tr>";
}
$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_topics")." ADD  `poll_id` mediumint(8) unsigned NOT NULL default '0' AFTER `topic_haspoll`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_topics")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Add field to ".$xoopsDB->prefix."_bb_topics</td></tr>";
}





echo "<tr>";
echo "<td colspan='2' align='center'><br /><br /><input type='hidden' name='action' value='update4' /><input type='submit' name='submit' value='"._NEWBB_UPDATE_L91."' /></td>
    </tr>";

echo "</table>";
install_footer();
}

/*
if ( $action == "update3" ) {

install_header();
echo "<table width='100%' border='0'><tr><td colspan='2' align='center'><b>". _NEWBB_UPDATE_L07."</b></td></tr>";










echo "<tr>";
echo "<td colspan='2' align='center'><br /><br /><input type='hidden' name='action' value='update4' /><input type='submit' name='submit' value='"._NEWBB_UPDATE_L92."' /></td>
    </tr>";


echo "</table>";
install_footer();
}
*/


if ( $action == "update4" ) {

install_header();
echo "<table width='100%' border='0'><tr><td colspan='2' align='center'><b>". _NEWBB_UPDATE_L08."</b></td></tr>";

$result = $xoopsDB->queryF("DROP TABLE ".$xoopsDB->prefix("bb_forum_access"));

if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not drop ".$xoopsDB->prefix("bb_forum_access")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Drop ".$xoopsDB->prefix."_bb_forum_access</td></tr>";
}

$result = $xoopsDB->queryF("DROP TABLE ".$xoopsDB->prefix("bb_forum_mods"));

if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not drop ".$xoopsDB->prefix("bb_forum_mods")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Drop ".$xoopsDB->prefix."_bb_forum_mods</td></tr>";
}


echo "<tr>";
echo "<td colspan='2' align='center'><br /><br /><input type='hidden' name='action' value='update5' /><input type='submit' name='submit' value='"._NEWBB_UPDATE_L93."' /></td>
    </tr>";

echo "</table>";
install_footer();
}

if ( $action == "update5" ) {

install_header();
echo "<table width='100%' border='0'><tr><td colspan='2' align='center'><b>". _NEWBB_UPDATE_L20."</b></td></tr>";
echo "<tr><td align='center'>"._NEWBB_UPDATE_L30."</td></tr>";
echo "</table>";
install_footer();
}

function saveNewbbModeratorUpdates($uid) {

        if ( is_array($uid) ) { $uid = implode(" ", $uid); }
        //explode(" ",$ff->forum_moderator)
return($uid);
}



?>