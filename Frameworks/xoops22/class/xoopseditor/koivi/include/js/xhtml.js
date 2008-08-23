/*
*   Samuels [Xoops Project] 
*   Based on Get XHTML for IE 1.03
*
*						  Created by Erik Arvidsson                           
*                  (http://webfx.eae.net/contact.html#erik)
*                      For WebFX (http://webfx.eae.net/) 
*
*
// $Id: xhtml.js,v 1.1.2.1 2005/06/04 02:11:53 phppp Exp $
*
* Some Functions for cleaning code and make it as xhtml compilant as possible
*/

//info from http://www.cs.tut.fi/~jkorpela/html/empty.html
var empty_elements ='|area|base|basefont|br|col|frame|hr|img|input|isindex|link|meta|param|';
var weird_attributes = '|contenteditable|_msh|_moz|_moz-userdefined|_base_href|_moz_resizing|_moz_dirty|_moz_editor_bogus_node|_xk_made|';

var auxtext=null;
var avoidtext = false;

function XK_removeFormat(id,option)
{
	var doc=document.getElementById('iframe'+id).contentWindow;
	var text=doc.document.body.innerHTML;
	if (text=='')return;
	
	switch(option)
	{
		case 'word':
		text=XK_cleanWORD(text);
		break;
		
		case 'span':
		text= text.replace(/<\/?span[^>]*>/gi,'');
		break;
		
		case 'font':
		text= text.replace(/<\/?font[^>]*>/gi,'');	
		break;
		
		case 'div':
		text= text.replace(/<\/?div[^>]*>/gi,'');
		break;
		
		case 'all':
		text= text.replace(/<\/?[^>]*>/gi,'');

		case 'lineBreaks':
		text= text.replace(/\s/g,' ');
		//text= text.replace(/<br \/>/gi,' ');
		//text = text.replace(/<br>/gi,' ');
		break;
		
		case 'empty':
		text = XK_removeEmptyTags(text);

		case 'style':
		text= text.replace(/<([\w]+)style=\"([^\"]*)\"([^>]*)/gi,"<$1$3");
		break;
	}
	doc.document.body.innerHTML=text;
	document.getElementById('RemoveFormat'+id).style.display="none";
};

function XK_removeEmptyTags(text)
{
	text = text.replace(/(<[^\/]*[^td]>|<[^\/][^>]*[^\/]*[^td]>)\s*<\/[^>]*[^td]>/gi, "");
	return text;
}

function XK_codeCleaner(text) 
{		
	//replace characters,
	//mmm disabled by now for compatibility reasons
	//text = XK_replaceCharacters(text);
	
	//replace linebreaks with spaces
	text= text.replace(/\s/g," ");
	
	//destroy tbody tags	
	text = text.replace(/<tbody>/gi,"");
	text = text.replace(/<\/tbody>/gi,"");
	
	//remove strange tags
	text = text.replace(/<[p|div|span|font] [^>]*\/>/gi, "");
		
	//for mozilla
	if (!isie)
	{
		text = text.replace(/<b>/gi, "<strong>");
		text = text.replace(/<b /gi, "<strong ");
		text = text.replace(/<\/b>/gi, "</strong>");
		text = text.replace(/<i>/gi, "<em>");
		text = text.replace(/<i /gi, "<em ");
		text = text.replace(/<\/i>/gi, "</em>");
		text = text.replace(/<br type="_moz" \/>/gi, "<br />");
	
		//hilite text crossbrowser compatibility
		text = text.replace(/<span style=\x22background-color:((.|\s)+?)>((.|\s)+?)<\/span>/gi,'<font style=\x22background-color:$1>$3</font>');
	}
	text = text.replace(/style="">/gi, ">");
	//anchor
	text = text.replace(/<img id=((.|\s)+?) title=((.|\s)+?)>/gi, '<a name=$1></a>');
	return text;
};

function XK_toWYSIWYG(text) 
{
	if (!isie)
	{
		text = text.replace(/<br \/>/gi,"<br>");
		text = text.replace(/<strong>/gi, "<b>");
		text = text.replace(/<strong /gi, "<b ");
		text = text.replace(/<\/strong>/gi, "</b>");
		text = text.replace(/<em>/gi, "<i>");
		text = text.replace(/<em /gi, "<i ");
		text = text.replace(/<\/em>/gi, "</i>");
	}
	else
	{
		text = text.replace(/<br \/>/gi,"<br>");
		text = text.replace(/<b>/gi, "<strong>");
		text = text.replace(/<b /gi, "<strong ");
		text = text.replace(/<\/b>/gi, "</strong>");
		text = text.replace(/<i>/gi, "<em>");
		text = text.replace(/<i /gi, "<em ");
		text = text.replace(/<\/i>/gi, "</em>");

	}
	text = text.replace(/<a name=\"(.*?)\"><\/a>/gi, '<img alt=\x22anchor\x22 id=\"$1\" title=\"$1\" src=\"'+url+'/skins/common/anchor.gif\" />');
	text = XK_removeLineBreaks(text);	
	return text;
};

function XK_cleanWORD(text) {
	if (text.indexOf('Mso') >= 0) 
	{ 
 
		// make one line 
		text = text.replace(/\s/g,' ').replace(/\&nbsp\;/g,' '); 
 
		// keep tags, strip attributes 
		text = text.replace(/<(\w[^>]*) class=([^ |>]*)([^>]*)/gi, "<$1$3");
		
		// Remove Style attributes
		text = text.replace(/<(\w[^>]*) style="([^"]*)"([^>]*)/gi, "<$1$3");
		text = text.replace(/ align=[^\s|>]*/gi,''); 
		 
		//clean up tags 
		text = text.replace(/<b [^>]*>/gi,'<b>'). 
			replace(/<i [^>]*>/gi,'<i>'). 
			replace(/<li [^>]*>/gi,'<li>'). 
			replace(/<ul [^>]*>/gi,'<ul>'); 
 
		// replace outdated tags 
		text = text.replace(/<b>/gi,'<strong>'). 
			replace(/<\/b>/gi,'</strong>'); 
 
		// mozilla doesn't like <em> tags 
		text = text.replace(/<em>/gi,'<i>'). 
			replace(/<\/em>/gi,'</i>'); 
 
		// kill unwanted tags 
		text = text.replace(/<\?xml:[^>]*>/g, '').// Word xml 
			replace(/<\/?st1:[^>]*>/g,'').     // Word SmartTags 
			replace(/<\/?[a-z]\:[^>]*>/g,'').  // All other funny Word non-HTML stuff 
			replace(/<\/?span[^>]*>/gi,''). 
			replace(/<\/?div[^>]*>/gi,''). 
			replace(/<\/?pre[^>]*>/gi,''). 
			replace(/<\/?h[1-6][^>]*>/gi,''); 
 
		//remove empty tags 
		text = XK_removeEmptyTags(text);
		 
		// nuke double spaces 
		text = text.replace(/  */gi,' ');
		return text;
	}
	return text; 
};

function XK_removeLineBreaks(text)
{
	//delete \n after html tags 
	text = text.replace(/<\/(.*?)>\n/gi,"<\/$1>");
	return text;
};

function XK_addLineBreaks(text)
{
	//add \n to html tags 
	text = text.replace(/<\/(.*?)>/gi,"<\/$1>\n");
	return text;
};

function XK_replaceCharacters(text) 
{
	//don't compress 
	var htmlcharacters = ['&euro;','&lsquo;','&rsquo;','&ldquo;','&rdquo;','&ndash;','&mdash;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&sup1;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;'];
	var characters=['\u20AC','\u2018','\u2019','\u201C','\u201D','\u2013','\u2014','\u00A1','\u00A2','\u00A3','\u00A4','\u00A5','\u00A6','\u00A7','\u00A8','\u00A9','\u00AA','\u00AB','\u00AC','\u00AE','\u00AF','\u00B0','\u00B1','\u00B2','\u00B3','\u00B4','\u00B5','\u00B6','\u00B7','\u00B8','\u00B9','\u00BA','\u00BB','\u00BC','\u00BD','\u00BE','\u00BF','\u00C0','\u00C1','\u00C2','\u00C3','\u00C4','\u00C5','\u00C6','\u00C7','\u00C8','\u00C9','\u00CA','\u00CB','\u00CC','\u00CD','\u00CE','\u00CF','\u00D0','\u00D1','\u00D2','\u00D3','\u00D4','\u00D5','\u00D6','\u00D7','\u00D8','\u00D9','\u00DA','\u00DB','\u00DC','\u00DD','\u00DE','\u00DF','\u00E0','\u00E1','\u00E2','\u00E3','\u00E4','\u00E5','\u00E6','\u00E7','\u00E8','\u00E9','\u00EA','\u00EB','\u00EC','\u00ED','\u00EE','\u00EF','\u00F0','\u00F1','\u00F2','\u00F3','\u00F4','\u00F5','\u00F6','\u00F7','\u00F8','\u00F9','\u00FA','\u00FB','\u00FC','\u00FD','\u00FE','\u00FF'];
	//don't compress
	
	for(var i = 0; i < characters.length; i++)
	{
		text = text.replace(eval('/'+characters[i]+'/g'),htmlcharacters[i]);
	}
	return text;
};

function XK_getXHTML(oNode) 
{
	var sb = new XK_StringBuilder;
	var cs = oNode.childNodes;
	var avoidtext = false;	
	var l = cs.length;
	for (var i = 0; i < l; i++)
	XK_appendNodeXHTML(cs[i], sb);
	return XK_codeCleaner(sb.toString());
}

function XK_fixAttribute(s) 
{
	return String(s).replace(/\&/g, "&amp;").replace(/</g, "&lt;").replace(/\"/g, "&quot;");
}

function XK_fixText(s) 
{
	return String(s).replace(/\&/g, "&amp;").replace(/</g, "&lt;");
}

function XK_getAttributeValue(oAttrNode, oElementNode, sb) 
{
	if (!oAttrNode.specified)return;
	
	var name = oAttrNode.nodeName;
	var value = oAttrNode.nodeValue;
		
	if(weird_attributes.indexOf('|'+name+'|') != -1)return;	
	if (name != "style" ) 
	{
		// IE5.x bugs for number values
		if (!isNaN(value))value = oElementNode.getAttribute(name);
		sb.append(" " + (oAttrNode.expando ? name : name.toLowerCase()) + "=\"" + XK_fixAttribute(value) + "\"");
	}
	else sb.append(" style=\"" + XK_fixAttribute(oElementNode.style.cssText.toLowerCase()) + "\"");
}

//this is a example of two buggy browsers in action
function XK_appendNodeXHTML(node, sb) 
{

	switch (node.nodeType) 
	{
		case 1:	// ELEMENT
		
			// IE5.0 and IE5.5 are weird
			if (node.nodeName == "!") {	sb.append(node.text);break;}
			var name = node.tagName.toLowerCase();
	
			//stupid explorer it adds extra meta tag	
			if (name == "meta" && (node.getAttribute('name') == "GENERATOR"))break;
	
			//stupid gecko it adds extra br's
			if (name == 'br' && !node.nextSibling)break;
				
			//aaaaj, again stupid explorer. It duplicates code, I need to mark all tags to know if they are already parsed.
			if (avoidtext){if (node.innerHTML == "" && node.canHaveChildren) {avoidtext = false;break;}}
			if (isie) {if (node._xk_made) {avoidtext = true;break;}node._xk_made = true;}		
			
			sb.append("<" + name);
			
			var attrs = node.attributes;
			var l = attrs.length;
			for (var i = 0; i < l; i++)
			{
				XK_getAttributeValue(attrs[i], node, sb);
			}
			
			//avoid confussion between tags that need empty closing "/>" and empty tags f.i:"<b></b>" under gecko
			var isempty=(!isie && empty_elements.indexOf('|'+name+'|') == -1)?true:false;	
			
			if (node.canHaveChildren || node.hasChildNodes()|| isempty ) 
			{
				sb.append(">");
				
				
				// childNodes
				var cs = node.childNodes;
				l = cs.length;
				for (var i = 0; i < l; i++)
				{
					XK_appendNodeXHTML(cs[i], sb);
				}		
				sb.append("</" + name + ">");
			}
			
			else if (name == "script")sb.append(">" + node.text + "</" + name + ">");
			else if (name == "title" || name == "style" || name == "comment")sb.append(">" + node.innerHTML + "</" + name + ">");
			else sb.append(" />");
			break;
			
		case 3:	// TEXT			
			if (auxtext==node){auxtext=null;break;}if(isie){auxtext=node;}
			sb.append( XK_fixText(node.nodeValue) );
			break;
				
		case 4:
			sb.append("<![CDA" + "TA[\n" + node.nodeValue + "\n]" + "]>");
			break;
				
		case 8:
			sb.append(node.text);
			if (/(^<\?xml)|(^<\!DOCTYPE)/.test(node.text) )sb.append("\n");
			break;
			
		case 9:	// DOCUMENT
			// childNodes
			var cs = node.childNodes;
			l = cs.length;
			for (var i = 0; i < l; i++)
			{
				XK_appendNodeXHTML(cs[i], sb);
			}
			break;
			
		default:
			sb.append("<!--\nNot Supported:\n\n" + "nodeType: " + node.nodeType + "\nnodeName: " + node.nodeName + "\n-->");
	}
}

function XK_StringBuilder(sString) 
{
	// public
	this.length = 0;
	
	this.append = function (sString) 
	{
		// append argument
		this.length += (this._parts[this._current++] = String(sString)).length;
		// reset cache
		this._string = null;
		return this;
	};
	
	this.toString = function () 
	{
		if (this._string != null)return this._string;	
		var s = this._parts.join("");
		this._parts = [s];
		this._current = 1;	
		return this._string = s;
	};

	// private
	this._current	= 0;
	this._parts		= [];
	this._string	= null;	// used to cache the string
	
	// init
	if (sString != null)this.append(sString);
}