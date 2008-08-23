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

function check_newbb_empty()
{
	global $xoopsDB;
	
	$bRet = true;

	$sql = "SELECT count(*) FROM ".$xoopsDB->prefix('bb_posts');
	$result = $xoopsDB->query($sql);
	if ($result)
	{
		$row = $xoopsDB->fetchArray($result);
		if ($row[0] > 0)
		{
			$bRet = false;
			echo _NEWBB_CONV_ERR_NOT_EMPTY."<br />";
		}
	}
	else
	{
		// newbb_plus tables don't exist - not installed!
		$bRet = false;
		echo _NEWBB_CONV_ERR_NOT_INSTALLED."<br />";
	}

	return $bRet;
}

function check_writable()
{
    if(!is_writable('./'))
	{
		echo _NEWBB_CONV_ERR_SQL_WRITE."<br />";
		return false;
	}
	return true;
}

function user_map()
{
	global $xoopsDB;

	$user_map = array();

	$sql = "SELECT * FROM ".$xoopsDB->prefix('users');
	$result = $xoopsDB->query($sql);
	if($result)
	{
		while ($row = $xoopsDB->fetchArray($result))
		{
			$user_map[$row->uid] = $row->uname;
		}
	}

	return $user_map;
}


function next_id($tbl_name)
{
	global $xoopsDB;
	$ret = -1;

	$arrFields = getTableFields($tbl_name);
	$primaryKey = getPrimaryKeyField($arrFields);

	if ($primaryKey != -1)
	{
		$sql = "SELECT max(".$arrFields[$primaryKey]['name'].") FROM ".$xoopsDB->prefix($tbl_name);
		$result = $xoopsDB->query($sql);
		if($result)
		{
			$row = $xoopsDB->fetchArray($result);
			$ret = $row[0];
			$ret++;
		}
	}

	return $ret;
}

function getTableFields($tbl_name)
{
	global $xoopsDB;

	$fields = array();
	$result = $xoopsDB->query("select * from ".$xoopsDB->prefix($tbl_name));
	if(!$result) echo $xoopsDB->error();
	for ($i = 0; $i < mysql_num_fields($result); $i++)
	{
		$fields[$i]['name'] = mysql_field_name($result, $i);
		$fields[$i]['type'] = mysql_field_type($result, $i);
		$fields[$i]['flags'] = mysql_field_flags($result, $i);
	}
	return $fields;
}

function getPrimaryKeyField($arrFields)
{
	$ret = -1;
	for ($i=0; $i<count($arrFields); $i++)
	{
		if (strpos($arrFields[$i]['flags'],'primary_key'))
		{
			$ret = $i;
			break;
		}
	}
	return $ret;
}

function runSQLFile($filename)
{
	@set_time_limit(300);

	global $xoopsConfig, $xoopsDB;
	include_once(XOOPS_ROOT_PATH.'/class/database/database.php');
	$xoopsDB = new Database();
	$xoopsDB->setPrefix($xoopsConfig['prefix']);
	$result1 = @$xoopsDB->connect($xoopsConfig['dbhost'], $xoopsConfig['dbuname'], $xoopsConfig['dbpass'], $xoopsConfig['db_pconnect']);
	if (!$result1) {
		echo $xoopsDB->error();
		exit();
	}
	$result2 = @mysq_select_db($xoopsConfig['dbname']);
	if (!$result2) {
		echo $xoopsDB->error();
		exit();
	}
	echo "<font size=+1><b>Executing SQL File</b></font><br /><br />";

	$handle = fopen ($filename, "r");
	$contents = fread ($handle, filesize ($filename));
	fclose ($handle);
	$cmds = explode(SQL_SEPARATOR, $contents);
	$cmd_count = 0;
	$ok_count = 0;
	
	foreach($cmds as $cmd)
	{
		if (empty($cmd)) continue;

		$cmd_count++;
		$result = $xoopsDB->query($cmd);
		if($result)
		{
			$ok_count++;
		}
		else
		{
		    echo $cmd."<br>".$xoopsDB->error()."<br>";
		}
	}
	
	printf(_NEWBB_CONV_SQL_EXEC, $ok_count, $cmd_count);
	echo "<br/>";
}
?>