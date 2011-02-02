<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package	:	MySmartGroup
 * @author		:	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start		:	5/4/2006 , 6:07 PM
 * @end 		:	5/4/2006 , 6:11 PM
 * @updated	:	24/07/2010 12:17:57 PM 
 */

class MySmartGroup
{
	private $engine;
	
	public $id;
	public $get_id;

	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
	public function insertGroup()
	{
		$this->engine->rec->table = $this->engine->table[ 'group' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function deleteGroup()
	{
 		$this->engine->rec->table = $this->engine->table[ 'group' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	public function updateGroup()
	{
 		$this->engine->rec->table = $this->engine->table['group'];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Get group information
	 */
	public function getGroupInfo()
	{		
		$this->engine->rec->table = $this->engine->table[ 'group' ];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
	public function getGroupList()
	{
		$this->engine->rec->table = $this->engine->table['group'];
		
		$this->engine->rec->getList();
	}
	
	/* ... */
	
	function GetGroupNumber($param)
	{
		if (!isset($param) 
			or !is_array($param))
		{
			$param = array();
		}
		
		$param['select']	=	'*';
		$param['from']		=	$this->engine->table['group'];
		
		$num = $this->engine->rec->GetNumber($param);
		
		return $num;
	}
	
	
	public function createSectionGroupCache( $id )
	{
		$this->engine->rec->order = "id ASC";
		$this->engine->rec->filter = "section_id='" . $id . "'";
		
		$groups = $this->getSectionGroupList();
		
		$cache = array();
		
		while ( $row = $this->engine->rec->getInfo() )
		{
			$cache[$row['group_id']]					=	array();
			$cache[$row['group_id']]['id']				=	$row['id'];
			$cache[$row['group_id']]['view_section']	=	$row['view_section'];
			$cache[$row['group_id']]['main_section']	=	$row['main_section'];
			
			$x += 1;
		}
		
		$cache = base64_encode( serialize( $cache ) );
		
		return $cache;
	}
	
	/* ... */
	
	public function updateSectionGroupCache( $id )
	{
		$cache = $this->createSectionGroupCache( $id );
		
		$this->engine->rec->table = $this->engine->table['section'];
		
		$this->engine->rec->fields = array(	'sectiongroup_cache'	=>	$cache );
		$this->engine->rec->filter = "id='" . $id . "'";
		
		$query = $this->engine->rec->update();
	}
	
	/* ... */
	
	public function insertSectionGroup()
	{
		$this->engine->rec->table = $this->engine->table[ 'section_group' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;

	}
	
	/* ... */
	
	public function deleteSectionGroup()
	{
		$this->engine->rec->table = $this->engine->table[ 'section_group' ];
		
		$query = $this->engine->rec->delete();
		
		return ($query) ? true : false;	
	}
	
	/* ... */
	
	public function updateSectionGroup()
	{
		$this->engine->rec->table = $this->engine->table['section_group'];
		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Get the permisson of group in sections
	 */
	public function getSectionGroupList()
	{
		$this->engine->rec->table = $this->engine->table['section_group'];
		
		$this->engine->rec->getList();
	}
	
	/* ... */
	
	function _GetCachedSectionGroup()
	{
		$cache = $this->engine->_CONF['info_row']['sectiongroup_cache'];
		$cache = unserialize($cache);
				
		return $cache;
	}
	
	function GetSectionGroupNumber($param)
	{
		if (!isset($param) 
			or !is_array($param))
		{
			$param = array();
		}
		
		$param['select']	=	'*';
		$param['from']		=	$this->engine->table['section_group'];
		
		$num = $this->engine->rec->GetNumber($param);
		
		return $num;
	}
	
	/* ... */
	
	public function getSectionGroupInfo()
	{
		$this->engine->rec->table = $this->engine->table[ 'section_group' ];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
}
 
?>
