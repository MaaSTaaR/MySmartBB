<?php

/**
 * @package 	: 	MySmartUsertitle
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @started 	: 	Thu 01 Sep 2011 06:35:42 AM AST 
 * @updated 	:	-
 */

class MySmartUsertitle
{
	private $engine;

	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	// ... //
	
	public function getNewUsertitle( $posts )
	{
		$this->engine->rec->table = $this->engine->table[ 'usertitle' ];
		$this->engine->rec->filter = "posts='" . $posts . "'";
		
		$UserTitle = $this->engine->rec->getInfo();
		
		return ( $UserTitle != false ) ? $UserTitle['usertitle'] : null;
	}
	
	// ... //
}

?>
