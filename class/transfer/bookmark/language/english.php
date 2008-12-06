<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		http://xoopsforge.com The XOOPS FORGE Project
* @copyright		http://xoops.org.cn The XOOPS CHINESE Project
* @copyright		XOOPS_copyrights.txt
* @copyright		readme.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license			GNU General Public License (GPL)
*					a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		CBB - XOOPS Community Bulletin Board
* @since			3.08
* @author		phppp
* ----------------------------------------------------------------------------------------------------------
* 				iForum - a bulletin Board (Forum) for ImpressCMS
* @since			1.00
* @author		modified by stranger
* @version		$Id$
*/

/**
 * Transfer::iforum language
 *
 * @author	    phppp, http://xoops.org.cn
 * @copyright	copyright (c) 2005 XOOPSForge.com
 * @package		module::article
 *
 */
 
define("_MD_TRANSFER_BOOKMARK","Add the link to bookmarks");
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