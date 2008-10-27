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
if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

require_once XOOPS_ROOT_PATH."/class/xoopseditor/xoopseditor.php";

/**
 * A select box with available editors
 * 
 * @package     kernel
 * @subpackage  form
 * 
 * @author	    phppp (D.J.)
 * @copyright	The XOOPS Project
 */
class XoopsFormSelectEditor extends XoopsFormElementTray
{	
	/**
	 * Constructor
	 * 
	 * @param	object	$form	the form calling the editor selection	
	 * @param	string	$name	editor name
	 * @param	string	$value	Pre-selected text value
     * @param	bool	$noHtml	dohtml disabled
	 */
	function XoopsFormSelectEditor(&$form, $name = "editor", $value = null, $noHtml = false)
	{
		$this->XoopsFormElementTray(_SELECT);

		$editor_handler =& new XoopsEditorHandler();
		$option_select = new XoopsFormSelect("", $name, $value);
		$extra = 'onchange="if(this.options[this.selectedIndex].value.length > 0 ){
			window.document.forms.'.$form->getName().'.submit();
			}"';
		$option_select->setExtra($extra);
		$option_select->addOptionArray($editor_handler->getList($noHtml));
		
		$this->addElement($option_select);
	}
}
?>