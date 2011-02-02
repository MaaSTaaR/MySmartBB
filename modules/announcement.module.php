<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM					=	array();
$CALL_SYSTEM['ANNOUNCEMENT'] 	= 	true;
$CALL_SYSTEM['ICONS'] 			= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartAnnouncementMOD');

class MySmartAnnouncementMOD
{
	public function run()
	{
		global $MySmartBB;
		
		/** Show the announcement **/
		if ($MySmartBB->_GET['show'])
		{
			$this->_showAnnouncement();
		}
		/** **/
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
			
		$MySmartBB->func->getFooter();
	}
		
	/** 
	 * Get the announcement and show it
	 */
	private function _showAnnouncement()		
	{
		global $MySmartBB;
		
		// Show header with page title
		$MySmartBB->func->showHeader('عرض الاعلان الاداري');
		
		// Clean the id from any strings
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		// Get the announcement information
		$MySmartBB->_CONF['template']['AnnInfo'] = $MySmartBB->announcement->getAnnouncementInfo();
		
		// No announcement , stop the page
		if (!$MySmartBB->_CONF['template']['AnnInfo'])
		{
			$MySmartBB->func->error('الاعلان المطلوب غير موجود');
		}
		
		/* ... */
		
		// Where is the member now?
		if ($MySmartBB->_CONF['member_permission'])
     	{
			$MySmartBB->rec->fields = array(	'user_location'	=>	'يطلع على الاعلان الاداري : ' . $MySmartBB->_CONF['template']['AnnInfo']['title']	);
			$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
			
			$update = $MySmartBB->online->updateOnline();
     	}
     	
     	/* ... */
     	
     	// Change text format
		$MySmartBB->_CONF['template']['AnnInfo']['text'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['template']['AnnInfo']['text']);
		$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['AnnInfo']['text']);
		
     	/* ... */
     	
		// We check if the "date" is saved as Unix stamptime, if true proccess it otherwise do nothing
		// We wrote these lines to ensure MySmartBB 2.x is compatible with MySmartBB's 1.x time save method
		if (is_numeric($MySmartBB->_CONF['template']['AnnInfo']['date']))
		{
			$MySmartBB->_CONF['template']['AnnInfo']['date'] = $MySmartBB->func->date($MySmartBB->_CONF['template']['AnnInfo']['date']);
		}

     	/* ... */
     			
		$MySmartBB->template->display('announcement');
		
     	/* ... */
	}
}
	
?>
