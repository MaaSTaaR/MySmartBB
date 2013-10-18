<?php

/**
 * @package MySmartPM
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @since 24/2/2006 8:31 AM
 * @license GNU GPL 
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
	
	/**
	 * Indicates the the private message has been read by the member.
	 * So it's not a new message anymore.
	 * 
	 * @param $id The id of the private message
	 * 
	 * @return boolean
	 */
	public function markMessageAsRead( $id )
	{
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'user_read'	=>	'1'	);
 		
 		$this->engine->rec->filter = "id='" . $id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	/**
	 * Gets the number of unread messages.
	 * 
	 * @param $username The username of the member who we want to check his/her unread messages number.
	 * 
	 * @return The number of unread messages.
	 * 
	 * @todo I think we should me it to MySmartMember. It's a members stuff.
	 */
	public function newMessageNumber( $username )
	{
 		if ( empty( $username ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM newMessageNumber() -- EMPTY username' );
 		
 		$this->engine->rec->table = $this->table;
		$this->engine->rec->filter = "user_to='" . $username . "' AND folder='inbox' AND user_read<>'1'";
				
		return $this->engine->rec->getNumber();
	}
	
	// ... //
	
	/**
	 * Gets the list of inbox private messages.
	 * 
	 * @param $username The username of the member who the messages belong to.
	 * 
	 */
	public function getInboxList( $username )
	{
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->filter = "user_to='" . $username . "' AND folder='inbox'";
 		
 	 	$this->engine->rec->getList();
	}
	
	// ... //
	
	/**
	 * Gets the list of sent private messages.
	 *
	 * @param $username The username of the member who the messages belong to.
	 *
	 */
	public function getSentList( $username )
	{
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->filter = "user_from='" . $username . "' AND folder='sent'";
 		
 	 	$this->engine->rec->getList();
	}	
}

?>
