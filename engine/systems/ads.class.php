<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartAds
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	4/3/2006 , 8:28 PM
 * @end   		: 	4/3/2006 , 8:38 PM
 * @updated 	: 	21/08/2008 08:42:34 PM 
 */

class MySmartAds
{
	var $id;
	var $Engine;
	
	function MySmartAds($Engine)
	{
		$this->Engine = $Engine;
	}
	
 	/**
 	 * Insert new ads
 	 *
 	 * @param :
 	 *			Oh :O it's a long list
 	 */
 	function InsertAds($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->Engine->records->Insert($this->Engine->table['ads'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
 	}
 	
 	/**
 	 * Update ads information
 	 *
 	 * @param :
 	 *			long list :\
 	 */
 	function UpdateAds($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
		           
		$query = $this->Engine->records->Update($this->Engine->table['ads'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
 		
	function DeleteAds($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['ads'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	/**
	 * Get ads info
 	 *
 	 * $this->Engine->ads->GetAdsInfo(array $param);
 	 *
 	 * $param = 
 	 *			array('id'=>'The id of ads');
 	 *
 	 * @return
 	 *				array -> of information
 	 *				false -> when no information found
 	 */
	function GetAdsInfo($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 	 	$param['select'] 	= 	'*';
 	 	$param['from'] 		= 	$this->Engine->table['ads'];
	 	
 	 	$rows = $this->Engine->records->GetInfo($param);
 	 	
 	 	return $rows;
	}
 	 
	/**
 	 * New visitor for the site
 	 *
 	 * $this->Engine->ads->NewVisit(array $param);
 	 *
 	 * $param =
 	 *			array(	'clicks'	=>	'last clicks which stored in database',
 	 					'id'		=>	'the id of ads	);
 	 *
 	 * @return
 	 *				true	->	when success
 	 *				false	->	when fail
 	 */
	function NewVisit($param)
	{
		if (empty($param['clicks'])
			and $param['clicks'] != 0)
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM NewVisit() -- EMPTY clicks',E_USER_ERROR);
		}
		
		$param['field'] = array();
		$param['field']['clicks'] = $param['clicks'] + 1;
		
		$update = $this->UpdateAds($param);
		
		return ($update) ? true : false;
	}
	
	/**
	 * Get random ads to show it
	 *
	 * $this->Engine->ads->GetRandomAds();
	 *
	 * $param = 
	 *			null
	 *
	 * @return
	 *			array -> of information
	 *			false -> when no information
	 */
	function GetRandomAds()
	{
 		$arr					=	array();
 		$arr['select']			=	'*';
 		$arr['from']			=	$this->Engine->table['ads'];
 		$arr['order']			=	array();
 		$arr['order']['type']	=	'RAND()';
 		
 		$rows = $this->Engine->records->GetInfo($arr);
 		
 		return $rows;
	}
	
	/**
	 * Get the number of ads which stored in database
	 *
	 * $param =
	 *			null
	 *
	 * @return
	 *			int	->	number of ads
	 */
	function GetAdsNumber($param)
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['ads'];
		
		$num = $this->Engine->records->GetNumber($param);
		
		return $num;
	}
	
  	/**
 	 * Get ads list
 	 *
 	 * $param =
 	 *			array(	'sql_statment'	=>	'the complete of SQL statement',
 	 *					'proc'			=>	true // When you want to proccess the outputs
 	 *					);
 	 *
 	 * @return
 	 *			array -> of information
 	 *			false -> when found no information
 	 */
 	function GetAdsList($param)
 	{
  		if (!isset($param)
  			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['ads'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
 		
 		return $rows;
 	}
}
 
 ?>
