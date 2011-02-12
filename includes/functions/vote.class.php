<?php

/**
 * @package 	: 	MySmartVote
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	09/06/2008 07:28:04 AM 
 * @updated 	:	Wed 09 Feb 2011 12:30:08 PM AST 
 */

class MySmartVote
{
	private $engine;

	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	 	
 	/* ... */
 	
 	public function doVote( $answers, $answer )
 	{	
 		$x 		= 	0;
 		$size 	= 	sizeof($answers);
 		$index	=	-1;
 		
 		while ($x < $size)
 		{
 			if ($answers[$x][0] == $answer)
 			{
 				$index = $x;
 				
 				break;
 			}
 			
 			$x += 1;
 		}
 		
 		if ($index != -1)
 		{
 			$answers[$index][1] += 1;
 			
 			unset($answer);
 			
 			$insert = $this->engine->poll->updatePoll();
 			
 			unset($answers);
 			
 			if ($insert)
 			{
 				$vote = $this->insertVote();
 				
 				return ($vote) ? true : false;
 			}
 		}
 		else
 		{
			trigger_error('ERROR::CANT_FIND_THE_ANSWER_IN_ARRAY -- FROM DoVote()',E_USER_ERROR);
 		}
 	}
}

?>
