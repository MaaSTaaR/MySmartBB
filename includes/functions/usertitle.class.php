<?php

/**
 * @package MySmartUsertitle
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @since Thu 01 Sep 2011 06:35:42 AM AST 
 * @license GNU GPL
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
	
	/**
	 * Gets the usertitle for a specific number of posts.
	 * 
	 * @param $posts The number of posts which we want to get the usertitle of it.
	 * 
	 * @return null if the usertitle doesn't exist, or returns the usertitle
	 */
	public function getNewUsertitle( $posts )
	{
		$this->engine->rec->table = $this->engine->table[ 'usertitle' ];
		$this->engine->rec->filter = "posts='" . $posts . "'";
		
		$info = $this->engine->rec->getInfo();
		
		return ( $info != false ) ? $info[ 'usertitle' ] : null;
	}
	
	// ... //
}

?>
