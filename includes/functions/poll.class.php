<?php

/**
 * @package 	: 	MySmartPoll
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @started 	: 	Wed 31 Aug 2011 12:55:55 AM AST 
 * @updated 	:	Wed 20 Jun 2012 09:02:59 PM AST 
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
	
	/**
	 * Inserts a poll to a topic.
	 * 
	 * @param $question The text of the poll's question.
	 * @param $answers An array of the answers.
	 * @param $subject_id The id of the topic of the poll.
	 * @param $update_subject_state Set it true if you want the function to mark to topic as a poll topic, otherwise set it false. Default value is false.
	 * 
	 * @return true for success, otherwise false.
	 */
	public function insertPoll( $question, $answers, $subject_id, $update_subject_state = false )
	{
		if ( empty( $question ) or !is_array( $answers ) or ( empty( $subject_id ) or $subject_id == 0 ) )
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM insertPoll()', E_USER_ERROR  );
		
		// ... //
		
		$list = array();
		$k = 0;
		
		foreach ( $answers as $key => $answer )
		{
			if ( !empty( $answer ) )
			{
				$list[ $k ][ 0 ] = $answer; // The text of the answer
				$list[ $k++ ][ 1 ] = 0; // The number of voters
			}
			else
			{
				break;
			}
		}
		
		$list = base64_encode( serialize( $list ) ); // To avoid troubling with unserialize(), we have to encode data
		
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
	
	// ... //
	
	/**
	 * Updates the result of a specific poll for a specific answer.
	 * 
	 * @param $poll The id of the poll or the array of poll's information as represented in database.
	 * @param $answer The text of the answer to be updated.
	 * 
	 * @return boolean
	 */
	public function updateResults( $poll, $answer )
	{
		if ( empty( $answer ) or ( empty( $poll ) or $poll == 0 ) )
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM MySmartPoll::updateResults()', E_USER_ERROR  );
		
		$info = null;
		
		// If "$poll" is an integer, so fetch poll's data.
		// $poll can be an array of a specific poll
		
		// Fetch data
		if ( is_int( $poll ) )
		{
			$this->engine->rec->table = $this->engine->table[ 'poll' ];
			$this->engine->rec->filter = "id='" . $poll . "'";
			
			$info = $this->engine->rec->getInfo();
		}
		elseif ( is_array( $poll ) )
		{
			$info = $poll;
			
			unset( $poll );
		}
		else
		{
			return false;
		}
		
		// Start the real work
		
		$answers = unserialize( base64_decode( $info[ 'answers' ] ) );
		
		// We can't use "array_search()", because our array is a 2D array.
		$key = null;
		
		foreach ( $answers as $k => $value )
		{
			if ( $value[ 0 ] == $answer )
			{
				$key = $k;
				
				break;
			}
		}
		
		if ( is_null( $key ) )
			return false;
		
		$answers[ $key ][ 1 ]++;
		
		$answers = base64_encode( serialize( $answers ) );
		
		// Finally update
		
		$this->engine->rec->table = $this->engine->table[ 'poll' ];
		$this->engine->rec->fields = array(	'answers'	=>	$answers );
		$this->engine->rec->filter = "id='" . $info[ 'id' ] . "'";
		
		$update = $this->engine->rec->update();
		
		return ( $update ) ? true : false;
		
		// Wooow, That was long
	}
}

?>
