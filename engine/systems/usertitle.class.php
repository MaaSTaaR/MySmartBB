<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartUsertitle
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	22/3/2006 , 5:05 PM
 * @end   		: 	22/3/2006 , 5:19 PM
 * @updated 	: 	17/07/2008 12:29:56 AM 
 */

class MySmartUsertitle
{
	var $id;
	var $Engine;
	
	function MySmartUsertitle($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function InsertUsertitle($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->Engine->records->Insert($this->Engine->table['usertitle'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;		
	}
	
	function GetUsertitleList($param)
	{
  		if (!isset($param)
  			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['usertitle'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
 		
 		return $rows;
	}
	
	function GetUsertitleInfo($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 	 	$param['select'] 	= 	'*';
 	 	$param['from'] 		= 	$this->Engine->table['usertitle'];
	 	
 	 	$rows = $this->Engine->records->GetInfo($param);
 	 	
 	 	return $rows; 	 	
	}
	
	function UpdateUsertitle($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 				           	   
		$query = $this->Engine->records->Update($this->Engine->table['usertitle'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
	}
	
	function DeleteUsertitle($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['usertitle'];
	
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	function GetUsertitleNumber($param)
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['usertitle'];
		
		$num = $this->Engine->records->GetNumber($param);
		
		return $num;
	}
}

?>
