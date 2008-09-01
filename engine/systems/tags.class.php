<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartTag
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	10/06/2008 03:56:35 AM 
 * @updated 	:	06/08/2008 02:40:01 AM 
 */

class MySmartTag
{
	var $id;
	var $Engine;
	
	function MySmartTag($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function InsertTag($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->Engine->records->Insert($this->Engine->table['tag'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
	}
	
 	function UpdateTag($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
		
		$query = $this->Engine->records->Update($this->Engine->table['tag'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
 	
	function DeleteTag($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['tag'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	function GetTagList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from']		=	$this->Engine->table['tag'];
 		
		$rows = $this->Engine->records->GetList($param);
		
		return $rows;
	}
	
	function GetTagInfo($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from']		=	$this->Engine->table['tag'];
		
		$rows = $this->Engine->records->GetInfo($param);
		
		return $rows;
	}
	
 	function GetTagNumber($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['tag'];
		
		$num   = $this->Engine->records->GetNumber($param);
		
		return $num;
 	}
 	
	///
	
	function InsertSubject($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->Engine->records->Insert($this->Engine->table['tag_subject'],$param['field']);
		
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
 			 
		$query = $this->Engine->records->Update($this->Engine->table['tag_subject'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
 	
	function DeleteSubject($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['tag_subject'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
		
	function GetSubjectList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from']		=	$this->Engine->table['tag_subject'];
 		
		$rows = $this->Engine->records->GetList($param);
		
		return $rows;
	}
		
	function GetSubjectInfo($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from']		=	$this->Engine->table['tag_subject'];
		
		$rows = $this->Engine->records->GetInfo($param);
		
		return $rows;
	}
	
 	function GetSubjectNumber($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['tag_subject'];
		
		$num   = $this->Engine->records->GetNumber($param);
		
		return $num;
 	}
}

?>
