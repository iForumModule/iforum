<?php
	// $Id$
	// Thanks Tom (http://www.wf-projects.com), for correcting the Engligh language package

	// Module Info
	//$constpref = '_MI_' . strtoupper( basename( dirname(  dirname(  dirname( __FILE__ ) ) ) ) ) ;
	$constpref = '_MI_IFORUM';

	// The name of this module
	define($constpref."_NAME", "iForum");

	// A brief description of this module
	define($constpref."_DESC", "Community Bulletin Board");

	// Names of blocks for this module (Not all module has blocks)
	define($constpref."_BLOCK_TOPIC_POST", "Recent Replied Topics");
	define($constpref."_BLOCK_TOPIC", "Recent Topics");
	define($constpref."_BLOCK_POST", "Recent Posts");
	define($constpref."_BLOCK_AUTHOR", "Authors");
	define($constpref."_BLOCK_TAG_CLOUD", "Tag Cloud");
	define($constpref."_BLOCK_TAG_TOP", "Top Tags");
	/*
	define($constpref."_BNAME2","Most Viewed Topics");
	define($constpref."_BNAME3","Most Active Topics");
	define($constpref."_BNAME4","Newest Digest");
	define($constpref."_BNAME5","Newest Sticky Topics");
	define($constpref."_BNAME6","Newest Posts");
	define($constpref."_BNAME7","Authors with most topics");
	define($constpref."_BNAME8","Authors with most posts");
	define($constpref."_BNAME9","Authors with most digests");
	define($constpref."_BNAME10","Authors with most sticky topics");
	define($constpref."_BNAME11","Recent post with text");
	*/

	// Names of admin menu items
	define($constpref."_ADMENU_INDEX", "Index");
	define($constpref."_ADMENU_CATEGORY", "Categories");
	define($constpref."_ADMENU_FORUM", "Forums");
	define($constpref."_ADMENU_PERMISSION", "Permissions");
	define($constpref."_ADMENU_BLOCK", "Blocks");
	define($constpref."_ADMENU_ORDER", "Order");
	define($constpref."_ADMENU_SYNC", "Sync forums");
	define($constpref."_ADMENU_PRUNE", "Prune");
	define($constpref."_ADMENU_REPORT", "Reports");
	define($constpref."_ADMENU_DIGEST", "Digest");
	define($constpref."_ADMENU_VOTE", "Votes");



	//config options

	define("_MI_DO_DEBUG", "Debug Mode");
	define("_MI_DO_DEBUG_DESC", "Dislay error message");

	define("_MI_IMG_SET", "Image Set");
	define("_MI_IMG_SET_DESC", "Select the Image Set to use");

	define("_MI_THEMESET", "Theme set");
	define("_MI_THEMESET_DESC", "Module-wide, select '"._NONE."' will use site-wide theme");

	define("_MI_DIR_ATTACHMENT", "Attachments physical path.");
	define("_MI_DIR_ATTACHMENT_DESC", "Physical path only needs to be set from your ImpressCMS root and not before, for example you may have attachments uploaded to www.yoururl.com/uploads/iforum the path entered would then be '/uploads/iforum' never include a trailing slash '/' the thumbnails path becomes '/uploads/iforum/thumbs'");
	define("_MI_PATH_MAGICK", "Path for ImageMagick");
	define("_MI_PATH_MAGICK_DESC", "Usually it is '/usr/bin/X11'. Leave it BLANK if you do not have ImageMagicK installed or for autodetecting.");

	define("_MI_SUBFORUM_DISPLAY", "Display Mode of subforums on index page");
	define("_MI_SUBFORUM_DISPLAY_DESC", "");
	define("_MI_SUBFORUM_EXPAND", "Expand");
	define("_MI_SUBFORUM_COLLAPSE", "Collapse");
	define("_MI_SUBFORUM_HIDDEN", "Hidden");

	define("_MI_POST_EXCERPT", "Post excerpt on forum page");
	define("_MI_POST_EXCERPT_DESC", "Length of post excerpt by mouse over. 0 for no excerpt.");

	define("_MI_PATH_NETPBM", "Path for Netpbm");
	define("_MI_PATH_NETPBM_DESC", "Usually it is '/usr/bin'. Leave it BLANK if you do not have Netpbm installed or  for autodetecting.");

	define("_MI_IMAGELIB", "Select the Image library to use");
	define("_MI_IMAGELIB_DESC", "Select which Image library to use for creating Thumbnails. Leave AUTO for automatically choice.");

	define("_MI_MAX_IMG_WIDTH", "Maximum Image Width");
	define("_MI_MAX_IMG_WIDTH_DESC", "Sets the maximum allowed <strong>Width</strong> size of an uploaded image otherwise thumbnail will be used. <br >Input 0 if you do not want to create thumbnails.");

	define("_MI_MAX_IMAGE_WIDTH", "Maximum Image Width for creating thumbnail");
	define("_MI_MAX_IMAGE_WIDTH_DESC", "Sets the maximum width of an uploaded image to create thumbnail. <br >Image with width larger than the value will not use thumbnail.");

	define("_MI_MAX_IMAGE_HEIGHT", "Maximum Image Height for creating thumbnail");
	define("_MI_MAX_IMAGE_HEIGHT_DESC", "Sets the maximum height of an uploaded image to create thumbnail. <br >Image with height larger than the value will not use thumbnail.");

	define("_MI_SHOW_DIS", "Show Disclaimer On");
	define("_MI_DISCLAIMER", "Disclaimer");
	define("_MI_DISCLAIMER_DESC", "Enter your Disclaimer that will be shown to the above selected option.");
	define("_MI_DISCLAIMER_TEXT", "The forum contains a lot of posts with a lot of usefull information. <br /><br />In order to keep the number of double-posts to a minimum, we would like to ask you to use the forum search before posting your questions here.");
	define("_MI_NONE", "None");
	define("_MI_POST", "Post");
	define("_MI_REPLY", "Reply");
	define("_MI_OP_BOTH", "Both");
	define("_MI_WOL_ENABLE", "Enable Who's Online");
	define("_MI_WOL_ENABLE_DESC", "Enable Who's Online Block shown below the Index page and the Forum pages");
	//define("_MI_WOL_ADMIN_COL","Administrator Highlight Color");
	//define("_MI_WOL_ADMIN_COL_DESC","Highlight Color of the Administrators shown in the Who's Online Block");
	//define("_MI_WOL_MOD_COL","Moderator Highlight Color");
	//define("_MI_WOL_MOD_COL_DESC","Highlight Color of the Moderators shown in the Who's Online Block");
	//define("_MI_LEVELS_ENABLE", "Enable HP/MP/EXP Levels Mod");
	//define("_MI_LEVELS_ENABLE_DESC", "<strong>HP</strong>  is determined by your average posts per day.<br /><strong>MP</strong>  is determined by your join date related to your post count.<br /><strong>EXP</strong> goes up each time you post, and when you get to 100%, you gain a level and the EXP drops to 0 again.");
	define("_MI_NULL", "disable");
	define("_MI_TEXT", "text");
	define("_MI_GRAPHIC", "graphic");
	define("_MI_USERLEVEL", "HP/MP/EXP Level Mode");
	define("_MI_USERLEVEL_DESC", "<strong>HP</strong>  is determined by your average posts per day.<br /><strong>MP</strong>  is determined by your join date related to your post count.<br /><strong>EXP</strong> goes up each time you post, and when you get to 100%, you gain a level and the EXP drops to 0 again.");
	define("_MI_RSS_ENABLE", "Enable RSS Feed");
	define("_MI_RSS_ENABLE_DESC", "Enable RSS Feed, edit options below for maximum Items and Description length");
	define("_MI_RSS_MAX_ITEMS", "RSS Max. Items");
	define("_MI_RSS_MAX_DESCRIPTION", "RSS Max. Description Length");
	define("_MI_RSS_UTF8", "Force RSS Encoding with utf-8");
	define("_MI_RSS_UTF8_DESCRIPTION", "'utf-8' will be used if enabled. Otherwise, the current encoding (" . _CHARSET . ") will be used.");
	define("_MI_RSS_CACHETIME", "RSS Feed cache time");
	define("_MI_RSS_CACHETIME_DESCRIPTION", "Cache time for re-generating RSS feed, in minutes.");

	define("_MI_MEDIA_ENABLE", "Enable Media Features");
	define("_MI_MEDIA_ENABLE_DESC", "Display attached Images directly in the post.");
	define("_MI_USERBAR_ENABLE", "Enable Userbar");
	define("_MI_USERBAR_ENABLE_DESC", "Display the expand Userbar: Profile, PM, ICQ, MSN, etc...");

	define("_MI_GROUPBAR_ENABLE", "Enable Group bar");
	define("_MI_GROUPBAR_ENABLE_DESC", "Display the Groups of the User in the Post info field.");

	define("_MI_RATING_ENABLE", "Enable Rating Function");
	define("_MI_RATING_ENABLE_DESC", "Allow Topic Rating");

	define("_MI_VIEWMODE", "View Mode of the Threads");
	define("_MI_VIEWMODE_DESC", "To override the General Settings of viewmode within threads, set to NONE in order to switch feature off");
	define("_MI_COMPACT", "Compact");

	define("_MI_REPORTMOD_ENABLE", "Report a Post");
	define("_MI_REPORTMOD_ENABLE_DESC", "User can report posts to Moderator(s), for any reason, which enables Moderator(s) to take action");
	define("_MI_SHOW_JUMPBOX", "Show Jumpbox");
	define("_MI_JUMPBOXDESC", "If Enabled, a drop-down menu will allow users to jump to another forum from a forum or topic");

	define("_MI_SHOW_PERMISSIONTABLE", "Show Permission Table");
	define("_MI_SHOW_PERMISSIONTABLE_DESC", "Setting YES will display user's right");

	define("_MI_EMAIL_DIGEST", "Email post digest");
	define("_MI_EMAIL_DIGEST_DESC", "Set time period for sending post digest to users");
	define($constpref."_EMAIL_NONE", "No email");
	define($constpref."_EMAIL_DAILY", "Daily");
	define($constpref."_EMAIL_WEEKLY", "Weekly");

	define("_MI_SHOW_IP", "Show user IP");
	define("_MI_SHOW_IP_DESC", "Setting YES will show users IP to moderators");

	define("_MI_ENABLE_KARMA", "Enable karma requirement");
	define("_MI_ENABLE_KARMA_DESC", "This allows user to set a karma requirement for other users reading his/her post");

	define("_MI_KARMA_OPTIONS", "Karma options for post");
	define("_MI_KARMA_OPTIONS_DESC", "Use ',' as delimer for multi-options.");

	define("_MI_SINCE_OPTIONS", "'Since' options for 'viewform' and 'search'");
	define("_MI_SINCE_OPTIONS_DESC", "Positive value for days and negative value for hours. Use ',' as delimer for multi-options.");

	define("_MI_SINCE_DEFAULT", "'Since' default value");
	define("_MI_SINCE_DEFAULT_DESC", "Default value if not specified by users. 0 - from beginning");

	define("_MI_MODERATOR_HTML", "Allow HTML tags for moderators");
	define("_MI_MODERATOR_HTML_DESC", "This option allows only moderators to use HTML in post subject");

	define("_MI_USER_ANONYMOUS", "Allow registered users to post anonymously");
	define("_MI_USER_ANONYMOUS_DESC", "This allows a logged in user to post anonymously");

	define("_MI_ANONYMOUS_PRE", "Prefix for anonymous user");
	define("_MI_ANONYMOUS_PRE_DESC", "This will add a prefix to the anonymous username whilst posting");

	define("_MI_REQUIRE_REPLY", "Allow requiring reply to read a post");
	define("_MI_REQUIRE_REPLY_DESC", "This feature forces readers to reply to the original posters post before being able to read the original");

	define("_MI_EDIT_TIMELIMIT", "Time limit for edit a post");
	define("_MI_EDIT_TIMELIMIT_DESC", "Set a Time limit for user editing their own post. In minutes, 0 for no limit");

	define("_MI_DELETE_TIMELIMIT", "Time limit for deleting a Post");
	define("_MI_DELETE_TIMELIMIT_DESC", "Set a Time limit for user deleting thier own post. In minutes, 0 for no limit");

	define("_MI_POST_TIMELIMIT", "Time limit for consecutively posting");
	define("_MI_POST_TIMELIMIT_DESC", "Set a Time limit for consecutively posting. In seconds, 0 for no limit");

	define("_MI_RECORDEDIT_TIMELIMIT", "Timelimit for recording edit info");
	define("_MI_RECORDEDIT_TIMELIMIT_DESC", "Set a Timelimit for waiving recording edit info. In minutes, 0 for no limit");

	define("_MI_SUBJECT_PREFIX", "Add a Prefix to the Topic Subject");
	define("_MI_SUBJECT_PREFIX_DESC", "Set a Prefix i.e. [solved] at the beginning of the Subject. Use ',' as delimer for multi-options, just leave NONE for no Prefix.");
	define("_MI_SUBJECT_PREFIX_DEFAULT", '<span style="color: #00CC00; ">[solved]</span>,<span style="color: #00CC00; ">[fixed]</span>,<span style="color: #FF0000; ">[request]</span>,<span style="color: #FF0000; ">[bug report]</span>,<span style="color: #FF0000; ">[unsolved]</span>');

	define("_MI_SUBJECT_PREFIX_LEVEL", "Level for groups that can use Prefix");
	define("_MI_SUBJECT_PREFIX_LEVEL_DESC", "Choose the groups allowed to use prefix.");
	define("_MI_SPL_DISABLE", 'Disable');
	define("_MI_SPL_ANYONE", 'Anyone');
	define("_MI_SPL_MEMBER", 'Members');
	define("_MI_SPL_MODERATOR", 'Moderators');
	define("_MI_SPL_ADMIN", 'Administrators');

	define("_MI_SHOW_REALNAME", "Show Realname");
	define("_MI_SHOW_REALNAME_DESC", "Replace username with user's real name.");

	define("_MI_CACHE_ENABLE", "Enable Cache");
	define("_MI_CACHE_ENABLE_DESC", "Store some intermediate results in session to save queries");

	define("_MI_QUICKREPLY_ENABLE", "Enable Quick reply");
	define("_MI_QUICKREPLY_ENABLE_DESC", "This will enable the Quick reply form");

	define("_MI_POSTSPERPAGE", "Posts per Page");
	define("_MI_POSTSPERPAGE_DESC", "The maximum number of posts that will be displayed per page");

	define("_MI_POSTSFORTHREAD", "Maximum posts for thread view mode");
	define("_MI_POSTSFORTHREAD_DESC", "Flat mode will be used if post count exceeds the number");

	define("_MI_TOPICSPERPAGE", "Topics per Page");
	define("_MI_TOPICSPERPAGE_DESC", "The maximum number of topics that will be displayed per page");

	define("_MI_IMG_TYPE", "Image Type");
	define("_MI_IMG_TYPE_DESC", "Select the image type of buttons in the forum.<br />- png: for high speed server;<br />- gif: for normal speed;<br />- auto: gif for IE and png for other browsers");

	define("_MI_PNGFORIE_ENABLE", "Enable PNG hack");
	define("_MI_PNGFORIE_ENABLE_DESC", "The hack to allow pnd transparence attribute with IE");

	define("_MI_FORM_OPTIONS", "Form Options");
	define("_MI_FORM_OPTIONS_DESC", "Form options that users can choose when posting/editing/replying.");
	define("_MI_FORM_COMPACT", "Compact");
	define("_MI_FORM_DHTML", "DHTML");
	define("_MI_FORM_SPAW", "Spaw Editor");
	define("_MI_FORM_HTMLAREA", "HtmlArea Editor");
	define("_MI_FORM_FCK", "FCK Editor");
	define("_MI_FORM_KOIVI", "Koivi Editor");
	define("_MI_FORM_TINYMCE", "TinyMCE Editor");

	define("_MI_MAGICK", "ImageMagick");
	define("_MI_NETPBM", "Netpbm");
	define("_MI_GD1", "GD1 Library");
	define("_MI_GD2", "GD2 Library");
	define("_MI_AUTO", "AUTO");

	define("_MI_WELCOMEFORUM", "Forum for welcoming new user");
	define("_MI_WELCOMEFORUM_DESC", "A profile post will be published when a user visits Forum module for the first time");

	define("_MI_PERMCHECK_ONDISPLAY", "Check permission");
	define("_MI_PERMCHECK_ONDISPLAY_DESC", "Check permission for edit on display page");

	define("_MI_USERMODERATE", "Enable user moderation");
	define("_MI_USERMODERATE_DESC", "");


	// RMV-NOTIFY
	// Notification event descriptions and mail templates

	define ('_MI_IFORUM_THREAD_NOTIFY', 'Thread');
	define ('_MI_IFORUM_THREAD_NOTIFYDSC', 'Notification options that apply to the current thread.');

	define ('_MI_IFORUM_FORUM_NOTIFY', 'Forum');
	define ('_MI_IFORUM_FORUM_NOTIFYDSC', 'Notification options that apply to the current forum.');

	define ('_MI_IFORUM_GLOBAL_NOTIFY', 'Global');
	define ('_MI_IFORUM_GLOBAL_NOTIFYDSC', 'Global forum notification options.');

	define ('_MI_IFORUM_THREAD_NEWPOST_NOTIFY', 'New Post');
	define ('_MI_IFORUM_THREAD_NEWPOST_NOTIFYCAP', 'Notify me of new posts in the current thread.');
	define ('_MI_IFORUM_THREAD_NEWPOST_NOTIFYDSC', 'Receive notification when a new message is posted in the current thread.');
	define ('_MI_IFORUM_THREAD_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New post in thread');

	define ('_MI_IFORUM_FORUM_NEWTHREAD_NOTIFY', 'New Thread');
	define ('_MI_IFORUM_FORUM_NEWTHREAD_NOTIFYCAP', 'Notify me of new topics in the current forum.');
	define ('_MI_IFORUM_FORUM_NEWTHREAD_NOTIFYDSC', 'Receive notification when a new thread is started in the current forum.');
	define ('_MI_IFORUM_FORUM_NEWTHREAD_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New thread in forum');

	define ('_MI_IFORUM_GLOBAL_NEWFORUM_NOTIFY', 'New Forum');
	define ('_MI_IFORUM_GLOBAL_NEWFORUM_NOTIFYCAP', 'Notify me when a new forum is created.');
	define ('_MI_IFORUM_GLOBAL_NEWFORUM_NOTIFYDSC', 'Receive notification when a new forum is created.');
	define ('_MI_IFORUM_GLOBAL_NEWFORUM_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New forum');

	define ('_MI_IFORUM_GLOBAL_NEWPOST_NOTIFY', 'New Post');
	define ('_MI_IFORUM_GLOBAL_NEWPOST_NOTIFYCAP', 'Notify me of any new posts.');
	define ('_MI_IFORUM_GLOBAL_NEWPOST_NOTIFYDSC', 'Receive notification when any new message is posted.');
	define ('_MI_IFORUM_GLOBAL_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New post');

	define ('_MI_IFORUM_FORUM_NEWPOST_NOTIFY', 'New Post');
	define ('_MI_IFORUM_FORUM_NEWPOST_NOTIFYCAP', 'Notify me of any new posts in the current forum.');
	define ('_MI_IFORUM_FORUM_NEWPOST_NOTIFYDSC', 'Receive notification when any new message is posted in the current forum.');
	define ('_MI_IFORUM_FORUM_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New post in forum');

	define ('_MI_IFORUM_GLOBAL_NEWFULLPOST_NOTIFY', 'New Post (Full Text)');
	define ('_MI_IFORUM_GLOBAL_NEWFULLPOST_NOTIFYCAP', 'Notify me of any new posts (include full text in message).');
	define ('_MI_IFORUM_GLOBAL_NEWFULLPOST_NOTIFYDSC', 'Receive full text notification when any new message is posted.');
	define ('_MI_IFORUM_GLOBAL_NEWFULLPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New post (full text)');

	define ('_MI_IFORUM_GLOBAL_DIGEST_NOTIFY', 'Digest');
	define ('_MI_IFORUM_GLOBAL_DIGEST_NOTIFYCAP', 'Notify me of post digest.');
	define ('_MI_IFORUM_GLOBAL_DIGEST_NOTIFYDSC', 'Receive digest notification.');
	define ('_MI_IFORUM_GLOBAL_DIGEST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : post digest');

	// FOR installation
	define($constpref."_INSTALL_CAT_TITLE", "Category Test");
	define($constpref."_INSTALL_CAT_DESC", "Category for test.");
	define($constpref."_INSTALL_FORUM_NAME", "Forum Test");
	define($constpref."_INSTALL_FORUM_DESC", "Forum for test.");
	define($constpref."_INSTALL_POST_SUBJECT", "Congratulations! The forum is working.");
	define($constpref."_INSTALL_POST_TEXT", "
		Welcome to ".(htmlspecialchars($GLOBALS["icmsConfig"]['sitename'], ENT_QUOTES))." forum.
		Feel free to register and login to start your topics.

		If you have any question concerning iForum usage, plz visit your local support site or [url=http://community.impresscms.org/modules/newbb/viewforum.php?forum=9]CBB Module Site[/url].
		");
	define("_MI_CAPTCHA_ENABLE", "Enable Captcha");
	define("_MI_CAPTCHA_ENABLE_DESC", "Enable or disable Captcha for users, while posting");

	// icms_version constants
	define ('_MI_IFORUM_BLOCK',);
	define ('_MI_IFORUM_BLOCK_DSC',"Shows recent posts in the forums");
	define ('_MI_IFORUM_BLOCK_AUTHOR',);
	define ('_MI_IFORUM_BLOCK_AUTHOR_DSC',"Shows authors stats");