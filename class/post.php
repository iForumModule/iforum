<?php
// $Id: post.php,v 1.3 2005/10/19 17:20:32 phppp Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
include_once XOOPS_ROOT_PATH.'/modules/newbb/include/functions.ini.php';
newbb_load_object();

class Post extends ArtObject {
    var $db;
    var $attachment_array = array();

    function Post($id = null)
    {
        $this->db = &Database::getInstance();
        $this->initVar('post_id', XOBJ_DTYPE_INT);
        $this->initVar('topic_id', XOBJ_DTYPE_INT);
        $this->initVar('forum_id', XOBJ_DTYPE_INT);
        $this->initVar('post_time', XOBJ_DTYPE_INT);
        $this->initVar('poster_ip', XOBJ_DTYPE_INT);
        $this->initVar('poster_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('subject', XOBJ_DTYPE_TXTBOX);
        $this->initVar('pid', XOBJ_DTYPE_INT);
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 0);
        $this->initVar('dosmiley', XOBJ_DTYPE_INT, 1);
        $this->initVar('doxcode', XOBJ_DTYPE_INT, 1);
        $this->initVar('uid', XOBJ_DTYPE_INT, 1);
        $this->initVar('icon', XOBJ_DTYPE_TXTBOX);
        $this->initVar('attachsig', XOBJ_DTYPE_INT);
        $this->initVar('approved', XOBJ_DTYPE_INT, 1);
        $this->initVar('post_karma', XOBJ_DTYPE_INT);
        $this->initVar('require_reply', XOBJ_DTYPE_INT);
        $this->initVar('attachment', XOBJ_DTYPE_TXTAREA);
        $this->initVar('post_text', XOBJ_DTYPE_TXTAREA);
        $this->initVar('post_edit', XOBJ_DTYPE_TXTAREA);
        $this->initVar('doimage', XOBJ_DTYPE_INT, 1);
        $this->initVar('dobr', XOBJ_DTYPE_INT, 1);
    }
    
    /**
     * add slashes to string variables of the object for storage.
     * also add slashes whereever needed
     *
     * @return bool true if successful
     * @access public
     */
    function prepareVars()
    {
        foreach ($this->vars as $k => $v) {
            $cleanv = $this->cleanVars[$k];
            switch ($v['data_type']) {
                case XOBJ_DTYPE_TXTBOX:
                case XOBJ_DTYPE_TXTAREA:
                case XOBJ_DTYPE_SOURCE:
                case XOBJ_DTYPE_EMAIL:
                    $cleanv = ($v['changed'])?$cleanv:(empty($v['value'])?'':$v['value']);
                    if (!isset($v['not_gpc']) || !$v['not_gpc']) {
                        $cleanv = $this->db->quoteString($cleanv);
                    }
                    break;
                case XOBJ_DTYPE_INT:
                    $cleanv = ($v['changed'])?intval($cleanv):(empty($v['value'])?0:$v['value']);
                    break;
                case XOBJ_DTYPE_ARRAY:
                    $cleanv = ($v['changed'])?$cleanv:serialize((count($v['value'])>0)?$v['value']:array());
                    break;
                case XOBJ_DTYPE_STIME:
                case XOBJ_DTYPE_MTIME:
                case XOBJ_DTYPE_LTIME:
                    $cleanv = ($v['changed'])?$cleanv:(empty($v['value'])?0:$v['value']);
                    break;

                default:
                    break;
            }
            $this->cleanVars[$k] = &$cleanv;
            unset($cleanv);
        }
        return true;
    }
    // ////////////////////////////////////////////////////////////////////////////////////
    // attachment functions    TODO: there should be a file/attachment management class
    function getAttachment()
    {
        if (count($this->attachment_array)) return $this->attachment_array;
        $attachment = $this->getVar('attachment');
        if (empty($attachment)) $this->attachment_array = null;
        else $this->attachment_array = @unserialize(base64_decode($attachment));
        return $this->attachment_array;
    }

    function incrementDownload($attach_key)
    {
        if (!$attach_key) return false;
        $this->attachment_array[strval($attach_key)]['num_download'] ++;
        return $this->attachment_array[strval($attach_key)]['num_download'];
    }

    function saveAttachment()
    {
        if (is_array($this->attachment_array) && count($this->attachment_array) > 0)
            $attachment_save = base64_encode(serialize($this->attachment_array));
        else $attachment_save = '';
        $this->setVar('attachment', $attachment_save);
        $sql = "UPDATE " . $this->db->prefix("bb_posts") . " SET attachment=" . $this->db->quoteString($attachment_save) . " WHERE post_id = " . $this->getVar('post_id');
        if (!$result = $this->db->queryF($sql)) {
            newbb_message("save attachment error: ". $sql);
            return false;
        }
        return true;
    }

    function deleteAttachment($attach_array = null)
    {
        global $xoopsModuleConfig;

        $attach_old = $this->getAttachment();
        if (!is_array($attach_old) || count($attach_old) < 1) return true;
        $this->attachment_array = array();

        if ($attach_array === null) $attach_array = array_keys($attach_old); // to delete all!
        if (!is_array($attach_array)) $attach_array = array($attach_array);

        foreach($attach_old as $key => $attach) {
            if (in_array($key, $attach_array)) {
                @unlink(XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['dir_attachments'] . '/' . $attach['name_saved']);
                @unlink(XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['dir_attachments'] . '/thumbs/' . $attach['name_saved']); // delete thumbnails
                continue;
            }
            $this->attachment_array[$key] = $attach;
        }
        if (is_array($this->attachment_array) && count($this->attachment_array) > 0)
            $attachment_save = base64_encode(serialize($this->attachment_array));
        else $attachment_save = '';
        $this->setVar('attachment', $attachment_save);
        return true;
    }

