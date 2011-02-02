<?php

/** PHP5 **/

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
	public function run()
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
				$this->_displayTopPage();
			}
		
			elseif ($MySmartBB->_GET['right'])
			{
				$this->_displayMenuPage();			
			}
		
			elseif ($MySmartBB->_GET['left'])
			{
				$this->_displayBodyPage();
			}
		}
	}
	
	private function _DisplayTopPage()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('header');
		$MySmartBB->template->display('top');
		$MySmartBB->template->display('footer');
	}
	
	private function _displayMenuPage()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('header');
		$MySmartBB->template->display('menu');
		$MySmartBB->template->display('footer');
	}
	
	private function _displayBodyPage()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['MemberNumber'] = $MySmartBB->_CONF['info_row']['member_number'];
		$MySmartBB->_CONF['template']['ActiveMember'] = $MySmartBB->member->getActiveMemberNumber();
		
		$MySmartBB->rec->filter = "parent<>'0'";
		
		$MySmartBB->_CONF['template']['ForumsNumber'] = $MySmartBB->section->getSectionNumber();
		$MySmartBB->_CONF['template']['SubjectNumber'] = $MySmartBB->subject->getSubjectNumber();
		$MySmartBB->_CONF['template']['ReplyNumber'] = $MySmartBB->reply->getReplyNumber();
		
		$day 	= 	date( 'j' );
		$month 	= 	date( 'n' );
		$year 	= 	date( 'Y' );
		
		$from 	= 	mktime( 0, 0, 0, $month, $day, $year );
		$to 	= 	mktime( 23, 59, 59, $month, $day, $year );
		
		$MySmartBB->rec->filter = "register_time BETWEEN '" . $from . "' AND '" . $to . "'";
		
		$MySmartBB->_CONF['template']['TodayMemberNumber'] = $MySmartBB->member->getMemberNumber();
		
		$MySmartBB->rec->filter = "native_write_time BETWEEN '" . $from . "' AND '" . $to . "'";
		
		$MySmartBB->_CONF['template']['TodaySubjectNumber'] = $MySmartBB->subject->getSubjectNumber();
		
		$MySmartBB->rec->filter = "write_time BETWEEN '" . $from . "' AND '" . $to . "'";
		
		$MySmartBB->_CONF['template']['TodayReplyNumber'] = $MySmartBB->reply->getReplyNumber();
		
		$MySmartBB->template->display('header');
		$MySmartBB->template->display('main_body');
		$MySmartBB->template->display('footer');
	}
}

?>
