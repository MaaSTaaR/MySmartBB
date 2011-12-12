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
		
		$MySmartBB->loadLanguage( 'team' );
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_showTeam();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter(); 
	}
	
	/** 
	 * Get team list 
	 */
	public function _showTeam()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'moderators' ] );
		
		//$MySmartBB->member->getTeamList();
		
		$MySmartBB->template->display('teamlist');
	}
}
	
?>
