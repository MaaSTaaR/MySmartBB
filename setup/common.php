<?php

$DIR = dirname( __FILE__ );
$DIR = str_replace('setup','',$DIR);

define('DIR',$DIR . '/');

//define('STOP_STYLE',false);
//define('JAVASCRIPT_SMARTCODE',false);
define('INSTALL',true);

// Can't live without this file :)
include('../../MySmartBB.class.php');
// Use the class in this file instead of use (X)HTML directly
include('mysmartdisplay.class.php');

// The master object
$MySmartBB = new MySmartBB;

$MySmartBB->html = new MySmartDisplay;

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
