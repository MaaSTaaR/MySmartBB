<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartForumMOD');

class MySmartForumMOD
{
	private $Section;
	private $SectionGroup;
	private $subject_res;
	private $stick_subject_res;
	private $id;
	
	public function run()
	{
		global $MySmartBB;
		
		$this->_initForum();
		
		if ( $MySmartBB->_GET[ 'show' ] )
		{
			$this->_browseForum();
		}
		elseif ( $MySmartBB->_GET[ 'password_check' ] )
		{
			$check = $MySmartBB->section->forumPassword( $this->Section[ 'id' ], $this->Section[ 'section_password' ], base64_encode( $MySmartBB->_POST[ 'password' ] ) );
			
			if ( $check )
				$MySmartBB->func->move( 'index.php?page=forum&amp;show=1&amp;id=' . $this->Section[ 'id' ] . $MySmartBB->_CONF[ 'template' ][ 'password' ], 0 );
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
	
	public function _browseForum()
	{
		global $MySmartBB;
				
		// ... //
		
		$this->_generalProcesses();
		$this->_sectionOnline();
		$this->_getModeratorsList();
		$this->_getAnnouncementList();
		$this->_getSubSection();
		$this->_getSubjectList();
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'forum_main' );
		
		$this->_callTemplate();
	}
	
	/*public function check( $id )
	{
		global $MySmartBB;
		
		$this->id = $id;
		
		// ... //
		
		$this->_initForum();
		
		// ... //
		
		$check = $MySmartBB->section->forumPassword( $this->Section[ 'id' ], $this->Section[ 'section_password' ], $MySmartBB->_POST[ 'password' ] );
			
		if ( $check )
			$MySmartBB->func->move( 'index.php?page=forum&amp;show=1&amp;id=' . $this->Section[ 'id' ] . $MySmartBB->_CONF[ 'template' ][ 'password' ] );
	}*/
	
	private function _getSectionInfo()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$this->Section = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$this->Section )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forum_doesnt_exist' ] );
		
		// ... //
			
		$MySmartBB->template->assign('section_info',$this->Section);
		
		// ... //
		
		$MySmartBB->func->showHeader( $this->Section[ 'title' ] );
		
		// .. //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->Section['id'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
		
		$this->SectionGroup = $MySmartBB->rec->getInfo();
		
		// ... //
		
		// Get the permissions of the parent section
		$MySmartBB->rec->select = 'view_section';
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->Section['parent'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
		
		$parent_per = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( $this->SectionGroup['view_section'] != 1 or $parent_per[ 'view_section' ] != 1 )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_view_forum' ] );
			
		if ( isset( $this->Section[ 'main_section' ] ) and $this->Section[ 'main_section' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cat_section' ] );
		
		// ... //
	}
	
	private function _generalProcesses()
	{
		global $MySmartBB;
		
		// This section is a link , so we should go to another location
		if ( $this->Section['linksection'] )
			$this->_goToLink();
		
		// ... //
		
		// Check if the section has been protected with a password
		$MySmartBB->section->forumPassword( $this->Section[ 'id' ], $this->Section[ 'section_password' ], $MySmartBB->_GET[ 'password' ] );
     	
     	// ... //
     	
		// Where is the member now?
		if ( $MySmartBB->_CONF['member_permission'] )
     	{
			$MySmartBB->online->updateMemberLocation( $MySmartBB->lang[ 'viewing' ] . ' ' . $MySmartBB->lang_common[ 'colon' ] . ' ' . $this->Section['title'] );
     	}
	}
	
	private function _goToLink()
	{
		global $MySmartBB;
		
		// ... //
		
		// Update the number of visitors
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->fields = array( 'linkvisitor' => $this->Section[ 'linkvisitor' ] + 1 );
		$MySmartBB->rec->filter = "id='" . $this->Section[ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		// Update the cache to show the number of visitors in the main page
		if ( $update )
			$MySmartBB->section->updateForumCache( $this->Section[ 'parent' ], $this->Section[ 'id' ] );
		
		// ... //
		
		$MySmartBB->func->msg( $MySmartBB->lang[ 'please_wait_to_move' ] . ' ' . $this->Section['linksite'] );
		$MySmartBB->func->move( $this->Section['linksite'], 2 );
		$MySmartBB->func->stop();
	}
	
	/**
	 * Know who is reading the section ?
	 */
	private function _sectionOnline()
	{
		global $MySmartBB;
		
		// ... //
		
		// Get the list of people who are reading this section
		
		$MySmartBB->rec->filter = "path='" . $MySmartBB->_SERVER['QUERY_STRING'] . "'";
		
		if ( !$MySmartBB->_CONF[ 'info_row' ][ 'show_onlineguest' ] )
		{
			$this->rec->filter .= " AND username<>'Guest'";
		}
		
		// This member can't see hidden member
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'show_hidden' ] )
		{
			$this->rec->filter .= " AND hide_browse<>'1'";
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->order = "user_id DESC";
		
		$MySmartBB->func->setResource( 'online_res' );
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		// Get the number of unregistered visitors who are reading this section
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->filter = "username='Guest' AND path='" . $MySmartBB->_SERVER['QUERY_STRING'] . "'";
		
		$MySmartBB->_CONF['template']['GuestNumber'] = $MySmartBB->rec->getNumber();
		
		// ... //
		
		// Get the number of members who read this section
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->filter = "username<>'Guest' AND path='" . $MySmartBB->_SERVER['QUERY_STRING'] . "'";
		
		$MySmartBB->_CONF['template']['MemberNumber'] = $MySmartBB->rec->getNumber();
		
		// ... //
	}
	
	private function _getModeratorsList()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'moderators' ];
		$MySmartBB->rec->filter = "section_id='" . $this->Section['id'] . "'";
		
		$MySmartBB->func->setResource( 'moderator_res' );
		
		$MySmartBB->rec->getList();
		
		$moderators_num = $MySmartBB->rec->getNumber( $MySmartBB->_CONF[ 'template' ][ 'res' ][ 'moderator_res' ] );
		
		if ( $moderators_num > 0 )
			$MySmartBB->template->assign( 'SHOW_MODERATORS', true );
	}
	
