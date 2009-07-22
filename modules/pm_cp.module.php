<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM					=	array();
$CALL_SYSTEM['PM'] 				= 	true;
$CALL_SYSTEM['ICONS'] 			= 	true;
$CALL_SYSTEM['TOOLBOX'] 		= 	true;
$CALL_SYSTEM['FILESEXTENSION'] 	= 	true;
$CALL_SYSTEM['ATTACH'] 			= 	true;

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPrivateMassegeCPMOD');

class MySmartPrivateMassegeCPMOD
{
	function run()
	{
		global $MySmartBB;
		
		if (!$MySmartBB->_CONF['info_row']['pm_feature'])
		{
			$MySmartBB->functions->error('المعذره .. خاصية الرسائل الخاصة موقوفة حاليا');
		}

		/** Can't use the private massege system **/
		if (!$MySmartBB->_CONF['rows']['group_info']['use_pm'])
		{
			$MySmartBB->functions->error('المعذره .. لا يمكنك استخدام الرسائل الخاصه');
		}
		/** **/
		
		/** Visitor can't use the private massege system **/
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->functions->error('المعذره .. هذه المنطقه للاعضاء فقط');
		}
		/** **/
		
		/** Conrol private masseges **/
		if ($MySmartBB->_GET['cp'])
		{
			/** Delete private massege **/
			if ($MySmartBB->_GET['del'])
			{
				$this->_DeletePrivateMassege();
			}
			/** **/
		}
		/** **/
		
		$MySmartBB->functions->GetFooter();
	}
	
	function _DeletePrivateMassege()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ عملية الحذف');
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$MySmartBB->functions->AddressBar('<a href="index.php?page=pm&amp;list=1&amp;folder=inbox">الرسائل الخاصه</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية الحذف');
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره المسار المتبع غير صحيح .');
		}
		
		$DelArr 			= 	array();
		$DelArr['user_to'] 	= 	true;
		$DelArr['username']	=	$MySmartBB->_CONF['member_row']['username'];
		$DelArr['id']		=	$MySmartBB->_GET['id'];
		
		$del = $MySmartBB->pm->DeleteFromSenderList($DelArr);
		
		if ($del)
		{
			// Recount the number of new messages after delete this message
			$NumArr 						= 	array();
			$NumArr['where'] 				= 	array();
		
			$NumArr['where'][0] 			= 	array();
			$NumArr['where'][0]['name'] 	= 	'user_to';
			$NumArr['where'][0]['oper'] 	= 	'=';
			$NumArr['where'][0]['value'] 	= 	$MySmartBB->_CONF['member_row']['username'];
		
			$NumArr['where'][1] 			= 	array();
			$NumArr['where'][1]['con'] 		= 	'AND';
			$NumArr['where'][1]['name'] 	= 	'folder';
			$NumArr['where'][1]['oper'] 	= 	'=';
			$NumArr['where'][1]['value'] 	= 	'inbox';
		
			$NumArr['where'][2] 			= 	array();
			$NumArr['where'][2]['con'] 		= 	'AND';
			$NumArr['where'][2]['name'] 	= 	'user_read';
			$NumArr['where'][2]['oper'] 	= 	'=';
			$NumArr['where'][2]['value'] 	= 	'0';
		
			$Number = $MySmartBB->pm->GetPrivateMassegeNumber($NumArr);
					      															
			$CacheArr 					= 	array();
			$CacheArr['field']			=	array();
			
			$CacheArr['field']['unread_pm'] 	= 	$Number;
			$CacheArr['where'] 					= 	array('username',$MySmartBB->_CONF['member_row']['username']);
			
			$Cache = $MySmartBB->member->UpdateMember($CacheArr);
			
			$MySmartBB->functions->msg('تم حذف الرساله بنجاح !');
			$MySmartBB->functions->goto('index.php?page=pm_list&list=1&folder=inbox');
		}
	}
}
