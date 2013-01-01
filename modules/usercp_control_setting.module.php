<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'JAVASCRIPT_func', true );
define( 'JAVASCRIPT_SMARTCODE', true );

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartUserCPSettingMOD' );

class MySmartUserCPSettingMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'usercp_control_setting' );
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		
		if ( $MySmartBB->_GET[ 'main' ] )				
		{
			$this->_settingMain();
		}
		elseif ( $MySmartBB->_GET[ 'start' ] )
		{
			$this->_settingChange();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _settingMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'edit_options' ] );
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'style_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->order = 'style_order ASC';
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'style_res' ];
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display( 'usercp_control_setting' );
	}
		
	private function _settingChange()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'update_process' ] );
		$MySmartBB->func->addressBar( '<a href="index.php?page=usercp&index=1">' . $MySmartBB->lang[ 'template' ][ 'usercp' ] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $MySmartBB->lang[ 'update_process' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'style'			=>	$MySmartBB->_POST[ 'style' ],
											'hide_online'	=>	$MySmartBB->_POST[ 'hide_online' ],
											'user_time'		=>	$MySmartBB->_POST[ 'user_time' ],
											'send_allow'	=>	$MySmartBB->_POST[ 'send_allow' ]	);
		
		$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move( 'index.php?page=usercp_control_setting&amp;main=1' );
		}
	}
}
