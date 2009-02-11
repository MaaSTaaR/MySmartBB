<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

include('common.php');
	
define('CLASS_NAME','MySmartNotesMOD');

class MySmartNotesMOD
{
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('header');
		
		// No changes
		if ($MySmartBB->_POST['note'] == $MySmartBB->_CONF['info_row']['admin_notes'])
		{
			$MySmartBB->functions->goto('admin.php?page=index&left=1');
		}
		
		if (empty($MySmartBB->_POST['note']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات !');
		}
		
		$update = $MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_POST['note'],'var_name'=>'admin_notes')); 
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث المذكرة بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->goto('admin.php?page=index&left=1');
		}
		
		$MySmartBB->template->display('footer');
	}
}

?>
