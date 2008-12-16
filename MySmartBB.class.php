<?php

////////////

// MySmartBB Engine
require_once(DIR . 'engine/Engine.class.php');
// General systems
require_once(DIR . 'includes/functions.class.php');
require_once(DIR . 'includes/template.class.php');
require_once(DIR . 'includes/smartcodeparse.class.php');

////////////

class MySmartBB extends Engine
{
	////////////
	
	// General systems
	var $functions;
	var $template;
	var $smartparse;
	
	////////////
	
	function MySmartBB()
	{
		////////////
		
		$e = Engine::Engine();
		
		////////////
		
		if (!defined('INSTALL'))
		{
  			$this->template		  	= 	new MySmartTemplate;
  			$this->smartparse	  	= 	new MySmartCodeParse;
  		}
  		
  		////////////
  		
  		if (defined('IN_ADMIN'))
  		{
  			$this->functions = new MySmartAdminFunctions();
  		}
  		else
  		{
  			$this->functions = new MySmartFunctions();
  		}
  		
  		////////////
  		
  		if (!is_bool($e)
  			and $e == 'ERROR::THE_TABLES_ARE_NOT_INSTALLED'
  			and !defined('INSTALL'))
  		{
  			$this->functions->goto('./setup/install/',0);
  			$this->functions->stop(true);
  		}
  	}
  	
  	////////////
}

////////////

?>
