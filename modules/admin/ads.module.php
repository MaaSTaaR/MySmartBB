<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM			=	array();
$CALL_SYSTEM['ADS'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartAdsMOD');
	
class MySmartAdsMOD extends _func
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
		
		$MySmartBB->template->display('ads_add');
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['link']) 
			or empty($MySmartBB->_POST['picture']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['sitename'] 	= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['site'] 		= 	$MySmartBB->_POST['link'];
		$MySmartBB->rec->fields['picture'] 		= 	$MySmartBB->_POST['picture'];
		$MySmartBB->rec->fields['width'] 		= 	$MySmartBB->_POST['width'];
		$MySmartBB->rec->fields['height'] 		= 	$MySmartBB->_POST['height'];
		$MySmartBB->rec->fields['clicks'] 		= 	0;
				
		$insert = $MySmartBB->rec->insert();
			
		if ($insert)
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
			
			$ads_num = $MySmartBB->rec->getNumber();
			
			$update = $MySmartBB->info->updateInfo( 'ads_num', $ads_num );
			
			if ($update)
			{
				$MySmartBB->func->msg('تم اضافة الاعلان بنجاح !');
				$MySmartBB->func->move('admin.php?page=ads&amp;control=1&amp;main=1');
			}
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->rec->getList();
				
		$MySmartBB->template->display('ads_main');
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('ads_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
				
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['link']) 
			or empty($MySmartBB->_POST['picture']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['sitename'] 	= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['site'] 		= 	$MySmartBB->_POST['link'];
		$MySmartBB->rec->fields['picture'] 		= 	$MySmartBB->_POST['picture'];
		$MySmartBB->rec->fields['width'] 		= 	$MySmartBB->_POST['width'];
		$MySmartBB->rec->fields['height'] 		= 	$MySmartBB->_POST['height'];
		$MySmartBB->rec->fields['clicks'] 		= 	$MySmartBB->_CONF['template']['Inf']['clicks'];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث الاعلان بنجاح !');
			$MySmartBB->func->move('admin.php?page=ads&amp;control=1&amp;main=1');
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('ads_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
			
			$ads_num = $MySmartBB->rec->getNumber();
			
			$update = $MySmartBB->info->updateInfo( 'ads_num', $ads_num );
			
			if ($update)
			{
				$MySmartBB->func->msg('تم حذف الاعلان بنجاح !');
				$MySmartBB->func->move('admin.php?page=ads&amp;control=1&amp;main=1');
			}
		}
	}
}

class _func
{	
	function check_by_id(&$AdsInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$AdsInfo = $MySmartBB->rec->getInfo();
		
		if ($AdsInfo == false)
		{
			$MySmartBB->func->error('الاعلان المطلوب غير موجود');
		}
	}
}

?>
