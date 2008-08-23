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
	echo "<font size=+1><b>".IPB_TITLE."</b></font><br /><br />";
	
	// Next user id
	$next_uid = next_id('users');
	// Map of existing XOOPS users
	$user_map = user_map();

	$ipb_db = db_connect();

	$sql_file_name = 'import_ipb.sql';
	@unlink($sql_file_name);

	$sql_file = fopen ($sql_file_name, "w+");

	echo "<b>".sprintf(IPB_IMPORTING, IPB_USERS).":</b><br/><br/>";
	$users = import_users($ipb_db, $next_uid, $user_map, $sql_file);

	echo "<br/><b>".sprintf(IPB_IMPORTING, IPB_CATS).":</b><br/>";
	$cats = import_categories($ipb_db, $sql_file);
	echo sprintf(IPB_IMPORTED, $cats, IPB_CATS)."<br/>";
	
	echo "<br/><b>".sprintf(IPB_IMPORTING, IPB_FORUMS).":</b><br/>";
	$forums = import_forums($ipb_db, $sql_file);
	echo sprintf(IPB_IMPORTED, $forums, IPB_FORUMS)."<br/>";
	
	echo "<br/><b>".sprintf(IPB_IMPORTING, IPB_POLLS).":</b><br/>";
	$polls = import_polls($ipb_db, $sql_file);
	echo sprintf(IPB_IMPORTED, $polls, IPB_POLLS)."<br/>";


	// User Dependent
	if ($convert_options['import_pms'] == 1)
	{
		echo "<br/><b>".sprintf(IPB_IMPORTING, IPB_PMS).":</b><br/>";
	    if ($convert_options['pm_sys'] == 0)
	    {
			$pms = import_user_pm_xoops($ipb_db, $sql_file);
		}
		else
		{
			echo "<br/><b>Currently no other Module</b><br/>";
		}
		echo sprintf(IPB_IMPORTED, $pms, IPB_PMS)."<br/>";
	}
	fclose($sql_file);

	return $sql_file_name;
}

function db_connect()
{
	global $convert_options;
	
	echo IPB_DBCONNECT;
	$ipb_db = mysql_connect($convert_options['dbhost'], $convert_options['dbuser'], $convert_options['dbpass']);
	if ($ipb_db)
	{
		if(!mysql_select_db($convert_options['dbname'], $ipb_db))
		{
			echo IPB_ERR_DBSEL;
			die();
		}
	}
	else
	{
			echo IPB_ERR_DBCONN;
		die();
	}
	echo _OK."<br /><br />";
	return $ipb_db;
}

function import_categories($ipb_db, $sql_file)
{
	global $xoopsDB, $convert_options;
	$cat_count = 0;
	
	$sql = "SELECT * FROM ".$convert_options['dbprefix']."categories where id>=0";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('bb_categories')." SET";
			$insert_sql .= " cat_id=".$row->id.",";
			$insert_sql .= " cat_title='".addslashes($row->name)."',";
			$insert_sql .= " cat_order=".$row->position.SQL_SEPARATOR;
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

function import_forums($ipb_db, $sql_file)
{
	global $xoopsDB, $convert_options;

	$forum_count = 0;
	$sql = "SELECT * FROM ".$convert_options['dbprefix']."forums";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
            $last_post = 0;
		    $q = "SELECT pid from ".$convert_options['dbprefix']."posts WHERE forum_id=".$row->id." order by post_date DESC";
			$r = mysql_query($q);
		    if($r)
		    {
		        $arr = mysql_fetch_array($r);
		        $last_post = $arr[0];
		    }
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('bb_forums')." SET";
			$insert_sql .= " forum_id=".$row->id.",";
			$insert_sql .= " forum_name='".addslashes($row->name)."',";
			$insert_sql .= " forum_desc='".addslashes($row->description)."',";
			$insert_sql .= " forum_topics=".$row->topics.",";
			$insert_sql .= " forum_posts=".$row->posts.",";
			$insert_sql .= " forum_last_post_id=".$last_post.",";
			$insert_sql .= " cat_id=".$row->category.",";
			$insert_sql .= " allow_html=".$row->use_html.",";
			$insert_sql .= " allow_polls=".intval($row->allow_poll>0).",";
			$insert_sql .= " forum_order=".$row->position.SQL_SEPARATOR;

			fwrite($sql_file, $insert_sql);
			$forum_count++;
		}
	}
	return $forum_count;
}

