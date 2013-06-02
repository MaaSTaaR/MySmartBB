<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('STOP_STYLE',true);

include('common.module.php');

define('CLASS_NAME','MySmartLogoutMOD');

class MySmartLogoutMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'logout' );
		
		$logout = $MySmartBB->member->logout();
								
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'logout' ] );
		
		if ( $logout )
		{
		    $MySmartBB->plugin->runHooks( 'logout_success' );
		    
			$MySmartBB->template->display( 'logout_msg' );
			
      		$MySmartBB->func->move( $MySmartBB->func->getLastLocation() );
		}
		
		$MySmartBB->func->getFooter();
	}
}
	
?>
