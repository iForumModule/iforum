CBB 3.0

XOOPS Community bulletin Board 3.0, for XOOPS 2.0*, 2.2* and 2.3*

D.J.
http://xoops.org.cn
http://xoopsforge.com


Appendix
1 Dropdown menu color configuration: adding dropdown menu color to theme/style.css as following:
/* color -- dropdown menu for Forum */
div.dropdown a, div.dropdown .menubar a{
	color:#FFF;
}

div.dropdown .menu, div.dropdown .menubar, div.dropdown .item, div.dropdown .separator{
	background-color: #2F5376; /* color set in your theme/style.ss .th{} is recommended */
	color:#FFF;
}

div.dropdown .separator{
	border: 1px inset #e0e0e0;
}

div.dropdown .menu a:hover, div.dropdown .userbar a:hover{
	color: #333;
}
/* color - end */

2 Fix for "right-to-left" themes (Arabic, Persian and more): adding to theme/style.css as following:

/* direction -- for rtl */
div.dropdown ul, div.dropdown .userbar{
	direction: ltr;
}

div.dropdown li ul {
	left: -150px !important; /* for IE, tune the value if necessary */
}
div.dropdown li>ul { 
	left: -1px !important; /* for non-IE, tune the value if necessary */
}

div.dropdown .userbar{
	float: right !important;  /* need a more formal solution, any help would be appreciated */
}
/* direction fix end */