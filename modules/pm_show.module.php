<?php

/** PHP5 **/

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

define('CLASS_NAME','MySmartPrivateMassegeShowMOD');

class MySmartPrivateMassegeShowMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if (!$MySmartBB->_CONF['info_row']['pm_feature'])
		{
			$MySmartBB->func->error('المعذره .. خاصية الرسائل الخاصة موقوفة حاليا');
		}
		
		/** Can't use the private massege system **/
		if (!$MySmartBB->_CONF['group_info']['use_pm'])
		{
			$MySmartBB->func->error('المعذره .. لا يمكنك استخدام الرسائل الخاصه');
		}
		/** **/
		
		/** Visitor can't use the private massege system **/
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->func->error('المعذره .. هذه المنطقه للاعضاء فقط');
		}
		/** **/
		
		/** Read a massege **/
		if ($MySmartBB->_GET['show'])
		{
			$this->_showMassege();
		}
		/** **/
		
		$MySmartBB->func->getFooter();
	}
	
	/**
	 * Get a massege information to show it
	 */
	private function _showMassege()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('إرسال رساله خاصه');
		
		if (empty($MySmartBB->_GET['id']))		
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "' AND user_to='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		
		$MySmartBB->_CONF['template']['MassegeRow'] = $MySmartBB->pm->getPrivateMassegeInfo();
																		
		if (!$MySmartBB->_CONF['template']['MassegeRow'])
		{
			$MySmartBB->func->error('الرساله المطلوبه غير موجوده');
		}
		
		$MySmartBB->func->CleanVariable($MySmartBB->_CONF['template']['MassegeRow'],'sql');
		
		/* ... */
		
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF['template']['MassegeRow']['user_from'] . "'";
		
		$MySmartBB->_CONF['template']['Info'] = $MySmartBB->member->getMemberInfo();
		
		/* ... */
		
		$send_text = $MySmartBB->_CONF['template']['MassegeRow']['text'];
		
		if (is_numeric($MySmartBB->_CONF['template']['Info']['register_date']))
		{
			$MySmartBB->_CONF['template']['Info']['register_date'] = $MySmartBB->func->date($MySmartBB->_CONF['template']['Info']['register_date']);
		}
		
		$MySmartBB->_CONF['template']['Info']['user_gender'] 	= 	str_replace('m','ذكر',$MySmartBB->_CONF['template']['Info']['user_gender']);
		$MySmartBB->_CONF['template']['Info']['user_gender'] 	= 	str_replace('f','انثى',$MySmartBB->_CONF['template']['Info']['user_gender']);
		$MySmartBB->_CONF['template']['MassegeRow']['title']	=	str_replace('رد :','',$MySmartBB->_CONF['template']['MassegeRow']['title']);
		$MySmartBB->_CONF['template']['MassegeRow']['text'] 	=	$MySmartBB->smartparse->replace($MySmartBB->_CONF['template']['MassegeRow']['text']);
		
		$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['MassegeRow']['text']);
		
		if (is_numeric($MySmartBB->_CONF['template']['MassegeRow']['date']))
		{
			$MassegeDate = $MySmartBB->func->date($MySmartBB->_CONF['template']['MassegeRow']['date']);
			$MassegeTime = $MySmartBB->func->time($MySmartBB->_CONF['template']['MassegeRow']['date']);
			
			$MySmartBB->_CONF['template']['MassegeRow']['date'] = $MassegeDate . ' ; ' . $MassegeTime;
		}
		
		/* ... */
		
		$MySmartBB->_CONF['template']['res']['attach_res'] = '';
		
		$MySmartBB->rec->filter = "pm_id='" . $MySmartBB->_GET['id'] . "'";
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['attach_res'];
		
		// Get the attachment information
		$MySmartBB->_CONF['template']['while']['AttachList'] = $MySmartBB->attach->getAttachList();
		
		/*if ($MySmartBB->_CONF['template']['while']['AttachList'] != false)
		{
			$MySmartBB->template->assign('ATTACH_SHOW',true);
		}*/
		
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
				
		$MySmartBB->func->getEditorTools();
		
		/* ... */
		
		$CheckOnline = $MySmartBB->online->isOnline( $MySmartBB->_CONF['timeout'], 'username', $MySmartBB->_CONF['template']['MassegeRow']['user_from'] );
											
		($CheckOnline) ? $MySmartBB->template->assign('status',"<font class='online'>متصل</font>") : $MySmartBB->template->assign('status',"<font class='offline'>غير متصل</font>");
		
		/* ... */
		
		if (!$MySmartBB->_CONF['template']['MassegeRow']['user_read'])
		{
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
			
			$Read = $MySmartBB->pm->markMessageAsRead();
			
			if ($Read)
			{
				$Number = $MySmartBB->pm->newMessageNumber( $MySmartBB->_CONF['member_row']['username'] );
				
				$MySmartBB->rec->fields = array(	'unread_pm'	=>	$Number);
				$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
				
				$Cache = $MySmartBB->member->UpdateMember();
			}
		}
				
		$MySmartBB->template->display('usercp_menu');
		$MySmartBB->template->display('pm_show');
	}
}

?>
