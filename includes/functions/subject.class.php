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
		
 		$this->engine->rec->table = $this->table . ' AS s,' . $this->engine->table[ 'member' ] . " AS m";
 		$this->engine->rec->select = '*,s.visitor AS subject_visitor';
 		$this->engine->rec->filter = "s.id='" . $subject_id . "' AND m.username=s.writer";
 		
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
	
	public function updateWriteTime( $id, $write_time = null )
	{
 		if ( empty( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM updateWriteTime() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$write_time = ( is_null( $write_time ) ) ? $this->engine->_CONF[ 'now' ] : $write_time;
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'write_time'	=>	$write_time	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function updateReplyNumber( $subject_id, $section_id, $reply_number = null, $operation = 'add', $operand = 1 )
	{
		if ( !is_null( $reply_number) )
		{
			$val = $reply_number;
		}
		else
		{
			$this->engine->rec->table = $this->engine->table[ 'subject' ];
			$this->engine->rec->select = 'reply_number';
			$this->engine->rec->filter = "id='" . $subject_id . "'";
			
			$subject_info = $this->engine->rec->getInfo();
			
			$val = $section_info[ 'reply_number' ];
		}
		
		if ( !is_null( $operation ) )
		{
			if ( $operation == 'add' )
				$val += $operand;
			else
				$val -= $operand;
		}
		
		$this->engine->rec->table = $this->table;
		$this->engine->rec->fields = array(	'reply_number'	=>	$val	);
		$this->engine->rec->filter = "id='" . $subject_id . "'";
		
		$update = $this->engine->rec->update();
		
		if ( $update )
		{
			// Update the total of replies in the section
			$this->engine->section->updateReplyNumber( $section_id, $val, null );
			
			// Update the total of replies
			$this->engine->cache->updateReplyNumber( $val );
		}
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
	
	public function moveSubjectToTrash( $reason, $subject_id, $section_id )
	{
 		if ( empty( $subject_id ) or empty( $section_id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM moveSubjectToTrash() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'1',
 											'delete_reason'	=>	$reason	);
 		
 		$this->engine->rec->filter = "id='" . $subject_id . "'";
 		
		$query = $this->engine->rec->update();
		
		if ( $query )
			$this->engine->section->updateSubjectNumber( $section_id, null, 'delete' );
		           
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
