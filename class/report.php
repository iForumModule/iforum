<?php
// $Id: report.php,v 1.1.4.2 2005/01/09 00:44:36 phppp Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
class Report extends XoopsObject {
    function Report()
    {
        $this->db = &Database::getInstance();
        $this->table = $this->db->prefix("bb_report");
        $this->initVar('report_id', XOBJ_DTYPE_INT);
        $this->initVar('post_id', XOBJ_DTYPE_INT);
        $this->initVar('reporter_uid', XOBJ_DTYPE_INT);
        $this->initVar('reporter_ip', XOBJ_DTYPE_INT);
        $this->initVar('report_time', XOBJ_DTYPE_INT);
        $this->initVar('report_text', XOBJ_DTYPE_TXTAREA);
        $this->initVar('report_result', XOBJ_DTYPE_TXTAREA);
        $this->initVar('report_memo', XOBJ_DTYPE_TXTAREA);
    }

    function prepareVars()
    {
        foreach ($this->vars as $k => $v) {
            $cleanv = $this->cleanVars[$k];
            switch ($v['data_type']) {
                case XOBJ_DTYPE_TXTBOX:
                case XOBJ_DTYPE_TXTAREA:
                case XOBJ_DTYPE_SOURCE:
                case XOBJ_DTYPE_EMAIL:
                    $cleanv = ($v['changed'])?$cleanv:'';
                    if (!isset($v['not_gpc']) || !$v['not_gpc']) {
                        $cleanv = $this->db->quoteString($cleanv);
                    }
                    break;
                case XOBJ_DTYPE_INT:
                    $cleanv = ($v['changed'])?$cleanv:0;
                    break;
                case XOBJ_DTYPE_ARRAY:
                    $cleanv = ($v['changed'])?$cleanv:serialize(array());
                    break;
                case XOBJ_DTYPE_STIME:
                case XOBJ_DTYPE_MTIME:
                case XOBJ_DTYPE_LTIME:
                    $cleanv = ($v['changed'])?$cleanv:0;
                    break;

                default:
                    break;
            }
            $this->cleanVars[$k] = &$cleanv;
            unset($cleanv);
        }
        return true;
    }
}

class NewbbReportHandler extends XoopsObjectHandler {
    function &get($id)
    {
        if (!$id) return false;
        $sql = 'SELECT * FROM ' . $this->db->prefix('bb_report') . ' WHERE report_id=' . $id;
        $array = $this->db->fetchArray($this->db->query($sql));
        $report = &$this->create(false);
        $report->assignVars($array);
        return $report;
    }

    function &create($isNew = true)
    {
        $report = new Report();
        if ($isNew) {
            $report->setNew();
        }
        return $report;
    }

    function process($report_id, $report_memo)
    {
        $sql = "UPDATE " . $this->db->prefix("bb_report") . " SET report_result = 1, report_memo = " . $this->db->quoteString($report_memo) . " WHERE report_id = $report_id";
        if (!$result = $this->db->queryF($sql)) {
            //echo "<br />process report error:" . $sql;
            return false;
        }
        return true;
    }

    function &getByPost($posts)
    {
        if (!$posts) return false;
        if (!is_array($posts)) $posts = array($posts);
        $post_criteria = ' post_id IN (' . implode(',', $posts) . ')';

        $sql = "SELECT * FROM " . $db->prefix('bb_report') . "  WHERE " . $post_criteria;
        $result = $this->db->queryF($sql);
        while ($myrow = $this->db->fetchArray($result)) {
            $report = &$post_handler->create(false);
            $report->assignVars($myrow);
            $ret[$myrow['report_id']] = $report;
            unset($report);
        }
        return $ret;
    }

