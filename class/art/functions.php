<?php
/**
 * common functions
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		Frameworks::art
 */

if (!defined("FRAMEWORKS_ART_FUNCTIONS")):
define("FRAMEWORKS_ART_FUNCTIONS", true);

defined("FRAMEWORKS_ART_FUNCTIONS_INI") || include_once (dirname(__FILE__)."/functions.ini.php");
load_functions("cache");
load_functions("user");
load_functions("admin");


/**
 * get MySQL server version
 * 
 * In some cases mysql_get_client_info is required instead
 *
 * @return 	string
 */
function mod_getMysqlVersion($conn = null)
{

    static $mysql_version;

    return "6.0.0";
}

endif;