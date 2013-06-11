<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartUserCPEmailMOD' );

class MySmartUserCPEmailMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$this->commonProcesses();
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'change_email' ] );
		
		$MySmartBB->plugin->runHooks( 'usercp_control_email_main' );
		
		$MySmartBB->template->display( 'usercp_control_email' );
		
		$MySmartBB->func->getFooter();
	}
	
	public function start()
	{
		global $MySmartBB;
		
		$this->commonProcesses();
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'execute_process' ] );
		$MySmartBB->func->addressBar( '<a href="' . $MySmartBB->_CONF[ 'init_path' ] . 'usercp">' . $MySmartBB->lang[ 'template' ][ 'usercp' ] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $MySmartBB->lang[ 'execute_process' ] );
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'new_email' ] ) or empty( $MySmartBB->_POST[ 'password' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		if ( !$MySmartBB->func->checkEmail( $MySmartBB->_POST[ 'new_email' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'wrong_email' ] );
			
		// ... //
		
		$MySmartBB->_POST[ 'password' ] = md5( trim( $MySmartBB->_POST[ 'password' ] ) );
		
		// ... //
		
		$checkPasswordCorrect = $MySmartBB->member->checkMember( $MySmartBB->_CONF[ 'member_row' ][ 'username' ], $MySmartBB->_POST[ 'password' ] );
		
		if ( !$checkPasswordCorrect )
			$MySmartBB->func->error( $MySmartBB->lang[ 'wrong_password' ] );
		
		// ... //
		
		$MySmartBB->_POST[ 'new_email' ] = trim( $MySmartBB->_POST[ 'new_email' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "email='" .  $MySmartBB->_POST[ 'new_email' ]. "'";
		
		$EmailExists = $MySmartBB->rec->getNumber();
		
		if ( $EmailExists > 0 )
			$MySmartBB->func->error( $MySmartBB->lang[ 'exist_email' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'usercp_control_email_action_start' );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'email'	=>	$MySmartBB->_POST[ 'new_email' ]	);
		$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
				
		$update = $MySmartBB->rec->update();
		
		// ... //
		
		if ( $update )
		{
		    $MySmartBB->plugin->runHooks( 'usercp_control_email_action_success' );
		    
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move( 'usercp_control_email' );
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function commonProcesses()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'usercp_control_email' ) ;
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
	}
}
