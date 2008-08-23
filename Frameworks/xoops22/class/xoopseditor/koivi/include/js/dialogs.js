/*
*   Samuels [Xoops Project] 
*   based on Justin Koivisto [W.A. Fisher Interactive] Koivi editor
*
*
// $Id: dialogs.js,v 1.1.2.1 2005/06/04 02:11:53 phppp Exp $
*
*/

window.opener = window.opener?window.opener:window.dialogArguments;

function SelectTab(div,divContent,skin)
{
	if (div.className==skin+'selectedTab')return;
	tags = document.getElementsByTagName('div');
	for(i = 0; i<tags.length; i++)
	{
		if (tags[i].className==skin+'selectedTab')
		{
			tags[i].className=skin+'notSelectedTab';
			div.className=skin+'selectedTab';
		}
		else if(tags[i].parentNode.className==skin+'downTabContainer')
		{
			tags[i].style.display="none";
		}
			
	}
	document.getElementById(divContent).style.display="";
	return;
}

function XK_doClean(option)
{
	var doc=document.getElementById('iframe').contentWindow;
	var text=doc.document.body.innerHTML;
	if(option=='word')text=window.opener.XK_cleanWORD(text);
	else text= text.replace(/<\/?[^>]*>/gi,'');
	doc.document.body.innerHTML=text;
};

function XK_updateIframe(id)
{
	var doc=document.getElementById('iframe').contentWindow;
	html=doc.document.body.innerHTML;
	window.opener.XK_insertHTML(html,id);
	if(document.getElementById('checkClose').checked)window.close();
	else window.focus();
};

function XK_disableUrlTextField(value)
{
	var urlSelect=document.getElementById('url');
	var openSelect=document.getElementById('open');
	
	if (value!=''){urlSelect.disabled=true;openSelect.disabled=true;}
	else{ urlSelect.disabled=false;openSelect.disabled=false;}

};

function sendSmilie(id,src) 
{
				window.opener.XK_InsertImage(id,src,'');
				window.close();  
};

//table

function sendTable(id) 
{
	var table				= new Object();		
	table["rows"]			=	document.getElementById('rows').value;
	table["columns"]		=	document.getElementById('columns').value;
	table["width"]			=	document.getElementById('width_value').value;
	table["height"]			=	document.getElementById('height_value').value;
	table["border"]			=	document.getElementById('border').value;
	table["spacing"]		=	document.getElementById('cell_spacing').value;
	table["padding"]		=	document.getElementById('cell_padding').value;
	window.opener.XK_createTable(id,table);
	window.close();  
};

//table props
function sendTableProps(id) 
{
	var table=new Object();
	table=tableValues();
	window.opener.XK_tableProp(id,table);
	window.close();  
};

function tableValues()
{
	var table					= 	new Object();
	
	table["width"]				=	document.getElementById('width').value;
	table["height"]				=	document.getElementById('height').value;
	table["border"]				=	document.getElementById('border').value;
	
	table["bgColor"]			=	document.getElementById('bgColor').value;
	table["backgroundImage"]	=	document.getElementById('backgroundImage').value;
	table["borderColor"]		=	document.getElementById('bordertColor').value;
	
	table["cellSpacing"]		=	document.getElementById('spacing').value;
	table["cellPadding"]		=	document.getElementById('padding').value;
	
	table["className"]			=	document.getElementById('class').value;
	
	table["collapse"]			=	(document.getElementById('collapse').checked)?"collapse":"";
	
	return table;
};


			
function initTableProps(id) 
{
	var table = window.opener.XK_tableProp(id,null);
	if (table.width==null)window.close();
	document.getElementById('width').value = table.width;
	document.getElementById('height').value = (table.height)?table.height:'';
	document.getElementById('border').value = table.border;
	document.getElementById('spacing').value = table.cellSpacing;
	document.getElementById('padding').value = table.cellPadding;
	document.getElementById('bgColor').value = table.bgColor;
	document.getElementById('bordertColor').value = table.borderColor;
	document.getElementById('class').value	=table.className;


	if(table.collapse.toLowerCase()=='collapse')document.getElementById('collapse').checked = true;
	
	bgimage=table.backgroundImage.replace('url(','');
	bgimage=bgimage.replace(')','');
	document.getElementById('backgroundImage').value = bgimage?bgimage:'';
	
	
	tablePreview();
	window.focus();
};

