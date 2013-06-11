<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

include('common.module.php');

define('CLASS_NAME','MySmartPrivateMassegeCPMOD');

class MySmartPrivateMassegeCPMOD
{
	public function run( $action )
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'pm_cp' );
		
		// ... //
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		
		if ( !$MySmartBB->_CONF[ 'info_row' ][ 'pm_feature' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'pm_feature_stopped' ] );
		
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'use_pm' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_use_pm' ] );
		
		// ... //
		
		$MySmartBB->load( 'pm' );
		
		if ( $action == 'delete' )
		{
			$this->_deletePrivateMassege();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _deletePrivateMassege()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'delete_process' ] );
		$MySmartBB->func->addressBar('<a href="' . $MySmartBB->_CONF[ 'init_path' ] . 'pm/inbox">' . $MySmartBB->lang[ 'template' ][ 'pm' ] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $MySmartBB->lang[ 'delete_process' ] );
		
		// ... //
		
		if ( !is_array( $MySmartBB->_POST[ 'delete_list' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_complete_process' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'pm_delete_start' );
		
		// ... //
		
		$k = 1;
		$array_size = sizeof( $MySmartBB->_POST[ 'delete_list' ] );
		
		$filter = "user_to='" . $MySmartBB->_CONF[ 'member_row' ][ 'username' ] . "' AND (";
		
		foreach ( $MySmartBB->_POST[ 'delete_list' ] as $key => $id )
		{
			$id = (int) $id;
			
			if ( empty( $id ) )
				continue;
				
			$filter .= "id='" . $id . "'";
			
			if ( $k++ != $array_size )
				$filter .= ' OR ';
			else
				$filter .= ')';
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		$MySmartBB->rec->filter = $filter;
		
		$del = $MySmartBB->rec->delete();
			
		if ( $del )
		{
			// ... //
			
			// Recount the number of new messages after the deletion
			
			$new_pm_num = $MySmartBB->pm->newMessageNumber( $MySmartBB->_CONF[ 'member_row' ][ 'username' ] );
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->fields = array(	'unread_pm'	=>	$new_pm_num	);
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
			
			$MySmartBB->rec->update();
			
			// ... //
			
			$MySmartBB->plugin->runHooks( 'pm_delete_success' );
			
			$MySmartBB->func->msg( $MySmartBB->lang[ 'delete_succeed' ] );
			$MySmartBB->func->move( 'pm_list/inbox' );
		}
	}
}
