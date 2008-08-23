/*
*   Samuels [Xoops Project] 
*   
*
*
// $Id: table_tools.js,v 1.1.2.1 2005/06/04 02:11:53 phppp Exp $
*
*/

//-----------------------------------CLASSES-------------------------------------------

//Class table
function XK_table(id)
{
	this.id			= 	id;
	this.rows		=	0;
	this.columns	=	0;
	this.width		=	200;
	this.widthUnits	=	'px';
	this.height		=	100;
	this.heightUnits=	'px';
	this.border		=	1;
	this.halignment	=	'';
	this.valignment	=	'';
	this.spacing	=	0;
	this.padding	=	1;
	this.head		= 	false;
};

//Class tableNode
function XK_tableNode (id)
{
	this.id			= 	id;
	this.td			= 	this.getTd(); if (this.td==null) return;
	this.table		= 	this.getTable();
	this.rowSelect	=	this.td.parentNode;
	this.tableSelect=	this.rowSelect.parentNode;

};

//-----------------------------------END CLASSES-------------------------------------------



//Functions for doing things


function XK_useTableOps(Option,id)
{
	myTableNode = new XK_tableNode(id);
	if (myTableNode.td==null)return;

	
	if (Option=='TableOps')XK_showHideDiv(id,'tpropbutton','TableOps');
	else
	{
		eval('myTableNode.'+Option+''+'()');
	}

};

//---------------------------DIVS AND POPUPS------------------------------------------

function XK_useTableDivs(id,option)
{
	myTableNode = new XK_tableNode(id);
	if (myTableNode.td==null)return;
	
	switch(option)
	{
		case 'borders':
		XK_showHideDiv(id,'cbbutton','CellBorders');
		break;
		
		case 'align':
		XK_showHideDiv(id,'cellpropbutton','CellAlign');
		break;
		
	}

}

//---------------------------END DIVS AND POPUPS------------------------------------------

function XK_isInsideCell(id)
{
  	myTableNode = new XK_tableNode(id);
	if (myTableNode.td==null)return false;
	else return true;
};


function XK_CellColor(id,color)
{
  	myTableNode = new XK_tableNode(id);
	if (myTableNode.td==null)return;
	myTableNode.td.bgColor=color;
};


function XK_TTools(id,url,name,width,height)
{
	myTableNode = new XK_tableNode(id);
	if (myTableNode.td==null)return;
	else XK_openPopup(url,name,width,height);
	return;
};


function XK_cellAlign(id,Halign,Valign)
{
  	myTableNode = new XK_tableNode(id);
	if (myTableNode.td==null)return;
	
	myTableNode.td.align=Halign;
	myTableNode.td.vAlign=Valign;
};


function XK_quickBorders(id,borders,color)
{
	myTableNode = new XK_tableNode(id);
	if (myTableNode.td==null)return;
		
	var style='1px solid '+color;
	
	switch(borders)
	{
		case 'all':
		myTableNode.td.style.borderLeft= style;
		myTableNode.td.style.borderRight= style;
		myTableNode.td.style.borderBottom= style;
		myTableNode.td.style.borderTop= style;
		break;
		
		case 'none':
		myTableNode.td.style.borderLeft= 'none';
		myTableNode.td.style.borderRight= 'none';
		myTableNode.td.style.borderBottom= 'none';
		myTableNode.td.style.borderTop= 'none';
		break;
		
		case 'top':
		myTableNode.td.style.borderTop= style;
		break;
		
		case 'left':
		myTableNode.td.style.borderLeft= style;
		break;
		
		case 'right':
		myTableNode.td.style.borderRight= style;
		break;
		
		case 'bottom':
		myTableNode.td.style.borderBottom= style;
		break;
	}	
};


function XK_Easytable(id,rows,columns)
{
	var iframeId='iframe'+id;
	
	myTable = new XK_table(id);
	myTable.rows = rows;
	myTable.columns = columns;
	document.getElementById(iframeId).contentWindow.focus();
	
	myTable.createTable();
};

