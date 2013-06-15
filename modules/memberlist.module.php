<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include('common.module.php');

define('CLASS_NAME','MySmartMemberlistMOD');

class MySmartMemberlistMOD
{
	private $Section;
	private $curr_page;
	
	public function run( $curr_page = 1 )
	{
		global $MySmartBB;
		
		$this->curr_page = (int) $curr_page;
		
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
		
		$MySmartBB->_CONF['template']['res']['member_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->result = 	&$MySmartBB->_CONF['template']['res']['member_res'];
		
		$MySmartBB->rec->pager 					= 	array();
		$MySmartBB->rec->pager[ 'total' ]		= 	$members_num;
		$MySmartBB->rec->pager[ 'perpage' ] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MySmartBB->rec->pager[ 'curr_page' ] 	= 	$this->curr_page;
		$MySmartBB->rec->pager[ 'prefix' ]		=	$MySmartBB->_CONF[ 'init_path' ] . 'member_list/';
		
		$MySmartBB->rec->order = "id ASC";
		
		$MySmartBB->rec->getList();
		
		// ... //

		$MySmartBB->template->assign( 'pager', $MySmartBB->pager->show() );
		
		$MySmartBB->plugin->runHooks( 'memberlist_start' );
		
		$MySmartBB->template->display( 'show_memberlist' );
	}
}
	
?>
