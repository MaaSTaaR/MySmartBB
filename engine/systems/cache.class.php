<?php

/** PHP5 **/

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartCache
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	15/6/2006 , 10:46 PM
 * @updated 	: 	13/07/2010 04:18:29 AM 
 */

class MySmartCache
{
	private $engine;
	
	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
	/**
	 * Update the last member
	 */
	public function updateLastMember( $member_num, $username, $id )
	{
		if ( !isset( $member_num )
			or !isset( $username )
			or !isset( $id ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM updateLastMember()',E_USER_ERROR);
		}
		
		$update_username = $this->engine->info->updateInfo( 'last_member', $username );
		$update_id = $this->engine->info->updateInfo( 'last_member_id', $id );
		$update_number = $this->engine->info->updateInfo( 'member_number', $member_num + 1 );
		
		return ( $update_username and $update_id and $update_number ) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Update the total of subjects
	 */
	public function updateSubjectNumber( $subject_num )
	{
		if ( !isset( $subject_num ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM updateSubjectNumber() -- EMPTY subject_num',E_USER_ERROR);
		}
		
		$val = $subject_num + 1;
		
		$update = $this->engine->info->updateInfo( 'subject_number', $val );
		
		return ($update) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Update the total of replys
	 */
	public function updateReplyNumber( $reply_num )
	{
		if ( !isset( $reply_num ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM updateReplyNumber() -- EMPTY reply_num',E_USER_ERROR);
		}
		
		$val = $reply_num + 1;
		
		$update = $this->engine->info->updateInfo( 'reply_number', $val );
		
		return ($update) ? true : false;
	}
	
	/* ... */
}

?>
