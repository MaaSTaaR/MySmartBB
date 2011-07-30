<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_func',true);
define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartUserCPReplyMOD');

class MySmartUserCPReplyMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->func->error( 'المعذره .. هذه المنطقه للاعضاء فقط' );
		}
		
		if ( $MySmartBB->_GET[ 'main' ] )
		{
			$this->_replyListMain();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _replyListMain()
	{
		//TODO later ...
	}
}

?>
