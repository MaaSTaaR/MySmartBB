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
 * @updated 	: 	06/07/2010 11:49:28 AM 
*/

/**
 * @package MySmartPM
 */

class MySmartPM
{
	public $id;
	private $engine;
	
	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
	/**
	 * Send private massege for member
	 */
	function insertMessage()
	{
		$this->engine->rec->table = $this->engine->table[ 'pm' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
		 
	/**
	 * Get the number of private massege
	 */
	public function getPrivateMessageNumber()
	{
 		$this->engine->rec->table = $this->engine->table[ 'pm' ];
 		
 		return $this->engine->rec->getNumber();
	}
	
	/* ... */
	
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
 		$param['from'] 		= 	$this->engine->table['pm'];
 		
 	 	$rows = $this->engine->records->GetList($param);
		
		return $rows;
	}
	
	/* ... */
	  
	public function getPrivateMassegeInfo()
	{
 		$this->engine->rec->table = $this->engine->table['pm'];
		
		return $this->engine->rec->getInfo();

	}
	
	/* ... */
	
	/**
	 * Delete private massege
	 *
	 * @param :
	 *			owner		->	the owner of list
	 *			username	->	the username to delete
	 */
	/*function DeleteFromSenderList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
	 		
	 	$param['table'] 	= 	$this->engine->table['pm'];
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
 		
 		
	 	$del = $this->engine->records->Delete($param);
	 	
	 	return ($del) ? true : false;
	}*/
	
	
 	/* ... */
 	
 	public function deletePrivateMessage()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'pm' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
 	}
 	
 	/* ... */
		       
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
 		$param['from'] 				= 	$this->engine->table['pm_list'];
 		
 		if (!empty($param['username']))
 		{
 			$param['where']				=	array();
 			$param['where'][0]			=	array();
 			$param['where'][0]['name']	=	'username';
 			$param['where'][0]['oper']	=	'=';
 			$param['where'][0]['value']	=	$param['username'];
 		}
 		
 	 	$rows = $this->engine->records->GetList($param);
 		
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
		           			           
		$query = $this->engine->records->Insert($this->engine->table['pm_list'],$field);
		
		if ($param['get_id'])
		{
			$this->id = $this->engine->DB->sql_insert_id();
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
	 	
		$param['table'] = $this->engine->table['pm_list'];
		
		$del = $this->engine->records->Delete($param);
			
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
		$param['from'] 					= 	$this->engine->table['pm_list'];
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
		
		$num = $this->engine->records->GetNumber($param);
		
		return ($num > 0) ? true : false;
	}
	
	/* ... */
	
	public function markMessageAsRead()
	{
 		$this->engine->rec->table = $this->engine->table['pm'];
 		$this->engine->rec->fields = array(	'user_read'	=>	'1'	);
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function newMessageNumber( $username )
	{
 		if ( empty( $username ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM newMessageNumber() -- EMPTY username');
 		}
 		
 		$this->engine->rec->table = $this->engine->table['pm'];
 		
		$this->engine->rec->filter = "user_to='" . $username . "' AND folder='inbox' AND user_read<>'1'";
				
		return $this->engine->rec->getNumber();
	}
	
	/* ... */
	
	/** High-Level functions **/
	public function getInboxList()
	{
 		$this->engine->rec->table = $this->engine->table[ 'pm' ];
 		
 		$this->engine->rec->filter = "user_to='" . $username . "' AND folder='inbox'";
 		
 	 	$this->engine->rec->getList();
	}
	
	/* ... */
	
	public function getSentList( $username )
	{
 		$this->engine->rec->table = $this->engine->table[ 'pm' ];
 		
 		$this->engine->rec->filter = "user_from='" . $username . "' AND folder='sent'";
 		
 	 	$this->engine->rec->getList();
	}
	
	/* ... */
	
	function UpdatePrivateMessage($param)
 	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->engine->records->Update($this->engine->table['pm'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
}

?>
