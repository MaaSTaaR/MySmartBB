<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);
define('STOP_STYLE',true);

include('common.php');
	
define('CLASS_NAME','MySmartLogoutMOD');
	
class MySmartLogoutMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			setcookie($MySmartBB->_CONF['admin_username_cookie'],'');
			setcookie($MySmartBB->_CONF['admin_password_cookie'],'');
		
			$MySmartBB->functions->goto('admin.php',0);
		}
	}
}

?>
