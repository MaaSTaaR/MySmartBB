<?php

/** PHP5 **/

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartOnline
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	4/4/2006 , 11:26 PM
 * @end   		: 	4/4/2006 , 11:38 PM
 * @updated 	: 	05/07/2010 02:50:48 PM 
 */

class MySmartOnline
{
	private $engine;
	
	public $id;
	public $get_id;
	
	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
 	public function insertOnline()
 	{
		$this->engine->rec->table = $this->engine->table[ 'online' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 	
 	public function updateOnline()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'online' ];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 	
 	public function getOnlineList()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'online' ];
 		
 	 	$this->engine->rec->getList();
 	}
 	
 	/* ... */
 	
 	public function getOnlineNumber()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'online' ];
 		
 		return $this->engine->rec->getNumber();
 	}
 	
 	/* ... */
 	
 	public function deleteOnline()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'online' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
 	}
 	
 	/* ... */
 	
 	public function getOnlineInfo()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'online' ];
		
		return $this->engine->rec->getInfo();
 	}
 	
 	/* ... */
 	
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
 	
 	/* ... */
 	
 	public function deleteToday()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'today' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
 	}
 	
 	/* ... */
 	
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
 	
 	/* ... */
 	
 	public function insertToday()
 	{
		$this->engine->rec->table = $this->engine->table[ 'today' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 	
 	public function getTodayList()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'today' ];
 		
 	 	$this->engine->rec->getList();
 	}
 	
 	/* ... */
 	
 	public function getTodayNumber()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'today' ];
 		
 		return $this->engine->rec->getNumber();
 	}
 	
 	/* ... */
}

?>
