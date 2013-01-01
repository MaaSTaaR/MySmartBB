<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('STOP_STYLE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartLogoutMOD');

class MySmartLogoutMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'logout' );
		
		if ( $MySmartBB->_GET[ 'index' ] )
		{
			$this->_startLogout();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}

	private function _startLogout()
	{
		global $MySmartBB;
		
		$logout = $MySmartBB->member->logout();
								
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'logout' ] );
		
		if ( $logout )
		{
		    $MySmartBB->plugin->runHooks( 'logout_success' );
		    
			$MySmartBB->template->display( 'logout_msg' );
			
      		$MySmartBB->func->move( $MySmartBB->func->getLastLocation() );
		}
	}
}
	
?>
