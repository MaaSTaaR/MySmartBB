<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_func',true);
define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartUserCPAvatarMOD');

class MySmartUserCPAvatarMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->func->error( 'المعذره .. هذه المنطقه للاعضاء فقط' );
		}
		
		if ( $MySmartBB->_GET[ 'main' ] )				
		{
			$this->_avatarMain();
		}
		elseif ( $MySmartBB->_GET[ 'start' ] )
		{
			$this->_avatarChange();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _avatarMain()
	{
		global $MySmartBB;
		
		// This line will include jQuery (Javascript library)
		$MySmartBB->template->assign('JQUERY',true);
		
		$MySmartBB->func->showHeader('الصوره الشخصيه');
		
		if (!$MySmartBB->_CONF['info_row']['allow_avatar'])
		{
			$MySmartBB->func->error('المعذره .. لا يمكنك استخدام هذه الميزه');
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		
		$avatar_num = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$avatar_num;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['avatar_perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=usercp&amp;control=1&amp;avatar=1&amp;main=1';
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['avatar_res'];
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->template->display('usercp_control_avatar');
	}
	
	private function _avatarChange()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تنفيذ عملية التحديث');
		
		$MySmartBB->func->addressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');
		
		$allowed_array = array('.jpg','.gif','.png');
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
		
		$MySmartBB->rec->fields['avater_path'] = '';
		
		if ($MySmartBB->_POST['options'] == 'no')
		{
			$MySmartBB->rec->fields['avater_path'] = '';
		}
		elseif ($MySmartBB->_POST['options'] == 'list')
		{
			if (empty($MySmartBB->_POST['avatar_list']))
			{
				$MySmartBB->func->error('يرجى اختيار الصوره المطلوبه');
			}
			
			$MySmartBB->rec->fields['avater_path'] = $MySmartBB->_POST['avatar_list'];
		}
		elseif ($MySmartBB->_POST['options'] == 'site')
		{
			if (empty($MySmartBB->_POST['avatar'])
				or $MySmartBB->_POST['avatar'] == 'http://')
			{
				$MySmartBB->func->error('يرجى اختيار الصوره المطلوبه');
			}
			elseif (!$MySmartBB->func->IsSite($MySmartBB->_POST['avatar']))
			{
				$MySmartBB->func->error('الموقع الذي قمت بكتابته غير صحيح !');
			}
				
			$extension = $MySmartBB->func->GetURLExtension($MySmartBB->_POST['avatar']);
				
			if (!in_array($extension,$allowed_array))
			{
				$MySmartBB->func->error('امتداد الصوره غير مسموح به !');
			}
			
			$size = @getimagesize($MySmartBB->_POST['avatar']);

			if ($size[0] > $MySmartBB->_CONF['info_row']['max_avatar_width'])
			{
				$MySmartBB->func->error('عرض الصورة غير مقبول');
			}
			
			if ($size[1] > $MySmartBB->_CONF['info_row']['max_avatar_height'])
			{
				$MySmartBB->func->error('طول الصورة غير مقبول');
			}
			
			$MySmartBB->rec->fields['avater_path'] = $MySmartBB->_POST['avatar'];
		}
		elseif ($MySmartBB->_POST['options'] == 'upload')
		{
			$pic = $MySmartBB->_FILES['upload']['tmp_name'];

			$size = @getimagesize($pic);

			if ($size[0] > $MySmartBB->_CONF['info_row']['max_avatar_width'])
			{
				$MySmartBB->func->error('عرض الصورة غير مقبول');
			}

			if ($size[1] > $MySmartBB->_CONF['info_row']['max_avatar_height'])
			{
				$MySmartBB->func->error('طول الصورة غير مقبول');
			}
			
     		if (!empty($MySmartBB->_FILES['upload']['name']))
     		{
     			//////////
     				
     			// Get the extension of the file
     			$ext = $MySmartBB->func->GetFileExtension($MySmartBB->_FILES['upload']['name']);
     			
     			// Bad try!
     			if ($ext == 'MULTIEXTENSION'
     				or !$ext)
     			{
     			}
     			else
     			{
	     			// Convert the extension to small case
    	 			$ext = strtolower($ext);
     			
    	 			// The extension is not allowed
    	 			if (!in_array($ext,$allowed_array))
					{
						$MySmartBB->func->error('امتداد الصوره غير مسموح به !');
					}
    	 			else
    	 			{
    	 				// Set the name of the file
    	 				
    	 				$filename = $MySmartBB->_FILES['upload']['name'];
    	 				
    	 				// There is a file which has same name, so change the name of the new file
    	 				if (file_exists($MySmartBB->_CONF['info_row']['download_path'] . '/avatar/' . $filename))
    	 				{
    	 					$filename = $MySmartBB->_FILES['files']['upload'] . '-' . $MySmartBB->func->RandomCode();
    	 				}
    	 					
    	 				//////////
    	 				
    	 				// Copy the file to download dirctory
    	 				$copy = copy($MySmartBB->_FILES['upload']['tmp_name'],$MySmartBB->_CONF['info_row']['download_path'] . '/avatar/' . $filename);	
    	 						
    	 				// Success
    	 				if ($copy)
    	 				{
    	 					// Change avatar to the new one
    	 					$MySmartBB->rec->fields['avater_path'] = $MySmartBB->_CONF['info_row']['download_path'] . '/avatar/' . $filename;
    	 				}
    	 							
    	 				//////////
    	 			}				
    	 		}
    	 	}
    	}
		else
		{
			$MySmartBB->func->msg('يرجى الانتظار');
			$MySmartBB->func->move('index.php?page=usercp&control=1&avatar=1&main=1',2);
			$MySmartBB->func->stop();
		}
		
		$update = $MySmartBB->member->updateMember();
			
		if ( $update )
		{
			$MySmartBB->func->msg('تم التحديث بنجاح !');
			$MySmartBB->func->move('index.php?page=usercp_control_avatar&main=1',2);
		}
	}
}
