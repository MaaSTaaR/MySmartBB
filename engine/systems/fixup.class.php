<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartFixup
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	18/3/2006 , 6:50 PM
 * @end   		: 	18/3/2006 , 7:00 PM
 * @updated 	: 	13/11/2007 12:33:32 PM 
 */
 
class MySmartFixup
{
	var $Engine;
	
	function MySmartFixup($Engine)
	{
		$this->Engine = $Engine;
	}
	
	function RepairTables()
	{
		$returns = array();
		
		foreach ($this->Engine->table as $k => $v)
		{
			$query = $this->Engine->DB->sql_query('REPAIR TABLE ' . $v);
			
			if ($query)
			{
				$returns[$v] = true;
			}
			else
			{
				$returns[$v] = false;
			}
		}
		
		return $returns;
	}
}
 
?>
