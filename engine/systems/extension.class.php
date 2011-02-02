<?php

/** PHP5 **/

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartFileExtension
 * @author		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start		: 	22/3/2006 , 6:01 PM
 * @end  		: 	22/3/2006 , 6:22 PM
 * @updated 	: 	27/07/2010 05:02:26 PM 
 */

class MySmartFileExtension
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
		
	public function insertExtension()
	{
		$this->engine->rec->table = $this->engine->table[ 'extension' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function getExtensionList()
	{
		$this->engine->rec->table = $this->engine->table[ 'extension' ];
		
 	 	$this->engine->rec->getList();
	}
	
	/* ... */
	
	public function getExtensionInfo()
	{
		$this->engine->rec->table = $this->engine->table['extension'];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
	public function updateExtension()
	{
 		$this->engine->rec->table = $this->engine->table[ 'extension' ];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}	
	
	/* ... */
	
	public function deleteExtension()
	{
 		$this->engine->rec->table = $this->engine->table[ 'extension' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
}

?>
