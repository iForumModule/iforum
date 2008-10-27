<?php
/**
 * Editor framework for XOOPS
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		xoopseditor
 */
class XoopsFormEditor extends XoopsFormTextArea
{
	var $editor;
	
	/**
	 * Constructor
	 *
     * @param	string  $caption    Caption
     * @param	string  $name       "name" attribute
     * @param	string  $value		Initial text
     * @param	array 	$configs	configures
     * @param	bool  	$noHtml		use non-WYSIWYG eitor onfailure
     * @param	string  $OnFailure	editor to be used if current one failed
	 */
	function XoopsFormEditor($caption, $name, $editor_configs = null, $noHtml = false, $OnFailure = "")
	{
		require_once XOOPS_ROOT_PATH."/class/xoopseditor/xoopseditor.php";
		$this->XoopsFormTextArea($caption, $editor_configs["name"]);
		$editor_handler =& new XoopsEditorHandler();
		$this->editor =& $editor_handler->get($name, $editor_configs, $noHtml, $OnFailure);
	}
	
	function render()
	{
		return $this->editor->render();
	}
}
?>
