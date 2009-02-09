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

define('CLASS_NAME','MySmartPrivateMassegeShowMOD');

class MySmartPrivateMassegeShowMOD
{
	function run()
	{
		global $MySmartBB;
		
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
		
		/** Read a massege **/
		if ($MySmartBB->_GET['show'])
		{
			$this->_ShowMassege();
		}
		/** **/
		
		$MySmartBB->functions->GetFooter();
	}
	
	/**
	 * Get a massege information to show it
	 */
	function _ShowMassege()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('إرسال رساله خاصه');
		
		if (empty($MySmartBB->_GET['id']))		
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$MsgArr 			= 	array();
		$MsgArr['id'] 		= 	$MySmartBB->_GET['id'];
		$MsgArr['username'] = 	$MySmartBB->_CONF['member_row']['username'];
		
		$MySmartBB->_CONF['template']['MassegeRow'] = $MySmartBB->pm->GetPrivateMassegeInfo($MsgArr);
																		
		if (!$MySmartBB->_CONF['template']['MassegeRow'])
		{
			$MySmartBB->functions->error('الرساله المطلوبه غير موجوده');
		}
		
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['MassegeRow'],'html');
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['MassegeRow'],'sql');
		
		$get_list  = 'id,username,user_sig,user_country,user_gender,register_date';
		$get_list .= ',posts,user_title,avater_path,away,away_msg,hide_online';
		
		$SenderArr = array();
		
		$SenderArr['get'] 		= 	$get_list;
		$SenderArr['where']		=	array('username',$MySmartBB->_CONF['template']['MassegeRow']['user_from']);
		
		$MySmartBB->_CONF['template']['Info'] = $MySmartBB->member->GetMemberInfo($SenderArr);
																		
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['Info'],'html');
		
		$send_text = $MySmartBB->_CONF['template']['MassegeRow']['text'];
		
		if (is_numeric($MySmartBB->_CONF['template']['Info']['register_date']))
		{
			$MySmartBB->_CONF['template']['Info']['register_date'] = $MySmartBB->functions->date($MySmartBB->_CONF['template']['Info']['register_date']);
		}
		
		$MySmartBB->_CONF['template']['Info']['user_gender'] 	= 	str_replace('m','ذكر',$MySmartBB->_CONF['template']['Info']['user_gender']);
		$MySmartBB->_CONF['template']['Info']['user_gender'] 	= 	str_replace('f','انثى',$MySmartBB->_CONF['template']['Info']['user_gender']);
		$MySmartBB->_CONF['template']['MassegeRow']['title']	=	str_replace('رد :','',$MySmartBB->_CONF['template']['MassegeRow']['title']);
		$MySmartBB->_CONF['template']['MassegeRow']['text'] 	=	$MySmartBB->smartparse->replace($MySmartBB->_CONF['template']['MassegeRow']['text']);
		
		$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['MassegeRow']['text']);
		
		if (is_numeric($MySmartBB->_CONF['template']['MassegeRow']['date']))
		{
			$MassegeDate = $MySmartBB->functions->date($MySmartBB->_CONF['template']['MassegeRow']['date']);
			$MassegeTime = $MySmartBB->functions->time($MySmartBB->_CONF['template']['MassegeRow']['date']);
			
			$MySmartBB->_CONF['template']['MassegeRow']['date'] = $MassegeDate . ' ; ' . $MassegeTime;
		}
		
		$AttachArr 				= 	array();
		$AttachArr['where'] 	= 	array('pm_id',$MySmartBB->_GET['id']);
		
		// Get the attachment information
		$MySmartBB->_CONF['template']['while']['AttachList'] = $MySmartBB->attach->GetAttachList($AttachArr);
		
		if ($MySmartBB->_CONF['template']['while']['AttachList'] != false)
		{
			$MySmartBB->template->assign('ATTACH_SHOW',true);

			$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['while']['AttachList'],'html');
		}
		
		// The writer signture isn't empty 
		if (!empty($MySmartBB->_CONF['template']['Info']['user_sig']))
		{
			// So , use the SmartCode in it
			$MySmartBB->_CONF['template']['Info']['user_sig'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['template']['Info']['user_sig']);
			$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['Info']['user_sig']);
		}
		
		$MySmartBB->template->assign('send_title','رد : ' . $MySmartBB->_CONF['template']['MassegeRow']['title']);
		$MySmartBB->template->assign('send_text','[quote]' . $send_text . '[/quote]');
		$MySmartBB->template->assign('to',$MySmartBB->_CONF['template']['MassegeRow']['user_from']);
				
		$MySmartBB->functions->GetEditorTools();
		
		$OnlineArr 				= 	array();	
		$OnlineArr['way'] 		= 	'username';
		$OnlineArr['username'] 	= 	$MySmartBB->_CONF['template']['MassegeRow']['user_from'];
		$OnlineArr['timeout'] 	= 	$MySmartBB->_CONF['timeout'];
		
		$CheckOnline = $MySmartBB->online->IsOnline($OnlineArr);
											
		($CheckOnline) ? $MySmartBB->template->assign('status',"<font class='online'>متصل</font>") : $MySmartBB->template->assign('status',"<font class='offline'>غير متصل</font>");
		
		if (!$MySmartBB->_CONF['template']['MassegeRow']['user_read'])
		{
			$ReadArr 						= 	array();
			$ReadArr['where'] 				= 	array();
			
			$ReadArr['where'][0] 			= 	array();
			$ReadArr['where'][0]['name'] 	= 	'id';
			$ReadArr['where'][0]['oper'] 	= 	'=';
			$ReadArr['where'][0]['value'] 	= 	$MySmartBB->_GET['id'];
			
			$Read = $MySmartBB->pm->MakeMassegeRead($ReadArr);
			
			if ($Read)
			{
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
			}
		}
				
		$MySmartBB->template->display('usercp_menu');
		$MySmartBB->template->display('pm_show');
	}
}

?>
