<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartMisc
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	16/6/2006 
 * @updated 	: 	31/08/2008 06:32:02 AM 
 */

class MySmartMisc
{
	var $Engine;
	
	function MySmartMisc($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function GetForumAge($param)
	{
     	$age = time() - $param['date'];
     	$age = ceil($age/(60*60*24));
     	
     	return $age;
	}
}

?>
