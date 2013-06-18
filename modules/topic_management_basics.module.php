<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'STOP_FOOTER', true );

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartManagementBasicsMOD' );

class MySmartManagementBasicsMOD
{
	public function run( $id )
	{
		global $MySmartBB;
		
		$id = (int) $id;
	}
}

?>