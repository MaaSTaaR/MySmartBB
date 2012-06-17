<?php

/**
 * @package 	: 	MySmartSubject
 * @author 		: 	Mohammed Q. Hussian <MaaSTaaR@gmail.com>
 * @start 		: 	11/3/2006 , 8:18 PM
 * @updated 	: 	Sat 03 Sep 2011 06:55:00 AM AST 
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
	
	public function massDeleteSubject( $section_id, $update_section_info = true )
	{
 		if ( empty( $section_id ) )
 			trigger_error('ERROR::NEED_PARAMETER -- FROM massDeleteSubject() -- EMPTY section_id',E_USER_ERROR);
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->filter = "section='" . $section_id . "'";
 		
 		$delete = $this->engine->rec->delete();
 		
 		if ( $delete )
 		{
 			if ( $update_section_info )
 			{
				// No subject in the section, that's mean no last subject.
				$this->engine->section->updateLastSubject( '', '', '', '', $section_id );
			
				// Update the number of subjects and replies on the section
				$this->engine->section->updateSubjectNumber( $section_id, null, null );
				$this->engine->section->updateReplyNumber( $section_id, null, null );
			
				$this->engine->section->updateForumCache( -1, $section_id );
			}
			
			return true;
 		}
 		
 		return false;
	}
	
	// ... //
	
	// If the parameter $update_from_info = false
	// the information of $from (last subject, subjects and replies number) will not be updated
	// we can use this parameter when want to delete $from and move its subjects to "$to"
	public function massMoveSubject( $to, $from, $update_from_info = true )
	{
 		if ( empty( $to ) or empty( $from ) )
 			trigger_error('ERROR::NEED_PARAMETER -- FROM massMoveSubject() -- EMPTY to OR from',E_USER_ERROR);
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'section'	=>	$to	);
 		$this->engine->rec->filter = "section='" . $from . "'";
 		
		$update = $this->engine->rec->update();
		
		// After mass move we have to update the information of the last subject of the sections
		if ( $update )
		{
			// ... //
			
			if ( $update_from_info )
			{
				// No subject in the section $from, that's mean no last subject.
				$this->engine->section->updateLastSubject( '', '', '', '', $from );
			
				// Update the number of subjects and replies on $form
				$this->engine->section->updateSubjectNumber( $from, null, null );
				$this->engine->section->updateReplyNumber( $from, null, null );
			
				$this->engine->section->updateForumCache( -1, $from );
			}
			
			// ... //
			
			$this->engine->rec->table = $this->engine->table[ 'subject' ];
			$this->engine->rec->filter = "section='" . $to . "'";
			$this->engine->rec->limit = '1';
			$this->engine->rec->order = 'write_time DESC';
			
			$last_topic = $this->engine->rec->getInfo();
			
			$writer = ( empty( $last_topic[ 'last_replier' ] ) ) ? $last_topic[ 'writer' ] : $last_topic[ 'last_replier' ];
			$date = $this->engine->func->date( $last_topic[ 'write_time' ] );
			
			$this->engine->section->updateLastSubject( $writer, $last_topic[ 'title' ], $lat_topic[ 'id' ], $date, $to );
			
			// Update the number of subjects and replies on $form
			$this->engine->section->updateSubjectNumber( $to, null, null );
			$this->engine->section->updateReplyNumber( $to, null, null );
			
			$this->engine->section->updateForumCache( -1, $to );
			
			// ... //
			
			return true;
		}
		
		return false;
	}
	
	// ... //
	
	public function getSubjectWriterInfo( $subject_id )
	{
		if ( empty( $subject_id ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM GetSubjectWriterInfo() -- EMPTY id');
		}
		
		// Fields to retrieve from member table
		// That helps us to keep the returned array as small as possible, and prevent the member's password to be retrieved
		$member_select = array( 'username', 'user_sig', 'user_country', 'user_gender', 'register_date', 'posts', 'user_title', 
								'visitor', 'avater_path', 'away', 'away_msg', 'hide_online', 'register_time', 'username_style_cache' );
		
		$select = 'subject.*,subject.visitor AS subject_visitor';
		
		foreach ( $member_select as $key => $field )
		{
			$select .= ',member.' . $field;
		}
		
 		$this->engine->rec->table = $this->table . ' AS subject,' . $this->engine->table[ 'member' ] . " AS member";
 		$this->engine->rec->select = $select; 		
 		$this->engine->rec->filter = "subject.id='" . $subject_id . "' AND subject.writer=member.username";
 		
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
	
	public function updateReplyNumber( $subject_id, $reply_number = null, $operation = 'add', $operand = 1 )
	{
		if ( !is_null( $reply_number) )
		{
			$val = $reply_number;
		}
		else
		{
			$this->engine->rec->table = $this->engine->table[ 'reply' ];
			$this->engine->rec->select = 'id';
			$this->engine->rec->filter = "subject_id='" . $subject_id . "'";
			
			$val = $this->engine->rec->getNumber();
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
			// Update the total of replies
			$this->engine->cache->updateReplyNumber();
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
