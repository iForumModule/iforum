<?php
// $Id: borderfieldset.class.php,v 1.1.2.1 2005/06/04 02:11:51 phppp Exp $
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

class WysiwygBorderFieldset
{
	var $url;
	var $skin;
	var $onchange;
	
	function WysiwygBorderFieldset($url,$skin,$onchange)
	{
		$this->setUrl($url);
		$this->setSkin($skin);
		$this->setOnchange($onchange);
	}
	
	function getonchange(){return $this->onchange;}
	function setonchange($onchange){$this->onchange = $onchange;}
	function getUrl(){return $this->url;}
	function setUrl($url){$this->url = $url;}
	function getSkin(){return $this->skin;}
	function setSkin($skin){$this->skin = $skin;}
	function display(){echo $this->_renderBorders();}
	
	function _renderBorders()
	{
		$url=$this->getUrl();
		$onchange=$this->getOnchange();
		$skin=$this->getSkin();
		$option='<option value="" selected="selected">-</option>
				<option value="none">none</option>
            	<option value="dotted">dotted</option>
            	<option value="dashed">dashed</option>
            	<option value="solid">solid</option>
            	<option value="double">double</option>
            	<option value="groove">groove</option>
            	<option value="ridge">ridge</option>
            	<option value="outset">outset</option>';
		$units='<option value="px">px</option>
            	<option value="em">em</option>
            	<option value="ex">ex</option>
            	<option value="cm" >cm</option>
            	<option value="mm">mm</option>
            	<option value="pc">pc</option>
            	<option value="in">in</option>
            	<option value="pt">pt</option>';
		
		$borders='		
					<table border="0" cellspacing="0" cellpadding="2">
              			<tr>
                			<td>'._XK_BORDERLEFT.'</td>
                			<td>
								<select class="'.$skin.'Input" id="borderLeftStyle" onchange="'.$onchange.'">'.$option.'</select>
								<input type="text" class="'.$skin.'Input" id="borderLeftWidth" maxlength="4" onchange="'.$onchange.'" onkeypress="return onlyNumbers(event,this.id);" />
      							<select class="'.$skin.'Input" id="borderLeftUnits" onchange="'.$onchange.'">'.$units.'</select>
								<img style="height:16px;width:10px;" alt="'._XK_FORECOLOR.'" id="borderLeft" title="'._XK_FORECOLOR.'" src="'.XOOPS_URL.'/'.$url.'/skins/'.$skin.'/popup.gif" onclick="XK_color(\'borderLeft\')"/>
								<input type="text" class="'.$skin.'Input" id="borderLeftColor" maxlength="7" onchange="'.$onchange.'" onkeypress="return onlyHexNumbers(event,this.id);" />
							</td>
              			</tr>
              			<tr>
                			<td>'._XK_BORDERRIGHT.'</td>
                			<td>
								<select class="'.$skin.'Input" id="borderRightStyle" onchange="'.$onchange.'">'.$option.'</select>
								<input type="text" class="'.$skin.'Input" id="borderRightWidth"  maxlength="4" onchange="'.$onchange.'" onkeypress="return onlyNumbers(event,this.id);" />
								<select class="'.$skin.'Input" id="borderRightUnits" onchange="'.$onchange.'">'.$units.'</select>
								<img style="height:16px;width:10px;" alt="'._XK_FORECOLOR.'" id="borderRight" title="'._XK_FORECOLOR.'" src="'.XOOPS_URL.'/'.$url.'/skins/'.$skin.'/popup.gif" onclick="XK_color(\'borderRight\')"/>
								<input type="text" class="'.$skin.'Input" id="borderRightColor" maxlength="7" onchange="'.$onchange.'" onkeypress="return onlyHexNumbers(event,this.id);" />							
							</td>
              			</tr>
						<tr>
                			<td>'._XK_BORDERTOP.'</td>
                			<td>
									<select class="'.$skin.'Input" id="borderTopStyle" onchange="'.$onchange.'">'.$option.'</select>
									<input type="text" class="'.$skin.'Input" id="borderTopWidth" maxlength="4" onchange="'.$onchange.'" onkeypress="return onlyNumbers(event,this.id);" />
									<select class="'.$skin.'Input" id="borderTopUnits" onchange="'.$onchange.'">'.$units.'</select>
									<img style="height:16px;width:10px;" alt="'._XK_FORECOLOR.'" id="borderTop" title="'._XK_FORECOLOR.'" src="'.XOOPS_URL.'/'.$url.'/skins/'.$skin.'/popup.gif" onclick="XK_color(\'borderTop\')"/>
									<input type="text" class="'.$skin.'Input" id="borderTopColor" maxlength="7" onchange="'.$onchange.'" onkeypress="return onlyHexNumbers(event,this.id);" />								
							</td>
              			</tr>
						<tr>
                			<td>'._XK_BORDERBOTTOM.'</td>
                			<td>
								<select class="'.$skin.'Input" id="borderBottomStyle" onchange="'.$onchange.'">'.$option.'</select>
								<input type="text" class="'.$skin.'Input" id="borderBottomWidth" maxlength="4" onchange="'.$onchange.'" onkeypress="return onlyNumbers(event,this.id);" />
      							<select class="'.$skin.'Input" id="borderBottomUnits" onchange="'.$onchange.'">'.$units.'</select>
								<img style="height:16px;width:10px;" alt="'._XK_FORECOLOR.'" id="borderBottom" title="'._XK_FORECOLOR.'" src="'.XOOPS_URL.'/'.$url.'/skins/'.$skin.'/popup.gif" onclick="XK_color(\'borderBottom\')"/>
								<input type="text" class="'.$skin.'Input" id="borderBottomColor" maxlength="7" onchange="'.$onchange.'" onkeypress="return onlyHexNumbers(event,this.id);" />      						
							</td>
              			</tr>
            </table>';
	return $borders;
}
}


?>
