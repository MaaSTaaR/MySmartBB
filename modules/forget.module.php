<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartForgetMOD');

class MySmartForgetMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->load( 'massege' );
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_index();
		}
		elseif ($MySmartBB->_GET['start'])
		{
			$this->_start();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _index()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('استرجاع كلمة المرور');
				
		$MySmartBB->template->display('forget_password_form');
	}
	
	private function _start()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تنفيذ عملية استرجاع كلمة المرور');
		
		$MySmartBB->func->addressBar('تنفيذ عملية استرجاع كلمة المرور');
		
		if (empty($MySmartBB->_POST['email']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		if (!$MySmartBB->func->checkEmail($MySmartBB->_POST['email']))
		{
			$MySmartBB->func->error('يرجى كتابة بريدك الالكتروني الصحيح');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "email='" . $MySmartBB->_POST['email'] . "'";
		
		$CheckEmail = $MySmartBB->rec->getNumber();
		
		if ( $CheckEmail > 0 )
		{
			$MySmartBB->func->error('البريد الالكتروني غير موجود في قواعد بياناتنا !');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "email='" . $MySmartBB->_POST['email'] . "'";
		
		$ForgetMemberInfo = $MySmartBB->rec->getInfo();
		
		$MySmartBB->func->CleanArray($ForgetMemberInfo,'sql');
		
		$Adress = 	$MySmartBB->func->getForumAdress();
		$Code	=	$MySmartBB->func->randomCode();
		
		$ChangeAdress = $Adress . 'index.php?page=new_password&index=1&code=' . $Code;
		$CancelAdress = $Adress . 'index.php?page=cancel_requests&index=1&type=1&code=' . $Code;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
		
		$MySmartBB->rec->fields = array(	'random_url'	=>	$code,
											'username'	=>	$ForgetMemberInfo['username'],
											'request_type'	=>	'1'	);
												
		$InsertReq = $MySmartBB->rec->insert();
		
		if ($InsertReq)
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->fields = array(	'new_password'	=>	$MySmartBB->func->randomCode() );
			$MySmartBB->rec->filter = "id='" . $ForgetMemberInfo['id'] . "'";
			
			$UpdateNewPassword = $MySmartBB->rec->update();
			
			if ($UpdateNewPassword)
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'email_msg' ];
				$MySmartBB->rec->filter = "id='1'";
				
				$MassegeInfo = $MySmartBB->rec->getInfo();
				
				$MassegeInfo['text'] = $MySmartBB->massege->messageProccess( 	$MySmartBB->_CONF['member_row']['username'], 
																				$MySmartBB->_CONF['info_row']['title'], 
																				null, 
																				$ChangeAdress, 
																				$CancelAdress, 
																				$MassegeInfo['text'] );
				
				$Send = $MySmartBB->func->mail(	$ForgetMemberInfo['email'],
												$MassegeInfo['title'],
												$MassegeInfo['text'],
												$MySmartBB->_CONF['info_row']['send_email'] );
				
				if ($Send)
				{
					$MySmartBB->func->msg('تم ارسال رسالة التأكيد إلى بريدك الالكتروني، يرجى مراجعته');
					$MySmartBB->func->goto('index.php',2);
				}
				else
				{
					$MySmartBB->func->error('لم يتم الارسال');
				}
			}
		}
	}
}

?>
