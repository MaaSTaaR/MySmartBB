<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include('common.module.php');

define('CLASS_NAME','MySmartMemberlistMOD');

class MySmartMemberlistMOD
{
	private $Section;
	
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'memberlist' );
		
		$this->_getMemberList();
		
		$MySmartBB->func->getFooter();
	}
		
	private function _getMemberList()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'memberlist' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		
		$members_num = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$MySmartBB->_CONF['template']['res']['member_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->result = 	&$MySmartBB->_CONF['template']['res']['member_res'];
		
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$members_num;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=member_list&amp;index=1';
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->order = "id ASC";
		
		$MySmartBB->rec->getList();
		
		// ... //

		$MySmartBB->template->assign( 'pager', $MySmartBB->pager->show() );
		
		$MySmartBB->plugin->runHooks( 'memberlist_start' );
		
		$MySmartBB->template->display( 'show_memberlist' );
	}
}
	
?>
