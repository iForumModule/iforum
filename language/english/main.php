<?php
// $Id: main.php,v 1.6 2005/05/19 12:21:45 phppp Exp $
if(defined('MAIN_DEFINED')) return;
define('MAIN_DEFINED',true);

define('_MD_ERROR','Error');
define('_MD_NOPOSTS','No Posts');
define('_MD_GO','Go');
define('_MD_SELFORUM','Select a Forum');

define('_MD_THIS_FILE_WAS_ATTACHED_TO_THIS_POST','Attached file:');
define('_MD_ALLOWED_EXTENSIONS','Allowed extensions');
define('_MD_MAX_FILESIZE','Maxium file size');
define('_MD_ATTACHMENT','Attach file');
define('_MD_FILESIZE','Size');
define('_MD_HITS','Hits');
define('_MD_GROUPS','Groups:');
define('_MD_DEL_ONE','Delete only this post');
define('_MD_DEL_RELATED','Delete all posts in this topic');
define('_MD_MARK_ALL_FORUMS','Mark all forums');
define('_MD_MARK_ALL_TOPICS','Mark all topics');
define('_MD_MARK_UNREAD','unread');
define('_MD_MARK_READ','read');
define('_MD_ALL_FORUM_MARKED','All forums marked');
define('_MD_ALL_TOPIC_MARKED','All topics marked');
define('_MD_BOARD_DISCLAIMER','Board Disclaimer');


//index.php
define('_MD_ADMINCP','Admin CP');
define('_MD_FORUM','Forum');
define('_MD_WELCOME','Welcome to %s Forum.');
define('_MD_TOPICS','Topics');
define('_MD_POSTS','Posts');
define('_MD_LASTPOST','Last Post');
define('_MD_MODERATOR','Moderator');
define('_MD_NEWPOSTS','New posts');
define('_MD_NONEWPOSTS','No new posts');
define('_MD_PRIVATEFORUM','Inactiv Forum');
define('_MD_BY','by'); // Posted by
define('_MD_TOSTART','To start viewing messages, select the forum that you want to visit from the list below.');
define('_MD_TOTALTOPICSC','Total Topics: ');
define('_MD_TOTALPOSTSC','Total Posts: ');
define('_MD_TOTALUSER','Total Users: ');
define('_MD_TIMENOW','The time now is %s');
define('_MD_LASTVISIT','You last visited: %s');
define('_MD_ADVSEARCH','Advanced Search');
define('_MD_POSTEDON','Posted on: ');
define('_MD_SUBJECT','Subject');
define('_MD_INACTIVEFORUM_NEWPOSTS','Inactive forum with new posts');
define('_MD_INACTIVEFORUM_NONEWPOSTS','Inactive forum without new posts');
define('_MD_SUBFORUMS','Subforums');
define('_MD_MAINFORUMOPT', 'Main Options');
define("_MD_PENDING_POSTS_FOR_AUTH","Posts pending approval:");



//page_header.php
define('_MD_MODERATEDBY','Moderated by');
define('_MD_SEARCH','Search');
//define('_MD_SEARCHRESULTS','Search Results');
define('_MD_FORUMINDEX','%s Forum Index');
define('_MD_POSTNEW','New Topic');
define('_MD_REGTOPOST','Register To Post');

//search.php
define('_MD_SEARCHALLFORUMS','Search All Forums');
define('_MD_FORUMC','Forum');
define('_MD_AUTHORC','Autor:');
define('_MD_SORTBY','Sort by');
define('_MD_DATE','Date');
define('_MD_TOPIC','Topic');
define('_MD_USERNAME','Username');
define('_MD_BODY','Body');
define('_MD_SINCE','Since');

