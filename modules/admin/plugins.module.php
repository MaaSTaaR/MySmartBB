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
			
			if ( $MySmartBB->_GET[ 'control' ] )
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
			else if ( $MySmartBB->_GET[ 'uninstall' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_pluginUninstall();
				}
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
		
		// ... //
		// Step 1 : Inserts hooks into plugin_hooks table, that's indicates the plugin is active.
		// Step 2 : Calls "activate()" method of the plugin
		// Step 3 : Activates the plugin by set the value 1 to "active" field in "plugins" table
		//			This field is useful to show to the user the plugin is active, but out work actually
		//			relies on "plugin_hooks" table.
		// ... //
		
		$info = $this->_checkID();
		
		$obj = $MySmartBB->plugin->createPluginObject( $info[ 'path' ] );
		
		// Step 1.
		if ( $MySmartBB->plugin->insertHooks( $obj->hooks(), $info[ 'id' ], $info[ 'path' ] ) )
		{
			// Step 2 and 3.
			$activate = $MySmartBB->plugin->activatePlugin( $info[ 'path' ] );
			
			if ( $activate )
			{
				$MySmartBB->func->msg( 'تم تفعيل الإضافة' );
				$MySmartBB->func->move( 'admin.php?page=plugins&amp;control=1' );
			}
		}
	}
	
	private function _pluginDeactive()
	{
		global $MySmartBB;
		
		// ... //
		// Step 1 : Removes hooks from plugin_hooks table, that's indicates the plugin is not active.
		// Step 2 : Calls "deactivate()" method of the plugin
		// Step 3 : Deactivates the plugin by set the value 0 to "active" field in "plugins" table
		// ... //
		
		$info = $this->_checkID();
		
		// Step 1.
		if ( $MySmartBB->plugin->removeHooks( $info[ 'id' ] ) )
		{
			// Step 2 and 3.
			$deactivate = $MySmartBB->plugin->deactivatePlugin( $info[ 'path' ] );
			
			if ( $deactivate )
			{
				$MySmartBB->func->msg( 'تم تعطيل الإضافة' );
				$MySmartBB->func->move( 'admin.php?page=plugins&amp;control=1' );
			}
		}
	}
	
	private function _pluginUninstall()
	{
		global $MySmartBB;

		$info = $this->_checkID();
		
		if ( $MySmartBB->plugin->uninstallPlugin( $info[ 'id' ], $info[ 'path' ] ) )
		{
			$MySmartBB->func->msg( 'تم إلغاء تثبيت الإضافه' );
			$MySmartBB->func->move( 'admin.php?page=plugins&amp;control=1' );
		}
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
