<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);
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
		
		$MySmartBB->template->display('header');
		$MySmartBB->template->display('main_body');
		$MySmartBB->template->display('footer');
	}
}

?>
