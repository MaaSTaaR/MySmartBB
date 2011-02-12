<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartSendMOD');

class MySmartSendMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['member'])
		{
			if ($MySmartBB->_GET['index'])
			{
				$this->_memberSendIndex();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_memberSendStart();
			}
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _memberSendIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('إرسال رساله بريديه إلى عضو');
		
		if (!$MySmartBB->_CONF['member_permission'])
     	{
     		$MySmartBB->func->error('لا يمكن للزوار إرسال رساله بريديه');
     	}
     	
     	$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
     	
     	if (empty($MySmartBB->_GET['id']))
     	{
     		$MySmartBB->func->error('المسار المتبع غير صحيح');
     	}
     	
     	/* ... */
     	
     	$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$MySmartBB->_CONF['template']['MemberInfo'] = $MySmartBB->rec->getInfo();
		
		/* ... */
		
		if (!$MySmartBB->_CONF['template']['MemberInfo'])
		{
			$MySmartBB->func->error('المعذره .. العضو المطلوب غير موجود في سجلاتنا');
		} 
		
		$MySmartBB->func->cleanArray($MySmartBB->_CONF['template']['MemberInfo'],'sql');
		
		/* ... */
		
		$MySmartBB->template->display('send_email');
	}
	
	private function _memberSendStart()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('إرسال رساله بريديه إلى عضو');
		
		if (!$MySmartBB->_CONF['member_permission'])
     	{
     		$MySmartBB->func->error('لا يمكن للزوار إرسال رساله بريديه');
     	}
     	
     	$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
     	
     	if (empty($MySmartBB->_GET['id']))
     	{
     		$MySmartBB->func->error('المسار المتبع غير صحيح');
     	}
     	
     	/* ... */
     	
     	$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$MemberInfo = $MySmartBB->rec->getInfo();
		
		/* ... */
		
		if (!$MemberInfo)
		{
			$MySmartBB->func->error('المعذره .. العضو المطلوب غير موجود في سجلاتنا');
		} 
		
		$MySmartBB->func->cleanArray($MemberInfo,'sql');
		
		/* ... */
		
		if (empty($MySmartBB->_POST['title'])
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$send = $MySmartBB->func->mail(	$MemberInfo['email'],
										$MySmartBB->_POST['title'],
										$MySmartBB->_POST['text'],
										$MySmartBB->_CONF['member_row']['email'] );
		
		if ($send)
		{
			$MySmartBB->func->msg('تم إرسال الرساله بنجاح');
			$MySmartBB->func->goto('index.php');
		}
		else
		{
			$MySmartBB->func->msg('هناك خطأ، لم يتم الارسال');
		}
	}
}

?>
