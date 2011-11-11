<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_func',true);
define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartUserCPSignatureMOD');

class MySmartUserCPSignatureMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'usercp_control_signature' );
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->func->error( $lang[ 'member_zone' ] );
		}
		
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'sig_allow' ] )
		{
			$MySmartBB->func->error( $lang[ 'cant_use_this_feature' ] );
		}
		
		$MySmartBB->load( 'icon,toolbox' );
		
		if ( $MySmartBB->_GET[ 'main' ] )
		{
			$this->_signMain();
		}
		elseif ( $MySmartBB->_GET[ 'start' ] )
		{
			$this->_signChange();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _signMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $lang[ 'compose_signature' ] );
		
		$MySmartBB->func->getEditorTools();
		
		$MySmartBB->_CONF[ 'template' ][ 'Sign' ] = $MySmartBB->smartparse->replace( $MySmartBB->_CONF[ 'member_row' ][ 'user_sig' ] );
		
		$MySmartBB->smartparse->replace_smiles( $MySmartBB->_CONF[ 'template' ][ 'Sign' ] );
		
		$MySmartBB->template->display( 'usercp_control_sign' );
	}
	
	private function _signChange()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->func->showHeader( $lang[ 'update_process' ] );
		
		$MySmartBB->func->addressBar('<a href="index.php?page=usercp&index=1">' . $lang[ 'usercp' ] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $lang[ 'update_process' ] );
		
		// ... //
		
		$MySmartBB->_POST['text'] = trim( $MySmartBB->_POST[ 'text' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'user_sig'	=>	$MySmartBB->_POST[ 'text' ]	);
		$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
				
		// ... //
		
		if ( $update )
		{
			$MySmartBB->func->msg( $lang[ 'update_succeed' ] );
			$MySmartBB->func->move('index.php?page=usercp_control_signature&amp;main=1');
		}
		
		// ... //
	}

}
