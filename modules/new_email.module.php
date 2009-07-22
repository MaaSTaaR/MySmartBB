<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['REQUEST'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartEmailMOD');

class MySmartEmailMOD
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
		
		$MySmartBB->functions->ShowHeader('إتمام عملية تغيير البريد الالكتروني');
		
		$MySmartBB->functions->AddressBar('إتمام عملية تغيير البريد الالكتروني');
		
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
		$ReqArr['type'] 		= 	2;
		$ReqArr['username'] 	= 	$MySmartBB->_CONF['member_row']['username'];
		
		$RequestInfo = $MySmartBB->request->GetRequestInfo($ReqArr);
		
		if (!$RequestInfo)
		{
			$MySmartBB->functions->error('المعذره الطلب غير موجود !');
		}
		
		$EmailArr 			= 	array();
		$EmailArr['field'] 	= 	array();
		
		$EmailArr['field']['email'] 	= 	$MySmartBB->_CONF['member_row']['new_email'];
		$EmailArr['where'] 				= 	array('id',$MySmartBB->_CONF['member_row']['id']);
		
		$UpdateEmail= $MySmartBB->member->UpdateMember($EmailArr);
		
		if ($UpdateEmail)
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح !');
			$MySmartBB->functions->goto('index.php');
		}
	}
}
	
?>
