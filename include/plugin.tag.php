<?php
/**
* Tag info
*
* @copyright The XOOPS project http://www.xoops.org/
* @license  http://www.fsf.org/copyleft/gpl.html GNU public license
* @author  Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
* @since  1.00
* @version  $Id$
* @package  module::iForum
*/
if (!defined('ICMS_ROOT_PATH'))
	{
	exit();
}
 
/**
* Get item fields:
* title
* content
* time
* link
* uid
* uname
* tags
*
* @var  array $items associative array of items: [modid][catid][itemid]
*
* @return boolean
*
*/
 
$MyDirName = basename(dirname(dirname(__FILE__ ) ) );
function iforum_tag_iteminfo(&$items)
{
	if (empty($items) || !is_array($items))
	{
		return false;
	}
	$MyDirName = basename(dirname(dirname(__FILE__ ) ) );
	 
	$items_id = array();
	foreach(array_keys($items) as $cat_id)
	{
		// Some handling here to build the link upon catid
		// catid is not used in iforum, so just skip it
		foreach(array_keys($items[$cat_id]) as $item_id)
		{
			// In iforum, the item_id is "topic_id"
			$items_id[] = intval($item_id);
		}
	}
	$item_handler = icms_getmodulehandler('topic', $MyDirName, 'iforum' );
	$items_obj = $item_handler->getObjects(new icms_db_criteria_Item("topic_id", "(".implode(", ", $items_id).")", "IN"), true);
	 
	foreach(array_keys($items) as $cat_id)
	{
		foreach(array_keys($items[$cat_id]) as $item_id)
		{
			$item_obj = & $items_obj[$item_id];
			$items[$cat_id][$item_id] = array(
			"title" => $item_obj->getVar("topic_title"),
				"uid" => $item_obj->getVar("topic_poster"),
				"link" => "viewtopic.php?topic_id={$item_id}",
				"time" => $item_obj->getVar("topic_time"),
				"tags" => tag_parse_tag($item_obj->getVar("topic_tags", "n")),
				"content" => "",
				);
		}
	}
	unset($items_obj);
}
 
/**
* Remove orphan tag-item links
*
* @return boolean
*
*/
function iforum_tag_synchronization($mid)
{
	$MyDirName = basename(dirname(dirname(__FILE__ ) ) );
	$item_handler = icms_getmodulehandler('topic', $MyDirName, 'iforum' );
	$link_handler = xoops_getmodulehandler("link", "tag");
	 
	/* clear tag-item links */
	if ($link_handler->mysql_major_version() >= 4):
	$sql = " DELETE FROM {$link_handler->table}". " WHERE ". "  tag_modid = {$mid}". "  AND ". "  ( tag_itemid NOT IN ". "   ( SELECT DISTINCT {$item_handler->keyName} ". "    FROM {$item_handler->table} ". "    WHERE {$item_handler->table}.approved > 0". "   ) ". "  )";
	else:
		$sql = " DELETE {$link_handler->table} FROM {$link_handler->table}". " LEFT JOIN {$item_handler->table} AS aa ON {$link_handler->table}.tag_itemid = aa.{$item_handler->keyName} ". " WHERE ". "  tag_modid = {$mid}". "  AND ". "  ( aa.{$item_handler->keyName} IS NULL". "   OR aa.approved < 1". "  )";
	endif;
	if (!$result = $link_handler->db->queryF($sql))
	{
		//icms_core_Message::error($link_handler->db->error());
	}
}
// These will try to create functions for tag plugin, if the filder has been reneamed to something else
if (!function_exists($MyDirName.'_tag_iteminfo'))
	{
	$myfunc = 'function '.$MyDirName.'_tag_iteminfo (&$items) { return iforum_tag_iteminfo($items);}';
	eval($myfunc);
}
if (!function_exists($MyDirName.'_tag_synchronization'))
	{
	$myfunc = 'function '.$MyDirName.'_tag_synchronization ($mid) { return iforum_tag_synchronization($mid);}';
	eval($myfunc);
}