<?php
// $Id: rank.php,v 1.1.2.3 2005/07/22 08:43:45 mithyt2 Exp $
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
// Author: D.J. (AKA phppp)                                                  //
// URL: http://www.xoops.org                                                 //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
/**
 * @package     kernel
 * 
 * @author	    D.J.
 * @copyright	copyright (c) 2000-2005 XOOPS.org
 */

class XoopsRank extends XoopsObject
{
    function XoopsRank()
    {
        $this->XoopsObject();
        $this->initVar('rank_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('rank_title', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('rank_min', XOBJ_DTYPE_INT, 0);
        $this->initVar('rank_max', XOBJ_DTYPE_INT, 0);
        $this->initVar('rank_special', XOBJ_DTYPE_INT, 0);
        $this->initVar('rank_image', XOBJ_DTYPE_TXTBOX, "");
    }
}
class XoopsRankHandler extends XoopsPersistableObjectHandler
{
    function XoopsRankHandler(&$db) {
        $this->XoopsPersistableObjectHandler($db, 'ranks', 'XoopsRank', 'rank_id', 'rank_title');
    }
}
?>