<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

include('common.php');

define('CLASS_NAME','MySmartCPOptionsMOD');
	
class MySmartCPOptionsMOD
{
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('header');
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_IndexPage();
		}
		elseif ($MySmartBB->_GET['ajax'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_AjaxMain();
			}
			elseif ($MySmartBB->_GET['update'])
			{
				$this->_AjaxUpdate();
			}
		}
		
		$MySmartBB->template->display('footer');
	}
	
	function _IndexPage()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('cp_options_main');
	}
	
	function _AjaxMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('cp_options_ajax');
	}
	
	function _AjaxUpdate()
	{
		global $MySmartBB;
			
		$update = array();
		
		$update[0] = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['admin_ajax_main_rename'],'var_name'=>'admin_ajax_main_rename'));
				
		if ($update[0])
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=cp_options&amp;ajax=1&amp;main=1');
		}
	}
}

?>
