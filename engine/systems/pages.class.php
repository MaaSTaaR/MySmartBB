<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartPages
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	9/3/2006 , 8:31 PM
 * @end   		: 	9/3/2006 , 8:33 PM
 * @updated 	: 	02/08/2010 08:54:08 PM 
 */
 
class MySmartPages
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
	
	public function insertPage()
	{
		$this->engine->rec->table = $this->engine->table[ 'pages' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function updatePage()
	{
 		$this->engine->rec->table = $this->engine->table[ 'pages' ];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function deletePage()
	{
 		$this->engine->rec->table = $this->engine->table[ 'pages' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	public function getPageInfo()
	{
 		$this->engine->rec->table = $this->engine->table['pages'];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
	public function getPagesList()
	{
 		$this->engine->rec->table = $this->engine->table[ 'pages' ];
 		
 	 	$this->engine->rec->getList();
	}
	
	/* ... */
	
	function GetPagesNumber()
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->engine->table['pages'];
		
		$num = $this->engine->records->GetNumber($param);
		
		return $num;
	}
}
 
?>
