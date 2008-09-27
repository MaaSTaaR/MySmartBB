<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartAttach
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	2/8/2006 , 1:14 PM
 * @updated 	: 	23/09/2008 01:49:20 AM 
 */

class MySmartAttach
{
	var $id;
	var $Engine;
	
	function MySmartAttach($Engine)
	{
		$this->Engine = $Engine;
	}
	
 	function InsertAttach($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
     			           
		$query = $this->Engine->records->Insert($this->Engine->table['attach'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
 	}
 	
 	function UpdateAttach($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->Engine->records->Update($this->Engine->table['attach'],$param['field'],$param['where']);
				
		return ($query) ? true : false;
 	}
 	
	function DeleteAttach($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['attach'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	function GetAttachList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['attach'];
		
		$rows = $this->Engine->records->GetList($param);
		
		return $rows;
	}
	
	function GetAttachNumber($param)
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['attach'];
		
		$num = $this->Engine->records->GetNumber($param);
		
		return $num;
	}
	
	function GetAttachInfo($param)
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from']		=	$this->Engine->table['attach'];
				
		$rows = $this->Engine->records->GetInfo($param);
		
		return $rows;
	}
}

?>
