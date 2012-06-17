<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('FOOTER_NAME','MySmartFooterMOD');

class MySmartFooterMOD
{
	public function run()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->filter = "style_on='1'";
		$MySmartBB->rec->order = 'style_order ASC';
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'style_res' ];
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->template->display( 'footer' );
	}
}

?>
