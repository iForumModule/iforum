<?php
// $Id: admin.php,v 1.3.2.1 2005/01/06 23:00:14 praedator Exp $
//%%%%%%	File Name  index.php   	%%%%%
define("_AM_NEWBB_FORUMCONF","Forum Configuration");
define("_AM_NEWBB_ADDAFORUM","Add a Forum");
define("_AM_NEWBB_SYNCFORUM","Sync forum");
define("_AM_NEWBB_REORDERFORUM","Reorder");
define("_AM_NEWBB_FORUM_MANAGER","Forums");
define("_AM_NEWBB_PRUNE_TITLE","Prune");
define("_AM_NEWBB_CATADMIN","Categories");
define("_AM_NEWBB_GENERALSET", "Module Settings" );
define("_AM_NEWBB_MODULEADMIN","Module Admin:");
define("_AM_NEWBB_HELP","Help");
define("_AM_NEWBB_ABOUT","About");
define("_AM_NEWBB_BOARDSUMMARY","Board Statistic");
define("_AM_NEWBB_PENDING_POSTS_FOR_AUTH","Posts pending authorization");
define("_AM_NEWBB_POSTID","Post ID");
define("_AM_NEWBB_POSTDATE","Post Date");
define("_AM_NEWBB_POSTER","Poster");
define("_AM_NEWBB_TOPICS","Topics");
define("_AM_NEWBB_SHORTSUMMARY","Board Summary");
define("_AM_NEWBB_TOTALPOSTS","Total Posts");
define("_AM_NEWBB_TOTALTOPICS","Total Topics");
define("_AM_NEWBB_TOTALVIEWS","Total Views");
define("_AM_NEWBB_BLOCKS","Blocks");
define("_AM_NEWBB_SUBJECT","Subject");
define("_AM_NEWBB_APPROVE","Approve Post");
define("_AM_NEWBB_APPROVETEXT","Content of this Posting");
define("_AM_NEWBB_POSTAPPROVED","Post has been approved");
define("_AM_NEWBB_POSTNOTAPPROVED","Post has NOT been approved");
define("_AM_NEWBB_POSTSAVED","Post has been saved");
define("_AM_NEWBB_POSTNOTSAVED","Post has NOT been saved");

define("_AM_NEWBB_TOPICAPPROVED","Topic has been approved");
define("_AM_NEWBB_TOPICNOTAPPROVED","Topic has been NOT approved");
define("_AM_NEWBB_TOPICID","Topic ID");
define("_AM_NEWBB_ORPHAN_TOPICS_FOR_AUTH","Unapproved topics authorization");


define('_AM_NEWBB_DEL_ONE','Delete only this message');
define('_AM_NEWBB_POSTSDELETED','Selected post deleted.');
define('_AM_NEWBB_NOAPPROVEPOST','There are presently no posts waiting approval.');
define('_AM_NEWBB_SUBJECTC','Subject:');
define('_AM_NEWBB_MESSAGEICON','Message Icon:');
define('_AM_NEWBB_MESSAGEC','Message:');
define('_AM_NEWBB_CANCELPOST','Cancel Post');
define('_AM_NEWBB_GOTOMOD','Go to module');

define('_AM_NEWBB_PREFERENCES','Module preferences');
define('_AM_NEWBB_POLLMODULE','Xoops Poll Module');
define('_AM_NEWBB_POLL_OK','Ready for use');
define('_AM_NEWBB_GDLIB1','GD1 library:');
define('_AM_NEWBB_GDLIB2','GD2 library:');
define('_AM_NEWBB_AUTODETECTED','Autodetected: ');
define('_AM_NEWBB_AVAILABLE','Available');
define('_AM_NEWBB_NOTAVAILABLE','<font color="red">Not available</font>');
define('_AM_NEWBB_NOTWRITABLE','<font color="red">Not writable</font>');
define('_AM_NEWBB_IMAGEMAGICK','ImageMagicK:');
define('_AM_NEWBB_IMAGEMAGICK_NOTSET','Not set');
define('_AM_NEWBB_ATTACHPATH','Path for attachment storing');
define('_AM_NEWBB_THUMBPATH','Path for attached image thumbs');
//define('_AM_NEWBB_RSSPATH','Path for RSS feed');
define('_AM_NEWBB_REPORT','Reported posts');
define('_AM_NEWBB_REPORT_PENDING','Pending report');
define('_AM_NEWBB_REPORT_PROCESSED','processed report');

