<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('STOP_STYLE',true);
define('LOGIN',true);

include('common.module.php');

define('CLASS_NAME','MySmartLoginMOD');

class MySmartLoginMOD
{
	private $username;
	private $password;
	
	public function run()
	{
		global $MySmartBB;
		
		$this->username = $MySmartBB->_POST[ 'username' ];
		$this->password = md5( $MySmartBB->_POST[ 'password' ] );
		
		$MySmartBB->loadLanguage( 'login' );
		
		$this->_startLogin();		
	}
	
	// Login after registeration
	public function register_login( $username, $password )
	{
		global $MySmartBB;
		
		$this->username = $MySmartBB->_GET[ 'username' ];
		$this->password = $MySmartBB->_GET[ 'password' ];
		
		$MySmartBB->loadLanguage( 'login' );
		
		$this->_startLogin( true );		
	}
	
	private function _startLogin( $register_login = false )
	{
		global $MySmartBB;
		
		// ... //
		
		$username = trim( $this->username );
		$password = trim( $this->password );

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
      	
      	$move_to = ( !$register_login ) ? $MySmartBB->func->getLastLocation() : '';
      	
      	$MySmartBB->func->move( $move_to );
	}
}

?>
