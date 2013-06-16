<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartUserCPSettingMOD' );

class MySmartUserCPSettingMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$this->commonProcesses();
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'edit_options' ] );
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'style_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->order = 'style_order ASC';
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'style_res' ];
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display( 'usercp_control_setting' );		
	}
		
	public function start()
	{
		global $MySmartBB;
		
		$this->commonProcesses();
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'update_process' ] );
		$MySmartBB->func->addressBar( '<a href="' . $MySmartBB->_CONF[ 'init_path' ] . 'usercp">' . $MySmartBB->lang[ 'template' ][ 'usercp' ] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $MySmartBB->lang[ 'update_process' ] );
		
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
			$MySmartBB->func->move( 'usercp_control_setting' );
		}		
	}
	
	private function commonProcesses()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'usercp_control_setting' );
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
	}
}
