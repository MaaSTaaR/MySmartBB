<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'IN_ADMIN', true );

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

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
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "parent<>'0'";
		$MySmartBB->rec->order = "sort ASC";
		
		$forums_res = &$MySmartBB->func->setResource();
		
		$MySmartBB->rec->getList();
		
		while ( $row = $MySmartBB->rec->getInfo( $forums_res ) )
		{
			$name = 'order-' . $row['id'];
			
			if ( $row[ 'order' ] != $MySmartBB->_POST[ $name ] )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
				$MySmartBB->rec->fields = array(	'sort'	=>	$MySmartBB->_POST[ $name ]	);
				$MySmartBB->rec->filter = "id='" . $row[ 'id' ] . "'";
				
				$update = $MySmartBB->rec->update();
				
				if ($update)
				{
					$cache = $MySmartBB->section->updateSectionsCache( $row[ 'parent' ] );
				}
				
				$s[ $row[ 'id' ] ] = ($update) ? 'true' : 'false';
			}

			$x += 1;
		}
		
		if ( in_array( 'false', $s ) )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'process_failed' ] );
		}
		else
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=forums&amp;control=1&amp;main=1');
		}
	}
}

?>
