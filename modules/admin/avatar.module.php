<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['AVATAR'] 		= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartAvatarMOD');
	
class MySmartAvatarMOD extends _functions
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

		$MySmartBB->template->display('avatar_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['path']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$AvrArr 			= 	array();
		$AvrArr['field']	=	array();
		
		$AvrArr['field']['avatar_path'] = $MySmartBB->_POST['path'];
		
		$insert = $MySmartBB->avatar->InsertAvatar($AvrArr);
			
		if ($insert)
		{
			$MySmartBB->functions->msg('تم اضافة الصوره بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=avatar&amp;control=1&amp;main=1');
		}
	}
	
	function _ControlMain()
	{
		global $MySmartBB;
		
		$AvrArr 					= 	array();
		$AvrArr['order']			=	array();
		$AvrArr['order']['field']	=	'id';
		$AvrArr['order']['type']	=	'DESC';
		$AvrArr['proc'] 			= 	array();
		$AvrArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['AvrList'] = $MySmartBB->avatar->GetAvatarList($AvrArr);
		
		$MySmartBB->template->display('avatars_main');
	}
	
	function _EditMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('avatar_edit');
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		if (empty($MySmartBB->_POST['path']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}

		$AvrArr 			= 	array();
		$AvrArr['field'] 	= 	array();
		
		$AvrArr['field']['avatar_path'] 	= 	$MySmartBB->_POST['path'];
		$AvrArr['where']					= 	array('id',$MySmartBB->_CONF['template']['Inf']['id']);
		
		$update = $MySmartBB->avatar->UpdateAvatar($AvrArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث الصوره بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=avatar&amp;control=1&amp;main=1');
		}
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
				
		$MySmartBB->template->display('avatar_del');
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$del = $MySmartBB->avatar->DeleteAvatar(array('id'	=>	$MySmartBB->_CONF['template']['id']));
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف الصوره بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=avatar&amp;control=1&amp;main=1');
		}
	}
}

class _functions
{
	function check_by_id(&$Inf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$AvArr 			= 	array();
		$AvArr['where']	= 	array('id',$MySmartBB->_GET['id']);
		
		$Inf = $MySmartBB->avatar->GetAvatarInfo($AvArr);
		
		if ($Inf == false)
		{
			$MySmartBB->functions->error('الصوره المطلوبه غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($Inf,'html');
	}
}

?>