function tablePreview() 
{
				
	var table		= 	new Object();
	table			= tableValues();	
	var previewItem = document.getElementById('previewTable');

	previewItem.width  = table["width"];
	previewItem.height = table["height"];
	previewItem.border = table["border"];	
	previewItem.bgColor= table["bgColor"];
	//previewItem.style.backgroundImage= table["backgroundImage"];
	previewItem.borderColor= table["borderColor"];	
	previewItem.cellPadding= table["cellSpacing"];
	previewItem.cellSpacing= table["cellPadding"];
	previewItem.style.borderCollapse = table["collapse"];

};	

function XK_TableC(id, color)
{
	textfield=document.getElementById('coloroption').value;
	document.getElementById(textfield).value=color;
	document.getElementById('colorPalette'+id).style.display="none";
	tablePreview();
};
//end table


//cell dialog
function sendCell(id) 
{
	var cell					= 	new Object();
	cell						=	CellValues();
	window.opener.XK_cellProp(id,cell);
	window.close();  
};
			
function initCellProps(id) 
{
	var cell = window.opener.XK_cellProp(id,null);
	if (cell==null)window.close();			
	document.getElementById('borderLeftStyle').value=cell["borderLeftStyle"];
	document.getElementById('borderRightStyle').value = cell["borderRightStyle"];
	document.getElementById('borderTopStyle').value = cell["borderTopStyle"];
	document.getElementById('borderBottomStyle').value = cell["borderBottomStyle"];
			
	document.getElementById('borderLeftWidth').value = (cell["borderLeftWidth"])?getWidth(cell["borderLeftWidth"]):'';
	document.getElementById('borderRightWidth').value = (cell["borderRightWidth"])?getWidth(cell["borderRightWidth"]):'';
	document.getElementById('borderTopWidth').value = (cell["borderTopWidth"])?getWidth(cell["borderTopWidth"]):'';
	document.getElementById('borderBottomWidth').value = (cell["borderBottomWidth"])?getWidth(cell["borderBottomWidth"]):'';
	
	document.getElementById('borderLeftUnits').value = (cell["borderLeftWidth"])?getUnits(cell["borderLeftWidth"]):'px';
	document.getElementById('borderRightUnits').value = (cell["borderRightWidth"])?getUnits(cell["borderRightWidth"]):'px';
	document.getElementById('borderTopUnits').value = (cell["borderTopWidth"])?getUnits(cell["borderTopWidth"]):'px';
	document.getElementById('borderBottomUnits').value = (cell["borderBottomWidth"])?getUnits(cell["borderBottomWidth"]):'px';
				
	document.getElementById('borderLeftColor').value = cell["borderLeftColor"];
	document.getElementById('borderRightColor').value = cell["borderRightColor"];
	document.getElementById('borderTopColor').value = cell["borderTopColor"];
	document.getElementById('borderBottomColor').value = cell["borderBottomColor"];
				
	document.getElementById('bgColor').value = cell["bgColor"];
	document.getElementById('class').value = cell["className"];
	
	document.getElementById('cellWidth').value = getWidth(cell["width"]);
	document.getElementById('cellHeight').value = getWidth(cell["height"]);
	document.getElementById('widthUnits').value = getUnits(cell["width"]);
	document.getElementById('heightUnits').value = getUnits(cell["height"]);
	
	document.getElementById('paddingLeft').value = (cell["paddingLeft"])?getWidth(cell["paddingLeft"]):'';
	document.getElementById('paddingRight').value = (cell["paddingRight"])?getWidth(cell["paddingRight"]):'';
	document.getElementById('paddingTop').value = (cell["paddingTop"])?getWidth(cell["paddingTop"]):'';
	document.getElementById('paddingBottom').value = (cell["paddingBottom"])?getWidth(cell["paddingBottom"]):'';
	
	document.getElementById('paddingLeftUnits').value = (cell["paddingLeft"])?getUnits(cell["paddingLeft"]):'px';
	document.getElementById('paddingRightUnits').value = (cell["paddingRight"])?getUnits(cell["paddingRight"]):'px';
	document.getElementById('paddingTopUnits').value = (cell["paddingTop"])?getUnits(cell["paddingTop"]):'px';
	document.getElementById('paddingBottomUnits').value = (cell["paddingBottom"])?getUnits(cell["paddingBottom"]):'px';
	
	
	bgimage=cell["backgroundImage"].replace('url(','');
	bgimage=bgimage.replace(')','');
	document.getElementById('backgroundImage').value = bgimage?bgimage:'';

	cellPreview();
	window.focus();


};

