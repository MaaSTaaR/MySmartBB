<?php

/**
 * @package 	: 	MySmartMasseges
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	15/7/2006 , 1:18 AM (kuwait : GMT+3)
 * @updated 	: 	Thu 28 Jul 2011 11:23:40 AM AST 
 */

class MySmartMessages
{
	private $engine;
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	public function messageProccess( $username, $title, $active_url, $change_url, $cancel_url, $new_password = null, $text )
	{
		$text = $this->engine->func->htmlDecode( $text );
		
		$search_array 		= 	array();
		$replace_array 		= 	array();
		
		$search_array[]		=	'[MySBB]username[/MySBB]';
		$replace_array[]	=	$username;
		
		$search_array[]		=	'[MySBB]board_title[/MySBB]';
		$replace_array[]	=	$title;
		
		$search_array[]		=	'[MySBB]url[/MySBB]';
		$replace_array[]	=	$active_url;
		
		$search_array[]		=	'[MySBB]change_url[/MySBB]';
		$replace_array[]	=	$change_url;
		
		$search_array[]		=	'[MySBB]cancel_url[/MySBB]';
		$replace_array[]	=	$cancel_url;
		
		$search_array[]		=	'[MySBB]new_password[/MySBB]';
		$replace_array[]	=	$new_password;
		
		$text = str_replace( $search_array, $replace_array, $text );
		
		return $text;
	}
}

?>
