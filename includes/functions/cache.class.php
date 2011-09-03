<?php

/**
 * @package 	: 	MySmartCache
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	15/6/2006 , 10:46 PM
 * @updated 	: 	Sat 03 Sep 2011 03:36:43 AM AST 
 */

class MySmartCache
{
	private $engine;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	// ... //
	
	public function updateLastMember( $member_num, $username, $id )
	{
		if ( !isset( $member_num )
			or !isset( $username )
			or !isset( $id ) )
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM updateLastMember()',E_USER_ERROR);
		}
		
		$update_username 	= 	$this->engine->info->updateInfo( 'last_member', $username );
		$update_id 			= 	$this->engine->info->updateInfo( 'last_member_id', $id );
		$update_number 		= 	$this->engine->info->updateInfo( 'member_number', $member_num + 1 );
		
		return ( $update_username and $update_id and $update_number ) ? true : false;
	}
	
	// ... //
	
	// Update the total of subjects in the bb.
	public function updateSubjectNumber( $value = null, $operation = 'add', $operand = 1 )
	{
		$val = $this->engine->_CONF['info_row']['subject_number'];
		
		if ( is_null( $value ) )
		{
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
	
	public function updateReplyNumber( $value = null, $operation = 'add', $operand = 1 )
	{
		$val = $this->engine->_CONF['info_row']['reply_number'];
		
		if ( is_null( $value ) )
		{
			if ( $operation == 'add' )
				$val += $operand;
			else
				$val -= $operand;
		}
		else
		{
			$val = $value;
		}
		
		$update = $this->engine->info->updateInfo( 'reply_number', $val );
		
		return ($update) ? true : false;		
	}
	
	// ... //
}

?>
