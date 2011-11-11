<?php

// TODO : Audit this file

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPasswordMOD');

class MySmartPasswordMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'new_password' );
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_index();
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
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'change_password_process' ] );
		
		$MySmartBB->func->addressBar( $MySmartBB->lang[ 'change_password_process' ] );
		
		if (empty($MySmartBB->_GET['code']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'please_login' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
		$MySmartBB->rec->filter = "random_url='" . $MySmartBB->_GET['code'] . "' AND request_type='1' AND username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		
		$RequestInfo = $MySmartBB->rec->getInfo();
		
		if (!$RequestInfo)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'request_doesnt_exist' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'password'	=>	md5($MySmartBB->_CONF['member_row']['new_password']) );
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
		
		$UpdatePassword = $MySmartBB->rec->update();
		
		$MySmartBB->member->cleanNewPassword( $MySmartBB->_CONF['member_row']['id'] );
		
		if ($UpdatePassword)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->goto('index.php');
		}
	}
}
	
?>
