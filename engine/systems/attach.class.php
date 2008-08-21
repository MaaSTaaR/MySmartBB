<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartAttach
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	2/8/2006 , 1:14 PM
 * @updated 	: 	21/08/2008 08:43:14 PM 
 */

class MySmartAttach
{
	var $Engine;
	
	function MySmartAttach($Engine)
	{
		$this->Engine = $Engine;
	}
	
	/**
	 * Get the attachment information
	 *
	 * $this->Engine->attach->GetAttachInfo(array $param);
	 *
	 * $param =
	 *			array(	'way'=>'id or subject or reply',
	 *					'id'=>'the id of attachment');
	 *
	 * @return :
	 *				array -> of information 
	 *		 		false -> when no information
	 */
	function GetAttachInfo($param)
	{
		if (empty($param['id']))
		{
			trigger_error('ERROR::NEED_PARAMETER -- FROM GetAttachInfo() -- EMPTY id',E_USER_ERROR);
		}
		
		$param['select'] 	= 	'*';
		$param['from']		=	$this->Engine->table['attach'];
		$param['where']		=	array();
		$param['where'][0]	=	array();
		
		// Get the attachment from subject id
		if ($param['way'] == 'subject')
		{
			$param['where'][0]['name'] 	= 	'subject_id';
			$param['where'][0]['oper']	=	'=';
			$param['where'][0]['value']	=	$param['id'];
			
			$param['where'][1]			=	array();
			$param['where'][1]['con']	=	'AND';
			$param['where'][1]['name']	=	'reply';
			$param['where'][1]['oper']	=	'<>';
			$param['where'][1]['value']	=	'1';
		}
		// Get the attachment from reply id
		elseif ($param['way'] == 'reply')
		{
			$param['where'][0]['name'] 	= 	'subject_id';
			$param['where'][0]['oper']	=	'=';
			$param['where'][0]['value']	=	$param['id'];
			
			$param['where'][1]			=	array();
			$param['where'][1]['con']	=	'AND';
			$param['where'][1]['name']	=	'reply';
			$param['where'][1]['oper']	=	'=';
			$param['where'][1]['value']	=	'1';
		}
		// Get the attachment from id
		else
		{
			$param['where'][0]['name'] 	= 	'id';
			$param['where'][0]['oper']	=	'=';
			$param['where'][0]['value']	=	$param['id'];
		}
		
		$rows = $this->Engine->records->GetInfo($param);
		
		return $rows;
	}
}

?>
