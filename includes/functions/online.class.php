<?php

/**
 * @package	:	MySmartOnline
 * @author		:	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start		:	4/4/2006 , 11:26 PM
 * @end  		:	4/4/2006 , 11:38 PM
 * @updated		:	Tue 08 Feb 2011 10:51:25 AM AST 
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
		
		$this->engine->rec->table = $this->engine->table['online'];
		
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
		$this->engine->rec->table = $this->engine->table[ 'today' ];
		
		if ( !empty( $username )
			and !empty( $date ) )
		{
			$MySmartBB->rec->filter = "username='" . $username . "' AND user_date='" . $date . "'";
		}
		else
		{
			return false;
		}
		
		$num = $this->engine->rec->getNumber();
		
		return ($num <= 0) ? false : true;
	}
}

?>
