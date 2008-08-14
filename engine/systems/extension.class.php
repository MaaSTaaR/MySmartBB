<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartFileExtension
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	22/3/2006 , 6:01 PM
 * @end   		: 	22/3/2006 , 6:22 PM
 * @updated 	: 	03/12/2007 12:04:22 AM 
 */

class MySmartFileExtension
{
	var $id;
	var $Engine;
	
	function MySmartFileExtension($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function InsertExtension($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		         			           
		$query = $this->Engine->records->Insert($this->Engine->table['extension'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
	}
	
	function GetExtensionList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}

 		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['extension'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
 		
 		return $rows; 		
	}
	
	function GetExtensionInfo($param)
	{		
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 	 	$param['select'] 	= 	'*';
 	 	$param['from'] 		= 	$this->Engine->table['extension'];
	 	
 	 	$rows = $this->Engine->records->GetInfo($param);
 	 	
 	 	return $rows;
	}
	
	function UpdateExtension($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
		
		$query = $this->Engine->records->Update($this->Engine->table['extension'],$param['field'],$param['where']);
		
		return ($query) ? true : false;
	}	
	
	function DeleteExtension($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['table'] = $this->Engine->table['extension'];
 		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
}

?>
