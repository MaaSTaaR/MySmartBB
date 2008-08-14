<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM					=	array();
$CALL_SYSTEM['ANNOUNCEMENT'] 	= 	true;
$CALL_SYSTEM['ICONS'] 			= 	true;

include('common.php');

define('CLASS_NAME','MySmartAnnouncementMOD');

class MySmartAnnouncementMOD
{
	function run()
	{
		global $MySmartBB;
		
		/** Show the announcement **/
		if ($MySmartBB->_GET['show'])
		{
			$this->_ShowAnnouncement();
		}
		/** **/
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
			
		$MySmartBB->functions->GetFooter();
	}
		
	/** 
	 * Get the announcement and show it
	 */
	function _ShowAnnouncement()		
	{
		global $MySmartBB;
		
		// Show header with page title
		$MySmartBB->functions->ShowHeader('عرض الاعلان الاداري');
		
		// Clean the id from any strings
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$AnnArr 			= 	array();
		$AnnArr['where']	=	array('id',$MySmartBB->_GET['id']);
		
		// Get the announcement information
		$MySmartBB->_CONF['template']['AnnInfo'] = $MySmartBB->announcement->GetAnnouncementInfo($AnnArr);
		
		// Clean the information
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['AnnInfo'],'html');
		
		// No announcement , stop the page
		if (!$MySmartBB->_CONF['template']['AnnInfo'])
		{
			$MySmartBB->functions->error('الاعلان المطلوب غير موجود');
		}
		
		$MySmartBB->_CONF['template']['AnnInfo']['text'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['template']['AnnInfo']['text']);
		$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['AnnInfo']['text']);
		
		// We check if the "date" is saved as Unix stamptime, if true proccess it otherwise do nothing
		// We wrote these lines to ensure MySmartBB 2.x is compatible with MySmartBB's 1.x time save method
		if (is_numeric($MySmartBB->_CONF['template']['AnnInfo']['date']))
		{
			$MySmartBB->_CONF['template']['AnnInfo']['date'] = $MySmartBB->functions->date($MySmartBB->_CONF['template']['AnnInfo']['date']);
		}
		
		$MySmartBB->template->display('announcement');
	}
}
	
?>
