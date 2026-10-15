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

defined("IFORUM_FUNCTIONS_INI") || include ICMS_ROOT_PATH.'/modules/'.basename(dirname(__FILE__, 2)).'/include/functions.ini.php';
class mod_iforum_Rate extends icms_ipf_Object {
	public function __construct(&$handler)
	{
		parent::__construct($handler);
		$this->initVar('ratingid', XOBJ_DTYPE_INT);
		$this->initVar('topic_id', XOBJ_DTYPE_INT);
		$this->initVar('ratinguser', XOBJ_DTYPE_INT);
		$this->initVar('rating', XOBJ_DTYPE_INT);
		$this->initVar('ratingtimestamp', XOBJ_DTYPE_INT);
		$this->initVar('ratinghostname', XOBJ_DTYPE_TXTBOX);
	}
}

class mod_iforum_RateHandler extends icms_ipf_Handler {
	use mod_iforum_HandlerTrait;

	public function __construct(&$db)
	{
		parent::__construct($db, 'rate', 'ratingid', 'ratingid', '', 'iforum');
		// the legacy schema is kept: the table is bb_votedata, not iforum_rate
		$this->table = $db->prefix('bb_votedata');
	}

	/**
	* clean orphan items from database
	*
	* @return  bool true on success
	*/
    function cleanOrphan($table_link = "", $field_link = "", $field_object = "")
	{
		return $this->removeOrphans($this->db->prefix("bb_topics"), "topic_id");
	}
}
