<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartAnnouncement
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	13/3/2006 , 12:06 AM
 * @end   		: 	13/3/2006 , 12:15 AM
 * @updated 	: 	16/07/2008 08:40:55 PM 
 */


class MySmartAnnouncement
{
	var $id;
	var $Engine;
	
	function MySmartAnnouncement($Engine)
	{
		$this->Engine = $Engine;
	}
	
 	/**
 	 * Insert new announcement
 	 *
 	 * @param :
 	 *			Oh :O it's a long list
 	 */
 	function InsertAnnouncement($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
     			           
		$query = $this->Engine->records->Insert($this->Engine->table['announcement'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
 	}
 	
 	/**
 	 * Update announcement information
 	 *
 	 * @param :
 	 *			long list :\
 	 */
 	function UpdateAnnouncement($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->Engine->records->Update($this->Engine->table['announcement'],$param['field'],$param['where']);
				
		return ($query) ? true : false;
 	}
 	
	function DeleteAnnouncement($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['announcement'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	/**
	 * Get the list of announcement
	 *
	 * $param =
	 *			array(	'sql_statment'	=>	'complete SQL statement',
	 *					'proc'			=>	true // When you want proccess the outputs
	 *					);
	 *
	 * @return :
	 *				array -> of information
	 *				false -> when found no information
	 */
	function GetAnnouncementList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['announcement'];
		
		$rows = $this->Engine->records->GetList($param);
		
		return $rows;
	}
	
	/**
	 * Get announcement info
	 *
	 * $param =
	 *			array(	'id'	=>	'the id of announcement');
	 *
	 * @return :
	 *			array -> of information
	 *			false -> when found no information
	 */
	function GetAnnouncementInfo($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['announcement'];
		
		$rows = $this->Engine->records->GetInfo($param);
 	 	
 	 	return $rows;
	}
	
	function GetAnnouncementNumber($param)
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['announcement'];
		
		$num = $this->Engine->records->GetNumber($param);
		
		return $num;
	}
}

?>
