<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartEmailMOD');

class MySmartEmailMOD
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
		
		$MySmartBB->func->showHeader('إتمام عملية تغيير البريد الالكتروني');
		
		$MySmartBB->func->addressBar('إتمام عملية تغيير البريد الالكتروني');
		
		if (empty($MySmartBB->_GET['code']))
		{
			$MySmartBB->func->error('الرابط المتبع غير صحيح');
		}
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->func->error('يرجى تسجيل دخولك اولاً');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
		$MySmartBB->rec->filter = "random_url='" . $MySmartBB->_GET['code'] . "' AND request_type='2' AND username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		
		$RequestInfo = $MySmartBB->rec->getInfo();
		
		if (!$RequestInfo)
		{
			$MySmartBB->func->error('المعذره الطلب غير موجود !');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'email'	=>	$MySmartBB->_CONF['member_row']['new_email'] );
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'"
		
		$UpdateEmail= $MySmartBB->rec->update();
		
		if ($UpdateEmail)
		{
			$MySmartBB->func->msg('تم التحديث بنجاح !');
			$MySmartBB->func->goto('index.php');
		}
	}
}
	
?>
