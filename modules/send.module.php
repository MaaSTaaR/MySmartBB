<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartSendMOD' );

class MySmartSendMOD
{
	private $memberInfo;
	
	public function run( $id )
	{
		global $MySmartBB;
		
		$this->commonProcesses( $id );
			
		$MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ] = $this->memberInfo;
		
		$MySmartBB->template->display( 'send_email' );		
	}
	
	public function start( $id )
	{
		global $MySmartBB;
		
		$this->commonProcesses( $id );
		
		if ( empty( $MySmartBB->_POST[ 'title' ] ) or empty( $MySmartBB->_POST[ 'text' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$sent = $MySmartBB->func->mail(	$this->memberInfo[ 'email' ],
										$MySmartBB->_POST[ 'title' ],
										$MySmartBB->_POST[ 'text' ],
										$MySmartBB->_CONF[ 'member_row' ][ 'email' ] );
		
		if ( $sent )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'send_succeed' ] );
			$MySmartBB->func->move( '' );
		}
		else
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'send_failed' ] );
		}		
	}
	
	private function commonProcesses( $id )
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'send' );
		
		// ... //
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_permission_for_visitors' ] );
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'send_email' ] );
		
		// ... //
		
		$id = (int) $id;
		
		if ( empty( $id ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->select = 'id,username,email';
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $id . "'";
		
		$this->memberInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$this->memberInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_doesnt_exist' ] );
	}
}

?>
