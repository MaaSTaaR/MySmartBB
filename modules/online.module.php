<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

/*$CALL_SYSTEM				=	array();
$CALL_SYSTEM['REQUEST'] 	= 	true;
$CALL_SYSTEM['MESSAGE'] 	= 	true;*/

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartOnlineMOD');

class MySmartOnlineMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('المتواجدين حالياً');
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_show();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->GetFooter();
	}
	
	private function _show()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->online->getOnlineList();
		
		$MySmartBB->template->display('online');
	}	
}

?>