    function setAttachment($name_saved = '', $name_display = '', $mimetype = '', $num_download = 0)
    {
	    static $counter=0;
        $this->attachment_array = $this->getAttachment();
        if ($name_saved) {
            $key = strval(time()+$counter++);
            $this->attachment_array[$key] = array('name_saved' => $name_saved,
                'name_display' => isset($name_display)?$name_display:$name_saved,
                'mimetype' => $mimetype,
                'num_download' => isset($num_download)?intval($num_download):0
                );
        }
        if (is_array($this->attachment_array)){
            $attachment_save = base64_encode(serialize($this->attachment_array));
        }else{
	        $attachment_save = null;
        }
        $this->setVar('attachment', $attachment_save);
        return true;
    }

    function displayAttachment($asSource = false)
    {
        global $xoopsModule, $xoopsModuleConfig;

        $post_attachment = '';
        $attachments = $this->getAttachment();
        if (is_array($attachments) && count($attachments) > 0) {
        	$image_extensions = array("jpg", "jpeg", "gif", "png", "bmp"); // need improve !!!
	        $post_attachment .= '<br /><strong>' . _MD_ATTACHMENT . '</strong>:';
	        $post_attachment .= '<br /><hr size="1" noshade="noshade" /><br />';
            foreach($attachments as $key => $att) {
                $file_extension = ltrim(strrchr($att['name_saved'], '.'), '.');
                $filetype = $file_extension;
                if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/images/filetypes/' . $filetype . '.gif'))
                    $icon_filetype = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/images/filetypes/' . $filetype . '.gif';
                else
                    $icon_filetype = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/images/filetypes/unknown.gif';
                $file_size = filesize(XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['dir_attachments'] . '/' . $att['name_saved']);
                $file_size = number_format ($file_size / 1024, 2)." KB";
                if (in_array(strtolower($file_extension), $image_extensions) && $xoopsModuleConfig['media_allowed']) {
	                    $post_attachment .= '<br /><img src="' . $icon_filetype . '" alt="' . $filetype . '" /><strong>&nbsp; ' . $att['name_display'] . '</strong> <small>('.$file_size.')</small>';
	                    $post_attachment .= '<br />' . newbb_attachmentImage($att['name_saved'], $asSource);
                		$isDisplayed = true;
                }
                else{
                    $post_attachment .= '<a href="' . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/dl_attachment.php?attachid=' . $key . '&amp;post_id=' . $this->getVar('post_id') . '"> <img src="' . $icon_filetype . '" alt="' . $filetype . '" /> ' . $att['name_display'] . '</a> ' . _MD_FILESIZE . ': '. $file_size . '; '._MD_HITS.': ' . $att['num_download'];
                }
            	$post_attachment .= '<br />';
            }
       }
        return $post_attachment;
    }
    // attachment functions
    // ////////////////////////////////////////////////////////////////////////////////////

    function setPostEdit($poster_name = '')
    {
        global $xoopsConfig, $xoopsModuleConfig, $xoopsUser;

        if( empty($xoopsModuleConfig['recordedit_timelimit'])
        	|| (time()-$this->getVar('post_time'))< $xoopsModuleConfig['recordedit_timelimit'] * 60
        	|| $this->getVar('approved')<1
        ){
	        return true;
        }
        if (is_object($xoopsUser) && $xoopsUser->isActive()) {
            if ($xoopsModuleConfig['show_realname'] && $xoopsUser->getVar('name')) {
                $edit_user = $xoopsUser->getVar('name');
            } else {
                $edit_user = $xoopsUser->getVar('uname');
            }
        }
        $post_edit = array();
        $post_edit['edit_user'] = $edit_user; // The proper way is to store uid instead of name. However, to save queries when displaying, the current way is ok.
        $post_edit['edit_time'] = time();

        $post_edits = $this->getVar('post_edit');
        if (!empty($post_edits)) $post_edits = unserialize(base64_decode($post_edits));
        if (!is_array($post_edits)) $post_edits = array();
        $post_edits[] = $post_edit;
        $post_edit = base64_encode(serialize($post_edits));
        unset($post_edits);
        $this->setVar('post_edit', $post_edit);
        return true;
    }

    function displayPostEdit()
    {
        global $myts, $xoopsModuleConfig;

        if( empty($xoopsModuleConfig['recordedit_timelimit']) ) return false;

        $post_edit = '';
        $post_edits = $this->getVar('post_edit');
        if (!empty($post_edits)) $post_edits = unserialize(base64_decode($post_edits));
        if (!isset($post_edits) || !is_array($post_edits)) $post_edits = array();
        if (is_array($post_edits) && count($post_edits) > 0) {
            foreach($post_edits as $postedit) {
                $edit_time = intval($postedit['edit_time']);
                $edit_user = $myts->stripSlashesGPC($postedit['edit_user']);
                $post_edit .= _MD_EDITEDBY . " " . $edit_user . " " . _MD_ON . " " . formatTimestamp(intval($edit_time)) . "<br/>";
            }
        }
        return $post_edit;
    }


