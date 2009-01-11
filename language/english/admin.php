<?php
// $Id: admin.php,v 1.3 2005/10/19 17:20:33 phppp Exp $
//%%%%%%	File Name  index.php   	%%%%%
//$constpref = '_AM_' . strtoupper( basename( dirname(  dirname(  dirname( __FILE__ ) ) ) ) ) ;
$constpref = '_AM_IFORUM';
define($constpref."_FORUMCONF","Forum Configuration");
define($constpref."_ADDAFORUM","Add a Forum");
define($constpref."_SYNCFORUM","Sync forum");
define($constpref."_REORDERFORUM","Reorder");
define($constpref."_FORUM_MANAGER","Forums");
define($constpref."_PRUNE_TITLE","Prune");
define($constpref."_CATADMIN","Categories");
define($constpref."_GENERALSET", "Module Settings" );
define($constpref."_MODULEADMIN","Module Admin:");
define($constpref."_HELP","Help");
define($constpref."_ABOUT","About");
define($constpref."_BOARDSUMMARY","Board Statistic");
define($constpref."_PENDING_POSTS_FOR_AUTH","Posts pending authorization");
define($constpref."_POSTID","Post ID");
define($constpref."_POSTDATE","Post Date");
define($constpref."_POSTER","Poster");
define($constpref."_TOPICS","Topics");
define($constpref."_SHORTSUMMARY","Board Summary");
define($constpref."_TOTALPOSTS","Total Posts");
define($constpref."_TOTALTOPICS","Total Topics");
define($constpref."_TOTALVIEWS","Total Views");
define($constpref."_BLOCKS","Blocks");
define($constpref."_SUBJECT","Subject");
define($constpref."_APPROVE","Approve Post");
define($constpref."_APPROVETEXT","Content of this Posting");
define($constpref."_POSTAPPROVED","Post has been approved");
define($constpref."_POSTNOTAPPROVED","Post has NOT been approved");
define($constpref."_POSTSAVED","Post has been saved");
define($constpref."_POSTNOTSAVED","Post has NOT been saved");

define($constpref."_TOPICAPPROVED","Topic has been approved");
define($constpref."_TOPICNOTAPPROVED","Topic has been NOT approved");
define($constpref."_TOPICID","Topic ID");
define($constpref."_ORPHAN_TOPICS_FOR_AUTH","Unapproved topics authorization");


define($constpref.'_DEL_ONE','Delete only this message');
define($constpref.'_POSTSDELETED','Selected post deleted.');
define($constpref.'_NOAPPROVEPOST','There are presently no posts waiting approval.');
define($constpref.'_SUBJECTC','Subject:');
define($constpref.'_MESSAGEICON','Message Icon:');
define($constpref.'_MESSAGEC','Message:');
define($constpref.'_CANCELPOST','Cancel Post');
define($constpref.'_GOTOMOD','Go to module');

define($constpref.'_PREFERENCES','Module preferences');
define($constpref.'_POLLMODULE','Xoops Poll Module');
define($constpref.'_POLL_OK','Ready for use');
define($constpref.'_GDLIB1','GD1 library:');
define($constpref.'_GDLIB2','GD2 library:');
define($constpref.'_AUTODETECTED','Autodetected: ');
define($constpref.'_AVAILABLE','Available');
define($constpref.'_NOTAVAILABLE','<font color="red">Not available</font>');
define($constpref.'_NOTWRITABLE','<font color="red">Not writable</font>');
define($constpref.'_IMAGEMAGICK','ImageMagicK:');
define($constpref.'_IMAGEMAGICK_NOTSET','Not set');
define($constpref.'_ATTACHPATH','Path for attachment storing');
define($constpref.'_THUMBPATH','Path for attached image thumbs');
//define($constpref.'_RSSPATH','Path for RSS feed');
define($constpref.'_REPORT','Reported posts');
define($constpref.'_REPORT_PENDING','Pending report');
define($constpref.'_REPORT_PROCESSED','processed report');

define($constpref.'_CREATETHEDIR','Create it');
define($constpref.'_SETMPERM','Set the permission');
define($constpref.'_DIRCREATED','The directory has been created');
define($constpref.'_DIRNOTCREATED','The directory can not be created');
define($constpref.'_PERMSET','The permission has been set');
define($constpref.'_PERMNOTSET','The permission can not be set');

