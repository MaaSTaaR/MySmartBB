<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartOnlineMOD');

class MySmartOnlineMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'online' );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'online' ] );
		
		if ( $MySmartBB->_GET[ 'show' ] )
		{
			$this->_show();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _show()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['res']['online_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->order = "id DESC";
		$MySmartBB->rec->result = 	&$MySmartBB->_CONF['template']['res']['online_res'];
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->rec->setInfoCallback( array( 'MySmartOnlineMOD', 'rowProcess' ) );
		
		$MySmartBB->plugin->runHooks( 'online_show_start' );
		
		$MySmartBB->template->display('online');
		
		$MySmartBB->rec->removeInfoCallback();
	}
	
	public function rowProcess( $row )
	{
		global $MySmartBB;
		
		$row[ 'username_style' ] = $MySmartBB->func->cleanVariable( $row[ 'username_style' ], 'unhtml' );
	}
}

?>
