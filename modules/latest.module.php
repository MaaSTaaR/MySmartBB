<?php

$CALL_SYSTEM = array();
$CALL_SYSTEM['SUBJECT'] = true;

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartLatestMOD');

class MySmartLatestMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['today'])
		{
			$this->_TodaySubject();
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	function _TodaySubject()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('مواضيع اليوم');
		
		$day 	= 	date('j');
		$month 	= 	date('n');
		$year 	= 	date('Y');
		
		$from 	= 	mktime(0,0,0,$month,$day,$year);
		$to 	= 	mktime(23,59,59,$month,$day,$year);
		
		$SubjectArr = array();
		
		$SubjectArr['where'] 				= 	array();
		
		/*$SubjectArr['where'][0] 			= 	array();
		$SubjectArr['where'][0]['name'] 	= 	'sec_section';
		$SubjectArr['where'][0]['oper'] 	= 	'<>';
		$SubjectArr['where'][0]['value'] 	= 	1;
		*/
		$SubjectArr['where'][0] 			= 	array();
		//$SubjectArr['where'][0]['con']		=	'AND';
		$SubjectArr['where'][0]['name'] 	= 	'native_write_time';
		$SubjectArr['where'][0]['oper'] 	= 	'BETWEEN';
		$SubjectArr['where'][0]['value'] 	= 	$from . ' AND ' . $to;
		
		$SubjectArr['where'][1] 			= 	array();
		$SubjectArr['where'][1]['con']		=	'AND';
		$SubjectArr['where'][1]['name'] 	= 	'delete_topic';
		$SubjectArr['where'][1]['oper'] 	= 	'<>';
		$SubjectArr['where'][1]['value'] 	= 	'1';
		
		$SubjectArr['order'] = array();
		$SubjectArr['order']['field'] 	= 	'id';
		$SubjectArr['order']['type'] 	= 	'DESC';

		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$SubjectArr['proc'] 						= 	array();
		// Ok Mr.XSS go to hell !
		$SubjectArr['proc']['*'] 					= 	array('method'=>'clean','param'=>'html'); 
		$SubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$SubjectArr['proc']['write_time'] 			= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
				
		$MySmartBB->_CONF['template']['while']['subject_list'] = $MySmartBB->subject->GetSubjectList($SubjectArr);
		
		$MySmartBB->template->display('today_subject');
	}
}

?>
