<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartVote
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	09/06/2008 07:28:04 AM 
 * @updated 	:	18/07/2010 04:53:39 AM 
 */

class MySmartVote
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
	
	function InsertVote($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           			           
		$query = $this->engine->records->Insert($this->engine->table['vote'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->engine->DB->sql_insert_id();
		}
		
		return ($query) ? true : false;
	}
			
 	function UpdateVote($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           				 
		$query = $this->engine->records->Update($this->engine->table['vote'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
 	 	
	function DeleteVote($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->engine->table['vote'];
		
		$del = $this->engine->records->Delete($param);
		
		return ($del) ? true : false;
	}
		
	function GetVoteList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from']		=	$this->engine->table['vote'];
 		
		$rows = $this->engine->records->GetList($param);
		
		return $rows;
	}
	
	/* ... */
	
	public function getVoteInfo()
	{		
 		$this->engine->rec->table = $this->engine->table['vote'];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
 	function GetVoteNumber($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->engine->table['vote'];
		
		$num   = $this->engine->records->GetNumber($param);
		
		return $num;
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
