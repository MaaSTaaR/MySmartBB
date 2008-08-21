<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartStyle
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	27/2/2006 , 8:38 PM
 * @end   		: 	27/2/2006 , 8:47 PM
 * @updated 	: 	21/08/2008 08:54:11 PM 
 */

class MySmartStyle
{
	var $id;
	var $Engine;
	
	function MySmartStyle($Engine)
	{
		$this->Engine = $Engine;
	}
	
 	/**
 	 * Insert new style
 	 *
 	 * @param :
 	 *			Oh :O it's a long list
 	 */
 	function InsertStyle($param)
 	{
  		if (!isset($param)
  			or !is_array($param))
 		{
 			$param = array();
 		}
		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['style'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
 	}
 	
 	/**
 	 * Update style information
 	 *
 	 * @param :
 	 *			long list :\
 	 */
 	function UpdateStyle($param)
 	{
  		if (!isset($param)
  			or !is_array($param))
 		{
 			$param = array();
 		}
 		           	   
		$query = $this->Engine->records->Update($this->Engine->table['style'],$param['field'],$param['where']);
		
		return ($query) ? true : false;
 	}
 		
	function DeleteStyle($param)
	{
  		if (!isset($param)
  			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['style'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
 	/**
 	 * Get style list
 	 *
 	 * @param :
 	 *			sql_statment	->	to complete SQL query
 	 */
	function GetStyleList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['style'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
 	 	  	 	
		return $rows;
  	 }
 	 
	/**
	 * Set the correct style for member or user
	 *
	 * @return : the information about the correct style
	 */
	function GetStyleInfo($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['style'];
		
		$rows = $this->Engine->records->GetInfo($param);
		
		return $rows;
	}
	
	function GetStyleNumber($param)
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['style'];
		
		$num = $this->Engine->records->GetNumber($param);
		
		return $num;
	}
	
	function ChangeStyle($param)
	{
		if (empty($param['style']))
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM ChangeStyle() -- EMPTY style',E_USER_ERROR);
		}
		
		$update = setcookie($this->Engine->_CONF['style_cookie'],$param['style'],$param['expire']);
		
		return ($update) ? true : false;
	}
	
 	function CreateStyleCache($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$style 	= 	$this->GetStyleInfo($param);
		$cache 	= 	'';
		
		if ($style != false)
		{
			$cache = array();
			
			$cache['style_path'] 		= 	$style['style_path'];
			$cache['image_path'] 		= 	$style['image_path'];
			$cache['template_path'] 	= 	$style['template_path'];
			$cache['cache_path'] 		= 	$style['cache_path'];
			
			$cache = base64_encode(serialize($cache));
		}
		else
		{
			return false;
		}
		
		return $cache;
 	}
}

?>