function import_users($ipb_db, $next_uid, $user_map, $sql_file)
{
	global $xoopsDB, $g_user_map, $convert_options;
	
	$user_count = 0;

	$sql = "SELECT * FROM ".$convert_options['dbprefix']."members";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
		    $uname = '';
			
			if ($row->id == 0) //Anonymous
			{
				$newbb_uid = 0;
				$uname = 'Anonymous';
			}
			else
			{
				// First check if username already exists in runcms
				$newbb_uid = array_search($row->name, $user_map);
				$uname = $row->name;

				// Not found... insert the account
				if ($newbb_uid <= 0)
				{
					$newbb_uid = $next_uid;

					$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('users')." SET";
					$insert_sql .= " uid='".$newbb_uid."',";
					$insert_sql .= " name='".addslashes($row->name)."',";
					$insert_sql .= " uname='".addslashes($row->name)."',";
					$insert_sql .= " email='".addslashes($row->email)."',";
					$insert_sql .= " url='".addslashes($row->website)."',";
					$insert_sql .= " user_avatar='".addslashes($row->avatar)."',";
					$insert_sql .= " user_regdate='".$row->joined."',";
					$insert_sql .= " user_icq='".addslashes($row->icq_number)."',";
					$insert_sql .= " user_from='".addslashes($row->location)."',";
					$insert_sql .= " user_sig='".addslashes($row->signature)."',";
					$insert_sql .= " user_viewemail='".$row->hide_email."',";
					$insert_sql .= " user_aim='".addslashes($row->aim_name)."',";
					$insert_sql .= " user_yim='".addslashes($row->yahoo)."',";
					$insert_sql .= " user_msnm='".addslashes($row->msnname)."',";
					$insert_sql .= " pass='".addslashes($row->password)."',";
					$insert_sql .= " posts='".$row->posts."',";
					$insert_sql .= " timezone_offset='".intval($row->time_offset)."',";
					$insert_sql .= " uorder='0',";
					$insert_sql .= " notify_method='1',";
					$insert_sql .= " notify_mode='0',";
					$insert_sql .= " user_intrest='".addslashes($row->interests)."',";
					$insert_sql .= " user_mailok='1'".SQL_SEPARATOR;
					fwrite($sql_file, $insert_sql);

					$next_uid++;
					$user_count++;
				}
			}

			$g_user_map[$row->id] = $newbb_uid;

			$topics = import_user_topics($ipb_db, $row->id, $newbb_uid, $sql_file);
			$posts = import_user_posts($ipb_db, $row->id, $newbb_uid, $sql_file);
			
			echo '<table width=100%><tr>';
		    echo "<td width=70%>".sprintf(IPB_IMPORTING, IPB_USER)." <b>$uname</b></td>";
			echo "<td width=15%>".IPB_TOPICS.": $topics</td><td width=15%>".IPB_POSTS.": $posts</td>";
			echo '</tr></table>';
		}
	}
	return $user_count;
}

function import_user_topics($ipb_db, $phpBB_uid, $newbb_uid, $sql_file)
{
	global $xoopsDB, $convert_options;
    $topic_count = 0;

	$sql = "SELECT * FROM ".$convert_options['dbprefix']."topics WHERE starter_id=$phpBB_uid";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
		    $last_post = 0;
		    $q = "SELECT pid from ".$convert_options['dbprefix']."posts WHERE topic_id=".$row->tid." order by post_date DESC";
			$r = mysql_query($q);
		    if($r)
		    {
		        $arr = mysql_fetch_array($r);
		        $last_post = $arr[0];
		    }
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('bb_topics')." SET";
			$insert_sql .= " topic_id=".$row->tid.",";
			$insert_sql .= " topic_title='".mysql_escape_string($row->title)."',";
			$insert_sql .= " topic_poster=".$newbb_uid.",";
			$insert_sql .= " topic_time=".$row->start_date.",";
			$insert_sql .= " topic_views=".$row->views.",";
			$insert_sql .= " topic_replies=".$row->posts.",";
			$insert_sql .= " topic_last_post_id=".$last_post.",";
			$insert_sql .= " forum_id=".$row->forum_id.",";
			$insert_sql .= " topic_sticky=".$row->pinned.SQL_SEPARATOR;
			fwrite($sql_file, $insert_sql);
			$topic_count++;
		}
	}
	return $topic_count;
}

