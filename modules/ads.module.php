<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartAdsPageMOD');

class MySmartAdsPageMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['goto'])
		{
			$this->_goToSite();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _goToSite()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('الانتقال إلى موقع');

		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->func->addressBar('الانتقال');
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الرابط المتبع غير صحيح');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$AdsRows = $MySmartBB->rec->getInfo();
		
		if (!$AdsRows)
		{
			$MySmartBB->func->error('الاعلان المطلوب غير موجود !');
		}
		
		$MySmartBB->rec->filter = "id='" . $AdsRows['id'] . "'";
		
		// [WE NEED A SYSTEM]
		$MySmartBB->ads->newVisit( $AdsRows['clicks'] );
		
		$MySmartBB->func->msg('يرجى الانتظار سوف يتم نقلك إلى الموقع التالي : ' . $AdsRows['sitename']);
		$MySmartBB->func->goto($AdsRows['site']);
	}
}
	
?>
