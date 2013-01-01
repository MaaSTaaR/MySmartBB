<?php

// TODO : Audit this file

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPasswordMOD');

class MySmartPasswordMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'new_password' );
		
		if ( $MySmartBB->_GET[ 'index' ] )
		{
			$this->_index();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _index()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'change_password_process' ] );
		$MySmartBB->func->addressBar( $MySmartBB->lang[ 'change_password_process' ] );
		
		// ... //
		
		if ( empty( $MySmartBB->_GET[ 'code' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
		$MySmartBB->rec->filter = "random_url='" . $MySmartBB->_GET[ 'code' ] . "' AND request_type='1'";
		
		$RequestInfo = $MySmartBB->rec->getInfo();
		
		if ( !$RequestInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'request_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'new_password_start' );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $RequestInfo[ 'username' ] . "'";
		
		$memberInfo = $MySmartBB->rec->getInfo();
		
		if ( !$memberInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_doesnt_exist ' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'password'	=>	md5( $memberInfo[ 'new_password' ] ) );
		$MySmartBB->rec->filter = "id='" . $memberInfo[ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		// ... //
		
		if ( $update )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'email_msg' ];
			$MySmartBB->rec->filter = "id='5'";
				
			$messageInfo = $MySmartBB->rec->getInfo();
				
			$messageInfo[ 'text' ] = $MySmartBB->massege->messageProccess( 		$memberInfo['username'], 
																				$MySmartBB->_CONF['info_row']['title'], 
																				null, 
																				null, 
																				null, 
																				$memberInfo[ 'new_password' ],
																				$messageInfo['text'] );
				
			$send = $MySmartBB->func->mail(	$memberInfo['email'],
											$messageInfo['title'],
											$messageInfo['text'],
											$MySmartBB->_CONF['info_row']['send_email'] );
			
			if ( $send )
			{
				$MySmartBB->member->cleanNewPassword( $memberInfo[ 'id' ] );
			
		    	$MySmartBB->plugin->runHooks( 'new_password_success' );
		    
				$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
				$MySmartBB->func->move( 'index.php' );
			}
		}
	}
}
	
?>
