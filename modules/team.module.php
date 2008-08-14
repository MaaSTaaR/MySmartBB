<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include('common.php');

define('CLASS_NAME','MySmartTeamMOD');

class MySmartTeamMOD
{
	function run()
	{
		global $MySmartBB;
		
		/** Show the team list **/
		if ($MySmartBB->_GET['show'])
		{
			$this->_ShowTeam();
		}
		/** **/
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter(); 
	}
	
	/** 
	 * Get team list 
	 */
	function _ShowTeam()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('المسؤولين');
		
		$MySmartBB->_CONF['template']['while']['GetTeamList'] = $MySmartBB->member->GetTeamList();
		
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['while']['GetTeamList'],'html');
		
		$MySmartBB->template->display('teamlist');
	}
}
	
?>
