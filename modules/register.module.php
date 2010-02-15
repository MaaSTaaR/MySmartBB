<?php

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
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['info_row']['reg_close'])
		{
			$MySmartBB->functions->error('المعذره .. التسجيل مغلق');
		}
		
		if (!$MySmartBB->_CONF['info_row']['reg_' . $MySmartBB->_CONF['day']])
   		{
   			$MySmartBB->functions->error('المعذره .. لا يمكنك التسجيل اليوم');
   		}
   		
		/** Show register form **/
		if ($MySmartBB->_GET['index'])
		{
			if ($MySmartBB->_CONF['info_row']['reg_o'] 
				and ( !isset( $MySmartBB->_GET[ 'agree' ] ) or !$MySmartBB->_GET[ 'agree' ] ) )
			{
				$this->_RegisterRules();
			}
			else
			{
				$this->_RegisterForm();
			}
		}
		/** **/
		
		/** Start registetr **/
		elseif ($MySmartBB->_GET['start'])
		{
			$this->_RegisterStart();
		}
		/** **/
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		if (!$MySmartBB->_CONF['info_row']['ajax_register'])
		{
			if (!isset($MySmartBB->_POST['ajax']))
			{
				$MySmartBB->functions->GetFooter();
			}
		}
	}
	
	/**
	 * Print registeration rules
	 */
	function _RegisterRules()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('شروط التسجيل');
		
		$MySmartBB->template->display('register_rules');
	}
	
	/**
	 * Show nice form for register :)
	 */
	function _RegisterForm()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('التسجيل');
		
		$MySmartBB->template->display('register');
	}
		
	/**
	 * Some checks then add the member to database
	 */
	function _RegisterStart()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ عملية التسجيل');
		
		// Clean the username and email from white spaces
		$MySmartBB->_POST['username'] 	= 	$MySmartBB->functions->CleanVariable($MySmartBB->_POST['username'],'trim');
		$MySmartBB->_POST['email'] 		= 	$MySmartBB->functions->CleanVariable($MySmartBB->_POST['email'],'trim');
		
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
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		// Ensure the email is equal the confirm of email
		if ($MySmartBB->_POST['email'] != $MySmartBB->_POST['email_confirm'])
		{
			$MySmartBB->functions->error('تأكيد البريد الالكتروني غير صحيح');
		}
		
		// Ensure the password is equal the confirm of password
		if ($MySmartBB->_POST['password'] != $MySmartBB->_POST['password_confirm']) 
		{
			$MySmartBB->functions->error('تأكيد كلمة المرور غير صحيح');
		}
		
		// Check if the email is valid, This line will prevent any false email
		if (!$MySmartBB->functions->CheckEmail($MySmartBB->_POST['email']))
		{
			$MySmartBB->functions->error('يرجى كتابة بريدك الالكتروني الصحيح');
		}
		
		// Ensure there is no person used the same username
		if ($MySmartBB->member->IsMember(array('where' => array('username',$MySmartBB->_POST['username']))))
		{
			$MySmartBB->functions->error('المعذره اسم المستخدم موجود مسبقاً يرجى اختيار اسم آخر');
		}
		
		// Ensure there is no person used the same email
		if ($MySmartBB->member->IsMember(array('where' => array('email',$MySmartBB->_POST['email']))))
		{
			$MySmartBB->functions->error('البريد الالكتروني مسجل مسبقاً , يرجى كتابة غيره');
		}
		
		if ($MySmartBB->banned->IsUsernameBanned(array('username'	=>	$MySmartBB->_POST['username'])))
		{
			$MySmartBB->functions->error('المعذره .. لا يمكنك التسجيل بهذا الاسم لانه ممنوع من قبل الاداره');
		}
		
		if ($MySmartBB->banned->IsEmailBanned(array('email'	=>	$MySmartBB->_POST['email'])))
		{
			$MySmartBB->functions->error('المعذره .. لا يمكنك التسجيل بهذا البريد الالكتروني لانه ممنوع من قبل الاداره');
		}
		
		if ($MySmartBB->banned->IsProviderBanned(array('provider'	=>	$EmailProvider)))
		{
			$MySmartBB->functions->error('المعذره .. لا يمكنك التسجيل بهذا البريد لان مزود البريد ممنوع من التسجيل');
		}
		
		if ($MySmartBB->_POST['username'] == 'Guest')
		{
			$MySmartBB->functions->error('المعذره .. لا يمكنك التسجيل بهذا الاسم');
		}

   		if (!isset($MySmartBB->_POST['username']{$MySmartBB->_CONF['info_row']['reg_less_num']}))
   		{
   			$MySmartBB->functions->error('عدد حروف إسم المستخدم أقل من (' . $MySmartBB->_CONF['info_row']['reg_less_num'] . ')');
      	}
      	
      	if (isset($MySmartBB->_POST['username']{$MySmartBB->_CONF['info_row']['reg_max_num']+1}))
      	{
       	 	$MySmartBB->functions->error('عدد حروف اسم المستخدم أكبر من  (' . $MySmartBB->_CONF['info_row']['reg_max_num'] . ')');
      	}

      	if (isset($MySmartBB->_POST['password']{$MySmartBB->_CONF['info_row']['reg_pass_max_num']+1}))
      	{
            $MySmartBB->functions->error('عدد حروف كلمة المرور أكبر من (' . $MySmartBB->_CONF['info_row']['reg_pass_max_num'] . ')');
      	}

      	if (!isset($MySmartBB->_POST['password']{$MySmartBB->_CONF['info_row']['reg_pass_min_num']-1}))
      	{
        	$MySmartBB->functions->error('عدد حروف كلمة المرور أقل من (' . $MySmartBB->_CONF['info_row']['reg_pass_min_num'] . ')');
      	}
      		
		if (strstr($MySmartBB->_POST['username'],'"') 
			or strstr($MySmartBB->_POST['username'],"'") 
			or strstr($MySmartBB->_POST['username'],'>') 
			or strstr($MySmartBB->_POST['username'],'<'))
      	{
      		$MySmartBB->functions->error('المعذره .. لا يمكنك التسجيل بهذه الرموز');
      	}
      		
      	$MySmartBB->_POST['password'] = md5($MySmartBB->_POST['password']);
      	
      	//////////
      	
      	// Get the information of default group to set username style cache
      	
		$GrpArr 			= 	array();
		$GrpArr['where'] 	= 	array('id',$MySmartBB->_CONF['info_row']['def_group']);
		
		$GroupInfo = $MySmartBB->group->GetGroupInfo($GrpArr);
		
		$style = $GroupInfo['username_style'];
		$username_style_cache = str_replace('[username]',$MySmartBB->_POST['username'],$style);
		
      	//////////
      	
      	$InsertArr 					= 	array();
      	$InsertArr['field']			=	array();
      	
      	$InsertArr['field']['username'] 			= 	$MySmartBB->_POST['username'];
      	$InsertArr['field']['password'] 			= 	$MySmartBB->_POST['password'];
      	$InsertArr['field']['email'] 				= 	$MySmartBB->_POST['email'];
      	$InsertArr['field']['usergroup'] 			= 	$MySmartBB->_CONF['info_row']['def_group'];
      	$InsertArr['field']['user_gender'] 			= 	$MySmartBB->_POST['gender'];
      	$InsertArr['field']['register_date'] 		= 	$MySmartBB->_CONF['now'];
      	$InsertArr['field']['user_title'] 			= 	'عضو';
      	$InsertArr['field']['style'] 				= 	$MySmartBB->_CONF['info_row']['def_style'];
      	$InsertArr['field']['username_style_cache']	=	$username_style_cache;
      	$InsertArr['get_id']						=	true;
      	
      	$insert = $MySmartBB->member->InsertMember($InsertArr);
      	
      	if (!$MySmartBB->_CONF['info_row']['ajax_register'])
      	{
      		if (!isset($MySmartBB->_POST['ajax']))
      		{
      			$MySmartBB->functions->AddressBar('تنفيذ عملية التسجيل');
      		}
      	}
      	
      	// Ouf finally , but we still have work in this module
      	if ($insert)
      	{
      		$member_num = $MySmartBB->member->GetMemberNumber(array('get_from'	=>	'cache'));
      			
      		$MySmartBB->cache->UpdateLastMember(array(	'username'		=>	$MySmartBB->_POST['username'],
      													'id'			=>	$MySmartBB->member->id,
      													'member_num'	=>	$member_num));
      														
      		if ($MySmartBB->_CONF['info_row']['def_group'] == 5)
      		{
      			$Adress	= 	$MySmartBB->functions->GetForumAdress();
				$Code	=	$MySmartBB->functions->RandomCode();
			
				$ActiveAdress = $Adress . 'index.php?page=active_member&index=1&code=' . $Code;
		
				$ReqArr 			= 	array();
				$ReqArr['field'] 	= 	array();
		
				$ReqArr['field']['random_url'] 		= 	$Code;
				$ReqArr['field']['username'] 		= 	$MySmartBB->_POST['username'];
				$ReqArr['field']['request_type'] 	= 	3;
			
				$InsertReq = $MySmartBB->request->InsertRequest($ReqArr);
			
				if ($InsertReq)
				{
					$MsgArr 			= 	array();
					$MsgArr['where'] 	= 	array('id','4');
				
					$MassegeInfo = $MySmartBB->message->GetMessageInfo($MsgArr);
				
					$MsgArr = array();
				
					$MsgArr['text'] 		= 	$MassegeInfo['text'];
					$MsgArr['active_url'] 	= 	$ActiveAdress;
					$MsgArr['username']		=	$MySmartBB->_CONF['member_row']['username'];
					$MsgArr['title']		=	$MySmartBB->_CONF['info_row']['title'];
				
					$MassegeInfo['text'] = $MySmartBB->message->MessageProccess($MsgArr);
					
					$Send = $MySmartBB->functions->mail($MySmartBB->_CONF['member_row']['email'],$MassegeInfo['title'],$MassegeInfo['text'],$MySmartBB->_CONF['info_row']['send_email']);
					
					if ($Send)
					{
						$MySmartBB->functions->msg('تم التسجيل بنجاح، و تم ارسال بريد التفعيل إلى بريدك الالكتروني');
						
						if (!$MySmartBB->_CONF['info_row']['ajax_register'])
						{
							if (!isset($MySmartBB->_POST['ajax']))
							{
								$MySmartBB->functions->goto('index.php');
							}
						}
					}
				}
			}
			else
      		{
      			$MySmartBB->functions->msg('تم التسجيل بنجاح');
      			
      			if (!$MySmartBB->_CONF['info_row']['ajax_register'])
      			{
      				if (!isset($MySmartBB->_POST['ajax']))
      				{
      					$MySmartBB->functions->goto('index.php?page=login&register_login=1&username=' . $MySmartBB->_POST['username'] . '&password=' . $MySmartBB->_POST['password']);
      				}
      			}
      		}
      	}
	}
}

?>