define('_AM_NEWBB_CREATETHEDIR','Create it');
define('_AM_NEWBB_SETMPERM','Set the permission');
define('_AM_NEWBB_DIRCREATED','The directory has been created');
define('_AM_NEWBB_DIRNOTCREATED','The directory can not be created');
define('_AM_NEWBB_PERMSET','The permission has been set');
define('_AM_NEWBB_PERMNOTSET','The permission can not be set');

define('_AM_NEWBB_DIGEST','Digest notification');
define('_AM_NEWBB_DIGEST_PAST','<font color="red">Should be sent out %d minutes ago</font>');
define('_AM_NEWBB_DIGEST_NEXT','Need to send out in %d minutes');
define('_AM_NEWBB_DIGEST_ARCHIVE','Digest archive');
define('_AM_NEWBB_DIGEST_SENT','Digest processed');
define('_AM_NEWBB_DIGEST_FAILED','Digest NOT processed');

// admin_forum_manager.php
define("_AM_NEWBB_NAME","Name");
define("_AM_NEWBB_CREATEFORUM","Create Forum");
define("_AM_NEWBB_EDIT","Edit");
define("_AM_NEWBB_CLEAR","Clear");
define("_AM_NEWBB_DELETE","Delete");
define("_AM_NEWBB_ADD","Add");
define("_AM_NEWBB_MOVE","Move");
define("_AM_NEWBB_ORDER","Order");
define("_AM_NEWBB_TWDAFAP","Note: This will remove the forum and all posts in it.<br /><br />WARNING: Are you sure you want to delete this Forum?");
define("_AM_NEWBB_FORUMREMOVED","Forum Removed.");
define("_AM_NEWBB_CREATENEWFORUM","Create a New Forum");
define("_AM_NEWBB_EDITTHISFORUM","Editing Forum:");
define("_AM_NEWBB_SET_FORUMORDER","Set Forum Position:");
define("_AM_NEWBB_ALLOWPOLLS","Allow Polls:");
define("_AM_NEWBB_ATTACHMENT_SIZE" ,"Max Size in kb`s:");
define("_AM_NEWBB_ALLOWED_EXTENSIONS", "Allowed Extensions:<span style='font-size: xx-small; font-weight: normal; display: block;'>'*' indicates no limititations.<br /> Extensions delimited by '|'</span>");
define("_AM_NEWBB_ALLOW_ATTACHMENTS", "Allow Attachments:");
define("_AM_NEWBB_ALLOWHTML","Allow HTML:");
define("_AM_NEWBB_YES","Yes");
define("_AM_NEWBB_NO","No");
define("_AM_NEWBB_ALLOWSIGNATURES","Allow Signatures:");
define("_AM_NEWBB_HOTTOPICTHRESHOLD","Hot Topic Threshold:");
//define("_AM_NEWBB_POSTPERPAGE","Posts per Page:<span style='font-size: xx-small; font-weight: normal; display: block;'>(This is the number of posts<br /> per topic that will be<br /> displayed per page.)</span>");
//define("_AM_NEWBB_TOPICPERFORUM","Topics per Forum:<span style='font-size: xx-small; font-weight: normal; display: block;'>(This is the number of topics<br /> per forum that will be<br /> displayed per page.)</span>");
//define("_AM_NEWBB_SHOWNAME","Replace user's name with real name:");
//define("_AM_NEWBB_SHOWICONSPANEL","Show icons panel:");
//define("_AM_NEWBB_SHOWSMILIESPANEL","Show smilies panel:");
define("_AM_NEWBB_MODERATOR_REMOVE","Remove current moderators");
define("_AM_NEWBB_MODERATOR_ADD","Add moderators");
define("_AM_NEWBB_ALLOW_SUBJECT_PREFIX", "Allow Subject Prefix for the Topics");
define("_AM_NEWBB_ALLOW_SUBJECT_PREFIX_DESC", "This allows a Prefix, which will be added to the Topic Subject");


// admin_cat_manager.php

define("_AM_NEWBB_SETCATEGORYORDER","Set Category Position:");
define("_AM_NEWBB_ACTIVE","Active");
define("_AM_NEWBB_INACTIVE","Inactive");
define("_AM_NEWBB_STATE","Status:");
define("_AM_NEWBB_CATEGORYDESC","Category Description:");
define("_AM_NEWBB_SHOWDESC","Show Description?");
define("_AM_NEWBB_SPONSORIMAGE","Sponsor Image:");
define("_AM_NEWBB_SPONSORLINK","Sponsor Link:");
define("_AM_NEWBB_DELCAT","Delete Category");
define("_AM_NEWBB_WAYSYWTDTTAL","Note: This will NOT remove the forums under the category, you must do that via the Edit Forum section.<br /><br />WARNING: Are you sure you want to delete this Category?");