function CellValues() 
{
	var cell					= 	new Object();
	cell["borderLeftStyle"]		=	document.getElementById('borderLeftStyle').value?document.getElementById('borderLeftStyle').value:'';
	cell["borderRightStyle"]	=	document.getElementById('borderRightStyle').value?document.getElementById('borderRightStyle').value:'';
	cell["borderTopStyle"]		=	document.getElementById('borderTopStyle').value?document.getElementById('borderTopStyle').value:'';
	cell["borderBottomStyle"]	=	document.getElementById('borderBottomStyle').value?document.getElementById('borderBottomStyle').value:'';
	cell["borderLeftWidth"]		=	document.getElementById('borderLeftWidth').value?document.getElementById('borderLeftWidth').value+document.getElementById('borderLeftUnits').value:'';
	cell["borderRightWidth"]	=	document.getElementById('borderRightWidth').value?document.getElementById('borderRightWidth').value+document.getElementById('borderRightUnits').value:'';
	cell["borderTopWidth"]		=	document.getElementById('borderTopWidth').value?document.getElementById('borderTopWidth').value+document.getElementById('borderRightUnits').value:'';
	cell["borderBottomWidth"]	=	document.getElementById('borderBottomWidth').value?document.getElementById('borderBottomWidth').value+document.getElementById('borderBottomUnits').value:'';
	cell["borderLeftColor"]		=	document.getElementById('borderLeftColor').value;
	cell["borderRightColor"]	=	document.getElementById('borderRightColor').value;
	cell["borderTopColor"]		=	document.getElementById('borderTopColor').value;
	cell["borderBottomColor"]	=	document.getElementById('borderBottomColor').value;
	cell["bgColor"]				=	document.getElementById('bgColor').value;
	cell["className"]			=	document.getElementById('class').value;
	cell["backgroundImage"]		=	document.getElementById('backgroundImage').value;
	cell["width"]				=	document.getElementById('cellWidth').value?document.getElementById('cellWidth').value+document.getElementById('widthUnits').value:'';
	cell["height"]				=	document.getElementById('cellHeight').value?document.getElementById('cellHeight').value+document.getElementById('heightUnits').value:'';
	cell["paddingLeft"]			=	document.getElementById('paddingLeft').value?document.getElementById('paddingLeft').value+document.getElementById('paddingLeftUnits').value:'';
	cell["paddingRight"]		=	document.getElementById('paddingRight').value?document.getElementById('paddingRight').value+document.getElementById('paddingRightUnits').value:'';
	cell["paddingTop"]			=	document.getElementById('paddingTop').value?document.getElementById('paddingTop').value+document.getElementById('paddingTopUnits').value:'';
	cell["paddingBottom"]		=	document.getElementById('paddingBottom').value?document.getElementById('paddingBottom').value+document.getElementById('paddingBottomUnits').value:'';
	return(cell);
};

