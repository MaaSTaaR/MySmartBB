<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SECTION'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartGroupsMOD');

class MySmartGroupsMOD extends _functions
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['add'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_AddMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_AddStart();
				}
			}
			elseif ($MySmartBB->_GET['control'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_ControlMain();
				}
			}
			elseif ($MySmartBB->_GET['edit'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_EditMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_EditStart();
				}
			}
			elseif ($MySmartBB->_GET['del'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_DelMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_DelStart();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	function _AddMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('group_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['group_order']) 
			or empty($MySmartBB->_POST['style'])
			or empty($MySmartBB->_POST['usertitle']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		// Enable HTML and (only) HTML
		$MySmartBB->_POST['style'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['style'],'unhtml');
		
		$GroupArr 			= 	array();
		$GroupArr['field']	=	array();
		
		$GroupArr['field']['title'] 					= 	$MySmartBB->_POST['name'];
		$GroupArr['field']['username_style'] 			= 	$MySmartBB->_POST['style'];
		$GroupArr['field']['user_title'] 				= 	$MySmartBB->_POST['usertitle'];
		$GroupArr['field']['forum_team'] 				= 	$MySmartBB->_POST['forum_team'];
		$GroupArr['field']['banned'] 					= 	$MySmartBB->_POST['banned'];
		$GroupArr['field']['view_section'] 				= 	$MySmartBB->_POST['view_section'];
		$GroupArr['field']['download_attach'] 			= 	$MySmartBB->_POST['download_attach'];
		$GroupArr['field']['download_attach_number'] 	= 	$MySmartBB->_POST['download_attach_number'];
		$GroupArr['field']['write_subject'] 			= 	$MySmartBB->_POST['write_subject'];
		$GroupArr['field']['write_reply'] 				= 	$MySmartBB->_POST['write_reply'];
		$GroupArr['field']['upload_attach'] 			= 	$MySmartBB->_POST['upload_attach'];
		$GroupArr['field']['upload_attach_num'] 		= 	$MySmartBB->_POST['upload_attach_num'];
		$GroupArr['field']['edit_own_subject'] 			= 	$MySmartBB->_POST['edit_own_subject'];
		$GroupArr['field']['edit_own_reply'] 			= 	$MySmartBB->_POST['edit_own_reply'];
		$GroupArr['field']['del_own_subject'] 			= 	$MySmartBB->_POST['del_own_subject'];
		$GroupArr['field']['del_own_reply']			 	= 	$MySmartBB->_POST['del_own_reply'];
		$GroupArr['field']['write_poll'] 				= 	$MySmartBB->_POST['write_poll'];
		$GroupArr['field']['no_posts'] 		    		= 	$MySmartBB->_POST['no_posts'];
		$GroupArr['field']['vote_poll'] 				= 	$MySmartBB->_POST['vote_poll'];
		$GroupArr['field']['use_pm'] 					= 	$MySmartBB->_POST['use_pm'];
		$GroupArr['field']['send_pm'] 					= 	$MySmartBB->_POST['send_pm'];
		$GroupArr['field']['resive_pm'] 				= 	$MySmartBB->_POST['resive_pm'];
		$GroupArr['field']['max_pm'] 					= 	$MySmartBB->_POST['max_pm'];
		$GroupArr['field']['min_send_pm'] 				= 	$MySmartBB->_POST['min_send_pm'];
		$GroupArr['field']['sig_allow'] 				= 	$MySmartBB->_POST['sig_allow'];
		$GroupArr['field']['sig_len'] 					= 	$MySmartBB->_POST['sig_len'];
		$GroupArr['field']['group_mod'] 				= 	$MySmartBB->_POST['group_mod'];
		$GroupArr['field']['del_subject'] 				= 	$MySmartBB->_POST['del_subject'];
		$GroupArr['field']['del_reply'] 				= 	$MySmartBB->_POST['del_reply'];
		$GroupArr['field']['edit_subject'] 				= 	$MySmartBB->_POST['edit_subject'];
		$GroupArr['field']['edit_reply'] 				= 	$MySmartBB->_POST['edit_reply'];
		$GroupArr['field']['stick_subject'] 			= 	$MySmartBB->_POST['stick_subject'];
		$GroupArr['field']['unstick_subject'] 			= 	$MySmartBB->_POST['unstick_subject'];
		$GroupArr['field']['move_subject'] 				= 	$MySmartBB->_POST['move_subject'];
		$GroupArr['field']['close_subject'] 			= 	$MySmartBB->_POST['close_subject'];
		$GroupArr['field']['usercp_allow'] 				= 	$MySmartBB->_POST['usercp_allow'];
		$GroupArr['field']['admincp_allow'] 			= 	$MySmartBB->_POST['admincp_allow'];
		$GroupArr['field']['search_allow'] 				= 	$MySmartBB->_POST['search_allow'];
		$GroupArr['field']['memberlist_allow'] 			= 	$MySmartBB->_POST['memberlist_allow'];
		$GroupArr['field']['vice'] 						= 	$MySmartBB->_POST['vice'];
		$GroupArr['field']['show_hidden'] 				= 	$MySmartBB->_POST['show_hidden'];
		$GroupArr['field']['view_usernamestyle'] 		= 	$MySmartBB->_POST['view_usernamestyle'];
		$GroupArr['field']['usertitle_change'] 			= 	$MySmartBB->_POST['usertitle_change'];
		$GroupArr['field']['onlinepage_allow'] 			= 	$MySmartBB->_POST['onlinepage_allow'];
		$GroupArr['field']['allow_see_offstyles'] 		= 	$MySmartBB->_POST['allow_see_offstyles'];
		$GroupArr['field']['admincp_section'] 			= 	$MySmartBB->_POST['admincp_section'];
		$GroupArr['field']['admincp_option'] 			= 	$MySmartBB->_POST['admincp_option'];
		$GroupArr['field']['admincp_member'] 			= 	$MySmartBB->_POST['admincp_member'];
		$GroupArr['field']['admincp_membergroup'] 		= 	$MySmartBB->_POST['admincp_membergroup'];
		$GroupArr['field']['admincp_membertitle'] 		= 	$MySmartBB->_POST['admincp_membertitle'];
		$GroupArr['field']['admincp_admin'] 			= 	$MySmartBB->_POST['admincp_admin'];
		$GroupArr['field']['admincp_adminstep'] 		= 	$MySmartBB->_POST['admincp_adminstep'];
		$GroupArr['field']['admincp_subject'] 			= 	$MySmartBB->_POST['admincp_subject'];
		$GroupArr['field']['admincp_database'] 			= 	$MySmartBB->_POST['admincp_database'];
		$GroupArr['field']['admincp_fixup'] 			= 	$MySmartBB->_POST['admincp_fixup'];
		$GroupArr['field']['admincp_ads'] 				= 	$MySmartBB->_POST['admincp_ads'];
		$GroupArr['field']['admincp_template'] 			= 	$MySmartBB->_POST['admincp_template'];
		$GroupArr['field']['admincp_adminads'] 			= 	$MySmartBB->_POST['admincp_adminads'];
		$GroupArr['field']['admincp_attach'] 			= 	$MySmartBB->_POST['admincp_attach'];
		$GroupArr['field']['admincp_page'] 				= 	$MySmartBB->_POST['admincp_page'];
		$GroupArr['field']['admincp_block'] 			= 	$MySmartBB->_POST['admincp_block'];
		$GroupArr['field']['admincp_style'] 			= 	$MySmartBB->_POST['admincp_style'];
		$GroupArr['field']['admincp_toolbox'] 			= 	$MySmartBB->_POST['admincp_toolbox'];
		$GroupArr['field']['admincp_smile'] 			= 	$MySmartBB->_POST['admincp_smile'];
		$GroupArr['field']['admincp_icon'] 				= 	$MySmartBB->_POST['admincp_icon'];
		$GroupArr['field']['admincp_avater'] 			= 	$MySmartBB->_POST['admincp_avater'];
		$GroupArr['field']['group_order'] 				= 	$MySmartBB->_POST['group_order'];
		$GroupArr['field']['admincp_contactus'] 		= 	$MySmartBB->_POST['admincp_contactus'];
		$GroupArr['get_id']								=	true;
				
		$insert = $MySmartBB->group->InsertGroup($GroupArr);
		
		if ($insert)
		{
			//////////
			
			$SecArr 						= 	array();
			$SecArr['order'] 				= 	array();
			$SecArr['order']['field'] 		= 	'id';
			$SecArr['order']['type'] 		= 	'ASC';
			
			$sections = $MySmartBB->section->GetSectionsList($SecArr);
			
			//////////
			
			$x = 0;
			$n = sizeof($sections);
			
			while ($x < $n)
			{
				$GrpArr 					= 	array();
				$GrpArr['field']			=	array();
				
				$GrpArr['field']['section_id'] 			= 	$sections['id'];
				$GrpArr['field']['group_id'] 			= 	$MySmartBB->group->id;
				$GrpArr['field']['view_section'] 		= 	$MySmartBB->_POST['view_section'];
				$GrpArr['field']['download_attach'] 	= 	$MySmartBB->_POST['download_attach'];
				$GrpArr['field']['write_subject'] 		= 	$MySmartBB->_POST['write_subject'];
				$GrpArr['field']['write_reply'] 		= 	$MySmartBB->_POST['write_reply'];
				$GrpArr['field']['upload_attach'] 		= 	$MySmartBB->_POST['upload_attach'];
				$GrpArr['field']['edit_own_subject'] 	= 	$MySmartBB->_POST['edit_own_subject'];
				$GrpArr['field']['edit_own_reply'] 		= 	$MySmartBB->_POST['edit_own_reply'];
				$GrpArr['field']['del_own_subject'] 	= 	$MySmartBB->_POST['del_own_subject'];
				$GrpArr['field']['del_own_reply'] 		= 	$MySmartBB->_POST['del_own_reply'];
				$GrpArr['field']['write_poll'] 			= 	$MySmartBB->_POST['write_poll'];
				$GrpArr['field']['no_posts'] 			= 	$MySmartBB->_POST['no_posts'];
				$GrpArr['field']['vote_poll'] 			= 	$MySmartBB->_POST['vote_poll'];
				$GrpArr['field']['main_section'] 		= 	($sections['parent'] == 0) ? 1 : 0;
				$GrpArr['field']['group_name'] 			= 	$MySmartBB->_POST['title'];
				
				$insert = $MySmartBB->group->InsertSectionGroup($GrpArr);
				
				$x += 1;
			}
			
			$cache = $MySmartBB->section->UpdateAllSectionsCache();
			
			if ($cache)
			{
				$MySmartBB->functions->msg('تم اضافة المجموعه بنجاح !');
				$MySmartBB->functions->goto('admin.php?page=groups&amp;control=1&amp;main=1');
			}
		}
	}
	
	function _ControlMain()
	{
		global $MySmartBB;

		//////////
		
		$GroupArr 							= 	array();
		$GroupArr['order'] 					= 	array();
		$GroupArr['order']['field'] 		= 	'id';
		$GroupArr['order']['type'] 			= 	'ASC';
		$GroupArr['proc'] 					= 	array();
		$GroupArr['proc']['*'] 				= 	array('method'=>'clean','param'=>'html');
		$GroupArr['proc']					=	array();
		$GroupArr['proc']['username_style']	=	array('method'=>'replace','search'=>'[username]','replace'=>'rows{title}','store'=>'h_title');
		
		$MySmartBB->_CONF['template']['while']['groups'] = $MySmartBB->group->GetGroupList($GroupArr);
		
		//////////
		
		$MySmartBB->template->display('groups_main');
	}
	
	function _EditMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('group_edit');
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['group_order']) 
			or empty($MySmartBB->_POST['style'])
			or empty($MySmartBB->_POST['usertitle']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		// Enable HTML and (only) HTML
		$MySmartBB->_POST['style'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['style'],'unhtml');
		
		$GroupArr 			= 	array();
		$GroupArr['field']	=	array();
		
		$GroupArr['field']['title'] 					= 	$MySmartBB->_POST['name'];
		$GroupArr['field']['username_style'] 			= 	$MySmartBB->_POST['style'];
		$GroupArr['field']['user_title'] 				= 	$MySmartBB->_POST['usertitle'];
		$GroupArr['field']['forum_team'] 				= 	$MySmartBB->_POST['forum_team'];
		$GroupArr['field']['banned'] 					= 	$MySmartBB->_POST['banned'];
		$GroupArr['field']['view_section'] 				= 	$MySmartBB->_POST['view_section'];
		$GroupArr['field']['download_attach'] 			= 	$MySmartBB->_POST['download_attach'];
		$GroupArr['field']['download_attach_number'] 	= 	$MySmartBB->_POST['download_attach_number'];
		$GroupArr['field']['write_subject'] 			= 	$MySmartBB->_POST['write_subject'];
		$GroupArr['field']['write_reply'] 				= 	$MySmartBB->_POST['write_reply'];
		$GroupArr['field']['upload_attach'] 			= 	$MySmartBB->_POST['upload_attach'];
		$GroupArr['field']['upload_attach_num'] 		= 	$MySmartBB->_POST['upload_attach_num'];
		$GroupArr['field']['edit_own_subject'] 			= 	$MySmartBB->_POST['edit_own_subject'];
		$GroupArr['field']['edit_own_reply'] 			= 	$MySmartBB->_POST['edit_own_reply'];
		$GroupArr['field']['del_own_subject'] 			= 	$MySmartBB->_POST['del_own_subject'];
		$GroupArr['field']['del_own_reply']			 	= 	$MySmartBB->_POST['del_own_reply'];
		$GroupArr['field']['write_poll'] 				= 	$MySmartBB->_POST['write_poll'];
		$GroupArr['field']['vote_poll'] 				= 	$MySmartBB->_POST['vote_poll'];
		$GroupArr['field']['use_pm'] 					= 	$MySmartBB->_POST['use_pm'];
		$GroupArr['field']['send_pm'] 					= 	$MySmartBB->_POST['send_pm'];
		$GroupArr['field']['resive_pm'] 				= 	$MySmartBB->_POST['resive_pm'];
		$GroupArr['field']['max_pm'] 					= 	$MySmartBB->_POST['max_pm'];
		$GroupArr['field']['min_send_pm'] 				= 	$MySmartBB->_POST['min_send_pm'];
		$GroupArr['field']['sig_allow'] 				= 	$MySmartBB->_POST['sig_allow'];
		$GroupArr['field']['sig_len'] 					= 	$MySmartBB->_POST['sig_len'];
		$GroupArr['field']['group_mod'] 				= 	$MySmartBB->_POST['group_mod'];
		$GroupArr['field']['del_subject'] 				= 	$MySmartBB->_POST['del_subject'];
		$GroupArr['field']['del_reply'] 				= 	$MySmartBB->_POST['del_reply'];
		$GroupArr['field']['edit_subject'] 				= 	$MySmartBB->_POST['edit_subject'];
		$GroupArr['field']['edit_reply'] 				= 	$MySmartBB->_POST['edit_reply'];
		$GroupArr['field']['stick_subject'] 			= 	$MySmartBB->_POST['stick_subject'];
		$GroupArr['field']['unstick_subject'] 			= 	$MySmartBB->_POST['unstick_subject'];
		$GroupArr['field']['move_subject'] 				= 	$MySmartBB->_POST['move_subject'];
		$GroupArr['field']['close_subject'] 			= 	$MySmartBB->_POST['close_subject'];
		$GroupArr['field']['usercp_allow'] 				= 	$MySmartBB->_POST['usercp_allow'];
		$GroupArr['field']['admincp_allow'] 			= 	$MySmartBB->_POST['admincp_allow'];
		$GroupArr['field']['search_allow'] 				= 	$MySmartBB->_POST['search_allow'];
		$GroupArr['field']['memberlist_allow'] 			= 	$MySmartBB->_POST['memberlist_allow'];
		$GroupArr['field']['vice'] 						= 	$MySmartBB->_POST['vice'];
		$GroupArr['field']['show_hidden'] 				= 	$MySmartBB->_POST['show_hidden'];
		$GroupArr['field']['view_usernamestyle'] 		= 	$MySmartBB->_POST['view_usernamestyle'];
		$GroupArr['field']['usertitle_change'] 			= 	$MySmartBB->_POST['usertitle_change'];
		$GroupArr['field']['onlinepage_allow'] 			= 	$MySmartBB->_POST['onlinepage_allow'];
		$GroupArr['field']['allow_see_offstyles'] 		= 	$MySmartBB->_POST['allow_see_offstyles'];
		$GroupArr['field']['admincp_section'] 			= 	$MySmartBB->_POST['admincp_section'];
		$GroupArr['field']['admincp_option'] 			= 	$MySmartBB->_POST['admincp_option'];
		$GroupArr['field']['admincp_member'] 			= 	$MySmartBB->_POST['admincp_member'];
		$GroupArr['field']['admincp_membergroup'] 		= 	$MySmartBB->_POST['admincp_membergroup'];
		$GroupArr['field']['admincp_membertitle'] 		= 	$MySmartBB->_POST['admincp_membertitle'];
		$GroupArr['field']['admincp_admin'] 			= 	$MySmartBB->_POST['admincp_admin'];
		$GroupArr['field']['admincp_adminstep'] 		= 	$MySmartBB->_POST['admincp_adminstep'];
		$GroupArr['field']['admincp_subject'] 			= 	$MySmartBB->_POST['admincp_subject'];
		$GroupArr['field']['admincp_database'] 			= 	$MySmartBB->_POST['admincp_database'];
		$GroupArr['field']['admincp_fixup'] 			= 	$MySmartBB->_POST['admincp_fixup'];
		$GroupArr['field']['admincp_ads'] 				= 	$MySmartBB->_POST['admincp_ads'];
		$GroupArr['field']['admincp_template'] 			= 	$MySmartBB->_POST['admincp_template'];
		$GroupArr['field']['admincp_adminads'] 			= 	$MySmartBB->_POST['admincp_adminads'];
		$GroupArr['field']['admincp_attach'] 			= 	$MySmartBB->_POST['admincp_attach'];
		$GroupArr['field']['admincp_page'] 				= 	$MySmartBB->_POST['admincp_page'];
		$GroupArr['field']['admincp_block'] 			= 	$MySmartBB->_POST['admincp_block'];
		$GroupArr['field']['admincp_style'] 			= 	$MySmartBB->_POST['admincp_style'];
		$GroupArr['field']['admincp_toolbox'] 			= 	$MySmartBB->_POST['admincp_toolbox'];
		$GroupArr['field']['admincp_smile'] 			= 	$MySmartBB->_POST['admincp_smile'];
		$GroupArr['field']['admincp_icon'] 				= 	$MySmartBB->_POST['admincp_icon'];
		$GroupArr['field']['admincp_avater'] 			= 	$MySmartBB->_POST['admincp_avater'];
		$GroupArr['field']['group_order'] 				= 	$MySmartBB->_POST['group_order'];
		$GroupArr['field']['admincp_contactus'] 		= 	$MySmartBB->_POST['admincp_contactus'];
		$GroupArr['field']['no_posts'] 		    		= 	$MySmartBB->_POST['no_posts'];
		$GroupArr['where']								=	array('id',$MySmartBB->_CONF['template']['Inf']['id']);
				
		$update = $MySmartBB->group->UpdateGroup($GroupArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث المجموعه بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=groups&amp;control=1&amp;main=1');
		}
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('group_del');
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$del = $MySmartBB->group->DeleteGroup(array('where'=>array('id',$MySmartBB->_GET['id'])));
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف المجموعه بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=groups&amp;control=1&amp;main=1');
		}
	}
}

class _functions
{	
	function check_by_id(&$GroupInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$GrpArr 			= 	array();
		$GrpArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$GroupInfo = $MySmartBB->group->GetGroupInfo($GrpArr);
		
		if ($GroupInfo == false)
		{
			$MySmartBB->functions->error('المجموعه المطلوبه غير موجوده');
		}
		
		$MySmartBB->functions->CleanVariable($GroupInfo,'html');
	}
}

?>
