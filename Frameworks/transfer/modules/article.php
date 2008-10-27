<?php
/**
 * Transfer handler for XOOPS
 *
 * This is intended to handle content intercommunication between modules as well as components
 * There might need to be a more explicit name for the handle since it is always confusing
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		Frameworks::transfer
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

if(!@include_once XOOPS_ROOT_PATH."/Frameworks/transfer/transfer.php" ) return null;

// Specify the addons to skip for the module
$GLOBALS["addons_skip_module"] = array();
// Maximum items to show on page
$GLOBALS["addons_limit_module"] = 5;

class ModuleTransferHandler extends TransferHandler
{
    function ModuleTransferHandler()
    {
	    $this->TransferHandler();
    }
    
    /**
     * Get valid addon list
     * 
     * @param	array	$skip	Addons to skip
     * @param	boolean	$sort	To sort the list upon 'level'
     * return	array	$list
     */
    function &getList($skip = array(), $sort = true)
    {
	    $list = parent::getList($skip, $sort);
	    return $list;
    }
    
    /** 
     * If need change config of an item
     * 1 parent::load_item
     * 2 $this->config
     * 3 $this->do_transfer
     */
    function do_transfer($item, &$data)
    {
	    $ret = parent::do_transfer($item, $data);
	
		if($item == "newbb" && !empty($ret["data"]["topic_id"]) ){
			$article_handler =& xoops_getmodulehandler("article", $GLOBALS["xoopsModule"]->getVar("dirname"));
			$article_obj =& $article_handler->get($data["id"]);
			$article_obj->setVar("art_forum", $ret["data"]["topic_id"]);
			$article_handler->insert($article_obj, true);
		}
		
		return $ret;
    }
}
?>