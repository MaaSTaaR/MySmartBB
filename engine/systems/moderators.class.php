<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartModerators
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@hotmail.com>
 * @start 		: 	18/05/2008 04:53:56 PM 
 * @updated 	:	06/07/2010 11:19:41 AM 
 */

class MySmartModerators
{
	private $engine;
	
	public $id;
	public $get_id;
	
	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
	public function insertModerator()
	{
		$this->engine->rec->table = $this->engine->table[ 'moderators' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
 	public function updateModerator()
 	{
 		$this->engine->rec->table = $this->engine->table['moderators'];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 	
	public function deleteModerator()
	{
 		$this->engine->rec->table = $this->engine->table[ 'moderators' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	public function getModeratorList()
	{
 		$this->engine->rec->table = $this->engine->table[ 'moderators' ];
 		
 	 	$this->engine->rec->getList();
	}
	
	/* ... */
	
	public function getModeratorInfo()
	{
 		$this->engine->rec->table = $this->engine->table['moderators'];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
 	function GetModeratorsNumber($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->engine->table['moderators'];
		
		$num   = $this->engine->records->GetNumber($param);
		
		return $num;
 	}
 	
 	/* ... */
	
 	public function createModeratorsCache( $section_id )
 	{
 		$this->engine->rec->filter = "section_id='" . $section_id . "'";
 		
		$this->getModeratorList();
		
 		$cache 	= 	array();
 		$x		=	0;
 		
		while ( $row = $this->engine->rec->getInfo() )
		{
			$cache[$x] 					= 	array();
			$cache[$x]['id']		 	= 	$row['id'];
			$cache[$x]['section_id'] 	= 	$row['section_id'];
			$cache[$x]['member_id'] 	= 	$row['member_id'];
			$cache[$x]['username'] 		= 	$row['username'];
			
			$x += 1;
		}
		
		$cache = serialize( $cache );
		
		return $cache;
 	}
 	
 	/* ... */
 	
 	// When the parameter "$is_id = true", so use the field "member_id" otherwise use the field "username" to compare with "$value"
 	public function isModerator( $value, $section_id, $is_id = false )
 	{
 		if ( !isset( $value )
 			or !isset( $section_id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM isModerator() -- EMPTY value or section_id');
 		}
 		
 		$this->engine->rec->table = $this->engine->table['moderators'];
 		
 		$this->engine->rec->filter = "section_id='" . $section_id . "'";
 		
 		if ( $is_id )
 		{
 			$this->engine->rec->filter .= " AND member_id='" . $value . "'";
 		}
 		else
 		{
 			$this->engine->rec->filter .= " AND username='" . $value . "'";
 		}
 		
    	$num = $this->engine->rec->getNumber();
    	 	
    	return ($num <= 0) ? false : true;
 	}
 	
 	/* ... */
}

?>
