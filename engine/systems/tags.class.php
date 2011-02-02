<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartTag
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	10/06/2008 03:56:35 AM 
 * @updated 	:	19/07/2010 07:51:36 AM 
 */

class MySmartTag
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
	
	public function insertTag()
	{
		$this->engine->rec->table = $this->engine->table[ 'tag' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
 	function updateTag()
 	{
 		$this->engine->rec->table = $this->engine->table['tag'];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 	
	function DeleteTag($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->engine->table['tag'];
		
		$del = $this->engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	function GetTagList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from']		=	$this->engine->table['tag'];
 		
		$rows = $this->engine->records->GetList($param);
		
		return $rows;
	}
	
	/* ... */
	
	public function getTagInfo()
	{
 		$this->engine->rec->table = $this->engine->table['tag'];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
 	function GetTagNumber($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->engine->table['tag'];
		
		$num   = $this->engine->records->GetNumber($param);
		
		return $num;
 	}
 	
	/* ... */
	
	public function insertSubject()
	{
		$this->engine->rec->table = $this->engine->table[ 'tag_subject' ];
		
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
 			 
		$query = $this->engine->records->Update($this->engine->table['tag_subject'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
 	
	function DeleteSubject($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->engine->table['tag_subject'];
		
		$del = $this->engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	/* ... */
	
	public function getSubjectList()
	{
 		$this->engine->rec->table = $this->engine->table[ 'tag_subject' ];
 		
 	 	$this->engine->rec->getList();
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
		$param['from']		=	$this->engine->table['tag_subject'];
		
		$rows = $this->engine->records->GetInfo($param);
		
		return $rows;
	}
	
	/* ... */
	
 	public function getSubjectNumber()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'tag_subject' ];
 		
 		return $this->engine->rec->getNumber();
 	}
 	
 	/* ... */
}

?>
