<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/*
 * @package 	: 	MySmartAvatar
 * @author 		: 	Mohammed Q. Hussian <MaaSTaaR@gmail.com>
 * @start 		: 	27/2/2006 , 8:00 PM
 * @end   		: 	27/2/2006 , 8:12 PM
 * @updated 	: 	16/07/2008 08:43:30 PM 
*/

class MySmartAvatar
{
	var $id;
	var $Engine;
	
	function MySmartAvatar($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function InsertAvatar($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->Engine->records->Insert($this->Engine->table['avatar'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
 	}
 	
	function UpdateAvatar($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->Engine->records->Update($this->Engine->table['avatar'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
 		
	function DeleteAvatar($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['avatar'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	/**
	 * Get avatar list from database
 	 *
 	 * $this->Engine->avatar->GetAvatarList(array $param);
 	 *
 	 * $param =
 	 *			array(	'sql_statment'	=>	'the complete of SQL statement',
 	 *					'proc'			=>	true // When you want to proccess the outputs
 	 *					);
 	 *
 	 * @return
 	 *			array -> of information
 	 *			false -> when found no information
 	 */
	function GetAvatarList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from']		=	$this->Engine->table['avatar'];
 		
		$rows = $this->Engine->records->GetList($param);
		
		return $rows;
	}
	
	/**
	 * Get avatar info
 	 *
 	 * $this->Engine->avatar->GetAvatarInfo(array $param);
 	 *
 	 * $param = 
 	 *			array('id'=>'The id of avatar');
 	 *
 	 * @return
 	 *				array -> of information
 	 *				false -> when no information found
 	 */
	function GetAvatarInfo($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from']		=	$this->Engine->table['avatar'];
		
		$rows = $this->Engine->records->GetInfo($param);
		
		return $rows;
	}
	
	function GetAvatarNumber($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['avatar'];
		
		$num   = $this->Engine->records->GetNumber($param);
		
		return $num;
	}
}

?>
