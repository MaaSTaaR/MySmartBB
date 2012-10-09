<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartActiveMOD');

class MySmartActiveMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'activate_member' );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'activate_membership' ] );
		
		if ( $MySmartBB->_GET[ 'index' ] )
		{
			$this->_index();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
			
		$MySmartBB->func->getFooter();
	}
		
	private function _index()
	{
		global $MySmartBB;
		
		$MySmartBB->func->addressBar( $MySmartBB->lang[ 'activate_membership' ] );
		
		$MySmartBB->plugin->runHooks( 'active_member_start' );
		
		// ... //
		
		if ( empty( $MySmartBB->_GET[ 'code' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_login' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
		$MySmartBB->rec->filter = "random_url='" . $MySmartBB->_GET['code'] . "' AND request_type='3' AND username='" . $MySmartBB->_CONF[ 'member_row' ][ 'username' ] . "'";
		
		$RequestInfo = $MySmartBB->rec->getInfo();
		
		if (!$RequestInfo)
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'request_doesnt_exist' ] );
		
      	// ... //
      	
      	// Get the information of default group to set username style cache
      	
      	$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['info_row']['adef_group'] . "'";
		
		$GroupInfo = $MySmartBB->rec->getInfo();
		
		$style = $GroupInfo['username_style'];
		$username_style_cache = str_replace('[username]',$MySmartBB->_CONF['member_row']['username'],$style);
		
      	// ... //
      	
      	$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'usergroup'	=>	$MySmartBB->_CONF['info_row']['adef_group'],
											'username_style_cache'	=>	$username_style_cache	);
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
		
		$UpdateGroup = $MySmartBB->rec->update();
		
		// ... //
		
		if ( $UpdateGroup )
		{
		    $MySmartBB->plugin->runHooks( 'active_member_success' );
		    
			$MySmartBB->func->msg( $MySmartBB->lang[ 'membership_activated' ] );
			$MySmartBB->func->move( 'index.php' );
		}
	}
}
	
?>
