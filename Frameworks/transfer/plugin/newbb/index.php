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
 * @since		3.00
 * @version		$Id$
 * @package		Frameworks::transfer
 */

//function transfer_newbb(&$data)
class transfer_newbb extends Transfer
{
	function transfer_newbb()
	{
		$this->Transfer("newbb");
	}
	
	function do_transfer(&$data)
	{
		eval(parent::do_transfer());
		
		if(!empty($data["entry"])){
			header("location: ".sprintf($this->config["url"], $data["entry"]));
			return;
		}
		
		$post_handler =& xoops_getmodulehandler("post", "newbb");
		$post_obj =& $post_handler->create();
		require_once(XOOPS_ROOT_PATH."/modules/newbb/include/functions.ini.php");
	    $post_obj->setVar("poster_ip", newbb_getIP());
	    $post_obj->setVar("uid", empty($GLOBALS["xoopsUser"])? 0 : $GLOBALS["xoopsUser"]->getVar("uid"));
	    $post_obj->setVar("forum_id", empty($data["forum_id"]) ? @$this->config["forum"] : $data["forum_id"]);
		$post_obj->setVar("subject", $data["title"]);
		$post_text = $data["content"]."<br />".
			"<a href=\"".$data["url"]."\">"._MORE."</a>";
		
		$post_obj->setVar("post_text",$post_text);
	    $post_obj->setVar("dohtml", 1);
	    $post_obj->setVar("dosmiley", 1);
	    $post_obj->setVar("doxcode", 1);
		$post_id = $post_handler->insert($post_obj);
		$topic_id = $post_obj->getVar("topic_id");
		unset($post_obj);
		
		return array("url" => sprintf($this->config["url"], $topic_id), "data" => array("topic_id" => $topic_id) ) ;
	}
}
?>