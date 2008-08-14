<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM			=	array();
$CALL_SYSTEM['ADS'] 	= 	true;

include('common.php');
	
define('CLASS_NAME','MySmartAdsMOD');
	
class MySmartAdsMOD extends _functions
{
	function run()
	{
		global $MySmartBB;
		
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
	
	function _AddMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('ads_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['link']) 
			or empty($MySmartBB->_POST['picture']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$AdsArr 			= 	array();
		$AdsArr['field']	=	array();
		
		$AdsArr['field']['sitename'] 	= 	$MySmartBB->_POST['name'];
		$AdsArr['field']['site'] 		= 	$MySmartBB->_POST['link'];
		$AdsArr['field']['picture'] 	= 	$MySmartBB->_POST['picture'];
		$AdsArr['field']['width'] 		= 	$MySmartBB->_POST['width'];
		$AdsArr['field']['height'] 		= 	$MySmartBB->_POST['height'];
		$AdsArr['field']['clicks'] 		= 	0;
				
		$insert = $MySmartBB->ads->InsertAds($AdsArr);
			
		if ($insert)
		{
			$ads_num = $MySmartBB->ads->GetAdsNumber(null);
			
			$update = $MySmartBB->info->UpdateInfo(array('value'	=>	$ads_num,'var_name'	=>	'ads_num'));
			
			if ($update)
			{
				$MySmartBB->functions->msg('تم اضافة الاعلان بنجاح !');
				$MySmartBB->functions->goto('admin.php?page=ads&amp;control=1&amp;main=1');
			}
		}
	}
	
	function _ControlMain()
	{
		global $MySmartBB;
		
		$AdsArr 					= 	array();
		$AdsArr['order']			=	array();
		$AdsArr['order']['field']	=	'id';
		$AdsArr['order']['type']	=	'DESC';
		$AdsArr['proc'] 			= 	array();
		$AdsArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['AdsList'] = $MySmartBB->ads->GetAdsList($AdsArr);
				
		$MySmartBB->template->display('ads_main');
	}
	
	function _EditMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AdsInfo'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['AdsInfo']);
		
		$MySmartBB->template->display('ads_edit');
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AdsInfo'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['AdsInfo']);
				
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['link']) 
			or empty($MySmartBB->_POST['picture']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$AdsArr 			= 	array();
		$AdsArr['field']	=	array();
		
		$AdsArr['field']['name'] 		= 	$MySmartBB->_POST['name'];
		$AdsArr['field']['site'] 		= 	$MySmartBB->_POST['link'];
		$AdsArr['field']['picture'] 	= 	$MySmartBB->_POST['picture'];
		$AdsArr['field']['width'] 		= 	$MySmartBB->_POST['width'];
		$AdsArr['field']['height'] 		= 	$MySmartBB->_POST['height'];
		$AdsArr['field']['clicks'] 		= 	$AdsInfo['clicks'];
		$AdsArr['where'] 				= 	array('id',$MySmartBB->_CONF['template']['AdsInfo']['id']);
				
		$update = $MySmartBB->ads->UpdateAds($AdsArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث الاعلان بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=ads&amp;control=1&amp;main=1');
		}
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AdsInfo'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['AdsInfo']);
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AdsInfo'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['AdsInfo']);
		
		$del = $MySmartBB->ads->DeleteAds(array('id'	=>	$MySmartBB->_GET['id']));
		
		if ($del)
		{
			$ads_num = $MySmartBB->ads->GetAdsNumber();
			
			$update = $MySmartBB->info->UpdateInfo(array('value'	=>	$ads_num,'var_name'	=>	'ads_num'));
			
			if ($update)
			{
				$MySmartBB->functions->msg('تم حذف الاعلان بنجاح !');
				$MySmartBB->functions->goto('admin.php?page=ads&amp;control=1&amp;main=1');
			}
		}
	}
}

class _functions
{	
	function check_by_id(&$AdsInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$AdsArr 			= 	array();
		$AdsArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$AdsInfo = $MySmartBB->ads->GetAdsInfo($AdsArr);
		
		if ($AdsInfo == false)
		{
			$MySmartBB->functions->error('الاعلان المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($AdsInfo,'html');
	}
}

?>
