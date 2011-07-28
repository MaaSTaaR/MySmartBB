<?php

/**
 * @package	:	MySmartStyle
 * @author		:	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start		:	27/2/2006 , 8:38 PM
 * @updated		:	Thu 28 Jul 2011 11:23:05 AM AST 
 */

class MySmartStyle
{
	private $engine;
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
		
	// ... //
	
	public function createStyleCache()
	{
		$this->engine->rec->table = $this->engine->table[ 'style' ];
		
		$style	=	$this->engine->rec->getInfo();
		$cache	=	'';
		
		if ( $style != false )
		{
			$cache = array();
			
			$cache[ 'style_path' ]		=	$style[ 'style_path' ];
			$cache[ 'image_path' ]		=	$style[ 'image_path' ];
			$cache[ 'template_path' ]	=	$style[ 'template_path' ];
			$cache[ 'cache_path' ]		=	$style[ 'cache_path' ];
			
			$cache = base64_encode( serialize( $cache ) );
		}
		else
		{
			return false;
		}
		
		return $cache;
	}
	
	// ... //
}

?>
