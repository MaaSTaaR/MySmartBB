<?php

/**
 * @package MySmartReply
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @since 12/3/2006 , 11:57 PM (Kuwait : GMT+3)
 * @license GNU GPL
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
	
	/**
	 * Returns the information of replies of a topic with the information of the writer.
	 * 
	 * @param $subject_id The id of the topic that replies belong to.
	 * 
	 * @return An array contains rows of replies and writers or false when not match. The id of reply will be stored as "reply_id"
	 */
	public function getReplyWriterInfo( $subject_id )
	{
		// ... //
		
 		if ( empty( $subject_id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM getReplyWriterInfo()' );
 		
 		// ... //
 		
 		// Fields to be retrieved from member table
		// That helps us to keep the returned array as small as possible, and prevent the member's password to retrieve
		$member_select = array( 'id', 'username', 'user_sig', 'user_country', 'user_gender', 'register_date', 'posts', 'user_title', 
								'visitor', 'avater_path', 'away', 'away_msg', 'hide_online', 'register_time', 'username_style_cache',
								'logged' );
		
		$select = 'reply.*,reply.id AS reply_id';
		
		foreach ( $member_select as $key => $field )
		{
			$select .= ',member.' . $field;
		}
		
		$this->engine->rec->table = $this->table . ' AS reply,' . $this->engine->table[ 'member' ] . ' AS member';
		$this->engine->rec->select = $select;
		
		$this->engine->rec->filter = "delete_topic<>'1' AND reply.subject_id='" . $subject_id . "' AND reply.writer=member.username";
		
		$this->engine->rec->order = 'reply_id ASC';
		
		$this->engine->rec->getList();
	}
	
	// ... //
	
	public function unTrashReply( $id )
	{
 		if ( empty( $id ) )
 			trigger_error('ERROR::NEED_PARAMETER -- FROM unTrashReply() -- EMPTY id',E_USER_ERROR);
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'0'	);
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$update = $this->engine->rec->update();
		
		// After untrash we should recount the number of replies of the subject
		if ( $update )
		{
			$this->engine->rec->table = $this->table;
			$this->engine->rec->filter = "id='" . $id . "'";
			
			$reply_info = $this->engine->rec->getInfo();
			
			$this->engine->subject->updateReplyNumber( $reply_info[ 'subject_id' ], null, null );
			
			$this->engine->section->updateForumCache( -1, $reply_info[ 'section' ] );
			
			return true;
		}
		           
		return false;
	}
	
	// ... //
	
	/**
	 * Restores the replies of a specific topic from the trash. Also recounts the number of replies
	 * of the forum which the topic belongs to. 
	 * 
	 * Note : It's better to use it through MySmartSubject::unTrashSubject or 
	 * 			call MySmartSection::updateForumCache( null, $section_id ) after calling this function.
	 *  		Yes this function does its job correctly but it will not update the cache of the specified
	 *  		forum, so the number of replies for the forum will be shown uncorrectly on the main page. 
	 *
	 * @param $subject_id The id of the topic.
	 * @param $section_id The id of the forum which the topic belongs to.
	 * 
	 * @return boolean
	 *
	 * @todo Change the name of this function to restoreReplies
	 */
	public function unTrashReplies( $subject_id, $section_id )
	{
		// ... //
		
 		if ( empty( $subject_id ) or empty( $section_id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM unTrashReplies()', E_USER_ERROR );
 		
 		// ... //
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'0'	);
 		$this->engine->rec->filter = "subject_id='" . $subject_id . "'";
 		
		$update = $this->engine->rec->update();
		
		if ( $update )
		{
			$this->engine->section->updateReplyNumber( $section_id, null );
			
			return true;
		}
		           
		return false;
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
	
	/**
	 * Moves a reply to trash.
	 * 
	 * @param $id The id of the reply to be deleted
	 * @param $subject_id The id of the topic that reply belongs to.
	 * @param $section_id The id of the forum that the reply belongs to.
	 * 
	 * @return true for success, otherwise false
	 */
	public function moveReplyToTrash( $id, $subject_id, $section_id )
	{
		// ... //
		
 		if ( empty( $id ) or empty( $subject_id ) or empty( $section_id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM moveReplyToTrash() -- EMPTY id' );
 		
 		// ... //
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'1'	);
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		
		if ( $query )
		{
			$this->engine->subject->updateReplyNumber( $subject_id );
			$this->engine->section->updateReplyNumber( $section_id );
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// ... //
	
	/**
	 * Moves all replies of a specific topic to trash.
	 * 
	 * @param $subject_id The id of the topic that we want to delete its replies (actually moving them to trash).
	 * @param $section_id The id of the forum that the topic belongs to, it is required to update the statistics of the forum.
	 * 
	 * @return true for success, otherwise false
	 */
	public function moveRepliesToTrash( $subject_id, $section_id )
	{
		// ... //
		
 		if ( empty( $subject_id ) or empty( $section_id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM moveRepliesToTrash()', E_USER_ERROR );
 		
 		// ... //
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'1'	);
 		$this->engine->rec->filter = "subject_id='" . $subject_id . "'";
 		
		$query = $this->engine->rec->update();
		
		if ( $query )
		{
			$this->engine->section->updateReplyNumber( $section_id, null, null );
			
			return true;
		}

		return false;
	}
	
	// ... //
}

?>
