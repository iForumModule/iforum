/*
*   Samuels [Xoops Project] 
*   Based on Justin Koivisto [W.A. Fisher Interactive] Koivi editor
*
*
// $Id: editor.js,v 1.1.2.1 2005/06/04 02:11:53 phppp Exp $
*
*/

var editors = new Array();//ACTIVE EDITORS
var isie;
var url;

//init wysiwyg editor
function XK_init(id, isiexplore, editorurl,textdirection)
{
	isie=isiexplore;
	url=editorurl;
	var doc=document.getElementById("iframe"+id).contentWindow.document;

	if(isie)
	{
		if (document.readyState != 'complete')
		{
       		setTimeout(function(){ XK_init(id, isiexplore, editorurl,textdirection);},100);
       		return;
     	}
     	doc.designMode="On";
	}

	else
	{
		//try if mozilla is ready to go
		try {setTimeout(function(){doc.designMode="On";doc.execCommand("usecss",false,true);},1000);}
		//I don't know how to do if it fails
		catch (e) {alert("ERROR: can't load the editor, please refresh the page");}
	} 

	if (!XK_registered(id)){editors[editors.length] = id;}

	//update hidden text fields on submit
	XK_onSubmitHandler(id);
	
	//update iframes with textfields values
	XK_insertText(id);
		
	//add hide floating menus event handlers;
	XK_attachEvent(document,"mousedown",XK_hideMenus);
	XK_attachEvent(doc,"mousedown",XK_hideMenus);

	//contextmenu:
	contextmenu =new XK_contextMenu(id);
	
	//set text direction
	if(textdirection=="rtl")XK_textDirection(textdirection,id);
	
	//destroy <p></p> on enter 
	if(isie)XK_destroyPTag(id);	
};

function XK_appendXoopsCss(id,themeCss)
{
	if(themeCss)
	{
		if(document.getElementById("cssEnabled"+id).checked)XK_AppendCss(id,themeCss,"xoopsTheme");
		else XK_DeleteCss(id,"xoopsTheme");
	}
}

function XK_destroyPTag(id)
{
	//disable manual undo "ctrl+z" because sometimes iexplore goes crazy.NOT NEEDED BY NOW
	//if (doc.event.ctrlKey && doc.event.keyCode == 90)return false;
	
	var doc = document.getElementById("iframe"+id).contentWindow;
	try{var enabled = document.getElementById("ptagenabled"+id).checked;}catch(e){var enabled=false;};
	
	if (!enabled)
	{
		doc.document.onkeydown = function () 
		{ 
			if ( (doc.event.keyCode == 13) ) 						
			{
				if ( !(XK_excludedTags(id)) && !(doc.document.queryCommandState( "insertunorderedlist" )) && !(doc.document.queryCommandState( "insertorderedlist" )))
				{
					XK_cancelBubble(doc.event);
					XK_insertHTML("<br>",id);
					return false;
				}else return;
				
			}
			else return;
		};
	}
	else
	{
		doc.document.onkeydown = function (){};	
	}
	doc.focus();			
};

function XK_excludedTags(id)
{
	var exludedTags=["H1","H2","H3","H4","H5","H6","PRE","ADDRESS","BLOCKQUOTE"];
	
	for(i=0;i< exludedTags.length;i++)
	{
		if(XK_isInsideThisTag(id,exludedTags[i])) return true;
	}
	return false;
}

//update iframe on init
function XK_insertText(id)
{
	//replace <strong>,<me> tags by <b><li> and others used by mozilla
	var my_content=XK_toWYSIWYG(document.getElementById(id).value);

	var doc=document.getElementById("iframe"+id).contentWindow;
	doc.document.open();	
	doc.document.write(my_content);
	doc.document.close();
};

function XK_registered(id)
{
    var found = false;
    for(i=0;i<editors.length;i++)
    {
	  if ((editors[i]).toUpperCase() == id.toUpperCase())
      {
        found = true;
	    break;
      }
    }
    return(found);
};

//update textfields on submit
function XK_onSubmitHandler(id)
{
    var sTemp = "";
    oForm = document.getElementById(id).form;

    if(oForm.onsubmit != null) {
      sTemp = oForm.onsubmit.toString();
      iStart = sTemp.indexOf("{") + 2;
      sTemp = sTemp.substr(iStart,sTemp.length-iStart-2);
    }
    if (sTemp.indexOf("XK_updateFields();") == -1)
    {
      oForm.onsubmit = new Function("XK_updateFields();" + sTemp);
    }
};

