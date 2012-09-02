<?php

/*
 * @package 	: 	MySmartMember
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @updated 	:   Mon 18 Jun 2012 04:30:40 PM AST 
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
	
	// ~ ~ //
	// Description : This function checks the username and password, If they are correct so login the user by registering the cookies.
	// 
	// Returns : 
	//				- false 
	//				- or array contains the information of the user
	// ~ ~ //
	public function loginMember( $username, $password, $expire = null )
	{
		if ( empty( $username ) or empty( $password ) )
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM loginMember() -- EMPTY username or password', E_USER_ERROR );
		
		$checkMember = $this->checkMember( $username, $password );
		    	       		       
		if ( !$checkMember )
		{
			return false;
		}
		else
		{
			setcookie( $this->engine->_CONF[ 'username_cookie' ], $username, $expire );
			setcookie( $this->engine->_CONF[ 'password_cookie' ], $password, $expire );
       				
       		return $checkMember;
       	}
	}
	
	// ... //
	
	// ~ ~ //
	// Description : This function checks the username and password.
	// 
	// Returns : 
	//				- false 
	//				- or array contains the information of the user
	// ~ ~ //
	public function checkMember( $username, $password )
	{
		if ( empty( $username ) or empty( $password ) )
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM checkMember() -- EMPTY username or password', E_USER_ERROR );
		
		$this->engine->rec->table = $this->table;
		$this->engine->rec->filter = "username='" . $username . "' AND password='" . $password . "'";
		
		$checkMember = $this->engine->rec->getInfo();
		
		return ( !$checkMember ) ? false : $checkMember;
	}
	
	// ... //
	
	// ~ ~ //
	// Description : This function logs the user out by deleteing the cookies
	// 
	// Returns : 
	//				- true or false 
	// ~ ~ //
	public function logout()
	{
		$this->engine->rec->table = $this->engine->table[ 'online' ];
		$this->engine->rec->filter = "user_id='" . (int) $this->engine->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$this->engine->rec->delete();
		
		$del = array();

		$del[ 1 ] = setcookie( $this->engine->_CONF[ 'username_cookie' ], '' );
     	$del[ 2 ] = setcookie( $this->engine->_CONF[ 'password_cookie' ], '' );
     	
     	return ( $del[ 1 ] and $del[ 2 ] ) ? true : false;
	}
	
	// ... //
	
	public function getUsernameWithStyle( $username, $style )
	{
		// These codes are from the first generation of MySmartBB
		// Do you remember it ? :)
		
		if ( empty( $username )
			or empty( $style ) )
		{
			trigger_error('ERROR::NEED_PARAMATER -- FROM getUsernameWithStyle() -- EMPTY style or username',E_USER_ERROR);
		}
		
		$html_tags = explode( '[username]', $style );
    					  
		$res  = $html_tags[ 0 ];
		$res .= $username;
		$res .= $html_tags[ 1 ];
		
		return $res;
	}
	
	// ... //
	
	public function lastVisitCookie( $last_visit, $date, $member_id )
	{
		if ( empty( $last_visit )
			or empty( $date )
			or empty( $member_id ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM lastVisitCookie() -- EMPTY last_visit OR date OR id',E_USER_ERROR);
		}
		
		$cookie = setcookie( $this->engine->_CONF[ 'lastvisit_cookie' ], $last_visit, time() + 85200 );
		
		$this->engine->rec->table = $this->table;
		$this->engine->rec->fields = array(	'lastvisit'	=>	$date	);
		$this->engine->rec->filter = "id='" . $member_id . "'";
								
		$query = $this->engine->rec->update();
	}
	
	// ... //
	
	public function getActiveMemberNumber()
	{
		$this->engine->rec->table = $this->table;
		$this->engine->rec->filter = "posts>'0'";
		
		$num = $this->engine->rec->getNumber();
		
		return $num;
	}
	
	// ... //
	
	public function cleanNewPassword( $id )
	{
		$this->engine->rec->table = $this->table;
		
		$this->engine->rec->fields = array(	'new_password'	=>	'' );
		$this->engine->rec->filter = "id='" . $id . "'";
		
		$query = $this->engine->rec->update();
	}
	
	// ... //
	
	public function checkAdmin( $username, $password )
	{
 		if ( empty( $username )
 			or empty( $password ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM checkAdmin() -- EMPTY username OR password',E_USER_ERROR);
 		}
 		
		$CheckMember = $this->checkMember( $username, $password );
		
		// Well , (s)he is a member
		if ( $CheckMember != false )
		{
			$this->engine->rec->table = $this->engine->table[ 'group' ];
			$this->engine->rec->filter = "id='" . $CheckMember[ 'usergroup' ] . "'";
			
			$GroupInfo = $this->engine->rec->getInfo();
			
			if ( $GroupInfo != false )
			{
				return ( $GroupInfo[ 'admincp_allow' ] ) ? $CheckMember : false;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	// ... //
	
	public function loginAdmin( $username, $password )
	{
 		if (empty( $username )
 			or empty( $password ))
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM loginAdmin() -- EMPTY username OR password',E_USER_ERROR);
 		}
 		
		$Check = $this->checkAdmin( $username, $password );
		
		if ($Check != false)
		{
			setcookie( $this->engine->_CONF['admin_username_cookie'], $username );
			setcookie( $this->engine->_CONF['admin_password_cookie'], $password );
       		
       		return true;
		}
		else
		{
			return false;
		}
	}
	
	// ... //
	
	// ~ ~ //
	// Description : 	This function returns and array that contains the information of a style of a specific member,
	//					in the begin it tries to retrieve the information from cache, if there is no cache it queries
	//					the database, and gets style's information then creates cache.
	//
	// Parameters :
	//				- $member_info : 	null or an array that contains member's information as stored in database.
	//									if it's null the function gets member's information from MySmartBB::_CONF[ 'member_row' ]
	// Returns : 
	//				- false 
	//				- or array that contains the information of the style
	// ~ ~ //
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
			// ... //
			
			$this->engine->rec->table = $this->engine->table[ 'style' ];
			$this->engine->rec->filter = "id='" . (int) $member_info['style']  . "'";
			
			$style_info = $this->engine->rec->getInfo();
			
			$this->updateMemberStyleCache( $style_info );
		}
		else
		{
			return false;
		}
		
		return $style_info;
	}
	
	// ... //
	
	public function updateMemberStyleCache( $style_info, $member_info = null )
	{
		if ( is_null( $member_info ) )
			$member_info = $this->engine->_CONF[ 'member_row' ];
		
	    $style_cache = $this->engine->style->createStyleCache( $style_info );
	    
	    $this->engine->rec->table = $this->engine->table[ 'member' ];
		$this->engine->rec->fields = array(	'style_cache'	=>	$style_cache,
											'style_id_cache'	=>	$member_info['style']	);
		
		if ( $member_info[ 'should_update_style_cache' ] )
		{
			$this->engine->rec->fields['should_update_style_cache'] = 0;
		}
		
		$this->engine->rec->filter = "id='" . (int) $member_info['id'] . "'";
		
		$update_cache = $this->engine->rec->update();
		
		return ( $update_cache ) ? true : false;
	}
	
	// ... //
	
	// ~ ~ //
	// Description : 	This function formats the information of member to show it in pages.
	//
	// Parameters :
	//				- $member_info : 	an array that contains member's information as stored in database.
	// Returns : 
	//				- Nothing, it gets the array as a reference.
	// ~ ~ //	
	public function processMemberInfo( &$member_info )
	{
		// ... //
		
		if ( is_numeric( $member_info['register_date'] ) )
		{
			$member_info['register_date'] = $this->engine->func->date( $member_info['register_date'] );
		}
		
		// Convert the writer's gender to a readable text
		$member_info['user_gender'] 	= 	str_replace( 'm', $this->engine->lang[ 'male' ], $member_info['user_gender'] );
		$member_info['user_gender'] 	= 	str_replace( 'f', $this->engine->lang[ 'female' ], $member_info['user_gender'] );
		
		// ... //
		
		// The status of the member (online or offline)
		if ( $member_info[  'logged' ] < $this->engine->_CONF[ 'timeout' ] )
			$this->engine->template->assign( 'status', 'offline' );
		else
			$this->engine->template->assign( 'status', 'online' );
		
		// ... //
		
		// Format the away message
		if ( !empty( $member_info['away_msg'] ) )
			$this->engine->smartparse->replace_smiles( $member_info[ 'away_msg' ] );
		
		// ... //
		
		// The username to show
		if ( empty( $member_info[ 'username_style_cache' ] ) )
		{
			$member_info['display_username'] = $member_info['username'];
		}
		else
		{
			$member_info['display_username'] = $member_info['username_style_cache'];
			$member_info['display_username'] = $this->engine->func->htmlDecode( $member_info['display_username'] );
		}
		
		// ... //
		
		// The writer's signture does'nt empty 
		if ( !empty( $member_info[ 'user_sig' ] ) )
		{
			$member_info['user_sig'] = $this->engine->smartparse->replace($member_info['user_sig']);
			$this->engine->smartparse->replace_smiles($member_info['user_sig']);
		}
		
		// ... //
	}
}

?>
