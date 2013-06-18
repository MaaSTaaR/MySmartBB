<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

// It's an ajax file. So don't show the footer
define( 'STOP_FOOTER', true );

include( 'common.module.php' );

class MySmartManagementMOD
{
	protected $subject_info;
	
	protected function run( $id )
	{
		global $MySmartBB;
	
		$MySmartBB->loadLanguage( 'management' );
		
		$MySmartBB->load( 'moderator' );
		
		// ... //
		
		if ( empty( $id ) )
			die( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $id . "'";
		
		$this->subject_info = $MySmartBB->rec->getInfo();
		
		if ( !$this->subject_info )
			die( $MySmartBB->lang[ 'subject_doesnt_exist' ] );
		
		// ... //
		
		if ( !$MySmartBB->moderator->moderatorCheck( $this->subject_info[ 'section' ] ) )
			die( $MySmartBB->lang[ 'no_permission' ] );
		
		// ... //
	}
}

?>