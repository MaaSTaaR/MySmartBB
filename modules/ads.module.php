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
			
		/** Go to ads site **/
		if ($MySmartBB->_GET['goto'])
		{
			$this->_goToSite();
		}
		/** **/
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
	
	/**
	 * Get the information of ads , then go to the site of ads
	 */
	private function _goToSite()
	{
		global $MySmartBB;
		
		// Show header, The parameter is the page title.
		$MySmartBB->func->showHeader('الانتقال إلى موقع');
		
		// Clean _GET['id'] from strings and protect ourself
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		// Show the address bar, It's make the browse easy
		$MySmartBB->func->addressBar('الانتقال');
		
		// No id ! stop the page :)
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الرابط المتبع غير صحيح');
		}
		
		// Get Ads information
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$AdsRows = $MySmartBB->ads->getAdsInfo();
		
		// Ads isn't here !
		if (!$AdsRows)
		{
			$MySmartBB->func->error('الاعلان المطلوب غير موجود !');
		}
		
		// New visitor
		$MySmartBB->rec->filter = "id='" . $AdsRows['id'] . "'";
		
		$MySmartBB->ads->newVisit( $AdsRows['clicks'] );
		
		// Go to the site
		$MySmartBB->func->msg('يرجى الانتظار سوف يتم نقلك إلى الموقع التالي : ' . $AdsRows['sitename']);
		$MySmartBB->func->goto($AdsRows['site']);
	}
}
	
?>
