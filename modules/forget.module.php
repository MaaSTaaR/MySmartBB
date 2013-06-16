<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartForgetMOD' );

class MySmartForgetMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'forget' );
		
		$MySmartBB->load( 'massege' );

		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'forget_password' ] );
		
		$MySmartBB->plugin->runHooks( 'forget_main_start' );
		
		$MySmartBB->template->display( 'forget_password_form' );		
	}
		
	public function start()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->loadLanguage( 'forget' );
		
		$MySmartBB->load( 'massege' );
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'do_retrieve_password' ] );
		$MySmartBB->func->addressBar( $MySmartBB->lang[ 'do_retrieve_password' ] );
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'email' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		if ( !$MySmartBB->func->checkEmail( $MySmartBB->_POST[ 'email' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'write_correct_email' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "email='" . $MySmartBB->_POST[ 'email' ] . "'";
		
		$ForgetMemberInfo = $MySmartBB->rec->getInfo();
		
		if ( !$ForgetMemberInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'email_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'forget_action_start' );
		
		// ... //
		
		$Adress = 	$MySmartBB->func->getForumAdress();
		$Code	=	$MySmartBB->func->randomCode();
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
		
		$MySmartBB->rec->fields = array(	'random_url'	=>	$Code,
											'username'		=>	$ForgetMemberInfo[ 'username' ],
											'request_type'	=>	'1'	);
												
		$insert = $MySmartBB->rec->insert();
		
		if ( $insert )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->fields = array(	'new_password'	=>	$MySmartBB->func->randomCode() );
			$MySmartBB->rec->filter = "id='" . $ForgetMemberInfo[ 'id' ] . "'";
			
			$update = $MySmartBB->rec->update();
			
			if ( $update )
			{
				$ChangeAdress = $Adress . 'index.php/new_password/' . $Code;
				$CancelAdress = $Adress . 'index.php/cancel_requests/1/' . $Code;
				
				// ... //
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'email_msg' ];
				$MySmartBB->rec->filter = "id='1'";
				
				$MassegeInfo = $MySmartBB->rec->getInfo();
				
				$MassegeInfo[ 'text' ] = $MySmartBB->massege->messageProccess( 	$ForgetMemberInfo[ 'username' ], 
																				$MySmartBB->_CONF[ 'info_row' ][ 'title' ], 
																				null, 
																				$ChangeAdress, 
																				$CancelAdress,
																				null,
																				$MassegeInfo[ 'text' ] );
				
				$Send = $MySmartBB->func->mail(	$ForgetMemberInfo[ 'email' ],
												$MassegeInfo[ 'title' ],
												$MassegeInfo[ 'text' ],
												$MySmartBB->_CONF[ 'info_row' ][ 'send_email' ] );
				
				if ( $Send )
				{
				    $MySmartBB->plugin->runHooks( 'forget_action_success' );
				    
					$MySmartBB->func->msg( $MySmartBB->lang[ 'email_sent' ] );
					$MySmartBB->func->move( '' );
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
