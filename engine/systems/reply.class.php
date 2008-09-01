<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartReply
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	12/3/2006 , 11:57 PM (kuwait : GMT+3)
 * @end   		: 	13/3/2006 , 12:01 AM (kuwait : GMT+3)
 * @updated 	: 	31/08/2008 05:03:08 AM 
 */


class MySmartReply
{
	var $id;
	var $Engine;
	
	function MySmartReply($Engine)
	{
		$this->Engine = $Engine;
	}
	
	/**
	 * Get reply list by subject id
	 *
	 * @param :
	 *			subject_id	->	the id of subject
	 */
	function GetReplyList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['reply'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
 		
 		return $rows; 		
	}
	
	function GetReplyInfo($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 	 	$param['select'] 	= 	'*';
 	 	$param['from'] 		= 	$this->Engine->table['reply'];
	 	
 	 	$rows = $this->Engine->records->GetInfo($param);
 	 	
 	 	return $rows; 		
	}
	
	function GetReplyNumber($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		if ($param['get_from'] == 'cache')
		{
			$num = $this->Engine->_CONF['info_row']['reply_number'];
		}
		elseif ($param['get_from'] == 'db')
		{
			$param['select'] 	= 	'*';
			$param['from'] 		= 	$this->Engine->table['reply'];
		
			$num = $this->Engine->records->GetNumber($param);
		}
		else
		{
			trigger_error('ERROR::BAD_VALUE_OF_GET_FROM_VARIABLE -- FROM GetReplyNumber() -- get_from SHOULD BE cache OR db',E_USER_ERROR);
		}
		
		return $num;
	}
	
	function GetReplyWriterInfo($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 					= 	'*,r.id AS reply_id';
		$param['from'] 						= 	$this->Engine->table['reply'] . ' AS r,' . $this->Engine->table['member'] . ' AS m';
		
		$param['where'] 					= 	array();
		
		$param['where'][0] 					= 	array();
		$param['where'][0]['name'] 			= 	'r.subject_id';
		$param['where'][0]['oper'] 			= 	'=';
		$param['where'][0]['value'] 		= 	$param['subject_id'];
		
		$param['where'][1] 					= 	array();
		$param['where'][1]['con'] 			= 	'AND';
		$param['where'][1]['name'] 			= 	'm.username';
		$param['where'][1]['oper'] 			= 	'=';
		$param['where'][1]['value'] 		= 	'r.writer';
		$param['where'][1]['del_quote'] 	= 	true;
		
		$rows = $this->Engine->records->GetList($param);
		
		return $rows;
	}
	
	/**
	 * Insert new reply
	 *
	 * @param :
	 *			see field array
	 */
	function InsertReply($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->Engine->records->Insert($this->Engine->table['reply'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false; 	    	
	}
	
 	function UpdateReply($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
		
		$query = $this->Engine->records->Update($this->Engine->table['reply'],$field,$param['where']);
				
		return ($query) ? true : false;
 	}
	
	function UnTrashReply($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$field 					= 	array();
 		$field['delete_topic'] 	= 	0;
		
		$query = $this->Engine->records->Update($this->Engine->table['reply'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
	
	function DeleteReply($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['reply'];
				
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	function MassDeleteReply($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['reply'];
		
		if (!empty($param['section_id']))
		{
			$param['where'] = array('section',$param['section_id']);
		}
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	function MassMoveReply($param)
	{
 		if (empty($param['to'])
 			or empty($param['from']))
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM MassMoveReply() -- EMPTY to OR from',E_USER_ERROR);
 		}
 		
 		$field 					= 	array();
 		$field['section'] 		= 	$param['to'];
 		
 		$where 					=	array('section',$param['from']);
		
		$query = $this->Engine->records->Update($this->Engine->table['reply'],$field,$where);
		
		return ($query) ? true : false;
	}

	/**
	 * Move reply to trash
	 *
	 * @param :
	 *			id	->	the id of reply
 	 *
 	 * @return :
 	 *			if success	->	true
 	 *			else		->	false
	 */
	function MoveReplyToTrash($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$field 					= 	array();
 		$field['delete_topic'] 	= 	1;
		
		$query = $this->Engine->records->Update($this->Engine->table['reply'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
	   
	/**
	 * Restore reply from trash
	 *
	 * @param :
	 *			id	->	the id of reply
 	 *
 	 * @return :
 	 *			if success	->	true
 	 *			else		->	false
	 */
	function UnMoveReplyToTrash($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$field 				= 	array();
 		$field['delete'] 	= 	0;
		
		$query = $this->Engine->records->Update($this->Engine->table['reply'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
}

?>
