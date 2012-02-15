<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

class MySmartCommon
{
	var $CheckMember; // TODO : for what?
	
	public function run()
	{
		global $MySmartBB;
		
		$this->_checkMember();
		$this->_commonCode();
		
		if (!$MySmartBB->_CONF['member_permission'])
		{
			if ( !defined( 'STOP_STYLE' ) or STOP_STYLE != true )
			{
				$this->_showLoginForm();
			}
		}
	}
		
	private function _checkMember()
	{
		global $MySmartBB;
		
		$username = $MySmartBB->_COOKIE[ $MySmartBB->_CONF[ 'admin_username_cookie' ] ];
		$password = $MySmartBB->_COOKIE[ $MySmartBB->_CONF[ 'admin_password_cookie' ] ];
		
		$MySmartBB->_CONF['member_permission'] = false;
		
		if (!empty($username) 
			and !empty($password))
		{
			$CheckMember = $MySmartBB->member->checkAdmin( $username, $password );
			
			if ($CheckMember != false)
			{
				$MySmartBB->_CONF['member_row'] = $CheckMember;
				$MySmartBB->_CONF['member_permission'] 	= 	true;
			}
			else
			{
				$MySmartBB->_CONF['member_permission'] = false;
			}
		}
		else
		{
			$MySmartBB->_CONF['member_permission'] = false;
		}
	}
	
	private function _commonCode()
	{
		global $MySmartBB;
				
		/* ... */
		
		// Set information for template engine
		$MySmartBB->template->setInformation(	'modules/admin/styles/main/templates/',
												'modules/admin/styles/main/compiler/',
												'.tpl',
												'file');
		
		/* ... */
		
		// We will use this in options page
		$MySmartBB->template->assign('_CONF',$MySmartBB->_CONF);
		
		/* ... */
	}
	
	private function _showLoginForm()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('header');
		$MySmartBB->template->display('login');
		$MySmartBB->template->display('footer');
	}
}
	
?>
