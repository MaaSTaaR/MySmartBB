<?php

/** PHP5 **/

// [WE NEED A SYSTEM]

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartNotesMOD');

class MySmartNotesMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('header');
		
		// No changes
		if ($MySmartBB->_POST['note'] == $MySmartBB->_CONF['info_row']['admin_notes'])
		{
			$MySmartBB->functions->move('admin.php?page=index&left=1');
		}
		
		if (empty($MySmartBB->_POST['note']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات !');
		}
		
		$update = $MySmartBB->info->updateInfo( 'admin_notes', $MySmartBB->_POST['note'] );
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث المذكرة بنجاح .. يرجى الانتظار حتى يتم ارجاعك إلى الصفحه');
			$MySmartBB->functions->move('admin.php?page=index&left=1');
		}
		
		$MySmartBB->template->display('footer');
	}
}

?>
