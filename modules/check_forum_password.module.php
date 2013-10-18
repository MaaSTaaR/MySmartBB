<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartForumPasswordMOD' );

class MySmartForumPasswordMOD
{
	public function run( $id )
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'forum' );
		
		$MySmartBB->load( 'section' );
		
		$id = (int) $id;
		
		if ( empty( $id ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $id . "'";
		
		$section_info = $MySmartBB->rec->getInfo();
		
		if ( !$section_info )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forum_doesnt_exist' ] );
		
		if ( empty( $section_info[ 'section_password' ] ) )
			$MySmartBB->func->move( 'forum/' . $section_info[ 'id' ], false, 0 );
		
		// ... //
		
		$check = $MySmartBB->section->forumPassword( $section_info[ 'id' ], 
				$section_info[ 'section_password' ], 
				base64_encode( $MySmartBB->_POST[ 'password' ] ) );
		
		if ( $check )
			$MySmartBB->func->move( 'forum/' . $section_info[ 'id' ], false, 0 );
	}
}

?>