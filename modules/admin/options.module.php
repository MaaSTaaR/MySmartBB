<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

include('common.php');

define('CLASS_NAME','MySmartOptionsMOD');
	
class MySmartOptionsMOD
{
	function run()
	{
		global $MySmartBB;

		$MySmartBB->template->display('header');
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_IndexPage();
		}
		elseif ($MySmartBB->_GET['general'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_GeneralMain();
			}
			elseif ($MySmartBB->_GET['update'])
			{
				$this->_GeneralUpdate();
			}
		}
		elseif ($MySmartBB->_GET['time'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_TimeMain();
			}
			elseif ($MySmartBB->_GET['update'])
			{
				$this->_TimeUpdate();
			}
		}
		elseif ($MySmartBB->_GET['pages'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_PagesMain();
			}
			elseif ($MySmartBB->_GET['update'])
			{
				$this->_PagesUpdate();
			}
		}
		elseif ($MySmartBB->_GET['register'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_RegisterMain();
			}
			elseif ($MySmartBB->_GET['update'])
			{
				$this->_RegisterUpdate();
			}
		}
		elseif ($MySmartBB->_GET['topics'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_TopicsMain();
			}
			elseif ($MySmartBB->_GET['update'])
			{
				$this->_TopicsUpdate();
			}
		}
		elseif ($MySmartBB->_GET['fast_reply'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_FastReplyMain();
			}
			elseif ($MySmartBB->_GET['update'])
			{
				$this->_FastReplyUpdate();
			}
		}
		elseif ($MySmartBB->_GET['member'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_MemberMain();
			}
			elseif ($MySmartBB->_GET['update'])
			{
				$this->_MemberUpdate();
			}
		}
		elseif ($MySmartBB->_GET['avatar'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_AvatarMain();
			}
			elseif ($MySmartBB->_GET['update'])
			{
				$this->_AvatarUpdate();
			}
		}
		elseif ($MySmartBB->_GET['close_days'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_CloseDaysMain();
			}
			elseif ($MySmartBB->_GET['update'])
			{
				$this->_CloseDaysUpdate();
			}
		}
		elseif ($MySmartBB->_GET['close'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_CloseMain();
			}
			elseif ($MySmartBB->_GET['update'])
			{
				$this->_CloseUpdate();
			}
		}
		elseif ($MySmartBB->_GET['ajax'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_AjaxMain();
			}
			elseif ($MySmartBB->_GET['update'])
			{
				$this->_AjaxUpdate();
			}
		}
		
