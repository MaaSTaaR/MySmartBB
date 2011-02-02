<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartCPOptionsMOD');
	
class MySmartCPOptionsMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
		
			if ($MySmartBB->_GET['index'])
			{
				$this->_indexPage();
			}
			elseif ($MySmartBB->_GET['ajax'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_ajaxMain();
				}
				elseif ($MySmartBB->_GET['update'])
				{
					$this->_ajaxUpdate();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _indexPage()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('cp_options_main');
	}
	
	private function _ajaxMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('cp_options_ajax');
	}
	
	private function _ajaxUpdate()
	{
		global $MySmartBB;
			
		$update = array();
		
		$update[0] = $MySmartBB->info->updateInfo( 'admin_ajax_main_rename', $MySmartBB->_POST['admin_ajax_main_rename'] );
				
		if ($update[0])
		{
			$MySmartBB->func->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->func->goto('admin.php?page=cp_options&amp;ajax=1&amp;main=1');
		}
	}
}

?>
