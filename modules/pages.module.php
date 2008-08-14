<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM			=	array();
$CALL_SYSTEM['PAGES'] 	= 	true;

include('common.php');

define('CLASS_NAME','MySmartAdsPageMOD');

class MySmartAdsPageMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_ShowPage();
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	function _ShowPage()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('عرض صفحه');
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$PageArr 			= 	array();
		$PageArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$MySmartBB->_CONF['template']['GetPage'] = $MySmartBB->pages->GetPageInfo($PageArr);
		
		if (!$MySmartBB->_CONF['template']['GetPage'])
		{
			$MySmartBB->functions->error('الصفحه المطلوبه غير متوفره');
		}
		
		$MySmartBB->template->display('show_page');
	}
}
	
?>
