<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['ICONS'] 		= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartSmileMOD');
	
class MySmartSmileMOD extends _functions
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

		$MySmartBB->template->display('smile_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['short'])	
			or empty($MySmartBB->_POST['path']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$SmlArr 			= 	array();
		$SmlArr['field']	=	array();
		
		$SmlArr['field']['smile_short'] 	= 	$MySmartBB->_POST['short'];
		$SmlArr['field']['smile_path'] 		= 	$MySmartBB->_POST['path'];
		
		$insert = $MySmartBB->icon->InsertSmile($SmlArr);
			
		if ($insert)
		{
			$cache = $MySmartBB->icon->UpdateSmilesCache(null);
			
			if ($cache)
			{
				$num = $MySmartBB->icon->GetSmilesNumber(null);
				
				$number = $MySmartBB->info->UpdateInfo(array('value'=>$num,'var_name'=>'smiles_number'));
				
				if ($number)
				{
					$MySmartBB->functions->msg('تم اضافة الابتسامه بنجاح !');
					$MySmartBB->functions->goto('admin.php?page=smile&amp;control=1&amp;main=1');
				}
			}
		}
	}
	
	function _ControlMain()
	{
		global $MySmartBB;
		
		$SmlArr 					= 	array();
		$SmlArr['proc'] 			= 	array();
		$SmlArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		$SmlArr['order']			=	array();
		$SmlArr['order']['field']	=	'id';
		$SmlArr['order']['type']	=	'DESC';
		
		$MySmartBB->_CONF['template']['while']['SmlList'] = $MySmartBB->icon->GetSmileList($SmlArr);
		
		$MySmartBB->template->display('smiles_main');
	}
	
	function _EditMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('smile_edit');
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($Inf);
		
		if (empty($MySmartBB->_POST['short']) 
			or empty($MySmartBB->_POST['path']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}

		$SmlArr 			= 	array();
		$SmlArr['field']	=	array();
		
		$SmlArr['field']['smile_short'] 	= 	$MySmartBB->_POST['short'];
		$SmlArr['field']['smile_path'] 		= 	$MySmartBB->_POST['path'];
		$SmlArr['where']					= 	array('id',$Inf['id']);
				
		$update = $MySmartBB->icon->UpdateSmile($SmlArr);
		
		if ($update)
		{
			$cache = $MySmartBB->icon->UpdateSmilesCache(array());
			
			if ($cache)
			{
				$MySmartBB->functions->msg('تم تحديث الابتسامه بنجاح !');
				$MySmartBB->functions->goto('admin.php?page=smile&amp;control=1&amp;main=1');
			}
		}
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('smile_del');
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($Inf);
		
		$del = $MySmartBB->icon->DeleteSmile(array('id'	=>	$Inf['id']));
		
		if ($del)
		{
			$cache = $MySmartBB->icon->UpdateSmilesCache(array());
			
			if ($cache)
			{
				$MySmartBB->functions->msg('تم حذف الابتسامه بنجاح !');
				$MySmartBB->functions->goto('admin.php?page=smile&amp;control=1&amp;main=1');
			}
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
		
		$Inf = $MySmartBB->icon->GetSmileInfo(array('id'	=>	$MySmartBB->_GET['id']));
		
		if ($Inf == false)
		{
			$MySmartBB->functions->error('الابتسامه المطلوبه غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($Inf,'html');
	}
}

?>
