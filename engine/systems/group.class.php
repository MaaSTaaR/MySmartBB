<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartGroup
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	5/4/2006 , 6:07 PM
 * @end   		: 	5/4/2006 , 6:11 PM
 * @updated 	: 	03/08/2008 03:07:51 AM 
 */

class MySmartGroup
{
	var $id;
	var $Engine;
	
	function MySmartGroup($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function InsertGroup($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
		           	  		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['group'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
	}
	
	function DeleteGroup($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['group'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	function UpdateGroup($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           	  
		$query = $this->Engine->records->Update($this->Engine->table['group'],$param['field'],$param['where']);
		
		return ($query) ? true : false;
	}

	/**
	 * Get group information
	 *
	 * $param =
	 * 			array('group_id or id'=>'the id of member group');
	 *
	 * @return
	 *			array -> or information
	 *			false -> when no information
	 */
	function GetGroupInfo($param)
 	{
  		if (!isset($param) 
  			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['group'];
		
 		$rows = $this->Engine->records->GetInfo($param);
 		
 		return $rows;
 	}
 	
  	/**
 	 * Get the list of groups
 	 *
 	 * @param :
 	 *			sql_statment	->	complete the sql statment
 	 *			way				->	(normal) or (online_table)
 	 */
 	function GetGroupList($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['group'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
 		
 		return $rows;
 	}
 	
	function GetGroupNumber($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['group'];
		
		$num = $this->Engine->records->GetNumber($param);
		
		return $num;
 	}
 	
 	///
	
	function CreateSectionGroupCache($param)
	{
  		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$cache = array();
 		
 		$GroupArr 						= 	array();
 		$GroupArr['get_from'] 			= 	'db';
 		
 		$GroupArr['order']				=	array();
 		$GroupArr['order']['field']		=	'id';
 		$GroupArr['order']['type']		=	'ASC';
 		
 		$GroupArr['where']				=	array('section_id',$param['id']);
 				
		$groups = $this->GetSectionGroupList($GroupArr);
		
 		$x	=	0;
 		$n	=	sizeof($groups);
 		
		while ($x < $n)
		{
			$cache[$groups[$x]['group_id']] 					= 	array();
			$cache[$groups[$x]['group_id']]['id'] 				= 	$groups[$x]['id'];
			$cache[$groups[$x]['group_id']]['view_section'] 	= 	$groups[$x]['view_section'];
			$cache[$groups[$x]['group_id']]['main_section'] 	= 	$groups[$x]['main_section'];
			
			$x += 1;
		}
		
		$cache = base64_encode(serialize($cache));
		
		return $cache;
	}
	
 	function UpdateSectionGroupCache($param)
 	{
  		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$cache = $this->CreateSectionGroupCache($param);
 		
 		$UpdateArr 							= 	array();
 		$UpdateArr['sectiongroup_cache'] 	= 	$cache;
 		$UpdateArr['where'] 				= 	array('id',$param['id']);
 		
 		$update = $this->Engine->section->UpdateSection($UpdateArr);
 		
 		return ($update) ? true : false;
 	}
 	
	function InsertSectionGroup($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
		           	  		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['section_group'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
	}
	
	function DeleteSectionGroup($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['section_group'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	function UpdateSectionGroup($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           	  
		$query = $this->Engine->records->Update($this->Engine->table['section_group'],$param['field'],$param['where']);
		
		return ($query) ? true : false;
	}


 	
 	/**
 	 * Get the permisson of group in sections
 	 *
 	 * @param :
 	 *			get_from	->	cache or db
 	 */
 	function GetSectionGroupList($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['section_group'];
 		
		$rows = $this->Engine->records->GetList($param);
 		
 		return $rows;
 	}
 	
 	function _GetCachedSectionGroup()
 	{
 		$cache = $this->Engine->_CONF['info_row']['sectiongroup_cache'];
 		$cache = unserialize($cache);
 		 		
 		return $cache;
 	}
 	
	function GetSectionGroupNumber($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['section_group'];
		
		$num = $this->Engine->records->GetNumber($param);
		
		return $num;
 	}
 	
	function GetSectionGroupInfo($param)
 	{
  		if (!isset($param) 
  			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['section_group'];
		
 		$rows = $this->Engine->records->GetInfo($param);
 		
 		return $rows;
 	}
}
 
?>
