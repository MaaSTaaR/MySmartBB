<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM			=	array();
$CALL_SYSTEM['FIXUP'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartFixMOD');
	
class MySmartFixMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['repair'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_RepairMain();
				}
			}
				
			$MySmartBB->template->display('footer');
		}
	}
	
	function _RepairMain()
	{
		global $MySmartBB;
		
		$repair = $MySmartBB->fixup->RepairTables();
		
		foreach ($repair as $table => $success)
		{
			if ($success)
			{
				$MySmartBB->functions->msg('تم تصليح الجدول ' . $table);
			}
			else
			{
				$MySmartBB->functions->msg('فشل في تصليح الجدول ' . $table);
			}
		}
	}
}

?>
