CBB

XOOPS Community Bulletin Board
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
