<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'STOP_STYLE', true );

include( 'common.module.php' );	
define( 'CLASS_NAME', 'MySmartLogoutMOD' );
	
class MySmartLogoutMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
			setcookie( $MySmartBB->_CONF[ 'admin_username_cookie' ], '' );
			setcookie( $MySmartBB->_CONF[ 'admin_password_cookie' ], '' );
		
			$MySmartBB->func->move( 'admin.php', false, 0 );
		}
	}
}

?>
