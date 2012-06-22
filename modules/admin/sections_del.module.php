<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartSectionEditMOD');
	
class MySmartSectionEditMOD
{
	private $Inf;
	
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
		
		$this->checkID($MySmartBB->_CONF['template']['Inf']);
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'sec_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->order = "sort ASC";
		$MySmartBB->rec->filter = "parent='0' AND id<>'" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'sec_res' ];
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'forum_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->order = "sort ASC";
		$MySmartBB->rec->filter = "parent<>'0' AND id<>'" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'forum_res' ];

		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->template->display('section_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		// ... //
		
		$this->checkID( $this->Inf );
		
		// ... //
				
		if ($MySmartBB->_POST['choose'] == 'move')
		{
			$this->__moveForums();
		}
		elseif ($MySmartBB->_POST['choose'] == 'del')
		{
			$this->__deleteForums();
		}
		elseif ($MySmartBB->_POST['choose'] == 'move_subjects')
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
		
		// ... //
		
		if ( empty( $MySmartBB->_POST['to'] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_complete_the_process' ] );
		
		// ... //
		
		// Move normal sections to another main section
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->fields	= array( 'parent' => $MySmartBB->_POST['to'] );
		$MySmartBB->rec->filter = "parent='" . $this->Inf[ 'id' ] . "'";

		$update = $MySmartBB->rec->update();
		
		// ... //
		
		$MySmartBB->section->updateSectionsCache( $MySmartBB->_POST[ 'to' ] );

		// ... //

		if ( $update )
		{
			// ... //
	
			$del = $this->__deleteSection( $this->Inf['id'] );
			
			if ($del)
			{
				// ... //
		
				$MySmartBB->func->msg( $MySmartBB->lang[ 'section_delete_succeed' ] );
		
				// ... //
				
				$del = $this->__deletePermissions( $this->Inf['id'] );
		
				// ... //
		
				if ($del)
				{
					$MySmartBB->func->msg( $MySmartBB->lang[ 'groups_delete_succeed' ] );
					$MySmartBB->func->move('admin.php?page=sections&amp;control=1&amp;main=1');
				}
		
				// ... //
			}
		}
	}
	
	private function __deleteForums()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->rec->select = 'id';
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "parent='" . $this->Inf['id'] . "'";
		$MySmartBB->rec->order = "sort ASC";

		$MySmartBB->rec->getList();
		
		// ... //
		
		// Delete permissions, topics and replies of the child forums
		
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
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'forums_groups_delete_succeed' ] );
		}
		else
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'groups_topics_delete_failed' ] );
		}
		
		// ... //

		$del = $this->__deleteChildForums( $this->Inf['id'] );

		if ($del)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'forums_delete_succeed' ] );
			
			$del = $this->__deleteSection( $this->Inf['id'] );
	
			if ($del)
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'section_delete_succeed' ] );
		
				$del = $this->__deletePermissions( $this->Inf['id'] );
				
				if ($del)
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
		$MySmartBB->rec->filter = "parent='" . $this->Inf['id'] . "'";
		$MySmartBB->rec->order = "sort ASC";
		
		$forums_res = &$MySmartBB->func->setResource();
		
		$MySmartBB->rec->getList();
		
		$x = 0;
		$s = array();
		$permissions_filter = '';
		
		while ( $row = $MySmartBB->rec->getInfo( $forums_res ) )
		{
			// ... //
			
			if ( $x > 0 )
				$permissions_filter .= 'OR ';
			
			$permissions_filter .= "section_id='" . $row[ 'id' ] . "' ";
			
			// ... //
			
			$move = $MySmartBB->subject->massMoveSubject( $MySmartBB->_POST['subject_to'], $row['id'], false );
	
			$s[$x] = ($move) ? 'true' : 'false';
	
			$x += 1;
		}
		
		if ( !empty( $permissions_filter ) )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
			$MySmartBB->rec->filter = $permissions_filter;
	
			$s[$x] = $MySmartBB->rec->delete() ? 'true' : 'false';
		}
		
		if (in_array('false',$s))
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'sections_groups_delete_failed' ] );
		}
		else
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'forums_groups_delete_succeed' ] );
		}
		
		$del = $this->__deleteChildForums( $this->Inf['id'] );

		if ($del)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'forums_delete_succeed' ] );
	
			$del = $this->__deleteSection( $this->Inf['id'] );
	
			if ($del)
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'section_delete_succeed' ] );
				
				$del = $this->__deletePermissions( $this->Inf['id'] );

				if ($del)
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
	
	private function checkID(&$Inf)
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( $Inf == false )
			$MySmartBB->func->error( $MySmartBB->lang[ 'section_doesnt_exist' ] );
		
		// ... //
	}
}

?>
