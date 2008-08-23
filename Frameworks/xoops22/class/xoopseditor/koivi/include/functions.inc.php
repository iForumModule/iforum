<?php
// $Id: functions.inc.php,v 1.1.2.2.2.1 2005/10/01 12:50:58 mithyt2 Exp $
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

/*
function getMainfile($url)
{
	
	$mpath='';
	for ($i=0;$i<strlen($url);$i++)
	{
		if ($url[$i]=='/')$mpath.='../';
	}
	return $mpath.'mainfile.php';
}

function getLanguage($url)
{
	global $xoopsConfig;
	if(file_exists(XOOPS_ROOT_PATH.''.$url.'/language/'.$xoopsConfig['language'].'.php')) 
	return ''.XOOPS_ROOT_PATH.''.$url.'/language/'.$xoopsConfig['language'].'.php';
	else return ''.XOOPS_ROOT_PATH.''.$url.'/language/english.php'; 
}


function CheckBrowser($get_isie=true)
{
	global $_SERVER;

		$comp=false;
		$isie=false;
		
		if(eregi("msie",$_SERVER['HTTP_USER_AGENT']) && !eregi("opera",$_SERVER['HTTP_USER_AGENT']) )
		{
			$val = explode(" ",stristr($_SERVER['HTTP_USER_AGENT'],"msie"));
			if((float)str_replace(";","",$val[1])>=5.5)$comp=true;
			$isie=true;
		}
		elseif(eregi("mozilla",$_SERVER['HTTP_USER_AGENT']) && eregi("rv:[0-9]\.[0-9]\.[0-9]",$_SERVER['HTTP_USER_AGENT']) && !eregi("netscape",$_SERVER['HTTP_USER_AGENT']))
		{
			$val = explode(" ",stristr($_SERVER['HTTP_USER_AGENT'],"rv:"));
			eregi("rv:[0-9]\.[0-9]\.[0-9]",$_SERVER['HTTP_USER_AGENT'],$val);
			$version = str_replace("rv:","",$val[0]);
			if ($version>1.3)$comp=true;
		}
		elseif(eregi("mozilla",$_SERVER['HTTP_USER_AGENT']) && eregi("rv:[0-9].[0-9][a-b]",$_SERVER['HTTP_USER_AGENT']) && !eregi("netscape",$_SERVER['HTTP_USER_AGENT']))
		{
			$val = explode(" ",stristr($_SERVER['HTTP_USER_AGENT'],"rv:"));
			eregi("rv:[0-9].[0-9][a-b]",$_SERVER['HTTP_USER_AGENT'],$val);
			$version = str_replace("rv:","",$val[0]);
			if ($version>1.3)$comp=true;
		}
		elseif(eregi("netscape",$_SERVER['HTTP_USER_AGENT']))
		{
			$val = explode("Netscape/",$_SERVER['HTTP_USER_AGENT']);
			$version = str_replace(" (ax)","",$val[1]);
			if($version>=7.1)$comp=true;
		}
	
	if($get_isie)return($isie);
	else return $comp;
}*/

function checkBrowser($get_isie=true)
{
	global $_SERVER;

		$comp=false;
		$isie=false;
		
		if(eregi("opera",$_SERVER['HTTP_USER_AGENT']))
		{
			$comp=false;
			$isie=false;
		}
		elseif(eregi("msie",$_SERVER['HTTP_USER_AGENT']))
		{
			$val = explode(" ",stristr($_SERVER['HTTP_USER_AGENT'],"msie"));
			if((float)str_replace(";","",$val[1])>=5.5)$comp=true;
			$isie=true;
		}
		elseif(eregi("mozilla",$_SERVER['HTTP_USER_AGENT']))
		{
			$comp=true;
			$isie=false;
		}
		elseif(eregi("netscape",$_SERVER['HTTP_USER_AGENT']))
		{
			$val = explode("Netscape/",$_SERVER['HTTP_USER_AGENT']);
			$version = str_replace(" (ax)","",$val[1]);
			if($version>=7.1)$comp=true;
			$isie=false;
		}
	
	if($get_isie)return($isie);
	else return $comp;
}
?>