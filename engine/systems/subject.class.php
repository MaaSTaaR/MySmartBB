<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */


/**
 * @package 	: 	MySmartSubject
 * @author 		: 	Mohammed Q. Hussian <MaaSTaaR@gmail.com>
 * @start 		: 	11/3/2006 , 8:18 PM
 * @end   		: 	11/3/2006 , 8:47 PM
 * @updated 	: 	05/11/2008 12:58:48 AM 
 */
 
class MySmartSubject
{
	var $id;
	var $Engine;
	
	function MySmartSubject($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function GetSubjectNumber($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		if ($param['get_from'] == 'cache')
		{
			$num = $this->Engine->_CONF['info_row']['subject_number'];
		}
		elseif ($param['get_from'] == 'db')
		{
			$param['select'] 	= 	'*';
			$param['from'] 		= 	$this->Engine->table['subject'];
			
			$num   = $this->Engine->records->GetNumber($param);
		}
 		else
 		{
 			trigger_error('ERROR::BAD_VALUE_OF_GET_FROM_VARIABLE -- FROM GetSubjectNumber() -- get_from SHOULD BE cache OR db',E_USER_ERROR);
 		}
		
		return $num;
	}
	
	function DeleteSubject($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['subject'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
 	function UpdateSubject($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		if (isset($param['field']['tags_cache']))
 		{
 			$param['field']['tags_cache'] = serialize($param['field']['tags_cache']);
 		}
 		
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$param['field'],$param['where']);
				
		return ($query) ? true : false;
 	}
 	
	
	function GetSubjectList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 	 	$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['subject'];
 		
 	 	$rows = $this->Engine->records->GetList($param);
 	 	
 	 	return $rows;
	}
 	 
	/**
	 * Get subject info by id
 	 *
 	 * @param :
	 *				id	->	the id of subject
	 *
	 */
	function GetSubjectInfo($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 	    $param['select'] 	= 	'*';
 	    $param['from'] 		= 	$this->Engine->table['subject'];
 	     	    
 		$rows = $this->Engine->records->GetInfo($param);
 		
		return $rows;
	}
 	
	/**
	 * Insert new subject
	 *
	 * @param :
	 */
	function InsertSubject($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		if (isset($param['field']['tags_cache']))
 		{
 			$param['field']['tags_cache'] = serialize($param['field']['tags_cache']);
 		}
 		
		$query = $this->Engine->records->Insert($this->Engine->table['subject'],$param['field']);
				
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false; 	    	
	}
	
	/**
	 * Restore subject from trash
	 *
	 * @param :
	 *			id	->	the id of subject
 	 *
 	 * @return :
 	 *			if success	->	true
 	 *			else		->	false
	 */
	
	function MassDeleteSubject($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['subject'];

		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	function MassMoveSubject($param)
	{
 		if (empty($param['to'])
 			or empty($param['from']))
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM MassMoveSubject() -- EMPTY to OR from',E_USER_ERROR);
 		}
 		
		$field 				= 	array();
		$field['section'] 	= 	$param['to'];
		
		$where	 			= 	array('section',$param['from']);
		
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$field,$where);
		
		return ($query) ? true : false;
	}
	
	/**
	 * Very spiecal function , it's get the subject and it's writer,section info in one query
	 */
	function GetSubjectWriterInfo($param)
	{
		if (empty($param['id']))
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM GetSubjectWriterInfo() -- EMPTY id');
		}
		
 		$arr							=	array();
 		$arr['select']					=	'*';
 		$arr['from']					=	$this->Engine->table['subject'] . ' AS s,' . $this->Engine->table['member'] . " AS m";
 		
 	    $arr['where'] 					= 	array();
 	    $arr['where'][0] 				= 	array();
 	    $arr['where'][0]['name'] 		= 	's.id';
 	    $arr['where'][0]['oper'] 		= 	'=';
 	    $arr['where'][0]['value'] 		= 	$param['id'];
 	    
 	    $arr['where'][1] 				= 	array();
 	    $arr['where'][1]['con'] 		= 	'AND';
 	    $arr['where'][1]['name'] 		= 	'm.username';
 	    $arr['where'][1]['oper'] 		= 	'=';
 	    $arr['where'][1]['value'] 		= 	's.writer';
 	    $arr['where'][1]['del_quote']	=	true;
 		
 		$rows = $this->Engine->records->GetInfo($arr);
 		
		return $rows;
	}
	
	function UpdateSubjectVisitor($param)
	{
		if (empty($param['visitor']))
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM UpdateSubjectVisitor() -- EMPTY visitor',E_USER_ERROR);
		}
		
		$field = array('visitor'	=> 	$param['visitor']+1);
		           			           
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$field,$param['where']);
 		
 		return ($query) ? true : false;
 		
	}
	
	function IsFlood()
	{
		if (empty($param['last_time']))
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM IsFlood() -- EMPTY last_time',E_USER_ERROR);
		}
		
		return (($this->Engine->_CONF['now'] - $this->Engine->_CONF['info_row']['floodctrl']) <= $param['last_time']) ? true : false;
	}
	
	function UpdateWriteTime($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$field = array('write_time'	=> 	$param['write_time']);
		           			           
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$field,$param['where']);
 				
		return ($query) ? true : false;
	}
	
	function UpdateReplyNumber($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$field = array('reply_number'	=> 	$param['reply_number']+1);
		           			           
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
	
	function UpdateLastReplier($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$field = array('last_replier'	=> 	$param['replier']);
		           			           
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$field,$param['where']);
		
		return ($query) ? true : false;
	}

 	/**
 	 * Stick subjects
 	 *
 	 * @param :
 	 *			id	->	the id of subject
 	 *
 	 * @return :
 	 *			if success	->	true
 	 *			else		->	false
 	 */
	function StickSubject($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$field = array('stick'	=> 	1);
		           	   
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
 	 
 	/**
 	 * Close subjects
 	 *
 	 * @param :
 	 *				id	->	the id of subject
 	 *
 	 * @return :
 	 *			if success	->	true
 	 *			else		->	false
 	 */
	function CloseSubject($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$field = array(	'close'				=> 	1,
 						'close_reason'		=>	$param['reason']);
		           	   
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
 	  
	/**
	 * Move subjects
	 *
	 * @param :
 	 *			subject_id	->	the id of subject
 	 *			section_id	->	the id of new section
 	 *
 	 * @return :
 	 *			if success	->	true
 	 *			else		->	false	 
	 */
	function MoveSubject($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$field = array('section'	=> 	$param['section_id']);
		           	   
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
 	   
	/**
	 * Move subjects to trash
	 *
	 * @param :
	 *			id	->	the id of subject
 	 *
 	 * @return :
 	 *			if success	->	true
 	 *			else		->	false
	 */
	function MoveSubjectToTrash($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$field = array(	'delete_topic'	=> 	1,
 						'delete_reason' => $param['reason']);
		           	   
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
	
	function UnTrashSubject($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$field = array('delete_topic'	=> 	0);
		           	   
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
	
	/**
	 * Unstick subject
	 *
	 * @param :
	 *			id	->	the id of subject
 	 *
 	 * @return :
 	 *			if success	->	true
 	 *			else		->	false	 
	 */
	function UnstickSubject($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$field = array('stick'	=> 	0);
		           	   
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
	
	/**
	 * Open subject
	 *
	 * @param :
	 *				id	->	the id of subject
 	 *
 	 * @return :
 	 *			if success	->	true
 	 *			else		->	false
	 */
	function OpenSubject($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$field = array('close'	=> 	0);
		           	   
		$query = $this->Engine->records->Update($this->Engine->table['subject'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
}
 
?>
