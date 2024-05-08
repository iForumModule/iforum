<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright  http://www.xoops.org/ The XOOPS Project
* @copyright  http://xoopsforge.com The XOOPS FORGE Project
* @copyright  http://xoops.org.cn The XOOPS CHINESE Project
* @copyright  XOOPS_copyrights.txt
* @copyright  readme.txt
* @copyright  http://www.impresscms.org/ The ImpressCMS Project
* @license   GNU General Public License (GPL)
*     a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package  CBB - XOOPS Community Bulletin Board
* @since   3.08
* @author  phppp
* ----------------------------------------------------------------------------------------------------------
*     iForum - a bulletin Board (Forum) for ImpressCMS
* @since   1.00
* @author  modified by stranger
* @version  $Id$
*/

include('admin_header.php');
icms_loadLanguageFile(dirname(dirname(__FILE__)), "common" );

function iforum_admin_getPathStatus($path)
{
	if (empty($path)) return false;
	if (@is_writable($path))
	{
		$path_status = _AM_IFORUM_AVAILABLE;
	}
	elseif(!@is_dir($path))
	{
		$path_status = _AM_IFORUM_NOTAVAILABLE." <a href=index.php?op=createdir&amp;path=$path>"._AM_IFORUM_CREATETHEDIR.'</a>';
	}
	else
	{
		$path_status = _AM_IFORUM_NOTWRITABLE." <a href=index.php?op=setperm&amp;path=$path>"._AM_IFORUM_SETMPERM.'</a>';
	}
	return $path_status;
}

function iforum_admin_mkdir($target, $mode = 0777)
{
	// http://www.php.net/manual/en/function.mkdir.php
	return is_dir($target) or (iforum_admin_mkdir(dirname($target), $mode) and mkdir($target, $mode) );
}

function iforum_admin_chmod($target, $mode = 0777)
{
	return @chmod($target, $mode);
}

function iforum_getImageLibs()
{
	$imageLibs = array();
	unset($output, $status);
	if (icms::$module->config['image_lib'] == 1 or icms::$module->config['image_lib'] == 0 )
		{
		$path = empty(icms::$module->config['path_magick'])?"":
		icms::$module->config['path_magick']."/";
		@exec($path.'convert -version', $output, $status);
		if (empty($status) && !empty($output))
		{
			if (preg_match("/imagemagick[ \t]+([0-9\.]+)/i", $output[0], $matches))
			$imageLibs['imagemagick'] = $matches[0];
		}
		unset($output, $status);
	}
	if (icms::$module->config['image_lib'] == 2 or icms::$module->config['image_lib'] == 0 )
		{
		$path = empty(icms::$module->config['path_netpbm'])?"":
		icms::$module->config['path_netpbm']."/";
		@exec($path.'jpegtopnm -version 2>&1', $output, $status);
		if (empty($status) && !empty($output))
		{
			if (preg_match("/netpbm[ \t]+([0-9\.]+)/i", $output[0], $matches))
			$imageLibs['netpbm'] = $matches[0];
		}
		unset($output, $status);
	}

	$GDfuncList = get_extension_funcs('gd');
	ob_start();
	@phpinfo(INFO_MODULES);
	$output = ob_get_contents();
	ob_end_clean();
	$matches[1] = '';
	if (preg_match("/GD Version[ \t]*(<[^>]+>[ \t]*)+([^<>]+)/s", $output, $matches))
	{
		$gdversion = $matches[2];
	}
	if ($GDfuncList )
	{
		if (in_array('imagegd2', $GDfuncList) )
		$imageLibs['gd2'] = $gdversion;
		else
			$imageLibs['gd1'] = $gdversion;
	}
	return $imageLibs;
}

$op = (isset($_GET['op']))? $_GET['op'] :
 "";

