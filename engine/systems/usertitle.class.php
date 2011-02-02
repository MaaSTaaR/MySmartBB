<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartUsertitle
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	22/3/2006 , 5:05 PM
 * @end   		: 	22/3/2006 , 5:19 PM
 * @updated 	: 	02/08/2010 09:10:54 PM 
 */

class MySmartUsertitle
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
	
	public function insertUsertitle()
	{
		$this->engine->rec->table = $this->engine->table[ 'usertitle' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;	
	}
	
	/* ... */
	
	public function getUsertitleList()
	{
 		$this->engine->rec->table = $this->engine->table[ 'usertitle' ];
 		
 	 	$this->engine->rec->getList();
	}
	
	/* ... */
	
	public function getUsertitleInfo()
	{
 		$this->engine->rec->table = $this->engine->table['usertitle'];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
	public function updateUsertitle()
	{
 		$this->engine->rec->table = $this->engine->table[ 'usertitle' ];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function deleteUsertitle()
	{
 		$this->engine->rec->table = $this->engine->table[ 'usertitle' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	function GetUsertitleNumber($param)
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->engine->table['usertitle'];
		
		$num = $this->engine->records->GetNumber($param);
		
		return $num;
	}
}

?>
