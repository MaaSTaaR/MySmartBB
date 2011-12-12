<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_func',true);
define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartUserCPEmailMOD');

class MySmartUserCPEmailMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'usercp_control_email' ) ;
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		}
		
		if ( $MySmartBB->_GET[ 'main' ] )				
		{
			$this->_emailMain();
		}
		elseif ( $MySmartBB->_GET[ 'start' ] )
		{
			$this->_emailChange();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _emailMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'change_email' ] );
		
		$MySmartBB->template->display( 'usercp_control_email' );
	}
	
	private function _emailChange()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'execute_process' ] );
		
		$MySmartBB->func->addressBar( '<a href="index.php?page=usercp&index=1">' . $MySmartBB->lang[ 'template' ][ 'usercp' ] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $MySmartBB->lang[ 'execute_process' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "email='" .  $MySmartBB->_POST[ 'new_email' ]. "'";
		
		$EmailExists = $MySmartBB->rec->getNumber();
		
		if ( empty($MySmartBB->_POST['new_email']) 
			or empty($MySmartBB->_POST['password']) )
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		// ... //
		
		$MySmartBB->_POST['password'] = md5( trim( $MySmartBB->_POST[ 'password' ] ) );
		
		// ... //

		// Ensure if the password is correct or not
		$checkPasswordCorrect = $MySmartBB->member->checkMember( $MySmartBB->_CONF[ 'member_row' ][ 'username' ], $MySmartBB->_POST[ 'password' ] );
		
		if ( !$checkPasswordCorrect )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'wrong_password' ] );
		}
		
		// ... //
		
		if (!$MySmartBB->func->checkEmail($MySmartBB->_POST['new_email']))
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'wrong_email' ] );
		}
		if ( $EmailExists > 0 )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'exist_email' ] );
		}
		
		$MySmartBB->_POST['new_email'] = trim( $MySmartBB->_POST['new_email'] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'email'	=>	$MySmartBB->_POST['new_email']	);
		$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF['member_row']['id'] . "'";
				
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move( 'index.php?page=usercp_control_email&amp;main=1' );
		}
	}
}
