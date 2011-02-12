<?php

/**
 * @package	:	MySmartGroup
 * @author		:	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start		:	5/4/2006 , 6:07 PM
 * @end 		:	5/4/2006 , 6:11 PM
 * @updated	:	Wed 09 Feb 2011 12:35:28 PM AST 
 */

class MySmartGroup
{
	private $engine;

	function __construct( $engine )
	{
		$this->engine = $engine;
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
	
	/*function _GetCachedSectionGroup()
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
	}*/
}
 
?>
