<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

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
		//$MySmartBB->_CONF['template']['ActiveMember'] = $MySmartBB->member->getActiveMemberNumber();
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "parent<>'0'";
		
		$MySmartBB->_CONF['template']['ForumsNumber'] = $MySmartBB->rec->getNumber();
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		
		$MySmartBB->_CONF['template']['SubjectNumber'] = $MySmartBB->rec->getNumber();
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		
		$MySmartBB->_CONF['template']['ReplyNumber'] = $MySmartBB->rec->getNumber();
		
		$day 	= 	date( 'j' );
		$month 	= 	date( 'n' );
		$year 	= 	date( 'Y' );
		
		$from 	= 	mktime( 0, 0, 0, $month, $day, $year );
		$to 	= 	mktime( 23, 59, 59, $month, $day, $year );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "register_time BETWEEN '" . $from . "' AND '" . $to . "'";
		
		$MySmartBB->_CONF['template']['TodayMemberNumber'] = $MySmartBB->rec->getNumber();
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "native_write_time BETWEEN '" . $from . "' AND '" . $to . "'";
		
		$MySmartBB->_CONF['template']['TodaySubjectNumber'] = $MySmartBB->rec->getNumber();
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->filter = "write_time BETWEEN '" . $from . "' AND '" . $to . "'";
		
		$MySmartBB->_CONF['template']['TodayReplyNumber'] = $MySmartBB->rec->getNumber();
		
		$MySmartBB->template->display('header');
		$MySmartBB->template->display('main_body');
		$MySmartBB->template->display('footer');
	}
}

?>