//viewforum.php
define('_MD_REPLIES','Replies');
define('_MD_POSTER','Poster');
define('_MD_VIEWS','Views');
define('_MD_MORETHAN','New posts [ Popular ]');
define('_MD_MORETHAN2','No New posts [ Popular ]');
define('_MD_TOPICSHASATT','Topic has Attachments');
define('_MD_TOPICHASPOLL','Topic has a Poll');
define('_MD_TOPICLOCKED','Topic is Locked');
define('_MD_LEGEND','Legend');
define('_MD_NEXTPAGE','Next Page');
define('_MD_SORTEDBY','Sorted by');
define('_MD_TOPICTITLE','topic title');
define('_MD_NUMBERREPLIES','number of replies');
define('_MD_TOPICPOSTER','topic poster');
define('_MD_TOPICTIME','Publish time');
define('_MD_LASTPOSTTIME','last post time');
define('_MD_ASCENDING','Ascending order');
define('_MD_DESCENDING','Descending order');
define('_MD_FROMLASTHOURS','From last %s hours');
define('_MD_FROMLASTDAYS','From last %s days');
define('_MD_THELASTYEAR','From the last year');
define('_MD_BEGINNING','From the beginning');
define('_MD_SEARCHTHISFORUM', 'Search This Forum');
define('_MD_TOPIC_SUBJECTC','Topic Prefix:');


define('_MD_RATINGS','Ratings');
define("_MD_CAN_POST", "You <strong>can</strong> start a new topic.<br />");
define("_MD_CANNOT_POST", "You <strong>cannot</strong> start a new topic.<br />");
define("_MD_CAN_VIEW", "You <strong>can</strong> view topic.<br />");
define("_MD_CANNOT_VIEW", "You <strong>cannot</strong> view topic.<br />");
define("_MD_CAN_REPLY", "You <strong>can</strong> reply to posts.<br />");
define("_MD_CANNOT_REPLY", "You <strong>cannot</strong> reply to posts.<br />");
define("_MD_CAN_EDIT", "You <strong>can</strong> edit your posts.<br />");
define("_MD_CANNOT_EDIT", "You <strong>cannot</strong> edit your posts.<br />");
define("_MD_CAN_DELETE", "You <strong>can</strong> delete your posts.<br />");
define("_MD_CANNOT_DELETE", "You <strong>cannot</strong> delete your posts.<br />");
define("_MD_CAN_ADDPOLL", "You <strong>can</strong> add new polls.<br />");
define("_MD_CANNOT_ADDPOLL", "You <strong>cannot</strong> add new polls.<br />");
define("_MD_CAN_VOTE", "You <strong>can</strong> vote in polls.<br />");
define("_MD_CANNOT_VOTE", "You <strong>cannot</strong> vote in polls.<br />");
define("_MD_CAN_ATTACH", "You <strong>can</strong> attach files to posts.<br />");
define("_MD_CANNOT_ATTACH", "You <strong>cannot</strong> attach files to posts.<br />");
define("_MD_CAN_NOAPPROVE", "You <strong>can</strong> post without approval.<br />");
define("_MD_CANNOT_NOAPPROVE", "You <strong>cannot</strong> post without approval.<br />");
define("_MD_IMTOPICS","Important Topics");
define("_MD_NOTIMTOPICS","Forum Topics");
define('_MD_FORUMOPTION', 'Forum options');

define('_MD_VAUP','View all unreplied posts');
define('_MD_VANP','View all new posts');


define('_MD_UNREPLIED','unreplied topics');
define('_MD_UNREAD','unread topics');
define('_MD_ALL','all topics');
define('_MD_ALLPOSTS','all posts');
define('_MD_VIEW','View');

//viewtopic.php
define('_MD_AUTHOR','Author');
define('_MD_LOCKTOPIC','Lock this topic');
define('_MD_UNLOCKTOPIC','Unlock this topic');
define('_MD_UNSTICKYTOPIC','Make this topic UnSticky');
define('_MD_STICKYTOPIC','Make this topic Sticky');
define('_MD_DIGESTTOPIC','Make this topic as Digest');
define('_MD_UNDIGESTTOPIC','Make this topic as UnDigest');
define('_MD_MOVETOPIC','Move this topic');
define('_MD_DELETETOPIC','Delete this topic');
define('_MD_TOP','Top');
define('_MD_BOTTOM','Bottom');
define('_MD_PREVTOPIC','Previous Topic');
define('_MD_NEXTTOPIC','Next Topic');
define('_MD_GROUP','Group:');
define('_MD_QUICKREPLY','Quick Reply');
define('_MD_POSTREPLY','Post Reply');
define('_MD_PRINTTOPICS','Print Topic');
define('_MD_PRINT','Print');
define('_MD_REPORT','Report');
define('_MD_PM','PM');
define('_MD_EMAIL','Email');
define('_MD_WWW','WWW');
define('_MD_AIM','AIM');
define('_MD_YIM','YIM');
define('_MD_MSNM','MSNM');
define('_MD_ICQ','ICQ');
define('_MD_PRINT_TOPIC_LINK', 'URL for this discussion');
define('_MD_ADDTOLIST','Add to your Contact List');
define('_MD_TOPICOPT', 'Topic options');
define('_MD_VIEWMODE', 'View mode');
define('_MD_NEWEST', 'Newest First');
define('_MD_OLDEST', 'Oldest First');

