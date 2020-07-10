<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		http://xoopsforge.com The XOOPS FORGE Project
* @copyright		http://xoops.org.cn The XOOPS CHINESE Project
* @copyright		XOOPS_copyrights.txt
* @copyright		readme.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license			GNU General Public License (GPL)
*					a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		CBB - XOOPS Community Bulletin Board
* @since			3.08
* @author		phppp
* ----------------------------------------------------------------------------------------------------------
* 				iForum - a bulletin Board (Forum) for ImpressCMS
* @since			1.00
* @author		modified by stranger
* @version		$Id$
*/

/**
 * @package     kernel
 * 
 * @author	    D.J.
 * @copyright	copyright (c) 2000-2005 XOOPS.org
 */

class XoopsRank extends XoopsObject
{
    function __construct()
    {
        $this->XoopsObject();
        $this->initVar('rank_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('rank_title', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('rank_min', XOBJ_DTYPE_INT, 0);
        $this->initVar('rank_max', XOBJ_DTYPE_INT, 0);
        $this->initVar('rank_special', XOBJ_DTYPE_INT, 0);
        $this->initVar('rank_image', XOBJ_DTYPE_TXTBOX, "");
    }
}
class XoopsRankHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) {
        $this->XoopsPersistableObjectHandler($db, 'ranks', 'XoopsRank', 'rank_id', 'rank_title');
    }
}