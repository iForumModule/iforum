<?php
// $Id: admin_digest.php,v 1.1.4.1 2005/01/06 22:55:33 praedator Exp $
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

include('admin_header.php');
include_once XOOPS_ROOT_PATH."/class/pagenav.php";


$op = 'default';
$item = 'process';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];
if (isset($_GET['item'])) $item = $_GET['item'];
if (isset($_POST['item'])) $item = $_POST['item'];
if (isset($_GET['report_id'])) $cat_id = $_GET['report_id'];
if (isset($_POST['report_id'])) $cat_id = $_POST['report_id'];

$start = (isset($_GET['start']))?$_GET['start']:0;
$report_handler =& xoops_getmodulehandler('report', 'newbb');

xoops_cp_header();
switch($op){
	case "delete":
		$digest_ids = $_POST['digest_id'];
		$digest_handler =& xoops_getmodulehandler('digest', 'newbb');
		foreach($digest_ids as $did => $value){
			$digest_handler->delete($did);
		}
		redirect_header( "admin_digest.php", 1);
		break;

	default:

		$limit = 5;
		newbb_adminmenu(8,_AM_NEWBB_DIGESTADMIN);
		echo "<fieldset><legend style='font-weight: bold; color: #900;'>" .  _AM_NEWBB_DIGESTADMIN . "</legend>";
		echo"<br />";
		echo '<form action="'.xoops_getenv('PHP_SELF').'" method="post">';
		echo "<table border='0' cellpadding='4' cellspacing='1' width='100%' class='outer'>";
		echo "<tr align='center'>";
		echo "<td class='bg3'>"._AM_NEWBB_DIGESTCONTENT."</td>";
		echo "<td class='bg3' width='2%'>"._DELETE."</td>";
		echo "</tr>";

		$digest_handler =& xoops_getmodulehandler('digest', 'newbb');
		$digests =& $digest_handler->getAllDigests($start, $limit);
		foreach($digests as $digest){
			echo "<tr class='odd' align='left'>";
			echo "<td><strong>#".$digest['digest_id'].' @ '. formatTimestamp($digest['digest_time']) . '</strong><br />' . str_replace("\n","<br />",$digest['digest_content']) . "</td>";
			echo "<td align='center' ><input type='checkbox' name='digest_id[".$digest['digest_id']."]' value='1' /></td>";
			echo "</tr>";
			echo "<tr colspan='2'><td height='2'></td></tr>";
		}
		$submit = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		echo "<tr colspan='2'><td align='center'>".$submit->render()."</td></tr>";
		$hidden =& new XoopsFormHidden('op', 'delete');
		echo $hidden->render();
		$hidden =& new XoopsFormHidden('item', $item);
		echo $hidden->render()."</form>";

		echo "</table>";

		$nav = new XoopsPageNav($digest_handler->getDigestCount(), $limit, $start, "start");
		echo $nav->renderNav(4);

		echo "</fieldset>";

		break;
}
xoops_cp_footer();

?>