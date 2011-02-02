<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['REQUEST'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartCReqMOD');

class MySmartCReqMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_index();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
			
		$MySmartBB->func->getFooter();
	}
	
	private function _index()
	{
		global $MySmartBB;
		
		// Show header with page title
		$MySmartBB->func->showHeader('إلغاء الطلب');
		
		$MySmartBB->func->addressBar('إلغاء الطلب');
		
		if (empty($MySmartBB->_GET['type']) 
			or empty($MySmartBB->_GET['code']))
		{
			$MySmartBB->func->error('الرابط المتبع غير صحيح');
		}
		
		$MySmartBB->_GET['type'] = (int) $MySmartBB->_GET['type'];
		$MySmartBB->_GET['code'] = trim( $MySmartBB->_GET['code'] );
		
		$MySmartBB->rec->filter = "type='" . $MySmartBB->_GET['type'] . "' AND random_url='" . $MySmartBB->_GET['code'] . "'";
		
		$CleanReq = $MySmartBB->request->deleteRequest();
			
		if ($CleanReq)
		{
			$MySmartBB->func->msg('تم الغاء الطلب بنجاح !');
			$MySmartBB->func->goto('index.php');
		}
	}
}

?>
