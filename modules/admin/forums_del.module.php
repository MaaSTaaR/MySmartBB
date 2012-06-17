<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'IN_ADMIN', true );

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartForumsDeleteMOD' );
	
class MySmartForumsDeleteMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_forums_del' );
		    
			$MySmartBB->load( 'section,subject' );
			
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_delMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_delStart();
			}
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->checkID( $MySmartBB->_CONF['template']['Inf'] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		
		$MySmartBB->rec->order = "sort ASC";
		$MySmartBB->rec->filter = "parent<>'0' AND id<>'" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('forum_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->checkID( $MySmartBB->_CONF['template']['Inf'] );
		
		if ( $MySmartBB->_POST['choose'] != 'move' and $MySmartBB->_POST['choose'] != 'del' )
			$MySmartBB->func->error( $MySmartBB->lang[ 'wrong_choice' ] );
		
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
			
		$del = $MySmartBB->rec->delete();
		
		if ( $del )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'delete_succeed' ] );
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
			$MySmartBB->rec->filter = "section_id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
							
			$del_group = $MySmartBB->rec->delete();
			
			if ( $del_group )
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'section_group_delete_succeed' ] );
				
				if ( $MySmartBB->_POST['choose'] == 'move' )
				{
					$move = $MySmartBB->subject->massMoveSubject( (int) $MySmartBB->_POST['to'], $MySmartBB->_CONF['template']['Inf']['id'], false );
					
					if ( $move )
					{
						$MySmartBB->func->msg( $MySmartBB->lang[ 'topics_moved' ] );
					}
				}
				elseif ( $MySmartBB->_POST[ 'choose' ] == 'del' )
				{
					$del = $MySmartBB->subject->massDeleteSubject( $MySmartBB->_CONF['template']['Inf']['id'], false );
					
					if ( $del )
					{
						$MySmartBB->func->msg( $MySmartBB->lang[ 'topics_delete_succeed' ] );
					}
				}
			}
			
			// After delete the forum we should update the cache of the parent
			// to show the forums correctly on the main page.
			$cache = $MySmartBB->section->updateSectionsCache( $MySmartBB->_CONF['template']['Inf']['parent'] );
			
			if ( $cache )
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
				$MySmartBB->func->move('admin.php?page=forums&amp;control=1&amp;main=1');
			}
		}
	}
	
	private function checkID( &$Inf )
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		if ($Inf == false)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'forum_doesnt_exit' ] );
		}		
	}
}

?>
