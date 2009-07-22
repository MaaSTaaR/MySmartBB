<?php

$CALL_SYSTEM = array();
$CALL_SYSTEM['SUBJECT'] = true;

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartReportMOD');

class MySmartReportMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['member'])
		{
			if ($MySmartBB->_GET['index'])
			{
				$this->_MemberReportIndex();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_MemberReportStart();
			}
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	function _MemberReportIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('إرسال تقرير عن مشاركة مخالفة');
		
		if (!$MySmartBB->_CONF['member_permission'])
     	{
     		$MySmartBB->functions->error('لا يمكن للزوار إرسال تقارير');
     	}
     	
     	$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
     	
     	if (empty($MySmartBB->_GET['id']))
     	{
     		$MySmartBB->functions->error('المسار المتبع غير صحيح');
     	}
     	
     	//////////
     			
		$MySmartBB->template->display('send_report');
	}
	
	function _MemberReportStart()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('إرسال تقرير عن مشاركة مخالفة');
		
		if (!$MySmartBB->_CONF['member_permission'])
     	{
     		$MySmartBB->functions->error('لا يمكن للزوار إرسال تقارير');
     	}
     	
     	$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
     	
     	if (empty($MySmartBB->_GET['id']))
     	{
     		$MySmartBB->functions->error('المسار المتبع غير صحيح');
     	}
     	
     	//////////
     	
		if (empty($MySmartBB->_POST['title'])
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->functions->error('الرجاء أدخل سبب كتابة تقرير عن هذه المشاركة.');
		}
		
		$Report = $MySmartBB->functions->mail($MySmartBB->_CONF['info_row']['admin_email'],$MySmartBB->_POST['title'],$MySmartBB->_POST['text'],$MySmartBB->_CONF['member_row']['email']);
		
		if ($Report)
		{
			$MySmartBB->functions->msg('تم إرسال التقرير بنجاح');
			$MySmartBB->functions->goto('index.php');
		}
		else
		{
			$MySmartBB->functions->msg('هناك خطأ، لم يتم إرسال التقرير');
		}
	}
}

?>
