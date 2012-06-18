<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('STOP_STYLE',true);
define('LOGIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartLoginMOD');

class MySmartLoginMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'login' );
		
		// Normal login
		if ( $MySmartBB->_GET[ 'login' ] )
		{
			$this->_startLogin();
		}
		// Login after register
		elseif ( $MySmartBB->_GET[ 'register_login' ] )
		{
			$this->_startLogin( true );
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _startLogin( $register_login = false )
	{
		global $MySmartBB;
		
		if ( !$register_login )
		{
			$username = trim( $MySmartBB->_POST[ 'username' ] );
			$password = trim( md5( $MySmartBB->_POST[ 'password' ] ) );
		}
		else
		{
			$username = trim( $MySmartBB->_GET[ 'username' ] );
			$password = trim( $MySmartBB->_GET[ 'password' ] );
		}
		
		if ( empty( $username ) or empty( $password ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$expire = ( isset( $MySmartBB->_POST[ 'temporary' ] ) and $MySmartBB->_POST[ 'temporary' ] == 'on' ) ? 0 : time() + 31536000;
		
		$isMember = $MySmartBB->member->loginMember( $username, $password, $expire );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'login' ] );
		
		if ( $isMember != false )
		{
			// ... //
			
			$MySmartBB->template->assign( 'username', $username );
			
			$MySmartBB->template->display( 'login_msg' );
			
			// ... //
			
			if ( $isMember[ 'style' ] != $isMember[ 'style_id_cache' ] )
			{
				$MySmartBB->rec->filter = "id='" . (int) $isMember[ 'style' ] . "'";
				
				$style_cache = $MySmartBB->style->createStyleCache( $isMember['style'] );
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
				$MySmartBB->rec->fields = array( 	'style_cache'	=>	$style_cache,
													'style_id_cache'	=>	$isMember['style']	);
				
				$MySmartBB->rec->filter = "id='" . (int) $isMember['id'] . "'";
				
				$update_cache = $MySmartBB->rec->update();
			}
			
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
			$MySmartBB->rec->filter = "user_ip='" . $MySmartBB->_CONF['ip'] . "'";
			
			$MySmartBB->rec->delete();
			
			// ... //
			
			$MySmartBB->plugin->runHooks( 'login_success' );
			
       		// ... //
      		
      		$move_to = 'index.php';
      		
      		if ( !$register_login )
      		{
				$url = parse_url( $MySmartBB->_SERVER[ 'HTTP_REFERER' ] );
		  		$url = $url[ 'query' ];
		  		$url = explode( '&', $url );
		  		$url = $url[ 0 ];

		 		$Y_url = explode( '/', $MySmartBB->_SERVER[ 'HTTP_REFERER' ] );
		  		$X_url = explode( '/', $MySmartBB->_SERVER[ 'HTTP_HOST' ] );
		  		
      			if ( $X_url[ 0 ] == $Y_url[ 2 ] )
      				if ( $url != 'page=logout' or empty( $url ) or $url != 'page=login' )
       					$move_to = $MySmartBB->_SERVER[ 'HTTP_REFERER' ];
      		}
      		
      		$MySmartBB->func->move( $move_to );
		}
		else
		{
		    $MySmartBB->plugin->runHooks( 'login_failed' );
		    
			$MySmartBB->func->msg( $MySmartBB->lang[ 'login_failed' ] );
		}
	}
}

?>
