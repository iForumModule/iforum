<?php 
// $Id: formwysiwygtextarea.php,v 1.1.2.6 2005/08/14 22:08:10 phppp Exp $
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                      				//
// Copyright (c) 2000 XOOPS.org                           					//
// <http://www.xoops.org/>                             						//
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
/**
* A textarea with wysiwyg buttons
* 
* @author Samuels 
* @copyright copyright (c) 2000-2003 XOOPS.org
* @package kernel
* @subpackage form
*/

include_once(dirname(__FILE__) . '/preferences.php');


class XoopsFormWysiwygTextArea extends XoopsFormElement {
    var $options;
    var $value;
    var $width = "100%";
    var $height = "400px";
    var $url;
    var $skin;
    var $fonts;
    var $direction;

	/**
	 * Constructor
	 *
     * @param	array   $configs  Editor Options
     * @param	binary 	$checkCompatible  true - return false on failure
	 */
	function XoopsFormWysiwygTextArea($configs, $checkCompatible = false)
	{
	    if(!empty($configs)) {
	        foreach($configs as $key => $val) {
	            if (method_exists($this, 'set'.Ucfirst($key))) {
	                $this->{'set'.Ucfirst($key)}($val);
	            }else{
	                $this->$key = $val;
	            }
	        }
	    }
		if($checkCompatible && !$this->isCompatible()) {
			return false;
		}
	}

	function setConfig($configs)
	{
	    foreach($configs as $key=>$val){
			$this->$key = $val;
	    }
	}
    function getDirection()
    {
	    if(empty($this->direction)){
	    	$this->direction = _XK_P_TDIRECTION;
    	}
        return $this->direction;
    }
    function setDirection($direction)
    {
        $this->direction = $direction;
    } 
    function getSkin()
    {
	    if(empty($this->skin)){
	    	$this->skin = _XK_P_SKIN;
    	}
        return $this->skin;
    } 
    function setSkin($skin)
    {
        $this->skin = $skin;
    } 
    function getUrl()
    {
	    if(empty($this->url)){
	    	$this->url = _XK_P_PATH;
    	}  
        return $this->url;
    } 
    function setUrl($value)
    {
        $this->url = $value;
    } 
    function getValue()
    {
        return $this->value;
    } 
    function setValue($value)
    {
        $this->value = $value;
    } 
    function setWidth($width)
    {
	    if(!empty($width)){
        	$this->width = $width;
    	}
    } 
    function getWidth()
    {
        return $this->width;
    } 
    function setHeight($height)
    {
	    if(!empty($height)){
        	$this->height = $height;
    	}
    } 
    function getHeight()
    {
        return $this->height;
    } 
    function getFonts()
    {
	    if(empty($this->fonts) || count($this->fonts)==0){
        	$this->fonts = array('Courier New' => 'Courier New, Courier, monospace', 'MS Serif' => 'MS Serif, New York, serif', 'Verdana' => 'Verdana, Geneva, Arial, Helvetica, sans-serif');
	    }	    
        return $this->fonts;
    } 
    
    function setFonts($fonts)
    {
        if(is_array($fonts)){
			$myts =& MyTextSanitizer::getInstance();
	        foreach($fonts as $key => $val){
		        $key =& $myts->htmlSpecialChars($key);
		        $val =& $myts->htmlSpecialChars($val);
	        	$this->fonts[$key] = $val;
        	}
        }
    } 
    
 	function getOptions()
    {
	    if(empty($this->options) || count($this->options)==0){
		    $this->options = explode(",", _XK_P_FULLTOOLBAR);
	    }
        return $this->options;
    } 
    
    function setOptions($options)
    {
        if ($options == 'small'){
	        $this->options = explode(",", _XK_P_SMALLTOOLBAR);
        }elseif(is_array($options)){
	        $this->options = $options;
        }
    } 

    function getThemeCSS()
    {
        global $xoopsConfig;
        if (getcss($xoopsConfig['theme_set']))return getcss($xoopsConfig['theme_set']);
        else return '';
    } 

    function setThemeCSS($themeCss)
    {
        $this->themeCss = $themeCss;
    } 

