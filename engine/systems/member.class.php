<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/*
 * @package 	: 	MySmartMember
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @updated 	:   16/08/2008 09:45:53 PM 
*/


class MySmartMember
{
	var $id;
	var $Engine;
	
	function MySmartMember($Engine)
	{
		$this->Engine = $Engine;
	}
	
	/**
	 * Insert new member in database
	 *
	 * @access : public
	 * @return : 
	 *				false			->	if the function can't add the member
	 *				true			->	if the function success to add member
	 *
	 * @param :
	 *			username -> the username
	 *			password -> of course the password :)
	 *			email	 -> the email :\
	 *			usergroup
	 *			user_gender
	 *			register_date
	 *			user_title
	 *			style
	 */
	function InsertMember($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->Engine->records->Insert($this->Engine->table['member'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
		}
		           
		return ($query) ? true : false;
	}
	
	/**
	 * Get members list
	 *
	 * @param :
	 *				sql_statment -> complete the sql query
	 */
	function GetMemberList($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->Engine->table['member'];
		
		$rows = $this->Engine->records->GetList($param);
		
		return $rows;
	}
	
	/**
	 * Get member information
	 *
	 * @param :
	 *			get	->	the list of fields
	 */
	function GetMemberInfo($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	(!empty($param['get'])) ? $param['get'] : '*';
		$param['from'] 		= 	$this->Engine->table['member'];
		
		$rows = $this->Engine->records->GetInfo($param);
		
		return $rows;
	}
	
	/**
	 * Get the total of members
	 *
	 * @param :
	 *			get_from	->	cache or db
	 */
	function GetMemberNumber($param)
	{
		if ($param['get_from'] == 'cache')
		{
			$num = $this->Engine->_CONF['info_row']['member_number'];
		}
		elseif ($param['get_from'] == 'db')
		{
			$num = $this->Engine->records->GetNumber(array('select'=>'*','from'=>$this->Engine->table['member']));
		}
		else
		{
			trigger_error('ERROR::BAD_VALUE_OF_GET_FROM_VARIABLE',E_USER_ERROR);
		}
		
		return $num;
	}
	
	function UpdateMember($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$query = $this->Engine->records->Update($this->Engine->table['member'],$param['field'],$param['where']);
				
		return ($query) ? true : false;
	}
	
	function DeleteMember($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['member'];
		
		$del = $this->Engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
	
	///
		 
	/**
	 * Check if the member exists in database or not
	 *
	 * @param :
	 *				way	->
	 						id
	 						username
	 						email
	 *
	 * @return :
	 *				false 	-> if isn't member
	 *				true	-> if is member
	 */
	function IsMember($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['member'];

		$num = $this->Engine->records->GetNumber($param);
				      		      
		return ($num <= 0) ? false : true;
	}
		  
	/**
	 * Check if user is exists and set cookie to log in
	 *
	 * @param :
	 *			username -> the usename
	 *			password -> the password with md5
	 */
	function LoginMember($param)
	{
		if (empty($param['username'])
			or empty($param['password']))
		{
			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
		}
		
		$CheckMember = $this->CheckMember(array('username'	=>	$param['username'],
		       									'password'	=>	$param['password']));
		    	       		       
		if (!$CheckMember)
		{
			return false;
		}
		else
		{
			setcookie($this->Engine->_CONF['username_cookie'],$param['username'],$param['expire']);
			setcookie($this->Engine->_CONF['password_cookie'],$param['password'],$param['expire']);
       				
       		return $CheckMember;
       	}
	}
		   
	/**
	 * Check if the member information is correct
	 *
	 * @param :
	 *			username -> the username
	 *			password -> the password
	 *			object	 -> if this function used in system file we sould identify the system object
	 */
	function CheckMember($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
		
		$MemberArr['get'] = '*';
		
		if (!empty($param['username'])
			and !empty($param['password']))
		{
			$MemberArr['where'] 				= 	array();
			$MemberArr['where'][0] 				= 	array();
			$MemberArr['where'][0]['name'] 		= 	'username';
			$MemberArr['where'][0]['oper'] 		= 	'=';
			$MemberArr['where'][0]['value'] 	= 	$param['username'];
		
			$MemberArr['where'][1] 				= 	array();
			$MemberArr['where'][1]['con'] 		= 	'AND';
			$MemberArr['where'][1]['name'] 		= 	'password';
			$MemberArr['where'][1]['oper'] 		= 	'=';
			$MemberArr['where'][1]['value'] 	= 	$param['password'];
		}
		
		$CheckMember = $this->GetMemberInfo($MemberArr);
		
		return (!$CheckMember) ? false : $CheckMember;
	}
	     	
	/**
	 * Member logout
	 *	
	 */
	function Logout()
	{
		$del = array();	

		$del[1] = setcookie($this->Engine->_CONF['username_cookie'],'');
     	$del[2] = setcookie($this->Engine->_CONF['password_cookie'],'');
     	
     	return ($del[1] and $del[2]) ? true : false;
	}
		        	 
	/**
	 * Get username with group style
	 *
	 * @param :
	 *				username	->	the name of user
	 *				group_style	->	the style of gorup
	 */
	function GetUsernameByStyle($param)
	{
		// These codes from the first generation of MySmartBB
		// Do you remember it ? :)
		
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
		
		if (empty($param['group_style'])
			or empty($param['username']))
		{
			trigger_error('ERROR::NEED_PARAMATER',E_USER_ERROR);
		}
		
		$general_style = $param['group_style'];
		$general_style = explode('[username]',$general_style);
    					  
		$style  = $general_style[0];
		$style .= $this->Engine->sys_functions->CleanVariable($param['username'],'html');
		$style .= $general_style[1];
		
		return $style;
	}
	
	/**
	 * Update the last visit date
	 *
	 * @param :
	 *			last_visit	->	the date
	 */
	function LastVisitCookie($param)
	{
		if (empty($param['last_visit'])
			or empty($param['date'])
			or empty($param['id']))
		{
			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
		}
		
		// TODO :: store the name of cookie in a variable like username,password cookies.
		$cookie = setcookie('MySmartBB_lastvisit',$param['last_visit'],time()+85200);
		
		$UpdateArr 					= 	array();
		
		$UpdateArr['field']					=	array();
		$UpdateArr['field']['lastvisit'] 	= 	$param['date'];
		
		$UpdateArr['where']			=	array('id',$param['id']);
								
		$query = $this->UpdateMember($UpdateArr);
	}
	


	/**
	 * Get the member time
	 */
	 // Probabbly this way is wrong   
	/*function GetMemberTime($param)
	{
		$time   = $this->Engine->_CONF['gmt_hour'] + $param['time'];
     	$time   = $time . $this->Engine->_CONF['gmt_seconds'];
     	
     	return $time;
	}*/
		
	/**
	 * Get the number of member who have posts > 0
	 */
	function GetActiveMemberNumber()
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 			= 	'*';
		$param['from'] 				= 	$this->Engine->table['member'];
		
		$param['where'] 			= 	array();
		$param['where'][0] 			= 	array();
		$param['where'][0]['name'] 	= 	'posts';
		$param['where'][0]['oper'] 	= 	'>';
		$param['where'][0]['value'] = 	'0';
		
		$num   = $this->Engine->records->GetNumber($param);
		
		return $num;
	}
	
	/**
	 * TODO : play with cache
	 */
	/*
	function GetTeamList()
	{
		$GetGroupList = $this->Engine->group->GetGroupList(array(	'sql_statment'	=>	"WHERE forum_team='1'",
																	'way'			=>	'normal'));
		
		for ($i = 0 ; $i <= sizeof($GetGroupList) ; $i++)
		{			
			$GetMemberList = $this->GetMemberList(array(	'sql_statment'	=>	"WHERE usergroup='" . $GetGroupList[$i]['id'] . "'"));
		}
		
		return $GetMemberList;
	}
	*/
	
	function CleanNewPassword($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$UpdateArr 					= 	array();
		$UpdateArr['new_password'] 	= 	'';
		$UpdateArr['where']			=	array('id',$param['id']);
								
		$query = $this->UpdateMember($UpdateArr);
		        	
		return ($query) ? true : false;	
	}
		
	function CheckAdmin($param)
	{
 		if (!isset($param['username'])
 			or !isset($param['password']))
 		{
 			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
 		}
 		
 		$MemberArr 					= 	array();
 		$MemberArr['username']		=	$param['username'];
 		$MemberArr['password']		=	$param['password'];
		
		$CheckMember = $this->CheckMember($MemberArr);
		
		// Well , this is a member
		if ($CheckMember != false)
		{
			$GroupArr 			= 	array();
			$GroupArr['where'] 	= 	array('id',$CheckMember['usergroup']);
			
			$GroupInfo = $this->Engine->group->GetGroupInfo($GroupArr);
			
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
	
	function LoginAdmin($param)
	{
 		if (empty($param['username'])
 			or empty($param['password']))
 		{
 			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
 		}
 		
		$Check = $this->CheckAdmin($param);
		
		if ($Check != false)
		{
			setcookie($this->Engine->_CONF['admin_username_cookie'],$param['username']);
			setcookie($this->Engine->_CONF['admin_password_cookie'],$param['password']);
       		
       		return true;
		}
		else
		{
			return false;
		}
	}
}

?>
