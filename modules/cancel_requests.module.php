<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['REQUEST'] 	= 	true;

include('common.php');

define('CLASS_NAME','MySmartCReqMOD');

class MySmartCReqMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_Index();
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
			
		$MySmartBB->functions->GetFooter();
	}
	
	function _Index()
	{
		global $MySmartBB;
		
		// Show header with page title
		$MySmartBB->functions->ShowHeader('إلغاء الطلب');
		
		$MySmartBB->functions->AddressBar('إلغاء الطلب');
		
		if (empty($MySmartBB->_GET['type']) 
			or empty($MySmartBB->_GET['code']))
		{
			$MySmartBB->functions->error('الرابط المتبع غير صحيح');
		}
		
		$MySmartBB->_GET['type'] = $MySmartBB->functions->CleanVarialbe($MySmartBB->_GET['type'],'intval');
		$MySmartBB->_GET['code'] = $MySmartBB->functions->CleanVarialbe($MySmartBB->_GET['code'],'trim');
		
		$CleanArr 			= 	array();
		$CleanArr['where'] 	= 	array();
		
		$CleanArr['where'][0]			=	array();
		$CleanArr['where'][0]['name'] 	= 	'type';
		$CleanArr['where'][0]['oper']	=	'=';
		$CleanArr['where'][0]['value']	=	$MySmartBB->_GET['type'];
		
		$CleanArr['where'][1]			=	array();
		$CleanArr['where'][1]['con']	=	'AND';
		$CleanArr['where'][1]['name'] 	= 	'random_url';
		$CleanArr['where'][1]['oper']	=	'=';
		$CleanArr['where'][1]['value']	=	$MySmartBB->_GET['code'];
		
		$CleanReq = $MySmartBB->request->DeleteRequest($CleanArr);
			
		if ($CleanReq)
		{
			$MySmartBB->functions->msg('تم الغاء الطلب بنجاح !');
			$MySmartBB->functions->goto('index.php');
		}
	}
}

?>
