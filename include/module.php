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
 
defined('ICMS_ROOT_PATH') or exit();

if (defined("XOOPS_MODULE_IFORUM_FUCTIONS")) exit();
define("XOOPS_MODULE_IFORUM_FUCTIONS", 1);
 
@include_once ICMS_ROOT_PATH.'/modules/'.basename(dirname(dirname(__FILE__ ) ) ).'/include/plugin.php';
include_once ICMS_ROOT_PATH.'/modules/'.basename(dirname(dirname(__FILE__ ) ) ).'/include/functions.php';
 
iforum_load_object();
function icms_module_update_iforum(&$module, $oldversion = null, $olddbversion = null) {
	$icmsDatabaseUpdater = icms_db_legacy_Factory::getDatabaseUpdater();
	$iforumConfig = iforum_load_config();
	 
	$newDbVersion = 1;
	if ($olddbversion < $newDbVersion) {
		echo "Database migrate to version " . $newDbVersion . "<br />";
		$table = new icms_db_legacy_updater_Table('bb_topics');
		if (!$table->fieldExists('topic_tags')) {
			$table->addNewField('topic_tags', "varchar(255) NOT NULL default ''");
			if (!$icmsDatabaseUpdater->updateTable($table)) {
				$module->setErrors("Could not add field in bb_topics");
			}
		}
	}

	if (!empty($iforumConfig["syncOnUpdate"])) {
		iforum_synchronization();
	}
	$icmsDatabaseUpdater->updateModuleDBVersion($newDbVersion, basename(dirname(dirname(__FILE__ ) ) ));
	 
	return true;
}
 
function icms_module_install_iforum(&$module) {
	/* Create a test category */
	$category_handler = icms_getmodulehandler('category', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
	$category = $category_handler->create();
	$category->setVar('cat_title', _MI_IFORUM_INSTALL_CAT_TITLE, true);
	$category->setVar('cat_image', "", true);
	$category->setVar('cat_order', 1);
	$category->setVar('cat_description', _MI_IFORUM_INSTALL_CAT_DESC, true);
	$category->setVar('cat_url', "http://www.impresscms.org ImpressCMS", true);
	if (!$cat_id = $category_handler->insert($category)) {
		return true;
	}
	 
	/* Create a forum for test */
	$forum_handler = icms_getmodulehandler('forum', basename(dirname(dirname(__FILE__ ) ) ), 'iforum' );
	$forum = $forum_handler->create();
	$forum->setVar('forum_name', _MI_IFORUM_INSTALL_FORUM_NAME, true);
	$forum->setVar('forum_desc', _MI_IFORUM_INSTALL_FORUM_DESC, true);
	$forum->setVar('forum_order', 1);
	$forum->setVar('forum_moderator', array());
	$forum->setVar('parent_forum', 0);
	$forum->setVar('cat_id', $cat_id);
	$forum->setVar('forum_type', 0);
	$forum->setVar('allow_html', 1);
	$forum->setVar('allow_sig', 1);
	$forum->setVar('allow_polls', 0);
	$forum->setVar('allow_subject_prefix', 1);
	//$forum->setVar('allow_attachments', 1);
	$forum->setVar('attach_maxkb', 100);
	$forum->setVar('attach_ext', "zip|jpg|gif");
	$forum->setVar('hot_threshold', 20);
	$forum_id = $forum_handler->insert($forum);
	 
	/* Set corresponding permissions for the category and the forum */
	$module_id = $module->getVar("mid") ;
	$gperm_handler = icms::handler("icms_member_groupperm");
	$groups_view = array(ICMS_GROUP_ADMIN, ICMS_GROUP_USERS, ICMS_GROUP_ANONYMOUS);
	$groups_post = array(ICMS_GROUP_ADMIN, ICMS_GROUP_USERS);
	$post_items = array('post', 'reply', 'edit', 'delete', 'addpoll', 'vote', 'attach', 'noapprove');
	foreach ($groups_view as $group_id) {
		$gperm_handler->addRight("category_access", $cat_id, $group_id, $module_id);
		$gperm_handler->addRight("forum_access", $forum_id, $group_id, $module_id);
		$gperm_handler->addRight("forum_view", $forum_id, $group_id, $module_id);
	}
	foreach ($groups_post as $group_id) {
		foreach($post_items as $item) {
			$gperm_handler->addRight("forum_".$item, $forum_id, $group_id, $module_id);
		}
	}
	 
	/* Create a test post */
	$post_handler = icms_getmodulehandler('post', basename(dirname(dirname(__FILE__))), 'iforum' );
	$forumpost = $post_handler->create();
	$forumpost->setVar('poster_ip', iforum_getIP());
	$forumpost->setVar('uid', (isset(icms::$user) ? icms::$user->getVar("uid") : 1));
	$forumpost->setVar('approved', 1);
	$forumpost->setVar('forum_id', $forum_id);
	$forumpost->setVar('subject', _MI_IFORUM_INSTALL_POST_SUBJECT, true);
	$forumpost->setVar('dohtml', 1);
	$forumpost->setVar('dosmiley', 1);
	$forumpost->setVar('doxcode', 1);
	$forumpost->setVar('dobr', 1);
	$forumpost->setVar('icon', "", true);
	$forumpost->setVar('attachsig', 1);
	$forumpost->setVar('post_time', time());
	$forumpost->setVar('post_text', _MI_IFORUM_INSTALL_POST_TEXT, true);
	$postid = $post_handler->insert($forumpost);
	 
	return true;
}
 
function iforum_setModuleConfig(&$module, $isUpdate = false) {
	return true;
}