		$MySmartBB->template->display('footer');
	}
	
	function _IndexPage()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_main');
	}
	
	function _GeneralMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_general');
	}
	
	function _GeneralUpdate()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['send_email']) 
			or empty($MySmartBB->_POST['admin_email']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$update = array();
		$update[0] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['title'],'var_name'=>'title'));
		$update[1] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['send_email'],'var_name'=>'send_email'));
		$update[2] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['admin_email'],'var_name'=>'admin_email'));
		$update[3] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['guest_online'],'var_name'=>'show_onlineguest'));
		
		if ($update[0] 
			and $update[1] 
			and $update[2] 
			and $update[3])
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=options&amp;general=1&amp;main=1');
		}
	}
	
	function _TimeMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_time');
	}
	
	function _TimeUpdate()
	{
		global $MySmartBB;
		
		$update = array();
		$update[0] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['time_stamp'],'var_name'=>'timestamp'));
		$update[1] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['time_system'],'var_name'=>'timesystem'));
		
		if ($update[0] and $update[1])
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=options&amp;time=1&amp;main=1');
		}
	}
	
	function _PagesMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_page');
	}
	
	function _PagesUpdate()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['page_max']) 
			or empty($MySmartBB->_POST['subject_perpage']) 
			or empty($MySmartBB->_POST['reply_perpage'])
			or empty($MySmartBB->_POST['avatar_perpage']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$update = array();
		
		$update[0] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['page_max'],'var_name'=>'page_max'));
		
		$update[1] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['subject_perpage'],'var_name'=>'subject_perpage'));
		
		$update[2] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['reply_perpage'],'var_name'=>'perpage'));
		
		$update[3] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['avatar_perpage'],'var_name'=>'avatar_perpage'));
		
		if ($update[0] 
			and $update[1] 
			and $update[2]
			and $update[3])
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=options&amp;pages=1&amp;main=1');
		}
	}
	
	function _RegisterMain()
	{
		global $MySmartBB;
		
		//////////
		
		$GroupArr 							= 	array();
		
		$GroupArr['order'] 					= 	array();
		$GroupArr['order']['field'] 		= 	'group_order';
		$GroupArr['order']['type'] 			= 	'ASC';
		
		$GroupList = $MySmartBB->group->GetGroupList($GroupArr);
		
		$MySmartBB->template->while_array['GroupList'] = $GroupList;
		
		//////////
		
		$MySmartBB->template->display('options_register');
	}
	
	function _RegisterUpdate()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['reg_less_num']) 
			or empty($MySmartBB->_POST['reg_max_num']) 
			or empty($MySmartBB->_POST['reg_pass_min_num']) 
			or empty($MySmartBB->_POST['reg_pass_max_num']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$update = array();
		$update[0] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['reg_close'],'var_name'=>'reg_close'));
		
		$update[1] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['def_group'],'var_name'=>'def_group'));
		
		$update[2] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['adef_group'],'var_name'=>'adef_group'));
		
		$update[3] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['reg_o'],'var_name'=>'reg_o'));
		
		$update[4] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['reg_less_num'],'var_name'=>'reg_less_num'));
		
		$update[5] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['reg_max_num'],'var_name'=>'reg_max_num'));
		
		$update[6] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['reg_pass_min_num'],'var_name'=>'reg_pass_min_num'));
		
		$update[7] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['reg_pass_max_num'],'var_name'=>'reg_pass_max_num'));
		
		if ($update[0] 
			and $update[1] 
			and $update[2] 
			and $update[3] 
			and $update[4] 
			and $update[5] 
			and $update[6] 
			and $update[7])
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=options&amp;register=1&amp;main=1');
		}
	}
	
	function _TopicsMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_topics');
	}
	
	function _TopicsUpdate()
	{
		global $MySmartBB;
		
		if (!isset($MySmartBB->_POST['post_text_min']) 
			or !isset($MySmartBB->_POST['post_text_max']) 
			or !isset($MySmartBB->_POST['post_title_min']) 
			or !isset($MySmartBB->_POST['post_title_max'])
			or !isset($MySmartBB->_POST['time_out'])
			or !isset($MySmartBB->_POST['floodctrl'])
			or !isset($MySmartBB->_POST['default_imagesW'])
			or !isset($MySmartBB->_POST['default_imagesH']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$update = array();
		$update[0] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['post_text_min'],'var_name'=>'post_text_min'));
		
		$update[1] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['post_text_max'],'var_name'=>'post_text_max'));
		
		$update[2] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['post_title_min'],'var_name'=>'post_title_min'));
		
		$update[3] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['post_title_max'],'var_name'=>'post_title_max'));
		
		$update[4] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['time_out'],'var_name'=>'time_out'));
		
		$update[5] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['floodctrl'],'var_name'=>'floodctrl'));
		
		$update[6] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['samesubject_show'],'var_name'=>'samesubject_show'));
		
		$update[7] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['show_subject_all'],'var_name'=>'show_subject_all'));
		
		$update[8] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['resize_imagesAllow'],'var_name'=>'resize_imagesAllow'));
		
		$update[9] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['default_imagesW'],'var_name'=>'default_imagesW'));
		
		$update[10] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['default_imagesH'],'var_name'=>'default_imagesH'));
		
		if ($update[0] 
			and $update[1] 
			and $update[2] 
			and $update[3] 
			and $update[4] 
			and $update[5] 
			and $update[6] 
			and $update[7]
			and $update[8]
			and $update[9]
			and $update[10])
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=options&amp;topics=1&amp;main=1');
		}
	}
	
	function _FastReplyMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_fast_reply');
	}
	
	function _FastReplyUpdate()
	{
		global $MySmartBB;
		
		$update = array();
		$update[0] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['fastreply_allow'],'var_name'=>'fastreply_allow'));
		
		$update[1] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['toolbox_show'],'var_name'=>'toolbox_show'));
		
		$update[2] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['smiles_show'],'var_name'=>'smiles_show'));
		
		$update[3] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['icons_show'],'var_name'=>'icons_show'));
		
		$update[4] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['title_quote'],'var_name'=>'title_quote'));
		
		$update[5] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['activate_closestick'],'var_name'=>'activate_closestick'));
		
		if ($update[0] 
			and $update[1] 
			and $update[2] 
			and $update[3] 
			and $update[4] 
			and $update[5])
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=options&amp;fast_reply=1&amp;main=1');
		}
	}
	
	function _MemberMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_member');
	}
	
	function _MemberUpdate()
	{
		global $MySmartBB;
		
		$update = array();
		$update[0] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['confirm_on_change_mail'],'var_name'=>'confirm_on_change_mail'));
		
		$update[1] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['confirm_on_change_pass'],'var_name'=>'confirm_on_change_pass'));
		
		$update[2] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['allow_apsent'],'var_name'=>'allow_apsent'));
		
		if ($update[0] 
			and $update[1]
			and $update[2])
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=options&amp;member=1&amp;main=1');
		}
	}

	function _AvatarMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('options_avatar');
	}
	
	function _AvatarUpdate()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['max_avatar_width'])
			and empty($MySmartBB->_POST['max_avatar_height']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
			
		$update = array();
		$update[0] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['allow_avatar'],'var_name'=>'allow_avatar'));
		
		$update[1] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['upload_avatar'],'var_name'=>'upload_avatar'));
		
		$update[2] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['max_avatar_width'],'var_name'=>'max_avatar_width'));
		
		$update[3] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['max_avatar_height'],'var_name'=>'max_avatar_height'));
		
		if ($update[0] 
			and $update[1]
			and $update[2]
			and $update[3])
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=options&amp;avatar=1&amp;main=1');
		}
	}

	function _CloseDaysMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_days');
	}
	
	function _CloseDaysUpdate()
	{
		global $MySmartBB;
			
		$update = array();
		$update[0] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['Sat'],'var_name'=>'Sat'));
		
		$update[1] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['Sun'],'var_name'=>'Sun'));
		
		$update[2] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['Mon'],'var_name'=>'Mon'));
		
		$update[3] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['Tue'],'var_name'=>'Tue'));
		
		$update[4] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['Wed'],'var_name'=>'Wed'));
		
		$update[5] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['Thu'],'var_name'=>'Thu'));
		
		$update[6] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['Fri'],'var_name'=>'Fri'));
		
		if ($update[0] 
			and $update[1]
			and $update[2]
			and $update[3]
			and $update[4]
			and $update[5]
			and $update[6])
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=options&amp;close_days=1&amp;main=1');
		}
	}
	
	function _CloseMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_close');
	}
	
	function _CloseUpdate()
	{
		global $MySmartBB;
			
		$update = array();
		$update[0] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['board_close'],'var_name'=>'board_close'));
		
		$update[1] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['board_msg'],'var_name'=>'board_msg'));
				
		if ($update[0] and $update[1])
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=options&amp;close=1&amp;main=1');
		}
	}

	function _AjaxMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_ajax');
	}
	
	function _AjaxUpdate()
	{
		global $MySmartBB;
			
		$update = array();
		
		$update[0] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['ajax_search'],'var_name'=>'ajax_search'));
		
		$update[1] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['ajax_register'],'var_name'=>'ajax_register'));
		
		$update[2] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['ajax_freply'],'var_name'=>'ajax_freply'));
				
		if ($update[0]
			and $update[1]
			and $update[2])
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=options&amp;ajax=1&amp;main=1');
		}
	}
}

?>
