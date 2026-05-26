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

class Report extends icms_ipf_Object {
	function __construct($handler = null)
	{
		$this->handler = $handler;
		$this->initVar('report_id', XOBJ_DTYPE_INT);
		$this->initVar('post_id', XOBJ_DTYPE_INT);
		$this->initVar('reporter_uid', XOBJ_DTYPE_INT);
		$this->initVar('reporter_ip', XOBJ_DTYPE_INT);
		$this->initVar('report_time', XOBJ_DTYPE_INT);
		$this->initVar('report_text', XOBJ_DTYPE_TXTBOX);
		$this->initVar('report_result', XOBJ_DTYPE_INT);
		$this->initVar('report_memo', XOBJ_DTYPE_TXTBOX);
	}
}

class IforumReportHandler extends icms_ipf_Handler {

	function __construct(&$db) {
    	parent::__construct($db, 'report', 'report_id', '', '', basename(dirname(__DIR__)));
		$this->table = $db->prefix('bb_report');
		$this->className = 'Report';
	}

	function &getByPost($posts)
	{
		$ret = array();
		if (!$posts)
		{
			return $ret;
		}
		if (!is_array($posts)) $posts = array($posts);
		$post_criteria = new icms_db_criteria_Item("post_id", "(" . implode(",", array_map("intval", $posts)) . ")", "IN");
		$ret = $this->getObjects($post_criteria);
		return $ret;
	}

	function &getAllReports( $start, $report_result = 0, $report_id = 0,$forums = 0, $order = "ASC", $perpage = 0)
	{
		$start = (int)$start;
		$report_result = (int)$report_result;
		$report_id = (int)$report_id;
		$forum_criteria = '';
		if ($order == "DESC")
		{
			$operator_for_position = '>' ;
		}
		else
		{
			$order = "ASC" ;
			$operator_for_position = '<' ;
		}
		$order_criteria = " ORDER BY r.report_id $order";

		if ($perpage <= 0)
		{
			$perpage = 10;
		}
		if (empty($start))
		{
			$start = 0;
		}
		$result_criteria = ' AND r.report_result = ' . $report_result;

		if (!$forums)
		{
			$forum_criteria = '';
		}
		else
		{
			$forums = is_array($forums) ? $forums : array($forums);
			$forum_criteria = ' AND p.forum_id IN (' . implode(',', array_map('intval', $forums)) . ')';
		}
		$tables_criteria = ' FROM ' . $this->db->prefix('bb_report') . ' r, ' . $this->db->prefix('bb_posts') . ' p WHERE r.post_id= p.post_id';

		if ($report_id)
		{
			$result = $this->db->query("SELECT COUNT(*) as report_count" . $tables_criteria . $forum_criteria . $result_criteria . " AND report_id $operator_for_position $report_id" . $order_criteria);
			$row = array('report_count' => 0);
			if ($result) $row = $this->db->fetchArray($result);
				$position = $row['report_count'];
			$start = intval($position / $perpage) * $perpage;
		}

		$sql = "SELECT r.*, p.subject, p.topic_id, p.forum_id" . $tables_criteria . $forum_criteria . $result_criteria . $order_criteria;
		$result = $this->db->query($sql, $perpage, $start);
		$ret = array();
		if (!$result)
		{
			return $ret;
		}
		//$report_handler =icms_getmodulehandler('report', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
		while ($myrow = $this->db->fetchArray($result))
		{
			$ret[] = $myrow; // return as array
		}
		return $ret;
	}

	function insert(&$report, $force = false, $checkObject = true, $debug = false)
	{
		if (!parent::insert($report, true))
		{
			return false;
		}

		return $report->getVar('report_id');
	}

	/**
	* clean orphan items from database
	*
	* @return  bool true on success
	*/
    function cleanOrphan($table_link = "", $field_link = "", $field_object = "")
	{
		$sql = 'DELETE FROM ' . $this->table
			. ' WHERE post_id NOT IN (SELECT post_id FROM ' . $this->db->prefix("bb_posts") . ')';

		return $this->db->queryF($sql);
	}
}
