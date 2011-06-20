<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartPluginMOD');
	
class MySmartPluginMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['control'])
			{
				$this->_controlMain();
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'plugin' ];
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('plugin_main');
	}
}

?>
