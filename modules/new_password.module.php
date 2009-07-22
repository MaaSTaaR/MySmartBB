<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['REQUEST'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPasswordMOD');

class MySmartPasswordMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['index'])
		{
			$this->Index();
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	function Index()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('إتمام عملية تغيير كلمة المرور');
		
		$MySmartBB->functions->AddressBar('إتمام عملية تغيير كلمة المرور');
		
		if (empty($MySmartBB->_GET['code']))
		{
			$MySmartBB->functions->error('الرابط المتبع غير صحيح');
		}
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->functions->error('يرجى تسجيل دخولك اولاً');
		}
		
		$ReqArr = array();
		
		$ReqArr['code'] 		= 	$MySmartBB->_GET['code'];
		$ReqArr['type'] 		= 	1;
		$ReqArr['username'] 	= 	$MySmartBB->_CONF['member_row']['username'];
		
		$RequestInfo = $MySmartBB->request->GetRequestInfo($ReqArr);
		
		if (!$RequestInfo)
		{
			$MySmartBB->functions->error('المعذره الطلب غير موجود !');
		}
		
		$PassArr 			= 	array();
		$PassArr['field'] 	= 	array();
		
		$PassArr['field']['password'] 	= 	md5($MySmartBB->_CONF['member_row']['new_password']);
		$PassArr['where'] 				= 	array('id',$MySmartBB->_CONF['member_row']['id']);
		
		$UpdatePassword = $MySmartBB->member->UpdateMember($PassArr);
		
		$CleanArr 			= 	array();
		$CleanArr['id'] 	= 	$MySmartBB->_CONF['member_row']['id'];
		
		$CleanNewPassword = $MySmartBB->member->CleanNewPassword($CleanArr);
		
		if ($UpdatePassword)
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح !');
			$MySmartBB->functions->goto('index.php');
		}
	}
}
	
?>
