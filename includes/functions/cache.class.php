<?php

/**
 * @package 	: 	MySmartCache
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	15/6/2006 , 10:46 PM
 * @updated 	: 	Sat 03 Sep 2011 03:36:43 AM AST 
 * @license     :   GNU LGPL
 */

class MySmartCache
{
	private $engine;
	
	const EMPTY_CACHE = -1;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	// ... //

 	public function updateCache( $key, $values )
 	{
 		if ( empty( $key )
 			or empty( $values )
 			or !is_array( $values ) )
 		{
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM updateCache() -- EMPTY name or value', E_USER_ERROR );
 		}
 		
 		$cache = serialize( $values );
 		$cache = base64_encode( $cache );
 		
		$this->engine->rec->table = $this->engine->table[ 'cache' ];
		$this->engine->rec->fields = array(	'cache'	=>	$cache	);
		$this->engine->rec->filter = "name='" . $key . "'";
		
		$query = $this->engine->rec->update();
		
		return ($query) ? true : false;
 	}
 	
 	// ... //
 	
 	public function getCache( $key )
 	{
 		if ( empty( $key ) )
 		{
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM getCache() -- EMPTY key', E_USER_ERROR );
 		}
 		
 	    $this->engine->rec->table = $this->engine->table[ 'cache' ];
 	    $this->engine->rec->filter = "name='" . $key . "'";
 	    
 	    $info = $this->engine->rec->getInfo();
 	    
 	    if ( !$info )
 	        return false;
 	    
 	    if ( empty( $info[ 'cache' ] ) )
 	        return self::EMPTY_CACHE;
 	    
 	    $values = unserialize( base64_decode( $info[ 'cache' ] ) );
 	    
 	    return $values;
 	}
 	
 	// ... //
 	
	/**
	 * Updates the username of the newest member and add one to the current number of members,
	 * This function should be called _after_ insert member into database.
	 * 
	 * @param $username The username of the newest member
	 * @param $id The id of the newest member
	 * 
	 * @return true for success, otherwise false
	 */
	public function updateLastMember( $username, $id )
	{
		// ... //
		
		if ( !isset( $username ) or !isset( $id ) )
			trigger_error('ERROR::NEED_PARAMETER -- FROM updateLastMember()',E_USER_ERROR);
		
		// ... //
		
		// Get the actual number of members
		$this->engine->rec->select = 'id';
		$this->engine->rec->table = $this->engine->table[ 'member' ];
		
		$member_num = $this->engine->rec->getNumber();
		
		// ... //
		
		$update_username 	= 	$this->engine->info->updateInfo( 'last_member', $username );
		$update_id 			= 	$this->engine->info->updateInfo( 'last_member_id', $id );
		$update_number 		= 	$this->engine->info->updateInfo( 'member_number', $member_num );
		
		return ( $update_username and $update_id and $update_number ) ? true : false;
	}
	
	// ... //
	
	// Update the total of subjects in the bb.
	public function updateSubjectNumber( $value = null, $operation = 'add', $operand = 1 )
	{
		if ( is_null( $value ) )
		{
			$val = $this->engine->_CONF[ 'info_row' ][ 'subject_number' ];
			
			if ( $operation == 'add' )
				$val += $operand;
			else
				$val -= $operand;
		}
		else
		{
			$val = $value;
		}
		
		$update = $this->engine->info->updateInfo( 'subject_number', $val );
		
		return ($update) ? true : false;
	}
	
	// ... //
	
	/**
	 * Updates total number of replies.
	 *
	 * @param $value If we already have the total number of replies we can pass it to this parameter, 
	 * 						otherwise keep it null so the number of replies will be getten automatically.
	 * @param $operation Can be "add" or "sub" or null, just use it if you want to add or substract
	 * 						a specific value to/from the number of replies.
	 * @param $operand The value of the oprand if $value is not null.
	 * 
	 * @return true for success, otherwise false
	 */
	public function updateReplyNumber( $value = null, $operation = 'add', $operand = 1 )
	{
		$do_operation = true;
		
		if ( !is_null( $value ) )
		{
			$val = $value;
		}
		else
		{
			$this->engine->rec->table = $this->engine->table[ 'reply' ];
			$this->engine->rec->filter = "delete_topic<>'1'";
			
			$val = $this->engine->rec->getNumber();
			
			$do_operation = false;
		}
		
		if ( !is_null( $operation ) and $do_operation )
		{
			if ( $operation == 'add' )
				$val += $operand;
			else
				$val -= $operand;
		}
		
		$update = $this->engine->info->updateInfo( 'reply_number', $val );
		
		return ( $update ) ? true : false;		
	}
	
	// ... //
}

?>
