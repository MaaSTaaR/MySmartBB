<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include('common.module.php');

define('CLASS_NAME','MySmartAdsPageMOD');

class MySmartAdsPageMOD
{
	private $id;
	
	public function run( $id )
	{
		global $MySmartBB;
		
		$this->id = (int) $id;
		
		$MySmartBB->loadLanguage( 'pages' );
		
		$this->_showPage();		
	}
	
	private function _showPage()
	{
		global $MySmartBB;
		
		// ... //
		
 		if ( empty( $this->id ) )
 			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pages' ];
		$MySmartBB->rec->filter = "id='" . $this->id . "'";
		
		$MySmartBB->_CONF[ 'template' ][ 'GetPage' ] = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$MySmartBB->_CONF[ 'template' ][ 'GetPage' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'page_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->_CONF[ 'template' ][ 'GetPage' ][ 'title' ] );
		
		$MySmartBB->_CONF[ 'template' ][ 'GetPage' ][ 'html_code'] = $MySmartBB->func->htmlDecode( $MySmartBB->_CONF[ 'template' ][ 'GetPage' ][ 'html_code' ] );
		
		$MySmartBB->plugin->runHooks( 'pages_start' );
		
		$MySmartBB->template->display( 'show_page' );
	}
}
	
?>
