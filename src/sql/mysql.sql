-- phpMyAdmin SQL Dump
-- version 2.6.4-pl4
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: May 07, 2006 at 01:26 PM
-- Server version: 5.0.16
-- PHP Version: 5.1.0
-- 
-- CBB 3.04
-- 
-- 
-- Database: `cbb`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_archive`
-- 

CREATE TABLE `bb_archive` (
  `topic_id` int(8) unsigned NOT NULL default '0',
  `post_id` int(10) unsigned NOT NULL default '0',
  `post_text` text NOT NULL
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_attachments`
-- 

CREATE TABLE `bb_attachments` (
  `attach_id` int(8) unsigned NOT NULL auto_increment,
  `post_id` int(10) unsigned NOT NULL default '0',
  `name_saved` varchar(255) NOT NULL default '',
  `name_disp` varchar(255) NOT NULL default '',
  `mimetype` varchar(255) NOT NULL default '',
  `online` tinyint(1) unsigned NOT NULL default '1',
  `attach_time` int(10) unsigned NOT NULL default '0',
  `download` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`attach_id`),
  KEY `post_id` (`post_id`)
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_categories`
-- 

CREATE TABLE `bb_categories` (
  `cat_id` smallint(3) unsigned NOT NULL auto_increment,
  `cat_image` varchar(50) NOT NULL default '',
  `cat_title` varchar(100) NOT NULL default '',
  `cat_description` text NOT NULL,
  `cat_order` smallint(3) unsigned NOT NULL default '0',
  `cat_url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cat_id`),
  KEY `cat_order` (`cat_order`)
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_digest`
-- 

