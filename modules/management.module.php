<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartManagementMOD');

class MySmartManagementMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'management' );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'subjects_management' ] );
		
		$MySmartBB->load( 'section,moderator,icon,toolbox' );
		
		$MySmartBB->_GET['section'] = (int) $MySmartBB->_GET[ 'section' ];
		
		if ( $MySmartBB->moderator->moderatorCheck( $MySmartBB->_GET[ 'section' ] ) )
		{
			$MySmartBB->load( 'cache,moderator,pm,reply,section,subject' );
			
			if ($MySmartBB->_GET['subject'])
			{
				$this->_subject();
			}
			elseif ($MySmartBB->_GET['move'])
			{
				$this->_moveStart();
			}
			elseif ($MySmartBB->_GET['subject_edit'])
			{
				$this->_subjectEditStart();
			}
			elseif ($MySmartBB->_GET['repeat'])
			{
				$this->_subjectRepeatStart();
			}
			elseif ($MySmartBB->_GET['close'])
			{
				$this->_closeStart();
			}
			elseif ($MySmartBB->_GET['delete'])
			{
				$this->_deleteStart();
			}
			elseif ($MySmartBB->_GET['reply'])
			{
				$this->_reply();
			}
			elseif ($MySmartBB->_GET['reply_edit'])
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
		
		if (!isset($MySmartBB->_GET['operator'])
			or !isset($MySmartBB->_GET['section']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		if ($MySmartBB->_GET['operator'] == 'stick')
		{
			$this->__stick();
		}
		elseif ($MySmartBB->_GET['operator'] == 'unstick')
		{
			$this->__unStick();
		}
		elseif ($MySmartBB->_GET['operator'] == 'close')
		{
			$this->__close();
		}
		elseif ($MySmartBB->_GET['operator'] == 'open')
		{
			$this->__open();
		}
		elseif ($MySmartBB->_GET['operator'] == 'delete')
		{
			$this->__subjectDelete();
		}
		elseif ($MySmartBB->_GET['operator'] == 'move')
		{
			$this->__moveIndex();
		}
		elseif ($MySmartBB->_GET['operator'] == 'edit')
		{
			$this->__subjectEdit();
		}
		elseif ($MySmartBB->_GET['operator'] == 'repeated')
		{
			$this->__subjectRepeat();
		}
		elseif ($MySmartBB->_GET['operator'] == 'up')
		{
			$this->__upStart();
		}
		elseif ($MySmartBB->_GET['operator'] == 'down')
		{
			$this->__downStart();
		}
	}
	
	private function __stick()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$update = $MySmartBB->subject->stickSubject( $MySmartBB->_GET['subject_id'] );
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_sticked' ] );
			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	private function __unStick()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$update = $MySmartBB->subject->unStickSubject( $MySmartBB->_GET['subject_id'] );
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_unsticked' ] );
			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	private function __close()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->template->assign('subject',$MySmartBB->_GET['subject_id']);
		
		$MySmartBB->template->display('subject_close_index');
	}
	
	private function __open()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$update = $MySmartBB->subject->openSubject( $MySmartBB->_GET['subject_id'] );
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_opened' ] );
			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	private function __subjectDelete()
	{
		global $MySmartBB;

		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];

		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->template->assign('subject',$MySmartBB->_GET['subject_id']);
		$MySmartBB->template->assign('section',$MySmartBB->_GET['section']);
		$MySmartBB->template->display('subject_delete_reason');
	}
	
	private function __moveIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		$MySmartBB->_GET['section'] = (int) $MySmartBB->_GET['section'];
		
		if (empty($MySmartBB->_GET['subject_id'])
			or empty($MySmartBB->_GET['section']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->func->getForumsList();
		
		// ... //
		
		$MySmartBB->template->assign( 'subject', $MySmartBB->_GET[ 'subject_id' ] );
		$MySmartBB->template->assign( 'section', $MySmartBB->_GET[ 'section' ] );
		
		$MySmartBB->template->display('subject_move_index');
	}
	
	private function _moveStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$update = $MySmartBB->subject->moveSubject( $MySmartBB->_POST['section'], $MySmartBB->_GET['subject_id'] );
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_moved' ] );
			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	private function _closeStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$update = $MySmartBB->subject->closeSubject( $MySmartBB->_POST['reason'], $MySmartBB->_GET['subject_id'] );
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_closed' ] );
			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	private function _deleteStart()
	{
		global $MySmartBB;

		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];

		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$update = $MySmartBB->subject->moveSubjectToTrash( $MySmartBB->_POST['reason'], $MySmartBB->_GET['subject_id'], $MySmartBB->_GET[ 'section' ] );

		if ($update)
		{
			// ... //			
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['subject_id'] . "'";
			
			$Subject = $MySmartBB->rec->getInfo();
			
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
			$MySmartBB->rec->fields = array(	'user_from'	=>	$MySmartBB->_CONF['member_row']['username'],
												'user_to'	=>	$Subject['writer'],
												'title'	=>	$MySmartBB->lang[ 'your_subject_deleted' ] . ' ' . $Subject['title'],
												'text'	=>	$MySmartBB->_POST['reason'],
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
			
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_deleted' ] );
			$MySmartBB->func->move('index.php?page=topic&show=1&id=' . $MySmartBB->_GET['subject_id']);
		}
	}

	private function __subjectEdit()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->template->assign('edit_page','index.php?page=management&amp;subject_edit=1&amp;subject_id=' . $MySmartBB->_GET['subject_id'] . '&amp;section=' . $MySmartBB->_GET['section']);
		
		$MySmartBB->func->getEditorTools();
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['subject_id'] . "'";
		
		$MySmartBB->_CONF['template']['SubjectInfo'] = $MySmartBB->rec->getInfo();
		
		$MySmartBB->template->display('subject_edit');
	}
	
	private function _subjectEditStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		if (!isset($MySmartBB->_POST['title'])
			or !isset($MySmartBB->_POST['text']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->fields = array(	'title'	=>	$MySmartBB->_POST['title'],
											'text'	=>	$MySmartBB->_POST['text'],
											'icon'	=>	$MySmartBB->_POST['icon'],
											'subject_describe'	=>	$MySmartBB->_POST['describe']	);
											
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['subject_id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	private function _reply()
	{
		global $MySmartBB;
		
		if (!isset($MySmartBB->_GET['operator'])
			or !isset($MySmartBB->_GET['section'])
			or !isset($MySmartBB->_GET['reply']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		elseif ($MySmartBB->_GET['operator'] == 'delete')
		{
			$this->__ReplyDelete();
		}
		elseif ($MySmartBB->_GET['operator'] == 'edit')
		{
			$this->__ReplyEdit();
		}
	}
	
	private function __replyDelete()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['reply_id'] = (int) $MySmartBB->_GET['reply_id'];
		
		if (empty($MySmartBB->_GET['reply_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$update = $MySmartBB->reply->moveReplyToTrash( $MySmartBB->_GET['reply_id'], $MySmartBB->_GET['subject_id'], $MySmartBB->_GET[ 'section' ] );
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'reply_deleted' ] );
			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	private function __replyEdit()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['reply_id'] = (int) $MySmartBB->_GET['reply_id'];
		
		if (empty($MySmartBB->_GET['reply_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		// ... //
		
		$MySmartBB->template->assign('edit_page','index.php?page=management&amp;reply_edit=1&amp;reply_id=' . $MySmartBB->_GET['reply_id'] . '&amp;section=' . $MySmartBB->_GET['section'] . '&amp;subject_id=' . $MySmartBB->_GET['subject_id']);
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['reply_id'] . "'";
		
		$MySmartBB->_CONF['template']['ReplyInfo'] = $MySmartBB->rec->getInfo();
		
		// ... //
		
		$MySmartBB->func->getEditorTools();
		
		$MySmartBB->template->display('reply_edit');
	}
	
	private function _replyEditStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['reply_id'] = (int) $MySmartBB->_GET['reply_id'];
		
		if (empty($MySmartBB->_GET['reply_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		if (!isset($MySmartBB->_POST['title'])
			or !isset($MySmartBB->_POST['text']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->fields = array(	'title'	=>	$MySmartBB->_POST['title'],
											'text'	=>	$MySmartBB->_POST['text'],
											'icon'	=>	$MySmartBB->_POST['icon']	);
											
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['reply_id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		// ... //
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	private function __subjectRepeat()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->template->assign('subject',$MySmartBB->_GET['subject_id']);
		
		$MySmartBB->template->display('subject_repeat_index');
	}
	
	private function _subjectRepeatStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['subject_id'] . "'";
		
		$Subject = $MySmartBB->rec->getInfo();
		
		if (!$Subject)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'subject_doesnt_exist' ] );
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $Subject['section'] . "'";
		
		$Section = $MySmartBB->rec->getInfo();
		
		if (!isset($MySmartBB->_POST['url']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		$update = $MySmartBB->subject->closeSubject( $MySmartBB->lang[ 'repeated_subject' ], $MySmartBB->_GET['subject_id'] );
		
		if ($update)
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
     		$MySmartBB->rec->fields = array(	'text'	=>	$MySmartBB->lang[ 'repeated_subject_see_original' ] . " [url=" . $MySmartBB->_POST['url'] . "]" . $MySmartBB->lang_common[ 'here' ] . '[/url]',
     											'writer'	=>	$MySmartBB->_CONF['member_row']['username'],
     											'subject_id'	=>	$MySmartBB->_GET['subject_id'],
     											'write_time'	=>	$MySmartBB->_CONF['now'],
     											'section'	=>	$Subject['section']	);
     											
     		$MySmartBB->rec->get_id = true; // TODO : Do we really need this?
     		
     		$insert = $MySmartBB->rec->insert();
     	
     		if ($insert)
     		{
     			// ... //
     			
     			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
     			$MySmartBB->rec->fields = array(	'lastpost_time'	=>	$MySmartBB->_CONF['now']	);
     			$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
     			
   				$UpdateMember = $MySmartBB->rec->update();
   				
   				// ... //
   				
     			$UpdateWriteTime = $MySmartBB->subject->updateWriteTime( $MySmartBB->_CONF['now'], $MySmartBB->_GET['subject_id'] );
     			
     			$UpdateReplyNumber = $MySmartBB->subject->updateReplyNumber( $Subject['reply_number'], $MySmartBB->_GET['subject_id'] );
     		    
     			$UpdateLast = $MySmartBB->section->updateLastSubject( $MySmartBB->_CONF['member_row']['username'], $Subject['title'], $Subject['id'], $MySmartBB->_CONF['date'],  (!$Section['sub_section']) ? $Section['id'] : $Section['from_sub_section'] );
     			
     			$UpdateSubjectNumber = $MySmartBB->cache->updateReplyNumber( $MySmartBB->_CONF['info_row']['reply_number'] );
     			     		
     			$UpdateLastReplier = $MySmartBB->subject->updateLastReplier( $MySmartBB->_CONF['member_row']['username'], $MySmartBB->_GET['subject_id'] );
     			
     			// ... //
     			
     			$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
     			$MySmartBB->rec->fields = array(	'reply_num'	=>	$Section['reply_num'] + 1 );
     			$MySmartBB->rec->filter = "id='" . $Section['id'] . "'";
     			
     			$UpdateSubjectNumber = $MySmartBB->rec->update();
     			
     			// ... //
     			     			
				$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
				$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
     		}
		}
	}
	
	private function __upStart()
	{
		global $MySmartBB;
	  	
	  	$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->fields = array(	'write_time'	=>	time() - ( intval('-42') )	);
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['subject_id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_raised' ] );
			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
		
	private function __downStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->fields = array(	'write_time'	=>	time() - ( intval('420000000000000000000') ) );
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['subject_id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
	    	$MySmartBB->func->msg( $MySmartBB->lang[ 'subject_downed' ] );
			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
}
?>
