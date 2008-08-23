<?php
// ------------------------------------------------------------------------- //
//                XOOPS - PHP Content Management System                      //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //


$g_user_map = array();

function do_import()
{
	global $xoopsDB, $convert_options;
	echo "<font size=+1><b>".PHPBB_TITLE."</b></font><br /><br />";

	// Next user id
	$next_uid = next_id('users');
	// Map of existing RUNCMS users
	$user_map = user_map();

	$phpBB_db = db_connect();

	$sql_file_name = 'import_phpbb2.sql';
	@unlink($sql_file_name);

	$sql_file = fopen ($sql_file_name, "w+");

	echo "<b>".sprintf(PHPBB_IMPORTING, PHPBB_USERS).":</b><br/><br/>";
	$users = import_users($phpBB_db, $next_uid, $user_map, $sql_file);

	echo "<br/><b>".sprintf(PHPBB_IMPORTING, PHPBB_CATS).":</b><br/>";
	$cats = import_categories($phpBB_db, $sql_file);
	echo sprintf(PHPBB_IMPORTED, $cats, PHPBB_CATS)."<br/>";

	echo "<br/><b>".sprintf(PHPBB_IMPORTING, PHPBB_FORUMS).":</b><br/>";
	$forums = import_forums($phpBB_db, $sql_file);
	echo sprintf(PHPBB_IMPORTED, $forums, PHPBB_FORUMS)."<br/>";

	echo "<br/><b>".sprintf(PHPBB_IMPORTING, PHPBB_POLLS).":</b><br/>";
	$polls = import_poll_desc($phpBB_db, $sql_file);
	echo sprintf(PHPBB_IMPORTED, $polls, PHPBB_POLLS)."<br/>";

	echo "<br/><b>".sprintf(PHPBB_IMPORTING, PHPBB_POLL_OPTS).":</b><br/>";
	$opts = import_poll_options($phpBB_db, $sql_file);
	echo sprintf(PHPBB_IMPORTED, $opts, PHPBB_POLL_OPTS)."<br/>";


	// User Dependent
	if ($convert_options['import_pms'] == 1)
	{
		echo "<br/><b>".sprintf(PHPBB_IMPORTING, PHPBB_PMS).":</b><br/>";
	    if ($convert_options['pm_sys'] == 0)
	    {
			$pms = import_user_pm_xoops($phpBB_db, $sql_file);
		}
		else
		{
			echo "<br/><b>Currently no other Module</b><br/>";
		}
		echo sprintf(PHPBB_IMPORTED, $pms, PHPBB_PMS)."<br/>";
	}

	fclose($sql_file);

	return $sql_file_name;
}

function db_connect()
{
	global $convert_options;
	
	echo PHPBB_DBCONNECT;
	$phpBB_db = mysql_connect($convert_options['dbhost'], $convert_options['dbuser'], $convert_options['dbpass']);
	if ($phpBB_db)
	{
		if(!mysql_select_db($convert_options['dbname'], $phpBB_db))
		{
			echo PHPBB_ERR_DBSEL;
			die();
		}
	}
	else
	{
			echo PHPBB_ERR_DBCONN;
		die();
	}
	echo _OK."<br /><br />";
	return $phpBB_db;
}

function import_categories($phpBB_db, $sql_file)
{
	global $xoopsDB, $convert_options;
	$cat_count = 0;
	
	$sql = "SELECT * FROM ".$convert_options['dbprefix']."categories";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('bb_categories')." SET";
			$insert_sql .= " cat_id=".$row->cat_id.",";
			$insert_sql .= " cat_title='".addslashes($row->cat_title)."',";
			$insert_sql .= " cat_order=".$row->cat_order.SQL_SEPARATOR;
			fwrite($sql_file, $insert_sql);
			$cat_count++;
		}
	}
	else
	{
	    echo "$sql<br>".mysql_error();
	}
	return $cat_count;
}

function import_forums($phpBB_db, $sql_file)
{
	global $xoopsDB, $convert_options;

	$forum_count = 0;
	$sql = "SELECT * FROM ".$convert_options['dbprefix']."forums";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('bb_forums')." SET";
			$insert_sql .= " forum_id=".$row->forum_id.",";
			$insert_sql .= " forum_name='".addslashes($row->forum_name)."',";
			$insert_sql .= " forum_desc='".addslashes($row->forum_desc)."',";
			$insert_sql .= " forum_topics=".$row->forum_topics.",";
			$insert_sql .= " forum_posts=".$row->forum_posts.",";
			$insert_sql .= " forum_last_post_id=".$row->forum_last_post_id.",";
			$insert_sql .= " cat_id=".$row->cat_id.",";
			$insert_sql .= " allow_attachments=".intval($row->auth_attachments>0).",";
			$insert_sql .= " allow_polls=".intval($row->auth_pollcreate>0).",";
			$insert_sql .= " forum_order=".$row->forum_order.SQL_SEPARATOR;

			fwrite($sql_file, $insert_sql);
			$forum_count++;
		}
	}
	return $forum_count;
}

