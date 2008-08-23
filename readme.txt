CBB

XOOPS Community bulletin Board
The further development of NewBB 2 developed by Marko Schmuck (predator) and D.J. (phppp)

CBB XOOPS Installation:
1 Make a full backup for your XOOPS
2 upload the files to xoops/modules/newbb
3 add dropdow menu color CSS to theme/style.css (Appendix)
3 If upgrade from newbb 1.0, run newbb/update/newbb1_to_newbb2.php [NO need if upgrade from newbb 2.*]
4 update newbb from Administration Area
5 set module preferences and permission(!Important). Some suggestions:
-- Disable png hack and select gif for imageset if your server is not powerful enough
-- Make sure you have <{$xoops_module_header}> in theme.html header

Changelog over NewBB 2.02:
1 CBB uses the same DB stucture/data with NewBB 2, it is convenient to switch between current CBB and current NewBB 2.
2 bugfixes for NewBB 2.02
3 clean/correct NewBB 2 templates

Major new features ( most suggested by XOOPS CHINA users)
1 dropdown menu selectable for end users: SELECT BOX, CLICK, HOVER
2 multi-attachments upload
3 RSS improvement, individual RSS Feeds for each category, each forum and the global module
4 FPDF improvement, UTF-8 encoding is now working
5 user friendly time display, four types: Today, Yesterday, this year and longer than one year
6 block handler: recent posts, recent topics, most views, most replies, recent digest, recent sticky, most valuable posters
7 time periods for blocks, you could have most views in last 24 hours, most views in this week, most views in this month
8 new page: view all posts, view new posts since last visit
9 "New member": an introduction thead will be posted automatically when a user logs on for the first time (if enabled)
10 adding dobr parameter


CBB
SITE: HTTP://XOOPS.ORG.CN
DEMO: HTTP://XOOPS.ORG.CN
SUPP: http://xoops.org.cn/modules/newbb/viewforum.php?forum=17

Appendix
theme/style.css adding dropdown menu color as following:
/* color -- dropdown menu for Forum */
#dropdown a{
	color:#FFFFFF;
	}

#dropdown .menubar, #dropdown .menu, #dropdown .item, #dropdown .separator{
	background-color: #99B5CC;
	color:#FFFFFF;
	}

#dropdown .separator{
	border: 1px inset #e0e0e0;
	}

#dropdown .menu a:hover{
	color: #333;
	}
/* color - end */
