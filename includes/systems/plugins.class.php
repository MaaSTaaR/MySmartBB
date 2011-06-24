<?php

/*
 * @package : MySmartPlugins
 * @author : Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start : 30/09/2009 10:18:46 PM (GMT+3)
 * @last update : 
 * @under : GNU LGPL
*/


// Next TODO : use cache
class MySmartPlugins
{
	private $engine;
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	public function installPlugin( $path )
	{
		$obj = $this->createPluginObject();
		
		$plugin_info = $obj->info();
		$hooks = $obj->hooks();
		
		// ... //
		
		// ~ First we have to check if this plugin is already installed ~ //
		
		$this->engine->rec->table = $this->engine->table[ 'plugin' ];
		$this->engine->rec->filter = "path='" . $path . "'";
		
		$info = $this->engine->rec->getInfo();
		
		if ( $info != false )
		{
			return 'ERROR::ALREADY_INSTALLED';
		}
		
		// Insert the plugin to the active list of plugins
		$this->engine->rec->table = $this->engine->table[ 'plugin' ];
		$this->engine->rec->fields = array(		'title'	=>	$plugin_info[ 'title' ],
												'description'	=>	$plugin_info[ 'description' ],
												'author'		=>	$plugin_info[ 'author' ],
												'license'		=>	$plugin_info[ 'license' ],
												'path'			=>	$path,
												'active'		=>	1	);
		
		$this->engine->rec->get_id = true;
		
		$insert = $this->engine->rec->insert();
		
		$id = $this->engine->rec->id;
		
		if ( $insert )
		{
			// Insert hooks into database
			$this->insertHooks( $hooks );
			
			$obj->activate();
			
			return true;
		}
		
		// ... //
	}
	
	public function createPluginObject( $path )
	{
		require_once( 'plugins/' . $path . '/plugin.php' );
		
		return new PLUGIN_CLASS_NAME;
	}
	
	public function insertHooks( $hooks, $rebuild_cache = true )
	{
		foreach ( $hooks as $key => $hook )
		{
			if ( strstr( $hook, ',' ) != false )
			{
				$list = explode( ',', $hook );
				
				foreach ( $list as $element )
				{
					$this->insertHook( $id, $key, $element, $path );
				}
			}
			else
			{
				$this->insertHook( $id, $key, $hook, $path );
			}
		}
		
		if ( $rebuild_cache )
			$this->rebuildHooksCache();
	}
	
	private function insertHook( $plugin_id, $hook, $func, $path )
	{
		$this->engine->rec->table = $this->engine->table[ 'hook' ];
		$this->engine->rec->fields = array(		'plugin_id'	=>	$plugin_id,
												'hook'		=>	$hook,
												'function'	=>	$func,
												'path'		=>	$path	);
													
		$insert = $this->engine->rec->insert();
		
		return ( $insert ) ? true : false;
	}
	
	public function runHooks( $hook )
	{
		// ~ Check if there is any cache, so use it, otherwise get the list from database ~ //
		
		$cache = unserialize( $this->engine->func->cleanVariable( $this->engine->_CONF[ 'info_row' ][ 'hooks_cache' ], 'unhtml' ) );
		
		if ( is_array( $cache ) )
		{
			if ( is_array( $cache[ $hook ] ) )
			{
				foreach ( $cache[ $hook ] as $value )
				{
					$this->runPlugin( $value[ 'path' ], $value[ 'function' ] );
				}
			}
		}
		else
		{
			$this->rebuildHooksCache();
		}
	}
	
	private function runPlugin( $path, $func )
	{
		require_once( 'plugins/' . $path . '/plugin.php' );
		
		$obj = new PLUGIN_CLASS_NAME;
		
		call_user_func( array( $obj, $func ) );
	}
	
	public function rebuildHooksCache()
	{
		$cache = array();
		
		$this->engine->rec->table = $this->engine->table[ 'hook' ];
		
		$this->engine->rec->getList();
		
		while ( $row = $this->engine->rec->getInfo() )
		{
			$cache[ $row[ 'hook' ] ][] = $row;
		}
		
		$cache = serialize( $cache );
		
		$update = $this->engine->info->updateInfo( 'hooks_cache', $cache );
		
		return ( $update ) ? true : false;
	}
	
	public function activatePlugin( $path )
	{
		require_once( 'plugins/' . $path . '/plugin.php' );
		
		$obj = new PLUGIN_CLASS_NAME;
		
		$this->engine->rec->table = $this->engine->table[ 'plugin' ];
		$this->engine->rec->fields = array( 'active'	=>	1 );
		$this->engine->rec->filter = "path='" . $path . "'";
		
		$update = $this->engine->rec->update();
		
		if ( $update )
		{
			$obj->activate();
			
			return true;
		}
		
		return false;
	}
	
	public function deactivatePlugin( $path )
	{
		require_once( 'plugins/' . $path . '/plugin.php' );
		
		$obj = new PLUGIN_CLASS_NAME;
		
		$this->engine->rec->table = $this->engine->table[ 'plugin' ];
		$this->engine->rec->fields = array( 'active'	=>	0 );
		$this->engine->rec->filter = "path='" . $path . "'";
		
		$update = $this->engine->rec->update();
		
		if ( $update )
		{
			$obj->deactivate();
			
			return true;
		}
		
		return false;
	}
}

?>
