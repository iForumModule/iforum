<?php
// $Id: post.php,v 1.1.1.111 2004/11/20 15:18:18 phppp Exp $
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
class Post extends XoopsObject {
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
    // prepareVars for db store
    // by phppp
    // not fully tested yet
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
        if (empty($attachment)) $this->attachment_array = false;
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
            echo _MD_ERROR_UPATEATTACHMENT . "<br />" . $sql;
            return false;
        }
        return true;
    }

    function deleteAttachment($attach_array = '')
    {
        global $xoopsModuleConfig;

        $attach_old = $this->getAttachment();
        if (!is_array($attach_old) || count($attach_old) < 1) return true;
        $this->attachment_array = array();

        if (!isset($attach_array)) $attach_array = array_keys($attach_old); // to delete all!
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

    function setAttachment($name_saved = '', $name_display = '', $mimetype = '', $num_download = '')
    {
        $this->getAttachment();
        if ($name_saved) {
            $key = strval(time());
            $this->attachment_array[$key] = array('name_saved' => $name_saved,
                'name_display' => isset($name_display)?$name_display:$name_saved,
                'mimetype' => $mimetype,
                'num_download' => isset($num_download)?intval($num_download):0
                );
        }
        if (is_array($this->attachment_array))
            $attachment_save = base64_encode(serialize($this->attachment_array));
        else $attachment_save = '';
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
            foreach($attachments as $key => $att) {
                $file_extension = ltrim(strrchr($att['name_saved'], '.'), '.');
                $filetype = $file_extension;
                if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/images/filetypes/' . $filetype . '.gif'))
                    $icon_filetype = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/images/filetypes/' . $filetype . '.gif';
                else
                    $icon_filetype = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/images/filetypes/unknown.gif';
                $post_attachment .= '<br /><br />';
                $file_size = filesize(XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['dir_attachments'] . '/' . $att['name_saved']);
                $file_size = number_format ($file_size / 1024, 2)." KB";
                if ($xoopsModuleConfig['media_allowed'] && in_array($file_extension, $image_extensions)) {
					$imginfo = @getimagesize(XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['dir_attachments'] . '/' . $att['name_saved']);
					if ( $imginfo )$file_size .= "; ".$imginfo[0]."X".$imginfo[1].' px';
                    $post_attachment .= '<br /><strong>' . _MD_THIS_FILE_WAS_ATTACHED_TO_THIS_POST . '</strong>&nbsp;<img src="' . $icon_filetype . '" alt="' . $filetype . '" /><strong>&nbsp; ' . $att['name_display'] . '</strong> <small>('.$file_size.')</small>';
                    $post_attachment .= '<br /><hr size="1" noshade="noshade" />';
                    $post_attachment .= '<br />' . newbb_attachmentImage($att['name_saved'], $asSource);
                } else {
                    $post_attachment .= '<br /><table width="80%" bordercolor="#000000" border="1" cellspacing="1">';
                    $post_attachment .= '<tr><td colspan="3" class="head"><strong>' . _MD_ATTACHMENT . '</strong></td></tr>';
                    $post_attachment .= '<tr class="even"><td width="50%"><strong>' . _MD_THIS_FILE_WAS_ATTACHED_TO_THIS_POST . '</strong></td><td><strong>' . _MD_FILESIZE . '</strong></td><td><strong>' . _MD_HITS . '</strong></td></tr>';
                    $post_attachment .= '<tr class="odd"><td><a href="' . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/dl_attachment.php?attachid=' . $key . '&amp;post_id=' . $this->getVar('post_id') . '"> <img src="' . $icon_filetype . '" alt="' . $filetype . '" /> ' . $att['name_display'] . '</a></td>';
                    $post_attachment .= '<td> ' . $file_size . '</td>';
                    $post_attachment .= '<td> ' . $att['num_download'] . '</td>';
                    $post_attachment .= '</tr></table>';
                }
            }
        }
        return $post_attachment;
    }
    // attachment functions
    // ////////////////////////////////////////////////////////////////////////////////////
    function setPostEdit($poster_name = '')
    {
        global $xoopsConfig, $xoopsModuleConfig, $xoopsUser;

        if( (time()-$this->getVar('post_time'))<$xoopsModuleConfig['recordedit_timelimit'] || $this->getVar('approved')==0 ) return true;
        $edit_user = (is_object($xoopsUser))? $xoopsUser->uname():($poster_name?$poster_name:$xoopsConfig['anonymous']);
        $post_edit = array();
        $post_edit['edit_user'] = $edit_user;
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
        global $myts;

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

        if (newbb_isAdmin($this->getVar('forum_id')) && $xoopsModuleConfig['allow_moderator_html']) $post['subject'] = $myts->undoHtmlSpecialChars($this->getVar('subject'));
        else $post['subject'] = newbb_htmlSpecialChars($this->vars['subject']['value']);

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
                $user_ip = (isset($_SERVER['HTTP_X_FORWARDED_FOR']))?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'];
                $user_ip = ip2long($user_ip);
            }
            $user_ok = ($user_ip == $this->getVar('poster_ip'))?true:false;
        }
        return $user_ok;
    }

    function showPost($isadmin, $forumdata)
    {
        global $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $xoopsUser, $myts, $xoopsTpl, $forumUrl, $forumImage, $viewtopic_users, $viewtopic_forum, $online, $user_karma, $viewmode, $order, $start, $total_posts;
        static $post_NO = 0;
        static $user_ip;

        $post_NO ++;
        if (strtolower($order) == "desc") $post_no = $total_posts - ($start + $post_NO) + 1;
        else $post_no = $start + $post_NO;

        $online_png = newbb_displayImage($forumImage['online'], _MD_ONLINE);
        $offline_png = newbb_displayImage($forumImage['offline'],_MD_OFFLINE);

        $uid = is_object($xoopsUser)? $xoopsUser->getVar('uid'):0;

        if ($isadmin or $this->checkIdentity()) {
            $post_text = $this->getVar('post_text');
            $post_attachment = $this->displayAttachment();
        } elseif ($xoopsModuleConfig['enable_karma'] && $this->getVar('post_karma') > $user_karma) {
            $post_text = "<div class='karma'>" . sprintf(_MD_KARMA_REQUIREMENT, $user_karma, $this->getVar('post_karma')) . "</div>";
            $post_attachment = '';
        } elseif ($xoopsModuleConfig['allow_require_reply'] && $this->getVar('require_reply') && (!$uid || !isset($viewtopic_users[$uid]))) {
            $post_text = "<div class='karma'>" . _MD_REPLY_REQUIREMENT . "</div>";
            $post_attachment = '';
        } else {
            $post_text = $this->getVar('post_text');
            $post_attachment = $this->displayAttachment();
        }
        $eachposter = (($this->getVar('uid') > 0) && isset($viewtopic_users[$this->getVar('uid')]))? $viewtopic_users[$this->getVar('uid')]['user']:false;
        if (is_object($eachposter) && $eachposter->isActive()) {
            if ($viewtopic_users[$this->getVar('uid')]['rank']['image'] != "") {
                $poster_rank['image'] = "<img src='" . XOOPS_UPLOAD_URL . "/" . $viewtopic_users[$this->getVar('uid')]['rank']['image'] . "' alt='' />";
            }
          	$poster_rank['title'] = $viewtopic_users[$this->getVar('uid')]['rank']['title'];
            if ($xoopsModuleConfig['wol_enabled']) {
                $poster_status = isset($online[$this->getVar('uid')]) ? $online_png : $offline_png;
            } else {
                $poster_status = '';
            }

            $profile_image = "<a href='" . XOOPS_URL . "/userinfo.php?uid=" . $eachposter->getVar('uid') . "'><img src=\"" . XOOPS_URL . "/images/icons/profile.gif\" alt='" . _PROFILE . "' /></a>";

            $RPG = $eachposter->getVar('posts');
            if ($xoopsModuleConfig['levels_enabled']) {
                $level = $viewtopic_users[$this->getVar('uid')]['level'];
                $RPG_HP = "<br />" . _MD_LEVEL . " " . $level['LEVEL'] . "<br />" . _MD_HP . " " . $level['HP'] . " / " . $level['HP_MAX'] . "<br /><table width='99px' border='0' cellspacing='0' cellpadding='0' bordercolor='#000000'><tr><td width='3' height='13'><img height='13' src='" . $forumUrl['images_set'] . "/rpg/img_left.gif' width='3' alt='' /></td><td width='100%' background='" . $forumUrl['images_set'] . "/rpg/img_backing.gif' height='13'><img src='" . $forumUrl['images_set'] . "/rpg/orange.gif' width='" . $level['HP_WIDTH'] . "%' height='12' alt='' /></td><td width='3' height='13'><img height='13' src='" . $forumUrl['images_set'] . "/rpg/img_right.gif' width='3' alt='' /></td></tr></table>";
                $RPG_MP = _MD_MP . " " . $level['MP'] . " / " . $level['MP_MAX'] . "<br /><table width='99px' border='0' cellspacing='0' cellpadding='0' bordercolor='#000000'><tr><td width='3' height='13'><img height='13' src='" . $forumUrl['images_set'] . "/rpg/img_left.gif' width='3' alt='' /></td><td width='100%' background='" . $forumUrl['images_set'] . "/rpg/img_backing.gif' height='13'><img src='" . $forumUrl['images_set'] . "/rpg/green.gif' width='" . $level['MP_WIDTH'] . "%' height='12'></td><td width='3' height='13'><img height='13' src='" . $forumUrl['images_set'] . "/rpg/img_right.gif' width='3' alt='' /></td></tr></table>";
                $RPG_EXP = _MD_EXP . " " . $level['EXP'] . "<br /><table width='99px' border='0' cellspacing='0' cellpadding='0' bordercolor='#000000'><tr><td width='3' height='13'><img height='13' src='" . $forumUrl['images_set'] . "/rpg/img_left.gif' width='3' alt='' /></td><td width='100%' background='" . $forumUrl['images_set'] . "/rpg/img_backing.gif' height='13'><img src='" . $forumUrl['images_set'] . "/rpg/blue.gif' width='" . $level['EXP'] . "%' height='12' alt='' /></td><td width='3' height='13'><img height='13' src='" . $forumUrl['images_set'] . "/rpg/img_right.gif' width='3' alt='' /></td></tr></table>";
            } else {
                $RPG_HP = "";
                $RPG_MP = "";
                $RPG_EXP = "";
            }

            if ($xoopsModuleConfig['userbar_enabled']) {
                $profile_png = newbb_displayImage($forumImage['personal'], _PROFILE);
                $pm_png = newbb_displayImage($forumImage['pm'], sprintf(_SENDPMTO, $eachposter->uname()));
                $icq_png = newbb_displayImage($forumImage['icq'], _MD_ICQ);
                $email_png = newbb_displayImage($forumImage['email'], sprintf(_SENDEMAILTO, $eachposter->uname('E')));
                $aim_png = newbb_displayImage($forumImage['aim'], _MD_AIM);
                $home_png = newbb_displayImage($forumImage['home'], _VISITWEBSITE);
                $yim_png = newbb_displayImage($forumImage['yahoo'], _MD_YIM);
                $msnm_png = newbb_displayImage($forumImage['msnm'], _MD_MSNM);

                $userbar = (is_object($xoopsUser))? "<tr><td class='head'><small><a class='newbb_link' href='" . XOOPS_URL . "/userinfo.php?uid=" . $eachposter->getVar('uid') . "' />" . $profile_png . "&nbsp;" . _PROFILE . "</a></small></td></tr> ":" ";
                $userbar .= (is_object($xoopsUser))? "<tr><td class='head'><small><a class='newbb_link' href=\"javascript:openWithSelfMain('" . XOOPS_URL . "/pmlite.php?send2=1&amp;to_userid=" . $eachposter->getVar('uid') . "', 'pmlite', 450, 380);\">" . $pm_png . "&nbsp;" . sprintf(_SENDPMTO, $eachposter->uname()) . "</a></small></td></tr> ":" ";
                $userbar .= ($isadmin || (is_object($xoopsUser) && $eachposter->getVar('user_viewemail')))? "<tr><td class='head' ><small><a class='newbb_link' href='mailto:" . $eachposter->getVar('email') . "'>" . $email_png . "&nbsp;" . sprintf(_SENDEMAILTO, $eachposter->uname('E')) . "</a></small></td></tr> ":" ";
                $userbar .= ($eachposter->getVar('url'))? "<tr><td class='head' ><small><a class='newbb_link' href='" . $eachposter->getVar('url') . "' target='_blank'>" . $home_png . "&nbsp;" . _VISITWEBSITE . "</a></small></td></tr> ":" ";
                $userbar .= (is_object($xoopsUser) && $eachposter->getVar('user_icq'))? "<tr><td class='head' ><small><a class='newbb_link' href='http://wwp.icq.com/scripts/search.dll?to=" . $eachposter->getVar('user_icq') . "' target='_blank'/>" . $icq_png . "&nbsp;" . _MD_ICQ . "</a></small></td></tr> ":" ";
                $userbar .= (is_object($xoopsUser) && $eachposter->getVar('user_aim'))? "<tr><td class='head' ><small><a class='newbb_link' href='aim:goim?screenname=" . $eachposter->getVar('user_aim') . "&message=Hi+" . $eachposter->getVar('user_aim') . "+Are+you+there?' target='_blank'>" . $aim_png . "&nbsp;" . _MD_AIM . "</a></small></td></tr> ":" ";
                $userbar .= (is_object($xoopsUser) && $eachposter->getVar('user_yim'))? "<tr><td class='head' ><small><a class='newbb_link' href='http://edit.yahoo.com/config/send_webmesg?.target=" . $eachposter->getVar('user_yim') . "&.src=pg' target='_blank'>" . $yim_png . "&nbsp;" . _MD_YIM . "</a></small></td></tr> ":" ";
                $userbar .= (is_object($xoopsUser) && $eachposter->getVar('user_msnm'))? "<tr><td class='head' ><small><a class='newbb_link' href='http://members.msn.com?mem=" . $eachposter->getVar('user_msnm') . "' target='_blank'>" . $msnm_png . "&nbsp;" . _MD_MSNM . "</a></small></td></tr> ":" ";
            }else{
	            $userbar = '';
            }

			if($xoopsModuleConfig['groupbar_enabled'] && isset($viewtopic_users[$this->getVar('uid')]['groups'])){
                $user_groups = implode("<br />", $viewtopic_users[$this->getVar('uid')]['groups']);
        	}else $user_groups = '';

            if ($xoopsModuleConfig['show_realname'] && $eachposter->getVar('name')) {
                $name = $eachposter->getVar('name');
            } else {
                $name = $eachposter->getVar('uname');
            }

            if ($forumdata['allow_sig'] && ($this->getVar('attachsig') || $eachposter->attachsig())) {
                $poster_sig = $myts->displayTarea($eachposter->getVar("user_sig", "N"), 0, 1, 1);
            }else $poster_sig = '';

            $posterarr = array('poster_uid' => $eachposter->getVar('uid'),
                'poster_name' => $name,
                'poster_uname' => '<a href="' . XOOPS_URL . '/userinfo.php?uid=' . $eachposter->getVar('uid') . '">' . $name . '</a>',
                'poster_avatar' => $eachposter->getVar('user_avatar'),
                'poster_from' => $eachposter->getVar('user_from'),
                'poster_regdate' => formatTimestamp($eachposter->getVar('user_regdate'), 's'),
                'poster_postnum' => $RPG . $RPG_HP . $RPG_MP . $RPG_EXP,
                'poster_sendpmtext' => sprintf(_SENDPMTO, $eachposter->getVar('uname')),
                'poster_rank_title' => $poster_rank['title'],
                'poster_rank_image' => $poster_rank['image'],
                'poster_status' => $poster_status,
                'poster_groups' => $user_groups, // To avoid extra queries
                'poster_userbar' => $userbar,
                'poster_sig' => $poster_sig
          	);


        } else {
            $posterarr = array('poster_uid' => 0,
                'poster_name' => $this->getVar('poster_name')?$this->getVar('poster_name'):$xoopsConfig['anonymous'],
                'poster_uname' => $this->getVar('poster_name')?$this->getVar('poster_name'):$xoopsConfig['anonymous'],
                'poster_avatar' => '',
                'poster_from' => '',
                'poster_regdate' => '',
                'poster_postnum' => '',
                'poster_sendpmtext' => '',
                'poster_rank_title' => '',
                'poster_rank_image' => '',
                'poster_status' => '',
                'poster_groups' => '',
                'poster_userbar' => '',
                'poster_sig' => ''
          	);
        }

        $posticon = $this->getVar('icon');
        if (isset($posticon) && $posticon != '')
            $post_image = '<a name="' . $this->getVar('post_id') . '"><img src="' . XOOPS_URL . '/images/subject/' . $this->getVar('icon') . '" alt="" /></a>';
        else
            $post_image = '<a name="' . $this->getVar('post_id') . '"><img src="' . XOOPS_URL . '/images/icons/posticon.gif" alt="" /></a>';

        if ($isadmin && $xoopsModuleConfig['show_ip']) $poster_ip = long2ip($this->getVar('poster_ip'));
        else $poster_ip = '';

        if (isset($viewtopic_users[$this->getVar('uid')]['is_forumadmin']) && $xoopsModuleConfig['allow_moderator_html']) $post_title = $myts->undoHtmlSpecialChars($this->getVar('subject'));
        else $post_title = $this->getVar('subject');

        $thread_buttons = array();
        $topic_handler = &xoops_getmodulehandler('topic', 'newbb');

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
            } else {
                $thread_buttons['edit']['image'] = "";
                $thread_buttons['edit']['link'] = "";
                $thread_buttons['edit']['name'] = "";
            }
        }

        if ($topic_handler->getPermission($viewtopic_forum, $forumdata['topic_status'], "delete")) {
            $delete_ok = false;
            if ($isadmin) {
                $delete_ok = true;
            } elseif ($this->checkIdentity() && $this->checkTimelimit('delete_timelimit')) {
                $delete_ok = true;
            }

            if ($delete_ok) {
                $thread_buttons['delete']['image'] = newbb_displayImage($forumImage['p_delete'], _DELETE);
                $thread_buttons['delete']['link'] = "delete.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order&amp;act=1";
                $thread_buttons['delete']['name'] = _DELETE;
            } else {
                $thread_buttons['delete']['image'] = "";
                $thread_buttons['delete']['link'] = "";
                $thread_buttons['delete']['name'] = "";
            }
            if ($isadmin) {
                $thread_buttons['delete']['image'] = newbb_displayImage($forumImage['p_delete'], _DELETE);
                $thread_buttons['delete']['link'] = "delete.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order&amp;act=99";
                $thread_buttons['delete']['name'] = _DELETE;
            }
        }
        if ($topic_handler->getPermission($viewtopic_forum, $forumdata['topic_status'], "reply")) {
            $t_reply = newbb_displayImage($forumImage['t_reply'], _MD_POSTREPLY);

            $xoopsTpl->assign('forum_reply', "<a href=\"reply.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=" . $viewmode . "&amp;start=$start&amp;post_id=" . $forumdata['topic_last_post_id'] . "\">" . $t_reply . "</a>");

            $thread_buttons['reply']['image'] = newbb_displayImage($forumImage['p_reply'], _MD_REPLY);
            $thread_buttons['reply']['link'] = "reply.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order&amp;start=$start";
            $thread_buttons['reply']['name'] = _MD_REPLY;
            $thread_buttons['quote']['image'] = newbb_displayImage($forumImage['p_quote'], _MD_QUOTE);
            $thread_buttons['quote']['link'] = "reply.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order&amp;start=$start&amp;quotedac=1";
            $thread_buttons['quote']['name'] = _MD_QUOTE;
        }
        if (!$isadmin && $xoopsModuleConfig['reportmod_enabled']) {
            $thread_buttons['report']['image'] = newbb_displayImage($forumImage['p_report'], _MD_REPORT);
            $thread_buttons['report']['link'] = "report.php?forum=" . $forumdata['forum_id'] . "&amp;topic_id=" . $this->getVar('topic_id') . "&amp;viewmode=$viewmode&amp;order=$order";
            $thread_buttons['report']['name'] = _MD_REPORT;
        }
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

        $xoopsTpl->append('topic_posts', array_merge($posterarr, array('post_id' => $this->getVar('post_id'),
                    'post_parent_id' => $this->getVar('pid'),
                    'post_date' => formatTimestamp($this->getVar('post_time'), 'm'),
                    'post_image' => $post_image,
                    'post_title' => $post_title,
                    'post_text' => $post_text,
                    'post_attachment' => $post_attachment,
                    'post_edit' => $this->displayPostEdit(),
                    'post_no' => $post_no,
                    'poster_ip' => $poster_ip,
 		    'thread_action' => $thread_action,
                    'thread_buttons' => $thread_buttons
                    )));

        unset($thread_buttons);

        unset($eachposter);

        $xoopsTpl->assign('poster_ip', $poster_ip);
    }

}

