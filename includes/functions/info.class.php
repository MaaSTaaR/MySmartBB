<?php

/**
 * @package 	: 	MySmartInfo
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	20/1/2007 , 9:29 PM
 * @end   		: 	20/1/2007 , 9:33 PM
 * @updated		: 	Thu 09 Feb 2012 06:53:33 AM AST 
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
 		if ( empty( $name )
 			or ( empty( $value ) and $value != 0 ) )
 		{
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM updateInfo() -- EMPTY name or value', E_USER_ERROR );
 		}
 		
		$this->engine->rec->table = $this->engine->table[ 'info' ];
		$this->engine->rec->fields = array(	'value'	=>	$value	);
		$this->engine->rec->filter = "var_name='" . $name . "'";
		
		$query = $this->engine->rec->update();
		           
		return ($query) ? true : false;
 	}
 	
 	public function insertInfo( $name, $value = null )
 	{
 		if ( empty( $name ) )
 		    trigger_error( 'ERROR::NEED_PARAMETER -- FROM insertInfo() -- EMPTY name', E_USER_ERROR );
 		
 		if ( $this->isExist( $name ) )
 		    trigger_error( 'ERROR::THE_KEY_IS_ALREADY_USED -- FROM insertInfo()', E_USER_ERROR );
 		
 		$value = ( !is_null( $value ) ) ? $value : '0';
 		
 		$this->engine->rec->table = $this->engine->table[ 'info' ];
		$this->engine->rec->fields = array(	'var_name'  =>  $name,
		                                    'value'	=>	$value	);
		
		$query = $this->engine->rec->insert();
		           
		return ( $query ) ? true : false;
 	}
 	
 	public function isExist( $name )
 	{
 		if ( empty( $name ) )
 		    trigger_error( 'ERROR::NEED_PARAMETER -- FROM isExist() -- EMPTY name', E_USER_ERROR ); 	    
 	
 	    $this->engine->rec->table = $this->engine->table[ 'info' ];
 	    $this->engine->rec->filter = "var_name='" . $name . "'";
 	    
 	    $number = $this->engine->rec->getNumber();
 	    
 	    return ( $number <= 0 ) ? false : true;
 	}
 	
 	public function removeInfo( $name )
 	{
 		if ( empty( $name ) )
 		    trigger_error( 'ERROR::NEED_PARAMETER -- FROM removeInfo() -- EMPTY name', E_USER_ERROR );
 		
		$this->engine->rec->table = $this->engine->table[ 'info' ];
		$this->engine->rec->filter = "var_name='" . $name . "'";
		
		$query = $this->engine->rec->delete();
		           
		return ( $query ) ? true : false;
 	}
}

?>
