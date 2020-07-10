<?php
/**
* iForum - a bulletin Board (Forum) for ImpressCMS
*
* Based upon CBB 3.08
*
* @copyright  http://www.xoops.org/ The XOOPS Project
* @copyright  http://xoopsforge.com The XOOPS FORGE Project
* @copyright  http://xoops.org.cn The XOOPS CHINESE Project
* @copyright  XOOPS_copyrights.txt
* @copyright  readme.txt
* @copyright  http://www.impresscms.org/ The ImpressCMS Project
* @license   GNU General Public License (GPL)
*     a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package  CBB - XOOPS Community Bulletin Board
* @since   3.08
* @author  phppp
* ----------------------------------------------------------------------------------------------------------
*     iForum - a bulletin Board (Forum) for ImpressCMS
* @since   1.00
* @author  modified by stranger
* @version  $Id$
*/
 
defined("ICMS_ROOT_PATH") or exit();

class iforum_uploader extends icms_file_MediaUploadHandler {
	/**
	 * Constructor
	 * No admin check for uploads
	 *
	 * @param string  $uploadDir
	 * @param array  $allowedMimeTypes
	 * @param int   $maxFileSize
	 * @param int   $maxWidth
	 * @param int   $maxHeight
	 */
	public function __construct($uploadDir, $allowedMimeTypes = array(), $maxFileSize = 0, $maxWidth = null, $maxHeight = null) {
		if (!is_array($allowedMimeTypes)) {
			if (empty($allowedMimeTypes) || $allowedMimeTypes == "*") {
				$allowedMimeTypes = array();
			} else {
				$allowedMimeTypes = explode("|", strtolower($allowedMimeTypes));
			}
		}
		$allowedMimeTypes = array_filter(array_map("trim", $allowedMimeTypes));
		
		// get corresponding mimetypes from mimetype handler
		$mimetypeHandler = icms_getModulehandler('mimetype', 'system');
		$mimetypes = $mimetypeHandler->getObjects(new icms_db_criteria_Item('extension', '("' . implode('","', $allowedMimeTypes) . '")', 'IN'));
		$allowedMimeTypes = array();
		foreach ($mimetypes as $mimetype) {
			$allowedMimeTypes = array_merge($allowedMimeTypes, explode(" ", $mimetype->getVar("types")));
		}
		
		parent::__construct($uploadDir, $allowedMimeTypes, $maxFileSize, $maxWidth, $maxHeight);
	}	 
}