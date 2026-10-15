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

if (!defined("ICMS_ROOT_PATH"))
{
	exit();
}

defined("IFORUM_FUNCTIONS_INI") || include ICMS_ROOT_PATH.'/modules/'.basename(dirname(__DIR__) ).'/include/functions.ini.php';
class mod_iforum_Text extends icms_ipf_Object {
	public function __construct(&$handler)
	{
		parent::__construct($handler);
		$this->initVar('post_id', XOBJ_DTYPE_INT);
		$this->initVar('post_text', XOBJ_DTYPE_TXTAREA);
		$this->initVar('post_edit', XOBJ_DTYPE_TXTAREA);
	}
}

class mod_iforum_TextHandler extends icms_ipf_Handler {
	use mod_iforum_HandlerTrait;

	public function __construct(&$db)
	{
		parent::__construct($db, 'text', 'post_id', 'post_id', '', 'iforum');
		// the legacy schema is kept: the table is bb_posts_text, not iforum_text
		$this->table = $db->prefix('bb_posts_text');
	}

	/**
	* clean orphan items from database
	*
	* @return  bool true on success
	*/
    function cleanOrphan($table_link = "", $field_link = "", $field_object = "")
	{
		return $this->removeOrphans($this->db->prefix("bb_posts"), "post_id");
	}
}
