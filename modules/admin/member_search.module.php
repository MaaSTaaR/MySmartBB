<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartMemberSearchMOD');
	
class MySmartMemberSearchMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_member_search' );
		    
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_searchMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_searchStart();
			}
				
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _searchMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('member_search_main');
	}
	
	private function _searchStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['keyword']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		if ($MySmartBB->_POST['search_by'] == 'username')
		{
			$field = 'username';
		}
		elseif ($MySmartBB->_POST['search_by'] == 'email')
		{
			$field = 'email';
		}
		else
		{
			$field = 'id';
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = $field . "='" . $MySmartBB->_POST['keyword'] . "'";
		
		$MySmartBB->_CONF['template']['MemInfo'] = $MySmartBB->rec->getInfo();
		
		if ($MySmartBB->_CONF['template']['MemInfo'] == false)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_result' ] );
		}
				
		$MySmartBB->template->display('member_search_result');
	}
}

?>
