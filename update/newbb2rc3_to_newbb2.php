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
<form action='newbb2rc3_to_newbb2.php' method='post'>
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
	<table width='100%' border='0'><tr><td colspan='2'>". _NEWBB_UPDATE_L4."</td></tr>
	<tr><td>-</td><td>"._NEWBB_UPDATE_L03."</td></tr>
	<tr><td>-</td><td><span style='color:#ff0000;font-weight:bold;'>"._NEWBB_UPDATE_L04."</span></td></tr>
	<tr>
    <td colspan='2' align='center'><br /><br /><input type='hidden' name='action' value='update2' /><input type='submit' name='submit' value='"._NEWBB_UPDATE_L99."' /></td>
    </tr>
  	</table>
	";
	install_footer();
	exit();
}





if ( $action == "update2" ) {

install_header();

$result = $xoopsDB->queryF("ALTER TABLE ".$xoopsDB->prefix("bb_online")." ADD `online_topic` INT(10) NOT NULL DEFAULT '0' AFTER `online_forum`");
if (!$result) {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/no.gif'></td><td width='70%' align='left'><span style='color:#ff0000;font-weight:bold'>Could not add field in ".$xoopsDB->prefix("bb_online")."</span></td></tr>";
}
else {
	echo "<tr align='center'><td width='30%' align='right'><img src='img/yes.gif'></td><td width='70%' align='left'>&nbsp;Change field in ".$xoopsDB->prefix."_bb_online</td></tr>";
}


echo "<tr>";
echo "<td colspan='2' align='center'><br /><br /><input type='hidden' name='action' value='update5' /><input type='submit' name='submit' value='"._NEWBB_UPDATE_L91."' /></td>
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