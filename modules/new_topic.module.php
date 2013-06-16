<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartTopicAddMOD' );

class MySmartTopicAddMOD
{
	private $id;
	private $SectionInfo;
	private $SectionGroup;
	private $moderator;
	private $subject_id;
	
	private function _commonCode()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->loadLanguage( 'new_topic' );
		
		$MySmartBB->load( 'cache,moderator,section,subject,icon,toolbox,poll,tag,attach,usertitle,moderator' );
		
		// ... //
		
		if ( empty( $this->id ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $this->id . "'";
		
		$this->SectionInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$this->SectionInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forum_doesnt_exist' ] );
		
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
		
		// The visitor can't show this section , so stop the page
		if ( !$this->SectionGroup[ 'view_section' ] or !$parent_per[ 'view_section' ]
			or !$this->SectionGroup[ 'write_subject' ] )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_write_permission' ] );
		}
		
		// ... //
		
		$MySmartBB->template->assign( 'SMARTCODE', true );
		$MySmartBB->template->assign( 'JQUERY', true );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'add_new_topic' ] );
		
		// ... //
		
		// It should be before calling forumPassword().
		$MySmartBB->template->assign( 'section_info', $this->SectionInfo );
		
		// ... //
		
		// Check if the section has been protected with a password
		$MySmartBB->section->forumPassword( $this->SectionInfo[ 'id' ], $this->SectionInfo[ 'section_password' ] );
		
		// ... //
		
		$this->moderator = $MySmartBB->moderator->moderatorCheck( $this->SectionInfo[ 'id' ] );
	}
	
	public function run( $id )
	{
		global $MySmartBB;
		
		$this->id = $id;
		
		$this->_commonCode();
		
		// ... //
		
		$MySmartBB->func->getEditorTools();
		
		// ... //
		
		// Instead of send a whole version of $this->SectionGroup to template engine
		// We just send options which we really need, we use this way to save memory
		$MySmartBB->template->assign( 'upload_attach', $this->SectionGroup[ 'upload_attach' ] );
		$MySmartBB->template->assign( 'Admin', $this->moderator );
		$MySmartBB->template->assign( 'id', $this->SectionInfo[ 'id' ] );
				
		// ... //
		
		$MySmartBB->plugin->runHooks( 'new_topic_main' );
		
		$MySmartBB->template->display( 'new_topic' );		
	}
	
	public function start( $id )
	{
		global $MySmartBB;
		
		$this->id = $id;
		
		$this->_commonCode();
		
		// ... //
		
		$MySmartBB->_POST[ 'title' ] 	= 	trim( $MySmartBB->_POST[ 'title' ] );
		$MySmartBB->_POST[ 'text' ] 	= 	trim( $MySmartBB->_POST[ 'text' ] );
		
		$MySmartBB->func->addressBar( '<a href="' . $MySmartBB->_CONF[ 'init_path' ] . 'forum/' . $this->SectionInfo[ 'id' ] . '/' . $this->SectionInfo[ 'title' ] . '">' . $this->SectionInfo[ 'title' ] . '</a> ' . $MySmartBB->_CONF[ 'info_row' ][ 'adress_bar_separate' ] . $MySmartBB->lang[ 'do_write_topic' ] );
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'title' ] ) or empty( $MySmartBB->_POST[ 'text' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$this->_checkContextLength();
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'new_topic_start' );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
    	$MySmartBB->rec->get_id = true;

		$MySmartBB->rec->fields = array(	'title'				=>	$MySmartBB->_POST[ 'title' ],
											'text'				=>	$MySmartBB->_POST[ 'text' ],
											'writer'			=>	$MySmartBB->_CONF[ 'member_row' ][ 'username' ],
											'section'			=>	$this->SectionInfo[ 'id' ],
											'write_time'		=>	$MySmartBB->_CONF[ 'now' ],
											'icon'				=>	$MySmartBB->_POST[ 'icon' ],
											'subject_describe'	=>	$MySmartBB->_POST[ 'describe' ],
											'native_write_time'	=>	$MySmartBB->_CONF[ 'now' ],
											'sec_subject'		=>	$this->SectionInfo[ 'sec_section' ],
											'poll_subject'		=>	'0',
											'attach_subject'	=>	( $MySmartBB->_POST[ 'attach' ] ) ? '1' : '0',
											'visitor'			=>	'0'	);
											
		if ( $this->moderator )
		{
			$MySmartBB->rec->fields[ 'stick' ] = ( $MySmartBB->_POST[ 'stick' ] ) ? 1 : 0;
			$MySmartBB->rec->fields[ 'close' ] = ( $MySmartBB->_POST[ 'close' ] ) ? 1 : 0;
		}
		
		$insert = $MySmartBB->rec->insert();
		
					
		if ( $insert )
		{
			$this->subject_id = $MySmartBB->rec->id;
			
			// ... //
						
			$this->_addPoll();
			
			$this->_addTags();
			
			$this->_addAttachments();
			
			// ... //
			
			$posts = ( !$this->SectionGroup[ 'no_posts' ] ) ? $MySmartBB->_CONF[ 'member_row' ][ 'posts' ] + 1 : $MySmartBB->_CONF[ 'member_row' ][ 'posts' ];
			
			$usertitle = ( $MySmartBB->_CONF[ 'group_info' ][ 'usertitle_change' ] ) ? $MySmartBB->usertitle->getNewUsertitle( $posts ) : $MySmartBB->_CONF[ 'member_row' ][ 'user_title' ];
			
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->fields = array(	'posts'	=>	$posts,
												'lastpost_time'	=>	$MySmartBB->_CONF[ 'now' ],
												'user_title'	=>	$usertitle );
												
   			$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
   			
   			$MySmartBB->rec->update();
   			
   			// ... //
			
			$this->_updateInformation();
			
			// ... //
			
			$MySmartBB->plugin->runHooks( 'new_topic_success' );
			
			$MySmartBB->func->msg( $MySmartBB->lang[ 'topic_published' ] );
			$MySmartBB->func->move( 'topic/' . $this->subject_id . '/' . $MySmartBB->_POST[ 'title' ] );
						
			// ... //
		}
	}
	
	// ... //
	
	private function _checkContextLength()
	{
		global $MySmartBB;
		
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'admincp_allow' ] )
		{
			if ( isset($MySmartBB->_POST[ 'title' ]{ $MySmartBB->_CONF[ 'info_row' ][ 'post_title_max' ] } ) )
	  			$MySmartBB->func->error( $MySmartBB->lang[ 'title_length_greater' ] . ' ' . $MySmartBB->_CONF[ 'info_row' ][ 'post_title_max' ] );

	   		if  ( !isset( $MySmartBB->_POST[ 'title' ]{ $MySmartBB->_CONF[ 'info_row' ][ 'post_title_min' ] - 1 } ) )
	 			$MySmartBB->func->error( $MySmartBB->lang[ 'title_length_lesser' ] . ' ' . $MySmartBB->_CONF[ 'info_row' ][ 'post_title_min' ] );

	  	 	if ( isset( $MySmartBB->_POST[ 'text' ]{ $MySmartBB->_CONF[ 'info_row' ][ 'post_text_max' ] } ) )
	 			$MySmartBB->func->error( $MySmartBB->lang[ 'context_length_greater' ] . ' ' . $MySmartBB->_CONF[ 'info_row' ][ 'post_text_max' ] );

			if ( !isset($MySmartBB->_POST[ 'text' ]{ $MySmartBB->_CONF[ 'info_row' ][ 'post_text_min' ] - 1 } ) )
	 			$MySmartBB->func->error( $MySmartBB->lang[ 'context_length_lesser' ] . ' ' . $MySmartBB->_CONF[ 'info_row' ][ 'post_text_min' ] );
		}
	}
	
	private function _addPoll()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_POST[ 'poll' ] )
		{
			if ( !empty( $MySmartBB->_POST[ 'question' ] )
				and !empty( $MySmartBB->_POST[ 'answers' ][ 0 ] )
				and !empty( $MySmartBB->_POST[ 'answers' ][ 1 ] ) )
			{
				$MySmartBB->poll->insertPoll( $MySmartBB->_POST[ 'question' ], $MySmartBB->_POST[ 'answers' ], $this->subject_id, true );
			}
		}
	}
	
	private function _addTags()
	{
		global $MySmartBB;
		
		if ( !empty( $MySmartBB->_POST[ 'tags' ][ 0 ] ) )
			$MySmartBB->tag->taggingSubject( $MySmartBB->_POST[ 'tags' ], $this->subject_id, $MySmartBB->_POST[ 'title' ] );
	}
	
	private function _addAttachments()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_POST[ 'attach' ] )
		{
			$MySmartBB->attach->uploadAttachments( 	$this->SectionGroup[ 'upload_attach' ], 
													$MySmartBB->_CONF[ 'group_info' ][ 'upload_attach_num' ], 
													$this->subject_id, 'files', 'subject' );			
		}
	}
	
	private function _updateInformation()
	{
		global $MySmartBB;
		
		$MySmartBB->section->updateLastSubject( 	$MySmartBB->_CONF[ 'member_row' ][ 'username' ], 
													$MySmartBB->_POST[ 'title' ], 
													$this->subject_id, 
													$MySmartBB->_CONF[ 'now' ], 
													( !$this->SectionInfo[ 'sub_section' ] ) ? $this->SectionInfo[ 'id' ] : $this->SectionInfo[ 'from_sub_section' ] );
			
		// ... //
		
		$MySmartBB->section->updateSubjectNumber( $this->SectionInfo[ 'id' ], $this->SectionInfo[ 'subject_num' ] );
		
		// ... //
		
		$MySmartBB->section->updateForumCache( $this->SectionInfo[ 'parent' ], $this->SectionInfo[ 'id' ] );
		
		// ... //
	}
}

?>
