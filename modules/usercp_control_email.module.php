<?php

// TODO :: Audit this file

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_func',true);
define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartUserCPEmailMOD');

class MySmartUserCPEmailMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->func->error( 'المعذره .. هذه المنطقه للاعضاء فقط' );
		}
		
		$MySmartBB->load( 'massege' );
		
		if ( $MySmartBB->_GET[ 'main' ] )				
		{
			$this->_emailMain();
		}
		elseif ( $MySmartBB->_GET[ 'start' ] )
		{
			$this->_emailChange();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _emailMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( 'تغيير البريد الالكتروني' );
		
		$MySmartBB->template->display( 'usercp_control_email' );
	}
	
	private function _emailChange()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->func->showHeader( 'تنفيذ العمليه' );
		
		$MySmartBB->func->addressBar( '<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ العمليه' );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "email='" .  $MySmartBB->_POST[ 'new_email' ]. "'";
		
		$EmailExists = $MySmartBB->member->isMember();
		
		if (empty($MySmartBB->_POST['new_email']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		if (!$MySmartBB->func->checkEmail($MySmartBB->_POST['new_email']))
		{
			$MySmartBB->func->error('يرجى كتابة بريدك الالكتروني الصحيح');
		}
		if ( $EmailExists > 0 )
		{
			$MySmartBB->func->error('المعذره .. البريد الالكتروني موجود مسبقاً');
		}
		
		$MySmartBB->_POST['new_email'] = trim( $MySmartBB->_POST['new_email'] );
		
		// We will send a confirm message, The confirm message will help user protect himself from crack
		if ($MySmartBB->_CONF['info_row']['confirm_on_change_mail'])
		{
			$adress	= 	$MySmartBB->func->getForumAdress();
			$code	=	$MySmartBB->func->randomCode();
		
			$ChangeAdress = $adress . 'index.php?page=new_email&index=1&code=' . $code;
			$CancelAdress = $adress . 'index.php?page=cancel_requests&index=1&type=2&code=' . $code;
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
			$MySmartBB->rec->fields = array(	'random_url'	=>	$code,
												'username'	=>	$MySmartBB->_CONF['member_rows']['username'],
												'request_type'	=>	'2'	);
		
			$insert = $MySmartBB->rec->insert();
		
			if ( $insert )
			{
				$UpdateArr = array();
			
				$UpdateArr['email'] 	= 	$MySmartBB->_POST['new_email'];
				$UpdateArr['where'] 	= 	array('id',$MySmartBB->_CONF['member_row']['id']);
			
				$UpdateNewEmail = $MySmartBB->member->UpdateNewEmail($UpdateArr); /* TODO : may you tell me please, where is this function? */
			
				if ($UpdateNewEmail)
				{
					$MassegeInfo = $MySmartBB->massege->GetMessageInfo(array('id'	=>	2));
					
					$MassegeInfo['text'] = $MySmartBB->massege->messageProccess( $MySmartBB->_CONF['member_row']['username'], $MySmartBB->_CONF['info_row']['title'], null, $ChangeAdress, $CancelAdress, $MassegeInfo['text'] );
				
					$send = $MySmartBB->func->mail($MySmartBB->_CONF['rows']['member_row']['email'],$MassegeInfo['title'],$MassegeInfo['text'],$MySmartBB->_CONF['info_row']['send_email']);
				
					if ( $send )
					{
						$MySmartBB->func->msg('تم ارسال رسالة التأكيد إلى بريدك الالكتروني , يرجى مراجعته');
						$MySmartBB->func->move('index.php?page=usercp&index=1');
					}
				}
			}
		}
		// Confirm message is off, so change email direct
		else
		{
			$MySmartBB->rec->fields = array(	'new_email'	=>	$MySmartBB->_POST['new_email']	);
			$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF['member_row']['id'] . "'";
					
			$update = $MySmartBB->member->updateMember();
		
			if ( $update )
			{
				$MySmartBB->func->msg( 'تم التحديث بنجاح !' );
				$MySmartBB->func->move( 'index.php?page=usercp_control_email&amp;main=1' );
			}
		}
	}
}