function XK_updateFields()
{
	var text;
	//var html_source;
	for (i=0; i<editors.length; i++)
	{	  
		//if html mode toggle to wysiwyg
		if (document.getElementById("iframe"+editors[i]).style.display=="none")XK_doToggleView(editors[i]);
		var doc=document.getElementById("iframe"+editors[i]).contentWindow.document;
		
		//I need to sanitize the HTML, so it's a must to take the DOM tree from the iframe
		var text=(document.getElementById(editors[i]).value.indexOf("<body")!=-1)?XK_getXHTML(doc):XK_getXHTML(doc.body);
		text=XK_removeLineBreaks(text);
	
		//now I'm sure the textfield is updated with the cleaned HTML
		document.getElementById(editors[i]).value=text;
	}
};

function XK_maximizeEditor(id)
{
	var doc=document.getElementById("iframe"+id).contentWindow.document;
	
	if(document.getElementById("alleditor"+id).style.position!="absolute")
	{
		document.getElementById("floatButton"+id).style.display="none";
		document.getElementById("alleditor"+id).style.position="absolute";
		document.getElementById("alleditor"+id).style.width=document.body.clientWidth-4+"px";
		
		//push editor to top
		document.getElementById("alleditor"+id).style.left="0px";
		document.getElementById("alleditor"+id).style.top="0px";
	}
	else 
	{
		document.getElementById("alleditor"+id).style.position="";
		document.getElementById("alleditor"+id).style.width="100%";
		document.getElementById("floatButton"+id).style.display="";
	}
	if(!isie){doc.designMode="On";doc.execCommand("usecss",false,true);}
	
	//go to top of the page
	document.documentElement.scrollTop=0;
	document.getElementById("iframe"+id).contentWindow.focus();
}

function XK_doTextFormat(command, option,id,value)
{
	var doc= document.getElementById("iframe"+id).contentWindow;
	switch(command)
	  {		
		//deprecated function, I'll make an advanced url dialog some day...
		case "createlink":
			if(XK_getSelectedText(id)==''){alert('Select content first');break;}
			
			if(!isie)
			{	
				var iurl=prompt("Enter a URL:", "");
        			if(document.getElementById("iframe"+id).contentWindow.document.queryCommandEnabled(command))
				{
      	      		try{doc.document.execCommand("createlink",false,iurl);}catch(e){};     	       		
      	      		return true;
				}
				else return false;
			}
			else try{doc.document.execCommand("createlink",false);}catch(e){};
			break;
		
		case "Quote":
		case "Code":
			XK_addCodes(command,id);
			break;
			
		case "insertimage":
			XK_InsertImage(id);
			break;
		
		case "fontsize":
		case "fontname":
		case "formatblock":
			XK_fontFormat(command,option,id);
			break;
			
 		default:
        	if(doc.document.queryCommandEnabled(command))
			{
			  try{doc.document.execCommand(command,false,value);}catch(e){};
			  doc.focus();
              return true;
        	}
			else 
			return false;
			break;
	  }
};

function XK_fontFormat(command,option,id)
{
	var doc= document.getElementById("iframe"+id).contentWindow;
	if(doc.document.queryCommandEnabled(command))
	{
		try{doc.document.execCommand(command,false,option);}catch(e){};
		document.getElementById(command+id).value="";
		doc.focus();
	}
};

//called from colorpalette
function XK_applyColor(id,color)
{
	var option=document.getElementById('coloroption'+id).value;
	switch(option)
	{
		case "forecolor":
		XK_foreColor(id,color);
		break;
		
		case "hilitecolor":
		XK_hiliteColor(id,color);
		break;
		
		case "cellcolor":
		XK_CellColor(id,color);
		break;
	}
	return;
};

function XK_countCharacters(id)
{
	var text=document.getElementById("iframe"+id).contentWindow.document.body.innerHTML;
	alert(text.length);
}

function XK_color(id,buttonid,option)
{
	document.getElementById('coloroption'+id).value=option;
	if (option!='cellcolor')
	XK_showHideDiv(id, buttonid, 'colorPalette');
	else if(XK_isInsideCell(id))
	XK_showHideDiv(id, buttonid, 'colorPalette');
};

