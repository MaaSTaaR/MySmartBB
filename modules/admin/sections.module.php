<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartSectionMOD');
	
class MySmartSectionMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_sections' );
		    
			$MySmartBB->template->display('header');
			
			if ( $MySmartBB->_GET[ 'control' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_controlMain();
				}
			}
			elseif ($MySmartBB->_GET['groups'])
			{
			    // TODO : what?
			}
			
			$MySmartBB->template->display('footer');
		}
	}
		
	private function _controlMain()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->order = "sort ASC";
		$MySmartBB->rec->filter = "parent='0'";
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->template->display('sections_main');

		// ... //
	}
}

?>
