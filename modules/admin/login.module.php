<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);
define('STOP_STYLE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartLoginMOD');
	
class MySmartLoginMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['login'])
		{
			$this->_StartLogin();
		}
	}
	
	function _StartLogin()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['username'])
			or empty($MySmartBB->_POST['password']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$username = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['username'],'trim');
		$password = $MySmartBB->functions->CleanVariable(md5($MySmartBB->_POST['password']),'trim');
		
		$IsMember = $MySmartBB->member->LoginAdmin(array(	'username'	=>	$username,
															'password'	=>	$password));
															

		if ($IsMember)
		{
			$MySmartBB->functions->goto('admin.php',0);
		}
		else
		{
			$MySmartBB->functions->error('المعلومات غير صحيحه');
		}
	}
}

?>
