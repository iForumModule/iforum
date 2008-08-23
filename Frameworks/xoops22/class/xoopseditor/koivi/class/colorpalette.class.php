<?php
// $Id: colorpalette.class.php,v 1.1.2.1 2005/06/04 02:11:51 phppp Exp $
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
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

class WysiwygColorPalette
{

	var $onclick;
	var $id;
	var $url;
	var $skin;


	function WysiwygColorPalette($onclick,$id,$url,$skin)
	{
		$this->setonclick($onclick);
		$this->setUrl($url);
		$this->setId($id);
		$this->setSkin($skin);
	}
	
	function getonclick(){return $this->onclick;}
	function setonclick($onclick){$this->onclick = $onclick;}
	function getId(){return $this->id;}
	function setId($id){$this->id = $id;}
	function getUrl(){return $this->url;}
	function setUrl($url){$this->url = $url;}
	function getSkin(){return $this->skin;}
	function setSkin($skin){$this->skin = $skin;}
	
	function _renderColorPalette()
	{
		$id=$this->getId();
		$function=$this->getonclick();
		$skin=$this->getSkin();
		$imgurl=$this->getUrl().'/skins/'.$skin;
		$colors=Array('#000000','#993300','#333300','#003300','#333366','#000099','#333399','#333333','#660000','#FF6600','#999900','#009900','#009999','#0000FF','#666699','#666666','#FF0000','#FF9900','#99CC00','#339966','#33CCCC','#3366FF','#660099','#999999','#FF00FF','#FFCC00','#FFFF00','#00FF00','#00FFFF','#00CCFF','#993366','#CCCCCC','#FF99CC','#FFCC99','#FFFF99','#CCFFCC','#CCFFFF','#99CCFF','#CC99FF','#FFFFFF');
		
		$text='<div name="XoopsKToolbarDivs" id="colorPalette'.$id.'" class="'.$skin.'ColorPickerD" style="display:none;">';
		
		$text.='	<div style="float:left;">';
		$text.='		<input class="'.$skin.'colorpickerPreview" type="text" id="colortextf'.$id.'" size="8" maxlength="8" />';
		$text.='		<input class="'.$skin.'colorpickerHEX" type="text" id="showc'.$id.'" maxlength="8" />';
		$text.='	</div>';
		
		$text.='	<img style="float:right;margin:2px;" alt="" src="'.$imgurl.'/none.gif" onmousedown="'.$function.'(\''.$id.'\',\'\')"/>';
		
		$text.='	<br style="clear:both;" />
					<div class="'.$skin.'ColorsContainer">';
					
		foreach ($colors as $color)
		{
			$text.='
						<div class="'.$skin.'Colors" style="background-color:'.$color.';border:1px solid #D7D7D7;" onmouseout="this.style.border=\'1px solid #D7D7D7\'" onmousedown="'.$function.'(\''.$id.'\',\''.$color.'\');this.style.border=\'1px solid #D7D7D7\'" onmouseover="XK_over(\''.$id.'\',\''.$color.'\');this.style.border=\'1px solid #000075\'"></div>';
		}
		$text.='	</div>
				</div>';
		
		$text.='<input type="hidden" id="coloroption'.$id.'"/>';
		return $text;
	}
	
	function display(){echo $this->_renderColorPalette();}
}
?>
