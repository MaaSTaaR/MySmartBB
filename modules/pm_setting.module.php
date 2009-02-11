<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM					=	array();
$CALL_SYSTEM['PM'] 				= 	true;
$CALL_SYSTEM['ICONS'] 			= 	true;
$CALL_SYSTEM['TOOLBOX'] 		= 	true;
$CALL_SYSTEM['FILESEXTENSION'] 	= 	true;
$CALL_SYSTEM['ATTACH'] 			= 	true;

define('JAVASCRIPT_SMARTCODE',true);

include('common.php');

define('CLASS_NAME','MySmartPrivateMassegeMOD');

class MySmartPrivateMassegeMOD
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
				
		if ($MySmartBB->_GET['setting'])
		{
			if ($MySmartBB->_GET['index'])
			{
				$this->_SettingIndex();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_SettingStart();
			}
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
					
		$MySmartBB->functions->GetFooter();
	}
			
	function _SettingIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('إعدادات الرسائل الخاصه');
		
		$MySmartBB->template->display('pm_setting');
	}
	
	function _SettingStart()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('إعدادات الرسائل الخاصه');
		
		if ($MySmartBB->_POST['autoreply']
			and (!isset($MySmartBB->_POST['title']) or !isset($MySmartBB->_POST['msg'])))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$UpdateArr 				= 	array();
		$UpdateArr['field']		=	array();
		
		$UpdateArr['field']['autoreply'] 		= 	$MySmartBB->_POST['autoreply'];
		$UpdateArr['field']['autoreply_title'] 	= 	$MySmartBB->_POST['title'];
		$UpdateArr['field']['autoreply_msg'] 	= 	$MySmartBB->_POST['msg'];
		$UpdateArr['field']['pm_senders'] 		= 	$MySmartBB->_POST['pm_senders'];
		$UpdateArr['field']['pm_senders_msg'] 	= 	$MySmartBB->_POST['pm_senders_msg'];
		$UpdateArr['where']						=	array('id',$MySmartBB->_CONF['member_row']['id']);
		
		$update = $MySmartBB->member->UpdateMember($UpdateArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث البيانات بنجاح');
			$MySmartBB->functions->goto('index.php?page=pm_setting&amp;setting=1&amp;index=1');
		}
	}
}

?>