define($constpref.'_DIGEST','Digest notification');
define($constpref.'_DIGEST_PAST','<font color="red">Should be sent out %d minutes ago</font>');
define($constpref.'_DIGEST_NEXT','Need to send out in %d minutes');
define($constpref.'_DIGEST_ARCHIVE','Digest archive');
define($constpref.'_DIGEST_SENT','Digest processed');
define($constpref.'_DIGEST_FAILED','Digest NOT processed');

// admin_forum_manager.php
define($constpref."_NAME","Name");
define($constpref."_CREATEFORUM","Create Forum");
define($constpref."_EDIT","Edit");
define($constpref."_CLEAR","Clear");
define($constpref."_DELETE","Delete");
define($constpref."_ADD","Add");
define($constpref."_MOVE","Move");
define($constpref."_ORDER","Order");
define($constpref."_TWDAFAP","Note: This will remove the forum and all posts in it.<br /><br />WARNING: Are you sure you want to delete this Forum?");
define($constpref."_FORUMREMOVED","Forum Removed.");
define($constpref."_CREATENEWFORUM","Create a New Forum");
define($constpref."_EDITTHISFORUM","Editing Forum:");
define($constpref."_SET_FORUMORDER","Set Forum Position:");
define($constpref."_ALLOWPOLLS","Allow Polls:");
define($constpref."_ATTACHMENT_SIZE" ,"Max Size in kb`s:");
define($constpref."_ALLOWED_EXTENSIONS", "Allowed Extensions:<span style='font-size: xx-small; font-weight: normal; display: block;'>'*' indicates no limititations.<br /> Extensions delimited by '|'</span>");
//define($constpref."_ALLOW_ATTACHMENTS", "Allow Attachments:");
define($constpref."_ALLOWHTML","Allow HTML:");
define($constpref."_YES","Yes");
define($constpref."_NO","No");
define($constpref."_ALLOWSIGNATURES","Allow Signatures:");
define($constpref."_HOTTOPICTHRESHOLD","Hot Topic Threshold:");
//define($constpref."_POSTPERPAGE","Posts per Page:<span style='font-size: xx-small; font-weight: normal; display: block;'>(This is the number of posts<br /> per topic that will be<br /> displayed per page.)</span>");
//define($constpref."_TOPICPERFORUM","Topics per Forum:<span style='font-size: xx-small; font-weight: normal; display: block;'>(This is the number of topics<br /> per forum that will be<br /> displayed per page.)</span>");
//define($constpref."_SHOWNAME","Replace user's name with real name:");
//define($constpref."_SHOWICONSPANEL","Show icons panel:");
//define($constpref."_SHOWSMILIESPANEL","Show smilies panel:");
define($constpref."_MODERATOR_REMOVE","Remove current moderators");
define($constpref."_MODERATOR_ADD","Add moderators");
define($constpref."_ALLOW_SUBJECT_PREFIX", "Allow Subject Prefix for the Topics");
define($constpref."_ALLOW_SUBJECT_PREFIX_DESC", "This allows a Prefix, which will be added to the Topic Subject");


// admin_cat_manager.php

define($constpref."_SETCATEGORYORDER","Set Category Position:");
define($constpref."_ACTIVE","Active");
define($constpref."_INACTIVE","Inactive");
define($constpref."_STATE","Status:");
define($constpref."_CATEGORYDESC","Category Description:");
define($constpref."_SHOWDESC","Show Description?");
define($constpref."_IMAGE","Image:");
//define($constpref."_SPONSORIMAGE","Sponsor Image:");
define($constpref."_SPONSORLINK","Sponsor Link:");
define($constpref."_DELCAT","Delete Category");
define($constpref."_WAYSYWTDTTAL","Note: This will NOT remove the forums under the category, you must do that via the Edit Forum section.<br /><br />WARNING: Are you sure you want to delete this Category?");



