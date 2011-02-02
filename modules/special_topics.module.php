<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;
$CALL_SYSTEM['SUBJECT'] 	= 	true;

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
		
		$MySmartBB->rec->filter = "special='1'";
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->subject->getSubjectList();
		
		$MySmartBB->template->display('special_subject');
	}
}

?>