    function &getPostBody($imageAsSource = false)
    {
        global $xoopsConfig, $xoopsModuleConfig, $xoopsUser, $myts;

        $uid = is_object($xoopsUser)? $xoopsUser->getVar('uid'):0;
		$karma_handler =& xoops_getmodulehandler('karma', 'newbb');
		$user_karma = $karma_handler->getUserKarma();

		$post=array();
		$post['attachment'] = false;
		$post_text = newbb_displayTarea($this->vars['post_text']['value'], $this->getVar('dohtml'), $this->getVar('dosmiley'), $this->getVar('doxcode'), $this->getVar('doimage'), $this->getVar('dobr'));
        if (newbb_isAdmin($this->getVar('forum_id')) or $this->checkIdentity()) {
            $post['text'] = $post_text. '<br />' .$this->displayAttachment($imageAsSource);
        } elseif ($xoopsModuleConfig['enable_karma'] && $this->getVar('post_karma') > $user_karma) {
            $post['text'] = sprintf(_MD_KARMA_REQUIREMENT, $user_karma, $this->getVar('post_karma'));
        } elseif ($xoopsModuleConfig['allow_require_reply'] && $this->getVar('require_reply') && (!$uid || !isset($viewtopic_users[$uid]))) {
            $post['text'] = _MD_REPLY_REQUIREMENT;
        } else {
            $post['text'] = $post_text. '<br />' .$this->displayAttachment($imageAsSource);
        }
		$member_handler =& xoops_gethandler('member');
        $eachposter = &$member_handler->getUser($this->getVar('uid'));
        if (is_object($eachposter) && $eachposter->isActive()) {
            if ($xoopsModuleConfig['show_realname'] && $eachposter->getVar('name')) {
                $post['author'] = $eachposter->getVar('name');
            } else {
                $post['author'] = $eachposter->getVar('uname');
            }
        	unset($eachposter);
        } else {
           	$post['author'] = $this->getVar('poster_name')?$this->getVar('poster_name'):$xoopsConfig['anonymous'];
        }

        $post['subject'] = newbb_htmlSpecialChars($this->vars['subject']['value']);

        $post['date'] = $this->getVar('post_time');

        return $post;
    }

    function isTopic()
    {
        if ($this->getVar('pid') == 0) {
            return true;
        }
        return false;
    }

    function checkTimelimit($action_tag = 'edit_timelimit')
    {
        return newbb_checkTimelimit($this->getVar('post_time'), $action_tag);
    }

    function checkIdentity($uid = -1)
    {
        global $xoopsUser;

        $uid = ($uid > -1)?$uid:(is_object($xoopsUser)? $xoopsUser->getVar('uid'):0);
        if ($this->getVar('uid') > 0) {
            $user_ok = ($uid == $this->getVar('uid'))?true:false;
        } else {
            static $user_ip;
            if (!isset($user_ip)) {
                $user_ip = newbb_getIP();
            }
            $user_ok = ($user_ip == $this->getVar('poster_ip'))?true:false;
        }
        return $user_ok;
    }

