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
	
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->load( 'section,subject' );
		
		$MySmartBB->template->assign('SECTION_RSS',true);
		$MySmartBB->template->assign('SECTION_ID',$MySmartBB->_GET['id']);
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_browseForum();
		}
		elseif ($MySmartBB->_GET['password_check'])
		{
			$this->_passwordCheck();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _browseForum()
	{
		global $MySmartBB;
		
		$this->_generalProcesses();
		$this->_sectionOnline();
		$this->_getModeratorsList();
		$this->_getAnnouncementList();
		$this->_getSubSection();
		$this->_getSubjectList();
		
		$this->_callTemplate();
	}
	
	private function _generalProcesses( $check = false )
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$this->Section = $MySmartBB->rec->getInfo();
				
		$MySmartBB->template->assign('section_info',$this->Section);
		
		// ... //
		
		if (!$this->Section)
		{
			$MySmartBB->func->error('القسم المطلوب غير موجود');
		}
		
		// ... //
		
		$MySmartBB->func->showHeader( $this->Section[ 'title' ] );
		
		// .. //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->Section['id'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
		
		$this->SectionGroup = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ($this->SectionGroup['view_section'] != 1)
		{
			$MySmartBB->func->error('المعذره ... غير مسموح لك بعرض هذا القسم');
		}
			
		if ( isset( $this->Section[ 'main_section' ] )
			and $this->Section[ 'main_section' ] )
		{
			$MySmartBB->func->error('المعذره .. هذا المنتدى قسم رئيسي');
		}
		
		// This section is a link , so we should go to another location
		if ($this->Section['linksection'])
		{
			$MySmartBB->func->msg('يرجى الانتظار سوف يتم تحويلك إلى ' . $this->Section['linksite']);
			$MySmartBB->func->move($this->Section['linksite'],3);
			$MySmartBB->func->stop();
		}
		
		// ... //
		
		if ( !$check )
		{
			// Check if the section has been protected with a password
			$MySmartBB->section->forumPassword( $this->Section[ 'id' ], $this->Section[ 'section_password' ], $MySmartBB->_GET[ 'password' ] );
     	}
     	
     	// ... //
     	
		// Where is the member now?
		if ( $MySmartBB->_CONF['member_permission'] )
     	{
			$MySmartBB->online->updateMemberLocation( 'يطلع على : ' . $this->Section['title'] );
     	}
	}
	
	/**
	 * Know who is reading the section ?
	 */
	private function _sectionOnline()
	{
		global $MySmartBB;
		
		// ... //
		
		// ~ Get the list of people who read this section ~ //
		
		$MySmartBB->rec->filter = "path='" . $MySmartBB->_SERVER['QUERY_STRING'] . "'";
		
		if (!$MySmartBB->_CONF['info_row']['show_onlineguest'])
		{
			$this->rec->filter .= " AND username<>'Guest'";
		}
		
		// This member can't see hidden member
		if (!$MySmartBB->_CONF['group_info']['show_hidden'])
		{
			$this->rec->filter .= " AND hide_browse<>'1'";
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->order = "user_id DESC";
		
		$MySmartBB->func->setResource( 'online_res' );
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		// ~ Get the number of unregisterd visitors who read this section ~ //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->filter = "username='Guest' AND path='" . $MySmartBB->_SERVER['QUERY_STRING'] . "'";
		
		$MySmartBB->_CONF['template']['GuestNumber'] = $MySmartBB->rec->getNumber();
		
		// ... //
		
		// ~ Get the number of members who read this section ~ //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->filter = "username<>'Guest' AND path='" . $MySmartBB->_SERVER['QUERY_STRING'] . "'";
		
		$MySmartBB->_CONF['template']['MemberNumber'] = $MySmartBB->rec->getNumber();
		
		// ... //
	}
	
	private function _getModeratorsList()
	{
		global $MySmartBB;
		
		// TODO : cache
		$MySmartBB->rec->table = $MySmartBB->table[ 'moderators' ];
		$MySmartBB->rec->filter = "section_id='" . $this->Section['id'] . "'";
		
		$MySmartBB->func->setResource( 'moderator_res' );
		
		$MySmartBB->rec->getList();
		
		$moderators_num = $MySmartBB->rec->getNumber( $MySmartBB->_CONF[ 'template' ][ 'res' ][ 'moderator_res' ] );
		
		if ( $moderator_num > 0 )
			$MySmartBB->template->assign( 'SHOW_MODERATORS', true );
	}
	
	private function _getAnnouncementList()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'announcement' ];
		$MySmartBB->rec->order = "id DESC";
		$MySmartBB->rec->limit = '1';
		
		$MySmartBB->func->setResource( 'announcement_res' );
		
		$MySmartBB->rec->getList();
		
		$announcement_num = $MySmartBB->rec->getNumber( $MySmartBB->_CONF[ 'template' ][ 'res' ][ 'announcement_res' ] );
		
		if ( $announcement_num > 0 )
			$MySmartBB->template->assign( 'SHOW_ANNOUNCEMENT', true );
	}
	
	private function _getSubSection()
	{
		global $MySmartBB;
		
		if ( !empty( $this->Section[ 'forums_cache' ] ) )
		{	
			$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->fetchForumsFromCache( $this->Section[ 'forums_cache' ] );
			
			$MySmartBB->template->assign('SHOW_SUB_SECTIONS',true);
		}
		else
		{
			$MySmartBB->template->assign('SHOW_SUB_SECTIONS',false);
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
		
		$MySmartBB->rec->setInfoCallback( 'MySmartForumMOD::rowsProcessCB' );
		
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
}

?>
