<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['REQUEST'] 	= 	true;
$CALL_SYSTEM['MESSAGE'] 	= 	true;

include('common.php');

define('CLASS_NAME','MySmartForgetMOD');

class MySmartForgetMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_Index();
		}
		elseif ($MySmartBB->_GET['start'])
		{
			$this->_Start();
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	function _Index()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('استرجاع كلمة المرور');
				
		$MySmartBB->template->display('forget_password_form');
	}
	
	function _Start()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ عملية استرجاع كلمة المرور');
		
		$MySmartBB->functions->AddressBar('تنفيذ عملية استرجاع كلمة المرور');
		
		if (empty($MySmartBB->_POST['email']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		if (!$MySmartBB->functions->CheckEmail($MySmartBB->_POST['email']))
		{
			$MySmartBB->functions->error('يرجى كتابة بريدك الالكتروني الصحيح');
		}
		
		$CheckArr 			= 	array();
		$CheckArr['where']	=	array('email',$MySmartBB->_POST['email']);
		
		$CheckEmail = $MySmartBB->member->IsMember($CheckArr);
		
		if (!$CheckEmail)
		{
			$MySmartBB->functions->error('البريد الالكتروني غير موجود في قواعد بياناتنا !');
		}
		
		$MemberArr 			= 	array();
		$MemberArr['where'] 	= 	array('email',$MySmartBB->_POST['email']);
		
		$ForgetMemberInfo = $MySmartBB->member->GetMemberInfo($MemberArr);
			
		$MySmartBB->functions->CleanVariable($ForgetMemberInfo,'html');
		$MySmartBB->functions->CleanVariable($ForgetMemberInfo,'sql');
		
		$Adress = 	$MySmartBB->functions->GetForumAdress();
		$Code	=	$MySmartBB->functions->RandomCode();
		
		$ChangeAdress = $Adress . 'index.php?page=new_password&index=1&code=' . $Code;
		$CancelAdress = $Adress . 'index.php?page=cancel_requests&index=1&type=1&code=' . $Code;
		
		$ReqArr 				= 	array();
		$ReqArr['field']		=	array();
		
		$ReqArr['field']['random_url'] 		= 	$Code;
		$ReqArr['field']['username'] 		= 	$ForgetMemberInfo['username'];
		$ReqArr['field']['request_type'] 	= 	1;
		
		$InsertReq = $MySmartBB->request->InsertRequest($ReqArr);
		
		if ($InsertReq)
		{
			$UpdateArr 					= 	array();
			$UpdateArr['field']			=	array();
			
			$UpdateArr['field']['new_password'] 	= 	$MySmartBB->functions->RandomCode();
			$UpdateArr['where'] 					= 	array('id',$ForgetMemberInfo['id']);
			
			$UpdateNewPassword = $MySmartBB->member->UpdateMember($UpdateArr);
			
			if ($UpdateNewPassword)
			{
				$MsgArr 			= 	array();
				$MsgArr['where'] 	= 	array('id','1');
				
				$MassegeInfo = $MySmartBB->message->GetMessageInfo($MsgArr);
			
				$MsgArr 				= 	array();
				$MsgArr['text'] 		= 	$MassegeInfo['text'];
				$MsgArr['change_url'] 	= 	$ChangeAdress;
				$MsgArr['cancel_url'] 	= 	$CancelAdress;
				$MsgArr['username']		=	$MySmartBB->_CONF['member_row']['username'];
				$MsgArr['title']		=	$MySmartBB->_CONF['info_row']['title'];
				
				$MassegeInfo['text'] = $MySmartBB->message->MessageProccess($MsgArr);
				
				$Send = $MySmartBB->functions->mail($ForgetMemberInfo['email'],$MassegeInfo['title'],$MassegeInfo['text'],$MySmartBB->_CONF['info_row']['send_email']);
				
				if ($Send)
				{
					$MySmartBB->functions->msg('تم ارسال رسالة التأكيد إلى بريدك الالكتروني، يرجى مراجعته');
					$MySmartBB->functions->goto('index.php',2);
				}
				else
				{
					$MySmartBB->functions->error('لم يتم الارسال');
				}
			}
		}
	}
}

?>