function cellPreview() 
{
				
	var cell		= 	new Object();
	cell			= CellValues();	
	var previewItem = document.getElementById('previewCell');
				
	//bg color
	previewItem.bgColor = cell["bgColor"];
	
	//bg image
	//previewItem.style.backgroundImage = 'url(' + cell["backgroundImage"] + ')';
	
	//borders style
	previewItem.style.borderLeftStyle 	= cell["borderLeftStyle"];
	previewItem.style.borderRightStyle 	= cell["borderRightStyle"];
	previewItem.style.borderTopStyle 	= cell["borderTopStyle"];
	previewItem.style.borderBottomStyle = cell["borderBottomStyle"];
			
	//borders Width
	previewItem.style.borderLeftWidth 	= cell["borderLeftWidth"];
	previewItem.style.borderRightWidth	= cell["borderRightWidth"];
	previewItem.style.borderTopWidth 	= cell["borderTopWidth"];
	previewItem.style.borderBottomWidth = cell["borderBottomWidth"];
			
	//borders Color
	previewItem.style.borderLeftColor 	= cell["borderLeftColor"];
	previewItem.style.borderRightColor 	= cell["borderRightColor"];
	previewItem.style.borderTopColor 	= cell["borderTopColor"];
	previewItem.style.borderBottomColor = cell["borderBottomColor"];
	
	//width and height
	previewItem.width 	= cell["width"];
	previewItem.height 	=cell["height"];
	
	//padding
	if(cell["paddingLeft"]||cell["paddingRight"]||cell["paddingTop"]||cell["paddingBottom"])
	{
		previewItem.style.paddingLeft=cell["paddingLeft"];
		previewItem.style.paddingRight=cell["paddingRight"];
		previewItem.style.paddingTop=cell["paddingTop"];
		previewItem.style.paddingBottom=["paddingBottom"];
	}

};	

function XK_CC(id, color)
{
	textfield=document.getElementById('coloroption').value;
	document.getElementById(textfield).value=color;
	document.getElementById('colorPalette'+id).style.display="none";
	cellPreview();
};

//image properties dialog
function imageValues() 
{
	var image					= 	new Object();
	
	image["alt"]				=	document.getElementById('alt').value;
	image["src"]				=	document.getElementById('src').value;
	image["align"]				=	document.getElementById('align').value;
	image["width"]				=	document.getElementById('width').value;
	image["height"]				=	document.getElementById('height').value;
	image["hspace"]				=	document.getElementById('hspace').value;
	image["vspace"]				=	document.getElementById('vspace').value;
	image["className"]			=	document.getElementById('className').value;
	
	//borders style
	image["borderLeftStyle"]	=	document.getElementById('borderLeftStyle').value;
	image["borderRightStyle"]	=	document.getElementById('borderRightStyle').value;
	image["borderTopStyle"]		=	document.getElementById('borderTopStyle').value;
	image["borderBottomStyle"]	=	document.getElementById('borderBottomStyle').value;
	
	//borders width
	image["borderLeftWidth"]	=	document.getElementById('borderLeftWidth').value?document.getElementById('borderLeftWidth').value+document.getElementById('borderLeftUnits').value:'';
	image["borderRightWidth"]	=	document.getElementById('borderRightWidth').value?document.getElementById('borderRightWidth').value+document.getElementById('borderRightUnits').value:'';
	image["borderTopWidth"]		=	document.getElementById('borderTopWidth').value?document.getElementById('borderTopWidth').value+document.getElementById('borderTopUnits').value:'';
	image["borderBottomWidth"]	=	document.getElementById('borderBottomWidth').value?document.getElementById('borderBottomWidth').value+document.getElementById('borderBottomUnits').value:'';
	
	//borders color
	image["borderLeftColor"]	=	document.getElementById('borderLeftColor').value;
	image["borderRightColor"]	=	document.getElementById('borderRightColor').value;
	image["borderTopColor"]		=	document.getElementById('borderTopColor').value;
	image["borderBottomColor"]	=	document.getElementById('borderBottomColor').value;
	
	//margins
	image["marginLeft"]			=	document.getElementById('marginLeft').value?document.getElementById('marginLeft').value+document.getElementById('marginLeftUnits').value:'';
	image["marginRight"]		=	document.getElementById('marginRight').value?document.getElementById('marginRight').value+document.getElementById('marginRightUnits').value:'';
	image["marginTop"]			=	document.getElementById('marginTop').value?document.getElementById('marginTop').value+document.getElementById('marginTopUnits').value:'';
	image["marginBottom"]		=	document.getElementById('marginBottom').value?document.getElementById('marginBottom').value+document.getElementById('marginBottomUnits').value:'';
	return(image);
};

