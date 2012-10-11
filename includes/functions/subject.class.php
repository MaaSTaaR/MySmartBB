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
	// ...
	// TODO : 	1- We should also change the value of "section" field of the replies of moved topics.
	//			2- It would be a great deal if we change this function to recieve "$from" as an array
	//				so we can move the topics of multiple forums to a specific forum, you can see an
	//				application of this in the file "admin/sections_del.module.php"
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
								'visitor', 'avater_path', 'away', 'away_msg', 'hide_online', 'register_time', 'username_style_cache',
								'logged' );
		
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
		if ( empty( $visits ) or empty( $id ) )
			trigger_error('ERROR::NEED_PARAMETER -- FROM updateSubjectVisits()',E_USER_ERROR);
		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'visitor'	=>	$visits + 1	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	/**
	 * Updates the time of latest reply on a topic, we use this time to sort topics list from newest to oldest, this function _must_ be called after inserting a reply.
	 * 
	 * @param $id The id of the topic to be updated.
	 * @param $write_time The time of inserting the new reply in a Unix time system.
	 * 						If it is null so the current time will be used. It's null by default.
	 * 
	 * @return true for success, otherwise false
	 */
	public function updateWriteTime( $id, $write_time = null )
	{
		// ... //
		
 		if ( empty( $id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM updateWriteTime() -- EMPTY id' );
 		
 		// ... //
 		
 		$write_time = ( is_null( $write_time ) ) ? $this->engine->_CONF[ 'now' ] : $write_time;
 		
 		// ... //
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'write_time'	=>	$write_time	);
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	/**
	 * Updates replies number of a topic.
	 *
	 * @param $subject_id The id of the topic that will be updated.
	 * @param $reply_number If we already have the value of replies number of the topic 
	 * 						we can pass it to this parameter, otherwise keep it null so
	 * 						the number of replies will be getten automatically.
	 * @param $operation Can be "add" or "sub" or null, just use it if you want to add or substract
	 * 						a specific value to/from the number of replies.
	 * @param $operand The value of the operand if $reply_number is not null.
	 * 
	 * @return true for success, otherwise false
	 */
	public function updateReplyNumber( $subject_id, $reply_number = null, $operation = 'add', $operand = 1 )
	{
		$do_operation = true;
		
		if ( !is_null( $reply_number ) )
		{
			$val = $reply_number;
		}
		else
		{
			$this->engine->rec->table = $this->engine->table[ 'reply' ];
			$this->engine->rec->select = 'id';
			$this->engine->rec->filter = "subject_id='" . $subject_id . "'";
			
			$val = $this->engine->rec->getNumber();
			
			// ... //
			
			$do_operation = false;
		}
		
		if ( !is_null( $operation ) and $do_operation )
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
			
			return true;
		}
		
		return false;
	}
	
	// ... //
	
	/**
	 * Updates the last replier of a topic.
	 * 
	 * @param $replier The username of the last replier.
	 * @param $id The id of the topic to be updated.
	 * 
	 * @return true for success, otherwise false
	 */
	public function updateLastReplier( $replier, $id )
	{
		// ... //
		
 		if ( empty( $id ) or empty( $replier ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM updateLastReplier()' );
 		
 		// ... //
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'last_replier'	=>	$replier	);
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	/**
	 * Sticks a specific topic.
	 * 
	 * @param $id The id of the topic to be stuck.
	 * 
	 * @return true for success, otherwise false
	 */
	public function stickSubject( $id )
	{
 		if ( empty( $id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM stickSubject() -- EMPTY id' );
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'stick'	=>	'1'	);
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	/**
	 * Closes a specific topic.
	 * 
	 * @param $reason The reason of close the topic, can be empty.
	 * @param $id The id of the topic to be closed. 
	 * 
	 * @return true for success, otherwise false
	 */
	public function closeSubject( $reason, $id )
	{
 		if ( empty( $id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM closeSubject() -- EMPTY id' );
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'close'	=>	'1',
 											'close_reason'	=>	$reason	);
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	/**
	 * Moves a topic to another forum.
	 * 
	 * @param $section_id The id of the forum that the topic belongs to.
	 * @param $subject_id The id of the topic.
	 * 
	 * @return true for success, otherwise false
	 */
	public function moveSubject( $section_id, $subject_id )
	{
		// ... //
		
 		if ( empty( $section_id ) or empty( $subject_id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM moveSubject() -- EMPTY section_id or subject_id', E_USER_ERROR );
 		
 		// ... //
 		
 		$this->engine->rec->table = $this->engine->table[ 'subject' ];
 		$this->engine->rec->filter = "id='" . $subject_id . "'";
 		
 		$subject_info = $this->engine->rec->getInfo();
 		
 		// ... //
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'section'	=>	$section_id	);
 		$this->engine->rec->filter = "id='" . $subject_id . "'";
 		
		$query = $this->engine->rec->update();
		
		if ( $query )
		{
			// ... //
			
			$this->engine->rec->table = $this->engine->table[ 'subject' ];
			$this->engine->rec->filter = "section='" . $section_id . "'";
			$this->engine->rec->limit = '1';
			$this->engine->rec->order = 'write_time DESC';
			
			$last_topic = $this->engine->rec->getInfo();
			
			$writer = ( empty( $last_topic[ 'last_replier' ] ) ) ? $last_topic[ 'writer' ] : $last_topic[ 'last_replier' ];
			$date = $this->engine->func->date( $last_topic[ 'write_time' ] );
			
			$this->engine->section->updateLastSubject( $writer, $last_topic[ 'title' ], $lat_topic[ 'id' ], $date, $section_id );
			
			$this->engine->section->updateSubjectNumber( $section_id, null, null );
			$this->engine->section->updateReplyNumber( $section_id, null, null );
			
			$this->engine->section->updateForumCache( -1, $section_id );
			
			// ... //
			
			$to = $subject_info[ 'section' ];
			
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
		else
		{
			return false;
		}
	}
	
	// ... //
	
	/**
	 * Moves a topic to trash, so the administrator can delete it permanently or restore it.
	 * 
	 * @param $reason The reason of delete the topic, can be empty.
	 * @param $subject_id The id of the topic to be deleted (actually moved to trash).
	 * @param $section_id The id of the forum that the topic belongs to, it is required to update the statistics of the forum.
	 * 
	 * @return true for success, otherwise false
	 */
	public function moveSubjectToTrash( $reason, $subject_id, $section_id )
	{
 		if ( empty( $subject_id ) or empty( $section_id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM moveSubjectToTrash() -- EMPTY id', E_USER_ERROR );
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'1',
 											'delete_reason'	=>	$reason	);
 		$this->engine->rec->filter = "id='" . $subject_id . "'";
 		
		$query = $this->engine->rec->update();
		
		if ( $query )
		{
			// Move all replies to trash so we can count the correct number
			// of replies and topics of the forum.
			$this->engine->reply->moveRepliesToTrash( $subject_id, $section_id );
			
			$this->engine->section->updateSubjectNumber( $section_id, null, null );
			
			// Update forum's cache so the new number of topics and replies
			// will be shown for the visitor in the main page.
			// The first parameter is null because the parent's id is unknown.
			$this->engine->section->updateForumCache( null, $section_id );
		}
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function unTrashSubject( $id, $section_id )
	{
 		if ( empty( $id ) or empty( $section_id ) )
 			trigger_error('ERROR::NEED_PARAMETER -- FROM unTrashSubject() -- EMPTY id',E_USER_ERROR);
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'0' );
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		
		if ( $query )
		{
			$this->engine->reply->unTrashReplies( $id, $section_id );
			
			$this->engine->section->updateSubjectNumber( $section_id, null, null );
			
			$this->engine->section->updateForumCache( null, $section_id );
			
			return true;
		}

		return false;
	}
	
	// ... //
	
	/**
	 * Unsticks a specific topic.
	 * 
	 * @param $id The id of the topic to be unstuck.
	 * 
	 * @return true for success, otherwise false
	 */
	public function unStickSubject( $id )
	{
 		if ( empty( $id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM unStickSubject() -- EMPTY id' );
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'stick'	=>	'0'	);
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //

	/**
	 * Opeans a closed topic.
	 * 
	 * @param $id The id of the topic to be unstuck.
	 * 
	 * @return true for success, otherwise false
	 */
	public function openSubject( $id )
	{
 		if ( empty( $id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM openSubject() -- EMPTY id' );
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'close'	=>	'0'	);
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
		
	}
	
	// ... //
}
 
?>
