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
include_once "functions.php";
$myts =& MyTextSanitizer::getInstance();

if ( isset($_POST) ) {
    foreach ($_POST as $k=>$v) {
        $$k = $myts->stripSlashesGPC($v);
    }
}
$step=0;
$language = 'english';

if ( file_exists("language/".$language."/converter.php") ) {
    include_once "language/".$language."/converter.php";
} elseif ( file_exists("language/english/converter.php") ) {
    include_once "language/english/converter.php";
    $language = 'english';
} else {
    echo 'no language file.';
    exit();
}

define('SQL_SEPARATOR', ";;\r\n");

$step = (isset($_POST['step'])) ? intval($_POST['step']) : 0;

switch ($step)
{
	case 1:
	{
	    config_form();
	    break;
	}
    case 2:
    {
		
		converter_header($step);
			
    	$converter = 'converter/convert_'.$_POST['src_type'].'.php';
    	
		if (file_exists($converter))
		{
			
			include_once($converter);

			$convert_options['dbhost'] = $_POST['src_dbhost'];
			$convert_options['dbuser'] = $_POST['src_dbuser'];
			$convert_options['dbpass'] = $_POST['src_dbpass'];
			$convert_options['dbname'] = $_POST['src_dbname'];
			$convert_options['dbprefix'] = $_POST['src_dbprefix'];
			$convert_options['import_pms'] = $_POST['import_pms'];
			$convert_options['pm_sys'] = $_POST['pm_sys'];
			if (check_newbb_empty() && check_writable())
			{
				@set_time_limit(300);
				$sqlfile = do_import();
				echo '<form action="index.php" method=post>';
				echo '<input type=hidden name=step value=3>';
				echo '<input type=hidden name=src_type value='.$_POST['src_type'].'>';
				echo '<input type=hidden name=sqlfile value="'.$sqlfile.'">';
				echo '<div align=center><input class=button type=submit name=submit value="'._NEWBB_CONV_PROCEED.'"></div>';
				echo '</form>';
			}
		}
		else
		{
			echo _NEWBB_CONV_ERR_NO_CONVERTER."<br />";
		}
		converter_footer();
		break;
    }
    case 3:
    {
		
		converter_header($step);
		if (file_exists($_POST['sqlfile']))
		{
			runSQLFile($_POST['sqlfile']);
		}
		echo '<br /><br />"'._NEWBB_CONV_ENDINFO.'"';
		
		if($POST['src_type'] == 'ipb1.3.1')
		{
		    echo _NEWBB_CONV_IPBEND;
		}
		echo '<br /><br />';
		echo '<div align=center>';
		echo '<input type=button class=button value="'._NEWBB_CONV_XOOPS_INDEX.'"       onclick="javasctipt:location=\''.XOOPS_URL.'/index.php\'">&nbsp;&nbsp;';
		echo '<input type=button class=button value="'._NEWBB_CONV_XOOPS_ADMIN.'" onclick="javasctipt:location=\''.XOOPS_URL.'/admin.php\'">&nbsp;&nbsp;';
		echo '<input type=button class=button value="'._NEWBB_CONV_NEWBB_INDEX.'"         onclick="javasctipt:location=\''.XOOPS_URL.'/modules/newbb/index.php\'">';
		echo '</div>';
		converter_footer();
		break;
    }
    case 0:
    default:
    {
        converter_instructions();
    }
}
exit();


function converter_instructions()
{
	
	converter_header(0);
		
	echo _NEWBB_CONV_INSTRUCTIONS_DESC;
	echo '<form action="index.php" method=post>';
	echo '<input type=hidden name=step value=1>';
	echo '<div align=center><input class=button type=submit name=submit value="'._NEWBB_CONV_PROCEED.'"></div>';
	echo '</form>';
	converter_footer();
	
}

function config_form()
{
	converter_header(1);
	
	include_once(XOOPS_ROOT_PATH.'/class/xoopsformloader.php');

	$converter_form = new XoopsThemeForm(_NEWBB_CONV_CFG_TITLE, 'converter_form', 'index.php');
	$src_type = new XoopsFormSelect(_NEWBB_CONV_CFG_FORUM_TYPE, 'src_type');
	$src_type->addOptionArray(list_converters());
	$converter_form->addElement($src_type);
	$converter_form->addElement(new XoopsFormText(_NEWBB_CONV_CFG_DB_HOST,		'src_dbhost',	40, 40));
	$converter_form->addElement(new XoopsFormText(_NEWBB_CONV_CFG_DB_USER,		'src_dbuser',	40, 40));
	$converter_form->addElement(new XoopsFormText(_NEWBB_CONV_CFG_DB_PASS,		'src_dbpass',	40, 40));
	$converter_form->addElement(new XoopsFormText(_NEWBB_CONV_CFG_DB_NAME,		'src_dbname',	40, 40));
	$converter_form->addElement(new XoopsFormText(_NEWBB_CONV_CFG_DB_PREFIX,		'src_dbprefix', 40, 40));
	$converter_form->addElement(new XoopsFormRadioYN(_NEWBB_CONV_CFG_PM,		    'import_pms', 1));

	$pm_sys = new XoopsFormSelect(_NEWBB_CONV_CFG_PM_SYSTEM, 'pm_sys');
	$pm_sys->addOption(0,_NEWBB_CONV_CFG_PM_XOOPS);
	$pm_sys->addOption(1,_NEWBB_CONV_CFG_PM_SYSTEM);
	$converter_form->addElement($pm_sys);

	$converter_form->addElement(new XoopsFormHidden('step', '2'));
	$converter_form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, $type="submit"));
	echo $converter_form->render();
	converter_footer();
	
}

