<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartMemberlistMOD');

class MySmartMemberlistMOD
{
	private $Section;
	
	public function run()
	{
		global $MySmartBB;
		
		/** Get the member information as list **/
		if ($MySmartBB->_GET['index'])
		{
			$this->_getMemberList();
		}
		/** **/
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
		
	private function _getMemberList()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('قائمة الاعضاء');
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		// Pager setup
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$MySmartBB->member->getMemberNumber();
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=member_list&amp;show=1&amp;id=' . $this->Section['id'];
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->order = "id ASC";
		
		$MySmartBB->member->getMemberList();

		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->template->display('show_memberlist');
	}
}
	
?>
