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
class IforumFormEditor extends icms_form_elements_Textarea
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
	function __construct($caption, $name, $editor_configs = null, $nohtml = false, $OnFailure = "")
	{
		parent::__construct($caption, $editor_configs["name"]);
		require_once ICMS_ROOT_PATH."/class/xoopseditor.php";
		$editor_handler = XoopsEditorHandler::getInstance();
		$this->editor = $editor_handler->get($name, $editor_configs, $nohtml, $OnFailure);
	}
	
	function render()
	{
		return $this->editor->render();
	}
}