function XK_createTable(id,table)
{
	myTable = new XK_table(id);
	myTable.rows = table.rows;
	myTable.columns = table.columns;
	myTable.spacing = table.spacing;
	myTable.padding = table.padding;
	myTable.border = table.border;	
	myTable.width = table.width;
	myTable.widthUnits = "px";
	myTable.height = table.height;
	myTable.heightUnits = "px";
	myTable.createTable();
};

//--------------------------------CONSTRUCTORS----------------------------------------

XK_table.prototype.createTable = function() 
{
    rows 		= 	this.rows;
    cols 		= 	this.columns;
	head 		= 	false;
	border 		= 	this.border+'px';
	spacing 	= 	this.spacing+'px';
	padding 	= 	this.padding+'px';
	width 		= 	this.width+''+this.widthUnits;
	height 		= 	this.height+''+this.heightUnits;

    if ((rows > 0) && (cols > 0)) 
    {
       table = ' <table style=\x22height: '+height+'; width: '+width+';\x22 cellspacing='+spacing+' cellpadding='+padding+' border=' + border + '>';
       for (var i=0; i < rows; i++) 
       {
          table = table + ' <tr>';
          for (var j=0; j < cols; j++) 
          {
			if(i==0 && head=='1') 
			{
             	table += '  <th>&nbsp;</th>';
            } 
            else 
            {
             	table += '  <td>&nbsp;</td>';
			}            
          }
          table += ' </tr>';
       }
       table += ' </table><br>';
		XK_insertHTML(table,this.id);
    }
};

XK_tableNode.prototype.deleteCol = function()
{
	if (this.td.parentNode.cells.length == 1)
	{
		if (isie)
		{
			this.table.removeNode(true);
		}
		return;
	}
	
	var lines= this.tableSelect.rows;
	var colx= this.getColumnNo(this.td);
	var rspan= new Array();
	var newCell;
	var cs;
	
	for(var i=0; i<lines.length; i++)
	{
		row= this.tableSelect.rows[i];
   		idx=0; 
   		for(var j=0; j<=colx ; j++)
   		{
	 		if(!rspan[j+idx])rspan[j+idx]=0;
   	 		while(rspan[j+idx]){rspan[j+idx]--; idx++ }
     		if(row.cells[j]) rspan[j+idx]=row.cells[j].rowSpan-1;
	 		if(!row.cells[j] || (j+idx>=colx) )
   	 		{
	  			if(isie)
	  			{
	  				if(row.cells[j-1]) cs=row.cells[j-1].colSpan;
	  				else cs=1;
	  			}else cs=1;
	  			if(cs==1) row.deleteCell(j);
	  			else row.cells[j-1].colSpan -= 1;
	  			break ;
   	 		}
  	 		idx += row.cells[j].colSpan-1;
   		}
  	}
};

XK_tableNode.prototype.deleteRow = function()
{
	//if number of rows=1 don't do anything under gecko and remove table under iexplore
	var nr=this.table.rows.length;
	if (nr==1)
	{
		if(isie)this.table.removeNode(true);
		return;
	}
	
	var ridx = this.rowSelect.rowIndex;
	var row = this.rowSelect; 
	var rlen= row.cells.length;
	for(var i=0; i<rlen; i++)
 	{
    	if(row.cells[i].rowSpan>1)
	 	{
      		var newCell= this.tableSelect.rows[ridx+1].insertCell(i);
      		newCell.rowSpan= row.cells[i].rowSpan - 1 ;
	  		newCell.innerHTML= row.cells[i].innerHTML ;
	  		row.cells[i].rowSpan =1;
	 	}
  	}
 	while(row.cells.length) { row.deleteCell(0); }
	for(var i=0; i<=ridx; i++)
	{
		row= this.tableSelect.rows[i]; 
		for(var j=0; j<row.cells.length; j++) 
	 	{
       		if(row.cells[j].rowSpan>1 && i+row.cells[j].rowSpan>ridx)
		 	row.cells[j].rowSpan -= 1;
	 	}
	}
  
	if(row.cells.length==0) this.tableSelect.deleteRow(ridx);
};


