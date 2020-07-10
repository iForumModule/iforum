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

defined('ICMS_ROOT_PATH') or exit();

/**
 * A select box with available editors
 * 
 * @package     kernel
 * @subpackage  form
 * 
 * @author	    phppp (D.J.)
 * @copyright	The XOOPS Project
 */
class IforumFormSelectEditor extends icms_form_elements_Tray {	
	var $allowed_editors = array();
	var $form;
	var $value;
	var $name;
	var $nohtml;
	
	/**
	 * Constructor
	 * 
	 * @param	object	$form	the form calling the editor selection	
	 * @param	string	$name	editor name
	 * @param	string	$value	Pre-selected text value
     * @param	bool	$noHtml	dohtml disabled
	 */
	function __construct(&$form, $name = "editor", $value = null, $nohtml = false, $allowed_editors = array()) {
		parent::__construct(_SELECT);
		$this->allowed_editors = $allowed_editors;
		$this->form		=& $form;
		$this->name		= $name;
		$this->value	= $value;
		$this->nohtml	= $nohtml;
	}
	
	function render() {
		$editor_handler = icms_plugins_EditorHandler::getInstance();
		$editor_handler->allowed_editors = $this->allowed_editors;
		$option_select = new icms_form_elements_Select("", $this->name, $this->value);
		$extra = 'onchange="if(this.options[this.selectedIndex].value.length > 0 ){
			window.document.forms.'.$this->form->getName().'.submit();
			}"';
		$option_select->setExtra($extra);
		$option_select->addOptionArray($editor_handler->getList($this->nohtml));
		
		$this->addElement($option_select);
		
		return parent::render();
	}
}