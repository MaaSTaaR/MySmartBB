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
		    $MySmartBB->loadLanguage( 'admin_plugins' );
		    
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
			else if ( $MySmartBB->_GET[ 'install' ] )
			{
				$this->_pluginInstall();
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		// ... //
		
		// ~ Gets the list of installed plugins ~ //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'plugin' ];
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		// ~ Get the list of plugins that can be installed ~ //
		
		// The array which contains the list of uninstalled plugins
		$uninstalled_list = array();
		
		$path = 'plugins/';
		
		$handle = @opendir( $path ); // Please PHP be quiet a little bit :-)
		
		if ( $handle )
		{
			while ( ( $file = readdir( $handle ) ) != false )
			{
				if ( $file == '.' 
					or $file == '..'
					or $file == '.svn'
					or is_file( $path . $file ) )
					continue;
				
				// TODO : This is a basic way to do the job, it's better to use cache or another way to improve the performance
				// It's a bad idea to query the database inside a loop :-( What if we have 100 uninstalled plugins? that's means 100 query!
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'plugin' ];
				$MySmartBB->rec->filter = "path='" . $file . "'";
				
				$check = $MySmartBB->rec->getNumber();
				
				if ( $check == 0 )
					$uninstalled_list[] = $file;
			}
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'plugins_dir_doesnt_exist' ] );
		}
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'uninstalled_list' ] = $uninstalled_list;
		
		$MySmartBB->template->display( 'plugin_main' );
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
				$MySmartBB->func->msg( $MySmartBB->lang[ 'plugin_enabled' ] );
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
				$MySmartBB->func->msg( $MySmartBB->lang[ 'plugin_disabled' ] );
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
			$MySmartBB->func->msg( $MySmartBB->lang[ 'plugin_uninstalled' ] );
			$MySmartBB->func->move( 'admin.php?page=plugins&amp;control=1' );
		}
	}
	
	private function _pluginInstall()
	{
		global $MySmartBB;
		
		$path = $MySmartBB->_GET[ 'path' ];
		
		$path = str_replace( 'http', '', $path ); // No Please :-(
		$path = str_replace( '.', '', $path );
		$path = str_replace( '..', '', $path );
		$path = str_replace( '/', '', $path );
		
		if ( empty( $path ) )
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		if ( !is_dir( 'plugins/' . $path ) )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'plugin_dir_doesnt_exist' ] );
		}
		
		// ~ We have to check if the plugin already installed or not ~ //
		$MySmartBB->rec->table = $MySmartBB->table[ 'plugin' ];
		$MySmartBB->rec->filter = "path='" . $path . "'";
		
		$check = $MySmartBB->rec->getNumber();
		
		if ( $check != 0 )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'plugin_already_installed' ] );
		}
		
		// ~ Install the plugin ~ //
		if ( $MySmartBB->plugin->installPlugin( $path ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'plugin_installed_enabled' ] );
			$MySmartBB->func->move( 'admin.php?page=plugins&amp;control=1' );
		}
		else
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'install_failed' ] );
		}
	}
	
	private function _checkID()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'plugin' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$info = $MySmartBB->rec->getInfo();
		
		if ( $info == false )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'plugin_doesnt_exist' ] );
		}
		
		return $info;
	}
}

?>
