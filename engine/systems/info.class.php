<?php

/** PHP5 **/

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
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
	
	public function getSettingInfo( $param = null )
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 	 	
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->engine->table['info'];
		
		$rows = $this->engine->rec->GetList($param);
		
		return $rows;
	}
	
 	public function updateInfo( $name, $value )
 	{
 		if ( !isset( $name )
 			or !isset( $value ) )
 		{
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM UpdateInfo() -- EMPTY name or value', E_USER_ERROR );
 		}
 		
		$this->engine->rec->table = $this->engine->table['info'];
		$this->engine->rec->fields = array(	'value'	=>	$value	);
		$this->engine->rec->filter = "var_name='" . $name . "'";
		
		$query = $this->engine->rec->update();
		           
		return ($query) ? true : false;
 	}
}

?>
