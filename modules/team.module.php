<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartTeamMOD');

class MySmartTeamMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_showTeam();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter(); 
	}
	
	/** 
	 * Get team list 
	 */
	public function _showTeam()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('المسؤولون');
		
		// [WE NEED A SYSTEM]
		$MySmartBB->member->getTeamList();
		
		$MySmartBB->template->display('teamlist');
	}
}
	
?>
