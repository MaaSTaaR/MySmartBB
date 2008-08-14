<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartInfo
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	20/1/2007 , 9:29 PM
 * @end   		: 	20/1/2007 , 9:33 PM
 * @updated		: 	16/07/2008 11:41:43 PM 
 */

class MySmartInfo
{
	var $Engine;
	
	function MySmartInfo($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function GetSettingInfo($param=null)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 	 	
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['info'];
		
		$rows = $this->Engine->records->GetList($param);
		
		return $rows;
	}
	
 	function UpdateInfo($param)
 	{
 		if (!isset($param['var_name']))
 		{
 			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
 		}
 		
 		$field = array('value'		=>	$param['value']);
		
		$where = array('var_name',$param['var_name']);
		
		$query = $this->Engine->records->Update($this->Engine->table['info'],$field,$where);
		           
		return ($query) ? true : false;
 	}
}

?>
