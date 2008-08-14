<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartMisc
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	16/6/2006 
 * @updated 	: 	13/11/2007 12:45:01 PM 
 */

class MySmartMisc
{
	var $Engine;
	
	function MySmartMisc($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function GetForumAge()
	{
     	$age = strtotime('now') - strtotime($this->Engine->_CONF['info_row']['create_date']);
     	$age = ceil ($age / (60*60*24));
     	
     	return $age . '|' . $install_date;
	}
}

?>
