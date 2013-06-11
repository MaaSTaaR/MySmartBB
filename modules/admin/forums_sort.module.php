<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartForumsSortMOD' );
	
class MySmartForumsSortMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_forums_sort' );
		    
			$MySmartBB->load( 'section' );
			
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'change_sort' ] )
			{
				$this->_changeSort();
			}
		}
	}
	
	private function _changeSort()
	{
		global $MySmartBB;
		
		$state = array();
		$parents = array(); // Parents to be updated
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "parent<>'0'";
		$MySmartBB->rec->order = "sort ASC";
		
		$forums_res = &$MySmartBB->func->setResource();
		
		$MySmartBB->rec->getList();
		
		while ( $row = $MySmartBB->rec->getInfo( $forums_res ) )
		{
			$name = 'order-' . $row[ 'id' ];
						
			if ( $row[ 'sort' ] != $MySmartBB->_POST[ $name ] and isset( $MySmartBB->_POST[ $name ] ) )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
				$MySmartBB->rec->fields = array(	'sort'	=>	$MySmartBB->_POST[ $name ]	);
				$MySmartBB->rec->filter = "id='" . $row[ 'id' ] . "'";
				
				$update = $MySmartBB->rec->update();
				
				if ( $update )
					if ( !in_array( $row[ 'parent' ], $parents ) )
						$parents[] = $row[ 'parent' ];
				
				$state[ $row[ 'id' ] ] = ( $update ) ? true : false;
			}
		}
		
		foreach ( $parents as $parent )
			$MySmartBB->section->updateSectionsCache( $parent );
		
		if ( in_array( false, $state ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'process_failed' ] );
		
		$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
		$MySmartBB->func->move( 'admin.php?page=forums&amp;control=1&amp;main=1' );
	}
}

?>
