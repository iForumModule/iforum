IFORUM 1.0

ImpressCMS bulletin Board, for ImpressCMS 1.1*

iforum, is fork of newbb (aka CBB), at this stage it just has some minor changes to work efficient with ImpressCMS 1.1
We will have a total code re-writing at a later stage!

Stranger
http://www.impresscms.org


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

