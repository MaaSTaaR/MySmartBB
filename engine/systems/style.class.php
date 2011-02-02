<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package	:	MySmartStyle
 * @author		:	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start		:	27/2/2006 , 8:38 PM
 * @end 		:	27/2/2006 , 8:47 PM
 * @updated	:	28/07/2010 01:23:55 PM 
 */

class MySmartStyle
{
	private $engine;
	
	public $id;
	public $get_id;
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
	/**
	 * Insert a new style
	 */
	public function insertStyle()
	{
		$this->engine->rec->table = $this->engine->table[ 'style' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	/**
	 * Update style information
	 */
	public function updateStyle()
	{
 		$this->engine->rec->table = $this->engine->table[ 'style' ];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
	public function deleteStyle()
	{
 		$this->engine->rec->table = $this->engine->table[ 'style' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	public function getStyleList()
	{
		$this->engine->rec->table = $this->engine->table[ 'style' ];
		
		$this->engine->rec->getList();
	 }
	 
	/* ... */
	
	public function getStyleInfo()
	{
		$this->engine->rec->table = $this->engine->table[ 'style' ];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
	
	function GetStyleNumber($param)
	{
		if (!isset($param))
		{
			$param	= array();
		}
		
		$param['select']	=	'*';
		$param['from']		=	$this->engine->table['style'];
		
		$num = $this->engine->rec->GetNumber($param);
		
		return $num;
	}
	
	/* ... */
	
	public function changeStyle( $style_id, $expire = null )
	{
		if ( !isset( $style_id ) )
		{
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM ChangeStyle() -- EMPTY style', E_USER_ERROR );
		}
		
		$update = setcookie( $this->engine->_CONF['style_cookie'], $style_id, $expire );
		
		return ($update) ? true : false;
	}
	
	/* ... */
	
	public function createStyleCache()
	{
		$style	=	$this->getStyleInfo();
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
	
	/* ... */
}

?>
