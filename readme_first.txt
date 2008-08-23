NewBB 2.0.2 Final release

The Xoops Project is pleased to announce the Final of the

Newbb 2.0.2


Brief Introduction to the Changes:

- Bugfix: silly delete Bug
- Bugfix: Poll Button was visible even if selected disallow in the Forum settings
- Bugfix: " was missing in templates viewtopic_flat.html and viewtopic_thread.html
- Bugfix: read / unread
- Bugfix: search typo error
- Added: TinyMCE Editor support
- Added: Permission setting for the Subject Prefix


- Changes in the Language Files:

added

-- main.php
---- define("_MD_FORM_TINYMCE","TinyMCE Editor");
-- modinfo.php
---- define("_MI_SUBJECT_PREFIX_LEVEL", "Level for groups that can use Prefix");
---- define("_MI_SUBJECT_PREFIX_LEVEL_DESC", "Choose the groups allowed to use prefix.");
---- define("_MI_SPL_DISABLE", 'Disable');
---- define("_MI_SPL_ANYONE", 'Anyone');
---- define("_MI_SPL_MEMBER", 'Members');
---- define("_MI_SPL_MODERATOR", 'Moderators');
---- define("_MI_SPL_ADMIN", 'Administrators');
---- define("_MI_FORM_TINYMCE","TinyMCE Editor");


Helpfiles included ( thanks to the french Xoops Support and philou )


Now, Get the:
-- [url=http://dev.xoops.org/modules/xfmod/project/showfiles.php?group_id=1001] Newbb 2.0.2 Final [/url]
-- [url=http://dev.xoops.org/modules/xfmod/project/showfiles.php?group_id=1001] Newbb 2.0.2 Final Update [/url]


[b]If you update from 2.0.1 to 2.0.2[/b]

just overwrite the files with the files in the update package and update the module in the moduleadmin. 


Update Scripts Along with the Package:
-- Newbb 1 to Newbb 2.0.2       ( newbb1_to_newbb2.php )
-- Newbb 2.0 RC1 to Newbb 2.0.2 ( newbb2rc1_to_newbb2.php )
-- Newbb 2.0 RC2 to Newbb 2.0.2 ( newbb2rc2_to_newbb2.php )
-- Newbb 2.0 RC3 to Newbb 2.0.2 ( newbb2rc3_to_newbb2.php )
-- Newbb Pro 1.03 to Newbb 2.0.2 ( newbbpro_to_newbb2.php )

[b]
MUST-DO: replace your /modules/system/admin/modulesadmin/main.php with the
-- [url=http://sourceforge.net/tracker/index.php?func=detail&aid=1052403&group_id=41586&atid=430842] Bugfix for block update[/url]
[/b]

Language Packages available on the download site:
-- English
-- French
-- Protuguesebr
-- German
-- Persian
-- Netherlands
-- Spanish
-- S/T Chinese (available at Xoops China)
-- Swedisch

MUST-DOs to Enjoy NewBB 2.0.2 if you update from NewBB 2.0:
[b]1. Upload the New Files
2. Update the NewBB Module in the Moduleadmin
3. To make the Popup Menu work, make sure that the [url=http://www.xoops.org/modules/newbb/viewtopic.php?topic_id=25275&forum=28&post_id=110408] <{$xoops_module_header}>[/url] is included in your theme.html
4. Update the newbb templates[/b]


MUST-DOs to Enjoy NewBB 2.0.2 if you update from NewBB 1.0:
[b]1. Delete all Files in your old newbb folder
2. Upload the New Files and Run the Proper Update Script
3. Update the NewBB Module in the Moduleadmin
4. Set Permissions for the Categories and Forums
5. To make the Popup Menu work, make sure that the [url=http://www.xoops.org/modules/newbb/viewtopic.php?topic_id=25275&forum=28&post_id=110408] <{$xoops_module_header}>[/url] is included in your theme.html
6. Update the newbb templates[/b]



MUST-DOs to Enjoy NewBB 2.0.2 if you update from NewBB 2.0 RC3:
1. Upload the New Files and Run the Proper Update Scripts
2. Update the NewBB Module in the Moduleadmin
3. Update the newbb templates



MUST-DOs to Enjoy NewBB 2.0.2 if you update from NewBB 2.0 RC2:
1. Upload the New Files and Run the Proper Update Scripts
2. Update the NewBB Module in the Moduleadmin
3. Update the newbb templates


With NewBB 2.0 you can add blocks on-fly as following.

1 Enter 'Administration Menu'=>"block admin"=>"Add new block"

2 In the "Add a new block":

2.1 Block Type: choose anyone as you prefer
2.2 Weight: input any valid value as you prefer
2.3 Visible: select any one as you prefer
2.4 Visible in: set any one as you prefer
2.5 Title: input any valid text as you prefer
2.6 Content:

include_once(XOOPS_ROOT_PATH . '/modules/newbb/blocks/newbb_block.php');
$options = "10|0|time|0";
b_newbb_custom($options);
//$options = "TheNumberToDisplay|ViewMode(0?1?2?)|time_Or_reviews_Or_replies|ForumId1,ForumId2,ForumId3";


2.7 Content Type: MUSTBE "PHP Script"
2.8 Cache lifetime: choose any one as you prefer
2.9 Preview, Submit: press any one as you prefer, BE SURE press at least one time "submit" before leaving block admin


For any suggestions, comments, bug report and feature request:
http://dev.xoops.org/modules/xfmod/project/?newbb Official NewBB 2.0 Project
http://www.xoops2.org Demo NewBB 2.0 Project

The NewBB project Team is always looking forward to security vulnerability report and fix, as well as other bug report, from ALL XOOPS COMMUNITIES.

The NewBB 2.0 belongs to all xoopers, the NewBB Project Team, the Xoops Developers and Supporters, the Xoops users.

Greetz Predator and phppp

