<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['REQUEST'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartActiveMOD');

class MySmartActiveMOD
{
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تفعيل العضويه');
		
		// The index page for active
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
		
		$MySmartBB->functions->AddressBar('تفعيل العضويه');
		
		// No code !
		if (empty($MySmartBB->_GET['code']))
		{
			$MySmartBB->functions->error('الرابط المتبع غير صحيح');
		}
		// This isn't member
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->functions->error('يرجى تسجيل دخولك اول');
		}
		
		$ReqArr = array();
		
		$ReqArr['code'] 	= 	$MySmartBB->_GET['code'];
		$ReqArr['type'] 	= 	3;
		$ReqArr['username'] = 	$MySmartBB->_CONF['member_row']['username'];
		
		// Get request information
		$RequestInfo = $MySmartBB->request->GetRequestInfo($ReqArr);
		
		// No request , so stop the page
		if (!$RequestInfo)
		{
			$MySmartBB->functions->error('المعذره الطلب غير موجود !');
		}
		
      	//////////
      	
      	// Get the information of default group to set username style cache
      	
		$GrpArr 			= 	array();
		$GrpArr['where'] 	= 	array('id',$MySmartBB->_CONF['info_row']['adef_group']);
		
		$GroupInfo = $MySmartBB->group->GetGroupInfo($GrpArr);
		
		$style = $GroupInfo['username_style'];
		$username_style_cache = str_replace('[username]',$MySmartBB->_CONF['member_row']['username'],$style);
		
      	//////////
      	
		$GroupArr 				= 	array();
		$GroupArr['field'] 		= 	array();
		
		$GroupArr['field']['usergroup'] 			= 	$MySmartBB->_CONF['info_row']['adef_group'];
		$GroupArr['field']['username_style_cache']	=	$username_style_cache;
		$GroupArr['where'] 							= 	array('id',$MySmartBB->_CONF['member_row']['id']);
			
		// We found the request , so active the member
		$UpdateGroup = $MySmartBB->member->UpdateMember($GroupArr);
		
		// The active is success
		if ($UpdateGroup)
		{	
			$MySmartBB->functions->msg('تم تفعيل عضويتك بنجاح , شكراً لك  !');
			$MySmartBB->functions->goto('index.php');
		}
	}
}
	
?>
