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
		require_once( 'plugins/' . $path . '/plugin.php' );
		
		$obj = new PLUGIN_CLASS_NAME;
		
		$info = $obj->info();
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
		$this->engine->rec->fields = array(		'title'	=>	$info[ 'title' ],
												'description'	=>	$info[ 'description' ],
												'author'		=>	$info[ 'author' ],
												'license'		=>	$info[ 'license' ],
												'path'			=>	$path	);
		
		$this->engine->rec->get_id = true;
		
		$insert = $this->engine->rec->insert();
		
		$id = $this->engine->rec->id;
		
		if ( $insert )
		{
			// Insert hooks into database
			foreach ( $hooks as $key => $hook )
			{
				$this->engine->rec->table = $this->engine->table[ 'hook' ];
				$this->engine->rec->fields = array(	'plugin_id'	=>	$id,
													'hook'		=>	$key,
													'function'	=>	$hook,
													'path'		=>	$path	);
													
				$insert = $this->engine->rec->insert();
				
				if ( $insert )
				{
					return true;
				}
			}
		}
		
		// ... //
	}
	
	public function runHooks( $hook )
	{
		// ~ Get hooks list ~ //
		
		$this->engine->rec->table = $this->engine->table[ 'hook' ];
		$this->engine->rec->filter = "hook='" . $hook . "'";
		
		$this->engine->rec->getList();
		
		while ( $row = $this->engine->rec->getInfo() )
		{
			require_once( 'plugins/' . $row[ 'path' ] . '/plugin.php' );
			
			$obj = new PLUGIN_CLASS_NAME;
			
			call_user_func( array( $obj, helloWorld ) );
		}
	}
}

?>
