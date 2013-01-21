<?php

/**
 * @package MySmartToolbox
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @since 21/09/2007 10:30:28 PM 
 * @license GNU GPL 
 */

class MySmartToolbox
{
	private $engine;
	
	public $id;
	public $get_id;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	// ... //
	
 	public function insertFont()
 	{	
		$this->engine->rec->table = $this->engine->table[ 'toolbox' ];
		
		if ( !is_array( $this->engine->rec->fields ) )
		{
			$this->engine->rec->fields = array();
		}
		
		$this->engine->rec->fields[ 'tool_type' ] = 1;
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
 	}
 	
 	// ... //
 	
	public function getFontsList()
	{
		$this->engine->rec->table = $this->engine->table[ 'toolbox' ];
 		
 		$statement = "tool_type='1'";
 		
 		if ( isset( $this->engine->rec->filter ) )
 		{
 			$this->engine->rec->filter .= ' AND ' . $statement;
 		}
 		else
 		{
 			$this->engine->rec->filter = $statement;
 		}
 		
 	 	$this->engine->rec->getList();
	}
	
	// ... //
	
 	public function updateFont()
 	{
 		$this->engine->rec->table = $this->engine->table['toolbox'];
 		
 		if ( !is_array( $this->engine->rec->fields ) )
		{
			$this->engine->rec->fields = array();
		}
		
		$this->engine->rec->fields[ 'tool_type' ] = 1;
		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
 	// ... //
 	
	public function getFontInfo()
	{
 		$this->engine->rec->table = $this->engine->table['toolbox'];
		
		$statement = "tool_type='1'";
 		
 		if ( isset( $this->engine->rec->filter ) )
 		{
 			$this->engine->rec->filter .= ' AND ' . $statement;
 		}
 		else
 		{
 			$this->engine->rec->filter = $statement;
 		}
 		
		return $this->engine->rec->getInfo();
	}
	
	// ... //
	
	public function deleteFont()
	{
 		$this->engine->rec->table = $this->engine->table[ 'toolbox' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	// ... //
	
 	public function insertColor()
 	{
		$this->engine->rec->table = $this->engine->table[ 'toolbox' ];
		
		if ( !is_array( $this->engine->rec->fields ) )
		{
			$this->engine->rec->fields = array();
		}
		
		$this->engine->rec->fields[ 'tool_type' ] = 2;
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
 	}
 	
 	// ... //
 	
	public function getColorsList()
	{
		$this->engine->rec->table = $this->engine->table[ 'toolbox' ];
 		
 		$statement = "tool_type='2'";
 		
 		if ( isset( $this->engine->rec->filter ) )
 		{
 			$this->engine->rec->filter .= ' AND ' . $statement;
 		}
 		else
 		{
 			$this->engine->rec->filter = $statement;
 		}
 		
 	 	$this->engine->rec->getList();
	}
 	
 	// ... //
 	
  	public function updateColor()
 	{
 		$this->engine->rec->table = $this->engine->table['toolbox'];
 		
 		if ( !is_array( $this->engine->rec->fields ) )
		{
			$this->engine->rec->fields = array();
		}
		
		$this->engine->rec->fields[ 'tool_type' ] = 2;
		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
 	// ... //
 	
 	public function getColorInfo()
	{
 		$this->engine->rec->table = $this->engine->table['toolbox'];
		
		$statement = "tool_type='2'";
 		
 		if ( isset( $this->engine->rec->filter ) )
 		{
 			$this->engine->rec->filter .= ' AND ' . $statement;
 		}
 		else
 		{
 			$this->engine->rec->filter = $statement;
 		}
 		
		return $this->engine->rec->getInfo();
	}
	
	// ... //
	
	public function deleteColor()
	{
 		$this->engine->rec->table = $this->engine->table[ 'toolbox' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	// ... //
}

?>
