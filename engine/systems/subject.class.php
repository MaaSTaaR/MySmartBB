<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartSubject
 * @author 		: 	Mohammed Q. Hussian <MaaSTaaR@gmail.com>
 * @start 		: 	11/3/2006 , 8:18 PM
 * @end   		: 	11/3/2006 , 8:47 PM
 * @updated 	: 	27/07/2010 05:12:29 PM 
 */
 
class MySmartSubject
{
	public $id;
	private $engine;
	
	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
	public function getSubjectNumber()
	{
 		$this->engine->rec->table = $this->engine->table[ 'subject' ];
 		
 		return $this->engine->rec->getNumber();
	}
	
	/* ... */
	
	public function deleteSubject()
	{
 		$this->engine->rec->table = $this->engine->table[ 'subject' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
 	public function updateSubject()
 	{		
 		$this->engine->rec->table = $this->engine->table['subject'];

 		if ( isset( $this->engine->fields[ 'tags_cache' ] ) )
 		{
 			$this->engine->fields[ 'tags_cache' ] = serialize( $this->engine->fields[ 'tags_cache' ] );
 		}
	
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
	/* ... */
	
	public function getSubjectList()
	{
 		$this->engine->rec->table = $this->engine->table['subject'];
 		
 	 	$this->engine->rec->getList();
	}
	
	/* ... */
 	
	public function getSubjectInfo()
	{
		$this->engine->rec->table = $this->engine->table['subject'];
		
		return $this->engine->rec->getInfo();
	}
 	
 	/* ... */
 	
	/**
	 * Insert a new subject
	 */
	public function insertSubject()
	{
		$this->engine->rec->table = $this->engine->table[ 'subject' ];
		
 		if ( isset( $this->engine->fields[ 'tags_cache' ] ) )
 		{
 			$this->engine->fields[ 'tags_cache' ] = serialize( $this->engine->fields[ 'tags_cache' ] );
 		}
 		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;	    	
	}
	
	/* ... */
	
	public function massDeleteSubject( $section_id )
	{
 		$this->engine->rec->table = $this->engine->table[ 'subject' ];
 		
 		$this->engine->rec->filter = "section_id='" . $section_id . "'";
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	public function massMoveSubject( $to, $from )
	{
 		if ( !isset( $to )
 			or !isset( $from ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM MassMoveSubject() -- EMPTY to OR from',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table[ 'subject' ];
 		
 		$this->engine->rec->fields = array(	'section'	=>	$to	);
 		
 		$this->engine->rec->filter = "section='" . $from . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	/**
	 * A very spiecal function , it gets the subject and its writer,section info in one query
	 */
	public function getSubjectWriterInfo( $id )
	{
		if ( !isset( $id ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM GetSubjectWriterInfo() -- EMPTY id');
		}
		
 		$this->engine->rec->table = $this->engine->table['subject'] . ' AS s,' . $this->engine->table['member'] . " AS m";
 		$this->engine->rec->filter = "s.id='" . $id . "' AND m.username=s.writer";
 		
 		$rows = $this->engine->rec->getInfo();
 		
		return $rows;
	}
	
	/* ... */
	
	public function updateSubjectVisits( $visits, $id )
	{
		if ( !isset( $visits )
			or !isset( $id ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM updateSubjectVisits()',E_USER_ERROR);
		}
		
 		$this->engine->rec->table = $this->engine->table['subject'];
 		
 		$this->engine->rec->fields = array(	'visitor'	=>	$visits + 1	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	function IsFlood()
	{
		if (empty($param['last_time']))
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM IsFlood() -- EMPTY last_time',E_USER_ERROR);
		}
		
		return (($this->engine->_CONF['now'] - $this->engine->_CONF['info_row']['floodctrl']) <= $param['last_time']) ? true : false;
	}
	
	/* ... */
	
	public function updateWriteTime( $write_time, $id )
	{
 		if ( !isset( $id )
 			or !isset( $write_time ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM updateWriteTime() -- EMPTY id or write_time',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['subject'];
 		
 		$this->engine->rec->fields = array(	'write_time'	=>	$write_time	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function updateReplyNumber( $reply_number, $id )
	{
 		if ( !isset( $id )
 			or !isset( $reply_number ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM updateReplyNumber() -- EMPTY id or reply_number',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['subject'];
 		
 		$this->engine->rec->fields = array(	'reply_number'	=>	$reply_number + 1	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function updateLastReplier( $replier, $id )
	{
 		if ( !isset( $id )
 			or !isset( $replier ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM updateLastReplier() -- EMPTY id or reply_number',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['subject'];
 		
 		$this->engine->rec->fields = array(	'last_replier'	=>	$replier	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
 	/**
 	 * Stick subjects
 	 */
	public function stickSubject( $id )
	{
 		if ( !isset( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM stickSubject() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['subject'];
 		
 		$this->engine->rec->fields = array(	'stick'	=>	'1'	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
 	 
 	/**
 	 * Close subjects
 	 */
	public function closeSubject( $reason, $id )
	{
 		if ( !isset( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM closeSubject() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['subject'];
 		
 		$this->engine->rec->fields = array(	'close'	=>	'1',
 											'close_reason'	=>	$reason	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Move subjects 
	 */
	public function moveSubject( $section_id, $subject_id )
	{
 		if ( !isset( $section_id )
 			or !isset( $subject_id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM moveSubject() -- EMPTY section_id or subject_id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['subject'];
 		
 		$this->engine->rec->fields = array(	'section'	=>	$section_id	);
 		
 		$this->engine->rec->filter = "id='" . $subject_id . "'";
 		
		$query = $this->engine->rec->update();
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Move subjects to trash
	 */
	public function moveSubjectToTrash( $reason, $id )
	{
 		if ( !isset( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM moveSubjectToTrash() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['subject'];
 		
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'1',
 											'delete_reason'	=>	$reason	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function unTrashSubject( $id )
	{
 		if ( !isset( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM moveSubjectToTrash() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['subject'];
 		
 		$this->engine->rec->fields = array(	'delete_topic'	=>	'0' );
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Unstick subject
	 */
	public function unStickSubject( $id )
	{
 		if ( !isset( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM unStickSubject() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['subject'];
 		
 		$this->engine->rec->fields = array(	'stick'	=>	'0'	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Open subject
	 */
	public function openSubject( $id )
	{
 		if ( !isset( $id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM openSubject() -- EMPTY id',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['subject'];
 		
 		$this->engine->rec->fields = array(	'close'	=>	'0'	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
		
	}
	
	/* ... */
}
 
?>
