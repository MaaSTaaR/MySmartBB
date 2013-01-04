<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'IN_ADMIN', true );

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartForumsEditMOD' );
	
class MySmartForumsEditMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_forums_edit' );
		    
			$MySmartBB->load( 'section' );
			
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_editMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_editStart();
			}
		}
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->checkID( $MySmartBB->_CONF['template']['Inf'] );
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList( false );
		
		// ... //
		
		$MySmartBB->template->display('forum_edit');
	}
	
	public function _editStart()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'name' ] ) or empty( $MySmartBB->_POST[ 'sort' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$info = false;
		
		$this->checkID( $info );
		
		// ... //
		
		// Check if the user changed the parent or not
		$new_parent_flag 	= 	false;
		$old_parent			=	0;
		
		if ( $info[ 'parent' ] != $MySmartBB->_POST[ 'parent' ] )
		{
			$new_parent_flag	= 	true;
			$old_parent			=	$info[ 'parent' ];
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 					= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['sort'] 					= 	$MySmartBB->_POST['sort'];
		$MySmartBB->rec->fields['section_describe']			=	$MySmartBB->_POST['describe'];
		$MySmartBB->rec->fields['section_password']			=	$MySmartBB->_POST['section_password'];
		$MySmartBB->rec->fields['show_sig']					=	$MySmartBB->_POST['show_sig'];
		$MySmartBB->rec->fields['usesmartcode_allow']		=	$MySmartBB->_POST['usesmartcode_allow'];
		$MySmartBB->rec->fields['section_picture']			=	$MySmartBB->_POST['section_picture'];
		$MySmartBB->rec->fields['sectionpicture_type']		=	$MySmartBB->_POST['sectionpicture_type'];
		$MySmartBB->rec->fields['use_section_picture']		=	$MySmartBB->_POST['use_section_picture'];
		$MySmartBB->rec->fields['linksection']				=	$MySmartBB->_POST['linksection'];
		$MySmartBB->rec->fields['linksite']					=	$MySmartBB->_POST['linksite'];
		$MySmartBB->rec->fields['subject_order']			=	$MySmartBB->_POST['subject_order'];
		$MySmartBB->rec->fields['hide_subject']				=	$MySmartBB->_POST['hide_subject'];
		$MySmartBB->rec->fields['sec_section']				=	$MySmartBB->_POST['sec_section'];
		$MySmartBB->rec->fields['parent']					=	$MySmartBB->_POST['parent'];

		$MySmartBB->rec->filter = "id='" . $info['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
			// There is a new main section, because of that we should update the
			// cache of the old parent to remove this child from the
			// list of the old parent and also we shoukd update the cache
			// of the new parent to add this child to the list.
			if ( $new_parent_flag )
			{
				$cache = $MySmartBB->section->updateSectionsCache( $old_parent );
				
				if ( $cache )
				{
					$cache = $MySmartBB->section->updateSectionsCache( $MySmartBB->_POST[ 'parent' ] );
				}
			}
			else
			{
				$cache = $MySmartBB->section->updateForumCache( $MySmartBB->_POST[ 'parent' ], $info['id'] );
			}
			
			if ($cache)
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'forum_updated' ] );
				$MySmartBB->func->move('admin.php?page=forums_edit&amp;main=1&amp;id=' . $info['id']);
			}
			else
			{
				$MySmartBB->func->error( $MySmartBB->lang[ 'update_failed' ] );
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
