<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * Private message system
 *
 * @package		: 	MySmartPM
 * @author		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	24/2/2006 8:31 AM
 * @end   		: 	24/2/2006 9:05 AM
 * @updated 	: 	16/07/2008 11:52:42 PM 
*/

/**
 * @package MySmartPM
 */

class MySmartPM
{
	var $id;
	var $Engine;
	
	function MySmartPM($Engine)
	{
		$this->Engine = $Engine;
	}
	
	/**
	 * Send private massege for member
	 *
	 * @param :
	 *			from	->	the username of the sender
	 *			to		->	the username of the resiver
	 *			title	->	the title of private massege
	 *			text	->	the text of private massege
	 *			date	->	the date of private massege
	 *			icon	->	the icon of private massege
	 *			folder	->	the folder of private massege
	 */
	function InsertMassege($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['pm'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
					
		return ($query) ? true : false;
	}
		 
	/**
	 * Get the number of private massege
	 *
	 * @param :
	 *			way -> 
	 *					new 	- to get the number of new pm
	 *					all 	- to get the total of pm
	 *					query 	- our own SQL query 
	 *
	 *			username -> the username
	 *			query	 -> if the way is query , this variable should value the query
	 */
	function GetPrivateMassegeNumber($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from']		=	$this->Engine->table['pm'];
		
		$num = $this->Engine->records->GetNumber($param);
		
		return $num;
	}
		   
	/**
	 * Get the list of private massege
	 *
	 * @param :
	 *			username ->	the owner of pm
	 *			folder	 -> the pm from which folder ?
	 */
	function GetPrivateMassegeList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
		
 		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['pm'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
		
		return $rows;
	}
	  
	/**
	 * Read pm by id
	 *
	 * @param :
	 *				id 			-> the id of pm
	 *				username 	-> who request the msg to read ?
	 */
	function GetPrivateMassegeInfo($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
		
		$param['select'] 			= 	'*';
		$param['from']				=	$this->Engine->table['pm'];
		$param['where']				=	array();
		
		if (!empty($param['id'])
			and !empty($param['username']))
		{
			$param['where'][0]			=	array();
			$param['where'][0]['name']	=	'id';
			$param['where'][0]['oper']	=	'=';
			$param['where'][0]['value']	=	$param['id'];
		
			$param['where'][1]			=	array();
			$param['where'][1]['con']	=	'AND';
			$param['where'][1]['name']	=	'user_to';
			$param['where'][1]['oper']	=	'=';
			$param['where'][1]['value']	=	$param['username'];
		}
		
		$rows = $this->Engine->records->GetInfo($param);
		
		return $rows;
	}
	
	/**
	 * Delete private massege
	 *
	 * @param :
	 *			owner		->	the owner of list
	 *			username	->	the username to delete
	 */
	function DeleteFromSenderList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
	 		
	 	$param['table'] 	= 	$this->Engine->table['pm'];
	 	$param['where'] 	= 	array();
	 	
	 	if (!empty($param['username'])
	 		and !empty($param['id']))
	 	{
 			$param['where'][0] 			= 	array();
 			$param['where'][0]['name'] 	= 	($param['user_to']) ? 'user_to' : 'user_from';
 			$param['where'][0]['oper'] 	= 	'=';
 			$param['where'][0]['value'] = 	$param['username'];
 		
 			$param['where'][1] 			= 	array();
 			$param['where'][1]['con']	=	'AND';
 			$param['where'][1]['name'] 	= 	'id';
 			$param['where'][1]['oper'] 	= 	'=';
 			$param['where'][1]['value'] = 	$param['id'];
 		}
 		
 		
	 	$del = $this->Engine->records->Delete($param);
	 	
	 	return ($del) ? true : false;
	}
		       
	/**
	 * Get member sender list
	 *
	 * @param :
	 *			username	->	the owner of list
	 */
	function GetSenderList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
	 	
 		$param['select'] 			= 	'*';
 		$param['from'] 				= 	$this->Engine->table['pm_list'];
 		
 		if (!empty($param['username']))
 		{
 			$param['where']				=	array();
 			$param['where'][0]			=	array();
 			$param['where'][0]['name']	=	'username';
 			$param['where'][0]['oper']	=	'=';
 			$param['where'][0]['value']	=	$param['username'];
 		}
 		
 	 	$rows = $this->Engine->records->GetList($param);
 		