function imagePreview() 
{
				
	var image		= new Object();
	image			= imageValues();	
	var previewItem = document.getElementById('previewimage');
				
	//borders style
	previewItem.style.borderLeftStyle 	= image["borderLeftStyle"];
	previewItem.style.borderRightStyle 	= image["borderRightStyle"];
	previewItem.style.borderTopStyle 	= image["borderTopStyle"];
	previewItem.style.borderBottomStyle = image["borderBottomStyle"];
			
	//borders Width
	previewItem.style.borderLeftWidth 	= image["borderLeftWidth"];
	previewItem.style.borderRightWidth	= image["borderRightWidth"];
	previewItem.style.borderTopWidth 	= image["borderTopWidth"];
	previewItem.style.borderBottomWidth = image["borderBottomWidth"];
			
	//borders Color
	previewItem.style.borderLeftColor 	= image["borderLeftColor"];
	previewItem.style.borderRightColor 	= image["borderRightColor"];
	previewItem.style.borderTopColor 	= image["borderTopColor"];
	previewItem.style.borderBottomColor = image["borderBottomColor"];
	
	//width and height
	if (image["width"])previewItem.width 	= image["width"];
	if (image["height"])previewItem.height 	= image["height"];
	
	//borders margin
	previewItem.style.marginLeft 	= image["marginLeft"];
	previewItem.style.marginRight 	= image["marginRight"];
	previewItem.style.marginTop 	= image["marginTop"];
	previewItem.style.marginBottom  = image["marginBottom"];
	
	//align
	previewItem.align= image["align"];
	previewItem.src= image["src"];	
};	

function XK_ImgPrev(id, color)
{
	textfield=document.getElementById('coloroption').value;
	document.getElementById(textfield).value=color;
	document.getElementById('colorPalette'+id).style.display="none";
	imagePreview();
};			
		

function sendImage(id) 
{
	var image = 	new Object();
	image	 =	imageValues();		
	window.opener.XK_imageProps(id,image);
	window.close();  
};
			
