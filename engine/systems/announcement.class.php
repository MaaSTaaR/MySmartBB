<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartAnnouncement
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	13/3/2006 , 12:06 AM
 * @end   		: 	13/3/2006 , 12:15 AM
 * @updated 	: 	02/08/2010 12:54:05 PM 
 */


class MySmartAnnouncement
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
	
 	/**
 	 * Insert a new announcement
 	 */
 	public function insertAnnouncement()
 	{
		$this->engine->rec->table = $this->engine->table[ 'announcement' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 	
 	/**
 	 * Update an announcement information
 	 */
 	public function updateAnnouncement()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'announcement' ];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 	
	public function deleteAnnouncement()
	{
 		$this->engine->rec->table = $this->engine->table[ 'announcement' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Get the list of announcement
	 */
	public function getAnnouncementList()
	{
 		$this->engine->rec->table = $this->engine->table[ 'announcement' ];
 		
 	 	$this->engine->rec->getList();
	}
	
	/* ... */
	
	/**
	 * Get announcement info
	 */
	public function getAnnouncementInfo()
	{
 		$this->engine->rec->table = $this->engine->table['announcement'];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
	function GetAnnouncementNumber($param)
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->engine->table['announcement'];
		
		$num = $this->engine->records->GetNumber($param);
		
		return $num;
	}
}

?>
