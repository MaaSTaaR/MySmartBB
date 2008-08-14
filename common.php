<?php

define('DIR',dirname( __FILE__ ) . '/');

//////////

define('JAVASCRIPT_SMARTCODE',false);

//////////

if (!is_array($CALL_SYSTEM))
{
	$CALL_SYSTEM = array();
}

$CALL_SYSTEM['GROUP'] 		= 	true;
$CALL_SYSTEM['MEMBER'] 		= 	true;
$CALL_SYSTEM['INFO'] 		= 	true;

if (!defined('IN_ADMIN'))
{
	$CALL_SYSTEM['ADS'] 		= 	true;
	$CALL_SYSTEM['ONLINE'] 		= 	true;
	$CALL_SYSTEM['STYLE'] 		= 	true;	
}

//////////

// Can't live without this file :)
include('./MySmartBB.class.php');

// The master object
$MySmartBB = new MySmartBB;

//////////

if (defined('IN_ADMIN'))
{
	require_once('modules/admin/common.module.php');
}
else
{
	require_once('modules/common.module.php');
}

//////////

class MySmartLocalCommon
{
	function run()
	{
		//////////
		
		@header('Content-Type: text/html; charset=utf-8'); // Viva utf ;)
		
		//////////
		
		$this->_SetConfigArray();
		
		//////////
		
		$this->_ProtectionFunctions();
		
		//////////
	}
		
	/**
	 * Set the important variables for the system
	 */
	function _SetConfigArray()
	{
		global $MySmartBB;
		
		//////////
		
		// Important variables , all important variables should store in _CONF array
		$MySmartBB->_CONF['member_permission']		=	false;
 		$MySmartBB->_CONF['param']					=	array();
 		$MySmartBB->_CONF['rows']					=	array();
 		$MySmartBB->_CONF['temp']['query_numbers']	=	0;
 		$MySmartBB->_CONF['temp']['queries']		=	array();
 		$MySmartBB->_CONF['template']				=	array();
 		$MySmartBB->_CONF['template']['while']		=	array();
 		$MySmartBB->_CONF['template']['foreach']	=	array();
 		
 		//////////
 		
 		// Make life easy for developers :)
 		$MySmartBB->DB->SetDebug(true);
 		$MySmartBB->DB->SetQueriesStore(true);
 		
 		//////////
 		
 		define('STOP_STYLE',$MySmartBB->_POST['ajax'] ? true : false);
 		
 		//////////
	}

	/**
	 * Protect the forums from script kiddie and crackers
	 */
	function _ProtectionFunctions()
	{
		global $MySmartBB;
		
		//////////
		
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
    			$MySmartBB->functions->error('قمت بعمليه غير مشروعه!');
   			}
  		}
  		
  		//////////
		
		// Check if $_GET don't value any SQL Injection
  		foreach ($MySmartBB->_GET as $sql_get)
    	{
   			if ((eregi("select", $sql_get)) or
       			(eregi("union", $sql_get)) 	or
       			(eregi("--", $sql_get)))
       		{
       			$this->error('قمت بعمليه غير مشروعه!');
   			}
  		}
  		
  		//////////
  		
  		// Stop any unknown forms
 		if ($MySmartBB->_SERVER['REQUEST_METHOD'] == 'POST')
    	{
    		//////////
    		
  			$Y = explode('/',$GLOBALS['HTTP_REFERER']);
  			$X = explode('/',$GLOBALS['HTTP_HOST']);
  			
  			//////////
  			
  			if ($Y[2] != $X[0])
        	{
   				$this->error('قمت بعمليه غير مشروعه!');
  			}
  			
  			//////////
 		}
 		
 		//////////
	}
}

//////////

$local_common = new MySmartLocalCommon();
$local_common->run();

//////////

$common = new MySmartCommon();
$common->run();

//////////

?>
