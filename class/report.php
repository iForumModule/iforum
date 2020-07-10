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
iforum_load_object();
 
class Report extends ArtObject {
	function __construct()
	{
		parent::__construct("bb_report");
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
 
class IforumReportHandler extends ArtObjectHandler {
	function __construct(&$db)
	{

    parent::__construct($db, 'bb_report', 'Report', 'report_id');

	}
	function &getByPost($posts)
	{
		$ret = array();
		if (!$posts)
		{
			return $ret;
		}
		if (!is_array($posts)) $posts = array($posts);
			$post_criteria = new icms_db_criteria_Item("post_id", "(" . implode(", ", $posts) . ")", "IN");
		$ret = $this->getAll($post_criteria);
		return $ret;
	}
	 
	function &getAllReports($forums = 0, $order = "ASC", $perpage = 0, &$start, $report_result = 0, $report_id = 0)
	{
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
		else if (!is_array($forums))
		{
			$forums = array($forums);
			$forum_criteria = ' AND p.forum_id IN (' . implode(',', $forums) . ')';
		}
		$tables_criteria = ' FROM ' . $this->db->prefix('bb_report') . ' r, ' . $this->db->prefix('bb_posts') . ' p WHERE r.post_id= p.post_id';
		 
		if ($report_id)
		{
			$result = $this->db->query("SELECT COUNT(*) as report_count" . $tables_criteria . $forum_criteria . $result_criteria . " AND report_id $operator_for_position $report_id" . $order_criteria);
			if ($result) $row = $this->db->fetchArray($result);
				$position = $row['report_count'];
			$start = intval($position / $perpage) * $perpage;
		}
		 
		$sql = "SELECT r.*, p.subject, p.topic_id, p.forum_id" . $tables_criteria . $forum_criteria . $result_criteria . $order_criteria;
		$result = $this->db->query($sql, $perpage, $start);
		$ret = array();
		//$report_handler =icms_getmodulehandler('report', basename(  dirname(  dirname( __FILE__ ) ) ), 'iforum' );
		while ($myrow = $this->db->fetchArray($result))
		{
			$ret[] = $myrow; // return as array
		}
		return $ret;
	}
	 
	/**
	* clean orphan items from database
	*
	* @return  bool true on success
	*/
	function cleanOrphan()
	{
		return parent::cleanOrphan($this->db->prefix("bb_posts"), "post_id");
	}
}