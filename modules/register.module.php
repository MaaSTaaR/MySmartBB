<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['BANNED'] 		= 	true;
$CALL_SYSTEM['CACHE'] 		= 	true;
$CALL_SYSTEM['REQUEST'] 	= 	true;
$CALL_SYSTEM['MESSAGE'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartRegisterMOD');

class MySmartRegisterMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['info_row']['reg_close'])
		{
			$MySmartBB->func->error('المعذره .. التسجيل مغلق');
		}
		
		if (!$MySmartBB->_CONF['info_row']['reg_' . $MySmartBB->_CONF['day']])
   		{
   			$MySmartBB->func->error('المعذره .. لا يمكنك التسجيل اليوم');
   		}
   		
		/** Show register form **/
		if ($MySmartBB->_GET['index'])
		{
			if ($MySmartBB->_CONF['info_row']['reg_o'] 
				and ( !isset( $MySmartBB->_GET[ 'agree' ] ) or !$MySmartBB->_GET[ 'agree' ] ) )
			{
				$this->_registerRules();
			}
			else
			{
				$this->_registerForm();
			}
		}
		/** **/
		
		/** Start registetr **/
		elseif ($MySmartBB->_GET['start'])
		{
			$this->_registerStart();
		}
		/** **/
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		if (!$MySmartBB->_CONF['info_row']['ajax_register'])
		{
			if (!isset($MySmartBB->_POST['ajax']))
			{
				$MySmartBB->func->getFooter();
			}
		}
	}
	
	/**
	 * Print registeration rules
	 */
	private function _registerRules()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('شروط التسجيل');
		
		$MySmartBB->template->display('register_rules');
	}
	
	/**
	 * Show nice form for register :)
	 */
	private function _registerForm()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('التسجيل');
		
		$MySmartBB->template->display('register');
	}
		
	/**
	 * Some checks then add the member to database
	 */
	private function _registerStart()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تنفيذ عملية التسجيل');
		
		// Clean the username and email from white spaces
		$MySmartBB->_POST['username'] 	= 	$MySmartBB->func->cleanVariable($MySmartBB->_POST['username'],'trim');
		$MySmartBB->_POST['email'] 		= 	$MySmartBB->func->cleanVariable($MySmartBB->_POST['email'],'trim');
		
		// Store the email provider in explode_email[1] and the name of email in explode_email[0]
		// That will be useful to ban email provider
		$explode_email = explode('@',$MySmartBB->_POST['email']);
	
		// Well , we get the provider of email
		$EmailProvider = $explode_email[1];
		
		// Ensure all necessary information are valid
		if (empty($MySmartBB->_POST['username']) 
			or empty($MySmartBB->_POST['password']) 
			or empty($MySmartBB->_POST['email']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		// Ensure the email is equal the confirm of email
		if ($MySmartBB->_POST['email'] != $MySmartBB->_POST['email_confirm'])
		{
			$MySmartBB->func->error('تأكيد البريد الالكتروني غير صحيح');
		}
		
		// Ensure the password is equal the confirm of password
		if ($MySmartBB->_POST['password'] != $MySmartBB->_POST['password_confirm']) 
		{
			$MySmartBB->func->error('تأكيد كلمة المرور غير صحيح');
		}
		
		// Check if the email is valid, This line will prevent any false email
		if (!$MySmartBB->func->checkEmail($MySmartBB->_POST['email']))
		{
			$MySmartBB->func->error('يرجى كتابة بريدك الالكتروني الصحيح');
		}
		
		// Ensure there is no person used the same username
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['username'] . "'";
		
		$isMember = $MySmartBB->member->isMember();
		
		if ( $isMember )
		{
			$MySmartBB->func->error('المعذره اسم المستخدم موجود مسبقاً يرجى اختيار اسم آخر');
		}
		
		// Ensure there is no person used the same email
		
		$MySmartBB->rec->filter = "email='" . $MySmartBB->_POST['email'] . "'";
		
		$isMember = $MySmartBB->member->isMember();
		
		if ( $isMember )
		{
			$MySmartBB->func->error('البريد الالكتروني مسجل مسبقاً , يرجى كتابة غيره');
		}
		
		if ($MySmartBB->banned->isUsernameBanned( $MySmartBB->_POST['username'] ))
		{
			$MySmartBB->func->error('المعذره .. لا يمكنك التسجيل بهذا الاسم لانه ممنوع من قبل الاداره');
		}
		
		if ($MySmartBB->banned->isEmailBanned( $MySmartBB->_POST['email'] ))
		{
			$MySmartBB->func->error('المعذره .. لا يمكنك التسجيل بهذا البريد الالكتروني لانه ممنوع من قبل الاداره');
		}
		
		if ($MySmartBB->banned->IsProviderBanned( $EmailProvider ))
		{
			$MySmartBB->func->error('المعذره .. لا يمكنك التسجيل بهذا البريد لان مزود البريد ممنوع من التسجيل');
		}
		
		if ($MySmartBB->_POST['username'] == 'Guest')
		{
			$MySmartBB->func->error('المعذره .. لا يمكنك التسجيل بهذا الاسم');
		}

   		if (!isset($MySmartBB->_POST['username']{$MySmartBB->_CONF['info_row']['reg_less_num']}))
   		{
   			$MySmartBB->func->error('عدد حروف إسم المستخدم أقل من (' . $MySmartBB->_CONF['info_row']['reg_less_num'] . ')');
      	}
      	
      	if (isset($MySmartBB->_POST['username']{$MySmartBB->_CONF['info_row']['reg_max_num']+1}))
      	{
       	 	$MySmartBB->func->error('عدد حروف اسم المستخدم أكبر من  (' . $MySmartBB->_CONF['info_row']['reg_max_num'] . ')');
      	}

      	if (isset($MySmartBB->_POST['password']{$MySmartBB->_CONF['info_row']['reg_pass_max_num']+1}))
      	{
            $MySmartBB->func->error('عدد حروف كلمة المرور أكبر من (' . $MySmartBB->_CONF['info_row']['reg_pass_max_num'] . ')');
      	}

      	if (!isset($MySmartBB->_POST['password']{$MySmartBB->_CONF['info_row']['reg_pass_min_num']-1}))
      	{
        	$MySmartBB->func->error('عدد حروف كلمة المرور أقل من (' . $MySmartBB->_CONF['info_row']['reg_pass_min_num'] . ')');
      	}
      		
		if (strstr($MySmartBB->_POST['username'],'"') 
			or strstr($MySmartBB->_POST['username'],"'") 
			or strstr($MySmartBB->_POST['username'],'>') 
			or strstr($MySmartBB->_POST['username'],'<'))
      	{
      		$MySmartBB->func->error('المعذره .. لا يمكنك التسجيل بهذه الرموز');
      	}
      		
      	$MySmartBB->_POST['password'] = md5($MySmartBB->_POST['password']);
      	
      	/* ... */
      	
      	// Get the information of default group to set username style cache
      	
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['info_row']['def_group'] . "'";
		
		$GroupInfo = $MySmartBB->group->getGroupInfo();
		
		$style = $GroupInfo['username_style'];
		$username_style_cache = str_replace('[username]',$MySmartBB->_POST['username'],$style);
		
		/* ... */
		
		$MySmartBB->rec->fields = array(	'username'	=>	$MySmartBB->_POST['username'],
      										'password'	=>	$MySmartBB->_POST['password'],
      										'email'	=>	$MySmartBB->_POST['email'],
      										'usergroup'	=>	$MySmartBB->_CONF['info_row']['def_group'],
      										'user_gender'	=>	$MySmartBB->_POST['gender'],
      										'register_date'	=>	$MySmartBB->_CONF['now'],
      										'user_title'	=>	'عضو',
      										'style'	=>	$MySmartBB->_CONF['info_row']['def_style'],
      										'username_style_cache'	=>	$username_style_cache);
      	
      	$MySmartBB->member->get_id = true;
      	
      	$insert = $MySmartBB->member->insertMember();
      	
      	if (!$MySmartBB->_CONF['info_row']['ajax_register'])
      	{
      		if (!isset($MySmartBB->_POST['ajax']))
      		{
      			$MySmartBB->func->addressBar('تنفيذ عملية التسجيل');
      		}
      	}
      	
      	// Ouf finally , but we still have work in this module
      	if ($insert)
      	{
      		$member_num = $this->engine->_CONF['info_row']['member_number'];
      			
      		$MySmartBB->cache->updateLastMember( $member_num, $MySmartBB->_POST['username'], $MySmartBB->member->id );
      														
      		if ($MySmartBB->_CONF['info_row']['def_group'] == 5)
      		{
      			$adress	= 	$MySmartBB->func->getForumAdress();
				$code	=	$MySmartBB->func->randomCode();
			
				$ActiveAdress = $Adress . 'index.php?page=active_member&index=1&code=' . $code;
		
				$MySmartBB->rec->fields = array(	'random_url'	=>	$code,
													'username'	=>	$MySmartBB->_POST['username'],
													'request_type'	=>	'3'	);
												
				$insert = $MySmartBB->request->insertRequest();
			
				if ($insert)
				{
					$MySmartBB->rec->filter = "id='4'";
					
					$MassegeInfo = $MySmartBB->massege->getMessageInfo();
					
					$MassegeInfo['text'] = $MySmartBB->massege->messageProccess( $MySmartBB->_CONF['member_row']['username'], $MySmartBB->_CONF['info_row']['title'], $ActiveAdress, null, null, $MassegeInfo['text'] );
					
					$Send = $MySmartBB->func->mail($MySmartBB->_CONF['member_row']['email'],$MassegeInfo['title'],$MassegeInfo['text'],$MySmartBB->_CONF['info_row']['send_email']);
					
					if ($Send)
					{
						$MySmartBB->func->msg('تم التسجيل بنجاح، و تم ارسال بريد التفعيل إلى بريدك الالكتروني');
						
						if (!$MySmartBB->_CONF['info_row']['ajax_register'])
						{
							if (!isset($MySmartBB->_POST['ajax']))
							{
								$MySmartBB->func->goto('index.php');
							}
						}
					}
				}
			}
			else
      		{
      			$MySmartBB->func->msg('تم التسجيل بنجاح');
      			
      			if (!$MySmartBB->_CONF['info_row']['ajax_register'])
      			{
      				if (!isset($MySmartBB->_POST['ajax']))
      				{
      					$MySmartBB->func->goto('index.php?page=login&register_login=1&username=' . $MySmartBB->_POST['username'] . '&password=' . $MySmartBB->_POST['password']);
      				}
      			}
      		}
      	}
	}
}

?>
