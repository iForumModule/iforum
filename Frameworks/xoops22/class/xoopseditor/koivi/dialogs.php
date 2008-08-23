<?php
// $Id: dialogs.php,v 1.1.2.2.2.1 2005/10/01 12:50:58 mithyt2 Exp $
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
/**
 *
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author	    Samuels
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */

 
/**
 * A textarea with wysiwyg buttons
 *
 * @author	    Samuels
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 *
 * @package     kernel
 * @subpackage  form
 */

$dialog = isset($_GET['dialog']) ? $_GET['dialog'] : 'none';
$skin = isset($_GET['skin']) ? $_GET['skin'] : 'default';
$id = isset($_GET['id']) ? $_GET['id'] : '';

/* The path is specified */
include_once(dirname(__FILE__) .'/../../../mainfile.php');
include_once(dirname(__FILE__) .'/preferences.php');
$url = _XK_P_PATH;

/* Check skin */
if(!in_array($skin, array("default", "common", "xp"))){
	include_once(XOOPS_ROOT_PATH."/class/xoopslists.php");
	$skin_list = XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH._XK_P_PATH.'/skins/');
	if(!in_array($skin, $skin_list)){
		$skins = array_keys($skin_list);
		$skin = $skins[0];
	}
}

if(file_exists(XOOPS_ROOT_PATH.''.$url.'/language/'.$xoopsConfig['language'].'.php')){ 
	include_once(XOOPS_ROOT_PATH.''.$url.'/language/'.$xoopsConfig['language'].'.php');
}else{
	include_once(XOOPS_ROOT_PATH.''.$url.'/language/english.php');
}

echo "<!DOCTYPE html PUBLIC '//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'._LANGCODE.'" lang="'._LANGCODE.'">';
echo '<head>';
echo '<meta http-equiv="content-type" content="text/html; charset='._CHARSET.'" />';
echo '<meta http-equiv="content-language" content="'._LANGCODE.'" />';
echo '<script type="text/javascript" src="'.XOOPS_URL.''.$url.'/include/js/dialogs.js"></script>';

