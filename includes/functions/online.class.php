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
	
	public function isOnline( $timeout, $way, $value )
	{
		if ( empty( $timeout ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM isOnline() -- EMPTY timeout');
		}
		
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
	
	public function isToday( $username, $date )
	{
		if ( empty( $username )
			and empty( $date ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM isToday() -- EMPTY username or date');
		}
		
		$this->engine->rec->table = $this->engine->table[ 'today' ];
		$this->engine->rec->filter = "username='" . $username . "' AND user_date='" . $date . "'";
		
		$num = $this->engine->rec->getNumber();
		
		return ($num <= 0) ? false : true;
	}
	
	// ... //
	
	public function updateMemberLocation( $location )
	{
		$this->engine->rec->table = $this->engine->table[ 'online' ];
		$this->engine->rec->fields = array(	'user_location'	=>	$location	);
		$this->engine->rec->filter = "username='" . $this->engine->_CONF[ 'member_row' ][ 'username' ] . "'";
		
		$update = $this->engine->rec->update();
		
		return ( $update ) ? true : false;
	}
}

?>
