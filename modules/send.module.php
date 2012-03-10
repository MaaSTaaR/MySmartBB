<?php

// TODO : Audit this file

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartSendMOD');

class MySmartSendMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'send' );
		
		if ($MySmartBB->_GET['member'])
		{
			if ($MySmartBB->_GET['index'])
			{
				$this->_memberSendIndex();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_memberSendStart();
			}
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _memberSendIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'send_email' ] );
		
		if (!$MySmartBB->_CONF['member_permission'])
     	{
     		$MySmartBB->func->error( $MySmartBB->lang[ 'no_permission_for_visitors' ] );
     	}
     	
     	$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
     	
     	if (empty($MySmartBB->_GET['id']))
     	{
     		$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
     	}
     	
     	// ... //
     	
     	$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$MySmartBB->_CONF['template']['MemberInfo'] = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if (!$MySmartBB->_CONF['template']['MemberInfo'])
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_doesnt_exist' ] );
		} 
		
		// ... //
		
		$MySmartBB->template->display('send_email');
	}
	
	private function _memberSendStart()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'send_email' ] );
		
		if (!$MySmartBB->_CONF['member_permission'])
     	{
     		$MySmartBB->func->error( $MySmartBB->lang[ 'no_permission_for_visitors' ] );
     	}
     	
     	$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
     	
     	if (empty($MySmartBB->_GET['id']))
     	{
     		$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
     	}
     	
     	// ... //
     	
     	$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$MemberInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if (!$MemberInfo)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_doesnt_exist' ] );
		}
		
		// ... //
		
		if (empty($MySmartBB->_POST['title'])
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		$send = $MySmartBB->func->mail(	$MemberInfo['email'],
										$MySmartBB->_POST['title'],
										$MySmartBB->_POST['text'],
										$MySmartBB->_CONF['member_row']['email'] );
		
		if ($send)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'send_succeed' ] );
			$MySmartBB->func->move('index.php');
		}
		else
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'send_failed' ] );
		}
	}
}

?>
