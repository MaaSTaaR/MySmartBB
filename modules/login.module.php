<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('STOP_STYLE',true);
define('LOGIN',true);

include('common.php');

define('CLASS_NAME','MySmartLoginMOD');

class MySmartLoginMOD
{
	function run()
	{
		global $MySmartBB;
		
		/** Normal login **/
		if ($MySmartBB->_GET['login'])
		{
			$this->_StartLogin();
		}
		/** **/
		
		/** Login after register **/
		elseif ($MySmartBB->_GET['register_login'])
		{
			$this->_StartLogin(true);
		}
		/** **/
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	/**
	 * Check if the username , password is true , then give the permisson .
	 * otherwise don't give the permisson
	 *
	 * @param :
	 *			register_login	-> 
	 *								true : to use this function to login after register
	 *								false : to use this function to normal login
	 */
	function _StartLogin($register_login=false)
	{
		global $MySmartBB;
		
		if (!$register_login)
		{
			$username = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['username'],'trim');
			$password = $MySmartBB->functions->CleanVariable(md5($MySmartBB->_POST['password']),'trim');
		}
		else
		{
			$username = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['username'],'trim');
			$password = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['password'],'trim');
		}
		
		$expire = ($MySmartBB->_POST['temporary'] == 'on') ? 0 : time() + 31536000;
		
		$IsMember = $MySmartBB->member->LoginMember(array(	'username'	=>	$username,
															'password'	=>	$password,
															'expire'	=>	$expire));
		
		$MySmartBB->functions->ShowHeader('تسجيل دخول');
		
		if ($IsMember != false)
		{
			//////////
			
			$username = $MySmartBB->functions->CleanVariable($username,'html');
			
			$MySmartBB->template->assign('username',$username);
			
			$MySmartBB->template->display('login_msg');
			
			//////////
			
			if ($IsMember['style'] != $IsMember['style_id_cache'])
			{
				$style_cache = $MySmartBB->style->CreateStyleCache(array('where'=>array('id',$IsMember['style'])));
			
				$UpdateArr						=	array();
				$UpdateArr['field']				=	array();
				
				$UpdateArr['field']['style_cache'] 		= 	$style_cache;
				$UpdateArr['field']['style_id_cache']	=	$IsMember['style'];
				$UpdateArr['where']						=	array('id',$IsMember['id']);
			
				$update_cache = $MySmartBB->member->UpdateMember($UpdateArr);
			}
			
			//////////
			
			$DelArr 						= 	array();
			$DelArr['where'] 				= 	array();
			$DelArr['where'][0] 			= 	array();
			$DelArr['where'][0]['name'] 	= 	'user_ip';
			$DelArr['where'][0]['oper'] 	= 	'=';
			$DelArr['where'][0]['value'] 	= 	$MySmartBB->_CONF['ip'];
			
			$MySmartBB->online->DeleteOnline($DelArr);
			
			//////////
			
			$url = parse_url($MySmartBB->_SERVER['HTTP_REFERER']);
      		$url = $url['query'];
      		$url = explode('&',$url);
      		$url = $url[0];

     		$Y_url = explode('/',$MySmartBB->_SERVER['HTTP_REFERER']);
      		$X_url = explode('/',$MySmartBB->_SERVER['HTTP_HOST']);
      		
      		//////////
      		
      		if (!$register_login)
      		{
      			if ($url != 'page=logout' 
      				or empty($url) 
      				or $url != 'page=login')
           		{
       				$MySmartBB->functions->goto($MySmartBB->_SERVER['HTTP_REFERER']);
      			}

      			elseif ($Y_url[2] != $X_url[0] 
      					or $url == 'page=logout' 
      					or $url == 'page=login')
           		{
       				$MySmartBB->functions->goto('index.php');
      			}
      		}
      		else
      		{
      			$MySmartBB->functions->goto('index.php');
      		}
		}
		else
		{
			$MySmartBB->functions->msg('كلمة المرور او اسم المستخدم غير صحيحين');
		}
	}
}

?>