CREATE TABLE `bb_digest` (
  `digest_id` int(8) unsigned NOT NULL auto_increment,
  `digest_time` int(10) unsigned NOT NULL default '0',
  `digest_content` text,
  PRIMARY KEY  (`digest_id`),
  KEY `digest_time` (`digest_time`)
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_forums`
-- 

CREATE TABLE `bb_forums` (
  `forum_id` smallint(4) unsigned NOT NULL auto_increment,
  `forum_name` varchar(150) NOT NULL default '',
  `forum_desc` text,
  `parent_forum` smallint(4) unsigned NOT NULL default '0',
  `forum_moderator` varchar(255) NOT NULL default '',
  `forum_topics` int(8) unsigned NOT NULL default '0',
  `forum_posts` int(10) unsigned NOT NULL default '0',
  `forum_last_post_id` int(10) unsigned NOT NULL default '0',
  `cat_id` smallint(3) unsigned NOT NULL default '0',
  `forum_type` tinyint(1) unsigned NOT NULL default '0',
  `allow_html` tinyint(1) unsigned NOT NULL default '1',
  `allow_sig` tinyint(1) unsigned NOT NULL default '1',
  `allow_subject_prefix` tinyint(1) unsigned NOT NULL default '0',
  `hot_threshold` tinyint(3) unsigned NOT NULL default '10',
  `forum_order` smallint(4) unsigned NOT NULL default '0',
#  `allow_attachments` tinyint(1) unsigned NOT NULL default '1',
  `attach_maxkb` smallint(3) unsigned NOT NULL default '1000',
  `attach_ext` varchar(255) NOT NULL default '',
  `allow_polls` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`forum_id`),
  KEY `forum_last_post_id` (`forum_last_post_id`),
  KEY `cat_forum` (`cat_id`,`forum_order`),
  KEY `forum_order` (`forum_order`),
  KEY `cat_id` (`cat_id`)
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_moderates`
-- 

CREATE TABLE `bb_moderates` (
  `mod_id` int(10) unsigned NOT NULL auto_increment,
  `mod_start` int(10) unsigned NOT NULL default '0',
  `mod_end` int(10) unsigned NOT NULL default '0',
  `mod_desc` varchar(255) NOT NULL default '',
  `uid` int(10) unsigned NOT NULL default '0',
  `ip` varchar(32) NOT NULL default '',
  `forum_id` smallint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mod_id`),
  KEY `uid` (`uid`),
  KEY `mod_end` (`mod_end`),
  KEY `forum_id` (`forum_id`)
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_online`
-- 

CREATE TABLE `bb_online` (
  `online_forum` int(10) unsigned NOT NULL default '0',
  `online_topic` int(8) unsigned NOT NULL default '0',
  `online_uid` int(10) unsigned NOT NULL default '0',
  `online_uname` varchar(255) NOT NULL default '',
  `online_ip` varchar(32) NOT NULL default '',
  `online_updated` int(10) unsigned NOT NULL default '0',
  KEY `online_forum` (`online_forum`),
  KEY `online_topic` (`online_topic`),
  KEY `online_updated` (`online_updated`)
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_posts`
-- 

CREATE TABLE `bb_posts` (
  `post_id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `topic_id` int(8) unsigned NOT NULL default '0',
  `forum_id` smallint(4) unsigned NOT NULL default '0',
  `post_time` int(10) unsigned NOT NULL default '0',
  `uid` int(10) unsigned NOT NULL default '0',
  `poster_name` varchar(255) NOT NULL default '',
  `poster_ip` int(11) NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `dohtml` tinyint(1) unsigned NOT NULL default '0',
  `dosmiley` tinyint(1) unsigned NOT NULL default '1',
  `doxcode` tinyint(1) unsigned NOT NULL default '1',
  `dobr` tinyint(1) unsigned NOT NULL default '1',
  `doimage` tinyint(1) unsigned NOT NULL default '1',
  `icon` varchar(25) NOT NULL default '',
  `attachsig` tinyint(1) unsigned NOT NULL default '0',
  `approved` smallint(2) NOT NULL default '1',
  `post_karma` int(10) unsigned NOT NULL default '0',
  `attachment` text,
  `require_reply` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`post_id`),
  KEY `uid` (`uid`),
  KEY `pid` (`pid`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_id` (`topic_id`),
  KEY `subject` (`subject`(40)),
  KEY `forumid_uid` (`forum_id`,`uid`),
  KEY `topicid_uid` (`topic_id`,`uid`),
  KEY `post_time` (`post_time`),
  KEY `topicid_postid_pid` (`topic_id`,`post_id`,`pid`),
  FULLTEXT KEY `search` (`subject`)
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_posts_text`
-- 

CREATE TABLE `bb_posts_text` (
  `post_id` int(10) unsigned NOT NULL default '0',
  `post_text` text,
  `post_edit` text,
  PRIMARY KEY  (`post_id`),
  FULLTEXT KEY `search` (`post_text`)
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_reads_forum`
-- 

CREATE TABLE `bb_reads_forum` (
  `read_id` int(10) unsigned NOT NULL auto_increment,
  `uid` int(10) unsigned NOT NULL default '0',
  `read_time` int(10) unsigned NOT NULL default '0',
  `read_item` smallint(4) unsigned NOT NULL default '0',
  `post_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`read_id`),
  KEY `uid` (`uid`),
  KEY `read_item` (`read_item`),
  KEY `post_id` (`post_id`)
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_reads_topic`
-- 

CREATE TABLE `bb_reads_topic` (
  `read_id` int(10) unsigned NOT NULL auto_increment,
  `uid` int(10) unsigned NOT NULL default '0',
  `read_time` int(10) unsigned NOT NULL default '0',
  `read_item` int(8) unsigned NOT NULL default '0',
  `post_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`read_id`),
  KEY `uid` (`uid`),
  KEY `read_item` (`read_item`),
  KEY `post_id` (`post_id`)
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_report`
-- 

CREATE TABLE `bb_report` (
  `report_id` int(8) unsigned NOT NULL auto_increment,
  `post_id` int(10) unsigned NOT NULL default '0',
  `reporter_uid` int(10) unsigned NOT NULL default '0',
  `reporter_ip` int(11) NOT NULL default '0',
  `report_time` int(10) unsigned NOT NULL default '0',
  `report_text` varchar(255) NOT NULL default '',
  `report_result` tinyint(1) unsigned NOT NULL default '0',
  `report_memo` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`report_id`),
  KEY `post_id` (`post_id`)
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_topics`
-- 

CREATE TABLE `bb_topics` (
  `topic_id` int(8) unsigned NOT NULL auto_increment,
  `topic_title` varchar(255) NOT NULL default '',
  `topic_poster` int(10) unsigned NOT NULL default '0',
  `topic_time` int(10) unsigned NOT NULL default '0',
  `topic_views` int(10) unsigned NOT NULL default '0',
  `topic_replies` mediumint(8) unsigned NOT NULL default '0',
  `topic_last_post_id` int(8) unsigned NOT NULL default '0',
  `forum_id` smallint(4) unsigned NOT NULL default '0',
  `topic_status` tinyint(1) unsigned NOT NULL default '0',
  `topic_subject` smallint(3) unsigned NOT NULL default '0',
  `topic_sticky` tinyint(1) unsigned NOT NULL default '0',
  `topic_digest` tinyint(1) unsigned NOT NULL default '0',
  `digest_time` int(10) unsigned NOT NULL default '0',
  `approved` tinyint(2) NOT NULL default '1',
  `poster_name` varchar(255) NOT NULL default '',
  `rating` double(6,4) NOT NULL default '0.0000',
  `votes` int(11) unsigned NOT NULL default '0',
  `topic_haspoll` tinyint(1) unsigned NOT NULL default '0',
  `poll_id` mediumint(8) unsigned NOT NULL default '0',
  `topic_tags` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`topic_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_last_post_id` (`topic_last_post_id`),
  KEY `topic_poster` (`topic_poster`),
  KEY `topic_forum` (`topic_id`,`forum_id`),
  KEY `topic_sticky` (`topic_sticky`),
  KEY `topic_digest` (`topic_digest`),
  KEY `digest_time` (`digest_time`)
);

-- --------------------------------------------------------

-- 
-- Table structure for table `bb_votedata`
-- 

CREATE TABLE `bb_votedata` (
  `ratingid` int(11) unsigned NOT NULL auto_increment,
  `topic_id` int(8) unsigned NOT NULL default '0',
  `ratinguser` int(10) unsigned NOT NULL default '0',
  `rating` tinyint(3) unsigned NOT NULL default '0',
  `ratinghostname` varchar(60) NOT NULL default '',
  `ratingtimestamp` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ratingid`),
  KEY `ratinguser` (`ratinguser`),
  KEY `ratinghostname` (`ratinghostname`),
  KEY `topic_id` (`topic_id`)
);
