<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('STOP_STYLE',true);

include('common.php');

define('CLASS_NAME','MySmartLogoutMOD');

class MySmartLogoutMOD
{
	function run()
	{
		global $MySmartBB;
		
		/** Simply , logout :) **/
		if ($MySmartBB->_GET['index'])
		{
			$this->_StartLogout();
		}
		/** **/
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter();
	}
		
	/**
	 * Delete cookies , and the member from online table then go to last page which the member was in it :)
	 */
	function _StartLogout()
	{
		global $MySmartBB;
		
		$DelArr 						= 	array();
		$DelArr['where'] 				= 	array();
		$DelArr['where'][0] 			= 	array();
		$DelArr['where'][0]['name'] 	= 	'user_id';
		$DelArr['where'][0]['oper'] 	= 	'=';
		$DelArr['where'][0]['value'] 	= 	$MySmartBB->_CONF['member_row']['id'];
		
		$MySmartBB->online->DeleteOnline($DelArr);
		
		$Logout = $MySmartBB->member->Logout();
								
		$MySmartBB->functions->ShowHeader('تسجيل خروج');
		
		if ($Logout)
		{	
			$MySmartBB->template->display('logout_msg');
			
			$url = parse_url($MySmartBB->_SERVER['HTTP_REFERER']);
      		$url = $url['query'];
      		$url = explode('&',$url);
      		$url = $url[0];
      		
     		$Y_url = explode('/',$MySmartBB->_SERVER['HTTP_REFERER']);
      		$X_url = explode('/',$MySmartBB->_SERVER['HTTP_HOST']);
      		
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
	}
}
	
?>