function XK_foreColor(id, color) 
{
	try{document.getElementById("iframe"+id).contentWindow.document.execCommand('forecolor',false, color);}catch(e){};
	return;
};

function XK_hiliteColor(id, color) 
{
	var doc= document.getElementById("iframe"+id).contentWindow;
	if (!isie)
	{
		try
		{
			doc.document.execCommand('usecss',false,false);
			doc.document.execCommand('hilitecolor', false, color);
			doc.document.execCommand("usecss",false,true);
		}
		catch(e){};			
	}
	else try{doc.document.execCommand('backcolor', false, color);}catch(e){};
	return;
};

function XK_insertDate(id)
{
	var date= new Date();
	document.getElementById("iframe"+id).contentWindow.focus();
	XK_insertHTML(date.toLocaleString(),id);
};

//makes a XoopsCode div or XoopsQuote div and puts inside it the selected text
function XK_addCodes(type,id) 
{
	document.getElementById("iframe"+id).contentWindow.focus();
	var text = XK_getSelectedText(id);
	if (text=="")text="&nbsp;";
	var text="<div style=\"border:1px solid\" class=\"xoops"+type+"\" >"+text+"</div>";	
	XK_insertHTML(text,id);		
};

function XK_textDirection(direction,id)
{
	//simplest version
	document.getElementById("iframe"+id).contentWindow.document.dir=direction;
	document.getElementById(id).dir=direction;
};

function XK_InsertImage(id,src,alt)
{
	document.getElementById("iframe"+id).contentWindow.focus();
	if (src==null) 
	{
		var image = prompt("Image source.",'http://');
		alt = "&nbsp;";
	}
	else var image = src;
	
	if (image!='http://' && image!=null)
	XK_insertHTML("<img src="+image+" alt=\""+alt+" \">",id);

	return;
};

function XK_insertAnchor(id)
{
	var name = prompt("Anchor.",'id');	
	document.getElementById("iframe"+id).contentWindow.focus();
	XK_insertHTML("<img alt=\x22anchor\x22 id=\""+name+"\" title=\""+name+"\" src=\""+url+"/skins/common/anchor.gif\" />",id);
	return;
};

function XK_print(id)
{
	var doc= document.getElementById("iframe"+id).contentWindow;
	if (isie){try{doc.document.execCommand('Print');}catch(e){};}
	else doc.print();
};

function XK_insertSymbol(symbol,id)
{
	document.getElementById('insertsymbol'+id).value="";
	document.getElementById("iframe"+id).contentWindow.focus();
	XK_insertHTML(symbol,id);
};

function XK_checkspell()
{   
    if(isie)
    {
    	try	
    	{
			var tmpis = new ActiveXObject("ieSpell.ieSpellExtension");
			tmpis.CheckAllLinkedDocuments(document);
    	}
    	catch(exception)
    	{
        	if(exception.number==-2146827859)
  			{
            	if(confirm("ieSpell not detected.  Click Ok to go to download page."))
 					window.open("http://www.iespell.com/download.php","Download");
 			}
 			else alert("Error Loading ieSpell: Exception " + exception.number);
        }       

    }   
    else window.open("http://spellbound.sourceforge.net./install.html#header","SpellBound");
};