XK_tableNode.prototype.deleteCell = function()
{
	var col= this.td.cellIndex;
	this.rowSelect.deleteCell(col);
	this.td = this.rowSelect.cells[col];
	if(!this.td) this.td = this.rowSelect.cells[col-1];
};

XK_tableNode.prototype.decreaseRowSpan = function()
{
  var rowSpan= this.td.rowSpan;
  var rowNum= this.tableSelect.rows.length;
  var ridx= this.rowSelect.rowIndex+rowSpan-1; // next


  var colx= this.getColumnNo(this.td) ; // current
  var rowNext= this.tableSelect.rows[ridx];
  var cidx=getCellIndex(colx, rowNext); // Next

  this.td.rowSpan -= 1;

  var newCell= rowNext.insertCell(cidx,1);
  newCell.innerHTML= '&nbsp;' ;
  rowNext.cells[cidx].colSpan = this.td.colSpan;
};


XK_tableNode.prototype.increaseRowSpan = function()
{
  var rowSpan= this.td.rowSpan;
  var rowNum= this.tableSelect.rows.length;
  var ridx= this.rowSelect.rowIndex+rowSpan; // next

  if( ridx>=rowNum) return; 

  var colx= this.getColumnNo(this.td) ; // current

  var rowNext= this.tableSelect.rows[ridx];
  var cidx=getCellIndex(colx, rowNext); // Next
  var cellNext= rowNext.cells[cidx];
  if(!cellNext) return;

  var coln=  this.getColumnNo(cellNext) ; // cell Next row
  if(coln != colx || cellNext.colSpan != this.td.colSpan )return;

  this.td.rowSpan += rowNext.cells[cidx].rowSpan;
  this.td.innerHTML += rowNext.cells[cidx].innerHTML;
  rowNext.deleteCell(cidx);
 
};

XK_tableNode.prototype.increaseSpan = function()
{
	var cidx= this.td.cellIndex;
	var row= this.td.parentNode;
	var nxt= row.cells[cidx+1];
   
	if(!nxt) return;

	var maxcol= this.getMaxColumn();
	var colx= this.getColumnNo(this.td) ; // current
	var coln= this.getColumnNo(nxt) ; // next

	if(colx+this.td.colSpan>=maxcol || colx+this.td.colSpan<coln || this.td.rowSpan != nxt.rowSpan) return;
	this.td.innerHTML += nxt.innerHTML;
	this.td.colSpan += nxt.colSpan;
	row.deleteCell(cidx+1);
};

XK_tableNode.prototype.decreaseSpan = function()
{
	if(this.td.colSpan==1) return;
	var col= this.td.cellIndex;
	this.td.colSpan -= 1;
	var newCell= this.td.parentNode.insertCell(col+1,1);
	newCell.innerHTML= '&nbsp;' ;
	newCell.rowSpan= this.td.rowSpan ;
};

XK_tableNode.prototype.insertCol = function()
{
	
	var lines= this.tableSelect.rows;
	var colx= this.getColumnNo(this.td);
	var rspan= new Array();
	var newCell, cs,rc ;
	for(var i=0; i<lines.length; i++)
	{
		row= this.tableSelect.rows[i];
		idx=0; 
		for(var j=0; j<=colx ; j++) // j= cellIndex
   		{
	 		if(!rspan[j+idx])rspan[j+idx]=0; 
	 		while(rspan[j+idx]){rspan[j+idx]--; idx++ }
			if(row.cells[j]) rspan[j+idx]=row.cells[j].rowSpan-1;
			if(!row.cells[j] || (j+idx>=colx) )
   	 		{
	  			if(isie)
	  			{
	  				if(row.cells[j-1]) cs=row.cells[j-1].colSpan;
	  				else cs=1;
	  			}else cs=1;
	  			
	  			if(cs==1)
				{
		  			newCell=row.insertCell(j); 
	      			newCell.innerHTML='&nbsp;';
	      			break; 
	    		}
	  			else
				{
		  			row.cells[j-1].colSpan += 1;
		  			break ;
	    		}
   	 		}
  	 		idx += row.cells[j].colSpan-1;
   		}
  	}
};

