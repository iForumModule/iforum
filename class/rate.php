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
 
defined("IFORUM_FUNCTIONS_INI") || include ICMS_ROOT_PATH.'/modules/'.basename(dirname(dirname(__FILE__ ) ) ).'/include/functions.ini.php';
iforum_load_object();
 
class Nrate extends ArtObject {
	function __construct()
	{
		parent::__construct("bb_votedata");
		$this->initVar('ratingid', XOBJ_DTYPE_INT);
		$this->initVar('topic_id', XOBJ_DTYPE_INT);
		$this->initVar('ratinguser', XOBJ_DTYPE_INT);
		$this->initVar('rating', XOBJ_DTYPE_INT);
		$this->initVar('ratingtimestamp', XOBJ_DTYPE_INT);
		$this->initVar('ratinghostname', XOBJ_DTYPE_TXTBOX);
	}
}
 
class IforumRateHandler extends ArtObjectHandler {
	function __construct(&$db)
	{
		parent::__construct($db, 'bb_votedata', 'Nrate', 'ratingid');
	}
	 
	/**
	* clean orphan items from database
	*
	* @return  bool true on success
	*/
	function cleanOrphan()
	{
		return parent::cleanOrphan($this->db->prefix("bb_topics"), "topic_id");
	}
}