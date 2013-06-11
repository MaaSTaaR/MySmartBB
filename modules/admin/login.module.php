<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'STOP_STYLE', true );

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartLoginMOD' );

class MySmartLoginMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'admin_login' );
		
		if ( $MySmartBB->_GET[ 'login' ] )
		{
			$this->_startLogin();
		}
	}
	
	private function _startLogin()
	{
		global $MySmartBB;
		
		$username = trim( $MySmartBB->_POST[ 'username' ] );
		$password = md5( trim( $MySmartBB->_POST[ 'password' ] ) );
		
		if ( empty( $MySmartBB->_POST[ 'username' ] ) or empty( $MySmartBB->_POST[ 'password' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$IsMember = $MySmartBB->member->loginAdmin( $username, $password );
		
		if ( $IsMember )
			$MySmartBB->func->move( 'admin.php', false, 0 );
		else
			$MySmartBB->func->error( $MySmartBB->lang[ 'wrong_information' ] );
	}
}

?>
