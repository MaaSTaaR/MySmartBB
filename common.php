<?php

define( 'DIR', dirname( __FILE__ ) . '/' );

// ... //

if ( !defined( 'JAVASCRIPT_SMARTCODE' ) )
	define( 'JAVASCRIPT_SMARTCODE', false );

// ... //

// Can't live without this file :)
include('MySmartBB.class.php');

// The master object
$MySmartBB = new MySmartBB;

// ... //

if (defined('COMMON_FILE_PATH'))
	require_once(COMMON_FILE_PATH);
else
	die('ERROR::COMMON_FILE_PATH_HAS_NO_VALUE');

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
		
		// Important variables , all important variables should be stored in _CONF array
		$MySmartBB->_CONF['member_permission']		=	false;
 		$MySmartBB->_CONF['param']					=	array();
 		$MySmartBB->_CONF['rows']					=	array();
 		$MySmartBB->_CONF['temp']['query_numbers']	=	0;
 		$MySmartBB->_CONF['temp']['queries']		=	array();
 		$MySmartBB->_CONF['template']				=	array();
 		$MySmartBB->_CONF['template']['while']		=	array();
 		$MySmartBB->_CONF['template']['foreach']	=	array();
	}

	/**
	 * Protect the forums from script kiddie and crackers
	 */
	private function _protectionFunctions()
	{
		global $MySmartBB;
		
		// ... //
		
		// Preventing XSS and SQL Injection's keywords from the GET request
    	foreach ( $MySmartBB->_GET as $get )
    	{
   			if ( (preg_match("/\<[^\>]*script*\"?[^\>]*\>/", $get)) or
       			(preg_match("/\<[^\>]*object*\"?[^\>]*\>/", $get)) or
       			(preg_match("/\<[^\>]*iframe*\"?[^\>]*\>/", $get)) or
       			(preg_match("/\<[^\>]*applet*\"?[^\>]*\>/", $get)) or
       			(preg_match("/\<[^\>]*meta*\"?[^\>]*\>/", $get)) or
       			(preg_match("/\<[^\>]*style*\"?[^\>]*\>/", $get)) or
       			(preg_match("/\<[^\>]*form*\"?[^\>]*\>/", $get)) or
       			(preg_match("/\<[^\>]*img*\"?[^\>]*\>/", $get)) or
       			(preg_match("/select/", $get)) or
       			(preg_match("/union/", $get)) or
       			(preg_match("/--/", $get)) )
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
