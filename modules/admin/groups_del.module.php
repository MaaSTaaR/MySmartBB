<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartGroupsDelMOD' );

class MySmartGroupsDelMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_groups_del' );
		    
		    $MySmartBB->load( 'group' );
		    
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_delMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_delStart();
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'Inf' ] = false;
		
		$this->checkID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		$MySmartBB->template->display( 'group_del' );
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$MySmartBB->load( 'section' );
		
		$info = false;
		
		$this->checkID( $info );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "id='" . $info[ 'id' ] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ( $del )
		{
			// Use the default group for the members who belong to the deleted group.
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->fields = array( 'usergroup'	=>	$MySmartBB->_CONF[ 'info_row' ][ 'adef_group' ] );
			$MySmartBB->rec->filter = "usergroup='" . $info[ 'id' ] . "'";
			
			$update = $MySmartBB->rec->update();
			
			if ( $update )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
				$MySmartBB->rec->filter = "group_id='" . $info[ 'id' ] . "'";
			
				$del = $MySmartBB->rec->delete();
			
				if ( $del )
				{
					$cache = $MySmartBB->section->updateAllSectionsCache();
					
					if ( $cache )
					{
						$MySmartBB->func->msg( $MySmartBB->lang[ 'group_deleted' ] );
						$MySmartBB->func->move( 'admin.php?page=groups&amp;control=1&amp;main=1' );
					}
				}
			}
		}
	}
		
	private function checkID( &$GroupInfo )
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$GroupInfo = $MySmartBB->rec->getInfo();
		
		if ( !$GroupInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'group_doesnt_exist' ] );
	}
}

?>
