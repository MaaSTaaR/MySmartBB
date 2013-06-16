<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include('common.module.php');

define('CLASS_NAME','MySmartOnlineMOD');

class MySmartOnlineMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'online' );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'online' ] );
		
		$this->_show();		
	}
	
	private function _show()
	{
		global $MySmartBB;
		
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'onlinepage_allow' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_permission' ] );
		
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
