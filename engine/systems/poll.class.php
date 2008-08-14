<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartPoll
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@hotmail.com>
 * @start 		: 	09/06/2008 03:47:00 AM 
 * @updated 	:	16/07/2008 11:54:12 PM 
 */

class MySmartPoll
{
	var $id;
	var $Engine;
	
	function MySmartPoll($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function InsertPoll($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['field']['answers'] = serialize($param['field']['answers']);
		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['poll'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
	}
			
 	function UpdatePoll($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['field']['answers'] = serialize($param['field']['answers']);
 			 
		$query = $this->Engine->records->Update($this->Engine->table['poll'],$$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
 	 	
	function DeletePoll($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['poll'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
		
	function GetPollList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from']		=	$this->Engine->table['poll'];
 		
		$rows = $this->Engine->records->GetList($param);
		
		return $rows;
	}
	
	function GetPollInfo($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from']		=	$this->Engine->table['poll'];
		
		$rows = $this->Engine->records->GetInfo($param);
		
		if (is_array($rows))
		{
			$rows['answers'] = unserialize($rows['answers']);
		}
		
		return $rows;
	}
		
 	function GetPollNumber($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['poll'];
		
		$num   = $this->Engine->records->GetNumber($param);
		
		return $num;
 	}
}

?>
