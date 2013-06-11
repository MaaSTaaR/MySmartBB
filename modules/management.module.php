<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'JAVASCRIPT_SMARTCODE', true );

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartManagementMOD' );

class MySmartManagementMOD
{
	private $subject_info;
	private $reply_info;
	
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'management' );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'subjects_management' ] );
		
		$MySmartBB->load( 'section,moderator,icon,toolbox' );
		
		// ... //
		
		if ( ( empty( $MySmartBB->_GET[ 'reply' ] ) and empty( $MySmartBB->_GET[ 'reply_edit' ] ) ) )
		{
			$MySmartBB->_GET[ 'subject_id' ] = (int) $MySmartBB->_GET[ 'subject_id' ];
		
			if ( empty( $MySmartBB->_GET[ 'subject_id' ] ) )
				$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
			
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'subject_id' ] . "'";
			
			$this->subject_info = $MySmartBB->rec->getInfo();
			
			if ( !$this->subject_info )
				$MySmartBB->func->error( $MySmartBB->lang[ 'subject_doesnt_exist' ] );
			
			// ... //
			
			$section_id = $this->subject_info[ 'section' ];
		}
		else
		{
			$MySmartBB->_GET[ 'reply_id' ] = (int) $MySmartBB->_GET[ 'reply_id' ];
		
			if ( empty( $MySmartBB->_GET[ 'reply_id' ] ) )
				$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
			
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'reply_id' ] . "'";
			
			$this->reply_info = $MySmartBB->rec->getInfo();
			
			if ( !$this->reply_info )
				$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
			
			$section_id = $this->reply_info[ 'section' ];
		}
		
		// ... //
		
		if ( $MySmartBB->moderator->moderatorCheck( $section_id ) )
		{
			$MySmartBB->load( 'cache,moderator,pm,reply,section,subject' );
			
			if ( $MySmartBB->_GET[ 'subject' ] )
			{
				$this->_subject();
			}
			elseif ( $MySmartBB->_GET[ 'move' ] )
			{
				$this->_moveStart();
			}
			elseif ( $MySmartBB->_GET[ 'subject_edit' ] )
			{
				$this->_subjectEditStart();
			}
			elseif ( $MySmartBB->_GET[ 'repeat' ] )
			{
				$this->_subjectRepeatStart();
			}
			elseif ( $MySmartBB->_GET[ 'close' ] )
			{
				$this->_closeStart();
			}
			elseif ( $MySmartBB->_GET[ 'delete' ] )
			{
				$this->_deleteStart();
			}
			elseif ( $MySmartBB->_GET[ 'reply' ] )
			{
				$this->_reply();
			}
			elseif ( $MySmartBB->_GET[ 'reply_edit' ] )
			{
				$this->_replyEditStart();
			}
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_permission' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
		
	private function _subject()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $MySmartBB->_GET[ 'operator' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
				
		// ... //
		
		if ( $MySmartBB->_GET['operator'] == 'stick' )
		{
			$this->__stick();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'unstick' )
		{
			$this->__unStick();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'close' )
		{
			$this->__close();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'open' )
		{
			$this->__open();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'delete' )
		{
			$this->__subjectDelete();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'move' )
		{
			$this->__moveIndex();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'edit' )
		{
			$this->__subjectEdit();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'repeated' )
		{
			$this->__subjectRepeat();
		}
		/*
		 * Freezed for 2.0.0, will be back later.
		elseif ( $MySmartBB->_GET['operator'] == 'up' )
		{
			$this->__upStart();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'down' )
		{
			$this->__downStart();
		}
		*/
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
	}
	
	private function __stick()
	{
		global $MySmartBB;
		
		$update = $MySmartBB->subject->stickSubject( $this->subject_info[ 'id' ] );
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_sticked' ] );
			$MySmartBB->func->move( 'topic/' . $this->subject_info[ 'id' ] . '/' . $this->subject_info[ 'title' ] );
		}
	}
	
	private function __unStick()
	{
		global $MySmartBB;
		
		$update = $MySmartBB->subject->unStickSubject( $this->subject_info[ 'id' ] );
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_unsticked' ] );
			$MySmartBB->func->move( 'topic/' . $this->subject_info[ 'id' ] . '/' . $this->subject_info[ 'title' ] );
		}
	}
	
	private function __close()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign( 'subject', $this->subject_info[ 'id' ] );
		$MySmartBB->template->assign( 'section', $this->subject_info[ 'section' ] );
		
		$MySmartBB->template->display( 'subject_close_index' );
	}
	
	private function __open()
	{
		global $MySmartBB;
		
		$update = $MySmartBB->subject->openSubject( $this->subject_info[ 'id' ] );
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_opened' ] );
			$MySmartBB->func->move( 'topic/' . $this->subject_info[ 'id' ] . '/' . $this->subject_info[ 'title' ] );
		}
	}
	
	private function __subjectDelete()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign( 'subject', $this->subject_info[ 'id' ] );
		$MySmartBB->template->assign( 'section', $this->subject_info[ 'section' ] );
		
		$MySmartBB->template->display( 'subject_delete_reason' );
	}
	
	private function __moveIndex()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList();
		
		// ... //
		
		$MySmartBB->template->assign( 'subject', $this->subject_info[ 'id' ] );
		$MySmartBB->template->assign( 'section', $this->subject_info[ 'section' ] );
		
		$MySmartBB->template->display( 'subject_move_index' );
	}
	
	private function _moveStart()
	{
		global $MySmartBB;
		
		$update = $MySmartBB->subject->moveSubject( $MySmartBB->_POST[ 'section' ], $this->subject_info[ 'id' ] );
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_moved' ] );
			$MySmartBB->func->move( 'topic/' . $this->subject_info[ 'id' ] . '/' . $this->subject_info[ 'title' ] );
		}
	}
	
	private function _closeStart()
	{
		global $MySmartBB;
		
		$update = $MySmartBB->subject->closeSubject( $MySmartBB->_POST[ 'reason' ], $this->subject_info[ 'id' ] );
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_closed' ] );
			$MySmartBB->func->move( 'topic/' . $this->subject_info[ 'id' ] . '/' . $this->subject_info[ 'title' ] );
		}
	}
	
	private function _deleteStart()
	{
		global $MySmartBB;
		
		$update = $MySmartBB->subject->moveSubjectToTrash( $MySmartBB->_POST[ 'reason' ], $this->subject_info[ 'id' ], $this->subject_info[ 'section' ] );

		if ( $update )
		{
			// Send a private message to the writer with the reason of deletion.
			if ( !empty( $MySmartBB->_POST[ 'reason' ] ) )
			{
				// ... //			
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
				$MySmartBB->rec->filter = "id='" . $this->subject_info[ 'id' ] . "'";
				
				$Subject = $MySmartBB->rec->getInfo();
				
				// ... //
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
				$MySmartBB->rec->fields = array(	'user_from'	=>	$MySmartBB->_CONF['member_row']['username'],
													'user_to'	=>	$Subject['writer'],
													'title'	=>	$MySmartBB->lang[ 'your_subject_deleted' ] . ' ' . $Subject['title'],
													'text'	=>	$MySmartBB->lang[ 'your_subject_deleted' ] . ' : ' . $MySmartBB->_POST['reason'],
													'date'	=>	$MySmartBB->_CONF['now'],
													'icon'	=>	$Subject['icon'],
													'folder'	=>	'inbox'	);
				
				$send = $MySmartBB->rec->insert();
				
				// ... //
				
				$number = $MySmartBB->pm->newMessageNumber( $Subject['writer'] );
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
				$MySmartBB->rec->fields = array(	'unread_pm'	=>	$number	);
				$MySmartBB->rec->filter = "username='" . $Subject[ 'writer' ] . "'";
				
				$update_cache = $MySmartBB->rec->update();
				
				// ... //
			}
			
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_deleted' ] );
			$MySmartBB->func->move( 'topic/' . $this->subject_info[ 'id' ] . '/' . $this->subject_info[ 'title' ] );
		}
	}

	private function __subjectEdit()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->template->assign( 'edit_page', 'index.php?page=management&amp;subject_edit=1&amp;subject_id=' . $this->subject_info[ 'id' ] . '&amp;section=' . $this->subject_info[ 'section' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $this->subject_info[ 'id' ] . "'";
		
		$MySmartBB->_CONF[ 'template' ][ 'SubjectInfo' ] = $MySmartBB->rec->getInfo();
		
		// ... //
		
		$MySmartBB->func->getEditorTools();
		
		// ... //
		
		$MySmartBB->template->display( 'subject_edit' );
	}
	
	private function _subjectEditStart()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( !isset( $MySmartBB->_POST[ 'title' ] ) or !isset( $MySmartBB->_POST[ 'text' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->fields = array(	'title'	=>	$MySmartBB->_POST[ 'title' ],
											'text'	=>	$MySmartBB->_POST[ 'text' ],
											'icon'	=>	$MySmartBB->_POST[ 'icon' ],
											'subject_describe'	=>	$MySmartBB->_POST[ 'describe' ]	);
											
		$MySmartBB->rec->filter = "id='" . $this->subject_info[ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('topic/' . $this->subject_info[ 'id' ] . '/' . $this->subject_info[ 'title' ]);
		}
	}
	
	private function _reply()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $MySmartBB->_GET[ 'operator' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		if ( $MySmartBB->_GET[ 'operator' ] == 'delete' )
		{
			$this->__replyDelete();
		}
		elseif ($MySmartBB->_GET[ 'operator' ] == 'edit' )
		{
			$this->__replyEdit();
		}
	}
	
	private function __replyDelete()
	{
		global $MySmartBB;
		
		$update = $MySmartBB->reply->moveReplyToTrash( $this->reply_info[ 'id' ], $this->reply_info[ 'subject_id' ], $this->reply_info[ 'section' ] );
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'reply_deleted' ] );
			$MySmartBB->func->move( 'topic/' . $this->reply_info[ 'subject_id' ] );
		}
	}
	
	private function __replyEdit()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->template->assign('edit_page','index.php?page=management&amp;reply_edit=1&amp;reply_id=' . $this->reply_info[ 'id' ] . '&amp;section=' . $this->reply_info[ 'section' ] . '&amp;subject_id=' . $this->reply_info[ 'subject_id' ]);
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'ReplyInfo' ] = $this->reply_info;
		
		// ... //
		
		$MySmartBB->func->getEditorTools();
		
		$MySmartBB->template->display( 'reply_edit' );
	}
	
	private function _replyEditStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'text' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->fields = array(	'title'	=>	$MySmartBB->_POST[ 'title' ],
											'text'	=>	$MySmartBB->_POST[ 'text' ],
											'icon'	=>	$MySmartBB->_POST[ 'icon' ]	);
											
		$MySmartBB->rec->filter = "id='" . $this->reply_info[ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		// ... //
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('topic/' . $this->reply_info[ 'subject_id' ]);
		}
	}
	
	private function __subjectRepeat()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign( 'subject', $this->subject_info[ 'id' ] );
		
		$MySmartBB->template->display( 'subject_repeat_index' );
	}
	
	private function _subjectRepeatStart()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'url' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$update = $MySmartBB->subject->closeSubject( $MySmartBB->lang[ 'repeated_subject' ], $this->subject_info[ 'id' ] );
		
		if ( $update )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
     		$MySmartBB->rec->fields = array(	'text'			=>	$MySmartBB->lang[ 'repeated_subject_see_original' ] . " [url=" . $MySmartBB->_POST['url'] . "]" . $MySmartBB->lang_common[ 'here' ] . '[/url]',
     											'writer'		=>	$MySmartBB->_CONF[ 'member_row' ][ 'username' ],
     											'subject_id'	=>	$this->subject_info[ 'id' ],
     											'write_time'	=>	$MySmartBB->_CONF[ 'now' ],
     											'section'		=>	$this->subject_info[ 'section' ]	);
     		
     		$insert = $MySmartBB->rec->insert();
     	
     		if ( $insert )
     		{
     			// ... //
     			
     			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
     			$MySmartBB->rec->fields = array(	'lastpost_time'	=>	$MySmartBB->_CONF[ 'now' ]	);
     			$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
     			
   				$UpdateMember = $MySmartBB->rec->update();
   				
   				// ... //
   				
     			$MySmartBB->subject->updateWriteTime( $this->subject_info[ 'id' ] );
     			
     			$MySmartBB->subject->updateReplyNumber( $this->subject_info[ 'id' ] );
     		    
     			$MySmartBB->section->updateLastSubject( $MySmartBB->_CONF[ 'member_row' ][ 'username' ], $this->subject_info[ 'title' ], $this->subject_info[ 'id' ], $MySmartBB->_CONF[ 'now' ],  ( !$this->subject_info[ 'sub_section' ] ) ? $this->subject_info[ 'id' ] : $this->subject_info[ 'from_sub_section' ] );
     			
     			$MySmartBB->cache->updateReplyNumber();
     			
     			$MySmartBB->subject->updateLastReplier( $MySmartBB->_CONF[ 'member_row' ][ 'username' ], $this->subject_info[ 'id' ] );
     			
     			$MySmartBB->section->updateReplyNumber( $this->subject_info[ 'section' ] );
     			
     			// We need to update forum's cache to show the correct number of statistics in the main page     			
     			$MySmartBB->section->updateForumCache( null, $this->subject_info[ 'section' ] );
     			
     			// ... //
     			     			
				$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
				$MySmartBB->func->move( 'topic/' . $this->subject_info[ 'id' ] . '/' . $this->subject_info[ 'title' ] );
     		}
		}
	}
	
	// Freezed feature (2.0.0) 
	private function __upStart()
	{
		global $MySmartBB;
	  	
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->fields = array(	'write_time'	=>	time() - ( intval( '-42' ) )	);
		$MySmartBB->rec->filter = "id='" . $this->subject_info[ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_raised' ] );
			$MySmartBB->func->move('topic/' . $this->subject_info[ 'id' ] . '/' . $this->subject_info[ 'title' ]);
		}
	}
	
	// Freezed feature (2.0.0)
	private function __downStart()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->fields = array(	'write_time'	=>	time() - ( intval('420000000000000000000') ) );
		$MySmartBB->rec->filter = "id='" . $this->subject_info[ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
	    	$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_downed' ] );
			$MySmartBB->func->move('topic/' . $this->subject_info[ 'id' ] . '/' . $this->subject_info[ 'title' ]);
		}
	}
}
?>
