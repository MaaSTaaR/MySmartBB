<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartForumsGroupsMOD' );
	
class MySmartForumsGroupsMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_forums_groups' );
		    
			$MySmartBB->load( 'group,section' );
			
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'index' ] )
			{
				$this->_groupControlMain();
			}
			if ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_groupControlStart();
			}
		}
	}
	
	private function _groupControlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'Inf' ] = false;
		
		$this->checkID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $MySmartBB->_CONF[ 'template' ][ 'Inf' ][ 'id' ] . "' AND main_section<>'1'";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'groups' ] = array();
		
		while ( $r = $MySmartBB->rec->getInfo() )
			$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'groups' ][] = $r;
		
		$MySmartBB->template->display( 'forums_groups_control_main' );
	}
		
	private function _groupControlStart()
	{
		global $MySmartBB;
		
		$info = false;
		
		$this->checkID( $info );

		$state = array();

		foreach ( $MySmartBB->_POST[ 'groups' ] as $id => $val )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
			
			$MySmartBB->rec->fields		=	array();
			
			$MySmartBB->rec->fields['view_section'] 		= 	$val['view_section'];
			$MySmartBB->rec->fields['download_attach'] 		= 	$val['download_attach'];
			$MySmartBB->rec->fields['write_subject'] 		= 	$val['write_subject'];
			$MySmartBB->rec->fields['write_reply'] 			= 	$val['write_reply'];
			$MySmartBB->rec->fields['upload_attach'] 		= 	$val['upload_attach'];
			$MySmartBB->rec->fields['edit_own_subject'] 	= 	$val['edit_own_subject'];
			$MySmartBB->rec->fields['edit_own_reply'] 		= 	$val['edit_own_reply'];
			$MySmartBB->rec->fields['del_own_subject'] 		= 	$val['del_own_subject'];
			$MySmartBB->rec->fields['del_own_reply'] 		= 	$val['del_own_reply'];
			$MySmartBB->rec->fields['write_poll'] 			= 	$val['write_poll'];
			$MySmartBB->rec->fields['no_posts'] 			= 	$val['no_posts'];
			$MySmartBB->rec->fields['vote_poll'] 			= 	$val['vote_poll'];
			
			$MySmartBB->rec->filter = "group_id='" . $id . "' AND section_id='" . $info[ 'id' ] . "'";
			
			$update = $MySmartBB->rec->update();
			
			$state[] = ( $update ) ? true : false;
		}
		
		if ( !in_array( false, $state ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			
			$cache = $MySmartBB->group->updateSectionGroupCache( $info[ 'id' ] );
			
			if ($cache)
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'cache_update_succeed' ] );
				
				$cache = $MySmartBB->section->updateForumCache( $info[ 'parent' ], $info[ 'id' ] );
				
				if ( $cache )
				{
					$MySmartBB->member->needUpdatesForbiddenForums();
					
					$MySmartBB->func->msg( $MySmartBB->lang[ 'final_step_succeed' ] );
					$MySmartBB->func->move('admin.php?page=forums_groups&amp;index=1&amp;id=' . $info[ 'id' ]);
				}
			}
		}
	}
	
	private function checkID( &$Inf )
	{
		global $MySmartBB;
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		if ( !$Inf )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forum_doesnt_exist' ] );
	}
}

?>
