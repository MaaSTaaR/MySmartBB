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
		
		$MySmartBB->loadLanguage( 'forget' );
		
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
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _index()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'forget_password' ] );
		
		$MySmartBB->plugin->runHooks( 'forget_main_start' );
		
		$MySmartBB->template->display('forget_password_form');
	}
	
	private function _start()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'do_retrieve_password' ] );
		
		$MySmartBB->func->addressBar( $MySmartBB->lang[ 'do_retrieve_password' ] );
		
		if (empty($MySmartBB->_POST['email']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		if (!$MySmartBB->func->checkEmail($MySmartBB->_POST['email']))
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'write_correct_email' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "email='" . $MySmartBB->_POST['email'] . "'";
		
		$CheckEmail = $MySmartBB->rec->getNumber();
		
		if ( $CheckEmail > 0 )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'email_doesnt_exist' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "email='" . $MySmartBB->_POST['email'] . "'";
		
		$ForgetMemberInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'forget_action_start' );
		
		// ... //
		
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
				    $MySmartBB->plugin->runHooks( 'forget_action_success' );
				    
					$MySmartBB->func->msg( $MySmartBB->lang[ 'email_sent' ] );
					$MySmartBB->func->move('index.php',2);
				}
				else
				{
				    $MySmartBB->plugin->runHooks( 'forget_action_failed' );
				    
					$MySmartBB->func->error( $MySmartBB->lang[ 'email_didnt_send' ] );
				}
			}
		}
	}
}

?>
