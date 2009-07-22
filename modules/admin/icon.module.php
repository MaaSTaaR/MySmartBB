<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['ICONS'] 		= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartIconMOD');
	
class MySmartIconMOD extends _functions
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

		$MySmartBB->template->display('icon_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['path']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$SmlArr 				= 	array();
		$SmlArr['field']		=	array();
		
		$SmlArr['field']['smile_path'] 	= 	$MySmartBB->_POST['path'];
		
		$insert = $MySmartBB->icon->InsertIcon($SmlArr);
			
		if ($insert)
		{
			$MySmartBB->functions->msg('تم اضافة الايقونه بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=icon&amp;control=1&amp;main=1');
		}
	}
	
	function _ControlMain()
	{
		global $MySmartBB;

		$IcnArr 					= 	array();
		$IcnArr['order']			=	array();
		$IcnArr['order']['field']	=	'id';
		$IcnArr['order']['type']	=	'DESC';
		$IcnArr['proc'] 			= 	array();
		$IcnArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['IcnList'] = $MySmartBB->icon->GetIconList($IcnArr);
		
		$MySmartBB->template->display('icons_main');
	}
	
	function _EditMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('icon_edit');
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

		$IcnArr 			= 	array();
		$IcnArr['field']	=	array();
		
		$IcnArr['field']['smile_path'] 	= 	$MySmartBB->_POST['path'];
		$IcnArr['where']				= 	array('id',$MySmartBB->_CONF['template']['Inf']['id']);
				
		$update = $MySmartBB->icon->UpdateIcon($IcnArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث الايقونه بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=icon&amp;control=1&amp;main=1');
		}
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('icon_del');
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$del = $MySmartBB->icon->DeleteIcon(array('id'	=>	$MySmartBB->_CONF['template']['Inf']['id']));
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف الايقونه بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=icon&amp;control=1&amp;main=1');
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
		
		$Inf = $MySmartBB->icon->GetIconInfo(array('id'	=>	$MySmartBB->_GET['id']));
		
		if ($Inf == false)
		{
			$MySmartBB->functions->error('الايقونه المطلوبه غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($Inf,'html');
	}
}

?>
