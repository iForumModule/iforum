/*
*   Samuels [Xoops Project] 
*
*
// $Id: cntextmenu.js,v 1.1.2.1 2005/06/04 02:11:53 phppp Exp $
*
*/
//Simple class to handle context menus

function XK_contextMenu(id)
{
	this.id=id;
	this.menu=document.getElementById("xkcontextmenu"+id);
	this.editor=document.getElementById("iframe"+id);
	var self = this;
	
	XK_attachEvent(this.editor.contentWindow.document,"contextmenu", function(event){return self.show(isie?self.editor.contentWindow.event:event)});
};

XK_contextMenu.prototype.visible = function()
{
	if (this.menu.style.display!="none")return true;
	else return false;
};

XK_contextMenu.prototype.show = function(e)
{
	this.visible=true;
	this.menu.style.display="block";
	
	//set menu position
	this.setPos(e);
	
	//set the visible options
	this.setOptions(e);
	
	//stop event propagation	
	XK_cancelBubble(e);
};

XK_contextMenu.prototype.setPos = function(e)
{
	if (e.pageX || e.pageY)	
	{
		posx = e.pageX;
		posy = e.pageY;
	}
	else if (e.clientX || e.clientY){
		posx = e.clientX;
		posy = e.clientY;
		if (isie){
			posx += document.body.scrollLeft;
			posy += document.body.scrollTop;
		}
	}
	
	//get real position
	posx=posx+XK_getOffsetLeft(this.editor);
	posy=posy+XK_getOffsetTop(this.editor);
	if(!isie)posy-=this.editor.contentWindow.document.body.scrollTop;
	
	//make sure it fits
	if ( posx+this.menu.offsetWidth > document.body.clientWidth ) posx -= this.menu.offsetWidth ;
	//if ( posy+this.menu.offsetHeight > document.body.clientHeight ) posy -= this.menu.offsetHeight ;
	
	// posx and posy contain the mouse position relative to the document
	this.menu.style.left=posx+"px";
	this.menu.style.top=posy+"px";
};

XK_contextMenu.prototype.setOptions = function(e)
{
	//set default visibility to all options
	this.refresh();
	
	var element=isie?e.srcElement:e.target;
	
	//show options depending the context
	while (element)
	{
		tag=element.tagName?element.tagName.toLowerCase():'';
		//img
		if(tag =='img'&&(XK_getImg(this.id)!=null)){this.setOptionVisible("xkimagecontext");return;}
		
		//table
		if(tag =='table')this.setOptionVisible("xktablecontext");
		
		//link
		if(tag =='a')this.setOptionVisible("xklinkcontext");
		
		element = element.parentNode ;
	}
};

XK_contextMenu.prototype.setOptionVisible = function(optionId)
{
	document.getElementById(optionId+this.id).style.display="block";
};
XK_contextMenu.prototype.setOptionHidden = function(optionId)
{
	document.getElementById(optionId+this.id).style.display="none";
};
XK_contextMenu.prototype.refresh = function()
{
	this.setOptionHidden("xkimagecontext");
	this.setOptionHidden("xktablecontext");
	this.setOptionHidden("xklinkcontext");
};