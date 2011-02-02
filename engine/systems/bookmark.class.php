<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartBookmark
 * @author 		: 	Ehab J. Ghazall <Ghazallsyria@gmail.com>
 * @start 		: 	15/2/2009 , 3:31 PM
 * @end   		: 	05/07/2010 11:01:50 PM 
*/
 
class MySmartBookmark
{
	public $id;
	private $engine;
	
	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
	public function insertSubject()
	{
		$this->engine->rec->table = $this->engine->table[ 'online' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	function UpdateSubject($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           	   
		$query = $this->engine->records->Update($this->engine->table['subjects_bookmark'],$param['field'],$param['where']);
		
		return ($query) ? true : false;
	}
	
	/* ... */
	
	public function deleteSubject()
	{
 		$this->engine->rec->table = $this->engine->table[ 'subjects_bookmark' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	function GetSubjectInfo($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->engine->table['subjects_bookmark'];

		$rows = $this->engine->records->GetInfo($param);
 	 	
		return $rows;
	}
	
	/* ... */
	
	public function getSubjectList()
	{
  		$this->engine->rec->table = $this->engine->table[ 'subjects_bookmark' ];
 		
 	 	$this->engine->rec->getList();
	}
	
	/* ... */
	
	function GetSubjectsNumber()
	{
		if (!isset($param))
		{
			$param 	= array();
		}
		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->engine->table['subjects_bookmark'];
		
		$num = $this->engine->records->GetNumber($param);
		
		return $num;
	}
}
 
?>
