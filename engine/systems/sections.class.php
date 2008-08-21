<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartSection
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@hotmail.com>
 * @updated 	: 	21/08/2008 08:53:44 PM 
 */
 
class MySmartSection
{
	var $id;
	var $Engine;
	
	function MySmartSection($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function InsertSection($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
		           	  		           	  		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['section'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
	}
	
 	function UpdateSection($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
				
		$query = $this->Engine->records->Update($this->Engine->table['section'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
 		
	function DeleteSection($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['section'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
 	/**
 	 * Get sections by two ways
 	 *
 	 * @param : $get_from -> string : get sections from cache or from databese
 	 * @param : $des -> array : descript of many things
 	 *
 	 * @access public
 	 */
	function GetSectionsList($param)
 	{
  		if (!isset($param) 
  			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['section'];
 		
 		$rows = $this->Engine->records->GetList($param);
 		
		return $rows;
 	}
	 	
 	/**
 	 * Get section information
 	 *
 	 * @access public
 	 */
	function GetSectionInfo($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 	 	$param['select'] 	= 	'*';
 	 	$param['from'] 		= 	$this->Engine->table['section'];
 	 		
		$rows = $this->Engine->records->GetInfo($param);
		
		return $rows;
	}
 	
	function GetSectionNumber($param)
 	{
  		if (!isset($param)
  			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from']		=	$this->Engine->table['section'];
 		
 		$num = $this->Engine->records->GetNumber($param);
 		
 		return $num;
 	}
 	
 	///
 	
 	// TODO :: DELETE ME!
	/**
	 * Get admin section list
	 *
	 */
	/*function GetSectionAdminList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['section_admin'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
 	       
		return $rows;
	}*/
	 	

 	
 	function CheckPassword($param)
 	{
 		if (empty($param['id'])
 			or empty($param['password']))
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM CheckPassword() -- EMPTY id OR password',E_USER_ERROR);
 		}
 		
 		$param['select'] 				= 	'*';
 		$param['from'] 					= 	$this->Engine->table['section'];
 		$param['where']					=	array();
 		
 		$param['where'][0]				=	array();
 		$param['where'][0]['name'] 		= 	'id';
 		$param['where'][0]['oper'] 		= 	'=';
 		$param['where'][0]['value'] 	= 	$param['id'];
 		
 		$param['where'][1]				=	array();
 		$param['where'][1]['con'] 		= 	'AND';
 		$param['where'][1]['name'] 		= 	'section_password';
 		$param['where'][1]['oper'] 		= 	'=';
 		$param['where'][1]['value'] 	= 	$param['password'];
 		
      	$num = $this->Engine->records->GetNumber($param);
      	
      	return ($num <= 0) ? false : true;
 	}
 	
 	function UpdateLastSubject($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$field = array(
		           		'last_writer'		=> 	$param['writer']		,
		           		'last_subject'		=>	$param['title']			,
		           		'last_subjectid'	=>	$param['subject_id']	,
		           		'last_date'			=>	$param['date']			,
		           	   );
		           			           
		$query = $this->Engine->records->Update($this->Engine->table['section'],$field,$param['where']);
 		
 		return ($query) ? true : false;
 	}
 	
	function CreateSectionsCache($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$arr 				= 	array();
 		$arr['get_from'] 	= 	'db';
 		$arr['type'] 		= 	'forum';
 		$arr['where'] 		= 	array('parent',$param['parent']);
 		
 		$forums = $this->GetSectionsList($arr);
 		
 		if ($forums != false)
 		{
 			$x = 0;
 			$size = sizeof($forums);
 		
 			$cache = array();
 		
 			while ($x < $size)
 			{
 				$cache[$x] 							= 	array();
				$cache[$x]['id'] 					= 	$forums[$x]['id'];
				$cache[$x]['title'] 				= 	$forums[$x]['title'];
				$cache[$x]['section_describe'] 		= 	$forums[$x]['section_describe'];
				$cache[$x]['parent'] 				= 	$forums[$x]['parent'];
				$cache[$x]['sort'] 					= 	$forums[$x]['sort'];
				$cache[$x]['section_picture'] 		= 	$forums[$x]['section_picture'];
				$cache[$x]['sectionpicture_type'] 	= 	$forums[$x]['sectionpicture_type'];
				$cache[$x]['use_section_picture'] 	= 	$forums[$x]['use_section_picture'];
				$cache[$x]['linksection'] 			= 	$forums[$x]['linksection'];
				$cache[$x]['linkvisitor'] 			= 	$forums[$x]['linkvisitor'];
				$cache[$x]['last_writer'] 			= 	$forums[$x]['last_writer'];
				$cache[$x]['last_subject'] 			= 	$forums[$x]['last_subject'];
				$cache[$x]['last_subjectid'] 		= 	$forums[$x]['last_subjectid'];
				$cache[$x]['last_date'] 			= 	$forums[$x]['last_date'];
				$cache[$x]['subject_num'] 			= 	$forums[$x]['subject_num'];
				$cache[$x]['reply_num'] 			= 	$forums[$x]['reply_num'];
				$cache[$x]['moderators'] 			= 	$forums[$x]['moderators'];
				$cache[$x]['forums_cache'] 			= 	$forums[$x]['forums_cache'];
			
				$cache[$x]['groups'] 				= 	array();
			
 				$GroupArr 							= 	array();
 				$GroupArr['get_from'] 				= 	'db';
 				$GroupArr['order']					=	array();
 				$GroupArr['order']['field']			=	'id';
 				$GroupArr['order']['type']			=	'ASC';
 				$GroupArr['where'] 					= 	array('section_id',$forums[$x]['id']);
 			
				$groups = $this->Engine->group->GetSectionGroupList($GroupArr);
			
				foreach ($groups as $group)
				{
					$cache[$x]['groups'][$group['group_id']] 					=	array();
					$cache[$x]['groups'][$group['group_id']]['view_section'] 	= 	$group['view_section'];
					$cache[$x]['groups'][$group['group_id']]['main_section'] 	= 	$group['main_section'];
				}
			
				$x += 1;
 			}
 		
 			$cache = base64_encode(serialize($cache));
 		}
 		
		return $cache;
	}
	
 	function UpdateSectionsCache($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$UpdateArr 					= 	array();
 		$UpdateArr['field']			=	array();
 		
 		$UpdateArr['field']['forums_cache'] 	= 	$this->CreateSectionsCache($param);
 		$UpdateArr['where']						=	array('id',$param['parent']);
 		
 		$update = $this->UpdateSection($UpdateArr);
 		
 		return ($update) ? true : false;
 	}
 	
 	function UpdateAllSectionsCache()
 	{
 		$Sections = $this->GetSectionsList(null);
 		
 		$fail = false;
 		
 		foreach ($Sections as $Section)
 		{ 			
 			if (!empty($Section['forums_cache']))
 			{
 				$CacheArr 				= 	array();
 				$CacheArr['parent'] 	= 	$Section['id'];
 			
 				$UpdateArr 					= 	array();
 				$UpdateArr['forums_cache'] 	= 	$this->CreateSectionsCache($CacheArr);
 				$UpdateArr['where']			=	array('id',$Section['parent']);
 			
 				$update = $this->UpdateSection($UpdateArr);
 				
 				if (!$update)
 				{
 					$fail = true;
 				}
 			}
 			else
 			{
 				continue;
 			}
 		}
 		
 		return ($fail) ? false : true;
 	}
}
 
?>
