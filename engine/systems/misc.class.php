<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartMisc
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	16/6/2006 
 * @updated 	: 	18/07/2010 03:53:13 AM 
 */

class MySmartMisc
{
	private $engine;
	
	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
	public function getForumAge( $date )
	{
     	$age = time() - $date;
     	$age = ceil( $age / ( 60 * 60 * 24 ) );
     	
     	return $age;
	}
	
	/* ... */
}

?>
