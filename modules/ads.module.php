<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartAdsPageMOD');

class MySmartAdsPageMOD
{
	function run()
	{
		global $MySmartBB;
			
		/** Go to ads site **/
		if ($MySmartBB->_GET['goto'])
		{
			$this->_GoToSite();
		}
		/** **/
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	/**
	 * Get the information of ads , then go to the site of ads
	 */
	function _GoToSite()
	{
		global $MySmartBB;
		
		// Show header, The parameter is the page title.
		$MySmartBB->functions->ShowHeader('الانتقال إلى موقع');
		
		// Clean _GET['id'] from strings and protect ourself
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		// Show the address bar, It's make the browse easy
		$MySmartBB->functions->AddressBar('الانتقال');
		
		// No id ! stop the page :)
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الرابط المتبع غير صحيح');
		}
		
		// Get Ads information
		$AdsArr 			= 	array();
		$AdsArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$AdsRows = $MySmartBB->ads->GetAdsInfo($AdsArr);
			
		// Clean the ads information from XSS dirty
		$MySmartBB->functions->CleanVariable($AdsRows,'html');
			
		// Ads isn't here !
		if (!$AdsRows)
		{
			$MySmartBB->functions->error('الاعلان المطلوب غير موجود !');
		}
		
		// New visitor
		$NewClickArr 			= 	array();
		$NewClickArr['clicks'] 	= 	$AdsRows['clicks'];
		$NewClickArr['where'] 	= 	array('id',$AdsRows['id']);
		
		$MySmartBB->ads->NewVisit($NewClickArr);
		
		// Go to the site
		$MySmartBB->functions->msg('يرجى الانتظار سوف يتم نقلك إلى الموقع التالي : ' . $AdsRows['sitename']);
		$MySmartBB->functions->goto($AdsRows['site']);
	}
}
	
?>
