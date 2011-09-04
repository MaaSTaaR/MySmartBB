<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartAnnouncementMOD');

class MySmartAnnouncementMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->load( 'icon,toolbox' );
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_showAnnouncement();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
			
		$MySmartBB->func->getFooter();
	}
	
	private function _showAnnouncement()		
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('عرض الاعلان الاداري');
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'announcement' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$MySmartBB->_CONF['template']['AnnInfo'] = $MySmartBB->rec->getInfo();
		
		if (!$MySmartBB->_CONF['template']['AnnInfo'])
		{
			$MySmartBB->func->error('الاعلان المطلوب غير موجود');
		}
		
		// ... //
		
		// Where is the member now?
     	$MySmartBB->online->updateMemberLocation( 'يطلع على الاعلان الاداري : ' . $MySmartBB->_CONF['template']['AnnInfo']['title'] );
     	
     	// ... //
     	
     	// Change text format
		$MySmartBB->_CONF['template']['AnnInfo']['text'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['template']['AnnInfo']['text']);
		$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['AnnInfo']['text']);
		
     	// ... //
     	
		// We check if the "date" is saved as Unix stamptime, if true proccess it otherwise do nothing
		// We wrote these lines to ensure MySmartBB 2.x is compatible with MySmartBB's 1.x time save method
		if (is_numeric($MySmartBB->_CONF['template']['AnnInfo']['date']))
		{
			$MySmartBB->_CONF['template']['AnnInfo']['date'] = $MySmartBB->func->date($MySmartBB->_CONF['template']['AnnInfo']['date']);
		}

     	// ... //
     			
		$MySmartBB->template->display('announcement');
		
     	// ... //
	}
}
	
?>
