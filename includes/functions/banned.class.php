<?php

/**
 * @package 	: 	MySmartBanned
 * @copyright 	: 	Mohammed Q. Hussian <MaaSTaaR@gmail.com>
 * @start 		: 	17/3/2006 , 7:13 PM
 * @updated 	: 	Thu 28 Jul 2011 10:27:35 AM AST 
 */
 
class MySmartBanned
{
	private $engine;
	private $table;

	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
		$this->table = $this->engine->table[ 'banned' ];
	}
	
	// ... //
	
	public function isUsernameBanned( $username )
	{
		if ( !isset( $username ) )
		{
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM isUsernameBanned() -- EMPTY username', E_USER_ERROR );
		}
		
		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->filter = "text='" . $username . "' AND text_type='1'";
 		
    	$num = $this->engine->rec->getNumber();
    	 	
    	return ( $num <= 0 ) ? false : true;
	}
 	
 	// ... //
 	
 	public function isEmailBanned( $email )
 	{
		if ( !isset( $email ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM isEmailBanned()',E_USER_ERROR);
		}
		
		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->filter = "text='" . $email . "' AND text_type='2'";
 		
    	$num = $this->engine->rec->getNumber();
    	 	
    	return ($num <= 0) ? false : true;
 	}
 	
 	// ... //
 	
 	public function isProviderBanned( $provider )
 	{
		if ( !isset( $provider ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM isProviderBanned()',E_USER_ERROR);
		}
		
		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->filter = "text='" . $provider . "' AND text_type='3'";
 		
    	$num = $this->engine->rec->getNumber();
    	 	
    	return ($num <= 0) ? false : true;
 	}
}
 
?>
