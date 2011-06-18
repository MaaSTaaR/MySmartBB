<?php

define( 'PLUGIN_CLASS_NAME', 'HelloWorldPlugin' );

require_once( 'plugins/interface.class.php' );

class PLUGIN_CLASS_NAME implements PluginInterface
{
	public function info()
	{
		return array(	'title'			=>	'Hello World Plugin',
						'description'	=>	'The first plugin of MySmartBB',
						'author'		=>	'Mohammed Q. Hussain',
						'license'		=>	'GNU/GPL'	);
	}
	
	public function hooks()
	{
		return array( 'main_start' => 'HelloWorldPlugin::helloWorld' );
	}
	
	public function activate()
	{
		global $MySmartBB;
	}
	
	public function deactivate()
	{
	}
	
	public function helloWorld()
	{
		echo 'Hello World!';
	}
}

?>
