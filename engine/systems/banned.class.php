<?php

/** PHP5 **/

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartBanned
 * @copyright 	: 	Mohammed Q. Hussian <MaaSTaaR@gmail.com>
 * @start 		: 	17/3/2006 , 7:13 PM
 * @end   		: 	17/3/2006 , 7:19 PM
 * @updated 	: 	13/07/2010 04:08:47 AM 
 */
 
class MySmartBanned
{
	private $engine;
	
	public $id;
	public $get_id;
	
	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
 	/**
 	 * Know if the username is ban or not
 	 */
	public function isUsernameBanned( $username )
	{
		if ( !isset( $username ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM isUsernameBanned() -- EMPTY username',E_USER_ERROR);
		}
		
		$this->engine->rec->table = $this->engine->table['banned'];
 		
 		$this->engine->rec->filter = "text='" . $username . "' AND text_type='1'";
 		
    	$num = $this->engine->rec->getNumber();
    	 	
    	return ($num <= 0) ? false : true;
	}
 	
 	/* ... */
 	
 	/**
 	 * Know if the email is ban or not
 	 */
 	public function isEmailBanned( $email )
 	{
		if ( !isset( $email ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM isEmailBanned()',E_USER_ERROR);
		}
		
		$this->engine->rec->table = $this->engine->table['banned'];
 		
 		$this->engine->rec->filter = "text='" . $email . "' AND text_type='2'";
 		
    	$num = $this->engine->rec->getNumber();
    	 	
    	return ($num <= 0) ? false : true;
 	}
 	
 	/**
 	 * Know if the provider is ban or not

 	 */
 	public function isProviderBanned( $provider )
 	{
		if ( !isset( $provider ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM isProviderBanned()',E_USER_ERROR);
		}
		
		$this->engine->rec->table = $this->engine->table['banned'];
 		
 		$this->engine->rec->filter = "text='" . $provider . "' AND text_type='3'";
 		
    	$num = $this->engine->rec->getNumber();
    	 	
    	return ($num <= 0) ? false : true;
 	}
}
 
?>