function initImageProps(id,url) 
{
	var image = window.opener.XK_imageProps(id,null);
		
	if(image==null)window.close();
		
	//Koivi anchor cant be edited
	if (image["src"]==url+"/skins/common/anchor.gif")window.close();
				
	document.getElementById('alt').value	=	image["alt"];
	document.getElementById('src').value	=	image["src"];
	document.getElementById('width').value	=	image["width"];
	document.getElementById('height').value	=	image["height"];
	document.getElementById('align').value	=	image["align"];
	if(image["hspace"]!=-1 && image["hspace"]!=0)document.getElementById('hspace').value	=	image["hspace"];
	if(image["vspace"]!=-1 && image["vspace"]!=0)document.getElementById('vspace').value	=	image["vspace"];
	document.getElementById('className').value	=	image["className"];
	
	document.getElementById('borderLeftStyle').value=image["borderLeftStyle"];
	document.getElementById('borderRightStyle').value = image["borderRightStyle"];
	document.getElementById('borderTopStyle').value = image["borderTopStyle"];
	document.getElementById('borderBottomStyle').value = image["borderBottomStyle"];
			
	document.getElementById('borderLeftWidth').value = image["borderLeftWidth"]?getWidth(image["borderLeftWidth"]):'';
	document.getElementById('borderRightWidth').value = image["borderRightWidth"]?getWidth(image["borderRightWidth"]):'';
	document.getElementById('borderTopWidth').value = image["borderTopWidth"]?getWidth(image["borderTopWidth"]):'';
	document.getElementById('borderBottomWidth').value = image["borderBottomWidth"]?getWidth(image["borderBottomWidth"]):'';

	document.getElementById('borderLeftUnits').value = image["borderLeftWidth"]?getUnits(image["borderLeftWidth"]):'px';
	document.getElementById('borderRightUnits').value = image["borderRightWidth"]?getUnits(image["borderRightWidth"]):'px';
	document.getElementById('borderTopUnits').value = image["borderTopWidth"]?getUnits(image["borderTopWidth"]):'px';
	document.getElementById('borderBottomUnits').value = image["borderBottomWidth"]?getUnits(image["borderBottomWidth"]):'px';	
						
	document.getElementById('borderLeftColor').value = image["borderLeftColor"];
	document.getElementById('borderRightColor').value = image["borderRightColor"];
	document.getElementById('borderTopColor').value = image["borderTopColor"];
	document.getElementById('borderBottomColor').value = image["borderBottomColor"];
	
	document.getElementById('marginLeft').value = getWidth(image["marginLeft"]);
	document.getElementById('marginRight').value = getWidth(image["marginRight"]);
	document.getElementById('marginTop').value = getWidth(image["marginTop"]);
	document.getElementById('marginBottom').value = getWidth(image["marginBottom"]);
	
	document.getElementById('marginLeftUnits').value = getUnits(image["marginLeft"]);
	document.getElementById('marginRightUnits').value = getUnits(image["marginRight"]);
	document.getElementById('marginTopUnits').value = getUnits(image["marginTop"]);
	document.getElementById('marginBottomUnits').value = getUnits(image["marginBottom"]);
	imagePreview();
	window.focus();
};

function getWidth(value)
{
	width=value.substring(0,value.length-2);
	return(width);

};

function getUnits(value)
{
	units=value.substring(value.length-2,value.length);
	return units;
};

//override functions
function XK_over(id,color)
{
	document.getElementById('colortextf'+id).style.backgroundColor =color;
	document.getElementById('showc'+id).value =color;
};

function XK_InsertImage(id,src,alt)
{
	document.getElementById('backgroundImage').value=src;
};

function XK_color(id)
{
	document.getElementById('coloroption').value=id+'Color';
	XK_showHideDiv(id,'colorPalette');
};

//Shows/Hides a Div Layer
function XK_showHideDiv(buttonId,divId)
{
	var divid=divId;
	buttonElement=document.getElementById(buttonId);
	document.getElementById(divid).style.left=window.opener.XK_getOffsetLeft(buttonElement) + "px";
	document.getElementById(divid).style.top=(window.opener.XK_getOffsetTop(buttonElement) + buttonElement.offsetHeight) + "px";
	if(document.getElementById(divid).style.display=="none")
	{
		document.getElementById(divid).style.display="";
	}
	else document.getElementById(divid).style.display="none";
};


function openWithSelfMain(url,name,width,height) 
{
	var options = "width=" + width + ",height=" + height + "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no";
	new_window = window.open(url, name, options);
	window.self.name = "main";
	new_window.focus();
};

function onlyNumbers(e,id)
{
	var value=document.getElementById(id).value;
	e = e?e:event;
	var keyCode =e.keyCode?e.keyCode:e.charCode;
	return (( keyCode >= 48 && keyCode <= 57 )||keyCode ==8||(keyCode ==46 && value.indexOf('.')==-1)||(keyCode >= 37 && keyCode <= 40));
}

function onlyHexNumbers(e,id)
{
	var value=document.getElementById(id).value?document.getElementById(id).value:'';
	e = e?e:event;
	var keyCode =e.keyCode?e.keyCode:e.charCode;
	return (
	( keyCode >= 48 && keyCode <= 57 )||( keyCode >= 65 && keyCode <= 70 )||( keyCode >= 97 && keyCode <= 102)||keyCode ==8||(keyCode ==35 && value.indexOf("#")==-1)||(keyCode >= 37 && keyCode <= 40));
}