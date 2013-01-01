<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartSendMOD' );

class MySmartSendMOD
{
	private $memberInfo;
	
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'send' );
		
		// ... //
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
     		$MySmartBB->func->error( $MySmartBB->lang[ 'no_permission_for_visitors' ] );
     	
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'send_email' ] );
		
		if ( $MySmartBB->_GET[ 'member' ] )
		{
			$this->_commonCode();
			
			if ( $MySmartBB->_GET[ 'index' ] )
			{
				$this->_memberSendIndex();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_memberSendStart();
			}
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _memberSendIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ] = $this->memberInfo;
		
		$MySmartBB->template->display( 'send_email' );
	}
	
	private function _memberSendStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'title' ] ) or empty( $MySmartBB->_POST[ 'text' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$sent = $MySmartBB->func->mail(	$this->memberInfo[ 'email' ],
										$MySmartBB->_POST[ 'title' ],
										$MySmartBB->_POST[ 'text' ],
										$MySmartBB->_CONF[ 'member_row' ][ 'email' ] );
		
		if ( $sent )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'send_succeed' ] );
			$MySmartBB->func->move( 'index.php' );
		}
		else
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'send_failed' ] );
		}
	}
	
	private function _commonCode()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->select = 'id,username,email';
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$this->memberInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$this->memberInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_doesnt_exist' ] );
	}
}

?>
