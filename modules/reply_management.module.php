<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

// It's an ajax file. So don't show the footer
define( 'STOP_FOOTER', true );

include( 'common.module.php' );

class MySmartReplyManagementMOD
{
	protected $reply_info;
	
	protected function run( $id )
	{
		global $MySmartBB;
	
		$MySmartBB->loadLanguage( 'management' );
		
		$MySmartBB->load( 'moderator' );
		
		// ... //
		
		if ( empty( $id ) )
			die( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->filter = "id='" . $id . "'";
		
		$this->reply_info = $MySmartBB->rec->getInfo();
		
		if ( !$this->reply_info )
			die( $MySmartBB->lang[ 'wrong_path' ] );
		
		// ... //
		
		if ( !$MySmartBB->moderator->moderatorCheck( $this->reply_info[ 'section' ] ) )
			die( $MySmartBB->lang[ 'no_permission' ] );
		
		// ... //
	}
}

?>