<?php
// $Id: formselectuser.php,v 1.1.2.4 2004/11/20 15:18:18 phppp Exp $
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

include_once XOOPS_ROOT_PATH . "/class/xoopsform/formselectuser.php";

class NewbbFormSelectUser extends XoopsFormSelectUser
{
    function NewbbFormSelectUser($caption, $name, $start = 0, $limit = 200, $value = null, $include_anon = false, $size = 10, $multiple = true)
    {
        $this->XoopsFormSelect($caption, $name, $value, $size, $multiple);

        $criteria = new CriteriaCompo();
        $criteria->setSort('uname');
        $criteria->setOrder('ASC');
        $criteria->setLimit($limit);
        $criteria->setStart($start);

        $member_handler = &xoops_gethandler('member');
        if ($include_anon) {
            global $xoopsConfig;
            $this->addOption(0, $xoopsConfig['anonymous']);
        } 
        $this->addOptionArray($member_handler->getUserList($criteria));
    } 

} 

?>
