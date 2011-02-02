<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartReply
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	12/3/2006 , 11:57 PM (kuwait : GMT+3)
 * @end   		: 	13/3/2006 , 12:01 AM (kuwait : GMT+3)
 * @updated 	: 	27/07/2010 05:13:42 PM 
 */


class MySmartReply
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
 		$param['from'] 		= 	$this->engine->table['reply'];
 		
 	 	$rows = $this->engine->records->GetList($param);
 		
 		return $rows; 		
	}
	
	/* ... */
	
	public function getReplyInfo()
	{
		$this->engine->rec->table = $this->engine->table['reply'];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
	public function getReplyNumber()
	{
 		$this->engine->rec->table = $this->engine->table[ 'reply' ];
 		
 		return $this->engine->rec->getNumber(); 		
	}
	
	/* ... */
	
	public function getReplyWriterInfo( $subject_id )
	{
 		if ( !isset( $subject_id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM getReplyWriterInfo()',E_USER_ERROR);
 		}
 		
		$this->engine->rec->select = '*,r.id AS reply_id';
		$this->engine->rec->table = $this->engine->table['reply'] . ' AS r,' . $this->engine->table['member'] . ' AS m';
		
		$statement = "r.subject_id='" . $subject_id . "' AND m.username=r.writer";
		
		if ( isset( $this->engine->rec->filter ) )
		{
			$this->engine->rec->filter .= ' AND ' . $statement;
		}
		else
		{
			$this->engine->rec->filter = $statement;
		}
		
		$this->engine->rec->getList();		
	}
	
	/* ... */
	
	/**
	 * Insert a new reply
	 */
	public function insertReply()
	{
		$this->engine->rec->table = $this->engine->table[ 'reply' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
 	public function updateReply()
 	{
 		$this->engine->rec->table = $this->engine->table['reply'];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
	
	public function unTrashReply( $id )
	{
 		if ( !isset( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM unTrashReply() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['reply'];
 		
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'0'	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function deleteReply()
	{
 		$this->engine->rec->table = $this->engine->table[ 'reply' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	public function massDeleteReply( $section_id )
	{
 		$this->engine->rec->table = $this->engine->table[ 'reply' ];
 		
 		$this->engine->rec->filter = "section='" . $section_id . "'";
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	public function massMoveReply( $to, $from )
	{
 		if ( !isset( $to )
 			or !isset( $from ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM massMoveReply() -- EMPTY to OR from',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table[ 'reply' ];
 		
 		$this->engine->rec->fields = array(	'section'	=>	$to	);
 		
 		$this->engine->rec->filter = "section='" . $from . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Move reply to trash
	 */
	public function moveReplyToTrash( $id )
	{
 		if ( !isset( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM moveReplyToTrash() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['reply'];
 		
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'1'	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	   
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
		
		$query = $this->engine->records->Update($this->engine->table['reply'],$field,$param['where']);
		
		return ($query) ? true : false;
	}
}

?>
