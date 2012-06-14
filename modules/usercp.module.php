<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_func',true);
define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartUserCPMOD');

class MySmartUserCPMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'usercp_main' );
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		}
		
		if ( isset( $MySmartBB->_GET[ 'index' ] ) )
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
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'usercp' ] );
		
		// ... //
		
		$MySmartBB->_CONF['template']['res']['last_subjects_res'] = '';
		
		$MySmartBB->rec->table		=	$MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter 	= 	"writer='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		$MySmartBB->rec->order 		= 	'id DESC';
		$MySmartBB->rec->limit 		= 	'5';
		$MySmartBB->rec->result 	= 	&$MySmartBB->_CONF['template']['res']['last_subjects_res'];
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'usercp_main_start' );
		
		// ... //
		
      	$MySmartBB->template->display('usercp_index');
	}
}

?>
