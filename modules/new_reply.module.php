<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartReplyAddMOD' );

class MySmartReplyAddMOD
{
	private $id;
	private $SectionInfo;
	private $SectionGroup;
	private $SubjectInfo;
	private $moderator = false;
	private $reply_id;
	
	private function _commonCode()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->loadLanguage( 'new_reply' );
		
		$MySmartBB->load( 'cache,moderator,reply,section,subject,icon,toolbox,attach,usertitle' );
		
		// ... //
		
		$MySmartBB->template->assign( 'SMARTCODE', true );
		$MySmartBB->template->assign( 'JQUERY', true );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'add_new_reply' ] );
		
		// ... //
		
		if ( empty( $this->id ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $this->id . "'";
		
		$this->SubjectInfo = $MySmartBB->rec->getInfo();

		if ( !$this->SubjectInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'topic_doent_exist' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $this->SubjectInfo[ 'section' ] . "'";
		
		$this->SectionInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		$this->moderator = $MySmartBB->moderator->moderatorCheck( $this->SectionInfo[ 'id' ] );
		
		// ... //

		if ( !$this->moderator and $this->SubjectInfo[ 'close' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'topic_closed' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->SectionInfo[ 'id' ] . "' AND group_id='" . $MySmartBB->_CONF[ 'group_info' ][ 'id' ] . "'";
		
		$this->SectionGroup = $MySmartBB->rec->getInfo();
		
		// ... //
		
		// Get the permissions of the parent section
		$MySmartBB->rec->select = 'view_section';
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->SectionInfo[ 'parent' ] . "' AND group_id='" . $MySmartBB->_CONF[ 'group_info' ][ 'id' ] . "'";
		
		$parent_per = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$this->SectionGroup[ 'view_section' ] or !$parent_per[ 'view_section' ]
			or !$this->SectionGroup[ 'write_reply' ] )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_write_permission' ] );
		}
		
		// ... //
		
		$MySmartBB->section->forumPassword( $this->SectionInfo[ 'id' ], $this->SectionInfo[ 'section_password' ], $MySmartBB->_GET[ 'password' ] );
		
		// ... //
		
		// Where is the member now?
		$MySmartBB->online->updateMemberLocation( $MySmartBB->lang[ 'writing_reply' ] . ' ' . $this->SubjectInfo['title'] );
		
		// ... //
		
		$MySmartBB->template->assign( 'section_info', $this->SectionInfo );
		$MySmartBB->template->assign( 'subject_info', $this->SubjectInfo );
	}
	
	public function run( $id )
	{
		global $MySmartBB;
		
		$this->id = (int) $id;
		
		$this->_commonCode();
		
		$MySmartBB->func->getEditorTools();
		
		$MySmartBB->template->assign( 'id', $this->id );
				
		// Instead of send a whole version of $this->SectionGroup to template engine
		// We just send options which we really need, we use this way to save memory
		$MySmartBB->template->assign( 'upload_attach', $this->SectionGroup[ 'upload_attach' ] );
		
		$MySmartBB->template->assign( 'Admin', $this->moderator );
		
		$MySmartBB->plugin->runHooks( 'new_reply_main' );
		
		$MySmartBB->template->display( 'new_reply' );
		
		$MySmartBB->func->getFooter();
	}
		
	public function start( $id )
	{
		global $MySmartBB;
		
		$this->id = $id;
		
		$this->_commonCode();
		
		// ... //
		
		$MySmartBB->_POST[ 'title' ] = trim( $MySmartBB->_POST[ 'title' ] );
		$MySmartBB->_POST[ 'text' ] = trim( $MySmartBB->_POST[ 'text' ] );
		
		// ... //
		
		$MySmartBB->func->addressBar( '<a href="' . $this->engine->_CONF[ 'init_path' ] . 'forum/' . $this->SectionInfo[ 'id' ] . '/' . $this->SectionInfo[ 'title' ] . $MySmartBB->_CONF[ 'template' ][ 'password' ] . '">' . $this->SectionInfo[ 'title' ] . '</a> ' . $MySmartBB->_CONF[ 'info_row' ][ 'adress_bar_separate' ] . ' <a href="' . $this->engine->_CONF[ 'init_path' ] . 'topic/' . $this->SubjectInfo[ 'id' ] . '/' . $this->SubjectInfo[ 'title' ] . $MySmartBB->_CONF[ 'template' ][ 'password' ] . '">' . $this->SubjectInfo[ 'title' ] . '</a> ' . $MySmartBB->_CONF[ 'info_row' ][ 'adress_bar_separate' ] . ' ' . $MySmartBB->lang[ 'template' ][ 'add_new_reply' ] );
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'text' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$this->_checkContextLength();
		
		if ( $this->moderator )
		{
			// ... //
			
			if ( isset( $MySmartBB->_POST[ 'stick' ] ) )
			{
				if ( $MySmartBB->_POST[ 'stick' ] == 'on' )
				{
					if ( !$this->SubjectInfo[ 'stick' ] )
						$update = $MySmartBB->subject->stickSubject( $this->SubjectInfo[ 'id' ] );
				}
				else
				{
					if ( $this->SubjectInfo[ 'stick' ] )
						$update = $MySmartBB->subject->unStickSubject( $this->SubjectInfo[ 'id' ] );
				}
			}
			
			// ... //
		
			if ( $MySmartBB->_POST[ 'close' ] == 'on' )
			{
				if ( !$this->SubjectInfo[ 'close' ] )
					$update = $MySmartBB->subject->closeSubject( null, $this->SubjectInfo[ 'id' ] );
			}
			else
			{
				if ( $this->SubjectInfo[ 'close' ] )
					$update = $MySmartBB->subject->openSubject( $this->SubjectInfo[ 'id' ] );
			}
		}
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'new_reply_start' );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->fields = array(	'title'			=>	$MySmartBB->_POST[ 'title' ],
											'text'			=>	$MySmartBB->_POST[ 'text' ],
											'writer'		=>	$MySmartBB->_CONF[ 'member_row' ][ 'username' ],
											'subject_id'	=>	$this->SubjectInfo[ 'id' ],
											'write_time'	=>	$MySmartBB->_CONF[ 'now' ],
											'section'		=>	$this->SubjectInfo[ 'section' ],
											'icon'			=>	$MySmartBB->_POST[ 'icon' ]	);
		$MySmartBB->rec->get_id = true;
		
		$insert = $MySmartBB->rec->insert();
		$this->reply_id = $MySmartBB->rec->id;
		
		if ( $insert )
		{
			// ... //
			
			$posts = ( !$this->SectionGroup[ 'no_posts' ] ) ? $MySmartBB->_CONF[ 'member_row' ][ 'posts' ] + 1 : $MySmartBB->_CONF[ 'member_row' ][ 'posts' ];
			
			$usertitle = ( $MySmartBB->_CONF[ 'group_info' ][ 'usertitle_change' ] ) ? $MySmartBB->usertitle->getNewUsertitle( $posts ) : $MySmartBB->_CONF[ 'member_row' ][ 'user_title' ];
			
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->fields = array(	'posts'			=>	$posts,
												'lastpost_time'	=>	$MySmartBB->_CONF[ 'now' ],
												'user_title'	=>	$usertitle 	);
			
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
			
   			$MySmartBB->rec->update();
			
			// ... //
			
			if ( $MySmartBB->_POST[ 'attach' ] )
			{
				$MySmartBB->attach->uploadAttachments( 	$this->SectionGroup[ 'upload_attach' ], 
														$MySmartBB->_CONF[ 'group_info' ][ 'upload_attach_num' ], 
														$this->reply_id, 'files', 'reply' );
			}
			
			// ... //
			
			$this->_updateInformation();
			
			// ... //
			
			$MySmartBB->plugin->runHooks( 'new_reply_success' );
			
			$MySmartBB->func->msg( $MySmartBB->lang[ 'reply_published' ] );
			$MySmartBB->func->move( 'topic/' . $this->SubjectInfo['id'] . '/' . $this->SubjectInfo[ 'title' ] . $MySmartBB->_CONF['template']['password']);
			
			$MySmartBB->func->getFooter();
		}
	}
	
	// ... //
	
	private function _checkContextLength()
	{
		global $MySmartBB;
		
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'admincp_allow' ] )
		{
			if ( isset( $MySmartBB->_POST[ 'title' ]{ $MySmartBB->_CONF[ 'info_row' ][ 'post_title_max' ] } ) )
				$MySmartBB->func->error( $MySmartBB->lang[ 'title_length_greater' ] . ' ' . $MySmartBB->_CONF[ 'info_row' ][ 'post_title_max' ] );
				
			if ( isset( $MySmartBB->_POST[ 'text' ]{ $MySmartBB->_CONF[ 'info_row' ][ 'post_text_max' ] } ) )
				$MySmartBB->func->error( $MySmartBB->lang[ 'context_length_greater' ] . ' ' . $MySmartBB->_CONF[ 'info_row' ][ 'post_text_max' ] );
		
			if ( !isset( $MySmartBB->_POST[ 'text' ]{ $MySmartBB->_CONF[ 'info_row' ][ 'post_text_min' ] - 1 } ) )
				$MySmartBB->func->error( $MySmartBB->lang[ 'context_length_lesser' ] . ' ' . $MySmartBB->_CONF[ 'info_row' ][ 'post_text_min' ] );
		}
	}
	
	// ... //
	
	private function _updateInformation()
	{
		global $MySmartBB;
		
		$MySmartBB->subject->updateWriteTime( $this->SubjectInfo[ 'id' ] );
			
		// ... //
		
		$MySmartBB->subject->updateReplyNumber( $this->SubjectInfo[ 'id' ], $this->SubjectInfo[ 'reply_number' ] );
		
		$MySmartBB->section->updateReplyNumber( $this->SectionInfo[ 'id' ], $this->SectionInfo[ 'reply_num' ] );
		
		
		// ... //

		$MySmartBB->section->updateLastSubject( 	$MySmartBB->_CONF[ 'member_row' ][ 'username' ], 
													$this->SubjectInfo[ 'title' ], 
													$this->SubjectInfo[ 'id' ], 
													$MySmartBB->_CONF[ 'now' ], 
													( !$this->SectionInfo[ 'sub_section' ] ) ? $this->SectionInfo[ 'id' ] : $this->SectionInfo[ 'from_sub_section' ] );
		
		// ... //
			
		$MySmartBB->subject->updateLastReplier( $MySmartBB->_CONF[ 'member_row' ][ 'username' ], $this->SubjectInfo[ 'id' ] );
		
		// ... //
		
		$MySmartBB->section->updateForumCache( $this->SectionInfo[ 'parent' ], $this->SectionInfo[ 'id' ] );
	}
}
	
// Wooooooow , The latest module of MySmartBB SEGMA 1 :) The THETA stage will come soon ;)
// 11/8/2006 -> 11:21 PM -> MaaSTaaR
	
?>
