<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPrivateMassegeMOD');

class MySmartPrivateMassegeMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'pm_setting' );
		
		// ... //
		
		if (!$MySmartBB->_CONF['info_row']['pm_feature'])
			$MySmartBB->func->error( $MySmartBB->lang[ 'pm_feature_stopped' ] );
		
		if (!$MySmartBB->_CONF['group_info']['use_pm'])
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_use_pm' ] );

		if (!$MySmartBB->_CONF['member_permission'])
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		
		// ... //
				
		if ($MySmartBB->_GET['setting'])
		{
			if ($MySmartBB->_GET['index'])
			{
				$this->_settingIndex();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_settingStart();
			}
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->MySmartBB->lang_common[ 'wrong_path' ] );
		}
					
		$MySmartBB->func->getFooter();
	}
			
	private function _settingIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'pm_setting' ] );
		
		$MySmartBB->plugin->runHooks( 'pm_setting_main' );
		
		$MySmartBB->template->display('pm_setting');
	}
	
	private function _settingStart()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'pm_setting' ] );
		
		// ... //
		
		if ( $MySmartBB->_POST['autoreply'] and ( !isset( $MySmartBB->_POST['title'] ) or !isset( $MySmartBB->_POST['msg'] ) ) )
			$MySmartBB->func->error( $MySmartBB->MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'pm_setting_action_start' );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'autoreply'	=>	$MySmartBB->_POST['autoreply'],
											'autoreply_title'	=>	$MySmartBB->_POST['title'],
											'autoreply_msg'	=>	$MySmartBB->_POST['msg'],
											'pm_senders'	=>	$MySmartBB->_POST['pm_senders'],
											'pm_senders_msg'	=>		$MySmartBB->_POST['pm_senders_msg']	);
											
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
		    $MySmartBB->plugin->runHooks( 'pm_setting_action_success' );
		    
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('index.php?page=pm_setting&amp;setting=1&amp;index=1');
		}
	}
}

?>
