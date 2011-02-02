<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM			=	array();
$CALL_SYSTEM['PM'] 		= 	true;

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPrivateMassegeListMOD');

class MySmartPrivateMassegeListMOD
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
		
		/** Get the list of masseges **/
		if ($MySmartBB->_GET['list'])
		{
			$this->_showList();
		}
		/** **/
		
		$MySmartBB->func->getFooter();
	}
	
	/**
	 * Get the list of masseges
	 */
	private function _showList()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('قائمة الرسائل');
		
		if (empty($MySmartBB->_GET['folder']))
		{
			$MySmartBB->func->error('المعذره .. المسار المتبع غير صحيح');
		}
		
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		/* ... */
		
		$MySmartBB->rec->filter = ($MySmartBB->_GET['folder'] == 'inbox') ? 'user_to' : 'user_from';
		$MySmartBB->rec->filter .= "='" . $MySmartBB->_CONF['member_row']['username'] . "' AND folder='";
		$MySmartBB->rec->filter .= ($MySmartBB->_GET['folder'] == 'inbox') ? 'inbox' : 'sent';
		$MySmartBB->rec->filter .= "'";
		
		$number = $MySmartBB->pm->getPrivateMassegeNumber();
		
		/* ... */
		
		//$MsgArr['proc']['date'] 		= 	array('method'=>'date','store'=>'date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		
		$MySmartBB->_CONF['template']['res']['pmlist_res'] = '';
		
		// Pager setup
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$number;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=pm&amp;show=1';
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['pmlist_res'];
		
		if ($MySmartBB->_GET['folder'] == 'sent')
		{
			$GetMassegeList = $MySmartBB->pm->getSentList( $MySmartBB->_CONF['member_row']['username'] );
		}
		else
		{
			$GetMassegeList = $MySmartBB->pm->getInboxList( $MySmartBB->_CONF['member_row']['username'] );
		}
				
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->template->display('pm_list');
	}
}

?>