//%%%%%%        File Name  admin_forums.php           %%%%%
define("_AM_NEWBB_FORUMNAME","Forum Name:");
define("_AM_NEWBB_FORUMDESCRIPTION","Forum Description:");
define("_AM_NEWBB_MODERATOR","Moderator(s):");
define("_AM_NEWBB_REMOVE","Remove");
define("_AM_NEWBB_CATEGORY","Category:");
define("_AM_NEWBB_DATABASEERROR","Database Error");
define("_AM_NEWBB_CATEGORYUPDATED","Category Updated.");
define("_AM_NEWBB_EDITCATEGORY","Editing Category:");
define("_AM_NEWBB_CATEGORYTITLE","Category Title:");
define("_AM_NEWBB_CATEGORYCREATED","Category Created.");
define("_AM_NEWBB_CREATENEWCATEGORY","Create a New Category");
define("_AM_NEWBB_FORUMCREATED","Forum Created.");
define("_AM_NEWBB_ACCESSLEVEL","Global Access Level:");
define("_AM_NEWBB_CATEGORY1","Category");
define("_AM_NEWBB_FORUMUPDATE","Forum Settings Updated");
define("_AM_NEWBB_FORUM_ERROR","ERROR: Forum Setting Error");
define("_AM_NEWBB_CLICKBELOWSYNC","Clicking the button below will sync up your forums and topics pages with the correct data from the database. Use this section whenever you notice flaws in the topics and forums lists.");
define("_AM_NEWBB_SYNCHING","Synchronizing forum index and topics (This may take a while)");
define("_AM_NEWBB_CATEGORYDELETED","Category deleted.");
define("_AM_NEWBB_MOVE2CAT","Move to category:");
define("_AM_NEWBB_MAKE_SUBFORUM_OF","Make a sub forum of:");
define("_AM_NEWBB_MSG_FORUM_MOVED","Forum moved!");
define("_AM_NEWBB_MSG_ERR_FORUM_MOVED","Failed to move forum.");
define("_AM_NEWBB_SELECT","< Select >");
define("_AM_NEWBB_MOVETHISFORUM","Move this Forum");

//%%%%%%        File Name  admin_forum_reorder.php           %%%%%
define("_AM_NEWBB_REORDERID","ID");
define("_AM_NEWBB_REORDERTITLE","Title");
define("_AM_NEWBB_REORDERWEIGHT","Position");
define("_AM_NEWBB_SETFORUMORDER","Set Board Ordering");
define("_AM_NEWBB_BOARDREORDER","The Board has reordered to your specification");

// forum_access.php
define("_AM_NEWBB_PERMISSIONS_TO_THIS_FORUM","Topic permissions for this Forum");
define("_AM_NEWBB_CAN_VIEW","Can View");
define("_AM_NEWBB_CAN_POST","Can start new topics");
define("_AM_NEWBB_CAN_REPLY","Can Reply");
define("_AM_NEWBB_CAN_EDIT","Can Edit");
define("_AM_NEWBB_CAN_DELETE","Can Delete");
define("_AM_NEWBB_CAN_ADDPOLL","Can Add Poll");
define("_AM_NEWBB_CAN_VOTE","Can Vote");
define("_AM_NEWBB_CAN_ATTACH","Can Attach");
define("_AM_NEWBB_CAN_NOAPPROVE","Can Post without Approval");
define("_AM_NEWBB_ACTION","Action");

// admin_forum_prune.php

define ("_AM_NEWBB_PRUNE_RESULTS_TITLE","Prune Results");
define ("_AM_NEWBB_PRUNE_RESULTS_TOPICS","Pruned Topics");
define ("_AM_NEWBB_PRUNE_RESULTS_POSTS","Pruned Posts");
define ("_AM_NEWBB_PRUNE_RESULTS_FORUMS","Pruned Forums");
define ("_AM_NEWBB_PRUNE_STORE","Store posts in this forum instead of deleting them");
define ("_AM_NEWBB_PRUNE_ARCHIVE","Make a copy of posts into Archive");
define ("_AM_NEWBB_PRUNE_FORUMSELERROR","You forgot to select forum(s) to prune");

