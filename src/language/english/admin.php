<?php
$constpref = '_AM_IFORUM';

	define("_AM_IFORUM_FORUMCONF", "Forum Configuration");
	define("_AM_IFORUM_ADDAFORUM", "Add a Forum");
	define("_AM_IFORUM_SYNCFORUM", "Sync forum");
	define("_AM_IFORUM_REORDERFORUM", "Reorder");
	define("_AM_IFORUM_FORUM_MANAGER", "Forums");
	define("_AM_IFORUM_PRUNE_TITLE", "Prune");
	define("_AM_IFORUM_CATADMIN", "Categories");
	define("_AM_IFORUM_GENERALSET", "Preferences" );
	define("_AM_IFORUM_MODULEADMIN", "Module Admin:");
	define("_AM_IFORUM_HELP", "Help");
	define("_AM_IFORUM_ABOUT", "About");
	define("_AM_IFORUM_BOARDSUMMARY", "Board Statistic");
	define("_AM_IFORUM_PENDING_POSTS_FOR_AUTH", "Posts pending authorization");
	define("_AM_IFORUM_POSTID", "Post ID");
	define("_AM_IFORUM_POSTDATE", "Post Date");
	define("_AM_IFORUM_POSTER", "Poster");
	define("_AM_IFORUM_TOPICS", "Topics");
	define("_AM_IFORUM_SHORTSUMMARY", "Board Summary");
	define("_AM_IFORUM_TOTALPOSTS", "Total Posts");
	define("_AM_IFORUM_TOTALTOPICS", "Total Topics");
	define("_AM_IFORUM_TOTALVIEWS", "Total Views");
	define("_AM_IFORUM_BLOCKS", "Blocks");
	define("_AM_IFORUM_SUBJECT", "Subject");
	define("_AM_IFORUM_APPROVE", "Approve Post");
	define("_AM_IFORUM_APPROVETEXT", "Content of this Posting");
	define("_AM_IFORUM_POSTAPPROVED", "Post has been approved");
	define("_AM_IFORUM_POSTNOTAPPROVED", "Post has NOT been approved");
	define("_AM_IFORUM_POSTSAVED", "Post has been saved");
	define("_AM_IFORUM_POSTNOTSAVED", "Post has NOT been saved");

	define("_AM_IFORUM_TOPICAPPROVED", "Topic has been approved");
	define("_AM_IFORUM_TOPICNOTAPPROVED", "Topic has been NOT approved");
	define("_AM_IFORUM_TOPICID", "Topic ID");
	define("_AM_IFORUM_ORPHAN_TOPICS_FOR_AUTH", "Unapproved topics authorization");

	define($constpref.'_DEL_ONE', 'Delete only this message');
	define($constpref.'_POSTSDELETED', 'Selected post deleted.');
	define($constpref.'_NOAPPROVEPOST', 'There are presently no posts waiting approval.');
	define($constpref.'_SUBJECTC', 'Subject:');
	define($constpref.'_MESSAGEICON', 'Message Icon:');
	define($constpref.'_MESSAGEC', 'Message:');
	define($constpref.'_CANCELPOST', 'Cancel Post');
	define($constpref.'_GOTOMOD', 'Go to module');

	define($constpref.'_PREFERENCES', 'Module preferences');
	define($constpref.'_POLLMODULE', 'Poll Module');
	define($constpref.'_POLL_OK', 'Ready for use');
	define($constpref.'_GDLIB1', 'GD1 library:');
	define($constpref.'_GDLIB2', 'GD2 library:');
	define($constpref.'_AUTODETECTED', 'Autodetected: ');
	define($constpref.'_AVAILABLE', 'Available');
	define($constpref.'_NOTAVAILABLE', '<span style="color: red; ">Not available</span>');
	define($constpref.'_NOTWRITABLE', '<span style="color: red; ">Not writable</span>');
	define($constpref.'_IMAGEMAGICK', 'ImageMagicK:');
	define($constpref.'_IMAGEMAGICK_NOTSET', 'Not set');
	define($constpref.'_ATTACHPATH', 'Path for attachment storing');
	define($constpref.'_THUMBPATH', 'Path for attached image thumbs');
	//define($constpref.'_RSSPATH','Path for RSS feed');
	define($constpref.'_REPORT', 'Reported posts');
	define($constpref.'_REPORT_PENDING', 'Pending report');
	define($constpref.'_REPORT_PROCESSED', 'processed report');

	define($constpref.'_CREATETHEDIR', 'Create it');
	define($constpref.'_SETMPERM', 'Set the permission');
	define($constpref.'_DIRCREATED', 'The directory has been created');
	define($constpref.'_DIRNOTCREATED', 'The directory can not be created');
	define($constpref.'_PERMSET', 'The permission has been set');
	define($constpref.'_PERMNOTSET', 'The permission can not be set');

	define($constpref.'_DIGEST', 'Digest notification');
	define($constpref.'_DIGEST_PAST', '<span style="color: red; ">Should be sent out %d minutes ago</span>');
	define($constpref.'_DIGEST_NEXT', 'Need to send out in %d minutes');
	define($constpref.'_DIGEST_ARCHIVE', 'Digest archive');
	define($constpref.'_DIGEST_SENT', 'Digest processed');
	define($constpref.'_DIGEST_FAILED', 'Digest NOT processed');

	// admin_forum_manager.php
	define("_AM_IFORUM_NAME", "Name");
	define("_AM_IFORUM_CREATEFORUM", "Create Forum");
	define("_AM_IFORUM_EDIT", "Edit");
	define("_AM_IFORUM_CLEAR", "Clear");
	define("_AM_IFORUM_DELETE", "Delete");
	define("_AM_IFORUM_ADD", "Add");
	define("_AM_IFORUM_MOVE", "Move");
	define("_AM_IFORUM_ORDER", "Order");
	define("_AM_IFORUM_TWDAFAP", "Note: This will remove the forum and all posts in it.<br /><br />WARNING: Are you sure you want to delete this Forum?");
	define("_AM_IFORUM_FORUMREMOVED", "Forum Removed.");
	define("_AM_IFORUM_CREATENEWFORUM", "Create a New Forum");
	define("_AM_IFORUM_EDITTHISFORUM", "Editing Forum:");
	define("_AM_IFORUM_SET_FORUMORDER", "Set Forum Position:");
	define("_AM_IFORUM_ALLOWPOLLS", "Allow Polls:");
	define("_AM_IFORUM_ATTACHMENT_SIZE" , "Max Size in kb`s:");
	define("_AM_IFORUM_ALLOWED_EXTENSIONS", "Allowed Extensions:<span style='font-size: xx-small; font-weight: normal; display: block;'>'*' indicates no limititations.<br /> Extensions delimited by '|'</span>");
	define("_AM_IFORUM_ALLOW_ATTACHMENTS", "Allow Attachments:");
	define("_AM_IFORUM_ALLOWHTML", "Allow HTML:");
	define("_AM_IFORUM_YES", "Yes");
	define("_AM_IFORUM_NO", "No");
	define("_AM_IFORUM_ALLOWSIGNATURES", "Allow Signatures:");
	define("_AM_IFORUM_HOTTOPICTHRESHOLD", "Hot Topic Threshold:");
	define("_AM_IFORUM_POSTPERPAGE","Posts per Page:<span style='font-size: xx-small; font-weight: normal; display: block;'>(This is the number of posts<br /> per topic that will be<br /> displayed per page.)</span>");
	define("_AM_IFORUM_TOPICPERFORUM","Topics per Forum:<span style='font-size: xx-small; font-weight: normal; display: block;'>(This is the number of topics<br /> per forum that will be<br /> displayed per page.)</span>");
	define("_AM_IFORUM_SHOWNAME","Replace user's name with real name:");
	define("_AM_IFORUM_SHOWICONSPANEL","Show icons panel:");
	define("_AM_IFORUM_SHOWSMILIESPANEL","Show smilies panel:");
	define("_AM_IFORUM_MODERATOR_REMOVE", "Remove current moderators");
	define("_AM_IFORUM_MODERATOR_ADD", "Add moderators");
	define("_AM_IFORUM_ALLOW_SUBJECT_PREFIX", "Allow Subject Prefix for the Topics");
	define("_AM_IFORUM_ALLOW_SUBJECT_PREFIX_DESC", "This allows a Prefix, which will be added to the Topic Subject");


	// admin_cat_manager.php

	define("_AM_IFORUM_SETCATEGORYORDER", "Set Category Position:");
	define("_AM_IFORUM_ACTIVE", "Active");
	define("_AM_IFORUM_INACTIVE", "Inactive");
	define("_AM_IFORUM_STATE", "Status:");
	define("_AM_IFORUM_CATEGORYDESC", "Category Description:");
	define("_AM_IFORUM_SHOWDESC", "Show Description?");
	define("_AM_IFORUM_IMAGE", "Image:");
	define("_AM_IFORUM_SPONSORIMAGE","Sponsor Image:");
	define("_AM_IFORUM_SPONSORLINK", "Sponsor Link:");
	define("_AM_IFORUM_DELCAT", "Delete Category");
	define("_AM_IFORUM_WAYSYWTDTTAL", "Note: This will NOT remove the forums under the category, you must do that via the Edit Forum section.<br /><br />WARNING: Are you sure you want to delete this Category?");



	//%%%%%%        File Name  admin_forums.php           %%%%%
	define("_AM_IFORUM_FORUMNAME", "Forum Name:");
	define("_AM_IFORUM_FORUMDESCRIPTION", "Forum Description:");
	define("_AM_IFORUM_MODERATOR", "Moderator(s):");
	define("_AM_IFORUM_REMOVE", "Remove");
	define("_AM_IFORUM_CATEGORY", "Category:");
	define("_AM_IFORUM_DATABASEERROR", "Database Error");
	define("_AM_IFORUM_CATEGORYUPDATED", "Category Updated.");
	define("_AM_IFORUM_EDITCATEGORY", "Editing Category:");
	define("_AM_IFORUM_CATEGORYTITLE", "Category Title:");
	define("_AM_IFORUM_CATEGORYCREATED", "Category Created.");
	define("_AM_IFORUM_CREATENEWCATEGORY", "Create a New Category");
	define("_AM_IFORUM_FORUMCREATED", "Forum Created.");
	define("_AM_IFORUM_ACCESSLEVEL", "Global Access Level:");
	define("_AM_IFORUM_CATEGORY1", "Category");
	define("_AM_IFORUM_FORUMUPDATE", "Forum Settings Updated");
	define("_AM_IFORUM_FORUM_ERROR", "ERROR: Forum Setting Error");
	define("_AM_IFORUM_CLICKBELOWSYNC", "Clicking the button below will sync up your forums and topics pages with the correct data from the database. Use this section whenever you notice flaws in the topics and forums lists.");
	define("_AM_IFORUM_SYNCHING", "Synchronizing forum index and topics (This may take a while)");
	define("_AM_IFORUM_CATEGORYDELETED", "Category deleted.");
	define("_AM_IFORUM_MOVE2CAT", "Move to category:");
	define("_AM_IFORUM_MAKE_SUBFORUM_OF", "Make a sub forum of:");
	define("_AM_IFORUM_MSG_FORUM_MOVED", "Forum moved!");
	define("_AM_IFORUM_MSG_ERR_FORUM_MOVED", "Failed to move forum.");
	define("_AM_IFORUM_SELECT", "< Select >");
	define("_AM_IFORUM_MOVETHISFORUM", "Move this Forum");
	define("_AM_IFORUM_MERGE", "Merge");
	define("_AM_IFORUM_MERGETHISFORUM", "Merge this Forum");
	define("_AM_IFORUM_MERGETO_FORUM", "Merge this forum to:");
	define("_AM_IFORUM_MSG_FORUM_MERGED", "Forum merged!");
	define("_AM_IFORUM_MSG_ERR_FORUM_MERGED", "Failed to merge forum.");

	//%%%%%%        File Name  admin_forum_reorder.php           %%%%%
	define("_AM_IFORUM_REORDERID", "ID");
	define("_AM_IFORUM_REORDERTITLE", "Title");
	define("_AM_IFORUM_REORDERWEIGHT", "Position");
	define("_AM_IFORUM_SETFORUMORDER", "Set Board Ordering");
	define("_AM_IFORUM_BOARDREORDER", "The Board has reordered to your specification");

	// admin_permission.php
	define("_AM_IFORUM_PERMISSIONS_TO_THIS_FORUM", "Topic permissions for this Forum");
	define("_AM_IFORUM_CAT_ACCESS", "Category access");
	define("_AM_IFORUM_CAN_ACCESS", "Can access");
	define("_AM_IFORUM_CAN_VIEW", "Can View");
	define("_AM_IFORUM_CAN_POST", "Can start new topics");
	define("_AM_IFORUM_CAN_REPLY", "Can Reply");
	define("_AM_IFORUM_CAN_EDIT", "Can Edit");
	define("_AM_IFORUM_CAN_DELETE", "Can Delete");
	define("_AM_IFORUM_CAN_ADDPOLL", "Can Add Poll");
	define("_AM_IFORUM_CAN_VOTE", "Can Vote");
	define("_AM_IFORUM_CAN_ATTACH", "Can Attach");
	define("_AM_IFORUM_CAN_NOAPPROVE", "Can Post without Approval");
	define("_AM_IFORUM_ACTION", "Action");

	define("_AM_IFORUM_PERM_TEMPLATE", "Set default permission template");
	define("_AM_IFORUM_PERM_TEMPLATE_DESC", "Edit the following permission template so that it can be applied to a forum or a couple of forums");
	define("_AM_IFORUM_PERM_FORUMS", "Select forums");
	define("_AM_IFORUM_PERM_TEMPLATE_CREATED", "Permission template has been created");
	define("_AM_IFORUM_PERM_TEMPLATE_ERROR", "Error occurs during permission template creation");
	define("_AM_IFORUM_PERM_TEMPLATEAPP", "Apply default permission");
	define("_AM_IFORUM_PERM_TEMPLATE_APPLIED", "Default permissions have been applied to forums");
	define("_AM_IFORUM_PERM_ACTION", "Permission management tools");
	define("_AM_IFORUM_PERM_SETBYGROUP", "Set permissions directly by group");
	define("_AM_IFORUM_PERM_PERMISSIONS", "Permissions");

	// admin_forum_prune.php

	define("_AM_IFORUM_PRUNE_RESULTS_TITLE", "Prune Results");
	define("_AM_IFORUM_PRUNE_RESULTS_TOPICS", "Pruned Topics");
	define("_AM_IFORUM_PRUNE_RESULTS_POSTS", "Pruned Posts");
	define("_AM_IFORUM_PRUNE_RESULTS_FORUMS", "Pruned Forums");
	define("_AM_IFORUM_PRUNE_STORE", "Store posts in this forum instead of deleting them");
	define("_AM_IFORUM_PRUNE_ARCHIVE", "Make a copy of posts into Archive");
	define("_AM_IFORUM_PRUNE_FORUMSELERROR", "You forgot to select forum(s) to prune");

	define("_AM_IFORUM_PRUNE_DAYS", "Remove topics without replies in:");
	define("_AM_IFORUM_PRUNE_FORUMS", "Forums to be pruned");
	define("_AM_IFORUM_PRUNE_STICKY", "Keep Sticky topics");
	define("_AM_IFORUM_PRUNE_DIGEST", "Keep Digest topics");
	define("_AM_IFORUM_PRUNE_LOCK", "Keep Locked topics");
	define("_AM_IFORUM_PRUNE_HOT", "Keep topics with more than this number of replies");
	define("_AM_IFORUM_PRUNE_SUBMIT", "Ok");
	define("_AM_IFORUM_PRUNE_RESET", "Reset");
	define("_AM_IFORUM_PRUNE_YES", "Yes");
	define("_AM_IFORUM_PRUNE_NO", "No");
	define("_AM_IFORUM_PRUNE_WEEK", "A Week");
	define("_AM_IFORUM_PRUNE_2WEEKS", "Two Weeks");
	define("_AM_IFORUM_PRUNE_MONTH", "A Month");
	define("_AM_IFORUM_PRUNE_2MONTH", "Two Months");
	define("_AM_IFORUM_PRUNE_4MONTH", "Four Months");
	define("_AM_IFORUM_PRUNE_YEAR", "A Year");
	define("_AM_IFORUM_PRUNE_2YEARS", "2 Years");

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
	define($constpref.'_BY', 'By');
	define($constpref.'_AUTHOR_WORD_EXTRA', "		");

	// admin_report.php
	define("_AM_IFORUM_REPORTADMIN", "Reported posts manager");
	define("_AM_IFORUM_PROCESSEDREPORT", "View processed reports");
	define("_AM_IFORUM_PROCESSREPORT", "Process reports");
	define("_AM_IFORUM_REPORTTITLE", "Report title");
	define("_AM_IFORUM_REPORTEXTRA", "Extra");
	define("_AM_IFORUM_REPORTPOST", "Reported post");
	define("_AM_IFORUM_REPORTTEXT", "Report text");
	define("_AM_IFORUM_REPORTMEMO", "Process memo");

	// admin_report.php
	define("_AM_IFORUM_DIGESTADMIN", "Digest manager");
	define("_AM_IFORUM_DIGESTCONTENT", "Digest content");

	// admin_votedata.php
	define("_AM_IFORUM_VOTE_RATINGINFOMATION", "Voting Information");
	define("_AM_IFORUM_VOTE_TOTALVOTES", "Total votes: ");
	define("_AM_IFORUM_VOTE_REGUSERVOTES", "Registered User Votes: %s");
	define("_AM_IFORUM_VOTE_ANONUSERVOTES", "Anonymous User Votes: %s");
	define("_AM_IFORUM_VOTE_USER", "User");
	define("_AM_IFORUM_VOTE_IP", "IP Address");
	define("_AM_IFORUM_VOTE_USERAVG", "Average User Rating");
	define("_AM_IFORUM_VOTE_TOTALRATE", "Total Ratings");
	define("_AM_IFORUM_VOTE_DATE", "Submitted");
	define("_AM_IFORUM_VOTE_RATING", "Rating");
	define("_AM_IFORUM_VOTE_NOREGVOTES", "No Registered User Votes");
	define("_AM_IFORUM_VOTE_NOUNREGVOTES", "No Unregistered User Votes");
	define("_AM_IFORUM_VOTEDELETED", "Vote data deleted.");
	define("_AM_IFORUM_VOTE_ID", "ID");
	define("_AM_IFORUM_VOTE_FILETITLE", "Thread Title");
	define("_AM_IFORUM_VOTE_DISPLAYVOTES", "Voting Data Information");
	define("_AM_IFORUM_VOTE_NOVOTES", "No User Votes to display");
	define("_AM_IFORUM_VOTE_DELETE", "No User Votes to display");
	define("_AM_IFORUM_VOTE_DELETEDSC", "<strong>Deletes</strong> the chosen vote information from the database.");
