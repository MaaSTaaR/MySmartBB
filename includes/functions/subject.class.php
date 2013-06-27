<?php

/**
 * @package MySmartSubject
 * @author Mohammed Q. Hussian <MaaSTaaR@gmail.com>
 * @since 11/3/2006 , 8:18 PM
 * @license GNU GPL
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
	
	/**
	 * Deletes all topics and replies for a specific section.
	 * 
	 * @param $section_id The id of the section.
	 * @param $update_section_info If this parameter = false, the information of the section (last subject, subjects and replies number) will not be updated
	 *			we can use this parameter when want to delete the section and delete its topics, The default value is true.
	 * 
	 * @return boolean
	 */
	public function massDeleteSubject( $section_id, $update_section_info = true )
	{
 		if ( empty( $section_id ) )
 			trigger_error('ERROR::NEED_PARAMETER -- FROM massDeleteSubject() -- EMPTY section_id',E_USER_ERROR);
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->filter = "section='" . $section_id . "'";
 		
 		$delete = $this->engine->rec->delete();
 		
 		if ( $delete )
 		{
 			$this->engine->rec->table = $this->engine->table[ 'reply' ];
 			$this->engine->rec->filter = "section='" . $section_id . "'";
 			
 			$del = $this->engine->rec->delete();
 			
 			if ( $update_section_info )
 			{
				// No subject in the section, that's mean no last subject.
				$this->engine->section->updateLastSubject( '', '', '', '', $section_id );
			
				// Update the number of subjects and replies on the section
				$this->engine->section->updateSubjectNumber( $section_id, 0, null );
				$this->engine->section->updateReplyNumber( $section_id, 0, null );
			
				$this->engine->section->updateForumCache( null, $section_id );
			}
			
			if ( $del )
				return true;
 		}
 		
 		return false;
	}
	
	// ... //
	
	/**
	 * Moves all topics and its replies from one section to another and updates all section's 
	 * related information such as topics number, replies number and last topic for both sections.
	 * 
	 * @param $to The id of the section which the topics will be moved to.
	 * @param $from The id of the section which the topics will be moved from.
	 * @param $update_from_info If this parameter = false, the information of $from (last subject, subjects and replies number) will not be updated
	 *			we can use this parameter when want to delete $from and move its topics to "$to", The default value is true.
	 * 								
	 * @return boolean
	 * 
	 * @todo It would be a great deal if we change this function to recieve "$from" as an array
	 * 			so we can move the topics of multiple forums to a specific forum, you can see an
	 * 			application of this in the file "admin/sections_del.module.php"
	 */
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
			
			$this->engine->rec->table = $this->engine->table[ 'reply' ];
			$this->engine->rec->fields = array(	'section'	=>	$to	);
			$this->engine->rec->filter = "section='" . $from . "'";
				
			$update = $this->engine->rec->update();
			
			// ... //
			
			// Updates the related information of $from.
			if ( $update_from_info )
			{
				// No subject in the section $from, that's mean no last subject.
				$this->engine->section->updateLastSubject( '', '', '', '', $from );
			
				// Update the number of subjects and replies on $form
				$this->engine->section->updateSubjectNumber( $from, 0, null );
				$this->engine->section->updateReplyNumber( $from, 0, null );
			
				$this->engine->section->updateForumCache( null, $from );
			}
			
			// ... //
			
			// Updates the related information of $to
			
			// ... //
			
			$this->engine->rec->table = $this->engine->table[ 'subject' ];
			$this->engine->rec->filter = "section='" . $to . "'";
			$this->engine->rec->limit = '1';
			$this->engine->rec->order = 'write_time DESC';
			
			$last_topic = $this->engine->rec->getInfo();
			
			$writer = ( empty( $last_topic[ 'last_replier' ] ) ) ? $last_topic[ 'writer' ] : $last_topic[ 'last_replier' ];
			$date = $this->engine->func->date( $last_topic[ 'write_time' ] );
			
			$this->engine->section->updateLastSubject( $writer, $last_topic[ 'title' ], $lat_topic[ 'id' ], $date, $to );
			
			// ... //
			
			// Update the number of topics and replies on $to
			$this->engine->section->updateSubjectNumber( $to );
			$this->engine->section->updateReplyNumber( $to );
			
			$this->engine->section->updateForumCache( null, $to );
			
			// ... //
			
			return true;
		}
		
		return false;
	}
	
	// ... //
	
	/**
	 * Returns the information of a topic with the information of the writer.
	 * 
	 * @param $subject_id The id of the topic to be got from database.
	 * 
	 * @return An array contains row of topic and writer or false when not match. The id of subject will be stored as "subject_id"
	 */
	public function getSubjectWriterInfo( $subject_id )
	{
		// ... //
		
		if ( empty( $subject_id ) )
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM getSubjectWriterInfo()' );
		
		// ... //
		
		// Fields to be retrieved from member table
		// That helps us to keep the returned array as small as possible, and prevents the member's password to be retrieved
		$member_select = array( 'username', 'user_sig', 'user_country', 'user_gender', 'register_date', 'posts', 'user_title', 
								'visitor', 'avater_path', 'away', 'away_msg', 'hide_online', 'register_time', 'username_style_cache',
								'logged' );
		
		$select = 'subject.*,subject.visitor AS subject_visitor, subject.id AS subject_id, member.id AS id';
		
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
	
	/**
	 * Updates visitors number of a topic.
	 * 
	 * @param $visits The current number of visitors.
	 * @param $id The id of the topic to be updated.
	 * 
	 * @return true for success, otherwise false
	 */
	public function updateSubjectVisits( $visits, $id )
	{
		if ( !isset( $visits ) or empty( $id ) )
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM updateSubjectVisits()' );
		
		$cookie_name = 'MySmartBB_topic_' . $id;
		
		// If MySmartBB_topic_[id] doesn't exist count a new visit and register this cookie.
		// Otherwise don't count a new visit. By this way we can ensure that the visitors number
		// will not raise with every refresh for the page.
		if ( !$this->engine->func->isCookie( $cookie_name ) )
		{
 			$this->engine->rec->table = $this->table;
 			$this->engine->rec->fields = array(	'visitor'	=>	$visits + 1	);
 			$this->engine->rec->filter = "id='" . $id . "'";
 		
			$query = $this->engine->rec->update();
			
			setcookie( $cookie_name, $id, time() + 31536000, $this->engine->_CONF[ 'bb_path' ] );
			
			return ( $query ) ? true : false;
		}
		
		return true;
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
			$this->engine->rec->filter = "subject_id='" . $subject_id . "' AND delete_topic<>'1'";
			
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
	 * @param $section_id The id of the forum that the topic will belong to.
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
			
			$this->engine->section->updateLastSubject( $writer, $last_topic[ 'title' ], $last_topic[ 'id' ], $date, $section_id );
			
			$this->engine->section->updateSubjectNumber( $section_id, null, null );
			$this->engine->section->updateReplyNumber( $section_id, null, null );
			
			$this->engine->section->updateForumCache( -1, $section_id );
			
			// ... //
			
			$from = $subject_info[ 'section' ];
			
			$this->engine->rec->table = $this->engine->table[ 'subject' ];
			$this->engine->rec->filter = "section='" . $from . "'";
			$this->engine->rec->limit = '1';
			$this->engine->rec->order = 'write_time DESC';
			
			$last_topic = $this->engine->rec->getInfo();
			
			if ( !$last_topic )
			{
				$writer = '';
				$date = '';
				$last_title = '';
				$last_id = '';	
			}
			else
			{				
				$writer = ( empty( $last_topic[ 'last_replier' ] ) ) ? $last_topic[ 'writer' ] : $last_topic[ 'last_replier' ];
				$date = $this->engine->func->date( $last_topic[ 'write_time' ] );
				$last_title = $last_topic[ 'title' ];
				$last_id = $last_topic[ 'id' ];
			}
			
			$this->engine->section->updateLastSubject( $writer, $last_title, $last_id, $date, $from );
			
			// Update the number of subjects and replies on $form
			$this->engine->section->updateSubjectNumber( $from, null, null );
			$this->engine->section->updateReplyNumber( $from, null, null );
			
			$this->engine->section->updateForumCache( -1, $from );
			
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
	
	/**
	 * Restores a specific topic from the trash. Also recounts the number of topics
	 * and replies of the forum which the topic belongs to.
	 * 
	 * @param $id The id of the topic.
	 * @param $section_id The id of the forum which the topic belongs to.
	 
	 * @return boolean
	 * 
	 * @todo Change the name of this function to restoreTopic
	 */
	public function unTrashSubject( $id, $section_id )
	{
 		if ( empty( $id ) or empty( $section_id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM unTrashSubject() -- EMPTY id', E_USER_ERROR );
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'0' );
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		
		if ( $query )
		{
			$this->engine->reply->unTrashReplies( $id, $section_id );
			
			$this->engine->section->updateSubjectNumber( $section_id, null );
			
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
	
	/**
	 * Gets topics list to be shown for public. This function eliminates the topics
	 * that forbidden to be shown for the current member. For instance deleted topics, topics which
	 * belong to a forum which the current member has no permission to access it. It's a really important
	 * function for any page that needs to show topics list such as (latest topics, search results etc...)
	 * 
	 * @param $filter The SQL filter
	 * @param $get_number (Default value : false) if it's true the function will return the number of rows
	 */
	public function getPublicTopicList( $filter = null, $get_number = false )
	{
		$this->engine->rec->table = $this->engine->table[ 'subject' ];
		$this->engine->rec->filter = $filter;
		
		if ( !is_null( $filter ) )
			$this->engine->rec->filter .= ' AND ';
		
		$this->engine->rec->filter .= "(delete_topic<>'1'";
		
		if ( is_array( $this->engine->_CONF[ 'forbidden_forums' ] ) and sizeof( $this->engine->_CONF[ 'forbidden_forums' ] ) > 0 )
			foreach ( $this->engine->_CONF[ 'forbidden_forums' ] as $forum_id )
				$this->engine->rec->filter .= " AND section<>'" . (int) $forum_id . "'";
		
		$this->engine->rec->filter .= ')';
		
		if ( !$get_number )
			$this->engine->rec->getList();
		else
			return $this->engine->rec->getNumber();
		
		// That was a black magic :-/
	}
}
 
?>