    // TODO: cleaning up and merge with post hanldings in viewpost.php
    function showPost($isadmin, $forumdata)
    {
        global $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $xoopsUser, $myts, $xoopsTpl, $forumUrl, $forumImage, $viewtopic_users, $viewtopic_posters, $viewtopic_forum, $online, $user_karma, $viewmode, $order, $start, $total_posts;
        static $post_NO = 0;
        static $user_ip;
        
        /* Moved to class permission for centralized process */
		//static $suspension = array();

        $post_NO ++;
        if (strtolower($order) == "desc") $post_no = $total_posts - ($start + $post_NO) + 1;
        else $post_no = $start + $post_NO;

        $uid = is_object($xoopsUser)? $xoopsUser->getVar('uid'):0;

        if ($isadmin or $this->checkIdentity()) {
            $post_text = $this->getVar('post_text');
            $post_attachment = $this->displayAttachment();
        } elseif ($xoopsModuleConfig['enable_karma'] && $this->getVar('post_karma') > $user_karma) {
            $post_text = "<div class='karma'>" . sprintf(_MD_KARMA_REQUIREMENT, $user_karma, $this->getVar('post_karma')) . "</div>";
            $post_attachment = '';
        } elseif (
	        	$xoopsModuleConfig['allow_require_reply']
	        	&& $this->getVar('require_reply')
	        	&& (
	        		!$uid
	        		|| !in_array($uid, $viewtopic_posters)
	        	)
        	) {
            $post_text = "<div class='karma'>" . _MD_REPLY_REQUIREMENT . "</div>";
            $post_attachment = '';
        } else {
            $post_text = $this->getVar('post_text');
            $post_attachment = $this->displayAttachment();
        }
        $poster = (($this->getVar('uid') > 0) && isset($viewtopic_users[$this->getVar('uid')]))?
        	$viewtopic_users[$this->getVar('uid')]:
            array(
            	'poster_uid' => 0,
                'name' => $this->getVar('poster_name')?$this->getVar('poster_name'):$myts->HtmlSpecialChars($xoopsConfig['anonymous']),
                'link' => $this->getVar('poster_name')?$this->getVar('poster_name'):$myts->HtmlSpecialChars($xoopsConfig['anonymous'])
            );

        $posticon = $this->getVar('icon');
        //if (!empty($posticon) && is_file(XOOPS_ROOT_PATH . "/images/subject/" . $posticon))
        if (!empty($posticon)){
            $post_image = '<a name="' . $this->getVar('post_id') . '"><img src="' . XOOPS_URL . '/images/subject/' . $posticon . '" alt="" /></a>';
        }else{
            $post_image = '<a name="' . $this->getVar('post_id') . '"><img src="' . XOOPS_URL . '/images/icons/posticon.gif" alt="" /></a>';
        }

        $post_title = $this->getVar('subject');

        $thread_buttons = array();
        
		if($GLOBALS["xoopsModuleConfig"]['enable_permcheck']){
			
			/*
			if(!isset($suspension[$this->getVar('forum_id')])){
				$moderate_handler =& xoops_getmodulehandler('moderate', 'newbb');
				$suspension[$this->getVar('forum_id')] = $moderate_handler->verifyUser(-1,"",$this->getVar('forum_id'));
			}
			*/
			
	        $topic_handler = &xoops_getmodulehandler('topic', 'newbb');
	
	        //if (!$suspension[$this->getVar('forum_id')] && $topic_handler->getPermission($viewtopic_forum, $forumdata['topic_status'], "edit")) {
	        if ($topic_handler->getPermission($viewtopic_forum, $forumdata['topic_status'], "edit")) {
	            $edit_ok = false;
	            if ($isadmin) {
	                $edit_ok = true;
	            } elseif ($this->checkIdentity() && $this->checkTimelimit('edit_timelimit')) {
	                $edit_ok = true;
	            }
	            if ($edit_ok) {
	                $thread_buttons['edit']['image'] = newbb_displayImage($forumImage['p_edit'], _EDIT);
	                $thread_buttons['edit']['link'] = "edit.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order";
	                $thread_buttons['edit']['name'] = _EDIT;
	            }
	        }
	
	        //if (!$suspension[$this->getVar('forum_id')] && $topic_handler->getPermission($viewtopic_forum, $forumdata['topic_status'], "delete")) {
	        if ($topic_handler->getPermission($viewtopic_forum, $forumdata['topic_status'], "delete")) {
	            $delete_ok = false;
	            if ($isadmin) {
	                $delete_ok = true;
	            } elseif ($this->checkIdentity() && $this->checkTimelimit('delete_timelimit')) {
	                $delete_ok = true;
	            }
	
	            if ($delete_ok) {
	                $thread_buttons['delete']['image'] = newbb_displayImage($forumImage['p_delete'], _DELETE);
	                $thread_buttons['delete']['link'] = "delete.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order";
	                $thread_buttons['delete']['name'] = _DELETE;
	            }
	        }
	        //if (!$suspension[$this->getVar('forum_id')] && $topic_handler->getPermission($viewtopic_forum, $forumdata['topic_status'], "reply")) {
	        if ($topic_handler->getPermission($viewtopic_forum, $forumdata['topic_status'], "reply")) {
	            $thread_buttons['reply']['image'] = newbb_displayImage($forumImage['p_reply'], _MD_REPLY);
	            $thread_buttons['reply']['link'] = "reply.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order&amp;start=$start";
	            $thread_buttons['reply']['name'] = _MD_REPLY;
	            /*
	            $thread_buttons['quote']['image'] = newbb_displayImage($forumImage['p_quote'], _MD_QUOTE);
	            $thread_buttons['quote']['link'] = "reply.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order&amp;start=$start&amp;quotedac=1";
	            $thread_buttons['quote']['name'] = _MD_QUOTE;
	            */
	        }
        
    	}else{
    	
			$thread_buttons['edit']['image'] = newbb_displayImage($forumImage['p_edit'], _EDIT);
			$thread_buttons['edit']['link'] = "edit.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order";
			$thread_buttons['edit']['name'] = _EDIT;
			
			$thread_buttons['delete']['image'] = newbb_displayImage($forumImage['p_delete'], _DELETE);
			$thread_buttons['delete']['link'] = "delete.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order";
			$thread_buttons['delete']['name'] = _DELETE;
			
			$thread_buttons['reply']['image'] = newbb_displayImage($forumImage['p_reply'], _MD_REPLY);
			$thread_buttons['reply']['link'] = "reply.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order&amp;start=$start";
			$thread_buttons['reply']['name'] = _MD_REPLY;
    	
		}
		
        if (!$isadmin && $xoopsModuleConfig['reportmod_enabled']) {
            $thread_buttons['report']['image'] = newbb_displayImage($forumImage['p_report'], _MD_REPORT);
            $thread_buttons['report']['link'] = "report.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order";
            $thread_buttons['report']['name'] = _MD_REPORT;
        }
                
        $thread_action = array();
        /*
        if ($isadmin) {
        	$thread_action['news']['image'] = newbb_displayImage($forumImage['news'], _MD_POSTTONEWS);
        	$thread_action['news']['link'] = "posttonews.php?topic_id=" . $this->getVar('topic_id');
        	$thread_action['news']['name'] = _MD_POSTTONEWS;
        }

        $thread_action['pdf']['image'] = newbb_displayImage($forumImage['pdf'], _MD_PDF);
        $thread_action['pdf']['link'] = "makepdf.php?type=post&amp;pageid=0&amp;scale=0.66";
        $thread_action['pdf']['name'] = _MD_PDF;

        $thread_action['print']['image'] = newbb_displayImage($forumImage['printer'], _MD_PRINT);
        $thread_action['print']['link'] = "print.php?form=2&amp;forum=". $forumdata['forum_id']."&amp;topic_id=" . $this->getVar('topic_id');
        $thread_action['print']['name'] = _MD_PRINT;

        if(is_object($xoopsUser) && $this->getVar('uid') > 0 && isset($viewtopic_users[$this->getVar('uid')])){
	        $thread_action['pm']['image'] = $image_url = "<img src=\"".$forumImage['pm']."\" alt=\""._MD_PM."\" align=\"middle\" />";
	        $thread_action['pm']['link'] = "posttopm.php?";
	        $thread_action['pm']['name'] = _MD_PM;
        }
        */

        $post = array(
	    			'post_id' => $this->getVar('post_id'),
	                'post_parent_id' => $this->getVar('pid'),
	                'post_date' => newbb_formatTimestamp($this->getVar('post_time')),
	                'post_image' => $post_image,
	                'post_title' => $post_title,
	                'post_text' => $post_text,
	                'post_attachment' => $post_attachment,
	                'post_edit' => $this->displayPostEdit(),
	                'post_no' => $post_no,
	                'post_signature' => ($this->getVar('attachsig'))?@$poster["signature"]:"",
	                'poster_ip' => ($isadmin && $xoopsModuleConfig['show_ip'])?long2ip($this->getVar('poster_ip')):"",
			    	'thread_action' => $thread_action,
	                'thread_buttons' => $thread_buttons,
	                'poster' => $poster
	       	);

        //$xoopsTpl->append('topic_posts', $post);

        unset($thread_buttons);
        unset($eachposter);
        
        return $post;
    }

}

