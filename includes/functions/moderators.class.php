<?php

/**
 * @package 	: 	MySmartModerators
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	18/05/2008 04:53:56 PM 
 * @updated 	:	Mon 05 Sep 2011 11:43:17 AM AST 
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
		
		$cache = base64_encode( serialize( $cache ) );
		
		return $cache;
 	}
 	
 	// ... //
 	
	/**
	 * Checks if the member is a moderator or not
	 *
	 *	@param $value Can be the id or the username of the member who we need to check.
	 *  @param $type Spicifies if $value is an 'id' or 'username'
	 *  @param $section_id The id of the section that we want to check if the member has a permission to moderate it,
	 *                       this parameter can be empty, in this case the function only checks if the member is on the list
	 *                       of moderators or not.
	 *  
	 *  @return true or false
	 */	
 	public function isModerator( $value, $type = 'id', $section_id = null )
 	{
 		// ... //
 		
 		if ( empty( $value ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM isModerator() -- EMPTY value or section_id' );
 		
 		// ... //
 		
 		$filter = '';
 		
  		if ( !is_null( $section_id ) )
 		    $filter .= "section_id='" . $section_id . "' AND ";
 		
 		// ... //
 		
 		if ( $type == 'id' )
 			$filter .= "member_id='" . $value . "'";
 		else
 			$filter .= "username='" . $value . "'";
 		
 		// ... //
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->filter = $filter;
 		
    	$num = $this->engine->rec->getNumber();
    	 	
    	return ( $num <= 0 ) ? false : true;
 	}
 	
 	// ... //
 	
	/**
	 * Checks if a member has a permission to control a specific forum's topics.
	 * 
	 * @param $section_id The id of the section to be checked
	 * @param $username The username of the member to be checked, can be null so the function will check the current member
	 * 
	 * @return true if the member has a permission, otherwise false
	 * 
	 * @see MySmartModerators::isModerator()
	 */
	public function moderatorCheck( $section_id, $username = null )
	{
		$Mod = false;
		$user = null;
		
		// ... //
		
		// Get the username, from the parameter or from member_row array.
		if ( $this->engine->_CONF[ 'member_permission' ] )
		{
			// $username parameter is null.
			// In this case we will check the current member.
			if ( !isset( $username ) )
			{
				// The current member is the administrator or the vice president.
				// Therefore absolutely (s)he has the permission.
				if ( $this->engine->_CONF[ 'group_info' ][ 'admincp_allow' ] 
					or $this->engine->_CONF[ 'group_info' ][ 'vice' ] )
				{
					return true;
				}
				else
				{
					$user = $this->engine->_CONF[ 'member_row' ][ 'username' ];
				}
			}
			else
			{
				$user = $username;
			}
			
			// ... //
			
			// Do the real job.
			$Mod = $this->isModerator( $user, 'username', $section_id );
		}
				
		return $Mod;
	}
	
	// ... //
	
	// ~ ~ //
	// Description : 	This function sets a specific member as a moderator of a specific section
	//
	// Parameters :
	//				- $member_info : 	an array that contains member's information as stored in database.
	//              - $section_info : 	an array that contains section's information as stored in database.
	//              - $group : the id of the group that the member will belong to, it must be a group that has moderators permissions
	//              - $usertitle : a custom user title, can be empty
	// Returns : 
	//				- true or false
	// ~ ~ //	
	public function setModerator( $member_info, $section_info, $group, $usertitle = null )
	{
	    $this->engine->rec->table = $this->table;
		
		$this->engine->rec->fields	=	array();
		$this->engine->rec->fields['username'] 	    = 	$member_info['username'];
		$this->engine->rec->fields['section_id'] 	= 	$section_info['id'];
		$this->engine->rec->fields['member_id'] 	= 	$member_info['id'];
		
		$insert = $this->engine->rec->insert();
		
		if ( $insert )
		{
			// ... //
			
			// ~ Change the group and the usertitle of the member ~ //
			
			$this->engine->rec->table = $this->engine->table[ 'group' ];
			$this->engine->rec->filter = "id='" . (int) $Member['group'] . "'";
			
			$Group = $this->engine->rec->getInfo();
			
			// If the user isn't an admin, so change the group
			if (!$Group['admincp_allow']
				and !$Group['vice']
				and !$Group['group_mod'])
			{
				$this->engine->rec->table = $this->engine->table[ 'member' ];
				
				$this->engine->rec->fields	= array();
				
				$this->engine->rec->fields['usergroup'] = $group;
				$this->engine->rec->fields['user_title'] = ( !empty( $usertitle ) ) ? $usertitle : 'مشرف على ' . $section_info['title'];
				
				$this->engine->rec->filter = "id='" . $member_info[ 'id' ] . "'";
				
				$change = $this->engine->rec->update();
			}
			
			// ... //
			
			// ~ Cache stuff ~ //
			
			$cache = $this->createModeratorsCache( $section_info[ 'id' ] );
			
			$this->engine->rec->table = $this->engine->table[ 'section' ];
			$this->engine->rec->fields	= array();
			$this->engine->rec->fields['moderators'] = $cache;
			
			$this->engine->rec->filter = "id='" . $section_info[ 'id' ] . "'";
			
			$update = $this->engine->rec->update();
			
			$this->engine->section->updateForumCache( $section_info[ 'parent' ], $section_info[ 'id' ] );
		
			return ( $update ) ? true : false;
		}
		
		return false;
	}
	
	// ~ ~ //
	// Description : 	This function unsets a specific member as a moderator of a specific section
	//
	// Parameters :
	//              - $moderator_info : 	an array that contains moderator's information as stored in database.
	//				- $member_info : 	an array that contains member's information as stored in database.
	// Returns : 
	//				- true or false
	// ~ ~ //	
	public function unsetModerator( $moderator_info, $member_info )
	{
		$this->engine->rec->table = $this->table;
		$this->engine->rec->filter = "id='" . $moderator_info[ 'id' ] . "'";
		
		$del = $this->engine->rec->delete();
		
		if ( $del )
		{
		    // We have to check if the member isn't a moderator of another section.
		    // If (s)he is, so we'll not change his/her group or title.
			if ( !$this->isModerator( $moderator_info[ 'member_id' ] ) )
			{
				$this->engine->rec->table = $this->engine->table[ 'group' ];
				$this->engine->rec->filter = "id='" . $member_info['group'] . "'";
				
				$Group = $this->engine->rec->getInfo();
				
				// If the user isn't an admin, so change the group
				if (!$Group['admincp_allow'] and !$Group['vice'])
				{
					$this->engine->rec->table = $this->engine->table[ 'member' ];
					$this->engine->rec->fields	=	array(  'usergroup' =>  '4' );
										
					$this->engine->rec->filter = "id='" . $moderator_info['member_id'] . "'";
					
					$change = $this->engine->rec->update();
				}				
			}
			
			// ... //
			
			$cache = $this->engine->moderator->createModeratorsCache( $moderator_info['section_id'] );
			
			$this->engine->rec->table   =   $this->engine->table[ 'section' ];
			$this->engine->rec->fields  =	array(  'moderators'    =>  $cache  );
			
			$this->engine->rec->filter = "id='" . $moderator_info['section_id'] . "'";
			
			$update = $this->engine->rec->update();
			
			// ... //
			
			// Update the cache of the section
			
			$this->engine->rec->select = 'id,parent';
			$this->engine->rec->table = $this->engine->table[ 'section' ];
			$this->engine->rec->filter = "id='" . $moderator_info['section_id'] . "'";
			
			$section_info = $this->engine->rec->getInfo();
			
			$this->engine->section->updateForumCache( $section_info[ 'parent' ], $section_info[ 'id' ] );
			
			// ... //
			
			return ( $update ) ? true : false;
		}
		
		return false;
	}
}

?>
