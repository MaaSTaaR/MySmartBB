<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM			=	array();
$CALL_SYSTEM['PAGES'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartAdsPageMOD');

class MySmartAdsPageMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_showPage();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->GetFooter();
	}
	
	private function _showPage()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('عرض صفحه');
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$MySmartBB->_CONF['template']['GetPage'] = $MySmartBB->pages->getPageInfo();
		
		if (!$MySmartBB->_CONF['template']['GetPage'])
		{
			$MySmartBB->func->error('الصفحه المطلوبه غير متوفره');
		}
		
		$MySmartBB->template->display('show_page');
	}
}
	
?>
