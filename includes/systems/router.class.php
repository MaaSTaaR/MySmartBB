<?php

/*
 * @package : MySmartRouter
 * @author : Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @license : GNU LGPL
*/

class MySmartRouter
{
	private $modules = array();
	private $dir;
	private $default_func;
	private $default_module;
	const KEY_DOESNT_EXIST = -100;
	const FILE_DOESNT_EXIST = -99;
	const FEW_ARGS = -98;
	const METHOD_DOESNT_EXIST = -97;
	const CANT_FETCH_METHOD = -96;
	
	public function __construct( $modules, $default_module, $dir = null, $default_func = 'run' )
	{
		$this->modules = $modules;
		$this->default_module = $default_module;
		$this->default_func = $default_func;
		$this->dir = ( is_null( $dir ) ) ? '' : $dir;
		
		unset( $modules );
	}
	
	private function _getURLPath( $uri, $script )
	{
		$len_script = $script . '/';
		
		if ( strlen( $len_script ) > strlen( $uri ) or strlen( $len_script ) == strlen( $uri ) )
		{
			return array();
		}
		else
		{
			$path = str_replace( $script . '/', '', $uri );
		
			$path = explode( '/', $path );
		}
		
		return $path;
	}
	
	public function run( $uri, $script )
	{
		// ... //
		
		$path = $this->_getURLPath( $uri, $script );
		$size = sizeof( $path );
		
		$module = $path[ 0 ];
		
		if ( $size == 0 )
			$module = $this->default_module;
		
		// ... //
		
		$file = $this->modules[ $module ];
		
		if ( is_null( $file ) )
			return $this::KEY_DOESNT_EXIST;
		
		// ... //
		
		$file_path = $this->dir . $file;
		
		if ( !file_exists( $file_path ) )
			return $this::FILE_DOESNT_EXIST;
		
		// ... //
		
		$func = ( !empty( $path[ 1 ] ) ) ? $path[ 1 ] : $this->default_func;
		
		// ... //
		
		include( $file_path );
		
		$class_name = CLASS_NAME;
		
		$class = new ReflectionClass( $class_name );
		
		// ... //
		
		$args_start_point = 2;
		
		// $path[ 1 ] may contains the first argument. So use the default function.
		if ( !$class->hasMethod( $func ) )
		{
			$func = $this->default_func;
			$args_start_point = 1;
		}
		
		try
		{
			$method = $class->getMethod( $func );
		}
		catch ( Exception $e )
		{
			if ( $e->getCode() == 0 )
				return $this::METHOD_DOESNT_EXIST;
			else
				return $this::CANT_FETCH_METHOD;
		}
		
		$args_num = $method->getNumberOfParameters();
		$req_args_num = $method->getNumberOfRequiredParameters();
		$recv_num = sizeof( $path ) - $args_start_point;
		
		$req_args_num = ( $req_args_num > 0 ) ? $req_args_num : 0;
		$recv_num = ( $recv_num > 0 ) ? $recv_num : 0;
		
		if ( $recv_num < $req_args_num )
			return $this::FEW_ARGS;
		
		$parameters = array();
		
		for ( $i = $args_start_point, $k = 1; $k <= $args_num; $i++, $k++ )
		{
			$parameters[] = $path[ $i ];
		}
		
		unset( $path );
		
		$method->invokeArgs( new $class_name(), $parameters );
		
		// ... //
		
		return true;
	}
}

?>
