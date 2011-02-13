<?php

$DIR = dirname( __FILE__ );
$DIR = str_replace('setup','',$DIR);

define('DIR',$DIR . '/');

define('STOP_STYLE',false);
define('JAVASCRIPT_SMARTCODE',false);
define('INSTALL',true);

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

// Can't live without this file :)
include('../../MySmartBB.class.php');
// Use the class in this file instead of use (X)HTML directly
include('mysmartdisplay.class.php');

// The master object
$MySmartBB = new MySmartBB;

$MySmartBB->html = new MySmartDisplay;

class MySmartInstall
{
	function add_field($param)
	{
		global $MySmartBB;
			
		/*$query = $MySmartBB->db->sql_query(*/ echo 'ALTER TABLE ' . $param['table'] . ' ADD ' . $param['field_name'] . ' ' . $param['field_des']; /*)*/;
					
		return true;
	}
	
	function rename_field($param)
	{
		global $MySmartBB;
			
		/*$query = $MySmartBB->db->sql_query(*/ echo 'ALTER TABLE ' . $param['old_name'] . ' RENAME ' . $param['new_name']; /*);*/
			
		return true;
	}
	
	function drop_field($param)
	{
		global $MySmartBB;
		
		/*$query = $MySmartBB->db->sql_query(*/ echo "ALTER TABLE " . $param['table_name'] . " DROP " . $param['field_name']; /*);*/
		
		return true;
	}
	
	function change_field($param)
	{
		global $MySmartBB;
		
		/*$query = $MySmartBB->db->sql_query(*/ echo "ALTER TABLE " . $param['table_name'] . " CHANGE " . $param['field_name'] . " " . $param['field_name'] . " " . $param['change']; /*);*/
		
		return true;
	}
	
	function create_table($param)
	{
		global $MySmartBB;
		
		$sql_statement = 'CREATE TABLE ' . $param['table_name'] . ' (';
		
		$x = 0;
		$z = sizeof($param['fields']);
		
		foreach ($param['fields'] as $f)
		{
			$sql_statement .= $f;
			
		    if ($x < $z-1)
		    {
		    	$x += 1;
		 		           			
		       	$sql_statement .= ',';
		    }
		}
		
		$sql_statement .= ') TYPE = MYISAM AUTO_INCREMENT=1';
		
		/*$query = $MySmartBB->db->sql_query(*/echo $sql_statement . '<br /><br />';/*);*/
		
		return true;
	}
	
	function drop_table($table_name)
	{
		global $MySmartBB;
		
		/*$query = $MySmartBB->db->sql_query(*/echo "DROP TABLE " . $table_name;/*);*/
		
		return true;
	}
	
	function rename_table($old,$new)
	{
		global $MySmartBB;
		
		/*$query = $MySmartBB->db->sql_query(*/echo "RENAME TABLE " . $old  . " TO " . $new;/*);*/
		
		return true;
	}
}

@header('Content-Type: text/html; charset=utf-8');

$MySmartBB->html->lang 					= 	array();
$MySmartBB->html->lang['direction']		=	'rtl';
$MySmartBB->html->lang['languagecode']	=	'ar';
$MySmartBB->html->lang['charset']		=	'utf-8';
$MySmartBB->html->lang['yes']			=	'نعم';
$MySmartBB->html->lang['align']			=	'right';
$MySmartBB->html->lang['no']			=	'لا';
$MySmartBB->html->lang['send']			=	'موافق';
$MySmartBB->html->lang['reset']			=	'اعادة الحقول';

$MySmartBB->html->stylesheet = '../../setup/setup.css';

?>
