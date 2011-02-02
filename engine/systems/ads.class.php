<?php

/** PHP5 **/

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package	:	MySmartAds
 * @author		:	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start		:	4/3/2006 , 8:28 PM
 * @end  		:	4/3/2006 , 8:38 PM
 * @updated	:	28/07/2010 01:36:44 PM  
 */

class MySmartAds
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
	 * Insert new ads
	 */
	public function insertAds()
	{
		$this->engine->rec->table = $this->engine->table[ 'ads' ];
		
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
	 * Update ads information
	 */
	public function updateAds()
	{
 		$this->engine->rec->table = $this->engine->table[ 'ads' ];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
		
	public function deleteAds()
	{
 		$this->engine->rec->table = $this->engine->table[ 'ads' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Get ads info
	 */
	public function getAdsInfo($param)
	{
		$this->engine->rec->table = $this->engine->table['ads'];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
	/**
	 * New visitor for the site
	 */
	public function newVisit( $clicks )
	{
		if (empty($clicks)
			and $clicks != 0)
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM NewVisit() -- EMPTY clicks',E_USER_ERROR);
		}
		
		$this->engine->rec->table = $this->engine->table['ads'];
		
		$this->engine->rec->fields = array(	'clicks'	=> $clicks + 1	);
		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Get a random ads to show it
	 */
	public function getRandomAds()
	{
		$this->engine->rec->table = $this->engine->table['ads'];
		
		$this->engine->rec->order = 'RAND()';
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
	public function getAdsNumber()
	{
 		$this->engine->rec->table = $this->engine->table[ 'ads' ];
 		
 		return $this->engine->rec->getNumber();
	}
	
	/* ... */
	
	public function getAdsList()
	{
 		$this->engine->rec->table = $this->engine->table[ 'ads' ];
 		
 	 	$this->engine->rec->getList();
	}
}
 
 ?>
