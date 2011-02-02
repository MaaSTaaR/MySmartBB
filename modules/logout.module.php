<?php

/** PHP5 **/

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
		
		if ( $MySmartBB->_GET[ 'index' ] )
		{
			$this->_startLogout();
		}
		else
		{
			$MySmartBB->func->error( 'المسار المتبع غير صحيح !' );
		}
		
		$MySmartBB->func->getFooter();
	}

	private function _startLogout()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->filter = "user_id='" . (int) $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$MySmartBB->rec->delete();
		
		// ... //
		
		// [WE NEED A SYSTEM]
		$logout = $MySmartBB->member->logout();
								
		$MySmartBB->func->showHeader( 'تسجيل خروج' );
		
		if ( $logout )
		{
			$MySmartBB->template->display('logout_msg');
			
			$url = parse_url( $MySmartBB->_SERVER[ 'HTTP_REFERER' ] );
      		$url = $url[ 'query' ];
      		$url = explode( '&', $url );
      		$url = $url[ 0 ];
      		
     		$Y_url = explode( '/', $MySmartBB->_SERVER[ 'HTTP_REFERER' ] );
      		$X_url = explode( '/', $MySmartBB->_SERVER[ 'HTTP_HOST' ] );
      		
      		if ( $url != 'page=logout' 
      			or empty( $url )
      			or $url != 'page=login' )
           	{
       			$MySmartBB->func->goto( $MySmartBB->_SERVER['HTTP_REFERER'] );
      		}

      		elseif ( $Y_url[ 2 ] != $X_url[ 0 ] 
      				or $url == 'page=logout' 
      				or $url == 'page=login' )
           	{
       			$MySmartBB->functions->goto( 'index.php' );
      		}
		}
	}
}
	
?>
