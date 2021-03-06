<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartActiveMOD' );

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
		$MySmartBB->rec->filter = "random_url='" . $MySmartBB->_GET[ 'code' ] . "' AND request_type='3' AND username='" . $MySmartBB->_CONF[ 'member_row' ][ 'username' ] . "'";
		
		$RequestInfo = $MySmartBB->rec->getInfo();
		
		if ( !$RequestInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'request_doesnt_exist' ] );
		
      	// ... //
      	
      	// Get the information of default group to set username style cache
      	
      	$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'info_row' ][ 'adef_group' ] . "'";
		
		$GroupInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		$username_style_cache = $MySmartBB->member->getUsernameWithStyle( $MySmartBB->_CONF[ 'member_row' ][ 'username' ], $GroupInfo[ 'username_style' ] );
      	
		// ... //
      	
      	$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'usergroup'	=>	$GroupInfo[ 'id' ],
											'username_style_cache'	=>	$username_style_cache,
											'user_title'	=>	$GroupInfo[ 'user_title' ]	);
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$UpdateGroup = $MySmartBB->rec->update();
		
		// ... //
		
		if ( $UpdateGroup )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
			$MySmartBB->rec->filter = "id='" . $RequestInfo[ 'id' ] . "'";
			
			$del = $MySmartBB->rec->delete();
			
			if ( $del )
			{
			    $MySmartBB->plugin->runHooks( 'active_member_success' );
			    
				$MySmartBB->func->msg( $MySmartBB->lang[ 'membership_activated' ] );
				$MySmartBB->func->move( 'index.php' );
			}
		}
	}
}
	
?>
