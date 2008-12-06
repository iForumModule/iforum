/*
Adapted by D.J. from Mike Hall's "Revenge of the Menu Bar" -- http://www.brainjar.com/
Use of Programming Code
May be used, redistributed and/or modified under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License or (at your option) any later version.
*/

function openMenu(event, id) {

  var el, x, y;

  el = document.getElementById(id);
  if (window.event) {
    x = window.event.clientX + document.documentElement.scrollLeft
                             + document.body.scrollLeft;
    y = window.event.clientY + document.documentElement.scrollTop +
                             + document.body.scrollTop;
  }
  else {
    x = event.clientX + window.scrollX;
    y = event.clientY + window.scrollY;
  }
  x -= 2; y -= 2;
  el.style.left = x + "px";
  el.style.top  = y + "px";
  el.style.visibility = "visible";
}

function closeMenu(event) {

  var current, related;

  if (window.event) {
    current = this;
    related = window.event.toElement;
  }
  else {
    current = event.currentTarget;
    related = event.relatedTarget;
  }

  if (current != related && !contains(current, related))
    current.style.visibility = "hidden";
}

function contains(a, b) {

  // Return true if node a contains node b.

  while (b.parentNode)
    if ((b = b.parentNode) == a)
      return true;
  return false;
}