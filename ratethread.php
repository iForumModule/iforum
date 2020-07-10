<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright  http://www.xoops.org/ The XOOPS Project
* @copyright  http://xoopsforge.com The XOOPS FORGE Project
* @copyright  http://xoops.org.cn The XOOPS CHINESE Project
* @copyright  XOOPS_copyrights.txt
* @copyright  readme.txt
* @copyright  http://www.impresscms.org/ The ImpressCMS Project
* @license   GNU General Public License (GPL)
*     a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package  CBB - XOOPS Community Bulletin Board
* @since   3.08
* @author  phppp
* ----------------------------------------------------------------------------------------------------------
*     iForum - a bulletin Board (Forum) for ImpressCMS
* @since   1.00
* @author  modified by stranger
* @version  $Id$
*/
 
include 'header.php';
 
$ratinguser = is_object(icms::$user)?icms::$user->getVar('uid'):
0;
$anonwaitdays = 1;
$ip = iforum_getIP(true);
foreach(array("topic_id", "rate", "forum") as $var)
{
	$ {
		$var }
	 = isset($_POST[$var]) ? (int)$_POST[$var] :
	 (isset($_GET[$var])?(int)$_GET[$var]:0);
}
 
$topic_handler = icms_getmodulehandler('topic', basename(__DIR__), 'iforum' );
$topic_obj = $topic_handler->get($topic_id);
if (!$topic_handler->getPermission($topic_obj->getVar("forum_id"), $topic_obj->getVar('topic_status'), "post")
	&& !$topic_handler->getPermission($topic_obj->getVar("forum_id"), $topic_obj->getVar('topic_status'), "reply")
)
{
	redirect_header("javascript:history.go(-1);", 2, _NOPERM);
}
 
if (empty($rate))
	{
	redirect_header("viewtopic.php?topic_id=".$topic_id."&amp;forum=".$forum."", 4, _MD_NOVOTERATE);
	exit();
}
$rate_handler = icms_getmodulehandler("rate", $icmsModule->getVar("dirname"), "iforum");
if ($ratinguser != 0) {
	// Check if Topic POSTER is voting (UNLESS Anonymous users allowed to post)
	$crit_post = new icms_db_criteria_Compo(new icms_db_criteria_Item("topic_id", $topic_id));
	$crit_post->add(new icms_db_criteria_Item("uid", $ratinguser));
	$post_handler = icms_getmodulehandler("post", $icmsModule->getVar("dirname"), "iforum");
	if ($post_handler->getCount($crit_post)) {
		redirect_header("viewtopic.php?topic_id=".$topic_id."&amp;forum=".$forum."", 4, _MD_CANTVOTEOWN);
		exit();
	}
	// Check if REG user is trying to vote twice.
	$crit_rate = new icms_db_criteria_Compo(new icms_db_criteria_Item("topic_id", $topic_id));
	$crit_rate->add(new icms_db_criteria_Item("ratinguser", $ratinguser));
	if ($rate_handler->getCount($crit_rate))
	{
		redirect_header("viewtopic.php?topic_id=".$topic_id."&amp;forum=".$forum."", 4, _MD_VOTEONCE);
		exit();
	}
}
else
{
	// Check if ANONYMOUS user is trying to vote more than once per day.
	$crit_rate = new icms_db_criteria_Compo(new icms_db_criteria_Item("topic_id", $topic_id));
	$crit_rate->add(new icms_db_criteria_Item("ratinguser", $ratinguser));
	$crit_rate->add(new icms_db_criteria_Item("ratinghostname", $ip));
	$crit_rate->add(new icms_db_criteria_Item("ratingtimestamp", time() - (86400 * $anonwaitdays), ">"));
	if ($rate_handler->getCount($crit_rate))
	{
		redirect_header("viewtopic.php?topic_id=".$topic_id."&amp;forum=".$forum."", 4, _MD_VOTEONCE);
		exit();
	}
}
$rate_obj = $rate_handler->create();
$rate_obj->setVar("rating", $rate * 2);
$rate_obj->setVar("topic_id", $topic_id);
$rate_obj->setVar("ratinguser", $ratinguser);
$rate_obj->setVar("ratinghostname", $ip);
$rate_obj->setVar("ratingtimestamp", time());
 
$ratingid = $rate_handler->insert($rate_obj);
;
 
iforum_updaterating($topic_id);
$ratemessage = _MD_VOTEAPPRE . "<br />" . sprintf(_MD_THANKYOU, $icmsConfig['sitename']);
redirect_header("viewtopic.php?topic_id=".$topic_id."&amp;forum=".$forum."", 2, $ratemessage);
exit();
 
include 'footer.php';