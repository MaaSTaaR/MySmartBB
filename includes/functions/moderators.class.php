<?php

/**
 * @package 	: 	MySmartModerators
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@hotmail.com>
 * @start 		: 	18/05/2008 04:53:56 PM 
 * @updated 	:	Wed 09 Feb 2011 12:52:46 PM AST 
 */

class MySmartModerators
{
	private $engine;
	
	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
 	/* ... */
	
 	public function createModeratorsCache( $section_id )
 	{
 		$this->engine->rec->table = $this->engine->table[ 'moderators' ];
 		$this->engine->rec->filter = "section_id='" . $section_id . "'";
 		
		$this->engine->rec->getList();
		
 		$cache 	= 	array();
 		$x		=	0;
 		
		while ( $row = $this->engine->rec->getInfo() )
		{
			$cache[$x] 					= 	array();
			$cache[$x]['id']		 	= 	$row['id'];
			$cache[$x]['section_id'] 	= 	$row['section_id'];
			$cache[$x]['member_id'] 	= 	$row['member_id'];
			$cache[$x]['username'] 		= 	$row['username'];
			
			$x += 1;
		}
		
		$cache = serialize( $cache );
		
		return $cache;
 	}
 	
 	/* ... */
 	
 	// When the parameter "$is_id = true", so use the field "member_id" otherwise use the field "username" to compare with "$value"
 	public function isModerator( $value, $section_id, $is_id = false )
 	{
 		if ( !isset( $value )
 			or !isset( $section_id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM isModerator() -- EMPTY value or section_id');
 		}
 		
 		$this->engine->rec->table = $this->engine->table['moderators'];
 		
 		$this->engine->rec->filter = "section_id='" . $section_id . "'";
 		
 		if ( $is_id )
 		{
 			$this->engine->rec->filter .= " AND member_id='" . $value . "'";
 		}
 		else
 		{
 			$this->engine->rec->filter .= " AND username='" . $value . "'";
 		}
 		
    	$num = $this->engine->rec->getNumber();
    	 	
    	return ($num <= 0) ? false : true;
 	}
 	
 	/* ... */
}

?>
