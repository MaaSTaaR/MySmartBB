<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartCReqMOD' );

class MySmartCReqMOD
{
	private $type;
	private $code;
	
	public function run( $type, $code )
	{
		global $MySmartBB;
		
		$this->type = (int) $type;
		$this->code = trim( $code );
		
		$MySmartBB->loadLanguage( 'cancel_requests' );
		
		$this->_index();			
	}
	
	private function _index()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'cancel_request' ] );
		$MySmartBB->func->addressBar( $MySmartBB->lang[ 'cancel_request' ] );
		
		$MySmartBB->plugin->runHooks( 'cancel_request_start' );
		
		// ... //
		
		if ( empty( $this->type ) or empty( $this->code ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
		$MySmartBB->rec->filter = "request_type='" . $this->type . "' AND random_url='" . $this->code . "'";
		
		$del = $MySmartBB->rec->delete();
			
		if ( $del )
		{
		    $MySmartBB->plugin->runHooks( 'cancel_request_success' );
		    
			$MySmartBB->func->msg( $MySmartBB->lang[ 'request_canceled' ] );
			$MySmartBB->func->move( '' );
		}
		
		// ... //
	}
}

?>
