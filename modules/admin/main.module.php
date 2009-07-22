<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM = array();
$CALL_SYSTEM['SECTION'] = true;
$CALL_SYSTEM['SUBJECT'] = true;
$CALL_SYSTEM['REPLY'] = true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartMainMOD');
	
class MySmartMainMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			if (empty($MySmartBB->_GET['top']) 
				and empty($MySmartBB->_GET['right']) 
				and empty($MySmartBB->_GET['left']))
			{
				$MySmartBB->template->display('main');
			}
			
			elseif ($MySmartBB->_GET['top'])
			{
				$this->_DisplayTopPage();
			}
		
			elseif ($MySmartBB->_GET['right'])
			{
				$this->_DisplayMenuPage();			
			}
		
			elseif ($MySmartBB->_GET['left'])
			{
				$this->_DisplayBodyPage();
			}
		}
	}
	
	function _DisplayTopPage()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('header');
		$MySmartBB->template->display('top');
		$MySmartBB->template->display('footer');
	}
	
	function _DisplayMenuPage()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('header');
		$MySmartBB->template->display('menu');
		$MySmartBB->template->display('footer');
	}
	
	function _DisplayBodyPage()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['MemberNumber'] = $MySmartBB->member->GetMemberNumber(array('get_from'	=>	'db'));
		
		$MySmartBB->_CONF['template']['ActiveMember'] = $MySmartBB->member->GetActiveMemberNumber();
		
		$SecArr 						= 	array();
		$SecArr['where'] 				= 	array();
		$SecArr['where'][0] 			= 	array();
		$SecArr['where'][0]['name'] 	= 	'parent';
		$SecArr['where'][0]['oper'] 	= 	'<>';
		$SecArr['where'][0]['value'] 	= 	'0';
		
		$MySmartBB->_CONF['template']['ForumsNumber'] = $MySmartBB->section->GetSectionNumber($SecArr);
		
		$MySmartBB->_CONF['template']['SubjectNumber'] = $MySmartBB->subject->GetSubjectNumber(array('get_from'	=>	'db'));
		
		$MySmartBB->_CONF['template']['ReplyNumber'] = $MySmartBB->reply->GetReplyNumber(array('get_from'	=>	'db'));
		
		$day 	= 	date('j');
		$month 	= 	date('n');
		$year 	= 	date('Y');
		
		$from 	= 	mktime(0,0,0,$month,$day,$year);
		$to 	= 	mktime(23,59,59,$month,$day,$year);
		
		$TodayMemberArr 				= 	array();
		$TodayMemberArr['get_from'] 	= 	'db';
		$TodayMemberArr['where'] 		= 	array();
		
		$TodayMemberArr['where'][0] 			= 	array();
		$TodayMemberArr['where'][0]['name'] 	= 	'register_time';
		$TodayMemberArr['where'][0]['oper'] 	= 	'BETWEEN';
		$TodayMemberArr['where'][0]['value'] 	= 	$from . ' AND ' . $to;
		
		$MySmartBB->_CONF['template']['TodayMemberNumber'] = $MySmartBB->member->GetMemberNumber($TodayMemberArr);
		
		$TodaySubjectArr 				= 	array();
		$TodaySubjectArr['get_from'] 	= 	'db';
		$TodaySubjectArr['where'] 		= 	array();
		
		$TodaySubjectArr['where'][0] 			= 	array();
		$TodaySubjectArr['where'][0]['name'] 	= 	'native_write_time';
		$TodaySubjectArr['where'][0]['oper'] 	= 	'BETWEEN';
		$TodaySubjectArr['where'][0]['value'] 	= 	$from . ' AND ' . $to;
		
		$MySmartBB->_CONF['template']['TodaySubjectNumber'] = $MySmartBB->subject->GetSubjectNumber($TodaySubjectArr);
		
		$TodayReplyArr 				= 	array();
		$TodayReplyArr['get_from'] 	= 	'db';
		$TodayReplyArr['where'] 	= 	array();
		
		$TodayReplyArr['where'][0] 				= 	array();
		$TodayReplyArr['where'][0]['name'] 		= 	'write_time';
		$TodayReplyArr['where'][0]['oper'] 		= 	'BETWEEN';
		$TodayReplyArr['where'][0]['value'] 	= 	$from . ' AND ' . $to;
		
		$MySmartBB->_CONF['template']['TodayReplyNumber'] = $MySmartBB->reply->GetReplyNumber($TodayReplyArr);
		
		$MySmartBB->template->display('header');
		$MySmartBB->template->display('main_body');
		$MySmartBB->template->display('footer');
	}
}

?>
