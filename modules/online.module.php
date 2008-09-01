<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

/*$CALL_SYSTEM				=	array();
$CALL_SYSTEM['REQUEST'] 	= 	true;
$CALL_SYSTEM['MESSAGE'] 	= 	true;*/

include('common.php');

define('CLASS_NAME','MySmartOnlineMOD');

class MySmartOnlineMOD
{
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('المتواجدين حالياً');
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_Show();
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	function _Show()
	{
		global $MySmartBB;
		
		$OnlineArr = array();
		$OnlineArr['order'] = array();
		$OnlineArr['order']['field'] = 'id';
		$OnlineArr['order']['type'] = 'DESC';
		
		$MySmartBB->_CONF['template']['while']['Online'] = $MySmartBB->online->GetOnlineList($OnlineArr);
		
		$MySmartBB->template->display('online');
	}	
}

?>