XK_tableNode.prototype.insertCell = function()
{
	var newCell= this.rowSelect.insertCell(this.td.cellIndex+1,1);
	newCell.innerHTML= this.td.innerHTML ;
};

XK_tableNode.prototype.insertRow = function()
{
	var ridx= this.rowSelect.rowIndex;


	var row= this.tableSelect.rows[ridx]; // first row
	var idx=0; 
	for(var j=0; j<row.cells.length; j++) // j= cellIndex
  	{
    	if(!row.cells[j]) break;
    	idx += row.cells[j].colSpan-1
  	}
 
 	var colx= j+idx;
	var newRow= this.tableSelect.insertRow(ridx);
	var newCell;
	for(var i=0; i<colx; i++)
	{ 
		newCell=newRow.insertCell(0,1); 
		newCell.innerHTML='&nbsp;' 
	}

	for(var i=0; i<=ridx; i++)
	{
		row= this.tableSelect.rows[i]; 
		for(var j=0; j<row.cells.length; j++) // j= cellIndex
	 	{
       		if(row.cells[j].rowSpan>1 && i+row.cells[j].rowSpan>ridx)
		 	row.cells[j].rowSpan += 1;
	 	}
  	}
};

XK_tableNode.prototype.getTd = function()
{
    var iframeId='iframe'+this.id;
	if (isie)
	{
	    document.getElementById(iframeId).contentWindow.focus();
		if (document.getElementById(iframeId).contentWindow.document.selection.type != 'Control')
    	{
      		var tControl =document.getElementById(iframeId).contentWindow.document.selection.createRange();
      		tControl = tControl.parentElement();
     		 while ((tControl.tagName.toLowerCase() != 'td') && (tControl.tagName.toLowerCase()!= 'th') && (tControl.tagName.toLowerCase()!= 'table') && (tControl.tagName.toLowerCase() != 'body'))
      		{
        		tControl = tControl.parentElement;
      		}
      			if ((tControl.tagName.toLowerCase() == 'td') || (tControl.tagName.toLowerCase() == 'th'))
       			return(tControl);
      			else
        		return (null);
    		}
   		else
    	{
      		return (null);
   		}
	}
	else
	{
		var td = this.XK_isInsideThisTagMoz ('TD');
		if (td==false)td = this.XK_isInsideThisTagMoz ('TH');
		if (td==false) return(null);
		else return(td);
	}
};

XK_tableNode.prototype.getTable = function()
{
    var iframeId='iframe'+this.id;
	if (isie)
	{
	    document.getElementById(iframeId).contentWindow.focus();
		if (document.getElementById(iframeId).contentWindow.document.selection.type != 'Control')
    	{
      		var tControl =document.getElementById(iframeId).contentWindow.document.selection.createRange();
      		tControl = tControl.parentElement();
     		 while ((tControl.tagName.toLowerCase() != 'table') && (tControl.tagName.toLowerCase() != 'body'))
      		{
        		tControl = tControl.parentElement;
      		}
      			if (tControl.tagName.toLowerCase() == 'table') 
       			return(tControl);
      			else
        		return(null);
    		}
   		else
    	{
      		return(null);
   		}
	}
	else
	{
		var table = this.XK_isInsideThisTagMoz ('TABLE');
		if (table==false) return(null);
		else return(table);
	}
};

XK_tableNode.prototype.getColumnNo = function(oTD)
{
	var cidx= oTD.cellIndex;
	var rowSelect= oTD.parentNode;
	var idx, row, colx ;
 	var rspan = new Array() ;
 	for(var i=0; i<rowSelect.rowIndex+1; i++)
  	{
   		row= this.tableSelect.rows[i];
   		idx=0; 
   		for(var j=0; j<row.cells.length; j++) // j= cellIndex
   		{
     		if(!rspan[j+idx])rspan[j+idx]=0;
	 		if(!row.cells[j]) break;
	 		while(rspan[j+idx]>0) { rspan[j+idx]--; idx++ }
     		rspan[j+idx]=row.cells[j].rowSpan-1;
   	 		if(i==rowSelect.rowIndex && j==cidx){ colx=j+idx; break }
  	 		idx += row.cells[j].colSpan-1;
   		}
  	}
 	return colx;
};

