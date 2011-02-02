<?php

/** PHP5 **/

$CALL_SYSTEM = array();
$CALL_SYSTEM['SUBJECT'] = true;

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartLatestMOD');

class MySmartLatestMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['today'])
		{
			$this->_todaySubject();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _todaySubject()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('مواضيع اليوم');
		
		$day 	= 	date('j');
		$month 	= 	date('n');
		$year 	= 	date('Y');
		
		$from 	= 	mktime( 0, 0, 0, $month, $day, $year );
		$to 	= 	mktime( 23, 59, 59, $month, $day, $year );
		
		/*$SubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$SubjectArr['proc']['write_time'] 			= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);*/
		
		$MySmartBB->rec->filter = "native_write_time BETWEEN " . $from . " AND " . $to . " AND delete_topic<>'1'";
		$MySmartBB->rec->order = "id DESC";
				
		$MySmartBB->subject->getSubjectList();
		
		$MySmartBB->template->display('today_subject');
	}
}

?>
