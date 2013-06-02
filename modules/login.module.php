<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('STOP_STYLE',true);
define('LOGIN',true);

include('common.module.php');

define('CLASS_NAME','MySmartLoginMOD');

class MySmartLoginMOD
{
	public function login()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'login' );
		
		$this->_startLogin();
		
		$MySmartBB->func->getFooter();
	}
	
	// Login after registeration
	public function register_login()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'login' );
		
		$this->_startLogin( true );
		
		$MySmartBB->func->getFooter();
	}
	
// 	public function run()
// 	{
// 		global $MySmartBB;
		
// 		$MySmartBB->loadLanguage( 'login' );
		
// 		// Normal login
// 		if ( $MySmartBB->_GET[ 'login' ] )
// 		{
// 			$this->_startLogin();
// 		}
// 		// Login after registeration
// 		elseif ( $MySmartBB->_GET[ 'register_login' ] )
// 		{
// 			$this->_startLogin( true );
// 		}
// 		else
// 		{
// 			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
// 		}
		
// 		$MySmartBB->func->getFooter();
// 	}
	
	private function _startLogin( $register_login = false )
	{
		global $MySmartBB;
		
		// ... //
		
		$username = ( !$register_login ) ? $MySmartBB->_POST[ 'username' ] : $MySmartBB->_GET[ 'username' ];
		$password = ( !$register_login ) ? md5( $MySmartBB->_POST[ 'password' ] ) : $MySmartBB->_GET[ 'password' ];
		
		$username = trim( $username );
		$password = trim( $password );

		// ... //
		
		if ( empty( $username ) or empty( $password ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$expire = ( $MySmartBB->_POST[ 'temporary' ] == 'on' ) ? 0 : time() + 31536000;
		
		// ... //
		
		$isMember = $MySmartBB->member->loginMember( $username, $password, $expire );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'login' ] );
		
		if ( !$isMember )
		{
			$MySmartBB->plugin->runHooks( 'login_failed' );
			
			$MySmartBB->func->error( $MySmartBB->lang[ 'login_failed' ] );
		}
		
		// ... //
		
		$MySmartBB->template->assign( 'username', $username );
		$MySmartBB->template->display( 'login_msg' );
		
		// ... //
		
		if ( $isMember[ 'style' ] != $isMember[ 'style_id_cache' ] )			
			$MySmartBB->member->updateMemberStyleCache( $isMember[ 'style' ], $isMember );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->filter = "user_ip='" . $MySmartBB->_CONF[' ip' ] . "'";
		
		$MySmartBB->rec->delete();
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'login_success' );
		
       	// ... //
      	
      	$move_to = ( !$register_login ) ? $MySmartBB->func->getLastLocation() : 'index.php';
      	
      	$MySmartBB->func->move( $move_to );
	}
}

?>
