<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM			=	array();
$CALL_SYSTEM['PAGES'] 	= 	true;

include('common.php');
	
define('CLASS_NAME','MySmartPagesMOD');
	
class MySmartPagesMOD extends _functions
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
		
		$MySmartBB->template->display('page_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['text']) 
			or empty($MySmartBB->_POST['name']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$PageArr 			= 	array();
		$PageArr['field']	=	array();
		
		$PageArr['field']['title'] 		= 	$MySmartBB->_POST['name'];
		$PageArr['field']['html_code'] 	= 	$MySmartBB->functions->CleanVariable($MySmartBB->_POST['text'],'unhtml');
				
		$insert = $MySmartBB->pages->InsertPage($PageArr);
		
		if ($insert)
		{
			$MySmartBB->functions->msg('تم اضافة الصفحه بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=pages&amp;control=1&amp;main=1');
		}
	}
	
	function _ControlMain()
	{
		global $MySmartBB;
		
		$PageArr 					= 	array();
		$PageArr['order']			=	array();
		$PageArr['order']['field']	=	'id';
		$PageArr['order']['type']	=	'DESC';
		$PageArr['proc'] 			= 	array();
		$PageArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['PagesList'] = $MySmartBB->pages->GetPagesList($PageArr);
		
		$MySmartBB->template->display('pages_main');
	}
	
	function _EditMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['Inf'],'html');
		
		$PageInfo['html_code'] = $MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['Inf']['html_code'],'unhtml');
		
		$MySmartBB->template->assign('Inf',$MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('page_edit');		
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($PageInfo);
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$PageArr 				= 	array();
		$PageArr['field']		=	array();
		
		$PageArr['field']['title'] 		= 	$MySmartBB->_POST['name'];
		$PageArr['field']['html_code'] 	= 	$MySmartBB->functions->CleanVariable($MySmartBB->_POST['text'],'unhtml');
		$PageArr['where']				=	array('id',$PageInfo['id']);
		
		$insert = $MySmartBB->pages->UpdatePage($PageArr);
		
		if ($insert)
		{
			$MySmartBB->functions->msg('تم تحديث الاعلان بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=pages&amp;control=1&amp;main=1');
		}
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('page_del');		
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($PageInfo);
		
		$DelArr 			= 	array();
		$DelArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$del = $MySmartBB->pages->DeletePage($DelArr);
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف الصفحه بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=pages&amp;control=1&amp;main=1');
		}
	}
}

class _functions
{
	function check_by_id(&$PageInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$PageArr 			= 	array();
		$PageArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$PageInfo = $MySmartBB->pages->GetPageInfo($PageArr);
		
		if ($PageInfo == false)
		{
			$MySmartBB->functions->error('الصفحه المطلوبه غير موجوده');
		}
		
		$MySmartBB->functions->CleanVariable($PageInfo,'html');
	}
}

?>
