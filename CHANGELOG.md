# iForum Changelog

## 3.0 beta 1
25 october 2026
### Breaking changes
* requires ImpressCMS 2.0.4 and PHP 8.2
* polls (xoopspoll integration) have been removed; existing poll data in the database is left untouched
* tags (tag module integration) have been removed; the topic_tags column is kept
* removed the unused rank compat handler and the duplicate forum handler
### Compatibility
* replace $xoopsUser, $xoopsRequestUri and $icmsPreloadHandler globals with icms::$user, $_SERVER['REQUEST_URI'] and icms::$preload
* replace XoopsTree, XoopsTpl, xoops_confirm and xoops_trim with their ImpressCMS equivalents
* use icms_module_header and icms_pagetitle instead of the deprecated xoops_ variants
* use icms_core_DataFilter instead of deprecated icms_core_Textsanitizer methods
* use icms_plugins_EditorHandler for the editor
### Fixes
* fix mysql_fetch_assoc call, duplicate WHERE in the forum manager and the getAllPosts signature
* fix null values passed to the text sanitizer
* create the upload folders on install and update instead of when loading the module manifest
* restrict unserialize and remove eval
## 2.4 beta 1
18 july 2024
### Prepare for ICMS 2.0
* refactor use of global $icmsModule to icms::$module
* fix database access
* moved the module below the /src folder
## 2.3
13 july 2021
* HTML Tags in translations from font to span
* add missing translation variable $constpref
* Compatibility with PHP up to 7.4
* myTextSanitizer -> icms_core_TextSanitizer
* remove end tags in files
## 2.0
29 November 2017
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

## iForum 1.0
18 Sept 2011
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
