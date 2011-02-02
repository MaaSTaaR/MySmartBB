<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/*
 * @package 	: 	MySmartAvatar
 * @author 		: 	Mohammed Q. Hussian <MaaSTaaR@gmail.com>
 * @start 		: 	27/2/2006 , 8:00 PM
 * @end   		: 	27/2/2006 , 8:12 PM
 * @updated 	: 	05/07/2010 10:30:29 PM 
*/

class MySmartAvatar
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
	
	public function insertAvatar()
 	{
		$this->engine->rec->table = $this->engine->table[ 'avatar' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 	
	public function updateAvatar()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'avatar' ];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 		
	public function deleteAvatar()
	{
 		$this->engine->rec->table = $this->engine->table[ 'avatar' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Get avatar list from database
 	 */
	public function getAvatarList()
	{
 		$this->engine->rec->table = $this->engine->table[ 'avatar' ];
 		
 	 	$this->engine->rec->getList();
	}
	
	/* ... */
	
	/**
	 * Get avatar info
 	 */
	public function getAvatarInfo()
	{
 		$this->engine->rec->table = $this->engine->table[ 'avatar' ];
		
		return $this->engine->rec->getInfo();		
	}
	
	/* ... */
	
	public function getAvatarNumber()
	{
		$this->engine->rec->table = $this->engine->table['avatar'];
		
 		$num = $this->engine->rec->getNumber();
 		
		return $num;
	}
	
	/* ... */
}

?>
