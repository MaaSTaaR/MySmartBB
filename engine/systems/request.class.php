<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartRequest
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	15/7/2006 , 12:50 AM
 * @end   		: 	15/7/2006 , 12:57 AM
 * @updated 	: 	18/07/2010 04:58:41 AM 
 */

class MySmartRequest
{
	public $id;
	private $engine;
	
	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
	public function insertRequest()
	{
		$this->engine->rec->table = $this->engine->table[ 'requests' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function getRequestInfo()
	{
 		$this->engine->rec->table = $this->engine->table['requests'];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
	public function deleteRequest()
	{
  		$this->engine->rec->table = $this->engine->table[ 'requests' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
}

?>
