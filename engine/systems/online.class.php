<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartOnline
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	4/4/2006 , 11:26 PM
 * @end   		: 	4/4/2006 , 11:38 PM
 * @updated 	: 	15/02/2010 02:42:43 PM 
 */

class MySmartOnline
{
	var $id;
	var $Engine;
	
	function MySmartOnline($Engine)
	{
		$this->Engine = $Engine;
	}
	
 	function InsertOnline($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		          			           
		$query = $this->Engine->records->Insert($this->Engine->table['online'],$param['field']);
		
		if ( isset( $param[ 'get_id' ] )
			and $param[ 'get_id' ] )
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
 	}
 	
 	function UpdateOnline($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
		           	   			
		$query = $this->Engine->records->Update($this->Engine->table['online'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
 	
 	function CleanOnlineTable($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['table'] = $this->Engine->table['online'];
 		
 		if (!empty($param['timeout']))
 		{
 			$param['where'] 			= 	array();
 			$param['where'][0] 			= 	array();
 			$param['where'][0]['name'] 	= 	'logged';
 			$param['where'][0]['oper']	=	'<';
 			$param['where'][0]['value']	=	$param['timeout'];
 		}
 		
 		$query = $this->Engine->records->Delete($param);
 		
 		return ($query) ? true : false;
 	}
 	
 	function GetOnlineList($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['online'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
 		
 		return $rows;
 	}
 	
 	function GetOnlineNumber($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['online'];
 		
 		$num = $this->Engine->records->GetNumber($param);
 		
 		return $num;
 	}
 	
 	function DeleteOnline($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['table'] = $this->Engine->table['online'];
 		
 		$query = $this->Engine->records->Delete($param);
 		
 		return ($query) ? true : false;
 	}
 	
 	function GetOnlineInfo( $param )
 	{
 		if ( !isset( $param )
 			or !is_array( $param ) )
 		{
 			$param = array();
 		}
 		
 		$x = 0;
 		
 		$param[ 'select' ] 	= 	'*';
 		$param[ 'from' ] 	= 	$this->Engine->table[ 'online' ];
 		
 		if ( isset( $param[ 'timeout' ] ) )
 		{
 			$param[ 'where' ] 					= 	array();
 			$param[ 'where' ][ $x ] 			= 	array();
 			$param[ 'where' ][ $x ][ 'name' ] 	= 	'logged';
 			$param[ 'where' ][ $x ][ 'oper' ] 	= 	'>=';
 			$param[ 'where' ][ $x ][ 'value' ] 	= 	$param[ 'timeout' ];
 			
 			$x += 1;
 		}
 		
 		if ( isset( $param[ 'username' ] ) )
 		{
 			$param[ 'where' ][ $x ] 				= 	array();
 			$param[ 'where' ][ $x ][ 'con' ] 		= 	'AND';
 			$param[ 'where' ][ $x ][ 'name' ] 		= 	'username';
 			$param[ 'where' ][ $x ][ 'oper' ] 		= 	'=';
 			$param[ 'where' ][ $x ][ 'value' ] 		= 	$param[ 'username' ];
 		}
 		
 		$rows = $this->Engine->records->GetInfo( $param );
 		
 		return $rows;
 	}
 	
 	function IsOnline($param)
 	{
 		if (empty($param['timeout']))
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM IsOnline() -- EMPTY timeout');
 		}
 		
 		$arr 						= 	array();
 		$arr['select'] 				= 	'*';
 		$arr['from'] 				= 	$this->Engine->table['online'];
 		$arr['where']				=	array();
 		
 		$arr['where'][0]			=	array();
 		$arr['where'][0]['name']	=	'logged';
 		$arr['where'][0]['oper']	=	'>=';
 		$arr['where'][0]['value']	=	$param['timeout'];
 		
 		if ($param['way'] == 'username')
 		{ 			
 			$arr['where'][1]			=	array();
 			$arr['where'][1]['con']		=	'AND';
 			$arr['where'][1]['name']	=	'username';
 			$arr['where'][1]['oper']	=	'=';
 			$arr['where'][1]['value']	=	$param['username'];
 		}
 		elseif ($param['way'] == 'ip')
 		{
 			$arr['where'][1]			=	array();
 			$arr['where'][1]['con']		=	'AND';
 			$arr['where'][1]['name']	=	'user_ip';
 			$arr['where'][1]['oper']	=	'=';
 			$arr['where'][1]['value']	=	$param['ip'];
 		}
 		else
 		{
 			return false;
 		}
 		
    	$num   = $this->Engine->records->GetNumber($arr);
    	 	
    	return ($num <= 0) ? false : true;
 	}
 	
 	///
 	
 	// TODO :: Add more basic functions here, it's important!
 	function CleanTodayTable($param)
 	{ 		
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['table'] = $this->Engine->table['today'];
 		
 		if (!empty($param['date']))
 		{
 			$param['where'] 			= 	array();
 			$param['where'][0] 			= 	array();
 			$param['where'][0]['name'] 	= 	'user_date';
 			$param['where'][0]['oper']	=	'<>';
 			$param['where'][0]['value']	=	$param['date'];
 		}
 		
 		$query = $this->Engine->records->Delete($param);
 		
 		return ($query) ? true : false;
 	}
 	
 	function IsToday($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 			= 	'*';
 		$param['from'] 				= 	$this->Engine->table['today'];
 		$param['where'] 			= 	array();
 		
 		if (!empty($param['username'])
 			and !empty($param['date']))
 		{
 			$param['where'][0] 			= 	array();
 			$param['where'][0]['name'] 	= 	'username';
 			$param['where'][0]['oper'] 	= 	'=';
 			$param['where'][0]['value'] = 	$param['username'];
 		
 			$param['where'][1] 			= 	array();
 			$param['where'][1]['con'] 	= 	'AND';
 			$param['where'][1]['name'] 	= 	'user_date';
 			$param['where'][1]['oper'] 	= 	'=';
 			$param['where'][1]['value'] = 	$param['date'];
 		}
 		
 		$num = $this->Engine->records->GetNumber($param);
 		
 		return ($num <= 0) ? false : true;
 	}
 	
 	function InsertToday($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['today'],$param['field']);
		
		if ( isset( $param[ 'get_id' ] )
			and $param[ 'get_id' ] )
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
 	}
 	
 	function GetTodayList($param)
 	{
  		if (!isset($param)
  			or !is_array($param))
 		{
 			$param = array();
 		}
 		
  		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['today'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
 		
 		return $rows;
 	}
 	
 	function GetTodayNumber($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['today'];
 		
 		$num = $this->Engine->records->GetNumber($param);
 		
 		return $num;
 	}
}

?>
