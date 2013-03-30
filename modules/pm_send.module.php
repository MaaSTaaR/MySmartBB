<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'JAVASCRIPT_SMARTCODE', true );

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartPrivateMassegeSendMOD' );

class MySmartPrivateMassegeSendMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'pm_send' );
		
		// ... //
		
		if ( !$MySmartBB->_CONF[ 'info_row' ][ 'pm_feature' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'pm_feature_stopped' ] );
		
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'use_pm' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_use_pm' ] );
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		
		// ... //
		
		$MySmartBB->load( 'pm,icon,toolbox,attach' );
		
		if ( $MySmartBB->_GET[ 'send' ] )
		{
			if ( $MySmartBB->_GET[ 'index' ] )
			{
				$this->_sendForm();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_startSend();
			}
		}

		$MySmartBB->func->getFooter();
	}
	
	private function _sendForm()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'send_pm' ] );
		
		if ( isset( $MySmartBB->_GET[ 'username' ] ) )
		{
			$MySmartBB->rec->select = 'username,pm_senders,away,pm_senders_msg,away_msg';
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->filter = "username='" . $MySmartBB->_GET[ 'username' ] . "'";
			
			$info = $MySmartBB->rec->getInfo();
															
			if ( !$info )
				$MySmartBB->func->error( $MySmartBB->lang[ 'member_doesnt_exist' ] );
			
			$MySmartBB->template->assign( 'recv_info', $info );
			$MySmartBB->template->assign( 'to', $info[ 'username' ] );
		}
		
		$MySmartBB->func->getEditorTools();
		
		$MySmartBB->plugin->runHooks( 'pm_send_main' );
		
		$MySmartBB->template->display( 'pm_send' );
	}
	
	private function _startSend()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'pm_send_process' ] );
		$MySmartBB->func->addressBar( '<a href="index.php?page=pm&amp;list=1&amp;folder=inbox">' . $MySmartBB->lang[ 'template' ][ 'pm' ] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $MySmartBB->lang[ 'pm_send_process' ] );
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'to' ][ 0 ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'write_username' ] );
		
		if ( empty( $MySmartBB->_POST[ 'title' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'write_title' ] );
		
		if ( empty( $MySmartBB->_POST[ 'text' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'write_message' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'pm_send_action_start' );
		
		// TODO : It's totally ugly code, do something :-(
		
		$size = sizeof( $MySmartBB->_POST[ 'to' ] );
		
		if ( $size <= 0 )
			$MySmartBB->func->error( $MySmartBB->MySmartBB->lang_common[ 'wrong_path' ] );
		
		$success 	= 	array();
		$fail		=	array();
		
     	$x = 0;
     	
     	for ( $x = 0; $x < $size; $x++ )
     	{
     		$username = $MySmartBB->_POST[ 'to' ][ $x ];
     		
     		// ... //
     		
     		if ( in_array( $username, $success ) or in_array( $username, $fail ) )
     			continue;
     		
     		if ( empty( $username ) )
     			continue;
			
     		// ... //
     		
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->filter = "username='" . $username . "'";
			
			$GetToInfo = $MySmartBB->rec->getInfo();
			
			if ( !$GetToInfo )
			{
				if ( $size > 1 )
				{
					$fail[] = $username;
					
					continue;
				}
				elseif ( $size == 1 )
				{
					$MySmartBB->func->error( $MySmartBB->lang[ 'member_doesnt_exist' ] );
				}
			}
			
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
			$MySmartBB->rec->filter = "id='" . $GetToInfo[ 'usergroup' ] . "'";
			
			$GetMemberOptions = $MySmartBB->rec->getInfo();
			
			if ( !$GetMemberOptions[ 'resive_pm' ] )
			{
				if ( $size > 1 )
				{
					$fail[] = $username;
					
					continue;
				}
				elseif ( $size == 1 )
				{
					$MySmartBB->func->error( $MySmartBB->lang[ 'member_cant_receive' ] );
				}
			}
			
			// ... //
			
			if ( $GetMemberOptions[ 'max_pm' ] > 0 )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
				$MySmartBB->rec->filter = "user_to='" . $GetToInfo[ 'username' ] . "'";
				
				$PrivateMassegeNumber = $MySmartBB->rec->getNumber();
				
				if ( $PrivateMassegeNumber > $GetMemberOptions[ 'max_pm' ] )
				{
					if ( $size > 1 )
					{
						$fail[] = $username;
							
						continue;
					}
					elseif ( $size == 1 )
					{
						$MySmartBB->func->error( $MySmartBB->lang[ 'member_max_inbox' ] );
					}
				}
			}
			
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
			$MySmartBB->rec->fields = array(	'user_from'	=>	$MySmartBB->_CONF[ 'member_row' ][ 'username' ],
												'user_to'	=>	$GetToInfo[ 'username' ],
												'title'	=>	$MySmartBB->_POST[ 'title' ],
												'text'	=>	$MySmartBB->_POST[ 'text' ],
												'date'	=>	$MySmartBB->_CONF[ 'now' ],
												'icon'	=>	$MySmartBB->_POST[ 'icon' ],
												'folder'	=>	'inbox'	);
			
			$MySmartBB->rec->get_id = true;
			
			$sent = $MySmartBB->rec->insert();
			
			$pm_id = $MySmartBB->rec->id;
			
			// ... //
													
			if ( $sent )
			{
     			if ( $MySmartBB->_POST[ 'attach' ] )
     				$MySmartBB->attach->uploadAttachments(	true, 
															$MySmartBB->_CONF[ 'group_info' ][ 'upload_attach_num' ], 
															$pm_id, 'files', 'pm' );
     			
     			// ... //
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
				$MySmartBB->rec->fields = array(	'user_from'	=>	$MySmartBB->_CONF[ 'member_row' ][ 'username' ],
													'user_to'	=>	$GetToInfo[ 'username' ],
													'title'	=>	$MySmartBB->_POST[ 'title' ],
													'text'	=>	$MySmartBB->_POST[ 'text' ],
													'date'	=>	$MySmartBB->_CONF[ 'now' ],
													'icon'	=>	$MySmartBB->_POST[ 'icon' ],
													'folder'	=>	'sent'	);
												
				$SentBox = $MySmartBB->rec->insert();
													
				if ( $SentBox )
				{
					if ( $GetToInfo[ 'autoreply' ] )
					{
						$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
						$MySmartBB->rec->fields = array(	'user_from'	=>	$GetToInfo['username'],
															'user_to'	=>	$MySmartBB->_CONF['member_row']['username'],
															'title'	=>	$MySmartBB->lang[ 'auto_reply' ] . ' ' . $GetToInfo['autoreply_title'],
															'text'	=>	$GetToInfo['autoreply_msg'],
															'date'	=>	$MySmartBB->_CONF['now'],
															'folder'	=>	'inbox'	);
													
						$insert = $MySmartBB->rec->insert();
						
						if ( $insert )
						{
							$new_pm = $MySmartBB->pm->newMessageNumber( $MySmartBB->_CONF['member_row']['username'] );
							
							$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
							$MySmartBB->rec->fields = array(	'unread_pm'	=>	$new_pm	);
							$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
								
							$MySmartBB->rec->update();
						}
					}
					
					$Number = $MySmartBB->pm->newMessageNumber( $GetToInfo[ 'username' ] );
		     			
		    		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
					$MySmartBB->rec->fields = array(	'unread_pm'	=>	$Number	);
					$MySmartBB->rec->filter = "username='" . $GetToInfo[ 'username' ] . "'";
					
					$Cache = $MySmartBB->rec->update();
					
					if ($Cache)
						$success[] = $username;
				}
			}
		}
     	
     	$sucess_number 	= 	sizeof( $success );
     	$fail_numer		=	sizeof( $fail );

     	if ( $sucess_number == $size )
     	{
     		$MySmartBB->func->msg( $MySmartBB->lang[ 'message_sent' ] );	
     	}
     	elseif ( $fail_number == $size )
     	{
     		$MySmartBB->func->msg( $MySmartBB->lang[ 'sent_fail' ] );
     	}
     	elseif ( $sucess_number < $size )
     	{
     		$MySmartBB->func->msg( $MySmartBB->lang[ 'sent_for_some' ] );
     	}
     	
     	$MySmartBB->func->move('index.php?page=pm_list&amp;list=1&amp;folder=inbox');
	}
}

?>