<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'IN_ADMIN', true );

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartForumsAddMOD' );
	
class MySmartForumsAddMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_forums_add' );
		    
			$MySmartBB->load( 'section' );
			
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_addMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_addStart();
			}
		}
	}
	
	private function _addMain()
	{
		global $MySmartBB;

		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->order = "id ASC";
		
		$MySmartBB->func->setResource( 'group_res' );
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList( false );
		
		// ... //
		
		$MySmartBB->template->display( 'forum_add' );
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		// ... //
		
 		if ( empty( $MySmartBB->_POST[ 'name' ] ) 
 				or ( $MySmartBB->_POST[ 'order_type' ] == 'manual' and empty( $MySmartBB->_POST[ 'sort' ] ) ) )
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		// ... //
		
		$sort = 0;
		
		if ( $MySmartBB->_POST[ 'order_type' ] == 'auto' )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
			$MySmartBB->rec->filter = "parent='" . (int) $MySmartBB->_POST[ 'parent' ] . "'";
			$MySmartBB->rec->order = "sort DESC";
			
			$section_info = $MySmartBB->rec->getInfo();
			
			$sort = ( !$section_info ) ? 1 : $section_info[ 'sort' ] + 1;
		}
		else
		{
			$sort = $MySmartBB->_POST['sort'];
		}
		
		// ... //
		
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		
		$MySmartBB->rec->fields = array();
		
		$MySmartBB->rec->fields['title'] 					= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['sort'] 					= 	$sort;
		$MySmartBB->rec->fields['section_describe']			=	$MySmartBB->_POST['describe'];
		$MySmartBB->rec->fields['parent']					=	$MySmartBB->_POST['parent'];
		$MySmartBB->rec->fields['show_sig']					=	1;
		$MySmartBB->rec->fields['usesmartcode_allow']		=	1;
		$MySmartBB->rec->fields['subject_order']			=	1;
		$MySmartBB->rec->fields['sectionpicture_type']		=	2;
		
		$MySmartBB->rec->get_id = true;
		
		$insert = $MySmartBB->rec->insert();
		
		// ... //
		
		if ( $insert )
		{
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
			$MySmartBB->rec->order = "id ASC";
			
			$MySmartBB->rec->getList();
			
			while ( $row = $MySmartBB->rec->getInfo() )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
				
				$MySmartBB->rec->fields	=	array();
				
				$MySmartBB->rec->fields['section_id'] 			= 	$MySmartBB->rec->id;
				$MySmartBB->rec->fields['group_id'] 			= 	$row['id'];
				$MySmartBB->rec->fields['view_section'] 		= 	$MySmartBB->_POST['groups'][$row['id']]['view_section'];
				$MySmartBB->rec->fields['download_attach'] 		= 	$row['download_attach'];
				$MySmartBB->rec->fields['write_subject'] 		= 	$MySmartBB->_POST['groups'][$row['id']]['write_subject'];
				$MySmartBB->rec->fields['write_reply'] 			= 	$MySmartBB->_POST['groups'][$row['id']]['write_reply'];
				$MySmartBB->rec->fields['upload_attach'] 		= 	$row['upload_attach'];
				$MySmartBB->rec->fields['edit_own_subject']		= 	$row['edit_own_subject'];
				$MySmartBB->rec->fields['edit_own_reply'] 		= 	$row['edit_own_reply'];
				$MySmartBB->rec->fields['del_own_subject'] 		= 	$row['del_own_subject'];
				$MySmartBB->rec->fields['del_own_reply'] 		= 	$row['del_own_reply'];
				$MySmartBB->rec->fields['write_poll'] 			= 	$row['write_poll'];
				$MySmartBB->rec->fields['no_posts'] 			= 	$row['no_posts'];
				$MySmartBB->rec->fields['vote_poll'] 			= 	$row['vote_poll'];
				$MySmartBB->rec->fields['main_section'] 		= 	0;
				$MySmartBB->rec->fields['group_name'] 			= 	$row['title'];
				
				$MySmartBB->rec->insert();
			}
			
			// ... //
			
			$cache = $MySmartBB->section->updateSectionsCache( $MySmartBB->_POST[ 'parent' ] );
			
			if ( $cache )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
				$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_POST[ 'parent' ] . "'";
				
				$parent_info = $MySmartBB->rec->getInfo();
				
				// The parent is not a category, It's a forum so we have to update the cache of this forum
				// because we want to show the sub-forums of that forum in the index page
				if ( $parent_info[ 'parent' ] != 0 )
					$cache = $MySmartBB->section->updateSectionsCache( $parent_info[ 'parent' ] );
				
				$MySmartBB->func->msg( $MySmartBB->lang[ 'forum_added' ] );
				$MySmartBB->func->move('admin.php?page=forums_edit&amp;main=1&amp;id=' . $MySmartBB->rec->id);
			}
			else
			{
				$MySmartBB->func->error( $MySmartBB->lang[ 'cache_update_failed' ] );
			}
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'add_failed' ] );
		}
	}
}

?>
