<?php

/**
 * @package	:	MySmartOnline
 * @author		:	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start		:	4/4/2006 , 11:26 PM
 * @updated		:	Thu 28 Jul 2011 11:18:47 AM AST 
 */

class MySmartOnline
{
	private $engine;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	// ... //
	
	public function isOnline( $way, $value, $timeout = null )
	{
		if ( is_null( $timeout ) )
			$timeout = $this->engine->_CONF['timeout'];
		
		$this->engine->rec->table = $this->engine->table[ 'online' ];
		
		$this->engine->rec->filter = "logged>=" . $timeout;
		
		if ( $way == 'username' )
		{
			$this->engine->rec->filter .= " AND username='" . $value . "'";
		}
		elseif ( $way == 'ip' )
		{
			$this->engine->rec->filter .= " AND user_ip='" . $value . "'";
		}
		else
		{
			return false;
		}
		
   		$num = $this->engine->rec->getNumber();
   		
   		return ($num <= 0) ? false : true;
	}
	
	// ... //
	
	public function isToday( $username, $date = null )
	{
		if ( empty( $username ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM isToday() -- EMPTY username or date');
		}
		
		if ( is_null( $date ) )
			$date = $this->engine->_CONF[ 'date' ];
			
		$this->engine->rec->table = $this->engine->table[ 'today' ];
		$this->engine->rec->filter = "username='" . $username . "' AND user_date='" . $date . "'";
		
		$num = $this->engine->rec->getNumber();
		
		return ($num <= 0) ? false : true;
	}
	
	// ... //
	
	public function updateMemberLocation( $location )
	{
		if ( $this->engine->_CONF[ 'member_permission' ] )
		{
			$this->engine->rec->table = $this->engine->table[ 'online' ];
			$this->engine->rec->fields = array(	'user_location'	=>	$location	);
			$this->engine->rec->filter = "username='" . $this->engine->_CONF[ 'member_row' ][ 'username' ] . "'";
		
			$update = $this->engine->rec->update();
		
			return ( $update ) ? true : false;
		}
		else
		{
			return false;
		}
	}
	
	// ... //
	
	// ~ ~ //
	// Description : 	This function checks if the member is already online and update online information, otherwise insert the member
	//					into online table
	// 
	// Returns : 
	//				- true or false
	// ~ ~ //
	public function onlineMember()
	{
		// ... //
		
		$IsOnline = $this->isOnline( 'username', $this->engine->_CONF[ 'member_row' ][ 'username' ] );
		
		// ... //
		
		// Get username with group style
		$username_style = $this->engine->member->getUsernameWithStyle( 	$this->engine->_CONF['member_row']['username'], 
																		$this->engine->_CONF['group_info']['username_style']  );
		
		// ... //
		
		// The member isn't online, Insert the information
		if ( !$IsOnline )
		{
			$this->engine->rec->table = $this->engine->table[ 'online' ];
			$this->engine->rec->fields = array(	'username'			=>	$this->engine->_CONF['member_row']['username'],
												'username_style'	=>	$username_style,
												'logged'			=>	$this->engine->_CONF['now'],
												'path'				=>	$this->engine->_SERVER['QUERY_STRING'],
												'user_ip'			=>	$this->engine->_CONF['ip'],
												'hide_browse'		=>	$this->engine->_CONF['member_row']['hide_online'],
												'user_location'		=>	$MemberLocation,
												'user_id'			=>	$this->engine->_CONF['member_row']['id']	);
												
			$insert = $this->engine->rec->insert();
		}
		// Member is already online , just update information
		else
		{
			$username_style_fi = str_replace('\\','',$username_style);
			
			if ($IsOnline['logged'] < $this->engine->_CONF['timeout'] 
				or $IsOnline['path'] != $this->engine->_SERVER['QUERY_STRING'] 
				or $IsOnline['username_style'] != $username_style_fi
				or $IsOnline['hide_browse'] != $this->engine->_CONF['rows']['member_row']['hide_online'])
			{
				$this->engine->rec->table = $this->engine->table[ 'online' ];
				$this->engine->rec->fields = array(	'username'			=>	$this->engine->_CONF['member_row']['username'],
													'username_style'	=>	$username_style,
													'logged'			=>	$this->engine->_CONF['now'],
													'path'				=>	$this->engine->_SERVER['QUERY_STRING'],
													'user_ip'			=>	$this->engine->_CONF['ip'],
													'hide_browse'		=>	$this->engine->_CONF['member_row']['hide_online'],
													'user_location'		=>	$MemberLocation,
													'user_id'			=>	$this->engine->_CONF['member_row']['id']	);
				
				$this->engine->rec->filter = "username='" . $this->engine->_CONF[ 'member_row' ][ 'username' ] . "'";
				
				$update = $this->engine->rec->update();
			}
		}
		
		return ( $insert or $update ) ? true : false;
	}
	
	// ~ ~ //
	// Description : 	This function checks if the member is already in today's visitor, if (s)he's not insert the member
	//					into today table, and update the number of member's visit
	// 
	// Returns : 
	//				- true or false
	// ~ ~ //
	public function todayMember()
	{
		$IsToday = $this->isToday( $this->engine->_CONF[ 'member_row' ][ 'username' ] );
		
		// Get username with group style
		$username_style = $this->engine->member->getUsernameWithStyle( 	$this->engine->_CONF['member_row']['username'], 
																		$this->engine->_CONF['group_info']['username_style']  );
		
		// The member doesn't exist in today table , so insert the member								  
		if (!$IsToday)
		{
			$this->engine->rec->table = $this->engine->table[ 'today' ];
			
			$this->engine->rec->fields = array(	'username'			=>	$this->engine->_CONF['member_row']['username'],
												'user_id'			=>	$this->engine->_CONF['member_row']['id'],
												'user_date'			=>	$this->engine->_CONF['date'],
												'hide_browse'		=>	$this->engine->_CONF['member_row']['hide_online'],
												'username_style'	=>	$username_style	);
			
			$InsertToday = $this->engine->rec->insert();
			
			if ($InsertToday)
			{				
				$this->engine->rec->table = $this->engine->table[ 'member' ];
				$this->engine->rec->fields = array(	'visitor'	=>	$this->engine->_CONF['member_row']['visitor'] + 1	);
				$this->engine->rec->filter = "id='" . (int) $this->engine->_CONF['member_row']['id'] . "'";
				
				$this->engine->rec->update();
				
				return true;
			}
			else
			{
				return false;
			}			
		}
		
		return true;
	}
	
	// ~ ~ //
	// Description : 	This function checks if the _visitor_ is already online and update online information, otherwise insert the visitor
	//					into online table
	// 
	// Returns : 
	//				- true or false
	// ~ ~ //
	public function onlineVisitor()
	{
		// Check if the visitor is already online
		$isOnline = $this->isOnline( 'ip', $this->engine->_CONF['ip'] );
								
		// The visitor is already online, just update the information										
		if ( $isOnline )
		{
			$this->engine->rec->table = $this->engine->table[ 'online' ];
			$this->engine->rec->fields = array(	'username'	=>	'Guest',
												'logged'	=>	$this->engine->_CONF['now'],
												'path'		=>	$this->engine->_SERVER['QUERY_STRING'],
												'user_ip'	=>	$this->engine->_CONF['ip']	);
			
			$this->engine->rec->filter = "username='Guest'";
			
			$update = $this->engine->rec->update();
		}
		// The visitor doesn't exist in online table, so we insert his/her info
		else
		{
			$this->engine->rec->table = $this->engine->table[ 'online' ];
			$this->engine->rec->fields = array(	'username'			=>	'Guest',
												'username_style'	=>	'Guest',
												'logged'			=>	$this->engine->_CONF['now'],
												'path'				=>	$this->engine->_SERVER['QUERY_STRING'],
												'user_ip'			=>	$this->engine->_CONF['ip'],
												'user_id'			=>	-1	);
			
			$insert = $this->engine->rec->insert(); 
		}
	}
}

?>
