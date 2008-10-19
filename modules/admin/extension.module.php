<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM						=	array();
$CALL_SYSTEM['FILESEXTENSION'] 		= 	true;

include('common.php');
	
define('CLASS_NAME','MySmartExtensionMOD');
	
class MySmartExtensionMOD extends _functions
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
					$this->_AddExtensionMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_AddExtensionStart();
				}
			}
			elseif ($MySmartBB->_GET['control'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_ControlExtensionMain();
				}
			}
			elseif ($MySmartBB->_GET['edit'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_EditExtensionMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_EditExtensionStart();
				}
			}
			elseif ($MySmartBB->_GET['del'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_DelExtensionMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_DelExtensionStart();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
		
	function _AddExtensionMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('extension_add');
	}
	
	function _AddExtensionStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['extension']) 
			or empty($MySmartBB->_POST['max_size']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		if (!strstr($MySmartBB->_POST['extension'],'.'))
		{
			$MySmartBB->_POST['extension'] = '.' . $MySmartBB->_POST['extension'];
		}
		
		$MySmartBB->_POST['extension'] = strtolower($MySmartBB->_POST['extension']);
		
		$ExArr 					= 	array();
		$ExArr['field']			=	array();
		
		$ExArr['field']['Ex'] 			= 	$MySmartBB->_POST['extension'];
		$ExArr['field']['max_size'] 	= 	$MySmartBB->_POST['max_size'];
		$ExArr['field']['mime_type'] 	= 	$MySmartBB->_POST['mime_type'];
		
		$insert = $MySmartBB->extension->InsertExtension($ExArr);
			
		if ($insert)
		{
			$MySmartBB->functions->msg('تم اضافة الامتداد بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=extension&amp;control=1&amp;main=1');
		}
	}
	
	function _ControlExtensionMain()
	{
		global $MySmartBB;

		$ExArr 						= 	array();
		$ExArr['order']				=	array();
		$ExArr['order']['field']	=	'id';
		$ExArr['order']['type']		=	'DESC';
		$ExArr['proc'] 				= 	array();
		$ExArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['ExList'] = $MySmartBB->extension->GetExtensionList($ExArr);
		
		$MySmartBB->template->display('extenstions_main');
	}
	
	function _EditExtensionMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('extenstion_edit');
	}

	function _EditExtensionStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		
		if (empty($MySmartBB->_POST['extension']) 
			or empty($MySmartBB->_POST['max_size']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$ExArr 				= 	array();
		$ExArr['field']		=	array();
		
		$ExArr['field']['Ex'] 			= 	$MySmartBB->_POST['extension'];
		$ExArr['field']['max_size'] 	= 	$MySmartBB->_POST['max_size'];
		$ExArr['field']['mime_type'] 	= 	$MySmartBB->_POST['mime_type'];
		$ExArr['where']					=	array('id',$MySmartBB->_CONF['template']['Inf']['id']);
				
		$update = $MySmartBB->extension->UpdateExtension($ExArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث الامتداد بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=extension&amp;control=1&amp;main=1');
		}
	}
	
	function _DelExtensionMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('extenstion_del');
	}
	
	function _DelExtensionStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$DelArr 			= 	array();
		$DelArr['where'] 	= 	array('id',$MySmartBB->_CONF['template']['Inf']['id']);
		
		$del = $MySmartBB->extension->DeleteExtension($DelArr);
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف الامتداد بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=extension&amp;control=1&amp;main=1');
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
		
		$InfArr 			= 	array();
		$InfArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$Inf = $MySmartBB->extension->GetExtensionInfo($InfArr);
		
		if ($Inf == false)
		{
			$MySmartBB->functions->error('الامتداد المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($Inf,'html');
	}
}

?>
