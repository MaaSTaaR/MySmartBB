<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartCReqMOD');

class MySmartCReqMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'cancel_requests' );
		
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
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'cancel_request' ] );
		$MySmartBB->func->addressBar( $MySmartBB->lang[ 'cancel_request' ] );
		
		$MySmartBB->plugin->runHooks( 'cancel_request_start' );
		
		// ... //
		
		if ( empty( $MySmartBB->_GET[ 'type' ] ) or empty( $MySmartBB->_GET[ 'code' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->_GET[ 'type' ] = (int) $MySmartBB->_GET[ 'type' ];
		$MySmartBB->_GET[ 'code' ] = trim( $MySmartBB->_GET[ 'code' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
		$MySmartBB->rec->filter = "request_type='" . $MySmartBB->_GET[ 'type' ] . "' AND random_url='" . $MySmartBB->_GET[ 'code' ] . "'";
		
		$del = $MySmartBB->rec->delete();
			
		if ( $del )
		{
		    $MySmartBB->plugin->runHooks( 'cancel_request_success' );
		    
			$MySmartBB->func->msg( $MySmartBB->lang[ 'request_canceled' ] );
			$MySmartBB->func->move( 'index.php' );
		}
		
		// ... //
	}
}

?>
