<?php

/** PHP5 **/

$CALL_SYSTEM = array();
$CALL_SYSTEM['SUBJECT'] = true;

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartReportMOD');

class MySmartReportMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['member'])
		{
			if ($MySmartBB->_GET['index'])
			{
				$this->_memberReportIndex();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_memberReportStart();
			}
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _memberReportIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('إرسال تقرير عن مشاركة مخالفة');
		
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->func->error('لا يمكن للزوار إرسال تقارير');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
				
		$MySmartBB->template->display('send_report');
	}
	
	private function _memberReportStart()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('إرسال تقرير عن مشاركة مخالفة');
		
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->func->error('لا يمكن للزوار إرسال تقارير');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		/* ... */
		
		if (empty($MySmartBB->_POST['title'])
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->func->error('الرجاء أدخل سبب كتابة تقرير عن هذه المشاركة.');
		}
		
		$Report = $MySmartBB->func->mail(	$MySmartBB->_CONF['info_row']['admin_email'],
											$MySmartBB->_POST['title'],
											$MySmartBB->_POST['text'],
											$MySmartBB->_CONF['member_row']['email'] );
		
		if ($Report)
		{
			$MySmartBB->func->msg('تم إرسال التقرير بنجاح');
			$MySmartBB->func->goto('index.php');
		}
		else
		{
			$MySmartBB->func->msg('هناك خطأ، لم يتم إرسال التقرير');
		}
	}
}

?>