//%%%%%%        File Name  admin_forums.php           %%%%%
define($constpref."_FORUMNAME","Forum Name:");
define($constpref."_FORUMDESCRIPTION","Forum Description:");
define($constpref."_MODERATOR","Moderator(s):");
define($constpref."_REMOVE","Remove");
define($constpref."_CATEGORY","Category:");
define($constpref."_DATABASEERROR","Database Error");
define($constpref."_CATEGORYUPDATED","Category Updated.");
define($constpref."_EDITCATEGORY","Editing Category:");
define($constpref."_CATEGORYTITLE","Category Title:");
define($constpref."_CATEGORYCREATED","Category Created.");
define($constpref."_CREATENEWCATEGORY","Create a New Category");
define($constpref."_FORUMCREATED","Forum Created.");
define($constpref."_ACCESSLEVEL","Global Access Level:");
define($constpref."_CATEGORY1","Category");
define($constpref."_FORUMUPDATE","Forum Settings Updated");
define($constpref."_FORUM_ERROR","ERROR: Forum Setting Error");
define($constpref."_CLICKBELOWSYNC","Clicking the button below will sync up your forums and topics pages with the correct data from the database. Use this section whenever you notice flaws in the topics and forums lists.");
define($constpref."_SYNCHING","Synchronizing forum index and topics (This may take a while)");
define($constpref."_CATEGORYDELETED","Category deleted.");
define($constpref."_MOVE2CAT","Move to category:");
define($constpref."_MAKE_SUBFORUM_OF","Make a sub forum of:");
define($constpref."_MSG_FORUM_MOVED","Forum moved!");
define($constpref."_MSG_ERR_FORUM_MOVED","Failed to move forum.");
define($constpref."_SELECT","< Select >");
define($constpref."_MOVETHISFORUM","Move this Forum");
define($constpref."_MERGE","Merge");
define($constpref."_MERGETHISFORUM","Merge this Forum");
define($constpref."_MERGETO_FORUM","Merge this forum to:");
define($constpref."_MSG_FORUM_MERGED","Forum merged!");
define($constpref."_MSG_ERR_FORUM_MERGED","Failed to merge forum.");

//%%%%%%        File Name  admin_forum_reorder.php           %%%%%
define($constpref."_REORDERID","ID");
define($constpref."_REORDERTITLE","Title");
define($constpref."_REORDERWEIGHT","Position");
define($constpref."_SETFORUMORDER","Set Board Ordering");
define($constpref."_BOARDREORDER","The Board has reordered to your specification");

// admin_permission.php
define($constpref."_PERMISSIONS_TO_THIS_FORUM","Topic permissions for this Forum");
define($constpref."_CAT_ACCESS","Category access");
define($constpref."_CAN_ACCESS","Can access");
define($constpref."_CAN_VIEW","Can View");
define($constpref."_CAN_POST","Can start new topics");
define($constpref."_CAN_REPLY","Can Reply");
define($constpref."_CAN_EDIT","Can Edit");
define($constpref."_CAN_DELETE","Can Delete");
define($constpref."_CAN_ADDPOLL","Can Add Poll");
define($constpref."_CAN_VOTE","Can Vote");
define($constpref."_CAN_ATTACH","Can Attach");
define($constpref."_CAN_NOAPPROVE","Can Post without Approval");
define($constpref."_ACTION","Action");

define($constpref."_PERM_TEMPLATE","Set default permission template");
define($constpref."_PERM_TEMPLATE_DESC","Edit the following permission template so that it can be applied to a forum or a couple of forums");
define($constpref."_PERM_FORUMS","Select forums");
define($constpref."_PERM_TEMPLATE_CREATED","Permission template has been created");
define($constpref."_PERM_TEMPLATE_ERROR","Error occurs during permission template creation");
define($constpref."_PERM_TEMPLATEAPP","Apply default permission");
define($constpref."_PERM_TEMPLATE_APPLIED","Default permissions have been applied to forums");
define($constpref."_PERM_ACTION","Permission management tools");
define($constpref."_PERM_SETBYGROUP","Set permissions directly by group");
define($constpref."_PERM_PERMISSIONS", "Permissions");

// admin_forum_prune.php

define($constpref."_PRUNE_RESULTS_TITLE","Prune Results");
define($constpref."_PRUNE_RESULTS_TOPICS","Pruned Topics");
define($constpref."_PRUNE_RESULTS_POSTS","Pruned Posts");
define($constpref."_PRUNE_RESULTS_FORUMS","Pruned Forums");
define($constpref."_PRUNE_STORE","Store posts in this forum instead of deleting them");
define($constpref."_PRUNE_ARCHIVE","Make a copy of posts into Archive");
define($constpref."_PRUNE_FORUMSELERROR","You forgot to select forum(s) to prune");

