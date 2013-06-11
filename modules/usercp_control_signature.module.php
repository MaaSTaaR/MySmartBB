<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_func',true);
define('JAVASCRIPT_SMARTCODE',true);

include( 'common.module.php' );

define('CLASS_NAME','MySmartUserCPSignatureMOD');

class MySmartUserCPSignatureMOD
{	
	public function run()
	{
		global $MySmartBB;
		
		$this->commonProcess();
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'compose_signature' ] );
		
		$MySmartBB->func->getEditorTools();
		
		$MySmartBB->_CONF[ 'template' ][ 'Sign' ] = $MySmartBB->smartparse->replace( $MySmartBB->_CONF[ 'member_row' ][ 'user_sig' ] );
		
		$MySmartBB->smartparse->replace_smiles( $MySmartBB->_CONF[ 'template' ][ 'Sign' ] );
		
		$MySmartBB->template->display( 'usercp_control_sign' );
		
		$MySmartBB->func->getFooter();
	}
	
	public function start()
	{
		global $MySmartBB;
		
		$this->commonProcess();
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'update_process' ] );
		$MySmartBB->func->addressBar('<a href="index.php?page=usercp&index=1">' . $MySmartBB->lang[ 'usercp' ] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $MySmartBB->lang[ 'update_process' ] );
		
		// ... //
		
		$MySmartBB->_POST['text'] = trim( $MySmartBB->_POST[ 'text' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'user_sig'	=>	$MySmartBB->_POST[ 'text' ]	);
		$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
				
		// ... //
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('usercp_control_signature');
		}
		
		$MySmartBB->func->getFooter();
		
		// ... //
	}
	
	private function commonProcess()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'usercp_control_signature' );
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'sig_allow' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_use_this_feature' ] );
		
		$MySmartBB->load( 'icon,toolbox' );
	}
}
