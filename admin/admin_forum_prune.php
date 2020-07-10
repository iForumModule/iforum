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
 
include("admin_header.php");
 
icms_cp_header();
loadModuleAdminMenu(7, _AM_IFORUM_PRUNE_TITLE);
echo "<fieldset style='border: #e8e8e8 1px solid;'>
	<legend style='display: inline; font-weight: bold; color: #900;'>" . _AM_IFORUM_PRUNE_TITLE . "</legend>";
echo"<br /><br /><table width='100%' border='0' cellspacing='1' class='outer'>" . "<tr><td class='odd'>";
 
if (!empty($_POST['submit']))
{
	$post_list = null;
	$topic_list = null;
	$topics_number = 0;
	$posts_number = 0;
	 
	if (empty($_POST["forums"]))
            redirect_header("./admin_forum_prune.php", 1, _AM_IFORUM_PRUNE_FORUMSELERROR);
        elseif (!is_array($_POST["forums"]))
            $selected_forums[] = $myts->addSlashes($_POST["forums"]);
        else
            $selected_forums = $myts->addSlashes($_POST["forums"]);
        
	$prune_days = $myts->addSlashes($_POST["days"]);
	$prune_ddays = time() - $prune_days;
	$archive = $myts->addSlashes($_POST["archive"]);
	$sticky = $myts->addSlashes($_POST["sticky"]);
	$digest = $myts->addSlashes($_POST["digest"]);
	$lock = $myts->addSlashes($_POST["lock"]);
	$hot = $myts->addSlashes($_POST["hot"]);
	if (!empty($_POST["store"]))$store = $myts->addSlashes($_POST["store"]);
            foreach ($selected_forums as $v)
            {
                $sql = "SELECT t.topic_id FROM " . icms::$xoopsDB->prefix("bb_topics") . " t, " . icms::$xoopsDB->prefix("bb_posts") . "  p
		WHERE t.forum_id IN (" . $v . ")
		AND p.post_id =t.topic_last_post_id ";

                if ($sticky) $sql .= " AND t.topic_sticky <> 1 ";
                if ($digest) $sql .= " AND t.topic_digest <> 1 ";
                if ($lock) $sql .= " AND t.topic_status <> 1 ";
                if ($hot != 0) $sql .= " AND t.topic_replies < " . $hot . " ";

                $sql .= " AND p.post_time<= " . $prune_ddays . " ";
	
                // Ok now we have the sql query completed, go for topic_id's and posts_id's
                $topics = array();
                if (!$result = icms::$xoopsDB->query($sql))
                {
                	return _MD_ERROR;
                }
                // Dave_L code
                while ($row = icms::$xoopsDB->fetchArray($result))
                {
                        $topics[] = $row['topic_id'];
                }
                $topics_number = count($topics);
                $topic_list = implode(',', $topics);

                if ($topic_list != null)
                {
                        $sql = "SELECT post_id FROM " . icms::$xoopsDB->prefix("bb_posts") . "
                                WHERE topic_id IN (" . $topic_list . ")";

                        $posts = array();
                        if (!$result = icms::$xoopsDB->query($sql))
                        {
                                return _MD_ERROR;
                        }
                        // Dave_L code
                        while ($row = icms::$xoopsDB->fetchArray($result))
                        {
                                $posts[] = $row['post_id'];
                        }
                        $posts_number = count($posts);
                        $post_list = implode(',', $posts);
                }
                // OKZ Now we have al posts id and topics id
                if ($post_list != null)
                {
                        // COPY POSTS TO OTHER FORUM
                        if ($store != null)
                        {
                                $sql = "UPDATE " . icms::$xoopsDB->prefix("bb_posts") . " SET forum_id=$store WHERE topic_id IN ($topic_list)";
                                if (!$result = icms::$xoopsDB->query($sql))
                                {
                                        return _AM_IFORUM_ERROR;
                                }

                                $sql = "UPDATE " . icms::$xoopsDB->prefix("bb_topics") . " SET forum_id=$store WHERE topic_id IN ($topic_list)";
                                if (!$result = icms::$xoopsDB->query($sql))
                                {
                                        return _MD_ERROR;
                                }
                        }
                        else
                        {
                                // ARCHIVING POSTS
                                if ($archive == 1)
                                {
                                        $result = icms::$xoopsDB->query("SELECT p.topic_id, p.post_id, t.post_text FROM " . icms::$xoopsDB->prefix("bb_posts") . " p, " . icms::$xoopsDB->prefix("bb_posts_text") . " t WHERE p.post_id IN ($post_list) AND p.post_id=t.post_id");
                                        while (list($topic_id, $post_id, $post_text) = icms::$xoopsDB->fetchRow($result))
                                        {
                                                $sql = icms::$xoopsDB->query("INSERT INTO " . icms::$xoopsDB->prefix("bb_archive") . " (topic_id, post_id, post_text) VALUES ($topic_id, $post_id, '$post_text')");
                                        }
                                }
                                // DELETE POSTS
                                $sql = "DELETE FROM " . icms::$xoopsDB->prefix("bb_posts") . " WHERE topic_id IN ($topic_list)";
                                if (!$result = icms::$xoopsDB->query($sql))
                                {
                                        return _MD_ERROR;
                                }
                                // DELETE TOPICS
                                $sql = "DELETE FROM " . icms::$xoopsDB->prefix("bb_topics") . " WHERE topic_id IN ($topic_list)";
                                if (!$result = icms::$xoopsDB->query($sql))
                                {
                                        return _MD_ERROR;
                                }
                                // DELETE POSTS_TEXT
                                $sql = "DELETE FROM " . icms::$xoopsDB->prefix("bb_posts_text") . " WHERE post_id IN ($post_list)";
                                if (!$result = icms::$xoopsDB->query($sql))
                                {
                                        return _MD_ERROR;
                                }
                                // SYNC FORUMS AFTER DELETE
                                $forum_handler->synchronization();
                                // I THINK POSTS AND TOPICS HAVE BEEN DESTROYED :LOL:
                        }
                }

                /*Pulling the names of the forums, so that we dont have to use numbers...*/
                $r = icms::$xoopsDB->query("SELECT forum_name FROM " . icms::$xoopsDB->prefix("bb_forums") . " WHERE forum_id = " . $v);
                while($row = mysql_fetch_assoc($r))
                {
                    $forum_name = $row['forum_name'];
                }
                
                $tform = new icms_form_Theme(_AM_IFORUM_PRUNE_RESULTS_TITLE, "prune_results", xoops_getenv('PHP_SELF'));
                $tform->addElement(new icms_form_elements_Label(_AM_IFORUM_PRUNE_RESULTS_FORUMS, $forum_name));
                $tform->addElement(new icms_form_elements_Label(_AM_IFORUM_PRUNE_RESULTS_TOPICS, $topics_number));
                $tform->addElement(new icms_form_elements_Label(_AM_IFORUM_PRUNE_RESULTS_POSTS, $posts_number));
                $tform->display();
        }
}
else
{
	$sform = new icms_form_Theme(_AM_IFORUM_PRUNE_TITLE, "prune", xoops_getenv('PHP_SELF'));
	$sform->setExtra('enctype="multipart/form-data"');
	 
	/* Let User select the number of days
	$sform->addElement( new icms_form_elements_Text(_AM_IFORUM_PRUNE_DAYS , 'days', 5, 10,100 ), true );
	*/
	// $sql="SELECT p.topic_id, p.post_id t.post_text FROM ".icms::$xoopsDB->prefix("bb_posts")." p, ".icms::$xoopsDB->prefix("bb_posts_text")." t WHERE p.post_id IN ($post_list) AND p.post_id=t.post_id";
	// $result = icms::$xoopsDB->query();
	// Days selected by selbox (better error control :lol:)
	$days = new icms_form_elements_Select(_AM_IFORUM_PRUNE_DAYS, 'days', null , 1, false);
	$days->addOptionArray(array(604800 => _AM_IFORUM_PRUNE_WEEK, 1209600 => _AM_IFORUM_PRUNE_2WEEKS, 2592000 => _AM_IFORUM_PRUNE_MONTH, 5184000 => _AM_IFORUM_PRUNE_2MONTH, 10368000 => _AM_IFORUM_PRUNE_4MONTH, 31536000 => _AM_IFORUM_PRUNE_YEAR , 63072000 => _AM_IFORUM_PRUNE_2YEARS));
	$sform->addElement($days);
	 
	$checkbox = new icms_form_elements_Checkbox(_AM_IFORUM_PRUNE_FORUMS, 'forums');
	$radiobox = new icms_form_elements_Radio(_AM_IFORUM_PRUNE_STORE, 'store');
	// PUAJJ I HATE IT, please tidy up
	$sql = "SELECT forum_name, forum_id FROM " . icms::$xoopsDB->prefix("bb_forums") . " ORDER BY forum_id";
	if ($result = icms::$xoopsDB->query($sql))
	{
		if ($myrow = icms::$xoopsDB->fetchArray($result))
		{
			do
			{
				$checkbox->addOption($myrow['forum_id'], $myrow['forum_name']);
				$radiobox->addOption($myrow['forum_id'], $myrow['forum_name']);
			}
			 while ($myrow = icms::$xoopsDB->fetchArray($result));
		}
		else
		{
			echo "NO FORUMS";
		}
	}
	else
	{
		echo "DB ERROR";
	}
	 
	$sform->addElement($checkbox);
	 
	$sticky_confirmation = new icms_form_elements_Radio(_AM_IFORUM_PRUNE_STICKY, 'sticky', 1);
	$sticky_confirmation->addOption(1, _AM_IFORUM_PRUNE_YES);
	$sticky_confirmation->addOption(0, _AM_IFORUM_PRUNE_NO);
	$sform->addElement($sticky_confirmation);
	 
	$digest_confirmation = new icms_form_elements_Radio(_AM_IFORUM_PRUNE_DIGEST, 'digest', 1);
	$digest_confirmation->addOption(1, _AM_IFORUM_PRUNE_YES);
	$digest_confirmation->addOption(0, _AM_IFORUM_PRUNE_NO);
	$sform->addElement($digest_confirmation);
	 
	$lock_confirmation = new icms_form_elements_Radio(_AM_IFORUM_PRUNE_LOCK, 'lock', 0);
	$lock_confirmation->addOption(1, _AM_IFORUM_PRUNE_YES);
	$lock_confirmation->addOption(0, _AM_IFORUM_PRUNE_NO);
	$sform->addElement($lock_confirmation);
	 
	$hot_confirmation = new icms_form_elements_Select(_AM_IFORUM_PRUNE_HOT, 'hot', null , 1, false);
	$hot_confirmation->addOptionArray(array('0' => 0, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30));
	$sform->addElement($hot_confirmation);
	 
	$sform->addElement($radiobox);
	 
	$archive_confirmation = new icms_form_elements_Radio(_AM_IFORUM_PRUNE_ARCHIVE, 'archive', 1);
	$archive_confirmation->addOption(1, _AM_IFORUM_PRUNE_YES);
	$archive_confirmation->addOption(0, _AM_IFORUM_PRUNE_NO);
	$sform->addElement($archive_confirmation);
	 
	$button_tray = new icms_form_elements_Tray('', '');
	$button_tray->addElement(new icms_form_elements_Button('', 'submit', _AM_IFORUM_PRUNE_SUBMIT, 'submit'));
	$button_tray->addElement(new icms_form_elements_Button('', 'reset', _AM_IFORUM_PRUNE_RESET, 'reset'));
	$sform->addElement($button_tray);
	 
	$sform->display();
}
 
echo"</td></tr></table>";
echo "</fieldset>";
icms_cp_footer();