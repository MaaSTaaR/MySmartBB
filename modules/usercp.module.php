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
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->func->error( 'المعذره .. هذه المنطقه للاعضاء فقط' );
		}
		
		if ( isset( $MySmartBB->_GET[ 'index' ] ) )
		{
			$this->_index();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _index()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('لوحة تحكم العضو');
		
		// ... //
		
		$MySmartBB->_CONF['template']['res']['reply_res'] = '';
		
		$MySmartBB->rec->table		=	$MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter 	= 	"writer='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		$MySmartBB->rec->order 		= 	'id DESC';
		$MySmartBB->rec->limit 		= 	'5';
		$MySmartBB->rec->result 	= 	&$MySmartBB->_CONF['template']['res']['last_subjects_res'];
		
		$MySmartBB->rec->getList();
		
		// ... //
		
      	$MySmartBB->template->display('usercp_index');
	}
}

?>