function import_users($phpBB_db, $next_uid, $user_map, $sql_file)
{
	global $xoopsDB, $g_user_map, $convert_options;
	
	$user_count = 0;

	$sql = "SELECT * FROM ".$convert_options['dbprefix']."users";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
		    $uname = '';
			
			if ($row->user_id == -1) //Anonymous
			{
				$newbb_uid = 0;
				$uname = 'Anonymous';
			}
			else
			{
				// First check if username already exists in runcms
				$newbb_uid = array_search($row->username, $user_map);
				$uname = $row->username;

				// Not found... insert the account
				if ($newbb_uid <= 0)
				{
					$newbb_uid = $next_uid;

					$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('users')." SET";
					$insert_sql .= " uid=".$newbb_uid.",";
					$insert_sql .= " name='".addslashes($row->username)."',";
					$insert_sql .= " uname='".addslashes($row->username)."',";
					$insert_sql .= " email='".addslashes($row->user_email)."',";
					$insert_sql .= " url='".addslashes($row->user_website)."',";
					$insert_sql .= " user_avatar='".addslashes($row->user_avatar)."',";
					$insert_sql .= " user_regdate=".$row->user_regdate.",";
					$insert_sql .= " user_icq='".addslashes($row->user_icq)."',";
					$insert_sql .= " user_from='".addslashes($row->user_from)."',";
					$insert_sql .= " user_sig='".addslashes($row->user_sig)."',";
					$insert_sql .= " user_viewemail=".$row->user_viewemail.",";
					$insert_sql .= " actkey='".addslashes($row->user_actkey)."',";
					$insert_sql .= " user_aim='".addslashes($row->user_aim)."',";
					$insert_sql .= " user_yim='".addslashes($row->user_yim)."',";
					$insert_sql .= " user_msnm='".addslashes($row->user_msnm)."',";
					$insert_sql .= " pass='".addslashes($row->user_password)."',";
					$insert_sql .= " posts=".$row->user_posts.",";
					$insert_sql .= " attachsig=".$row->user_attachsig.",";
					$insert_sql .= " rank=".intval($row->user_rank).",";
					$level = ($row->user_level >= 0) ? 1 : 0;
					$insert_sql .= " level=$level,";
					$insert_sql .= " uorder='0',";
					$insert_sql .= " notify_method='1',";
					$insert_sql .= " notify_mode='0',";
					$insert_sql .= " user_occ='".addslashes($row->user_occ)."',";
					$insert_sql .= " user_intrest='".addslashes($row->user_intrests)."'".SQL_SEPARATOR;
					fwrite($sql_file, $insert_sql);

					$next_uid++;
					$user_count++;
				}
			}

			$g_user_map[$row->user_id] = $newbb_uid;

			$topics = import_user_topics($phpBB_db, $row->user_id, $newbb_uid, $sql_file);
			$posts = import_user_posts($phpBB_db, $row->user_id, $newbb_uid, $sql_file);
			$poll_log = import_user_poll_log($phpBB_db, $row->user_id, $newbb_uid, $sql_file);
			echo '<table width=100%><tr>';
		    echo "<td width=55%>".sprintf(PHPBB_IMPORTING, PHPBB_USER)." <b>$uname</b></td>";
			echo "<td width=15%>".PHPBB_TOPICS.": $topics</td><td width=15%>".PHPBB_POSTS.": $posts</td><td width=15%>".PHPBB_VOTES.": $poll_log</td>";
			echo '</tr></table>';
		}
	}
	return $user_count;
}

function import_user_topics($phpBB_db, $phpBB_uid, $newbb_uid, $sql_file)
{
	global $xoopsDB, $convert_options;
    $topic_count = 0;

	$sql = "SELECT * FROM ".$convert_options['dbprefix']."topics WHERE topic_poster=$phpBB_uid";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('bb_topics')." SET";
			$insert_sql .= " topic_id=".$row->topic_id.",";
			$insert_sql .= " topic_title='".mysql_escape_string($row->topic_title)."',";
			$insert_sql .= " topic_poster=".$newbb_uid.",";
			$insert_sql .= " topic_time=".$row->topic_time.",";
			$insert_sql .= " topic_views=".$row->topic_views.",";
			$insert_sql .= " topic_replies=".$row->topic_replies.",";
			$insert_sql .= " topic_last_post_id=".$row->topic_last_post_id.",";
			$insert_sql .= " forum_id=".$row->forum_id.",";
			$insert_sql .= " topic_status=".$row->topic_status.SQL_SEPARATOR;
			fwrite($sql_file, $insert_sql);
			$topic_count++;
		}
	}
	return $topic_count;
}

