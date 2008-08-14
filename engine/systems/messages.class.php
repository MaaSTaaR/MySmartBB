<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartMasseges
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	15/7/2006 , 1:18 AM (kuwait : GMT+3)
 * @end   		: 	15/7/2006 , 1:24 AM (kuwait : GMT+3)
 * @updated 	: 	16/07/2008 11:44:29 PM 
 */

class MySmartMessages
{
	var $Engine;
	
	function MySmartMessages($Engine)
	{
		$this->Engine = $Engine;
	}
	
	/**
	 * Get massege information
	 *
	 * @param :
	 *			id	->	the id of massege
	 */
	function GetMessageInfo($param)
	{
 		if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 	 	$param['select'] 	= 	'*';
 	 	$param['from'] 		= 	$this->Engine->table['email_msg'];
 	 	
 	 	$rows = $this->Engine->records->GetInfo($param);
 	 	
 	 	return $rows;
	}
	
	/**
	 * Proccess massege
	 *
	 * @param :
	 *			active_url
	 *			change_url
	 *			text
	 */
	function MessageProccess($param)
	{		
		$search_array 		= 	array();
		$replace_array 		= 	array();
		
		$search_array[]		=	'[MySBB]username[/MySBB]';
		$replace_array[]	=	$param['username'];
		
		$search_array[]		=	'[MySBB]board_title[/MySBB]';
		$replace_array[]	=	$param['title'];
		
		$search_array[]		=	'[MySBB]url[/MySBB]';
		$replace_array[]	=	$param['active_url'];
		
		$search_array[]		=	'[MySBB]change_url[/MySBB]';
		$replace_array[]	=	$param['change_url'];
		
		$search_array[]		=	'[MySBB]cancel_url[/MySBB]';
		$replace_array[]	=	$param['cancel_url'];
		
		$text = str_replace($search_array,$replace_array,$param['text']);
		
		return $text;
	}
}

?>
