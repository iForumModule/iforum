<?php
// $Id: schinese.php,v 1.1.1.1 2005/10/19 16:23:35 phppp Exp $
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
/**
 * Transfer::newbb language
 *
 * @author	    phppp, http://xoops.org.cn
 * @copyright	copyright (c) 2005 XOOPSForge.com
 * @package		module::article
 *
 */
 
define("_MD_TRANSFER_BOOKMARK","ÃÌº”µΩ È«©");
//define("_MD_TRANSFER_BOOKMARK_ITEMS",""); // del.icio.us?

/* Chinese */
define("_MD_TRANSFER_BOOKMARK_ITEMS","
	[<a title=\"Delicious\" href=\"javascript:void(delicious=window.open('http://del.icio.us/post?url='+encodeURIComponent('%2\$s')+'&title='+encodeURIComponent('%1\$s'), 'delicious'));delicious.focus();\">Del.icio.us</a>]
	[<a title=\"Furl\" href=\"javascript:void(furl=window.open('http://www.furl.net/storeIt.jsp?t='+encodeURIComponent('%1\$s')+'&u='+encodeURIComponent('%2\$s'), 'furl'));furl.focus();\">Furl It</a>]
	[<a title=\"ViVi Bookmark\" href=\"javascript:t='';void(vivi=window.open('http://vivi.sina.com.cn/collect/icollect.php?pid=2008&title='+escape('%1\$s')+'&url='+escape('%2\$s')+'&desc='+escape(t),'vivi','scrollbars=no,width=480,height=480,left=75,top=20,status=no,resizable=yes'));vivi.focus();\"><font color=\"#ff0000\">Sina VIVI</font></a>]
	[<a title=\"Yesky\" href=\"javascript:t='';void(yesky=window.open('http://hot.yesky.com/dp.aspx?t='+escape('%1\$s')+'&u='+escape('%2\$s')+'&c='+escape(t)+'&st=2','yesky','scrollbars=no,width=400,height=480,left=75,top=20,status=no,resizable=yes'));yesky.focus();\">Yesky bookmark</a>]
	[<a href=\"javascript:t='';void(keyit=window.open('http://www.365key.com/storeit.aspx?t='+escape('%1\$s')+'&u='+escape('%2\$s')+'&c='+escape(t),'keyit','scrollbars=no,width=475,height=575,left=75,top=20,status=no,resizable=yes'));keyit.focus();\"><strong><font color=\"#a287be\">365k</font><font color=\"#00cc00\">e</font><font color=\"#a287be\">y</font></strong></a>]
	[<a href=\"javascript:t='';void(keyit=window.open('http://blogmark.blogchina.com/jsp/key/quickaddkey.jsp?k='+encodeURI('%1\$s')+'&u='+encodeURI('%2\$s')+'&c='+encodeURI(t),'keyit','scrollbars=no,width=500,height=430,status=no,resizable=yes'));keyit.focus();\"><b>BlogChina</b></a>]
");
?>