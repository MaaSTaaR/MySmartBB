<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['ICONS'] 		= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartSmileMOD');
	
class MySmartSmileMOD extends _func
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

		$MySmartBB->template->display('smile_add');
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['short'])	
			or empty($MySmartBB->_POST['path']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['smile_short'] 	= 	$MySmartBB->_POST['short'];
		$MySmartBB->rec->fields['smile_path'] 	= 	$MySmartBB->_POST['path'];
		
		$insert = $MySmartBB->icon->insertSmile();
			
		if ($insert)
		{
			$cache = $MySmartBB->icon->updateSmilesCache();
			
			if ($cache)
			{
				$num = $MySmartBB->icon->getSmilesNumber();
				
				$number = $MySmartBB->info->updateInfo( 'smiles_number', $num );
				
				if ($number)
				{
					$MySmartBB->func->msg('تم اضافة الابتسامه بنجاح !');
					$MySmartBB->func->move('admin.php?page=smile&amp;control=1&amp;main=1');
				}
			}
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->icon->getSmileList($SmlArr);
		
		$MySmartBB->template->display('smiles_main');
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('smile_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($Inf);
		
		if (empty($MySmartBB->_POST['short']) 
			or empty($MySmartBB->_POST['path']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}

		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['smile_short'] 	= 	$MySmartBB->_POST['short'];
		$MySmartBB->rec->fields['smile_path'] 	= 	$MySmartBB->_POST['path'];
		
		$MySmartBB->rec->filter = "id='" . $Inf['id'] . "'";
		
		$update = $MySmartBB->icon->updateSmile();
		
		if ($update)
		{
			$cache = $MySmartBB->icon->updateSmilesCache();
			
			if ($cache)
			{
				$MySmartBB->func->msg('تم تحديث الابتسامه بنجاح !');
				$MySmartBB->func->move('admin.php?page=smile&amp;control=1&amp;main=1');
			}
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('smile_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($Inf);
		
		$MySmartBB->rec->filter = "id='" . $Inf['id'] . "'";
		
		$del = $MySmartBB->icon->deleteSmile();
		
		if ($del)
		{
			$cache = $MySmartBB->icon->updateSmilesCache();
			
			if ($cache)
			{
				$MySmartBB->func->msg('تم حذف الابتسامه بنجاح !');
				$MySmartBB->func->move('admin.php?page=smile&amp;control=1&amp;main=1');
			}
		}
	}
}

class _func
{
	function check_by_id(&$Inf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->icon->getSmileInfo();
		
		if ($Inf == false)
		{
			$MySmartBB->func->error('الابتسامه المطلوبه غير موجود');
		}
	}
}

?>
