<?php
/**
 * user select with page navigation
 *
 * limit: Only work with javascript enabled
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		kernal
 */
if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

class XoopsFormSelectUser extends XoopsFormElementTray
{
	/**
	 * Constructor
	 *
	 * @param	string	$caption
	 * @param	string	$name
	 * @param	mixed	$value	    	Pre-selected value (or array of them).
	 *									For an item with massive members, such as "Registered Users", "$value" should be used to store selected temporary users only instead of all members of that item
	 * @param	bool	$include_anon	Include user "anonymous"?
	 * @param	int		$size	        Number or rows. "1" makes a drop-down-list.
     * @param	bool    $multiple       Allow multiple selections?
	 */
	function XoopsFormSelectUser($caption, $name, $include_anon = false, $value = array(), $size = 1, $multiple = false)
	{
	    $this->XoopsFormElementTray($caption, "<br /><br />", $name);

        $select_form = new XoopsFormSelect("", $name, $value, $size, $multiple);
        if ($include_anon) {
            $select_form->addOption(0, $GLOBALS["xoopsConfig"]['anonymous']);
        }
        $member_handler = &xoops_gethandler('member');
        $criteria = new CriteriaCompo();
        if (!is_array($value)) {
            $value = array($value);
        }
	    if(is_array($value) && count($value)>0) {
		    $id_in = "(".implode(",", $value).")";
			$criteria->add(new Criteria("uid", $id_in, "IN"));
	        $criteria->setSort('name');
	        $criteria->setOrder('ASC');
        	$users = $member_handler->getUserList($criteria);
        	$select_form->addOptionArray($member_handler->getUserList($criteria));
	    }

	    $mid = is_object($GLOBALS["xoopsModule"])?$GLOBALS["xoopsModule"]->getVar("mid"):0;
	    $action_tray = new XoopsFormElementTray("", " | ");
	    $action_tray->addElement(new XoopsFormLabel('', "<a href='###' onclick='return openWithSelfMain(\"".XOOPS_URL."/Frameworks/xoops22/include/userselect.php?action=1&amp;target=".$name."&amp;multiple=".$multiple."&amp;mid=".$mid."\", \"userselect\", 800, 500, null);' >"._LIST."</a>"));
	    $action_tray->addElement(new XoopsFormLabel('', "<a href='###' onclick='return openWithSelfMain(\"".XOOPS_URL."/Frameworks/xoops22/include/userselect.php?action=0&amp;target=".$name."&amp;multiple=".$multiple."&amp;mid=".$mid."\", \"userselect\", 800, 500, null);' >"._SEARCH."</a>"));
	    $action_tray->addElement(new XoopsFormLabel('', "<a href='###' onclick='var sel = xoopsGetElementById(\"".$name.($multiple?"[]":"")."\");for (var i = sel.options.length-1; i >= 0; i--) {if (sel.options[i].selected) {sel.options[i] = null;}}'>"._DELETE."</a>".
			"<script type=\"text/javascript\">
		    function addusers(opts){
			    var num = opts.substring(0, opts.indexOf(\":\"));
			    opts = opts.substring(opts.indexOf(\":\")+1, opts.length);
        		var sel = xoopsGetElementById(\"".$name.($multiple?"[]":"")."\");
			    var arr = new Array(num);
			    for(var n=0; n<num; n++){
			    	var nm = opts.substring(0, opts.indexOf(\":\"));
			    	opts = opts.substring(opts.indexOf(\":\")+1, opts.length);
			    	var val = opts.substring(0, opts.indexOf(\":\"));
			    	opts = opts.substring(opts.indexOf(\":\")+1, opts.length);
			    	var txt = opts.substring(0, nm - val.length);
			    	opts = opts.substring(nm - val.length, opts.length);
					var added = false;
					for (var k = 0; k < sel.options.length; k++) {
						if(sel.options[k].value == val){
							added = true;
							break;
						}
					}
					if(added==false){
						sel.options[k] = new Option(txt, val);
						sel.options[k].selected = true;
	        		}
			    }
				return true;
		    }
			</script>"
			));

	    $this->addElement($select_form);
	    $this->addElement($action_tray);
    }
}
?>