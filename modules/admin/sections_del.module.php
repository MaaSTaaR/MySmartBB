<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );
	
class MySmartSectionEditMOD
{
	private $Inf = null;
	
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_sections_del' );
		    
			$MySmartBB->load( 'group,subject,section' );
			
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
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'Inf' ] = null;
		
		$this->checkID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'sec_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->order = "sort ASC";
		$MySmartBB->rec->filter = "parent='0' AND id<>'" . $MySmartBB->_CONF[ 'template' ][ 'Inf' ][ 'id' ] . "'";
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'sec_res' ];
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'forum_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->order = "sort ASC";
		$MySmartBB->rec->filter = "parent<>'0' AND parent<>'" . $MySmartBB->_CONF[ 'template' ][ 'Inf' ][ 'id' ] . "'";
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'forum_res' ];

		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->template->display( 'section_del' );
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		// ... //
		
		$this->checkID( $this->Inf );
		
		// ... //
				
		if ( $MySmartBB->_POST[ 'choose' ] == 'move' )
		{
			$this->__moveForums();
		}
		elseif ( $MySmartBB->_POST[ 'choose' ] == 'del' )
		{
			$this->__deleteForums();
		}
		elseif ( $MySmartBB->_POST[ 'choose' ] == 'move_subjects' )
		{
			$this->__moveTopics();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'wrong_choice' ] );
		}
	}
	
	private function __moveForums()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'to' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_complete_the_process' ] );
		
		// ... //
		
		// Move forums to another parent
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->fields	= array( 'parent' => $MySmartBB->_POST[ 'to' ] );
		$MySmartBB->rec->filter = "parent='" . $this->Inf[ 'id' ] . "'";

		$update = $MySmartBB->rec->update();
		
		// ... //
		
		// Update the children's cache of the new parent.
		// So the new children will be shown on the main page.
		$MySmartBB->section->updateSectionsCache( $MySmartBB->_POST[ 'to' ] );

		// ... //

		if ( $update )
		{
			// Delete the parent.
			if ( $this->__deleteSection( $this->Inf[ 'id' ] ) )
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'section_delete_succeed' ] );
				
				// Delete group's permissions of the parent.
				if ( $this->__deletePermissions( $this->Inf[ 'id' ] ) )
				{
					$MySmartBB->func->msg( $MySmartBB->lang[ 'groups_delete_succeed' ] );
					$MySmartBB->func->move( 'admin.php?page=sections&amp;control=1&amp;main=1' );
				}
			}
		}
	}
	
	private function __deleteForums()
	{
		global $MySmartBB;
		
		// ... //
		
		// Get the ids of all children to delete their permissions, topics and replies.
		
		$MySmartBB->rec->select = 'id';
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "parent='" . $this->Inf[ 'id' ] . "'";
		$MySmartBB->rec->order = "sort ASC";

		$MySmartBB->rec->getList();
		
		// ... //
		
		// Construct the SQL filters to use them in the deletion of topics, replies and permissions.
		
		$k = 0;
		
		$permissions_filter = '';
		$topics_filter = '';
		
		while ( $row = $MySmartBB->rec->getInfo() )
		{
			if ( $k > 0 )
			{
				$permissions_filter .= 'OR ';
				$topics_filter .= 'OR ';
			}
			
			$permissions_filter .= "section_id='" . $row[ 'id' ] . "' ";
			$topics_filter .= "section='" . $row[ 'id' ] . "' ";
			
			$k++;
		}
		
		// ... //
		
		// Delete permissions, topics and replies of the children forums after constructed our filter.
		
		// TODO : what about attachments, polls, tags and the total number of topics/replies
		
		if ( !empty( $permissions_filter ) )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
			$MySmartBB->rec->filter = $permissions_filter;
	
			$del_permissions = $MySmartBB->rec->delete();
		}
		
		if ( !empty( $topics_filter ) )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
			$MySmartBB->rec->filter = $topics_filter;
	
			$del_topics = $MySmartBB->rec->delete();
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
			$MySmartBB->rec->filter = $topics_filter;
	
			$del_replies = $MySmartBB->rec->delete();
		}
		
		if ( $del_permissions and $del_topics and $del_replies )
			$MySmartBB->func->msg( $MySmartBB->lang[ 'forums_groups_delete_succeed' ] );
		else
			$MySmartBB->func->msg( $MySmartBB->lang[ 'groups_topics_delete_failed' ] );
		
		// ... //

		if ( $this->__deleteChildForums( $this->Inf[ 'id' ] ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'forums_delete_succeed' ] );
			
			if ( $this->__deleteSection( $this->Inf[ 'id' ] ) )
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'section_delete_succeed' ] );
				
				if ( $this->__deletePermissions( $this->Inf[ 'id' ] ) )
				{
					$MySmartBB->func->msg( $MySmartBB->lang[ 'groups_delete_succeed' ] );
					$MySmartBB->func->msg( $MySmartBB->lang[ 'final_step_succeed' ] );
					$MySmartBB->func->move('admin.php?page=sections&amp;control=1&amp;main=1');
				}
			}
		}
	}
	
	private function __moveTopics()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "parent='" . $this->Inf[ 'id' ] . "'";
		$MySmartBB->rec->order = "sort ASC";
		
		$forums_res = &$MySmartBB->func->setResource();
		
		$MySmartBB->rec->getList();
		
		$x = 0;
		$state = array();
		$permissions_filter = '';
		
		while ( $row = $MySmartBB->rec->getInfo( $forums_res ) )
		{
			// ... //
			
			if ( $x > 0 )
				$permissions_filter .= 'OR ';
			
			$permissions_filter .= "section_id='" . $row[ 'id' ] . "' ";
			
			// ... //
			
			$move = $MySmartBB->subject->massMoveSubject( $MySmartBB->_POST['subject_to'], $row['id'], false );
	
			$state[] = ( $move ) ? true : false;
	
			$x++;
		}
		
		if ( !empty( $permissions_filter ) )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
			$MySmartBB->rec->filter = $permissions_filter;
	
			$state[] = $MySmartBB->rec->delete() ? true : false;
		}
		
		// ... //
		
		if ( in_array( false, $state ) )
			$MySmartBB->func->msg( $MySmartBB->lang[ 'sections_groups_delete_failed' ] );
		else
			$MySmartBB->func->msg( $MySmartBB->lang[ 'forums_groups_delete_succeed' ] );
		
		// ... //
		
		if ( $this->__deleteChildForums( $this->Inf[ 'id' ] ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'forums_delete_succeed' ] );
			
			if ( $this->__deleteSection( $this->Inf[ 'id' ] ) )
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'section_delete_succeed' ] );

				if ( $this->__deletePermissions( $this->Inf[ 'id' ] ) )
				{
					$MySmartBB->func->msg( $MySmartBB->lang[ 'groups_delete_succeed' ] );
					$MySmartBB->func->msg( $MySmartBB->lang[ 'final_step_succeed' ] );
					$MySmartBB->func->move('admin.php?page=sections&amp;control=1&amp;main=1');
				}
			}
		}
	}
	
	private function __deleteSection( $id )
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $id . "'";
	
		$del = $MySmartBB->rec->delete();
		
		return ( $del ) ? true : false;
	}
	
	private function __deletePermissions( $id )
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->Inf['id'] . "' AND main_section='1'";
	
		$del = $MySmartBB->rec->delete();
		
		return ( $del ) ? true : false;
	}
	
	private function __deleteChildForums( $parent )
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "parent='" . $parent . "'";

		$del = $MySmartBB->rec->delete();
		
		return ( $del ) ? true : false;
	}
	
	private function checkID( &$Inf )
	{
		global $MySmartBB;

		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$Inf )
			$MySmartBB->func->error( $MySmartBB->lang[ 'section_doesnt_exist' ] );		
	}
}

?>
