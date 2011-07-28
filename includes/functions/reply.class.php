<?php

/**
 * @package 	: 	MySmartReply
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	12/3/2006 , 11:57 PM (Kuwait : GMT+3)
 * @end   		: 	13/3/2006 , 12:01 AM (Kuwait : GMT+3)
 * @updated 	: 	Wed 09 Feb 2011 11:31:27 AM AST 
 */


class MySmartReply
{
	private $engine;
	private $table;
		
	function __construct( $engine )
	{
		$this->engine = $engine;
		$this->table = $this->engine->table[ 'reply' ];
	}
	
	// ... //
	
	public function getReplyWriterInfo( $subject_id )
	{
 		if ( empty( $subject_id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM getReplyWriterInfo()',E_USER_ERROR);
 		}
 		
		$this->engine->rec->select = '*,r.id AS reply_id';
		$this->engine->rec->table = $this->table . ' AS r,' . $this->engine->table['member'] . ' AS m';
		
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
	
	// ... //
	
	public function unTrashReply( $id )
	{
 		if ( empty( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM unTrashReply() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'0'	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
		
	// ... //
	
	public function massDeleteReply( $section_id )
	{
 		if ( empty( $section_id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM massDeleteReply() -- EMPTY section_id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->filter = "section='" . $section_id . "'";
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	// ... //
	
	public function massMoveReply( $to, $from )
	{
 		if ( empty( $to )
 			or empty( $from ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM massMoveReply() -- EMPTY to OR from',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'section'	=>	$to	);
 		
 		$this->engine->rec->filter = "section='" . $from . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function moveReplyToTrash( $id )
	{
 		if ( empty( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM moveReplyToTrash() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'1'	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
}

?>
