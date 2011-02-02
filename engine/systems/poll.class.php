<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartPoll
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@hotmail.com>
 * @start 		: 	09/06/2008 03:47:00 AM 
 * @updated 	:	16/07/2008 11:54:12 PM 
 */

class MySmartPoll
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
	
	public function insertPoll()
	{
		$this->engine->rec->table = $this->engine->table[ 'poll' ];
		
 		$this->engine->fields[ 'answers' ] = serialize( $this->engine->fields[ 'answers' ] );
 		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
			
 	function UpdatePoll($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['field']['answers'] = serialize($param['field']['answers']);
 			 
		$query = $this->engine->records->Update($this->engine->table['poll'],$$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
 	 	
	function DeletePoll($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->engine->table['poll'];
		
		$del = $this->engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
		
	function GetPollList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from']		=	$this->engine->table['poll'];
 		
		$rows = $this->engine->records->GetList($param);
		
		return $rows;
	}
	
	/* ... */
	
	public function getPollInfo()
	{
 		$this->engine->rec->table = $this->engine->table['poll'];
		
		$row = $this->engine->rec->getInfo();
		
		if ( is_array( $row ) )
		{
			$row[ 'answers' ] = unserialize( $row[ 'answers' ] );
		}
		
		return $row;
	}
	
	/* ... */
		
 	function GetPollNumber($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->engine->table['poll'];
		
		$num   = $this->engine->records->GetNumber($param);
		
		return $num;
 	}
}

?>
