<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM			=	array();
$CALL_SYSTEM['PM'] 		= 	true;

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPrivateMassegeListMOD');

class MySmartPrivateMassegeListMOD
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
		
		/** Get the list of masseges **/
		if ($MySmartBB->_GET['list'])
		{
			$this->_ShowList();
		}
		/** **/
		
		$MySmartBB->functions->GetFooter();
	}
	
	/**
	 * Get the list of masseges
	 */
	function _ShowList()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('قائمة الرسائل');
		
		if (empty($MySmartBB->_GET['folder']))
		{
			$MySmartBB->functions->error('المعذره .. المسار المتبع غير صحيح');
		}
		
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		//////////
		
		$NumArr 						= 	array();
		$NumArr['where'] 				= 	array();
		
		$NumArr['where'][0] 			= 	array();
		$NumArr['where'][0]['name'] 	= 	($MySmartBB->_GET['folder'] == 'inbox') ? 'user_to' : 'user_from';
		$NumArr['where'][0]['oper'] 	= 	'=';
		$NumArr['where'][0]['value'] 	= 	$MySmartBB->_CONF['member_row']['username'];
		
		$NumArr['where'][1] 			= 	array();
		$NumArr['where'][1]['con'] 		= 	'AND';
		$NumArr['where'][1]['name'] 	= 	'folder';
		$NumArr['where'][1]['oper'] 	= 	'=';
		$NumArr['where'][1]['value'] 	= 	($MySmartBB->_GET['folder'] == 'inbox') ? 'inbox' : 'sent';
		
		//////////
		
		$MsgArr = array();
		
		$MsgArr['username'] 			= 	$MySmartBB->_CONF['member_row']['username'];
		
		$MsgArr['proc'] 				= 	array();
		$MsgArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		$MsgArr['proc']['date'] 		= 	array('method'=>'date','store'=>'date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);

		$MsgArr['order']				=	array();
		$MsgArr['order']['field']		=	'id';
		$MsgArr['order']['type']		=	'DESC';
		
		// Pager setup
		$MsgArr['pager'] 				= 	array();
		$MsgArr['pager']['total']		= 	$MySmartBB->pm->GetPrivateMassegeNumber($NumArr);
		$MsgArr['pager']['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MsgArr['pager']['count'] 		= 	$MySmartBB->_GET['count'];
		$MsgArr['pager']['location'] 	= 	'index.php?page=pm&amp;show=1';
		$MsgArr['pager']['var'] 		= 	'count';
		
		if ($MySmartBB->_GET['folder'] == 'sent')
		{
			$GetMassegeList = $MySmartBB->pm->GetSentList($MsgArr);
		}
		else
		{
			$GetMassegeList = $MySmartBB->pm->GetInboxList($MsgArr);
		}
		
		$MySmartBB->_CONF['template']['while']['MassegeList'] = $GetMassegeList;
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->template->display('pm_list');
	}
}

?>
