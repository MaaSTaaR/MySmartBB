<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartBookmark
 * @author 		: 	Ehab J. Ghazall <Ghazallsyria@gmail.com>
 * @start 		: 	15/2/2009 , 3:31 PM
 * @end   		: 	15/2/2009 , 4:12 PM
*/
 
class MySmartBookmark
{
	var $id;
	var $Engine;
	
	function MySmartBookmark($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function InsertSubject($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['subjects_bookmark'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
	}
			
	function UpdateSubject($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           	   
		$query = $this->Engine->records->Update($this->Engine->table['subjects_bookmark'],$param['field'],$param['where']);
		
		return ($query) ? true : false;
	}
	
	function DeleteSubject($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['subjects_bookmark'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	function GetSubjectInfo($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['subjects_bookmark'];

		$rows = $this->Engine->records->GetInfo($param);
 	 	
		return $rows;
	}
	
	function GetSubjectList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['subjects_bookmark'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
 		
 		return $rows;
	}
	
	function GetSubjectsNumber()
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['subjects_bookmark'];
		
		$num = $this->Engine->records->GetNumber($param);
		
		return $num;
	}
}
 
?>