    /**
    * Prepare HTML for output
    * 
    * @return string HTML
    */
    function render()
    { 
        // include files
        include_once XOOPS_ROOT_PATH . '' . $this->getUrl() . '/include/functions.inc.php';
        static $koivi_js_loaded = false;
        static $koivi_tabletools_loaded = false;

		if(isset($GLOBALS["KOIVI_FONTLIST"])){
			$this->setFonts($GLOBALS["KOIVI_FONTLIST"]);
		}
        $url = XOOPS_URL . '' . $this->getUrl();
        $skinUrl = $url . '/skins/' . $this->getSkin();
        $isie = checkBrowser();
        $toggleMode = false;
        $themeCss = false;
        $colorPalette = false;
        $extraDivs = ''; 

        if (!$koivi_js_loaded) {
            $form = '<script language="JavaScript" type="text/javascript" src="' . $url . '/include/js/cntextmenu.js"></script>';
            $form .= '<script language="JavaScript" type="text/javascript" src="' . $url . '/include/js/editor.js"></script>';
            $form .= '<script language="JavaScript" type="text/javascript" src="' . $url . '/include/js/xhtml.js"></script>';
            $koivi_js_loaded = true;
        } else {
            $form = '';
        } 
        if (in_array('createtable', $this->getOptions()) && $koivi_tabletools_loaded == false) {
            $form .= '<script language="JavaScript" type="text/javascript" src="' . $url . '/include/js/table_tools.js"></script>';
            $koivi_tabletools_loaded = true;
        } 

        $form .= '<link href="' . $skinUrl . '/' . $this->getSkin() . '.css" rel="Stylesheet" type="text/css" />
				<div id="alleditor' . $this->getName() . '" style="width:' . $this->getWidth() . ';border:1px solid silver;">
					<div id="toolbar' . $this->getName() . '" class="' . $this->getSkin() . 'toolbarBackCell">';

        if (in_array('floating', $this->getOptions())) {
            $form .= '	<div class="' . $this->getSkin() . 'editorStatus">
							<img alt=""  src="' . $skinUrl . '/minimize.gif" onclick="XK_hideToolbar(\'' . $this->getName() . '\',\'' . $skinUrl . '\')" />
							<img id="floatButton' . $this->getName() . '" alt="' . _XK_FLOAT . '" title="' . _XK_FLOAT . '" src="' . $skinUrl . '/floating.gif" onclick="XK_floatingToolbar(\'' . $this->getName() . '\',\'' . $this->getSkin() . '\')"/>
							<img id="maximizeButton' . $this->getName() . '" alt="' . _XK_FLOAT . '" title="' . _XK_FLOAT . '" src="' . $skinUrl . '/fullscreen.gif" onclick="XK_maximizeEditor(\'' . $this->getName() . '\')"/>
						</div>';
        } 

        $form .= '<div id="buttons' . $this->getName() . '" class="' . $this->getSkin() . 'toolBar">';

        foreach ($this->getOptions() as $tool) {
            switch (strtolower($tool)) {
                case "bold":
                    $form .= '<img alt="' . _XK_BOLD . '" title="' . _XK_BOLD . '" src="' . $skinUrl . '/bold.gif" onmousedown="XK_doTextFormat(\'bold\',\'\',\'' . $this->getName() . '\')" />';
                    break;

                case "cellalign":
                    $form .= '<img alt="' . _XK_CELLALIGN . '" title="' . _XK_CELLALIGN . '" src="' . $skinUrl . '/cellalign.gif"/>';
                    $form .= '<img alt="' . _XK_CELLALIGN . '" title="' . _XK_CELLALIGN . '" id="cellpropbutton' . $this->getName() . '" src="' . $skinUrl . '/popup.gif" onclick="XK_useTableDivs(\'' . $this->getName() . '\',\'align\')"/>';
                    $extraDivs .= $this->_renderCellAlign();
                    break;

                case "cellborders":
                    $form .= '<img alt="' . _XK_CELLPROPS . '" title="' . _XK_CELLPROPS . '" src="' . $skinUrl . '/cellborders.gif" onmousedown="XK_TTools(\'' . $this->getName() . '\',\'' . $url . '/dialogs.php?id=' . $this->getName() . '&amp;dialog=cellProps&amp;skin=' . $this->getSkin() . '&amp;url=' . $this->getUrl() . '\',\'table\',400,260)"/>';
                    $form .= '<img alt="' . _XK_CELLALIGN . '" title="' . _XK_CELLALIGN . '" id="cbbutton' . $this->getName() . '" src="' . $skinUrl . '/popup.gif" onclick="XK_useTableDivs(\'' . $this->getName() . '\',\'borders\')"/>';
                    $extraDivs .= $this->_renderCellBorders();
                    break;

                case "cellcolor":
                    $form .= '<img alt="' . _XK_FORECOLOR . '" id="cellcolor' . $this->getName() . '" title="' . _XK_FORECOLOR . '" src="' . $skinUrl . '/cellcolor.gif" onclick="XK_color(\'' . $this->getName() . '\',\'cellcolor\',\'cellcolor\')"/>';
                    $colorPalette = true;
                    break;

                case "code":
                    $form .= '<img alt="' . _XK_CODE . '" title="' . _XK_CODE . '" src="' . $skinUrl . '/code.gif" onmousedown="XK_doTextFormat(\'Code\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "copy":
                    $form .= '<img alt="' . _XK_COPY . '" title="' . _XK_COPY . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'copy\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "createlink":
                    $form .= '<img alt="' . _XK_CREATELINK . '" title="' . _XK_CREATELINK . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'createlink\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "createtable":
                    $form .= '<img alt="' . _XK_INSERTTABLE . '" title="' . _XK_INSERTTABLE . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_openPopup(\'' . $url . '/dialogs.php?id=' . $this->getName() . '&amp;dialog=table&amp;url=' . $this->getUrl() . '\',\'table\',400,290)"/>';
                    $form .= '<img alt="' . _XK_CREATEQUICKTABLE . '" id="tablebutton' . $this->getName() . '" title="' . _XK_CREATEQUICKTABLE . '" src="' . $skinUrl . '/popup.gif" onclick="XK_showHideDiv(\'' . $this->getName() . '\',\'tablebutton\',\'tablepicker\')"/>';
                    $extraDivs .= $this->_renderQuickTable();
                    break;

                case "cut":
                    $form .= '<img alt="' . _XK_CUT . '" title="' . _XK_CUT . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'cut\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "fontname":
                    $form .= '<select id="fontname' . $this->getName() . '" class="' . $this->getSkin() . 'selectInput" onchange="XK_doTextFormat(\'fontname\',this.options[this.selectedIndex].value,\'' . $this->getName() . '\')"><option value="">' . _XK_FONT . '</option>';
                    foreach ($this->getFonts() as $fontname => $font) {
                        $form .= '<option value="' . $font . '">' . $fontname . '</option>';
                    } 
                    $form .= '</select>';

                    break;

                case "fontsize":
                    $form .= '
					<select id="fontsize' . $this->getName() . '" class="' . $this->getSkin() . 'selectInput" onchange="XK_doTextFormat(\'fontsize\',this.options[this.selectedIndex].value,\'' . $this->getName() . '\')"">
						<option value="">' . _XK_FONT_SIZE . '</option>
						<option value="-2">' . _XK_FONT_XSMALL . '</option>
						<option value="-1">' . _XK_FONT_SMALL . '</option>
						<option value="+0">' . _XK_FONT_MEDIUM . '</option>
						<option value="+1">' . _XK_FONT_LARGE . '</option>
						<option value="+2">' . _XK_FONT_XLARGE . '</option>
						<option value="+4">' . _XK_FONT_XXLARGE . '</option>
         			 </select>';
                    break;

                case "forecolor":
                    $form .= '<img  alt="' . _XK_FORECOLOR . '" id="forecolor' . $this->getName() . '" title="' . _XK_FORECOLOR . '" src="' . $skinUrl . '/forecolor.gif" onclick="XK_color(\'' . $this->getName() . '\',\'forecolor\',\'forecolor\')"/>';
                    $colorPalette = true;
                    break;

                case "formatblock":
                    $form .= '	 
          			<select id="formatblock' . $this->getName() . '" class="' . $this->getSkin() . 'selectInput" onchange="XK_doTextFormat(\'formatblock\',this.options[this.selectedIndex].value,\'' . $this->getName() . '\')">
           				<option value="">' . _XK_FONT_FORMAT . '</option>
						<option value="&lt;p&gt;">' . _XK_FONT_NONE . '</option>
           				<option value="&lt;h1&gt;">' . _XK_FONT_HEADING1 . '</option>
           				<option value="&lt;h2&gt;">' . _XK_FONT_HEADING2 . '</option>
           				<option value="&lt;h3&gt;">' . _XK_FONT_HEADING3 . '</option>
						<option value="&lt;h4&gt;">' . _XK_FONT_HEADING4 . '</option>
						<option value="&lt;h5&gt;">' . _XK_FONT_HEADING5 . '</option>
						<option value="&lt;h6&gt;">' . _XK_FONT_HEADING6 . '</option>
						<option value="&lt;p&gt;">' . _XK_FONT_PARAGRAPH . '</option>
						<option value="&lt;pre&gt;">' . _XK_FONT_FORMATTED . '</option>
						<option value="&lt;address&gt;">' . _XK_FONT_ADDRESS . '</option>
					</select>';

                    break;

                case "hilitecolor":
                    $form .= '<img  alt="' . _XK_HILITECOLOR . '" id="hilitecolor' . $this->getName() . '" title="' . _XK_HILITECOLOR . '" src="' . $skinUrl . '/hilitecolor.gif" onclick="XK_color(\'' . $this->getName() . '\',\'hilitecolor\',\'hilitecolor\')"/>';
                    $colorPalette = true;
                    break;

                case "imagemanager":
                    $form .= '<img alt="' . _XK_INSERTIMAGEM . '" title="' . _XK_INSERTIMAGEM . '" onmouseover="style.cursor=\'hand\'" onmousedown="javascript:openWithSelfMain(\'' . XOOPS_URL . '/imagemanager.php?target=' . $this->getName() . '&amp;wysiwyg=1\',\'imgmanager\',400,430);" src="' . $skinUrl . '/imagemanager.gif"/>';
                    break;

                case "imageproperties":
                    $form .= '<img alt="' . _XK_EDITIMAGE . '" title="' . _XK_EDITIMAGE . '" src="' . $skinUrl . '/imageprops.gif" onmousedown="XK_openPopup(\'' . $url . '/dialogs.php?id=' . $this->getName() . '&amp;dialog=imageProps&amp;url=' . $this->getUrl() . '&amp;skin=' . $this->getSkin() . '\',\'table\',400,260)"/>';
                    break;

                case "indent":
                    $form .= '<img alt="' . _XK_INDENT . '" title="' . _XK_INDENT . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'indent\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "inserthorizontalrule":
                    $form .= '<img alt="' . _XK_INSERTHORIZONTALRULE . '" title="' . _XK_INSERTHORIZONTALRULE . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'inserthorizontalrule\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case 'insertanchor':
                    $form .= '<img alt="' . _XK_INSERTANCHOR . '" title="' . _XK_INSERTANCHOR . '" src="' . $skinUrl . '/insertanchor.gif" onmousedown="XK_insertAnchor(\'' . $this->getName() . '\')"/>';
                    break;

                case "insertdate":
                    $form .= '<img alt="' . _XK_INSERTDATE . '" title="' . _XK_INSERTDATE . '"  src="' . $skinUrl . '/insertdate.gif" onmousedown="XK_insertDate(\'' . $this->getName() . '\')"/>';
                    break;

                case "insertimage":
                    $form .= '<img alt="' . _XK_INSERTIMAGE . '" title="' . _XK_INSERTIMAGE . '" src="' . $skinUrl . '/insertimage.gif" onmousedown="XK_doTextFormat(\'insertimage\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "insertorderedlist":
                    $form .= '<img alt="' . _XK_INSERTORDEREDLIST . '" title="' . _XK_INSERTORDEREDLIST . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'insertorderedlist\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "insertunorderedlist":
                    $form .= '<img alt="' . _XK_INSERTUNORDEREDLIST . '" title="' . _XK_INSERTUNORDEREDLIST . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'insertunorderedlist\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "insertsymbols":
                    $form .= $this->_renderInsertSymbols();
                    break;

                case "italic":
                    $form .= '<img alt="' . _XK_ITALIC . '" title="' . _XK_ITALIC . '" src="' . $skinUrl . '/italic.gif" onmousedown="XK_doTextFormat(\'italic\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "justifycenter":
                    $form .= '<img alt="' . _XK_JUSTIFYCENTER . '" title="' . _XK_JUSTIFYCENTER . '" src="' . $skinUrl . '/justifycenter.gif" onmousedown="XK_doTextFormat(\'justifycenter\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "justifyfull":
                    $form .= '<img alt="' . _XK_JUSTIFYFULL . '" title="' . _XK_JUSTIFYFULL . '" src="' . $skinUrl . '/justifyfull.gif" onmousedown="XK_doTextFormat(\'justifyfull\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "justifyleft":
                    $form .= '<img alt="' . _XK_JUSTIFYLEFT . '" title="' . _XK_JUSTIFYLEFT . '" src="' . $skinUrl . '/justifyleft.gif" onmousedown="XK_doTextFormat(\'justifyleft\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "justifyright":
                    $form .= '<img alt="' . _XK_JUSTIFYRIGHT . '" title="' . _XK_JUSTIFYRIGHT . '" src="' . $skinUrl . '/justifyright.gif" onmousedown="XK_doTextFormat(\'justifyright\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "ltr":
                    $form .= '<img alt="' . _XK_LEFTTORIGHT . '" title="' . _XK_LEFTTORIGHT . '" src="' . $skinUrl . '/ltr.gif" onmousedown="XK_textDirection(\'ltr\',\'' . $this->getName() . '\')"/>';
                    break;

                case "newline":
                    $form .= '<br />';
                    break;

                case 'newparagraph':
                    if ($isie)$form .= '<input class="' . $this->getSkin() . 'checkbox" type="checkbox" alt="' . _XK_NEWPARAGRAPH . '" title="' . _XK_NEWPARAGRAPH . '" id="ptagenabled' . $this->getName() . '" onclick="XK_destroyPTag(\'' . $this->getName() . '\')">';
                    break;

                case "outdent":
                    $form .= '<img alt="' . _XK_OUTDENT . '" title="' . _XK_OUTDENT . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'outdent\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "paste":
                    $form .= '<img alt="' . _XK_PASTE . '" title="' . _XK_PASTE . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'paste\',null,\'' . $this->getName() . '\')"/>';
                    break;

                case "pastespecial":
                    $form .= '<img alt="' . _XK_PASTESPECIAL . '" title="' . _XK_PASTESPECIAL . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="document.getElementById(\'iframe' . $this->getName() . '\').contentWindow.focus();openWithSelfMain(\'' . $url . '/dialogs.php?id=' . $this->getName() . '&amp;skin=' . $this->getSkin() . '&amp;dialog=pastespecial&amp;url=' . $this->getUrl() . '\',\'pastespecial\',350,280);"/>';
                    break;

                case 'print':
                    $form .= '<img alt="' . _XK_PRINT . '" title="' . _XK_PRINT . '" src="' . $skinUrl . '/print.gif" onmousedown="XK_print(\'' . $this->getName() . '\')"/>';
                    break;

                case "quote":
                    $form .= '<img alt="' . _XK_QUOTE . '" title="' . _XK_QUOTE . '" src="' . $skinUrl . '/quote.gif" onmousedown="XK_doTextFormat(\'Quote\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "redo":
                    $form .= '<img alt="' . _XK_REDO . '" title="' . _XK_REDO . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'redo\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "rtl":
                    $form .= '<img alt="' . _XK_RIGHTTOLEFT . '" title="' . _XK_RIGHTTOLEFT . '" src="' . $skinUrl . '/rtl.gif" onmousedown="XK_textDirection(\'rtl\',\'' . $this->getName() . '\')"/>';
                    break;

                case "separator":
                    $form .= '<img alt="|" src="' . $skinUrl . '/separator.gif"/>';
                    break;

                case 'spellcheck':
                    $form .= '<img alt="' . _XK_SPELLCHECK . '" title="' . _XK_SPELLCHECK . '" src="' . $skinUrl . '/spellcheck.gif" onmousedown="XK_checkspell()"/>';
                    break;

                case "strikethrough":
                    $form .= '<img alt="' . _XK_STRIKETHROUGH . '" title="' . _XK_STRIKETHROUGH . '" src="' . $skinUrl . '/strikethrough.gif" onmousedown="XK_doTextFormat(\'strikethrough\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "subscript":
                    $form .= '<img alt="' . _XK_SUBSCRIPT . '" title="' . _XK_SUBSCRIPT . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'subscript\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "superscript":
                    $form .= '<img alt="' . _XK_SUPERSCRIPT . '" title="' . _XK_SUPERSCRIPT . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'superscript\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "removeformat":
                    $form .= '<img alt="' . _XK_REMOVEFORMAT . '" title="' . _XK_REMOVEFORMAT . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'removeformat\',\'\',\'' . $this->getName() . '\')"/>';
                    $form .= '<img alt="' . _XK_REMOVE_DESC . '" title="' . _XK_REMOVE_DESC . '" id="rformatbutton' . $this->getName() . '" src="' . $skinUrl . '/popup.gif" onclick="XK_showHideDiv(\'' . $this->getName() . '\',\'rformatbutton\',\'RemoveFormat\')"/>';
                    $extraDivs .= $this->_renderCleanFormats();
                    break;

                case "themecss":
                    $themeCss = true;
                    break;

                case "tableprops":
                    $form .= '<img alt="' . _XK_TABLEPROPS . '" title="' . _XK_TABLEPROPS . '" src="' . $skinUrl . '/tableprops.gif" onmousedown="XK_TTools(\'' . $this->getName() . '\',\'' . $url . '/dialogs.php?id=' . $this->getName() . '&amp;dialog=tableProps&amp;skin=' . $this->getSkin() . '&amp;url=' . $this->getUrl() . '\',\'table\',400,260)"/>';
                    $form .= '<img alt="' . _XK_TABLETOOLS . '" title="' . _XK_TABLETOOLS . '" id="tpropbutton' . $this->getName() . '" src="' . $skinUrl . '/popup.gif" onclick="XK_useTableOps(\'TableOps\',\'' . $this->getName() . '\')"/>';
                    $extraDivs .= $this->_renderTableProps();
                    break;

                case "toggleborders":
                    $form .= '<img alt="' . _XK_TABLEBORDERS_TOGGLE . '" title="' . _XK_TABLEBORDERS_TOGGLE . '" src="' . $skinUrl . '/toggletableborders.gif" onmousedown="XK_toggleBorders(\'' . $this->getName() . '\',\'document.body\')"/>';
                    break;

                case "togglemode":
                    $toggleMode = true;
                    break;

                case "underline":
                    $form .= '<img alt="' . _XK_UNDERLINE . '" title="' . _XK_UNDERLINE . '" src="' . $skinUrl . '/underline.gif" onmousedown="XK_doTextFormat(\'underline\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "undo":
                    $form .= '<img alt="' . _XK_UNDO . '" title="' . _XK_UNDO . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'undo\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                case "unlink":
                    $form .= '<img alt="' . _XK_UNLINK . '" title="' . _XK_UNLINK . '" src="' . $skinUrl . '/' . $tool . '.gif" onmousedown="XK_doTextFormat(\'unlink\',\'\',\'' . $this->getName() . '\')"/>';
                    break;

                default:
                    break;
            } 
        } 
        $form .= '</div></div>
						<iframe class="' . $this->getSkin() . 'wIframe" id="iframe' . $this->getName() . '"style="height:' . $this->getHeight() . ';" frameBorder="0"></iframe> 
						<textarea wrap=soft id="' . $this->getName() . '" name="' . $this->getName() . '" rows="1" cols="1" style="display:none; width:' . $this->getWidth() . '; height:' . $this->getHeight() . '">' . $this->getValue() . '</textarea>
						<div class="' . $this->getSkin() . 'statusBar">
							<div class="' . $this->getSkin() . 'smileysBar">' . $this->_renderWysiwygSmileys() . '</div>';

        $form .= '<div class="' . $this->getSkin() . 'htmlBar">';
		if ($toggleMode)$form .= '<div class="' . $this->getSkin() . 'htmlBar"><input type="checkbox" alt="' . _XK_TOGLE_MODE . '" title="' . _XK_TOGLE_MODE . '"  onclick="XK_doToggleView(\'' . $this->getName() . '\')" />HTML</div>';
        if ($themeCss)$form .= '<div class="' . $this->getSkin() . 'htmlBar"><input type="checkbox" alt="' . _XK_ENABLECSS_MODE . '" title="' . _XK_ENABLECSS_MODE . '" id="cssEnabled' . $this->getName() . '" onclick="XK_appendXoopsCss(\'' . $this->getName() . '\',\'' . $this->getThemeCSS() . '\')" />CSS &nbsp;</div>';
		$form .= '</div>';
        $form .= '</div>'; 
        // Render additional DIV'S
        if ($colorPalette) {
            include_once XOOPS_ROOT_PATH . '' . $this->getUrl() . '/class/colorpalette.class.php';
            $palette = new WysiwygColorPalette('XK_applyColor', $this->getName(), $url, $this->getSkin());
            $extraDivs .= $palette->_renderColorPalette();
        } 

        $extraDivs .= $this->_renderContextMenu();

        $form .= $extraDivs;
        $form .= '<input type="hidden" value="off" id="borderstoggle' . $this->getName() . '"/>';
        $form .= '<img alt="" width="0" height="0" src="' . $url . '/skins/common/blank.gif" onload="XK_init(\'' . $this->getName() . '\',\'' . $isie . '\',\'' . $url . '\',\'' . $this->getDirection() . '\')"/>';
        $form .= '</div>';
        return $form;
    } 

    function _renderWysiwygSmileys()
    {
        $myts = &MyTextSanitizer::getInstance();
        $url = XOOPS_URL . '' . $this->getUrl();
        $ret = '';
        $db = &Database::getInstance();
        $result = $db->query('SELECT * FROM ' . $db->prefix('smiles') . ' WHERE display=1');
        while ($smiles = $db->fetchArray($result)) {
            $ret .= '<img  onmousedown="XK_InsertImage(\'' . $this->getName() . '\',\'' . XOOPS_UPLOAD_URL . '/' . htmlspecialchars($smiles["smile_url"], ENT_QUOTES) . '\',\'\');" src="' . XOOPS_UPLOAD_URL . '/' . htmlspecialchars($smiles["smile_url"], ENT_QUOTES) . '" alt="" />';
        } 

        $ret .= '&nbsp;[<a href="#moresmiley" onmousedown="javascript:openWithSelfMain(\'' . $url . '/dialogs.php?id=' . $this->getName() . '&amp;dialog=smilies&amp;url=' . $this->getUrl() . '\',\'smilies\',300,475);">' . _MORE . '</a>]';
        return $ret;
    } 

    function _renderTableProps()
    {
        $url = XOOPS_URL . '' . $this->getUrl();
        $skinUrl = $url . '/skins/' . $this->getSkin();
        $ret = '
		<div name="XoopsKToolbarDivs" id="TableOps' . $this->getName() . '" class="' . $this->getSkin() . 'tablePropsD" style="display:none;">
    			<img title="' . _XK_INSERTCELL . '" alt="' . _XK_INSERTCELL . '" src="' . $skinUrl . '/insertcell.gif" onmousedown="XK_useTableOps(\'insertCell\',\'' . $this->getName() . '\');" /><br />
				<img title="' . _XK_DELCELL . '" alt="' . _XK_DELCELL . '" src="' . $skinUrl . '/delcell.gif" onmousedown="XK_useTableOps(\'deleteCell\',\'' . $this->getName() . '\');" /><br />
				
				<img title="' . _XK_INSERTROW . '" alt="' . _XK_INSERTROW . '" src="' . $skinUrl . '/insertrow.gif" onmousedown="XK_useTableOps(\'insertRow\',\'' . $this->getName() . '\');" /><br />
				<img title="' . _XK_DELROW . '" alt="' . _XK_DELROW . '" src="' . $skinUrl . '/delrow.gif" onmousedown="XK_useTableOps(\'deleteRow\',\'' . $this->getName() . '\');" /><br />
				<img title="' . _XK_MOREROWSPAN . '" alt="' . _XK_MOREROWSPAN . '" src="' . $skinUrl . '/morerowspan.gif" onmousedown="XK_useTableOps(\'increaseRowSpan\',\'' . $this->getName() . '\');" /><br />
				<img title="' . _XK_LESSROWSPAN . '" alt="' . _XK_LESSROWSPAN . '" src="' . $skinUrl . '/lessspan.gif" onmousedown="XK_useTableOps(\'decreaseRowSpan\',\'' . $this->getName() . '\');" /><br />
				
				<img title="' . _XK_INSERTCOL . '" alt="' . _XK_INSERTCOL . '" src="' . $skinUrl . '/insertcol.gif" onmousedown="XK_useTableOps(\'insertCol\',\'' . $this->getName() . '\');" /><br />
				<img title="' . _XK_DELCOL . '" alt="' . _XK_DELCOL . '" src="' . $skinUrl . '/delcol.gif" onmousedown="XK_useTableOps(\'deleteCol\',\'' . $this->getName() . '\');" /><br />		
				<img title="' . _XK_MORECOLSPAN . '" alt="' . _XK_MORECOLSPAN . '" src="' . $skinUrl . '/morespan.gif" onmousedown="XK_useTableOps(\'increaseSpan\',\'' . $this->getName() . '\');" /><br />
				<img title="' . _XK_LESSCOLSPAN . '" alt="' . _XK_LESSCOLSPAN . '" src="' . $skinUrl . '/lessspan.gif" onmousedown="XK_useTableOps(\'decreaseSpan\',\'' . $this->getName() . '\');" />
		</div>
		';

        return $ret;
    } 

    function _renderCellAlign()
    {
        $url = XOOPS_URL . '' . $this->getUrl();
        $skinUrl = $url . '/skins/' . $this->getSkin();
        $mouseover = 'onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"';

        $ret = '<div name="XoopsKToolbarDivs" class="' . $this->getSkin() . 'cellAlignD" id="CellAlign' . $this->getName() . '" style="display: none;">
			  <table   border="0" cellspacing="8" cellpadding="0" style="width:80px;">
  				<tr>
				    <td ' . $mouseover . ' ><img alt="' . _XK_CELLALIGNLEFTTOP . '" title="' . _XK_CELLALIGNLEFTTOP . '" src="' . $skinUrl . '/lefttop.gif" onmousedown="XK_cellAlign(\'' . $this->getName() . '\',\'left\',\'top\')"/></td>
				    <td ' . $mouseover . '><img alt="' . _XK_CELLALIGNCENTERTOP . '" title="' . _XK_CELLALIGNCENTERTOP . '" src="' . $skinUrl . '/centertop.gif" onmousedown="XK_cellAlign(\'' . $this->getName() . '\',\'center\',\'top\')"/></td>
				    <td ' . $mouseover . '><img alt="' . _XK_CELLALIGNRIGHTTOP . '" title="' . _XK_CELLALIGNRIGHTTOP . '" src="' . $skinUrl . '/righttop.gif" onmousedown="XK_cellAlign(\'' . $this->getName() . '\',\'right\',\'top\')"/></td>
			    </tr>
			    <tr>
				    <td ' . $mouseover . '><img alt="' . _XK_CELLALIGNLEFTMIDDLE . '" title="' . _XK_CELLALIGNLEFTMIDDLE . '" src="' . $skinUrl . '/leftmiddle.gif" onmousedown="XK_cellAlign(\'' . $this->getName() . '\',\'left\',\'middle\')"/></td>
				    <td ' . $mouseover . '><img alt="' . _XK_CELLALIGNCENTERMIDDLE . '" title="' . _XK_CELLALIGNCENTERMIDDLE . '" src="' . $skinUrl . '/centermiddle.gif" onmousedown="XK_cellAlign(\'' . $this->getName() . '\',\'center\',\'middle\')"/></td>
				    <td ' . $mouseover . '><img alt="' . _XK_CELLALIGNRIGHTMIDDLE . '" title="' . _XK_CELLALIGNRIGHTMIDDLE . '" src="' . $skinUrl . '/rightcenter.gif" onmousedown="XK_cellAlign(\'' . $this->getName() . '\',\'right\',\'middle\')"/></td>
			  </tr>
			  <tr>
    				<td ' . $mouseover . '><img alt="' . _XK_CELLALIGNLEFTBOTTOM . '" title="' . _XK_CELLALIGNLEFTBOTTOM . '" src="' . $skinUrl . '/leftbottom.gif" onmousedown="XK_cellAlign(\'' . $this->getName() . '\',\'left\',\'bottom\')"/></td>
				    <td ' . $mouseover . '><img alt="' . _XK_CELLALIGNCENTERBOTTOM . '" title="' . _XK_CELLALIGNCENTERBOTTOM . '" src="' . $skinUrl . '/centerbottom.gif" onmousedown="XK_cellAlign(\'' . $this->getName() . '\',\'center\',\'bottom\')"/></td>
				    <td ' . $mouseover . '><img alt="' . _XK_CELLALIGNRIGHTBOTTOM . '" title="' . _XK_CELLALIGNRIGHTBOTTOM . '" src="' . $skinUrl . '/rightbottom.gif" onmousedown="XK_cellAlign(\'' . $this->getName() . '\',\'right\',\'bottom\')"/></td>
			  </tr>
		   </table>
		  </div>';

        return $ret;
    } 

    function _renderCleanFormats()
    {
        $url = XOOPS_URL . '' . $this->getUrl();
        $skinUrl = $url . '/skins/' . $this->getSkin();
        $mouseover = 'onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';"';

        $ret = '<div name="XoopsKToolbarDivs" class="' . $this->getSkin() . 'ClearFormatsD" id="RemoveFormat' . $this->getName() . '" style="display: none;">				
  				<div ' . $mouseover . ' onmousedown="XK_removeFormat(\'' . $this->getName() . '\',\'lineBreaks\');" class="' . $this->getSkin() . 'DivOption">' . _XK_REMOVE_LINEBREAKS . '</div>
				<div ' . $mouseover . ' onmousedown="XK_removeFormat(\'' . $this->getName() . '\',\'span\');" class="' . $this->getSkin() . 'DivOption">' . _XK_REMOVE_SPANF . '</div>
				<div ' . $mouseover . ' onmousedown="XK_removeFormat(\'' . $this->getName() . '\',\'font\');" class="' . $this->getSkin() . 'DivOption">' . _XK_REMOVE_FONTF . '</div>
				<div ' . $mouseover . ' onmousedown="XK_removeFormat(\'' . $this->getName() . '\',\'word\');" class="' . $this->getSkin() . 'DivOption">' . _XK_REMOVE_WORDF . '</div>
				<div ' . $mouseover . ' onmousedown="XK_removeFormat(\'' . $this->getName() . '\',\'empty\');" class="' . $this->getSkin() . 'DivOption">' . _XK_REMOVE_EMPTYF . '</div>
				<div ' . $mouseover . ' onmousedown="XK_removeFormat(\'' . $this->getName() . '\',\'all\');" class="' . $this->getSkin() . 'DivOption">' . _XK_REMOVE_ALLF . '</div>
			</div>';

        return $ret;
    } 

    function _renderCellBorders()
    {
        $url = XOOPS_URL . '' . $this->getUrl();
        $skinUrl = $url . '/skins/' . $this->getSkin();
        $ret = '<div name="XoopsKToolbarDivs" class="' . $this->getSkin() . 'cellBordersD" style="display:none;" id="CellBorders' . $this->getName() . '">
					<table border="0" cellspacing="8" cellpadding="0" width=100%>
						<tr >
							<td onmousedown="XK_quickBorders(\'' . $this->getName() . '\',\'all\',\'Black\')" style="border:1px solid black;" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';">&nbsp;</td>
							<td onmousedown="XK_quickBorders(\'' . $this->getName() . '\',\'left\',\'Black\')" style="border:1px dotted silver; border-left:1px solid black;" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';">&nbsp;</td>
							<td onmousedown="XK_quickBorders(\'' . $this->getName() . '\',\'right\',\'Black\')" style="border:1px dotted silver;border-right:1px solid black;" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';">&nbsp;</td>
						</tr>
						<tr >
							<td onmousedown="XK_quickBorders(\'' . $this->getName() . '\',\'none\',\'Black\')" style="border:1px dotted silver;" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';">&nbsp;</td>
							<td onmousedown="XK_quickBorders(\'' . $this->getName() . '\',\'top\',\'Black\')" style="border:1px dotted silver;border-top:1px solid black;" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';">&nbsp;</td>
							<td onmousedown="XK_quickBorders(\'' . $this->getName() . '\',\'bottom\',\'Black\')" style="border:1px dotted silver;border-bottom:1px solid black;" onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'#FFFFFF\';">&nbsp;</td>
						</tr>
					</table>
				</div>';

        return $ret;
    } 

    function _renderContextMenu()
    {
        $url = XOOPS_URL . '' . $this->getUrl();
        $skinUrl = $url . '/skins/' . $this->getSkin();

        $mouseover = 'onmouseover="this.style.background=\'#B6BDD2\';" onmouseout="this.style.background=\'none\';"';

        $ret = '<div name="XoopsKToolbarDivs" id="xkcontextmenu' . $this->getName() . '" class="' . $this->getSkin() . 'contextMenu" style="display:none;">';

        $ret .= '		<div ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_doTextFormat(\'cut\',\'\',\'' . $this->getName() . '\')" ><img alt="" src="' . $skinUrl . '/cut.gif" />' . _XK_CUT . '</div>
					<div ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_doTextFormat(\'copy\',\'\',\'' . $this->getName() . '\')" ><img alt="" src="' . $skinUrl . '/copy.gif" />' . _XK_COPY . '</div>
					<div ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_doTextFormat(\'paste\',\'\',\'' . $this->getName() . '\')" ><img alt="" src="' . $skinUrl . '/paste.gif" />' . _XK_PASTE . '</div>';

        $ret .= '	<div class="' . $this->getSkin() . 'contextLast" ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_doTextFormat(\'removeformat\',\'\',\'' . $this->getName() . '\')" ><img alt="" src="' . $skinUrl . '/removeformat.gif"/>' . _XK_REMOVEFORMAT . '</div>	
					<div id="xklinkcontext' . $this->getName() . '" style="display:none;" class="' . $this->getSkin() . 'contextLast" ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_doTextFormat(\'unlink\',\'\',\'' . $this->getName() . '\')" ><img alt="" src="' . $skinUrl . '/unlink.gif" />' . _XK_UNLINK . '</div>				
					<div id="xkimagecontext' . $this->getName() . '" class="' . $this->getSkin() . 'contextLast" ' . $mouseover . ' style="display:none;" onmousedown="this.style.background=\'none\';XK_openPopup(\'' . $url . '/dialogs.php?id=' . $this->getName() . '&amp;dialog=imageProps&amp;url=' . $this->getUrl() . '&amp;skin=' . $this->getSkin() . '\',\'table\',400,260)"><img alt="" src="' . $skinUrl . '/imageprops.gif" />' . _XK_EDITIMAGE . '</div>
					<div id="xktablecontext' . $this->getName() . '" style="display:none;">
								
						<div ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_TTools(\'' . $this->getName() . '\',\'' . $url . '/dialogs.php?id=' . $this->getName() . '&amp;dialog=tableProps&amp;skin=' . $this->getSkin() . '&amp;url=' . $this->getUrl() . '\',\'table\',400,260)" ><img alt="" " src="' . $skinUrl . '/tableprops.gif" />' . _XK_TABLEPROPS . '</div>
						<div class="' . $this->getSkin() . 'contextLast" ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_TTools(\'' . $this->getName() . '\',\'' . $url . '/dialogs.php?id=' . $this->getName() . '&amp;dialog=cellProps&amp;skin=' . $this->getSkin() . '&amp;url=' . $this->getUrl() . '\',\'table\',400,260)" ><img alt="" src="' . $skinUrl . '/cellborders.gif" />' . _XK_CELLPROPS . '</div>
								
						<div ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_useTableOps(\'insertCell\',\'' . $this->getName() . '\');" ><img alt="" src="' . $skinUrl . '/insertcell.gif" />' . _XK_INSERTCELL . '</div>
						<div class="' . $this->getSkin() . 'contextLast" ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_useTableOps(\'deleteCell\',\'' . $this->getName() . '\');" ><img alt="" src="' . $skinUrl . '/delcell.gif" />' . _XK_DELCELL . '</div>
								
						<div ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_useTableOps(\'insertRow\',\'' . $this->getName() . '\');" ><img alt="" src="' . $skinUrl . '/insertrow.gif" />' . _XK_INSERTROW . '</div>
						<div ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_useTableOps(\'deleteRow\',\'' . $this->getName() . '\');" ><img alt="" src="' . $skinUrl . '/delrow.gif" />' . _XK_DELROW . '</div>
						<div ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_useTableOps(\'increaseRowSpan\',\'' . $this->getName() . '\');" ><img alt="" src="' . $skinUrl . '/morerowspan.gif" />' . _XK_MOREROWSPAN . '</div>
						<div class="' . $this->getSkin() . 'contextLast" ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_useTableOps(\'decreaseRowSpan\',\'' . $this->getName() . '\');" ><img alt="" src="' . $skinUrl . '/lessspan.gif" />' . _XK_LESSROWSPAN . '</div>
								
						<div ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_useTableOps(\'insertCol\',\'' . $this->getName() . '\');" ><img alt="" src="' . $skinUrl . '/insertcol.gif" />' . _XK_INSERTCOL . '</div>
						<div ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_useTableOps(\'deleteCol\',\'' . $this->getName() . '\');" ><img alt="" src="' . $skinUrl . '/delcol.gif" />' . _XK_DELCOL . '</div>
						<div ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_useTableOps(\'increaseSpan\',\'' . $this->getName() . '\');" ><img alt="" src="' . $skinUrl . '/morespan.gif" />' . _XK_MORECOLSPAN . '</div>
						<div class="' . $this->getSkin() . 'contextLast" ' . $mouseover . ' onmousedown="this.style.background=\'none\';XK_useTableOps(\'decreaseSpan\',\'' . $this->getName() . '\');" ><img alt="" src="' . $skinUrl . '/lessspan.gif" />' . _XK_LESSCOLSPAN . '</div>
					</div>';
        $ret .= '</div>';

        return $ret;
    } 

    function _renderQuickTable()
    {
        $url = XOOPS_URL . '' . $this->getUrl();
        $ret = '<div name="XoopsKToolbarDivs" class="' . $this->getSkin() . 'quickTableD" style=" display:none; " id="tablepicker' . $this->getName() . '">';
        $ret .= '<table style="width:80px;" >';
        for ($i = 1;$i < 8;$i++) {
            $ret .= '<tr>';

            for ($j = 1;$j < 8;$j++) {
                $ret .= '<td class=\'' . $this->getSkin() . 'tdPicker\' id="' . $this->getName() . '-' . $i . '-' . $j . '" bgcolor="#FFFFFF" onmouseover="XK_tableOver(\'' . $this->getName() . '\',\'' . $i . '\',\'' . $j . '\')" onmouseout="XK_tableOut(\'' . $this->getName() . '\',\'' . $i . '\',\'' . $j . '\')" onmousedown="XK_tableClick(\'' . $this->getName() . '\',\'' . $i . '\',\'' . $j . '\')"><img alt="" width="5" height="5" src="' . $url . '/skins/common/blank.gif" /></td>';
            } 

            $ret .= '</tr>';
        } 
        $ret .= '</table></div>';
        return $ret;
    } 

    function _renderInsertSymbols()
    {
        $url = XOOPS_URL . '' . $this->getUrl();
        $symbols = Array("{", "|", "}", "~", "&euro;", "&lsquo;", "&rsquo;", "&ldquo;", "&rdquo;", "&ndash;", "&mdash;", "&iexcl;", "&cent;", "&pound;", "&curren;", "&yen;", "&brvbar;", "&sect;", "&uml;", "&copy;", "&ordf;", "&laquo;", "&not;", "&reg;", "&macr;", "&deg;", "&plusmn;", "&sup2;", "&sup3;", "&acute;", "&micro;", "&para;", "&middot;", "&cedil;", "&sup1;", "&ordm;", "&raquo;", "&frac14;", "&frac12;", "&frac34;", "&iquest;", "&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;", "&Auml;", "&Aring;", "&AElig;", "&Ccedil;", "&Egrave;", "&Eacute;", "&Ecirc;", "&Euml;", "&Igrave;", "&Iacute;", "&Icirc;", "&Iuml;", "&ETH;", "&Ntilde;", "&Ograve;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Ouml;", "&times;", "&Oslash;", "&Ugrave;", "&Uacute;", "&Ucirc;", "&Uuml;", "&Yacute;", "&THORN;", "&szlig;", "&agrave;", "&aacute;", "&acirc;", "&atilde;", "&auml;", "&aring;", "&aelig;", "&ccedil;", "&egrave;", "&eacute;", "&ecirc;", "&euml;", "&igrave;", "&iacute;", "&icirc;", "&iuml;", "&eth;", "&ntilde;", "&ograve;", "&oacute;", "&ocirc;", "&otilde;", "&ouml;", "&divide;", "&oslash;", "&ugrave;", "&uacute;", "&ucirc;", "&uuml;", "&uuml;", "&yacute;", "&thorn;", "&yuml;") ;
        $length = sizeof($symbols);

        $i = 0;
        $ret = ' <select id="insertsymbol' . $this->getName() . '" class="' . $this->getSkin() . 'selectInput" name="select' . $this->getName() . '" onchange=\'XK_insertSymbol(this.options[this.selectedIndex].value, "' . $this->getName() . '")\'>';
        $ret .= '<option value="" selected="selected">' . _XK_SYMBOLS . '</option>';
        while ($i < $length) {
            $ret .= '<option value="' . $symbols[$i] . '">' . $symbols[$i] . '</option>';
            $i++;
        } 
        $ret .= '</select>';
        return $ret;
    } 
	/**
	 * Check if compatible
	 *
     * @return
	 */
	function isCompatible()
	{
		if ( !is_readable(XOOPS_ROOT_PATH . _XK_P_PATH. "/include/functions.inc.php")) {
		    return false;
		}
		include_once(XOOPS_ROOT_PATH . _XK_P_PATH. "/include/functions.inc.php");
		return checkBrowser(false);
	}
} 

?>