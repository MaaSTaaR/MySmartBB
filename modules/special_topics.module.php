<?php

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
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader();
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_SpecialSubject();
		}
		
		$MySmartBB->functions->GetFooter();
	}

	function _SpecialSubject()
	{
		global $MySmartBB;
		
		$SpecialArr 							= 	array();
		$SpecialArr['proc'] 					= 	array();
		$SpecialArr['proc']['*'] 				= 	array('method'=>'clean','param'=>'html');

		$SpecialArr['where']					=	array();
		$SpecialArr['where'][0]					=	array();
		$SpecialArr['where'][0]['name']			=	'special';
		$SpecialArr['where'][0]['oper']			=	'=';
		$SpecialArr['where'][0]['value']		=	'1';

		$SpecialArr['order']					=	array();
		$SpecialArr['order']['field']			=	'id';
		$SpecialArr['order']['type']			=	'DESC';

		$MySmartBB->_CONF['template']['while']['SpecialSubjectList'] = $MySmartBB->subject->GetSubjectList($SpecialArr);
		
		$MySmartBB->template->display('special_subject');
	}
}

?>
