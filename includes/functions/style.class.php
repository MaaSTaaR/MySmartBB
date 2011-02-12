<?php

/**
 * @package	:	MySmartStyle
 * @author		:	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start		:	27/2/2006 , 8:38 PM
 * @end 		:	27/2/2006 , 8:47 PM
 * @updated	:	Wed 09 Feb 2011 11:15:01 AM AST 
 */

class MySmartStyle
{
	private $engine;
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
		
	// ... //
	
	public function changeStyle( $style_id, $expire = null )
	{
		if ( !isset( $style_id ) )
		{
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM ChangeStyle() -- EMPTY style', E_USER_ERROR );
		}
		
		$update = setcookie( $this->engine->_CONF['style_cookie'], $style_id, $expire );
		
		return ($update) ? true : false;
	}
	
	// ... //
	
	public function createStyleCache()
	{
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
