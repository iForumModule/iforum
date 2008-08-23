<?php
// $Id: karma.php,v 1.4 2005/04/18 01:22:28 phppp Exp $
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
class NewbbKarmaHandler {
    var $user;

    function getUserKarma($user = false)
    {
        global $xoopsUser;

        if (!isset($user) || !$user) {
            if (is_object($xoopsUser)) $this->user = &$xoopsUser;
            else $this->user = null;
        } elseif (is_object($user)) {
            $this->user = &$user;
        } elseif (is_int ($user) && $user > 0) {
            $member_handler = &xoops_gethandler('member');
            $this->user = &$member_handler->get($user);
        } else $this->user = null;

        return $this->calUserkarma();
    } 

    function calUserkarma()
    {
        if (!$this->user) $user_karma = 0;
        else $user_karma = $this->user->getVar('posts') * 50;
        return $user_karma;
    } 

    function updateUserKarma()
    {
    } 

    function writeUserKarma()
    {
    } 

    function readUserKarma()
    {
    } 
} 

?>