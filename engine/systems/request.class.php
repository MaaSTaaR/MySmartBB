<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartRequest
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	15/7/2006 , 12:50 AM
 * @end   		: 	15/7/2006 , 12:57 AM
 * @updated 	: 	17/07/2008 12:13:54 AM 
 */

class MySmartRequest
{
	var $id;
	var $Engine;
	
	function MySmartRequest($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function InsertRequest($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           	   		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['requests'],$param['field']);

		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
	}
	
	function GetRequestInfo($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['requests'];
		
		if (!empty($param['code']) 
			and !empty($param['type']) 
			and !empty($param['username']))
		{
			$param['where'] 				= 	array();
		
			$param['where'][0] 				= 	array();
			$param['where'][0]['name'] 		= 	'random_url';
			$param['where'][0]['oper'] 		= 	'=';
			$param['where'][0]['value'] 	= 	$param['code'];
		
			$param['where'][1] 				= 	array();
			$param['where'][1]['con'] 		= 	'AND';
			$param['where'][1]['name'] 		= 	'request_type';
			$param['where'][1]['oper'] 		= 	'=';
			$param['where'][1]['value'] 	= 	$param['type'];
		
			$param['where'][2] 				= 	array();
			$param['where'][2]['con'] 		= 	'AND';
			$param['where'][2]['name'] 		= 	'username';
			$param['where'][2]['oper'] 		= 	'=';
			$param['where'][2]['value'] 	= 	$param['username'];
		}
		
		$rows = $this->Engine->records->GetInfo($param);
		
		return $rows;
	}
	
	function DeleteRequest($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['requests'];
		
 		$query = $this->Engine->records->Delete($param);
 		
 		return ($query) ? true : false;
	}
}
 
 
?>
