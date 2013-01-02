<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'IN_ADMIN', true );

define( 'COMMON_FILE_PATH', dirname(__FILE__) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartNotesMOD' );

class MySmartNotesMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->loadLanguage( 'admin_notes' );
			
			$MySmartBB->template->display( 'header' );
			
			// No changes
			if ( $MySmartBB->_POST[ 'note' ] == $MySmartBB->_CONF[ 'info_row' ][ 'admin_notes' ] )
			{
				$MySmartBB->func->move( 'admin.php?page=index&left=1' );
			}
			else
			{
				$update = $MySmartBB->info->updateInfo( 'admin_notes', $MySmartBB->_POST[ 'note' ] );
				
				if ( $update )
				{
					$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
					$MySmartBB->func->move( 'admin.php?page=index&left=1' );
				}
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}
}

?>