switch ($dialog)
{
	case 'smilies':
	echo '<link rel="stylesheet" type="text/css" media="all" href="'.getcss($xoopsConfig['theme_set']).'" />';
	echo '</head><body style="width:100%;">
		<table width="100%" class="outer">
		<tr>
		<th colspan="3">'._MSC_SMILIES.'</th>
		</tr>
		<tr class="head">
		<td>'._MSC_CODE.'</td>
		<td>'._MSC_EMOTION.'</td>
		<td>'._XK_IMAGE.'</td>
		</tr>';
		if ($getsmiles = $xoopsDB->query('SELECT * FROM '.$xoopsDB->prefix('smiles'))) {
			$rcolor = 'even';
			while ( $smile = $xoopsDB->fetchArray($getsmiles) ) {
				echo "<tr class='$rcolor'><td>".$smile['code']."</td><td>".$smile['emotion']."</td><td><img onmouseover='style.cursor=\"hand\"' onclick=\"sendSmilie('".$id."','".XOOPS_UPLOAD_URL."/".$smile['smile_url']."')\" src='".XOOPS_UPLOAD_URL."/".$smile['smile_url']."' alt='' /></td></tr>";
				$rcolor = ($rcolor == 'even') ? 'odd' : 'even';
			}
		} else {
			echo "Could not retrieve data from the database.";
		}
		echo '</table>'._MSC_CLICKASMILIE;
		echo '</body></html>';
		break;
	
	case 'pastespecial':
		echo '
			<title>'._XK_PASTESPECIAL.'</title>
			<link href="'.XOOPS_URL.''.$url.'/skins/'.$skin.'/'.$skin.'.css" rel="stylesheet" type="text/css" />
			</head>	
		<body scroll=no class="'.$skin.'PropsBody" onload="document.getElementById(\'iframe\').contentWindow.document.designMode=\'on\';">';
		echo ''._XK_PASTEINSTRUCTIONS.'<br />
				<iframe class="'.$skin.'pasteSIframe" id="iframe" frameborder=0;></iframe>';
		echo '<br />';
		echo '<input class="'.$skin.'Input2" type="submit" value="'._XK_REMOVE_WORDF.'" onclick="XK_doClean(\'word\')">';
		echo '<input class="'.$skin.'Input2" type="submit" value="'._XK_REMOVE_ALLF.'" onclick="XK_doClean(\'all\')">';
		echo '<br /><input type="checkbox" id="checkClose" checked>'._XK_CLOSE_APASTE.'';
		echo '<br /><br />';
		echo '&nbsp;<input class="'.$skin.'SubmitInput" type="submit" value="Ok" onclick="XK_updateIframe(\''.$id.'\')">&nbsp;
					<input class="'.$skin.'SubmitInput" type="submit" value="Close" onclick="window.close();">';
		echo '</body></html>';
	break;	
		
	case 'table':
	echo '<link rel="stylesheet" type="text/css" media="all" href="'.getcss($xoopsConfig['theme_set']).'" />';
	echo '<title>'._XK_INSERTTABLE.'</title>';
	echo'</head><body style="width:100%;">';

		include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
		$sform = new XoopsThemeForm( _XK_INSERTTABLE, "table", xoops_getenv( 'PHP_SELF' ) );
		$sform->addElement( new XoopsFormText( _XK_ROWS, 'rows', 4, 4, '2' ), true );
		$sform->addElement( new XoopsFormText( _XK_COLS, 'columns', 4, 4, '2' ), true );
		$sform->addElement( new XoopsFormText( _XK_WIDTH, 'width_value', 4, 4, '100' ), true );
		$sform->addElement( new XoopsFormText( _XK_HEIGHT, 'height_value', 4, 4, '100' ), true );
		$sform->addElement( new XoopsFormText( _XK_BORDER, 'border', 4, 4, '1' ), true );
		$sform->addElement( new XoopsFormText( _XK_SPACING, 'cell_spacing', 4, 4, '1' ), true );
		$sform->addElement( new XoopsFormText( _XK_PADDING, 'cell_padding', 4, 4, '1' ), true );
		$button_tray = new XoopsFormElementTray( '', '' );
		$button_submit = new XoopsFormButton( '', '', _SUBMIT, 'button' );
		$button_submit->setExtra( 'onclick="sendTable(\''.$id.'\')"' );
		$button_cancel = new XoopsFormButton( '', '', _CANCEL, 'button' );
		$button_cancel->setExtra( 'onclick="window.close()"' );
		$button_tray->addElement( $button_submit );
		$button_tray->addElement( $button_cancel );
		$sform->addElement( $button_tray );
		$sform->display();
	
	echo '</body></html>';

	break;
	
	case 'cellProps':
	include_once XOOPS_ROOT_PATH.''.$url."/class/colorpalette.class.php";
	include_once XOOPS_ROOT_PATH.''.$url."/class/borderfieldset.class.php";
	echo '	<title>'._XK_CELLPROPS.'</title>
			<link href="'.XOOPS_URL.'/'.$url.'/skins/'.$skin.'/'.$skin.'.css" rel="stylesheet" type="text/css" />
			</head>';
		echo '<body scroll=no class="'.$skin.'PropsBody" onload="initCellProps(\''.$id.'\')" >';
		$uni='<option value="px">px</option>
            	<option value="em">em</option>
            	<option value="ex">ex</option>
            	<option value="cm">cm</option>
            	<option value="mm">mm</option>
            	<option value="pc">pc</option>
            	<option value="in">in</option>
            	<option value="pt">pt</option>';
				
		$units=$uni.'<option value="%">%</option>';
		
		$palette= new WysiwygColorPalette('XK_CC','',XOOPS_URL.'/'.$url, $skin);
		$palette->display();	
		echo '<form name="form1" method="post" action="">';
		$borders=new WysiwygBorderFieldset($url,$skin,'cellPreview()');
		
		echo '
		<div class="'.$skin.'selectedTab" onclick="SelectTab(this,\'a\',\''.$skin.'\');">'._XK_OTHERS.'</div>
		<div class="'.$skin.'notSelectedTab" onclick="SelectTab(this,\'b\',\''.$skin.'\');">'._XK_BORDERS.'</div>
		<div class="'.$skin.'notSelectedTab" onclick="SelectTab(this,\'c\',\''.$skin.'\');">'._XK_CELLPADDING.'</div>
		<div class="'.$skin.'notSelectedTab" onclick="SelectTab(this,\'d\',\''.$skin.'\');cellPreview();">'._XK_PREVIEW.'</div>';
		echo '
		<div class="'.$skin.'downTabContainer">
			
			<div class="'.$skin.'divTabContent" id="a">
				<table border="0" cellspacing="0" cellpadding="2">
              		<tr>
                		<td>'._XK_WIDTH.'</td>
                		<td><input type="text" class="'.$skin.'Input" id="cellWidth"  onkeypress="return onlyNumbers(event,this.id);"  /><select class="'.$skin.'Input" id="widthUnits" >'.$units.'</select></td>
              		</tr>
              		<tr>
                		<td>'._XK_HEIGHT.'</td>
                		<td><input type="text" class="'.$skin.'Input" id="cellHeight" onkeypress="return onlyNumbers(event,this.id);"  /><select class="'.$skin.'Input" id="heightUnits" >'.$units.'</select></td>
              		</tr>
					<tr>
                		<td>'._XK_FORECOLOR.'</td>
                		<td><input type="text" class="'.$skin.'Input" id="bgColor"   /><img style="height:16px;width:10px;" alt="'._XK_FORECOLOR.'" id="bg" title="'._XK_FORECOLOR.'" src="'.XOOPS_URL.'/'.$url.'/skins/'.$skin.'/popup.gif" onclick="XK_color(\'bg\')"/></td>
              		</tr>
              		<tr>
                		<td>'._XK_IMGBACK.'</td>
                		<td><input type="text" class="'.$skin.'Input" id="backgroundImage"  /><img style="height:16px;width:10px;" alt="'._XK_INSERTIMAGEM.'" id="bg" title="'._XK_INSERTIMAGEM.'" src="'.XOOPS_URL.'/'.$url.'/skins/'.$skin.'/popup.gif"onclick="openWithSelfMain(\''.XOOPS_URL.'/imagemanager.php?target='.$id.'&amp;wysiwyg=1\',\'imgmanager\',400,430)"/></td>
              		</tr>
					<tr>
                		<td>'._XK_CLASS.'</td>
                		<td><input type="text" class="'.$skin.'Input" id="class" /></td>
              		</tr>
            		</table>		
				</div>
			
			<div class="'.$skin.'divTabContent" style="display:none" id="b">';
				$borders->display();
			echo'</div>
			
			<div class="'.$skin.'divTabContent" style="display:none" id="c">
			
				<table border="0" cellspacing="0" cellpadding="2">
              		<tr>
                		<td>'._XK_BORDERLEFT.'</td>
                		<td><input type="text" class="'.$skin.'Input" id="paddingLeft"  onkeypress="return onlyNumbers(event,this.id);"  /><select class="'.$skin.'Input" id="paddingLeftUnits" >'.$uni.'</select></td>
              		</tr>
              		<tr>
                		<td>'._XK_BORDERRIGHT.'</td>
                		<td><input type="text" class="'.$skin.'Input" id="paddingRight"  onkeypress="return onlyNumbers(event,this.id);"  /><select class="'.$skin.'Input" id="paddingRightUnits" >'.$uni.'</select></td>
              		</tr>
              		<tr>
                		<td>'._XK_BORDERTOP.'</td>
                		<td><input type="text" class="'.$skin.'Input" id="paddingTop"  onkeypress="return onlyNumbers(event,this.id);"  /><select class="'.$skin.'Input" id="paddingTopUnits" >'.$uni.'</select></td>
              		</tr>
              		<tr>
                		<td>'._XK_BORDERBOTTOM.'</td>
                		<td><input type="text" class="'.$skin.'Input" id="paddingBottom"  onkeypress="return onlyNumbers(event,this.id);"  /><select class="'.$skin.'Input" id="paddingBottomUnits" >'.$uni.'</select></td>
              		</tr>
            	</table>
			</div>
			
			<div class="'.$skin.'divTabContent" style="display:none" id="d">
				<div align="center" class="'.$skin.'cellPreviewDiv">
					<table border="0" id="previewCell">
          				<tr>
           					<td id="PreviewCell2">test</td>
          				</tr>
        			</table>
				</div> 
			</div>	
		</div>';
						
		echo'<br style="clear:both;" />
				<input class="'.$skin.'SubmitInput" type="button" value="Ok" onclick="sendCell(\''.$id.'\')"/>
				<input class="'.$skin.'SubmitInput" type="reset" value="Reset" onclick="cellPreview()"/>
		</form>
	</body>
	</html>
	';
	
	break;
	
	case 'tableProps':
	include_once XOOPS_ROOT_PATH.''.$url."/class/colorpalette.class.php";
	echo '	<title>'._XK_TABLEPROPS.'</title>
			<link href="'.XOOPS_URL.'/'.$url.'/skins/'.$skin.'/'.$skin.'.css" rel="stylesheet" type="text/css" />
			</head>';
		echo '<body scroll=no class="'.$skin.'PropsBody" onload="initTableProps(\''.$id.'\')" >';
		
		$palette= new WysiwygColorPalette('XK_TableC','', XOOPS_URL.'/'.$url, $skin);
		$palette->display();	
			
		echo '<form name="form1" method="post" action="">';
		echo '
		<div class="'.$skin.'selectedTab" onclick="SelectTab(this,\'a\',\''.$skin.'\');">'._XK_OTHERS.'</div>
		<div class="'.$skin.'notSelectedTab" onclick="SelectTab(this,\'b\',\''.$skin.'\');">'._XK_FORECOLOR.'</div>
		<div class="'.$skin.'notSelectedTab" onclick="SelectTab(this,\'c\',\''.$skin.'\');tablePreview();">'._XK_PREVIEW.'</div>';
				
		echo'
			<div class="'.$skin.'downTabContainer">
					
					<div class="'.$skin.'divTabContent" id="a">
						<table border="0" cellspacing="0" cellpadding="2">
							<tr>
   								<td>'._XK_WIDTH.'</td>
    							<td><input type="text" class="'.$skin.'Input" id="width" /></td>
  							</tr>
							<tr>
   								<td>'._XK_HEIGHT.'</td>
    							<td><input type="text" class="'.$skin.'Input" id="height" /></td>
  							</tr>
							<tr>
   								<td>'._XK_BORDER.'</td>
    							<td><input type="text" class="'.$skin.'Input" id="border"onkeypress="return onlyNumbers(event,this.id);"/></td>
  							</tr>
							<tr>
   								<td>'._XK_PADDING.'</td>
    							<td><input type="text" class="'.$skin.'Input" id="padding"onkeypress="return onlyNumbers(event,this.id);"/></td>
  							</tr>
							<tr>
   								<td>'._XK_SPACING.'</td>
    							<td><input type="text" class="'.$skin.'Input" id="spacing"onkeypress="return onlyNumbers(event,this.id);"/></td>
  							</tr>
							<tr>
   								<td>'._XK_CLASS.'</td>
    							<td><input type="text" class="'.$skin.'Input" id="class"/></td>
  							</tr>
							<tr>
   								<td>'._XK_BCOLLPASE.'</td>
    							<td><input type="checkbox" id="collapse" onclick="tablePreview()"/></td>
  							</tr>
						</table>
					</div>
					
					<div class="'.$skin.'divTabContent" style="display:none;" id="b">
						<table border="0" cellspacing="0" cellpadding="2">
							<tr>
   								<td>'._XK_FORECOLOR.'</td>
    							<td><input type="text" class="'.$skin.'Input" id="bgColor" maxlength="7"/><img style="height:16px;width:10px;" alt="'._XK_FORECOLOR.'" id="bg" title="'._XK_FORECOLOR.'" src="'.XOOPS_URL.'/'.$url.'/skins/'.$skin.'/popup.gif" onclick="XK_color(\'bg\')"/></td>
  							</tr>
							<tr>
   								<td>'._XK_BORDERCOLOR.'</td>
    							<td><input type="text" class="'.$skin.'Input" id="bordertColor" maxlength="7" /><img style="height:16px;width:10px;" alt="'._XK_BORDERCOLOR.'" id="bordert" title="'._XK_BORDERCOLOR.'" src="'.XOOPS_URL.'/'.$url.'/skins/'.$skin.'/popup.gif" onclick="XK_color(\'bordert\')"/></td>
  							</tr>
							<tr>
   								<td>'._XK_IMGBACK.'</td>
    							<td><input type="text" class="'.$skin.'Input" id="backgroundImage"/><img style="height:16px;width:10px;" alt="'._XK_INSERTIMAGEM.'" id="bi" title="'._XK_INSERTIMAGEM.'" src="'.XOOPS_URL.'/'.$url.'/skins/'.$skin.'/popup.gif"onclick="openWithSelfMain(\''.XOOPS_URL.'/imagemanager.php?target='.$id.'&amp;wysiwyg=1\',\'imgmanager\',400,430)"/></td>
  							</tr>
						</table>
					</div>
					
					<div class="'.$skin.'divTabContent" style="display:none;" id="c">
						<div align="center" class="'.$skin.'tablePreviewDiv">
							<br />
							<table border="0" id="previewTable">
          						<tr>
									<td>test</td><td>test</td>
          						</tr>
								<tr>
           							<td>test</td><td>test</td>
          						</tr>
        					</table>
						</div>  
					</div>
					
				</div>
				<br style="clear:both;" />
				<input class="'.$skin.'SubmitInput" type="button" value="Ok" onclick="sendTableProps(\''.$id.'\')"/>
				<input class="'.$skin.'SubmitInput" type="reset" value="Reset" onclick="tablePreview()"/>
			</form>
			</body></html>';
	break;
	
	case 'imageProps':
	include_once XOOPS_ROOT_PATH.''.$url."/class/colorpalette.class.php";
	include_once XOOPS_ROOT_PATH.''.$url."/class/borderfieldset.class.php";
	echo '	<title>'._XK_IMAGEPROPS.'</title>
			<link href="'.XOOPS_URL.''.$url.'/skins/'.$skin.'/'.$skin.'.css" rel="stylesheet" type="text/css" />
			</head>';
			echo '<body scroll=no class="'.$skin.'PropsBody" onload="initImageProps(\''.$id.'\')" >';
		$units='<option value="px">px</option>
            	<option value="em">em</option>
            	<option value="ex">ex</option>
            	<option value="cm" >cm</option>
            	<option value="mm">mm</option>
            	<option value="pc">pc</option>
            	<option value="in">in</option>
            	<option value="pt">pt</option>';
		$borders=new WysiwygBorderFieldset($url,$skin,'imagePreview()');
		$palette= new WysiwygColorPalette('XK_ImgPrev','', XOOPS_URL.'/'.$url, $skin);
		$palette->display();
	echo'<form name="form1" method="post" action="">';
	
	
	echo '
		<div class="'.$skin.'selectedTab" onclick="SelectTab(this,\'a\',\''.$skin.'\');">'._XK_OTHERS.'</div>
		<div class="'.$skin.'notSelectedTab" onclick="SelectTab(this,\'b\',\''.$skin.'\');">'._XK_BORDERS.'</div>
		<div class="'.$skin.'notSelectedTab" onclick="SelectTab(this,\'c\',\''.$skin.'\');">'._XK_MARGINS.'</div>
		<div class="'.$skin.'notSelectedTab" onclick="SelectTab(this,\'d\',\''.$skin.'\');imagePreview();">'._XK_PREVIEW.'</div>';
					
				echo'
				<div class="'.$skin.'downTabContainer">

					<div class="'.$skin.'divTabContent" id="a">
						<table border="0" cellspacing="0" cellpadding="2">
  						<tr>
    						<td>'._XK_IMAGEALIGN.'</td>
    						<td><select class="'.$skin.'Input" id="align" >
          						<option value="">-</option>
								<option value="baseline">'._XK_BASELINE.'</option>
          						<option value="top">'._XK_TOP.'</option>
          						<option value="middle">'._XK_MIDDLE.'</option>
          						<option value="bottom">'._XK_BOTTOM.'</option>
								<option value="texttop">'._XK_TEXTTOP.'</option>
          						<option value="absmiddle">'._XK_ABSMIDDLE.'</option>
          						<option value="absbottom">'._XK_ABSBOTTOM.'</option>
          						<option value="left">'._XK_LEFT.'</option>
          						<option value="right">'._XK_RIGHT.'</option>
          						</select>
							</td>
  						</tr>
						<tr>
    						<td>'._XK_WIDTH.'</td>
    						<td>
								<input onkeypress="return onlyNumbers(event,this.id);"  type="text" class="'.$skin.'Input" id="width"/>
							</td>
  						</tr>
						<tr>
    						<td>'._XK_HEIGHT.'</td>
    						<td>
								<input onkeypress="return onlyNumbers(event,this.id);"  type="text" class="'.$skin.'Input" id="height"/>
							</td>
  						</tr>
						<tr>
    						<td>'._XK_ALT.'</td>
    						<td>
								<input type="text" class="'.$skin.'Input4" id="alt" />
							</td>
  						</tr>
						<tr>
    						<td>'._XK_SRC.'</td>
    						<td>
								<input type="text" class="'.$skin.'Input4" id="src" />
							</td>
  						</tr>
						<tr>
    						<td>'._XK_CLASS.'</td>
    						<td>
								<input type="text" class="'.$skin.'Input" id="className"/>
							</td>
  						</tr>
						
						</table>
					</div>
					
					<div class="'.$skin.'divTabContent" style="display:none" id="b">';
						$borders->display();
					echo'</div>
					
					<div class="'.$skin.'divTabContent" style="display:none" id="c">
						<table border="0" cellspacing="0" cellpadding="2">
  							<tr>
    							<td>'._XK_LEFT.'</td>
    							<td><input maxlength="5" type="text" class="'.$skin.'Input" id="marginLeft" onkeypress="return onlyNumbers(event,this.id);"  /><select class="'.$skin.'Input" id="marginLeftUnits">'.$units.'</select></td>
  							</tr>
							<tr>
    							<td>'._XK_RIGHT.'</td>
    							<td><input maxlength="5" type="text" class="'.$skin.'Input" id="marginRight" onkeypress="return onlyNumbers(event,this.id);"  /><select class="'.$skin.'Input" id="marginRightUnits">'.$units.'</select></td>
  							</tr>
							<tr>
    							<td>'._XK_TOP.'</td>
    							<td><input maxlength="5" type="text" class="'.$skin.'Input" id="marginTop" onkeypress="return onlyNumbers(event,this.id);"  /><select class="'.$skin.'Input" id="marginTopUnits">'.$units.'</select></td>
  							</tr>
							<tr>
    							<td>'._XK_HSPACE.'</td>
    							<td><input onkeypress="return onlyNumbers(event,this.id);"  type="text" class="'.$skin.'Input" id="hspace"/></td>
  							</tr>
							<tr>
    							<td>'._XK_VSPACE.'</td>
    							<td><input onkeypress="return onlyNumbers(event,this.id);"  type="text" class="'.$skin.'Input" id="vspace"/></td>
  							</tr>
							<tr>
    							<td>'._XK_BOTTOM.'</td>
    							<td><input maxlength="5" type="text" class="'.$skin.'Input" id="marginBottom" onkeypress="return onlyNumbers(event,this.id);"  /><select class="'.$skin.'Input" id="marginBottomUnits">'.$units.'</select></td>
  							</tr>
						</table>					
					</div>
	
					<div class="'.$skin.'divTabContent" style="display:none;" id="d">
						<div style="height:160px;overflow:auto;">
							<img id="previewimage" alt="" src="'.XOOPS_URL.'/'.$url.'/skins/common/xoops.gif" width="61" height="61"/>En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no hace mucho tiempo que viv&iacute;a un hidalgo de noble cuna, que pose&iacute;a un antiguo escudo, una lanza en astillero, un roc&iacute;n flaco y un galgo corredor. Era de condici&oacute;n modesta; y as&iacute;, las tres partes de su hacienda...			
    						<br style="clear:both;" />
						</div>
					</div>
					
				</div>
							<br style="clear:both;" />								
							<input class="'.$skin.'SubmitInput" type="button" value="Ok" onclick="sendImage(\''.$id.'\')"/>
					</form>
				</body>
			</html>';
	break;
	
	case 'createLink':
		
		echo '<link rel="stylesheet" type="text/css" media="all" href="'.getcss($xoopsConfig['theme_set']).'" />';
		echo'</head>
		<body  class="'.$skin.'PropsBody" style="width:100%;" onLoad="XK_MakeAnchorSelect(\''.$id.'\')">';
		
		include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
		$sform = new XoopsThemeForm( _XK_EDITIMAGE, 'linkform', xoops_getenv( 'PHP_SELF' ) );
		$sform->addElement( new XoopsFormText( 'Url', 'url', 20, 100, '' ), true );
		$select= new XoopsFormSelect( 'Anchor', 'anchor', '', 1,false);
		$select->setExtra( 'onchange="XK_disableUrlTextField(this.options[this.selectedIndex].value)"' );
		$sform->addElement($select);
		$sform->addElement( new XoopsFormSelect( 'Open', 'open', '', 1,false), true );
		$button_tray = new XoopsFormElementTray( '', '' );
		$button_submit = new XoopsFormButton( '', '', _SUBMIT, 'button' );
		$button_submit->setExtra( 'onclick="sendLink(\''.$id.'\')"' );
		$button_cancel = new XoopsFormButton( '', '', _CANCEL, 'button' );
		$button_cancel->setExtra( 'onclick="window.close()"' );
		$button_tray->addElement( $button_submit );
		$button_tray->addElement( $button_cancel );
		$sform->addElement( $button_tray );
		$sform->display();
		
	break;
	
	default:
	echo '</head><body onload="window.close()">';
	echo 'ERROR';
	echo '</body></html>';
	break;
}
?>