define('_MD_FORUMSEARCH','Search Forum');

define('_MD_RATED','Rated:');
define('_MD_RATE','Rate Thread');
define('_MD_RATEDESC','Rate this Thread');
define('_MD_RATING','Vote now');
define('_MD_RATE1','Terrible');
define('_MD_RATE2','Bad');
define('_MD_RATE3','Average');
define('_MD_RATE4','Good');
define('_MD_RATE5','Excellent');

define('_MD_TOPICOPTION','Topic options');
define('_MD_KARMA_REQUIREMENT', 'Your personal karm %s does not reach the required karma %s. <br /> Please try later.');
define('_MD_REPLY_REQUIREMENT', 'To view this post, you must login and reply first.');
define('_MD_TOPICOPTIONADMIN','Topic Admin options');
define('_MD_POLLOPTIONADMIN','Poll Admin options');

define('_MD_EDITPOLL','Edit this Poll');
define('_MD_DELETEPOLL','Delete this Poll');
define('_MD_RESTARTPOLL','Restart this Poll');
define('_MD_ADDPOLL','Add Poll');

define('_MD_QUICKREPLY_EMPTY','Enter a quick reply here');

define('_MD_LEVEL','Level :');
define('_MD_HP','HP :');
define('_MD_MP','MP :');
define('_MD_EXP','EXP :');

define('_MD_BROWSING','Browsing this Thread:');
define('_MD_POSTTONEWS','Send this post to a news Story');

define('_MD_EXCEEDTHREADVIEW','Post count exceeds the threshold for thread mode<br />Changing to flat mode');


//forumform.inc
define('_MD_PRIVATE','This is a <strong>Private</strong> forum.<br />Only users with special access can post new topics and replies to this forum');
define('_MD_QUOTE','Quote');
define('_MD_VIEW_REQUIRE','View requirements');
define('_MD_REQUIRE_KARMA','Karma');
define('_MD_REQUIRE_REPLY','Reply');
define('_MD_REQUIRE_NULL','No requirement');

define("_MD_SELECT_FORMTYPE","Select your desired form type");

define("_MD_FORM_COMPACT","Compact");
define("_MD_FORM_DHTML","DHTML");
define("_MD_FORM_SPAW","Spaw Editor");
define("_MD_FORM_HTMLAREA","HTMLArea");
define("_MD_FORM_FCK","FCK Editor");
define("_MD_FORM_KOIVI","Koivi Editor");
define("_MD_FORM_TINYMCE","TinyMCE Editor");

// ERROR messages
define('_MD_ERRORFORUM','ERROR: Forum not selected!');
define('_MD_ERRORPOST','ERROR: Post not selected!');
define('_MD_NORIGHTTOVIEW','You don\'t have the right to view this topic.');
define('_MD_NORIGHTTOPOST','You don\'t have the right to post in this forum.');
define('_MD_NORIGHTTOEDIT','You don\'t have the right to edit in this forum.');
define('_MD_NORIGHTTOREPLY','You don\'t have the right to reply in this forum.');
define('_MD_NORIGHTTOACCESS','You don\'t have the right to access this forum.');
define('_MD_ERRORTOPIC','ERROR: Topic not selected!');
define('_MD_ERRORCONNECT','ERROR: Could not connect to the forums database.');
define('_MD_ERROREXIST','ERROR: The forum you selected does not exist. Please go back and try again.');
define('_MD_ERROROCCURED','An Error Occured');
define('_MD_COULDNOTQUERY','Could not query the forums database.');
define('_MD_FORUMNOEXIST','Error - The forum/topic you selected does not exist. Please go back and try again.');
define('_MD_USERNOEXIST','That user does not exist.  Please go back and search again.');
define('_MD_COULDNOTREMOVE','Error - Could not remove posts from the database!');
define('_MD_COULDNOTREMOVETXT','Error - Could not remove post texts!');
define('_MD_TIMEISUP','Your have reach the timelimit for editing your post.');
define('_MD_TIMEISUPDEL','Your have reach the timelimit for deleting your post.');

