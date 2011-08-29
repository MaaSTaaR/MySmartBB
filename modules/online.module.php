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
		
		$MySmartBB->func->showHeader('المتواجدون حالياً');
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_show();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _show()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->rec->setInfoCallback( 'MySmartOnlineMOD::rowProcess' );
		
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
