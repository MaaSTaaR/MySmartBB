<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartGroupsMOD');

class MySmartGroupsMOD extends _func
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['add'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_addMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_addStart();
				}
			}
			elseif ($MySmartBB->_GET['control'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_controlMain();
				}
			}
			elseif ($MySmartBB->_GET['edit'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_editMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_editStart();
				}
			}
			elseif ($MySmartBB->_GET['del'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_delMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_delStart();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _addMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('group_add');
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['group_order']) 
			or empty($MySmartBB->_POST['style'])
			or empty($MySmartBB->_POST['usertitle']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		// Enable HTML and (only) HTML
		$MySmartBB->_POST['style'] = $MySmartBB->func->cleanVariable( $MySmartBB->_POST['style'], 'unhtml' );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 					= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['username_style'] 			= 	$MySmartBB->_POST['style'];
		$MySmartBB->rec->fields['user_title'] 				= 	$MySmartBB->_POST['usertitle'];
		$MySmartBB->rec->fields['forum_team'] 				= 	$MySmartBB->_POST['forum_team'];
		$MySmartBB->rec->fields['banned'] 					= 	$MySmartBB->_POST['banned'];
		$MySmartBB->rec->fields['view_section'] 			= 	$MySmartBB->_POST['view_section'];
		$MySmartBB->rec->fields['download_attach'] 			= 	$MySmartBB->_POST['download_attach'];
		$MySmartBB->rec->fields['download_attach_number'] 	= 	$MySmartBB->_POST['download_attach_number'];
		$MySmartBB->rec->fields['write_subject'] 			= 	$MySmartBB->_POST['write_subject'];
		$MySmartBB->rec->fields['write_reply'] 				= 	$MySmartBB->_POST['write_reply'];
		$MySmartBB->rec->fields['upload_attach'] 			= 	$MySmartBB->_POST['upload_attach'];
		$MySmartBB->rec->fields['upload_attach_num'] 		= 	$MySmartBB->_POST['upload_attach_num'];
		$MySmartBB->rec->fields['edit_own_subject'] 		= 	$MySmartBB->_POST['edit_own_subject'];
		$MySmartBB->rec->fields['edit_own_reply'] 			= 	$MySmartBB->_POST['edit_own_reply'];
		$MySmartBB->rec->fields['del_own_subject'] 			= 	$MySmartBB->_POST['del_own_subject'];
		$MySmartBB->rec->fields['del_own_reply']			= 	$MySmartBB->_POST['del_own_reply'];
		$MySmartBB->rec->fields['write_poll'] 				= 	$MySmartBB->_POST['write_poll'];
		//$MySmartBB->rec->fields['no_posts'] 		    	= 	$MySmartBB->_POST['no_posts'];
		$MySmartBB->rec->fields['vote_poll'] 				= 	$MySmartBB->_POST['vote_poll'];
		$MySmartBB->rec->fields['use_pm'] 					= 	$MySmartBB->_POST['use_pm'];
		$MySmartBB->rec->fields['send_pm'] 					= 	$MySmartBB->_POST['send_pm'];
		$MySmartBB->rec->fields['resive_pm'] 				= 	$MySmartBB->_POST['resive_pm'];
		$MySmartBB->rec->fields['max_pm'] 					= 	$MySmartBB->_POST['max_pm'];
		$MySmartBB->rec->fields['min_send_pm'] 				= 	$MySmartBB->_POST['min_send_pm'];
		$MySmartBB->rec->fields['sig_allow'] 				= 	$MySmartBB->_POST['sig_allow'];
		$MySmartBB->rec->fields['sig_len'] 					= 	$MySmartBB->_POST['sig_len'];
		$MySmartBB->rec->fields['group_mod'] 				= 	$MySmartBB->_POST['group_mod'];
		$MySmartBB->rec->fields['del_subject'] 				= 	$MySmartBB->_POST['del_subject'];
		$MySmartBB->rec->fields['del_reply'] 				= 	$MySmartBB->_POST['del_reply'];
		$MySmartBB->rec->fields['edit_subject'] 			= 	$MySmartBB->_POST['edit_subject'];
		$MySmartBB->rec->fields['edit_reply'] 				= 	$MySmartBB->_POST['edit_reply'];
		$MySmartBB->rec->fields['stick_subject'] 			= 	$MySmartBB->_POST['stick_subject'];
		$MySmartBB->rec->fields['unstick_subject'] 			= 	$MySmartBB->_POST['unstick_subject'];
		$MySmartBB->rec->fields['move_subject'] 			= 	$MySmartBB->_POST['move_subject'];
		$MySmartBB->rec->fields['close_subject'] 			= 	$MySmartBB->_POST['close_subject'];
		$MySmartBB->rec->fields['usercp_allow'] 			= 	$MySmartBB->_POST['usercp_allow'];
		$MySmartBB->rec->fields['admincp_allow'] 			= 	$MySmartBB->_POST['admincp_allow'];
		$MySmartBB->rec->fields['search_allow'] 			= 	$MySmartBB->_POST['search_allow'];
		$MySmartBB->rec->fields['memberlist_allow'] 		= 	$MySmartBB->_POST['memberlist_allow'];
		$MySmartBB->rec->fields['vice'] 					= 	$MySmartBB->_POST['vice'];
		$MySmartBB->rec->fields['show_hidden'] 				= 	$MySmartBB->_POST['show_hidden'];
		$MySmartBB->rec->fields['view_usernamestyle'] 		= 	$MySmartBB->_POST['view_usernamestyle'];
		$MySmartBB->rec->fields['usertitle_change'] 		= 	$MySmartBB->_POST['usertitle_change'];
		$MySmartBB->rec->fields['onlinepage_allow'] 		= 	$MySmartBB->_POST['onlinepage_allow'];
		$MySmartBB->rec->fields['allow_see_offstyles'] 		= 	$MySmartBB->_POST['allow_see_offstyles'];
		$MySmartBB->rec->fields['admincp_section'] 			= 	$MySmartBB->_POST['admincp_section'];
		$MySmartBB->rec->fields['admincp_option'] 			= 	$MySmartBB->_POST['admincp_option'];
		$MySmartBB->rec->fields['admincp_member'] 			= 	$MySmartBB->_POST['admincp_member'];
		$MySmartBB->rec->fields['admincp_membergroup'] 		= 	$MySmartBB->_POST['admincp_membergroup'];
		$MySmartBB->rec->fields['admincp_membertitle'] 		= 	$MySmartBB->_POST['admincp_membertitle'];
		$MySmartBB->rec->fields['admincp_admin'] 			= 	$MySmartBB->_POST['admincp_admin'];
		$MySmartBB->rec->fields['admincp_adminstep'] 		= 	$MySmartBB->_POST['admincp_adminstep'];
		$MySmartBB->rec->fields['admincp_subject'] 			= 	$MySmartBB->_POST['admincp_subject'];
		$MySmartBB->rec->fields['admincp_database'] 		= 	$MySmartBB->_POST['admincp_database'];
		$MySmartBB->rec->fields['admincp_fixup'] 			= 	$MySmartBB->_POST['admincp_fixup'];
		$MySmartBB->rec->fields['admincp_ads'] 				= 	$MySmartBB->_POST['admincp_ads'];
		$MySmartBB->rec->fields['admincp_template'] 		= 	$MySmartBB->_POST['admincp_template'];
		$MySmartBB->rec->fields['admincp_adminads'] 		= 	$MySmartBB->_POST['admincp_adminads'];
		$MySmartBB->rec->fields['admincp_attach'] 			= 	$MySmartBB->_POST['admincp_attach'];
		$MySmartBB->rec->fields['admincp_page'] 			= 	$MySmartBB->_POST['admincp_page'];
		$MySmartBB->rec->fields['admincp_block'] 			= 	$MySmartBB->_POST['admincp_block'];
		$MySmartBB->rec->fields['admincp_style'] 			= 	$MySmartBB->_POST['admincp_style'];
		$MySmartBB->rec->fields['admincp_toolbox'] 			= 	$MySmartBB->_POST['admincp_toolbox'];
		$MySmartBB->rec->fields['admincp_smile'] 			= 	$MySmartBB->_POST['admincp_smile'];
		$MySmartBB->rec->fields['admincp_icon'] 			= 	$MySmartBB->_POST['admincp_icon'];
		$MySmartBB->rec->fields['admincp_avater'] 			= 	$MySmartBB->_POST['admincp_avater'];
		$MySmartBB->rec->fields['group_order'] 				= 	$MySmartBB->_POST['group_order'];
		$MySmartBB->rec->fields['admincp_contactus'] 		= 	$MySmartBB->_POST['admincp_contactus'];
		
		$MySmartBB->rec->get_id = true;
		
		$insert = $MySmartBB->rec->insert();
		
		if ($insert)
		{
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
			$MySmartBB->rec->order = 'id ASC';
			
			$sections = $MySmartBB->rec->getList();
			
			// ... //
			
			while ( $row = $MySmartBB->rec->getInfo() )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
				
				$MySmartBB->rec->fields			=	array();
				
				$MySmartBB->rec->fields['section_id'] 			= 	$row['id'];
				$MySmartBB->rec->fields['group_id'] 			= 	$MySmartBB->group->id;
				$MySmartBB->rec->fields['view_section'] 		= 	$MySmartBB->_POST['view_section'];
				$MySmartBB->rec->fields['download_attach'] 		= 	$MySmartBB->_POST['download_attach'];
				$MySmartBB->rec->fields['write_subject'] 		= 	$MySmartBB->_POST['write_subject'];
				$MySmartBB->rec->fields['write_reply'] 			= 	$MySmartBB->_POST['write_reply'];
				$MySmartBB->rec->fields['upload_attach'] 		= 	$MySmartBB->_POST['upload_attach'];
				$MySmartBB->rec->fields['edit_own_subject'] 	= 	$MySmartBB->_POST['edit_own_subject'];
				$MySmartBB->rec->fields['edit_own_reply'] 		= 	$MySmartBB->_POST['edit_own_reply'];
				$MySmartBB->rec->fields['del_own_subject'] 		= 	$MySmartBB->_POST['del_own_subject'];
				$MySmartBB->rec->fields['del_own_reply'] 		= 	$MySmartBB->_POST['del_own_reply'];
				$MySmartBB->rec->fields['write_poll'] 			= 	$MySmartBB->_POST['write_poll'];
				//$MySmartBB->rec->fields['no_posts'] 			= 	$MySmartBB->_POST['no_posts'];
				$MySmartBB->rec->fields['vote_poll'] 			= 	$MySmartBB->_POST['vote_poll'];
				$MySmartBB->rec->fields['main_section'] 		= 	($row['parent'] == 0) ? 1 : 0;
				$MySmartBB->rec->fields['group_name'] 			= 	$MySmartBB->_POST['title'];
				
				$insert = $MySmartBB->rec->insert();
			}
			
			$cache = $MySmartBB->section->updateAllSectionsCache();
			
			if ($cache)
			{
				$MySmartBB->func->msg('تم اضافة المجموعه بنجاح !');
				$MySmartBB->func->move('admin.php?page=groups&amp;control=1&amp;main=1');
			}
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;

		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->order = "id ASC";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->rec->setInfoCallback( 'MySmartGroupsMOD::rowProcess' );
		
		// ... //
		
		$MySmartBB->template->display('groups_main');
	}
	
	public function rowProcess( $row )
	{
		global $MySmartBB;
		
		$style = $MySmartBB->func->cleanVariable( $row[ 'username_style' ], 'unhtml' );
		
		$row[ 'h_title' ] = str_replace( '[username]', $row[ 'title' ], $style );
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('group_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['group_order']) 
			or empty($MySmartBB->_POST['style'])
			or empty($MySmartBB->_POST['usertitle']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		// Enable HTML and (only) HTML
		$MySmartBB->_POST['style'] = $MySmartBB->func->CleanVariable($MySmartBB->_POST['style'],'unhtml');
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 					= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['username_style'] 			= 	$MySmartBB->_POST['style'];
		$MySmartBB->rec->fields['user_title'] 				= 	$MySmartBB->_POST['usertitle'];
		$MySmartBB->rec->fields['forum_team'] 				= 	$MySmartBB->_POST['forum_team'];
		$MySmartBB->rec->fields['banned'] 					= 	$MySmartBB->_POST['banned'];
		$MySmartBB->rec->fields['view_section'] 				= 	$MySmartBB->_POST['view_section'];
		$MySmartBB->rec->fields['download_attach'] 			= 	$MySmartBB->_POST['download_attach'];
		$MySmartBB->rec->fields['download_attach_number'] 	= 	$MySmartBB->_POST['download_attach_number'];
		$MySmartBB->rec->fields['write_subject'] 			= 	$MySmartBB->_POST['write_subject'];
		$MySmartBB->rec->fields['write_reply'] 				= 	$MySmartBB->_POST['write_reply'];
		$MySmartBB->rec->fields['upload_attach'] 			= 	$MySmartBB->_POST['upload_attach'];
		$MySmartBB->rec->fields['upload_attach_num'] 		= 	$MySmartBB->_POST['upload_attach_num'];
		$MySmartBB->rec->fields['edit_own_subject'] 			= 	$MySmartBB->_POST['edit_own_subject'];
		$MySmartBB->rec->fields['edit_own_reply'] 			= 	$MySmartBB->_POST['edit_own_reply'];
		$MySmartBB->rec->fields['del_own_subject'] 			= 	$MySmartBB->_POST['del_own_subject'];
		$MySmartBB->rec->fields['del_own_reply']			 	= 	$MySmartBB->_POST['del_own_reply'];
		$MySmartBB->rec->fields['write_poll'] 				= 	$MySmartBB->_POST['write_poll'];
		$MySmartBB->rec->fields['vote_poll'] 				= 	$MySmartBB->_POST['vote_poll'];
		$MySmartBB->rec->fields['use_pm'] 					= 	$MySmartBB->_POST['use_pm'];
		$MySmartBB->rec->fields['send_pm'] 					= 	$MySmartBB->_POST['send_pm'];
		$MySmartBB->rec->fields['resive_pm'] 				= 	$MySmartBB->_POST['resive_pm'];
		$MySmartBB->rec->fields['max_pm'] 					= 	$MySmartBB->_POST['max_pm'];
		$MySmartBB->rec->fields['min_send_pm'] 				= 	$MySmartBB->_POST['min_send_pm'];
		$MySmartBB->rec->fields['sig_allow'] 				= 	$MySmartBB->_POST['sig_allow'];
		$MySmartBB->rec->fields['sig_len'] 					= 	$MySmartBB->_POST['sig_len'];
		$MySmartBB->rec->fields['group_mod'] 				= 	$MySmartBB->_POST['group_mod'];
		$MySmartBB->rec->fields['del_subject'] 				= 	$MySmartBB->_POST['del_subject'];
		$MySmartBB->rec->fields['del_reply'] 				= 	$MySmartBB->_POST['del_reply'];
		$MySmartBB->rec->fields['edit_subject'] 				= 	$MySmartBB->_POST['edit_subject'];
		$MySmartBB->rec->fields['edit_reply'] 				= 	$MySmartBB->_POST['edit_reply'];
		$MySmartBB->rec->fields['stick_subject'] 			= 	$MySmartBB->_POST['stick_subject'];
		$MySmartBB->rec->fields['unstick_subject'] 			= 	$MySmartBB->_POST['unstick_subject'];
		$MySmartBB->rec->fields['move_subject'] 				= 	$MySmartBB->_POST['move_subject'];
		$MySmartBB->rec->fields['close_subject'] 			= 	$MySmartBB->_POST['close_subject'];
		$MySmartBB->rec->fields['usercp_allow'] 				= 	$MySmartBB->_POST['usercp_allow'];
		$MySmartBB->rec->fields['admincp_allow'] 			= 	$MySmartBB->_POST['admincp_allow'];
		$MySmartBB->rec->fields['search_allow'] 				= 	$MySmartBB->_POST['search_allow'];
		$MySmartBB->rec->fields['memberlist_allow'] 			= 	$MySmartBB->_POST['memberlist_allow'];
		$MySmartBB->rec->fields['vice'] 						= 	$MySmartBB->_POST['vice'];
		$MySmartBB->rec->fields['show_hidden'] 				= 	$MySmartBB->_POST['show_hidden'];
		$MySmartBB->rec->fields['view_usernamestyle'] 		= 	$MySmartBB->_POST['view_usernamestyle'];
		$MySmartBB->rec->fields['usertitle_change'] 			= 	$MySmartBB->_POST['usertitle_change'];
		$MySmartBB->rec->fields['onlinepage_allow'] 			= 	$MySmartBB->_POST['onlinepage_allow'];
		$MySmartBB->rec->fields['allow_see_offstyles'] 		= 	$MySmartBB->_POST['allow_see_offstyles'];
		$MySmartBB->rec->fields['admincp_section'] 			= 	$MySmartBB->_POST['admincp_section'];
		$MySmartBB->rec->fields['admincp_option'] 			= 	$MySmartBB->_POST['admincp_option'];
		$MySmartBB->rec->fields['admincp_member'] 			= 	$MySmartBB->_POST['admincp_member'];
		$MySmartBB->rec->fields['admincp_membergroup'] 		= 	$MySmartBB->_POST['admincp_membergroup'];
		$MySmartBB->rec->fields['admincp_membertitle'] 		= 	$MySmartBB->_POST['admincp_membertitle'];
		$MySmartBB->rec->fields['admincp_admin'] 			= 	$MySmartBB->_POST['admincp_admin'];
		$MySmartBB->rec->fields['admincp_adminstep'] 		= 	$MySmartBB->_POST['admincp_adminstep'];
		$MySmartBB->rec->fields['admincp_subject'] 			= 	$MySmartBB->_POST['admincp_subject'];
		$MySmartBB->rec->fields['admincp_database'] 			= 	$MySmartBB->_POST['admincp_database'];
		$MySmartBB->rec->fields['admincp_fixup'] 			= 	$MySmartBB->_POST['admincp_fixup'];
		$MySmartBB->rec->fields['admincp_ads'] 				= 	$MySmartBB->_POST['admincp_ads'];
		$MySmartBB->rec->fields['admincp_template'] 			= 	$MySmartBB->_POST['admincp_template'];
		$MySmartBB->rec->fields['admincp_adminads'] 			= 	$MySmartBB->_POST['admincp_adminads'];
		$MySmartBB->rec->fields['admincp_attach'] 			= 	$MySmartBB->_POST['admincp_attach'];
		$MySmartBB->rec->fields['admincp_page'] 				= 	$MySmartBB->_POST['admincp_page'];
		$MySmartBB->rec->fields['admincp_block'] 			= 	$MySmartBB->_POST['admincp_block'];
		$MySmartBB->rec->fields['admincp_style'] 			= 	$MySmartBB->_POST['admincp_style'];
		$MySmartBB->rec->fields['admincp_toolbox'] 			= 	$MySmartBB->_POST['admincp_toolbox'];
		$MySmartBB->rec->fields['admincp_smile'] 			= 	$MySmartBB->_POST['admincp_smile'];
		$MySmartBB->rec->fields['admincp_icon'] 				= 	$MySmartBB->_POST['admincp_icon'];
		$MySmartBB->rec->fields['admincp_avater'] 			= 	$MySmartBB->_POST['admincp_avater'];
		$MySmartBB->rec->fields['group_order'] 				= 	$MySmartBB->_POST['group_order'];
		$MySmartBB->rec->fields['admincp_contactus'] 		= 	$MySmartBB->_POST['admincp_contactus'];
		//$MySmartBB->rec->fields['no_posts'] 		    		= 	$MySmartBB->_POST['no_posts'];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث المجموعه بنجاح !');
			$MySmartBB->func->move('admin.php?page=groups&amp;control=1&amp;main=1');
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('group_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->func->msg('تم حذف المجموعه بنجاح !');
			$MySmartBB->func->move('admin.php?page=groups&amp;control=1&amp;main=1');
		}
	}
}

class _func
{	
	function check_by_id(&$GroupInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$GroupInfo = $MySmartBB->rec->getInfo();
		
		if ($GroupInfo == false)
		{
			$MySmartBB->func->error('المجموعه المطلوبه غير موجوده');
		}
	}
}

?>
