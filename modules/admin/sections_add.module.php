<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartSectionAddMOD' );

class MySmartSectionAddMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_sections_add' );
		    
			$MySmartBB->load( 'group' );
			
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_addMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_addStart();
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _addMain()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->order = "id ASC";
		
		$MySmartBB->rec->getList();
		
		// ... //

		$MySmartBB->template->display( 'sections_add' );		
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'name' ] ) 
			or ( $MySmartBB->_POST[ 'order_type' ] == 'manual' and empty( $MySmartBB->_POST[ 'sort' ] ) ) )
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		// ... //
		
		// How to sort this section? automatically or manually?
		$sort = 0;
		
		if ( $MySmartBB->_POST[ 'order_type' ] == 'auto' )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
			$MySmartBB->rec->filter = "parent='0'";
			$MySmartBB->rec->order = "sort DESC";
			
			$SortSection = $MySmartBB->rec->getInfo();
			
			$sort = ( !$SortSection ) ? 1 :  $SortSection[ 'sort' ] + 1;
		}
		else
		{
			$sort = $MySmartBB->_POST[ 'sort' ];
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields[ 'title' ] 		= 	$MySmartBB->_POST[ 'name' ];
		$MySmartBB->rec->fields[ 'sort' ] 		= 	$sort;
		$MySmartBB->rec->fields[ 'parent' ] 	= 	'0';
		
		$MySmartBB->rec->get_id	= true;
		
		$insert = $MySmartBB->rec->insert();
		
		if ( $insert )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
			$MySmartBB->rec->order = "id ASC";
			
			$MySmartBB->rec->getList();
			
			while ( $row = $MySmartBB->rec->getInfo() )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
				
				$MySmartBB->rec->fields		=	array();
				
				$MySmartBB->rec->fields['section_id'] 			= 	$MySmartBB->rec->id;
				$MySmartBB->rec->fields['group_id'] 			= 	$row['id'];
				$MySmartBB->rec->fields['view_section'] 		= 	$MySmartBB->_POST['groups'][$row['id']]['view_section'];
				$MySmartBB->rec->fields['download_attach'] 		= 	$row['download_attach'];
				$MySmartBB->rec->fields['write_subject'] 		= 	$row['write_subject'];
				$MySmartBB->rec->fields['write_reply'] 			= 	$row['write_reply'];
				$MySmartBB->rec->fields['upload_attach'] 		= 	$row['upload_attach'];
				$MySmartBB->rec->fields['edit_own_subject'] 	= 	$row['edit_own_subject'];
				$MySmartBB->rec->fields['edit_own_reply'] 		= 	$row['edit_own_reply'];
				$MySmartBB->rec->fields['del_own_subject'] 		= 	$row['del_own_subject'];
				$MySmartBB->rec->fields['del_own_reply'] 		= 	$row['del_own_reply'];
				$MySmartBB->rec->fields['write_poll'] 			= 	$row['write_poll'];
				$MySmartBB->rec->fields['vote_poll'] 			= 	$row['vote_poll'];
				$MySmartBB->rec->fields['main_section'] 		= 	1;
				$MySmartBB->rec->fields['group_name'] 			= 	$row['title'];
				
				$insert = $MySmartBB->rec->insert();
			}
			
			$cache = $MySmartBB->group->updateSectionGroupCache( $MySmartBB->rec->id );
			
			if ( $cache )
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'section_added' ] );
				$MySmartBB->func->move( 'admin.php?page=sections&amp;control=1&amp;main=1' );
			}
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'add_failed' ] );
		}
	}
}

?>