    function getReportCount($criteria, $forums = 0)
    {
        if (!$forums) {
            $forum_criteria = '';
        } else if (!is_array($forums)) {
            $forums = array($forums);
            $forum_criteria = ' r LEFT JOIN ' . $this->db->prefix("bb_posts") . ' p ON p.post_id= r.post_id WHERE p.forum_id IN (' . implode(',', $forums) . ')';
        }
        $tables_criteria = ' FROM ' . $this->db->prefix('bb_report');
        $operator = (empty($forum_criteria))? ' WHERE ':' AND ';
        $result_criteria = (isset($criteria))?$operator.' report_result = ' . intval($criteria):'';

        $sql = "SELECT COUNT(*) as report_count " . $tables_criteria . $forum_criteria . $result_criteria;

        $result = $this->db->query($sql);
        if ($result) $row = $this->db->fetchArray($result);
        return $row['report_count'];
    }

    function &getAllReports($forums = 0, $order = "ASC", $perpage = 0, &$start, $report_result = 0, $report_id = 0)
    {
        if ($order == "DESC") {
            $operator_for_position = '>' ;
        } else {
            $order = "ASC" ;
            $operator_for_position = '<' ;
        }
        $order_criteria = " ORDER BY r.report_id $order";

        if ($perpage <= 0) {
            $perpage = 10;
        }
        if (empty($start)) {
            $start = 0;
        }
        $result_criteria = ' AND r.report_result = ' . $report_result;

        if (!$forums) {
            $forum_criteria = '';
        } else if (!is_array($forums)) {
            $forums = array($forums);
            $forum_criteria = ' AND p.forum_id IN (' . implode(',', $forums) . ')';
        }
        $tables_criteria = ' FROM ' . $this->db->prefix('bb_report') . ' r, ' . $this->db->prefix('bb_posts') . ' p WHERE r.post_id= p.post_id';

        if ($report_id) {
            $result = $this->db->query("SELECT COUNT(*) as report_count" . $tables_criteria . $forum_criteria . $result_criteria . " AND report_id $operator_for_position $report_id" . $order_criteria);
            if ($result) $row = $this->db->fetchArray($result);
            $position = $row['report_count'];
            $start = intval($position / $perpage) * $perpage;
        }

        $sql = "SELECT r.*, p.subject, p.topic_id, p.forum_id" . $tables_criteria . $forum_criteria . $result_criteria . $order_criteria;
        $result = $this->db->query($sql, $perpage, $start);
        $ret = array();
        $report_handler = &xoops_getmodulehandler('report', 'newbb');
        while ($myrow = $this->db->fetchArray($result)) {
            $ret[] = $myrow; // return as array
        }
        return $ret;
    }

    function insert(&$report)
    {
        if (!$report->isDirty()) return true;
        if (!$report->cleanVars())return false;
        $report->prepareVars();
        foreach ($report->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        if ($report->isNew()) {
            $report_id = $this->db->genId($this->db->prefix("bb_report") . "_report_id_seq");

            $sql = "INSERT INTO " . $this->db->prefix("bb_report") . "
            			(  report_id,  post_id,  reporter_uid,  reporter_ip,  report_time,  report_text,  report_result,  report_memo )
					VALUES
            			( $report_id, $post_id, $reporter_uid, $reporter_ip, $report_time, $report_text, $report_result, $report_memo )";

            if (!$result = $this->db->queryF($sql)) {
                //echo "<br />Insert report error:" . $sql;
                return false;
            }
            if ($report_id == 0) $report_id = $this->db->getInsertId();

            $report->setVar('report_id', $report_id);
        } else {
            $sql = "UPDATE " . $this->db->prefix("bb_report") . " SET report_result = $report_result, report_memo = $report_memo WHERE report_id = " . $report->getVar('report_id');
            $result = $this->db->queryF($sql);
            if (!$result) {
                //echo "<br />Process report error:" . $sql;
                return false;
            }
        }
        return $report->getVar('report_id');
    }

    function delete($report)
    {
        if (is_object($report)) $report_id = $report->getVar('report_id');
        else $report_id = $report;
        $sql = "DELETE FROM " . $this->db->prefix("bb_report") . " WHERE report_id=" . $report_id . "";
        if (! $result = $this->db->queryF($sql)) {
            //echo "<br />Delete report error:" . $sql;
            return false;
        }
        return true;
    }
}

?>