<?php

////////////

// MySmartBB Engine - The heart of this script
require_once(DIR . 'engine/Engine.class.php');

// General systems
require_once( DIR . 'includes/functions.class.php' );
require_once( DIR . 'includes/template.class.php' );
require_once( DIR . 'includes/template.compiler.class.php' );
require_once( DIR . 'includes/smartcodeparse.class.php' );
require_once( DIR . 'includes/plugins.class.php' );

////////////

class MySmartBB extends Engine
{
	////////////
	
	// General systems
	var $func;
	var $template;
	var $smartparse;
	var $plugin;
	
	////////////
	
	function __construct()
	{
		////////////
		
		$e = Engine::Engine();
		
		////////////
		
		if (!defined('INSTALL'))
		{
			$compiler = new MySmartTemplateCompiler( $this );
			
  			$this->template		=	new MySmartTemplate( $compiler );
  			$this->smartparse	=	new MySmartCodeParse;
  			$this->plugin		=	new MySmartPlugins;
  		}
  		
  		////////////
  		
  		if (defined('IN_ADMIN'))
  		{
  			$this->func = new MySmartAdminFunctions();
  		}
  		else
  		{
  			$this->func = new MySmartFunctions();
  		}
  		
  		////////////
  		
  		if (!is_bool($e)
  			and $e == 'ERROR::THE_TABLES_ARE_NOT_INSTALLED'
  			and !defined('INSTALL'))
  		{
  			$this->func->move('./setup/install/',0);
  			$this->func->stop(true);
  		}
  	}
  	
  	////////////
}

////////////

?>
