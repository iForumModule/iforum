# phpMyAdmin SQL Dump
# version 2.5.6
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Aug 17, 2004 at 10:28 AM
# Server version: 4.0.20
# PHP Version: 4.2.3
#
# Database : `xpsbeta_xoops`
#

# --------------------------------------------------------

#
# Table structure for table `bb_archive`
#

CREATE TABLE `bb_archive` (
  `topic_id` tinyint(8) NOT NULL default '0',
  `post_id` tinyint(8) NOT NULL default '0',
  `post_text` text NOT NULL
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `bb_attachments`
#

CREATE TABLE `bb_attachments` (
  `attach_id` int(8) unsigned NOT NULL auto_increment,
  `post_id` int(10) default NULL,
  `name_saved` varchar(255) default NULL,
  `name_disp` varchar(255) default NULL,
  `mimetype` varchar(255) default NULL,
  `online` int(1) NOT NULL default '1',
  `attach_time` int(10) NOT NULL default '0',
  `download` int(10) NOT NULL default '0',
  PRIMARY KEY  (`attach_id`),
  KEY `post_id` (`post_id`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `bb_categories`
#

CREATE TABLE `bb_categories` (
  `cat_id` smallint(3) unsigned NOT NULL auto_increment,
  `cat_image` varchar(50) NOT NULL default '',
  `cat_title` varchar(100) NOT NULL default '',
  `cat_description` text NOT NULL,
  `cat_order` smallint(3) unsigned NOT NULL default '0',
  `cat_state` int(1) NOT NULL default '0',
  `cat_url` varchar(50) NOT NULL default '',
  `cat_showdescript` smallint(3) NOT NULL default '0',
  PRIMARY KEY  (`cat_id`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `bb_digest`
#

CREATE TABLE `bb_digest` (
  `digest_id` int(8) unsigned NOT NULL auto_increment,
  `digest_time` int(10) NOT NULL default '0',
  `digest_content` text,
  PRIMARY KEY  (`digest_id`),
  KEY `digest_time` (`digest_time`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `bb_forums`
#

CREATE TABLE `bb_forums` (
  `forum_id` smallint(4) unsigned NOT NULL auto_increment,
  `forum_name` varchar(150) NOT NULL default '',
  `forum_desc` text,
  `parent_forum` int(10) NOT NULL default '0',
  `forum_moderator` text NOT NULL,
  `forum_topics` int(8) NOT NULL default '0',
  `forum_posts` int(8) NOT NULL default '0',
  `forum_last_post_id` int(5) unsigned NOT NULL default '0',
  `cat_id` int(2) NOT NULL default '0',
  `forum_type` int(1) NOT NULL default '0',
  `allow_html` int(1) NOT NULL default '1',
  `allow_sig` int(1) NOT NULL default '1',
  `allow_subject_prefix` int(1) NOT NULL default '0',
  `hot_threshold` tinyint(3) unsigned NOT NULL default '10',
  `forum_order` int(8) NOT NULL default '0',
  `allow_attachments` int(1) NOT NULL default '1',
  `attach_maxkb` int(10) NOT NULL default '1000',
  `attach_ext` text NOT NULL,
  `allow_polls` int(1) NOT NULL default '0',
  `subforum_count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`forum_id`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `bb_votedate`
#

CREATE TABLE `bb_votedata` (
  `ratingid` int(11) unsigned NOT NULL auto_increment,
  `topic_id` int(11) unsigned NOT NULL default '0',
  `ratinguser` int(11) NOT NULL default '0',
  `rating` tinyint(3) unsigned NOT NULL default '0',
  `ratinghostname` varchar(60) NOT NULL default '',
  `ratingtimestamp` int(10) NOT NULL default '0',
  PRIMARY KEY  (ratingid),
  KEY ratinguser (ratinguser),
  KEY ratinghostname (ratinghostname),
  KEY topic_id (topic_id)
) TYPE=MyISAM;


# --------------------------------------------------------

#
# Table structure for table `bb_online`
#

CREATE TABLE `bb_online` (
  `online_forum` int(10) NOT NULL default '0',
  `online_topic` int(10) NOT NULL default '0',
  `online_uid` int(10) default NULL,
  `online_uname` varchar(255) default NULL,
  `online_ip` varchar(32) default NULL,
  `online_updated` int(14) default NULL
) TYPE=MyISAM COMMENT='whoisonline';

# --------------------------------------------------------

#
# Table structure for table `bb_report`
#

CREATE TABLE `bb_report` (
  `report_id` int(8) unsigned NOT NULL auto_increment,
  `post_id` int(10) default NULL,
  `reporter_uid` int(10) default NULL,
  `reporter_ip` int(11) NOT NULL default '0',
  `report_time` int(10) NOT NULL default '0',
  `report_text` varchar(255) default NULL,
  `report_result` tinyint(1) NOT NULL default '0',
  `report_memo` varchar(255) default NULL,
  PRIMARY KEY  (`report_id`),
  KEY `post_id` (`post_id`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `bb_posts`
#

CREATE TABLE `bb_posts` (
  `post_id` int(8) unsigned NOT NULL auto_increment,
  `pid` int(8) NOT NULL default '0',
  `topic_id` int(8) NOT NULL default '0',
  `forum_id` int(4) NOT NULL default '0',
  `post_time` int(10) NOT NULL default '0',
  `uid` int(10) unsigned NOT NULL default '0',
  `poster_name` varchar(255) NOT NULL default '',
  `poster_ip` int(11) NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `dohtml` tinyint(1) NOT NULL default '0',
  `dosmiley` tinyint(1) NOT NULL default '1',
  `doxcode` tinyint(1) NOT NULL default '1',
  `dobr` tinyint(1) NOT NULL default '1',
  `doimage` tinyint(1) NOT NULL default '1',
  `icon` varchar(25) NOT NULL default '',
  `attachsig` tinyint(1) NOT NULL default '0',
  `approved` int(1) NOT NULL default '1',
  `post_karma` int(10) NOT NULL default '0',
  `attachment` text,
  `require_reply` int(1) NOT NULL default '0',
  PRIMARY KEY  (`post_id`),
  KEY `uid` (`uid`),
  KEY `pid` (`pid`),
  KEY `subject` (`subject`(40)),
  KEY `forumid_uid` (`forum_id`,`uid`),
  KEY `topicid_uid` (`topic_id`,`uid`),
  KEY `topicid_postid_pid` (`topic_id`,`post_id`,`pid`),
  FULLTEXT KEY `search` (`subject`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `bb_posts_text`
#

CREATE TABLE `bb_posts_text` (
  `post_id` int(8) unsigned NOT NULL default '0',
  `post_text` text,
  `post_edit` text,
  PRIMARY KEY  (`post_id`),
  FULLTEXT KEY `search` (`post_text`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `bb_topics`
#

CREATE TABLE `bb_topics` (
  `topic_id` int(8) unsigned NOT NULL auto_increment,
  `topic_title` varchar(255) default NULL,
  `topic_poster` int(5) NOT NULL default '0',
  `topic_time` int(10) NOT NULL default '0',
  `topic_views` int(5) NOT NULL default '0',
  `topic_replies` int(4) NOT NULL default '0',
  `topic_last_post_id` int(8) unsigned NOT NULL default '0',
  `forum_id` int(4) NOT NULL default '0',
  `topic_status` tinyint(1) NOT NULL default '0',
  `topic_subject` int(3) NOT NULL default '0',
  `topic_sticky` tinyint(1) NOT NULL default '0',
  `topic_digest` tinyint(1) NOT NULL default '0',
  `digest_time` int(10) NOT NULL default '0',
  `approved` int(1) NOT NULL default '1',
  `poster_name` varchar(255) NOT NULL default '',
  `rating` double(6,4) NOT NULL default '0.0000',
  `votes` int(11) unsigned NOT NULL default '0',
  `topic_haspoll` tinyint(1) NOT NULL default '0',
  `poll_id` mediumint(8) unsigned NOT NULL default '0',

  PRIMARY KEY  (`topic_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_last_post_id` (`topic_last_post_id`),
  KEY `topic_poster` (`topic_poster`),
  KEY `topic_forum` (`topic_id`,`forum_id`),
  KEY `topic_sticky` (`topic_sticky`),
  KEY `topic_digest` (`topic_digest`)
) TYPE=MyISAM;