XK_tableNode.prototype.getMaxColumn = function()
{
	var cell, colnum=0;
 	for(var i=0; i<this.tableSelect.rows[0].cells.length ; i++) // i= cellIndex
  	{
   		cell= this.tableSelect.rows[0].cells[i];
   		colnum += cell.colSpan;
  	}
 	return colnum;
};

XK_tableNode.prototype.XK_isInsideThisTagMoz = function(tagname)
{
	var iframeId='iframe'+this.id;
	var sel=document.getElementById(iframeId).contentWindow.getSelection();
  	var range = sel.getRangeAt(0);
	var container = range.startContainer;
	if (container.nodeType != 1) {
		var textNode = container;
    	container = textNode.parentNode;
	}
	thisTag = container;
	while(thisTag.tagName.toLowerCase()!=tagname.toLowerCase() &&thisTag.tagName.toLowerCase()!='body') {
			thisTag = thisTag.parentNode;
	}
	if (thisTag.tagName.toLowerCase() == tagname.toLowerCase()) {
		return (thisTag);
	} else {
		return false;
	}
};

//---------------------------------END CONSTRUCTORS----------------------------------------------------


//useful functions

function XK_RgbToHex(rgb)
{
	var digit = new Array ( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F' );
	var hex= new Array();
	var r = new Array();
	var n1;
	var n2;
	var retstr;
	
	//prepare numbers
	rgb = rgb.substr(4);
	rgb = rgb.replace(/\)/, '');
	r= rgb.split(',');


	for(i=0;i<3;i++)
	{
		n1 = Math.floor ( r[i] / 16 );
		n2 = r[i] - n1 * 16;
		retstr = digit[ n1 ];
		retstr += digit[ n2 ];
		hex[i]=retstr;
	}
	return('#'+hex[0]+''+hex[1]+''+hex[2]+'');

};


function XK_tableOver(id,i,j) 
{
var prueb;
	for(r=1;r<=i;r++)
   	{
		for(s=1;s<=j;s++)
   		{
			x =document.getElementById(id+'-'+r+'-'+s);
			x.style.backgroundColor = 'blue';
		}
	}
};
	
function XK_tableOut(id,i,j) 
{
	for(r=1;r<=i;r++)
   	{
		for(s=1;s<=j;s++)
   		{
			x =document.getElementById(id+'-'+r+'-'+s);
			x.style.backgroundColor = 'white';
		}
	}
		
};
	
function XK_tableClick(id,i,j) 
{
	XK_Easytable(id,i,j);
	XK_tableOut(id);
};

