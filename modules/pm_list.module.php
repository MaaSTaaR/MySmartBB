<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include('common.module.php');

define('CLASS_NAME','MySmartPrivateMassegeListMOD');

class MySmartPrivateMassegeListMOD
{
	private $folder;
	private $curr_page;
	
	public function run( $folder, $curr_page = 1 )
	{
		global $MySmartBB;
		
		$this->folder = $folder;
		$this->curr_page = (int) $curr_page;
		
		// ... //
		
		$MySmartBB->loadLanguage( 'pm_list' );
		
		// ... //
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		
		if ( !$MySmartBB->_CONF[ 'info_row' ][ 'pm_feature' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'pm_feature_stopped' ] );
		
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'use_pm' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_use_pm' ] );
		
		// ... //
		
		$MySmartBB->load( 'pm' );
		
		$this->_showList();		
	}
	
	private function _showList()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'pm_list' ] );
		
		// ... //
				
		$field = ( $this->folder == 'inbox' ) ? 'user_to' : 'user_from';
		$folder = ( $this->folder == 'inbox' ) ? 'inbox' : 'sent';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		$MySmartBB->rec->filter = $field . "='" . $MySmartBB->_CONF[ 'member_row' ][ 'username' ] . "' AND folder='" . $folder . "'";
		
		$number = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'pmlist_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		
		$MySmartBB->rec->pager 					= 	array();
		$MySmartBB->rec->pager[ 'total' ]		= 	$number;
		$MySmartBB->rec->pager[ 'perpage' ] 	= 	$MySmartBB->_CONF[ 'info_row' ][ 'perpage' ];
		$MySmartBB->rec->pager[ 'curr_page' ] 	= 	$this->curr_page;
		$MySmartBB->rec->pager[ 'prefix' ] 		= 	$MySmartBB->_CONF[ 'init_path' ] . 'pm_list/' . $this->folder . '/';
		
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'pmlist_res' ];
		
		if ( $this->folder == 'sent' )
		{
			$MySmartBB->template->assign( 'SENT_FOLDER', true );
			
			$GetMassegeList = $MySmartBB->pm->getSentList( $MySmartBB->_CONF[ 'member_row' ][ 'username' ] );
		}
		else
		{
			$MySmartBB->template->assign( 'INBOX_FOLDER', true );
			
			$GetMassegeList = $MySmartBB->pm->getInboxList( $MySmartBB->_CONF[ 'member_row' ][ 'username' ] );
		}
				
		$MySmartBB->template->assign( 'pager', $MySmartBB->pager->show() );
		
		$MySmartBB->rec->setInfoCallback( array( 'MySmartPrivateMassegeListMOD', 'rowsProcessCB' ) );
		
		$MySmartBB->plugin->runHooks( 'pm_list_main' );
		
		$MySmartBB->template->display( 'pm_list' );
		
		$MySmartBB->rec->removeInfoCallback();
	}
	
	public function rowsProcessCB( $row )
	{
		global $MySmartBB;
		
		$row[ 'date' ] = $MySmartBB->func->date( $row[ 'date' ] );
	}
}

?>
