<?php

/**
 * @package 	: 	MySmartModerators
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	18/05/2008 04:53:56 PM 
 * @updated 	:	Thu 28 Jul 2011 11:15:50 AM AST 
 */

class MySmartModerators
{
	private $engine;
	private $table;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
		$this->table = $this->engine->table[ 'moderators' ];
	}
	
 	// ... //
	
 	public function createModeratorsCache( $section_id )
 	{
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->filter = "section_id='" . $section_id . "'";
 		
		$this->engine->rec->getList();
		
 		$cache 	= 	array();
 		$x		=	0;
 		
		while ( $row = $this->engine->rec->getInfo() )
		{
			$cache[ $x ] 					= 	array();
			$cache[ $x ][ 'id' ]		 	= 	$row[ 'id' ];
			$cache[ $x ][ 'section_id' ] 	= 	$row[ 'section_id' ];
			$cache[ $x ][ 'member_id' ] 	= 	$row[ 'member_id' ];
			$cache[ $x ][ 'username' ] 		= 	$row[ 'username' ];
			
			$x += 1;
		}
		
		$cache = serialize( $cache );
		
		return $cache;
 	}
 	
 	// ... //
 	
 	// When the parameter "$is_id = true", so use the field "member_id" otherwise use the field "username" to compare with "$value"
 	public function isModerator( $value, $section_id, $is_id = false )
 	{
 		if ( empty( $value )
 			or empty( $section_id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM isModerator() -- EMPTY value or section_id');
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
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
 	
 	// ... //
 	
	public function moderatorCheck( $section_id, $username = null )
	{
		global $MySmartBB;
		
		$Mod = false;
		$user = null;
		
		if ( $MySmartBB->_CONF['member_permission'] )
		{
			if ( !isset( $username ) )
			{
				if ($MySmartBB->_CONF['group_info']['admincp_allow'] 
					or $MySmartBB->_CONF['group_info']['vice'])
				{
					$Mod = true;
				}
				else
				{
					$user = $MySmartBB->_CONF['member_row']['username'];
				}
			}
			else
			{
				$user = $username;
			}
			
			if ( !$Mod )
				$Mod = $MySmartBB->moderator->isModerator( $user, $section_id );
		}
				
		return $Mod;
	}
	
	// ... //
}

?>
