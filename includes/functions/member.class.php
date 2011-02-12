<?php

/*
 * @package 	: 	MySmartMember
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @updated 	:   Tue 08 Feb 2011 11:05:42 AM AST 
*/

class MySmartMember
{
	private $engine;
	
	public $id;
	public $get_id;
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	// ... //
	
	public function loginMember( $username, $password, $expire = null )
	{
		if ( empty( $username )
			or empty( $password ) )
		{
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM LoginMember() -- EMPTY username or password', E_USER_ERROR );
		}
		
		$checkMember = $this->checkMember( $username, $password );
		    	       		       
		if ( !$checkMember )
		{
			return false;
		}
		else
		{
			setcookie( $this->engine->_CONF['username_cookie'], $username, $expire );
			setcookie( $this->engine->_CONF['password_cookie'], $password, $expire );
       				
       		return $checkMember;
       	}
	}
	
	// ... //
	
	public function checkMember( $username, $password )
	{
		$this->engine->rec->table = $this->engine->table[ 'member' ];
		
		if ( !empty( $username )
			and !empty( $password ) )
		{
			$this->engine->rec->filter = "username='" . $username . "' AND password='" . $password . "'";
		}
		else
		{
			return false;
		}
		
		$checkMember = $this->engine->rec->getInfo();
		
		return ( !$checkMember ) ? false : $checkMember;
	}
	
	// ... //
	
	public function logout()
	{
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
			trigger_error('ERROR::NEED_PARAMETER -- FROM LastVisitCookie() -- EMPTY last_visit OR date OR id',E_USER_ERROR);
		}
		
		// TODO :: store the name of cookie in a variable like username,password cookies.
		$cookie = setcookie( 'MySmartBB_lastvisit', $last_visit, time()+85200 );
		
		$this->rec->table = $this->table[ 'member' ];
		$this->rec->fields = array(	'lastvisit'	=>	$date	);
		$this->rec->filter = "id='" . $member_id . "'";
								
		$query = $this->rec->update();
	}
	
	// ... //
	
	public function getActiveMemberNumber()
	{
		$this->engine->table = $this->engine->table['member'];
		$this->engine->filter = "posts>0";
		
		return $this->engine->rec->getNumber();
	}
	
	// ... //
	
	public function cleanNewPassword( $id )
	{
		$this->engine->rec->table = $this->engine->table['member'];
		
		$this->engine->rec->fields = array(	'new_password'	=>	'' );
		$this->engine->rec->filter = "id='" . $id . "'";
		
		$query = $this->engine->rec->update();
	}
	
	// ... //
	
	public function checkAdmin( $username, $password )
	{
 		if (!isset($username)
 			or !isset($password))
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM checkAdmin() -- EMPTY username OR password',E_USER_ERROR);
 		}
 		
		$CheckMember = $this->checkMember( $username, $password );
		
		// Well , (s)he is a member
		if ($CheckMember != false)
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
			setcookie($this->engine->_CONF['admin_username_cookie'],$username);
			setcookie($this->engine->_CONF['admin_password_cookie'],$password);
       		
       		return true;
		}
		else
		{
			return false;
		}
	}
}

?>
