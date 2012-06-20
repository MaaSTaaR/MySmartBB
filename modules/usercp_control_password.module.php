<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_func',true);
define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartUserCPPasswordMOD');

class MySmartUserCPPasswordMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'usercp_control_password' );
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		
		if ( $MySmartBB->_GET[ 'main' ] )				
		{
			$this->_passwordMain();
		}
		elseif ( $MySmartBB->_GET[ 'start' ] )
		{
			$this->_passwordChange();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _passwordMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'change_password' ] );
		
		$MySmartBB->plugin->runHooks( 'usercp_control_password_main' );
		
		$MySmartBB->template->display( 'usercp_control_password' );
	}
	
	private function _passwordChange()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'execute_process' ] );
		$MySmartBB->func->addressBar( '<a href="index.php?page=usercp&index=1">' . $MySmartBB->lang[ 'template' ][ 'usercp' ] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $MySmartBB->lang[ 'execute_process' ] );
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'old_password' ] ) or empty( $MySmartBB->_POST[ 'new_password'] ) )
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		// ... //
		
		$MySmartBB->_POST['old_password'] = md5( trim( $MySmartBB->_POST[ 'old_password' ] ) );
		$MySmartBB->_POST['new_password'] = md5( trim( $MySmartBB->_POST[ 'new_password' ] ) );
		
		// ... //

		// Ensure if the password is correct or not
		$checkPasswordCorrect = $MySmartBB->member->checkMember( $MySmartBB->_CONF[ 'member_row' ][ 'username' ], $MySmartBB->_POST[ 'old_password' ] );
		
		if ( !$checkPasswordCorrect )
			$MySmartBB->func->error( $MySmartBB->lang[ 'wrong_password' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'usercp_control_password_start' );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'password'	=>	$MySmartBB->_POST['new_password']	);
		$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF['member_row']['id'] . "'";
			
		$update = $MySmartBB->rec->update();

		if ( $update )
		{
		    $MySmartBB->plugin->runHooks( 'usercp_control_password_success' );
		    
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move( 'index.php?page=usercp_control_password&amp;main=1' );
		}
	}
}
