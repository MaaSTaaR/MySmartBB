<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);
define('STOP_STYLE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartLogoutMOD');
	
class MySmartLogoutMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			setcookie($MySmartBB->_CONF['admin_username_cookie'],'');
			setcookie($MySmartBB->_CONF['admin_password_cookie'],'');
		
			$MySmartBB->func->move( 'admin.php', 0 );
		}
	}
}

?>
