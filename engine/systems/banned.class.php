<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartBanned
 * @copyright 	: 	Mohammed Q. Hussian <MaaSTaaR@gmail.com>
 * @start 		: 	17/3/2006 , 7:13 PM
 * @end   		: 	17/3/2006 , 7:19 PM
 * @updated 	: 	13/11/2007 12:28:45 PM 
 */
 
class MySmartBanned
{
	var $Engine;
	
	function MySmartBanned($Engine)
	{
		$this->Engine = $Engine;
	}
	
 	/**
 	 * Know if the username is ban or not
 	 *
 	 * $param =
 	 *			array('username'=>'the username');
 	 *
 	 * @return
 	 *			true -> when the username is banned
 	 *			false -> when the username isn't banned
 	 */
	function IsUsernameBanned($param)
	{
		if (empty($param['username']))
		{
			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
		}
		
		$query_array 			= 	array();
		$query_array['text'] 	= 	$param['username'];
		$query_array['type'] 	= 	1;
		
		$num = $this->_BaseQueryNum($query_array);
 		
		return ($num <= 0) ? false : true;
	}
 	
 	/**
 	 * Know if the email is ban or not
 	 *
 	 * $param =
 	 *			array('email'=>'the email');
 	 *
 	 * @return
 	 *			true -> when the email is banned
 	 *			false -> when the email isn't banned
 	 */
 	function IsEmailBanned($param)
 	{
		if (empty($param['email']))
		{
			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
		}
		
 		$query_array 			= 	array();
		$query_array['text'] 	= 	$param['email'];
		$query_array['type'] 	= 	2;
		
		$num = $this->_BaseQueryNum($query_array);
 		
 		return ($num <= 0) ? false : true;
 	}
 	
 	/**
 	 * Know if the provider is ban or not
 	 *
 	 * $param =
 	 *			array('provider'=>'the provider');
 	 *
 	 * @return
 	 *			true -> when the provider is banned
 	 *			false -> when the provider isn't banned
 	 */
 	function IsProviderBanned($param)
 	{
		if (empty($param['provider']))
		{
			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
		}
		
 		$query_array 			= 	array();
		$query_array['text'] 	= 	$param['provider'];
		$query_array['type'] 	= 	3;
		
		$num = $this->_BaseQueryNum($query_array);
		
 		return ($num <= 0) ? false : true;
 	}
 	
 	/**
 	 * Get the number of rows which stored in database
 	 *
 	 * @access : private
 	 */
 	function _BaseQueryNum($param)
 	{
		if (empty($param['text'])
			or empty($param['type']))
		{
			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
		}
		
 		$arr 						= 	array();
 		$arr['select'] 				= 	'*';
 		$arr['from'] 				= 	$this->Engine->table['banned'];
 		$arr['where']				=	array();
 		
 		$arr['where'][0]			=	array();
 		$arr['where'][0]['name']	=	'text';
 		$arr['where'][0]['oper']	=	'=';
 		$arr['where'][0]['value']	=	$param['text'];
 		
 		$arr['where'][1]			=	array();
 		$arr['where'][1]['con']		=	'AND';
 		$arr['where'][1]['name']	=	'text_type';
 		$arr['where'][1]['oper']	=	'=';
 		$arr['where'][1]['value']	=	$param['type'];
 		
 		$num = $this->Engine->records->GetNumber($arr);
 		
 		return $num;
 	}
}
 
?>
