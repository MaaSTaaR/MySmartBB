<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_func',true);
define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartUserCPInfoMOD');

class MySmartUserCPInfoMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'usercp_control_info' );
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		
		if ( $MySmartBB->_GET[ 'main' ] )
		{
			$this->_infoMain();
		}
		elseif ( $MySmartBB->_GET[ 'start' ] )
		{
			$this->_infoChange();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _infoMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'edit_information' ] );
		
		$MySmartBB->plugin->runHooks( 'usercp_control_info_main' );
		
		$MySmartBB->template->display( 'usercp_control_info' );
	}
	
	private function _infoChange()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'update_process' ] );
		$MySmartBB->func->addressBar('<a href="index.php?page=usercp&index=1">' . $MySmartBB->lang[ 'template' ][ 'usercp' ] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $MySmartBB->lang[ 'update_process' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'usercp_control_info_start' );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'user_country'	=>	$MySmartBB->_POST['country'],
											'user_website'	=>	$MySmartBB->_POST['website'],
											'user_info'	=>	$MySmartBB->_POST['info'],
											'away'	=>	$MySmartBB->_POST['away'],
											'away_msg'	=>	$MySmartBB->_POST['away_msg']	);
		
		$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
		    $MySmartBB->plugin->runHooks( 'usercp_control_info_update_success' );
		    
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('index.php?page=usercp_control_info&amp;main=1');
		}
	}
}
