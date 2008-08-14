<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartPages
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	9/3/2006 , 8:31 PM
 * @end   		: 	9/3/2006 , 8:33 PM
 * @updated 	: 	16/07/2008 11:51:01 PM 
 */
 
class MySmartPages
{
	var $id;
	var $Engine;
	
	function MySmartPages($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function InsertPage($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['pages'],$field);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
	}
			
	function UpdatePage($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           	   
		$query = $this->Engine->records->Update($this->Engine->table['pages'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
	
	function DeletePage($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['pages'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
 	/**
 	 * Get page
 	 *
 	 * @param :
 	 *			id	->	the id of page
 	 */
	function GetPageInfo($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['pages'];

		$rows = $this->Engine->records->GetInfo($param);
 	 	
		return $rows;
	}
	
	function GetPagesList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['pages'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
 		
 		return $rows;
	}
	
	function GetPagesNumber()
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['pages'];
		
		$num = $this->Engine->records->GetNumber($param);
		
		return $num;
	}
}
 
?>
