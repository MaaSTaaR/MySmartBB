<?php

/**
 * @package 	: 	MySmartReply
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	12/3/2006 , 11:57 PM (kuwait : GMT+3)
 * @end   		: 	13/3/2006 , 12:01 AM (kuwait : GMT+3)
 * @updated 	: 	Wed 09 Feb 2011 11:31:27 AM AST 
 */


class MySmartReply
{
	private $engine;
		
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	
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
}

?>
