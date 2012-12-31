<?php

/**
 * @package	    :	MySmartOnline
 * @author		:	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start		:	4/4/2006 , 11:26 PM
 * @updated		:	Fri 27 Apr 2012 11:48:41 PM AST 
 * @license     :   GNU LGPL
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
	
	/**
	 * Checks if the member is online or not.
	 * 
	 * @param $way Can be 'username' to check the member according to his/her username
	 * 				or 'ip' to check the member according to his/her ip.
	 * @param $value The username or ip to be checked.
	 * @param $timeout The timeout, can be null so the default value (in MySmartBB::_CONF[ 'timeout' ])
	 * 					will be used.
	 * 
	 * @return boolean
	 */
	public function isOnline( $way, $value, $timeout = null )
	{
		if ( is_null( $timeout ) )
			$timeout = $this->engine->_CONF[ 'timeout' ];
		
		// ... //
		
		$field = 'username';
		
		if ( $way == 'ip' )
			$field = 'user_ip';
		
		// ... //
		
		$this->engine->rec->table = $this->engine->table[ 'online' ];
		$this->engine->rec->filter = "logged>=" . $timeout . ' AND ' . $field . "='" . $value . "'";
		
   		$num = $this->engine->rec->getNumber();
   		
   		return ( $num <= 0 ) ? false : true;
	}
	
	// ... //
	
	/**
	 * Checks if the member attended today or not,
	 *
	 * @param $username The username of the member to be checked
	 * @param $date The default value is null, if it is null the member
	 * 					will be checked for today date, otherwise the member will
	 * 					be checked for a specific date.
	 *
	 * @return boolean
	 */
	public function isToday( $username, $date = null )
	{
		if ( empty( $username ) )
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM isToday() -- EMPTY username or date' );
		
		if ( is_null( $date ) )
			$date = $this->engine->_CONF[ 'date' ];
		
		$this->engine->rec->table = $this->engine->table[ 'today' ];
		$this->engine->rec->filter = "username='" . $username . "' AND user_date='" . $date . "'";
		
		$num = $this->engine->rec->getNumber();
		
		return ( $num <= 0 ) ? false : true;
	}
	
	// ... //
	
	/**
	 * Updates the current location of the current member, so we can know what is the member doing.
	 * 
	 * @param $location The textual location of the member, for example : He is viewing a topic
	 * 
	 * @return true for success, otherwise false
	 */
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
	
	/**
	 * Checks if the current member is already online and update online information, otherwise 
	 * insert the member into online table.
	 * 
	 * @return boolean
	 */
	public function onlineMember()
	{
		// ... //
		
		$username = $this->engine->_CONF[ 'member_row' ][ 'username' ];
		
		$IsOnline = $this->isOnline( 'username', $username );
		
		// ... //
		
		// Get username with group style
		$username_style = $this->engine->member->getUsernameWithStyle( 	$username, 
																		$this->engine->_CONF[ 'group_info' ][ 'username_style' ]  );
		
		// ... //
		
		$this->engine->rec->table = $this->engine->table[ 'online' ];
		$this->engine->rec->fields = array(	'username'			=>	$username,
											'username_style'	=>	$username_style,
											'logged'			=>	$this->engine->_CONF[ 'now' ],
											'path'				=>	$this->engine->_SERVER[ 'QUERY_STRING' ],
											'user_ip'			=>	$this->engine->_CONF[ 'ip' ],
											'hide_browse'		=>	$this->engine->_CONF[ 'member_row' ][ 'hide_online' ],
											'user_id'			=>	$this->engine->_CONF[ 'member_row' ][ 'id' ]	);
		
		// ... //
		
		// The member isn't online, Insert the information
		if ( !$IsOnline )
		{
			$insert = $this->engine->rec->insert();
		}
		// Member is already online , just update information
		else
		{
			if ( $IsOnline[ 'logged' ] < $this->engine->_CONF[ 'timeout' ] 
				or $IsOnline[ 'path' ] != $this->engine->_SERVER[ 'QUERY_STRING' ] 
				or $IsOnline[ 'username_style' ] != $username_style
				or $IsOnline[ 'hide_browse' ] != $this->engine->_CONF[ 'member_row' ][ 'hide_online' ] )
			{
				$this->engine->rec->filter = "username='" . $username . "'";
				
				$update = $this->engine->rec->update();
			}
		}
		
		return ( $insert or $update ) ? true : false;
	}
	
	/**
	 * Checks if the member is already in today's visitor, if (s)he's not then insert the member
	 * into today table, and update the number of member's visits
	 * 
	 * @return boolean
	 */
	public function todayMember()
	{
		$username = $this->engine->_CONF[ 'member_row' ][ 'username' ];
		
		$IsToday = $this->isToday( $username );
		
		// The member doesn't exist in today table , so insert the member								  
		if ( !$IsToday )
		{
		    $username_style = $this->engine->member->getUsernameWithStyle( 	$username, 
																			$this->engine->_CONF[ 'group_info' ][ 'username_style' ]  );
																		
			
			$insert = $this->insertToday( 	$username, 
											$this->engine->_CONF[ 'member_row' ][ 'id' ],
                                            $this->engine->_CONF[ 'date' ], 
											$this->engine->_CONF[ 'member_row' ][ 'hide_online' ], 
											$username_style,
                                            $this->engine->_CONF[ 'member_row' ][ 'visitor' ] );
			
			return ( $insert ) ? true : false;	
		}
		
		return true;
	}
	
	/**
	 * Inserts a member to the list of members who attended today and updates
	 * the number of member's visits to the forum.
	 * 
	 * @param $username The username.
	 * @param $id The id of the member.
	 * @param $date The date of today or whatever.
	 * @param $hidden Is this member hidden?
	 * @param $username_style The stylish username of the member.
	 * @param $visits The current number of member's visits to the forum.
	 * 
	 * @return boolean
	 */
	public function insertToday( $username, $id, $date, $hidden, $username_style, $visits )
	{
		$this->engine->rec->table = $this->engine->table[ 'today' ];
		
		$this->engine->rec->fields = array(	'username'			=>	$username,
											'user_id'			=>	$id,
											'user_date'			=>	$date,
											'hide_browse'		=>	$hidden,
											'username_style'	=>	$username_style	);
			
		$insert = $this->engine->rec->insert();
		
		if ( $insert )
		{
		    // Update visits number of the member
			$this->engine->rec->table = $this->engine->table[ 'member' ];
			$this->engine->rec->fields = array(	'visitor'	=>	$visits + 1	);
			$this->engine->rec->filter = "id='" . (int) $id . "'";
			
			return ( $this->engine->rec->update() ) ? true : false;
		}
		
		return ( $insert ) ? true : false;
	}
	
	/**
	 * Checks if the _visitor_ is already online and update online information, 
	 * otherwise insert the visitor into online table
	 */
	public function onlineVisitor()
	{
		// Check if the visitor is already online
		$isOnline = $this->isOnline( 'ip', $this->engine->_CONF[ 'ip' ] );
		
		$this->engine->rec->table = $this->engine->table[ 'online' ];
		$this->engine->rec->fields = array(	'username'			=>	'Guest',
											'username_style'	=>	'Guest',
											'logged'			=>	$this->engine->_CONF['now'],
											'path'				=>	$this->engine->_SERVER['QUERY_STRING'],
											'user_ip'			=>	$this->engine->_CONF['ip'],
											'user_id'			=>	-1	);
		
		// The visitor is already online, just update the information										
		if ( $isOnline )
		{
			$this->engine->rec->filter = "user_ip='" . $this->engine->_CONF[ 'ip' ] . "'";
			
			$update = $this->engine->rec->update();
		}
		// The visitor doesn't exist in online table, so we insert his/her info
		else
		{
			$insert = $this->engine->rec->insert(); 
		}
	}
}

?>
