<?php

$CALL_SYSTEM = array();
$CALL_SYSTEM['SUBJECT'] = true;

(!defined('IN_MYSMARTBB')) ? die() : '';

include('common.php');

define('CLASS_NAME','MySmartSendMOD');

class MySmartSendMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['member'])
		{
			if ($MySmartBB->_GET['index'])
			{
				$this->_MemberSendIndex();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_MemberSendStart();
			}
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	function _MemberSendIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('إرسال رساله بريديه إلى عضو');
		
		if (!$MySmartBB->_CONF['member_permission'])
     	{
     		$MySmartBB->functions->error('لا يمكن للزوار إرسال رساله بريديه');
     	}
     	
     	$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
     	
     	if (empty($MySmartBB->_GET['id']))
     	{
     		$MySmartBB->functions->error('المسار المتبع غير صحيح');
     	}
     	
     	//////////
     	
		$MemArr = array();
		
		$MemArr['get'] 	= 'id,username';
		$MemArr['where'] = array('id',$MySmartBB->_GET['id']);
		
		$MySmartBB->_CONF['template']['MemberInfo'] = $MySmartBB->member->GetMemberInfo($MemArr);
		
		//////////
		
		if (!$MySmartBB->_CONF['template']['MemberInfo'])
		{
			$MySmartBB->functions->error('المعذره .. العضو المطلوب غير موجود في سجلاتنا');
		} 
		
		// Kill XSS first
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['MemberInfo'],'html');
		// Second Kill SQL Injections
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['MemberInfo'],'sql');
		
		//////////
		
		$MySmartBB->template->display('send_email');
	}
	
	function _MemberSendStart()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('إرسال رساله بريديه إلى عضو');
		
		if (!$MySmartBB->_CONF['member_permission'])
     	{
     		$MySmartBB->functions->error('لا يمكن للزوار إرسال رساله بريديه');
     	}
     	
     	$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
     	
     	if (empty($MySmartBB->_GET['id']))
     	{
     		$MySmartBB->functions->error('المسار المتبع غير صحيح');
     	}
     	
     	//////////
     	
		$MemArr = array();
		
		$MemArr['get'] 	= 'id,username';
		$MemArr['where'] = array('id',$MySmartBB->_GET['id']);
		
		$MemberInfo = $MySmartBB->member->GetMemberInfo($MemArr);
		
		//////////
		
		if (!$MemberInfo)
		{
			$MySmartBB->functions->error('المعذره .. العضو المطلوب غير موجود في سجلاتنا');
		} 
		
		// Kill XSS first
		$MySmartBB->functions->CleanVariable($MemberInfo,'html');
		// Second Kill SQL Injections
		$MySmartBB->functions->CleanVariable($MemberInfo,'sql');
		
		//////////
		
		if (empty($MySmartBB->_POST['title'])
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$send = $MySmartBB->functions->mail($MemberInfo['email'],$MySmartBB->_POST['title'],$MySmartBB->_POST['text'],$MySmartBB->_CONF['member_row']['email']);
		
		if ($send)
		{
			$MySmartBB->functions->msg('تم إرسال الرساله بنجاح');
			$MySmartBB->functions->goto('index.php');
		}
		else
		{
			$MySmartBB->functions->msg('هناك خطأ، لم يتم الارسال');
		}
	}
}

?>
