<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include('common.php');

define('CLASS_NAME','MySmartMemberlistMOD');

class MySmartMemberlistMOD
{
	function run()
	{
		global $MySmartBB;
		
		/** Get the member information as list **/
		if ($MySmartBB->_GET['index'])
		{
			$this->_GetMemberList();
		}
		/** **/
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter();
	}
		
	function _GetMemberList()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('قائمة الاعضاء');
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$ListArr 						= 	array();
		
		// Order data
		$ListArr['order']				=	array();
		$ListArr['order']['field']		=	'id';
		$ListArr['order']['type']		=	'ASC';
		
		// Clean data from HTML
		$ListArr['proc'] 				= 	array();
		$ListArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		
		// Pager setup
		$ListArr['pager'] 				= 	array();
		$ListArr['pager']['total']		= 	$MySmartBB->member->GetMemberNumber(array('get_from'=>'db'));
		$ListArr['pager']['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$ListArr['pager']['count'] 		= 	$MySmartBB->_GET['count'];
		$ListArr['pager']['location'] 	= 	'index.php?page=member_list&amp;show=1&amp;id=' . $this->Section['id'];
		$ListArr['pager']['var'] 		= 	'count';
		
		$GetMemberList = $MySmartBB->member->GetMemberList($ListArr);
		
		$MySmartBB->_CONF['template']['while']['MemberList'] = $GetMemberList;
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->template->display('show_memberlist');
	}
}
	
?>