function XK_tableProp(id,ntProps)
{
    var iframeId='iframe'+id;
	document.getElementById(iframeId).contentWindow.focus();    
	myTableNode = new XK_tableNode(id);
	var tTable = myTableNode.table ;
	
	var tProps = {};
    tProps.width 			= (tTable.style.width)?tTable.style.width:tTable.width;
    tProps.height 			= (tTable.style.height)?tTable.style.height:tTable.height;
    tProps.border 			= tTable.border;
    tProps.borderColor		= tTable.getAttribute('borderColor');
    tProps.cellPadding 		= tTable.cellPadding;
    tProps.cellSpacing 		= tTable.cellSpacing;
    tProps.bgColor 			= tTable.bgColor;
    tProps.backgroundImage	= tTable.style.backgroundImage;   
    tProps.collapse 		=(tTable.style.borderCollapse)?tTable.style.borderCollapse:'';
    tProps.className 		= tTable.className;

    if (ntProps!=null)
	{
      // set new settings
      
      tTable.style.borderCollapse=ntProps.collapse;
      
      if (ntProps.width)
      {
      	tTable.style.width = ntProps.width;  	
      }
	  else tTable.style.width ='';
	  tTable.removeAttribute('width',0);

      if (ntProps.height)
      {
      	tTable.style.height = ntProps.height; 	
      }
	  else tTable.style.height ='';
	  tTable.removeAttribute('height',0);
	  
	  if (ntProps.border)tTable.border = ntProps.border;
	  else tTable.removeAttribute('border',0);
      if (ntProps.cellPadding)tTable.cellPadding = ntProps.cellPadding;
	  else tTable.removeAttribute('cellpadding',0);
      if (ntProps.cellSpacing)tTable.cellSpacing = ntProps.cellSpacing;
	  else tTable.removeAttribute('cellspacing',0);
	  if (ntProps.bgColor)tTable.bgColor = ntProps.bgColor;
	  else tTable.removeAttribute('bgcolor',0);
	  if (ntProps.background)tTable.background = ntProps.background;
	  else tTable.removeAttribute('background',0);
	  if (ntProps.borderColor)tTable.setAttribute('borderColor',ntProps.borderColor);
	  else tTable.removeAttribute('borderColor',0);
	  	
	  if (ntProps.className)tTable.className = ntProps.className;
	  else tTable.removeAttribute('className',0);
	  
	  if(ntProps.backgroundImage)tTable.style.backgroundImage	= 'url('+ntProps.backgroundImage+')';
      else{
      		tTable.removeAttribute('backgroundImage',0); 
      		tTable.style.backgroundImage='';
      	} 
    }
	else return tProps;
};

