<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartAttach
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	2/8/2006 , 1:14 PM
 * @updated 	: 	15/07/2010 03:30:51 AM 
 */

class MySmartAttach
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
	
 	public function insertAttach()
 	{
		$this->engine->rec->table = $this->engine->table[ 'attach' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 	
 	public function updateAttach()
 	{
 		$this->engine->rec->table = $this->engine->table['attach'];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 	
	function DeleteAttach($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->engine->table['attach'];
		
		$del = $this->engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	/* ... */
	
	public function getAttachList()
	{
 		$this->engine->rec->table = $this->engine->table[ 'attach' ];
 		
 	 	$this->engine->rec->getList();
	}
	
	/* ... */
	
	function GetAttachNumber($param)
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->engine->table['attach'];
		
		$num = $this->engine->records->GetNumber($param);
		
		return $num;
	}
	
	/* ... */
	
	public function getAttachInfo()
	{
 		$this->engine->rec->table = $this->engine->table['attach'];
		
		return $this->engine->rec->getInfo();

	}
	
	/* ... */
	
}

?>
