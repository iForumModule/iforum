<?php
define('_NEWBB_CONV_CHARSET','ISO-8859-1');
define('_NEWBB_CONV_TITLE','XOOPS NEWBB 2.0 CONVERTER');
define('_NEWBB_CONV_INSTRUCTIONS','Instructions');
define('_NEWBB_CONV_CONFIG','Configuration');
define('_NEWBB_CONV_GEN_SQL','Generate SQL');
define('_NEWBB_CONV_EXEC_SQL','Execute SQL');

define('_NEWBB_CONV_PROCEED','Proceed');

define('_NEWBB_CONV_XOOPS_INDEX','XOOPS Index');
define('_NEWBB_CONV_XOOPS_ADMIN','XOOPS Admin Panel');
define('_NEWBB_CONV_NEWBB_INDEX','NewBB 2.0 Index');

define('_NEWBB_CONV_CFG_TITLE','Converter Configuration');
define('_NEWBB_CONV_CFG_FORUM_TYPE','Source Forum');
define('_NEWBB_CONV_CFG_DB_HOST','Source DB Host');
define('_NEWBB_CONV_CFG_DB_USER','Source DB User');
define('_NEWBB_CONV_CFG_DB_PASS','Source DB Password');
define('_NEWBB_CONV_CFG_DB_NAME','Source DB Name');
define('_NEWBB_CONV_CFG_DB_PREFIX','Source DB Prefix');
define('_NEWBB_CONV_CFG_PM','Import Private Messages');
define('_NEWBB_CONV_CFG_PM_SYSTEM','Private Messages System');
define('_NEWBB_CONV_CFG_PM_XOOPS','XOOPS PM');

define('_NEWBB_CONV_ERR_NO_CONVERTER','<center><font color=#ff0000><strong>Fatal Error: Cannot find converter.</strong></font></center>');
define('_NEWBB_CONV_ERR_NOT_EMPTY','<center><font color=#ff0000><strong>Fatal Error: NewBB 2.0 is not empty.</strong></font></center>');
define('_NEWBB_CONV_ERR_NOT_INSTALLED','<center><font color=#ff0000><strong>Fatal Error: NewBB 2.0 is not installed.</strong></font></center>');
define('_NEWBB_CONV_ERR_SQL_WRITE','<center><font color=#ff0000><strong>Fatal Error: Cannont write to this directory. Please CHMOD the converter directory to 777.</strong></font></center>');
define('_NEWBB_CONV_SQL_EXEC','<b>%s/%s SQL Queries Executed Succesfully</b>');
define('_NEWBB_CONV_INSTRUCTIONS_DESC','

<font size=+1><b>Converter Instructions</b></font>
<br /><br />
<font size=-1>
This Converter script will attempt to convert data from another php/mysql forum into the XOOPS 2.x / Newbb 2.0 environment.<br /><br />
The following forums are currently supported:</font><br /><br />
<center><strong>
<li>phpBB 2.0.X</li>
<li>Invision Board 1.3.1</li>
</strong></center><br /><br />
<font size=-1 color=#ff0000><strong>Before proceeding to convert data, the NewBB 2.0 module must be installed but must be empty i.e. no categories, no forums, no posts... nothing!</strong></font><br/>
<br /><br />
<b><u>How It Works:</u></b><br /><font size=-1>This converter works in three steps:<br /><br />
<strong>Step 1:</strong> Provide the forum type and database connection parameters of the external forum.<br />
<strong>Step 2:</strong> Generate an SQL file from the data in the external forum ready for converting into XOOPS 2.x .<br />
<strong>Step 3:</strong> Execute the SQL queries from the generated file, converting the data.<br />
</font><br /><br />
<b><u>User Accounts:</u></b><br /><font size=-1>This converter script can cope with having existing users accounts set up in the XOOPS 2.x environment.
All user accounts from the external forum will be added incrementally into XOOPS 2.x remapping all of the user\'s topics, posts, private messages etc. to use the new user id.
If an account is found in the external forum with the exact same username to an account in XOOPS 2.x, all of their forum topics, posts etc. will be mapped to this user account.</font>
<br /><br /><center>
<font color=#ff0000 size=+1>REMEMBER TO TAKE BACKUPS BEFORE PROCEEDING WITH THE CONVERTING!!</font>
</center><br /><br />');

define('_NEWBB_CONV_ENDINFO','
<font size=+1><b>Post-Import Configuration</b></font>
<br /><br />
You will now need to go to the XOOPS Administrator panel and perform the following tasks:
<li>1. Add forum moderators</li>
<li>2. Set forum permissions</li>');

define('_NEWBB_CONV_IPBEND','<li>3. Copy all attachments from (ipb)\uploads to (xoops)\uploads\attachments</li>');


//ipb
define('IPB_TITLE','Generating SQL for IPB -> XOOPS 2.x / NewBB 2.0');
define('IPB_DBCONNECT','Connecting to IPB database...    ');
define('IPB_ERR_DBSEL','Fatal Error: FAILED TO SELECT DB');
define('IPB_ERR_DBCONN','Fatal Error: FAILED TO CONNECT TO DB');

define('IPB_USERS','Users');
define('IPB_USER','User');
define('IPB_CATS','Categories');
define('IPB_FORUMS','Forums');
define('IPB_POLLS','Polls');
define('IPB_PMS','Private Messages');
define('IPB_TOPICS','Topics');
define('IPB_POSTS','Posts');
define('IPB_NOTIFY','Topic Notifications');
define('IPB_IMPORTING','Importing %s');
define('IPB_IMPORTED','%d %s imported');

//phpbb
define('PHPBB_TITLE','Generating SQL for phpBB2 -> XOOPS 2.x / NewBB 2.0');
define('PHPBB_DBCONNECT','Connecting to phpBB2 database...    ');
define('PHPBB_ERR_DBSEL','Fatal Error: FAILED TO SELECT DB');
define('PHPBB_ERR_DBCONN','Fatal Error: FAILED TO CONNECT TO DB');

define('PHPBB_USERS','Users');
define('PHPBB_USER','User');
define('PHPBB_CATS','Categories');
define('PHPBB_FORUMS','Forums');
define('PHPBB_POLLS','Polls');
define('PHPBB_POLL_OPTS','Poll Options');
define('PHPBB_PMS','Private Messages');
define('PHPBB_TOPICS','Topics');
define('PHPBB_POSTS','Posts');
define('PHPBB_VOTES','Poll Votes');
define('PHPBB_NOTIFY','Topic Notifications');

define('PHPBB_IMPORTING','Importing %s');
define('PHPBB_IMPORTED','%d %s imported');
?>