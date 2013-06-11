<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include('common.module.php');

define('CLASS_NAME','MySmartPrivateMassegeListMOD');

class MySmartPrivateMassegeListMOD
{
	private $folder;
	
	public function run( $folder )
	{
		global $MySmartBB;
		
		$this->folder = $folder;
		
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
		
		$MySmartBB->func->getFooter();
	}
	
	private function _showList()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'pm_list' ] );
		
		// ... //
		
		$MySmartBB->_GET[ 'count' ] = ( !isset( $MySmartBB->_GET[ 'count' ] ) ) ? 0 : $MySmartBB->_GET[ 'count' ];
		
		// ... //
		
		$field = ( $this->folder == 'inbox' ) ? 'user_to' : 'user_from';
		$folder = ( $this->folder == 'inbox' ) ? 'inbox' : 'sent';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		$MySmartBB->rec->filter = $field . "='" . $MySmartBB->_CONF[ 'member_row' ][ 'username' ] . "' AND folder='" . $folder . "'";
		
		$number = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'pmlist_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$number;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF[ 'info_row' ][ 'perpage' ];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET[ 'count' ];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=pm_list&amp;list=1&amp;folder=' . $this->folder;
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
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
