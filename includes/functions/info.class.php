<?php

/**
 * @package 	: 	MySmartInfo
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	20/1/2007 , 9:29 PM
 * @end   		: 	20/1/2007 , 9:33 PM
 * @updated		: 	03/07/2010 09:03:27 PM 
 */

class MySmartInfo
{
	private $engine;
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
 	public function updateInfo( $name, $value )
 	{
 		if ( !isset( $name )
 			or !isset( $value ) )
 		{
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM updateInfo() -- EMPTY name or value', E_USER_ERROR );
 		}
 		
		$this->engine->rec->table = $this->engine->table[ 'info' ];
		$this->engine->rec->fields = array(	'value'	=>	$value	);
		$this->engine->rec->filter = "var_name='" . $name . "'";
		
		$query = $this->engine->rec->update();
		           
		return ($query) ? true : false;
 	}
}

?>