function import_user_posts($phpBB_db, $phpBB_uid, $newbb_uid, $sql_file)
{
	global $xoopsDB, $convert_options;
	$post_count = 0;

	$sql = "SELECT * FROM ".$convert_options['dbprefix']."posts p, ".$convert_options['dbprefix']."posts_text pt WHERE p.post_id=pt.post_id AND poster_id=$phpBB_uid";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('bb_posts')." SET";
			$insert_sql .= " post_id=".$row->post_id.",";
			$insert_sql .= " topic_id=".$row->topic_id.",";
			$insert_sql .= " forum_id=".$row->forum_id.",";
			$insert_sql .= " post_time=".$row->post_time.",";
			$insert_sql .= " uid=".$newbb_uid.",";
			$insert_sql .= " poster_ip='".decode_ip($row->poster_ip)."',";
			$insert_sql .= " subject='".addslashes($row->post_subject)."',";
			$insert_sql .= " post_text='".addslashes($row->post_text)."',";
			$insert_sql .= " allow_html=".$row->enable_html.",";
			$insert_sql .= " allow_smileys=".$row->enable_smilies.",";
			$insert_sql .= " allow_bbcode=".$row->enable_bbcode.",";
			$insert_sql .= " attachsig=".$row->enable_sig.",";
			$insert_sql .= " is_approved=1,";
			$insert_sql .= " anon_uname='".addslashes($row->post_username)."'".SQL_SEPARATOR;

			fwrite($sql_file, $insert_sql);
			$post_count++;
		}
	}
	return $post_count;
}

function import_poll_desc($phpBB_db, $sql_file)
{
	global $xoopsDB, $convert_options;
    $poll_count = 0;

	$sql = "SELECT * FROM ".$convert_options['dbprefix']."vote_desc";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
		    // Work out the number of votes for this poll
		    $q = "SELECT SUM(vote_result) FROM ".$convert_options['dbprefix']."vote_results WHERE vote_id=".$row->vote_id;
		    $r = mysql_query($q);
		    list($votes) = mysql_fetch_array($r);
		    
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('xoopspoll_desc')." SET";
			$insert_sql .= " poll_id=".$row->vote_id.",";
			$insert_sql .= " topic_id=".$row->topic_id.",";
			$insert_sql .= " votes=".$votes.",";
			$insert_sql .= " voters=".$votes.",";
			$insert_sql .= " question='".addslashes($row->vote_text)."',";
			$insert_sql .= " start_time=".$row->vote_start.",";
			$insert_sql .= " end_time=".($row->vote_start + $row->vote_length).SQL_SEPARATOR;

			fwrite($sql_file, $insert_sql);
			$poll_count++;
		}
	}
	return $poll_count;
}

function import_poll_options($phpBB_db, $sql_file)
{
	global $xoopsDB, $convert_options;
    $poll_options = 0;

	$sql = "SELECT * FROM ".$convert_options['dbprefix']."vote_results";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('xoopspoll_option')." SET";
			$insert_sql .= " option_id=".$row->vote_option_id.",";
			$insert_sql .= " poll_id=".$row->vote_id.",";
			$insert_sql .= " option_text='".addslashes($row->vote_option_text)."',";
			$insert_sql .= " option_color='".addslashes('aqua.gif')."',";
			$insert_sql .= " option_count=".$row->vote_result.SQL_SEPARATOR;

			fwrite($sql_file, $insert_sql);
			$poll_options++;
		}
	}
	return $poll_options;
}

function import_user_poll_log($phpBB_db, $phpBB_uid, $newbb_uid, $sql_file)
{
	global $xoopsDB, $convert_options;
    $vote_count = 0;

	$sql = "SELECT * FROM ".$convert_options['dbprefix']."vote_voters WHERE vote_user_id=$phpBB_uid";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('xoopspoll_log')." SET";
			$insert_sql .= " poll_id=".$row->vote_id.",";
			$insert_sql .= " user_id=".$newbb_uid.",";
			$insert_sql .= " ip='".decode_ip($row->vote_user_ip)."'".SQL_SEPARATOR;

			fwrite($sql_file, $insert_sql);
			$vote_count++;
		}
	}
	return $vote_count;
}

function decode_ip($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}

function import_user_pm_xoops($phpBB_db, $sql_file)
{
	global $xoopsDB, $g_user_map, $convert_options;
    $pm_count = 0;

	$sql = "SELECT * FROM ".$convert_options['dbprefix']."privmsgs p, ".$convert_options['dbprefix']."privmsgs_text t WHERE p.privmsgs_id=t.privmsgs_text_id";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
		    if ($row->privmsgs_type > 1) continue;
		    
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('priv_msgs')." SET";
			$insert_sql .= " subject='".addslashes($row->privmsgs_subject)."',";
			$insert_sql .= " from_userid=".$g_user_map[$row->privmsgs_from_userid].",";
			$insert_sql .= " to_userid=".$g_user_map[$row->privmsgs_to_userid].",";
			$insert_sql .= " msg_time=".$row->privmsgs_date.",";
			$insert_sql .= " msg_text='".addslashes($row->privmsgs_text)."',";
			$read_msg = ($row->privmsgs_type == 0) ? 1 : 0;
			$insert_sql .= " read_msg=".$read_msg.SQL_SEPARATOR;

			fwrite($sql_file, $insert_sql);
			$pm_count++;
		}
	}
	return $pm_count;
}

?>