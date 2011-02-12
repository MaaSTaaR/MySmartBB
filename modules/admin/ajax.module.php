<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartAjaxMOD');

class MySmartAjaxMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			if ($MySmartBB->_GET['sections'])
			{	
				if ($MySmartBB->_GET['rename'])
				{
					$this->_sectionRename();
				}
			}
		}
	}
	
	private function _sectionRename()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['title'])
			or empty($MySmartBB->_POST['id']))
		{
			$MySmartBB->functions->error('المسار المُتبع غير صحيح');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		
		$MySmartBB->rec->fields 	= 	array();
		
		$MySmartBB->rec->fields['title'] 	= 	$MySmartBB->_POST['title'];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST['id'] . "'";
				
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			echo $MySmartBB->_POST['title'];
		}
	}
}

?>
