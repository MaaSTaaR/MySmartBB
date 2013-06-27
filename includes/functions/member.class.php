<?php

/**
 * @package MySmartMember
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @license GNU GPL 
*/

class MySmartMember
{
	private $engine;
	private $table;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
		$this->table = $this->engine->table[ 'member' ];
	}
	
	// ... //
	
	/**
	 * Checks username and password, If they are correct so log the user in by registering the cookies.
	 * 
	 * @param $username The username
	 * @param $password The password hashed with md5()
	 * @param $expire Cookie's expiration time, default value if null
	 * 
	 * @return false if the username and password are not correct.
	 * 
	 * @see MySmartMember::checkMember()
	 */
	public function loginMember( $username, $password, $expire = null )
	{
		if ( empty( $username ) or empty( $password ) )
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM loginMember() -- EMPTY username or password', E_USER_ERROR );
		
		$checkMember = $this->checkMember( $username, $password );

		if ( !$checkMember )
			return false;
		
		setcookie( $this->engine->_CONF[ 'username_cookie' ], $username, $expire, $this->engine->_CONF[ 'bb_path' ] );
		setcookie( $this->engine->_CONF[ 'password_cookie' ], $password, $expire, $this->engine->_CONF[ 'bb_path' ] );
		
		return $checkMember;
	}
	
	// ... //
	
	/**
	 * Checks if the username and password are correct then return an array which
	 * contains the information of member, otherwise returns false
	 * 
	 * @param $username The username
	 * @param $password The password hashed with md5()
	 * 
	 * @return Array of member's information or false if there is no such memer.
	 */
	public function checkMember( $username, $password )
	{
		if ( empty( $username ) or empty( $password ) )
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM checkMember() -- EMPTY username or password' );
		
		$this->engine->rec->table = $this->table;
		$this->engine->rec->filter = "username='" . $username . "' AND password='" . $password . "'";
		
		$checkMember = $this->engine->rec->getInfo();
		
		return ( !$checkMember ) ? false : $checkMember;
	}
	
	// ... //
	
	/**
	 * Logs the current member out by deleting the cookies and the member from online table
	 * 
	 * @return boolean
	 */
	public function logout()
	{
		$this->engine->rec->table = $this->engine->table[ 'online' ];
		$this->engine->rec->filter = "user_id='" . (int) $this->engine->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$this->engine->rec->delete();
		
		$del = array();

		$del[ 1 ] = setcookie( $this->engine->_CONF[ 'username_cookie' ], '', 0, $this->engine->_CONF[ 'bb_path' ] );
     	$del[ 2 ] = setcookie( $this->engine->_CONF[ 'password_cookie' ], '', 0, $this->engine->_CONF[ 'bb_path' ] );
     	$del[ 3 ] = setcookie( $this->engine->_CONF[ 'forum_password_cookie' ], '', 0, $this->engine->_CONF[ 'bb_path' ] );
     	
     	return ( $del[ 1 ] and $del[ 2 ] and $del[ 3 ] ) ? true : false;
	}
	
	// ... //
	
	/**
	 * Gets the username in a stylish way.
	 * 
	 * @param $username The username of the member.
	 * @param $style The style of the username in the following form <html_tag>[username]</html_tag>.
	 * 					for example <strong>[username]</strong>.
	 * 					We usually get this value from "username_style" field in group table from the database.
	 * 
	 * @return The styled username as the following <html_tag>$username</html_tag>
	 */
	public function getUsernameWithStyle( $username, $style )
	{
		if ( empty( $username ) or empty( $style ) )
			trigger_error( 'ERROR::NEED_PARAMATER -- FROM getUsernameWithStyle() -- EMPTY style or username' );
		
		// TODO : why not using str_replace instead? that will do the job in just one line.
		
		$html_tags = explode( '[username]', $style );
    					  
		$res  = $html_tags[ 0 ];
		$res .= $username;
		$res .= $html_tags[ 1 ];
		
		return $res;
	}
	
	// ... //
	
	/**
	 * Registers the previous visit date on a cookie, and the current visit date on the database, 
	 * so we can show for the member when did he visit the forum last time according the the cookie.
	 * 
	 * @param $last_visit The previous visit date.
	 * @param $date The current visit date.
	 * @param $member_id The id of the member to be updated.
	 * 
	 */
	public function lastVisitCookie( $last_visit, $date, $member_id )
	{
		// ... //
		
		if ( empty( $last_visit ) or empty( $date ) or empty( $member_id ) )
			trigger_error('ERROR::NEED_PARAMETER -- FROM lastVisitCookie() -- EMPTY last_visit OR date OR id',E_USER_ERROR);
		
		// ... //
		
		$cookie = setcookie( $this->engine->_CONF[ 'lastvisit_cookie' ], $last_visit, time() + 85200 );
		
		$this->engine->rec->table = $this->table;
		$this->engine->rec->fields = array(	'lastvisit'	=>	$date	);
		$this->engine->rec->filter = "id='" . $member_id . "'";
								
		$query = $this->engine->rec->update();
	}
	
	// ... //
	
	/**
	 * Gets the number of members who have at least one post.
	 * 
	 * @return The number of members
	 */
	public function getActiveMemberNumber()
	{
		$this->engine->rec->table = $this->table;
		$this->engine->rec->filter = "posts>'0'";
		
		$num = $this->engine->rec->getNumber();
		
		return $num;
	}
	
	// ... //
	
	/**
	 * Cleans the new_password field of a specific member, This field
	 * used to reset the password after forgetting it.
	 * 
	 * @param $id The id of the member.
	 */
	public function cleanNewPassword( $id )
	{
		$this->engine->rec->table = $this->table;
		
		$this->engine->rec->fields = array(	'new_password'	=>	'' );
		$this->engine->rec->filter = "id='" . $id . "'";
		
		$query = $this->engine->rec->update();
	}
	
	// ... //
	
	/**
	 * Checks if the username and password are correct, if so checks if the member is the administrator.
	 * 
	 * @param $username The username.
	 * @param $password The password hashed with md5.
	 * 
	 * @return false if the username and password are incorrect, otherwise an array of member's information.
	 * 
	 * @see MySmartMember::checkMember()
	 */
	public function checkAdmin( $username, $password )
	{
 		if ( empty( $username ) or empty( $password ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM checkAdmin() -- EMPTY username OR password', E_USER_ERROR );
 		
		$CheckMember = $this->checkMember( $username, $password );
		
		if ( $CheckMember != false )
		{
			$this->engine->rec->table = $this->engine->table[ 'group' ];
			$this->engine->rec->filter = "id='" . $CheckMember[ 'usergroup' ] . "'";
			
			$GroupInfo = $this->engine->rec->getInfo();
			
			if ( $GroupInfo != false )
				return ( $GroupInfo[ 'admincp_allow' ] ) ? $CheckMember : false;
			else
				return false;
		}
		else
		{
			return false;
		}
	}
	
	// ... //
	
	/**
	 * Log the administrator in after checking the username, password and administrator's permissions.
	 * 
	 * @param $username The username.
	 * @param $password The password hashed with md5.
	 * 
	 * @return boolean
	 */
	public function loginAdmin( $username, $password )
	{
 		if ( empty( $username ) or empty( $password ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM loginAdmin() -- EMPTY username OR password', E_USER_ERROR );
 		
		$Check = $this->checkAdmin( $username, $password );
		
		if ( $Check != false )
		{
			setcookie( $this->engine->_CONF[ 'admin_username_cookie' ], $username );
			setcookie( $this->engine->_CONF[ 'admin_password_cookie' ], $password );
       		
       		return true;
		}
		else
		{
			return false;
		}
	}
	
	// ... //
	
	/**
	 * Returns an array of style information of a specific member,
	 * It tries to retrieve the information from cache, if there is no cache it queries
	 * the database, and gets style's information then creates cache.
	 * 
	 * @param $member_info null or an array that contains member's information as stored in database.
	 * 						if it's null the function gets member's information from MySmartBB::_CONF[ 'member_row' ].
	 * 
	 * @return false or array that contains the information of the style
	 */
	public function getMemberStyle( $member_info = null )
	{
		if ( is_null( $member_info ) )
			$member_info = $this->engine->_CONF[ 'member_row' ];
		
		$style_info = array();
		
		// Is there any cache?
		// Note : If the field should_update_style_cache is true, so we have to update the current cache
		if ( $member_info[ 'style_id_cache' ] == $member_info[ 'style' ]
			and !$member_info[ 'should_update_style_cache' ]
			and !empty( $member_info[ 'style_cache' ] ) )
		{
			$cache = unserialize( base64_decode( $member_info[ 'style_cache' ] ) );
			
			if ( !is_array( $cache )
			    or empty( $cache[ 'style_path' ] )
			    or empty( $cache[ 'image_path' ] )
			    or empty( $cache[ 'template_path' ] )
			    or empty( $cache[ 'cache_path' ] ) )
			{
			    $this->updateMemberStyleCache( $member_info[ 'style' ] );
			    
			    $style_info = $this->engine->style->getStyleInfo( $member_info[ 'style' ] );
			}
			else
			{
				$style_info[ 'style_path' ] 		= 	$cache[ 'style_path' ];
				$style_info[ 'image_path' ] 		= 	$cache[ 'image_path' ];
				$style_info[ 'template_path' ] 		= 	$cache[ 'template_path' ];
				$style_info[ 'cache_path' ] 		= 	$cache[ 'cache_path' ];			
				$style_info[ 'id' ] 				= 	$member_info[ 'style' ];
			}
		}
		// TODO : Just use else?
		else if ( $member_info[ 'style_id_cache' ] != $member_info[ 'style' ] 
				or ( $member_info['should_update_style_cache'] )
				or empty( $member_info[ 'style_cache' ] ) )
		{
			$style_info = $this->engine->style->getStyleInfo( $member_info[ 'style' ] );
			
			$this->updateMemberStyleCache( $style_info );
		}
		else
		{
			return false;
		}
		
		return $style_info;
	}
	
	// ... //
	
	/**
	 * Updates style cache of the member
	 * 
	 * @param $style_info an array of style information as represented in database, or the id of the style.
	 * @param $member_info null or an array that contains member's information as stored in database.
	 * 						if it's null the function gets member's information from MySmartBB::_CONF[ 'member_row' ].
	 * 
	 * @return if success true, otherwise false.
	 */
	public function updateMemberStyleCache( $style_info, $member_info = null )
	{
		if ( is_null( $member_info ) )
			$member_info = $this->engine->_CONF[ 'member_row' ];
		
	    $style_cache = $this->engine->style->createStyleCache( $style_info );
	    
	    // ... //
	    
	    $this->engine->rec->table = $this->engine->table[ 'member' ];
		$this->engine->rec->fields = array(	'style_cache'		=>	$style_cache,
											'style_id_cache'	=>	$member_info[ 'style' ]	);
		
		if ( $member_info[ 'should_update_style_cache' ] )
			$this->engine->rec->fields[ 'should_update_style_cache' ] = '0';
		
		$this->engine->rec->filter = "id='" . (int) $member_info[ 'id' ] . "'";
		
		$update_cache = $this->engine->rec->update();
		
		// ... //
		
		return ( $update_cache ) ? true : false;
	}
	
	// ... //
	
	/**
	 * Formats the information of member to show it in pages.
	 * 
	 * @param $member_info an array that contains member's information as stored in database. It's a reference.
	 */
	public function processMemberInfo( &$member_info )
	{
		// ... //
		
		if ( is_numeric( $member_info[ 'register_date' ] ) )
			$member_info[ 'register_date' ] = $this->engine->func->date( $member_info[ 'register_date' ] );
		
		// ... //
		
		// Convert the writer's gender to a readable text
		$member_info[ 'user_gender' ] 	= 	str_replace( 'm', $this->engine->lang[ 'male' ], $member_info[ 'user_gender' ] );
		$member_info[ 'user_gender' ] 	= 	str_replace( 'f', $this->engine->lang[ 'female' ], $member_info[ 'user_gender' ] );
		
		// ... //
		
		// The status of the member (online or offline)
		if ( $member_info[  'logged' ] < $this->engine->_CONF[ 'timeout' ] )
			$this->engine->template->assign( 'status', 'offline' );
		else
			$this->engine->template->assign( 'status', 'online' );
		
		// ... //
		
		// Format the away message
		if ( !empty( $member_info[ 'away_msg' ] ) )
			$this->engine->smartparse->replace_smiles( $member_info[ 'away_msg' ] );
		
		// ... //
		
		// The username to be shown
		if ( empty( $member_info[ 'username_style_cache' ] ) )
		{
			$member_info[ 'display_username' ] = $member_info[ 'username' ];
		}
		else
		{
			$member_info[ 'display_username' ] = $member_info[ 'username_style_cache' ];
			$member_info[ 'display_username' ] = $this->engine->func->htmlDecode( $member_info[ 'display_username' ] );
		}
		
		// ... //
		
		// The writer's signture isn't empty 
		if ( !empty( $member_info[ 'user_sig' ] ) )
		{
			$member_info[ 'user_sig' ] = $this->engine->smartparse->replace( $member_info[ 'user_sig' ] );
			$this->engine->smartparse->replace_smiles( $member_info[ 'user_sig' ] );
		}
		
		// ... //
	}
	
	/**
	 * Indicates that members' forbidden forums list need to be updated after the modifying of
	 * forums' permissions. If the parameters are null (which is the default value) the update
	 * will affect all members.
	 * 
	 * @param $member_id Can be null, or the id of the member to be updated.
	 * @param $group_id Can be null, or the id of the group which the members who belong to should be updated
	 * 
	 * @return true/false
	 */
	public function needUpdatesForbiddenForums( $member_id = null, $group_id = null )
	{
		$this->engine->rec->table = $this->engine->table[ 'member' ];
		$this->engine->rec->fields = array( 'need_update_forbidden_forums' => '1' );
		
		$this->engine->rec->filter = null;
		
		if ( !is_null( $member_id ) )
			$this->engine->rec->filter .= "id='" . $member_id . "'";
		
		if ( !is_null( $group_id ) )
			$this->engine->rec->filter .= "usergroup='" . $group_id . "'";
		
		$update = $this->engine->rec->update();
		
		if ( $update and is_null( $member_id ) )
			$update = $this->engine->info->updateInfo( 'need_update_global_forbidden_forums', '1' );
		
		return ( $update ) ? true : false;
	}
}

?>