 		return $rows;
	}
		       
	/**
	 * Insert new member to sender list
	 *
	 * @param :
	 *			owner		->	the owner of list
	 *			username	->	the username to insert
	 */
	function InsertSenderList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$field = array(
		           		'list_username'	=>	$param['username'],
		           		'username'		=>	$param['owner'],
		           	   );
		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['pm_list'],$field);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
			
		return ($query) ? true : false;
	}
		        
	/**
	 * Delete member from sender list
	 *
	 * @param :
	 *			owner		->	the owner of list
	 *			username	->	the username to delete
	 */
	function DeleteSenderList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
	 	
		$param['table'] = $this->Engine->table['pm_list'];
		
		$del = $this->Engine->records->Delete($param);
			
		return ($del) ? true : false;
	}
		         
	/**
	 * Check if member is exists in sender list
	 *
	 * @param :
	 *				owner		->	the owner of list
	 *				username	->	the username to know if exists
	 */
	function CheckSenderList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
	 	
		$param['select'] 				= 	'*';
		$param['from'] 					= 	$this->Engine->table['pm_list'];
		$param['where'] 				= 	array();
		
		if (!empty($param['username'])
			and !empty($param['owner']))
		{
			$param['where'][0] 				= 	array();
			$param['where'][0]['name'] 		= 	'list_username';
			$param['where'][0]['oper'] 		= 	'=';
			$param['where'][0]['value'] 	= 	$param['username'];
		
			$param['where'][1] 				= 	array();
			$param['where'][1]['con'] 		= 	'AND';
			$param['where'][1]['name'] 		= 	'username';
			$param['where'][1]['oper'] 		= 	'=';
			$param['where'][1]['value'] 	= 	$param['owner'];
		}
		
		$num = $this->Engine->records->GetNumber($param);
		
		return ($num > 0) ? true : false;
	}
		          
	function MakeMassegeRead($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$field 				= 	array();
		$field['user_read'] = 	'1';
		
		$update = $this->Engine->records->Update($this->Engine->table['pm'],$field,$param['where']);
		
		return ($update) ? true : false;
	}
	
	function NewMessageNumber($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$arr 							= 	array();
		$arr['where'] 					= 	array();
		
		$arr['where'][0] 				= 	array();
		$arr['where'][0]['name'] 		= 	'user_to';
		$arr['where'][0]['oper'] 		= 	'=';
		$arr['where'][0]['value'] 		= 	$param['username'];
		
		$arr['where'][1] 				= 	array();
		$arr['where'][1]['con'] 		= 	'AND';
		$arr['where'][1]['name'] 		= 	'folder';
		$arr['where'][1]['oper'] 		= 	'=';
		$arr['where'][1]['value'] 		= 	'inbox';
		
		$arr['where'][2] 				= 	array();
		$arr['where'][2]['con'] 		= 	'AND';
		$arr['where'][2]['name'] 		= 	'user_read';
		$arr['where'][2]['oper'] 		= 	'<>';
		$arr['where'][2]['value'] 		= 	'1';
		
		return $this->GetPrivateMassegeNumber($arr);
	}
	
	/** High-Level functions **/
	function GetInboxList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['where'] 				= 	array();
		
		$param['where'][0] 				= 	array();
		$param['where'][0]['name'] 		= 	'user_to';
		$param['where'][0]['oper'] 		= 	'=';
		$param['where'][0]['value'] 	= 	$param['username'];
		
		$param['where'][1] 				= 	array();
		$param['where'][1]['con'] 		= 	'AND';
		$param['where'][1]['name'] 		= 	'folder';
		$param['where'][1]['oper'] 		= 	'=';
		$param['where'][1]['value'] 	= 	'inbox';
		
		$rows = $this->GetPrivateMassegeList($param);
		
		return $rows;
	}
	
	function GetSentList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['where'] 				= 	array();
		
		$param['where'][0] 				= 	array();
		$param['where'][0]['name'] 		= 	'user_from';
		$param['where'][0]['oper'] 		= 	'=';
		$param['where'][0]['value'] 	= 	$param['username'];
		
		$param['where'][1] 				= 	array();
		$param['where'][1]['con'] 		= 	'AND';
		$param['where'][1]['name'] 		= 	'folder';
		$param['where'][1]['oper'] 		= 	'=';
		$param['where'][1]['value'] 	= 	'sent';
		
		$rows = $this->GetPrivateMassegeList($param);
		
		return $rows;
	}
	
	function UpdatePrivateMessage($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->Engine->records->Update($this->Engine->table['pm'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
}

?>
