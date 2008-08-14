<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartModerators
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@hotmail.com>
 * @start 		: 	18/05/2008 04:53:56 PM 
 * @updated 	:	16/07/2008 11:47:00 PM 
 */

class MySmartModerators
{
	var $id;
	var $Engine;
	
	function MySmartModerators($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function InsertModerator($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['moderators'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
	}
			
 	function UpdateModerator($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           				 
		$query = $this->Engine->records->Update($this->Engine->table['moderators'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
 	 	
	function DeleteModerator($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['moderators'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
		
	function GetModeratorList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from']		=	$this->Engine->table['moderators'];
 		
		$rows = $this->Engine->records->GetList($param);
		
		return $rows;
	}
	
	function GetModeratorInfo($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from']		=	$this->Engine->table['moderators'];
		
		$rows = $this->Engine->records->GetInfo($param);
		
		return $rows;
	}
	
 	function GetModeratorsNumber($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['moderators'];
		
		$num   = $this->Engine->records->GetNumber($param);
		
		return $num;
 	}
 	
 	///
	
 	function CreateModeratorsCache($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$moderators = $this->GetModeratorList($param);
		
 		$cache 	= 	array();
 		$x		=	0;
 		$n		=	sizeof($moderators);
 		
		while ($x < $n)
		{
			$cache[$x] 					= 	array();
			$cache[$x]['id']		 	= 	$moderators[$x]['id'];
			$cache[$x]['section_id'] 	= 	$moderators[$x]['section_id'];
			$cache[$x]['member_id'] 	= 	$moderators[$x]['member_id'];
			$cache[$x]['username'] 		= 	$moderators[$x]['username'];
			
			$x += 1;
		}
		
		$cache = serialize($cache);
		
		return $cache;
 	}
 	
 	function IsModerator($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$InfoArr = array();
 		
 		if (isset($param['username']))
 		{
 			$InfoArr['where'][0] 			= 	array();
 			$InfoArr['where'][0]['name'] 	= 	'username';
 			$InfoArr['where'][0]['value'] 	= 	$param['username'];
 		}
 		elseif (isset($param['member_id']))
 		{
 			$InfoArr['where'][0] 			= 	array();
 			$InfoArr['where'][0]['name'] 	= 	'member_id';
 			$InfoArr['where'][0]['value'] 	= 	$param['member_id'];
 		}
 		
 		
 		$InfoArr['where'][1] 			= 	array();
 		$InfoArr['where'][1]['con'] 	= 	'AND';
 		$InfoArr['where'][1]['name'] 	= 	'section_id';
 		$InfoArr['where'][1]['value'] 	= 	$param['section_id'];
 		
 		$Info = $this->GetModeratorInfo($param);
 		
 		return is_array($Info) ? true : false;
 	}
}

?>
