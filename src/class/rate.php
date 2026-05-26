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

if (!defined("ICMS_ROOT_PATH")) {
	exit();
}

class Nrate extends icms_ipf_Object {
	function __construct($handler = null)
	{
		$this->handler = $handler;
		$this->initVar('ratingid', XOBJ_DTYPE_INT);
		$this->initVar('topic_id', XOBJ_DTYPE_INT);
		$this->initVar('ratinguser', XOBJ_DTYPE_INT);
		$this->initVar('rating', XOBJ_DTYPE_INT);
		$this->initVar('ratingtimestamp', XOBJ_DTYPE_INT);
		$this->initVar('ratinghostname', XOBJ_DTYPE_TXTBOX);
	}
}

class IforumRateHandler extends icms_ipf_Handler {
	function __construct(&$db)
	{
		parent::__construct($db, 'rate', 'ratingid', '', '', basename(dirname(__FILE__, 2)));
		$this->table = $db->prefix('bb_votedata');
		$this->className = 'Nrate';
	}

	function insert(&$rate, $force = false, $checkObject = true, $debug = false)
	{
		if (!parent::insert($rate, true))
		{
			return false;
		}

		return $rate->getVar('ratingid');
	}

	function getAllRates($start = 0, $limit = 20)
	{
		$sql = 'SELECT v.ratingid, v.topic_id, v.ratinguser, v.rating, v.ratinghostname, v.ratingtimestamp,'
			. ' t.topic_title FROM ' . $this->table . ' v'
			. ' LEFT JOIN ' . $this->db->prefix('bb_topics') . ' t ON t.topic_id = v.topic_id'
			. ' ORDER BY v.ratingtimestamp DESC';

		$result = $this->db->query($sql, (int)$limit, (int)$start);
		if (!$result)
		{
			return array();
		}

		$rates = array();
		while ($row = $this->db->fetchArray($result))
		{
			$rates[] = $row;
		}

		return $rates;
	}

	function getAverageRating()
	{
		$sql = 'SELECT COUNT(*) AS vote_count, AVG(rating) AS average_rating FROM ' . $this->table;
		$result = $this->db->query($sql);
		if (!$result)
		{
			return array('vote_count' => 0, 'average_rating' => 0);
		}

		$row = $this->db->fetchArray($result);
		$voteCount = isset($row['vote_count']) ? (int)$row['vote_count'] : 0;
		$averageRating = ($voteCount > 0 && isset($row['average_rating'])) ? number_format((float)$row['average_rating'], 2) : '0';

		return array('vote_count' => $voteCount, 'average_rating' => $averageRating);
	}

	function deleteRating($ratingId)
	{
		$ratingId = (int)$ratingId;
		if ($ratingId < 1)
		{
			return false;
		}

		$rate = $this->get($ratingId);
		if (!$rate || $rate->isNew())
		{
			return false;
		}

		$topicId = (int)$rate->getVar('topic_id');
		if (!parent::delete($rate, true))
		{
			return false;
		}

		iforum_updaterating($topicId);

		return true;
	}

	/**
	* clean orphan items from database
	*
	* @return  bool true on success
	*/
    function cleanOrphan($table_link = "", $field_link = "", $field_object = "")
	{
		$sql = 'DELETE FROM ' . $this->table
			. ' WHERE topic_id NOT IN (SELECT topic_id FROM ' . $this->db->prefix("bb_topics") . ')';

		return $this->db->queryF($sql);
	}
}