class NewbbPostHandler extends XoopsObjectHandler {
    function &get($id)
    {
        $sql = 'SELECT p.*, t.*, tp.topic_status FROM ' . $this->db->prefix('bb_posts') . ' p LEFT JOIN ' . $this->db->prefix('bb_posts_text') . ' t ON p.post_id=t.post_id LEFT JOIN ' . $this->db->prefix('bb_topics') . ' tp ON tp.topic_id=p.topic_id WHERE p.post_id=' . $id;
        $array = $this->db->fetchArray($this->db->query($sql));
        $post = &$this->create(false);
        $post->assignVars($array);

        return $post;
    }

    function &getByLimit($topic_id, $limit, $approved = 1)
    {
        $sql = 'SELECT p.*, t.*, tp.topic_status FROM ' . $this->db->prefix('bb_posts') . ' p LEFT JOIN ' . $this->db->prefix('bb_posts_text') . ' t ON p.post_id=t.post_id LEFT JOIN ' . $this->db->prefix('bb_topics') . ' tp ON tp.topic_id=p.topic_id WHERE p.topic_id=' . $topic_id . ' AND p.approved ='. $approved .' ORDER BY p.post_time DESC';
        $result = $this->db->query($sql, $limit, 0);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $post = &$this->create(false);
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

    function approve($post_id)
    {
        $post = &$this->get($post_id);
        if (!is_object($post)) {
            echo "<br />post not exist:" . $post_id;
            return false;
        }
        $sql = "UPDATE " . $this->db->prefix("bb_posts") . " SET approved = 1 WHERE post_id = $post_id";
        if (!$result = $this->db->queryF($sql)) {
            echo "<br />approve post error:" . $sql;
            return false;
        }
        if ($post->isTopic()) {
            $sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET approved = 1 WHERE topic_id = " . $post->getVar('topic_id');
            if (!$result = $this->db->queryF($sql)) {
                echo "<br />approve post error:" . $sql;
                return false;
            }
            $sql = sprintf("UPDATE %s SET topic_last_post_id = %u, topic_time = %u WHERE topic_id = %u", $this->db->prefix("bb_topics"), $post_id, time(), $post->getVar('topic_id'));
            if (!$result = $this->db->queryF($sql)) {
            }
        } else {
            $sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET topic_replies=topic_replies+1, topic_last_post_id = " . $post_id . ", topic_time = " . time() . " WHERE topic_id =" . $post->getVar('topic_id') . "";
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
            									//$HTTP_SERVER_VARS['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'] = 'POST';
            unset($poster);
        }

        return true;
    }

    function unApprove($post_id)
    {
        $sql = "UPDATE " . $this->db->prefix("bb_posts") . " SET approved = 0 WHERE post_id = $post_id";
        if (!$result = $this->db->queryF($sql)) {
            echo "<br />unapprove post error:" . $sql;
            return false;
        }
        return true;
    }

    function insertnewsubject($topic_id, $subject)
    {
        $sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET topic_subject = " . intval($subject) . " WHERE topic_id = $topic_id";
        $result = $this->db->queryF($sql);
        if (!$result) {
            echo "<br />update topic subject error:" . $sql;
            return false;
        }
        return true;
    }

    function insert(&$post)
    {
        global $xoopsUser, $xoopsConfig;

        if (!$post->isDirty()) return true;
        if (!$post->cleanVars())return false;
        $post->prepareVars();
        foreach ($post->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        if ($post->isNew()) {
            $post_time = time();
            if (empty($topic_id)) {
                $topic_id = $this->db->genId($this->db->prefix("bb_topics") . "_topic_id_seq");
                $sql = "INSERT INTO " . $this->db->prefix("bb_topics") . "
                			(topic_id,  topic_title, topic_poster, forum_id,  topic_time, poster_name,  approved)
                        VALUES
                        	($topic_id, $subject,    $uid,        $forum_id, $post_time, $poster_name, $approved)";

                if (!$result = $this->db->query($sql)) {
                    $post->deleteAttachment();
                    echo "<br />Insert topic error:" . $sql;
                    return false;
                }
                if ($topic_id == 0) {
                    $topic_id = $this->db->getInsertId();
                }
                $post->setVar('topic_id', $topic_id);
            }
            $pid = isset($pid)?intval($pid):0;
            $post_id = $this->db->genId($this->db->prefix("bb_posts") . "_post_id_seq");

            $sql = "INSERT INTO " . $this->db->prefix("bb_posts") . "
            			( post_id,  pid,  topic_id,  forum_id,  post_time,  uid,  poster_ip,  poster_name,  subject,  dohtml,  dosmiley,  doxcode,  doimage,  dobr, icon,  attachsig,  attachment,  approved,  post_karma, require_reply)
					VALUES
                    	($post_id, $pid, $topic_id, $forum_id, $post_time, $uid, $poster_ip, $poster_name, $subject, $dohtml, $dosmiley, $doxcode, $doimage, $dobr, $icon, $attachsig, $attachment, $approved, $post_karma, $require_reply)";

            if (!$result = $this->db->query($sql)) {
                echo "<br />Insert post error:" . $sql;
                return false;
            }
            if ($post_id == 0) $post_id = $this->db->getInsertId();

            $sql = sprintf("INSERT INTO %s (post_id, post_text) VALUES (%u, %s)", $this->db->prefix("bb_posts_text"), $post_id, $post_text);
            if (!$result = $this->db->query($sql)) {
                $sql = sprintf("DELETE FROM %s WHERE post_id = %u", $this->db->prefix("bb_posts"), $post_id);
                $this->db->query($sql);
                return false;
            }
            if ($approved) {
                if ($pid == 0) {
                    $sql = sprintf("UPDATE %s SET topic_last_post_id = %u, topic_time = %u WHERE topic_id = %u", $this->db->prefix("bb_topics"), $post_id, $post_time, $topic_id);
                    if (!$result = $this->db->query($sql)) {
                    }
                } else {
                    $sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET topic_replies=topic_replies+1, topic_last_post_id = " . $post_id . ", topic_time = $post_time WHERE topic_id =" . $topic_id . "";
                    if (!$result = $this->db->query($sql)) {
                    }
                }
                if (is_object($xoopsUser)) {
                    $xoopsUser->incrementPost();
                }
	            if ($post->isTopic()) $increment = " forum_topics = forum_topics+1, ";
	            else $increment = '';
	            $sql = sprintf("UPDATE %s SET forum_posts = forum_posts+1, " . $increment . " forum_last_post_id = %u WHERE forum_id = %u", $this->db->prefix("bb_forums"), $post_id, $forum_id);
	            $result = $this->db->query($sql);
	            if (!$result) {
	            } ;
            }
            $post->setVar('post_id', $post_id);
        } else {
            if ($post->isTopic()) {
                $sql = "UPDATE " . $this->db->prefix("bb_topics") . " SET topic_title = $subject, approved = $approved WHERE topic_id = " . $post->getVar('topic_id');
                if (!$result = $this->db->query($sql)) {
                    echo "<br />update topic error:" . $sql;
                    return false;
                }
            }
            $sql = "UPDATE " . $this->db->prefix("bb_posts") . " SET subject = $subject, dohtml= $dohtml, dosmiley= $dosmiley, doxcode = $doxcode, doimage = $doimage, dobr = $dobr, icon= $icon, attachsig= $attachsig, attachment= $attachment, approved = $approved, post_karma = $post_karma, require_reply = $require_reply WHERE post_id = " . $post->getVar('post_id');
            $result = $this->db->query($sql);
            if (!$result = $this->db->query($sql)) {
                echo "<br />update post error:" . $sql;
                return false;
            }
            $post_id = $post->getVar('post_id');
            $sql = "UPDATE " . $this->db->prefix("bb_posts_text") . " SET post_text = $post_text, post_edit = $post_edit WHERE post_id = " . $post->getVar('post_id');
            $result = $this->db->query($sql);
            if (!$result) {
                echo "<br />update post text error:" . $sql;
                return false;
            }
        }
        return $post->getVar('post_id');
    }

    function delete(&$post, $isDeleteOne = true)
    {
        global $xoopsModule, $xoopsModuleConfig;
        $sql = "SELECT * FROM " . $this->db->prefix("bb_posts") . " WHERE post_id= " . $post->getVar('post_id');
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        if ($post->isTopic()) $isDeleteOne = false;
        include_once(XOOPS_ROOT_PATH . "/class/xoopstree.php");
        $mytree = new XoopsTree($this->db->prefix("bb_posts"), "post_id", "pid");
        $arr = $mytree->getAllChild($post->getVar('post_id'));
        if ($isDeleteOne) {
            $arr = $mytree->getFirstChild($post->getVar('post_id'));
            for ($i = 0; $i < count($arr); $i++) {
                $sql = "UPDATE " . $this->db->prefix("bb_posts") . " SET pid = " . $post->getVar('pid') . " WHERE post_id = " . $arr[$i]['post_id'] . " AND pid=" . $post->getVar('post_id');
                if (!$result = $this->db->query($sql)) {
                    echo "<br />Could not update post " . $arr[$i]['post_id'] . "<br />" . $sql . " ; original pid:" . $arr[$i]['pid'];
                }
            }
        } else {
            $arr = $mytree->getAllChild($post->getVar('post_id'));
            for ($i = 0; $i < count($arr); $i++) {
                $childpost = &$this->create(false);
                $childpost->setVar('post_id', $arr[$i]["post_id"]);
                $this->delete($childpost);
                unset($childpost);
            }
        }

        $post->deleteAttachment();

        $sql = sprintf("DELETE FROM %s WHERE post_id = %u", $this->db->prefix("bb_posts"), $post->getVar('post_id'));
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE post_id = %u", $this->db->prefix("bb_posts_text"), $post->getVar('post_id'));
        if (!$result = $this->db->query($sql)) {
            echo "Could not remove posts text for Post ID:" . $post->getVar('post_id') . ".<br />";
        }
        if ($post->getVar('uid')) {
            $sql = sprintf("UPDATE %s SET posts=posts-1 WHERE uid = %u", $this->db->prefix("users"), $post->getVar('uid'));
            if (!$result = $this->db->query($sql)) {
                echo "Could not update user posts.";
            }
        }

        if ($post->isTopic()) {
            $sql = sprintf("DELETE FROM %s WHERE topic_id = %u", $this->db->prefix("bb_topics"), $post->getVar('topic_id'));
            if (!$result = $this->db->query($sql)) {
                echo "Could not delete topic.";
            }
        }
    }
}

?>