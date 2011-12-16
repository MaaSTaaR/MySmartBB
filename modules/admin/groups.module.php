<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartGroupsMOD');

class MySmartGroupsMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
		    $MySmartBB->loadLanguage( 'admin_groups' );
		    
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['control'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_controlMain();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
		
	private function _controlMain()
	{
		global $MySmartBB;

		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->order = "id ASC";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->rec->setInfoCallback( 'MySmartGroupsMOD::rowProcess' );
		
		// ... //
		
		$MySmartBB->template->display('groups_main');
		
		$MySmartBB->rec->removeInfoCallback();
	}
	
	public function rowProcess( $row )
	{
		global $MySmartBB;
		
		$style = $MySmartBB->func->cleanVariable( $row[ 'username_style' ], 'unhtml' );
		
		$row[ 'h_title' ] = str_replace( '[username]', $row[ 'title' ], $style );
	}
}

?>