	private function _getAnnouncementList()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'announcement' ];
		$MySmartBB->rec->order = "id DESC";
		$MySmartBB->rec->limit = '1';
		
		$MySmartBB->rec->getList();
		
		$announcement = $MySmartBB->rec->getInfo();
		
		if ( $announcement != false )
		{
			$announcement[ 'date' ] = $MySmartBB->func->date( $announcement[ 'date' ] );
			
			$MySmartBB->template->assign( 'SHOW_ANNOUNCEMENT', true );
			$MySmartBB->template->assign( 'announcement', $announcement );
		}
	}
	
	private function _getSubSection()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign('SHOW_SUB_SECTIONS',false);
		
		if ( !empty( $this->Section[ 'forums_cache' ] ) )
		{
			$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->fetchForumsFromCache( $this->Section[ 'forums_cache' ] );
			
			$MySmartBB->template->assign('SHOW_SUB_SECTIONS',true);
		}
	}
	
	private function _getSubjectList()
	{
		global $MySmartBB;
		
		$this->__getSubjectList();
		$this->__getStickSubjectList();
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		$MySmartBB->template->assign('section_id',$this->Section['id']); // TODO : See the line 73
	}
	
	private function __getSubjectList()
	{
		global $MySmartBB;
		
		// ... //
		
		$filter = "section='" . $this->Section['id'] . "' AND stick<>'1' AND delete_topic<>'1'";
		
		if ($this->Section['hide_subject'] 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			$filter .= " AND writer='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = $filter;
		
		$subject_total = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->rec->filter = $filter;
		
		if ($this->Section['subject_order'] == 2)
		{
			$MySmartBB->rec->order = "id DESC";
		}
		elseif ($this->Section['subject_order'] == 3)
		{
			$MySmartBB->rec->order = "id ASC";
		}
		else
		{
			$MySmartBB->rec->order = "write_time DESC";
		}
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$subject_total;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['subject_perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=forum&amp;show=1&amp;id=' . $this->Section['id'] . '#subject_table';
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$this->subject_res = &$MySmartBB->func->setResource();
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->rec->setInfoCallback( array( 'MySmartForumMOD', 'rowsProcessCB' ) );
		
		// ... //
	}
	
	private function __getStickSubjectList()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "section='" . $this->Section['id'] . "' AND stick='1' AND delete_topic<>'1'";
		$MySmartBB->rec->order = "write_time DESC";
		
		$this->stick_subject_res = &$MySmartBB->func->setResource();
		
		$MySmartBB->rec->getList();
		
		$stick_num = $MySmartBB->rec->getNumber( $this->stick_subject_res );
		
		if ( $stick_num > 0 )
			$MySmartBB->template->assign( 'SHOW_STICK', true );
	}
	
	public function rowsProcessCB( $row )
	{
		global $MySmartBB;
		
		$row[ 'write_date' ] = $MySmartBB->func->date( $row[ 'native_write_time' ] );
		$row[ 'reply_date' ] = $MySmartBB->func->date( $row[ 'write_time' ] );
	}
	
	private function _callTemplate()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'subject_res' ] = $this->subject_res;
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'stick_subject_res' ] = $this->stick_subject_res;
		
		$MySmartBB->template->display('forum');
	}
	
	// ... //
	
	private function _initForum()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'forum' );
		
		$MySmartBB->load( 'section,subject' );
		
		$MySmartBB->template->assign( 'SECTION_RSS', true );
		$MySmartBB->template->assign( 'SECTION_ID', (int) $MySmartBB->_GET[ 'id' ] );
		
		$this->_getSectionInfo();
	}
}

?>
