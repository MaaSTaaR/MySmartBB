<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPrivateMassegeMOD');

class MySmartPrivateMassegeMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if (!$MySmartBB->_CONF['info_row']['pm_feature'])
		{
			$MySmartBB->func->error('المعذره .. خاصية الرسائل الخاصة موقوفة حاليا');
		}
		
		/** Can't use the private massege system **/
		if (!$MySmartBB->_CONF['group_info']['use_pm'])
		{
			$MySmartBB->func->error('المعذره .. لا يمكنك استخدام الرسائل الخاصه');
		}
		/** **/
		
		/** Visitor can't use the private massege system **/
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->func->error('المعذره .. هذه المنطقه للاعضاء فقط');
		}
		/** **/
				
		if ($MySmartBB->_GET['setting'])
		{
			if ($MySmartBB->_GET['index'])
			{
				$this->_settingIndex();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_settingStart();
			}
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
					
		$MySmartBB->func->getFooter();
	}
			
	private function _settingIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('إعدادات الرسائل الخاصه');
		
		$MySmartBB->template->display('pm_setting');
	}
	
	private function _settingStart()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('إعدادات الرسائل الخاصه');
		
		if ($MySmartBB->_POST['autoreply']
			and (!isset($MySmartBB->_POST['title']) or !isset($MySmartBB->_POST['msg'])))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'autoreply'	=>	$MySmartBB->_POST['autoreply'],
											'autoreply_title'	=>	$MySmartBB->_POST['title'],
											'autoreply_msg'	=>	$MySmartBB->_POST['msg'],
											'pm_senders'	=>	$MySmartBB->_POST['pm_senders'],
											'pm_senders_msg'	=>		$MySmartBB->_POST['pm_senders_msg']	);
											
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث البيانات بنجاح');
			$MySmartBB->func->move('index.php?page=pm_setting&amp;setting=1&amp;index=1');
		}
	}
}

?>