//reply.php
define('_MD_ON','on'); //Posted on
define('_MD_USERWROTE','%s wrote:'); // %s is username

//post.php
define('_MD_EDITNOTALLOWED','You\'re not allowed to edit this post!');
define('_MD_EDITEDBY','Edited by');
define('_MD_ANONNOTALLOWED','Anonymous users are not allowed to post.<br />Please register.');
define('_MD_THANKSSUBMIT','Thanks for your submission!');
define('_MD_REPLYPOSTED','A reply to your topic has been posted.');
define('_MD_HELLO','Hello %s,');
define('_MD_URRECEIVING','You are receiving this email because a message you posted on %s forums has been replied to.'); // %s is your site name
define('_MD_CLICKBELOW','Click on the link below to view the thread:');
define('_MD_WAITFORAPPROVAL','Thank you. Your post will be approved before publication.');
define('_MD_POSTING_LIMITED','Why not take a break and come back in %d sec');

//forumform.inc
define('_MD_NAMEMAIL','Name/Email:');
define('_MD_LOGOUT','Logout');
define('_MD_REGISTER','Register');
define('_MD_SUBJECTC','Subject:');
define('_MD_MESSAGEICON','Message Icon:');
define('_MD_MESSAGEC','Message:');
define('_MD_ALLOWEDHTML','Allowed HTML:');
define('_MD_OPTIONS','Options:');
define('_MD_POSTANONLY','Post Anonymously');
define('_MD_DOSMILEY','Enable Smiley');
define('_MD_DOXCODE','Enable Xoops Code');
define('_MD_DOBR','Enable line break (Suggest to turn off if HTML enabled)');
define('_MD_DOHTML','Enable html tags');
define('_MD_NEWPOSTNOTIFY', 'Notify me of new posts in this thread');
define('_MD_ATTACHSIG','Attach Signature');
define('_MD_POST','Post');
define('_MD_SUBMIT','Submit');
define('_MD_CANCELPOST','Cancel Post');
define('_MD_REMOVE','Remove');
define('_MD_UPLOAD','Upload');

// forumuserpost.php
define('_MD_ADD','Add');
define('_MD_REPLY','Reply');

// topicmanager.php
define('_MD_VIEWTHETOPIC','View the topic');
define('_MD_RETURNTOTHEFORUM','Return to the forum');
define('_MD_RETURNFORUMINDEX','Return to the forum index');
define('_MD_ERROR_BACK','Error - Please go back and try again.');
define('_MD_GOTONEWFORUM','View the updated topic');

define('_MD_TOPICDELETE','The topic has been deleted.');
define('_MD_TOPICMOVE','The topic has been moved.');
define('_MD_TOPICLOCK','The topic has been locked.');
define('_MD_TOPICUNLOCK','The topic has been unlocked.');
define('_MD_TOPICSTICKY','The topic has been Stickyed.');
define('_MD_TOPICUNSTICKY','The topic has been unStickyed.');
define('_MD_TOPICDIGEST','The topic has been Digested.');
define('_MD_TOPICUNDIGEST','The topic has been unDigested.');

define('_MD_DELETE','Delete');
define('_MD_MOVE','Move');
define('_MD_LOCK','Lock');
define('_MD_UNLOCK','unLock');
define('_MD_STICKY','Sticky');
define('_MD_UNSTICKY','unSticky');
define('_MD_DIGEST','Digest');
define('_MD_UNDIGEST','unDigest');

define('_MD_DESC_DELETE','Once you press the delete button at the bottom of this form the topic you have selected, and all its related posts, will be <strong>permanently</strong> removed.');
define('_MD_DESC_MOVE','Once you press the move button at the bottom of this form the topic you have selected, and its related posts, will be moved to the forum you have selected.');
define('_MD_DESC_LOCK','Once you press the lock button at the bottom of this form the topic you have selected will be locked. You may unlock it at a later time if you like.');
define('_MD_DESC_UNLOCK','Once you press the unlock button at the bottom of this form the topic you have selected will be unlocked. You may lock it again at a later time if you like.');
define('_MD_DESC_STICKY','Once you press the Sticky button at the bottom of this form the topic you have selected will be Stickyed. You may unSticky it again at a later time if you like.');
define('_MD_DESC_UNSTICKY','Once you press the unSticky button at the bottom of this form the topic you have selected will be unStickyed. You may Sticky it again at a later time if you like.');
define('_MD_DESC_DIGEST','Once you press the Digest button at the bottom of this form the topic you have selected will be Digested. You may unDigest it again at a later time if you like.');
define('_MD_DESC_UNDIGEST','Once you press the unDigest button at the bottom of this form the topic you have selected will be unDigested. You may Digest it again at a later time if you like.');

