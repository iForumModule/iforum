<?php
// $Id: ratethread.php,v 1.3 2005/10/19 17:20:28 phppp Exp $
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

include 'header.php';

global $myts;

if (!is_object($xoopsUser)) {
    $ratinguser = 0;
}else{
    $ratinguser = $xoopsUser -> getVar('uid');
}
// Make sure only 1 anonymous from an IP in a single day.
$anonwaitdays = 1;
$ip = newbb_getIP(true);
$vars = array("topic_id", "rate", "forum");
foreach($vars as $var){
	${$var} = isset($_POST[$var]) ? intval($_POST[$var]) : (isset($_GET[$var])?intval($_GET[$var]):0);
}

$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
$topic_obj =& $topic_handler->get($topic_id);
if (!$topic_handler->getPermission($topic_obj->getVar("forum_id"), $topic_obj->getVar('topic_status'), "post")
	&&
	!$topic_handler->getPermission($topic_obj->getVar("forum_id"), $topic_obj->getVar('topic_status'), "reply")
){
	redirect_header("javascript:history.go(-1);", 2, _NOPERM);
}

if ($rate > 0 ){

    $rating = $rate * 2;
    // Check if Topic POSTER is voting (UNLESS Anonymous users allowed to post)
    if ($ratinguser != 0) {
        $result = $xoopsDB -> query("SELECT topic_poster FROM " . $xoopsDB -> prefix('bb_topics') . " WHERE topic_id=$topic_id");
        while (list($ratinguserDB) = $xoopsDB -> fetchRow($result)){
            if ($ratinguserDB == $ratinguser){
                redirect_header("viewtopic.php?topic_id=".$topic_id."&amp;forum=".$forum."", 4, _MD_CANTVOTEOWN);
                exit();
            }
        }
        // Check if REG user is trying to vote twice.
        $result = $xoopsDB -> query("SELECT ratinguser FROM " . $xoopsDB -> prefix('bb_votedata') . " WHERE topic_id=$topic_id");
        while (list($ratinguserDB) = $xoopsDB -> fetchRow($result)){
            if ($ratinguserDB == $ratinguser){
                redirect_header("viewtopic.php?topic_id=".$topic_id."&amp;forum=".$forum."", 4, _MD_VOTEONCE);
                exit();
            }
        }
    }
    else
    {
        // Check if ANONYMOUS user is trying to vote more than once per day.
        $yesterday = (time() - (86400 * $anonwaitdays));
        $result = $xoopsDB -> query("SELECT COUNT(*) FROM " . $xoopsDB -> prefix('bb_votedata') . " WHERE topic_id=$topic_id AND ratinguser=0 AND ratinghostname = '$ip'  AND ratingtimestamp > $yesterday");
        list($anonvotecount) = $xoopsDB -> fetchRow($result);
        if ($anonvotecount >= 1){
            redirect_header("viewtopic.php?topic_id=".$topic_id."&amp;forum=".$forum."", 4, _MD_VOTEONCE);
            exit();
        }
    }
}
else
{
	redirect_header("viewtopic.php?topic_id=".$topic_id."&amp;forum=".$forum."", 4, _MD_NOVOTERATE);
    exit();
}
// All is well.  Add to Line Item Rate to DB.
$newid = $xoopsDB -> genId($xoopsDB -> prefix('bb_votedata') . "_ratingid_seq");
$datetime = time();
$sql = sprintf("INSERT INTO %s (ratingid, topic_id, ratinguser, rating, ratinghostname, ratingtimestamp) VALUES (%u, %u, %u, %u, '%s', %u)", $xoopsDB -> prefix('bb_votedata'), $newid, $topic_id, $ratinguser, $rating, $ip, $datetime);
if(!$result = $xoopsDB -> queryF($sql)){
	newbb_message($sql);
}

// All is well.  Calculate Score & Add to Summary (for quick retrieval & sorting) to DB.
newbb_updaterating($topic_id);
$ratemessage = _MD_VOTEAPPRE . "<br />" . sprintf(_MD_THANKYOU, $xoopsConfig['sitename']);
redirect_header("viewtopic.php?topic_id=".$topic_id."&amp;forum=".$forum."", 4, $ratemessage);
exit();

include 'footer.php';
?>