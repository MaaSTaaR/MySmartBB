<?php

/**
 * @package MySmartTemplate
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @version 1.0.0
 * @since 20/4/2006 , 7:00 PM (GMT+3)
 * @license GNU LGPL
*/

/**
 * Major changes from 0.30 (MySmartBB's version)
 * ---------------------------------------
 * 1- PHP5 Object Orinted Programming
 * 2- Changes functions name from (G)etTemplateDir to (g)etTemplateDir
 * 3- Uses Exception system
 * 4- There are two classes MySmartTemplate (the main one) and MySmartCompiler that can be any class and its object stores in $this->compiler
 */

class MySmartTemplate
{
	protected $templates_dir;
	protected $compiler_dir;
	protected $templates_ex;
	protected $alt_templates_dir = null; // Alternative templates directory, We need it when we have more than one directory of templates
	private $compiler; // An object for the compiler which we have to use
	private $method	= 'file';
	
	function __construct( $compiler )
	{
		/* MySmartTemplate requires two functions from the compiler class, 
		 * 1st function : "public function compile( $string )" that function does the main function of compiler
		 * 2nd function : "public function assign( $varname, $value )" that function register the variables used in templates
		 */
		$this->compiler = $compiler;
	}
	
	/**
	 * Public functions
	 */
	
	// ... //
	 
	public function setInformation( $templates_dir, $compiler_dir, $templates_ex, $method )
	{
		$this->templates_dir 	= 	$templates_dir;
		$this->compiler_dir 	= 	$compiler_dir;
		$this->templates_ex		=	$templates_ex;
		$this->method			=	$method;
		
		if ( $this->templates_dir[ strlen( $this->templates_dir ) - 1 ] != '/' )
			$this->templates_dir .= '/';
		
		if ( $this->compiler_dir[ strlen( $this->compiler_dir ) - 1 ] != '/' )
			$this->compiler_dir .= '/';
	}
	
	// ... //
	
	public function getTemplateDir()
	{
		return $this->templates_dir;
	}
	
	// ... //
		
	public function getCompilerDir()
	{
		return $this->compilter_dir;
	}
	
	// ... //
	
	public function getTemplateExtention()
	{
		return $this->templates_ex;
	}
	
	// ... //
	
	public function setAltTemplateDir( $dir )
	{
	    $this->alt_templates_dir = $dir;
	    
		if ( $this->alt_templates_dir[ strlen( $this->alt_templates_dir ) - 1 ] != '/' )
			$this->alt_templates_dir .= '/';
	}
	
	// ... //
	
	public function unsetAltTemplateDir()
	{
	    $this->alt_templates_dir = null;
	}
	
	// ... //
	
	/**
	 * Display the template after compile it
	 */
	public function display( $template_name, $alt_path = false )
	{
		if ( $this->method == 'file' )
		{
			try
			{
				$this->_getTemplateFromFile( $template_name, false, $alt_path );
			}
			catch ( Exception $e )
			{
				trigger_error( $e->getMessage(), E_USER_ERROR );
			}
		}
		else
		{
			trigger_error( 'ERROR::BAD_VALUE_OF_METHOD_VARIABLE', E_USER_ERROR );
		}
	}
	
	// ... //
	
	public function content( $template_name, $alt_path = false )
	{
		if ($this->method == 'file')
		{
			try
			{
				return $this->_getTemplateFromFile( $template_name, true, $alt_path );
			}
			catch ( Exception $e )
			{
				trigger_error( $e->getMessage(), E_USER_ERROR );
			}
		}
		else
		{
			trigger_error( 'ERROR::BAD_VALUE_OF_METHOD_VARIABLE', E_USER_ERROR );
		}
	}
	
	// ... //
	
	public function assign( $varname, $value )
	{
		$this->compiler->assign( $varname, $value );
	}
	
	/**
	 * Private functions
	 */
	
	// ... //

	private function _getTemplateFromFile( $template_name, $content = false, $alt_path )
	{
		// ... //
		
		if ( $alt_path and !is_null( $this->alt_templates_dir ) )
		    $template_file = $this->alt_templates_dir;
		else
		    $template_file = $this->templates_dir;
		
		$template_file .= $template_name . $this->templates_ex;
		$compiled_file = $this->compiler_dir . $template_name . '-compiler.php';
		
		// ... //
		
		// The template's size should be bigger than 0 byte
		if ( filesize( $template_file ) > 0 )
		{
			// ... //
			
			// Compile the templete in these cases
			// 1- There is no previous compiled file.
			// 2- There is one but the original template file has new modifications, so update the compiled file.
			// 3- The operating system is Windows, so we can't use filectime() function
			if ( !( file_exists( $compiled_file ) )
				or ( file_exists( $compiled_file )
					and filectime( $compiled_file ) < filectime( $template_file ) )
				or ( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) )
			{
				$this->_createCompiledFile( $template_file, $compiled_file );
			}
			
			// ... //
			
			if ( !$content )
				$this->_getCompiledFile( $template_name, $content );
			else
				return $this->_getCompiledFile( $template_name, $content );
			
			// ... //
		}
		else
		{
			throw new Exception( 'ERROR::FILE_SIZE_IS_ZERO' );
		}
	}
	
	// ... //
	
	private function _createCompiledFile( $template_file, $compiled_file )
	{
		// ... //
		
		// Get the content of template
		$fp = fopen( $template_file, 'r' );
		
		if ( !$fp )
			throw new Exception( 'ERROR::CAN_NOT_OPEN_THE_FILE' );
		
		$fr = fread( $fp, filesize( $template_file ) );
		
		fclose( $fp );
		
		// ... //
		
		// Compile the template
		$string = $this->compiler->compile( $fr );
		
		// ... //
		
		// Create compiled file
		$create = fopen( $compiled_file, 'w+' );
 		
 		if ( !$create )
 			throw new Exception( 'ERROR::CAN_NOT_OPEN_THE_FILE' );
 		
 		$write = fwrite( $create, $string );
 		
 		if ( !$write )
 			throw new Exception( 'ERROR::CAN_NOT_WRITE_TO_THE_FILE' );
 		
 		fclose( $create );
 					
 		// ... //
	}
	
	// ... //
	
	/**
	 * If the template is already compiled , so include it
	 */
	private function _getCompiledFile( $template_name, $content = false )
	{
		$compiled_name = $this->compiler_dir . $template_name . '-compiler.php';
		
		if ( file_exists( $compiled_name ) )
		{
			// Include the compiled file to display it.
			if ( !$content )
			{
				global $MySmartBB; /** Only for our case **/
				
				include( $compiled_name );
				
				// Don't forget return true :)
				return true;
			}
			// Return the content of compiled file.
			else
			{
				$template_name = $this->templates_dir . $template_name . $this->templates_ex;
				
				$fp = fopen( $compiled_name, 'r' );
		
				if ( !$fp )
					trigger_error( 'ERROR::CAN_NOT_OPEN_THE_FILE', E_USER_ERROR );
		
				$fr = fread( $fp, filesize( $template_name ) );
				
				if ( !$fr )
					trigger_error( 'ERROR::CAN_NOT_READ_FROM_THE_FILE', E_USER_ERROR );
				
				fclose($fp);
				
				return $fr;
			}
		}
		// The file is not here , so return false
		else
		{
			return false;
		}
	}
}

?>
