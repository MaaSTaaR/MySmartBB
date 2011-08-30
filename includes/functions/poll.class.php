<?php

/**
 * @package 	: 	MySmartPoll
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @started 	: 	Wed 31 Aug 2011 12:55:55 AM AST 
 * @updated 	:	-
 */

class MySmartPoll
{
	private $engine;

	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	// ... //
	
	public function insertPoll( $question, $answers, $subject_id, $update_subject_state = false )
	{
		if ( empty( $question ) or !is_array( $answers ) or ( empty( $subject_id ) or $subject_id == 0 ) )
		{
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM insertPoll()', E_USER_ERROR  );
		}
		
		// ... //
		
		$list = array();
		$k = 0;
		
		foreach ( $answers as $key => $answer )
		{
			if ( !empty( $answer ) )
			{
				$list[ $k ][ 0 ] = $answer; // The text of the answer
				$list[ $k++ ][ 1 ] = '0'; // The number of voters
			}
			else
			{
				break;
			}
		}
		
		$list = serialize( $list );
		
		// ... //
		
		$this->engine->rec->table = $this->engine->table[ 'poll' ];
		
		$this->engine->rec->fields = array(	'qus'			=>	$question,
     										'answers'		=>	$list,
     										'subject_id'	=>	$subject_id);
     													
     	$insert = $this->engine->rec->insert();
     	
     	if ( $insert )
     	{
     		// Mark the subject as a subject with a poll
     		if ( $update_subject_state )
     		{
     			$this->engine->rec->table = $this->engine->table[ 'subject' ];
     			
     			$this->engine->rec->fields = array(	'poll_subject'	=>	'1'	);
     			
     			$this->engine->rec->filter = "id='" . $subject_id . "'";
     			
     			$update = $this->engine->rec->update();
     			
     			return ( $update ) ? true : false;
     		}
     		
     		return true;
     	}
     	else
     	{
     		return false;
     	}
	}
}

?>
