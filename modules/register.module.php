<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartRegisterMOD');

class MySmartRegisterMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'register' );
		
		// ... //
		
		if ( $MySmartBB->_CONF[ 'info_row' ][ 'reg_close' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'register_closed' ] );
		
		if ( !$MySmartBB->_CONF[ 'info_row' ][ 'reg_' . $MySmartBB->_CONF[ 'day' ] ] )
   			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_register_today' ] );
   		
   		// ... //
   		
		if ( $MySmartBB->_GET[ 'index' ] )
		{
			if ( $MySmartBB->_CONF[ 'info_row' ][ 'reg_o' ] 
				and ( !isset( $MySmartBB->_GET[ 'agree' ] ) or !$MySmartBB->_GET[ 'agree' ] ) )
			{
				$this->_registerRules();
			}
			else
			{
				$this->_registerForm();
			}
		}
		elseif ( $MySmartBB->_GET[ 'start' ] )
		{
			$MySmartBB->load( 'banned,cache,group,massege' );
			
			$this->_registerStart();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
	    $MySmartBB->func->getFooter();
	}
	
	/**
	 * Print registeration rules
	 */
	private function _registerRules()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'register_rules' ] );
		
		$MySmartBB->_CONF[ 'info_row' ][ 'register_rules' ] = nl2br( $MySmartBB->_CONF[ 'info_row' ][ 'register_rules' ] );
		
		$MySmartBB->plugin->runHooks( 'register_rules_main' );
		
		$MySmartBB->template->display( 'register_rules' );
	}
	
	/**
	 * Show nice form for register :)
	 */
	private function _registerForm()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'registering' ] );
		
		$MySmartBB->plugin->runHooks( 'register_main' );
		
		$MySmartBB->template->display( 'register' );
	}
		
	/**
	 * Some checks then add the member to database
	 */
	private function _registerStart()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'registering' ] );
		
		$MySmartBB->_POST[ 'username' ] 	= 	trim( $MySmartBB->_POST[ 'username' ] );
		$MySmartBB->_POST[ 'email' ] 		= 	trim( $MySmartBB->_POST[ 'email' ] );
		
		// ... //
		
		// A long list of checks before registeration
		$this->__checkFieldsValidity();
		$this->__checkAlreadyUsed();
		$this->__checkBanned();
		$this->__checkConstraints();
		$this->__checkLength();
      		
      	$MySmartBB->_POST[ 'password' ] = md5( $MySmartBB->_POST[ 'password' ] );
      	
      	// ... //
      	
      	$MySmartBB->plugin->runHooks( 'register_start' );
      	
      	// ... //
      	
      	// Get the information of default group to set username style cache
      	$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'info_row' ][ 'def_group' ] . "'";
		
		$GroupInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		// Get the stylish username
		$style = $GroupInfo[ 'username_style' ];
		$username_style_cache = str_replace( '[username]', $MySmartBB->_POST['username'], $style );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'username'		=>	$MySmartBB->_POST[ 'username' ],
      										'password'		=>	$MySmartBB->_POST[ 'password' ],
      										'email'			=>	$MySmartBB->_POST[ 'email' ],
      										'usergroup'		=>	$MySmartBB->_CONF[ 'info_row']['def_group' ],
      										'user_gender'	=>	$MySmartBB->_POST[ 'gender' ],
      										'register_date'	=>	$MySmartBB->_CONF[ 'now' ],
      										'user_title'	=>	$GroupInfo[ 'user_title' ],
      										'style'			=>	$MySmartBB->_CONF[ 'info_row' ][ 'def_style' ],
      										'username_style_cache'	=>	$username_style_cache);
      	
      	$MySmartBB->rec->get_id = true;
      	
      	$insert = $MySmartBB->rec->insert();
      	
      	if ( $insert )
      	{
      		// ... //
      		
      		// Update statistics
      		$MySmartBB->cache->updateLastMember( $MySmartBB->_POST[ 'username' ], $MySmartBB->rec->id );
      		
      		// ... //
      		
      		$MySmartBB->plugin->runHooks( 'register_success' );
      		
      		// ... //
      		
      		// The default group requires an email activation from its members.
      		// Therefore, We register a request and send the activation message to the member's email.
      		if ( $MySmartBB->_CONF[ 'info_row' ][ 'def_group' ] == 5 )
      		{
      			$this->__sendActivationCode();      			
			}
			else
      		{
      			$MySmartBB->func->msg( $MySmartBB->lang[ 'register_succeed' ] );
      			$MySmartBB->func->move( $this->engine->_CONF[ 'init_path' ] . 'login/register_login/' . $MySmartBB->_POST[ 'username' ] . '/' . $MySmartBB->_POST[ 'password' ] );
      		}
      	}
	}
	
	private function __checkFieldsValidity()
	{
		global $MySmartBB;
		
		// Ensure all necessary information are valid
		if ( empty( $MySmartBB->_POST[ 'username' ] ) 
			or empty( $MySmartBB->_POST[ 'password' ] ) 
			or empty( $MySmartBB->_POST[ 'email' ] ) )
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		// Ensure the email is equal the confirm of email
		if ( $MySmartBB->_POST[ 'email' ] != $MySmartBB->_POST[ 'email_confirm' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'email_confirmation_not_identical' ] );
		
		// Ensure the password is equal the confirm of password
		if ( $MySmartBB->_POST[ 'password' ] != $MySmartBB->_POST[ 'password_confirm' ] ) 
			$MySmartBB->func->error( $MySmartBB->lang[ 'password_confirmation_not_identical' ] );
		
		// Check if the email is valid, This line will prevent any false email
		if ( !$MySmartBB->func->checkEmail( $MySmartBB->_POST[ 'email' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'please_write_correct_email' ] );
	}
	
	private function __checkAlreadyUsed()
	{
		global $MySmartBB;
		
		// ... //
		
		// Ensure there is no person used the same username
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['username'] . "'";
		
		$isMember = $MySmartBB->rec->getNumber();
		
		if ( $isMember > 0 )
			$MySmartBB->func->error( $MySmartBB->lang[ 'username_does_exist' ] );
		
		// ... //
		
		// Ensure there is no person used the same email
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "email='" . $MySmartBB->_POST['email'] . "'";
		
		$isMember = $MySmartBB->rec->getNumber();
		
		if ( $isMember > 0 )
			$MySmartBB->func->error( $MySmartBB->lang[ 'email_does_exist' ] );
		
		// ... //
	}
	
	private function __checkBanned()
	{
		global $MySmartBB;
		
		// Store the email provider in explode_email[1] and the name of email in explode_email[0]
		// That will be useful to ban email providers
		$explode_email = explode( '@', $MySmartBB->_POST[ 'email' ] );
		$email_provider = $explode_email[ 1 ];
		
		if ( $MySmartBB->banned->isUsernameBanned( $MySmartBB->_POST[ 'username' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'banned_username' ] );
		
		if ( $MySmartBB->banned->isEmailBanned( $MySmartBB->_POST[ 'email' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'banned_email' ] );
		
		if ( $MySmartBB->banned->isProviderBanned( $email_provider ))
			$MySmartBB->func->error( $MySmartBB->lang[ 'banned_provider' ] );
	}
	
	private function __checkConstraints()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_POST[ 'username' ] == 'Guest' )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_register_this_username' ] );
		
		if ( strstr( $MySmartBB->_POST[ 'username' ], '"' ) 
			or strstr( $MySmartBB->_POST[ 'username' ], "'" ) 
			or strstr( $MySmartBB->_POST[ 'username' ], '>' ) 
			or strstr( $MySmartBB->_POST[ 'username' ], '<' ) )
      	{
      		$MySmartBB->func->error( $MySmartBB->lang[ 'forbidden_symbols' ] );
      	}
	}
	
	private function __checkLength()
	{
		global $MySmartBB;
		
   		if ( !isset( $MySmartBB->_POST[ 'username' ]{ $MySmartBB->_CONF[ 'info_row' ][ 'reg_less_num' ] - 1 } ) )
   			$MySmartBB->func->error( $MySmartBB->lang[ 'username_length_less_than' ] . ' ' . $MySmartBB->_CONF[ 'info_row' ][ 'reg_less_num' ] );
      	
      	if ( isset( $MySmartBB->_POST[ 'username' ]{ $MySmartBB->_CONF[ 'info_row' ][ 'reg_max_num' ] } ) )
       	 	$MySmartBB->func->error( $MySmartBB->lang[ 'username_length_greater_than' ] . ' ' . $MySmartBB->_CONF[ 'info_row' ][ 'reg_max_num' ] );

      	if ( isset( $MySmartBB->_POST[ 'password' ]{ $MySmartBB->_CONF[ 'info_row' ][ 'reg_pass_max_num' ] } ) )
            $MySmartBB->func->error( $MySmartBB->lang[ 'password_length_greater_than' ] . ' ' . $MySmartBB->_CONF[ 'info_row' ][ 'reg_pass_max_num' ] );

      	if ( !isset( $MySmartBB->_POST[ 'password' ]{ $MySmartBB->_CONF[ 'info_row' ][ 'reg_pass_min_num' ] - 1 } ) )
        	$MySmartBB->func->error( $MySmartBB->lang[ 'password_length_less_than' ] . ' ' . $MySmartBB->_CONF[ 'info_row' ][ 'reg_pass_min_num' ] );
	}
	
	private function __sendActivationCode()
	{
		global $MySmartBB;
		
      	$adress	= 	$MySmartBB->func->getForumAdress();
		$code	=	$MySmartBB->func->randomCode();
		
		$ActiveAdress = $adress . 'index.php/activation/' . $code;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
		$MySmartBB->rec->fields = array(	'random_url'	=>	$code,
											'username'		=>	$MySmartBB->_POST[ 'username' ],
											'request_type'	=>	'3'	);
		
		$insert = $MySmartBB->rec->insert();
		
		if ( $insert )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'email_msg' ];
			$MySmartBB->rec->filter = "id='4'";
			
			$MassegeInfo = $MySmartBB->rec->getInfo();
			
			$MassegeInfo[ 'text' ] = $MySmartBB->massege->messageProccess(	$MySmartBB->_POST[ 'username' ], 
																			$MySmartBB->_CONF[ 'info_row' ][ 'title' ], 
																			$ActiveAdress, 
																			null, null, null,
																			$MassegeInfo[ 'text' ] );
			
			$send = $MySmartBB->func->mail(	$MySmartBB->_POST[ 'email' ],
											$MassegeInfo[ 'title' ],
											$MassegeInfo[ 'text' ],
											$MySmartBB->_CONF[ 'info_row' ][ 'send_email' ] );
			
			if ( $send )
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'register_succeed_email' ] );
				$MySmartBB->func->move( 'index.php' );
			}
			else
			{
				$MySmartBB->func->error( $MySmartBB->lang[ 'send_failed' ] );
			}
		}
	}
}

?>