define ("_AM_NEWBB_PRUNE_DAYS","Remove topics without replies in:");
define ("_AM_NEWBB_PRUNE_FORUMS","Forums to be pruned");
define ("_AM_NEWBB_PRUNE_STICKY","Keep Sticky topics");
define ("_AM_NEWBB_PRUNE_DIGEST","Keep Digest topics");
define ("_AM_NEWBB_PRUNE_LOCK","Keep Locked topics");
define ("_AM_NEWBB_PRUNE_HOT","Keep topics with more than this number of replies");
define ("_AM_NEWBB_PRUNE_SUBMIT","Ok");
define ("_AM_NEWBB_PRUNE_RESET","Reset");
define ("_AM_NEWBB_PRUNE_YES","Yes");
define ("_AM_NEWBB_PRUNE_NO","No");
define ("_AM_NEWBB_PRUNE_WEEK","A Week");
define ("_AM_NEWBB_PRUNE_2WEEKS","Two Weeks");
define ("_AM_NEWBB_PRUNE_MONTH","A Month");
define ("_AM_NEWBB_PRUNE_2MONTH","Two Months");
define ("_AM_NEWBB_PRUNE_4MONTH","Four Months");
define ("_AM_NEWBB_PRUNE_YEAR","A Year");
define ("_AM_NEWBB_PRUNE_2YEARS","2 Years");

// About.php constants
define('_AM_NEWBB_AUTHOR_INFO', "Author Informations");
define('_AM_NEWBB_AUTHOR_NAME', "Author");
define('_AM_NEWBB_AUTHOR_WEBSITE', "Author's website");
define('_AM_NEWBB_AUTHOR_EMAIL', "Author's email");
define('_AM_NEWBB_AUTHOR_CREDITS', "Credits");
define('_AM_NEWBB_MODULE_INFO', "Module Development Information");
define('_AM_NEWBB_MODULE_STATUS', "Status");
define('_AM_NEWBB_MODULE_DEMO', "Demo Site");
define('_AM_NEWBB_MODULE_SUPPORT', "Official support site");
define('_AM_NEWBB_MODULE_BUG', "Report a bug for this module");
define('_AM_NEWBB_MODULE_FEATURE', "Suggest a new feature for this module");
define('_AM_NEWBB_MODULE_DISCLAIMER', "Disclaimer");
define('_AM_NEWBB_AUTHOR_WORD', "The Author's Word");
define('_AM_NEWBB_BY','By');

// admin_report.php
define("_AM_NEWBB_REPORTADMIN","Reported posts manager");
define("_AM_NEWBB_PROCESSEDREPORT","View processed reports");
define("_AM_NEWBB_PROCESSREPORT","Process reports");
define("_AM_NEWBB_REPORTTITLE","Report title");
define("_AM_NEWBB_REPORTEXTRA","Extra");
define("_AM_NEWBB_REPORTPOST","Reported post");
define("_AM_NEWBB_REPORTTEXT","Report text");
define("_AM_NEWBB_REPORTMEMO","Process memo");

// admin_report.php
define("_AM_NEWBB_DIGESTADMIN","Digest manager");
define("_AM_NEWBB_DIGESTCONTENT","Digest content");

// admin_votedata.php
define("_AM_NEWBB_VOTE_RATINGINFOMATION", "Voting Information");
define("_AM_NEWBB_VOTE_TOTALVOTES", "Total votes: ");
define("_AM_NEWBB_VOTE_REGUSERVOTES", "Registered User Votes: %s");
define("_AM_NEWBB_VOTE_ANONUSERVOTES", "Anonymous User Votes: %s");
define("_AM_NEWBB_VOTE_USER", "User");
define("_AM_NEWBB_VOTE_IP", "IP Address");
define("_AM_NEWBB_VOTE_USERAVG", "Average User Rating");
define("_AM_NEWBB_VOTE_TOTALRATE", "Total Ratings");
define("_AM_NEWBB_VOTE_DATE", "Submitted");
define("_AM_NEWBB_VOTE_RATING", "Rating");
define("_AM_NEWBB_VOTE_NOREGVOTES", "No Registered User Votes");
define("_AM_NEWBB_VOTE_NOUNREGVOTES", "No Unregistered User Votes");
define("_AM_NEWBB_VOTEDELETED", "Vote data deleted.");
define("_AM_NEWBB_VOTE_ID", "ID");
define("_AM_NEWBB_VOTE_FILETITLE", "Thread Title");
define("_AM_NEWBB_VOTE_DISPLAYVOTES", "Voting Data Information");
define("_AM_NEWBB_VOTE_NOVOTES", "No User Votes to display");
define("_AM_NEWBB_VOTE_DELETE", "No User Votes to display");
define("_AM_NEWBB_VOTE_DELETEDSC", "<strong>Deletes</strong> the chosen vote information from the database.");


?>