<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM					=	array();
$CALL_SYSTEM['PM'] 				= 	true;
$CALL_SYSTEM['ICONS'] 			= 	true;
$CALL_SYSTEM['TOOLBOX'] 		= 	true;
$CALL_SYSTEM['FILESEXTENSION'] 	= 	true;
$CALL_SYSTEM['ATTACH'] 			= 	true;

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPrivateMassegeCPMOD');

class MySmartPrivateMassegeCPMOD
{
	function run()
	{
		global $MySmartBB;
		
		if (!$MySmartBB->_CONF['info_row']['pm_feature'])
		{
			$MySmartBB->func->error('المعذره .. خاصية الرسائل الخاصة موقوفة حاليا');
		}

		if (!$MySmartBB->_CONF['group_info']['use_pm'])
		{
			$MySmartBB->func->error('المعذره .. لا يمكنك استخدام الرسائل الخاصه');
		}

		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->func->error('المعذره .. هذه المنطقه للاعضاء فقط');
		}

		if ($MySmartBB->_GET['cp'])
		{
			if ($MySmartBB->_GET['del'])
			{
				$this->_deletePrivateMassege();
			}
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _deletePrivateMassege()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تنفيذ عملية الحذف');
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->func->addressBar('<a href="index.php?page=pm&amp;list=1&amp;folder=inbox">الرسائل الخاصه</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية الحذف');
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره المسار المتبع غير صحيح .');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		$MySmartBB->rec->filter = "user_to='" . $MySmartBB->_CONF['member_row']['username'] . "' AND id='" . $MySmartBB->_GET['id'] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			// Recount the number of new messages after delete this message
			$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
			$MySmartBB->rec->filter = "user_to='" . $MySmartBB->_CONF['member_row']['username'] . "' AND folder='inobx' AND user_read='0'";
			
			$Number = $MySmartBB->rec->getNumber();
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->fields = array(	'unread_pm'	=>	$Number	);
			$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
			
			$MySmartBB->rec->update();
			
			$MySmartBB->func->msg('تم حذف الرساله بنجاح !');
			$MySmartBB->func->goto('index.php?page=pm_list&list=1&folder=inbox');
		}
	}
}
