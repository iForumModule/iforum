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
 
if (!defined('ICMS_ROOT_PATH'))
{
	exit();
}
/* some static icmsModuleConfig */
$customConfig = array();
 
// specification for custom time format
// default manner will be used if not specified
$customConfig["formatTimestamp_custom"] = ""; // Could be set as "Y-m-d H:i"
 
// requiring "name" field for anonymous users in edit form
$customConfig["require_name"] = true;
 
// display "register or login to post" for anonymous users
$customConfig["show_reg"] = true;
 
// perform forum/topic synchronization on module update
$customConfig["syncOnUpdate"] = true;
 
// time for pending/deleted topics/posts, expired one will be removed automatically, in days; 0 or no cleanup
$customConfig["pending_expire"] = 7;
 
// redirect to its URI of an attachment when requested
// Set to true if your attachment would be corrupted after download with normal way
$customConfig["download_direct"] = false;
 
// Set allowed editors
// Should set from module preferences?
$customConfig["editor_allowed"] = array();
 
// Set the default editor
$icmsConfig = icms::$config->getConfigsByCat(ICMS_CONF);
$customConfig["editor_default"] = $icmsConfig["editor_default"];
 
// storage method for reading records: 0 - none; 1 - cookie; 2 - db
$customConfig["read_mode"] = 2;
 
// expire time for reading records, in days
$customConfig["read_expire"] = 30;
 
// maximum records per forum for one user
$customConfig["read_items"] = 100;
 
// default value for editor rows, coloumns
$customConfig["editor_rows"] = 25;
$customConfig["editor_cols"] = 60;
 
// default value for editor width, height (string)
$customConfig["editor_width"] = "100%";
$customConfig["editor_height"] = "400px";
 
// Enable tag system
$customConfig["allow_tagging"] = 1;
 
return $customConfig;