//change between code and wysiwyg modes
function XK_doToggleView(id)
{
	var doc= document.getElementById("iframe"+id).contentWindow.document;
	if(document.getElementById("iframe"+id).style.display!="none")
	{    
		//hide editor
		if (!isie)doc.designMode="Off";
		document.getElementById("iframe"+id).style.display="none";
		document.getElementById("toolbar"+id).style.display="none";
  
		//show textarea with code
		document.getElementById(id).style.display="block";
            
		//get xhtml
		var text=(document.getElementById(id).value.indexOf("<body")!=-1)?XK_getXHTML(doc):XK_getXHTML(doc.body);
        
        //add linebreaks to tags for better reading
		document.getElementById(id).value=XK_addLineBreaks(text);
		
		document.getElementById(id).focus();
	}
	else
	{  
		var text=XK_toWYSIWYG(document.getElementById(id).value);
		
		//if it's a complete html page
		if(text.indexOf("<body")!=-1)
		{
			if(isie)
			{
				doc.open();	
				doc.write(text);
				doc.close();
			}
			else
			{
				//stupid gecko "uncaught exception" if I try to open the doc to write
				//more gecko workarounds, I'm saving the head tag
				var headCode=text.split(/<\/head>/gi);
				if(headCode[0]!='')
				{
					headCode=headCode[0].split(/<head>/gi);
					headCode=(headCode[1])?headCode[1]:'';
					text=text.replace(headCode,'');
				}

				//here it comes the body tag attributes, gecko lose them
				var bodyCode=text.split(/<body/gi);
				bodyCode=bodyCode[1].split('>');
				bodyCode=(bodyCode[0])?bodyCode[0]:'';
				
				bodyCode=bodyCode.replace(/^\s*(.*)/, "$1");
  				bodyCode=bodyCode.replace(/(.*?)\s*$/, "$1");
  				bodyCode=bodyCode.replace(/\s/g,"=");
  				bodyAttrs=bodyCode.split('=');

				//insert the html
				doc.body.innerHTML = text;
		
				//update head saved before
				doc.getElementsByTagName('head')[0].innerHTML=headCode;
				
				
				//if there are some body attribute, just update it one by one
				if(bodyAttrs.length >1)
				{
					bodyHTML=doc.getElementsByTagName('body')[0];
					
					for(i=0;i<bodyAttrs.length;i++)
					{
						attribute=bodyAttrs[i];
						i++;
						value=(bodyAttrs[i]);
					
						//correct hex colour values
						value=value.replace(/#([0-9]|[a-f])/gi, "$1");
					
						//delete non necessary quotes 
						//(funny, if I don't delete quotes in colour values, gecko lies)
						value=value.replace(/['"](.*)['"]/gi, "$1");
						bodyHTML.setAttribute(attribute,value,0);
					}
				}
			}
		}
		else doc.body.innerHTML = text;

		//show editor
		document.getElementById("iframe"+id).style.display="block";
		document.getElementById("toolbar"+id).style.display="block";
		//hide textarea
		document.getElementById(id).style.display="none";
		//enable design mode again for gecko
		if (!isie){doc.designMode="On";doc.execCommand("usecss",false,true);}
	}
};

function getAnchors(id)
{
	text=XK_codeCleaner(document.getElementById("iframe"+id).contentWindow.document.body.innerHTML);
	var result=new Array(); 
	result=text.match(/<a name=\"(.*?)\"><\/a>/gi);
	return result;
}

function XK_floatingToolbar(id,skin)
{
	var ft=JSFX_FloatDiv("toolbar"+id, 200,200);
	if (document.getElementById("toolbar"+id).className!=skin+"floatingToolBar")
	{	
		XK_hideMenus();		
		document.getElementById("toolbar"+id).className=skin+"floatingToolBar";
		document.getElementById("maximizeButton"+id).style.display="none";
		ft.floatIt();
	}
	else
	{
		document.getElementById("toolbar"+id).className=skin+"toolbarBackCell";
		document.getElementById("maximizeButton"+id).style.display="";
		ft.cancelFloat();

	}
};

function XK_getImg(id) 
{
	var doc= document.getElementById("iframe"+id).contentWindow;
	if(isie)
	{
		if (doc.document.selection.type == 'Control')
    	{ 
			var tControl = doc.document.selection.createRange();
			if (tControl(0).tagName.toLowerCase() == 'img') return(tControl(0));
    		else return(null);
    	}
			else
    		{
      			return(null);
    		}
    }
    else
    {
    	var range = doc.getSelection().getRangeAt(0);
		var container = range.startContainer;
		var pos = range.startOffset;
		var imageNode = null;
	
		if (container.tagName) 
		{
			var images = container.getElementsByTagName('IMG');
			if (container.childNodes[pos].tagName == 'IMG') node = container.childNodes[pos];
			return node;
		}
		else return; 
    }   	
};

function XK_imageProps(id,img)
{
    var node=XK_getImg(id);  
    if(node==null)return; 
	
	if(img!=null)
	{
    	if(img["alt"])node.setAttribute('alt',img["alt"]);
		if(img["src"])node.setAttribute('src',img["src"]);
		if(img["width"]){node.style.width = img["width"];node.removeAttribute('width',0);}
		if(img["height"]){node.style.height = img["height"];node.removeAttribute('height',0);}		
		if(img["vspace"])node.vspace = img["vspace"];else node.removeAttribute('vspace',0);
		if(img["hspace"])node.hspace = img["hspace"];else node.removeAttribute('hspace',0);
		if(img["align"])node.setAttribute('align',img["align"]);else node.removeAttribute('align',0);
		if(img["className"])node.className = img["className"];else node.removeAttribute('className',0);
		
		//margin style
		node.style.marginLeft			= img["marginLeft"];
		node.style.marginRight			= img["marginRight"];
		node.style.marginTop			= img["marginTop"];
		node.style.marginBottom			= img["marginBottom"];
		
		//borders style
      	node.style.borderLeftStyle 		= img["borderLeftStyle"];
      	node.style.borderRightStyle 	= img["borderRightStyle"];
      	node.style.borderTopStyle 		= img["borderTopStyle"];
      	node.style.borderBottomStyle 	= img["borderBottomStyle"]; 	
      	
      	//borders Width
      	node.style.borderLeftWidth 		= img["borderLeftWidth"];
      	node.style.borderRightWidth 	= img["borderRightWidth"];
      	node.style.borderTopWidth 		= img["borderTopWidth"];
      	node.style.borderBottomWidth 	= img["borderBottomWidth"];
			
		//borders Color
      	node.style.borderLeftColor 		= img["borderLeftColor"];
      	node.style.borderRightColor 	= img["borderRightColor"];
      	node.style.borderTopColor 		= img["borderTopColor"];
      	node.style.borderBottomColor 	= img["borderBottomColor"];

		return;
	}
	else
	{
    	var image 				= 	new Object();
    	image["alt"]			=	node.getAttribute('alt');
		image["src"]			=	node.getAttribute('src');
		image["width"]			=	node.width;	
		image["height"]			=	node.height;
		image["vspace"]			=	node.vspace;	
		image["hspace"]			=	node.hspace;
		image["className"]		=	node.className;
		
		image["align"]			=	node.getAttribute('align');
		image["marginLeft"]		=	node.style.marginLeft;
		image["marginRight"]	=	node.style.marginRight;
		image["marginTop"]		=	node.style.marginTop;
		image["marginBottom"]	=	node.style.marginBottom;
		
		//borders style
      	image["borderLeftStyle"] 	= node.style.borderLeftStyle; 
    	image["borderRightStyle"]	= node.style.borderRightStyle;
      	image["borderTopStyle"]		= node.style.borderTopStyle;
      	image["borderBottomStyle"] 	= node.style.borderBottomStyle;  	
      	
      	//borders Width
		image["borderLeftWidth"]	= node.style.borderLeftWidth; 
		image["borderRightWidth"]	= node.style.borderRightWidth;
		image["borderTopWidth"]		= node.style.borderTopWidth;
		image["borderBottomWidth"]	= node.style.borderBottomWidth;
				
		//borders Color
		if(isie)
		{
			image["borderLeftColor"]	= node.style.borderLeftColor;
			image["borderRightColor"]	= node.style.borderRightColor;
			image["borderTopColor"] 	= node.style.borderTopColor; 
			image["borderBottomColor"]	= node.style.borderBottomColor;
		}
		else
		{
			image["borderLeftColor"]	= (node.style.borderLeftColor)?XK_RgbToHex(node.style.borderLeftColor):node.style.borderLeftColor;			
			image["borderRightColor"]	= (node.style.borderRightColor)?XK_RgbToHex(node.style.borderRightColor):node.style.borderRightColor;
			image["borderTopColor"] 	= (node.style.borderTopColor)?XK_RgbToHex(node.style.borderTopColor):node.style.borderTopColor; 
			image["borderBottomColor"]	= (node.style.borderBottomColor)?XK_RgbToHex(node.style.borderBottomColor):node.style.borderBottomColor;
		}


 		return (image);
 	}
    
};

function XK_hideToolbar(id,url)
{
	var doc=document.getElementById("buttons"+id).style.display;
	if(doc=="none")
	{
		document.getElementById("buttons"+id).style.display="";
	}
	else
	{ 
		document.getElementById("buttons"+id).style.display="none";
	}
};

//Shows/Hides a Div Layer
function XK_showHideDiv(id,buttonId,divId)
{
	var divid=divId+id;
	buttonElement=document.getElementById(buttonId+id);
	document.getElementById(divid).style.left=XK_getOffsetLeft(buttonElement) + "px";
	document.getElementById(divid).style.top=(XK_getOffsetTop(buttonElement) + buttonElement.offsetHeight) + "px";
	if(document.getElementById(divid).style.display=="none")
	{
		document.getElementById(divid).style.display="";
	}
	else document.getElementById(divid).style.display="none";
};



function XK_hideMenus()
{
  var men=new Array();
  
  if(!isie)men = document.getElementsByName("XoopsKToolbarDivs");
  //stupid iexplore, getElementsByName doesn't run at all
  else men = getElementsByNameAndTag("XoopsKToolbarDivs", "div");
  for (var i=0; i < men.length; i++) 
  {
      try{document.getElementById(men[i].id).style.display="none";}catch(e){};  
  }
}

//USEFUL FUNCTIONS

var timeout;
function JSFX_FloatDiv(id, sx, sy)
{
	var ns = (navigator.appName.indexOf("Netscape") != -1);
	var d = document;
	var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
	var px = document.layers ? "" : "px";
	window[id + "_obj"] = el;
	if(d.layers)el.style=el;
	el.cx = el.sx = sx;el.cy = el.sy = sy;
	el.sP=function(x,y){this.style.left=x+px;this.style.top=y+px;};
	el.floatIt=function()
	{
		var pX, pY;		
		pX = (this.sx >= 0) ? 0 : ns ? innerWidth : 
		document.documentElement && document.documentElement.clientWidth ?document.documentElement.clientWidth : document.body.clientWidth;
		pY = ns ? pageYOffset : document.documentElement && document.documentElement.scrollTop ?document.documentElement.scrollTop : document.body.scrollTop;
		if(this.sy<0) pY += ns ? innerHeight : document.documentElement && document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight;
		this.cx += (pX + this.sx - this.cx)/8;this.cy += (pY + this.sy - this.cy)/2;
		this.sP(this.cx, this.cy);		
		timeout=setTimeout(this.id + "_obj.floatIt()", 40);
	};
	el.cancelFloat=function()
	{
		clearTimeout(timeout);
	};
	
	return el;
};

function XK_AppendCss(id,css,name)
{
	if (css=="")return false;
	var doc = document.getElementById("iframe"+id).contentWindow.document;
	var stylesheet = doc.createElement( 'link' ) ;
	stylesheet.setAttribute('href',css);
	stylesheet.setAttribute('rel','stylesheet');
	stylesheet.setAttribute('type','text/css');
	stylesheet.setAttribute('id','name'+id);
	doc.getElementsByTagName('head')[0].appendChild( stylesheet );
};

function XK_DeleteCss(id,name)
{
	var doc = document.getElementById("iframe"+id).contentWindow.document;
	var node=doc.getElementById('name'+id);
	if (node.parentNode)
   	node.parentNode.removeChild(node);
   	//stupid iexplore, doesn't refresh
   	if(isie)doc.body.innerHTML=doc.body.innerHTML;
};

function getElementsByNameAndTag(name, tag) 
{
	var tam, list, tags;         
	list = new Array();
	tam = 0;
	tags = document.getElementsByTagName(tag);
	for(i = 0; i<tags.length; i++) 
	{
		if (tags[i].getAttribute("name")==name) 
		list[tam++] = tags[i];        
    }
	return list;
}

function XK_attachEvent(doc,event,func)
{
	if (isie)doc.attachEvent("on"+event, func, true);
	else doc.addEventListener(event, func, true);
}

function XK_createRange(id)
{
	if(isie)
		{
       	 //retrieve selected range
       	 var sel=document.getElementById("iframe"+id).contentWindow.document.selection;
       	 if(sel!=null)
			{
       	     var newselectionRange=sel.createRange();
       	     newselectionRange.select();
			}
    	return (newselectionRange);
		}
		
	else 
	{	
		range=document.createRange();
		return (range);
	}
		
	selection = doc.window.getSelection();       
	doc.focus();
};

//doesn't run well if used with elements into a div with relative position
function XK_getOffsetLeft(elm) {
	var mOffsetLeft = elm.offsetLeft;
	var mOffsetParent = elm.offsetParent;
	
	while(mOffsetParent) {
		mOffsetLeft += mOffsetParent.offsetLeft;
		mOffsetParent = mOffsetParent.offsetParent;
	}
	return mOffsetLeft;
};

function XK_getOffsetTop(elm) {
	var mOffsetTop = elm.offsetTop;
	var mOffsetParent = elm.offsetParent;
	
	while(mOffsetParent){
		mOffsetTop += mOffsetParent.offsetTop;
		mOffsetParent = mOffsetParent.offsetParent;
	}
	return mOffsetTop;
};

function XK_openPopup(url,name,width,height) 
{
	if(isie)
	{
		var Iwidth=width+30;
		var Iheight=height+40;
		var options = "dialogwidth:" + Iwidth +"px; dialogheight:" + Iheight +"px;top= "+(screen.height-height)/2+"px;left= "+(screen.width-width)/2+"px;toolbar=no;location=no;directories=no;status=no;menubar=no;scrollbars=no;resizable=no;copyhistory=no;";
		var new_window = window.showModalDialog(url, self, options);	
	}
	else 
	{
		var options = "width=" + width + ",height=" + height + ",top= "+(screen.height-height)/2+"px,left= "+(screen.width-width)/2+"px,dependable=yes, modal=yes, toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no";
		var new_window = window.open(url, name, options);
	}
};

//inserts html into iframe
function XK_insertHTML(html,id) 
{
	var doc= document.getElementById("iframe"+id).contentWindow;
	var range= XK_createRange(id);
	doc.focus();
    if (isie) 
    {
        try {
            	range.pasteHTML(html); 
				range.select();
				range.moveEnd("character", 1);
				range.moveStart("character", 1);
				range.collapse(false);
        	} catch (e) {}
    } 
    else 
    {
        selection = doc.window.getSelection();       
        doc.focus();

        if (selection) 
        {
            try{range = selection.getRangeAt(0)}catch(e){};
        } 
        else range = doc.document.createRange();

        var fragment = doc.document.createDocumentFragment();
        var div = doc.document.createElement("div");
        div.innerHTML = html;

        while (div.firstChild) {
            fragment.appendChild(div.firstChild);
        }

        selection.removeAllRanges();
        range.deleteContents();

        var node = range.startContainer;
        var pos = range.startOffset;

        switch (node.nodeType) {
            case 3:
                if (fragment.nodeType == 3) {
                    node.insertData(pos, fragment.data);
                    range.setEnd(node, pos + fragment.length);
                    range.setStart(node, pos + fragment.length);
                } else {
                    node = node.splitText(pos);
                    node.parentNode.insertBefore(fragment, node);
                    range.setEnd(node, pos + fragment.length);
                    range.setStart(node, pos + fragment.length);
                }
                break;

            case 1:
                node = node.childNodes[pos];
                if(node==null)break;
                node.parentNode.insertBefore(fragment, node);                 
                range.setEnd(node, pos + fragment.length);
                range.setStart(node, pos + fragment.length);
                break;
        }
        selection.addRange(range);
    }
};

function XK_over(id,color)
{
	document.getElementById('colortextf'+id).style.backgroundColor =color;
	document.getElementById('showc'+id).value =color;
};

//returns selected text on iframe
function XK_getSelectedText(id)
{
	var newselectionRange= XK_createRange(id);
	if(isie)
	{	
		var text=newselectionRange.htmlText;
    }
	else
	{
		var e = document.getElementById("iframe"+id);
		var text = e.contentWindow.getSelection();
	}
	return text;
};

//to know if a range is inside a tag for iexplore
function XK_isInsideThisTag(id,tagname)
{
	if (isie)
	{
		var range= XK_createRange(id);
	    var element = range.parentElement();
	    var tag = element.tagName.toLowerCase();
	    while ((tag!="body") && (tag!=tagname.toLowerCase()))
	    {
		   element = element.parentElement;
		   tag = element.tagName.toLowerCase();
	    }
	    if (tag==tagname.toLowerCase()) return (tag);
	    else return false;
	}
};

function XK_cancelBubble(event) 
{
	if(!isie){event.preventDefault();event.stopPropagation();}
	else{event.cancelBubble = true;event.returnValue = false;} 
};

//THE END.
//Note: funny liar browsers

// used by system_imagemanager.html
function XoopsEditor_InsertImage(id,src,alt,align)
{
	return XK_InsertImage(id,src,alt,align);
}