switch ($op)
{
	case "createdir":
	if (isset($_GET['path'])) $path = $_GET['path'];
	$res = iforum_admin_mkdir($path);
	$msg = ($res)?_AM_IFORUM_DIRCREATED:
	_AM_IFORUM_DIRNOTCREATED;
	redirect_header('index.php', 2, $msg . ': ' . $path);
	exit();
	break;

	case "setperm":
	if (isset($_GET['path'])) $path = $_GET['path'];
	$res = iforum_admin_chmod($path, 0777);
	$msg = ($res)?_AM_IFORUM_PERMSET:
	_AM_IFORUM_PERMNOTSET;
	redirect_header('index.php', 2, $msg . ': ' . $path);
	exit();
	break;

	case "senddigest":
	$digest_handler =icms_getmodulehandler('digest', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
	$res = $digest_handler->process(true);
	$msg = ($res)?_AM_IFORUM_DIGEST_FAILED:
	_AM_IFORUM_DIGEST_SENT;
	redirect_header('index.php', 2, $msg);
	exit();
	break;

	case "default":
	default:

	icms_cp_header();

	loadModuleAdminMenu(0, "Index");
	$imageLibs = iforum_getImageLibs();

	echo "<fieldset style='border: #e8e8e8 1px solid;'>
		<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_PREFERENCES . "</legend>";

	echo "<div style='padding: 12px;'>" . _AM_IFORUM_POLLMODULE . ": ";
	echo (iforum_poll_module_active()) ? _AM_IFORUM_AVAILABLE : _AM_IFORUM_NOTAVAILABLE;
	echo "</div>";
	echo "<div style='padding: 8px;'>";
	echo "<a href='http://www.imagemagick.org' target='_blank'>"._AM_IFORUM_IMAGEMAGICK."&nbsp;</a>";
	if (array_key_exists('imagemagick', $imageLibs))
	{
		echo "<strong><font color='green'>"._AM_IFORUM_AUTODETECTED.$imageLibs['imagemagick']."</font></strong>";
	}
	else
	{
		 echo _AM_IFORUM_NOTAVAILABLE;
	}
	echo "<br />";
	echo "<a href='http://sourceforge.net/projects/netpbm' target='_blank'>NetPBM:&nbsp;</a>";
	if (array_key_exists('netpbm', $imageLibs))
	{
		echo "<strong><font color='green'>"._AM_IFORUM_AUTODETECTED.$imageLibs['netpbm']."</font></strong>";
	}
	else
	{
		 echo _AM_IFORUM_NOTAVAILABLE;
	}
	echo "<br />";
	echo _AM_IFORUM_GDLIB1."&nbsp;";
	if (array_key_exists('gd1', $imageLibs))
	{
		echo "<strong><font color='green'>"._AM_IFORUM_AUTODETECTED.$imageLibs['gd1']."</font></strong>";
	}
	else
	{
		 echo _AM_IFORUM_NOTAVAILABLE;
	}

	echo "<br />";
	echo _AM_IFORUM_GDLIB2."&nbsp;";
	if (array_key_exists('gd2', $imageLibs))
	{
		echo "<strong><font color='green'>"._AM_IFORUM_AUTODETECTED.$imageLibs['gd2']."</font></strong>";
	}
	else
	{
		 echo _AM_IFORUM_NOTAVAILABLE;
	}
	echo "</div>";


	echo "<div style='padding: 8px;'>" . _AM_IFORUM_ATTACHPATH . ": ";
	$attach_path = ICMS_ROOT_PATH . '/' . icms::$module->config['dir_attachments'] . '/';
	$path_status = iforum_admin_getPathStatus($attach_path);
	echo $attach_path . ' ( ' . $path_status . ' )';

	echo "<br />" . _AM_IFORUM_THUMBPATH . ": ";
	$thumb_path = $attach_path . 'thumbs/'; // be careful
	$path_status = iforum_admin_getPathStatus($thumb_path);
	echo $thumb_path . ' ( ' . $path_status . ' )';

	echo "</div>";

	echo "</fieldset><br />";

	echo "<fieldset style='border: #e8e8e8 1px solid;'>
		<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_BOARDSUMMARY . "</legend>";
	echo "<div style='padding: 12px;'>";
	echo _AM_IFORUM_TOTALTOPICS . " <strong>" . get_total_topics() . "</strong> | ";
	echo _AM_IFORUM_TOTALPOSTS . " <strong>" . get_total_posts() . "</strong> | ";
	echo _AM_IFORUM_TOTALVIEWS . " <strong>" . get_total_views() . "</strong></div>";
	echo "</fieldset><br />";

	$report_handler =icms_getmodulehandler('report', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
	echo "<fieldset style='border: #e8e8e8 1px solid;'>
		<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_REPORT . "</legend>";
	echo "<div style='padding: 12px;'><a href='admin_report.php'>" . _AM_IFORUM_REPORT_PENDING . "</a> <strong>" . $report_handler->getCount(new icms_db_criteria_Item("report_result", 0)) . "</strong> | ";
	echo _AM_IFORUM_REPORT_PROCESSED . " <strong>" . $report_handler->getCount(new icms_db_criteria_Item("report_result", 1)) . "</strong>";
	echo "</div>";
	echo "</fieldset><br />";

	if (icms::$module->config['email_digest'] > 0)
	{
		$digest_handler =icms_getmodulehandler('digest', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
		echo "<fieldset style='border: #e8e8e8 1px solid;'>
			<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_DIGEST . "</legend>";
		$due = ($digest_handler->checkStatus()) / 60; // minutes
		$prompt = ($due > 0)? sprintf(_AM_IFORUM_DIGEST_PAST, $due):
		sprintf(_AM_IFORUM_DIGEST_NEXT, abs($due));
		echo "<div style='padding: 12px;'><a href='index.php?op=senddigest'>" . $prompt . "</a> | ";
		echo "<a href='admin_digest.php'>" . _AM_IFORUM_DIGEST_ARCHIVE . "</a> <strong>" . $digest_handler->getDigestCount() . "</strong>";
		echo "</div>";
		echo "</fieldset><br />";
	}

	echo "<br /><br />";

	/* A trick to clear garbage for suspension management
	* Not good but works
	*/
	if (!empty(icms::$module->config['enable_usermoderate']))
		{
		$moderate_handler = icms_getmodulehandler('moderate', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
		$moderate_handler->clearGarbage();
	}

	icms_cp_footer();
	break;
}

?>
