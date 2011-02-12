<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPasswordMOD');

class MySmartPasswordMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_index();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _index()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('إتمام عملية تغيير كلمة المرور');
		
		$MySmartBB->func->addressBar('إتمام عملية تغيير كلمة المرور');
		
		if (empty($MySmartBB->_GET['code']))
		{
			$MySmartBB->func->error('الرابط المتبع غير صحيح');
		}
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->func->error('يرجى تسجيل دخولك اولاً');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
		$MySmartBB->rec->filter = "random_url='" . $MySmartBB->_GET['code'] . "' AND request_type='1' AND username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		
		$RequestInfo = $MySmartBB->rec->getInfo();
		
		if (!$RequestInfo)
		{
			$MySmartBB->func->error('المعذره الطلب غير موجود !');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'password'	=>	md5($MySmartBB->_CONF['member_row']['new_password']) );
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
		
		$UpdatePassword = $MySmartBB->rec->update();
		
		$MySmartBB->member->cleanNewPassword( $MySmartBB->_CONF['member_row']['id'] );
		
		if ($UpdatePassword)
		{
			$MySmartBB->func->msg('تم التحديث بنجاح !');
			$MySmartBB->func->goto('index.php');
		}
	}
}
	
?>
