<?php

/**
 * @package MySmartGroup
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @since 5/4/2006 , 6:07 PM
 * @license GNU GPL 
 */

class MySmartGroup
{
	private $engine;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	// ... //
	
	/**
	 * Creates a serialzed cache of group's permissions for a specific section.
	 * 
	 * @param $id The id of the section
	 * 
	 * @return Serialized cache.
	 */
	public function createSectionGroupCache( $id )
	{
		$this->engine->rec->table = $this->engine->table[ 'section_group' ];
		$this->engine->rec->order = "id ASC";
		$this->engine->rec->filter = "section_id='" . $id . "'";
		
		$groups = $this->engine->rec->getList();
		
		$cache = array();
		
		while ( $row = $this->engine->rec->getInfo() )
		{
			$cache[ $row[ 'group_id' ] ]					=	array();
			$cache[ $row[ 'group_id' ] ][ 'id' ]			=	$row[ 'id' ];
			$cache[ $row[ 'group_id' ] ][ 'view_section' ]	=	$row[ 'view_section' ];
			$cache[ $row[ 'group_id' ] ][ 'main_section' ]	=	$row[ 'main_section' ];
		}
		
		$cache = base64_encode( serialize( $cache ) );
		
		return $cache;
	}
	
	// ... //
	
	/**
	 * Updates the cache of group's permissions for a specific section.
	 * 
	 * @param $id The id of the section.
	 * 
	 * @return boolean
	 * 
	 * @see MySmartGroup::createSectionGroupCache()
	 */
	public function updateSectionGroupCache( $id )
	{
		$cache = $this->createSectionGroupCache( $id );
		
		$this->engine->rec->table = $this->engine->table[ 'section' ];
		
		$this->engine->rec->fields = array(	'sectiongroup_cache'	=>	$cache );
		$this->engine->rec->filter = "id='" . $id . "'";
		
		$query = $this->engine->rec->update();
		
		return $query;
	}
	
	// ... //
}
 
?>