function XK_cellProp(id,ncProps)
{	   
	myTableNode = new XK_tableNode(id);
	var cd = myTableNode.td;
	var cProps = {};
	cProps.width 				= (cd.style.width)?cd.style.width:cd.width;
	cProps.height		 		= (cd.style.height)?cd.style.height:cd.height;
	cProps.bgColor				= cd.bgColor;
	cProps.backgroundImage		= cd.style.backgroundImage;
	cProps.align 				= cd.align;
	cProps.valign 				= cd.valign;
	cProps.className 			= cd.className;
	cProps.noWrap 				= cd.noWrap;
	//borders style
      	
	cProps.borderLeftStyle 		= cd.style.borderLeftStyle;
	cProps.borderRightStyle		= cd.style.borderRightStyle;
	cProps.borderTopStyle 		= cd.style.borderTopStyle;
	cProps.borderBottomStyle 	= cd.style.borderBottomStyle;  	

	//borders Width
	cProps.borderLeftWidth		= cd.style.borderLeftWidth; 
	cProps.borderRightWidth		= cd.style.borderRightWidth;
	cProps.borderTopWidth		= cd.style.borderTopWidth;
	cProps.borderBottomWidth	= cd.style.borderBottomWidth;
				
	//borders Color
	if(isie)
	{
		cProps.borderLeftColor		= cd.style.borderLeftColor;
		cProps.borderRightColor		= cd.style.borderRightColor;
		cProps.borderTopColor 		= cd.style.borderTopColor; 
		cProps.borderBottomColor	= cd.style.borderBottomColor;
	}
	else
	{
		cProps.borderLeftColor		= (cd.style.borderLeftColor)?XK_RgbToHex(cd.style.borderLeftColor):cd.style.borderLeftColor;			
		cProps.borderRightColor		= (cd.style.borderRightColor)?XK_RgbToHex(cd.style.borderRightColor):cd.style.borderRightColor;
		cProps.borderTopColor 		= (cd.style.borderTopColor)?XK_RgbToHex(cd.style.borderTopColor):cd.style.borderTopColor; 
		cProps.borderBottomColor	= (cd.style.borderBottomColor)?XK_RgbToHex(cd.style.borderBottomColor):cd.style.borderBottomColor;
	}
        
        //padding
        cProps.paddingLeft		= cd.style.paddingLeft; 
		cProps.paddingRight		= cd.style.paddingRight;
		cProps.paddingTop		= cd.style.paddingTop;
		cProps.paddingBottom	= cd.style.paddingBottom;

        
        if (ncProps!=null)  
      	{
        	//new settings
	  		if (ncProps.align)cd.align = ncProps.align;
			else cd.removeAttribute('align',0);
			if (ncProps.vAlign)cd.vAlign = ncProps.vAlign;
			else cd.removeAttribute('valign',0);
			if (ncProps.width)
			{
				cd.style.width = ncProps.width;
				cd.removeAttribute('width',0);
			}
			else
			{
				cd.style.width = '';
				cd.removeAttribute('width',0);
			}
        	if (ncProps.height)
			{
				cd.style.height = ncProps.height;
				cd.removeAttribute('height',0);
			}
			else
			{
				cd.style.height = '';
				cd.removeAttribute('height',0);
			}
        	cd.style.height = (ncProps.height)?ncProps.height:'';
        	if (ncProps.bgColor)cd.bgColor = ncProps.bgColor;
			else cd.removeAttribute('bgcolor',0);
	    	if (ncProps.background)cd.background = ncProps.background;
			else cd.removeAttribute('background',0);
			if (ncProps.className)cd.className = ncProps.className;
			else cd.removeAttribute('className',0);
			if (ncProps.noWrap)cd.noWrap = ncProps.noWrap;
			else cd.removeAttribute('nowrap',0);           	
        	
        	//borders style

      		cd.style.borderLeftStyle 	= ncProps.borderLeftStyle;
      		cd.style.borderRightStyle 	= ncProps.borderRightStyle;
      		cd.style.borderTopStyle 	= ncProps.borderTopStyle;
      		cd.style.borderBottomStyle 	= ncProps.borderBottomStyle; 	
      	
      		//borders Width
      		cd.style.borderLeftWidth 	= ncProps.borderLeftWidth;
      		cd.style.borderRightWidth 	= ncProps.borderRightWidth;
      		cd.style.borderTopWidth 	= ncProps.borderTopWidth;
      		cd.style.borderBottomWidth 	= ncProps.borderBottomWidth;
				
			//borders Color
      		cd.style.borderLeftColor 	= ncProps.borderLeftColor;
      		cd.style.borderRightColor 	= ncProps.borderRightColor;
      		cd.style.borderTopColor 	= ncProps.borderTopColor;
      		cd.style.borderBottomColor 	= ncProps.borderBottomColor;
      		
      		///padding Width
      		cd.style.paddingLeft 	= ncProps.paddingLeft;
      		cd.style.paddingRight 	= ncProps.paddingRight;
      		cd.style.paddingTop 	= ncProps.paddingTop;
      		cd.style.paddingBottom 	= ncProps.paddingBottom;

      		if(ncProps.backgroundImage)cd.style.backgroundImage	= 'url('+ncProps.backgroundImage+')';
      		else{
      				cd.removeAttribute('backgroundImage',0); 
      				cd.style.backgroundImage='';
      			}

      		return;       	      	
      	}
	  	else return cProps;
};

function getCellIndex(colx, row)
{
 var tableSelect= row.parentNode;
 var rowIdx= row.rowIndex;

 var rspan= new Array();
 var newCell, cs , idx;
 for(var i=0; i<rowIdx+1; i++)
  {
   row= tableSelect.rows[i];
   idx=0; 
   for(var j=0; j<=colx ; j++) // j= cellIndex
   	{
	 if(!rspan[j+idx])rspan[j+idx]=0;
   	 
	 while(rspan[j+idx]){rspan[j+idx]--; idx++ }

     if(row.cells[j]) rspan[j+idx]=row.cells[j].rowSpan-1;
	 if(!row.cells[j] || (j+idx>=colx) )
   	 {
       if(i==rowIdx) return j;
	   else break;
     }
  	 idx += row.cells[j].colSpan-1;
   	}
  }

};

function XK_toggleBorders(id)
{
	try{XK_DeleteCss(id,'xoopsborders')}
	catch(e){XK_AppendCss(id,url+'/skins/common/borders.css','xoopsborders');}
};