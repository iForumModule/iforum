<?php
// $Id: index.php,v 1.3 2005/10/19 17:20:32 phppp Exp $
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
include('admin_header.php');

function newbb_admin_getPathStatus($path)
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

function newbb_admin_mkdir($target, $mode=0777)
{
	// http://www.php.net/manual/en/function.mkdir.php
	return is_dir($target) or ( newbb_admin_mkdir(dirname($target), $mode) and mkdir($target, $mode) );
}

function newbb_admin_chmod($target, $mode = 0777)
{
	return @chmod($target, $mode);
}

function newbb_getImageLibs()
{
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

$op = (isset($_GET['op']))? $_GET['op'] : "";

switch ($op) {
    case "createdir":
		if (isset($_GET['path'])) $path = $_GET['path'];
        $res = newbb_admin_mkdir($path);
        $msg = ($res)?_AM_NEWBB_DIRCREATED:_AM_NEWBB_DIRNOTCREATED;
        redirect_header('index.php', 2, $msg . ': ' . $path);
        exit();
        break;

    case "setperm":
		if (isset($_GET['path'])) $path = $_GET['path'];
        $res = newbb_admin_chmod($path, 0777);
        $msg = ($res)?_AM_NEWBB_PERMSET:_AM_NEWBB_PERMNOTSET;
        redirect_header('index.php', 2, $msg . ': ' . $path);
        exit();
        break;

    case "senddigest":
        $digest_handler = &icms_getmodulehandler('digest', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
        $res = $digest_handler->process(true);
        $msg = ($res)?_AM_NEWBB_DIGEST_FAILED:_AM_NEWBB_DIGEST_SENT;
        redirect_header('index.php', 2, $msg);
        exit();
        break;

    case "default":
    default:

        xoops_cp_header();

        loadModuleAdminMenu(0, "Index");
		$imageLibs = newbb_getImageLibs();

        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_PREFERENCES . "</legend>";

        echo "<div style='padding: 12px;'>" . _AM_NEWBB_POLLMODULE . ": ";
        $module_handler = &xoops_gethandler('module');
        $xoopspoll = &$module_handler->getByDirname('xoopspoll');
        if (is_object($xoopspoll)) $isOK = $xoopspoll->getVar('isactive');
        else $isOK = false;
        echo ($isOK)?_AM_NEWBB_AVAILABLE:_AM_NEWBB_NOTAVAILABLE;
        echo "</div>";
        echo "<div style='padding: 8px;'>";
	    echo "<a href='http://www.imagemagick.org' target='_blank'>"._AM_NEWBB_IMAGEMAGICK."&nbsp;</a>";
	    if(array_key_exists('imagemagick',$imageLibs)) {
	    	echo "<strong><font color='green'>"._AM_NEWBB_AUTODETECTED.$imageLibs['imagemagick']."</font></strong>";
	    }
	    else { echo _AM_NEWBB_NOTAVAILABLE;
		}
	    echo "<br />";
		echo "<a href='http://sourceforge.net/projects/netpbm' target='_blank'>NetPBM:&nbsp;</a>";
		if(array_key_exists('netpbm',$imageLibs)) {
			echo "<strong><font color='green'>"._AM_NEWBB_AUTODETECTED.$imageLibs['netpbm']."</font></strong>";
		}
		else { echo _AM_NEWBB_NOTAVAILABLE;
		}
		echo "<br />";
		echo _AM_NEWBB_GDLIB1."&nbsp;";
		if(array_key_exists('gd1',$imageLibs)) {
			echo "<strong><font color='green'>"._AM_NEWBB_AUTODETECTED.$imageLibs['gd1']."</font></strong>";
		}
		else { echo _AM_NEWBB_NOTAVAILABLE;
		}
			
		echo "<br />";
		echo _AM_NEWBB_GDLIB2."&nbsp;";
		if(array_key_exists('gd2',$imageLibs)) {
			echo "<strong><font color='green'>"._AM_NEWBB_AUTODETECTED.$imageLibs['gd2']."</font></strong>";
		}
		else { echo _AM_NEWBB_NOTAVAILABLE;
		}
		echo "</div>";
      

        echo "<div style='padding: 8px;'>" . _AM_NEWBB_ATTACHPATH . ": ";
        $attach_path = XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['dir_attachments'] . '/';
        $path_status = newbb_admin_getPathStatus($attach_path);
        echo $attach_path . ' ( ' . $path_status . ' )';

        echo "<br />" . _AM_NEWBB_THUMBPATH . ": ";
        $thumb_path = $attach_path . 'thumbs/'; // be careful
        $path_status = newbb_admin_getPathStatus($thumb_path);
        echo $thumb_path . ' ( ' . $path_status . ' )';

        echo "</div>";

        echo "</fieldset><br />";

        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_BOARDSUMMARY . "</legend>";
        echo "<div style='padding: 12px;'>";
        echo _AM_NEWBB_TOTALTOPICS . " <strong>" . get_total_topics() . "</strong> | ";
        echo _AM_NEWBB_TOTALPOSTS . " <strong>" . get_total_posts() . "</strong> | ";
        echo _AM_NEWBB_TOTALVIEWS . " <strong>" . get_total_views() . "</strong></div>";
        echo "</fieldset><br />";

        $report_handler = &icms_getmodulehandler('report', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_REPORT . "</legend>";
        echo "<div style='padding: 12px;'><a href='admin_report.php'>" . _AM_NEWBB_REPORT_PENDING . "</a> <strong>" . $report_handler->getCount(new Criteria("report_result", 0)) . "</strong> | ";
        echo _AM_NEWBB_REPORT_PROCESSED . " <strong>" . $report_handler->getCount(new Criteria("report_result", 1)) . "</strong>";
        echo "</div>";
        echo "</fieldset><br />";

        if ($xoopsModuleConfig['email_digest'] > 0) {
            $digest_handler = &icms_getmodulehandler('digest', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
            echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_NEWBB_DIGEST . "</legend>";
            $due = ($digest_handler->checkStatus()) / 60; // minutes
            $prompt = ($due > 0)? sprintf(_AM_NEWBB_DIGEST_PAST, $due):sprintf(_AM_NEWBB_DIGEST_NEXT, abs($due));
            echo "<div style='padding: 12px;'><a href='index.php?op=senddigest'>" . $prompt . "</a> | ";
            echo "<a href='admin_digest.php'>" . _AM_NEWBB_DIGEST_ARCHIVE . "</a> <strong>" . $digest_handler->getDigestCount() . "</strong>";
            echo "</div>";
            echo "</fieldset><br />";
        }

        echo "<br /><br />";

        /* A trick to clear garbage for suspension management
         * Not good but works
         */
		if (!empty($xoopsModuleConfig['enable_usermoderate'])){
			$moderate_handler =& icms_getmodulehandler('moderate', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
			$moderate_handler->clearGarbage();
		}
         
        xoops_cp_footer();
        break;
}

?>