class NewbbPostHandler extends ArtObjectHandler
{
    function NewbbPostHandler(&$db) {
        $this->ArtObjectHandler($db, 'bb_posts', 'Post', 'post_id', 'subject');
    }
    
    function &get($id)
    {
	    $id = intval($id);
	    $post = null;
        $sql = 'SELECT p.*, t.*, tp.topic_status FROM ' . $this->db->prefix('bb_posts') . ' p LEFT JOIN ' . $this->db->prefix('bb_posts_text') . ' t ON p.post_id=t.post_id LEFT JOIN ' . $this->db->prefix('bb_topics') . ' tp ON tp.topic_id=p.topic_id WHERE p.post_id=' . $id;
        if($array = $this->db->fetchArray($this->db->query($sql))){
	        $post =& $this->create(false);
	        $post->assignVars($array);
        }

        return $post;
    }

    function &getByLimit($topic_id, $limit, $approved = 1)
    {
        $sql = 'SELECT p.*, t.*, tp.topic_status FROM ' . $this->db->prefix('bb_posts') . ' p LEFT JOIN ' . $this->db->prefix('bb_posts_text') . ' t ON p.post_id=t.post_id LEFT JOIN ' . $this->db->prefix('bb_topics') . ' tp ON tp.topic_id=p.topic_id WHERE p.topic_id=' . $topic_id . ' AND p.approved ='. $approved .' ORDER BY p.post_time DESC';
        $result = $this->db->query($sql, $limit, 0);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $post =& $this->create(false);
            $post->assignVars($myrow);

            $ret[$myrow['post_id']] = $post;
            unset($post);
        }
        return $ret;
    }

    function &create($isNew = true)
    {
        $post = new Post();
        if ($isNew) {
            $post->setNew();
        }
        return $post;
    }

    function getPostForPDF(&$post)
    {
	    return $post->getPostBody(true);
    }

    function getPostForPrint(&$post)
    {
	    return $post->getPostBody();
    }

    function approve(&$post)
    {
	    if(!is_object($post)){
        	$post =& $this->get($post);
    	}
    	$post_id = $post->getVar("post_id");
        if ($post_id==0) {
            newbb_message("post not exist:" . $post_id);
            return false;
        }elseif($post->getVar("approved")>0){
	        return true;
        }
        $sql = "UPDATE " . $this->db->prefix("bb_posts") . " SET approved = 1 WHERE post_id = $post_id";
        if (!$result = $this->db->queryF($sql)) {
            newbb_message("approve post error:" . $sql);
            return false;
        }
        if ($post->isTopic()) {
            $sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET approved = 1 WHERE topic_id = " . $post->getVar('topic_id');
            if (!$result = $this->db->queryF($sql)) {
                newbb_message("approve post error:" . $sql);
                return false;
            }
            $sql = sprintf("UPDATE %s SET topic_last_post_id = %u, topic_time = %u WHERE topic_id = %u", $this->db->prefix("bb_topics"), $post_id, time(), $post->getVar('topic_id'));
            if (!$result = $this->db->queryF($sql)) {
            }
        } else {
            $sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET topic_replies=topic_replies+1, topic_last_post_id = " . $post_id . " WHERE topic_id =" . $post->getVar('topic_id') . "";
            if (!$result = $this->db->queryF($sql)) {
            }
        }
        if ($post->isTopic()) $increment = " forum_topics = forum_topics+1, ";
        else $increment = '';
        $sql = sprintf("UPDATE %s SET forum_posts = forum_posts+1, " . $increment . " forum_last_post_id = %u WHERE forum_id = %u", $this->db->prefix("bb_forums"), $post_id, $post->getVar('forum_id'));
        $result = $this->db->queryF($sql);
        if (!$result) {
        } ;
        $member_handler = &xoops_gethandler('member');
        $poster = &$member_handler->getUser($post->getVar('uid'));
        if (is_object($poster)) {
	        $poster->setVar('posts',$poster->getVar('posts') + 1);
	        $res=$member_handler->insertUser($poster, true);
            //$res = $poster->incrementPost(); 	// In order to make this work, we have to set
            									//$_SERVER['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'] = 'POST';
            unset($poster);
        }

        return true;
    }

    /*
    function unApprove($post_id)
    {
        $sql = "UPDATE " . $this->db->prefix("bb_posts") . " SET approved = 0 WHERE post_id = $post_id";
        if (!$result = $this->db->queryF($sql)) {
            newbb_message("unapprove post error:" . $sql);
            return false;
        }
        return true;
    }
    */

    function insertnewsubject($topic_id, $subject)
    {
        $sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET topic_subject = " . intval($subject) . " WHERE topic_id = $topic_id";
        $result = $this->db->queryF($sql);
        if (!$result) {
            newbb_message("update topic subject error:" . $sql);
            return false;
        }
        return true;
    }

    function insert(&$post, $force = true)
    {
        global $xoopsUser, $xoopsConfig;

        if (!$post->isDirty()) return true;
        if (!$post->cleanVars())return false;
        $post->prepareVars();
        foreach ($post->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        $queryFunc = ($force)?"queryF":"query";
        if ($post->isNew()) {
	        // Change query to queryF for welcome new user -- less security but no better solution
	        // D.J., 14/04/2005
            $post_time = time();
            if (empty($topic_id)) {
                $topic_id = $this->db->genId($this->db->prefix("bb_topics") . "_topic_id_seq");
                $sql = "INSERT INTO " . $this->db->prefix("bb_topics") . "
                			(topic_id,  topic_title, topic_poster, forum_id,  topic_time, poster_name,  approved)
                        VALUES
                        	($topic_id, $subject,    $uid,        $forum_id, $post_time, $poster_name, $approved)";

                if (!$result = $this->db->{$queryFunc}($sql)) {
                    $post->deleteAttachment();
                    $post->setErrors("Insert topic error:" . $sql);
                    return false;
                }
                if ($topic_id == 0) {
                    $topic_id = $this->db->getInsertId();
                }
                $post->setVar('topic_id', $topic_id);
                
                $pid = 0;
	            $post->setVar("pid", 0);
            }elseif(empty($pid)){
				$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
	            $pid = $topic_handler->getTopPostId($topic_id);
	            $post->setVar("pid", $pid);
            }
            $pid = isset($pid)?intval($pid):0;
            $post_id = $this->db->genId($this->db->prefix("bb_posts") . "_post_id_seq");

            $sql = "INSERT INTO " . $this->db->prefix("bb_posts") . "
            			( post_id,  pid,  topic_id,  forum_id,  post_time,  uid,  poster_ip,  poster_name,  subject,  dohtml,  dosmiley,  doxcode,  doimage,  dobr, icon,  attachsig,  attachment,  approved,  post_karma, require_reply)
					VALUES
                    	($post_id, $pid, $topic_id, $forum_id, $post_time, $uid, $poster_ip, $poster_name, $subject, $dohtml, $dosmiley, $doxcode, $doimage, $dobr, $icon, $attachsig, $attachment, $approved, $post_karma, $require_reply)";

            if (!$result = $this->db->{$queryFunc}($sql)) {
                $post->setErrors("Insert post error:" . $sql);
                return false;
            }
            if ($post_id == 0) $post_id = $this->db->getInsertId();

            $sql = sprintf("INSERT INTO %s (post_id, post_text) VALUES (%u, %s)", $this->db->prefix("bb_posts_text"), $post_id, $post_text);
            if (!$result = $this->db->{$queryFunc}($sql)) {
                $sql = sprintf("DELETE FROM %s WHERE post_id = %u", $this->db->prefix("bb_posts"), $post_id);
                $this->db->query($sql);
                return false;
            }
            if ($approved>0) {
                if ($pid == 0) {
                    $sql = sprintf("UPDATE %s SET topic_last_post_id = %u, topic_time = %u WHERE topic_id = %u", $this->db->prefix("bb_topics"), $post_id, $post_time, $topic_id);
                    if (!$result = $this->db->{$queryFunc}($sql)) {
                    }
                } else {
                    $sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET topic_replies=topic_replies+1, topic_last_post_id = " . $post_id . " WHERE topic_id =" . $topic_id . "";
                    if (!$result = $this->db->{$queryFunc}($sql)) {
                    }
                }
                if (is_object($xoopsUser)) {
			        $member_handler = &xoops_gethandler('member');
			        $xoopsUser->setVar('posts',$xoopsUser->getVar('posts') + 1);
			        $res=$member_handler->insertUser($xoopsUser, true);
                }
	            if ($post->isTopic()) $increment = " forum_topics = forum_topics+1, ";
	            else $increment = '';
	            $sql = sprintf("UPDATE %s SET forum_posts = forum_posts+1, " . $increment . " forum_last_post_id = %u WHERE forum_id = %u", $this->db->prefix("bb_forums"), $post_id, $forum_id);
	            $result = $this->db->{$queryFunc}($sql);
	            if (!$result) {
	            } ;
            }
            $post->setVar('post_id', $post_id);
        } else {
            if ($post->isTopic()) {
                $sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET topic_title = $subject, approved = $approved WHERE topic_id = " . $post->getVar('topic_id');
                if (!$result = $this->db->{$queryFunc}($sql)) {
                    $post->setErrors("update topic error:" . $sql);
                    return false;
                }
            }
            if(isset($pid)) $pid_update = isset($pid)?"pid=".$pid:"1=1";
            $sql = "UPDATE " . $this->db->prefix("bb_posts") . " SET topic_id=$topic_id, $pid_update, subject = $subject, dohtml= $dohtml, dosmiley= $dosmiley, doxcode = $doxcode, doimage = $doimage, dobr = $dobr, icon= $icon, attachsig= $attachsig, attachment= $attachment, approved = $approved, post_karma = $post_karma, require_reply = $require_reply WHERE post_id = " . $post->getVar('post_id');
            if (!$result = $this->db->{$queryFunc}($sql)) {
                $post->setErrors("update post error:" . $sql);
                return false;
            }
            $post_id = $post->getVar('post_id');
            $sql = "UPDATE " . $this->db->prefix("bb_posts_text") . " SET post_text = $post_text, post_edit = $post_edit WHERE post_id = " . $post->getVar('post_id');
            $result = $this->db->{$queryFunc}($sql);
            if (!$result) {
                $post->setErrors("update post text error:" . $sql);
                return false;
            }
        }
        return $post->getVar('post_id');
    }

    function delete(&$post, $isDeleteOne = true, $force = false)
    {
        if(!is_object($post) || $post->getVar('post_id')==0) return false;
        if ($isDeleteOne) {
	        if($post->isTopic()){
		        $criteria = new CriteriaCompo(new Criteria("topic_id", $post->getVar('topic_id')));
		        $criteria->add(new Criteria('approved', 1));
		        $criteria->add(new Criteria('pid', 0, ">"));
		    	if($this->getPostCount($criteria)>0){
			    	return false;
		    	}
	        }
	        return $this->_delete($post, $force);
        }
        else {
	        include_once(XOOPS_ROOT_PATH . "/class/xoopstree.php");
	        $mytree = new XoopsTree($this->db->prefix("bb_posts"), "post_id", "pid");
            $arr = $mytree->getAllChild($post->getVar('post_id'));
            for ($i = 0; $i < count($arr); $i++) {
                $childpost =& $this->create(false);
                $childpost->assignVars($arr[$i]);
                $this->_delete($childpost, $force);
                unset($childpost);
            }
            $this->_delete($post, $force);
        }

        return true;
    }

    function _delete(&$post, $force = false)
    {
	    global $xoopsModule, $xoopsConfig;
	    static $forum_lastpost = array();
	    
        if(!is_object($post) || $post->getVar('post_id')==0) return false;

        $postcount_toupdate = ($post->getVar("approved")>0);
        
        /* Set active post as deleted */
        if($post->getVar("approved")>0 && empty($force)) {
        	$sql = "UPDATE " . $this->db->prefix("bb_posts") . " SET approved = -1 WHERE post_id = ".$post->getVar("post_id");
	        if (!$result = $this->db->queryF($sql)) {
	        }
        /* delete pending post directly */
        }else{
	        $sql = sprintf("DELETE FROM %s WHERE post_id = %u", $this->db->prefix("bb_posts"), $post->getVar('post_id'));
	        if (!$result = $this->db->queryF($sql)) {
		        $post->setErrors("delte post error: ".$sql);
	            return false;
	        }
	        $post->deleteAttachment();
	
	        $sql = sprintf("DELETE FROM %s WHERE post_id = %u", $this->db->prefix("bb_posts_text"), $post->getVar('post_id'));
	        if (!$result = $this->db->queryF($sql)) {
	            $post->setErrors("Could not remove post text: " . $sql);
	            return false;
	        }
        }

        if ($post->isTopic()) {
			$topic_handler =& xoops_getmodulehandler('topic', 'newbb');			
			$topic_obj =& $topic_handler->get($post->getVar('topic_id'));
        	if(is_object($topic_obj) && $topic_obj->getVar("approved")>0 && empty($force)){
        		$topiccount_toupdate = 1;
        		$topic_obj->setVar("approved", -1);
        		$topic_handler->insert($topic_obj);
        		xoops_notification_deletebyitem ($xoopsModule->getVar('mid'), 'thread', $post->getVar('topic_id'));
        	}else{
	        	if(is_object($topic_obj)):
	        	if($topic_obj->getVar("approved")>0){
        			xoops_notification_deletebyitem ($xoopsModule->getVar('mid'), 'thread', $post->getVar('topic_id'));
    			}
	        
				$poll_id = $topic_obj->getVar("poll_id");
				if($poll_id>0){
					if (is_dir(XOOPS_ROOT_PATH."/modules/xoopspoll/")){
						include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspoll.php";
						include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspolloption.php";
						include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspolllog.php";
						include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspollrenderer.php";
					
						$poll = new XoopsPoll($poll_id);
						if ( $poll->delete() != false ) {
							XoopsPollOption::deleteByPollId($poll->getVar("poll_id"));
							XoopsPollLog::deleteByPollId($poll->getVar("poll_id"));
							xoops_comment_delete($xoopsModule->getVar('mid'), $poll->getVar('poll_id'));
						}
					}
				}
				endif;
				
	        	$sql = sprintf("DELETE FROM %s WHERE topic_id = %u", $this->db->prefix("bb_topics"), $post->getVar('topic_id'));
	            if (!$result = $this->db->queryF($sql)) {
	                newbb_message("Could not delete topic: ". $sql);
	            }
		        $sql = sprintf("DELETE FROM %s WHERE topic_id = %u", $this->db->prefix("bb_votedata"), $post->getVar('topic_id'));
		        if (!$result = $this->db->queryF($sql)) {
	                newbb_message("Could not delete votedata: " .$sql);
		        }
	        }
        }else{
            $sql = "UPDATE ".$this->db->prefix("bb_topics")." t
            				LEFT JOIN ".$this->db->prefix("bb_posts")." p ON p.topic_id = t.topic_id
            				SET t.topic_last_post_id = p.post_id
            				WHERE t.topic_last_post_id = ".$post->getVar('post_id')."
            						AND p.post_id = (SELECT MAX(post_id) FROM ".$this->db->prefix("bb_posts")." WHERE topic_id=t.topic_id)";
            if (!$result = $this->db->queryF($sql)) {
            }
        }

        $decrement = array();
        if( $postcount_toupdate>0 ){
	        $member_handler = &xoops_gethandler('member');
	        $poster = &$member_handler->getUser($post->getVar('uid'));
	        if (is_object($poster)) {
		        $poster->setVar('posts',$poster->getVar('posts') - 1);
		        $res=$member_handler->insertUser($poster, true);
	            unset($poster);
	        }
	
	        $sql = "UPDATE " . $this->db->prefix("bb_posts") . " SET pid = " . $post->getVar('pid') . " WHERE pid=" . $post->getVar('post_id');
	        if (!$result = $this->db->queryF($sql)) {
	            newbb_message("Could not update post: " . $sql);
	        }
	        $decrement[] = "forum_posts = forum_posts-1";
        }
        /* Synchronization performed in function sync() */
        /*
        if ($post->isTopic() && $topiccount_toupdate>0) {
	        $decrement[]= "forum_topics = forum_topics-1";
        }
        if(!isset($forum_lastpost[$post->getVar('forum_id')])){
        	$sql = 'SELECT forum_last_post_id FROM ' . $this->db->prefix('bb_forums') . ' WHERE forum_id ='.$post->getVar('forum_id');
        	if ($result = $this->db->query($sql)) {
	        	$row = $this->db->fetchArray($result);
	        	$forum_lastpost[$post->getVar('forum_id')] = $row["forum_last_post_id"];
        	}else{
	        	$forum_lastpost[$post->getVar('forum_id')] = -1;
        	}
    	}
        if($forum_lastpost[$post->getVar('forum_id')] == $post->getVar('post_id')){
        	$sql = 'SELECT MAX(post_id) AS last_post FROM ' . $this->db->prefix('bb_posts') . ' AS p LEFT JOIN  ' . $this->db->prefix('bb_topics') . ' AS t ON p.topic_id=t.topic_id WHERE p.approved=1 AND t.approved=1';
        	if ($result = $this->db->query($sql)) {
	        	$row = $this->db->fetchArray($result);
				$decrement[]= "forum_last_post_id = ".$row["last_post"];
        	}
        }
        if(count($decrement)){		        
	        $sql = sprintf("UPDATE %s SET " . implode(", ", $decrement) . " WHERE forum_id = %u", $this->db->prefix("bb_forums"), $post->getVar('forum_id'));
	        $result = $this->db->queryF($sql);
        }
        */

        return true;
    }

    /*
    function emptyTopic(&$post)
    {
	    global $xoopsModule, $xoopsConfig;
        if(!is_object($post) || !$post->isTopic()) return false;

        $sql = sprintf("UPDATE %s SET post_text='[--DELETED--]', post_edit='' WHERE post_id = %u", $this->db->prefix("bb_posts_text"), $post->getVar('post_id'));
        if (!$result = $this->db->queryF($sql)) {
            newbb_message("Could not remove post text: " . $sql);
            return false;
        }

        $post->deleteAttachment();
        $sql = sprintf("UPDATE %s SET uid=0, attachment='', attachsig=0 WHERE post_id = %u", $this->db->prefix("bb_posts"), $post->getVar('post_id'));
        if (!$result = $this->db->queryF($sql)) {
            newbb_message("Could not remove post : " . $sql);
            return false;
        }

        $sql = sprintf("UPDATE %s SET topic_poster=0, topic_haspoll=0 WHERE topic_id = %u", $this->db->prefix("bb_topics"), $post->getVar('topic_id'));
        if (!$result = $this->db->queryF($sql)) {
            newbb_message("Could not update topic: " . $sql);
            return false;
        }

        if ($post->getVar('uid')) {
            $sql = sprintf("UPDATE %s SET posts=posts-1 WHERE uid = %u", $this->db->prefix("users"), $post->getVar('uid'));
            if (!$result = $this->db->queryF($sql)) {
                newbb_message("Could not update user posts: ".$sql);
            }
        }

		$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
		$poll_id =& $topic_handler->get($post->getVar('topic_id'), "poll_id");
		if($poll_id>0){
			if (is_dir(XOOPS_ROOT_PATH."/modules/xoopspoll/")){
				include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspoll.php";
				include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspolloption.php";
				include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspolllog.php";
				include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspollrenderer.php";
				$poll = new XoopsPoll($poll_id);
				if ( $poll->delete() != false ) {
					XoopsPollOption::deleteByPollId($poll->getVar("poll_id"));
					XoopsPollLog::deleteByPollId($poll->getVar("poll_id"));
					xoops_comment_delete($xoopsModule->getVar('mid'), $poll->getVar('poll_id'));
				}
			}
		}
        $sql = sprintf("DELETE FROM %s WHERE topic_id = %u", $this->db->prefix("bb_votedata"), $post->getVar('topic_id'));
        if (!$result = $this->db->queryF($sql)) {
            newbb_message("Could not delete votedata: ".$sql);
        }

        return true;
    }
    */

    function getPostCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) AS count FROM ' . $this->db->prefix('bb_posts');
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
        }
        $result = $this->db->query($sql);
        if (!$result) {
            newbb_message("NewbbPostHandler::getPostCount error:" . $sql);
            return false;
        }
        $myrow = $this->db->fetchArray($result);
        return $myrow["count"];
    }

    function &getPostsByLimit($limit=1, $start=0, $criteria = null)
    {
        $sql = 'SELECT p.*, t.* '.
        		' FROM ' . $this->db->prefix('bb_posts') . ' AS p'.
        		' LEFT JOIN ' . $this->db->prefix('bb_posts_text') . " AS t ON t.post_id = p.post_id";

        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " ".$criteria->renderWhere();
            if ($criteria->getSort() != "") {
                $sql .= " ORDER BY ".$criteria->getSort()." ".$criteria->getOrder();
            }
        }
        $result = $this->db->query($sql, intval($limit), intval($start));
        if (!$result) {
            newbb_message( "NewbbPostHandler::getPostsByLimit error:" . $sql);
            return null;
        }
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $post = &$this->create(false);
            $post->assignVars($myrow);
            $ret[$myrow['post_id']] = $post;
            unset($post);
        }
        return $ret;
    }
}

?>