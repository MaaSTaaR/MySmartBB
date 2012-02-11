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
   			if ((eregi("<[^>]*script*\"?[^>]*>", $xss_get)) or
       			(eregi("<[^>]*object*\"?[^>]*>", $xss_get)) or
       			(eregi("<[^>]*iframe*\"?[^>]*>", $xss_get)) or
       			(eregi("<[^>]*applet*\"?[^>]*>", $xss_get)) or
       			(eregi("<[^>]*meta*\"?[^>]*>", $xss_get)) 	or
       			(eregi("<[^>]*style*\"?[^>]*>", $xss_get)) 	or
       			(eregi("<[^>]*form*\"?[^>]*>", $xss_get)) 	or
       			(eregi("<[^>]*img*\"?[^>]*>", $xss_get)))
            {
    			$MySmartBB->func->error('قمت بعمليه غير مشروعه!');
   			}
  		}
  		
  		// ... //
		
		// Check if $_GET don't value any SQL Injection
  		foreach ($MySmartBB->_GET as $sql_get)
    	{
   			if ((eregi("select", $sql_get)) or
       			(eregi("union", $sql_get)) 	or
       			(eregi("--", $sql_get)))
       		{
       			$MySmartBB->func->error('قمت بعمليه غير مشروعه!');
   			}
  		}
  		
  		// ... //
  		
  		// Stop any unknown forms
 		if ($MySmartBB->_SERVER['REQUEST_METHOD'] == 'POST')
    	{
    		// ... //
    		
  			$Y = explode('/',$GLOBALS['HTTP_REFERER']);
  			$X = explode('/',$GLOBALS['HTTP_HOST']);
  			
  			// ... //
  			
  			if ($Y[2] != $X[0])
        	{
   				$MySmartBB->func->error('قمت بعمليه غير مشروعه!');
  			}
  			
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
