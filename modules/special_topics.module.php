<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartSpecialSubjectMOD');

class MySmartSpecialSubjectMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader();
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_specialSubject();
		}
		
		$MySmartBB->func->getFooter();
	}

	private function _specialSubject()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "special='1'";
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('special_subject');
	}
}

?>
