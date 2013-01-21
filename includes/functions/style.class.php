<?php

/**
 * @package MySmartStyle
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @since 27/2/2006 , 8:38 PM
 * @license GNU GPL
 */

class MySmartStyle
{
	private $engine;
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
		
	// ... //
	
	/**
	 * Create serialized cache of a specific style.
	 * 
	 * @param $value Can be style's id or an array of style information as represented in database.
	 * 					This cache will be created for this style.
	 * 
	 * @return false or the cache in serialized form.
	 */
	public function createStyleCache( $value )
	{
		$id = null;
		$style_info = null;
		
		$cache = array();
		
		// ... //
		
		// $value is the style's id.
		if ( is_numeric( $value ) )
			$id = $value;
		// $value is the style's information.
		elseif ( is_array( $value ) )
			$style_info = $value;
		else
			return false;
		
		unset( $value );
		
		// ... //
		
		if ( !is_null( $id ) )
		{
			$this->engine->rec->table = $this->engine->table[ 'style' ];
			$this->engine->rec->filter = "id='" . $id . "'";
			
			$style_info = $this->engine->rec->getInfo();
		}
		
		if ( $style_info != false )
		{
			$cache[ 'style_path' ]		=	$style_info[ 'style_path' ];
			$cache[ 'image_path' ]		=	$style_info[ 'image_path' ];
			$cache[ 'template_path' ]	=	$style_info[ 'template_path' ];
			$cache[ 'cache_path' ]		=	$style_info[ 'cache_path' ];
			
			$cache = base64_encode( serialize( $cache ) );
		}
		else
		{
			return false;
		}
		
		return $cache;
	}
	
	// ... //
	
	public function deleteStyle( $id )
	{
		if ( empty( $id ) )
 			trigger_error('ERROR::NEED_PARAMETER -- FROM deleteStyle() -- EMPTY id',E_USER_ERROR);
 		
 		$this->engine->rec->table = $this->engine->table[ 'style' ];
		$this->engine->rec->filter = "id='" . $id . "'";
		
		$del = $this->engine->rec->delete();
		
		if ( $del )
		{
			// Find members who use the style which deleted and change the id of it to the default one
			$this->engine->rec->table = $this->engine->table[ 'member' ];
			$this->engine->rec->fields = array( 'style'	=>	$this->engine->_CONF[ 'info_row' ][ 'def_style' ],
												'style_id_cache'	=>	$this->engine->_CONF[ 'info_row' ][ 'def_style' ],
												'should_update_style_cache'	=>	'1'	);
			
			$this->engine->rec->filter = "style='" . $id . "'";
			
			$update = $this->engine->rec->update();
			
			return ( $update ) ? true : false;
		}
		else
		{
			return false;
		}
	}
	
	// ... //
	
	/**
	 * Gets the information of style from the database.
	 * 
	 * @param $id The id of the style.
	 * 
	 * @return false or array.
	 */
	public function getStyleInfo( $id )
	{
		if ( empty( $id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM getStyleInfo() -- EMPTY id' );
 		
		$this->engine->rec->table = $this->engine->table[ 'style' ];
		$this->engine->rec->filter = "id='" . (int) $id  . "'";
		
		$info = $this->engine->rec->getInfo();
		
		return $info;
	}
}

?>
