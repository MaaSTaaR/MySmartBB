<?php

/**
 * @package 	: 	MySmartSubject
 * @author 		: 	Mohammed Q. Hussian <MaaSTaaR@gmail.com>
 * @start 		: 	11/3/2006 , 8:18 PM
 * @updated 	: 	Thu 28 Jul 2011 10:58:08 AM AST 
 */
 
class MySmartSubject
{
	private $engine;
	private $table;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
		$this->table = $this->engine->table[ 'subject' ];
	}
	
	// ... //
	
/* 	public function updateSubject()
 	{		
 		$this->engine->rec->table = $this->table;

 		if ( isset( $this->engine->fields[ 'tags_cache' ] ) )
 		{
 			$this->engine->fields[ 'tags_cache' ] = serialize( $this->engine->fields[ 'tags_cache' ] );
 		}
	
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}*/
	
	// ... //
	
	public function massDeleteSubject( $section_id )
	{
 		if ( empty( $section_id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM massDeleteSubject() -- EMPTY section_id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->filter = "section_id='" . $section_id . "'";
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	// ... //
	
	public function massMoveSubject( $to, $from )
	{
 		if ( empty( $to )
 			or empty( $from ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM massMoveSubject() -- EMPTY to OR from',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'section'	=>	$to	);
 		
 		$this->engine->rec->filter = "section='" . $from . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function getSubjectWriterInfo( $subject_id )
	{
		if ( empty( $subject_id ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM GetSubjectWriterInfo() -- EMPTY id');
		}
		
 		$this->engine->rec->table = $this->table . ' AS s,' . $this->engine->table['member'] . " AS m";
 		$this->engine->rec->filter = "s.id='" . $id . "' AND m.username=s.writer";
 		
 		$rows = $this->engine->rec->getInfo();
 		
		return $rows;
	}
	
	// ... //
	
	public function updateSubjectVisits( $visits, $id )
	{
		if ( empty( $visits )
			or empty( $id ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM updateSubjectVisits()',E_USER_ERROR);
		}
		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'visitor'	=>	$visits + 1	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function updateWriteTime( $write_time, $id )
	{
 		if ( empty( $id )
 			or empty( $write_time ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM updateWriteTime() -- EMPTY id or write_time',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'write_time'	=>	$write_time	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function updateReplyNumber( $reply_number, $id )
	{
 		if ( empty( $id )
 			or empty( $reply_number ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM updateReplyNumber() -- EMPTY id or reply_number',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'reply_number'	=>	$reply_number + 1	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function updateLastReplier( $replier, $id )
	{
 		if ( empty( $id )
 			or empty( $replier ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM updateLastReplier() -- EMPTY id or reply_number',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'last_replier'	=>	$replier	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function stickSubject( $id )
	{
 		if ( empty( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM stickSubject() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'stick'	=>	'1'	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function closeSubject( $reason, $id )
	{
 		if ( empty( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM closeSubject() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'close'	=>	'1',
 											'close_reason'	=>	$reason	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function moveSubject( $section_id, $subject_id )
	{
 		if ( empty( $section_id )
 			or empty( $subject_id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM moveSubject() -- EMPTY section_id or subject_id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'section'	=>	$section_id	);
 		
 		$this->engine->rec->filter = "id='" . $subject_id . "'";
 		
		$query = $this->engine->rec->update();
		
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function moveSubjectToTrash( $reason, $id )
	{
 		if ( empty( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM moveSubjectToTrash() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'1',
 											'delete_reason'	=>	$reason	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function unTrashSubject( $id )
	{
 		if ( empty( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM unTrashSubject() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'0' );
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function unStickSubject( $id )
	{
 		if ( empty( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM unStickSubject() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'stick'	=>	'0'	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //

	public function openSubject( $id )
	{
 		if ( empty( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM openSubject() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'close'	=>	'0'	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
		
	}
	
	// ... //
}
 
?>