function list_converters()
{
	$arrConverter = array();

	$d = dir("./converter"); 
	while (false !== ($entry = $d->read()))
	{ 
		if($entry != "." && $entry != "..")
		{
			if (substr($entry, 0, 8) == 'convert_')
			{
				$p = strrpos($entry, '.');
				$converter = substr($entry, 8, $p-8);
				$arrConverter[$converter] = $converter;
			}
		}
	} 
	$d->close();
	
	return $arrConverter;	
}

function converter_header(){
echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title>Newbb 2.0 Converter</title>
  <meta http-equiv="Content-Type" content="text/html; charset="'. _NEWBB_CONV_CHARSET .'" />
  <style type="text/css" media="all"><!-- @import url(../../../xoops.css); --></style>
  <link rel="stylesheet" type="text/css" media="all" href="style.css" />
</head>';
echo '
<body style="margin: 0; padding: 0;" bgcolor="#2F5376">

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

<table width="778" align="center" cellspacing="0" cellpadding="0" background="img/bg_table.gif">
  <tr>
    <td width="5%">&nbsp;</td>
    <td align="center" ><div style="padding: 10px; text-align:left;">';


echo '<table width="100%">';
	echo '<tr class="bg2"><td colspan=2 align=center><font size=+1><b>'._NEWBB_CONV_TITLE.'</b></font></td></tr>';
	echo '<tr valign=top><td width="150"><br />'; 
	switch (isset($_POST['step']))
	{
	    case 0:
		    echo '<li><b><font color=#FF0000>'._NEWBB_CONV_INSTRUCTIONS.'</font></b></li>';
		    echo '<li><b>'._NEWBB_CONV_CONFIG.'</b></li>';
			echo '<li><b>'._NEWBB_CONV_GEN_SQL.'</b></li>';
			echo '<li><b>'._NEWBB_CONV_EXEC_SQL.'</b></li></td>';
			break;
	    case 1:
		    echo '<li><b>'._NEWBB_CONV_INSTRUCTIONS.'</b></li>';
		    echo '<li><b><font color=#FF0000>'._NEWBB_CONV_CONFIG.'</font></b></li>';
			echo '<li><b>'._NEWBB_CONV_GEN_SQL.'</b></li>';
			echo '<li><b>'._NEWBB_CONV_EXEC_SQL.'</b></li></td>';
			break;
	    case 2:
		    echo '<li><b>'._NEWBB_CONV_INSTRUCTIONS.'</b></li>';
		    echo '<li><b>'._NEWBB_CONV_CONFIG.'</font></b></li>';
			echo '<li><b><font color=#FF0000>'._NEWBB_CONV_GEN_SQL.'</font></b></li>';
			echo '<li><b>'._NEWBB_CONV_EXEC_SQL.'</b></li></td>';
			break;
	    case 3:
		    echo '<li><b>'._NEWBB_CONV_INSTRUCTIONS.'</b></li>';
		    echo '<li><b>'._NEWBB_CONV_CONFIG.'</font></b></li>';
			echo '<li><b>'._NEWBB_CONV_GEN_SQL.'</b></li>';
			echo '<li><b><font color=#FF0000>'._NEWBB_CONV_EXEC_SQL.'</font></b></li></td>';
			break;
	}
	echo '<td>';


}

function converter_footer($step=1){

echo '</td></tr></table>';
echo '<td width="5%">&nbsp;</td>
  </tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><strong>Newbb 2.0 Converter by <a href="http://dev.xoops.org">dev.xoops.org</a><br /><br /><a href="http://www.xoops.org/" target="_blank"><img src="../../../images/s_poweredby.gif" alt="XOOPS" border="0" /></a>&nbsp;
 <a href="http://www.spreadfirefox.com/?q=affiliates&amp;id=0&amp;t=70"><img border="0" alt="Get Firefox!" title="Get Firefox!" src="img/get.gif"/></a>   
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
</body>
</html>';
}

?>