define('_MD_MOVETOPICTO','Move Topic To:');
define('_MD_NOFORUMINDB','No Forums in DB');

// delete.php
define('_MD_DELNOTALLOWED','Sorry, but you\'re not allowed to delete this post.');
define('_MD_AREUSUREDEL','Are you sure you want to delete this post and all its child posts?');
define('_MD_POSTSDELETED','Selected post and all its child posts deleted.');
define('_MD_POSTDELETED','Selected post deleted.');

// definitions moved from global.
define('_MD_THREAD','Thread');
define('_MD_FROM','From');
define('_MD_JOINED','Joined');
define('_MD_ONLINE','Online');
define('_MD_OFFLINE','Offline');
define('_MD_FLAT', 'Flat');


// online.php
define('_MD_USERS_ONLINE', 'Users Online:');
define('_MD_ANONYMOUS_USERS', 'Anonymous Users');
define('_MD_REGISTERED_USERS', 'Registered Users: ');
define('_MD_BROWSING_FORUM','Users browsing forum');
define('_MD_TOTAL_ONLINE','Total %d Users Online.');
define('_MD_ADMINISTRATOR','Administrator');

define('_MD_NO_SUCH_FILE','File not exist!');
define('_MD_ERROR_UPATEATTACHMENT','Error occur when updating attachment');

// ratethread.php
define("_MD_CANTVOTEOWN", "You cannot vote on the topic you submitted.<br />All votes are logged and reviewed.");
define("_MD_VOTEONCE", "Please do not vote for the same topic more than once.");
define("_MD_VOTEAPPRE", "Your vote is appreciated.");
define("_MD_THANKYOU", "Thank you for taking the time to vote here at %s"); // %s is your site name
define("_MD_VOTES","Votes");
define("_MD_NOVOTERATE","You did not rate this Topic");


// polls.php
define("_MD_POLL_DBUPDATED","Database Updated Successfully!");
define("_MD_POLL_POLLCONF","Polls Configuration");
define("_MD_POLL_POLLSLIST", "Polls List");
define("_MD_POLL_AUTHOR", "Author of this poll");
define("_MD_POLL_DISPLAYBLOCK", "Display in block?");
define("_MD_POLL_POLLQUESTION", "Poll Question");
define("_MD_POLL_VOTERS", "Total voters");
define("_MD_POLL_VOTES", "Total votes");
define("_MD_POLL_EXPIRATION", "Expiration");
define("_MD_POLL_EXPIRED", "Expired");
define("_MD_POLL_VIEWLOG","View log");
define("_MD_POLL_CREATNEWPOLL", "Create new poll");
define("_MD_POLL_POLLDESC", "Poll description");
define("_MD_POLL_DISPLAYORDER", "Display order");
define("_MD_POLL_ALLOWMULTI", "Allow multiple selections?");
define("_MD_POLL_NOTIFY", "Notify the poll author when expired?");
define("_MD_POLL_POLLOPTIONS", "Options");
define("_MD_POLL_EDITPOLL", "Edit poll");
define("_MD_POLL_FORMAT", "Format: yyyy-mm-dd hh:mm:ss");
define("_MD_POLL_CURRENTTIME", "Current time is %s");
define("_MD_POLL_EXPIREDAT", "Expired at %s");
define("_MD_POLL_RESTART", "Restart this poll");
define("_MD_POLL_ADDMORE", "Add more options");
define("_MD_POLL_RUSUREDEL", "Are you sure you want to delete this poll and all its comments?");
define("_MD_POLL_RESTARTPOLL", "Restart poll");
define("_MD_POLL_RESET", "Reset all logs for this poll?");
define("_MD_POLL_ADDPOLL","Add Poll");
define("_MD_POLLMODULE_ERROR","xoopspoll module not available for use");

