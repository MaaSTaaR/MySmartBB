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
			else if ( $MySmartBB->_GET[ 'active' ] )
			{
				$this->_pluginActivate();
			}
			else if ( $MySmartBB->_GET[ 'deactive' ] )
			{
				$this->_pluginDeactive();
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
	
	private function _pluginActivate()
	{
		global $MySmartBB;
		
		$info = $this->_checkID();
		
		$obj = $MySmartBB->plugin->createPluginObject( $info[ 'path' ] );
		
		$this->insertHooks( $obj->hooks() );
			
		$obj->activate();
	}
	
	private function _pluginDeactive()
	{
		global $MySmartBB;
		
		$info = $this->_checkID();
		
		// ....
	}
	
	private function _checkID()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
		{
			$MySmartBB->func->error( 'المسار المتبع غير صحيح' );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'plugin' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$info = $MySmartBB->rec->getInfo();
		
		if ( $info == false )
		{
			$MySmartBB->func->error( 'الإضافه غير موجوده في قواعد البيانات' );
		}
		
		return $info;
	}
}

?>
