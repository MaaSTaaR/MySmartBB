<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/*
 * @package 	: 	MySmartMember
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @updated 	:   02/08/2010 09:47:05 PM 
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
	
	/* ... */
	
	/**
	 * Insert new member in database
	 */
	public function insertMember()
	{
		$this->engine->rec->table = $this->engine->table[ 'member' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Get members list
	 */
	public function getMemberList()
	{
 		$this->engine->rec->table = $this->engine->table[ 'member' ];
 		
 	 	$this->engine->rec->getList();
	}
	
	/* ... */
	
	/**
	 * Get a member information
	 */
	public function getMemberInfo()
	{
		$this->engine->rec->table = $this->engine->table['member'];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
	/**
	 * Get the total of members
	 */
	public function getMemberNumber()
	{
 		$this->engine->rec->table = $this->engine->table[ 'member' ];
 		
 		return $this->engine->rec->getNumber();
	}
	
	/* ... */
	
	public function updateMember()
	{
 		$this->engine->rec->table = $this->engine->table['member'];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function deleteMember()
	{
 		$this->engine->rec->table = $this->engine->table[ 'member' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Check if the member exists in database or not
	 */
	public function isMember()
	{
		$num = $this->engine->rec->getNumber();
		
		return ($num <= 0) ? false : true;
	}
	
	/* ... */
		  
	/**
	 * Check if user is exists and set cookie to log in
	 *
	 * @param :
	 *			username -> the usename
	 *			password -> the password with md5
	 */
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
	
	/* ... */
		   
	/**
	 * Check if the member information is correct
	 */
	public function checkMember( $username, $password )
	{
		if ( !empty( $username )
			and !empty( $password ) )
		{
			$this->engine->rec->filter = "username='" . $username . "' AND password='" . $password . "'";
		}
		else
		{
			return false;
		}
		
		$checkMember = $this->getMemberInfo();
		
		return (!$checkMember) ? false : $checkMember;
	}
	
	/* ... */
	     	
	/**
	 * Member logout
	 */
	public function logout()
	{
		$del = array();	

		$del[ 1 ] = setcookie( $this->engine->_CONF[ 'username_cookie' ], '' );
     	$del[ 2 ] = setcookie( $this->engine->_CONF[ 'password_cookie' ], '' );
     	
     	return ( $del[ 1 ] and $del[ 2 ] ) ? true : false;
	}
	
	/* ... */
		        	 
	/**
	 * Get the username with the group style
	 */
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
	
	/* ... */
	
	/**
	 * Update the last visit date
	 */
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
		
		$this->rec->fields = array(	'lastvisit'	=>	$date	);
		
		$this->rec->filter = "id='" . $member_id . "'";
								
		$query = $this->updateMember();
	}
	
	/* ... */

	/**
	 * Get the member time
	 */
	 // Probabbly this way is wrong   
	/*function GetMemberTime($param)
	{
		$time   = $this->engine->_CONF['gmt_hour'] + $param['time'];
     	$time   = $time . $this->engine->_CONF['gmt_seconds'];
     	
     	return $time;
	}*/
	
	/* ... */
	
	/**
	 * Get the number of member who have posts > 0
	 */
	public function getActiveMemberNumber()
	{
		$this->engine->table = $this->engine->table['member'];
		$this->engine->filter = "posts>0";
		
		return $this->engine->rec->getNumber();
	}
	
	/* ... */
	
	/**
	 * TODO : play with cache
	 */
	/*
	function GetTeamList()
	{
		$GetGroupList = $this->engine->group->GetGroupList(array(	'sql_statment'	=>	"WHERE forum_team='1'",
																	'way'			=>	'normal'));
		
		for ($i = 0 ; $i <= sizeof($GetGroupList) ; $i++)
		{			
			$GetMemberList = $this->GetMemberList(array(	'sql_statment'	=>	"WHERE usergroup='" . $GetGroupList[$i]['id'] . "'"));
		}
		
		return $GetMemberList;
	}
	*/
	
	/* ... */
	
	public function cleanNewPassword( $id )
	{
		$this->engine->rec->table = $this->engine->table['member'];
		
		$this->engine->rec->fields = array(	'new_password'	=>	'' );
		$this->engine->rec->filter = "id='" . $id . "'";
		
		$query = $this->engine->rec->update();
	}
	
	/* ... */
	
	public function checkAdmin( $username, $password )
	{
 		if (!isset($username)
 			or !isset($password))
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM checkAdmin() -- EMPTY username OR password',E_USER_ERROR);
 		}
 		
		$CheckMember = $this->checkMember( $username, $password );
		
		// Well , this is a member
		if ($CheckMember != false)
		{
			$MySmartBB->rec->filter = "id='" . $CheckMember['usergroup'] . "'";
			
			$GroupInfo = $this->engine->group->getGroupInfo();
			
			if ($GroupInfo != false)
			{
				return ($GroupInfo['admincp_allow']) ? $CheckMember : false;
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
	
	/* ... */
	
	public function loginAdmin( $username, $password )
	{
 		if (empty($username)
 			or empty($password))
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