//report.php
define("_MD_REPORTED", "Thank you for reporting this post/thread! A moderator will look into your report shortly.");
define("_MD_REPORT_ERROR", "Error occured while sending the report.");
define("_MD_REPORT_TEXT", "Report message:");

define("_MD_PDF","Create PDF from Post");
define("_MD_PDF_PAGE","Page %s");

//print.php
define("_MD_COMEFROM","This Post was from:");

//viewpost.php
define("_MD_VIEWALLPOSTS","All Posts");
define("_MD_VIEWTOPIC","Topic");
define("_MD_VIEWFORUM","Forum");

define("_MD_COMPACT","Compact");

define("_MD_MENU_SELECT","SELECT");
define("_MD_MENU_HOVER","HOVER");
define("_MD_MENU_CLICK","CLICK");

define("_MD_WELCOME_SUBJECT","%s has joined the forum");
define("_MD_WELCOME_MESSAGE","Hi, %s is a newbie.");

// !!IMPORTANT!! insert '\' to any char among reserved chars: "a", "A","B","c","d","D","F","g","G","h","H","i","I","j","l","L","m","M","n","O","r","s","S","t","T","U","w","W","Y","y","z","Z"	
// insert additional '\' to 't', 'r', 'n'
define("_MD_TODAY", "\To\d\a\y G:i:s");
define("_MD_YESTERDAY", "\Ye\s\\te\\r\d\a\y G:i:s");
define("_MD_MONTHDAY", "n/j G:i:s");
define("_MD_YEARMONTHDAY", "Y/n/j G:i");

define("_MD_VIEWNEWPOSTS","View new posts");

define("_MD_INVALID_SUBMIT","Invalid submission. You could have exceeded session time. Please re-submit or make a backup of your post and login to resubmit if necessary.");

define("_MD_ACCOUNT","Account");
define("_MD_NAME","Name");
define("_MD_PASSWORD","Password");
define("_MD_LOGIN","Login");

// For user info
// If you have customized userbar, define here.
require_once(XOOPS_ROOT_PATH."/modules/newbb/class/user.php");
class User_language extends User
{
    function User_language(&$user)
    {
	    $this->User($user);
    }

    function &getUserbar()
    {
	    global $xoopsModuleConfig, $xoopsUser, $isadmin;
    	if (empty($xoopsModuleConfig['userbar_enabled'])) return null;
    	$user =& $this->user;
    	$userbar = array();
        $userbar[] = array("link"=>XOOPS_URL . "/userinfo.php?uid=" . $user->getVar("uid"), "name" =>_PROFILE);
		if (is_object($xoopsUser))
        $userbar[]= array("link"=>"javascript:void openWithSelfMain('" . XOOPS_URL . "/pmlite.php?send2=1&amp;to_userid=" . $user->getVar("uid") . "', 'pmlite', 450, 380);", "name"=>_MD_PM);
        if($user->getVar('user_viewemail') || $isadmin)
        $userbar[]= array("link"=>"javascript:void window.open('mailto:" . $user->getVar('email') . "', 'new');", "name"=>_MD_EMAIL);
        if($user->getVar('url'))
        $userbar[]= array("link"=>"javascript:void window.open('" . $user->getVar('url') . "', 'new');", "name"=>_MD_WWW);
        if($user->getVar('user_icq'))
        $userbar[]= array("link"=>"javascript:void window.open('http://wwp.icq.com/scripts/search.dll?to=" . $user->getVar('user_icq')."', 'new');", "name" => _MD_ICQ);
        if($user->getVar('user_aim'))
        $userbar[]= array("link"=>"javascript:void window.open('aim:goim?screenname=" . $user->getVar('user_aim') . "&amp;message=Hi+" . $user->getVar('user_aim') . "+Are+you+there?" . "', 'new');", "name"=>_MD_AIM);
        if($user->getVar('user_yim'))
        $userbar[]= array("link"=>"javascript:void window.open('http://edit.yahoo.com/config/send_webmesg?.target=" . $user->getVar('user_yim') . "&.src=pg" . "', 'new');", "name"=> _MD_YIM);
        if($user->getVar('user_msnm'))
        $userbar[]= array("link"=>"javascript:void window.open('http://members.msn.com?mem=" . $user->getVar('user_msnm') . "', 'new');", "name" => _MD_MSNM);
		return $userbar;
    }
}
?>