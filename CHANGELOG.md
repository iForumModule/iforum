# iForum Changelog

## iForum 2.0 - 29 November 2017
### New
- added: Lightbox for images within the postings added (sato-san)
- added: Japanese translation files (sato-san)
### Fix
- Bugfix: Link for ICQ fixed (sato-san)
- Bugfix: Position from "document icons" and "post icon" optimized for a better view (sato-san)
- Bugfix: Editor selection dissabled, because the admin has to setup this function (sato-san)
- Bugfix: Replace all all TYPE=MyISAM to ENGINE=MyISAM (sato-san)
- Bugfix: If a forum has subforum, the numbers for topics and posts are not longer dispalyed, since the summery of numbers are not available (sato-san)
- Bugfix: The navigation on top in the search template is available now (sato-san)
- Bugfix: Error in PM fixed (sato-san)
### Improvement
- Improved: Some parts of templates redesigned (sato-san)
- Improved: Mousepointer for the category icons for a better usability (sato-san)
- Improved: Made the usebar lighter. Uniform icons (sato-san)
- Improved: Userbar in Text version with better design (sato-san)
- Improved: updated version number format to string and corrected several URLs in icms_version (fiammybe)
- iForum needs ImpressCMS 1.3+, and not 1.2+ - updated


## iForum 1.0 - 18 Sept 2011
### New
- implemented icms updating methods
- added: _MD_UP on language/english/main.php (sato-san)
- added: _MD_POSTTIME on language/english/main.php (sato-san)
- added: German files with UTF-8  (sato-san)
- added: the module create the upload-folders automatically (sato-san)
- added: Spanish files with UTF-8  (juancj)
- added: Portuguesebr files with UTF-8  (Gibaphp)
- added: French files with UTF-8  (FaYsSaL)
- added: Russian files with UTF-8  (algalochkin)
- added: smarty modulename (in blocks)
- added: div class="comUserImg for avatars (Knallkopp_02)
- Finished Implementing easy-renaming
- New template set (MrTheme)
- Added icons instead of transfer text
- Added Captcha Control option
- Added Captcha Control for posts
- Added Control for wysiwyg editors
- Added Tagging options (partly, it is not finished yet)
- Added Built in RTL support
- Added xoops-magazine image set as default
- New icons (thanks McDonald And http://dryicons.com/)

### Fix
- Bugfix: for allowed editors in ICMS 1.1
- Bugfix: for fast-reply in IE (McDonald)
- Bugfix: for newbb_rtl.css
- Bugfix: date&time.
- Bugfix: PDF issues
- Bugfix: if no editor is allowed, the form will disappear
- Bugfix: with FCKEDITOR paths
- Bugfix: xoopseditor path changed to editors
- Bugfix: need for xoops_local
- Bugfix for user signatures in ICMS 1.1

### Improvement
- Improved: &newbb_displayTarea (to use icms purifier)
- issues with RTL
- Changed PDF generator to TCPDF for UTF-8 languages
- changed from mod_isModuleAction to icms_moduleAction (sato-san)
- changed from formcaptcha.php to captcha.php (sato-san)

### Removed
- Removed need to have frameworks

## CBB 3.08 - Jan 3rd, 2007 
- Bugfix for user stats (jorff, agl)
- Bugfix for reading new posts

## CBB 3.07 - October 29th, 2006 
- Bugfix for permission template (js related)
- Added support for FCKeditor upload
- Added support for extended xcode which allows flash/wmplayer/...
- Fix for XSS reported by bubuche93

## CBB 3.06 - October 8th, 2006 
- Bugfix version

## CBB 3.05 - July 22nd, 2006 
### New
- Added editor parameter control based on plugin'ed configs
### Fix
- Bugfix for notifying new replies for a specific topic
- Bugfix for permission check when moving a post
- Bugfix for xhtml compliance in forum selection box (reported by skalpa)
- Bugfix for update scripts for newbb 2.2
- Bugfix for category name display in permission admin
- Bugfix for view_level check in viewforum template (reported by topmuzik.com)
### Removed
- Removed inherition of view mode and post order from system-wide preference

## CBB 3.04 Final - June 3rd, 2006 
### New
- MySQL syntax for data synchronization for different versions
- Added topic check before storing post (reported by marco)
- Added reading records options: cookie, database (inspired by Ajout Gizmhail)
- Added data synchronization
- Added missing "previous/next topic"
- Created object handler for post_text
### Fix
- xhtml fixes
- bugfix for group permission check form (reported by Aries)
- Bugfix for topic title transfered from post subject
- Other minor fixes
- Fixed bugs in print.php (reported by ideiafacil)
- Fixed bugs reported on xoops.org
- Fixed bug in templates for file inclusion: for both update from file and from db modes 
### Improvement
- Modified database structure for query optimization
- Code correction for performance and cleaning up
- Partial improvement on permission precision
- Improvement on category/forum structured display for permission admin and block edit pages
- Improvement on compliant xhtml
- Changed fields in TABLE bb_forums
- Changed testing post message in language file
- category, forum, topic, post, report, rate refactoring
### Removed
- Removed unnecessary forum option 'allow_attachments' 

## CBB 3.03 - Apr 26th, 2006 
### New
- Split functions.php
### Fix
- Fixed rss+xml rel link (by CeBepuH)
- Fixed typo in "pm" path for "transfer" (by CeBepuH)
- Fixed clear property in newbb.css (by CeBepuH)
- Fixed undefined method "setMessage" for module which could lead to newbb 2.* upgrade failure 

## CBB 3.02 - Apr 23rd, 2006 
### New
- Skip cache for edit pages
- Added action request detection in xoops_version.php so that some useful features are reactived including "welcome forum"
- Added time limit to "recent replied topic" block
### Improvement
- Performance improvement, including PHP scripting and MySQL db structure
### Fix
- Fixed URL iteration for menumode (reported by genetailor)
- Charset completeness for PDF maker (reported by domecc)
- Bugfix for "sort by rating" URL (reported by Mowaffak)
- Bugfix for signature setting (removed unnecessary user setting check)

## CBB 3.01 - Feb 22th, 2006 
### Fix
- Fixed bugs in permission management
- Fixed bugs in formloader

## CBB 3.0 - Feb 10th, 2006 
### New
- Compatible with XOOPS 2.0, 2.2, 2.3
### Fix
- Fixed bugs in user select
- Fixed bugs in permission management

## CBB 2.32
- DB query optimization

## CBB 2.31
- bugfixes
- speed improvement

## CBB 2.3
- moderator accessible distributed batch threads/posts management (approval, edit, move, delete, merge, split)
- moderator accessible distributed user/IP suspension management
- trashcan implemented
- user-based post search and management
- plugable module bridging handler implemented

## CBB 2.2
- block/profile/css/adminmenu/encoding related content upgraded to XOOPS 2.2
- XOOPS editor framework implemented
- permission management separated from forum/category and default permission set and management added
- category/forum creation on module installation
- send PM with quoted post content
- embedded upgrade: any version of newbb/cbb could be updated to up-to-date CBB by updating module
- forum queries in xoops_version.php moved to save db query
- change relative path to full path for some images
- change forum list in jumpbox and topicmanager to a more clear style
- moderator management merged into forum admin form with xoopsuserselect form

## CBB 1.15
- fix for aged security problem (XSS)

## CBB 1.14
- bugfix for inactive user posting (Reported by Aries @ xoops.org.cn)
- bugfix for deleting topic with poll (Reported by gropius @ xoops.org.cn)
- change default value for displaying forum topic time duration (Reported by Zjerre @ xoops.org)
- change formselectuser.php for XOOPS 2.2

## CBB 1.13
- bugfix for IP recording (Reported by alitan @ xoops.org)
- changing time display for "Today/yesterday ..." (Reported by alitan @ xoops.org)
- adding post link (Preliminary solution by ackbarr && Suggested by Peekay @ xoops.org)
- further cleaning "Compact mode" (Suggested by Rou4 @ XOOPS CHINA)
- adding new block "recent post text"
- bugfix for function newbb_admin_mkdir
- bugfix for permission table of locked topic
- adding indication for locked topic in view topic (Requested by SuperVoley @ xoops.org)
- bugfix for category management (Reported by chia @ xoops.tnc.edu.tw)
- bugfix for subject sanitizing problem (Reported by CeBepuH @ xoops.org)
- rolling back signature to pure xcode format (comprehensive improvement is expected after XOOPS 2.2)
- bugfix for empty message check in quick reply
- template validation on XHTML 1.0 (not complete yet)
- compatible with news 1.30+ for posttonews (reported by cosmodrum @ xoops.org)

## CBB 1.12
- login on-fly in "quick reply" (requested by Rou4 @ XOOPS CHINA)
- sort order in viewpost.php (reported by kmac @ XOOPS CHINA)
- bugfix for time display (reported by kmac @ XOOPS CHINA)
- clean display of regist date (requested by kmac @ XOOPS CHINA)
- bugfix for forum selection in "advanced search" (reported by kmac @ XOOPS CHINA)
- rolling back missed disclaimer (reported by kmac @ XOOPS CHINA)
- bugfix for duplicated security check and post_time_limit check (reported by kmac @ XOOPS CHINA)
- permission check for poll management (reported by karuna @ XOOPS CHINA)

## CBB 1.11
- re-write user info renderer
- bugfix for poster display in thread mode (reported by iamtj @ XOOPS CHINA)
- correction of deleting post message (reported by iamtj @ XOOPS CHINA)
- post backup if submission exceeds session limit or time limit
- correction of encoding problem in XOOPS function formatTimestamp($time, 'rss') (reported by chia @ XOOPS CHINA)

## CBB 1.10
- bugfix and layout improvement (suggested by iamtj @ XOOPS CHINA, fast reply in thread mode, anonymous button, register to post ...)
- rolling back "RSS enable" (requested by Aries @ XOOPS CHINA, CeBepuH @ XOOPS)
- bugfix for template dir in rss.php (reported by jodn007 @ XOOPS CHINA)
- bugfix for caching in rss.php
- bugfix for rss encoding conversion (reported by chia @ XOOPS CHINA)
- read new posts since last visit (Tuning suggested by Peekay @ XOOPS)
- enable 'delete top post' (requested by iamtj @ XOOPS CHINA)
- bugfix for Last Visit recording
- bugfix/improvement for "move forum"
- adding "merge forum"
- post date / poster ip display changed
- options for user level bar
- backward/forward compatible with XOOPS 2.0*

## CBB 1.00
### Improvements over NewBB 2.02:
- CBB uses the same DB stucture/data with NewBB 2, it is convenient to switch between current CBB and current NewBB 2.
- bugfixes for NewBB 2.02
- clean/correct NewBB 2 templates
### New
- dropdown menu selectable for end users: SELECT BOX, CLICK, HOVER
- multi-attachments upload
- RSS improvement, individual RSS Feeds for each category, each forum and the global module
- FPDF improvement, UTF-8 encoding is now working
- user friendly time display, four types: Today, Yesterday, this year and longer than one year
- block handler: recent posts, recent topics, most views, most replies, recent digest, recent sticky, most valuable posters
- time periods for blocks, you could have most views in last 24 hours, most views in this week, most views in this month
- new page: view all posts, view new posts since last visit
- "New member": an introduction thead will be posted automatically when a user logs on for the first time (if enabled)
- adding dobr parameter
