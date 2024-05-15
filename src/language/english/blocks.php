<?php
	// $Id$
	// Blocks
	if (defined('_MB_IFORUM_DEFINED')) return;
	else define('_MB_IFORUM_DEFINED', true);
	//$constpref = '_MB_' . strtoupper( basename( dirname(  dirname(  dirname( __FILE__ ) ) ) ) ) ;
	$constpref = '_MB_IFORUM';
	 
	define($constpref."_FORUM", "Forum");
	define($constpref."_TOPIC", "Topic");
	define($constpref."_RPLS", "Replies");
	define($constpref."_VIEWS", "Views");
	define($constpref."_LPOST", "Last Post");
	define($constpref."_VSTFRMS", "Forums");
	define($constpref."_DISPLAY", "Number of posts: ");
	define($constpref."_DISPLAYMODE", "Display mode: ");
	define($constpref."_DISPLAYMODE_FULL", "Full");
	define($constpref."_DISPLAYMODE_COMPACT", "Compact");
	define($constpref."_DISPLAYMODE_LITE", "Lite");
	define($constpref."_FORUMLIST", "Allowed forum list: ");
	//define($constpref."_FORUMLIST_DESC","Forums allowed to display in the block");
	//define($constpref."_FORUMLIST_ID","ID");
	//define($constpref."_FORUMLIST_NAME","Forum name");
	define($constpref."_ALLTOPICS", "Topics");
	define($constpref."_ALLPOSTS", "Posts");
	 
	define($constpref."_CRITERIA", "Display criteria");
	define($constpref."_CRITERIA_TOPIC", "Topics");
	define($constpref."_CRITERIA_POST", "Posts");
	define($constpref."_CRITERIA_TIME", "Most recent");
	define($constpref."_CRITERIA_TITLE", "Post title");
	define($constpref."_CRITERIA_TEXT", "Post text");
	define($constpref."_CRITERIA_VIEWS", "Most views");
	define($constpref."_CRITERIA_REPLIES", "Most replies");
	define($constpref."_CRITERIA_DIGEST", "Newest digest");
	define($constpref."_CRITERIA_STICKY", "Newest sticky");
	define($constpref."_CRITERIA_DIGESTS", "Most digests");
	define($constpref."_CRITERIA_STICKYS", "Most sticky topics");
	define($constpref."_TIME", "Time period");
	define($constpref."_TIME_DESC", "Positive for days and negative for hours");
	 
	define($constpref."_TITLE", "Title");
	define($constpref."_AUTHOR", "Author");
	define($constpref."_COUNT", "Count");
	define($constpref."_INDEXNAV", "Display Navigator");
	 
	define($constpref."_TITLE_LENGTH", "Title/Post length");
?>