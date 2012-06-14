<?php

/**
 * @package 	: 	MySmartIcons
 * @author		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start		: 	21/09/2007 10:28:43 PM 
 * @updated 	:	Thu 28 Jul 2011 11:00:18 AM AST 
 */

class MySmartIcons
{
	private $engine;
	private $table;
	
	public $id;
	public $get_id;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
		$this->table = $this->engine->table[ 'smiles' ];
	}
	
	// ... //
	
	public function insertSmile()
	{
		$this->engine->rec->table = $this->table;
		
		if ( !is_array( $this->engine->rec->fields ) )
		{
			$this->engine->rec->fields = array();
		}
		
		$this->engine->rec->fields[ 'smile_type' ] = '0';
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	// ... //
	
 	public function updateSmile()
 	{
		$this->engine->rec->table = $this->table;
		
		if ( !is_array( $this->engine->rec->fields ) )
		{
			$this->engine->rec->fields = array();
		}
		
		$this->engine->rec->fields[ 'smile_type' ] = '0';
		
		$query = $this->engine->rec->update();
		
		return ( $query ) ? true : false;
 	}
 	
 	// ... //
 	
	public function deleteSmile()
	{
 		$this->engine->rec->table = $this->table;
 		
		$statement = "smile_type='0'";
		
		if ( isset( $this->engine->rec->filter ) )
		{
			$this->engine->rec->filter .= ' AND ' . $statement;
		}
		else
		{
			$this->engine->rec->filter = $statement;
		}
		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	// ... //
	
	public function getSmileList()
	{ 
     	$this->engine->rec->table = $this->table;
		
		$statement = "smile_type='0'";
		
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
	
	public function getCachedSmiles()
	{
		$cache = $this->engine->_CONF[ 'info_row' ][ 'smiles_cache' ];
		
		$cache = $this->engine->func->htmlDecode( $cache );
		
		$cache = unserialize( $cache );
		
		return $cache;
	}
	
	// ... //
	
	public function getSmileInfo()
	{
 		$this->engine->rec->table = $this->table;
				
		$statement = "smile_type='0'";
		
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
	
 	public function createSmilesCache()
 	{	
		$cache 	= 	array();
		$x		=	0;
		
		$this->getSmileList();
		
		while ( $row = $this->engine->rec->getInfo() )
		{
			$cache[$x]					= 	array();
			$cache[$x]['id']		 	= 	$row['id'];
			$cache[$x]['smile_short'] 	= 	$row['smile_short'];
			$cache[$x]['smile_path'] 	= 	$row['smile_path'];
			
			$x += 1;
		}
		
		$cache = serialize( $cache );
		
		return $cache;
 	}
 	
 	// ... //
 	
 	public function updateSmilesCache()
 	{
		$cache = $this->createSmilesCache();
		
		$update_cache = $this->engine->info->updateInfo( 'smiles_cache', $cache );
		
		return ($update_cache) ? true : false;
 	}
 	
 	// ... //
 	
 	public function getSmilesNumber()
 	{
		$this->engine->rec->table = $this->table;
		
		$statement = "smile_type='0'";
		
		if ( isset( $this->engine->rec->filter ) )
		{
			$this->engine->rec->filter .= ' AND ' . $statement;
		}
		else
		{
			$this->engine->rec->filter = $statement;
		}
		
		return $this->engine->rec->getNumber();
 	}
	
 	// ... //
	
	public function insertIcon()
	{
		$this->engine->rec->table = $this->table;
		
		if ( !is_array( $this->engine->rec->fields ) )
		{
			$this->engine->rec->fields = array();
		}
		
		$this->engine->rec->fields[ 'smile_type' ] = '1';
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	// ... //
	
  	public function updateIcon()
 	{
		$this->engine->rec->table = $this->table;
		
		if ( !is_array( $this->engine->rec->fields ) )
		{
			$this->engine->rec->fields = array();
		}
		
		$this->engine->rec->fields[ 'smile_type' ] = '1';
		
		$query = $this->engine->rec->update();
		
		return ( $query ) ? true : false;

 	}
 	
 	// ... //
 	
	public function deleteIcon()
	{
 		$this->engine->rec->table = $this->table;
 		
		$statement = "smile_type='1'";
		
		if ( isset( $this->engine->rec->filter ) )
		{
			$this->engine->rec->filter .= ' AND ' . $statement;
		}
		else
		{
			$this->engine->rec->filter = $statement;
		}
		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
    
    // ... // 
	
	public function getIconList()
	{
		$this->engine->rec->table = $this->table;
		
		$statement = "smile_type<>'0'";
		
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
    
	public function getIconInfo()
	{
 		$this->engine->rec->table = $this->table;
				
		$statement = "smile_type='1'";
		
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
}

?>
