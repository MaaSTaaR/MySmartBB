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
		    
			$MySmartBB->template->display('logout_msg');
			
			$move_to = 'index.php';
			
			if ( !empty( $MySmartBB->_SERVER[ 'HTTP_REFERER' ] ) )
			{
				$url = parse_url( $MySmartBB->_SERVER[ 'HTTP_REFERER' ] );
      			$url = $url[ 'query' ];
      			$url = explode( '&', $url );
      			$url = $url[ 0 ];
      		
     			$Y_url = explode( '/', $MySmartBB->_SERVER[ 'HTTP_REFERER' ] );
      			$X_url = explode( '/', $MySmartBB->_SERVER[ 'HTTP_HOST' ] );
      			
      			if ( $X_url[ 0 ] == $Y_url[ 2 ] )
      			{
      				if ( $url != 'page=logout' or empty( $url ) or $url != 'page=login' )
           			{
       					$move_to = $MySmartBB->_SERVER[ 'HTTP_REFERER' ];
      				}
      			}
      		}
      		
      		$MySmartBB->func->move( $move_to );
		}
	}
}
	
?>
