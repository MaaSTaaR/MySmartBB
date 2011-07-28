<?php

/**
 * Private message system
 *
 * @package		: 	MySmartPM
 * @author		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	24/2/2006 8:31 AM
 * @end   		: 	24/2/2006 9:05 AM
 * @updated 	: 	Thu 28 Jul 2011 11:21:55 AM AST 
*/

class MySmartPM
{
	private $engine;
	private $table;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
		$this->table = $this->engine->table[ 'pm' ];
	}
	
	// ... //
	
	public function markMessageAsRead()
	{
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'user_read'	=>	'1'	);
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function newMessageNumber( $username )
	{
 		if ( empty( $username ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM newMessageNumber() -- EMPTY username');
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
		$this->engine->rec->filter = "user_to='" . $username . "' AND folder='inbox' AND user_read<>'1'";
				
		return $this->engine->rec->getNumber();
	}
	
	// ... //
	
	public function getInboxList( $username )
	{
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->filter = "user_to='" . $username . "' AND folder='inbox'";
 		
 	 	$this->engine->rec->getList();
	}
	
	// ... //
	
	public function getSentList( $username )
	{
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->filter = "user_from='" . $username . "' AND folder='sent'";
 		
 	 	$this->engine->rec->getList();
	}	
}

?>
