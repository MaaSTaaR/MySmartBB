<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );
	
class MySmartSectionSortMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_sections_sort' );
		    
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_changeSort();
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _changeSort()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "parent='0'";
		
		$MySmartBB->rec->getList();
		
		$state = array();
		
		while ( $row = $MySmartBB->rec->getInfo() )
		{
			$name = 'order-' . $row[ 'id' ];
			
			$MySmartBB->rec->table	= 	$MySmartBB->table[ 'section' ];
			$MySmartBB->rec->fields	=	array( 'sort' => $MySmartBB->_POST[ $name ] );
			$MySmartBB->rec->filter = 	"id='" . $row[ 'id' ] . "'";
			
			$state[ $row[ 'id' ] ] = $MySmartBB->rec->update();
		}
		
		if ( in_array( false, $state ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'process_failed' ] );
		
		$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
		$MySmartBB->func->move('admin.php?page=sections&amp;control=1&amp;main=1');
	}
}

?>
