<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartPrivateMassegeMOD' );

class MySmartPrivateMassegeMOD
{
	private function commonProcesses()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'pm_setting' );
		
		// ... //
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		
		if ( !$MySmartBB->_CONF[ 'info_row' ][ 'pm_feature' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'pm_feature_stopped' ] );
		
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'use_pm' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_use_pm' ] );
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'pm_setting' ] );		
	}
			
	public function run()
	{
		global $MySmartBB;
		
		$this->commonProcesses();
		
		$MySmartBB->plugin->runHooks( 'pm_setting_main' );
		
		$MySmartBB->template->display( 'pm_setting' );
		
		$MySmartBB->func->getFooter();
	}
	
	public function start()
	{
		global $MySmartBB;
		
		$this->commonProcesses();
		
		if ( $MySmartBB->_POST[ 'autoreply' ] and ( empty( $MySmartBB->_POST[ 'title' ] ) or empty( $MySmartBB->_POST[ 'msg' ] ) ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'pm_setting_action_start' );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'autoreply'			=>	$MySmartBB->_POST[ 'autoreply' ],
											'autoreply_title'	=>	$MySmartBB->_POST[ 'title' ],
											'autoreply_msg'		=>	$MySmartBB->_POST[ 'msg' ],
											'pm_senders'		=>	$MySmartBB->_POST[ 'pm_senders' ],
											'pm_senders_msg'	=>	$MySmartBB->_POST[ 'pm_senders_msg' ]	);
											
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
		    $MySmartBB->plugin->runHooks( 'pm_setting_action_success' );
		    
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move( 'pm_setting' );
		}
		
		$MySmartBB->func->getFooter();
	}
}

?>