define($constpref."_PRUNE_DAYS","Remove topics without replies in:");
define($constpref."_PRUNE_FORUMS","Forums to be pruned");
define($constpref."_PRUNE_STICKY","Keep Sticky topics");
define($constpref."_PRUNE_DIGEST","Keep Digest topics");
define($constpref."_PRUNE_LOCK","Keep Locked topics");
define($constpref."_PRUNE_HOT","Keep topics with more than this number of replies");
define($constpref."_PRUNE_SUBMIT","Ok");
define($constpref."_PRUNE_RESET","Reset");
define($constpref."_PRUNE_YES","Yes");
define($constpref."_PRUNE_NO","No");
define($constpref."_PRUNE_WEEK","A Week");
define($constpref."_PRUNE_2WEEKS","Two Weeks");
define($constpref."_PRUNE_MONTH","A Month");
define($constpref."_PRUNE_2MONTH","Two Months");
define($constpref."_PRUNE_4MONTH","Four Months");
define($constpref."_PRUNE_YEAR","A Year");
define($constpref."_PRUNE_2YEARS","2 Years");

// About.php constants
define($constpref.'_AUTHOR_INFO', "Author Informations");
define($constpref.'_AUTHOR_NAME', "Author");
define($constpref.'_AUTHOR_WEBSITE', "Author's website");
define($constpref.'_AUTHOR_EMAIL', "Author's email");
define($constpref.'_AUTHOR_CREDITS', "Credits");
define($constpref.'_MODULE_INFO', "Module Development Information");
define($constpref.'_MODULE_STATUS', "Status");
define($constpref.'_MODULE_DEMO', "Demo Site");
define($constpref.'_MODULE_SUPPORT', "Official support site");
define($constpref.'_MODULE_BUG', "Report a bug for this module");
define($constpref.'_MODULE_FEATURE', "Suggest a new feature for this module");
define($constpref.'_MODULE_DISCLAIMER', "Disclaimer");
define($constpref.'_AUTHOR_WORD', "The Author's Word");
define($constpref.'_BY','By');
define($constpref.'_AUTHOR_WORD_EXTRA', "
");

// admin_report.php
define($constpref."_REPORTADMIN","Reported posts manager");
define($constpref."_PROCESSEDREPORT","View processed reports");
define($constpref."_PROCESSREPORT","Process reports");
define($constpref."_REPORTTITLE","Report title");
define($constpref."_REPORTEXTRA","Extra");
define($constpref."_REPORTPOST","Reported post");
define($constpref."_REPORTTEXT","Report text");
define($constpref."_REPORTMEMO","Process memo");

// admin_report.php
define($constpref."_DIGESTADMIN","Digest manager");
define($constpref."_DIGESTCONTENT","Digest content");

// admin_votedata.php
define($constpref."_VOTE_RATINGINFOMATION", "Voting Information");
define($constpref."_VOTE_TOTALVOTES", "Total votes: ");
define($constpref."_VOTE_REGUSERVOTES", "Registered User Votes: %s");
define($constpref."_VOTE_ANONUSERVOTES", "Anonymous User Votes: %s");
define($constpref."_VOTE_USER", "User");
define($constpref."_VOTE_IP", "IP Address");
define($constpref."_VOTE_USERAVG", "Average User Rating");
define($constpref."_VOTE_TOTALRATE", "Total Ratings");
define($constpref."_VOTE_DATE", "Submitted");
define($constpref."_VOTE_RATING", "Rating");
define($constpref."_VOTE_NOREGVOTES", "No Registered User Votes");
define($constpref."_VOTE_NOUNREGVOTES", "No Unregistered User Votes");
define($constpref."_VOTEDELETED", "Vote data deleted.");
define($constpref."_VOTE_ID", "ID");
define($constpref."_VOTE_FILETITLE", "Thread Title");
define($constpref."_VOTE_DISPLAYVOTES", "Voting Data Information");
define($constpref."_VOTE_NOVOTES", "No User Votes to display");
define($constpref."_VOTE_DELETE", "No User Votes to display");
define($constpref."_VOTE_DELETEDSC", "<strong>Deletes</strong> the chosen vote information from the database.");
?>