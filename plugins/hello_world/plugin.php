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
		return array( 	'main_after_header' 	=> 'helloWorld,helloWorld2',
						'main_before_footer'	=> 'byeWorld'	);
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
		echo 'Hello World!<br />';
	}
	
	public function helloWorld2()
	{
		echo '2 - Hello World!';
	}
	
	public function byeWorld()
	{
		echo 'Bye Bye World!';
	}
}

?>
