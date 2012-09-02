<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartTopicMOD');

class MySmartTopicMOD
{
	private $Info;
	private $SectionInfo;
	private $SectionGroup;
	private $subject_id;
	private $subject_title;
	private $reply_number = 1;
	private $moderator;
	
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'topic' );
		
		if ( $MySmartBB->_GET[ 'show' ] )
		{
			$MySmartBB->load( 'moderator,reply,subject,icon,toolbox,section' );
			
			$this->_getSubject();
			$this->_getSection();
			$this->_moderatorCheck();
			$this->_getGroup();
			$this->_checkSystem();
			$this->_getWriterInfo();
			$this->_checkTags();
			$this->_checkPoll();
			$this->_subjectTextFormat();
			$this->_getAttachments();
			$this->_subjectEnd();
			$this->_getReply();
			
			$MySmartBB->plugin->runHooks( 'topic_main' );
			
			if ( empty( $MySmartBB->_GET[ 'print' ] ) )
			{
				if ($MySmartBB->_CONF['info_row']['samesubject_show'])
				{
					$this->_similarTopics();
				}
			
				$this->_pageEnd();
			}
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		if ( empty( $MySmartBB->_GET[ 'print' ] ) )
		{
			$MySmartBB->func->getFooter();
		}
	}
	
	private function _getSubject()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];

		if ( empty( $MySmartBB->_GET['id'] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		// Get the subject and the writer's information
		$this->Info = $MySmartBB->subject->getSubjectWriterInfo( $MySmartBB->_GET['id'] );
		
		if ( !$this->Info )
			$MySmartBB->func->error( $MySmartBB->lang[ 'topic_doesnt_exist' ] );

		// ... //
		
		if ( $this->Info['delete_topic'] and !$MySmartBB->_CONF['group_info']['admincp_allow'] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'topic_trashed' ] );
		
		// ... //
				
		if ( empty( $MySmartBB->_GET[ 'print' ] ) )
			$MySmartBB->func->showHeader( $this->Info[ 'title' ] );
		
		// ... //
		
		$this->Info['subject_id'] = $this->subject_id = $MySmartBB->_GET['id'];
		$this->subject_title = $this->Info[ 'title' ];
		
		// ... //
		
		$MySmartBB->template->assign('subject_id',$MySmartBB->_GET['id']);
		$MySmartBB->template->assign('section_id',$this->Info['section']);
		
		// ... //
		
     	$MySmartBB->online->updateMemberLocation( $MySmartBB->lang[ 'viewing_topic' ] . ' ' . $MySmartBB->lang_common['colon'] . '' . $this->Info['title'] );
     	
     	// ... //
	}
		
	private function _getSection()
	{
		global $MySmartBB;
		
     	$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $this->Info['section'] . "'";
		
		$this->SectionInfo = $MySmartBB->rec->getInfo();
		
		$MySmartBB->template->assign( 'section_info', $this->SectionInfo );
	}
	
	private function _moderatorCheck()
	{
		global $MySmartBB;
		
		$this->moderator = $MySmartBB->moderator->moderatorCheck( $this->SectionInfo['id'] );
		
		$MySmartBB->template->assign('Mod',$this->moderator);
	}
	
	private function _getGroup()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->SectionInfo['id'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
		
		$this->SectionGroup = $MySmartBB->rec->getInfo();
	}
		
	private function _checkSystem()
	{
		global $MySmartBB;
		
		// ... //
		
		// Get the permissions of the parent section
		$MySmartBB->rec->select = 'view_section';
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->SectionInfo['parent'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
		
		$parent_per = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if (!$this->SectionGroup['view_section'] or $parent_per[ 'view_section' ] != 1)
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_view_topic' ] );
		
		if ($MySmartBB->_CONF['member_row']['username'] != $this->Info['writer'])
			$MySmartBB->subject->updateSubjectVisits( $this->Info['visitor'], $MySmartBB->_GET['id'] );
		
		// ... //
		
		// Check if the section has been protected with a password
		$MySmartBB->section->forumPassword( $this->SectionInfo[ 'id' ], $this->SectionInfo[ 'section_password' ], $MySmartBB->_GET[ 'password' ] );
	}
		
	private function _getWriterInfo()
	{
		global $MySmartBB;
		
		$this->_baseWriterInfo();
	}
	
	private function _checkTags()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['res']['tags_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'tag_subject' ];
		$MySmartBB->rec->filter = "subject_id='" . $MySmartBB->_GET['id'] . "'";
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['tags_res'];
		
		$MySmartBB->rec->getList();
		
		$tags_number = $MySmartBB->rec->getNumber( $MySmartBB->_CONF['template']['res']['tags_res'] );
		
		if ( $tags_number > 0 )
			$MySmartBB->template->assign('SHOW_TAGS',true);
		else
			$MySmartBB->template->assign('SHOW_TAGS',false);
	}
	
	private function _checkPoll()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign( 'SHOW_POLL', false );
		
		if ( $this->Info[ 'poll_subject' ] )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'poll' ];
			$MySmartBB->rec->filter = "subject_id='" . $MySmartBB->_GET['id'] . "'";
			
			$Poll = $MySmartBB->rec->getInfo( false );
			
			if ( $Poll != false )
			{
				$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'answers' ] = unserialize( base64_decode( $Poll['answers'] ) );
				
				$MySmartBB->template->assign('Poll',$Poll);
				
				unset($Poll['answers']);
				
				$MySmartBB->template->assign( 'SHOW_POLL', true );
			}
		}
	}
		
	private function _subjectTextFormat()
	{
		$this->_baseFormat();
	}
	
	private function _getAttachments()
	{
		global $MySmartBB;
		
		// We have attachments in this subject
		if ( $this->Info['attach_subject'] )
		{
			$MySmartBB->_CONF['template']['res']['attach_res'] = '';
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
			$MySmartBB->rec->filter = "subject_id='" . $MySmartBB->_GET['id'] . "'";
			$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['attach_res'];
			
			$MySmartBB->rec->getList();
			
			$attach_num = $MySmartBB->rec->getNumber( $MySmartBB->_CONF['template']['res']['attach_res'] );
			
			if ( $attach_num > 0 )
				$MySmartBB->template->assign( 'ATTACH_SHOW', true );
		}
	}
	
	private function _subjectEnd()
	{
		global $MySmartBB;			
		
		$topic_date = $MySmartBB->func->date($this->Info['native_write_time']);
		$topic_time = $MySmartBB->func->time($this->Info['native_write_time']);
		
		$this->Info['native_write_time'] = $topic_date . ' ' . $MySmartBB->lang_common[ 'comma' ] . ' ' . $topic_time;
		
		$this->_baseEnd();
		
		if ( empty( $MySmartBB->_GET[ 'print' ] ) )
			$MySmartBB->template->display('show_subject');
		else
			$MySmartBB->template->display('print_subject');
	}
	
	private function _getReply()
	{
		global $MySmartBB;
				
		// Show the replies
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->filter = "subject_id='" . $this->Info['subject_id'] . "' AND delete_topic<>'1'";
		
		$reply_number = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$reply_res = '';
		
		// Pager setup
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$reply_number;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=topic&amp;show=1&amp;id=' . $this->Info['subject_id'];
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->result = &$reply_res;
		
		$MySmartBB->reply->getReplyWriterInfo( $this->subject_id );
		
		while ( $this->Info = $MySmartBB->rec->getInfo( $reply_res ) )
		{
			$this->__getReplierInfo();
			$this->__replyFormat();
			$this->__getReplyAttachments();
			$this->__replyEnd();
		}
	}
	
	private function __getReplierInfo()
	{
		global $MySmartBB;
		
		$this->_baseWriterInfo();
		
		$this->Info['reply_number'] = $this->reply_number;
		
		$this->reply_number += 1;
	}
		
	private function __replyFormat()
	{
		global $MySmartBB;
		
		$this->_baseFormat();
	}
	
	private function __getReplyAttachments()
	{
		global $MySmartBB;
		
		// We have attachment in this reply
		if ( $this->Info['attach_reply'] )
		{
			$MySmartBB->_CONF['template']['res']['attach_res'] = '';
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
			$MySmartBB->rec->filter = "subject_id='" . $this->Info['reply_id'] . "' AND reply='1'";
			$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['attach_res'];
			
			// Get the attachment information
			$MySmartBB->rec->getList();
			
			$attach_num = $MySmartBB->rec->getNumber( $MySmartBB->_CONF['template']['res']['attach_res'] );
			
			if ( $attach_num > 0 )
				$MySmartBB->template->assign( 'SHOW_REPLY_ATTACH', true );
		}
	}
	
	private function __replyEnd()
	{
		global $MySmartBB;
					
		$reply_date = $MySmartBB->func->date($this->Info['write_time']);
		$reply_time = $MySmartBB->func->time($this->Info['write_time']);
		
		$this->Info['write_time'] = $reply_date . ' ' . $MySmartBB->lang_common[ 'comma' ] . ' ' . $reply_time;
		
		$this->_baseEnd();
		
		if ( empty( $MySmartBB->_GET[ 'print' ] ) )
			$MySmartBB->template->display('show_reply');
		else
			$MySmartBB->template->display('print_reply');
	}
	
	// ... //
		
	private function _similarTopics()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['res']['similar_subjects_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "title LIKE '%" . $this->subject_title . "%' AND delete_topic<>'1' AND id<>'" . $this->subject_id . "'";
		$MySmartBB->rec->order = 'write_time DESC';
		$MySmartBB->rec->limit = '5';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['similar_subjects_res'];
		
		$MySmartBB->rec->getList();
		
		$topics_number = $MySmartBB->rec->getNumber( $MySmartBB->_CONF['template']['res']['similar_subjects_res'] );
		
		if ( $topics_number > 0 )
			$MySmartBB->template->assign('SHOW_SIMILAR',true);
		else
			$MySmartBB->template->assign('SHOW_SIMILAR',false);
	}
	
	private function _pageEnd()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->func->getEditorTools();
		
     	$MySmartBB->template->assign('id',$MySmartBB->_GET['id']);
     	
     	$MySmartBB->template->assign('Admin',$this->moderator);
     	
     	$MySmartBB->template->assign('stick',$this->Info['stick']);
     	$MySmartBB->template->assign( 'close', $this->Info['close'] );
     	
     	$MySmartBB->template->display( 'topic_end' );
	}
	
	// ... //
	
	private function _baseWriterInfo()
	{
		global $MySmartBB;
		
		// Convert some information to a formatted info
		$MySmartBB->member->processMemberInfo( $this->Info );
	}
	
	private function _baseFormat()
	{
		global $MySmartBB;
		
		// ... //
		
		// The visitor come from the search page, so highlight the key word
		if ( !empty( $MySmartBB->_GET['highlight'] ) )
		{
			$this->Info['text'] = str_replace( $MySmartBB->_GET['highlight'], "<span class='highlight'>" . $MySmartBB->_GET['highlight'] . "</span>",$this->Info['text'] );
		}
		
		// ... //
		
		if ( $this->SectionInfo[ 'usesmartcode_allow' ] )
			$this->Info['text'] = $MySmartBB->smartparse->replace($this->Info['text']);
		else
			$this->Info['text'] = nl2br($this->Info['text']);
		
		// ... //
		
		$MySmartBB->smartparse->replace_smiles($this->Info['text']);
	}
	
	private function _baseEnd()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign('Info',$this->Info);
		$MySmartBB->template->assign('section',$this->Info['section']);
		
		unset( $this->Info );
	}
}

?>