function import_user_posts($ipb_db, $phpBB_uid, $newbb_uid, $sql_file)
{
	global $xoopsDB, $convert_options;
	$post_count = 0;

	$sql = "SELECT * FROM ".$convert_options['dbprefix']."posts WHERE author_id=$phpBB_uid";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('bb_posts')." SET";
			$insert_sql .= " post_id=".$row->pid.",";
//			$insert_sql .= " pid="..",";
			$insert_sql .= " topic_id=".$row->topic_id.",";
			$insert_sql .= " forum_id=".$row->forum_id.",";
			$insert_sql .= " post_time=".$row->post_date.",";
			$insert_sql .= " uid=".$newbb_uid.",";
			$insert_sql .= " poster_ip='".$row->ip_address."',";
			$insert_sql .= " subject='".addslashes($row->post_title)."',";
			$insert_sql .= " post_text='".addslashes($row->post)."',";
			$insert_sql .= " allow_html=1,";
			$insert_sql .= " allow_smileys=1,";
			$insert_sql .= " allow_bbcode=1,";
//			$insert_sql .= " type="..",";
//			$insert_sql .= " icon='".addslashes()."',";
			$insert_sql .= " attachsig=".$row->use_sig.",";
			$has_attach = (empty($row->attach_file)) ? 0 : 1;
			$insert_sql .= " has_attachment=".$has_attach.",";
			$insert_sql .= " is_approved=1,";
			$insert_sql .= " anon_uname='".addslashes($row->author_name)."'".SQL_SEPARATOR;

			fwrite($sql_file, $insert_sql);
			$post_count++;
			
			if ($has_attach)
			{
				$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('bb_attachments')." SET";
				$insert_sql .= " post_id=".$row->pid.",";
				$insert_sql .= " is_approved=1,";
				$insert_sql .= " file_name='".addslashes($row->attach_file)."',";
				$insert_sql .= " file_pseudoname='".addslashes($row->attach_)."',";
				$insert_sql .= " file_hits='".$row->attach_hits."'".SQL_SEPARATOR;
				fwrite($sql_file, $insert_sql);
			}
		}
	}
	return $post_count;
}

function import_polls($ipb_db, $sql_file)
{
	global $xoopsDB, $convert_options;
    $poll_count = 0;

	$sql = "SELECT * FROM ".$convert_options['dbprefix']."polls";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
		    
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('xoopspoll_desc')." SET";
			$insert_sql .= " poll_id=".$row->pid.",";
			$insert_sql .= " question='".addslashes($row->poll_question)."',";
			$insert_sql .= " votes=".$row->votes.",";
			$insert_sql .= " voters=".$row->votes.",";
			$insert_sql .= " start_time=".$row->start_date.",";
			$insert_sql .= " end_time=".($row->start_date + (7*24*60*60)).SQL_SEPARATOR;

			fwrite($sql_file, $insert_sql);
			
			$choices = unserialize($row->choices);
			foreach($choices as $option)
			{
				$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('xoopspoll_option')." SET";
				$insert_sql .= " poll_id=".$row->pid.",";
				$insert_sql .= " option_text='".addslashes($option[1]).",";
				$insert_sql .= " option_count=".$option[2].",";
				$insert_sql .= " option_color='aqua.gif'".SQL_SEPARATOR;

				fwrite($sql_file, $insert_sql);
			}

			$poll_count++;
		}
	}
	return $poll_count;
}


function import_user_pm_xoops($ipb_db, $sql_file)
{
	global $xoopsDB, $g_user_map, $convert_options;
    $pm_count = 0;
    
        print_r($g_user_map);

	$sql = "SELECT * FROM ".$convert_options['dbprefix']."messages";
	$result = mysql_query($sql);
	if ($result)
	{
		while ($row = mysql_fetch_object($result))
		{
			$insert_sql  = "INSERT INTO ".$xoopsDB->prefix('priv_msgs')." SET";
			$insert_sql .= " subject='".addslashes($row->title)."',";
			$insert_sql .= " from_userid='".$g_user_map[$row->from_id]."',";
			$insert_sql .= " to_userid='".$g_user_map[$row->recipient_id]."',";
			$insert_sql .= " msg_time='".$row->msg_date."',";
			$insert_sql .= " msg_text='".addslashes($row->message)."',";
			$insert_sql .= " read_msg='".$row->read_state."'".SQL_SEPARATOR;

			fwrite($sql_file, $insert_sql);
			$pm_count++;
		}
	}
	return $pm_count;
}

?>
