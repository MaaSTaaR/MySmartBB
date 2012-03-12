<?php

define( 'DIR', dirname( __FILE__ ) . '/' );

// ... //

if ( !defined( 'JAVASCRIPT_SMARTCODE' ) )
{
	define( 'JAVASCRIPT_SMARTCODE', false );
}

// ... //

// Can't live without this file :)
include('MySmartBB.class.php');

// The master object
$MySmartBB = new MySmartBB;

// ... //

if (defined('COMMON_FILE_PATH'))
{
	require_once(COMMON_FILE_PATH);
}
else
{
	die('ERROR::COMMON_FILE_PATH_HAS_NO_VALUE');
}

// ... //

class MySmartLocalCommon
{
	public function run()
	{
		// ... //
		
		@header('Content-Type: text/html; charset=utf-8'); // Viva utf ;)
		
		// ... //
		
		$this->_setConfigArray();
		
		// ... //
		
		$this->_protectionFunctions();
		
		// ... //
	}
	
	private function _setConfigArray()
	{
		global $MySmartBB;
		
		// ... //
		
		// Important variables , all important variables should store in _CONF array
		$MySmartBB->_CONF['member_permission']		=	false;
 		$MySmartBB->_CONF['param']					=	array();
 		$MySmartBB->_CONF['rows']					=	array();
 		$MySmartBB->_CONF['temp']['query_numbers']	=	0;
 		$MySmartBB->_CONF['temp']['queries']		=	array();
 		$MySmartBB->_CONF['template']				=	array();
 		$MySmartBB->_CONF['template']['while']		=	array();
 		$MySmartBB->_CONF['template']['foreach']	=	array();
 		
 		// ... //
 		
 		//if ( !defined( 'STOP_STYLE' ) )
 		//	define( 'STOP_STYLE', ( isset( $MySmartBB->_POST['ajax'] ) ) ? true : false );
 		
 		// ... //
	}

	/**
	 * Protect the forums from script kiddie and crackers
	 */
	private function _protectionFunctions()
	{
		global $MySmartBB;
		
		// ... //
		
		// Check if $_GET don't value any HTML or Javascript codes
    	foreach ($MySmartBB->_GET as $xss_get)
    	{
   			if ((preg_match("/\<[^\>]*script*\"?[^\>]*\>/", $xss_get)) or
       			(preg_match("/\<[^\>]*object*\"?[^\>]*\>/", $xss_get)) or
       			(preg_match("/\<[^\>]*iframe*\"?[^\>]*\>/", $xss_get)) or
       			(preg_match("/\<[^\>]*applet*\"?[^\>]*\>/", $xss_get)) or
       			(preg_match("/\<[^\>]*meta*\"?[^\>]*\>/", $xss_get)) 	 or
       			(preg_match("/\<[^\>]*style*\"?[^\>]*\>/", $xss_get))  or
       			(preg_match("/\<[^\>]*form*\"?[^\>]*\>/", $xss_get)) 	 or
       			(preg_match("/\<[^\>]*img*\"?[^\>]*\>/", $xss_get)))
            {
    			die( 'Forbidden Action' );
   			}
  		}
  		
  		// ... //
		
		// Check if $_GET don't value any SQL Injection
  		foreach ($MySmartBB->_GET as $sql_get)
    	{
   			if ((preg_match("/select/", $sql_get)) or
       			(preg_match("/union/", $sql_get)) 	or
       			(preg_match("/--/", $sql_get)))
       		{
       			die( 'Forbidden Action' );
   			}
  		}
  		
  		// ... //
  		
  		// Stop any external post request.
  		// At least pervent novice crackers.
 		if ( $MySmartBB->_SERVER['REQUEST_METHOD'] == 'POST' )
    	{
    		// ... //
    		
  			$from = explode( '/', $MySmartBB->_SERVER[ 'HTTP_REFERER' ] );
  			$host = explode( '/', $MySmartBB->_SERVER[ 'HTTP_HOST' ] );

  			// ... //
  			
  			if ( $from[ 2 ] != $host[ 0 ] )
   				die( 'Forbidden Action' );
  			
  			// ... //
 		}
 		
 		// ... //
	}
}

// ... //

$local_common = new MySmartLocalCommon();
$local_common->run();

// ... //

$common = new MySmartCommon();
$common->run();

// ... //

?>
