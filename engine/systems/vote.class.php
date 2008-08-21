<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartVote
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	09/06/2008 07:28:04 AM 
 * @updated 	:	21/08/2008 08:57:59 PM 
 */

class MySmartVote
{
	var $id;
	var $Engine;
	
	function MySmartVote($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function InsertVote($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		           			           
		$query = $this->Engine->records->Insert($this->Engine->table['vote'],$param['field']);
		
		if ($param['get_id'])
		{
			$this->id = $this->Engine->DB->sql_insert_id();
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
 		           				 
		$query = $this->Engine->records->Update($this->Engine->table['vote'],$param['field'],$param['where']);
		           
		return ($query) ? true : false;
 	}
 	 	
	function DeleteVote($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['table'] = $this->Engine->table['vote'];
		
		$del = $this->Engine->records->Delete($param);
		
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
 		$param['from']		=	$this->Engine->table['vote'];
 		
		$rows = $this->Engine->records->GetList($param);
		
		return $rows;
	}
	
	function GetVoteInfo($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from']		=	$this->Engine->table['vote'];
		
		$rows = $this->Engine->records->GetInfo($param);
		
		return $rows;
	}
		
 	function GetVoteNumber($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
		$param['select'] 	= 	'*';
		$param['from'] 		= 	$this->Engine->table['vote'];
		
		$num   = $this->Engine->records->GetNumber($param);
		
		return $num;
 	}
 	
 	function DoVote($param)
 	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$x 		= 	0;
 		$size 	= 	sizeof($param['answers']);
 		$index	=	-1;
 		
 		while ($x < $size)
 		{
 			if ($param['answers'][$x][0] == $param['answer'])
 			{
 				$index = $x;
 				
 				break;
 			}
 			
 			$x += 1;
 		}
 		
 		if ($index != -1)
 		{
 			$param['answers'][$index][1] += 1;
 			
 			unset($param['answer']);
 			
 			$insert = $this->Engine->poll->UpdatePoll($param);
 			
 			unset($param['answers'],$param['where']);
 			
 			if ($insert)
 			{
 				$vote = $this->InsertVote($param);
 				
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
