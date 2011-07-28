<?php

/**
 * @package	:	MySmartGroup
 * @author		:	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start		:	5/4/2006 , 6:07 PM
 * @updated		:	Thu 28 Jul 2011 11:13:05 AM AST 
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
			
			$x += 1;
		}
		
		$cache = base64_encode( serialize( $cache ) );
		
		return $cache;
	}
	
	// ... //
	
	public function updateSectionGroupCache( $id )
	{
		$cache = $this->createSectionGroupCache( $id );
		
		$this->engine->rec->table = $this->engine->table['section'];
		
		$this->engine->rec->fields = array(	'sectiongroup_cache'	=>	$cache );
		$this->engine->rec->filter = "id='" . $id . "'";
		
		$query = $this->engine->rec->update();
		
		return $query;
	}
	
	// ... //
}
 
?>
