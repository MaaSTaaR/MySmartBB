<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM			=	array();
$CALL_SYSTEM['FIXUP'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartFixMOD');
	
class MySmartFixMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['repair'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_repairMain();
				}
			}
				
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _repairMain()
	{
		global $MySmartBB;
		
		$repair = $MySmartBB->fixup->repairTables();
		
		foreach ($repair as $table => $success)
		{
			if ($success)
			{
				$MySmartBB->func->msg('تم تصليح الجدول ' . $table);
			}
			else
			{
				$MySmartBB->func->msg('فشل في تصليح الجدول ' . $table);
			}
		}
	}
}

?>
