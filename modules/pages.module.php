<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartAdsPageMOD');

class MySmartAdsPageMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'pages' );
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_showPage();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _showPage()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pages' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
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
